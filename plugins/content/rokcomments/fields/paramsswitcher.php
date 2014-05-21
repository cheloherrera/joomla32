<?php
/**
 * @version   $Id: paramsswitcher.php 6847 2013-01-28 17:48:05Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2014 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
JHtml::_('behavior.framework', true);


/**
 *
 */
class JFormFieldParamsSwitcher extends JFormFieldList
{
    /**
     * @var string
     */
    public $type = 'ParamsSwitcher';

    /**
     * @return string
     */
    function getInput()
    {
        $doc = JFactory::getDocument();
        $ver = new JVersion();

        // Initialize some field attributes.
        $attr = '';
        $attr .= $this->element['class'] ? ' class="' . (string)$this->element['class'] . '"' : '';
        // To avoid user's confusion, readonly="true" should imply disabled="true".
        if ((string)$this->element['readonly'] == 'true' || (string)$this->element['disabled'] == 'true') {
            $attr .= ' disabled="disabled"';
        }
        $attr .= $this->element['size'] ? ' size="' . (int)$this->element['size'] . '"' : '';
        $attr .= $this->element['multiple'] ? ' multiple="multiple"' : '';
        // Initialize JavaScript field attributes.
        $attr .= $this->element['onchange'] ? ' onchange="' . (string)$this->element['onchange'] . '"' : '';

        if (version_compare($ver->getShortVersion(), '3.0', '<')) {

            $js = "window.addEvent('load', function() {
                $('" . $this->id . "').addEvent('change', function(){
                    var sel = this.getSelected().get('value');
                    $$('." . $this->element['name'] . "').getParent('li').setStyle('display','none');
                    $$('.'+sel).getParent('li').setStyle('display','block');
                }).fireEvent('change');
            });";

        } else {

            $js = "window.addEvent('load', function() {
                var chzn = $('" . $this->id . "_chzn');
                if(chzn!=null){
                    chzn.addEvent('click', function(){
                        $$('." . $this->element['name'] . "').getParent('div.control-group').setStyle('display','none');
                        var text = chzn.getElement('span').get('text');
                        var options = $('" . $this->id . "').getElements('option');
                        options.each(function(option) {
                        var optText = String(option.get('text'));
                        var optValue = String(option.get('value'));
                            if(text == optText){
                                var sel = optValue;
                            }
                            $$('.'+sel).getParent('div.control-group').setStyle('display','block');
                        });
                    }).fireEvent('click');
                }
            });";
        }

        $doc->addScriptDeclaration($js);

        $html = JHtml::_('select.genericlist', (array)$this->getOptions(), $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
        return $html;
    }

}