<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

JLoader::import('joomla.plugin.plugin');

// Make sure ATS is installed, otherwise bail out
if(!file_exists(JPATH_ADMINISTRATOR.'/components/com_ats')) {
	return;
}

// PHP version check
if(defined('PHP_VERSION')) {
	$version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
	$version = phpversion();
} else {
	$version = '5.0.0'; // all bets are off!
}
if(!version_compare($version, '5.3.0', '>=')) return;

// Joomla! version check
if(version_compare(JVERSION, '2.5', 'lt') && version_compare(JVERSION, '1.6.0', 'ge')) {
	// Joomla! 1.6.x and 1.7.x: sorry fellas, no go.
	return;
}

// Timezone fix; avoids errors printed out by PHP 5.3.3+ (thanks Yannick!)
if(function_exists('date_default_timezone_get') && function_exists('date_default_timezone_set')) {
	if(function_exists('error_reporting')) {
		$oldLevel = error_reporting(0);
	}
	$serverTimezone = @date_default_timezone_get();
	if(empty($serverTimezone) || !is_string($serverTimezone)) $serverTimezone = 'UTC';
	if(function_exists('error_reporting')) {
		error_reporting($oldLevel);
	}
	@date_default_timezone_set( $serverTimezone);
}

// Include F0F's loader if required
if(!defined('F0F_INCLUDED')) {
	$libraries_dir = defined('JPATH_LIBRARIES') ? JPATH_LIBRARIES : JPATH_ROOT.'/libraries';
	$mainFile = $libraries_dir.'/f0f/include.php';
	if(file_exists($mainFile)) {
		@include_once $mainFile;
	}
}

// If F0F is not present (e.g. not installed) bail out
if(!defined('F0F_INCLUDED') || !class_exists('F0FLess', true)) {
	return;
}

// Is ATS enabled?
JLoader::import('joomla.application.component.helper');
if(!JComponentHelper::isEnabled('com_ats', true)) {
	return;
}

/**
 * ATS Search plugin
 */
class plgSystemAtsreplybyemail extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onAfterInitialise()
	{
		$config = array('input' => array());
		$model = F0FModel::getTmpInstance('Emailcheck','AtsModel',$config);

		if(!$model->shouldCheckForEmail()) return;

		try {
			$model->checkEmail();
		} catch (Exception $exc) {
			JLog::add($exc->getMessage(), JLog::ERROR);
		}
	}
}