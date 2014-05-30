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
JLoader::import('joomla.plugin.helper');
JPluginHelper::importPlugin('ats');

F0FTemplateUtils::addCSS('media://com_ats/css/backend.css?'.ATS_VERSIONHASH);
JFactory::getDocument()->addScriptDeclaration("function addToValidationFetchQueue(myfunction){}");
JFactory::getDocument()->addScriptDeclaration("function addToValidationQueue(myfunction){}");

$this->loadHelper('credits');
$this->loadHelper('select');
$this->loadHelper('format');

$user	   = JFactory::getUser();
?>

<div id="ats-ticket-toprow">

<form action="index.php" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
	<input type="hidden" name="option" value="com_ats" />
	<input type="hidden" name="view" value="ticket" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="ats_ticket_id" value="<?php echo $this->item->ats_ticket_id ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

	<div class="row-fluid">
		<div class="span6">
			<h3><?php echo JText::_('COM_ATS_TICKETS_LEGEND_TICKETPARAMS'); ?></h3>

			<table class="table table-striped table-boxed">
				<tr>
					<td colspan="2">
						<h4><?php echo JText::sprintf('COM_ATS_TICKETS_HEADING_ID', $this->item->ats_ticket_id) ?></h4>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_TITLE'); ?>
					</td>
					<td class="ats-infotable-data">
						<input type="text" name="title" class="ats-title" value="<?php echo $this->escape($this->item->title) ?>" />
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_SLUG'); ?>
					</td>
					<td class="ats-infotable-data">
						<input type="text" name="alias" class="ats-slug" value="<?php echo $this->escape($this->item->alias) ?>" />
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_CATEGORY'); ?>
					</td>
					<td class="ats-infotable-data">
						<select name="catid">
							<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
							<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_ats'), 'value', 'text', $this->item->catid);?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_STATUS'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperSelect::ticketstatuses($this->item->status, 'status', array(), 'atsstatus') ?>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_PUBLIC'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperSelect::publicstate($this->item->public, 'public') ?>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKET_PRIORITY'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperSelect::priorities('priority', $this->item->priority) ?>
					</td>
				</tr>
				<?php if (ATS_PRO): ?>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_ASSIGN_TO'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperSelect::getManagers($this->item->assigned_to, 'assigned_to', array(), $this->item->catid) ?>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_BUCKET'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperSelect::buckets($this->item->ats_bucket_id) ?>
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_ORIGIN'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo $this->item->origin ? JText::_('COM_ATS_TICKETS_ORIGIN_'.$this->item->origin) : JText::_('COM_ATS_TICKETS_ORIGIN_WEB') ?>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_CREATED'); ?>
					</td>
					<td class="ats-infotable-data">
						<?php echo AtsHelperFormat::date($this->item->created_on) ?>
					</td>
				</tr>
				<tr>
					<td class="ats-infotable-label">
						<?php echo JText::_('COM_ATS_TICKETS_HEADING_MODIFIED'); ?>
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

		<div class="span6">
			<h3><?php echo JText::_('COM_ATS_TICKETS_LEGEND_USERINFO'); ?></h3>
<?php

			echo $this->loadAnyTemplate('admin:com_ats/ticket/form_userinfo');

			$app       = JFactory::getApplication();
			$jResponse = array();

			// I have to display custom fields only on edit mode, since I don't have the catid while creating it
			// (in frontend I'm ok since I can get it from menu params)
			if($this->item->ats_ticket_id)
			{
				// I use the array + array syntax so empty values won't replace valid ones
				$args = $this->item->getProperties() + $this->cache;
				unset($args['input']);

				$jResponse = $app->triggerEvent('onTicketFormRenderPerCatFields', array($args));
			}

			if(is_array($jResponse) && !empty($jResponse))
			{?>
				<h3><?php echo JText::_('COM_ATS_TITLE_CUSTOMFIELDS')?></h3>
			<?php
				foreach($jResponse as $customFields):
					if(is_array($customFields) && !empty($customFields)) foreach($customFields as $field):
						if(array_key_exists('isValid', $field)) {
							$customField_class = $field['isValid'] ? (array_key_exists('validLabel', $field) ? 'success' : '') : 'error';
						} else {
							$customField_class = '';
						}
				?>
					<div class="control-group <?php echo $customField_class ?>">
						<label for="<?php echo $field['id']?>" class="control-label">
							<?php echo $field['label']?>
						</label>
						<div class="controls">
							<?php echo $field['elementHTML']?>
							<?php if(array_key_exists('validLabel', $field)):?>
							<span id="<?php echo $field['id']?>_valid" class="help-inline"
								  style="<?php if(!$field['isValid']):?>display:none<?php endif?>">
									  <?php echo $field['validLabel']?>
							</span>
							<?php endif;?>
							<?php if(array_key_exists('invalidLabel', $field)):?>
							<span id="<?php echo $field['id']?>_invalid" class="help-inline"
								  style="<?php if($field['isValid']):?>display:none<?php endif?>">
									  <?php echo $field['invalidLabel']?>
							</span>
							<?php endif;?>
						</div>
					</div>

				<?php
						endforeach;
					endforeach;
				}
				?>
			<table>
				<tr>
					<td></td>
				</tr>
			</table>
		</div>
	</div>
