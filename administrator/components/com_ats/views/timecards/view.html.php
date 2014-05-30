<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsViewTimecards extends F0FViewHtml
{
	protected function onBrowse($tpl = null)
	{
		return true;
	}

	protected function onRead($tpl = null)
	{
		return true;
	}
}
