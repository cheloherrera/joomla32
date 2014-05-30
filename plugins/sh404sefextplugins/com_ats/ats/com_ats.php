<?php
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Incoming var from the include
 * @var     string  $option     Component name, ie com_foobar
 * @var     int     $id         Id of the current record
 */

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG;
$sefConfig = & shRouter::shGetConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
if ($dosef == false) return;
// ------------------  standard plugin initialize function - don't change ---------------------------

require_once JPATH_ADMINISTRATOR.'/components/com_ats/fof/include.php';
require_once JPATH_SITE.'/components/com_ats/helpers/router.php';

if (!function_exists( 'shAtsMenuName'))
{
    function shAtsMenuName($task, $Itemid, $option, $shLangName)
    {
        $sefConfig           = &shRouter::shGetConfig();
        $shArsDownloadName = shGetComponentPrefix($option);

        if( empty($shArsDownloadName) ) $shArsDownloadName = getMenuTitle($option, $task, $Itemid, null, $shLangName);
        if( empty($shArsDownloadName) || $shArsDownloadName == '/' ) $shArsDownloadName = 'AkeebaTicketSystem';

        return str_replace( '.', $sefConfig->replacement, $shArsDownloadName );
    }
}

// remove common URL from GET vars list, so that they don't show up as query string in the URL
shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('lang');
shRemoveFromGETVarsList('view');
shRemoveFromGETVarsList('format');

if( isset($Itemid) ) shRemoveFromGETVarsList('Itemid');

global $shGETVars;
global $atsHandleViews;

$atsHandleViews = array(
    'categories', 'latest', 'my', 'newticket', 'ticket', 'tickets'
);

$task    = isset($task) ? @$task : null;
$Itemid  = isset($Itemid) ? @$Itemid : null;
$title[] = shAtsMenuName($task, $Itemid, $option, $shLangName);

// We need to find out if the menu item link has a view param
$menuQuery = array();
$menuView = 'categories';

// Get the menu view, if an Item ID exists
if($Itemid) {
    $menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
    if(is_object($menu)) {
        parse_str(str_replace('index.php?',  '',$menu->link), $menuQuery); // remove "index.php?" and parse
        if(array_key_exists('view', $menuQuery)) {
            $menuView = $menuQuery['view'];
        }
    }
}

// Add the view
$newView = $view ? $view : $menuView;

// We can only handle specific views. Is it one of them?
if(!in_array($newView, $atsHandleViews)) {
    return array();
}

