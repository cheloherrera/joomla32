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
 * $hideStatus   Should I hide the status column?
 * $hidePublish  Should I hide the publish column?
 * $otherFields	 Other fields that should be included in the form, coming from outside
 */
// Prevent warnings with param variables
if(!isset($hideStatus))		$hideStatus  = 0;
if(!isset($hidePublish))	$hidePublish = 0;
if(!isset($otherFields))	$otherFields = '';

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
if (version_compare(JVERSION, '3.0', 'gt'))
{
	JHtml::_('dropdown.init');
	JHtml::_('formbehavior.chosen', 'select');
}

F0FTemplateUtils::addCSS('media://com_ats/css/backend.css?'.ATS_VERSIONHASH);

$this->loadHelper('select');

$user	= JFactory::getUser();
$userId	= $user->get('id');
$task	= $this->input->getCmd('task', 'browse');

$sortFields = array(
	'id'				=> JText::_('JGRID_HEADING_ID'),
	'user_username' => JText::_('COM_ATS_BUCKETS_HEADING_USER'),
	'created_on' => JText::_('COM_ATS_BUCKETS_HEADING_CREATED'),
	'modified_on' => JText::_('COM_ATS_BUCKETS_HEADING_MODIFIED'),
	'title' => JText::_('COM_ATS_BUCKETS_HEADING_TITLE'),
	'state' => JText::_('JSTATUS'),
	'status' => JText::_('COM_ATS_BUCKETS_HEADING_STATUS'),
);


?>

<?php if (version_compare(JVERSION, '3.0', 'ge')): ?>
	<script type="text/javascript">
		Joomla.orderTable = function() {
			table = document.getElementById("sortTable");
			direction = document.getElementById("directionTable");
			order = table.options[table.selectedIndex].value;
			if (order != '$order')
			{
				dirn = 'asc';
			}
			else {
				dirn = direction.options[direction.selectedIndex].value;
			}
			Joomla.tableOrdering(order, dirn);
		}
	</script>
<?php endif; ?>

