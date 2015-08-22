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

class PluginSandbox_ModuleTopic_EntityTopic extends PluginSandbox_Inherits_ModuleTopic_EntityTopic {

    public function setRating($nRating) {

        parent::setRating($nRating);
        if ((float)$nRating >= C::Get('plugin.sandbox.topic_rating_out')) {
            $this->setTopicStatus(0);
        }
    }
}

// EOF