<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerCredittransactions extends F0FController
{
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->cacheableTasks = array();
	}

	public function execute($task) {
		// Only allow back-end and administrator access
		list($isCli, $isAdmin) = F0FDispatcher::isCliAdmin();
		if(!$isAdmin) {
			$user = JFactory::getUser();
			if(
				!$user->authorise('core.admin','com_ats')
				&& !$user->authorise('core.manage','com_ats')
			){
				return false;
			}
		}

		parent::execute($task);
	}
}