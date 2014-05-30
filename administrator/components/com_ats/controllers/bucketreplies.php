<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

// @TODO Currently there are two controllers for Bucketreplies - one for the front- and one of the backend. Can this be avoided?

class AtsControllerBucketreplies extends F0FController
{
	protected function onBeforeSave()
	{
		$bucket_id = $this->input->getInt('ats_bucket_id',0);
		$item_id = $this->input->getInt('Itemid',0);
		$url = 'index.php?option=com_ats&view=bucket&id='.$bucket_id.(JFactory::getApplication()->isSite() ? '&Itemid='.$item_id : '');

		$this->input->set('returnurl', base64_encode($url));
		return true;
	}

	/**
	 * Save the reply
	 */
	public function save()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}

		// Reply
		$model  = F0FModel::getTmpInstance('Bucketreplies','AtsModel');
		$data   = $this->input->getData();
		$result = $model->reply($data);

		$this->setRedirect('index.php?option=com_ats&view=bucket&id='.$data['ats_bucket_id']);
	}
}