<form action="<?php echo JRoute::_('index.php?option=com_ats&view=buckets'); ?>" method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="task" value="<?php echo $task?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists->order; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists->order_Dir; ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	<?php echo $otherFields;?>

	<?php if(version_compare(JVERSION, '3.0', 'gt')): ?>
		<div id="filter-bar" class="btn-toolbar">
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC') ?></label>
				<?php echo $this->getModel()->getPagination()->getLimitBox(); ?>
			</div>
			<?php
			$asc_sel	= ($this->getLists()->order_Dir == 'asc') ? 'selected="selected"' : '';
			$desc_sel	= ($this->getLists()->order_Dir == 'desc') ? 'selected="selected"' : '';
			?>
			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC') ?></label>
				<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC') ?></option>
					<option value="asc" <?php echo $asc_sel ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING') ?></option>
					<option value="desc" <?php echo $desc_sel ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING') ?></option>
				</select>
			</div>
			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY') ?></label>
				<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JGLOBAL_SORT_BY') ?></option>
					<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $this->getLists()->order) ?>
				</select>
			</div>
		</div>
		<div class="clearfix"> </div>
	<?php endif; ?>

	<?php
		// Sadly I can't use the toolbar since I'm using tmpl=component which hides the top area ;(
		if($this->input->getCmd('task') == 'choosebucket'):
	?>
	<?php endif?>
	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $this->lists->order_Dir, $this->lists->order, $task) ?>
				</th>
				<th width="15%" class="nowrap">
					<?php echo JHTML::_('grid.sort', 'COM_ATS_BUCKETS_HEADING_USER', 'user_username', $this->lists->order_Dir, $this->lists->order, $task) ?>
				</th>
				<th width="4%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_ATS_BUCKETS_HEADING_CREATED', 'created_on', $this->lists->order_Dir, $this->lists->order, $task) ?>
				</th>
				<th width="4%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_ATS_BUCKETS_HEADING_MODIFIED', 'modified_on', $this->lists->order_Dir, $this->lists->order, $task) ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_ATS_BUCKETS_HEADING_TITLE', 'title', $this->lists->order_Dir, $this->lists->order, $task) ?>
				</th>
			<?php if(!$hidePublish):?>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'state', $this->lists->order_Dir, $this->lists->order, $task) ?>
				</th>
			<?php endif;?>
			<?php if(!$hideStatus):?>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_ATS_BUCKETS_HEADING_STATUS', 'status', $this->lists->order_Dir, $this->lists->order, $task) ?>
				</th>
			<?php endif;?>
			</tr>
			<tr>
				<td></td>
				<td>
					<!-- TODO: ID filtering -->
				</td>
				<td>
					<input type="text" class="input-medium" name="username" id="username"
						   class="input-small"
							value="<?php echo $this->escape($this->getModel()->getState('username','')); ?>"
							title="<?php echo JText::_('COM_ATS_BUCKETS_HEADING_USER'); ?>"
							placeholder="<?php echo JText::_('COM_ATS_BUCKETS_HEADING_USER'); ?>"
						/>
					<nobr>
					<button class="btn btn-mini" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button class="btn btn-mini" type="button" onclick="document.id('username').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
					</nobr>
				</td>
				<td></td>
				<td></td>
				<td>
					<input type="text" name="search" id="search"
						value="<?php echo $this->escape($this->getModel()->getState('search',''));?>"
						class="input-large" onchange="document.adminForm.submit();"
						placeholder="<?php echo JText::_('COM_ATS_BUCKETS_HEADING_TITLE'); ?>"
						/>
					<nobr>
					<button class="btn btn-mini" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button class="btn btn-mini" type="button" onclick="document.id('search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
					</nobr>
				</td>
			<?php if(!$hidePublish):?>
				<td>
					<?php echo AtsHelperSelect::published($this->getModel()->getState('enabled',''), 'enabled', array('onchange'=>"this.form.submit()",'class'=>'input-small')) ?>
				</td>
			<?php endif; ?>
			<?php if(!$hideStatus):?>
				<td>
					<?php echo AtsHelperSelect::bucketstatuses($this->getModel()->getState('status',''), 'status', array('onchange'=>"this.form.submit()",'class'=>'input-small')) ?>
				</td>
			<?php endif;?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="20">
					<?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if($count = count($this->items)): ?>
		<?php $i = -1 ?>
		<?php foreach ($this->items as $i => $item) :
			$i++;
			$item->published = $item->enabled;

			$this->loadHelper('avatar');
			$avatarURL = AtsHelperAvatar::getAvatarURL($item->user_email, 64);
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->ats_bucket_id); ?>
				</td>
				<td class="center">
					<?php echo $item->ats_bucket_id; ?>
				</td>
				<td>
					<?php if($avatarURL): ?>
						<img src="<?php echo $avatarURL?>" align="left" class="gravatar" />
					<?php endif?>

					<strong><?php echo $item->user_username ?></strong> [ <?php echo $item->created_by; ?> ]
					<p class="smallsub">
					<?php echo $item->user_name ?><br/>
					<?php echo $item->user_email ?>
					</p>
				</td>
				<td  class="nowrap">
					<?php echo JHtml::_('date',$item->created_on, JText::_('DATE_FORMAT_LC4')); ?>
				</td>
				<td  class="nowrap">
					<?php if($item->modified_on == '0000-00-00 00:00:00'): ?>
					&mdash;
					<?php else: ?>
					<?php echo JHtml::_('date',$item->modified_on, JText::_('DATE_FORMAT_LC4')); ?>
					<?php endif; ?>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_ats&view=bucket&task=edit&id='.(int) $item->ats_bucket_id); ?>">
						<?php echo $this->escape($item->title); ?>
					</a>
				</td>
			<?php if(!$hidePublish):?>
				<td class="center">
					<?php echo JHTML::_('grid.published', $item, $i); ?>
				</td>
			<?php endif;?>
			<?php if(!$hideStatus):?>
				<td class="center">
					<span class="ats-ticket-status-<?php echo $item->status?>">
						<?php echo JText::_('COM_ATS_BUCKETS_STATUS_'.$item->status);?>
					</span>
				</td>
			<?php endif;?>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td colspan="20">
					<?php echo  JText::_('COM_ATS_COMMON_NORECORDS') ?>
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</form>

