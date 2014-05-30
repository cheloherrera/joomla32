<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

JLoader::import('joomla.plugin.plugin');

class plgAtsPostemail extends JPlugin
{
	/**
	 * Public constructor
	 *
	 * @param object $subject The onject to observe
	 * @param array $config Configuration parameters to the plugin
	 */
	public function __construct(&$subject, $config = array()) {
		parent::__construct($subject, $config);

		if(!defined('F0F_INCLUDED')) {
			require_once JPATH_LIBRARIES.'/f0f/include.php';
		}

		$this->loadLanguage();
	}

	/**
	 * This handles the onATSPost event which is triggered every time a post is
	 * created or edited.
	 *
	 * @param array $info An indexed array with post info. The post key contains an AtsTablePost object.
	 * @return void
	 */
	public function onATSPost($info)
	{
		// Only send notifications for NEW posts, or posts edited by a non-administrator
		$sendEmail = false;

		if ($info['new'])
		{
			// New post; send email
			$sendEmail = true;
		}
		else
		{
			// Modified post. Let's think...
			$modified_by = $info['post']->modified_by;
			if ($modified_by <= 0)
			{
				// Not modified / modified by invalid user - no email
				$sendEmail = false;
			}
			else
			{
				$user = JFactory::getUser($modified_by);
				$isAdmin = $user->authorise('core.manage','com_ats')
					|| $user->authorise('core.admin','com_ats')
					|| $user->authorise('core.manage','com_ats.category.' . $info['ticket']->catid);
				if (!$isAdmin)
				{
					$sendEmail = true;
				}
			}
		}

		if (!$sendEmail)
		{
			return;
		}

		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		// Extract the post and ticket objects
		$post   = $info['post'];
		$ticket = $info['ticket'];

		// Is this a new ticket?
		$isNewTicket = false;
		if(($ticket->modified_by == $ticket->created_by) && ($ticket->modified_on == $ticket->created_on))
		{
			$isNewTicket = true;
		}
		else
		{
			$isNewTicket = $ticket->modified_by == 0;
		}

		// Let's get the user ID's of all users who are managers of ATS or the
		// specific category
		$managers		 = $this->_getManagersForATSCategory($ticket->catid);
		$skipNotAssigned = JComponentHelper::getParams('com_ats')->get('assigned_noemail', 0);

		if (!empty($managers))
		{
			foreach($managers as $manager)
			{
				// Make sure we are not sending an email to the user who posted
				if ($manager == $post->created_by)
				{
					 continue;
				}

				// Should I notify only the assigned manager?
				if($skipNotAssigned)
				{
					// Ticket assigned, let's skip everyone else!
					if($info['ticket']->assigned_to && $info['ticket']->assigned_to != $manager)
					{
						continue;
					}
				}

				// Send email to the manager
				$this->_sendEmailToUser($manager, $post, $ticket, 'manager');
			}
		}

		// Send email to the ticket owner, unless it's a reply sent by himself.
		// New ticket notifications will always be sent.
		if (($ticket->created_by != $post->created_by) || $isNewTicket)
		{
			$this->_sendEmailToUser($ticket->created_by, $post, $ticket, 'owner');
		}

		// Send email to subscribers of the category, unless they are already
		// emailed above.
		// Make sure it's a public ticket; if it's private DO NOT notify the
		// subscribers (it would beat the point of having private tickets)
		if($ticket->public)
		{
			$subscribers = $this->_getSubscribersForATSCategory($ticket->catid, $isNewTicket);
			if (!empty($subscribers))
			{
				foreach($subscribers as $subscriber)
				{
					// Make sure we are not sending an email to the user who posted
					if ($subscriber == $post->created_by)
					{
						continue;
					}

					// Make sure we are not emailing an administrator of the category
					if (in_array($subscriber, $managers))
					{
						continue;
					}

					// Send email to the manager
					$this->_sendEmailToUser($subscriber, $post, $ticket, 'subscriber');
				}
			}
		}
	}

