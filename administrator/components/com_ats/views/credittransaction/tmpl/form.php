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

JHTML::_('behavior.tooltip');
if(version_compare(JVERSION, '3.0', 'ge')) {
	JHTML::_('behavior.framework');
} else {
	JHTML::_('behavior.mootools');
}
JHTML::_('behavior.modal');

?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" class="form form-horizontal">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="credittransaction" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_credittransaction_id" value="<?php echo $this->item->ats_credittransaction_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

	<div class="control-group">
		<label for="user_id" class="control-label">
				<?php echo  JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_USER_ID_LBL'); ?>
		</label>
		<div class="controls">
				<input type="hidden" name="user_id" id="userid" value="<?php echo $this->item->user_id?>" />
				<input type="text" class="input-medium" name="xxx_userid" id="userid_visible" value="<?php echo $this->item->user_id ? JFactory::getUser($this->item->user_id)->username : '' ?>" disabled="disabled" />
				<button onclick="return false;" class="btn btn-mini modal"><?php echo JText::_('COM_ATS_COMMON_SELECTUSER')?></button>
				<a class="modal" style="display: none" id="userselect" href="index.php?option=com_users&amp;view=users&amp;layout=modal&amp;tmpl=component&amp;field=userid" rel="{handler: 'iframe', size: {x: 800, y: 500}}">Select</a>
		</div>
	</div>
	<div class="control-group">
		<label for="transaction_date" class="control-label">
				<?php echo  JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_TRANSACTION_DATE_LBL'); ?>
		</label>
		<div class="controls">
			<?php echo JHTML::_('calendar', $this->item->transaction_date, 'transaction_date', 'transaction_date'); ?>
		</div>
	</div>
	<div class="control-group">
		<label for="type" class="control-label">
				<?php echo  JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_TYPE_LBL'); ?>
		</label>
		<div class="controls">
			<input type="text" class="input-large" name="type" value="<?php echo $this->item->type?>"
				   placeholder="<?php echo JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_TYPE_LBL') ?>" />
		</div>
	</div>
	<div class="control-group">
		<label for="unique_id" class="control-label">
				<?php echo  JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_UNIQUE_ID_LBL'); ?>
		</label>
		<div class="controls">
			<input type="text" class="input-large" name="unique_id" value="<?php echo $this->item->unique_id?>"
				   placeholder="<?php echo JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_UNIQUE_ID_LBL') ?>" />
		</div>
	</div>
	<div class="control-group">
		<label for="value" class="control-label">
				<?php echo  JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_VALUE_LBL'); ?>
		</label>
		<div class="controls">
			<input type="text" class="input-small" name="value" value="<?php echo $this->item->value?>"
				   placeholder="<?php echo JText::_('COM_ATS_CREDITTRANSACTIONS_FIELD_VALUE_LBL') ?>" />
		</div>
	</div>
</form>

<script type="text/javascript">
function jSelectUser_userid(id, username)
{
	document.getElementById('userid').value = id;
	document.getElementById('userid_visible').value = username;
	try {
		document.getElementById('sbox-window').close();
	} catch(err) {
		SqueezeBox.close();
	}
}

window.addEvent("domready", function() {
	$$("button.modal").each(function(el) {
		el.addEvent("click", function(e) {
			try {
				new Event(e).stop();
			} catch(anotherMTUpgradeIssue) {
				try {
					e.stop();
				} catch(WhateverIsWrongWithYouIDontCare) {
					try {
						DOMEvent(e).stop();
					} catch(NoBleepinWay) {
						alert('If you see this message, your copy of Joomla! is FUBAR');
					}
				}
			}
			SqueezeBox.fromElement(document.getElementById('userselect'), {
				parse: 'rel'
			});
		});
	});
});
</script>