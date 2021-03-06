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

$component = JComponentHelper::getParams('com_ats');
if(!isset($quickreply)) $quickreply = !($this->item instanceof AtsTablePost);

if(!isset($ats_ticket_id)) {
	$ats_ticket_id = 0;
	if($this->item instanceof AtsTablePost) $ats_ticket_id = $this->item->ats_ticket_id;
}

if(!isset($ats_post_id)) {
	$ats_post_id = 0;
	if($this->item instanceof AtsTablePost) $ats_post_id = $this->item->ats_post_id;
}

if(!isset($returnURL)) {
	$returnURLtemp = $this->input->getString('returnurl',null);
	if(!empty($returnURLtemp)) $returnURL = $returnURLtemp;
}

$js = <<<JS
akeeba.jQuery(document).ready(function(jQuery){
    jQuery('#addAttachment').click(function(){
        if(jQuery('input[name="attachedfile[]"]').length >= 10)
        {
            return false;
        }

        var clone = jQuery('.attachmentWrapper').first().clone();
        clone.children('input').val('');
        clone.children('a').css('display', 'inline-block');

        clone.appendTo('.attachmentHolder');
    })

    jQuery('.attachmentHolder').on('click', '.attachmentWrapper a', function(){
        jQuery(this).parent().remove();
    });
})
JS;

AkeebaStrapper::addJSdef($js);

?>

<div class="ats-ticket-replyarea">
<form action="index.php" method="post" <?php echo $quickreply ? '' : 'name="adminForm" id="adminForm"' ?> enctype="multipart/form-data">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="post" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_ticket_id" value="<?php echo $ats_ticket_id ?>" />
	<input type="hidden" name="ats_post_id" value="<?php echo $ats_post_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	<?php if(isset($returnURL)): ?>
	<input type="hidden" name="returnurl" value="<?php echo $returnURL ?>" />
	<?php endif; ?>

	<div class="ats-ticket-replyarea-content bbcode">
		<?php
			$contents = '';
			if(AtsHelperEditor::isEditorBBcode()) {
				$name = 'content'; $id = 'bbcode';
			} else {
				$name = 'content_html'; $id = 'ats-content';
			}
			if(isset($this->item)) {
				if($this->item instanceof AtsTablePost) {
					if(AtsHelperEditor::isEditorBBcode()) {
						$contents = $this->item->content;
					} else {
						$contents = $this->item->content_html;
					}
				}
			}
			echo AtsHelperEditor::showEditor($name, $id, $contents, '95%', 400, 80, 20);
		?>
	</div>

	<div class="ats-ticket-replyarea-timetracking form-inline">
	<?php if($component->get('showcredits', 0)):?>
		<label for="ats-credits-charge"><?php echo JText::_('COM_ATS_POSTS_CREDITS_CHARGE')?></label>
		<span class="input-append">
			<input type="text" name="extracredits" id="ats-credits-charge" class="input-small" value="" />
			<span class="add-on"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_CREDITS') ?></span>
		</span>
	<?php endif;?>
		<label for="ats-timespent">
			<?php echo JText::_('COM_ATS_POSTS_LBL_TIMESPENT'); ?>
		</label>
		<span class="input-append">
			<input type="text" name="timespent" id="ats-timespent" class="input-small" value="<?php echo $this->item->timespent ?>" />
			<span class="add-on"><?php echo JText::_('COM_ATS_POSTS_LBL_TIMESPENT_MINUTES') ?></span>
		</span>
		<br/>
	</div>

	<?php if(!($this->item instanceof AtsTablePost)):?>
	<div class="ats-ticket-replyarea-attachment">
		<p><?php echo JText::_('COM_ATS_POSTS_MSG_ADDATTACHMENT'); ?></p>
        <div class="attachmentHolder">
            <div class="attachmentWrapper">
                <input type="file" name="attachedfile[]" size="10" />
                <a class="btn btn-mini btn-inverse" href="javascript:void(0)" style="display: none"><?php echo JText::_('COM_ATS_COMMON_REMOVE')?></a>
            </div>
        </div>

        <a href="javascript:void(0);" class="btn" id="addAttachment"><?php echo JText::_('COM_ATS_POSTS_ADD_ATTACHMENT')?></a>
	</div>

	<div class="ats-ticket-replyarea-postbutton">
		<input class="btn btn-primary" type="submit" value="<?php echo JText::_('COM_ATS_POSTS_MSG_POST') ?>" />
	</div>
	<?php endif; ?>
</form>
</div>