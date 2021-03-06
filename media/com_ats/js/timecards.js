if(typeof(akeeba) == 'undefined') {
	var akeeba = {};
}
if(typeof(akeeba.jQuery) == 'undefined') {
	akeeba.jQuery = jQuery.noConflict();
}

var jsonurl = 'index.php?option=com_ats&view=timecards&format=json';
var timeChart;

function loadTimeGraph()
{
	akeeba.jQuery.ajax(jsonurl, {
		data    : {
			'sumtimespent'  : 1,
			'since'         : akeeba.jQuery('#time_start').val(),
			'until'         : akeeba.jQuery('#time_end').val(),
			'limit'         : 0,
			'limitstart'    : 0
		},
		dataType: 'json',
		cache   : false,
		beforeSend : function(jqXHR, settings ){
			akeeba.jQuery('#nodata-warn').hide();
		},
		success : function(json, status, jqXH){

			if(!json.data[0].length)
			{
				akeeba.jQuery('#nodata-warn').show();
			}

			var options = {
				data : json.data,
				highlighter: {
					show        : true,
					showMarker  : false,
					tooltipAxes : 'y'
				},
				seriesDefaults : {
					renderer: akeeba.jQuery.jqplot.BarRenderer,
					rendererOptions: {
						barMargin : 50
					}
				},
				axes:{
					yaxis : {
						label : Joomla.JText._('COM_ATS_COMMON_HOURS'),
						labelRenderer: akeeba.jQuery.jqplot.CanvasAxisLabelRenderer
					},
					xaxis : {
						label : Joomla.JText._('COM_ATS_COMMON_SUPPORT_STAFF'),
						labelRenderer: akeeba.jQuery.jqplot.CanvasAxisLabelRenderer,
						renderer : akeeba.jQuery.jqplot.CategoryAxisRenderer,
						ticks : json.labels,
						tickOptions: {
							fontSize: '10pt',
							labelPosition: 'middle'
						}
					}
				}
			};

			timeChart.replot(options)
		}
	});
}

akeeba.jQuery(document).ready(function(){
	timeChart = akeeba.jQuery.jqplot('ats-timecard', [[[]]] ,{});

	akeeba.jQuery('#time_graph_reload').click(function(){
		loadTimeGraph();
	});

	akeeba.jQuery('#time_graph_reload').click();
});