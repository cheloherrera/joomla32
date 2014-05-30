<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTableManagernote extends F0FTable
{
	public function check()
	{
		$ret = true;

		// Process the content
		require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/bbcode.php';
		$content = htmlentities($this->note, ENT_NOQUOTES, 'UTF-8', false);
		$content = str_replace('<', '&lt;', $content);
		$content = str_replace('>', '&gt;', $content);
		if(!empty($content)) {
			$this->note_html = AtsHelperBbcode::parseBBCode($content);
		}

		return $ret;
	}
}