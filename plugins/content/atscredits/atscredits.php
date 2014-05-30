<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

defined('_JEXEC') or die();

JLoader::import('joomla.plugin.plugin');

// PHP version check
if(defined('PHP_VERSION')) {
    $version = PHP_VERSION;
} elseif(function_exists('phpversion')) {
    $version = phpversion();
} else {
    // No version info. I'll lie and hope for the best.
    $version = '5.0.0';
}
// Old PHP version detected. EJECT! EJECT! EJECT!
if(!version_compare($version, '5.3.0', '>=')) return;

// Make sure F0F is loaded, otherwise do not run
if(!defined('F0F_INCLUDED')) {
    include_once JPATH_LIBRARIES.'/f0f/include.php';
}
if(!defined('F0F_INCLUDED'))
{
    return;
}

class plgContentAtscredits extends JPlugin
{
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    public function onContentPrepare($context, &$article, &$params, $limitstart = 0)
    {
        // Check whether the plugin should process or not
        if (JString::strpos($article->text, 'atscredits') === false)
        {
            return true;
        }

        require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/credits.php';

        // Search for this tag in the content
        $regex = "#{atscredits(.*?)}#s";

        $article->text = preg_replace_callback($regex, array('self', 'process'), $article->text);
    }

    private function process($match)
    {
        if(JFactory::getUser()->guest)
        {
            $ret = '';
        }
        else
        {
            $credits = AtsHelperCredits::creditsLeft(JFactory::getUser()->id, true);
            $ret     = JText::sprintf('PLG_ATSCREDITS_CREDITS', $credits);
        }

        return $ret;
    }
}

