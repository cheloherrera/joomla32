<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerTickets extends F0FController
{
	public function __construct($config = array())
    {
		parent::__construct($config);

		$this->cacheableTasks = array();
        $this->registerTask('showspared', 'browse');
	}

	/**
	 * Makes a ticket public
	 */
	public function public_publish()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$this->setpublic(1);
	}

	/**
	 * Makes a ticket private
	 */
	public function public_unpublish()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$this->setpublic(0);
	}

	/**
	 * Reopens a ticket
	 */
	public function status_publish()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$this->setstatus('O');
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

		if(!in_array($status, $standard) && !isset($custom[$status]))
		{
			echo json_encode(array('err' => JText::_('COM_ATS_TICKET_INVALID_STATE')));
			return false;
		}

		$model = F0FModel::getTmpInstance('Tickets', 'AtsModel');
		$model->setId($id);

		if(!$model->setstatus($status))
		{
			$result = array('err' => $model->getError());
		}
		else
		{
			if(in_array($status, $standard))
			{
				$class = 'ats-ticket-status-'.$status;
				$deco  = JText::_('COM_ATS_TICKETS_STATUS_'.$status);
			}
			else
			{
				$class = 'ats-ticket-status-P';
				$deco  = $custom[$status];
			}

			$result = array('msg' => $deco, 'ats_class' => $class);
		}

		echo json_encode($result);
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
	 * Closes a ticket
	 */
	public function status_unpublish()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$this->setstatus('C');
	}

	/**
	 * Sets the visibility status of a ticket
	 *
	 * @param int $state 0 = private, 1 = public
	 */
	protected final function setpublic($state = 0)
	{
		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$status = $model->visible($state);

		// redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option='.$this->component.'&view='.F0FInflector::pluralize($this->view);
		if(!$status)
		{
			$this->setRedirect($url, $model->getError(), 'error');
		}
		else
		{
			$this->setRedirect($url);
		}
		$this->redirect();
	}

	/**
	 * Sets the status of a ticket
	 *
	 * @param string $state 'C' to close a ticket, 'O' to open it
	 */
	protected final function setstatus($state = 'C')
	{
		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$status = $model->setstatus($state);

		// redirect
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option='.$this->component.'&view='.F0FInflector::pluralize($this->view);
		if(!$status)
		{
			$this->setRedirect($url, $model->getError(), 'error');
		}
		else
		{
			$this->setRedirect($url);
		}
		$this->redirect();
	}

	public function onBeforeAdd()
	{
		$view    	 = $this->getThisView();
		$view->cache = array();

		return parent::onBeforeAdd();
	}

	/**
	 * Overrides standard onBeforeEdit checks: we check if
	 * we have saved data incoming from the session (previous failed validation)
	 *
	 * @return bool
	 */
	public function onBeforeEdit()
	{
		// Standard ACL check
		if(!$this->checkACL('core.edit'))
		{
			return false;
		}

		$session = JFactory::getSession();
		$view    = $this->getThisView();

		// @TODO Load everything inside the $cache variable, in the same way we do in Akeeba Subs
		$cache['custom'] = $session->get('custom', array(), 'com_ats.newticket');
		$view->assign('cache',				$cache);

		return true;
	}

	public function assign()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}

		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		$data = $model->getItem()->getData();
		if(!JFactory::getUser()->authorise('core.edit','com_ats.category.'.$data['catid'])) {
			return false;
			jexit();
		}

		$assigned_to = $this->input->getInt('assigned_to', 0);
		$data['assigned_to'] = $assigned_to;
		$model->getItem()->save($data);

		if($assigned_to)
		{
			$return['assigned'] = JFactory::getUser($assigned_to)->name;
		}
		else
		{
			$return['assigned'] = JText::_('COM_ATS_TICKETS_UNASSIGNED');
		}
		$return['result'] = $model->getItem()->save($data);

		echo json_encode($return);
		jexit();
	}

	public function browse($cachable = false) {
		// When groupbydate is set to 1 we force a JSON view which returns the
		// stats grouped by date. You can use the since/until or other filter in
		// the URL to filter the whole lot
		if($this->input->getInt('groupbydate',0) == 1) {
			if(JFactory::getUser()->guest) {
				return false;
			} else {
				$list = $this->getThisModel()
					->savestate(0)
					->limit(0)
					->limitstart(0)
					->savestate(0)
					->getItemList();
				header('Content-type: application/json');
				echo json_encode($list);
				JFactory::getApplication()->close();
			}
		}

		// Limit what a front-end user can do
		if(JFactory::getApplication()->isSite()) {
			if(JFactory::getUser()->guest) {
				return false;
			}
		}

		// If it's the back-end CSV view, force no limits
		if(JFactory::getApplication()->isAdmin() && ($this->input->getCmd('format','html') == 'csv')) {
			$this->getThisModel()
				->savestate(0)
				->limit(0)
				->limitstart(0);
		}

		return parent::browse($cachable);
	}
}
