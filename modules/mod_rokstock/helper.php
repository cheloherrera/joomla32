<?php
/**
 * @version   $Id: helper.php 6809 2013-01-27 22:04:15Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).'/lib/googlestock.class.php');

/**
 *
 */
class modRokStockHelper
{
    /**
     * @static
     *
     * @param $params
     * @param $url
     */
    public static function loadScripts(&$params, $url)
    {
        JHtml::_('behavior.framework', true);

        $js_file = JURI::base() . 'modules/mod_rokstock/tmpl/js/rokstock' . self::_getJSVersion() . '.js';

        if (!defined('ROKSTOCK_JS')) {
            $save_cookie     = ($params->get("store_cookie", "1") == "1") ? 1 : 0;
            $duration_cookie = $params->get("store_time", 30);
            $externals       = ($params->get('externals', "1") == "1") ? 1 : 0;
            $show_main_chart = ($params->get("show_main_chart", "1") == "1") ? 1 : 0;
            $show_tooltips   = ($params->get("show_tooltips", "1") == "1") ? 1 : 0;

            $document =JFactory::getDocument();
            $document->addScript($js_file);
            $document->addScriptDeclaration("window.addEvent('domready', function() {
	new RokStock({
		detailURL: '{$url}',
		cookie: {$save_cookie},
		cookieDuration: {$duration_cookie},
		externalLinks: {$externals},
		mainChart: {$show_main_chart},
		toolTips: {$show_tooltips}
	});
});");
            define('ROKSTOCK_JS', 1);
        }
    }

    /**
     * @static
     *
     * @param $stocks
     * @param $params
     *
     * @return bool
     */
    public static function getStock($stocks, &$params)
    {
        $gstock = new googleStock(JPATH_CACHE);
        $output = $gstock->makeRequest($stocks);

        return $output;
    }

    /**
     * @static
     * @return string
     */
    private static function _getJSVersion()
    {
        return "";
    }
}