    /**
     * Event fired when a ticket is assigned to someone. ATS will notify assigned user (unless they assigned
     * a ticket to themselves
     *
     * @param    F0FTable  $ticket  Assigned ticket
     *
     * @return   bool               Is everything alright?
     */
    public function onATSassign($ticket)
    {
        require_once JPATH_SITE.'/components/com_ats/helpers/email.php';

        // Current user is the one assigned to, it's useless to notify myself
        if($ticket->assigned_to == JFactory::getUser()->id)
        {
            return true;
        }

        $mailer                  = AtsHelperEmail::getMailer();
        list($subject, $body,)   = AtsHelperEmail::loadEmailTemplateFromDB('manager-assignedticket');
        $sitename                = JFactory::getConfig()->get('sitename');
        $user                    = JFactory::getUser($ticket->assigned_to);

        $mailer->addRecipient($user->email, $user->name);

        $categories = F0FModel::getTmpInstance('Categories','AtsModel')
                        ->category($ticket->catid)
                        ->getList();

        if(!empty($categories))
        {
            $category = array_pop($categories);
        }

        $baseURL    = str_replace('/administrator', '', JURI::base());
        $subpathURL = str_replace('/administrator', '', JURI::base(true));
        $url        = JRoute::_('index.php?option=com_ats&view=ticket&id='.$ticket->ats_ticket_id, false);

        if(substr($url,0,14) == '/administrator')
        {
            $url = substr($url,14);
        }

        $url        = ltrim($url, '/');
        $subpathURL = ltrim($subpathURL, '/');

        // Ehm... why?
        if(substr($url,0,strlen($subpathURL)+1) == "$subpathURL/")
        {
            $url = substr($url,strlen($subpathURL)+1);
        }

        $ticketURL = rtrim($baseURL,'/').'/'.ltrim($url,'/');

        //Grab first post, so we can use its text inside the email
        $post = F0FModel::getTmpInstance('Posts', 'AtsModel')
                    ->ticket($ticket->ats_ticket_id)
                    ->filter_order('ats_post_id')
                    ->filter_order_Dir('ASC')
                    ->getFirstItem();

        $attachmentURL = '';
        if($post->ats_attachment_id)
        {

            $attachment = F0FModel::getTmpInstance('Attachments','AtsModel')
                                ->setId($post->ats_attachment_id)
                                ->getItem();

            //Why this extra check?
            if($attachment->ats_attachment_id == $post->ats_attachment_id)
            {
                $attFilename = JPATH_ROOT.'/media/com_ats/attachments/'.$attachment->mangled_filename;
                $realName    = $attachment->original_filename;

                if(@file_exists($attFilename))
                {
                    $attSize = @filesize($attFilename);

                    if($attSize < 2097152)
                    {
                        // Attach the file
                        $mailer->AtsAddAttachment($attFilename, $realName, 'base64', $attachment->mime_type);
                    }
                    else
                    {
                        // Create a link to the attachment, for attachments over 2Mb
                        $baseURL    = JURI::base();
                        $baseURL    = str_replace('/administrator', '', $baseURL);
                        $subpathURL = JURI::base(true);
                        $subpathURL = str_replace('/administrator', '', $subpathURL);

                        $url = JRoute::_('index.php?option=com_ats&view=attachment&task=read&format=raw&id='.$attachment->ats_attachment_id, true);
                        if(substr($url,0,14) == '/administrator') $url = substr($url,14);
                        $url = ltrim($url, '/');
                        $subpathURL = ltrim($subpathURL, '/');
                        if(substr($url,0,strlen($subpathURL)+1) == "$subpathURL/") $url = substr($url,strlen($subpathURL)+1);
                        $attachmentURL = rtrim($baseURL,'/').'/'.ltrim($url,'/');
                    }
                }
            }
        }

        $mailInfo = array(
            'id'				=> $ticket->ats_ticket_id,
            'title'				=> $ticket->title,
            'attachment'		=> empty($attachmentURL) ? '' : JText::sprintf('PLG_ATS_POSTEMAIL_ATTACHMENT_LINK',$attachmentURL, $realName),
            'url'				=> $ticketURL,
            'catname'			=> $category->title,
            'text'				=> $post->content_html,
            'sitename'			=> $sitename,
            'user_name'			=> $user->name,
        );

        $this->_parseTemplate($body, $subject, $mailInfo, $mailer);

        // Send the email
        $ret = $mailer->Send();
        unset($mailer);

        return true;
    }

