<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerJuser extends F0FController
{
	public function execute($task)
	{
		$task = 'browse';
		parent::execute($task);
	}

	protected function onBeforeBrowse() {
		$user = JFactory::getUser();
		return $user->authorise('core.manage','com_ats');
	}
}