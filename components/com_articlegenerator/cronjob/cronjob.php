<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################


// this statement will show the folder where file resides
$path = dirname(__FILE__);
$path = str_replace("components\com_articlegenerator\cronjob", "", $path);
$path = str_replace("components/com_articlegenerator/cronjob", "", $path);
$path = str_replace("\\", "\\\\", $path);
//echo "your absolute path to joomla $path";

//change this variable to reflect joomla installation directory.
$joomladir = $path;

/////////////////////////////////////////////////////////////////////////////////////
// Don't change anything from here on, unless you know exactly what your're doing. //
/////////////////////////////////////////////////////////////////////////////////////

require_once("myemulated.php");
//ini_set("display_errors","0");
include_once($joomladir."/configuration.php");

global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang, $database,
    $mosConfig_mailfrom, $mosConfig_fromname,$noreturn,$my;

		define( '_JEXEC', 1 );
		define( 'JPATH_BASE', $joomladir );
		define( 'DS', DIRECTORY_SEPARATOR );
		define ('JPATH_COMPONENT_ADMINISTRATOR',JPATH_BASE.DIRECTORY_SEPARATOR."administrator/components/com_articlegenerator");
		
		// Load the framework
		require_once ( JPATH_BASE . 'includes' .DIRECTORY_SEPARATOR. 'defines.php' );
		require_once ( JPATH_BASE . 'includes' .DIRECTORY_SEPARATOR. 'framework.php' );
		require_once( JPATH_BASE .'administrator/includes'.DIRECTORY_SEPARATOR.'helper.php' );
		// create the mainframe object
		$mainframe = JFactory::getApplication( 'site' );
		
		// Initialize the framework
		$mainframe->initialise();
			
		// load system plugin group
		JPluginHelper::importPlugin( 'system' );
			
		// trigger the onBeforeStart events
		$mainframe->triggerEvent( 'onBeforeStart' );
		$lang = JFactory::getLanguage();
//		$mainframe->route();  // in Joomla 3.2: error: Call to protected method JApplicationSite::route() from context
//		$mosConfig_lang = $GLOBALS['mosConfig_lang'] = strtolower( $lang->getBackwardLang() );
			// Adjust the live site path
		$mosConfig_live_site = str_replace('/administrator/components/com_articlegenerator', '', JUri::base());
		$mosConfig_absolute_path = JPATH_BASE;
 		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DIRECTORY_SEPARATOR.'tables');

if (file_exists( $mosConfig_absolute_path. '/language/'.$mosConfig_lang.'.php' )) {
     require_once( $mosConfig_absolute_path. '/language/'.$mosConfig_lang.'.php' );
} elseif (file_exists( $mosConfig_absolute_path. '/language/english.php' )) {
     require_once( $mosConfig_absolute_path. '/language/english.php' );
}
 $my=new myEmulated();
 $my->id=493; //default id for administrator...

 echo "Cronjob starting at: ".Date("m/d/Y H:i:s")."<br/>\r\n";
 include($mosConfig_absolute_path."/administrator/components/com_articlegenerator/postsource.php");
 $db = JFactory::getDBO();	 
 $query = "SELECT id FROM #__articlegenerator WHERE published='1'";
 $db->setQuery($query);
 $ids = $db->loadObjectList();
   	foreach ($ids as $id)
  	{
     postallsourceitems($id->id);

				
				echo '<br><img src='.$mosConfig_live_site.'save_f2.png width="20" height="20" border="0"  />';
				echo ' '.$countFeedItem .' Item Saved ';
				echo "<br> Saved  Feed ID: ". $id->id;
		

		}






 echo "<br /><br />Ended Cronjob at: ".Date("m/d/Y H:i:s")."<br/>\r\n";
?>
