/**
 * Setup (required for Joomla! 3)
 */
if(typeof(akeeba) == 'undefined') {
    var akeeba = {};
}
if(typeof(akeeba.jQuery) == 'undefined') {
    akeeba.jQuery = jQuery.noConflict();
}

akeeba.jQuery(document).ready(function($){
    akeeba.jQuery('.select-status li a').click(function(){
        var image = akeeba.jQuery(this).parents('div.select-status').parent().find('img');

        var self = this;
        akeeba.jQuery.ajax('index.php?option=com_ats&view=tickets&task=ajax_set_status&format=json&'+jQuery('#token').attr('name')+'=1',{
            type : 'POST',
            dataType : 'json',
            data : {
                'id' 	 : akeeba.jQuery('input[name="ats_ticket_id"]').val(),
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
                    var label = akeeba.jQuery(self).parents('div.select-status').parent().find('span[class*="label-"]');
                    label.attr('class', 'label pull-right ' + responseJSON.ats_class).html(responseJSON.msg);
                }
            }
        })
    })
});