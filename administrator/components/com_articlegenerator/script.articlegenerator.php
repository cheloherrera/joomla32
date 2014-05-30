<?php
######################################################################
# Article-Generator	          	                                     #
# Copyright (C) 2013 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 2.2                        	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################


// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
//the name of the class must be the name of your component + InstallerScript
//for example: com_contentInstallerScript for com_content.
class com_articlegeneratorInstallerScript
{



        /*
         * $parent is the class calling this method.
         * $type is the type of change (install, update or discover_install, not uninstall).
         * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
         * If preflight returns false, Joomla will abort the update and undo everything already done.
         */
        function preflight( $type, $parent ) {
                
                // get information about versions and update schemas und show it
                $jversion = new JVersion();
 
                // Installing component manifest file version
                $this->release = $parent->get( "manifest" )->version;
 
                // Manifest file minimum Joomla version
                $this->minimum_joomla_release = $parent->get( "manifest" )->attributes()->version;   
 
                // Show the essential information at the install/update back-end
                echo '<p>Current Article-Generator Version: ' . $this->getManifest('version');
                echo '<br />Installing Article-Generator Version: ' . $this->release;
                
                $ExtensionID = $this->getExtensionID('extension_id');
//                echo '<br />Current extension_id in #__extensions: ' . $ExtensionID;
                if ( $ExtensionID != '' ) {
                				$version_id = $this->getSchemas('version_id');                				
                			  }                                
                else { $version_id = ''; }
//                echo '<br />Current version_id in #__schemas: ' . $version_id;
  
                echo '<br /><br />Current Joomla Version: ' . $jversion->getShortVersion();
                echo '<br />Minimum Joomla Version: ' . $this->minimum_joomla_release;



								// this component does not work with Joomla releases prior to 3.1, The possible operators are: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne
								if( version_compare( $jversion->getShortVersion(), '3.1', 'lt' ) ) {
					 			Jerror::raiseWarning(null, 'Cannot install this version of Article-Generator in a Joomla release prior to 3.1. You can find an new Version on the <a href="http://www.suchmaschinen-optimierung-seo.org/index.php/SEO-Nachrichten/article-generator.html" target="blank">official Article-Generator website</a>');
					 			
					 			return false;
					
					 			
					 			}


					
							  // this component does not work with PHP releases prior to 5.0, The possible operators are: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne
								if (version_compare(PHP_VERSION, '5', 'lt' )) {
					 			Jerror::raiseWarning(null, 'Cannot install this version of Article-Generator in a PHP release prior to 5.0. Your server currently uses ' . PHP_VERSION . '. Please update PHP on your server or contact the developer of Article-Generator with the <a href="http://www.suchmaschinen-optimierung-seo.org/index.php/component/option,com_dfcontact/Itemid,2/" target="blank">official Article-Generator contact form</a>');
					 			
					 			return false;
					 			
					 			}


 
//                // abort if the component being installed is not newer than the currently installed version
//                if ( $type == 'update' ) {
//                        $oldRelease = $this->getManifest('version');
//                        $rel = $oldRelease . ' to ' . $this->release;
//                        if ( version_compare( $this->release, $oldRelease, 'le' ) ) {
//                                Jerror::raiseWarning(null, 'Incorrect version sequence. Currently installed version is newer. Cannot upgrade ' . $rel);
//                                return false;
//                        }
//                }
//                else { $rel = $this->release; }
              
                
                
                // set update schema version if not exists in #__schemas (first version with update-sql-file is 2.1)
                $oldRelease = $this->getManifest('version');
                if ( $version_id == '' and $ExtensionID != '' ) {
                				$set_version_id = $oldRelease;
                				$this->setversion_id( $ExtensionID, $set_version_id );
                				
                			  }                                
                else { }
            

                echo '<p>' . JText::_('Article-Generator ' . $type . ' ' . $rel) . '</p>';

        }
        
        
        
 
        /*
         * $parent is the class calling this method.
         * install runs after the database scripts are executed.
         * If the extension is new, the install method is run.
         * If install returns false, Joomla will abort the install and undo everything already done.
         */
        function install( $parent ) {
        	
	

	        	
        	
                echo '<p>' . JText::_('Article-Generator install to ' . $this->release) . '</p>';
                // You can have the backend jump directly to the newly installed component configuration page
                // $parent->getParent()->setRedirectURL('index.php?option=com_articlegenerator');
        }
        
        
 
 
        /*
         * $parent is the class calling this method.
         * update runs after the database scripts are executed.
         * If the extension exists, then the update method is run.
         * If this returns false, Joomla will abort the update and undo everything already done.
         */
        function update( $parent ) {
                echo '<p>' . JText::_('Article-Generator update to ' . $this->release) . '</p>';
                // You can have the backend jump directly to the newly updated component configuration page
                // $parent->getParent()->setRedirectURL('index.php?option=com_articlegenerator');
        }
       
        
        
 
        /*
         * $parent is the class calling this method.
         * $type is the type of change (install, update or discover_install, not uninstall).
         * postflight is run after the extension is registered in the database.
         */
        function postflight( $type, $parent ) {
        	// The postflight method is a good place to set the default values of component parameters during installs, and to set the values
        	// of hidden component parameters during installs and updates.
                // always create or modify these parameters
//                $params['my_param0'] = 'Component version ' . $this->release;
//                $params['my_param1'] = 'Another value';
// 
//                // define the following parameters only if it is an original install
//                if ( $type == 'install' ) {
//                        $params['my_param2'] = '4';
//                        $params['my_param3'] = 'Star';
//                }
// 
//                $this->setParams( $params );
 
                echo '<p>' . JText::_('Article-Generator ' . $type . ' to ' . $this->release) . '</p>';
        }
 
 
 
 
        /*
         * $parent is the class calling this method
         * uninstall runs before any other action is taken (file removal or database processing).
         */
        function uninstall( $parent ) {
        				
       	
        	
        	
        	
        	
                echo '<p>' . JText::_('Article-Generator uninstall ' . $this->release) . '</p>';
        }
 
 
 
 
 
 
 
 
 // other functions used to get this functions above running
 
 
  
