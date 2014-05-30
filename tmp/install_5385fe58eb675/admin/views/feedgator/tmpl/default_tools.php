<?php

/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.3RC4
* @package FeedGator
* @author Matt Faulds
* @email mattfaulds@gmail.com
* @copyright (C) 2010 Matthew Faulds - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
/*print_r($this->dups);*/
?>
<br />
<ul>
	<li><a href="index.php?option=com_feedgator&task=syncImports">Synchronise Import Database</a></li>
	<li style="list-style:none;">&nbsp;</li>
	<li><a id="duplink" href="#">View Duplicates</a></li>
</ul>
<table id="duptable" class="adminlist" style="display:none;">
 <thead>
   <tr>
     <td class="title" width="10%"><?php echo JText::_('Number of Duplicates'); ?></td>
     <td class="title" width="40%"><?php echo JText::_('Title'); ?></td>
     <td class="title" width="30%"><?php echo JText::_('Feed'); ?></td>
     <td class="title" width="20%"><?php echo JText::_('Content Type'); ?></td>
   </tr>
 </thead>
 <tbody>
   	<?php if(!empty($this->dups)) { ?>
   		<?php $i=0; foreach($this->dups as &$dup) { ?>
		    <tr>
		      <td><span class="dupdrill" rel="tr<?php echo $i; ?>"> <?php echo $dup->num; ?></span></td>
		      <td><?php echo $dup->title; ?></td>
		      <td><?php echo $dup->feed_title; ?></td>
		      <td><?php echo $dup->content_type; ?></td>
		    </tr>
		    <tr id="tr<?php echo $i; ?>" style="display:none;">
		    	<td colspan="4">
		    		<table id="drilldowntable" class="adminlist">
						<thead>
						   <tr>
						     <td class="title" width="10%"><?php echo JText::_('Duplicate'); ?></td>
						     <td class="title" width="40%"><?php echo JText::_('Title'); ?></td>
						     <td class="title" width="10%"><?php echo JText::_('Content ID'); ?></td>
						     <td class="title" width="10%"><?php echo JText::_('Section ID'); ?></td>
						     <td class="title" width="10%"><?php echo JText::_('Category ID'); ?></td>
						     <td class="title" width="20%"><?php echo JText::_('Ignore'); ?></td>
						   </tr>
						 </thead>
						 <tbody>
						 	<?php $ds = &$dup->dups; for($j=0;$j<count($ds);$j++) { ?>
							 	<tr id="<?php echo $i.$j.'_'.$ds[$j]->id; ?>">
							 		<td><?php echo $j; ?></td>
							 		<td><a href="<?php echo $ds[$j]->content_link; ?>"><?php echo $ds[$j]->title; ?></a></td>
								    <td><?php echo $ds[$j]->id; ?></td>
								    <td><?php echo $ds[$j]->sectionid; ?></td>
								    <td><?php echo $ds[$j]->catid; ?></td>
								    <td><a class="ignoredup" href="#" type="<?php echo $dup->content_type; ?>" rel="<?php echo $i.$j.'_'.$ds[$j]->id; ?>">Ignore</a></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</td>
			</tr>
	   <?php $i++; } ?>
   	<?php } else { ?>
   		<tr>
   			<td colspan="4"><?php echo JText::_('No Duplicates Found'); ?></td>
   		</tr>
   	<?php } ?>
 </tbody>
</table>