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

JHtml::_('bootstrap.tooltip');

## Adding the AJAX part to the dropdowns & Lightbox functions
$document = JFactory::getDocument();
$live_site = JUri::root();

## Include the toolbars for saving.

JToolBarHelper::title(   JText::_( 'Article-Generator V2' ), 'generic.png' );
JToolBarHelper::custom('showsource','preview','preview','Show Source',true);
JToolBarHelper::spacer();
JToolBarHelper::divider();
JToolBarHelper::spacer();
// JToolBarHelper::custom('postAll','apply','apply','Post Source',true);   
// JToolBarHelper::spacer();
// JToolBarHelper::divider();
JToolBarHelper::spacer();
JToolBarHelper::addNew('addarticlegenerator');
JToolBarHelper::editList('editarticlegenerator');
JToolBarHelper::deleteList('Are you sure you want to remove the selected Sources?','removearticlegenerator','Delete',true);		
//	JToolBarHelper::custom( 'copysave', 'copy.png', 'copy_f2.png', 'Copy', true );
JToolBarHelper::spacer();
JToolBarHelper::divider();
JToolBarHelper::spacer();
JToolBarHelper::publishList('articlegeneratorpublish');
JToolBarHelper::unpublishList('articlegeneratorunpublish');



//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');


//## Adding the AJAX part to the functions
//$document = JFactory::getDocument();
//$live_site = JUri::root();
?>


<script type="text/javascript">
	
var ajax = new Array();

Joomla.submitbutton = function(pressbutton)
{

// Ajax funtion use for save the content from rss feeds 

	if (pressbutton == 'postAll') {

		//document.getElementById('cb0').value;
 
	var cbs = document.adminForm.elements["cid[]"];
//	alert(cbs.length);
	if(!cbs.length){
			var feedID=document.getElementById('cb0').value;
			var url = '<?php echo $live_site;?>administrator/index.php?option=com_articlegenerator&controller=articlegenerator&task=postAll&format=raw&feedid='+feedID;	
			var updateDiv = "processing"+feedID;
			
			new Ajax(url, {
			method: 'get',
			update: updateDiv
			}).request();

			}


	
	
	document.getElementById('processing').innerHTML=' <img  src="components/com_articlegenerator/assets/images/process.gif" border="0"  /><br>Processing';

		
	for(var i=0; i<cbs.length; i++){
		if(cbs[i].checked){
			var feedID = cbs[i].value;
	
			var url = '<?php echo $live_site;?>administrator/index.php?option=com_articlegenerator&controller=articlegenerator&task=postAll&format=raw&feedid='+feedID;	
			var updateDiv = "processing"+feedID;
			
			new Ajax(url, {
			method: 'get',
			update: updateDiv
			}).request();

			}
		
		}

		// this code for end the process and hide the waiting process gif // 

		var feedID='end';
		var url = '<?php echo $live_site;?>administrator/index.php?option=com_articlegenerator&controller=articlegenerator&task=postAll&format=raw&feedid='+feedID;	
			//var updateDiv = "processing"+feedID;
			var updateDiv = "processing";
			new Ajax(url, {
			method: 'get',
			update: updateDiv
			}).request();
		
	}
	else {
		
		submitform( pressbutton );
		return;
	}
	
}

</script>


		 	





<form action="index.php" method="post" name="adminForm" id="adminForm">

<div align="center" id ='processing' ></div>
	<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
		<tr>
			<th width="20">
				<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
			</th>			
			<th width="20">
				<?php echo JHtml::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>				
				<?php echo JHtml::_('grid.sort',   'State', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="200">		
				<?php echo JHtml::_('grid.sort',   'Source-Name', 'title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>				
				<?php echo JHtml::_('grid.sort',   'Source-Url', 'feed_url', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort',   'Front Page', 'frontpage', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>			
			</th>			
			<th width="50">
				<?php echo JHtml::_('grid.sort',   'Vaild for', 'validfor', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort',   'Category', 'catid', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
				<?php echo JHtml::_('grid.sort',   'Order By', 'ordering', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th>
		    <?php echo JHtml::_('grid.order',  $this->items,'filesave.png', 'saveorderarticlegenerators'); ?>
			</th>				
		</tr>
	</thead>
	<?php	
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row        =$this->items[$i];
		$checked    = JHtml::_('grid.id', $i, $row->id );
		$option = JRequest::getCmd('option');
		$link 		  = JRoute::_( 'index.php?option=' .$option. '&controller=articlegenerator&view=articlegenerator&task=editarticlegenerator&cid='.$row->id.'' );
		$published 	= JHtml::_('grid.published', $row, $i,'publish_g.png','publish_x.png','articlegenerator' );
	
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $checked; ?>
			</td>
			<td align="center">
				<?php echo $row->id; ?>
			</td>
			<td align="center">
				<?php echo $published; ?>
			</td>			
			<td align="center">
				<a href="<?php echo $link; ?>"><?php echo $row->title; ?></a> <div id="processing<?php echo $row->id;?>"></div>
			</td>
			<td align="center">
				<a  target='_blank' href="<?php echo JRoute::_($row->feed_url); ?>"><?php echo $row->feed_url; ?></a>
			</td>
			<td align="center">
				<img src="images/<?php echo ( $row->frontpage ) ? 'tick.png' : ( $row->state != -1 ? 'publish_x.png' : 'disabled.png' );?>" width="16" height="16" border="0" alt="<?php echo ( $row->frontpage ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>" />
			</td>
			<td align="center">
				<?php if (round($row->validfor/86400) == 0) {echo 'Ever';} else {echo round($row->validfor/86400); echo ' Days';} ?>
				</td>			
			<td align="center">
				<?php	$category = JTable::getInstance('category'); $category->load($row->catid); ?><?php echo $category->title; ?>
			</td>
			<td class="order">
			  <span><?php echo $this->page->orderUpIcon( $i, true, 'orderup', 'Move Up', $ordering ); ?></span>
			  <span><?php echo $this->page->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
			  <?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
			</td>
			<td class="order">
			  <input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
		  </td>		  
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>




	
	<tfoot>
    <tr>
	<td colspan="13">
	  <?php echo $this->page->getListFooter(); ?>
	  <br />	
	  <div>
			<fieldset><legend>ArticleGenerator</legend>
				<table cellpadding="2" cellspacing="0" border="0">
					<td>
						<?php echo JText::_('ARTICLEGENERATOR'); ?>
					</td>  
				</table>
				</fieldset>
			</div>
	</td>
    </tr>
  </tfoot>
	
	
	</table>
</div>

<input type="hidden" name="option"           value="<?php echo $option; ?>" />
<input type="hidden" name="task"             value=""/>
<input type="hidden" name="boxchecked"       value="0"/>
<input type="hidden" name="controller"       value="articlegenerator"/>
<input type="hidden" name="view"             value="articlegenerators"/>
<input type="hidden" name="filter_order"     value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />




</form>	
									 	