// Build the URL
switch($newView)
{
    case 'tickets':
        // Fetch the category ID
        $catID = $shGETVars['category'];
        shRemoveFromGETVarsList('category');

        // Do I have to look for a new Item ID?
        $found = false;
        $menu  = JFactory::getApplication()->getMenu()->getItem($Itemid);
        $qoptions = array(
            'option'	=> 'com_ats',
            'view'		=> 'tickets',
        );
        $params = array(
            'category'	=> $catID
        );
        $found = AtsHelperRouter::checkMenu($menu, $qoptions, $params);

        if(!$found)
        {
            $qoptions2 = array_merge($qoptions, array('category' => $catID));
            $found     = AtsHelperRouter::checkMenu($menu, $qoptions2);
        }

        if(!$found)
        {
            // Try to find a menu item ID directly for this category
            $item = AtsHelperRouter::findMenu($qoptions, $params);

            // Or, try to find a manual link
            if(is_null($item)) {
                $item = AtsHelperRouter::findMenu($qoptions2);
            }

            if(!is_null($item)) {
                $Itemid = $item->id;
                $found  = true;
            }

        }

        // Get and append the category alias path, if the category wasn't found
        if(!$found)
        {
            $db = JFactory::getDbo();
            $q = $db->getQuery(true)
                ->select($db->qn('path'))
                ->from($db->qn('#__categories'))
                ->where($db->qn('id').' = '.$db->q($catID))
                ->where($db->qn('extension').' = '.$db->q('com_ats'));
            $db->setQuery($q);
            $path = $db->loadResult();
            $pathParts = explode('/', $path);
            foreach($pathParts as $p) $title[] = $p;
        }
        break;

    case 'ticket':
        $ticketID = (int)$shGETVars['id'];
        shRemoveFromGETVarsList('id');

        $ticket = F0FModel::getTmpInstance('Tickets', 'AtsModel')
            ->setId($ticketID)
            ->getItem();
        $catID = $ticket->catid;

        // Do I have to look for a new Item ID?
        $found = false;
        $menu  = JFactory::getApplication()->getMenu()->getItem($Itemid);
        $qoptions = array(
            'option'	=> 'com_ats',
            'view'		=> 'tickets',
        );
        $params = array(
            'category'	=> $catID
        );
        $found = AtsHelperRouter::checkMenu($menu, $qoptions, $params);
        if(!$found) {
            $qoptions2 = array_merge($qoptions, array('category' => $catID));
            $found = AtsHelperRouter::checkMenu($menu, $qoptions2);
        }
        if(!$found) {
            // Try to find a menu item ID directly for this category
            $item = AtsHelperRouter::findMenu($qoptions, $params);

            // Or, try to find a manual link
            if(is_null($item)) {
                $item = AtsHelperRouter::findMenu($qoptions2);
            }

            if(is_null($item))
            {
                unset($qoptions2['category']);
                $qoptions2['view'] = 'categories';
                $item = AtsHelperRouter::findMenu($qoptions2);
                if(!is_null($item))
                {
                    $Itemid = $item->id;
                }
            }
            else
            {
                $Itemid = $item->id;
                $found = true;
            }

        }

        // Get and append the category alias path, if the category wasn't found
        if(!$found)
        {
            $db = JFactory::getDbo();
            $q = $db->getQuery(true)
                ->select($db->qn('path'))
                ->from($db->qn('#__categories'))
                ->where($db->qn('id').' = '.$db->q($catID))
                ->where($db->qn('extension').' = '.$db->q('com_ats'));
            $db->setQuery($q);
            $path = $db->loadResult();
            $pathParts = explode('/', $path);
            foreach($pathParts as $p) $title[] = $p;
        }

        // Append the ticket ID and alias
        $title[] = $ticketID . ':' . $ticket->alias;

        break;

    case 'newticket':
        $catID = (int)$shGETVars['category'];
        shRemoveFromGETVarsList('category');

        // Do I have to look for a new Item ID?
        $found = false;
        $menu  = JFactory::getApplication()->getMenu()->getItem($Itemid);
        $qoptions = array(
            'option'	=> 'com_ats',
            'view'		=> 'tickets',
        );
        $params = array(
            'category'	=> $catID
        );
        $found = AtsHelperRouter::checkMenu($menu, $qoptions, $params);
        if(!$found) {
            $qoptions2 = array_merge($qoptions, array('category' => $catID));
            $found = AtsHelperRouter::checkMenu($menu, $qoptions2);
        }
        if(!$found) {
            // Try to find a menu item ID directly for this category
            $item = AtsHelperRouter::findMenu($qoptions, $params);

            // Or, try to find a manual link
            if(is_null($item)) {
                $item = AtsHelperRouter::findMenu($qoptions2);
            }

            if(!is_null($item)) {
                $Itemid = $item->id;
                $found = true;
            }

        }

        // Get and append the category alias path, if the category wasn't found
        if(!$found)
        {
            $db = JFactory::getDbo();
            $q = $db->getQuery(true)
                ->select($db->qn('path'))
                ->from($db->qn('#__categories'))
                ->where($db->qn('id').' = '.$db->q($catID))
                ->where($db->qn('extension').' = '.$db->q('com_ats'));
            $db->setQuery($q);
            $path = $db->loadResult();
            $pathParts = explode('/', $path);
            foreach($pathParts as $p) $title[] = $p;
        }

        // Append "new"
        $title[] = 'new';

        // Make sure the view name is not added
        $newView = '';
        break;

    case 'categories':
    case 'my':
    case 'latest':
        // Do I have to look for a new Item ID?
        $found = false;
        $menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
        $qoptions = array(
            'option'	=> 'com_ats',
            'view'		=> $newView,
        );
        $found = AtsHelperRouter::checkMenu($menu, $qoptions);
        if(!$found) {
            // Try to find a menu item ID directly for this category
            $item = AtsHelperRouter::findMenu($qoptions);

            if(!is_null($item)) {
                $Itemid = $item->id;
                $found = true;
            }
        }

        // No other parameters are expected
        break;
}

// Process the Itemid
$menuView = null;
if($Itemid) {
    $menu = JFactory::getApplication()->getMenu()->getItem($Itemid);
    if(is_object($menu)) {
        parse_str(str_replace('index.php?',  '',$menu->link), $menuQuery); // remove "index.php?" and parse
        if(array_key_exists('view', $menuQuery)) {
            $menuView = $menuQuery['view'];
        }
    }
}

// If the menu's view is different to the new view, add the view name to the URL
if(!empty($newView) && ($newView != $menuView)) {
    // Only append the view name if the $menuView is not categories, OR if the
    // $menuView is categories and the $newView IS NOT 'ticket' or 'tickets'
    if( ($menuView != 'categories') || empty($menuView) ) {
        array_unshift($title, $newView);
    } elseif(!in_array($newView, array('ticket','tickets'))) {
        array_unshift($title, $newView);
    }
}

$title[] = '/';
// ------------------  standard plugin finalize function - don't change ---------------------------
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString,
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null),
      (isset($shLangName) ? @$shLangName : null));
}
// ------------------  standard plugin finalize function - don't change ---------------------------
