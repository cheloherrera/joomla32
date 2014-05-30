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

JToolBarHelper::title('Configuration', 'generic.png');
JToolBarHelper::save('savearticlegeneratorconfig');

if ($this->dataconfig->id < 1)  {
	## Cancel the operation
	JToolBarHelper::cancel();
} else {
	## For existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
};

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
		<legend><?php echo JText::_( 'Configuration' ); ?></legend>

		<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
				  <tr>
					<th WIDTH="15%" >Name</th>
					<th WIDTH="20%" >Value</th>
					<th width="65%" >Description</th>
					</tr>
		</thead>
    <tbody>
		<tr>
      <td class="key">
        <?php echo JText::_( 'Get with CURL:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['getwith'];?>
      </td>
			<td>
				<strong>Get with CURL</strong><br />CURL is a library that allows you to connect and communicate to many different types of servers with many different types of protocols. So you will get the source-feed. If set to "No" the php fopen is used. (more Information's are to find in the manual under D. Troubleshooting curl and fopen)<br />
			</td>      
    </tr>
		<tr>
      <td class="key">
        <?php echo JText::_( 'Insert credit ArticleGenerator:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['credit'];?>
      </td>
			<td>
				<strong>Insert credit ArticleGenerator</strong><br />This is a nearly invisible link that gives Article-Generator a bit of credit; the link will show on the right in the article and is nearly invisible on white backgrounds. Although I would love you to keep it but you're welcome to remove it.<br />
			</td>      
    </tr>
    <tr>
			<td class="key">
				<?php echo JText::_( 'Number of SEO-Keywords:' ); ?>
			</td>
			<td>
				<input class="text_area" type="text" name="countkeys" id="countkeys" size="53" maxlength="250" value="<?php echo $this->dataconfig->countkeys;?>" />
			</td>
			<td>
				<strong>Number of SEO-Keywords</strong><br />Total Number of SEO keywords article generator is allowed to create.<br />
			</td>
		</tr>    	
    <tr>
			<td class="key">
				<?php echo JText::_( 'Minimum length of SEO-Keywords:' ); ?>
			</td>
			<td>
				<input class="text_area" type="text" name="minLengthkeys" id="minLengthkeys" size="53" maxlength="250" value="<?php echo $this->dataconfig->minLengthkeys;?>" />
			</td>
			<td>
				<strong>Minimum length of SEO-Keywords</strong><br />The minimum length of an SEO keyword.<br />
			</td>
		</tr>    
		<tr>
      <td class="key">
        <?php echo JText::_( 'Use Title, Content or Both to generate Keywords:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['usetitle'];?>
      </td>
			<td>
				<strong>Use Title, Content or Both to generate Keywords</strong><br />If set to title, then keywords will be generated from the title and so on ....<br />
			</td>      
    </tr>
    <tr>
			<td class="key">
				<?php echo JText::_( 'Blacklist of SEO-Keywords:' ); ?>
			</td>
			<td>
			  <textarea name="blackListkeys" id="blackListkeys" cols="30" rows="2"><?php echo $this->dataconfig->blackListkeys;?></textarea>
			</td>
			<td>
				<strong>Blacklist of SEO-Keywords</strong><br />Do not use list, Article-Generator will not use any of the keywords in this list when generating SEO keywords. You can use the links below to copy and paste the keywords for your language:
			  <br /><a target="_blank" title="english-keyword-blacklist" href="components/com_articlegenerator/assets/english_keyword_blacklist.txt"><strong>english-keyword-blacklist</strong></a>
		  	<br /><a target="_blank" title="german-keyword-blacklist" href="components/com_articlegenerator/assets/german_keyword_blacklist.txt"><strong>german-keyword-blacklist</strong></a>		
			</td>
		</tr>	


		
		
	
    <tbody>						
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type= "hidden" name="id" value="<?php echo $this->dataconfig->id; ?>" />
<input type= "hidden" name="option" value="com_articlegenerator" />
<input type= "hidden" name="controller" value="articlegenerator" />
<input type= "hidden" name="task" value="savearticlegeneratorconfig" />


<div>
<fieldset><legend>ArticleGenerator</legend>
<table cellpadding="2" cellspacing="0" border="0">
	<br />	
	<?php echo JText::_('ARTICLEGENERATOR'); ?>
</table>
</fieldset>
</div>
</form>									 	