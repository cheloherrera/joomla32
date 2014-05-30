<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

if(version_compare(JVERSION, '3.0', 'ge')){
	JHTML::_('behavior.framework');
}else{
	JHTML::_('behavior.mootools');
}

F0FTemplateUtils::addCSS('media://com_ats/css/jquery.jqplot.min.css?'.ATS_VERSIONHASH);

AkeebaStrapper::addJSfile('media://com_ats/js/timecards.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/excanvas.min.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/jquery.jqplot.min.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.highlighter.min.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.barRenderer.min.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.categoryAxisRenderer.min.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.canvasAxisLabelRenderer.min.js?'.ATS_VERSIONHASH);
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.canvasTextRenderer.min.js?'.ATS_VERSIONHASH);

JText::script('COM_ATS_COMMON_HOURS');
JText::script('COM_ATS_COMMON_SUPPORT_STAFF');

$time_start = date('Y-m-01');
$time_end   = date('Y-m-t', strtotime($time_start));
?>
<div>
	<h3><?php echo JText::_('COM_ATS_TIMECARDS_USERS') ?></h3>
	<table>
		<tr>
			<td><?php echo JText::_('COM_ATS_COMMON_FROMDATE') ?></td>
			<td>
				<?php echo JHTML::calendar($time_start, 'time_start', 'time_start'); ?>
				<button class="btn btn-mini" id="time_graph_reload" onclick="return false">
					<?php echo JText::_('COM_ATS_COMMON_RELOADGRAPHS') ?>
				</button>
			</td>
		</tr>
		<tr>
			<td><?php echo JText::_('COM_ATS_COMMON_TODATE') ?></td>
			<td><?php echo JHTML::calendar($time_end, 'time_end', 'time_end'); ?></td>
		</tr>
	</table>
	<div id="nodata-warn" class="alert" style="text-align: center;display: none">
		<strong><em>
		<?php echo JText::_('COM_ATS_COMMON_NORECORDS')?>
		</em></strong>
	</div>
	<div style="padding-bottom: 80px;padding-left: 55px">
		<div id="ats-timecard" style="height:300px"></div>
	</div>
</div>