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

class PluginSandbox_ModuleComment_MapperComment extends PluginSandbox_Inherits_ModuleComment_MapperComment {

    /**
     * Получить ID комментариев, сгрупированных по типу (для вывода прямого эфира)
     *
     * @param string $sTargetType        Тип владельца комментария
     * @param array  $aExcludeTargets    Список ID владельцев для исключения
     * @param int    $iLimit             Количество элементов
     *
     * @return int[]
     */
    public function GetCommentsIdOnline($sTargetType, $aExcludeTargets, $iLimit) {

        if (C::Get('plugin.sandbox.widget_stream_split') && ($sTargetType == 'topic' || $sTargetType == 'sandbox')) {
            $sql = "SELECT
					comment_id
				FROM
					?_comment_online AS c
					INNER JOIN ?_topic AS t ON t.topic_id = c.target_id
				WHERE
					c.target_type = 'topic'
					{ AND t.topic_status != ?d }
					{ AND t.topic_status = ?d }
				    { AND target_parent_id NOT IN(?a) }
				ORDER by comment_online_id DESC
				LIMIT 0, ?d ;";

            $aCommentsId = $this->oDb->selectCol(
                $sql,
                ($sTargetType == 'topic') ? TOPIC_STATUS_SANDBOX : DBSIMPLE_SKIP,
                ($sTargetType == 'sandbox') ? TOPIC_STATUS_SANDBOX : DBSIMPLE_SKIP,
                (!empty($aExcludeTargets) ? $aExcludeTargets : DBSIMPLE_SKIP),
                $iLimit
            );
        } else {
            $sql = "SELECT
					comment_id
				FROM
					?_comment_online
				WHERE
					target_type = ?
				{ AND target_parent_id NOT IN(?a) }
				ORDER by comment_online_id DESC
				LIMIT 0, ?d ;";

            $aCommentsId = $this->oDb->selectCol(
                $sql,
                $sTargetType,
                (!empty($aExcludeTargets) ? $aExcludeTargets : DBSIMPLE_SKIP),
                $iLimit
            );
        }

        return $aCommentsId ? $aCommentsId : array();
    }

}

// EOF