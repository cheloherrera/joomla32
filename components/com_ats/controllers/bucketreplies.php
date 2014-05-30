<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerBucketreplies extends F0FController
{
	public function __construct($config = array())
    {
		parent::__construct($config);
		$this->cacheableTasks = array();
	}

	protected function onBeforeSave()
	{
		// @TODO handle attachments?

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
		$model  = $this->getThisModel();
		$data   = $this->input->getData();
		$result = $model->reply($data);

		if($result)
		{
			$msg  = JText::_('COM_ATS_BUCKET_POST_ADDED');
			$type = 'message';
		}
		else
		{
			$msg  = JText::_('COM_ATS_BUCKET_POST_ADD_ERROR');
			$type = 'error';
		}

		$url = JRoute::_('index.php?option=com_ats&view=bucket&id='.$data['ats_bucket_id']);
		$returnURL = $this->input->getBase64('returnurl');
		if($returnURL)
		{
			$url = base64_decode($returnURL);
		}

		$this->setRedirect($url, $msg, $type);
	}
}