<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die();

class AtsTableJuser extends F0FTable
{
	function __construct( $table, $key, &$db )
	{
		$table = '#__users';
		$key = 'id';
		parent::__construct($table, $key, $db);
	}
}