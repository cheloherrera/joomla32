<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerBuckets extends F0FController
{
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->cacheableTasks = array();
		$this->registerTask('choosebucket', 'browse');
		$this->registerTask('blank', 'browse');
	}

	/**
	 * Reopens a bucket
	 */
	public function status_publish()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			if($this->_csrfProtection() === false) return false;
		}

		$this->setstatus('O');
	}

	/**
	 * Closes a bucket
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
	 * Sets the status of a bucket
	 *
	 * @param string $state 'C' to close a bucket, 'O' to open it
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

	public function addtickets()
	{
		$tickets = $this->input->get('ats_ticket_id', array(), 'array');
		$bucket  = $this->input->get('cid', array(), 'array');

		if($bucket)
		{
			$bucket = array_shift($bucket);
		}

		if(!$bucket)
		{
			$url  = 'index.php?option=com_ats&view=buckets&tmpl=component&task=choosebucket&layout=choose&ats_ticket_id[]=';
			$url .= implode('&ats_ticket_id[]=', $tickets);
			$this->setRedirect($url, JText::_('COM_ATS_BUCKETS_CHOOSE_ONE'), 'notice');
			$this->redirect();
		}

		if(!$tickets)
		{
			$msg  = JText::_('COM_ATS_BUCKETS_NO_TICKET_SELECTED');
			$type = 'notice';
		}
		else
		{
			$result = F0FModel::getTmpInstance('Tickets', 'AtsModel')
						->addTicketsToBucket($tickets, $bucket);

			if($result)
			{
				$msg  = JText::_('COM_ATS_BUCKETS_TICKETS_ADDED');
				$type = 'message';
			}
			else
			{
				$msg  = JText::_('COM_ATS_BUCKETS_TICKETS_NOT_ADDED');
				$type = 'error';
			}

		}

		$this->setRedirect('index.php?option=com_ats&view=buckets&task=blank&tmpl=component&layout=close', $msg, $type);
	}
}
