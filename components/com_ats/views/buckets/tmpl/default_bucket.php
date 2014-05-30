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
 * $displayCbx	Should I display bucket checkbox?
 * $hideLinks	Should I hide bucket links?
 */
// Prevent warnings with param variables
if(!isset($displayCbx))	$displayCbx = 0;
if(!isset($hideLinks))	$hideLinks  = 0;

$bucketURL = JRoute::_('index.php?option=com_ats&view=bucket&id='.$this->bucket->ats_bucket_id);

$createdOn = new JDate($this->bucket->created_on);
$createdOn = $createdOn->format('Y-m-d H:i T', true);
$createdBy = JFactory::getUser($this->bucket->created_by)->username;

$modifiedOn = new JDate($this->bucket->modified_on);
if($modifiedOn->toUnix() > 90000) {
	$lastOn = $modifiedOn->format('Y-m-d H:i T', true);
	$lastBy = JFactory::getUser($this->bucket->modified_by)->username;
} else {
	$lastOn = $createdOn; $lastBy = $createdBy;
}

$mine = JFactory::getUser()->id == $this->bucket->created_by;

switch($this->bucket->status) {
	case 'O':
	default:
		$status_class = 'label-important';
		break;

	case 'C':
		$status_class = 'label-success';
		break;

	case 'P':
		$status_class = 'label-warning';
		break;
}

?>
<tr>
<?php if($displayCbx):?>
	<td style="vertical-align:middle;text-align:center">
		<?php // I have to remove any onclick event since there is no adminForm form... ?>
		<?php echo preg_replace('#onclick=".*?"#', '', JHtml::_('grid.id', $this->i, $this->bucket->ats_bucket_id)); ?>
	</td>
<?php endif;?>
	<td>
		<span class="label <?php echo $status_class?> pull-right">
			<?php echo JText::_('COM_ATS_BUCKETS_STATUS_'.strtoupper($this->bucket->status)) ?>
		</span>
		<?php if($mine): ?>
		<span class="pull-left badge badge-info" style="margin-right: 2px">
			<i class="icon-user icon-white"></i>
		</span>
		<?php endif; ?>
		<h4>
		<?php if($hideLinks):?>
			#<?php echo $this->bucket->ats_bucket_id.':'.$this->escape($this->bucket->title) ?>
		<?php else:?>
			<a href="<?php echo $bucketURL ?>">
				#<?php echo $this->bucket->ats_bucket_id.':'.$this->escape($this->bucket->title) ?>
			</a>
		<?php endif;?>
		</h4>

		<span class="small pull-right">
			<?php echo JText::sprintf('COM_ATS_BUCKETS_MSG_LASTPOST', $lastBy, $lastOn) ?>
		</span>
		<span class="small pull-left">
			<?php echo JText::sprintf('COM_ATS_BUCKETS_MSG_CREATED', $createdOn, $createdBy) ?>
		</span>
	</td>
</tr>