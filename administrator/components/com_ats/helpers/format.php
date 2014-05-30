<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die();

class AtsHelperFormat
{
	public static function date($date, $format = null, $local = false)
	{
		JLoader::import('joomla.utilities.date');
		$jDate = new JDate($date, 'GMT');

		if(empty($format)) {
			$format = 'Y-m-d H:i';
		}

		if($local) {
			$tz = new DateTimeZone(JFactory::getUser()->getParam('timezone','UTC'));
			$jDate->setTimezone($tz);
		}
		return $jDate->format($format, $local);
	}

	public static function date2($date, $format = null, $local = false)
	{
		JLoader::import('joomla.utilities.date');
		$jDate = new JDate($date, 'GMT');

		if(empty($format)) {
			$format = JText::_('DATE_FORMAT_LC2').' T';
		}

		if($local) {
			$tz = new DateTimeZone(JFactory::getUser()->getParam('timezone','UTC'));
			$jDate->setTimezone($tz);
		}
		return $jDate->format($format, $local, true);
	}

	/**
	 * Converts a fancy shothand size notation (e.g. 8M) to bytes
	 *
	 * @param type $fancy
	 * @return type
	 */
	public static function toBytes($fancy)
	{
		if(empty($fancy)) return 0;

		$value = (float)$fancy;
		$fancy = trim($fancy);
		$units = array(
			'K'	=> 1024, 'M' => 1048576, 'G' => 1073741824
		);
		$u = substr($fancy, -1);
		if($u === false) return (int)$value;
		if(!array_key_exists($u, $units)) return (int)$value;

		return (int)($value * $units[$u]);
	}

	/**
	 * Convert bytes to human readable format
	 *
	 * @see http://codeaid.net/php/convert-size-in-bytes-to-a-human-readable-format-(php)
	 * @param int $bytes
	 * @param int $precision
	 * @return type
	 */
	public static function bytesToSize($bytes, $precision = 2)
	{
		$kilobyte = 1024;
		$megabyte = $kilobyte * 1024;
		$gigabyte = $megabyte * 1024;
		$terabyte = $gigabyte * 1024;

		if (($bytes >= 0) && ($bytes < $kilobyte)) {
			return $bytes . ' B';

		} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
			return round($bytes / $kilobyte, $precision) . ' KB';

		} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
			return round($bytes / $megabyte, $precision) . ' MB';

		} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
			return round($bytes / $gigabyte, $precision) . ' GB';

		} elseif ($bytes >= $terabyte) {
			return round($bytes / $terabyte, $precision) . ' TB';
		} else {
			return $bytes . ' B';
		}
	}

	public static function categoryName($id)
	{
		static $categories = null;

		if (is_null($categories))
		{
			if(!class_exists('CategoriesModelCategories')) {
				require_once JPATH_ADMINISTRATOR.'/components/com_categories/models/categories.php';
			}

			$model = new CategoriesModelCategories();
			$model->getState()->set('list.select', 'a.id, a.title, a.level');
			$model->getState()->set('filter.extension',	'com_ats');
			$model->getState()->set('filter.access',		null);
			$model->getState()->set('filter.published',	1);
			$items = $model->getItems();

			$categories = array();

			if (!empty($items))
			{
				foreach ($items as $item)
				{
					$categories[$item->id] = $item->title;
				}
			}
		}

		if (array_key_exists($id, $categories))
		{
			return $categories[$id];
		}
		else
		{
			return '';
		}
	}
}