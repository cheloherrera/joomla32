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
$this->loadHelper('select');

// Load the required CSS
F0FTemplateUtils::addCSS('media://com_ats/css/frontend.css?'.ATS_VERSIONHASH);

$model  = $this->getModel();
$itemId = $this->input->getInt('Itemid',0);

if($itemId != 0)
{
	$actionURL = 'index.php?Itemid='.$itemId;
}
else
{
	$actionURL = 'index.php';
}

$js = <<<JS
if(typeof(akeeba) == 'undefined') {
	var akeeba = {};
}
if(typeof(akeeba.jQuery) == 'undefined') {
	akeeba.jQuery = jQuery.noConflict();
}

akeeba.jQuery(document).ready(function($){
    $('#reset').click(function(){
        $('#title').val('');
        $('#category').val('');
    });

    $('#category').change(function(){
        $('#adminForm').submit();
    });
})
JS;

AkeebaStrapper::addJSdef($js);
?>
<div class="akeeba-bootstrap">
<?php echo AtsHelperModules::loadposition('ats-top'); ?>
<?php echo AtsHelperModules::loadposition('ats-mytickets-top'); ?>

<?php if ($this->pageparams->get('show_page_heading', 1)) : ?>
	<h1>
		<?php echo JText::_('COM_ATS_MY_TITLE'); ?>
	</h1>
<?php endif; ?>
<form id="adminForm" name="adminForm" action="<?php echo $actionURL ?>" method="post">
    <input type="hidden" name="option" value="com_ats" />
    <input type="hidden" name="view" value="my" />

    <div>
        <div class="pull-left">
            <input type="text" name="title" id="title" value="<?php echo $model->getState('title')?>" placeholder="<?php echo JText::_('COM_ATS_TICKETS_HEADING_TITLE')?>"/>
            <button class="btn btn-mini"><?php echo JText::_('COM_ATS_COMMON_SEARCH')?></button>
            <button class="btn btn-mini" id="reset"><?php echo JText::_('COM_ATS_COMMON_RESET')?></button>
        </div>
        <div class="pull-right">
            <?php echo AtsHelperSelect::getCategories($model->getState('category'))?>
        </div>
    </div>

    <div class="clearfix"></div>

<?php if(empty($this->items)): ?>
<?php echo AtsHelperModules::loadposition('ats-mytickets-none-top'); ?>
<p>
	<?php echo JText::_('COM_ATS_MYTICKETS_MSG_NOTICKETS') ?>
</p>
<?php echo AtsHelperModules::loadposition('ats-mytickets-none-bottom'); ?>

<?php else: ?>
    <table class="table table-striped">
        <thead>
    <?php foreach($this->items as $ticket):?>
    <?php $this->ticket = $ticket; echo $this->loadAnyTemplate('site:com_ats/my/default_ticket')  ?>
    <?php endforeach; ?>
        </thead>
    </table>

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
<?php endif; ?>
</form>

<?php echo AtsHelperModules::loadposition('ats-mytickets-bottom'); ?>
<?php echo AtsHelperModules::loadposition('ats-bottom'); ?>
</div>