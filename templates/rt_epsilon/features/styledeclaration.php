<?php
/**
 * @version   $Id: styledeclaration.php 19364 2014-03-01 13:51:28Z arifin $
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2014 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureStyleDeclaration extends GantryFeature {
    var $_feature_name = 'styledeclaration';

    function isEnabled() {
		global $gantry;
        $menu_enabled = $this->get('enabled');

        if (1 == (int)$menu_enabled) return true;
        return false;
    }

	function init() {
		global $gantry;
		$browser = $gantry->browser;

        // Logo
    	$css = $this->buildLogo();

        // Less Variables
    	$lessVariables = array(
            'accent-color1'             => $gantry->get('accent-color1',                '#FB6058'),
            'accent-color2'             => $gantry->get('accent-color2',                '#FFC37A'),

            'header-text-color'         => $gantry->get('header-text-color',            '#898788'),
            'header-background'         => $gantry->get('header-background',            '#EAE6E5'),
            'header-type'               => $gantry->get('header-type',                  'headroom'),
            'header-top-offset'         => $gantry->get('header-top-offset',            '80'),

            'demoroksprocket-type'      => $gantry->get('demoroksprocket-type',         'preset1'),

            'showcase-text-color'       => $gantry->get('showcase-text-color',          '#898788'),
            'showcase-background'       => $gantry->get('showcase-background',          '#EAE6E5'),

            'top-text-color'            => $gantry->get('top-text-color',               '#898788'),
            'top-background'            => $gantry->get('top-background',               '#EAE6E5'),
            'top-type'                  => $gantry->get('top-type',                     'epsilon'),

            'utility-text-color'        => $gantry->get('utility-text-color',           '#898788'),
            'utility-background'        => $gantry->get('utility-background',           '#EAE6E5'),

            'feature-text-color'        => $gantry->get('feature-text-color',           '#AAA8A9'),
            'feature-background'        => $gantry->get('feature-background',           '#EAE6E5'),

            'maintop-text-color'        => $gantry->get('maintop-text-color',           '#898788'),
            'maintop-background'        => $gantry->get('maintop-background',           '#EAE6E5'),
            'maintop-type'              => $gantry->get('maintop-type',                 'epsilon'),

            'expandedtop-text-color'    => $gantry->get('expandedtop-text-color',       '#818181'),
            'expandedtop-background'    => $gantry->get('expandedtop-background',       '#EDECED'),

            'mainbody-overlay'          => $gantry->get('mainbody-overlay',             'light'),

            'expandedbottom-text-color' => $gantry->get('expandedbottom-text-color',    '#818181'),
            'expandedbottom-background' => $gantry->get('expandedbottom-background',    '#EDECED'),

            'extension-text-color'      => $gantry->get('extension-text-color',         '#AAA8A9'),
            'extension-background'      => $gantry->get('extension-background',         '#EAE6E5'),

            'bottom-text-color'         => $gantry->get('bottom-text-color',            '#898788'),
            'bottom-background'         => $gantry->get('bottom-background',            '#EAE6E5'),

            'footer-text-color'         => $gantry->get('footer-text-color',            '#9F9FA1'),
            'footer-background'         => $gantry->get('footer-background',            '#323337'),
            'footer-type'               => $gantry->get('footer-type',                  'epsilon'),

            'copyright-text-color'      => $gantry->get('copyright-text-color',         '#9F9FA1'),
            'copyright-background'      => $gantry->get('copyright-background',         '#323337')
    	);

        // Section Background Images
        $positions  = array('top-customtop-image', 'maintop-custommaintop-image', 'footer-customfooter-image');
        $source     = "";

        foreach ($positions as $position) {
            $data = $gantry->get($position, false) ? json_decode(str_replace("'", '"', $gantry->get($position))) : false;
            if ($data) $source = $data->path;
            if (!preg_match('/^\//', $source)) $source = JURI::root(true).'/'.$source;
            $lessVariables[$position] = $data ? 'url(' . $source . ')' : 'none';
        }

        $gantry->addInlineStyle($css);

       	$gantry->addLess('global.less', 'master.css', 7, $lessVariables);

	    $this->_disableRokBoxForiPhone();

        if ($gantry->get('layout-mode')=="responsive") $gantry->addLess('mediaqueries.less');
        if ($gantry->get('layout-mode')=="960fixed")   $gantry->addLess('960fixed.less');
        if ($gantry->get('layout-mode')=="1200fixed")  $gantry->addLess('1200fixed.less');

        // RTL
        if ($gantry->get('rtl-enabled')) $gantry->addLess('rtl.less', 'rtl.css', 8, $lessVariables);

        // Demo Styling
        if ($gantry->get('demo')) $gantry->addLess('demo.less', 'demo.css', 9, $lessVariables);

        // Third Party (k2)
        if ($gantry->get('k2')) $gantry->addLess('thirdparty-k2.less', 'thirdparty-k2.css', 10, $lessVariables);

        // Chart Script
        if ($gantry->get('chart-enabled')) $gantry->addScript('chart.js');
	}

    function buildLogo(){
		global $gantry;

        if ($gantry->get('logo-type')!="custom") return "";

        $source = $width = $height = "";

        $logo = str_replace("&quot;", '"', str_replace("'", '"', $gantry->get('logo-custom-image')));
        $data = json_decode($logo);

        if (!$data){
            if (strlen($logo)) $source = $logo;
            else return "";
        } else {
            $source = $data->path;
        }

        if (substr($gantry->baseUrl, 0, strlen($gantry->baseUrl)) == substr($source, 0, strlen($gantry->baseUrl))){
            $file = JPATH_ROOT . '/' . substr($source, strlen($gantry->baseUrl));
        } else {
            $file = JPATH_ROOT . '/' . $source;
        }

        if (isset($data->width) && isset($data->height)){
            $width = $data->width;
            $height = $data->height;
        } else {
            $size = @getimagesize($file);
            $width = $size[0];
            $height = $size[1];
        }

        if (!preg_match('/^\//', $source))
        {
            $source = JURI::root(true).'/'.$source;
        }

        $source = str_replace(' ', '%20', $source);

        $output = "";
        $output .= "#rt-logo {background: url(".$source.") 50% 0 no-repeat !important;}"."\n";
        $output .= "#rt-logo {width: ".$width."px;height: ".$height."px;}"."\n";

        $file = preg_replace('/\//i', DIRECTORY_SEPARATOR, $file);

        return (file_exists($file)) ?$output : '';
    }

	function _disableRokBoxForiPhone() {
		global $gantry;

		if ($gantry->browser->platform == 'iphone' || $gantry->browser->platform == 'android') {
			$gantry->addInlineScript("window.addEvent('domready', function() {\$\$('a[rel^=rokbox]').removeEvents('click');});");
		}
	}
}