<?php
/**
 * @package   ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license   GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelEmailcheck extends F0FModel
{
	static $component_params = null;

	/**
	 * Get the timestamp of the last email check
	 *
	 * @return int
	 */
	public function getLastTimestamp()
	{
		$params = $this->getComponentParams();

		return $params->get('email_lastcheck', 0);
	}

	/**
	 * Set the timestamp of the last email check to now
	 */
	public function setLastTimestamp()
	{
		$params = $this->getComponentParams();

		$timestamp = time();
		$params->set('email_lastcheck', $timestamp);

		$this->setComponentParams();
	}

	/**
	 * Should we check for new email?
	 *
	 * @return bool
	 */
	public function shouldCheckForEmail()
	{
		$params = $this->getComponentParams();
		$period = $params->get('email_checkevery', 5) * 60;

		if ($period < 0)
		{
			$period = 300;
		}

		$now = time();
		$last = $this->getLastTimestamp();

		return ($now - $last) >= $period;
	}

	public function checkEmail($cliFeedback = false)
	{
		// Instanciate the mail server connector object
		if (!class_exists('AtsHelperMail', false))
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/mail.php';
		}
		$params = $this->getComponentParams();
		$mboxparams = array(
			'mailbox_type'         => $params->get('mailboxtype', 'imap'),
			'server'               => $params->get('email_server', 'imap.gmail.com'),
			'port'                 => $params->get('email_port', ''),
			'ssl'                  => $params->get('email_ssl', '0'),
			'tls'                  => $params->get('email_tls', '1'),
			'validate_certificate' => $params->get('email_validate_certificate', '1'),
			'gmail'                => $params->get('gmail', '0'),
			'username'             => $params->get('email_username', ''),
			'password'             => $params->get('email_password', ''),
			'folder'               => $params->get('email_folder', 'INBOX')
		);
		$mailbox = new AtsHelperMail($mboxparams);

		// Get parameters
		$replyByEmail = $params->get('replybyemail', '0');
		$newByEmail = $params->get('newbyemail', '0');
		$default_category = $params->get('email_default_category', '0');
		$delete_after = $params->get('email_delete', '1');

		// Bail out if no email feature is set at all
		if (!$replyByEmail && !$newByEmail)
		{
			return;
		}

		// Open the mailbox connection
		$mailbox->open();

		// Get the IMAP date since when to look for email
		$lastcheck = $this->getLastTimestamp();
		if (empty($lastcheck))
		{
			$lastcheck = time() - 86400;
		}
		$since = date("d-M-Y", $lastcheck - 86400);

		// Set the last check date to prevent this loop running in parallel several times
		$this->setLastTimestamp();

		// Fetch new emails
		$emails = $mailbox->getMessagesSince($since);

		// Bail out if we have no new email to check
		if (!count($emails))
		{
			return;
		}

		// Loop through all messages
		foreach ($emails as $email)
		{
			if ($cliFeedback)
			{
				echo $email['mid'] . ' -- ' . $email['fromaddress'] . ' ' . $email['subject'] . "\n";
			}

			$this->processEmail($email, $lastcheck);

			if ($delete_after)
			{
				if ($cliFeedback)
				{
					echo "   deleting original message from server\n";
				}

				$mailbox->delete($email['mid']);
			}
		}

		// Close and expunge mailbox
		$mailbox->expunge();
	}

	protected function processEmail($email, $lastcheck)
	{
		// Yes, that's required...
		JLoader::import('joomla.application.component.helper');
		JLoader::import('legacy.component.helper');
		JLoader::import('joomla.environment.uri');

		// Load the credits helper
		if (!class_exists('AtsHelperCredits'))
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/credits.php';
		}

		// Make sure we are not processing the same email twice
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from($db->qn('#__ats_posts'))
			->where($db->qn('email_uid') . ' = ' . $db->q($email['uid']));
		$db->setQuery($query);
		$uid_count = $db->loadResult();
		if ($uid_count)
		{
			return;
		}

		// Initialise
		$params = $this->getComponentParams();
		$replyByEmail = $params->get('replybyemail', '0');
		$newByEmail = $params->get('newbyemail', '0');
		$default_category = $params->get('email_default_category', '0');
		$nonewtickets = $params->get('nonewtickets', 0);
		$noreplies = $params->get('noreplies', 0);
		$emailadminonly = $params->get('emailadminonly', 0);

		// Get the ticket ID and validate it
		$ticketID = $this->getTicketID($email);
		if ($ticketID)
		{
			$ticket = F0FModel::getTmpInstance('Tickets', 'AtsModel')
				->getItem($ticketID);
			if ($ticket->ats_ticket_id != $ticketID)
			{
				$ticket = null;
				$ticketID = 0;
			}
		}
		else
		{
			$ticket = null;
		}

		// Get the category ID
		if (is_null($ticket))
		{
			$to = $email['toemail'];
			$categoryID = $this->getCategoryIDFromEmail($to);
			// If no category was found, use the default category
			if (empty($categoryID))
			{
				$categoryID = $default_category;
			}
		}
		else
		{
			$categoryID = $ticket->catid;
		}

		if (is_array($categoryID))
		{
			$categoryID = array_shift($categoryID);
		}

		// Get the user
		$from = $email['fromemail'];
		$user = $this->getUserFromEmail($from);

		// Get the date and make sure it's after our last check timestamp
		$date = $email['unixdate'];
		$correctDate = $date > $lastcheck;

		// Get the subject
		$subject = $email['subject'];

		// Do we have "reply above this line" line?
		$hasReplyAboveLine = $this->hasReplyAboveLine($email['body']);

		// Get the body which is above the reply line
		$emailmessage = $this->extractMessage($email);
		$emailmessage = $this->sanitizeHtml($emailmessage, $user);

		// We need a valid user to go on
		if (!$user->id || $user->guest)
		{
			// Maybe send an email telling the user he screwed up if there's a valid ticket ID?
			$this->sendErrorEmail('mailgateway-invaliduser', $from);

			return;
		}

		// Does the user has access to the category?
		$categories = F0FModel::getTmpInstance('Categories', 'AtsModel')
			->category($categoryID)
			->userid($user->id)
			->getList();

		if (!empty($categories))
		{
			foreach ($categories as $category)
			{
				$found = false;

				if ($category->id == $categoryID)
				{
					$found = true;
					break;
				}

				if (!$found)
				{
					$category = null;
				}
			}
		}
		else
		{
			$category = null;
		}

		// Get ACL permissions and make sure we can post here
		$perms = $this->getPostPermissions($categoryID, $user);

		if (!$perms['ticket'])
		{
			$category = null;
		}

		// Replies only allowed by a manager and this is not a manager
		if (!$perms['manager'] && $emailadminonly)
		{
			// Send an email telling the user he has no access
			$this->sendErrorEmail('mailgateway-noaccess', $from, array(
				'name'     => $user->name,
				'username' => $user->username
			));

			return;
		}

		// If we cannot post to the category, bail out
		if (is_null($category))
		{
			// Send an email telling the user that replies by email are not allowed
			$this->sendErrorEmail('mailgateway-newreplydisabled', $from, array(
				'name'     => $user->name,
				'username' => $user->username
			));

			return;
		}

		$canPost = false;
		$post = array();
		$ticketModel = F0FModel::getTmpInstance('Tickets', 'AtsModel');
		$ticketModel->reset();

		if (is_null($ticket) && $newByEmail)
		{
			// If we are not allowed to create new tickets globally, cancel this op
			if ($nonewtickets && !$perms['manager'])
			{
				// Send an email to the user telling him that the No New Tickets global switch is enabled
				$this->sendErrorEmail('mailgateway-nonewtickets', $from, array(
					'name'     => $user->name,
					'username' => $user->username
				));

				return;
			}

			// Do we have enough credits?
			$priority = $perms['private'] ? 1 : 5;
			$haveCredits = AtsHelperCredits::haveEnoughCredits($user->id, $category->id, true, !$perms['private'], $priority);
			if (!$haveCredits)
			{
				// Send an email to the user telling him that he doesn't have enough credits
				$this->sendErrorEmail('mailgateway-nocredits-ticket', $from, array(
					'name'             => $user->name,
					'username'         => $user->username,
					'credits_required' => AtsHelperCredits::creditsRequired($category->id, true, !$perms['private'], $priority),
					'credits_left'     => AtsHelperCredits::creditsLeft($user->id, true),
				));

				return;
			}

			// Allow posting to the (new) ticket
			$canPost = true;
			$newTicket = true;

			$ticket = array(
				'ats_ticket_id'	=> null,
				'id' => 0,
				'catid'      => $category->id,
				'status'     => 'O',
				'title'      => $subject,
				'public'     => !$perms['private'],
				'origin'     => 'email',
				'enabled'    => 1,
				'created_by' => $user->id,
			);

			// Required to preload the AtsTableTicket class
			$dummy = F0FTable::getInstance('Ticket', 'AtsTable');

			$ticketModel->setId(0);
			AtsTableTicket::$overrideuser = 1;
			//JFactory::getSession()->set('ticket.overrideuser', 1, 'com_ats');
			$ticketModel->setId(0);
			$dummy->reset();
			$dummy->ats_ticket_id = null; // Don't ask why, reset() doesn't reset the primary key. DAMN!
			$status = $ticketModel->save($ticket);
			AtsTableTicket::$overrideuser = 0;
			//JFactory::getSession()->set('ticket.overrideuser', 0, 'com_ats');

			if (!$status)
			{
				// Send an email informing the user that ticket creation failed
				$this->sendErrorEmail('mailgateway-newticketfailed', $from, array(
					'name'     => $user->name,
					'username' => $user->username,
				));

				return;
			}

			$ats_ticket_id = $ticketModel->getId();
			$post['ats_ticket_id'] = $ats_ticket_id;
			$ticket = $ticketModel->getSavedTable();
		}
		elseif (!is_null($ticket))
		{
			// Existing ticket. Can we post the reply?
			$canPost = $hasReplyAboveLine && $replyByEmail;
			$newTicket = false;
			$post['ats_ticket_id'] = $ticket->ats_ticket_id;
		}
		elseif (!$newByEmail)
		{
			// New ticket creation not allowed in config
			$this->sendErrorEmail('mailgateway-newticketdisabled', $from, array(
				'name'     => $user->name,
				'username' => $user->username,
			));

			return;
		}

		if ($canPost && !$newTicket)
		{
			// Make sure the user has enough credits
			$haveCredits = AtsHelperCredits::haveEnoughCredits($user->id, $category->id, false, !$perms['private'], $ticket->priority);
			if (!$haveCredits)
			{
				// Send an email to the user telling him that he doesn't have enough credits
				$this->sendErrorEmail('mailgateway-nocredits-post', $from, array(
					'name'             => $user->name,
					'username'         => $user->username,
					'credits_required' => AtsHelperCredits::creditsRequired($category->id, false, !$perms['private'], $ticket->priority),
					'credits_left'     => AtsHelperCredits::creditsLeft($user->id, true),
				));

				return;
			}


			// Make sure the user is replying to his own ticket or he's an admin
			if (
				!$user->authorise('core.manage', 'com_ats.category.' . $category->id) &&
				!$user->authorise('core.manage', 'com_ats')
			)
			{
				if ($user->id != $ticket->created_by)
				{
					// Illegal post by a non-admin, non-owner user
					$canPost = false;
				}
				else
				{
					// User posted: set ticket status to 'O'
					$ticketModel->setId($post['ats_ticket_id']);

					// Do not remove: required to completely reset the table before saving
					$ticketModel->getTable()->reset();
					$ticketModel->getTable()->ats_ticket_id = $post['ats_ticket_id'];

					$update = array(
						'status'      => 'O',
						'modified_by' => $user->id
					);
					$ticketModel->save($update);
				}
			}
			else
			{
				// Admin posted: set ticket status to 'P'
				$ticketModel->setId($post['ats_ticket_id']);

				// Do not remove: required to completely reset the table before saving
				$ticketModel->getTable()->reset();
				$ticketModel->getTable()->ats_ticket_id = $post['ats_ticket_id'];

				$update = array(
					'status'      => 'P',
					'modified_by' => $user->id
				);
				$ticketModel->save($update);
			}
		}
		elseif (!$replyByEmail && !$newTicket)
		{
			// New ticket creation not allowed in config
			$this->sendErrorEmail('mailgateway-newreplydisabled', $from, array(
				'name'     => $user->name,
				'username' => $user->username,
			));

			return;
		}
		elseif (!$hasReplyAboveLine && !$newTicket)
		{
			$this->sendErrorEmail('mailgateway-noreplyline', $from, array(
				'name'     => $user->name,
				'username' => $user->username,
			));

			return;
		}

		$newAttachment = false;
		if ($canPost && $perms['attachment'])
		{
			// Do we have attachments, at all?
			if (count($email['parts']))
			{
				// Load the necessary media helper
				if (!class_exists('MediaHelper'))
				{
					require_once(JPATH_ADMINISTRATOR . '/components/com_media/helpers/media.php');
				}

				$tempdir = JFactory::getConfig()->get('tmp_path');

				// Find the largest attached file
				$largestSize = 0;
				$partid = false;

				foreach ($email['parts'] as $id => $part)
				{
					$size = strlen($part->data);

					if ($size > $largestSize)
					{
						$tmpName = tempnam($tempdir, 'atsup');
						$res = @file_put_contents($tmpName, $part->data);

						if ($res === false)
						{
							continue;
						}

						$fakeFileStructure = array(
							'name'     => $part->filename,
							'size'     => $size,
							'tmp_name' => $tmpName,
						);

						$allowedFile = $this->canUpload($fakeFileStructure);

						@unlink($tmpName);

						if ($allowedFile)
						{
							$largestSize = $size;
							$partid = $id;
						}
					}
				}

				if ($partid !== false)
				{
					$part = $email['parts'][$partid];
					$tempdir = JFactory::getConfig()->get('tmp_path');
					$size = strlen($part->data);

					$tmpName = tempnam($tempdir, 'atsup');
					$res = @file_put_contents($tmpName, $part->data);

					if ($res !== false)
					{
						$fakeFileStructure = array(
							'name'     => $part->filename,
							'size'     => $size,
							'tmp_name' => $tmpName,
						);

						$attachmentModel = F0FModel::getTmpInstance('Attachments', 'AtsModel');
						$filedef = $attachmentModel->uploadFile($fakeFileStructure, false);

						if ($filedef !== false)
						{
							$attachment = F0FModel::getTmpInstance('Attachments', 'AtsModel')
								->setId(0)
								->getItem();
							JLoader::import('joomla.utilities.date');
							$jdate = new JDate();
							$filedef['created_by'] = $user->id;
							$filedef['created_on'] = $jdate->toSql();
							$filedef['enabled'] = 1;

							// Do not remove: required to completely reset the table before saving
							$attachment->reset();
							$attachment->ats_attachment_id = null;

							$result = $attachment->save($filedef);

							$ats_attachment_id = $attachment->ats_attachment_id;
						}

						$newAttachment = true;
						@unlink($tmpName);
					}
				}
			}
		}

		if ($canPost)
		{
			// If we are not allowed to create new replies globally, cancel this op
			if ($noreplies && !$perms['manager'])
			{
				// Send an email to the user telling him that the No New Replies global switch is enabled
				$this->sendErrorEmail('mailgateway-nonewreplies', array(
					'name'     => $user->name,
					'username' => $user->username
				));

				return;
			}

			// Add a post
			$post['content_html'] = $emailmessage;
			$post['content'] = '';
			$post['enabled'] = 1;
			$post['origin'] = 'email';
			$post['created_by'] = $user->id;
			$post['email_uid'] = $email['uid'];

			if ($newAttachment)
			{
				$post['ats_attachment_id'] = $ats_attachment_id;
			}

			$postModel = F0FModel::getTmpInstance('Posts', 'AtsModel');
			$postModel->setId(0);

			// Do not remove: required to completely reset the table before saving
			$postModel->getTable()->reset();
			$postModel->getTable()->ats_post_id = 0;

			$status = $postModel->save($post);

			if (!$status)
			{
				if ($newTicket)
				{
					$ticketModel->setId($ats_ticket_id)->getItem()->delete();
				}
				if ($newAttachment)
				{
					$attachmentModel->setId($ats_attachment_id)->getItem()->delete();
				}
				// Send an email informing the user that ticket creation failed
				$this->sendErrorEmail('mailgateway-newpostfailed', $from, array(
					'name'     => $user->name,
					'username' => $user->username,
				));

				return;
			}

			// Update post reference inside attachment record
			if ($newAttachment)
			{
				$pTable = $postModel->getSavedTable();
				$aTable = F0FModel::getTmpInstance('Attachments', 'AtsModel')->getSavedTable();

				if (is_object($aTable ) && ($aTable instanceof AtsTableAttachment))
				{
					$aTable->ats_post_id = $pTable->ats_post_id;

					$aTable->store();
				}
			}

			$ats_post_id = $postModel->getId();
		}
	}

	/**
	 * Returns the ticket ID found inside an email
	 *
	 * @param array $email
	 *
	 * @return boolean|int False if no ID is found, else the ticket ID
	 */
	protected function getTicketID(&$email)
	{
		$ticketId = $email['ticketid'];

		$body = $email['body'];
		$hasTicketId = preg_match('/\{ticketid\:(\d+)\}/ism', $body, $matches);

		if ($hasTicketId)
		{
			$ticketId_alt = $matches[1];
		}
		else
		{
			$ticketId_alt = 0;
		}

		$ticketId = max($ticketId, $ticketId_alt);
		if (empty($ticketId))
		{
			return false;
		}
		else
		{
			return $ticketId;
		}
	}

	/**
	 * Extracts the part of the message which is above the reply line
	 *
	 * @param array $email
	 *
	 * @return string
	 */
	protected function extractMessage($email)
	{
		$body = $email['body'];
		$parts = explode('!-!-', $body);

		return $parts[0];
	}

	/**
	 * Does the message have a "reply above this line" line?
	 *
	 * @param array $email
	 *
	 * @return bool
	 */
	protected function hasReplyAboveLine($email)
	{
		$regex = '#!-!-(.*)-!-!#s';
		if (is_array($email))
		{
			$body = $email['body'];
		}
		elseif (is_string($email))
		{
			$body = $email;
		}
		$result = preg_match_all($regex, $body, $matches);

		return ($result !== false) && ($result > 0);
	}

	/**
	 * Gets a user object from an email address
	 *
	 * @param string $from Email address
	 *
	 * @return JUser a user object
	 */
	protected function &getUserFromEmail($from)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->qn('id'))
			->from($db->qn('#__users'))
			->where($db->qn('email') . ' = ' . $db->q($from));
		$db->setQuery($query, 0, 1);
		$uid = $db->loadResult();

		$user = JUser::getInstance($uid);

		return $user;
	}

	/**
	 * Sanitizes the HTML using the text filter specified in the component's
	 * configuration.
	 *
	 * @param string $html The HTML to sanitize
	 * @param JUser  $user The user used to determine which type of filtering to apply
	 *
	 * @return string The sanitized HTML
	 */
	protected function sanitizeHtml($html, JUser $user = null)
	{
		if (!class_exists('AtsHelperFilter'))
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/filter.php';
		}

		return AtsHelperFilter::filterText($html, $user);
	}

	/**
	 * Gets the category ID based on the email address of the user
	 *
	 * @staticvar null|array $catmap Holds a map of emails to categories
	 *
	 * @param string $email Email address to check
	 *
	 * @return int The category ID, or 0 if none is found
	 */
	protected function getCategoryIDFromEmail($email)
	{
		static $catmap = null;

		if (is_null($catmap))
		{
			JLoader::import('joomla.application.component.helper');
			$model = F0FModel::getTmpInstance('Categories', 'AtsModel');
			$items = $model->access(null)->published(1)->getList();

			$catmap = array();
			if (!empty($items))
			{
				foreach ($items as $item)
				{
					$params = new JRegistry($item->params);
					$catemail = $params->get('category_email', '');
					if (empty($catemail))
					{
						continue;
					}
					if (array_key_exists($catemail, $catmap))
					{
						continue;
					}
					$catmap[$catemail] = $item->id;
				}
			}
		}

		if (array_key_exists($email, $catmap))
		{
			return $catmap[$email];
		}

		return 0;
	}

	protected function getPostPermissions($category_id, &$user)
	{
		// Can I post to the category?
		$canCreateTicket = false;
		if ($user->authorise('core.create', 'com_ats'))
		{
			$canCreateTicket = true;
		}
		elseif ($user->authorise('core.create', 'com_ats.category.' . $category_id))
		{
			$canCreateTicket = true;
		}

		// Can I post private tickets?
		$canPostPrivately = false;
		if ($user->authorise('ats.private', 'com_ats'))
		{
			$canPostPrivately = true;
		}
		elseif ($user->authorise('ats.private', 'com_ats.category.' . $category_id))
		{
			$canPostPrivately = true;
		}

		// Can I post private attachments?
		$canPostAttachments = false;
		if ($user->authorise('ats.attachment', 'com_ats'))
		{
			$canPostAttachments = true;
		}
		elseif ($user->authorise('ats.attachment', 'com_ats.category.' . $category_id))
		{
			$canPostAttachments = true;
		}

		// Is this a manager
		$manager = false;
		if ($user->authorise('core.manage', 'com_ats.category.' . $category_id))
		{
			$manager = true;
		}
		elseif ($user->authorise('core.manage', 'com_ats'))
		{
			$manager = true;
		}

		return array(
			'ticket'     => $canCreateTicket,
			'private'    => $canPostPrivately,
			'attachment' => $canPostAttachments,
			'manager'    => $manager
		);
	}

	protected function sendErrorEmail($key, $toEmail, Array $extraVars = array())
	{
		// Get the email content
		if (!class_exists('AtsHelperEmail'))
		{
			require_once JPATH_SITE . '/components/com_ats/helpers/email.php';
		}

		list($subject, $templateText, $loadLanguage) = AtsHelperEmail::loadEmailTemplateFromDB($key);

		if (empty($templateText) || empty($subject))
		{
			return false;
		}

		$mailer = AtsHelperEmail::getMailer();
		AtsHelperEmail::parseTemplate($templateText, $subject, $extraVars, $mailer);
		$mailer->addRecipient($toEmail);
		$mailer->Send();
		unset($mailer);
	}

	/**
	 * Returns a JRegistry object with the component parameters, without using
	 * JComponentHelper.
	 *
	 * @return \JRegistry The component parameters
	 */
	private function &getComponentParams()
	{
		if (!is_object(self::$component_params))
		{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true)
				->select('params')
				->from($db->qn('#__extensions'))
				->where($db->qn('element') . '=' . $db->q('com_ats'))
				->where($db->qn('type') . '=' . $db->q('component'));
			$db->setQuery($query);
			$rawparams = $db->loadResult();
			self::$component_params = new JRegistry();
			self::$component_params->loadString($rawparams, 'JSON');
		}

		return self::$component_params;
	}

	/**
	 * Save the component parameters
	 *
	 * @param JRegistry $params The component parameters' JRegistry object to save
	 */
	private function setComponentParams()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->update($db->qn('#__extensions'))
			->set($db->qn('params') . '=' . $db->q(self::$component_params->toString()))
			->where($db->qn('element') . '=' . $db->q('com_ats'))
			->where($db->qn('type') . '=' . $db->q('component'));
		$db->setQuery($query);
		$db->execute();
	}

	/**
	 * Checks if the file can be uploaded
	 *
	 * @param   array  $file      File information
	 * @param   string $component The option name for the component storing the parameters
	 *
	 * @return  boolean
	 *
	 * @since   3.2
	 */
	private function canUpload($file, $component = 'com_media')
	{
		$params = JComponentHelper::getParams($component);

		if (empty($file['name']))
		{
			return false;
		}

		jimport('joomla.filesystem.file');

		if (str_replace(' ', '', $file['name']) != $file['name'] || $file['name'] !== JFile::makeSafe($file['name']))
		{
			return false;
		}

		$format = strtolower(JFile::getExt($file['name']));

		// Media file names should never have executable extensions buried in them.
		$executable = array(
			'php', 'js', 'exe', 'phtml', 'java', 'perl', 'py', 'asp', 'dll', 'go', 'ade', 'adp', 'bat', 'chm', 'cmd', 'com', 'cpl', 'hta', 'ins', 'isp',
			'jse', 'lib', 'mde', 'msc', 'msp', 'mst', 'pif', 'scr', 'sct', 'shb', 'sys', 'vb', 'vbe', 'vbs', 'vxd', 'wsc', 'wsf', 'wsh'
		);

		$explodedFileName = explode('.', $file['name']);

		if (count($explodedFileName > 2))
		{
			foreach ($executable as $extensionName)
			{
				if (in_array($extensionName, $explodedFileName))
				{
					return false;
				}
			}
		}

		$allowable = explode(',', $params->get('upload_extensions'));
		$ignored = explode(',', $params->get('ignore_extensions'));

		if ($format == '' || $format == false || (!in_array($format, $allowable) && !in_array($format, $ignored)))
		{
			return false;
		}

		$maxSize = (int)($params->get('upload_maxsize', 0) * 1024 * 1024);

		if ($maxSize > 0 && (int)$file['size'] > $maxSize)
		{
			return false;
		}

		if ($params->get('restrict_uploads', 1))
		{
			$images = explode(',', $params->get('image_extensions'));

			if (in_array($format, $images))
			{
				// If it is an image run it through getimagesize
				// If tmp_name is empty, then the file was bigger than the PHP limit
				if (!empty($file['tmp_name']))
				{
					if (($imginfo = getimagesize($file['tmp_name'])) === false)
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			elseif (!in_array($format, $ignored))
			{
				// If it's not an image, and we're not ignoring it
				$allowed_mime = explode(',', $params->get('upload_mime'));
				$illegal_mime = explode(',', $params->get('upload_mime_illegal'));

				if (function_exists('finfo_open') && $params->get('check_mime', 1))
				{
					// We have fileinfo
					$finfo = finfo_open(FILEINFO_MIME);
					$type = finfo_file($finfo, $file['tmp_name']);

					if (strlen($type) && !in_array($type, $allowed_mime) && in_array($type, $illegal_mime))
					{
						return false;
					}

					finfo_close($finfo);
				}
				elseif (function_exists('mime_content_type') && $params->get('check_mime', 1))
				{
					// We have mime magic.
					$type = mime_content_type($file['tmp_name']);

					if (strlen($type) && !in_array($type, $allowed_mime) && in_array($type, $illegal_mime))
					{
						return false;
					}
				}
				else //elseif (!JFactory::getUser()->authorise('core.manage', $component)) // which user? :)
				{
					return false;
				}
			}
		}

		$xss_check = file_get_contents($file['tmp_name'], false, null, -1, 256);

		$html_tags = array(
			'abbr', 'acronym', 'address', 'applet', 'area', 'audioscope', 'base', 'basefont', 'bdo', 'bgsound', 'big', 'blackface', 'blink',
			'blockquote', 'body', 'bq', 'br', 'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'comment', 'custom', 'dd', 'del',
			'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'fn', 'font', 'form', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
			'head', 'hr', 'html', 'iframe', 'ilayer', 'img', 'input', 'ins', 'isindex', 'keygen', 'kbd', 'label', 'layer', 'legend', 'li', 'limittext',
			'link', 'listing', 'map', 'marquee', 'menu', 'meta', 'multicol', 'nobr', 'noembed', 'noframes', 'noscript', 'nosmartquotes', 'object',
			'ol', 'optgroup', 'option', 'param', 'plaintext', 'pre', 'rt', 'ruby', 's', 'samp', 'script', 'select', 'server', 'shadow', 'sidebar',
			'small', 'spacer', 'span', 'strike', 'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title',
			'tr', 'tt', 'ul', 'var', 'wbr', 'xml', 'xmp', '!DOCTYPE', '!--'
		);

		foreach ($html_tags as $tag)
		{
			// A tag is '<tagname ', so we need to add < and a space or '<tagname>'
			if (stristr($xss_check, '<' . $tag . ' ') || stristr($xss_check, '<' . $tag . '>'))
			{
				return false;
			}
		}

		return true;
	}
}