<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die;

class AtsHelperAutooffline
{
	/**
	 * A cached copy of the component's parameters
	 *
	 * @var JRegistry
	 */
	private static $component_params = null;

	/**
	 * Processes the automatic off-line schedule definitions and brings the
	 * ticket system on-line / off-line based on your schedule. If no definition
	 * matches the ticket system is brought on-line. If no definition is set
	 * then the off-line status remains in its current, manual state.
	 *
	 * @return void
	 */
	public static function processAutoOffline()
	{
		// Get off line schedule definitions
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
			->select('*')
			->from($db->qn('#__ats_offlineschedules'))
			->where($db->qn('enabled') . ' = ' . $db->q(1))
			->order($db->qn('ordering') . ' ASC');
		$db->setQuery($query);
		$definitions = $db->loadObjectList();

		// Quit if there are no definitions
		if (empty($definitions))
		{
			return;
		}

		// Default state is no tickets = off and no replies = off
		$nonewtickets = false;
		$noreplies = false;

		// Get the current time, weekday, day, month and year
		JLoader::import('joomla.utilities.date');
		$jDate = new JDate();

		$hour		= $jDate->format('H');
		$minute		= $jDate->format('i');
		$second		= $jDate->format('s');
		$weekday	= $jDate->format('w');
		$day		= $jDate->format('d');
		$month		= $jDate->format('m');
		$year		= $jDate->format('Y');

		$jNow = new JDate($hour . ':' . $minute . ':' . $second);

		// Loop through all definitions
		foreach ($definitions as $def)
		{
			// Break down the definition date stuff into arrays
			$weekdays	= explode(',', $def->weekdays);
			$days		= explode(',', $def->days);
			$months		= explode(',', $def->months);
			$years		= explode(',', $def->years);

			// Check if we are on the correct weekday
			if (!empty($weekdays) && !in_array('*', $weekdays))
			{
				if (!in_array($weekday, $weekdays))
				{
					continue;
				}
			}

			// Check if we are on the correct weekday
			if (!empty($days) && !in_array('0', $days) && !in_array('*', $days))
			{
				if (!in_array($day, $days))
				{
					continue;
				}
			}

			// Check if we are on the correct weekday
			if (!empty($months) && !in_array('*', $months) && !in_array('0', $months))
			{
				if (!in_array($month, $months))
				{
					continue;
				}
			}

			// Check if we are on the correct weekday
			if (!empty($years) && !in_array('*', $years) && !in_array('0', $years))
			{
				if (!in_array($years, $year))
				{
					continue;
				}
			}

			// Check the time
			$jStart = new JDate($def->timestart);
			$jEnd = new JDate($def->timeend);

			if (($jStart->toUnix() <= $jNow->toUnix()) && ($jEnd->toUnix() >= $jNow->toUnix()))
			{
				if ($def->notickets)
				{
					$nonewtickets = true;
				}
				if ($def->noreplies)
				{
					$noreplies = true;
				}
			}

			// If both no tickets and no replies are set to true break the loop
			if ($nonewtickets && $noreplies)
			{
				break;
			}
		}

		// Get the existing values of no tickets and no replies.
		$params = self::getComponentParams();
		$oldNoNewTickets = $params->get('nonewtickets', 0);
		$oldNoReplies = $params->get('noreplies', 0);

		// If they differ, set them in the component configuration and save it.
		if (($oldNoNewTickets != $nonewtickets) || ($oldNoReplies != $noreplies))
		{
			$params->set('nonewtickets', $nonewtickets ? 1 : 0);
			$params->set('noreplies', $noreplies ? 1 : 0);
			self::saveComponentParams();
			self::$component_params = null;
		}
	}

	/**
	 * Returns a JRegistry object with the component parameters, without using
	 * JComponentHelper.
	 *
	 * @return \JRegistry The component parameters
	 */
	private static function &getComponentParams()
	{
		if(!is_object(self::$component_params))
		{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true)
				->select('params')
				->from($db->qn('#__extensions'))
				->where($db->qn('element').'='.$db->q('com_ats'))
				->where($db->qn('type').'='.$db->q('component'));
			$db->setQuery($query);
			$rawparams = $db->loadResult();
			self::$component_params = new JRegistry();
			self::$component_params->loadString($rawparams, 'JSON');
		}

		return self::$component_params;
	}

	/**
	 * Saves the component parameter directly to the database.
	 *
	 * @return void
	 */
	private static function saveComponentParams()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true)
			->update($db->qn('#__extensions'))
			->set($db->qn('params') . ' = ' . $db->q(self::$component_params->toString('JSON')))
			->where($db->qn('element').'='.$db->q('com_ats'))
			->where($db->qn('type').'='.$db->q('component'));
		$db->setQuery($query);
		$db->execute();
	}
}