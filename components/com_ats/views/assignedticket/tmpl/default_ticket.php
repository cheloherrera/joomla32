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

$mine = JFactory::getUser()->id == $this->ticket->created_by;
$icon = $this->ticket->public ? 'icon-eye-open' : 'icon-eye-close';
$badge = $this->ticket->public ? 'badge-warning' : 'badge-success';

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

?>
<tr>
	<td>
		<span class="label <?php echo $status_class?> pull-right">
			<?php echo AtsHelperHtml::decodeStatus($this->ticket->status)?>
		</span>
		<?php if($mine): ?>
		<span class="pull-left badge badge-info" style="margin-right: 2px">
			<i class="icon-user icon-white"></i>
		</span>
		<?php endif; ?>
		<span class="pull-left badge <?php echo $badge?>" style="margin-right: 2px">
			<i class="<?php echo $icon?> icon-white"></i>
		</span>
		<h4>
			<a href="<?php echo $ticketURL ?>">
				#<?php echo $this->ticket->ats_ticket_id ?>:
				<?php echo $this->escape($this->ticket->title) ?>
			</a>
		</h4>

		<span class="small pull-right">
			<?php echo JText::sprintf('COM_ATS_TICKETS_MSG_LASTPOST', $lastBy, $lastOn) ?>
		</span>
		<span class="small pull-left">
			<?php echo JText::sprintf('COM_ATS_TICKETS_MSG_CREATED', $createdOn, $createdBy) ?>
		</span>
	</td>
</tr>