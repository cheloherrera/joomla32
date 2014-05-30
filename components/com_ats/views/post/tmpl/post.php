<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

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

// Load behaviours
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');

JLoader::import('joomla.plugin.helper');

$component  = JComponentHelper::getParams('com_ats');
$mediaLimit = JComponentHelper::getParams('com_media')->get('upload_maxsize', 0) * 1024 * 1024;
$user       = JFactory::getUser();
$isManager  = $user->authorise('core.manage','com_ats');
$isAdmin    = ($user->authorise('core.admin','com_ats') || $user->authorise('core.manage','com_ats'));

if(isset($category))
{
	$isManager = $user->authorise('core.manage','com_ats.category.' . $category);
}

// Is the "No new tickets" killswitch activated and we're not managers?
if(JComponentHelper::getParams('com_ats')->get('noreplies', 0) && !$isManager) {
	echo $this->loadAnyTemplate('site:com_ats/post/noreplies');
	return;
}

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);

$this->loadHelper('editor');

// This is required for the degenerate case of a ticket without posts
require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/format.php';

// Get upload limits
$umf = AtsHelperFormat::toBytes(ini_get('upload_max_filesize'));
$pms = AtsHelperFormat::toBytes(ini_get('post_max_size'));
if( ($umf * $pms) == 0 ) {
	$uploadLimit = max($umf, $pms);
} else {
	$uploadLimit = min($umf, $pms);
}

$uploadLimit = min($uploadLimit, $mediaLimit);
$uploadLimit = AtsHelperFormat::bytesToSize($uploadLimit);

$moduleContent = '';
$cannedreply   = false;
if(!$isManager)
{
	$moduleContent = AtsHelperModules::loadposition('ats-replyarea-overlay');
} else
{
	$cannedreply = true;
}

if(!isset($direct)) $direct = false;

$siterootURL = JURI::base().'index.php';
$tags        = array();

if($this->item->created_by)
{
    $tags = F0FModel::getTmpInstance('Usertags', 'AtsModel')->loadTagsByUser($this->item->created_by);
}

if($allow_attachment)
{
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
}

?>
<?php if(!empty($moduleContent)): ?>
<div id="ats-replyarea-overlay">
	<?php echo $moduleContent ?>
	<p>
		<a href="javascript:return false;" id="ats-replyarea-overlay-close" class="btn btn-success">
			<i class="icon-ok icon-white"></i>
			<?php echo JText::_('COM_ATS_NEWTICKET_INSTANTREPLY_CLOSEMESSAGE'); ?>
		</a>
	</p>
</div>
<?php endif ?>

<div class="controls">
	<?php if(AtsHelperEditor::isEditorBBcode()): ?>
	<div class="ats-ticket-content-info help-block">
		<?php echo JText::_('COM_ATS_NEWTICKET_LBL_YOURREQUEST_INFO'); ?>
	</div>
	<?php endif; ?>
</div>
	<div class="ats-ticket-replyarea-content bbcode">
		<?php
			$contents = '';
			if(AtsHelperEditor::isEditorBBcode()) {
				$name = $direct ? 'content' : 'post[content]'; $id = 'bbcode';
			} else {
				$name = $direct ? 'content_html' : 'post[content_html]'; $id = 'ats-content';
			}
			$params 				 = array();
			$params['buckets']  	 = $isAdmin && ATS_PRO;
			$params['ats_ticket_id'] = $this->item->ats_ticket_id;
			if($cannedreply)
			{
				$params['cannedreplies'] = true;
				if (isset($category))
				{
					$params['category'] = $category;
				}
			}

			echo AtsHelperEditor::showEditor($name, $id, $post_content, '95%', 400, 80, 20, $params);
		?>
	</div>

<?php if($isManager || $allow_attachment): ?>
	<div class="clearfix"></div>
	<div class="form-horizontal">
<?php endif; ?>

<?php if($isManager): ?>
    <?php if(ATS_PRO): ?>
		<?php if($component->get('showcredits', 0)):?>
		<div class="control-group">
			<label for="ats-credits-charge" class="control-label"><?php echo JText::_('COM_ATS_POSTS_CREDITS_CHARGE')?></label>
			<div class="controls">
				<span class="input-append">
					<input type="text" name="extracredits" id="ats-credits-charge" class="input-small" value="" />
					<span class="add-on"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_CREDITS') ?></span>
				</span>
			</div>
		</div>
	    <?php endif;?>

		<div class="control-group">
			<label for="ats-timespent" class="control-label"><?php echo JText::_('COM_ATS_POSTS_LBL_TIMESPENT'); ?></label>
			<div class="controls">
				<span class="input-append">
					<input type="text" name="timespent" id="ats-timespent" class="input-small" value="" />
					<span class="add-on"><?php echo JText::_('COM_ATS_POSTS_LBL_TIMESPENT_MINUTES') ?></span>
				</span>
			</div>
		</div>
    <?php endif; ?>
		<div class="control-group">
			<label for="usertags" class="control-label"><?php echo JText::_('COM_ATS_COMMON_USER_TAGS')?></label>
			<div class="controls">
				<?php echo AtsHelperSelect::usertags('usertags[]', $tags, array('class' => 'advancedSelect input-large', 'multiple' => 'multiple', 'size' => 5))?>
			</div>
        </div>
<?php endif; ?>

<?php if($allow_attachment): ?>
	<div class="ats-ticket-replyarea-attachment control-group">
		<label for="attachedfile" class="control-label"><?php echo JText::_('COM_ATS_NEWTICKET_LBL_ATTACHMENT'); ?></label>
		<div class="controls">
            <div class="attachmentHolder">
                <div class="attachmentWrapper">
			        <input type="file" name="attachedfile[]" size="10" />
                    <a class="btn btn-mini btn-inverse" href="javascript:void(0)" style="display: none"><?php echo JText::_('COM_ATS_COMMON_REMOVE')?></a>
                </div>
            </div>
			<span class="help-block">
				<?php echo JText::sprintf('COM_ATS_NEWTICKET_LBL_ATTACHMENT_MAXSIZE',$uploadLimit); ?>
			</span>

            <a href="javascript:void(0);" class="btn" id="addAttachment"><?php echo JText::_('COM_ATS_POSTS_ADD_ATTACHMENT')?></a>
		</div>
	</div>
<?php endif; ?>

<?php if($isManager || $allow_attachment): ?>
	</div>
<?php endif; ?>

<?php
if(!empty($moduleContent)) {
JFactory::getDocument()->addScriptDeclaration( <<<JS
(function($) {
	$(document).ready(function()	{
		$('#ats-replyarea-overlay-close').click(function(e){
			$('#ats-replyarea-overlay').hide();
		});
	});
})(akeeba.jQuery);
JS
);
}
