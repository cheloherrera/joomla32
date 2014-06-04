<?php
/**
* @version   $Id: error.php 16849 2013-12-12 20:56:22Z arifin $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2014 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*
* Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
*
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

// Load and Inititialize Gantry Class
require_once(dirname(__FILE__) . '/lib/gantry/gantry.php');
$gantry->init();

$doc = JFactory::getDocument();
$app = JFactory::getApplication();

// Less Variables
$lessVariables = array(
    'accent-color1'             => $gantry->get('accent-color1',            '#86DBC8'),
    'accent-color2'             => $gantry->get('accent-color2',            '#34AE93'),

    'button-text-color'         => $gantry->get('button-text-color',        '#314F49'),
    'button-background'         => $gantry->get('button-background',        '#86DBC8'),          

    'header-overlay'            => $gantry->get('header-overlay',           'dark'),
    'header-text-color'         => $gantry->get('header-text-color',        '#BBBBBB'),
    'header-background'         => $gantry->get('header-background',        '#191A1C'),

    'navigation-overlay'        => $gantry->get('navigation-overlay',       'dark'),
    'navigation-text-color'     => $gantry->get('navigation-text-color',    '#BBBBBB'),
    'navigation-background'     => $gantry->get('navigation-background',    '#191A1C'),            

    'showcase-overlay'          => $gantry->get('showcase-overlay',         'dark'),
    'showcase-text-color'       => $gantry->get('showcase-text-color',      '#BBBBBB'),
    'showcase-background'       => $gantry->get('showcase-background',      '#191A1C'), 

    'utility-overlay'           => $gantry->get('utility-overlay',          'dark'),
    'utility-text-color'        => $gantry->get('utility-text-color',       '#BBBBBB'),
    'utility-background'        => $gantry->get('utility-background',       '#1F2022'),             

    'feature-overlay'           => $gantry->get('feature-overlay',          'dark'),
    'feature-text-color'        => $gantry->get('feature-text-color',       '#BBBBBB'),
    'feature-background'        => $gantry->get('feature-background',       '#191A1C'), 

    'maintop-overlay'           => $gantry->get('maintop-overlay',          'dark'),
    'maintop-text-color'        => $gantry->get('maintop-text-color',       '#BBBBBB'),
    'maintop-background'        => $gantry->get('maintop-background',       '#131315'),             

    'mainbody-overlay'          => $gantry->get('mainbody-overlay',         'dark'),
    'mainbody-text-color'       => $gantry->get('mainbody-text-color',      '#BBBBBB'),
    'mainbody-background'       => $gantry->get('mainbody-background',      '#27292B'),            

    'bottom-overlay'            => $gantry->get('bottom-overlay',           'dark'),
    'bottom-text-color'         => $gantry->get('bottom-text-color',        '#BBBBBB'),
    'bottom-background'         => $gantry->get('bottom-background',        '#191A1C'),   

    'footer-overlay'            => $gantry->get('footer-overlay',           'dark'),
    'footer-text-color'         => $gantry->get('footer-text-color',        '#BBBBBB'),
    'footer-background'         => $gantry->get('footer-background',        '#191A1C'),

    'copyright-overlay'         => $gantry->get('copyright-overlay',        'dark'),
    'copyright-text-color'      => $gantry->get('copyright-text-color',     '#BBBBBB'),
    'copyright-background'      => $gantry->get('copyright-background',     '#191A1C')            
);

$gantry->addStyle('grid-responsive.css', 5);
$gantry->addLess('bootstrap.less', 'bootstrap.css', 6);
$gantry->addLess('error.less', 'error.css', 4, $lessVariables);

// Scripts
if ($gantry->browser->name == 'ie'){
	if ($gantry->browser->shortversion == 8){
		$gantry->addScript('html5shim.js');
		$gantry->addScript('placeholder-ie.js');
	}
	if ($gantry->browser->shortversion == 9){
		$gantry->addInlineScript("if (typeof RokMediaQueries !== 'undefined') window.addEvent('domready', function(){ RokMediaQueries._fireEvent(RokMediaQueries.getQuery()); });");
		$gantry->addScript('placeholder-ie.js');
	}		
}
if ($gantry->get('layout-mode', 'responsive') == 'responsive') $gantry->addScript('rokmediaqueries.js');

ob_start();
?>
<body <?php echo $gantry->displayBodyTag(); ?>>
	<div id="rt-page-surround">
		<?php /** Begin Header Surround **/ ?>
		<header id="rt-header-surround">
			<?php /** Begin Header **/ if ($gantry->countModules('header')) : ?>
			<div id="rt-header" class="<?php if ($gantry->get('header-overlay')!='') : ?><?php echo 'rt-overlay-'.$gantry->get('header-overlay'); ?><?php endif; ?>">
				<div class="rt-container">
					<?php echo $gantry->displayModules('header','standard','standard'); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Header **/ endif; ?>
		</header>
		<?php /** End Header Surround **/ ?>

		<?php /** Begin Showcase Section **/ ?>
		<section id="rt-showcase-surround">
			<?php /** Begin Showcase **/ ?>
			<div id="rt-showcase" class="<?php if ($gantry->get('showcase-overlay')!='') : ?><?php echo 'rt-overlay-'.$gantry->get('showcase-overlay'); ?><?php endif; ?>">
				<div class="rt-container">
					<div class="rt-error-header">
						<div class="rt-error-code"><?php echo $this->error->getCode(); ?></div>
						<div class="rt-error-code-desc"><?php echo $this->error->getMessage(); ?></div>
					</div>
					<div class="rt-error-content">
						<div class="rt-error-title"><?php echo JText::_("RT_ERROR_TITLE"); ?></div>
						<div class="rt-error-message"><?php echo JText::_("RT_ERROR_MESSAGE"); ?></div>
						<div class="rt-error-button"><a href="<?php echo $gantry->baseUrl; ?>" class="readon"><span><?php echo JText::_("RT_ERROR_HOME"); ?></span></a></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php /** End Showcase **/ ?>			
		</section>
		<?php /** End Showcase Section **/ ?>

		<?php /** Begin Footer Section **/ ?>
		<footer id="rt-footer-surround">
			<div class="rt-footer-surround-pattern">
				<?php /** Begin Copyright **/ ?>
				<div id="rt-copyright">
					<div class="rt-container">
						<?php echo $gantry->displayModules('copyright','standard','standard'); ?>
						<div class="clear"></div>
					</div>
				</div>
				<?php /** End Copyright **/ ?>
			</div>
		</footer>
		<?php /** End Footer Surround **/ ?>
	</div>
</body>
</html>
<?php

$body = ob_get_clean();
$gantry->finalize();

require_once(JPATH_LIBRARIES.'/joomla/document/html/renderer/head.php');
$header_renderer = new JDocumentRendererHead($doc);
$header_contents = $header_renderer->render(null);
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<?php echo $header_contents; ?>
	<?php if ($gantry->get('layout-mode') == '960fixed') : ?>
	<meta name="viewport" content="width=960px">
	<?php elseif ($gantry->get('layout-mode') == '1200fixed') : ?>
	<meta name="viewport" content="width=1200px">
	<?php else : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php endif; ?>
</head>
<?php
$header = ob_get_clean();
echo $header.$body;