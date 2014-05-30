<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerCustomfield extends F0FController
{
	protected function onBeforeSaveorder()
	{
		$this->getThisModel()->preventCatCheck = true;

		return parent::onBeforeSaveorder();
	}

	protected function onAfterSaveorder()
	{
		$this->getThisModel()->preventCatCheck = false;

		return true;
	}
}