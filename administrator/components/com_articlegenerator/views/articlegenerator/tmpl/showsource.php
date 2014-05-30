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

JToolBarHelper::title('Check Source Content', 'generic.png');
//JToolBarHelper::save('savecconfig');

if ($this->data->id < 1)  {
	## Cancel the operation
	JToolBarHelper::cancel();
} else {
	## For existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
};


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


<?php									 	
									 	

   $rssUrl=$this->data->feed_url;   
   $kyw=split(",",$this->data->keywords);
   $kwds=implode("|",$kyw);
   $keywords="/$kwds/";
   if (strlen($this->data->negkey)>0) {
      $neg=split(",",$this->data->negkey);
      $nkeywords=implode("|",$neg);
      $negkeywords="/".$nkeywords."/i";
    } else {
      $negkeywords="";
    }
   $catid=$this->data->catid;
//   $sectionid=$this->data->sectionid;
   $fulltext=$this->data->fulltext;
   $delay=$this->data->delay;
   require_once(JPATH_COMPONENT_ADMINISTRATOR.DIRECTORY_SEPARATOR."getsource.php");
   $items=rssUtil($rssUrl, array('keywords'=>"$keywords", 'negativekeywords'=>"$negkeywords", 'cuttag'=>$this->data->cutat, 'cache'=>0, 'debug'=>0, 'username'=>$this->data->username, 'password'=>$this->data->password, 'extractfulltext'=>$this->data->extractfulltext, 'cutatcharacter'=>$this->data->cutatcharacter, 'ignoreitem'=>$this->data->ignoreitem, 'minimum_count'=>$this->data->minimum_count, 'allowabletags'=>$this->data->allowabletags), $this->dataconfig->getwith);

?>
   
   
   <form action="index.php" method="post" name="adminForm" id="adminForm">
   <table  class="adminheading">
   <tr >
     <th class="title">
    	<?php  echo $items[0] ?>
     </th>
   </tr>
  </table>
  <table align="center" class="table table-bordered table-striped table-hover table-condensed"> 
  <tr >
     <th class="title">
    	<?php echo JText::_("Content from: "); echo $this->data->feed_url; ?>
     </th>
   </tr>
  </table>
   <table align="center" class="table table-bordered table-striped table-hover table-condensed">
  <tr>
   <th class='title' width="5%"><input type="checkbox" id='allcheck' name="allcheck" value="All" onclick='selectAll()' /></th> 
   <th class='title' width="5%">Article No.</th>   
   <th colspan='2' class='title' width="80%">Article Content</title> 
  </tr>
<?php
	//process the returned text array here...
	array_shift($items);
	for ($it=0;$it<count($items);$it++) {
	 $parts=split("\|",$items[$it]); //get all the parts
?>
	<tr>
		<th rowspan='6'>
			<input type="checkbox" name="cid[]" value="<?php echo $it ?>"/>
			<input type="hidden" name="contents[]" value="<?php echo $items[$it]?>"/>
		</th>
		<th rowspan='6'>
			<?php echo $it ?>
		</th>	
	</tr>	
  <tr>
  	<th>
			<strong><?php echo JText::_( 'Title:' ); ?></strong>
		</th>
  	<td>
			<a  href="<?php echo rawurldecode($parts[0]); ?>" target="_blank"><?php echo rawurldecode($parts[1]);?></a>
    </td>
  </tr>
  <tr>
  	<th>
			<strong><?php echo JText::_( 'Date:' ); ?></strong>
		</th>
  	<td>
			<?php echo rawurldecode($parts[2]); ?>
    </td>
  </tr>
  <tr>
  	<th>
			<strong><?php echo JText::_( 'Author:' ); ?></strong>
		</th>
  	<td>
			<?php echo rawurldecode($parts[6]); ?>
    </td>
  </tr>  
  <tr>
  	<th>
			<strong><?php echo JText::_( 'Intro-Text from Feed or selfcreated Fulltext:' ); ?></strong>
		</th>
  	<td>
			<?php echo rawurldecode($parts[3]); ?>
    </td>
  </tr>
  <tr>
  	<th>
			<strong><?php echo JText::_( 'Fulltext from Feed:' ); ?></strong>
		</th>
  	<td>
			<?php echo rawurldecode($parts[4]); ?>
    </td>
  </tr>




<?php
	} 
?>
  </table> 
<input type= "hidden" name="id" value="<?php echo $this->data->id; ?>" />
<input type= "hidden" name="option" value="com_articlegenerator" />
<input type= "hidden" name="controller" value="articlegenerator" />
<input type= "hidden" name="task" value="articlegenerator" />


<div><br /><br />
<fieldset><legend>ArticleGenerator</legend>
<table cellpadding="2" cellspacing="0" border="0">
	<br />	
	<?php echo JText::_('ARTICLEGENERATOR'); ?>
</table>
</fieldset>
</div>
</form>






<script type="text/javascript">
<!--
 function selectAll() {
   var form=document.forms[0];
   var ref=document.getElementById('allcheck').checked;
   for (i=0;i<form.elements.length;i++) {
     if (form.elements[i].type=='checkbox' && form.elements[i].name=='cid[]') {
       form.elements[i].checked=ref;
     }
  }
 }
-->
</script>

								 	