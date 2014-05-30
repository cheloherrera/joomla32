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
	Akeeba Ticket System can not load because an incomplete installation was
	detected. In order to fix this problem, please follow these steps:
</p>
<ol>
	<li>
		Download Akeeba Ticket System' installation ZIP package from our
		Downloads page.
	</li>
	<li>
		Go to <a href="<?php echo JURI::base() ?>index.php?option=com_installer">Extensions &gt;
		<?php echo version_compare(JVERSION, '1.6.0', 'ge') ? "Install/Uninstall" : "Manage"; ?>
		</a>, click on &quot;Browse...&quot;, find the ZIP file you downloaded and double click on it.
	</li>
	<li>
		Click on &quot;Upload &amp; Install&quot;
	</li>
</ol>
<p>
	This will install all of the missing files while preserving your existing
	settings and subscriptions.
</p>
<p>
	<strong>IMPORTANT!</strong> Do not uninstall the component before following
	the procedure above. When you uninstall the component, all of your existing
	settings and all of the subscriptions will be <em>removed</em>.
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
<h2>Incompatible PHP version</h2>
<p>You need PHP 5.3.0 or later to run this component</p>
<?php return; endif;

// Load version.php
JLoader::import('joomla.filesystem.file');
$version_php = JPATH_COMPONENT_ADMINISTRATOR.DIRECTORY_SEPARATOR.'version.php';
if(!defined('ATS_VERSION') && JFile::exists($version_php)) {
	require_once $version_php;
}

// Dispatch
F0FDispatcher::getAnInstance('com_ats')->dispatch();