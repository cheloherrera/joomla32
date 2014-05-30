<?php

/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */
// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsDispatcher extends F0FDispatcher
{

	public function __construct($config = array())
	{
		$this->defaultView = 'categories';

		parent::__construct($config);
	}

	public function onBeforeDispatch()
	{
		// You can't fix stupid… but you can try working around it
		if ((!function_exists('json_encode')) || (!function_exists('json_decode')))
		{
			require_once JPATH_ADMINISTRATOR . '/components/' . $this->component . '/helpers/jsonlib.php';
		}

		$result = parent::onBeforeDispatch();

		if ($result)
		{
			// Automatically set ATS on-line or off-line
			include_once JPATH_ADMINISTRATOR . '/components/com_ats/helpers/autooffline.php';
			if (class_exists('AtsHelperAutooffline', false))
			{
				AtsHelperAutooffline::processAutoOffline();
			}

			// Merge the language overrides
			$paths	 = array(JPATH_ADMINISTRATOR, JPATH_ROOT);
			$jlang	 = JFactory::getLanguage();
			$jlang->load($this->component, $paths[0], 'en-GB', true);
			$jlang->load($this->component, $paths[0], null, true);
			$jlang->load($this->component, $paths[1], 'en-GB', true);
			$jlang->load($this->component, $paths[1], null, true);

			$jlang->load($this->component . '.override', $paths[0], 'en-GB', true);
			$jlang->load($this->component . '.override', $paths[0], null, true);
			$jlang->load($this->component . '.override', $paths[1], 'en-GB', true);
			$jlang->load($this->component . '.override', $paths[1], null, true);

			// Load Akeeba Strapper only if I didn't load it already (ie nested calls with F0FDispatecher)
			if ($this->input->getBool('bootstrap', true))
			{
				include_once JPATH_ROOT . '/media/akeeba_strapper/strapper.php';
				AkeebaStrapper::bootstrap();
			}
		}

		return $result;
	}

	public function onAfterDispatch()
	{
		$result = parent::onAfterDispatch();
		if ($result)
		{
			if (class_exists('AtsHelperBreadcrumbs'))
			{
				AtsHelperBreadcrumbs::buildCrumbs();
			}
		}
		return $result;
	}

}