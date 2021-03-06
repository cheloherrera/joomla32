<?php
/**
 * @package   AdminTools
 * @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die;

class AdmintoolsTableIpbl extends F0FTable
{
	public function __construct($table, $key, &$db)
	{
		parent::__construct('#__admintools_ipblock', 'id', $db);
	}

	public function check()
	{
		if (!$this->ip)
		{
			$this->setError(JText::_('ATOOLS_ERR_IPBL_NEEDS_IP'));

			return false;
		}

		return true;
	}
}
