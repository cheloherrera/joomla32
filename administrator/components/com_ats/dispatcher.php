<?php

/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 * @revision 7b140cb9ee5bbab084535ae5bbab09f7fc78af226f7c
 */
// Protect from unauthorized access
defined('_JEXEC') or die();

class AtsDispatcher extends F0FDispatcher
{

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

			if (!JFactory::getUser()->authorise('core.manage', 'com_ats'))
			{
				JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
				return false;
			}
			// Language loading
			$paths	 = array(JPATH_ROOT, JPATH_ADMINISTRATOR);
			$jlang	 = JFactory::getLanguage();
			// -- Component
			$jlang->load($this->component, $paths[0], 'en-GB', true);
			$jlang->load($this->component, $paths[0], null, true);
			$jlang->load($this->component, $paths[1], 'en-GB', true);
			$jlang->load($this->component, $paths[1], null, true);
			// -- Component overrides
			$jlang->load($this->component . '.override', $paths[0], 'en-GB', true);
			$jlang->load($this->component . '.override', $paths[0], null, true);
			$jlang->load($this->component . '.override', $paths[1], 'en-GB', true);
			$jlang->load($this->component . '.override', $paths[1], null, true);

			// Load Akeeba Strapper
			include_once JPATH_ROOT . '/media/akeeba_strapper/strapper.php';
			AkeebaStrapper::bootstrap();
			AkeebaStrapper::addCSSfile('media://com_ats/css/backend.css');

			$view = F0FInflector::singularize($this->input->getCmd('view',$this->defaultView));

			if ($view == 'liveupdate')
			{
				$url = JUri::base() . 'index.php?option=com_ats';
				JFactory::getApplication()->redirect($url);
				return;
			}
		}

		return $result;
	}

}