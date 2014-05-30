<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTablePost extends F0FTable
{
	/** @var bool Is this a new ticket? Automatically managed */
	private $_isNew = false;

	public function onBeforeBind(&$from) {
		$result = parent::onBeforeBind($from);
		if($result) {
			$from = (array)$from;
			if(array_key_exists('content', $from) && !array_key_exists('content_html', $from)) {
				$from['content_html'] = '';
			} elseif(!array_key_exists('content', $from) && array_key_exists('content_html', $from)) {
				$from['content'] = '';
			}
		}
		return $result;
	}

	public function check()
	{
		$ret = true;

		// Do we have a valid ticket?
		if(empty($this->ats_ticket_id)) {
			$this->setError(JText::_('COM_ATS_POSTS_ERR_NOTICKET'));
			$ret = false;
		} else {
			$this->_ticket = F0FModel::getTmpInstance('Ticket', 'AtsModel')
				->setId($this->ats_ticket_id)
				->getItem();
			if($this->_ticket->ats_ticket_id != $this->ats_ticket_id) {
				$this->setError(JText::_('COM_ATS_POSTS_ERR_INVALIDTICKET'));
				$ret = false;
			}
		}

		// Process the content
		require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/bbcode.php';
		$content = htmlentities($this->content, ENT_NOQUOTES, 'UTF-8', false);
		$content = str_replace('<', '&lt;', $content);
		$content = str_replace('>', '&gt;', $content);
		if(!empty($content)) {
			$this->content_html = AtsHelperBbcode::parseBBCode($content);
		} else {
			require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/filter.php';
			$this->content_html = AtsHelperFilter::filterText($this->content_html);
		}

		return $ret;
	}

	protected function onBeforeStore($updateNulls = true) {
		$ret = parent::onBeforeStore(true);

		// Check for new post
		if($ret) {
			// If it's a new post, save the ticket ID
			if($this->ats_post_id == 0) {
				$this->_ticket_id = $this->ats_ticket_id;
				$this->_isNew = true;
			} else {
				$this->_ticket_id = null;
			}
		}

		return $ret;
	}

	protected function onAfterStore()
	{
		$ret = parent::onAfterStore();

		if($ret)
		{
            // Load attachments inside the table
            $attachments = array();
            $table       = F0FModel::getTmpInstance('Attachments', 'AtsModel')->getTable();

            if($this->ats_attachment_id)
            {
                $files = explode(',', $this->ats_attachment_id);

                foreach($files as $file)
                {
                    $table->load($file);
                    $attachments[] = clone $table;
                }
            }

            $this->attachments = $attachments;

			if(!is_null($this->_ticket_id))
			{
				// Charge credits for the reply
				if($this->created_by == $this->_ticket->created_by)
				{
					if(!class_exists('AtsHelperCredits'))
					{
						require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';
					}
					// If the post is within 10 seconds of the ticket, it's the
					// first post of a ticket and must not be charged.
					JLoader::import('joomla.utilities.date');

					$params  = JComponentHelper::getParams('com_ats');
					$jTicket = new JDate($this->_ticket->created_on);
					$jPost   = new JDate($this->created_on);
					if($params->get('showcredits', 0) && abs($jTicket->toUnix() - $jPost->toUnix()) > 10)
					{
						AtsHelperCredits::chargeCredits($this->created_by, $this->_ticket->catid, $this->_ticket->ats_ticket_id, $this->ats_post_id, false, $this->_ticket->public);
					}
				}

				// Update the existing ticket
				if($this->_ticket->status != 'C')
				{
					// Get the total amount of tracked item for all posts of this ticket
					$db = JFactory::getDbo();
					$query = $db->getQuery(true)
						->select('SUM(' . $db->qn('timespent') . ')')
						->from($db->qn('#__ats_posts'))
						->where($db->qn('ats_ticket_id') . ' = ' . $db->q($this->_ticket_id))
						->where($db->qn('enabled') . ' = ' . $db->q('1'));
					$db->setQuery($query);
					$timespent = $db->loadResult();

					if($this->created_by == $this->_ticket->created_by)
					{
						// The user replied -- open
						$this->_ticket->save(array(
							'status'	=> 'O',
							'timespent'	=> $timespent,
						));
					}
					else
					{
						// A manager replied -- pending
						$this->_ticket->save(array(
							'status'	=> 'P',
							'timespent'	=> $timespent,
						));
					}
				}

				// New post, call plugins (e.g. email)
				$this->postNotifiable(true);
			}
			else
			{
				// Existing post is modified, call plugins (e.g. email)
				$this->postNotifiable(false);
			}
		}

		return $ret;
	}

	protected function onBeforeDelete($oid)
    {
		$status = parent::onBeforeDelete($oid);

		if($status)
        {
			// Load the post record
			$item = clone $this;
			$item->load($oid);

			// Delete any attachments
			if($item->ats_attachment_id)
            {
                $attachments = explode(',', $item->ats_attachment_id);

                $table = F0FModel::getTmpInstance('Attachments', 'AtsModel')->getTable();

                foreach($attachments as $attachment)
                {
                    $table->delete($attachment);
                }
			}

			// Refund credits
			$ticket = F0FModel::getTmpInstance('Tickets','AtsModel')
				->setId($item->ats_ticket_id)
				->getItem();

			if(!class_exists('AtsHelperCredits'))
            {
				require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';
			}

			AtsHelperCredits::refundCredits($ticket->catid, $ticket->ats_ticket_id, $item->ats_post_id, 'post');
		}

		return $status;
	}

	private function postNotifiable($newPost = false)
	{
		// Load the "ats" plugins
		JLoader::import('joomla.plugin.helper');
		JPluginHelper::importPlugin('ats');

		// Reference to the Ticket object
		$ticket = F0FModel::getTmpInstance('Tickets', 'AtsModel')
			->setId($this->ats_ticket_id)
			->getItem();

		$info = array(
			'new'		=> $newPost,
			'post'		=> clone $this,
			'ticket'	=> $ticket,
		);

		// Fire plugins (onAKSubscriptionChange) passing ourselves as a parameter
		$dispatcher = JDispatcher::getInstance();
		$jResponse = $dispatcher->trigger('onATSPost', array($info));

		return true;
	}

	protected function onBeforePublish(&$cid, $publish)
	{
		require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';

		$params = JComponentHelper::getParams('com_ats');
		$result = parent::onBeforePublish($cid, $publish);

		if($result)
		{
			if(!is_array($cid))
			{
				$cid = array($cid);
			}

			foreach($cid as $id)
			{
				// $cid contains the post number. We have to retrieve the post record
				// and the ticket record
				$post = F0FModel::getTmpInstance('Posts','AtsModel')
							->setId($id)
							->getItem();
				if($post->ats_post_id == $id)
				{
					$ticket = F0FModel::getTmpInstance('Tickets','AtsModel')
						->setId($post->ats_ticket_id)
						->getItem();

					// Apply credit logic only if we enabled that feature
					if($params->get('showcredits', 0))
					{
						if($publish)
						{
							// Charge credits on post publish
							AtsHelperCredits::chargeCredits($post->created_by, $ticket->catid, $ticket->ats_ticket_id, $post->ats_post_id, false, $ticket->public);
						}
						else
						{
							// Refund credits on post unpublish
							AtsHelperCredits::refundCredits($ticket->catid, $ticket->ats_ticket_id, $post->ats_post_id, 'post');
						}
					}
				}
			}


		}

		return $result;
	}
}