</form>

</div>

<?php // Load the post form only if we have a ticket (let's keep it simple)?>
<?php if($this->item->ats_ticket_id):?>
<div class="row-fluid">
	<div class="span12">
<?php if($user->authorise('core.manage','com_ats')):?>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#ats_ticket_backend_conversation" data-toggle="tab">
						<?php echo JText::_('COM_ATS_TICKETS_LEGEND_CONVO') ?>
					</a>
				</li>
				<li>
					<a href="#ats_ticket_backend_notes" data-toggle="tab">
						<?php echo JText::_('COM_ATS_TICKETS_LEGEND_MANAGERNOTES') ?>
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="ats_ticket_backend_conversation">
<?php endif; ?>
					<h3><?php echo JText::_('COM_ATS_TICKETS_LEGEND_CONVO'); ?></h3>
					<?php
					if($this->item->ats_ticket_id)
					{
						F0FDispatcher::getTmpInstance('com_ats', 'posts', array('input'=>array(
							'ticket'			=> $this->item->ats_ticket_id,
							'task'				=> 'browse',
							'layout'			=> 'threaded',
							'limit'				=> 0,
							'limitstart'		=> 0,
							'render_toolbar'	=> 0,
							'savestate'			=> 0,
						)))->dispatch();
					}
					?>

					<div class="ats-clear"></div>

					<?php if($this->item->status != 'C'): ?>
					<h3 class="ats-ticket-reply-header"><?php echo JText::_('COM_ATS_POSTS_HEADING_REPLYAREA')?></h3>

					<?php // If the ticket is already assigned to another manager, warn the user ?>
					<?php if($this->item->assigned_to && $this->item->assigned_to != $user->id):?>
						<div class="alert alert-danger">
							<?php echo JText::sprintf('COM_ATS_TICKET_ALREADY_ASSIGNED_WARN', JFactory::getUser($this->item->assigned_to)->name)?>
						</div>
					<?php endif;?>

					<?php echo $this->loadAnyTemplate('admin:com_ats/post/form',array(
						'ats_ticket_id'	=> $this->item->ats_ticket_id,
						'returnURL'		=> base64_encode(JURI::getInstance()->toString()),
						'item'			=> null,
						'savestate'		=> 0,
					));?>
					<?php endif; ?>
<?php if($user->authorise('core.manage','com_ats')):?>
				</div>
				<div class="tab-pane" id="ats_ticket_backend_notes">
					<h3><?php echo JText::_('COM_ATS_TICKETS_LEGEND_MANAGERNOTES'); ?></h3>
					<?php
						if($this->item->ats_ticket_id)
						{
							F0FDispatcher::getTmpInstance('com_ats', 'managernotes', array('input'=>array(
								'ticket'			=> $this->item->ats_ticket_id,
								'task'				=> 'browse',
								'layout'			=> 'threaded',
								'limit'				=> 0,
								'limitstart'		=> 0,
								'render_toolbar'	=> 0,
								'savestate'			=> 0,
							)))->dispatch();
						}
					?>

					<h3 class="ats-ticket-reply-header"><?php echo JText::_('COM_ATS_POSTS_HEADING_MANAGERNOTEAREA')?></h3>
					<?php echo $this->loadAnyTemplate('admin:com_ats/managernote/form',array(
						'ats_ticket_id'	=> $this->item->ats_ticket_id,
						'returnURL'		=> base64_encode(JURI::getInstance()->toString()),
						'item'			=> null,
						'savestate'		=> 0,
					));?>
				</div>
			</div>
		</div>
<?php endif; ?>
	</div>
</div>
<?php endif?>

<?php if($user->authorise('core.manage','com_ats')): ?>
<!--
<div class="row-fluid">
	<div class="span12">
		<h3><?php echo JText::_('COM_ATS_TICKETS_LEGEND_MANAGEMENT')?></h3>

		TODO: Ticket buttons (move, delete)
	</div>
</div>
-->
<?php endif ?>