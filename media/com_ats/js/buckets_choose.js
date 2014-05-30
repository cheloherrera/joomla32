akeeba.jQuery(document).ready(function($){
    akeeba.jQuery('#addTickets').click(function(){
		var cbx = akeeba.jQuery('input[name="cid[]"]:checked');

		if(cbx.length == 0)
		{
			alert(akeeba.jQuery('#chooseone').val());
			return false;
		}
		
		if(cbx.length > 1)
		{
			alert(akeeba.jQuery('#chooseonlyone').val());
			return false;
		}
		
		// Ajax request
		var structure = {
			type: "POST",
			url: 'index.php?option=com_ats&view=buckets&task=addtickets&format=json',
			data : {
				'cid' : cbx[0].value,
				'ats_ticket_id' : document.id('ats_ticket_id').value
			},
			beforeSend: function() {
                akeeba.jQuery('#loading').show('fast');
			},
			success: function(responseJSON)
			{
                akeeba.jQuery('#loading').hide('fast');
				if(responseJSON == 'true')
				{
                    akeeba.jQuery('#saveok').show();
                    akeeba.jQuery('#saveko').hide();
					
					setTimeout(function(){parent.SqueezeBox.close()}, '500');
				}
				else
				{
                    akeeba.jQuery('#saveok').hide();
                    akeeba.jQuery('#saveko').show();
				}
			}
		};

        akeeba.jQuery.ajax( structure );
	});
})