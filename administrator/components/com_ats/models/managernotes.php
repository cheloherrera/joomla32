<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelManagernotes extends F0FModel
{
	private function getFilterValues()
	{
		return (object)array(
			'ticket'		=> $this->getState('ticket','','int'),
			'search'		=> $this->getState('search',null,'string'),
			'enabled'		=> $this->getState('enabled','','cmd'),
			'user_id'		=> $this->getState('user_id','','int'),
		);
	}

	public function buildCountQuery() {
		$db = $this->getDbo();
		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from($db->qn('#__ats_managernotes').' AS '.$db->qn('tbl'));
		;

		$this->_buildQueryWhere($query);

		return $query;
	}

	public function buildQuery($overrideLimits = false) {
		$db = $this->getDbo();
		$query = $db->getQuery(true)
				->from($db->qn('#__ats_managernotes').' AS '.$db->qn('tbl'));

		$this->_buildQueryColumns($query);
		$this->_buildQueryWhere($query);

		if(!$overrideLimits) {
			$order = $this->getState('filter_order',null,'cmd');
			if(!array_key_exists($order, array_keys($this->getTable()->getData()))) $order = $this->getTable()->getKeyName();
			$dir = $this->getState('filter_order_Dir', 'ASC', 'cmd');
			$query->order($db->qn($order).' '.$dir);
		}

		return $query;
	}

	protected function _buildQueryColumns($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		$query->select(array(
			$db->qn('tbl').'.'.'*',
		));
	}

	protected function _buildQueryWhere($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		JLoader::import('joomla.utilities.date');

		// Filter by ticket ID
		if($state->ticket > 0) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('ats_ticket_id').' = '.$db->q($state->ticket)
			);
		}

		// Search inside the rendered HTML contents
		if($state->search) {
			$query->where(
				'MATCH ('.$db->q('note').') AGAINST ('.$db->q($state->search).')'
			);
		}

		// Filter by enabled status
		if(is_numeric($state->enabled)) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('enabled').' = '.
					$db->q($state->enabled)
			);
		}

		// Filter by user ID (who created the row)
		if($state->user_id > 0) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('created_by').' = '.
					$db->q($state->user_id)
			);
		} elseif(is_array($state->user_id)) {
			$ids = array();
			foreach($state->user_id as $id) if( (int)$id > 0 ) $ids[] = (int)$id;
			if(!emtpy($ids)) {
				$filter = implode(',',$ids);
				$query->where(
					$db->qn('tbl').'.'.$db->qn('created_by').' IN ('.$ids.')'
				);
			}
		}
	}
}