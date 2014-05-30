<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerAssignedtickets extends F0FController
{
	public function __construct($config = array())
    {
		parent::__construct($config);
		$this->modelName = 'AtsModelTickets';
		$this->cacheableTasks = array();
	}

	public function execute($task)
    {
		if(!in_array($task,array('browse')))
        {
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
			if(JFactory::getUser()->guest)
            {
				// Not a logged in user, redirect to login page
				$returl = base64_encode(JFactory::getURI()->toString());
				$url = JRoute::_('index.php?option=com_users&view=login&return='.$returl);
				JFactory::getApplication()->redirect($url, JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'));
			}

			// Convince the model to sort on date, descending and filter on my tickets
			$db = JFactory::getDbo();

			$this->getThisModel()
				->assignedtome(1)
				->enabled(1)
				->category(0)
				->limit(20)
				->status('O,C,P,1,2,3,4,5,6,7,8,9')
				->filterNewest(1)
				->filter_order_Dir('DESC');

			// If no tickets are shown even though I do have tickets, use a limitstart of 0
			if($this->getThisModel()->getTotal() && !count($this->getThisModel()->getItemList()) )
            {
				$this->getThisModel()->limitstart(0);
			}

			// Fetch page parameters
			$params = JFactory::getApplication()->getPageParameters('com_ats');

			// Push page parameters
			$this->getThisView()->assign('pageparams',		$params);
		}
		return $result;
	}
}