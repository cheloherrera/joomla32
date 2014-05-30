<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

// This file is loaded when editing existing tickets
JPluginHelper::importPlugin('ats');

if(version_compare(JVERSION, '3.0', 'ge'))
{
    JHTML::_('behavior.framework');
    JHtml::_('formbehavior.chosen');
}
else
{
    JHTML::_('behavior.mootools');
    AkeebaStrapper::addCSSfile('media://com_ats/css/chosen.min.css');
    AkeebaStrapper::addJSfile('media://com_ats/js/chosen.jquery.min.js');

    $js = <<<JS
akeeba.jQuery(document).ready(function(){
    akeeba.jQuery('.advancedSelect').chosen({
        disable_search_threshold : 10,
        allow_single_deselect : true,
        width: '300px'
    });
})
JS;

    AkeebaStrapper::addJSdef($js);
}

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);
JFactory::getDocument()->addScriptDeclaration("function addToValidationFetchQueue(myfunction){}");
JFactory::getDocument()->addScriptDeclaration("function addToValidationQueue(myfunction){}");

$this->loadHelper('editor');
$this->loadHelper('select');

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

$isManager = JFactory::getUser()->authorise('core.manage','com_ats');
if(isset($category))
{
	$isManager = JFactory::getUser()->authorise('core.manage','com_ats.category.' . $category);
}

$tags = F0FModel::getTmpInstance('Usertags', 'AtsModel')->loadTagsByUser($this->item->created_by);
?>
<div class="akeeba-bootstrap">
<div class="ats-ticket-replyarea">
<form class="form-horizontal" action="<?php echo JURI::base() ?>index.php" method="post" <?php echo $quickreply ? '' : 'name="adminForm" id="adminForm"' ?> enctype="multipart/form-data">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="post" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="ats_ticket_id" value="<?php echo $ats_ticket_id ?>" />
	<input type="hidden" name="ats_post_id" value="<?php echo $ats_post_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	<?php if(isset($returnURL)): ?>
	<input type="hidden" name="returnurl" value="<?php echo $returnURL ?>" />
	<?php endif; ?>

<?php
// Allow custom field edit only if I'm a manger and this is the fist post of the thread
if($isManager && $this->getModel()->isFirstOne())
{
	// @TODO Load everything inside the $cache variable, in the same way we do in Akeeba Subs
	$app  = JFactory::getApplication();
	$args = array_merge($this->ticket->getProperties(), array('catid' => $this->ticket->catid));
	unset($args['input']);
	$jResponse = $app->triggerEvent('onTicketFormRenderPerCatFields', array($args));
	if(is_array($jResponse) && !empty($jResponse))
	{
		foreach($jResponse as $customFields)
		{
			if(is_array($customFields) && !empty($customFields))
			{
				foreach($customFields as $field)
				{
					if(array_key_exists('isValid', $field) && $this->input->getInt('formsubmit', 0))
					{
						$customField_class = $field['isValid'] ? (array_key_exists('validLabel', $field) ? 'success' : '') : 'error';
					}
					else
					{
						$customField_class = '';
					}
	?>
		<div class="control-group <?php echo $customField_class ?>">
			<label for="<?php echo $field['id']?>" class="control-label">
				<?php echo $field['label']?>
			</label>
			<div class="controls">
				<?php echo $field['elementHTML']?>
				<?php if(array_key_exists('validLabel', $field) && $this->input->getInt('formsubmit', 0)):?>
				<span id="<?php echo $field['id']?>_valid" class="help-inline"
					  style="<?php if(!$field['isValid']):?>display:none<?php endif?>">
						  <?php echo $field['validLabel']?>
				</span>
				<?php endif;?>
				<?php if(array_key_exists('invalidLabel', $field) && $this->input->getInt('formsubmit', 0)):?>
				<span id="<?php echo $field['id']?>_invalid" class="help-inline"
					  style="<?php if($field['isValid']):?>display:none<?php endif?>">
						  <?php echo $field['invalidLabel']?>
				</span>
				<?php endif;?>
			</div>
		</div>

	<?php
				}
			}
		}
	}
}
	?>

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

<?php if($isManager && ($this->item instanceof AtsTablePost) && ATS_PRO): ?>
	<div class="ats-ticket-replyarea-timetracking form-inline">
        <div class="control-group">
		<label for="ats-timespent" class="control-label"><?php echo JText::_('COM_ATS_POSTS_LBL_TIMESPENT'); ?></label>
            <div class="controls">
                <span class="input-append">
                    <input type="text" name="timespent" id="ats-timespent" class="input-small" value="<?php echo $this->item->timespent ?>" />
                    <span class="add-on"><?php echo JText::_('COM_ATS_POSTS_LBL_TIMESPENT_MINUTES') ?></span>
                </span>
            </div>
        </div>
	</div>
<?php endif; ?>
<?php if($isManager) : ?>
    <div class="control-group">
        <label for="usertags" class="control-label"><?php echo JText::_('COM_ATS_COMMON_USER_TAGS')?></label>
        <div class="controls">
            <?php echo AtsHelperSelect::usertags('usertags[]', $tags, array('class' => 'advancedSelect input-large', 'multiple' => 'multiple', 'size' => 5))?>
        </div>
    </div>
<?php endif; ?>

	<?php if(!($this->item instanceof AtsTablePost)):?>
	<div class="ats-ticket-replyarea-attachment">
		<p><?php echo JText::_('COM_ATS_POSTS_MSG_ADDATTACHMENT'); ?></p>
		<input type="file" name="attachedfile" size="10" />
	</div>

	<div class="ats-ticket-replyarea-postbutton">
		<input class="btn btn-primary" type="submit" value="<?php echo JText::_('COM_ATS_POSTS_MSG_POST') ?>" />
	</div>
	<?php else: ?>
	<input class="btn btn-primary" type="submit" value="<?php echo JText::_('COM_ATS_POSTS_MSG_POST') ?>" />
	<?php endif; ?>
</form>
</div>
</div>