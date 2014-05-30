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
$this->loadHelper('format');
$this->loadHelper('modules');

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/tickets.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/latestopen-keyboard.js?'.ATS_VERSIONHASH);

// Get the Itemid
$itemId = $this->input->getInt('Itemid',0);
if($itemId != 0) {
	$actionURL = 'index.php?Itemid='.$itemId;
} else {
	$actionURL = 'index.php';
}

?>
<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-latest-top'); ?>
<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo JText::_('COM_ATS_LATEST_TITLE'); ?>
	</h1>
<?php endif; ?>

<?php if(empty($this->items)): ?>
<?php echo AtsHelperModules::loadposition('ats-latest-none-top'); ?>
<p>
	<?php echo JText::_('COM_ATS_LATEST_MSG_NOTICKETS') ?>
</p>
<?php echo AtsHelperModules::loadposition('ats-latest-none-bottom'); ?>

<?php else: ?>
<table class="table table-striped">
	<thead>
<?php
	$counter = 0;
	foreach($this->items as $ticket):
		$counter++;
?>
<?php $this->ticket = $ticket; echo $this->loadAnyTemplate('site:com_ats/latest/default_ticket', array('counter' => $counter))  ?>
<?php
	endforeach;
?>
	</thead>
</table>

<form id="ats-pagination" action="<?php echo $actionURL ?>" method="post">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="my" />
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

<?php endif; ?>

<?php echo AtsHelperModules::loadposition('ats-latest-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>