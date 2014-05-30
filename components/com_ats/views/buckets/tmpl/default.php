<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

/*
 * Variables coming from loadAnytemplate method
 *
 * $assignTickets	Should I display the "Add to bucket" button?
 * $hideLinks		Should I hide bucket link?
 */
// Prevent warnings with param variables
if(!isset($assignTickets))	$assignTickets = 0;
if(!isset($hideLinks))		$hideLinks	   = 0;

// Load template helpers
$this->loadHelper('modules');
// ...and some back-end helpers
require_once JPATH_ADMINISTRATOR.'/components/com_ats/helpers/select.php';

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);
$loading = F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif');

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);
if($itemId != 0) {
	$actionURL = 'index.php?Itemid='.$itemId;
} else {
	$actionURL = 'index.php';
}

$filter_status = $this->getModel()->getState('status','');
?>
<div class="akeeba-bootstrap">

<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-buckets-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo 'Buckets' ?>
	</h1>
<?php endif; ?>

<div class="ats-buttonbar">
<?php if($assignTickets):?>
	<div style="float:left">
		<button id="addTickets" class="btn pull-left"><?php echo JText::_('COM_ATS_BUCKETS_ADD_TICKETS')?></button>
		<div class="pull-left" style="margin:5px">
			<img id="loading" style="display:none" src="<?php echo $loading?>" />
			<div id="saveok" class="pull-left" style="display:none;">
				<i><?php echo JText::_('COM_ATS_BUCKETS_TICKET_SAVE_OK')?></i>
			</div>
			<div id="saveko" class="pull-left" style="display:none">
				<i><?php echo JText::_('COM_ATS_BUCKETS_TICKET_SAVE_ERR')?></i>
			</div>
		</div>
	</div>
<?php endif;?>
	<div style="float: right;">
		<?php echo AtsHelperSelect::bucketstatuses($filter_status, 'filter-status', array('onchange'=>"document.getElementById('ats_filter_status').value = document.getElementById('filter-status')[document.getElementById('filter-status').selectedIndex].value;document.forms.atspagination.submit();")) ?>
	</div>
</div>

<div class="ats-clear"></div>

<?php if(empty($this->items)): ?>
<?php echo AtsHelperModules::loadposition('ats-buckets-none-top'); ?>
<p>
	<?php echo JText::_('COM_ATS_BUCKETS_MSG_NOBUCKETS') ?>
</p>
<?php echo AtsHelperModules::loadposition('ats-buckets-none-bottom'); ?>

<?php else: ?>
<table class="table table-striped">
	<thead>
<?php
	// Required by JHtml::_('grid.id') if we want the checkbox
	$this->i = 0;
	foreach($this->items as $bucket)
	{
		$this->bucket = $bucket;
		echo $this->loadAnyTemplate('site:com_ats/buckets/default_bucket', array(
				'displayCbx' => $assignTickets,
				'hideLinks'	 => $hideLinks
				));
		$this->i++;
	}
?>
	</thead>
</table>

<?php endif; ?>

<form id="ats-pagination" name="atspagination" action="<?php echo $actionURL ?>" method="post">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="buckets" />
	<input type="hidden" name="status" value="<?php echo $filter_status; ?>" id="ats_filter_status" />

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
<?php if($assignTickets):?>
	<input type="hidden" name="boxchecked" value="0" />
<?php endif;?>
</form>

<?php echo AtsHelperModules::loadposition('ats-buckets-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>

</div>