        /*
         * get a variable from the manifest file (actually, from the manifest cache).
         */
        function getManifest( $name ) {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "com_articlegenerator"');
                $manifest = json_decode( $db->loadResult(), true );
                return $manifest[ $name ];
        }




        /*
         * get extension_id from #__extensions
         */
        function getExtensionID( $name ) {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT extension_id FROM #__extensions WHERE name = "com_articlegenerator"');
                $ExtensionID = $db->loadResult();
                return $ExtensionID;
        }



        
        /*
         * get version_id from #__schemas
         */
        function getSchemas( $name ) {
                $db = JFactory::getDbo();
                $ExtensionID = $this->getExtensionID('extension_id');
                $db->setQuery('SELECT version_id FROM #__schemas WHERE extension_id = '. $ExtensionID .'');
                $version_id = $db->loadResult();
                return $version_id;
        }
  
  
  
  
        /*
         * sets extension_id and version_id into #__schemas if not exists (first version with update-sql-file is 2.1)
         */
        function setversion_id( $ExtensionID, $set_version_id ) {
        	      // Get a db connection.
								$db = JFactory::getDbo();
 								// Create a new query object.
								$query = $db->getQuery(true);
 								// Insert columns.
								$columns = array('extension_id', 'version_id');		
 								// Insert values.
								$values = array($db->quote( $ExtensionID ), $db->quote( $set_version_id ));
 								// Prepare the insert query.								
								$query
    								->insert($db->quoteName('#__schemas'))
    								->columns($db->quoteName($columns))
    								->values(implode(',', $values));   								
								// Reset the query using our newly populated query object.
								$db->setQuery($query);
								try {
								    // Execute the query in Joomla 3.0.
								    $result = $db->execute();
								} catch (Exception $e) {
								    // catch any database errors.
								}


        }  
  
  
  
 
        /*
         * sets parameter values in the component's row of the extension table
         */
//        function setParams($param_array) {
//                if ( count($param_array) > 0 ) {
//                        // read the existing component value(s)
//                        $db = JFactory::getDbo();
//                        $db->setQuery('SELECT params FROM #__extensions WHERE name = "com_articlegenerator"');
//                        $params = json_decode( $db->loadResult(), true );
//                        // add the new variable(s) to the existing one(s)
//                        foreach ( $param_array as $name => $value ) {
//                                $params[ (string) $name ] = (string) $value;
//                        }
//                        // store the combined new and existing values back as a JSON string
//                        $paramsString = json_encode( $params );
//                        $db->setQuery('UPDATE #__extensions SET params = ' .
//                                $db->quote( $paramsString ) .
//                                ' WHERE name = "com_articlegenerator"' );
//                                $db->query();
//                }
//        }
}












?>