<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);

$this->loadHelper('editor');

if(!isset($returnURL)) {
	$returnURLtemp = $this->input->getString('returnurl',null);
	if(!empty($returnURLtemp)) $returnURL = $returnURLtemp;
}

?>

<div class="ats-ticket-replyarea">
<form action="index.php?option=com_ats&view=bucket&id=4" method="post" id="adminForm" enctype="multipart/form-data">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="bucketreply" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_bucket_id" value="<?php echo $ats_bucket_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	<?php if(isset($returnURL)): ?>
	<input type="hidden" name="returnurl" value="<?php echo $returnURL ?>" />
	<?php endif; ?>

	<div class="ats-ticket-replyarea-content bbcode">
		<?php
			if(AtsHelperEditor::isEditorBBcode()) {
				$name = 'content'; $id = 'bbcode';
			} else {
				$name = 'content_html'; $id = 'ats-content';
			}
			echo AtsHelperEditor::showEditor($name, $id, '', '95%', 400, 80, 20);
		?>
	</div>

	<div class="ats-ticket-replyarea-attachment">
		<p><?php echo JText::_('COM_ATS_POSTS_MSG_ADDATTACHMENT'); ?></p>
		<input type="file" name="attachedfile" size="10" />
	</div>
	<br />
	<div class="ats-ticket-replyarea-postbutton">
		<input class="btn btn-primary" type="submit" value="<?php echo JText::_('COM_ATS_POSTS_MSG_POST') ?>" />
	</div>
</form>
</div>