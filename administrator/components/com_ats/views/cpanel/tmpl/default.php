<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.framework');

$params = JComponentHelper::getParams('com_ats');

if($params->get('userfeedback', 0))
{
    F0FTemplateUtils::addCSS('admin://components/com_ats/assets/datatables/css/datatables.css');
    AkeebaStrapper::addJSfile('admin://components/com_ats/assets/datatables/js/datatables.min.js');
    AkeebaStrapper::addJSfile('admin://components/com_ats/assets/datatables/js/paging.js');
}

F0FTemplateUtils::addCSS('media://com_ats/css/backend.css?'.ATS_VERSIONHASH);
F0FTemplateUtils::addCSS('media://com_ats/css/jquery.jqplot.min.css');

AkeebaStrapper::addJSfile('media://com_ats/js/excanvas.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jquery.jqplot.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.highlighter.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.dateAxisRenderer.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.categoryAxisRenderer.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.canvasAxisTickRenderer.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.canvasTextRenderer.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.barRenderer.min.js');
AkeebaStrapper::addJSfile('media://com_ats/js/jqplot.hermite.js');

?>
<?php if (ATS_PRO && (version_compare(JVERSION, '2.5.19', 'lt') || (version_compare(JVERSION, '3.0.0', 'gt') && version_compare(JVERSION, '3.2.1', 'lt')))):?>
	<div class="alert alert-error">
		<?php echo JText::_('COM_ATS_CPANEL_ERR_OLDJOOMLANOUPDATES'); ?>
	</div>
<?php elseif (ATS_PRO && version_compare(JVERSION, '2.5.999', 'lt') && !$this->update_plugin): ?>
	<div class="alert alert-warning">
		<?php echo JText::_('COM_ATS_CPANEL_ERR_NOPLUGINNOUPDATES'); ?>
	</div>
<?php endif; ?>


<?php if ($this->needsdlid): ?>
<div class="alert alert-error">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<?php echo JText::sprintf('COM_ATS_CPANEL_MSG_NEEDSDLID','https://www.akeebabackup.com/instructions/1519-akeeba-ticket-system-download-id.html'); ?>
</div>
<?php endif;?>

<div id="updateNotice"></div>

