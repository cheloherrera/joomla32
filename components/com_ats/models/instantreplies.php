<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsModelInstantreplies extends F0FModel
{
	public function &getItemList($overrideLimits = false, $group = '')
	{
		$results   = array();
        $docimport = array();
        $tickets   = array();

        $params = JComponentHelper::getParams('com_ats');

		$search = $this->getState('search', '');

		if(empty($search)) return $results;

		if(strlen($search) < 6) return $results;

		$dicats = implode(',',$this->getState('dicats', array()));

		$db = $this->getDBO();

		$query = $db->getQuery(true)
			->select(array(
				$db->qn('docimport_article_id').' AS '.$db->qn('id'),
				$db->qn('docimport_category_id').' AS '.$db->qn('catid'),
				$db->qn('title'),
				$db->qn('fulltext'),
                'MATCH('.$db->qn('fulltext').') AGAINST ('.$db->q($search).') as '.$db->qn('score')
			))->from($db->qn('#__docimport_articles'))
			->where($db->qn('docimport_category_id').' IN ('.$dicats.')')
			->where('MATCH('.$db->qn('fulltext').') AGAINST ('.$db->q($search).')');

		$raw_results = $db->setQuery($query, 0, 10)->loadObjectList();

		foreach($raw_results as $row)
        {
			$introtext = substr(strip_tags($row->fulltext), 0, 150).'&hellip;';
			$url = JRoute::_('index.php?option=com_docimport&view=article&id='.$row->id);

			$docimport[$row->score] = (object)array(
				'title'		=> $row->title,
				'preview'	=> $introtext,
				'url'		=> $url,
                'source'    => 'docimport'
			);
		}

        $query = $db->getQuery(true)
                    ->select(array(
                        $db->qn('tickets').'.'.$db->qn('ats_ticket_id'),
                        $db->qn('tickets').'.'.$db->qn('title'),
                        $db->qn('content_html'),
                        'MATCH('.$db->qn('content_html').') AGAINST ('.$db->q($search).') as '.$db->qn('score')
                    ))
                    ->from($db->qn('#__ats_posts').' AS '.$db->qn('posts'))
                    ->innerJoin($db->qn('#__ats_tickets').' '.$db->qn('tickets').' on '.$db->qn('posts').'.'.$db->qn('ats_ticket_id').' = '.
                            $db->qn('tickets').'.'.$db->qn('ats_ticket_id'))
                    ->where($db->qn('public').' = '.$db->q(1))
                    ->where($db->qn('catid').' = '.$db->q($this->input->getInt('catid')))
                    ->where($db->qn('tickets').'.'.$db->qn('enabled').' = '.$db->q(1))
                    ->where('MATCH('.$db->qn('content_html').') AGAINST ('.$db->q($search).')');

        $status[] = $db->qn('status').' = '.$db->q('C');

        $pending  = '('.$db->qn('status').' != '.$db->q('C');
        if($params->get('instantreplies_daylimit', 0))
        {
            $daysago = new JDate('-'.$params->get('instantreplies_daylimit', 0).' days');
            $pending .= ' AND '.$db->qn('tickets').'.'.$db->qn('modified_on').' >= '.$db->q($daysago->toSql());
        }

        $status[] = $pending.')';
        $query->where('('.implode(' OR ', $status).')');

        $raw_results = $db->setQuery($query, 0, 10)->loadObjectList();

        foreach($raw_results as $row)
        {
            $preview = substr(strip_tags($row->content_html), 0, 150).'&hellip;';

            $url = JRoute::_('index.php?option=com_ats&view=ticket&id='.$row->ats_ticket_id);

            $tickets[$row->score] = (object) array(
                'title'     => $row->title,
                'preview'   => $preview,
                'url'       => $url,
                'source'    => 'ats'
            );
        }

        // Merge the results ordered by score and pick only the first 10 items
        $sort_results = array_merge($docimport, $tickets);
        krsort($sort_results);
        $sort_results = array_slice($sort_results, 0, 10);

        // Ok, now they're sorted by key, so I can add them to the result array in order to have int keys
        foreach($sort_results as $result)
        {
            $results[] = $result;
        }

		return $results;
	}
}