<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsViewBucket extends F0FViewHtml
{
	public function onEdit($tpl = null) {
		// Get bucket ID
		$data = $this->input->getData();
		$bucket_id = $data['id'];

		// Get all tickets of the bucket
		$tickets = F0FModel::getTmpInstance('Tickets','AtsModel')
			->bucket($bucket_id)
			->getList();
		$this->assign('tickets', $tickets);

		return parent::onEdit($tpl);
	}
}