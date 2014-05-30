<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTableOfflineschedule extends F0FTable
{
	public function check()
	{
		$ret = true;

		// weekdays, days, months, years

		if (is_array($this->weekdays))
		{
			$this->weekdays = implode(',', $this->weekdays);
		}

		if (is_array($this->days))
		{
			$this->days = implode(',', $this->days);
		}

		if (is_array($this->months))
		{
			$this->months = implode(',', $this->months);
		}

		if (is_array($this->years))
		{
			$this->years = implode(',', $this->years);
		}

		return $ret;
	}

	protected function onAfterLoad(&$result)
	{
		parent::onAfterLoad($result);

		if ($result)
		{
			$this->weekdays = explode(',', $this->weekdays);
			$this->days = explode(',', $this->days);
			$this->months = explode(',', $this->months);
			$this->years = explode(',', $this->years);
		}

		return $result;
	}
}