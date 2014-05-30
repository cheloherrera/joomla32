<?php
/**
 *  @package ats
 *  @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

/**
 * The updates provisioning Model
 */
class AtsModelUpdates extends F0FUtilsUpdate
{
	/**
	 * Public constructor. Initialises the protected members as well.
	 *
	 * @param array $config
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$isPro = defined('ATS_PRO') ? ATS_PRO : 0;

		JLoader::import('joomla.application.component.helper');
		$params = JComponentHelper::getParams('com_ats');
		$dlid = $params->get('downloadid', '');
		$this->extraQuery = null;

		// If I have a valid Download ID I will need to use a non-blank extra_query in Joomla! 3.2+
		if (preg_match('/^([0-9]{1,}:)?[0-9a-f]{32}$/i', $dlid))
		{
			// Even if the user entered a Download ID in the Core version. Let's switch his update channel to Professional
			$isPro = true;

			$this->extraQuery = 'dlid=' . $dlid;
		}

		$this->updateSiteName = 'Akeeba Ticket System ' . ($isPro ? 'Professional' : 'Core');
		$this->updateSite = 'http://cdn.akeebabackup.com/updates/ats' . ($isPro ? '' : 'core') . '.xml';
	}
}