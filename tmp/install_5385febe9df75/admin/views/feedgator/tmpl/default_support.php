<?php
/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.4
* @package FeedGator
* @author Original author Stephen Simmons
* @now continued and modified by Matt Faulds, Remco Boom & Stephane Koenig and others
* @email mattfaulds@gmail.com
* @Joomla 1.5 Version by J. Kapusciarz (mrjozo)
* @copyright (C) 2005 by Stephen Simmons - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.pane');
$options =  array('allowAllClose'=>1,'startOffset'=>-1,'startTransition'=>0,'opacityTransition'=>1);
$pane = JPane::getInstance('sliders', $options);

$cronpath = str_replace('views'.DS.'feedgator'.DS.'tmpl'.DS.'default_support.php','cron.feedgator.php',__FILE__);

?>
<div class="fgsupport">
	<div class="fglogo"></div>
	<h1>FeedGator Support</h1>
	<ul class="main">
		<li>Are you <strong class="blue">having problems</strong> using FeedGator?</li>
		<li>Do you have questions about <strong class="blue">how to use FeedGator?</strong></li>
		<li>Do you want to configure FeedGator to <strong class="blue">run automatically?</strong></li>
		<li>Do you need <strong class="blue">custom content aggregation</strong> or other development services?</li>
	</ul>
	<h3>Here's the help you're looking for:</h3>
	<br />

	<?php echo $pane->startPane('pane'); ?>
	<?php echo $pane->startPanel('FeedGator development site','panel1'); ?>

		<p>For general help using FeedGator, the most current Frequently Asked Questions, or to submit feature requests or suggestions... or to just let me know how much you love the component :)... please visit <a href="http://joomlacode.org/gf/project/feedgator">http://joomlacode.org/gf/project/feedgator</a>.</p>
		<p>We try to help everyone but please be patient if you don't immediately receive an answer. If you want to ask a question about your installation of if you want to report a problem, please always mention the version of your Joomla! installation and FeedGator version!</p>

	<?php echo $pane->endPanel(); ?>
	<?php echo $pane->startPanel('Configuring automatic imports using cron','panel2'); ?>

		<p>RSS feeds can be imported automatically at regular intervals using cron on your server. If you're not sure what cron is, <a href="http://en.wikipedia.org/wiki/Cron" target="_blank">click here</a>. Running FeedGator via cron is essentially the same as clicking the "Import All" link from the administrative interface. All of your settings are preserved.</p>
		<p>Your cron file is found here: <EM><?php echo $cronpath; ?></em></p>

		<h4>cPanel</h4>
		<p>In cPanel the frequency that cron is run is set using the cPanel cron interface. All you have to do is enter the path to the cron file. Here's an example using your file:</p>
		<pre><?php echo $cronpath; ?> >/dev/null</pre>
		<br/>

		<h4>Other systems</h4>
		<p>Other cron systems may require you to set you cron frequency manually. An example below shows running cron every 30mins. To run cron at different intervals, consult the <a href="http://unixhelp.ed.ac.uk/CGI/man-cgi?crontab+5" target="_blank">cron documentation</a> or follow <a href="http://en.wikipedia.org/wiki/Cron" target="_blank">this link</a>.</p>
		<pre>*/30 * * * * /usr/local/bin/php <?php echo $cronpath; ?> > /dev/null</pre>
		<br/>

		<h4>Important Points</h4>
		<ul>
			<li>The "> /dev/null" stops the cron system sending you an email every time it runs but it will still send error messages. Use ">/dev/null 2>&1" to silence all cron email output.</li>
			<li>The actual frequency that a feed is parsed for importing is set within FeedGator a) through the feed default settings and b) for each individual feed. Under <em>Processing and Duplicates</em> there are 2 relevant options: "cron Import Limit" and "cron Interval". Using these settings you can restrict the number of items imported with each cron task and vary the frequency that individual feeds are processed independent of the cron frequency.</li>
			<li>cron.feedgator.php is designed to be run from the directory that it was installed to. If you move the file to another directory, you will need to edit the file to set to the proper location.</li>
		</ul>

	<?php echo $pane->endPanel(); ?>
	<?php echo $pane->startPanel('Configuring automatic imports using the automator plugin','panel3'); ?>

		<p>FeedGator can run automatically using the System - FeedGator Automator Plugin (automatically installed with FeedGator). Simply set a frequency that you wish the plugin to run in the plugin settings and then publish it.</p>

		<h4>Important Points</h4>
		<ul>
			<li>The automator plugin is much less efficient than proper cron and will sometimes slow your site down.</li>
			<li>The actual frequency that a feed is parsed for importing is set within FeedGator a) through the feed default settings and b) for each individual feed. Under <em>Processing and Duplicates</em> there are 2 relevant options: "Automator Import Limit" and "Automator Interval".</li>
			<li><strong>You are strongly recommended to keep the Automator Import Limit to a low number to reduce the number of items processed when using the automator plugin</strong></li>
			<li><strong>You are strongly recommended to consider higher numbers for the Automator Interval to reduce the frequency that the automator plugin is activated</strong></li>
		</ul>

	<?php echo $pane->endPanel(); ?>
	<?php echo $pane->startPanel('Report a bad feed','panel4'); ?>

		<p>If you have recieved an error while trying to import a feed, please let me know. I investigate EVERY feed that is reported, because I want FeedGator to work with ALL feeds, even ones that don't conform to the RSS validation standard. I'm serious about this. BUT please follow these steps before reporting a feed.</p>
		<ol>
			<li>First make sure the feed URL is correct - I hate wasting time checking bogus URLs. You can do this by copy and pasting the feed URL into your browser's address bar. If you see an error when trying to view the feed with a browser, then it cannot be imported using FeedGator. If you see a web site instead of a feed when you view the URL in a browser, then it cannot be imported. This will also help to make sure you've typed the URL correctly. </li>
			<li>If the URL is a legitimate feed URL, try to import it a few times before reporting it. Some busy or slow servers can occasionally cause FeedGator to time out waiting for the feed to be fetched. This is not a bug or a bad feed.</li>
		</ol>
		<p>Once you're sure the feed URL is correct, you can post it on the support forum at <a href="http://joomlacode.org/gf/project/feedgator">http://joomlacode.org/gf/project/feedgator</a> and we'll take a look at it. </p>

	<?php echo $pane->endPanel(); ?>
	<?php echo $pane->startPanel('Custom development services or support','panel5'); ?>

		<p>If you need personalised priority support or custom development (i.e. a plugin to support com_xxxx) then it may be available. Contact via the <a href="http://joomlacode.org/gf/project/feedgator/forum">JoomlaCode</a> forum or <a href="http://www.trafalgardesign.com">Trafalgar Design</a> for more details.</p>

	<?php echo $pane->endPanel(); ?>
	<?php echo $pane->endPane(); ?>
</div>