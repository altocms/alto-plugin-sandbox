<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

/**
 * @package plugin Sandbox
 */

class PluginSandbox_ModuleTopic_MapperTopic extends PluginSandbox_Inherits_ModuleTopic_MapperTopic {

    /**
     * @param ModuleTopic_EntityTopic $oTopic Объект топика
     *
     * @return int|bool
     */
    public function AddTopic(ModuleTopic_EntityTopic $oTopic) {

        $iTopicId = parent::AddTopic($oTopic);
        if ($iTopicId) {
            $sql = "
              UPDATE ?_topic
                  SET topic_status = ?d:topic_status
              WHERE topic_id = ?d:topic_id
            ";
            $this->oDb->sqlQuery(
                $sql,
                array(
                    ':topic_status' => $oTopic->getTopicStatus(),
                    ':topic_id'     => $iTopicId,
                )
            );
        }
        return $iTopicId;
    }

    /**
     * @param ModuleTopic_EntityTopic $oTopic Объект топика
     *
     * @return bool
     */
    public function UpdateTopic(ModuleTopic_EntityTopic $oTopic) {

        $bResult = parent::UpdateTopic($oTopic);
        if ($bResult) {
            $sql = "
              UPDATE ?_topic
                  SET topic_status = ?d:topic_status
              WHERE topic_id = ?d:topic_id
            ";
            $this->oDb->sqlQuery(
                $sql,
                array(
                    ':topic_status' => $oTopic->getTopicStatus(),
                    ':topic_id'     => $oTopic->getId(),
                )
            );
        }
        return $bResult;
    }

    /**
     * @param array $aFilter
     *
     * @return string
     */
    protected function buildFilter($aFilter) {

        $sWhere = parent::buildFilter($aFilter);
        if (isset($aFilter['topic_status'])) {
            if (!is_array($aFilter['topic_status'])) {
                $aFilter['topic_status'] = array(intval($aFilter['topic_status']));
            } else {
                $aFilter['topic_status'] = array_map('intval', $aFilter['topic_status']);
            }
            $sWhere .= ' AND (t.topic_status IN (' . join(',', $aFilter['topic_status']) . '))';
        }
        if (isset($aFilter['topic_status_not'])) {
            if (!is_array($aFilter['topic_status_not'])) {
                $aFilter['topic_status'] = array(intval($aFilter['topic_status_not']));
            } else {
                $aFilter['topic_status'] = array_map('intval', $aFilter['topic_status_not']);
            }
            $sWhere .= ' AND (t.topic_status NOT IN (' . join(',', $aFilter['topic_status']) . '))';
        }
        if (isset($aFilter['topic_status_between'])) {
            if (!is_array($aFilter['topic_status_between'])) {
                $aFilter['topic_status'] = array(intval($aFilter['topic_status_between']));
            } else {
                $aFilter['topic_status'] = array_map('intval', $aFilter['topic_status_between']);
            }
            $sWhere .= ' AND (t.topic_status BETWEEN (' . reset($aFilter['topic_status']) . ',' . end($aFilter['topic_status']) . '))';
        }

        return $sWhere;
    }

}

// EOF
