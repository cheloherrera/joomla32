<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

// Load template helpers
$this->loadHelper('modules');

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);
if($itemId != 0) {
	$actionURL = 'index.php?Itemid='.$itemId;
} else {
	$actionURL = 'index.php';
}

?>
<div class="akeeba-bootstrap">
<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-assignedtickets-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo JText::_('COM_ATS_MY_TITLE'); ?>
	</h1>
<?php endif; ?>

<?php if(empty($this->items)): ?>
<?php echo AtsHelperModules::loadposition('ats-assignedtickets-none-top'); ?>
<p>
	<?php echo JText::_('COM_ATS_MYTICKETS_MSG_NOTICKETS') ?>
</p>
<?php echo AtsHelperModules::loadposition('ats-assignedtickets-none-bottom'); ?>

<?php else: ?>
<table class="table table-striped">
	<thead>
<?php foreach($this->items as $ticket):?>
<?php $this->ticket = $ticket; echo $this->loadAnyTemplate('site:com_ats/assignedticket/default_ticket')  ?>
<?php endforeach; ?>
	</thead>
</table>

<form id="ats-pagination" action="<?php echo $actionURL ?>" method="post">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="assignedticket" />

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

<?php endif; ?>

<?php echo AtsHelperModules::loadposition('ats-assignedtickets-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>
</div>