	/**
	 * Returns a list of subscribers per ATS category
	 *
	 * @param int $category_id ATS category ID
	 * @param bool $isNewTicket True if this is a new ticket
	 */
	private function _getSubscribersForATSCategory($category_id, $isNewTicket)
	{
		$subscribers = array();

		// @todo

		return $subscribers;
	}

	/**
	 * Gets all the user IDs registered as managers for a specific ATS category
	 *
	 * @param    int    $catid
	 *
	 * @return   array
	 */
	private function _getManagersForATSCategory($catid)
	{
		$managers = AtsHelper::getManagers($catid);

		$params = F0FModel::getTmpInstance('Categories', 'AtsModel')
					->getCatParams($catid);

		if (!is_object($params))
		{
			$notify  = array('all');
            $exclude = array();
		}
		else
		{
			$notify  = $params->get('notify_managers', array('all'));
            $exclude = $params->get('exclude_managers', array());
		}

        $whitelist = array();
        $blacklist = array();

        // Only notify the managers selected by the site administrators if they are, indeed, managers of this category.
        foreach ($managers as $manager)
        {
            if (in_array('all', $notify) || in_array($manager->id, $notify))
            {
                $whitelist[] = $manager->id;
            }
        }

        // Remove managers from the whitelist array
        foreach ($managers as $manager)
        {
            if (in_array('all', $exclude) || in_array($manager->id, $exclude))
            {
                $blacklist[] = $manager->id;
            }
        }

        $ret = array_diff($whitelist, $blacklist);

		return $ret;
	}

	/**
	 * Sends a new post email notification
	 *
	 * @param  int $user_id Recipient's user ID
	 * @param  AtsTablePost $post
	 * @param  AtsTableTicket $ticket
	 * @param  string $towho One of 'manager', 'owner' or 'subscriber'. Determines the subject and post body template.
     *
     * @return bool  Is the email correctly sent?
     */
	private function _sendEmailToUser($user_id, $post, $ticket, $towho = 'manager')
	{
		list($isCLI, ) = F0FDispatcher::isCliAdmin();

		if($isCLI)
        {
			JLoader::import('joomla.application.component.helper');
			$siteURL = JComponentHelper::getParams('com_ats')->get('siteurl','http://www.example.com');
		}

		// Extract the useful information
		$userReceipient = JFactory::getUser($user_id);

		if($post->created_by == -1)
        {
			$userPoster = clone JFactory::getUser();
			$userPoster->username = 'system';
			$userPoster->name = JText::_('COM_ATS_CLI_SYSTEMUSERLABEL');
		}
        else
        {
			$userPoster = JFactory::getUser($post->created_by);
		}

		// Get a mailer instance
	    require_once JPATH_SITE.'/components/com_ats/helpers/email.php';

		$mailer = AtsHelperEmail::getMailer();

		// If the category specifies a category_email parameter,
		// set the Reply-To address to it.
		$categories = F0FModel::getTmpInstance('Categories','AtsModel')
                        ->category($ticket->catid)
                        ->getList();

		if(!empty($categories))
        {
			$category = array_pop($categories);
			$params   = new JRegistry();
			if(version_compare(JVERSION, '3.0', 'ge')) {
				$params->loadString($category->params, 'JSON');
			} else {
				$params->loadJSON($category->params);
			}

			$category_email = $params->get('category_email', '');
			$category_email = trim($category_email);

			if(!empty($category_email))
            {
				$mailfrom = $category_email;
				$conf     = JFactory::getConfig();
				$fromname = $conf->get('fromname');
				$mailer->SetFrom(JMailHelper::cleanLine($mailfrom), JMailHelper::cleanLine($fromname), 0);
			}
		}

		$mailer->addRecipient($userReceipient->email, $userReceipient->name);

		// Load the category
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true)
                    ->select('*')
                    ->from('#__categories')
                    ->where($db->qn('id').' = '.$db->q($ticket->catid));
		$category = $db->setQuery($query)->loadObject();

