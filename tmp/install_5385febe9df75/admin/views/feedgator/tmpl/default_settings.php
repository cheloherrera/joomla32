<?php
/**
* FeedGator - Aggregate RSS newsfeed content into a Joomla! database
* @version 2.4
* @package FeedGator
* @author Original author Stephen Simmons
* @now continued and modified by Matt Faulds, Remco Boom & Stephane Koenig and others
* @email mattfaulds@gmail.com
* @Joomla 1.5 Version by J. Kapusciarz (mrjozo)
* @copyright (C) 2005 by Stephen Simmons - All rights reserved
* @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
*
**/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.mootools');
jimport('joomla.html.pane');
$options =  array('startOffset'=>0);
$pane = JPane::getInstance('tabs',$options);

?>

<form name="adminForm" id="adminForm" method="post" action="index.php">

	<?php
	if(J_VERSION < 1.6) {

		echo $this->params->render('params','advanced');

	} else {

		echo FeedgatorHelper::renderForm($this->params->getParams('params','advanced'));

	} ?>

	<input type="hidden" name="id" value="<?php echo $this->component->id;?>" />
	<input type="hidden" name="option" value="com_feedgator"/>
	<input type="hidden" value="" name="task"/>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>