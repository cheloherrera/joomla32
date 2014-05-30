<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelBucketreplies extends F0FModel
{
	/*
	 * Reply to all tickets in the bucket
	 */
	public function reply($data = array())
	{
		if(empty($data))
		{
			$data = $this->input->getData();
		}

		$bucket_id = $data['ats_bucket_id'];

		if(!$bucket_id)
		{
			return false;
		}

		$user    = JFactory::getUser();
		$db		 = JFactory::getDbo();
		$jNow    = new JDate();

		$content      = isset($data['content']) ? $data['content'] : null;
		$content_html = isset($data['content_html']) ? $data['content_html'] : null;

		$tickets = F0FModel::getTmpInstance('Tickets','AtsModel')
					->bucket($bucket_id)
					->getList();

		$result = true;

		foreach($tickets as $ticket)
		{
			$t = F0FModel::getTmpInstance('Tickets','AtsModel')
					->getItem($ticket->ats_ticket_id);

			// Reply if ticket is not closed
			if($t->status == 'C')
			{
				continue;
			}

			$post = array(
				'ats_ticket_id'		=> $ticket->ats_ticket_id,
				'content'			=> $content,
				'content_html'  	=> $content_html,
				'enabled'			=> 1
			);
			$table = clone F0FTable::getAnInstance('Post', 'AtsTable');

			// Let's use the save method so it will fire every event
			$result = $table->save($post) && $result;
		}

		return $result;
	}
}