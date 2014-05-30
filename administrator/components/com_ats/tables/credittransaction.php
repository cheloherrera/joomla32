<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTableCredittransaction extends F0FTable
{
	public function check()
    {
		if(!intval($this->transaction_date))
        {
			JLoader::import('joomla.utilities.date');
			$jNow = new JDate();
			$this->transaction_date = $jNow->toSql();
		}

		if(empty($this->type))
        {
			$this->type = 'ats';
		}

		if(empty($this->unique_id))
        {
			$this->unique_id = $this->user_id.'_';

			if(function_exists('sha1'))
            {
				$this->unique_id .= sha1(microtime(true));
			}
            elseif(function_exists('md5'))
            {
				$this->unique_id .= md5(microtime(true));
			}
            else
            {
				$this->unique_id .= microtime(true);
			}
		}

		$result = parent::check();

		return $result;
	}
}