<?php
/**
 * @package   ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license   GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTableTicket extends F0FTable
{
	/** @var bool Is this a new ticket? Automatically managed */
	private $_isNew = false;

	/** @var bool Used by the CRON jobs to prevent created_by from being overridden */
	public static $overrideuser = false;

	function visible($cid = null, $publish = 1, $user_id = 0)
	{
		JArrayHelper::toInteger($cid);
		$user_id = (int)$user_id;
		$publish = (int)$publish;
		$k = $this->_tbl_key;

		if (count($cid) < 1)
		{
			if ($this->$k)
			{
				$cid = array($this->$k);
			}
			else
			{
				$this->setError("No items selected.");

				return false;
			}
		}

		if (method_exists($this, 'onBeforeVisible'))
		{
			if (!$this->onBeforeVisible($cid, $publish))
			{
				return false;
			}
		}

		$query = $this->_db->getQuery(true)
			->update($this->_db->qn($this->_tbl))
			->set($this->_db->qn('public') . ' = ' . (int)$publish);

		$checkin = in_array('locked_by', array_keys($this->getProperties()));
		if ($checkin)
		{
			$query->where(
				' (' . $this->_db->qn('locked_by') .
				' = 0 OR ' . $this->_db->qn('locked_by') . ' = ' . (int)$user_id . ')',
				'AND'
			);
		}

		$cids = $this->_db->qn($k) . ' = ' .
			implode(' OR ' . $this->_db->qn($k) . ' = ', $cid);
		$query->where('(' . $cids . ')');

		$this->_db->setQuery((string)$query);
		if (!$this->_db->execute())
		{
			$this->setError($this->_db->getErrorMsg());

			return false;
		}

		if (count($cid) == 1 && $checkin)
		{
			if ($this->_db->getAffectedRows() == 1)
			{
				$this->checkin($cid[0]);
				if ($this->$k == $cid[0])
				{
					$this->published = $publish;
				}
			}
		}
		$this->setError('');

		return true;
	}

	function setstatus($cid = null, $status = 'C', $user_id = 0)
	{
		JArrayHelper::toInteger($cid);
		$user_id = (int)$user_id;
		$status = strtoupper(substr($status, 0, 1));
		$k = $this->_tbl_key;

		if (count($cid) < 1)
		{
			if ($this->$k)
			{
				$cid = array($this->$k);
			}
			else
			{
				$this->setError("No items selected.");

				return false;
			}
		}

		$query = $this->_db->getQuery(true)
			->update($this->_db->qn($this->_tbl))
			->set($this->_db->qn('status') . ' = ' . $this->_db->q($status));

		$checkin = in_array('locked_by', array_keys($this->getProperties()));
		if ($checkin)
		{
			$query->where(
				' (' . $this->_db->qn('locked_by') .
				' = 0 OR ' . $this->_db->qn('locked_by') . ' = ' . (int)$user_id . ')',
				'AND'
			);
		}

		$cids = $this->_db->qn($k) . ' = ' .
			implode(' OR ' . $this->_db->qn($k) . ' = ', $cid);
		$query->where('(' . $cids . ')');

		$this->_db->setQuery((string)$query);
		if (!$this->_db->execute())
		{
			$this->setError($this->_db->getErrorMsg());

			return false;
		}

		if (count($cid) == 1 && $checkin)
		{
			if ($this->_db->getAffectedRows() == 1)
			{
				$this->checkin($cid[0]);
				if ($this->$k == $cid[0])
				{
					$this->published = $publish;
				}
			}
		}
		$this->setError('');

		return true;
	}

	public function check()
	{
		$ret = true;

		// Do we have a category?
		if (empty($this->catid))
		{
			$ret = false;
			$this->setError(JText::_('COM_ATS_TICKETS_ERR_NOCATID'));
		}

		// Can we post to the category?
		if (!class_exists('AtsHelper'))
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/ats.php';
		}

		if (self::$overrideuser || JFactory::getSession()->get('ticket.overrideuser', 0, 'com_ats'))
		{
			$userid = $this->created_by;
		}
		else
		{
			$userid = null;
		}

		$actions = AtsHelper::getActions($this->catid, $userid, $this->created_by);

		if (!$actions->get('core.create'))
		{
			$ret = false;
			$this->setError(JText::_('COM_ATS_TICKETS_ERR_CATNOAUTH'));
		}

		// Do we have a title?
		$this->title = trim($this->title);
		if (empty($this->title))
		{
			$ret = false;
			$this->setError(JText::_('COM_ATS_TICKETS_ERR_NOTITLE'));
		}

		// Do we have an alias?
		if (is_string($this->alias))
		{
			$this->alias = trim($this->alias);
		}
		else
		{
			$this->alias = '';
		}
		if (empty($this->alias))
		{
			require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/filter.php';
			$this->alias = AtsHelperFilter::toSlug($this->title);
		}

		// Do we have the same slug?
		$existingItems = F0FModel::getTmpInstance('Tickets', 'AtsModel')
			->alias($this->alias)
			->getList(true);

		if (!empty($existingItems))
		{
			$count = 0;
			$maxid = 0;
			$k = $this->getKeyName();
			foreach ($existingItems as $item)
			{
				if ($item->$k != $this->$k)
				{
					// Is it the exact same alias?
					if ($item->alias == $this->alias)
					{
						$count++;
						// Or is it alias-number
					}
					else
					{
						$number = substr($item->alias, strlen($this->alias));
						$number = (int)$number;
						if ($number <= 0)
						{
							continue;
						}

						$count++;
						if ($number > $maxid)
						{
							$maxid = $number;
						}
					}
				}
			}
			if ($count)
			{
				// Let's try to create a unique alias
				if ($maxid == 0)
				{
					$maxid = $count;
				}
				$maxid++;
				$this->alias .= '-' . $maxid;
			}
		}

		// Check the public status
		if (!$this->public)
		{
			$myData = $this->getData();
			$allowed = true;
			// If the ticket already exists and it is already private, do nothing
			$checkExisting = clone $this;
			$checkExisting->reset();
			$checkExisting->load($this->ats_ticket_id);
			$allowed = ($checkExisting->ats_ticket_id == $this->ats_ticket_id);
			// Is the current user allowed to make the ticket private?
			if (!$allowed)
			{
				$allowed = AtsHelper::getActions($this->catid)->get('ats.private', false);
			}
			// Is the owner allowed private tickets?
			if (!$allowed)
			{
				$user = JUser::getInstance($this->created_by);
				$allowed = $user->authorise('ats.private', 'com_ats.category.' . (int)($this->catid));
			}
			// Switch to public mode if all checks failed
			if (!$allowed)
			{
				$this->public = 1;
			}
			$this->bind($myData);
		}

		// Check the status
		// @TODO: Do we really need this check?
		if (!in_array($this->status, array('O', 'P', 'C', 1, 2, 3, 4, 5, 6, 7, 8, 9)))
		{
			$this->status = 'O';
		}

		// Check the origin
		if (!in_array($this->origin, array('web', 'email')))
		{
			$this->origin = 'web';
		}

		// Priority is not set, so I automatically set it by looking at the visibility
		if (!$this->priority)
		{
			if (!$this->public)
			{
				// Private tickets have high priority
				$this->priority = 1;
			}
			else
			{
				$this->priority = 5;
			}
		}

		// I have to manually add the create_on field, or F0F will replace the userid in created_by
		// and we can't create tickets on behalf of another user
		if (!$this->created_on || ($this->created_on == '0000-00-00 00:00:00') || ($this->created_on == JFactory::getDbo()->getNullDate()))
		{
			$date = new JDate();
			$this->created_on = $date->toSql();
		}


		return $ret;
	}

	protected function onBeforeStore($updateNulls)
	{
		$result = parent::onBeforeStore(true);
		if ($result)
		{
			$this->_isNew = empty($this->ats_ticket_id);
			// @TODO ATS uses doens't follow all F0F conventions, so some events aren't fired.
			// This is the common line for every request (backend and frontend)
			// Convert the custom fields array into a JSON string
			$custom = $this->input->get('custom', array(), 'array');
			if ($custom)
			{
				$this->params = json_encode($custom);
			}
		}

		return $result;
	}

	protected function onAfterStore()
	{
		require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/credits.php';

		$params = JComponentHelper::getParams('com_ats');
		$result = parent::onAfterStore();

		// If it's a new ticket, charge credits (only if we enabled that feature)
		if ($result && $params->get('showcredits', 0) && $this->_isNew)
		{
			AtsHelperCredits::chargeCredits($this->created_by, $this->catid, $this->ats_ticket_id, 0, true, $this->public, $this->priority);
		}

		return $result;
	}

	protected function onBeforePublish(&$cid, $publish)
	{
		require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/credits.php';

		$params = JComponentHelper::getParams('com_ats');
		$result = parent::onBeforePublish($cid, $publish);

		// Apply credit logic only if we enabled that feature
		if ($result && $params->get('showcredits', 0))
		{
			$ticket = F0FModel::getTmpInstance('Tickets', 'AtsModel')
				->setId($cid)
				->getItem();

			if ($publish)
			{
				// Charge credits on ticket publish
				AtsHelperCredits::chargeCredits($ticket->created_by, $ticket->catid, $ticket->ats_ticket_id, 0, true, $ticket->public, $this->priority);
			}
			else
			{
				// Refund credits on ticket unpublish
				AtsHelperCredits::refundCredits($ticket->catid, $ticket->ats_ticket_id, 0, 'ticket');
			}
		}

		return $result;
	}

	protected function onBeforeDelete($oid)
	{
		$result = parent::onBeforeDelete($oid);

		if ($result)
		{
			// Load the ticket. This is required to refund the credits later on.
			$this->load($oid);
		}

		return $result;
	}

	protected function onAfterDelete($oid)
	{
		$result = parent::onAfterDelete($oid);
		if ($result)
		{
			// Remove all posts under this ticket
			$postsModel = F0FModel::getTmpInstance('Posts', 'AtsModel');
			$posts = $postsModel
				->ticket($oid)
				->getItemList(true);
			if (!empty($posts))
			{
				$table = $postsModel->getTable();
				foreach ($posts as $post)
				{
					$table->delete($post->ats_post_id);
				}
			}

			// Remove credit charges for this ticket
			require_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/credits.php';

			$params = JComponentHelper::getParams('com_ats');

			if ($params->get('showcredits', 0))
			{
				var_dump($this->catid, $this->ats_ticket_id);
				AtsHelperCredits::refundCredits($this->catid, $this->ats_ticket_id, 0, 'ticket');
			}
		}

		return $result;
	}

	/**
	 * Converts the params JSON string into a formatted array
	 */
	protected function onAfterLoad(&$result)
	{
		if ($result && $this->params && $this->params != '{}')
		{
			$this->custom = json_decode($this->params, true);
		}

		parent::onAfterLoad($result);
	}
}
