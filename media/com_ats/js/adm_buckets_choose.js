akeeba.jQuery(document).ready(function($){
    akeeba.jQuery('#addTickets').click(function(){
		if(document.adminForm.boxchecked.value == 0)
		{
			alert(akeeba.jQuery('#chooseone').val());
			return false;
		}
		
		if(document.adminForm.boxchecked.value > 1)
		{
			alert(akeeba.jQuery('#chooseonlyone').val());
			return false;
		}
		
		Joomla.submitbutton('addtickets');
	});
});