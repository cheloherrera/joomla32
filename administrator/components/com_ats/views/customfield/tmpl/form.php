<?php
/**
 *  @package Ats
 *  @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die();

$this->loadHelper('select');

?>

<div class="row-fluid">
<div class="span12">

<form action="index.php" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="customfields" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="ats_customfield_id" value="<?php echo $this->item->ats_customfield_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

	<div class="well">
		<div class="control-group">
			<label class="control-label" for="title"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_TITLE') ?></label>
			<div class="controls">
				<input
					placeholder="<?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_TITLE') ?>"
					type="text" name="title" id="title" value="<?php echo $this->item->title ?>" />
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_TITLE') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="slug"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_SLUG') ?></label>
			<div class="controls">
				<input
					placeholder="<?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_SLUG') ?>"
					type="text" name="slug" id="slug" value="<?php echo $this->item->slug ?>" />
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_SLUG') ?></p>
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
			<label class="control-label" for="show"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_SHOW') ?></label>
			<div class="controls">
				<?php echo AtsHelperSelect::fieldshow('show', $this->item->show) ?>
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_SHOW') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="ats_level_id"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_CATEGORY') ?></label>
			<div class="controls">
				<?php echo AtsHelperSelect::getCategories($this->item->cats, 'catid[]', array('size' => '7', 'multiple' => 'true')) ?>
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_CATEGORY') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="type"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_TYPE') ?></label>
			<div class="controls">
				<?php echo AtsHelperSelect::fieldtypes('type', $this->item->type) ?>
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_TYPE') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="options"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_OPTIONS') ?></label>
			<div class="controls">
				<textarea name="options" id="options" cols="50" rows="7" class="input-xxlarge"><?php echo $this->item->options ?></textarea>
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_OPTIONS') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="default"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_DEFAULT') ?></label>
			<div class="controls">
				<input
					placeholder="<?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_DEFAULT') ?>"
					type="text" name="default" id="default" value="<?php echo $this->item->default ?>" />
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_DEFAULT') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="allow_empty"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_ALLOW_EMPTY') ?></label>
			<div class="controls">
				<?php echo JHTML::_('select.booleanlist', 'allow_empty', null, $this->item->allow_empty); ?>
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_ALLOW_EMPTY') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="valid_label"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_VALID_LABEL') ?></label>
			<div class="controls">
				<input
					placeholder="<?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_VALID_LABEL') ?>"
					type="text" name="valid_label" id="valid_label" value="<?php echo $this->item->valid_label ?>" />
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_VALID_LABEL') ?></p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="invalid_label"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_INVALID_LABEL') ?></label>
			<div class="controls">
				<input
					placeholder="<?php echo JText::_('COM_ATS_CUSTOMFIELDS_FIELD_INVALID_LABEL') ?>"
					type="text" name="invalid_label" id="invalid_label" value="<?php echo $this->item->invalid_label ?>" />
				<p class="help-block"><?php echo JText::_('COM_ATS_CUSTOMFIELDS_HELP_INVALID_LABEL') ?></p>
			</div>
		</div>
	</div>
</form>

</div>
</div>