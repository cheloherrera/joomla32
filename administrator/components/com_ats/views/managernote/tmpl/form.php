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

if(!isset($quickreply)) $quickreply = !($this->item instanceof AtsTableManagernote);

if(!isset($ats_ticket_id)) {
	$ats_ticket_id = 0;
	if($this->item instanceof AtsTableManagernote) $ats_ticket_id = $this->item->ats_ticket_id;
}

if(!isset($ats_managernote_id)) {
	$ats_managernote_id = 0;
	if($this->item instanceof AtsTableManagernote) $ats_managernote_id = $this->item->ats_managernote_id;
}

if(!isset($returnURL)) {
	$returnURLtemp = $this->input->getString('returnurl',null);
	if(!empty($returnURLtemp)) $returnURL = $returnURLtemp;
}

?>

<div class="ats-ticket-replyarea">

<form action="index.php" method="post" <?php echo $quickreply ? '' : 'name="adminForm2"' ?>>
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="managernote" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_ticket_id" value="<?php echo $ats_ticket_id ?>" />
	<input type="hidden" name="ats_managernote_id" value="<?php echo $ats_managernote_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	<?php if(isset($returnURL)): ?>
	<input type="hidden" name="returnurl" value="<?php echo $returnURL ?>" />
	<?php endif; ?>

	<div class="ats-ticket-replyarea-content bbcode">
		<?php
			$contents = '';
			if(AtsHelperEditor::isEditorBBcode()) {
				$name = 'note'; $id = 'bbcodemn';
			} else {
				$name = 'note_html'; $id = 'ats-note';
			}
			if(isset($this->item)) {
				if($this->item instanceof AtsTableManagernote) {
					if(AtsHelperEditor::isEditorBBcode()) {
						$contents = $this->item->note;
					} else {
						$contents = $this->item->note_html;
					}
				}
			}
			echo AtsHelperEditor::showEditor($name, $id, $contents, '95%', 400, 80, 20);
		?>
	</div>
	<div class="ats-clear"></div>

	<div class="ats-ticket-replyarea-postbutton">
		<input class="btn btn-primary" type="submit" value="<?php echo JText::_('COM_ATS_MANAGERNOTES_MSG_POST') ?>" />
	</div>
</form>
</div>