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

(function($) {
	$(document).ready(function(){
		$('.advancedSelect').chosen({
			disable_search_threshold : 10,
			allow_single_deselect : true
		});
	})
})(akeeba.jQuery);

JS;

    AkeebaStrapper::addJSdef($js);

}
JHTML::_('behavior.modal');

$this->loadHelper('select');

$ownerUser = JFactory::getUser($this->item->created_by);
$tags      = array();

if($this->item->created_by)
{
    $tags = F0FModel::getTmpInstance('Usertags', 'AtsModel')->loadTagsByUser($this->item->created_by);
}

?>
<table class="table table-striped table-boxed">
	<?php if (!$this->showuserinfo): ?>
	<tr>
		<td><?php echo JText::_('COM_ATS_COMMON_USERSELECT_LBL')?></td>
		<td>
			<input type="hidden" name="created_by" id="created_by" value="<?php echo $this->item->created_by?>" />
			<input type="text" class="input-medium" name="xxx_userid" id="created_by_visible" value="<?php echo $this->item->created_by ? JFactory::getUser($this->item->created_by)->username : '' ?>" disabled="disabled" />
			<button onclick="return false;" class="btn btn-mini modal"><?php echo JText::_('COM_ATS_COMMON_SELECTUSER')?></button>
			<a class="modal" style="display: none" id="userselect" href="index.php?option=com_users&view=users&layout=modal&tmpl=component&field=userid" rel="{handler: 'iframe', size: {x: 800, y: 500}}">Select</a>
		</td>
	</tr>
    <tr>
        <td><?php echo JText::_('COM_ATS_COMMON_USER_TAGS')?></td>
        <td>
            <?php echo AtsHelperSelect::usertags('usertags[]', $tags, array('class' => 'advancedSelect', 'multiple' => 'multiple', 'size' => 5))?>
        </td>
    </tr>
	<?php else: ?>
	<tr>
		<td class="ats-infotable-label"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_USERNAME'); ?></td>
		<td class="ats-infotable-data">
			<a href="index.php?option=com_users&task=user.edit&id=<?php echo $ownerUser->id ?>" target="_blank">
			<strong><?php echo $ownerUser->username ?></strong> [<?php echo $ownerUser->id ?>]
			</a>
		</td>
	</tr>
    <tr>
        <td><?php echo JText::_('COM_ATS_COMMON_USER_TAGS')?></td>
        <td>
            <?php echo AtsHelperSelect::usertags('usertags[]', $tags, array('class' => 'advancedSelect', 'multiple' => 1))?>
        </td>
    </tr>
	<tr>
		<td class="ats-infotable-label"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_NAME'); ?></td>
		<td class="ats-infotable-data"><?php echo $ownerUser->name ?></td>
	</tr>
	<tr>
		<td class="ats-infotable-label"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_EMAIL'); ?></td>
		<td class="ats-infotable-data"><?php echo $ownerUser->email ?></td>
	</tr>
	<tr>
		<td class="ats-infotable-label"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_CREDITS'); ?></td>
		<td class="ats-infotable-data"><?php echo AtsHelperCredits::creditsLeft($ownerUser->id, true) ?>
		</td>
	</tr>
	<?php if($this->akeebasubs): ?>
	<tr>
		<td class="ats-infotable-label"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_SUBSCRIPTIONS'); ?></td>
		<td class="ats-infotable-data">
			<?php if(count($this->activesubs)): ?>
			<?php echo implode(', ', $this->activesubs) ?>
			<?php else: ?>
			&mdash;
			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="ats-infotable-label"><?php echo JText::_('COM_ATS_TICKETS_USERINFO_SUBSCRIPTIONS_INACTIVE'); ?></td>
		<td class="ats-infotable-data">
			<?php if(count($this->inactivesubs)): ?>
			<?php echo implode(', ', $this->inactivesubs) ?>
			<?php else: ?>
			&mdash;
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if (ATS_PRO): ?>
	<tr>
		<td>&nbsp;</td>
		<td>
			<?php if($creditsCharged = AtsHelperCredits::creditsCharged('ticket', $this->item->ats_ticket_id)): ?>
			<a href="index.php?option=com_ats&view=ticket&task=creditsrefund&id=<?php echo $this->item->ats_ticket_id ?>&<?php echo JFactory::getSession()->getFormToken() ?>=1" class="btn btn-danger">
				<i class="icon-white icon-remove-sign"></i>
				<?php echo JText::sprintf('COM_ATS_TICKETS_CREDITS_REFUND', $creditsCharged); ?>
			</a>
			<?php else: ?>
			<a href="index.php?option=com_ats&view=ticket&task=creditscharge&id=<?php echo $this->item->ats_ticket_id ?>&<?php echo JFactory::getSession()->getFormToken() ?>=1" class="btn btn-success">
				<i class="icon-white icon-plus-sign"></i>
				<?php echo JText::sprintf('COM_ATS_TICKETS_CREDITS_CHARGE', AtsHelperCredits::creditsRequired($this->item->catid, true, $this->item->public, $this->item->priority)); ?>
			</a>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
</table>
<?php endif; ?>

<?php if (!$this->showuserinfo): ?>
<script type="text/javascript">
function jSelectUser_userid(id, username)
{
	document.getElementById('created_by').value = id;
	document.getElementById('created_by_visible').value = username;

    akeeba.jQuery.ajax('index.php?option=com_ats&view=usertags&task=getbyuser&user=' + id,{
        dataType : 'json',
        success : function(response){
            // On Joomla 2.5 I have "chosen", in 3.2 I have "liszt"
            akeeba.jQuery('#usertags').val(response).trigger('liszt:updated').trigger('chosen:updated');
        }
    });

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
<?php endif; ?>