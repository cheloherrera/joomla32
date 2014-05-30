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

JToolBarHelper::title('Source Details', 'generic.png');
JToolBarHelper::save('savearticlegenerator');

if ($this->data->id < 1)  {
	## Cancel the operation
	JToolBarHelper::cancel();
} else {
	## For existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
};

JHtml::_('bootstrap.tooltip');
$editor = JFactory::getEditor();

?>
<script language="javascript" type="text/javascript">

Joomla.submitbutton = function(pressbutton)
{
	
	var form = document.adminForm;

	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	
	// do field validation
	if (form.title.value == ""){
		alert( "<?php echo JText::_('Source must have a title' ); ?>" );
		form.title.focus();
	} 

	else if (form.feed_url.value == ""){
		alert( "<?php echo JText::_('Enter the Source-Url ' ); ?>" );
		form.feed_url.focus();
	} 

	
	else if (document.adminForm.catid.options[document.adminForm.catid.selectedIndex].value== 0||
		document.adminForm.catid.options[document.adminForm.catid.selectedIndex].value== -1){
		alert( "<?php echo JText::_('Select the Category where the new articles should be saved' ); ?>" );
		form.catid.focus();
	} 
	
	
	else {
		
		submitform( pressbutton );
	}
}



function changeDynaList() {
	
	var sectioncategories = new Array;
		<?php
		$i = 0;
		foreach ($this->sectioncategories as $k=>$items) {
			foreach ($items as $v) {
				echo "sectioncategories[".$i++."] = new Array( '$k','".addslashes( $v->id )."','".addslashes( $v->title )."' );\n\t\t";
			}
		}
		?>
	
	var list = eval( 'document.adminForm.catid' );
	
	var source=sectioncategories;
	var key=document.adminForm.catid.options[document.adminForm.sectionid.selectedIndex].value;
	var orig_key=0;
	var orig_val=0;
	for (i in list.options.length) {
		list.options[i] = null;
	}
	i = 0;
	for (x in source) {
		if (source[x][0] == key) {
			opt = new Option();
			opt.value = source[x][1];
			opt.text = source[x][2];

			if ((orig_key == key && orig_val == opt.value) || i == 0) {
				opt.selected = true;
			}
			list.options[i++] = opt;
		}
	}
	list.length = i;
	
}


//-->
</script>



									 	
									 	
									 	
									 	
<form action = "index.php" method="POST" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Source Details' ); ?></legend>

     
<?php 
echo JHtml::_('bootstrap.startTabSet', 'sourcedetails', array('active' => 'Source_Details'));
?>

