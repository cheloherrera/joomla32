<?php
/**
 * @package        ats
 * @copyright      Copyright (c)2010-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license        GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 */

defined('_JEXEC') or die();

require_once __DIR__ . '/abstract.php';

/**
 * A date input field
 *
 * @author Nicholas K. Dionysopoulos
 * @since  2.6.0
 */
class AtsCustomFieldDate extends AtsCustomFieldAbstract
{
	public function getField($item, $cache, $userparams)
	{
		// Get the current value
		if (array_key_exists($item->slug, $cache['custom']))
		{
			$current = $cache['custom'][$item->slug];
		}
		else
		{
			if (!is_object($userparams->params))
			{
				$current = $item->default;
			}
			else
			{
				$slug = $item->slug;
				$current = property_exists($userparams->params, $item->slug) ? $userparams->params->$slug : $item->default;
			}
		}

		// Is this a required field?
		$required = $item->allow_empty ? '' : '* ';

		// Set up field's HTML content
		$html = JHTML::_('calendar', $current, 'custom[' . $item->slug . ']', $item->slug);

		// Setup the field
		$field = array(
			'id'          => $item->slug,
			'label'       => $required . JText::_($item->title),
			'elementHTML' => $html,
			'isValid'     => $required ? (!empty($current) && $current != '0000-00-00 00:00:00') : true
		);

		if ($item->invalid_label)
		{
			$field['invalidLabel'] = JText::_($item->invalid_label);
		}
		if ($item->valid_label)
		{
			$field['validLabel'] = JText::_($item->valid_label);
		}

		return $field;
	}

	public function getJavascript($item)
	{
		$slug = $item->slug;
		$javascript = <<<JS
akeeba.jQuery(document).ready(function($){
	addToValidationFetchQueue(plg_ats_customfields_fetch_$slug);
JS;

		if (!$item->allow_empty)
		{
			$javascript .= <<<JS

	addToValidationQueue(plg_ats_customfields_validate_$slug);
JS;
		}

		$javascript .= <<<JS
});

function plg_ats_customfields_fetch_$slug()
{
	var result = {};
	(function($) {
		result.$slug = $('#$slug').val();
	})(akeeba.jQuery);
	return result;
}

JS;

		if (!$item->allow_empty):
			$success_javascript = '';
			$failure_javascript = '';
			if (!empty($item->invalid_label))
			{
				$success_javascript .= "$('#{$slug}_invalid').css('display','none');\n";
				$failure_javascript .= "$('#{$slug}_invalid').css('display','inline-block');\n";
			}
			if (!empty($item->valid_label))
			{
				$success_javascript .= "$('#{$slug}_valid').css('display','inline-block');\n";
				$failure_javascript .= "$('#{$slug}_valid').css('display','none');\n";
			}
			$javascript .= <<<JS
function plg_ats_customfields_validate_$slug(response)
{
	var thisIsValid = true;
	(function($) {
		$('#$slug').parent().parent().removeClass('error').removeClass('success');
		if(response.custom_validation.$slug) {
			$('#$slug').parent().parent().addClass('success');
			$success_javascript
		} else {
			$('#$slug').parent().parent().addClass('error');
			$failure_javascript
			thisIsValid = false;
		}
		return thisIsValid;
	})(akeeba.jQuery);
}

JS;
		endif;

		$document = JFactory::getDocument();
		$document->addScriptDeclaration($javascript);
	}

	public function validate($item, $custom)
	{
		if (!array_key_exists($item->slug, $custom))
		{
			$custom[$item->slug] = '';
		}

		$valid = true;

		if (!$item->allow_empty)
		{
			$valid = !empty($custom[$item->slug]);
			if ($valid)
			{
				$valid = $custom[$item->slug] != '0000-00-00 00:00:00';
			}
		}

		return $valid ? 1 : 0;
	}
}