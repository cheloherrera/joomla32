<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die;

// Include the component versioning
include_once JPATH_COMPONENT_ADMINISTRATOR.'/version.php';

if(!defined('ATS_VERSION'))
{
	define('ATS_VERSION','git');
	define('ATS_DATE', date('Y-m-d'));
	define('ATS_PRO', 0);
}

define('ATS_VERSIONHASH', md5(ATS_VERSION.ATS_DATE));

// Include F0F
if(!defined('F0F_INCLUDED')) {
	require_once JPATH_LIBRARIES.'/f0f/include.php';
}
if(!defined('F0F_INCLUDED') || !class_exists('F0FForm', true)) {?>
<h1>Akeeba Ticket System</h1>
<h2>Incomplete installation detected</h2>
<p>
	Please consult the documentation
</p>
<?php return; }

if(!version_compare(JVERSION, '2.5', 'ge')):?>
<h1>Akeeba Ticket System</h1>
<h2>Incompatible Joomla! Release</h2>
<p>You need Joomla! 2.5 or later to run this component</p>
<?php return; endif;

// PHP version check
if(defined('PHP_VERSION')) {
	$version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
	$version = phpversion();
} else {
	// No version info. I'll lie and hope for the best.
	$version = '5.0.0';
}
// Old PHP version detected. EJECT! EJECT! EJECT!
if(!version_compare($version, '5.3.0', '>=')):?>
<h1>Akeeba Ticket System</h1>
<h2>Incompatible PHP Version</h2>
<p>You need PHP 5.3.0 or later to run this component</p>
<?php return; endif;

require_once JPATH_COMPONENT.'/helpers/breadcrumbs.php';

// Dispatch
F0FDispatcher::getAnInstance('com_ats')->dispatch();