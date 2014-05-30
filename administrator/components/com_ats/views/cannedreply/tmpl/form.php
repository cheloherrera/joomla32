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

$this->loadHelper('editor');
?>

<div class="ats-ticket-replyarea">
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" class="form form-horizontal">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="cannedreply" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_cannedreply_id" value="<?php echo $this->item->ats_cannedreply_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

	<div class="control-group">
		<label for="title_field" class="control-label">
				<?php echo  JText::_('COM_ATS_CANNEDREPLIES_FIELD_TITLE'); ?>
		</label>
		<div class="controls">
			<input type="text" size="90" id="title_field" name="title" class="title" value="<?php echo  $this->escape($this->item->title) ?>" />
		</div>
	</div>

	<div class="ats-ticket-replyarea-content bbcode">
		<?php echo AtsHelperEditor::showEditorBBcode('reply', 'bbcodecr', $this->item->reply, '100%', '400', 80, 20, array('class'=>'input-xxlarge')) ?>
	</div>
	<div class="ats-clear"></div>
</form>
</div>