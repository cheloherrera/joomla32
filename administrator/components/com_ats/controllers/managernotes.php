<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerManagernotes extends F0FController
{
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->cacheableTasks = array();
	}

	protected function onBeforeBrowse() {
		$result = parent::onBeforeBrowse();

		$ticket_id = $this->input->getInt('ats_ticket_id', 0);
		if($result && JFactory::getApplication()->isSite() ) {
			$this->getThisModel()->ticket($ticket_id);
		}

		// Allow notes viewing only for managers
		$user = JFactory::getUser();
		$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
			->setId($ticket_id)
			->getItem();
		if(
			!$user->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
			!$user->authorise('core.manage','com_ats') &&
			!$user->authorise('core.admin','com_ats')
		){
			return false;
		}

		$this->input->set('catid', $ticket->catid);

		return $result;
	}

	protected function onBeforeAdd() {
		return false;
	}

	protected function onBeforeRead()
	{
		$result = true;

		$ticket_id = $this->input->getInt('ats_ticket_id', 0);

		// Allow notes viewing only for managers
		$user = JFactory::getUser();
		$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
			->setId($ticket_id)
			->getItem();
		if(
			!$user->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
			!$user->authorise('core.manage','com_ats') &&
			!$user->authorise('core.admin','com_ats')
		){
			return false;
		}

		return $result;
	}

	protected function onBeforeEdit() {
		$result = parent::onBeforeEdit();

		// Are we withing the editing time limit?
		$withinEditingTime = false;
		$item = $this->getThisModel()->getItem();
		if(($item->modified_by == JFactory::getUser()->id) || ($item->created_by == JFactory::getUser()->id)) {
			JLoader::import('joomla.utilities.date');
			if(($item->modified_by == JFactory::getUser()->id)) {
				$editedOn = new JDate($item->modified_on);
			} else {
				$editedOn = new JDate($item->created_on);
			}
			$now = new JDate();
			$editedAgo = abs($now->toUnix() - $editedOn->toUnix());

			JLoader::import('joomla.application.component.helper');
			$params = JComponentHelper::getParams('com_ats');
			$editeableforxminutes = $params->get('editeableforxminutes', 15);
			$withinEditingTime = $editedAgo < 60 * $editeableforxminutes;
		}

		return $result || $withinEditingTime;
	}

	/**
	 * Perform a complex ACL check
	 * @return boolean
	 */
	protected function onBeforeSave()
	{
		// Check if it's a new note
		$newPost = $this->getThisModel()->getItem()->ats_managernote_id <= 0;

		$user = JFactory::getUser();
		$note = $this->getThisModel()->getItem();
		// Check if it's a new ticket (not supported)
		if($newPost) {
			$ticket_id = $this->input->getInt('ats_ticket_id',0);
		} else {
			$ticket_id = $note->ats_ticket_id;
		}
		if($ticket_id <= 0) {
			return false;
		}

		$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
			->setId($ticket_id)
			->getItem();

		// Allow note posting/editing only for managers
		if(
			!$user->authorise('core.manage','com_ats.category.'.$ticket->catid) &&
			!$user->authorise('core.manage','com_ats') &&
			!$user->authorise('core.admin','com_ats')
		){
			return false;
		}

		// If we are still here, we are allowed to post

		// Get return URL
		if($customURL = $this->input->getString('returnurl','')) $customURL = base64_decode($customURL);
		$url = !empty($customURL) ? $customURL : 'index.php?option=com_ats&view=ticket&id='.$ticket_id.(JFactory::getApplication()->isSite() ? '&Itemid='.$this->input->getInt('Itemid',0) : '');

		$this->input->set('returnurl', base64_encode($url));
		return true;
	}

	public function browse($cachable = false) {

		// If it's the back-end CSV view, force no limits
		if(JFactory::getApplication()->isAdmin() && ($this->input->getCmd('format','html') == 'csv')) {
			$this->getThisModel()
				->savestate(0)
				->limit(0)
				->limitstart(0);
		}

		// Limit what a front-end user can do
		if(JFactory::getApplication()->isSite()) {
			if(JFactory::getUser()->guest) {
				$ticket = $this->getThisModel()->ticket;
				if(!$ticket) return false;
			}
		}

		return parent::browse($cachable);
	}

	protected function onBeforeRemove()
	{
		$item = $this->getThisModel()->getItem();
		$ticket_id = $item->ats_ticket_id;
		$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
			->setId($ticket_id)
			->getItem();
		$user = JFactory::getUser();
		return $this->checkACL('core.delete') || $this->checkACL('core.admin') || $this->checkACL('core.manage') || $user->authorise('core.manage','com_ats.category.'.$ticket->catid);
	}

	protected function onBeforePublish()
	{
		$item = $this->getThisModel()->getItem();
		$ticket_id = $item->ats_ticket_id;
		$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
			->setId($ticket_id)
			->getItem();
		$user = JFactory::getUser();

		return parent::onBeforePublish() || $this->checkACL('core.admin') || $this->checkACL('core.manage') || $user->authorise('core.manage','com_ats.category.'.$ticket->catid);
	}

	protected function onBeforeUnpublish()
	{
		$item = $this->getThisModel()->getItem();
		$ticket_id = $item->ats_ticket_id;
		$ticket = F0FModel::getTmpInstance('Ticket','AtsModel')
			->setId($ticket_id)
			->getItem();
		$user = JFactory::getUser();

		return parent::onBeforeUnpublish() || $this->checkACL('core.admin') || $this->checkACL('core.manage') || $user->authorise('core.manage','com_ats.category.'.$ticket->catid);
	}
}