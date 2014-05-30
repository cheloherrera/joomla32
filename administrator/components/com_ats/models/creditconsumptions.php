<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelCreditconsumptions extends F0FModel
{
	public function buildQuery($overrideLimits = false) {
		$db = $this->getDbo();

		$query = parent::buildQuery($overrideLimits);

		$sum = $this->getState('sum', null, 'int');
		if($sum) {
			$query
				->clear('select')
				->select(array(
					$db->qn('ats_credittransaction_id'),
					'SUM('.$db->qn('value').') AS '.$db->qn('consumed')
				))
				->group($db->qn('ats_credittransaction_id'));
		}

		$tids = $this->getState('transaction_ids', array(), 'array');
		if(count($tids)) {
			$temp = array();
			foreach($tids as $i) {
				$temp[] = $db->q((int)$i);
			}
			$temp = array_unique($temp);

			$query->where($db->qn('ats_credittransaction_id').' IN('.implode(',', $tids).')');
		}

		return $query;
	}
}