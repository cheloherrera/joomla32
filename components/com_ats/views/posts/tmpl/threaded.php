<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

if(empty($this->items)) return;

// Get the return URL to point back to ourselves
$returnURL = base64_encode(JURI::getInstance()->toString());

$i = 0;
foreach($this->items as $item)
{
	echo $this->loadAnyTemplate('site:com_ats/posts/threaded_post',array(
		'item'				=> $item,
		'returnURL'			=> $returnURL,
		'showCustomFields'	=> ($i === 0)
	));

	$i++;
}

// Let's save the last post id for later use (most likely this section is called within another F0FDispatcher
// instance, so I can't directly access to these variables :(
$last_ats_post_id = $this->getModel()->_last_ats_post_id;
if($last_ats_post_id)
{
	$session = JFactory::getSession();
	$session->set($item->ats_ticket_id.'.last_post', $last_ats_post_id, 'com_ats');
}
?>