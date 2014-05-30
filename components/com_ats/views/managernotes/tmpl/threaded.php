<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

if(empty($this->items)) return;

$this->loadHelper('bbcode');

// Get the return URL to point back to ourselves
$returnURL = base64_encode(JURI::getInstance()->toString());

foreach($this->items as $item):?>
<?php echo $this->loadAnyTemplate('site:com_ats/managernotes/threaded_note',array(
	'item'		=> $item,
	'returnURL'	=> $returnURL
));?>
<?php endforeach; ?>