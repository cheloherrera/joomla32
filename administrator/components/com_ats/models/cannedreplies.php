<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelCannedreplies extends F0FModel
{
	private function getFilterValues()
	{
		return (object)array(
			'title'			=> $this->getState('title',null,'string'),

			'search'		=> $this->getState('search',null,'string'),
			'enabled'		=> $this->getState('enabled','','cmd'),
		);
	}

	protected function _buildQueryColumns($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		$query->select(array(
			'*'
		));

		$order = $this->getState('filter_order', 'ordering', 'cmd');
		if(!in_array($order, array_keys($this->getTable()->getData()))) $order = 'ordering';
		$dir = strtoupper($this->getState('filter_order_Dir', 'ASC', 'cmd'));
		if(!in_array($dir,array('ASC','DESC'))) $dir = 'ASC';
		$query->order($order.' '.$dir);
	}

	protected function _buildQueryWhere($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		JLoader::import('joomla.utilities.date');

		// Search for title
		if($state->title) {
			$title = "%{$state->title}%";
			$query->where(
				$db->qn('title').' LIKE '.$db->q($title)
			);
		}

		// Search for content
		if($state->search) {
			$search = "%{$state->search}%";
			$query->where(
				$db->qn('reply').' LIKE '.$db->q($search)
			);
		}

		// Filter by enabled status
		if(is_numeric($state->enabled)) {
			$query->where(
					$db->qn('enabled').' = '.$db->q($state->enabled)
			);
		}
	}

	public function buildQuery($overrideLimits = false) {
		$db = $this->getDbo();
		$query = $db->getQuery(true)
				->from($db->qn('#__ats_cannedreplies'));

		$this->_buildQueryColumns($query);
		$this->_buildQueryWhere($query);

		return $query;
	}
}