<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelCredittransactions extends F0FModel
{
	public function buildQuery($overrideLimits = false) {
		// Get the filters
		$filters = (object)array(
			'search'			=> $this->getState('search', null, 'string'),
			'ats_credittransaction_id' => $this->getState('ats_credittransaction_id', null, 'int'),
			'user_id'			=> $this->getState('user_id', null, 'int'),
			'transaction_date'	=> $this->getState('transaction_date', null, 'string'),
			'type'				=> $this->getState('type', null, 'string'),
			'unique_id'			=> $this->getState('unique_id', null, 'string'),
			'value'				=> $this->getState('value', null, 'int'),
			'enabled'				=> $this->getState('enabled', '', 'cmd'),
		);

		// Get base query
		$db = $this->getDbo();
		$query = $db->getQuery(true)
			->select(array(
				$db->qn('t').'.*',
				$db->qn('u').'.'.$db->qn('name'),
				$db->qn('u').'.'.$db->qn('username'),
				$db->qn('u').'.'.$db->qn('email'),
			))
			->from($db->qn('#__ats_credittransactions').' AS '.$db->qn('t'))
			->join('LEFT OUTER',$db->qn('#__users').' AS '.$db->qn('u').' ON('.
					$db->qn('u').'.'.$db->qn('id').' = '.
					$db->qn('t').'.'.$db->qn('user_id').')'
			)
		;

		// Filter: user information
		if(!empty($filters->search)) {
			$query->where('CONCAT(IF(u.name IS NULL,"",u.name),IF(u.username IS NULL,"",u.username),IF(u.email IS NULL, "", u.email)) LIKE '.
				$db->q($filters->search));
		}

		// Filter: transaction ID
		if(!empty($filters->ats_credittransaction_id)) {
			$query->where($db->qn('t').'.'.$db->qn('ats_credittransaction_id').' = '.$db->q($filters->ats_credittransaction_id));
		}

		// Filter: user ID
		if(!empty($filters->user_id)) {
			$query->where($db->qn('t').'.'.$db->qn('user_id').' = '.$db->q($filters->user_id));
		}

		// Filter: transaction date
		if(!empty($filters->transaction_date)) {
			$query->where($db->qn('t').'.'.$db->qn('transaction_date').' >= '.$db->q($filters->transaction_date));
		}

		// Filter: type
		if(!empty($filters->type)) {
			$query->where($db->qn('t').'.'.$db->qn('type').' LIKE '.$db->q('%'.$filters->type.'%'));
		}

		// Filter: unique ID
		if(!empty($filters->unique_id)) {
			$query->where($db->qn('t').'.'.$db->qn('unique_id').' LIKE '.$db->q('%'.$filters->unique_id.'%'));
		}

		// Filter: value (credits)
		if(!empty($filters->value)) {
			$query->where($db->qn('t').'.'.$db->qn('value').' = '.$db->q($filters->value));
		}

		// Filter: enabled
		if(is_numeric($filters->enabled)) {
			$query->where($db->qn('t').'.'.$db->qn('enabled').' = '.$db->q($filters->enabled));
		}

		$order = $this->getState('filter_order', 'ats_credittransaction_id', 'cmd');
		if(!in_array($order, array_keys($this->getTable()->getData()))) $order = 'ats_credittransaction_id';
		$dir = $this->getState('filter_order_Dir', 'DESC', 'cmd');
		$query->order($order.' '.$dir);

		return $query;
	}
}