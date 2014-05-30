<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsControllerAttachments extends F0FController
{
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->cacheableTasks = array();
	}

	public function execute($task) {
		if(!in_array($task,array('read','publish','unpublish','remove'))) {
			$task = 'read';
		}
		parent::execute($task);
	}

	protected function onBeforePublish() {
		return parent::onBeforePublish();
	}

	protected function onBeforeUnpublish() {
		return parent::onBeforeUnpublish();
	}

	protected function onBeforeRemove() {
		return parent::onBeforeRemove();
	}

	public function read() {
		// Load the model
		$model = $this->getThisModel();
		if(!$model->getId()) $model->setIDsFromRequest();

		// Does the attachment exist?
		if($model->getItem()->ats_attachment_id != $model->getId()) {
			JError::raiseError(404, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
		}

		$model->doDownload();
	}
}