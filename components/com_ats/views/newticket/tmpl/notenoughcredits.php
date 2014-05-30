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
<div class="akeeba-bootstrap">

<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-newticket-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo JText::sprintf('COM_ATS_NEWTICKET_TITLE', $this->escape($this->category->title)); ?>
	</h1>
<?php endif; ?>

<p id="ats-notenoughcredits-default-message">
	<?php echo JText::_('COM_ATS_NEWTICKET_MSG_NOTENOUGHCREDITS'); ?>
</p>

<?php echo AtsHelperModules::loadposition('ats-notenoughcredits'); ?>

<?php echo AtsHelperModules::loadposition('ats-newticket-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>

</div>