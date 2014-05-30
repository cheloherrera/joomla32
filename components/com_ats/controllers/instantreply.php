<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerInstantreply extends F0FController
{
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->cacheableTasks = array();
	}

	public function execute($task) {
		return parent::execute($task);
	}

	public function onBeforeBrowse()
	{
		// Init
		$docimportCategories = array();

		// Get category information
		$category_id = $this->input->getInt('catid',0);
		$categories = F0FModel::getTmpInstance('Categories','AtsModel')
			->category($category_id)
			->getList();
		if(!empty($categories)) {
			$category = array_pop($categories);
		} else {
			return false;
		}
		$params = new JRegistry();
		if(version_compare(JVERSION, '3.0', 'ge')) {
			$params->loadString($category->params, 'JSON');
		} else {
			$params->loadJSON($category->params);
		}

		$docimportCategories = $params->get('dicats',array());

		$this->getThisModel()->setState('dicats', $docimportCategories);

		return true;
	}
}
