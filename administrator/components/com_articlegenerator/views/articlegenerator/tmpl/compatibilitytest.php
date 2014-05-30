<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################


## Check if the file is included in the Joomla Framework
defined('_JEXEC') or die ('No Acces to this file!');

## Setting the toolbars up here..

JToolBarHelper::title('Compatibility Test', 'generic.png');
//JToolBarHelper::save('savearticlegeneratorconfig');

//if ($this->dataconfig->id < 1)  {
//	## Cancel the operation
//	JToolBarHelper::cancel();
//} else {
//	## For existing items the button is renamed `close`
//	JToolBarHelper::cancel( 'cancel', 'Close' );
//};

JHtml::_('bootstrap.tooltip');


?>
<script language="javascript" type="text/javascript">

Joomla.submitbutton = function(pressbutton)
{
	
	var form = document.adminForm;

	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	
	
	
	else {
		
		submitform( pressbutton );
	}
}





//-->
</script>

		 	
									 	
									 	
<form action = "index.php" method="POST" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Compatibility Test' ); ?></legend>

		<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
				  <tr>
					<th WIDTH="100%" ></th>
					</tr>
		</thead>
    <tbody>
		<tr>
      <td class="key">
        <div align="center"><iframe src="<?php echo JUri::base(). "components/com_articlegenerator/fulltextrss/libraries/simplepie/compatibility_test/sp_compatibility_test.php"; ?>" style="border:1px #FFFFFF ridge;" name="Compatibility Test" scrolling="no" frameborder="1" align=aus marginheight="5px" marginwidth="5px" height="725" width="800"></iframe></div>
      </td>
     
    </tr>


		
		
	
    <tbody>						
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type= "hidden" name="id" value="<?php echo $this->data->id; ?>" />
<input type= "hidden" name="option" value="com_articlegenerator" />
<input type= "hidden" name="controller" value="articlegenerator" />
<input type= "hidden" name="task" value="articlegeneratorconfig" />


<div>
<fieldset><legend>ArticleGenerator</legend>
<table cellpadding="2" cellspacing="0" border="0">
	<br />	
	<?php echo JText::_('ARTICLEGENERATOR'); ?>
</table>
</fieldset>
</div>
</form>									 	