		// Get the subject
		$isNewTicket = false;

		if(($ticket->modified_by == $ticket->created_by) && ($ticket->modified_on == $ticket->created_on))
        {
			$isNewTicket = true;
		}
        else
        {
			$isNewTicket = $ticket->modified_by == 0;
		}
		$newold = $isNewTicket ? 'NEW' : 'OLD';
		$status = $ticket->public ? 'PUBLIC' : 'PRIVATE';

		// Get default body and subject
		$subject = JText::sprintf("PLG_ATS_POSTEMAIL_{$newold}TICKET_{$status}_TO{$towho}_SUBJECT", $ticket->ats_ticket_id, $ticket->title, $category->title);
		list($template, $subject) = $this->_getEmailTemplate($towho, $isNewTicket, $ticket->public);

		// I have no body and subject, this means that the webmaster doesn't want to send any emails,
		// so let's stop here
		if(!$template && !$subject)
		{
			return true;
		}

		// Set mail priority using phpmailer Priority variable and setting custom headers.
		// X-Priority header is already set by phpmailer
		// http://www.php.net/manual/en/function.mail.php#91058
		if($ticket->priority == 1)
		{
			$mailer->Priority = 2;
			$head_priority = 'High';
		}
		elseif($ticket->priority == 5)
		{
			$mailer->Priority = 3;
			$head_priority = 'Normal';
		}
		else
		{
			$mailer->Priority = 5;
			$head_priority = 'Low';
		}

		$mailer->addCustomHeader('X-MSMail-Priority: '.$head_priority);
		$mailer->addCustomHeader('Importance: '.$head_priority);

		// Attach files if less than 2Mb (with addAttachment($attachFile)), or set up a link to them
		$attachmentURLs = array();

        if($post->attachments)
        {
            foreach($post->attachments as $attachment)
            {
                $attFilename = JPATH_ROOT.'/media/com_ats/attachments/'.$attachment->mangled_filename;
                $realName = $attachment->original_filename;

                if(@file_exists($attFilename))
                {
                    $attSize = @filesize($attFilename);

                    if($attSize < 2097152 && count($post->attachments) == 1)
                    {
                        // Attach the file
                        $mailer->AtsAddAttachment($attFilename, $realName, 'base64', $attachment->mime_type);
                    }
                    else
                    {
                        // Create a link to the attachment, for attachments over 2Mb or for multiple attachments
                        $baseURL = JURI::base();
                        $baseURL = str_replace('/administrator', '', $baseURL);
                        $subpathURL = JURI::base(true);
                        $subpathURL = str_replace('/administrator', '', $subpathURL);

                        if($isCLI)
                        {
                            $url = rtrim($siteURL,'/').'/index.php?option=com_ats&view=attachment&task=read&format=raw&id='.$attachment->ats_attachment_id;
                        }
                        else
                        {
                            $url = JRoute::_('index.php?option=com_ats&view=attachment&task=read&format=raw&id='.$attachment->ats_attachment_id, false);
                        }

                        if(substr($url,0,14) == '/administrator')
                        {
                            $url = substr($url,14);
                        }

                        $url = ltrim($url, '/');
                        $subpathURL = ltrim($subpathURL, '/');

                        if(substr($url,0,strlen($subpathURL)+1) == "$subpathURL/")
                        {
                            $url = substr($url,strlen($subpathURL)+1);
                        }

                        $attachmentURLs[] = rtrim($baseURL,'/').'/'.ltrim($url,'/');
                    }
                }
            }
        }

