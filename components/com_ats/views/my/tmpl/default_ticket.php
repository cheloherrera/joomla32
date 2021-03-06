<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;
$ticketURL = JRoute::_('index.php?option=com_ats&view=ticket&id='.$this->ticket->ats_ticket_id);

$this->loadHelper('html');

$createdOn = new JDate($this->ticket->created_on);
$createdOn = $createdOn->format('Y-m-d H:i T', true);
$createdBy = JFactory::getUser($this->ticket->created_by)->username;

$modifiedOn = new JDate($this->ticket->modified_on);
if($modifiedOn->toUnix() > 90000) {
	$lastOn = $modifiedOn->format('Y-m-d H:i T', true);
	$lastBy = JFactory::getUser($this->ticket->modified_by)->username;
} else {
	$lastOn = $createdOn; $lastBy = $createdBy;
}

$returnURL   = base64_encode(JFactory::getURI()->toString());
$curUser	 = JFactory::getUser();
$mine = JFactory::getUser()->id == $this->ticket->created_by;
$icon = $this->ticket->public ? 'icon-eye-open' : 'icon-eye-close';
$badge = $this->ticket->public ? 'badge-warning' : 'badge-success';
$assign_class= $this->ticket->assigned_to ? 'badge-info': '';
$assigned_to = $this->ticket->assigned_name ? $this->ticket->assigned_name : JText::_('COM_ATS_TICKETS_UNASSIGNED');
$assignedToMe = $this->ticket->assigned_to == $curUser->id;
$adminActionsURL = 'index.php?option=com_ats&view=ticket&id='.$this->ticket->ats_ticket_id.'&returnurl='.$returnURL.'&Itemid='.$this->input->getInt('Itemid',0).'&'.JFactory::getSession()->getFormToken().'=1';

switch($this->ticket->status) {
	case 'O':
		$status_class = 'label-important';
		break;

	case 'C':
		$status_class = 'label-success';
		break;

	case 'P':
	default:
		$status_class = 'label-warning';
		break;
}

$isManager = AtsHelper::isManager($this->ticket->catid);

?>
<tr>
	<td>
		<h4>
			<input type="hidden" class="ats_ticket_id" value="<?php echo $this->ticket->ats_ticket_id?>" />

			<div class="pull-right">
			<?php if($isManager):?>
					<?php echo AtsHelperHtml::createStatusDropdown(array('div_style' => 'pull-right', 'btn_style' => '', 'title' => ''))?>
			<?php endif;?>
				<span class="label <?php echo $status_class?> pull-right">
					<?php echo AtsHelperHtml::decodeStatus($this->ticket->status)?>
				</span>
			</div>

			<?php if ($this->ticket->priority > 5): ?>
			<span class="pull-left badge badge-info" style="margin-right: 2px">
				<span class="icon-arrow-down icon-white"></span>
			</span>
			<?php elseif (($this->ticket->priority > 0) && ($this->ticket->priority < 5)): ?>
			<span class="pull-left badge badge-important" style="margin-right: 2px">
				<span class="icon-arrow-up icon-white"></span>
			</span>
			<?php else: ?>
			<?php endif; ?>

			<span class="pull-left badge <?php echo $badge?>" style="margin-right: 2px">
				<span class="<?php echo $icon?> icon-white"></span>
			</span>

			<?php if($isManager && ATS_PRO):?>
			<span class="pull-right">&nbsp;</span>
			<?php echo AtsHelperHtml::buildManagerdd(null, array('div' => 'assignto pull-right', 'a' => 'btn-mini'), $this->ticket->catid)?>
			<span class="pull-right badge assigned_to <?php echo $assign_class?>" style="margin-right:5px"><?php echo $assigned_to?></span>
			<span class="loading btn-small pull-right" style="display:none">
				<i class="icon-ok"></i>
				<i class="icon-warning-sign"></i>
				<img src="<?php echo F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif')?>" />
			</span>
			<input type="hidden" class="ticket_id" value="<?php echo $this->ticket->ats_ticket_id ?>" />
			<?php endif;?>

			<a href="<?php echo $ticketURL ?>">
				#<?php echo $this->ticket->ats_ticket_id ?>:
				<?php echo $this->escape($this->ticket->title) ?>
			</a>
		</h4>
		<div class="clearfix"></div>

		<div>
			<span class="small pull-right">
				<?php echo JText::sprintf('COM_ATS_TICKETS_MSG_LASTPOST', $lastBy, $lastOn) ?>
			</span>
			<span class="small pull-left">
				<?php echo JText::sprintf('COM_ATS_TICKETS_MSG_CREATED', $createdOn, $createdBy) ?>
			</span>
		</div>
	</td>
</tr>