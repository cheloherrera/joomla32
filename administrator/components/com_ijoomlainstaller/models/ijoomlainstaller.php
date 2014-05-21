<?php
/*------------------------------------------------------------------------
# com_adagency
# ------------------------------------------------------------------------
# author    iJoomla
# copyright Copyright (C) 2013 ijoomla.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.ijoomla.com
# Technical Support:  Forum - http://www.ijoomla.com/forum/index/
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

jimport ("joomla.aplication.component.model");

class ijoomlainstallerAdminModelijoomlainstaller extends InstallerModel {
	
	function __construct () {
		parent::__construct();
	}
	
	/// strart function added on 08-07-2013 to extract domain
	function extract_domain($domain){
		if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)){
			return $matches['domain'];
		} 
		else{
			return $domain;
		}
	}
	/// end function
	
	function skipHttp($domain){
		$domain = str_replace("https://", "", $domain);
		$domain = str_replace("http://", "", $domain);
		return $domain;
	}
	
	function getLicenseDetails($component){
		$page_content = "";
		
		if(function_exists('curl_init')){
			$domain = $_SERVER['HTTP_HOST'];
			$domain = $this->skipHttp($domain);
			//$domain = $this->extract_domain($domain);
			
			$url_first = "http://www.ijoomla.com/";
			if(strpos($component, "community") !== FALSE){
				$url_first = "http://www.jomsocial.com/";
			}
			
			$joomla = "2.5";
			if(version_compare(JVERSION, '3.0', 'ge')){
				$joomla = "3.0";
			}
			
			$url = $url_first."index.php?option=com_digistore&controller=digistoreAutoinstaller&task=get_license_details&tmpl=component&format=raw&component=".$component."&domain=".urlencode($domain)."&joomla=".$joomla;
			
			$ch = curl_init($url); // initialize curl with given url
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // add useragent
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
			if((ini_get('open_basedir') == '') && (ini_get('safe_mode') == 'Off')) {
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
			}
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // max. seconds to execute
			curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
			$page_content = @curl_exec($ch);
		}
		else{
			$page_content = "CURL_NOT_ENABLED";
		}
		
		if($page_content == "CURL_NOT_ENABLED"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_CURL_NOT_ENABLED"), 'error');
		}
		elseif($page_content == "NO_LICENCE"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_NO_VALID_LICENSE"), 'error');
		}
		else{
			return $page_content;
		}
	}
	
	function checkLicense(){
		$page_content = "";

		if(function_exists('curl_init')){
			$component = JRequest::getVar("component", "");
			
			$license = JRequest::getVar("license", array(), "post", "array");
			$license = $license[$component];
			
			$version = JRequest::getVar("version", array(), "post", "array");
			$version = $version[$component];
			
			$token_installer = JRequest::getVar("token_installer", "");
			
			if(trim($component) == "" || trim($license) == ""){
				$page_content = "NO_LICENCE";
			}
			else{
				$domain = $_SERVER['HTTP_HOST'];
				$domain = $this->skipHttp($domain);
				//$domain = $this->extract_domain($domain);
				$url_first = "http://www.ijoomla.com/";
				if(strpos($component, "community") !== FALSE){
					$url_first = "http://www.jomsocial.com/";
				}
				
				if(function_exists("curl_exec")){
					$joomla = "2.5";
					if(version_compare(JVERSION, '3.0', 'ge')){
						$joomla = "3.0";
					}
					
					$url = $url_first."index.php?option=com_digistore&controller=digistoreAutoinstaller&task=check_license&tmpl=component&component=".$component."&license=".$license."&domain=".urlencode($domain)."&token_installer=".$token_installer."&joomla=".$joomla."&version=".$version;
					$ch = curl_init($url); // initialize curl with given url
					curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // add useragent
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
					if((ini_get('open_basedir') == '') && (ini_get('safe_mode') == 'Off')) {
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
					}
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // max. seconds to execute
					curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
					$page_content = @curl_exec($ch);
				}
				else{
					$page_content = "CURL_EXEC_NOT_ENABLED";
				}
			}
		}
		else{
			$page_content = "CURL_NOT_ENABLED";
		}
		
		if($page_content == "LICENSE_EXPIRED"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_LICENSE_EXPIRED"), 'error');
		}
		elseif($page_content == "CURL_NOT_ENABLED"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_CURL_NOT_ENABLED"), 'error');
		}
		elseif($page_content == "CURL_EXEC_NOT_ENABLED"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_CURL_EXEC_NOT_ENABLED"), 'error');
		}
		elseif($page_content == "NO_LICENSE_FOR_DOMAIN"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_NO_LICENSE_FOR_DOMAIN"), 'error');
		}
		elseif($page_content == "NO_DOMAIN_FOR_LICENSE"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_NO_DOMAIN_FOR_LICENSE"), 'error');
		}
		elseif($page_content == "NO_LICENCE"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_NO_VALID_LICENSE"), 'error');
		}
		else{
			$_SESSION["licenseid"] = trim($license);
			echo $page_content;
		}
	}
	
	function renew(){
		$page_content = "";
		
		if(function_exists('curl_init')){
			$component = JRequest::getVar("component", "");
			$license = JRequest::getVar("license", array(), "request", "array");
			$license = $license[$component];
			$token_installer = JRequest::getVar("token_installer", "");
			
			if(trim($component) == "" || trim($license) == ""){
				$page_content = "NO_LICENCE";
			}
			else{
				$domain = $_SERVER['HTTP_HOST'];
				$domain = $this->skipHttp($domain);
				//$domain = $this->extract_domain($domain);

				$url_first = "http://www.ijoomla.com/";
				if(strpos($component, "community") !== FALSE){
					$url_first = "http://www.jomsocial.com/";
				}

				$url = $url_first."index.php?option=com_digistore&controller=digistoreAutoinstaller&task=renew&tmpl=component&component=".$component."&license=".$license."&domain=".urlencode($domain)."&token_installer=".$token_installer;
				$ch = curl_init($url); // initialize curl with given url
				curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // add useragent
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
				if((ini_get('open_basedir') == '') && (ini_get('safe_mode') == 'Off')) {
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
				}
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // max. seconds to execute
				curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
				$page_content = @curl_exec($ch);
			}
		}
		else{
			$page_content = "CURL_NOT_ENABLED";
		}
		
		if($page_content == "CURL_NOT_ENABLED"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_CURL_NOT_ENABLED"), 'error');
		}
		elseif($page_content == "NO_LICENCE"){
			$app = JFactory::getApplication("admin");
			$app->redirect("index.php?option=com_ijoomlainstaller", JText::_("IJOOMLA_INSTALLER_NO_VALID_LICENSE"), 'error');
		}
		else{
			echo $page_content;
		}
	}

};
?>