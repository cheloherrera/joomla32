<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerLatest extends F0FController
{
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->modelName = 'AtsModelTickets';
		$this->cacheableTasks = array();
	}

	public function execute($task) {
		if(!in_array($task,array('browse'))) {
			$task = 'browse';
		}
		$this->input->setVar('task', $task);
		return parent::execute($task);
	}

	protected function onBeforeBrowse()
	{
		$result = parent::onBeforeBrowse();

		if($result)
		{
			if(JFactory::getUser()->guest) {
				// Not a logged in user, redirect to login page
				$returl = base64_encode(JFactory::getURI()->toString());
				$url = JRoute::_('index.php?option=com_users&view=login&return='.$returl);
				JFactory::getApplication()->redirect($url, JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'));
			}

			// Get all published categories
			$allCategoriesRaw = F0FModel::getTmpInstance('Categories','AtsModel')
				->getList();
			if (empty($allCategoriesRaw))
			{
				// No view access to any category? Go away!
				return false;
			}

			$allCategories = array();
			foreach ($allCategoriesRaw as $category)
			{
				$allCategories[] = $category->id;
			}

			// Initialise the filtered categories array
			$categories = array();

			// If I'm not a global administrator, find the categories I am an administrator of
			$user = JFactory::getUser();
			if (!$user->authorise('core.admin', 'com_ats') && !$user->authorise('core.manage', 'com_ats'))
			{
				foreach ($categories as $category)
				{
					if ($user->authorise('core.manage', 'com_ats.category.' . $category))
					{
						$categories[] = $category;
					}
				}
			}
			else
			{
				$categories = $allCategories;
			}

			// If there are no categories to which I am an administrator, return false
			if (empty($categories))
			{
				return false;
			}

			// Convince the model to sort on date, descending and filter on my tickets
			$db = JFactory::getDbo();

			$this->getThisModel()
				->enabled(1)
				->public('')
				->category(0)
				->categories($categories)
				->status('O')
				->filterNewest(1)
				->filter_order_Dir('ASC')
				;

			// If no tickets are shown even though I do have tickets, use a limitstart of 0
			if($this->getThisModel()->getTotal() && !count($this->getThisModel()->getItemList()) ) {
				$this->getThisModel()->limitstart(0);
			}

			// Fetch page parameters
			$params = JFactory::getApplication()->getPageParameters('com_ats');

			// Push page parameters
			$this->getThisView()->assign('pageparams', $params);
		}

		return $result;
	}
}