<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerCannedreplies extends F0FController
{
	protected function onBeforeBrowse() {
		$result = parent::onBeforeBrowse();
		if($result && JFactory::getApplication()->isSite() ) {
			$user = JFactory::getUser();
			$allowed = $user->authorise('core.manage','com_ats');
			$category = $this->input->getInt('category', 0);
			if ($category)
			{
				$allowed = $allowed || $user->authorise('core.manage','com_ats.category.' . $category);
			}
			if(!$allowed) {
				return false;
			}
		}
		return $result;
	}

	protected function onBeforeAdd() {
		$result = parent::onBeforeAdd();
		if($result && JFactory::getApplication()->isSite()) {
			$result = false;
		}
		return $result;
	}

	protected function onBeforeSave() {
		$result = parent::onBeforeSave();
		if($result && JFactory::getApplication()->isSite()) {
			$result = false;
		}
		return $result;
	}

	protected function onBeforeEdit() {
		$result = parent::onBeforeEdit();
		if($result && JFactory::getApplication()->isSite()) {
			$result = false;
		}
		return $result;
	}

	protected function onBeforeRead() {
		$result = parent::onBeforeBrowse();
		if($result && JFactory::getApplication()->isSite() ) {
			$user = JFactory::getUser();
			$allowed = $user->authorise('core.manage','com_ats');
			$category = $this->input->getInt('category', 0);
			if ($category)
			{
				$allowed = $allowed || $user->authorise('core.manage','com_ats.category.' . $category);
			}
			if(!$allowed) {
				return false;
			}
		}
		return $result;
	}
}