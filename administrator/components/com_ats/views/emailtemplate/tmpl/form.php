<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/backend.css?'.ATS_VERSIONHASH);

$this->loadHelper('select');
$editor = JFactory::getEditor();
?>

<div class="ats-ticket-replyarea">
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="emailtemplate" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_emailtemplate_id" value="<?php echo $this->item->ats_emailtemplate_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

	<div class="control-group">
		<label for="key_field" class="control-label">
				<?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_KEY_LBL'); ?>
		</label>
		<div class="controls">
			<input type="text" size="90" id="key_field" name="key" class="title" value="<?php echo  $this->escape($this->item->key) ?>" />
			<span class="help-block"><?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_KEY_DESC') ?></span>
		</div>
	</div>

	<div class="control-group">
		<label for="subject_field" class="control-label">
				<?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_SUBJECT_LBL'); ?>
		</label>
		<div class="controls">
			<input type="text" class="input-xxlarge" id="subject_field" name="subject" value="<?php echo  $this->escape($this->item->subject) ?>" />
			<span class="help-block"><?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_SUBJECT_DESC') ?></span>
		</div>
	</div>

	<div class="control-group">
		<label for="enabled" class="control-label">
			<?php echo JText::_('JPUBLISHED'); ?>
		</label>
		<div class="controls">
			<?php echo JHTML::_('select.booleanlist', 'enabled', null, $this->item->enabled); ?>
		</div>
	</div>

	<div class="control-group">
		<label for="language" class="control-label">
				<?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_LANGUAGE_LBL'); ?>
		</label>
		<div class="controls">
			<?php echo AtsHelperSelect::languages($this->item->language, 'language') ?>
			<span class="help-block"><?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_LANGUAGE_DESC') ?></span>
		</div>
	</div>

	<div class="control-group">
		<label for="template" class="control-label">
				<?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_TEMPLATE_LBL'); ?>
		</label>
		<div class="controls">
			<?php echo $editor->display( 'template',  $this->item->template, '97%', '391', '50', '20', false ) ; ?>
			<span class="help-block"><?php echo JText::_('COM_ATS_EMAILTEMPLATES_FIELD_TEMPLATE_DESC') ?></span>
		</div>
	</div>

</form>
</div>