<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

// I have to normalize the entire array, since some ticket could have a custom field set and
// others another ;(

$keys   = array();
$merged = array();

foreach($this->items as $item)
{
	$keys   = get_object_vars($item);
	$merged = $merged + array_keys($keys);
}

if ($this->csvHeader)
{
	foreach ($merged as $column)
	{
		$csv[] = '"' . str_replace('"', '""', $column) . '"';
	}

	echo implode(",", $csv) . "\r\n";
}

foreach ($this->items as $item)
{
	$csv = array();
	foreach ($merged as $column)
	{
		if (isset($item->$column))
		{
			$csv[] = '"' . str_replace('"', '""', $item->$column) . '"';
		}
		else
		{
			$csv[] = '""';
		}
	}

	echo implode(",", $csv) . "\r\n";
}