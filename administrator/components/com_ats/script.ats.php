<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// no direct access
defined('_JEXEC') or die();

// Load FOF if not already loaded
if (!defined('F0F_INCLUDED'))
{
	$paths = array(
		(defined('JPATH_LIBRARIES') ? JPATH_LIBRARIES : JPATH_ROOT . '/libraries') . '/f0f/include.php',
		__DIR__ . '/fof/include.php',
	);

	foreach ($paths as $filePath)
	{
		if (!defined('F0F_INCLUDED') && file_exists($filePath))
		{
			@include_once $filePath;
		}
	}
}

// Pre-load the installer script class from our own copy of FOF
if (!class_exists('F0FUtilsInstallscript', false))
{
	@include_once __DIR__ . '/fof/utils/installscript/installscript.php';
}

// Pre-load the database schema installer class from our own copy of FOF
if (!class_exists('F0FDatabaseInstaller', false))
{
	@include_once __DIR__ . '/fof/database/installer.php';
}

// Pre-load the update utility class from our own copy of FOF
if (!class_exists('F0FUtilsUpdate', false))
{
	@include_once __DIR__ . '/fof/utils/update/update.php';
}

class Com_AtsInstallerScript extends F0FUtilsInstallscript
{
	/**
	 * The component's name
	 *
	 * @var   string
	 */
	protected $componentName = 'com_ats';

	/**
	 * The title of the component (printed on installation and uninstallation messages)
	 *
	 * @var string
	 */
	protected $componentTitle = 'Akeeba Ticket System';

	/**
	 * The list of extra modules and plugins to install on component installation / update and remove on component
	 * uninstallation.
	 *
	 * @var   array
	 */
	protected $installation_queue = array(		// modules => { (folder) => { (module) => { (position), (published) } }* }*
		'modules' => array(
			'admin' => array(
				//'foobar' => array('cpanel', 1)
			),
			'site' => array(
                'atscredits' => array('left', 0),
				//'foobar' => array('left', 0),
			)
		),
		// plugins => { (folder) => { (element) => (published) }* }*
		'plugins' => array(
			'ats' => array(
				'alphauserpoints'		=> 0,
				'customfields'			=> 1,
				'gravatar'				=> 1,
				'postemail'				=> 1,
				'sociallike'			=> 0,
			),
            'content' => array(
                'atscredits'            => 1,
            ),
			'finder' => array(
				'ats'					=> 1,
			),
			'installer' => array(
				'akeebaticketsystem'	=> 1,
			),
			'search' => array(
				'ats'					=> 1,
			),
            'sh404sefextplugins' => array(
                'com_ats'               => 1
            ),
			'system' => array(
				'atsreplybyemail'		=> 0,
			),
			'user' => array(
				'ats'					=> 1,
			),
		)
	);

	/**
	 * Obsolete files and folders to remove from both paid and free releases. This is used when you refactor code and
	 * some files inevitably become obsolete and need to be removed.
	 *
	 * @var   array
	 */
	protected $removeFilesAllVersions = array(
		'files'	=> array(
			'cache/com_ats.updates.php',
			'cache/com_ats.updates.ini',
			'administrator/cache/com_ats.updates.php',
			'administrator/cache/com_ats.updates.ini',

			// FOF 1.x files
			'libraries/fof/controller.php',
			'libraries/fof/dispatcher.php',
			'libraries/fof/inflector.php',
			'libraries/fof/input.php',
			'libraries/fof/model.php',
			'libraries/fof/query.abstract.php',
			'libraries/fof/query.element.php',
			'libraries/fof/query.mysql.php',
			'libraries/fof/query.mysqli.php',
			'libraries/fof/query.sqlazure.php',
			'libraries/fof/query.sqlsrv.php',
			'libraries/fof/render.abstract.php',
			'libraries/fof/render.joomla.php',
			'libraries/fof/render.joomla3.php',
			'libraries/fof/render.strapper.php',
			'libraries/fof/string.utils.php',
			'libraries/fof/table.php',
			'libraries/fof/template.utils.php',
			'libraries/fof/toolbar.php',
			'libraries/fof/view.csv.php',
			'libraries/fof/view.html.php',
			'libraries/fof/view.json.php',
			'libraries/fof/view.php',

			// Old component files, no longer used
			'administrator/components/com_ats/views/cannedreplies/default.php',
			'administrator/components/com_ats/views/credittransactions/default.php',
			'administrator/components/com_ats/views/customfields/default.php',
			'administrator/components/com_ats/views/emailtemplates/default.php',
		),
		'folders' => array(
		)
	);

	/**
	 * A list of scripts to be copied to the "cli" directory of the site
	 *
	 * @var   array
	 */
	protected $cliScriptFiles = array(
		'ats-auto-reply.php',
		'ats-autoclose-tickets.php',
		'ats-mail-fetch.php',
		'ats-remove-attachments.php',
	);

	/**
	 * Renders the post-installation message
	 */
	protected function renderPostInstallation($status, $fofInstallationStatus, $strapperInstallationStatus, $parent)
	{
?>

<h1>Akeeba Ticket System</h1>

<div style="margin: 1em; font-size: 14pt; background-color: #fffff9; color: black">
	You can download translation files <a href="http://cdn.akeebabackup.com/language/ats/index.html">directly from our CDN page</a>.
</div>
<img src="../media/com_ats/images/ats-48.png" width="48" height="48" alt="Akeeba Ticket System" align="left" />
<h2 style="font-size: 14pt; font-weight: black; padding: 0; margin: 0 0 0.5em;">&nbsp;Welcome to Akeeba Ticket System!</h2>
<span>
	The simplest and easiest ticket system for Joomla!&trade;
</span>

<?php
		parent::renderPostInstallation($status, $fofInstallationStatus, $strapperInstallationStatus, $parent);
	}

	protected function renderPostUninstallation($status, $parent)
	{
?>
<h2 style="font-size: 14pt; font-weight: black; padding: 0; margin: 0 0 0.5em;">&nbsp;Akeeba Ticket System Uninstallation</h2>
<p>We are sorry that you decided to uninstall Akeeba Ticket System. Please let us know why by using the Contact Us form on our site. We appreciate your feedback; it helps us develop better software!</p>

<?php
		parent::renderPostUninstallation($status, $parent);
	}

}