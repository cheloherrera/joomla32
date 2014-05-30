<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3.4
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.pane');
$options =  array('allowAllClose'=>1,'startOffset'=>0,'startTransition'=>1,'opacityTransition'=>1);
$pane = &JPane::getInstance('sliders', $options);
?>
<script>
function pressbutton(url) {
	var f = document.adminForm;
	f.install_url.value = url;
	f.submit();
}
</script>
<table class="adminform">
	<tbody>
		<tr>
			<td valign="top" width="55%">
				<div id="cpanel">
					<?php // get the cpanels
					echo FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=feeds'),array('src'=>'components/com_feedgator/images/cpanel/feeds.png','alt'=>'Manage Feeds'),JText::_('Manage Feeds'));
					echo FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=settings'),array('src'=>'components/com_feedgator/images/cpanel/settings.png','alt'=>'Global Settings'),JText::_('Global Settings'));
					echo FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=plugins'),array('src'=>'components/com_feedgator/images/cpanel/plugins.png','alt'=>'Plugins'),JText::_('Plugins'));
					echo FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=tools'),array('src'=>'components/com_feedgator/images/cpanel/tools.png','alt'=>'Tools'),JText::_('Tools'));
					echo FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=imports'),array('src'=>'components/com_feedgator/images/cpanel/history.png','rel' =>'test','alt'=>'Import History'),JText::_('Import History'));
					echo FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=support'),array('src'=>'components/com_feedgator/images/cpanel/support.png','alt'=>'Support'),JText::_('Support'));
					echo FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=about'),array('src'=>'components/com_feedgator/images/cpanel/about.png','alt'=>'About FeedGator'),JText::_('About FeedGator'));
					echo FeedgatorHelper::renderCpanel();
					echo FeedgatorHelper::renderCpanel();
					echo (@$this->version_data['dev']['upgrade'] OR $this->version_data['stable']['upgrade']) ? FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/warning.png','alt'=>JText::_('FG_UPDATE_NEEDED')),JText::_('FG_UPDATE_NEEDED')) : FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/ok.png','alt'=>JText::_('FG_LATEST_VERSION')),JText::_('FG_LATEST_VERSION'));
					echo $this->jplugin ? FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/ok.png','alt'=>JText::_('FG_J_PLGS_OK')),JText::_('FG_J_PLGS_OK')) : FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/warning.png','alt'=>JText::_('FG_J_PLGS_NOT_OK')),JText::_('FG_J_PLGS_NOT_OK'));
					echo $this->fgplugins ? FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/ok.png','alt'=>JText::_('FG_PLGS_OK')),JText::_('FG_PLGS_OK')) : FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=plugins'),array('src'=>'components/com_feedgator/images/cpanel/warning.png','alt'=>JText::_('FG_PLGS_NOT_OK')),JText::_('FG_PLGS_NOT_OK'));
					echo $this->import_sync ? FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/ok.png','alt'=>JText::_('FG_IMPORTS_OK')),JText::_('FG_IMPORTS_OK')) : FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=tools'),array('src'=>'components/com_feedgator/images/cpanel/warning.png','alt'=>JText::_('FG_IMPORTS_NOT_OK')),JText::_('FG_IMPORTS_NOT_OK'));
					echo $this->duplicates ? FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=tools'),array('src'=>'components/com_feedgator/images/cpanel/warning.png','alt'=>JText::_('FG_DUPS')),JText::_('FG_DUPS')) : FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/ok.png','alt'=>JText::_('FG_NO_DUPS')),JText::_('FG_NO_DUPS'));
					echo $this->globals ? FeedgatorHelper::renderCpanel(array('href'=>'#'),array('src'=>'components/com_feedgator/images/cpanel/ok.png','alt'=>JText::_('FG_GLOBALS')),JText::_('FG_GLOBALS')) : FeedgatorHelper::renderCpanel(array('href'=>'index.php?option=com_feedgator&task=settings'),array('src'=>'components/com_feedgator/images/cpanel/warning.png','alt'=>JText::_('FG_NO_GLOBALS')),JText::_('FG_NO_GLOBALS'));
					?>
				</div>
			</td>
			<td valign="top" width="45%">
				<?php
				echo $pane->startPane('pane');
				echo $pane->startPanel('FeedGator','panel1');
					echo JText::_('FG_DESCRIPTION');
					FeedgatorHelper::renderVersionUpdatePanel($this->version_data);
				echo $pane->endPanel();
				echo $pane->startPanel('Latest Imports','panel2');
				    if($this->latest_imports) { ?>
						<table class="adminlist">
						    <thead>
						      <tr>
						        <td class="title"><?php echo JText::_('Title'); ?></td>
						        <td class="title"><?php echo JText::_('Feed'); ?></td>
						        <td class="title"><?php echo JText::_('Created'); ?></td>
						      </tr>
						    </thead>
						    <tbody>
						      	<?php foreach($this->latest_imports as $latest) { ?>
							      <tr>
							        <td><?php echo '<a href="'.$latest->content_link.'">'.$latest->title.'</a>'; ?></td>
							        <td><?php echo '<a href="'.$latest->feed_link.'">'.$latest->feed_title.'</a>'; ?></td>
							        <td><?php echo JHTML::_('date', $latest->created); ?></td>
		   					      </tr>
						      <?php } ?>
						    </tbody>
					    </table>
				    <?php } else { ?>
				    	<p><?php echo JText::_('No Imports in Database'); ?></p>
				    <?php }
				echo $pane->endPanel();
				echo $pane->startPanel('Credits','panel3');
				?>
					<ul>
						<li>Built on the <a href="http://www.joomla.org/" target="_blank">Joomla</a> framework</li>
						<li><a href="http://simplepie.org" target="_blank">SimplePie</a> RSS feed parser</li>
						<li><a href="http://lab.arc90.com/experiments/readability/">Readability</a> port by <a href="http://fivefilters.org/content-only/">FiveFilters.org</a> for full text extraction</li>
						<li><a href="http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/">htmLawed</a> (X)HTML filter, processor, purifier, sanitizer and beautifier for imported text</li>
						<li><a href="http://extensions.joomla.org/extensions/news-display/related-items/5701">Add Keywords</a> Joomla plugin for automated metadata generation</li>
						<li><a href="http://developer.yahoo.com/search/content/V1/termExtraction.html">Yahoo's term extraction API</a> for automatic Term Extraction</li>
						<li>Small icons <a href="http://www.famfamfam.com/lab/icons/silk/">Famfamfam Silk Icons</a> by Mark James (take a look because you'll notice they're used everywhere but very, very rarely attributed properly!)</li>
						<li>Coding influences from: <a href="http://joomla.vargas.co.cr/">Xmap component by Vargas</a>, <a href="http://www.trafalgardesign.com">Trafalgar Design</a> Learning Management System (unreleased)</li>
					</ul>
					<ul>
						<li>Released under the GNU <a href="http://www.gnu.org/licenses/gpl-2.0.html">GPLv2</a> copyleft license</li>
						<li>Maintained and developed by Matthew Faulds (2010)</li>
						<li>Original author Stephen Simmons (2006)</li>
						<li>Contributing authors: Remco Boom, Stephane Koenig and others</li>
					</ul>
				<?php
				echo $pane->endPanel();
				// statistics slider here
				echo $pane->endPane();
				?>
			</td>
		</tr>
	</tbody>
</table>