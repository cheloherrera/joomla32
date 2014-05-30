<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

static $subsPerUser = array();

JLoader::import('joomla.filesystem.file');

$this->loadHelper('avatar');
$avatarURL = AtsHelperAvatar::getAvatarURL($user, 64);

// Get the list of subscriptions for this user
$this->loadHelper('subscriptions');
if(!array_key_exists($user->username, $subsPerUser)) {
	$subsPerUser[$user->username] = AtsHelperSubscriptions::getSubscriptionsList($user);
}

?>
<?php if($avatarURL): ?>
<div class="ats-post-userinfo-avatar">
	<img src="<?php echo $avatarURL?>" />
</div>
<?php endif; ?>
<div class="ats-post-userinfo-username">
	<?php echo $user->username ?>
</div>
<div class="ats-post-userinfo-badge">
	<?php foreach($user->groups as $groupName => $groupID):
	$basePath = JPATH_ROOT.'/media/com_ats/groups/';
	$altPath = JPATH_BASE.'/templates/'.JFactory::getApplication()->getTemplate().'/media/com_ats/groups/';
	$alias = AtsHelperFilter::toSlug($groupName);
	$img = null;
	if(JFile::exists($altPath.$alias.'.png') || JFile::exists($basePath.$alias.'.png')) {
		$img = F0FTemplateUtils::parsePath('media://com_ats/groups/'.$alias.'.png');
	} elseif(JFile::exists($altPath.$alias.'.jpg') || JFile::exists($basePath.$alias.'.jpg')) {
		$img = F0FTemplateUtils::parsePath('media://com_ats/groups/'.$alias.'.jpg');
	}

	if(!is_null($img)):
	?>
	<img src="<?php echo $img?>" border="0" />
	<?php
	endif;
	endforeach; ?>
</div>
<?php if(AtsHelperSubscriptions::hasSubscriptionsComponent() && count($subsPerUser[$user->username]->active)): ?>
<div class="ats-post-userinfo-subscriptions">
	<?php echo implode(', ',$subsPerUser[$user->username]->active) ?>
</div>
<?php endif; ?>
<?php
    // User tags
    if($this->isManager)
    {
        $tags = F0FModel::getTmpInstance('Usertags', 'AtsModel')->loadTagsByUser($user->id);

        foreach($tags as $tagid)
        {
            $tag = F0FModel::getTmpInstance('Usertags', 'AtsModel')->getItem($tagid);
            ?>
            <span class="label label-info atsTooltip" data-toggle="tooltip" title="<?php echo $tag->descr?>">
                <?php echo $tag->title ?>
            </span>
            <?php
        }
    }
?>