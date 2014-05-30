<?php
/**
 * @package   ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license   GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelCpanels extends F0FModel
{
	/**
	 * Checks the database for missing / outdated tables
	 *
	 * @return  AtsModelCpanels
	 */
	public function checkAndFixDatabase()
	{
		// Install or update database
		$dbInstaller = new F0FDatabaseInstaller(array(
			'dbinstaller_directory'	=> JPATH_ADMINISTRATOR . '/components/com_ats/sql/xml'
		));
		$dbInstaller->updateSchema();

		return $this;
	}

	/**
	 * Does the user needs to enter a Download ID?
	 *
	 * @return boolean
	 */
	public function needsDownloadID()
	{
		JLoader::import('joomla.application.component.helper');

		// Do I need a Download ID?
		$ret = false;
		$params = JComponentHelper::getParams('com_ats');
		if (version_compare(JVERSION, '3.0', 'ge'))
		{
			$dlid = $params->get('downloadid', '');
		}
		else
		{
			$dlid = $params->getValue('downloadid', '');
		}
		if (!preg_match('/^([0-9]{1,}:)?[0-9a-f]{32}$/i', $dlid))
		{
			$ret = true;
		}

		return $ret;
	}

	/**
	 * Checks if the download ID provisioning plugin for the updates of this extension is published. If not, it will try
	 * to publish it automatically. It reports the status of the plugin as a boolean.
	 *
	 * @return  bool
	 */
	public function isUpdatePluginEnabled()
	{
		// We can't be bothered about the plugin in Joomla! 2.5.0 through 2.5.19
		if (version_compare(JVERSION, '2.5.19', 'lt'))
		{
			return true;
		}

		// We can't be bothered about the plugin in Joomla! 3.x
		if (version_compare(JVERSION, '3.0.0', 'gt'))
		{
			return true;
		}

		$db = $this->getDBO();

		// Let's get the information of the update plugin
		$query = $db->getQuery(true)
			->select('*')
			->from($db->qn('#__extensions'))
			->where($db->qn('folder').' = '.$db->quote('installer'))
			->where($db->qn('element').' = '.$db->quote('akeebaticketsystem'))
			->where($db->qn('type').' = '.$db->quote('plugin'))
			->order($db->qn('ordering').' ASC');
		$db->setQuery($query);
		$plugin = $db->loadObject();

		// If the plugin is missing report it as unpublished (of course!)
		if (!is_object($plugin))
		{
			return false;
		}

		// If it's enabled there's nothing else to do
		if ($plugin->enabled)
		{
			return true;
		}

		// Otherwise, try to enable it and report false (so the user knows what he did wrong)
		$pluginObject = (object)array(
			'extension_id'	=> $plugin->extension_id,
			'enabled'		=> 1
		);

		try
		{
			$result = $db->updateObject('#__extensions', $pluginObject, 'extension_id');
			// Do not remove this line. We need to tell the user he's doing something wrong.
			$result = false;
		}
		catch (Exception $e)
		{
			$result = false;
		}

		return $result;
	}
}