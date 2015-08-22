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

class PluginSandbox_ActionContent extends PluginSandbox_Inherits_ActionContent {

    /**
     * Adds new topic
     *
     * @param $oTopic
     *
     * @return bool|ModuleTopic_EntityTopic
     */
    protected function _addTopic($oTopic) {

        if (!E::IsAdminOrModerator()) {
            $xUserRatingOut = C::Val('plugin.sandbox.user_rating_out', false);
            if ($xUserRatingOut === false || E::User()->getUserRating() < $xUserRatingOut) {
                $oTopic->setTopicStatus(TOPIC_STATUS_SANDBOX);
            }
        }

        return parent::_addTopic($oTopic);
    }
}

// EOF