<div class="row-fluid">
	<div class="span6" id="cpanel">
		<h2><?php echo JText::_('COM_ATS_CPANEL_TICKETS')?></h2>
		<div id="akticketschart">
			<img id="akthrobber" src="<?php echo F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif')?>" />
			<p id="aknodata" style="display:none">
				<?php echo JText::_('COM_ATS_CPANEL_STATS_NODATA')?>
			</p>
		</div>

        <h2><?php echo JText::_('COM_ATS_CPANEL_SPAREDTICKTS')?></h2>
        <label style="display: inline" for="sinceSpared"><?php echo JText::_('COM_ATS_COMMON_FROMDATE')?></label>
        <?php
            $since = new JDate('-1 month');
            echo JHTML::calendar($since->format('Y-m-d'), 'sinceSpared', 'sinceSpared', '%Y-%m-%d', array('class'=> 'input-small'));
        ?>

        <label style="display: inline" for="untilSpared"><?php echo JText::_('COM_ATS_COMMON_TODATE')?></label>
        <?php echo JHTML::calendar(date('Y-m-d'), 'untilSpared', 'untilSpared', '%Y-%m-%d', array('class'=> 'input-small'));?>

        <button class="btn btn-primary pull-right" id="reloadSpared">
            <i class="icon-white icon-refresh"></i>
            <?php echo JText::_('COM_ATS_COMMON_RELOADGRAPHS') ?>
        </button>

        <div id="aksparedtickets" style="height:300px">
            <img id="akthrobberspared" src="<?php echo F0FTemplateUtils::parsePath('media://com_ats/images/throbber.gif')?>" />
            <p id="aknodataspared" style="display:none">
                <?php echo JText::_('COM_ATS_CPANEL_STATS_NODATA')?>
            </p>
        </div>

    <?php if($params->get('userfeedback', 0) && ATS_PRO):

            $interval['week']  = '7 days';
            $interval['month'] = '30 days';
            $interval['year']  = '365 days';
            $interval['all']   = -1;

            $ratings = F0FModel::getTmpInstance('Tickets', 'AtsModel')
                        ->getRatings($interval);
        ?>
        <div style="margin-top:20px">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="userfeedback">
                <thead>
                    <tr>
                        <th><?php echo JText::_('JGLOBAL_USERNAME') ?></th>
                        <th style="width: 15%"><?php echo JText::_('COM_ATS_CPANEL_RATING_LAST7DAYS') ?></th>
                        <th style="width: 15%"><?php echo JText::_('COM_ATS_CPANEL_RATING_LAST30DAYS') ?></th>
                        <th style="width: 15%"><?php echo JText::_('COM_ATS_CPANEL_RATING_LAST365DAYS') ?></th>
                        <th style="width: 15%"><?php echo JText::_('COM_ATS_CPANEL_RATING_OVERALL') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($ratings as $rating):?>
                    <tr>
                        <td><?php echo $rating['user']?></td>
                        <td><?php echo isset($rating['week'])  ? $rating['week']  : 0 ?></td>
                        <td><?php echo isset($rating['month']) ? $rating['month'] : 0 ?></td>
                        <td><?php echo isset($rating['year'])  ? $rating['year']  : 0 ?></td>
                        <td><?php echo isset($rating['all'])   ? $rating['all']   : 0 ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
	</div>

	<div class="span6">
		<h3><?php echo JText::_('COM_ATS_CPANEL_STATS')?></h3>
		<table width="100%" class="table table-striped">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th><?php echo JText::_('COM_ATS_TICKETS_STATUS_O') ?></th>
					<th><?php echo JText::_('COM_ATS_TICKETS_STATUS_P') ?></th>
					<th><?php echo JText::_('COM_ATS_TICKETS_STATUS_C') ?></th>
					<th><?php echo JText::_('COM_ATS_TICKETS_STATUS_TOTAL') ?></th>
				</tr>
			</thead>
			<tbody>
				<tr class="row0">
					<th><?php echo JText::_('COM_ATS_TICKETS_PUBLIC_PUBLIC') ?></th>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=O&public=1&enabled=1">
						<?php
							$public_open = F0FModel::getTmpInstance('Tickets','AtsModel')
								->savestate(0)
								->status('O')
								->public(1)
								->enabled(1)
								->getTotal();
							echo $public_open;
						?>
						</a>
					</td>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=P&public=1&enabled=1">
						<?php
							$public_pending = F0FModel::getTmpInstance('Tickets','AtsModel')
								->savestate(0)
								->status('P,1,2,3,4,5,6,7,8,9')
								->public(1)
								->enabled(1)
								->getTotal();
							echo $public_pending;
						?>
						</a>
					</td>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=C&public=1&enabled=1">
						<?php
							$public_closed = F0FModel::getTmpInstance('Tickets','AtsModel')
								->savestate(0)
								->status('C')
								->public(1)
								->enabled(1)
								->getTotal();
							echo $public_closed;
						?>
						</a>
					</td>
					<th>
						<a href="index.php?option=com_ats&view=tickets&status=&public=1&enabled=1">
						<?php
							echo $public_open + $public_closed + $public_pending;
						?>
						</a>
					</th>
				</tr>
				<tr class="row1">
					<th><?php echo JText::_('COM_ATS_TICKETS_PUBLIC_PRIVATE') ?></th>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=O&public=0&enabled=1">
						<?php
							$private_open = F0FModel::getTmpInstance('Tickets','AtsModel')
								->savestate(0)
								->status('O')
								->public(0)
								->enabled(1)
								->getTotal();
							echo $private_open;
						?>
						</a>
					</td>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=P&public=0&enabled=1">
						<?php
							$private_pending = F0FModel::getTmpInstance('Tickets','AtsModel')
								->savestate(0)
								->status('P,1,2,3,4,5,6,7,8,9')
								->public(0)
								->enabled(1)
								->getTotal();
							echo $private_pending;
						?>
						</a>
					</td>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=C&public=0&enabled=1">
						<?php
							$private_closed = F0FModel::getTmpInstance('Tickets','AtsModel')
								->savestate(0)
								->status('C')
								->public(0)
								->enabled(1)
								->getTotal();
							echo $private_closed;
						?>
						</a>
					</td>
					<th>
						<a href="index.php?option=com_ats&view=tickets&status=&public=0&enabled=1">
						<?php
							echo $private_open +$private_closed + $private_pending;
						?>
						</a>
					</th>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th><?php echo JText::_('COM_ATS_TICKETS_STATUS_TOTAL') ?></th>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=O&public=&enabled=1">
						<?php echo $public_open + $private_open ?>
						</a>
					</td>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=P&public=&enabled=1">
						<?php echo $public_pending + $private_pending ?>
						</a>
					</td>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=C&public=&enabled=1">
						<?php echo $public_closed + $private_closed ?>
						</a>
					</td>
					<td>
						<a href="index.php?option=com_ats&view=tickets&status=&public=&enabled=1">
						<?php echo $public_open + $private_open + $public_pending + $private_pending + $public_closed + $private_closed ?>
						</a>
					</td>
				</tr>
			</tfoot>
		</table>

		<h3><?php echo JText::_('COM_ATS_CPANEL_VERSIONINFO')?></h3>
		<p>
			Akeeba Ticket System <?php echo defined('ATS_PRO') && ATS_PRO ? 'Professional' : 'Core' ?>
			<?php echo ATS_VERSION ?>

			<a href="index.php?option=com_ats&view=update&task=force" class="btn btn-inverse btn-small">
				<?php echo JText::_('COM_ATS_CPANEL_MSG_RELOADUPDATE'); ?>
			</a>
		</p>
	</div>
