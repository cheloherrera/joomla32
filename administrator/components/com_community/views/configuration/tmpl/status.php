<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_USER_STATUS' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="::<?php echo JText::_('COM_COMMUNITY_CONFIGURATION_USER_STATUS_CHARACTER_LIMIT_TIPS'); ?>">
						<?php echo JText::_( 'COM_COMMUNITY_CONFIGURATION_USER_STATUS_CHARACTER_LIMIT'); ?>
					</span>
				</td>
				<td valign="top">
					<div><input type="text" name="statusmaxchar" value="<?php echo $this->config->get('statusmaxchar'); ?>" size="5" /><?php echo JText::_('COM_COMMUNITY_CHARACTERS');?></div>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>