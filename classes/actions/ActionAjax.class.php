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

class PluginSandbox_ActionAjax extends PluginSandbox_Inherits_ActionAjax {

    protected function RegisterEvent() {

        parent::RegisterEvent();
        $this->AddEventPreg('/^stream$/i', '/^comment_sandbox$/', 'EventStreamCommentSandbox');
        $this->AddEventPreg('/^stream$/i', '/^topic_sandbox$/', 'EventStreamTopicSandbox');
    }

    protected function EventStreamCommentSandbox() {

        $aVars = array();
        if ($aComments = E::ModuleComment()->GetCommentsOnline('sandbox', Config::Get('widgets.stream.params.limit'))) {
            $aVars['aComments'] = $aComments;
        }
        $sTextResult = E::ModuleViewer()->FetchWidget('stream_comment.tpl', $aVars);
        E::ModuleViewer()->AssignAjax('sText', $sTextResult);
    }

    /**
     * Обработка получения последних топиков
     * Используется в блоке "Прямой эфир"
     *
     */
    protected function EventStreamTopicSandbox() {

        $aVars = array();
        $aFilter = E::ModuleTopic()->GetNamedFilter('default', array('accessible' => true, 'sandbox' => true));
        $aTopics = E::ModuleTopic()->GetTopicsByFilter($aFilter, 1, Config::Get('widgets.stream.params.limit'));
        if ($aTopics) {
            $aVars['aTopics'] = $aTopics['collection'];
            // LS-compatibility
            $aVars['oTopics'] = $aTopics['collection'];
        }
        $sTextResult = E::ModuleViewer()->FetchWidget('stream_topic.tpl', $aVars);
        E::ModuleViewer()->AssignAjax('sText', $sTextResult);
    }

}

// EOF