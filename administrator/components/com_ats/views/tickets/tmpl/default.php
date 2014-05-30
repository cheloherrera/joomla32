<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.framework');
JHtml::_('behavior.modal');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
if (version_compare(JVERSION, '3.0', 'gt'))
{
	JHtml::_('dropdown.init');
	JHtml::_('formbehavior.chosen', 'select');
}

F0FTemplateUtils::addCSS('media://com_ats/css/backend.css?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/adm_tickets.js?'.ATS_VERSIONHASH);

$this->loadHelper('avatar');
$this->loadHelper('html');
$this->loadHelper('select');

$throbber   = F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif');
$user		= JFactory::getUser();
$userId		= $user->get('id');
$returnURL  = base64_encode('index.php?option=com_ats&view=tickets&limit='.$this->input->getInt('limit').'&limitstart='.$this->input->getInt('limistart'));
$throbber	= F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif');

$sortFields = array(
	'id'				=> JText::_('JGRID_HEADING_ID'),
	'user_username'		=> JText::_('COM_ATS_TICKETS_HEADING_USER'),
	'created_on'		=> JText::_('COM_ATS_TICKETS_HEADING_CREATED'),
	'modified_on'		=> JText::_('COM_ATS_TICKETS_HEADING_MODIFIED'),
	'title' 			=> JText::_('COM_ATS_TICKETS_HEADING_TITLE'),
	'timespent' 		=> JText::_('COM_ATS_TICKETS_HEADING_TIMESPENT'),
	'state' 			=> JText::_('JSTATUS'),
	'status' 			=> JText::_('COM_ATS_TICKETS_HEADING_STATUS'),
	'public' 			=> JText::_('COM_ATS_TICKETS_HEADING_PUBLIC'),
	'category_title'	=> JText::_('JCATEGORY'),
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

<form action="<?php echo JRoute::_('index.php?option=com_ats&view=tickets'); ?>" method="post" name="adminForm"
	  id="adminForm" xmlns="http://www.w3.org/1999/html">
	<input type="hidden" name="task" value="browse" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists->order; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists->order_Dir; ?>" />
	<input type="hidden" id="token" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
	<input type="hidden" id="user" value="<?php echo $userId?>" />

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

	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<th width="15%" class="nowrap">
					<?php echo JHTML::_('grid.sort', 'COM_ATS_TICKETS_HEADING_USER', 'user_username', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<th width="4%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_ATS_TICKETS_HEADING_CREATED', 'created_on', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<th width="4%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_ATS_TICKETS_HEADING_MODIFIED', 'modified_on', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ATS_TICKETS_HEADING_TITLE', 'title', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<?php if (ATS_PRO): ?>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ATS_TICKETS_HEADING_TIMESPENT', 'timespent', $this->lists->order_Dir, $this->lists->order, 'timespent') ?>
				</th>
				<?php endif; ?>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'state', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_ATS_TICKETS_HEADING_STATUS', 'status', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_ATS_TICKETS_HEADING_PUBLIC', 'public', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category_title', $this->lists->order_Dir, $this->lists->order, 'browse') ?>
				</th>
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
							title="<?php echo JText::_('COM_ATS_TICKETS_HEADING_USER'); ?>"
							placeholder="<?php echo JText::_('COM_ATS_TICKETS_HEADING_USER'); ?>"
						/>
					<nobr>
					<button class="btn btn-mini" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button class="btn btn-mini" type="button" onclick="document.id('username').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
					</nobr>
				</td>
				<td colspan="2">
					<input type="text" class="input-medium" name="ass_username" id="ass_username"
							value="<?php echo $this->escape($this->getModel()->getState('ass_username','')); ?>"
							title="<?php echo JText::_('COM_ATS_TICKETS_ASSIGNED_TO'); ?>"
							placeholder="<?php echo JText::_('COM_ATS_TICKETS_ASSIGNED_TO'); ?>"
						/>
					<nobr>
					<button class="btn btn-mini" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button class="btn btn-mini" type="button" onclick="document.id('ass_username').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
					</nobr>
				</td>
				<td>
					<input type="text" name="search" id="search"
						value="<?php echo $this->escape($this->getModel()->getState('search',''));?>"
						class="input-large" onchange="document.adminForm.submit();"
						placeholder="<?php echo JText::_('COM_ATS_TICKETS_HEADING_TITLE'); ?>"
						/>
					<nobr>
					<button class="btn btn-mini" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
					<button class="btn btn-mini" type="button" onclick="document.id('search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
					</nobr>
				</td>
				<?php if (ATS_PRO): ?>
				<td></td>
				<?php endif; ?>
				<td>
					<?php echo AtsHelperSelect::published($this->getModel()->getState('enabled',''), 'enabled', array('onchange'=>"this.form.submit()",'class'=>'input-small')) ?>
				</td>
				<td>
					<?php echo AtsHelperSelect::ticketstatuses($this->getModel()->getState('status',''), 'status', array('onchange'=>"this.form.submit()",'class'=>'input-small'), 'atsstatus') ?>
				</td>
				<td>
					<?php echo AtsHelperSelect::publicstate($this->getModel()->getState('public',''), 'public', array('onchange'=>"this.form.submit()",'class'=>'input-small')) ?>
				</td>
				<td>
					<select name="category" class="input-medium" onchange="this.form.submit()">
						<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
						<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_ats'), 'value', 'text', $this->getModel()->getState('category',''));?>
					</select>
				</td>
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
			$item->cat_link = JRoute::_('index.php?option=com_categories&extension=com_ats&task=edit&type=other&cid[]='. $item->catid);
			$canCreate	 = $user->authorise('core.create',		'com_ats.category.'.$item->catid);
			$canEdit	 = $user->authorise('core.edit',			'com_ats.category.'.$item->catid);
			$canChange	 = $user->authorise('core.edit.state',	'com_ats.category.'.$item->catid);
			$assigned_class = $item->assigned_to ? 'badge-info' : '';
			$assignedToMe = $item->assigned_to == $userId;
			$assigned_to  = $item->assigned_name ? $item->assigned_name : JText::_('COM_ATS_TICKETS_UNASSIGNED');
			$adminActionsURL = 'index.php?option=com_ats&view=ticket&id='.$item->ats_ticket_id.'&returnurl='.$returnURL.'&'.JFactory::getSession()->getFormToken().'=1';

			$item->published = $item->enabled;

			$avatarURL = AtsHelperAvatar::getAvatarURL($item->user_email, 64);
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->ats_ticket_id); ?>
				</td>
				<td class="center">
					<?php if ($item->priority > 5): ?>
					<span class="pull-left badge badge-info" style="margin-right: 2px">
						<i class="icon-arrow-down icon-white"></i>
					</span>
					<?php elseif (($item->priority > 0) && ($item->priority < 5)): ?>
					<span class="pull-left badge badge-important" style="margin-right: 2px">
						<i class="icon-arrow-up icon-white"></i>
					</span>
					<?php endif; ?>

					<?php echo $item->ats_ticket_id; ?>
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
					<?php if (ATS_PRO): ?>
					<span class="badge assigned_to <?php echo $assigned_class?> pull-left"><?php echo $assigned_to?></span>
					<?php endif; ?>
					<?php if ($canEdit && ATS_PRO) : ?>
						<?php echo AtsHelperHtml::buildManagerdd(null, array('div' => 'assignto pull-right', 'a' => 'btn-mini'), $item->catid)?>
						<span class="loading btn-small" style="display:none">
							<i class="icon-ok"></i>
							<i class="icon-warning-sign"></i>
							<img src="<?php echo $throbber ?>" />
						</span>
						<input type="hidden" class="ticket_id" value="<?php echo $item->ats_ticket_id ?>" />
						<br/>
						<a href="<?php echo JRoute::_('index.php?option=com_ats&view=ticket&task=edit&id='.(int) $item->ats_ticket_id); ?>">
							<?php echo $this->escape($item->title); ?>
						</a>
					<?php else : ?>
						<?php echo $this->escape($item->title); ?>
					<?php endif; ?>

				</td>
				<?php if (ATS_PRO): ?>
				<td  class="nowrap">
					<?php echo $item->timespent > 0 ? sprintf('%.1f', $item->timespent) : '&mdash;'; ?>
				</td>
				<?php endif; ?>
				<td class="center">
					<?php echo JHTML::_('grid.published', $item, $i); ?>
				</td>
				<td class="center">
					<?php echo AtsHelperHtml::decodeStatus($item->status, true)?>
					<?php echo AtsHelperHtml::createStatusDropdown(array('div_style' => 'pull-right', 'btn_style' => '', 'title' => ''))?>
					<img src="<?php echo $throbber?>" style="display:none" />
				</td>
				<td class="center public">
					<?php echo JHtml::_('jgrid.published', $item->public, $i, 'public_', $canChange);?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->category_title); ?>
				</td>
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
<input type="hidden" id="warnmessage" value="<?php echo JText::_('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')?>" />
