/**
 * Setup (required for Joomla! 3)
 */
if(typeof(akeeba) == 'undefined')
{
	var akeeba = {};
}

if(typeof(akeeba.jQuery) == 'undefined')
{
	akeeba.jQuery = jQuery.noConflict();
}

var ats_latestopen_active = 0;
var ats_latestopen_max = 10;
var ats_latestopen_id = 0;

akeeba.jQuery(document).ready(function($){
	function renderActiveReply()
	{
		akeeba.jQuery('tr.ats-latestopen-row').each(function(index, e){
			ats_latestopen_max = akeeba.jQuery(e).data('latestopensequence');
			
			if (akeeba.jQuery(e).data('latestopensequence') == ats_latestopen_active)
			{
				ats_latestopen_id = akeeba.jQuery(e).data('latestopenid');
                akeeba.jQuery(e).addClass('alert-success');
			}
			else
			{
                akeeba.jQuery(e).removeClass('alert-success');
			}
		});
	}

    akeeba.jQuery(document).keypress(function(event){
		if (event.which == 106)
		{
			// Try to go up
			if (ats_latestopen_active > 1)
			{
				event.preventDefault();
				
				ats_latestopen_active--;
				renderActiveReply();
			}
		}
		else if (event.which == 107)
		{
			// Try to go down
			if (ats_latestopen_active < ats_latestopen_max)
			{
				event.preventDefault();
				
				ats_latestopen_active++;
				renderActiveReply();
			}
		}	
		else if (event.which == 13)
		{
			// ENTER key pressed, use the current reply
			event.preventDefault();
			
			window.location = akeeba.jQuery('#ats-latestopenlink-' + ats_latestopen_active).attr('href');
		}
		//else { alert(event.which) }
	})

    akeeba.jQuery('#ats-cannedreplies').focus();
	renderActiveReply();
});