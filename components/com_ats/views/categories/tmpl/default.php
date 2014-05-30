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

// Get page parameters
$params = JFactory::getApplication()->getPageParameters('com_ats');
?>
<div class="akeeba-bootstrap">

<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-categories-top'); ?>

<?php if ($params->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo $this->escape($params->get('page_heading', JText::_('COM_ATS_CATEGORIES_TITLE'))); ?>
	</h1>
<?php endif; ?>

<?php if(empty($this->items)):?>
<?php echo AtsHelperModules::loadposition('ats-categories-none-top'); ?>
<p>
	<?php echo JText::_('COM_ATS_CATEGORIES_MSG_NOCATEGORIES') ?>
</p>
<?php echo AtsHelperModules::loadposition('ats-categories-none-bottom'); ?>
<?php else: ?>
<table class="table table-striped">
	<tbody>
<?php foreach($this->items as $cat):
$catURL = JRoute::_('index.php?option=com_ats&view=tickets&category='.$cat->id);
$newTicketURL = JRoute::_('index.php?option=com_ats&view=newticket&category='.$cat->id);
$canCreateTicket = false;
if(JFactory::getUser()->authorise('core.create', 'com_ats')) {
	$canCreateTicket = true;
} elseif(JFactory::getUser()->authorise('core.create', 'com_ats.category.'.$cat->id)) {
	$canCreateTicket = true;
}
?>
		<tr>
			<td>

				<h4>
					<?php if($cat->level > 1) for($i = 1; $i < $cat->level; $i++): ?>
					<div class="ats-category-levelpad">&#x2520;</div>
					<?php endfor; ?>
					<a href="<?php echo $catURL ?>">
						<?php echo $this->escape($cat->title) ?>
					</a>
				</h4>

				<div class="ats-category-quickbuttons pull-right">
					<a class="btn btn-info" href="<?php echo $catURL ?>">
						<i class="icon-folder-open icon-white"></i>
						<?php echo JText::_('COM_ATS_CATEGORIES_VIEWTICKETS') ?>
					</a><?php if($canCreateTicket): ?><br/><a class="btn btn-success btn-small" href="<?php echo $newTicketURL ?>">
						<i class="icon-file icon-white"></i>
						<?php echo JText::_('COM_ATS_TICKETS_BUTTON_NEWTICKET') ?>
					</a>
					<?php endif; ?>
				</div>

				<div class="ats-category-desc">
					<?php echo $cat->description ?>
				</div>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php echo AtsHelperModules::loadposition('ats-categories-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>

</div>