<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelBuckets extends F0FModel
{
	private function getFilterValues()
	{
		return (object)array(
			'title'			=> $this->getState('title',null,'string'),
			'username'		=> $this->getState('username',null,'string'),
			'user_id'		=> $this->getState('user_id',null,'int'),
			'created_since'	=> $this->getState('created_since',null,'string'),
			'created_until'	=> $this->getState('created_until',null,'string'),
			'modified_since'=> $this->getState('modified_since',null,'string'),
			'modified_until'=> $this->getState('modified_until',null,'string'),

			'search'		=> $this->getState('search',null,'string'),
			'enabled'		=> $this->getState('enabled','','cmd'),
			'status'		=> $this->getState('status',null,'raw'),

			'frontendfilter'=> $this->getState('frontendfilter',null,'cmd'),

			'groupbydate'	=> $this->getState('groupbydate',null,'int'),
		);
	}

	protected function _buildQueryJoins($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1) return;

		$query->join('LEFT OUTER', $db->qn('#__users').' AS '.$db->qn('u').' ON '.
					$db->qn('u').'.'.$db->qn('id').' = '.
					$db->qn('tbl').'.'.$db->qn('created_by'))
		;
	}

	protected function _buildQueryColumns($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1) {
			$query->select(array(
				'DATE('.$db->qn('created_on').') AS '.$db->qn('date'),
				'COUNT('.$db->qn('ats_bucket_id').') AS '.$db->qn('buckets')
			));
		} else {
			$query->select(array(
				$db->qn('tbl').'.*',
				$db->qn('u').'.'.$db->qn('username').' AS '.$db->qn('user_username'),
				$db->qn('u').'.'.$db->qn('name').' AS '.$db->qn('user_name'),
				$db->qn('u').'.'.$db->qn('email').' AS '.$db->qn('user_email'),
			));

			$order = $this->getState('filter_order', 'ats_bucket_id', 'cmd');
			if(!in_array($order, array_keys($this->getTable()->getData()))) $order = 'ats_bucket_id';
			$dir = strtoupper($this->getState('filter_order_Dir', 'DESC', 'cmd'));
			if(!in_array($dir,array('ASC','DESC'))) $dir = 'ASC';
			$query->order($order.' '.$dir);
		}
	}

	protected function _buildQueryGroup($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		if($state->groupbydate == 1) {
			$query->group(array(
				'DATE('.$db->qn('tbl').'.'.$db->qn('created_on').')'
			));
		}
	}

	protected function _buildQueryWhere($query)
	{
		$db = $this->getDbo();
		$state = $this->getFilterValues();

		JLoader::import('joomla.utilities.date');

		if(!$state->groupbydate) {
			// Search for title
			if($state->title) {
				$title = "%{$state->title}%";
				$query->where(
					$db->qn('tbl').'.'.$db->qn('title').' LIKE '.$db->q($title)
				);
			}

			// Search for username
			if($state->username) {
				$username = "%{$state->username}%";
				$query->where(
					$db->qn('u').'.'.$db->qn('username').' LIKE '.$db->q($username)
				);
			}

			// Search for title
			if($state->search) {
				$search = "%{$state->search}%";
				$query->where(
					$db->qn('tbl').'.'.$db->qn('title').' LIKE '.$db->q($search)
				);
			}


			// Filter by user ID
			if($state->user_id > 0) {
				$query->where(
					$db->qn('tbl').'.'.$db->qn('created_by').' = '.$db->q($state->user_id)
				);
			}
		}

		// Filter by enabled status
		if(is_numeric($state->enabled)) {
			$query->where(
				$db->qn('tbl').'.'.$db->qn('enabled').' = '.
					$db->q($state->enabled)
			);
		}

		// Filter by status (open, closed, pending)
		if($state->status) {
			$states_temp = explode(',', $state->status);
			$states = array();
			foreach($states_temp as $s) {
				$s = strtoupper($s);
				if(!in_array($s, array('O','P','C'))) continue;
				$states[] = $db->q($s);
			}
			if(!empty($states)) {
				$query->where(
					$db->qn('tbl').'.'.$db->qn('status').' IN ('.
						implode(',',$states).')'
				);
			}
		}



		// "Created Since" queries
		$since = trim($state->created_since);
		if(empty($since) || ($since == '0000-00-00') || ($since == '0000-00-00 00:00:00')) {
			$since = '';
		} else {
			$jFrom = new JDate($since);
			$since = $jFrom->toUnix();
			if($since == 0) {
				$since = '';
			} else {
				$since = $jFrom->toSql();
			}
			// Filter from-to dates
			$query->where(
				$db->qn('tbl').'.'.$db->qn('created_on').' >= '.
					$db->q($since)
			);
		}

		// "Created Until" queries
		$until = trim($state->created_until);
		if(empty($until) || ($until == '0000-00-00') || ($until == '0000-00-00 00:00:00')) {
			$until = '';
		} else {
			$jFrom = new JDate($until);
			$until = $jFrom->toUnix();
			if($until == 0) {
				$until = '';
			} else {
				$until = $jFrom->toSql();
			}
			$query->where(
				$db->qn('tbl').'.'.$db->qn('created_on').' <= '.
					$db->q($until)
			);
		}

		// "Modified Since" queries
		$since = trim($state->modified_since);
		if(empty($since) || ($since == '0000-00-00') || ($since == '0000-00-00 00:00:00')) {
			$since = '';
		} else {
			$jFrom = new JDate($since);
			$since = $jFrom->toUnix();
			if($since == 0) {
				$since = '';
			} else {
				$since = $jFrom->toSql();
			}
			// Filter from-to dates
			$query->where(
				$db->qn('tbl').'.'.$db->qn('modified_on').' >= '.
					$db->q($since)
			);
		}

		// "Modified Until" queries
		$until = trim($state->modified_until);
		if(empty($until) || ($until == '0000-00-00') || ($until == '0000-00-00 00:00:00')) {
			$until = '';
		} else {
			$jFrom = new JDate($until);
			$until = $jFrom->toUnix();
			if($until == 0) {
				$until = '';
			} else {
				$until = $jFrom->toSql();
			}
			$query->where(
				$db->qn('tbl').'.'.$db->qn('modified_on').' <= '.
					$db->q($until)
			);
		}
	}

	public function buildQuery($overrideLimits = false) {
		$db = $this->getDbo();
		$query = $db->getQuery(true)
				->from($db->qn('#__ats_buckets').' AS '.$db->qn('tbl'));

		$this->_buildQueryColumns($query);
		$this->_buildQueryJoins($query);
		$this->_buildQueryWhere($query);
		$this->_buildQueryGroup($query);

		return $query;
	}

	public function visible($publish = 1, $user = null)
	{
		if(is_array($this->id_list) && !empty($this->id_list)) {
			if(empty($user)) {
				$oUser = JFactory::getUser();
				$user = $oUser->id;
			}
			$table = $this->getTable($this->table);

			if(!$this->onBeforeVisible($table)) return false;

			if(!$table->visible($this->id_list, $publish, $user) ) {
				$this->setError($table->getError());
				return false;
			} else {
				$this->onAfterVisible($table);

				// Call the plugin events
				$dispatcher = JDispatcher::getInstance();
				JPluginHelper::importPlugin('content');
				$name = $this->input->getCmd('view','cpanel');
				$context = $this->option.'.'.$name.'.visibility';
				$result = $dispatcher->trigger($this->event_change_state, array($context, $this->id_list, $publish));
			}
		}
		return true;
	}

	public function setstatus($status = 'C', $user = null)
	{
		if(is_array($this->id_list) && !empty($this->id_list)) {
			if(empty($user)) {
				$oUser = JFactory::getUser();
				$user = $oUser->id;
			}
			$table = $this->getTable($this->table);

			if(!$table->setstatus($this->id_list, $status, $user) ) {
				$this->setError($table->getError());
				return false;
			}
		}
		return true;
	}
}