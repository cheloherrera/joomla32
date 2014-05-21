<?php
/**
* @version   $Id: comingsoon.php 18688 2014-02-11 15:15:47Z arifin $
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
    'accent-color1'             => $gantry->get('accent-color1',            '#E03D1F'),
    'accent-color2'             => $gantry->get('accent-color2',            '#3091CF'),

    'header-overlay'            => $gantry->get('header-overlay',           'light'),
    'header-text-color'         => $gantry->get('header-text-color',        '#080808'),
    'header-background'         => $gantry->get('header-background',        '#EFEFEF'),

    'showcase-overlay'          => $gantry->get('showcase-overlay',         'dark'),
    'showcase-text-color'       => $gantry->get('showcase-text-color',      '#EFEFEF'),
    'showcase-background'       => $gantry->get('showcase-background',      '#E03D1F'), 
    'showcase-type'             => $gantry->get('showcase-type',            'preset1'),  

    'mainbody-overlay'          => $gantry->get('mainbody-overlay',         'light'),    

    'bottom-overlay'            => $gantry->get('bottom-overlay',           'dark'),
    'bottom-text-color'         => $gantry->get('bottom-text-color',        '#EFEFEF'),
    'bottom-background'         => $gantry->get('bottom-background',        '#383838'),     

    'footer-overlay'            => $gantry->get('footer-overlay',           'dark'),
    'footer-text-color'         => $gantry->get('footer-text-color',        '#8F8F8F'),
    'footer-background'         => $gantry->get('footer-background',        '#080808'),
    'footer-type'               => $gantry->get('footer-type',              'preset2')   
);

$gantry->addStyle('grid-responsive.css', 5);
$gantry->addLess('bootstrap.less', 'bootstrap.css', 6);
$gantry->addLess('comingsoon.less', 'comingsoon.css', 4, $lessVariables);

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

// Simple Counter
$gantry->addScript('simplecounter.js');
$gantry->addInlineScript("
	window.addEvent('load', function(){ 
		var counter = new SimpleCounter(
			'rt-comingsoon-counter',
			/* Year (Full Year), Month (0 to 11), Day (1 to 31) */
			/* For example: Date(2016,10,1) means 1 November 2020 */			
			new Date('".$gantry->get('comingsoon-year')."','".$gantry->get('comingsoon-month')."','".$gantry->get('comingsoon-date')."'),
			{lang : {      
				d:{single:'".JText::_("DAY")."',plural:'".JText::_("DAYS")."'}, 		//days
				h:{single:'".JText::_("HOUR")."',plural:'".JText::_("HOURS")."'},     	//hours
				m:{single:'".JText::_("MINUTE")."',plural:'".JText::_("MINUTES")."'}, 	//minutes
				s:{single:'".JText::_("SECOND")."',plural:'".JText::_("SECONDS")."'} 	//seconds
			}
		});
	});
");

ob_start();
?>
<body id="rt-comingsoon" <?php echo $gantry->displayBodyTag(); ?>>
	<div id="rt-page-surround">
		<header id="rt-header-surround">
			<div class="rt-overlay">
				<div class="rt-comingsoon-body">
					<div class="rt-logo-block rt-comingsoon-logo">
					    <a id="rt-logo" href="<?php echo $gantry->baseUrl; ?>"></a>
					</div>

					<?php
						$msgs = $app->getMessageQueue();
					?>
					<?php if (sizeof($msgs) > 0) : ?>	
						<div class="rt-container">
							<jdoc:include type="message" />
							<div class="clear"></div>
						</div>
					<?php endif; ?>

					<div class="rt-comingsoon-title rt-big-title rt-center">
						<div class="module-title">
							<h2 class="title"><?php echo JText::_("RT_COMINGSOON_TITLE"); ?></h2>
						</div>						
					</div>				

					<p class="rt-comingsoon-message">
						<?php echo JText::_("RT_COMINGSOON_MESSAGE"); ?>
					</p>

					<div class="rt-counter-block">
						<div id="rt-comingsoon-counter"></div>					
					</div>
				</div>
			</div>
		</header>
		<section id="rt-subscription-form">
			<div class="rt-container">
				<?php if ($gantry->get('email-subscription-enabled')) : ?>
					<p class="rt-subscription-title">
						<?php echo JText::_("RT_COMINGSOON_SUBSCRIPTION_TITLE"); ?>
					</p>				
					<form class="rt-comingsoon-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $gantry->get('feedburner-uri'); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
						<input type="text" placeholder="<?php echo JText::_('RT_EMAIL') ?>" class="inputbox" name="email">
						<input type="hidden" value="<?php echo $gantry->get('feedburner-uri'); ?>" name="uri"/>
						<input type="hidden" name="loc" value="en_US"/>
						<input type="submit" name="Submit" class="button" value="<?php echo JText::_('RT_SUBSCRIBE') ?>" />
					</form>
					<div class="clear"></div>	
				<?php endif; ?>					
			</div>		
		</section>
		<section id="rt-authorized-form">
			<h2 class="rt-authorized-form-title"><?php echo JText::_("AUTHORIZED_LOGIN"); ?></h2>

			<p class="rt-authorized-login-message">
				<?php echo JText::_("RT_AUTHORIZED_LOGIN_MESSAGE"); ?>
			</p>				

			<?php 
		        $user    = JFactory::getUser();
		        $isAdmin = $user->get('isRoot');					
			?>
			<?php if (!$isAdmin): ?>
				<form class="rt-authorized-login-form" action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="rt-form-login">
					<input name="username" id="username" class="inputbox" type="text" placeholder="<?php echo JText::_('JGLOBAL_USERNAME') ?>" />
					<input type="password" name="password" class="inputbox" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
					<input type="hidden" name="remember" class="inputbox" value="yes" id="remember" />
					<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.login" />
					<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
					<?php echo JHtml::_('form.token'); ?>					
				</form>
			<?php endif; ?>
			<?php if ($isAdmin): ?>
				<form class="rt-authorized-login-form" action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="rt-form-login">
					<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
					<input type="hidden" name="option" value="com_users" />
					<input type="hidden" name="task" value="user.logout" />
					<input type="hidden" name="return" value="<?php echo $return; ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</form>	
			<?php endif; ?>	
		</section>
		<footer id="rt-footer-surround">
			<div class="rt-footer-surround-pattern">
				<div id="rt-copyright">
					<div class="rt-container">
						<?php echo $gantry->displayModules('copyright','standard','standard'); ?>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</footer>
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