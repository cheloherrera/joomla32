<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerTickets extends F0FController
{
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->cacheableTasks = array();
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
		// Get the ticket ID
		if(!$this->input->getInt('id',0)) {
			JError::raiseError('501', JText::_('COM_ATS_ERR_INVALID_TICKETID'));
			return false;
		}

		if ($this->layout != 'print')
		{
			$this->layout = 'item';
		}

		// Is this a valid ticket?
		if($this->getThisModel()->getItem()->ats_ticket_id != $this->input->getInt('id',0))
		{
			JError::raiseError('404', JText::_('COM_ATS_ERR_TICKETNOTFOUND'));
			return false;
		}

		// Fetch privileges
		$perms = $this->_getPrivileges();

		if(!$perms['view']) {
			if(JFactory::getUser()->guest) {
				$returl = base64_encode(JFactory::getURI()->toString());
				$url = JRoute::_('index.php?option=com_users&view=login&return='.$returl, false);
				JFactory::getApplication()->redirect($url, JText::_('COM_ATS_ERR_TICKETNOTAUTH'));
			} else {
				JError::raiseError('403', JText::_('COM_ATS_ERR_TICKETNOTAUTH'));
				return false;
			}
		}

		// Get page parameters
		$this->getThisView()->assign('perms',	$perms);

		$params = JFactory::getApplication()->getPageParameters('com_ats');
		$this->getThisView()->assign('pageparams',		$params);

		// Get ticket category
		$categories = F0FModel::getTmpInstance('Categories','AtsModel')
			->category($this->getThisModel()->getItem()->catid)
			->getList();
		if(!empty($categories)) {
			$category = array_pop($categories);
		}

		if (!isset($category))
		{
			return false;
		}

		$this->getThisView()->assign('category',	$category);

		// Do we have Akeeba Subscriptions?
		JLoader::import('joomla.filesystem.folder');
		$hasAkeebasubs = JFolder::exists(JPATH_ADMINISTRATOR.'/components/com_akeebasubs');
		$this->getThisView()->assign('akeebasubs', $hasAkeebasubs);

		// Push Akeeba Subscriptions' levels for this user
		if($hasAkeebasubs) {
			if(!defined('AKEEBASUBS_VERSION')) {
				include_once JPATH_ADMINISTRATOR.'/components/com_akeebasubs/version.php';
			}

			$subs = F0FModel::getTmpInstance('Subscriptions', 'AkeebasubsModel')
				->limit(0)
				->limitstart(0)
				->paystate('C')
				->user_id($this->getThisModel()->getItem()->created_by)
				->getList();

			$subscriptions_active = array();
			$subscriptions_inactive = array();
			if(!empty($subs)) foreach($subs as $sid => $sub) {
				$name = $sub->title;
				if($sub->enabled) {
					if(!in_array($name, $subscriptions_active)) $subscriptions_active[] = $name;
				} else {
					if(!in_array($name, $subscriptions_inactive)) $subscriptions_inactive[] = $name;
				}
			}
			$this->getThisView()->assign('activesubs', $subscriptions_active);
			$this->getThisView()->assign('inactivesubs', $subscriptions_inactive);
		}

		// Load reply data from session and push data
		$this->getThisView()->assign('post_content',	JFactory::getSession()->get('post_content', '', 'com_ats.newticket'));
		JFactory::getSession()->clear('post_content',	'com_ats.newticket');

		$this->getThisView()->cache = array();

		// Redirection to canonical URL
		$currentURL = JFactory::getURI()->toString(array('path', 'query', 'fragment'));
		$canonicalURL = JRoute::_('index.php?option=com_ats&view=ticket&id='.$this->getThisModel()->getItem()->ats_ticket_id);
		$canonicalURL = str_replace('&amp;', '&', $canonicalURL);
		if(substr($currentURL, 0, strlen($canonicalURL)) != $canonicalURL) {
			JFactory::getApplication()->redirect($canonicalURL, '', 'message', true);
		}

		return true;
	}

	protected function onBeforeBrowse() {
		$result = parent::onBeforeBrowse();
		if($result) {
			// Convince the model to sort on date, descending and filter on mine
			// or public tickets
			$db = JFactory::getDbo();

			$this->getThisModel()
				->frontendfilter(1)
				->enabled(1)
				->limit(20)
				->filterNewest(1)
				->filter_order_Dir('DESC')
				;

			// Fetch page parameters
			$params = JFactory::getApplication()->getPageParameters('com_ats');

			// Fetch the category
			$category_id = $this->input->getInt('category',0);
			if(empty($category_id)) {
				$category_id = $params->get('category', 0);
			}
			$categories = F0FModel::getTmpInstance('Categories','AtsModel')
				->category($category_id)
				->getList();
			if(!empty($categories)) {
				$category = array_pop($categories);
			} else {
				// Category not found, this means that the user is not allowed to access it
				return false;
			}

			// Push page parameters
			$this->getThisView()->assign('pageparams',		$params);

			// Push category object
			$this->getThisView()->assign('category',		$category);

			/**/
			// Redirection to canonical URL
			$currentURL = JFactory::getURI()->toString(array('path', 'query', 'fragment'));
			$canonicalURL = JRoute::_('index.php?option=com_ats&view=tickets&category='.$category_id);
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
	 * Get the privileges for the current ticket
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

		$ticket = $this->getThisModel()->getItem();

		// If I am the onwer of this ticket, I can see it and post to it
		if($ticket->created_by == JFactory::getUser()->id) {
			$ret['view'] = true;
			$ret['post'] = true;
			$ret['close'] = true;
			// If I can edit my own in this category, I can edit the ticket
			if(JFactory::getUser()->authorise('core.edit.own', 'com_ats.category.'.$ticket->catid)) {
				$ret['edit'] = true;
			}
			// If I can generally edit my own, I can edit the ticket
			if(JFactory::getUser()->authorise('core.edit.own', 'com_ats')) {
				$ret['edit'] = true;
			}
		}

		// If I am the manager of the category, I can do anything
		if(JFactory::getUser()->authorise('core.manage', 'com_ats.category.'.$ticket->catid)) {
			$ret = array(
				'view'		=> true,
				'post'		=> true,
				'edit'		=> true,
				'admin'		=> true,
				'close'		=> true,
				'attachment'=> true,
			);
		}

		// If I am the manager of the component, I can do anything
		if(
			JFactory::getUser()->authorise('core.manage', 'com_ats')
			|| JFactory::getUser()->authorise('core.manage', 'com_ats.category.' . $ticket->catid)
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

		// If it's a public ticket, I can view it
		if($ticket->public) {
			$ret['view'] = true;
		}

		// I am allowed attachments in this category
		if(JFactory::getUser()->authorise('ats.attachment', 'com_ats.category.'.$ticket->catid)) {
			$ret['attachment'] = true;
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

	public function ajax_set_status()
	{
		if($this->_csrfProtection() === false)
		{
			echo json_encode(array('msg' => 'error'));
			jexit();
		}

		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$id		  = $this->input->getInt('id');
		$status   = $this->input->getCmd('status');
		$standard = array('O', 'C', 'P');
		$custom   = AtsHelper::getCustomTicketStatuses();

        if(!$id)
        {
            echo json_encode(array('err' => JText::_('COM_ATS_TICKET_INVALID_ID')));
            return false;
        }

        $model = F0FModel::getTmpInstance('Tickets', 'AtsModel');
        $model->setId($id);

        $perms = $this->_getPrivileges();

		if(!$perms['admin'])
		{
			echo json_encode(array('err' => JText::_('COM_ATS_TICKET_PERMISSION_ERROR')));
			return false;
		}

		if(!in_array($status, $standard) && !isset($custom[$status]))
		{
			echo json_encode(array('err' => JText::_('COM_ATS_TICKET_INVALID_STATE')));
			return false;
		}

		if(!$model->setstatus($status))
		{
			$result = array('err' => $model->getError());
		}
		else
		{
			if(in_array($status, $standard))
			{
				if    ($status == 'O')  $class = 'label-important';
				elseif($status == 'C')  $class = 'label-success';
				elseif($status == 'P')	$class = 'label-warning';

				$deco  = JText::_('COM_ATS_TICKETS_STATUS_'.$status);
			}
			else
			{
				$class = 'label-warning';
				$deco  = $custom[$status];
			}

			$result = array('msg' => $deco, 'ats_class' => $class);
		}

		echo json_encode($result);
		jexit();
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
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=ticket&id='.$this->input->getInt('id',0).'&Itemid='.$this->input->getInt('Itemid',0);
		if(!$status)
		{
			$this->setRedirect($url, $model->getError(), 'error');
		}
		else
		{
			$this->setRedirect($url);
		}
		$this->redirect();
		return true;
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

        // Do I have any incoming rating from ticket closing?
        if($this->input->getInt('rating', 0))
        {
            $data['rating'] = $this->input->getInt('rating', 0);
        }

		$status = $model->getItem()->save($data);

		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=ticket&id='.$this->input->getInt('id',0).'&Itemid='.$this->input->getInt('Itemid',0);
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

		$status = $model->getItem()->save($data);

		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=ticket&id='.$this->input->getInt('id',0).'&Itemid='.$this->input->getInt('Itemid',0);
		if($status == false) {
			$this->setRedirect($url, $model->getError(), 'error');
		} else {
			$this->setRedirect($url);
		}
	}

	public function move()
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
		$data['catid'] = $this->input->getInt('catid', 0);
		$status = $model->getItem()->save($data);

		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=ticket&id='.$this->input->getInt('id',0).'&Itemid='.$this->input->getInt('Itemid',0);
		if($status == false) {
			$this->setRedirect($url, $model->getError(), 'error');
		} else {
			$this->setRedirect($url);
		}
	}

	public function assign()
	{
        JLoader::import('joomla.plugin.helper');
        JPluginHelper::importPlugin('ats');

		// CSRF prevention
		if($this->csrfProtection)
        {
			$this->_csrfProtection();
		}

		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$perms = $this->_getPrivileges();
		if(!$perms['admin']) {
			return false;
			jexit();
		}

		$assigned_to = $this->input->getInt('assigned_to', 0);
		$data = $model->getItem()->getData();
		$data['assigned_to'] = $assigned_to;

		if($assigned_to)
		{
			$return['assigned'] = JFactory::getUser($assigned_to)->name;
		}
		else
		{
			$return['assigned'] = JText::_('COM_ATS_TICKETS_UNASSIGNED');
		}

		$return['result'] = $model->getItem()->save($data);
        JFactory::getApplication()->triggerEvent('onATSassign', array($model->getItem()));

		if($customURL = $this->input->getString('returnurl',''))
		{
			$url = base64_decode($customURL);
			if($return['result'] == false) {
				$this->setRedirect($url, $model->getError(), 'error');
			} else {
				$this->setRedirect($url);
			}
			return;
		}

		echo json_encode($return);
		jexit();
	}

	/**
	 * Refunds the credits charged for a ticket
	 */
	public function creditsrefund()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$status = false;

		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$ticket = $model->getItem();
		if($ticket->ats_ticket_id) {
			if(
				!JFactory::getUser()->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
				!JFactory::getUser()->authorise('core.manage','com_ats')
			) {
				return false;
			}

			if(!class_exists('AtsHelperCredits')) {
				require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';
			}
			AtsHelperCredits::refundCredits($ticket->catid, $ticket->ats_ticket_id, 0, 'ticket');
			$status = true;
		}

		// redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option='.$this->component.'&view='.F0FInflector::singularize($this->view).'&id='.$ticket->ats_ticket_id;
		if(!$status)
		{
			$this->setRedirect($url, JText::_('COM_ATS_TICKETS_CREDITS_REFUND_ERROR'), 'error');
		}
		else
		{
			$this->setRedirect($url, JText::_('COM_ATS_TICKETS_CREDITS_REFUND_SUCCESS'));
		}
		$this->redirect();
	}

	/**
	 * Charges again some credits for a ticket
	 */
	public function creditscharge()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$status = false;

		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$ticket = $model->getItem();
		if($ticket->ats_ticket_id) {
			if(
				!JFactory::getUser()->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
				!JFactory::getUser()->authorise('core.manage','com_ats')
			) {
				return false;
			}

			if(!class_exists('AtsHelperCredits')) {
				require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/credits.php';
			}
			AtsHelperCredits::chargeCredits($ticket->created_by, $ticket->catid, $ticket->ats_ticket_id, 0, true, $ticket->public);
			$status = true;
		}

		// redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option='.$this->component.'&view='.F0FInflector::singularize($this->view).'&id='.$ticket->ats_ticket_id;
		if(!$status)
		{
			$this->setRedirect($url, JText::_('COM_ATS_TICKETS_CREDITS_CHARGE_ERROR'), 'error');
		}
		else
		{
			$this->setRedirect($url, JText::_('COM_ATS_TICKETS_CREDITS_CHARGE_SUCCESS'));
		}
		$this->redirect();
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


}