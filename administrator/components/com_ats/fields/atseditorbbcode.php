<?php
// Protect from unauthorized access
defined('_JEXEC') or die();

class F0FFormFieldAtseditorbbcode extends F0FFormFieldText
{
	public function getInput()
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/editor.php';

		$html = AtsHelperEditor::showEditorBBcode('reply', 'Bbcode', $this->value, '95%', 400, 80, 20, array(), true);

		return $html;
	}
}