<?php
echo JHtml::_('bootstrap.addTab', 'sourcedetails', 'Source_Details', JText::_('Source Details', true));
?>

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
        <?php echo JText::_( 'Source-Name:' ); ?>
      </td>
			<td>
				<input class="text_area" type="text" name="title" id="title" size="53" maxlength="250" value="<?php echo $this->data->title;?>" />
			</td>
			<td>
				<strong>Source-Name</strong><br />You can choose any name to identify the different sources.<br />
			</td>
		</tr>
		<tr>
			<td class="key">
        <?php echo JText::_( 'Source-Url:' ); ?>
      </td>
			<td>
			  <textarea name="feed_url" id="feed_url" cols="30" rows="10"><?php echo $this->data->feed_url;?></textarea>
			</td>
			<td>
				<strong>Source-Url</strong><br />You can insert any Source-Url you like, e.g. Feed-Url or Website-Url. If the Source-Feed in the browser is shown ok than copy and paste the url from the browser. If you have inserted a Website-Url, then you must enable the option "extract fulltext" in the "Source Options".<br />
			</td>
		</tr>	      
		<tr>
      <td class="key">
        <?php echo JText::_( 'Language:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['language'];?>
		  </td>
		  <td>
				<strong>Language</strong><br />You can choose the Language of the sources<br />
			</td>
    </tr>	
	  </tbody>		
  </table>

<?php
echo JHtml::_('bootstrap.endTab');
?>

<?php
echo JHtml::_('bootstrap.addTab', 'sourcedetails', 'Source_Options', JText::_('Source Options', true));
?>

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
        <?php echo JText::_( 'extract Fulltext:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['extractfulltext'];?>
		  </td>
		  <td>
				<strong>extract Fulltext - UNDER DEVELOPING - ONLY FOR TESTING IN THIS VERSION</strong><br />If this option is enabled, you extract content from an standard HTML page. Or you extract fulltext content from a normal Intro-Feed. This extraction is in most cases without pictures. You get as much text content. But please note the copyright and ask if in doubt the author!<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'switch Feed-Intro and Feed-Full:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['switchintrofull'];?>
      </td>
      <td>
				<strong>switch Feed-Intro and Feed-Full</strong><br />You can switch the source-feed-intro and source-feed-fulltext before all other options work so sometimes you can make better articles depending on the layout of the source-feed.<br />
			</td>
    </tr>   
		<tr>
      <td class="key">
        <?php echo JText::_( 'Get Feed-Article which includes these Words:' ); ?>
      </td>
			<td>
			  <textarea name="keywords" id="keywords" cols="30" rows="1"><?php echo $this->data->keywords;?></textarea>
			</td>
			<td>
				<strong>Get Feed-Article which includes these Words</strong><br />Generate article only if the following words existing in Source-Article. Separate your keywords with ", " If left blank, then  Article-Generator will generate an article for each Source-Article.<br />
			</td>
		</tr>	
		<tr>
      <td class="key">
        <?php echo JText::_( 'Do not get Feed-Article which includes these NegativeWords:' ); ?>
      </td>
			<td>
			  <textarea name="negkey" id="negkey" cols="30" rows="1"><?php echo $this->data->negkey;?></textarea>
			</td>
			<td>
				<strong>Do not get Feed-Article which includes these NegativeWords</strong><br />Generate article only if the following words <strong>not</strong> existing in Source-Article. Separate your keywords with ", " If left blank, then  Article-Generator will generate an article for each Source-Article.<br />
			</td>
		</tr>		
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Ignore Feed-Article:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['ignoreitem'];?>
      </td>
      <td>
				<strong>Ignore Feed-Article</strong><br />If this option is set to "yes", then "Minimum character count for Ignore Feed-Article" (below) is used to ignore articles with short article-intro!<br />
			</td>
    </tr>
	  <tr>
			<td class="key">
        <?php echo JText::_( 'Minimum character count for Ignore Feed-Article:' ); ?>
      </td>
			<td>
				<input class="text_area" type="text" name="minimum_count" id="minimum_count" size="53" maxlength="250" value="<?php echo $this->data->minimum_count;?>" />
			</td>
			<td>
				<strong>Minimum character count for Ignore Feed-Article</strong><br />Use a number ( e.g. 7 or 25 etc. )  to define how many characters the article-intro should have. If there are not enough characters inside the article-intro, then the article will be ignored. Or you can leave it blank to get all articles.<br />
			</td>
		</tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Duplicate Avoidance:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['avoiddup'];?>
      </td>
      <td>
				<strong>Duplicate Avoidance</strong><br />Article Generator uses a build in logic that prohibit the system from generating duplicate articles from the same source. Warning: duplicates can seriously hit your SEO. This checks also the archived and unpublished articles for duplicates. You must delete such old articles to get new articles!<br />
			</td>
    </tr>        
	  </tbody>		
  </table>


<?php 
echo JHtml::_('bootstrap.endTab');
?>

<?php 
echo JHtml::_('bootstrap.addTab', 'sourcedetails', 'Article_Options', JText::_('Article Options', true));
?>

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
        <?php echo JText::_( 'Post as user:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['users'];?>
      </td>
      <td>
				<strong>Post as user</strong><br />You can choose which user should be shown as author. You can leave it blank.<br />
			</td>
    </tr>
	  <tr>
      <td class="key">
        <?php echo JText::_( 'Category:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['catid'];?>
      </td>
      <td>
				<strong>Category</strong><br />Category where the new articles are saved.<br />
			</td>
    </tr>       
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Access Group:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['accessgrp'];?>
      </td>
      <td>
				<strong>Access Group</strong><br />You can choose the Access Group. Only users with these Access Group can read the article.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Show on Front Page:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['frontpage'];?>
      </td>
      <td>
				<strong>Show on Front Page</strong><br />If set to yes the new articles are also shown on FrontPage.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Valid For:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['validfor'];?>
      </td>
      <td>
				<strong>Valid For</strong><br />You can choose how long the new articles are published.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Auto Unpublish:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['autopublish'];?>
      </td>
      <td>
				<strong>Auto Unpublish</strong><br />Articles will be unpublished if the valid-for-time is left. <strong>You must set this option in the right way to the option above. If you choose "valid for ... days" then it must be set to "Yes". The combination "valid for ever" and "No" is creating the articles in the status "unpublished" and so you can work on them before publishing</strong>.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Set Feed-Date as created date:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['createddate'];?>
      </td>
      <td>
				<strong>Set Feed-Date as created date</strong><br />Your new article is created at that date that the feed-article is created. But not all feeds set there creation-date so it could be used 31.12.1999 from Joomla. If set to "No", then the date is set when you or the cronjob creates the new article.<br />
			</td>
    </tr>
	  </tbody>		
  </table>


<?php 
echo JHtml::_('bootstrap.endTab');
?>

<?php 
echo JHtml::_('bootstrap.addTab', 'sourcedetails', 'Article_Styling', JText::_('Article Styling', true));
?>

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
        <?php echo JText::_( 'Insert advertising-field:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['insertadvert'];?>
		  </td>
		  <td>
				<strong>Insert advertising-field</strong><br />If set to "yes" then it is possible to insert an own advertisement-field in the article. See field below.<br />
			</td>
    </tr>
		<tr>
      <td class="key">
        <?php echo JText::_( 'Advertising:' ); ?>
      </td>
			<td>
			  <textarea name="advert" id="advert" cols="30" rows="1"><?php echo $this->data->advert;?></textarea>
			</td>
			<td>
				<strong>Advertising</strong><br />You should insert: {loadposition user99} and create a custom-html-module on position user99. Insert there the advert-code. So you can change advertisment later. Now there is already such a modul, you only have to insert the advert-code and to choose "all" in the Menu Assignment. More details in the manual.<br />
			</td>
		</tr>					
	  <tr>
			<td class="key">
        <?php echo JText::_( 'Cut at Character:' ); ?>
      </td>
			<td>
				<input class="text_area" type="text" name="cutatcharacter" id="cutatcharacter" size="53" maxlength="250" value="<?php echo $this->data->cutatcharacter;?>" />
			</td>
			<td>
				<strong>Cut at Character</strong><br />Use a number ( e.g. 7 or 25 etc. )  to define how many characters the article-intro should have, or you can leave it blank if you would like the full intro to be viewed.<br />
			</td>
		</tr>	
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Combination Introtext/Fulltext/Advert:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['fulltext'];?>
      </td>
      <td>
				<strong>Combination Introtext/Fulltext/Advert</strong><br />Choose different stylings for your article. For more Details see in the manual.<br />
			</td>
    </tr>	
		<tr>
      <td class="key">
        <?php echo JText::_( 'Article Style for Intro:' ); ?>
      </td>
			<td>
      	<?php echo $editor->display( 'articleintrostyle',  $this->data->articleintrostyle, '250', '100', '20', '10', true, array()) ; ?>
			</td>
			<td>
				<strong>Article Style for Intro - UNDER DEVELOPING - NOT WORKING IN THIS VERSION</strong><br />You can choose to following Tags to create your Intro with HTML:<br />
			</td>
		</tr>	 	
		<tr>
      <td class="key">
        <?php echo JText::_( 'Article Style for Fulltext:' ); ?>
      </td>
			<td>
	      <?php echo $editor->display( 'articlefullstyle',  $this->data->articlefullstyle, '250', '100', '20', '10', true, array()) ; ?>
			</td>
			<td>
				<strong>Article Style for Fulltext - UNDER DEVELOPING - NOT WORKING IN THIS VERSION</strong><br />You can choose to following Tags to create your Fulltext with HTML:<br />
			</td>
		</tr>	 	
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Show Intro in readmore:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['showintro'];?>
      </td>
      <td>
				<strong>Show Intro in readmore</strong><br />Choose different stylings for your article. For more Details see in the manual.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Link-Handling Feed-Intro:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['feedlinksintro'];?>
      </td>
      <td>
				<strong>Link-Handling Feed-Intro</strong><br />You can choose to delete links from the source-feed-introtext from text or from images and you can choose to leave the text and images without the links or leave not.<br />
			</td>
    </tr>    
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Link-Handling Feed-Full:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['feedlinksfull'];?>
      </td>
      <td>
				<strong>Link-Handling Feed-Full</strong><br />You can choose to delete links from the source-feed-fulltext from text or from images and you can choose to leave the text and images without the links or leave not.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Image-Handling Feed-Intro:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['feedimageintro'];?>
      </td>
      <td>
				<strong>Image-Handling Feed-Intro</strong><br />You can choose to delete or leave images in the source-feed-introtext.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Image-Handling Feed-Full:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['feedimagefull'];?>
      </td>
      <td>
				<strong>Image-Handling Feed-Full</strong><br />You can choose to delete or leave images in the source-feed-fulltext.<br />
			</td>
    </tr>        
		<tr>
      <td class="key">
        <?php echo JText::_( 'Allow HTML Tags:' ); ?>
      </td>
			<td>
			  <textarea name="allowabletags" id="allowabletags" cols="30" rows="1"><?php echo $this->data->allowabletags;?></textarea>
			</td>			
			<td>
				<strong>Allow HTML Tags</strong><br />You can choose to delete or leave HTML Tags in the source-feed-text.a b br p img link strong ul li ol table script<br />Insert 'all' or 'none' or some single seperated by space. <strong>If this field is empty or set to 'none' then you will get no images or other html inside your article.</strong><br />
			</td>
		</tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Store Author:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['origauthor'];?>
      </td>
      <td>
				<strong>Store Author</strong><br />You can store the original-author as article-author-alias or as text. But in most cases it is not set in the source-feed.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Include Feed-Original-Date:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['origdate'];?>
      </td>
      <td>
				<strong>Include Feed-Original-Date</strong><br />If set to yes there will be a line in the article where the original-date from the feed is shown.<br />
			</td>
    </tr>
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Include link to Original-Article:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['includelink'];?>
      </td>
      <td>
				<strong>Include link to Original-Article</strong><br />In the article-text you find an "Read full article" which will take you to the Original-Article from the source.<br />
			</td>
    </tr> 
    <tr>
			<td class="key">
        <?php echo JText::_( 'Text for Readfullarticle-Button:' ); ?>
      </td>
			<td>
				<input class="text_area" type="text" name="readfullarticle" id="readfullarticle" size="53" maxlength="250" value="<?php echo $this->data->readfullarticle;?>" />
			</td>
			<td>
				<strong>Text for Readfullarticle-Button</strong><br />Enter the text you would like to be visible for the option above. <strong>e.g. 'Read full article on'</strong> <br />
			</td>
		</tr>       
	 	<tr>
      <td class="key">
        <?php echo JText::_( 'Open readmore link in JCE-Popup:' ); ?>
      </td>
      <td>
		    <?php echo $this->lists['jceboxlinks'];?>
      </td>
      <td>
				<strong>Open readmore link in JCE-Popup</strong><br />If set to yes then the link to the original-article will open in an lightbox-popup so the user don't leave your website so easily and will read more from your articles. <strong>Don't forget to enable the Menu Assignment in the backend of the plugin JCE-Mediabox after installing or creating new categories</strong>.<br />
			</td>
    </tr>                                       
		<tr>
			<td class="key">
        <?php echo JText::_( 'JCE Params if JCE-Popup is set to yes:' ); ?>
      </td>
			<td>
			  <textarea name="jceparams" id="jceparams" cols="30" rows="1"><?php echo $this->data->jceparams;?></textarea>
			</td>
			<td>
			<strong>JCE Params if JCE-Popup is set to yes</strong><br />It is possible to add additional styles to be applied to an popup, e.g.: width[640];height[480];autostart[true];loop[true];title[Google];group[groupname];styles[background-color:#000000,color:#ffffff] <br />Styles should be separate with a comma not a semi-colon as in HTML. Leaving the width and height values out will create a full screen popup. More Information you can find in the instructions of jcemediabox.<br />
			</td>
		</tr>	
	  </tbody>		
  </table>


<?php 
echo JHtml::_('bootstrap.endTab');
?>

<?php 
echo JHtml::_('bootstrap.addTab', 'sourcedetails', 'Authenticated_Sources', JText::_('Authenticated Sources', true));
?>

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
          <?php echo JText::_( 'Username' ); ?>:
        </td>
			  <td>
			    <input type="text" size="53" maxlength="250" name="username" value="<?php echo $this->data->username ?>"/>
			  </td>
			  <td>
				  <strong>Authenticated feeds</strong><br />It is only to set if the source-feed is password protected. You will get the password from the webmaster of the source-feed.<br />
			  </td>
	  	</tr>	
  	  <tr>
		  	<td class="key">
          <?php echo JText::_( 'Password' ); ?>:
        </td>
	  		<td>
	  		  <input type="password" size="53" maxlength="250" name="password" value="<?php echo $this->data->password ?>"/>
	  		</td>
  			<td>
    		</td>
	  	</tr>		 
    </tbody>
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
<input type= "hidden" name="task" value="savearticlegenerator" />


<div>
<fieldset><legend>ArticleGenerator</legend>
<table cellpadding="2" cellspacing="0" border="0">
	<br />	
	<?php echo JText::_('ARTICLEGENERATOR'); ?>
</table>
</fieldset>
</div>
</form>									 	