		// Get a link to the new post
		$baseURL    = JURI::base();
		$baseURL    = str_replace('/administrator', '', $baseURL);
		$subpathURL = JURI::base(true);
		$subpathURL = str_replace('/administrator', '', $subpathURL);

		if($isCLI)
        {
			$url = rtrim($siteURL,'/').'/index.php?option=com_ats&view=ticket&id='.$ticket->ats_ticket_id;
		}
        elseif(class_exists('JApplication'))
        {
			$url = str_replace('&amp;','&', JRoute::_('index.php?option=com_ats&view=ticket&id='.$ticket->ats_ticket_id));
		}
        else
        {
			$url = 'index.php?option=com_ats&view=ticket&id='.$ticket->ats_ticket_id;
		}

		$url .= '#p'.$post->ats_post_id;

		if(substr($url,0,14) == '/administrator')
        {
            $url = substr($url,14);
        }

		$url        = ltrim($url, '/');
		$subpathURL = ltrim($subpathURL, '/');

		if(substr($url, 0, strlen($subpathURL) + 1) == "$subpathURL/")
        {
            $url = substr($url,strlen($subpathURL)+1);
        }

		if($isCLI)
        {
			$postURL = rtrim($siteURL,'/').'/'.ltrim($url,'/');
		}
        else
        {
			$postURL = rtrim($baseURL,'/').'/'.ltrim($url,'/');
		}

		// Get the body of the message, based on overridable template files
		$sitename = JFactory::getConfig()->get('sitename');

		require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/avatar.php';

        $attachmentToken = '';

        if($attachmentURLs)
        {
            foreach($attachmentURLs as $attachmentURL)
            {
                $attachmentToken[] = JText::sprintf('PLG_ATS_POSTEMAIL_ATTACHMENT_LINK',$attachmentURL, $realName);
            }

            $attachmentToken = implode('<br/>', $attachmentToken);
        }

		$mailInfo = array(
			'id'				=> $ticket->ats_ticket_id,
			'title'				=> $ticket->title,
			'url'				=> $postURL,
			'attachment'		=> $attachmentToken,
			'poster_username'	=> $userPoster->username,
			'poster_name'		=> $userPoster->name,
			'user_username'		=> $userReceipient->username,
			'user_name'			=> $userReceipient->name,
			'text'				=> $post->content_html,
			'catname'			=> $category->title,
			'sitename'			=> $sitename,
			'origin'			=> $post->origin,
			'avatar'			=> AtsHelperAvatar::getAvatarURL($userPoster, 64),
			'assigned_to'		=> $ticket->assigned_to ? JFactory::getUser($ticket->assigned_to)->name : JText::_('COM_ATS_TICKETS_UNASSIGNED'),
		);

		list($isCli, $isAdmin) = F0FDispatcher::isCliAdmin();

		if (!$isCli)
		{
			if(!class_exists('AtsHelperSubscriptions', false))
            {
				require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/subscriptions.php';
			}

			if(AtsHelperSubscriptions::hasSubscriptionsComponent())
            {
				$subs = AtsHelperSubscriptions::getSubscriptionsList($userPoster);
				$mailInfo['subscriptions'] = implode(', ', $subs->active);
			}
		}
		else
		{
			$mailInfo['subscriptions'] = '';
		}

		// Prefix the text with the ticket reply information if this is a
		// manager or user email and the reply by email is enabled.
		// Get the component parameters
		JLoader::import('joomla.application.component.helper');
		$cparams = JComponentHelper::getParams('com_ats', false);
		$emailadminonly = $cparams->get('emailadminonly', 0);

