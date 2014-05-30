<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

$this->loadHelper('filter');
$this->loadHelper('signature');

if(!$item->enabled || !JFactory::getUser()->authorise('core.manage', 'com_ats')) return;

// The user who created this post
if($item->created_by == -1) {
	$postUser = clone JFactory::getUser();
	$postUser->username = 'system';
	$postUser->email = 'noreply@example.com';
	$postUser->name = JText::_('COM_ATS_CLI_SYSTEMUSERLABEL');
} else {
	$postUser = JFactory::getUser($item->created_by);
}
$user = JFactory::getUser();

// Get the return URL to point back to ourselves
$permalink = JFactory::getURI();
$permalink->setFragment('mn'.$item->ats_managernote_id);

// Get the token
$token = JFactory::getSession()->getFormToken().'=1';

?>
<div class="ats-post ats-post-status-<?php echo $item->enabled ? 'published' : 'unpublished' ?>" id="mn<?php echo $item->ats_managernote_id ?>">
	<div class="ats-post-header">
		<span class="ats-post-header-date">
			<a href="<?php echo $permalink ?>">
				<?php echo $postUser->name ?> (<?php echo $postUser->username ?>)
				&bull;
				<?php echo AtsHelperFormat::date($item->created_on); ?>
			</a>
		</span>
	</div>
	<div class="ats-post-body">
		<div class="ats-post-content">
			<div class="ats-post-content-html">
				<?php if(empty($item->note_html)): ?>
				<?php echo AtsHelperBbcode::parseBBCode($item->note) ?>
				<?php else: ?>
				<?php echo $item->note_html; ?>
				<?php endif; ?>
			</div>
			<div class="ats-post-content-signature">
				<?php echo nl2br(AtsHelperSignature::getSignature($postUser)) ?>
			</div>
		</div>
	</div>
	<div class="ats-post-footer">
		<?php if(($item->modified_on != '0000-00-00 00:00:00') && !empty($item->modified_on)): ?>
		<div class="ats-post-edits">
			<?php echo JText::sprintf('COM_ATS_TICKETS_MSG_EDITEDBYON', JFactory::getUser($item->modified_by)->username, AtsHelperFormat::date($item->modified_on) ) ?>
		</div>
		<?php endif; ?>
		<div class="ats-post-buttons">
			<?php if($user->authorise('core.edit.state','com_ats') || ($user->authorise('core.edit.own','com_ats') && ($user->id == $item->id)) ): ?>
			<?php if($item->enabled): ?>
			<a class="btn" href="index.php?option=com_ats&view=managernote&task=unpublish&id=<?php echo $item->ats_managernote_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
				<i class="icon-lock"></i>
				<?php echo JText::_('COM_ATS_COMMON_UNPUBLISH') ?>
			</a>
			<?php else: ?>
			<a class="btn" href="index.php?option=com_ats&view=managernote&task=publish&id=<?php echo $item->ats_managernote_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
				<i class="icon-lock"></i>
				<?php echo JText::_('COM_ATS_COMMON_PUBLISH') ?>
			</a>
			<?php endif; ?>
			<?php endif; ?>
			
			<?php if($user->authorise('core.manage','com_ats') || $user->authorise('core.edit','com_ats') || ($user->authorise('core.edit.own','com_ats') && ($user->id == $item->id)) ): ?>
			<a class="btn" href="index.php?option=com_ats&view=managernote&task=edit&id=<?php echo $item->ats_managernote_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>">
				<i class="icon-pencil"></i>
				<?php echo JText::_('COM_ATS_COMMON_EDIT') ?>
			</a>
			<?php endif ?>
			
			<?php if(JFactory::getUser()->authorise('core.delete','com_ats')): ?>
			<a class="btn btn-danger" href="index.php?option=com_ats&view=managernote&task=remove&id=<?php echo $item->ats_managernote_id ?>&returnurl=<?php echo $returnURL ?>&<?php echo $token ?>" onclick="return confirm('<?php echo JText::_('COM_ATS_POSTS_MSG_DELETEPROMPT') ?>')">
				<i class="icon-trash icon-white"></i>
				<?php echo JText::_('COM_ATS_COMMON_DELETE') ?>
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>