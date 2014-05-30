<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

F0FTemplateUtils::addCSS('media://com_ats/css/backend.css?'.ATS_VERSIONHASH);

$this->loadHelper('select');
$this->loadHelper('format');

?>

<div id="ats-bucket-toprow">

<form action="index.php" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="bucket" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="ats_bucket_id" value="<?php echo $this->item->ats_bucket_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

	<div class="row-fluid">
		<div class="span12">
			<h3><?php echo JText::_('COM_ATS_BUCKETS_LEGEND_BUCKETPARAMS'); ?></h3>

			<table class="table table-striped table-boxed">
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_BUCKETS_HEADING_TITLE'); ?>
					</td>
					<td class="ats-infotable-data">
						<input type="text" name="title" class="input-xxlarge" value="<?php echo $this->escape($this->item->title) ?>" />
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_BUCKETS_HEADING_STATUS'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperSelect::bucketstatuses($this->item->status, 'status') ?>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_BUCKETS_HEADING_CREATED'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperFormat::date($this->item->created_on) ?>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_BUCKETS_HEADING_MODIFIED'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php if($this->item->modified_on == '0000-00-00 00:00:00'): ?>
						&mdash;
						<?php else: ?>
						<?php echo AtsHelperFormat::date($this->item->modified_on) ?>
						<?php endif; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>
</div>

<?php
$showTicketList = false;
$showReplyArea  = false;
$showTabs 	    = false;

if(property_exists($this, 'tickets'))
{
	$showTicketList = count($this->tickets) > 0;
	$showReplyArea = $this->item->status != 'C' && count($this->tickets) > 0;
	$showTabs = $showReplyArea && $showTicketList;
}
?>
<div class="row-fluid">
	<div class="span12">
<?php if($showTabs):?>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#ats_bucket_reply" data-toggle="tab">
						<?php echo JText::_('COM_ATS_BUCKETS_LEGEND_REPLY') ?>
					</a>
				</li>
				<li>
					<a href="#ats_bucket_tickets" data-toggle="tab">
						<?php echo JText::_('COM_ATS_BUCKETS_LEGEND_TICKETLIST') ?>
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="ats_bucket_reply">
<?php endif; ?>
<?php if($showReplyArea):?>
					<h3><?php echo JText::_('COM_ATS_POSTS_HEADING_REPLYAREA'); ?></h3>
					<?php echo $this->loadAnyTemplate('site:com_ats/bucketreply/form',array(
						'ats_bucket_id'	=> $this->item->ats_bucket_id,
						'returnURL'		=> base64_encode(JURI::getInstance()->toString()),
						'item'			=> null,
						'savestate'		=> 0,
					));?>
<?php endif; ?>
<?php if($showTabs):?>
				</div>
				<div class="tab-pane" id="ats_bucket_tickets">
<?php endif; ?>
<?php if($showTicketList):?>
					<h3><?php echo JText::_('COM_ATS_BUCKETS_HEADING_TICKETLIST'); ?></h3>
					<table class="table table-striped">
						<thead>
						<?php foreach($this->tickets as $ticket):?>
						<?php $this->ticket = $ticket; echo $this->loadAnyTemplate('site:com_ats/tickets/default_ticket')  ?>
						<?php endforeach; ?>
						</thead>
					</table>
<?php else: ?>
					<div class="alert alert-info">
						<?php echo JText::_('COM_ATS_BUCKETS_NO_TICKETS_INFO') ?>
					</div>
<?php endif; ?>
<?php if($showTabs):?>
				</div>
			</div>
		</div>
<?php endif; ?>
	</div>
</div>
