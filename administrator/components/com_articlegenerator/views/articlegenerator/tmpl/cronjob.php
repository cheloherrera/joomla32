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

JToolBarHelper::title('Cronjob', 'generic.png');
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
		<legend><?php echo JText::_( 'Post All / Cronjob' ); ?></legend>



<?php 
echo JHtml::_('bootstrap.startTabSet', 'cronjob', array('active' => 'Post_published_Feeds_manually'));
?>

<?php 
echo JHtml::_('bootstrap.addTab', 'cronjob', 'Post_published_Feeds_manually', JText::_('Post published Feeds manually', true));
?>

	<table class="table table-bordered table-striped table-hover">
		<thead>
				  <tr>
					  <th WIDTH="100%" ><?php echo JText::_( '<span style="font-size: 10pt;"><strong>If you have published one ore more Feeds in the Source Manager then you can post the published Feeds manually by clicking this button:' ); ?></th>
					</tr>
		</thead>
    <tbody>
		  <tr>
        <td WIDTH="100%">
        	<?php $path = str_replace('/administrator', '', JUri::base()); ?>  
          <div align="center"><?php echo JText::_( '<a href="'.$path. "components/com_articlegenerator/cronjob/cronjob.php". '" target="cronjob" title="Post published Feeds manually"><img src="components/com_articlegenerator/assets/images/cronjob_48.png" class="center" alt="Post published Feeds manually"  /><br />Post published Feeds manually</a><br /><br /></div>' );   ?>
          <div align="center"><iframe name="cronjob" style="border:1px #FFFFFF ridge;" scrolling="auto" frameborder="1"  marginheight="5px" marginwidth="5px" height="180" width="500"></iframe></div>
        </td>
      </tr>
    <tbody>						
	</table>	
	
<?php
echo JHtml::_('bootstrap.endTab');
?>

<?php 
echo JHtml::_('bootstrap.addTab', 'cronjob', 'install_Cronjob_on_a_server', JText::_('install Cronjob on a server', true));
?>

	<table class="table table-bordered table-striped table-hover">
		<thead>
				  <tr>
					  <th WIDTH="100%" ><?php echo JText::_( '<span style="font-size: 10pt;"><strong>This is the link that should be executed as Cronjob on your server:' ); ?></th>
				</tr>
		</thead>
    <tbody>
		  <tr>
        <td WIDTH="100%">
          <?php $path = str_replace('/administrator', '', JUri::base()); ?>
          <?php echo JText::_( '<div align="center"><br /><br /><span style="font-size: 10pt; color: #30ee11;"><strong>'.$path. "components/com_articlegenerator/cronjob/cronjob.php".'</strong></span><br /><br /></div>' );   ?>
          <?php echo JText::_( '<br /><br /><span style="font-size: 10pt;"><strong>Most users will probably want to use c-panel to execute the cronjob but maybe you need help from your hosting-service.<br /><br />The best solution is to use these free web-services to execute the cronjob-link above:<br /><br /><a target="_blank" title="Create an account at www.setcronjob.com" href="http://www.setcronjob.com/">Create an account at www.setcronjob.com</a> (english language)<br /><br /><a target="_blank" title="Create an account at www.cronjob.de" href="http://www.cronjob.de/">Create an account at www.cronjob.de</a> (german language)<br /><br /><br /><br />' );   ?>
        </td>
      </tr>
    <tbody>						
	</table>	

<?php 
echo JHtml::_('bootstrap.endTab');
?>

<?php 
echo JHtml::_('bootstrap.endTabSet');
?>	
	
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