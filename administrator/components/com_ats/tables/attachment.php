<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsTableAttachment extends F0FTable
{
	public function deleteFile($oid)
	{
		$item = clone $this;
		$item->load($oid);
		if($item->ats_attachment_id == $oid) {
			$filename = JPATH_ROOT.'/media/com_ats/attachments/'.$item->mangled_filename;
			if(!@unlink($filename)) {
				JLoader::import('joomla.filesystem.file');
				if(JFile::exists($filename)) {
					return JFile::delete($filename);
				}
			} else {
				return true;
			}
		}

		return true;
	}

	protected function onBeforeDelete($oid)
    {
		$status = parent::onBeforeDelete($oid);

		if($status)
        {
			// Delete the physical file before deleting the record
			$this->deleteFile($oid);

            // Update post record removing the link to this attachment
            $table = F0FModel::getTmpInstance('Posts', 'AtsModel')->getTable();
            $table->load($this->ats_post_id);

            if($table->ats_post_id)
            {
                $attachments = explode(',', $table->ats_attachment_id);
                $attachments = array_diff($attachments, array($oid));

                // If it's an empty set, let's add 0 for consistency vs previous versions
                if(!$attachments)
                {
                    $attachments[] = 0;
                }

                $table->ats_attachment_id = implode(',', $attachments);
                $table->store();
            }
		}

		return $status;
	}
}