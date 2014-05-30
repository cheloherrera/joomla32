<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

JHTML::_('behavior.keepalive');
JHTML::_('behavior.modal');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

AkeebaStrapper::addCSSfile('media://com_ats/css/print.css?'.ATS_VERSIONHASH);

$this->loadHelper('credits');
$this->loadHelper('format');
$this->loadHelper('html');
$this->loadHelper('modules');
$this->loadHelper('select');

$user      = JFactory::getUser();
$ownerUser = JFactory::getUser($this->item->created_by);
$component = JComponentHelper::getParams('com_ats');

$isManager = $user->authorise('core.manage','com_ats') || $user->authorise('core.manage','com_ats.category.' . $this->category->id);

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);

$show_credits     = JComponentHelper::getParams('com_ats')->get('showcredits', 0);
$credits_charged  = AtsHelperCredits::creditsCharged('ticket', $this->item->ats_ticket_id);
$totalcredits	  = AtsHelperCredits::creditsCharged('all', $this->item->ats_ticket_id);

if($this->item->assigned_to)
{
	$class 		 = 'label-info';
	$assigned_to = JFactory::getUser($this->item->assigned_to)->name;
}
else
{
	$class 		 = 'label-important';
	$assigned_to = JText::_('COM_ATS_TICKETS_UNASSIGNED');
}
?>

<h1 class="ats-ticket-view-sitename">
	<?php echo JFactory::getConfig()->get('sitename') ?>
</h1>

<h2 class="ats-ticket-view-title">
	<span class="ats-ticket-view-title-number">
	#<?php echo $this->escape($this->item->ats_ticket_id); ?>
	</span>
	<?php echo $this->escape($this->item->title); ?>
</h2>

<h3 class="ats-ticket-view-postedin">
	<?php echo JText::sprintf('COM_ATS_TICKET_LBL_POSTEDIN', $this->escape($this->category->title)) ?>
</h3>

<?php if($this->perms['admin'] && ATS_PRO ):?>
<div class="ats-ticket-view-stats">
	<?php echo JText::sprintf('COM_ATS_TICKET_TIMESPENT_MSG', $this->item->timespent); ?>
	<?php if ($show_credits): ?>
	<br/>
	<?php echo JText::sprintf('COM_ATS_TICKET_TOTALCREDITS_MSG', $totalcredits); ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if($this->item->public): ?>
<div class="ats-newticket-pubnote ats-newticket-pubnote-public">
	<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PUBLIC') ?>
</div>
<?php else: ?>
<div class="ats-newticket-pubnote ats-newticket-pubnote-private">
	<?php echo JText::_('COM_ATS_NEWTICKET_MSG_PUBNOTE_PRIVATE') ?>
</div>
<?php endif; ?>

<?php if( $this->perms['admin'] && ($this->item->status == 'C') ): ?>
<div class="ats-ticket-closed">
	<?php echo JText::_('COM_ATS_TICKET_MSG_CLOSEDNOTICE_CLOSED_ADMIN') ?>
</div>
<?php endif; ?>

<?php
/**/
	F0FDispatcher::getTmpInstance('com_ats', 'posts', array('input'=>array(
		'category_id'		=> $this->category->id,
		'ats_ticket_id'		=> $this->item->ats_ticket_id,
		'ticket_owner'		=> $this->item->created_by,
		'layout'			=> 'print',
		'limit'				=> 0,
		'limitstart'		=> 0,
		'render.toolbar'	=> 0,
		'filter_order'		=> 'created_on',
		'filter_order_Dir'	=> 'ASC',
        'bootstrap'         => false
	)))->dispatch();
/**/
?>