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
$tab = JRequest::getInt('fgtab');
$options =  array('startOffset'=>$tab);
$pane = JPane::getInstance('tabs',$options);

/*echo '<pre>';
print_r($this->fgParams);
echo '</pre>';*/

?>

<script language="javascript" type="text/javascript">
<!--

var contentsections = new Array;
var sectioncategories = new Array;

<?php

$i = 0;

foreach ($this->contentsections as $k=>$items) {
	foreach ($items as $v) {
		echo "contentsections[".$i++."] = new Array( '$k','".addslashes( $v->id )."','".addslashes( $v->title )."' );\n\t\t";
	}
}
$i = 0;

foreach ($this->sectioncategories as $k=>$items) {
	foreach ($items as $v) {
		echo "sectioncategories[".$i++."] = new Array( '$k','".addslashes( $v->id )."','".addslashes( $v->title )."' );\n\t\t";
	}
}
if(J_VERSION < 1.6) {
?>
   function submitbutton(pressbutton) {
<?php } else { ?>
	Joomla.submitbutton = function(pressbutton) {
<?php } ?>
     var form = document.adminForm;

     if (pressbutton == 'cancel') {
       submitform( pressbutton );
       return;
     }      // do field validation

     if (form.datacontent_type.value == "-1") {
       alert( "You must choose a content type" );
     } else {
       submitform( pressbutton );
     }
   }

   function toggle(place,type) {
   		var elems = new Array;
   		var hide = 0;
   		if(place == 'processing') {
			if((type == 0) OR (type == null)) {
				hide = 1;
				elems[] = 'paramscompare_existing';
				elems[] = 'paramsforce_new';
				elems[] = 'paramscheck_text';
				elems[] = 'paramsmerging';
			}
			if(type == 1) {
				elems[] = 'paramscompare_existing';
				elems[] = 'paramsforce_new';
			}
			if(type == 2) {
				elems[] = 'paramscheck_text';
				elems[] = 'paramsmerging';
			}
		}
		foreach(elems as elem) {
			$(elem).parent.setStyle('display',(hide ? 'none' : ''));
		}
	}

-->
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">

	<?php
	if(J_VERSION < 1.6) {

		echo $pane->startPane('pane');
		echo $pane->startPanel(JText::_('FG_TAB_FEED_DETAILS'),'panel1');

		echo $this->fgParams->render('data','feed_1');
		echo $this->fgParams->render('params','feed_2');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_PUBLISHING'),'panel2');

		echo $this->fgParams->render('data','publishing_1');
		echo $this->fgParams->render('params','publishing_2');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_PROCESSING_DUPS'),'panel3');

		echo $this->fgParams->render('params','duplicates');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_TXT_HANDLING'),'panel4');

		echo $this->fgParams->render('params','text_1');
		echo $this->fgParams->render('data','text_2');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_LANGS'),'panel5');

		echo $this->fgParams->render('params','languages');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_IMGS_ENCS'),'panel6');

		echo $this->fgParams->render('params','images');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_LINKS'),'panel7');

		echo $this->fgParams->render('params','links');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_TXT_FLTRS'),'panel8');

		echo $this->fgParams->render('params','text');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_HTML_FLTRS'),'panel9');

		echo $this->fgParams->render('params','html');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_IMPORT_FLTRS'),'panel10');

		echo $this->fgParams->render('data','import_1');
		echo $this->fgParams->render('params','import_2');
		echo $this->fgParams->render('data','import_3');

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_TAGGING'),'panel11');

		echo $this->fgParams->render('params','tagging');

	} else {

		echo $pane->startPane('pane');
		echo $pane->startPanel(JText::_('FG_TAB_FEED_DETAILS'),'panel1');

		$pdata = $this->fgParams->getParams('data','feed_1');
		echo FeedgatorHelper::renderForm($pdata,false,array('control'=>'data'));
		$pdata = $this->fgParams->getParams('params','feed_2');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_PUBLISHING'),'panel2');

		$pdata = $this->fgParams->getParams('data','publishing_1');
		echo FeedgatorHelper::renderForm($pdata,false,array('control'=>'data'));
		$pdata = $this->fgParams->getParams('params','publishing_2');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_PROCESSING_DUPS'),'panel3');

		$pdata = $this->fgParams->getParams('params','duplicates');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_TXT_HANDLING'),'panel4');

		$pdata = $this->fgParams->getParams('params','text_1');
		echo FeedgatorHelper::renderForm($pdata);
		$pdata = $this->fgParams->getParams('data','text_2');
		echo FeedgatorHelper::renderForm($pdata,false,array('control'=>'data'));

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_LANGS'),'panel5');

		$pdata = $this->fgParams->getParams('params','languages');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_IMGS_ENCS'),'panel6');

		$pdata = $this->fgParams->getParams('params','images');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_LINKS'),'panel7');

		$pdata = $this->fgParams->getParams('params','links');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_TXT_FLTRS'),'panel8');

		$pdata = $this->fgParams->getParams('params','text');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_HTML_FLTRS'),'panel9');

		$pdata = $this->fgParams->getParams('params','html');
		echo FeedgatorHelper::renderForm($pdata);

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_IMPORT_FLTRS'),'panel10');

		$pdata = $this->fgParams->getParams('data','import_1');
		echo FeedgatorHelper::renderForm($pdata,false,array('control'=>'data'));
		$pdata = $this->fgParams->getParams('params','import_2');
		echo FeedgatorHelper::renderForm($pdata);
		$pdata = $this->fgParams->getParams('data','import_3');
		echo FeedgatorHelper::renderForm($pdata,false,array('control'=>'data'));

		echo $pane->endPanel();
		echo $pane->startPanel(JText::_('FG_TAB_TAGGING'),'panel11');

		$pdata = $this->fgParams->getParams('params','tagging');
		echo FeedgatorHelper::renderForm($pdata);
		unset($pdata);
	}

	echo $pane->endPanel();
	echo $pane->startPanel(JText::_('FG_TAB_PLG_SETTINGS'),'panel12');

	echo '<div id="pluginparams">'.JText::_('FG_PLG_PARAMS_NOT_LOADED').'</div>';

	echo $pane->endPanel();
	echo $pane->endPane(); ?>

	<input type="hidden" name="cid" value="-2" />
	<input type="hidden" name="option" value="com_feedgator" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>