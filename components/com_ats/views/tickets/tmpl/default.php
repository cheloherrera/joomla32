<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;
if(version_compare(JVERSION, '3.0', 'ge')) {
	JHTML::_('behavior.framework');
} else {
	JHTML::_('behavior.mootools');
}

// Load template helpers
$this->loadHelper('ats');
$this->loadHelper('html');
$this->loadHelper('modules');
// ...and some back-end helpers
require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/select.php';

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/tickets.js');

$user = JFactory::getUser();

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);
if($itemId != 0) {
	$actionURL = 'index.php?Itemid='.$itemId;
} else {
	$actionURL = 'index.php';
}

$canCreateTicket = false;
if($user->authorise('core.create', 'com_ats')) {
	$canCreateTicket = true;
} elseif($user->authorise('core.create', 'com_ats.category.'.$this->category->id)) {
	$canCreateTicket = true;
}

$filter_status = $this->getModel()->getState('status','');
$this->isManager = ($user->authorise('core.manage', 'com_ats') || $user->authorise('core.manage', 'com_ats.category.'.$this->category->id));
?>
<div class="akeeba-bootstrap">

<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-tickets-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo $this->escape($this->category->title); ?>
	</h1>
<?php endif; ?>

<div class="ats-buttonbar">
	<?php if($canCreateTicket): ?>
	<div class="ats-button ats-button-action-newticket" style="float:left">
		<span class="ats-button-wrapper">
			<span class="ats-button-pre"></span>
			<a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_ats&view=newticket&category='.$this->category->id.($itemId ? '&Itemid='.$itemId : '')) ?>">
				<i class="icon-file icon-white"></i>
				<?php echo JText::_('COM_ATS_TICKETS_BUTTON_NEWTICKET') ?>
			</a>
			<span class="ats-button-post"></span>
		</span>
	</div>
	<?php endif; ?>
	<div style="float: right;">
		<?php echo AtsHelperSelect::ticketstatuses($filter_status, 'filter-status', array('onchange'=>"document.getElementById('ats_filter_status').value = document.getElementById('filter-status')[document.getElementById('filter-status').selectedIndex].value;document.forms.atspagination.submit();"), 'filter-status') ?>
	</div>

	<div class="ak_clr"></div>
</div>

<div class="ats-clear"></div>

<?php if(empty($this->items)): ?>
<?php echo AtsHelperModules::loadposition('ats-tickets-none-top'); ?>
<p>
	<?php echo JText::_('COM_ATS_TICKETS_MSG_NOTICKETS') ?>
</p>
<?php echo AtsHelperModules::loadposition('ats-tickets-none-bottom'); ?>

<?php else: ?>
<table class="table table-striped">
<?php foreach($this->items as $ticket):?>
<?php $this->ticket = $ticket; echo $this->loadAnyTemplate('site:com_ats/tickets/default_ticket')  ?>
<?php endforeach; ?>
</table>

<?php endif; ?>

<form id="ats-pagination" name="atspagination" action="<?php echo $actionURL ?>" method="post">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="tickets" />
	<input type="hidden" name="category" value="<?php echo $this->category->id ?>" />
	<input type="hidden" name="status" value="<?php echo $filter_status; ?>" id="ats_filter_status" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" id="token" />
	<input type="hidden" id="user" value="<?php echo JFactory::getUser()->id?>" />

<?php if ($this->pageparams->get('show_pagination',1)) : ?>
	<?php if($this->pagination->get('pages.total') > 1): ?>
	<div class="pagination">
		<?php if ($this->pageparams->get('show_pagination_results',1)) : ?>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php endif; ?>

		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
<?php endif; ?>
</form>

<?php echo AtsHelperModules::loadposition('ats-tickets-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>

</div>