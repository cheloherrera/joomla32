<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

// Load template helpers
$this->loadHelper('modules');
$this->loadHelper('format');

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);

?>
<p id="ats-post-notenoughcredits-default-message">
	<?php echo JText::_('COM_ATS_POST_MSG_NOTENOUGHCREDITS'); ?>
</p>
<?php echo AtsHelperModules::loadposition('ats-post-notenoughcredits'); ?>