</div>


<?php $xday = gmdate('Y-m-d', time() - 30 * 24 * 3600); ?>
<script type="text/javascript">
var ticketPoints = [];
var postsPoints = [];
var myMax = 0;
var myMax2 = 0;

(function($) {
	$(document).ready(function()
    {

    <?php if($params->get('userfeedback', 0) && ATS_PRO):?>
        $('#userfeedback').dataTable( {
            "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap"
        } );

        $.extend( $.fn.dataTableExt.oStdClasses, {
            "sWrapper": "dataTables_wrapper form-inline"
        } );
    <?php endif;?>

		var url = "index.php?option=com_ats&view=tickets&created_since=<?php echo $xday?>&enabled=1&groupbydate=1&public=&status=&format=json";
		$.jqplot.config.enablePlugins = true;
		$.getJSON(url, function(data){
			$.each(data, function(index, item){
				ticketPoints.push([item.date, item.tickets]);
				myMax = Math.max(myMax, item.tickets);
			});
			myMax++;
			if(ticketPoints.length == 0) {
				$('#akthrobber').hide();
				$('#aknodata').show();
				return;
			}

			url = "index.php?option=com_ats&view=posts&since=<?php echo $xday?>&enabled=1&groupbydate=1&public=&status=&format=json";
			$.getJSON(url, function(data){
				$.each(data, function(index, item){
					postsPoints.push([item.date, item.posts]);
					myMax2 = Math.max(myMax2, item.posts);
				});
				myMax2++;
				$('#akthrobber').hide();

				renderPlot();
			});
		});

        akeeba.jQuery('#reloadSpared').click(function(){
            $.ajax('index.php?option=com_ats&view=tickets&task=showspared&layout=spared&format=json', {
                dataType : 'json',
                cache : false,
                data : {
                    created_since : $('#sinceSpared').val(),
                    created_until : $('#untilSpared').val()
                },
                success : function(data){
                    $('#akthrobberspared').hide();
                    renderSpared(data.tickets, data.categories);
                }
            });
        });

        akeeba.jQuery('#reloadSpared').click();

		// Check for ATS updates
		$.ajax('index.php?option=com_ats&view=cpanel&task=updateinfo&tmpl=component', {
			success: function(msg, textStatus, jqXHR)
			{
				// Get rid of junk before and after data
				var match = msg.match(/###([\s\S]*?)###/);
				data = match[1];

				if (data.length)
				{
					$('#updateNotice').html(data);
				}
			}
		});
	});

    function renderSpared(tickets, categories)
    {
        $.jqplot('aksparedtickets', tickets, {
            // Tell the plot to stack the bars.
            stackSeries: true,
            captureRightClick: true,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                rendererOptions: {
                    barMargin: 30
                },
                pointLabels: {show: true}
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks   : categories,
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
                    tickOptions: {
                        angle: -80,
						labelPosition: 'end',
                        fontSize: '10pt'
                    }
                },
                yaxis : {
                    min : 0,
                    max : 100
                }
            },
            legend: {
                show: true,
                location: 'e',
                placement: 'outside'
            },
            series: [
                {label : '<?php echo JText::_('COM_ATS_CPANEL_OPENED')?>'},
                {label : '<?php echo JText::_('COM_ATS_CPANEL_SAVED')?>'}
            ],
            highlighter : {
                tooltipAxes : 'y',
                formatString : '%d%'
            }
        });
    }

	function renderPlot()
	{
		plot1 = $.jqplot('akticketschart', [ticketPoints, postsPoints], {
			show: true,
			axes:{
				xaxis:{renderer:$.jqplot.DateAxisRenderer,tickInterval:'1 week'},
				yaxis:{min: 0, max: myMax, tickOptions:{formatString:'%u'}},
				y2axis:{min: 0, max: myMax2, tickOptions:{formatString:'%u'}}
			},
			series:[
				{
					yaxis: 'yaxis',
					xaxis: 'xaxis',
					//color: '#aae0aa',
					lineWidth:1,
					renderer:$.jqplot.BarRenderer,
					rendererOptions:{barPadding: 0, barMargin: 0, barWidth: 5, shadowDepth: 0, varyBarColor: 0},
					markerOptions: {
						style:'none'
					}
				},
				{
					yaxis: 'y2axis',
					xaxis: 'xaxis',
					lineWidth:3,
					markerOptions:{
						style:'filledCircle',
						size:8
					},
					renderer: $.jqplot.hermiteSplineRenderer,
					rendererOptions:{steps: 60, tension: 0.6}
				}
			],
			highlighter: {sizeAdjust: 7.5},
			axesDefaults:{useSeriesColor: true}
		});
	}
})(akeeba.jQuery);
</script>

<div style="clear: both;"></div>