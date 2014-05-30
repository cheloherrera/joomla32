akeeba.jQuery(document).ready(function($){
	function atsAssignmentClick()
	{
		var parent 	  = akeeba.jQuery(this).parent('td');
		var id	   	  = akeeba.jQuery(this).parents('td').find('input.ticket_id').val();
		var hide   	  = ['.loading img', '.loading .icon-warning-sign'];
		var show   	  = ['.loading .icon-ok'];
		var assign_to = 0;
		
		if(akeeba.jQuery(this).hasClass('assignme'))
		{
			assign_to = akeeba.jQuery('#user').val();
		}
		else if(akeeba.jQuery(this).parent('.assignto'))
		{
			assign_to = akeeba.jQuery(this).parent().find('input.assignto').val();
		}
		
		if(this.hasClass('unassign')){
			hide.push('.unassign');
			show.push('.assignme');
		}
		else{
			hide.push('.assignme');
			show.push('.unassign');
		}
		
		var structure = {
			_rootElement: this,
			type: "POST",
			dataType: 'json',
			url : 'index.php?option=com_ats&view=ticket&format=json&' + akeeba.jQuery('#token').attr('name') + '=1',
			data: {
				'task' : 'assign',
				'id'   : id,
				'assigned_to' : assign_to
			},
			beforeSend: function() {
				var wait = akeeba.jQuery(this._rootElement).parents('td').find('.loading');
				wait.css('display','inline').find('i').css('display', 'none');
				wait.find('img').css('display', 'inline-block');
			},
			success: function(responseJSON)
			{
				var assigned = akeeba.jQuery(this._rootElement).parents('td').find('.assigned_to');
				var unassign = akeeba.jQuery(this._rootElement).hasClass('unassign');
				
				if(responseJSON.result == true){
					assigned.html(responseJSON.assigned);
					unassign ? assigned.removeClass('badge-info') : assigned.addClass('badge-info');
					for (var i = 0; i < hide.length; i++)
					{
						var elementDefinition = hide[i];
                        akeeba.jQuery(this._rootElement).parents('td').find(elementDefinition).css('display', 'none');
					}
					for (var i = 0; i < show.length; i++)
					{
						var elementDefinition = show[i];
                        akeeba.jQuery(this._rootElement).parents('td').find(elementDefinition).css('display', 'inline-block');
					}
				}
				else
				{
					var wait = akeeba.jQuery(this._rootElement).parents('td').find('.loading');
					wait.find('.icon-ok,img').css('display', 'none');
					wait.find('.icon-warning-sign').show('fast');
				}
			}
		};

        akeeba.jQuery.ajax( structure );
	}

    akeeba.jQuery('.unassign a').click(atsAssignmentClick);
    akeeba.jQuery('.assignme a').click(atsAssignmentClick);
    akeeba.jQuery('.assignto li a').click(atsAssignmentClick);
	
	akeeba.jQuery('.select-status li a').click(function(){
		var image = akeeba.jQuery(this).parents('td').find('img');

		var self = this;
        akeeba.jQuery.ajax('index.php?option=com_ats&view=tickets&task=ajax_set_status&format=json&'+akeeba.jQuery('#token').attr('name')+'=1',{
			type : 'POST',
			dataType : 'json',
			data : {
				'id' 	 : akeeba.jQuery(this).parents('tr').find('input[name="cid[]"]').val(),
				'status' : akeeba.jQuery(this).data('status')
			},
			beforeSend : function(){
				image.show();
			},
			success : function(responseJSON){
				image.hide();
				
				if(responseJSON.err){
					alert(responseJSON.err);
				}
				else{
					var label = akeeba.jQuery(self).parents('td').find('[class*="ats-ticket-status-"]');
					label.attr('class', responseJSON.ats_class).html(responseJSON.msg);
				}
			}
		})
	})
});

akeeba.jQuery(document).ready(function($){
    akeeba.jQuery('#bucketadd').click(function(){
		if(document.adminForm.boxchecked.value == 0)
		{
			alert(akeeba.jQuery('#warnmessage').val());
			return false;
		}
		
		var href = akeeba.jQuery('#bucketadd').attr('href');

        akeeba.jQuery('input[name="cid[]"]:checked').each(function(i, item){
			href += '&ats_ticket_id[]=' + akeeba.jQuery(item).val();
		})
		
		// Inject selected tickets into the url
        akeeba.jQuery('#bucketadd').attr('href', href);
		
		SqueezeBox.open(this, {'handler' : 'iframe', 'size' : {'x' : 1050, 'y' : 550}});
		return false;
	});
});