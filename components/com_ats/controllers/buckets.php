<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerBuckets extends F0FController
{
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->cacheableTasks = array();
		$this->registerTask('choosebucket', 'browse');
	}

	public function execute($task)
	{
		if(in_array($task,array('new','edit','read','add')))
		{
			$task = 'read';
		}
		return parent::execute($task);
	}

	public function onBeforeRead()
	{
		// Get the bucket ID
		if(!$this->input->getInt('id',0)) {
			JError::raiseError('501', JText::_('COM_ATS_ERR_INVALID_BUCKETID'));
			return false;
		}
		$this->layout = 'item';

		// Is this a valid bucket?
		if($this->getThisModel()->getItem()->ats_bucket_id != $this->input->getInt('id',0))
		{
			JError::raiseError('404', JText::_('COM_ATS_ERR_BUCKETNOTFOUND'));
			return false;
		}

		// Fetch privileges
		$perms = $this->_getPrivileges();

		if(!$perms['view']) {
			if(JFactory::getUser()->guest) {
				$returl = base64_encode(JFactory::getURI()->toString());
				$url = JRoute::_('index.php?option=com_users&view=login&return='.$returl);
				JFactory::getApplication()->redirect($url, JText::_('COM_ATS_ERR_BUCKETNOTAUTH'));
			} else {
				JError::raiseError('403', JText::_('COM_ATS_ERR_BUCKETNOTAUTH'));
				return false;
			}
		}

		// Get page parameters
		$this->getThisView()->assign('perms',	$perms);

		$params = JFactory::getApplication()->getPageParameters('com_ats');
		$this->getThisView()->assign('pageparams',		$params);

		// Load reply data from session and push data
		$this->getThisView()->assign('post_content',	JFactory::getSession()->get('post_content', '', 'com_ats.newbucket'));
		JFactory::getSession()->clear('post_content',	'com_ats.newbucket');

		// Redirection to canonical URL
		$currentURL = JFactory::getURI()->toString(array('path', 'query', 'fragment'));
		$canonicalURL = JRoute::_('index.php?option=com_ats&view=bucket&id='.$this->getThisModel()->getItem()->ats_bucket_id);
		$canonicalURL = str_replace('&amp;', '&', $canonicalURL);
		if(substr($currentURL, 0, strlen($canonicalURL)) != $canonicalURL) {
			JFactory::getApplication()->redirect($canonicalURL, '', 'message', true);
		}

		return true;
	}

	protected function onBeforeBrowse()
	{
		$user = JFactory::getUser();

		// Only users with admin or manage permissions can see the buckets
		if(!$user->authorise('core.admin', 'com_ats') || !$user->authorise('core.manage', 'com_ats'))
		{
			return false;
		}

		$result = parent::onBeforeBrowse();
		if($result) {
			// Convince the model to sort on date, descending and filter on mine
			// or public buckets
			$db = JFactory::getDbo();

			$this->getThisModel()
				->frontendfilter(1)
				->enabled(1)
				->limit(20)
				->filterNewest(1)
				->filter_order_Dir('DESC')
				;

			// @TODO Remove these variables, since they are already fetch by F0F and stored inside $params view variable
			// Fetch page parameters
			$params = JFactory::getApplication()->getPageParameters('com_ats');

			// Push page parameters
			$this->getThisView()->assign('pageparams',		$params);

			/**/
			// Redirection to canonical URL
			$currentURL = JFactory::getURI()->toString(array('path', 'query', 'fragment'));
			$canonicalURL = JRoute::_('index.php?option=com_ats&view=buckets');
			$canonicalURL = str_replace('&amp;', '&', $canonicalURL);
			if(substr($currentURL, 0, strlen($canonicalURL)) != $canonicalURL) {
				// This line is required for the state to persist
				$dummyList = $this->getThisModel()->getItemList();
				// Perform the actual redirection
				JFactory::getApplication()->redirect($canonicalURL, '', 'message', true);
			}
			/**/
		}
		return $result;
	}

	/**
	 * Get the privileges for the current bucket
	 * @return array
	 */
	private function _getPrivileges()
	{
		$ret = array(
			'view'		=> false,
			'post'		=> false,
			'edit'		=> false,
			'admin'		=> false,
			'close'		=> false,
			'attachment'=> false,
		);

		$bucket = $this->getThisModel()->getItem();

		// If I am the onwer of this bucket, I can see it and post to it
		if($bucket->created_by == JFactory::getUser()->id) {
			$ret['view'] = true;
			$ret['post'] = true;
			$ret['close'] = true;
			// @TODO
			// If I can edit my own in this category, I can edit the bucket
			/*if(JFactory::getUser()->authorise('core.edit.own', 'com_ats.category.'.$bucket->catid)) {
				$ret['edit'] = true;
			}*/
			// If I can generally edit my own, I can edit the bucket
			if(JFactory::getUser()->authorise('core.edit.own', 'com_ats')) {
				$ret['edit'] = true;
			}
		}

		// If I am the manager of the component, I can do anything
		if(
			JFactory::getUser()->authorise('core.manage', 'com_ats')
			|| JFactory::getUser()->authorise('core.manage', 'com_ats.category.' . $bucket->catid)
			)
		{
			$ret = array(
				'view'		=> true,
				'post'		=> true,
				'edit'		=> true,
				'admin'		=> true,
				'close'		=> true,
				'attachment'=> true,
			);
		}

		// I am allowed attachments, generally
		if(JFactory::getUser()->authorise('ats.attachment', 'com_ats')) {
			$ret['attachment'] = true;
		}

		return $ret;
	}

	public function public_publish()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}

		$this->setpublic(1);
	}

	public function public_unpublish()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}

		$this->setpublic(0);
	}

	protected final function setpublic($state = 0)
	{
		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$perms = $this->_getPrivileges();
		if(!$perms['admin']) {
			JError::raiseError('403', 'JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');
			return false;
		} else {
			$status = $model->visible($state);
		}

		// redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=bucket&id='.$this->input->getInt('id',0).'&Itemid='.$this->input->getInt('Itemid',0);
		if(!$status)
		{
			$this->setRedirect($url, $model->getError(), 'error');
		}
		else
		{
			$this->setRedirect($url);
		}
		$this->redirect();
		return;
	}

	public function close()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}

		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$perms = $this->_getPrivileges();
		if(!$perms['admin'] && !($model->getItem()->created_by = JFactory::getUser()->id)) {
			JError::raiseError('403', 'JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');
			return false;
		}

		$data = $model->getItem()->getData();
		$data['status'] = 'C';
		$model->getItem()->save($data);

		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=bucket&id='.$this->input->getInt('id',0).'&Itemid='.$this->input->getInt('Itemid',0);
		if($status == false) {
			$this->setRedirect($url, $model->getError(), 'error');
		} else {
			$this->setRedirect($url);
		}
	}

	public function reopen()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}

		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$perms = $this->_getPrivileges();
		if(!$perms['admin']) {
			JError::raiseError('403', 'JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');
			return false;
		}

		$data = $model->getItem()->getData();
		$data['status'] = 'O';
		$model->getItem()->save($data);

		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=bucket&id='.$this->input->getInt('id',0).'&Itemid='.$this->input->getInt('Itemid',0);
		if($status == false) {
			$this->setRedirect($url, $model->getError(), 'error');
		} else {
			$this->setRedirect($url);
		}
	}

	/**
	 * ACL check before changing the publish status of a record; override to customise
	 *
	 * @return  boolean  True to allow the method to run
	 */
	protected function onBeforePublish()
	{
		$perms = $this->_getPrivileges();
		return $perms['admin'];
	}

	/**
	 * ACL check before changing the publish status of a record; override to customise
	 *
	 * @return  boolean  True to allow the method to run
	 */
	protected function onBeforeUnpublish()
	{
		$perms = $this->_getPrivileges();
		return $perms['admin'];
	}

	public function addtickets()
	{
		// @TODO Use header instead of return values
		$tickets = $this->input->getInt('ats_ticket_id');
		$bucket  = $this->input->getInt('cid');

		if(!$bucket)
		{
			echo json_encode('false');
			return false;
		}

		if(!$tickets)
		{
			$msg  = JText::_('COM_ATS_BUCKETS_NO_TICKET_SELECTED');
			$type = 'notice';

			echo json_encode('false');
			return false;
		}
		else
		{
			$result = F0FModel::getTmpInstance('Tickets', 'AtsModel')
						->addTicketsToBucket($tickets, $bucket);

			if(!$result)
			{
				echo json_encode('false');
				return false;
			}
		}

		echo json_encode('true');
		return true;
	}
}