		if($cparams->get('replybyemail', 0))
        {
			if( (($towho == 'manager') && !$emailadminonly) || ($towho != 'manager') )
			{
				// Add the reply above line
				$ticketInfo = '{ticketid:'.$mailInfo['id'].'}';
				$body = '!-!- ' . JText::_('PLG_ATS_POSTEMAIL_REPLYABOVE') . ' ' . $ticketInfo . ' -!-!';
				$body = '<p>'.$body.'</p>';
				$template = $body.$template;
				// Add a custom header, too
				$mailer->AddCustomHeader('X-ATS-ticketid:'.$mailInfo['id']);
			}
		}

		$this->_parseTemplate($template, $subject, $mailInfo, $mailer);

		// Send the email
		$ret = $mailer->Send();
		unset($mailer);

		return $ret;
	}

	/**
	 * Gets an email template from the database (preferred), from the overrides
	 * directory (deprecated) or from the translation keys (not encouraged).
	 *
	 * @param string $tpl The template type to fetch, e.g manager or owner
	 * @param bool $isNewTicket Is this a new ticket (true) or a reply (false)?
	 * @param bool $isPublic Is this a public (true) or a private (false) ticket?
	 *
	 * @return array An array containing the subject and template text
	 */
	private function _getEmailTemplate($tpl = 'manager', $isNewTicket, $isPublic)
	{
		// Get status variables
		$tmplFile     = '';
		$templateText = '';
		$subject      = '';
		$loadLanguage = null;

		// Get status variables
		$newold = $isNewTicket ? 'NEW' : 'OLD';
		$status = $isPublic ? 'PUBLIC' : 'PRIVATE';
		$key = strtolower("$tpl-$status-$newold");

		if(!class_exists('AtsHelperEmail')) {
			require_once JPATH_SITE.'/components/com_ats/helpers/email.php';
		}

		// If I'm under ATS PRO, I will only load the template from the DB
		if(ATS_PRO)
		{
			list($templateText, $subject, $loadLanguage) = AtsHelperEmail::loadEmailTemplateFromDB($key);
		}
		// Otherwise I'll load it from the filesystem
		else
		{
			// Get default body
			$loadLanguage = null;
			$basePath = dirname(__FILE__).'/templates/';
			$jLang = JFactory::getLanguage();
			$userLang = JFactory::getUser()->getParam('language','');
			$languages = array(
				$userLang, $jLang->getTag(), $jLang->getDefault(), 'en-GB', '*'
			);

			foreach($languages as $lang)
			{
				if(empty($lang))
				{
					continue;
				}

				if(!empty($loadLanguage))
				{
					continue;
				}

				$filename = "$lang/$tpl.tpl";

				if(file_exists($basePath.'overrides/'.$filename))
				{
					$loadLanguage = $lang;
					$tmplFile = $basePath.'overrides/'.$filename;
					break;
				}
				elseif(file_exists($basePath.'default/'.$filename))
				{
					$loadLanguage = $lang;
					$tmplFile = $basePath.'default/'.$filename;
					break;
				}
			}
			JLoader::import("joomla.filesystem.file");

			// Load the template text
			if($tmplFile && JFile::exists($tmplFile))
			{
				$templateText = @file_get_contents($tmplFile);

				if(empty($templateText))
				{
					$templateText = JFile::read($tmplFile);
				}
			}
		}

		return array($subject, $templateText);
	}

    /**
     * Parses the template's variables
     *
     * @param $templateText
     * @param string $subject The subject of the email
     * @param array $mailInfo Extra parameters
     * @param JMail $mailer The PHPMailer object
     */
	private function _parseTemplate($templateText, $subject, $mailInfo, &$mailer)
	{
		if(!class_exists('AtsHelperEmail')) {
			require_once JPATH_SITE.'/components/com_ats/helpers/email.php';
		}
		AtsHelperEmail::parseTemplate($templateText, $subject, $mailInfo, $mailer);
	}
}