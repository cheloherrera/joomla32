<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsViewTickets extends F0FViewCsv
{
	public function __construct($config = array())
	{
		$config['csv_fields'] = array(
			'ats_ticket_id',
			'catid',
			'status',
			'title',
			'alias',
			'public',
			'origin',
			'timespent',
			"created_on",
			"created_by",
			"enabled","category_title",
			"user_username",
			"user_name",
			"user_email"
		);
		parent::__construct($config);
	}
}