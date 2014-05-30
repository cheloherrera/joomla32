<?php
/**
 * @package   AdminTools
 * @copyright Copyright (c)2010-2014 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die;

$lang = JFactory::getLanguage();
$option = 'com_admintools';

if (version_compare(JVERSION, '3.0', 'ge'))
{
	JHTML::_('behavior.framework');
	JHtml::_('formbehavior.chosen');
}
else
{
	JHTML::_('behavior.mootools');
	AkeebaStrapper::addCSSfile('media://com_admintools/css/chosen.min.css');
	AkeebaStrapper::addJSfile('media://com_admintools/js/chosen.jquery.min.js');

	$js = <<<JS
akeeba.jQuery(document).ready(function(){
    akeeba.jQuery('.advancedSelect').chosen({
        disable_search_threshold : 10,
        allow_single_deselect : true,
        width: '300px'
    });
})
JS;
	AkeebaStrapper::addJSdef($js);
}

$this->loadHelper('select');

$js = <<<JS
akeeba.jQuery(document).ready(function(){
    akeeba.jQuery('#wafTabs a:first').tab('show');
});
JS;

AkeebaStrapper::addJSdef($js);
?>
<form name="adminForm" id="adminForm" action="index.php" method="post" class="form form-horizontal form-horizontal-wide">
    <input type="hidden" name="option" value="com_admintools"/>
    <input type="hidden" name="view" value="wafconfig"/>
    <input type="hidden" name="task" value="save"/>
    <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken(); ?>" value="1"/>

	<?php if (!$this->longConfig): ?>
    <ul class="nav nav-tabs" id="wafTabs">
        <li><a href="#basic" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_BASICSETTINGS') ?></a></li>
        <li><a href="#activeFiltering" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_ACTIVEFILTERING') ?></a></li>
        <li><a href="#jhardening" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_JHARDENING') ?></a></li>
        <li><a href="#fingerprinting" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_FINGERPRINTING') ?></a></li>
        <li><a href="#honeypot" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_PROJECTHONEYPOT') ?></a></li>
        <li><a href="#exceptions" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_EXCEPTIONS') ?></a></li>
        <li><a href="#tsr" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_TSR') ?></a></li>
        <li><a href="#loggingReporting" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_LOGGINGANDREPORTING') ?></a></li>
        <li><a href="#custommessage" data-toggle="tab"><?php echo JText::_('ATOOLS_LBL_WAF_CUSTOMMESSAGE_HEADER') ?></a></li>
    </ul>
	<?php endif; ?>

	<?php if (!$this->longConfig): ?>
	<div class="tab-content">
	<?php endif; ?>

        <div class="tab-pane" id="basic">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_BASICSETTINGS') ?></h3>
			<?php endif; ?>

            <div class="control-group">
                <label class="control-label" for="ipwl"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_IPWL'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('ipwl', array(), $this->wafconfig['ipwl']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="ipbl"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_IPBL'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('ipbl', array(), $this->wafconfig['ipbl']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="adminpw"
                       title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_ADMINPW_TIP'); ?>"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_ADMINPW'); ?></label>

                <div class="controls">
                    <input type="text" size="20" name="adminpw" value="<?php echo $this->wafconfig['adminpw'] ?>"
                           title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_ADMINPW_TIP') ?>"/>
                </div>
            </div>

        <?php
            $disabled = '';
            $message  = '';

            if(!JFactory::getConfig()->get('sef') || !JFactory::getConfig()->get('sef_rewrite'))
            {
	            $disabled = ' disabled="true"';
	            $message  = '<div class="alert" style="margin:10px 0 0">'.JText::_('ATOOLS_LBL_WAF_OPT_ADMINLOGINFOLDER_ALERT').'</div>';
            }
        ?>

	        <div class="control-group">
		        <label class="control-label" for="adminpw"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_ADMINLOGINFOLDER'); ?></label>

		        <div class="controls">
			        <input type="text" <?php echo $disabled ?>size="20" name="adminlogindir" value="<?php echo $this->wafconfig['adminlogindir'] ?>" />
			        <?php echo $message ?>
		        </div>
	        </div>

            <div class="control-group">
                <label class="control-label"><?php echo JText::_('ATOOLS_LBL_WAF_AWAYSCHEDULE')?></label>

                <div class="controls">
                    <?php echo JText::_('ATOOLS_LBL_WAF_AWAYSCHEDULE_FROM') ?>
                    <input type="text" name="awayschedule_from" class="input-mini" value="<?php echo $this->wafconfig['awayschedule_from']?>" />
                    <?php echo JText::_('ATOOLS_LBL_WAF_AWAYSCHEDULE_TO') ?>
                    <input type="text" name="awayschedule_to" class="input-mini" value="<?php echo $this->wafconfig['awayschedule_to']?>" />
                    <div class="alert alert-info" style="margin-top: 10px">
                    <?php
                        $date = new JDate('now', JFactory::getConfig()->get('offset', 'UTC'));
                        echo JText::sprintf('ATOOLS_LBL_WAF_AWAYSCHEDULE_TIMEZONE', $date->format('H:i', true));
                    ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="activeFiltering">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_ACTIVEFILTERING') ?></h3>
			<?php endif; ?>

            <div class="control-group">
                <label class="control-label" for="sqlishield"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_SQLISHIELD'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('sqlishield', array(), $this->wafconfig['sqlishield']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="xssshield"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_XSSSHIELD'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('xssshield', array(), $this->wafconfig['xssshield']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="xssshield_allowphp"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_XSSSHIELD_PHP'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('xssshield_allowphp', array(), $this->wafconfig['xssshield_allowphp']) ?>
                </div>
            </div>

            <?php
            // Warning! If the users inputs an empty string, the default one will be prompted, even if in the DB there aren't any
            // However, this is a very edge scenario, since only experienced users should touch this field and they can blank it
            // out inserting a space character
            ?>
            <div class="control-group">
                <label class="control-label"
                       for="xssshield_safe_keys"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_XSSSHIELD_SAFE_PARAMS'); ?></label>

                <div class="controls">
                    <input type="text" size="20" name="xssshield_safe_keys"
                           value="<?php echo $this->wafconfig['xssshield_safe_keys'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="muashield"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_MUASHIELD'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('muashield', array(), $this->wafconfig['muashield']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="csrfshield"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_CSRFSHIELD'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::csrflist('csrfshield', array(), $this->wafconfig['csrfshield']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="rfishield"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_RFISHIELD'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('rfishield', array(), $this->wafconfig['rfishield']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="dfishield"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_DFISHIELD'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('dfishield', array(), $this->wafconfig['dfishield']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="dfishield"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_UPLOADSHIELD'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('uploadshield', array(), $this->wafconfig['uploadshield']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="antispam"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_ANTISPAM'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('antispam', array(), $this->wafconfig['antispam']) ?>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="jhardening">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_JHARDENING') ?></h3>
			<?php endif; ?>

			<div class="control-group">
                <label class="control-label"
                       for="blockinstall"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_BLOCKINSTALL'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::blockinstallopts('blockinstall', array('class' => 'input-xlarge'), $this->wafconfig['blockinstall']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="nonewadmins"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_NONEWADMINS'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('nonewadmins', array(), $this->wafconfig['nonewadmins']) ?>
                </div>
            </div>

            <?php if (version_compare(JVERSION, '3.2.0', 'ge')): ?>
                <div class="control-group">
                    <label class="control-label"
                           for="resetjoomlatfa"><?php echo JText::_('COM_ADMINTOOLS_LBL_WAF_OPT_RESETJOOMLATFA'); ?></label>

                    <div class="controls">
                        <?php echo AdmintoolsHelperSelect::booleanlist('resetjoomlatfa', array(), $this->wafconfig['resetjoomlatfa']) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="control-group">
                <label class="control-label" for="nofesalogin"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_NOFESALOGIN'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('nofesalogin', array(), $this->wafconfig['nofesalogin']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="trackfailedlogins"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_TRACKFAILEDLOGINS'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('trackfailedlogins', array(), $this->wafconfig['trackfailedlogins']) ?>
                </div>
            </div>

        <?php
            // Detect user registration and activation type
            $disabled = '';
            $message  = '';
            $classes  = array('class' => 'input-small');
            $userParams = JComponentHelper::getParams('com_users');

            // User registration disabled
            if(!$userParams->get('allowUserRegistration'))
            {
                $classes['disabled'] = 'true';
                $disabled = ' disabled="true" ';
                $message  = '<div style="margin-top:10px" class="alert alert-info">'.JText::_('ATOOLS_LBL_WAF_ALERT_NOREGISTRATION').'</div>';
            }
            // Super User user activation
            elseif($userParams->get('useractivation') == 2)
            {
                $message = '<div style="margin-top: 10px" class="alert">'.JText::_('ATOOLS_LBL_WAF_ALERT_ADMINACTIVATION').'</div>';
            }
            // No user activation
            elseif($userParams->get('useractivation') == 0)
            {
                $classes['disabled'] = 'true';
                $disabled = ' disabled="true" ';
                $message  = '<div style="margin-top:10px" class="alert alert-info">'.JText::_('ATOOLS_LBL_WAF_ALERT_NOUSERACTIVATION').'</div>';
            }
        ?>

            <div class="control-group">
                <label class="control-label" for="deactivateusers"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_DEACTIVATEUSERS'); ?></label>

                <div class="controls">
                    <input class="input-mini pull-left" type="text" size="5" name="deactivateusers_num" <?php echo $disabled ?>
                           value="<?php echo $this->wafconfig['deactivateusers_num'] ?>"/>
                    <span class="floatme"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_DEACTIVATENUMFREQ') ?></span>
                    <input class="input-mini" type="text" size="5" name="deactivateusers_numfreq" <?php echo $disabled ?>
                           value="<?php echo $this->wafconfig['deactivateusers_numfreq'] ?>"/>
                    <?php
                        echo AdmintoolsHelperSelect::trsfreqlist('tsrfrequency', $classes, $this->wafconfig['deactivateusers_frequency']);

                        echo $message;
                    ?>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="fingerprinting">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_FINGERPRINTING') ?></h3>
			<?php endif; ?>

			<div class="control-group">
                <label class="control-label"
                       for="custgenerator"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_CUSTGENERATOR'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('custgenerator', array(), $this->wafconfig['custgenerator']) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="generator"><?php echo JText::_('ATOOLS_LBL_WAF_GENERATOR'); ?></label>

                <div class="controls">
                    <input type="text" size="45" name="generator" value="<?php echo $this->wafconfig['generator'] ?>"
                           title="<?php echo JText::_('ATOOLS_LBL_WAF_GENERATOR_TIP') ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="tmpl"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_TMPL'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('tmpl', array(), $this->wafconfig['tmpl']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="tmplwhitelist"
                       title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_TMPLWHITELIST_TIP'); ?>"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_TMPLWHITELIST'); ?></label>

                <div class="controls">
                    <input type="text" size="45" name="tmplwhitelist" value="<?php echo $this->wafconfig['tmplwhitelist'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="template"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_TEMPLATE'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('template', array(), $this->wafconfig['template']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="allowsitetemplate"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_ALLOWSITETEMPLATE') ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('allowsitetemplate', array(), $this->wafconfig['allowsitetemplate']) ?>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="honeypot">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_LBL_PROJECTHONEYPOT') ?></h3>
			<?php endif; ?>

            <div class="control-group">
                <label class="control-label"
                       for="httpblenable"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_HTTPBLENABLE'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('httpblenable', array(), $this->wafconfig['httpblenable']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bbhttpblkey"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_bbhttpblkey'); ?></label>

                <div class="controls">
                    <input type="text" size="45" name="bbhttpblkey" value="<?php echo $this->wafconfig['bbhttpblkey'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="httpblthreshold"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_HTTPBLTHRESHOLD'); ?></label>

                <div class="controls">
                    <input type="text" size="5" name="httpblthreshold"
                           value="<?php echo $this->wafconfig['httpblthreshold'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="httpblmaxage"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_HTTPBLMAXAGE'); ?></label>

                <div class="controls">
                    <input type="text" size="5" name="httpblmaxage" value="<?php echo $this->wafconfig['httpblmaxage'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="httpblblocksuspicious"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_HTTPBLBLOCKSUSPICIOUS'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('httpblblocksuspicious', array(), $this->wafconfig['httpblblocksuspicious']) ?>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="exceptions">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_EXCEPTIONS') ?></h3>
			<?php endif; ?>

			<div class="control-group">
                <label class="control-label"
                       for="neverblockips"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_NEVERBLOCKIPS'); ?></label>

                <div class="controls">
                    <input class="input-xxlarge" type="text" size="50" name="neverblockips"
                           value="<?php echo $this->wafconfig['neverblockips'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="whitelist_domains"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_WHITELIST_DOMAINS'); ?></label>

                <div class="controls">
                    <input type="text" class="input-large" name="whitelist_domains" id="whitelist_domains"
                           value="<?php echo $this->wafconfig['whitelist_domains'] ?>">
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tsr">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_LBL_TSR') ?></h3>
			<?php endif; ?>

			<div class="control-group">
                <label class="control-label" for="tsrenable"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_TSRENABLE'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('tsrenable', array(), $this->wafconfig['tsrenable']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="emailafteripautoban"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_EMAILAFTERIPAUTOBAN'); ?></label>

                <div class="controls">
                    <input class="input-large" type="text" size="50" name="emailafteripautoban"
                           value="<?php echo $this->wafconfig['emailafteripautoban'] ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="tsrstrikes"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_TSRSTRIKES'); ?></label>

                <div class="controls">
                    <input class="input-mini pull-left" type="text" size="5" name="tsrstrikes"
                           value="<?php echo $this->wafconfig['tsrstrikes'] ?>"/>
                    <span class="floatme"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_TSRNUMFREQ') ?></span>
                    <input class="input-mini" type="text" size="5" name="tsrnumfreq"
                           value="<?php echo $this->wafconfig['tsrnumfreq'] ?>"/>
                    <?php echo AdmintoolsHelperSelect::trsfreqlist('tsrfrequency', array('class' => 'input-small'), $this->wafconfig['tsrfrequency']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="tsrbannum"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_TSRBANNUM'); ?></label>

                <div class="controls">
                    <input class="input-mini" type="text" size="5" name="tsrbannum"
                           value="<?php echo $this->wafconfig['tsrbannum'] ?>"/>
                    &nbsp;
                    <?php echo AdmintoolsHelperSelect::trsfreqlist('tsrbanfrequency', array(), $this->wafconfig['tsrbanfrequency']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="tsrpermaban"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_PERMABAN'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('permaban', array(), $this->wafconfig['permaban']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="permabannum"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_PERMABANNUM'); ?></label>

                <div class="controls">
                    <input class="input-mini" type="text" size="5" name="permabannum"
                           value="<?php echo $this->wafconfig['permabannum'] ?>"/>
                    <span><?php echo JText::_('ATOOLS_LBL_WAF_LBL_PERMABANNUM_2') ?></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="spammermessage"><?php echo JText::_('ATOOLS_LBL_WAF_LBL_SPAMMERMESSAGE'); ?></label>

                <div class="controls">
                    <input type="text" class="input-xxlarge" name="spammermessage"
                           value="<?php echo $this->wafconfig['spammermessage'] ?>"/>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="loggingReporting">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_OPTGROUP_LOGGINGANDREPORTING') ?></h3>
			<?php endif; ?>

			<div class="control-group">
                <label class="control-label"
                       for="saveusersignupip"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_SAVEUSERSIGNUPIP'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('saveusersignupip', array(), $this->wafconfig['saveusersignupip']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="logbreaches"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_LOGBREACHES'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('logbreaches', array(), $this->wafconfig['logbreaches']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="iplookup" title="<?php echo JText::_('ATOOLS_LBL_WAF_IPLOOKUP_DESC') ?>">
                    <?php echo JText::_('ATOOLS_LBL_WAF_IPLOOKUP_LABEL'); ?>
                </label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::httpschemes('iplookupscheme', array('class' => 'input-small'), $this->wafconfig['iplookupscheme']) ?>
                    <input type="text" size="50" name="iplookup" value="<?php echo $this->wafconfig['iplookup'] ?>"
                           title="<?php echo JText::_('ATOOLS_LBL_WAF_IPLOOKUP_DESC') ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="emailbreaches"
                       title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILBREACHES_TIP'); ?>"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILBREACHES'); ?></label>

                <div class="controls">
                    <input type="text" size="20" name="emailbreaches" value="<?php echo $this->wafconfig['emailbreaches'] ?>"
                           title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILBREACHES_TIP') ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="emailonadminlogin"
                       title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILADMINLOGIN_TIP'); ?>"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILADMINLOGIN'); ?></label>

                <div class="controls">
                    <input type="text" size="20" name="emailonadminlogin"
                           value="<?php echo $this->wafconfig['emailonadminlogin'] ?>"
                           title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILADMINLOGIN_TIP') ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="emailonfailedadminlogin"
                       title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILADMINFAILEDLOGIN_TIP'); ?>"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILADMINFAILEDLOGIN'); ?></label>

                <div class="controls">
                    <input type="text" size="20" name="emailonfailedadminlogin"
                           value="<?php echo $this->wafconfig['emailonfailedadminlogin'] ?>"
                           title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILADMINFAILEDLOGIN_TIP') ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="showpwonloginfailure"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_SHOWPWONLOGINFAILURE'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('showpwonloginfailure', array(), $this->wafconfig['showpwonloginfailure']) ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="reasons_nolog"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_REASONS_NOLOG'); ?></label>

                <div class="controls">
                    <?php
                    echo AdmintoolsHelperSelect::reasons($this->wafconfig['reasons_nolog'], 'reasons_nolog[]', array(
                            'class'     => 'advancedSelect input-large',
                            'multiple'  => 'multiple',
                            'size'      => 5,
                            'hideEmpty' => true
                        )
                    )
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label"
                       for="reasons_noemail"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_REASONS_NOEMAIL'); ?></label>

                <div class="controls">
                    <?php
                    echo AdmintoolsHelperSelect::reasons($this->wafconfig['reasons_noemail'], 'reasons_noemail[]', array(
                            'class'     => 'advancedSelect input-large',
                            'multiple'  => 'multiple',
                            'size'      => 5,
                            'hideEmpty' => true
                        )
                    )
                    ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" title="<?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILTHROTTLE_TIP') ?>"
                       for="email_throttle"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_EMAILTHROTTLE'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('email_throttle', array(), $this->wafconfig['email_throttle']) ?>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="custommessage">
			<?php if ($this->longConfig): ?>
				<h3><?php echo JText::_('ATOOLS_LBL_WAF_CUSTOMMESSAGE_HEADER') ?></h3>
			<?php endif; ?>

			<div class="control-group">
                <label class="control-label" for="custom403msg"
                       title="<?php echo JText::_('ATOOLS_LBL_WAF_CUSTOMMESSAGE_DESC') ?>">
                    <?php echo JText::_('ATOOLS_LBL_WAF_CUSTOMMESSAGE_LABEL'); ?>
                </label>

                <div class="controls">
                    <input type="text" class="input-xxlarge" name="custom403msg"
                           value="<?php echo $this->wafconfig['custom403msg'] ?>"
                           title="<?php echo JText::_('ATOOLS_LBL_WAF_CUSTOMMESSAGE_DESC') ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="use403view"><?php echo JText::_('ATOOLS_LBL_WAF_OPT_USE403VIEW'); ?></label>

                <div class="controls">
                    <?php echo AdmintoolsHelperSelect::booleanlist('use403view', array(), $this->wafconfig['use403view']) ?>
                </div>
            </div>
        </div>
	<?php if (!$this->longConfig): ?>
	</div>
	<?php endif; ?>
</form>