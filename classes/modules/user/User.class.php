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

class PluginSandbox_ModuleUser extends PluginSandbox_Inherits_ModuleUser {

    public function GetUserProfileStats($xUser) {

        $aUserPublicationStats = parent::GetUserProfileStats($xUser);
        $iCountTopicsSandbox = E::ModuleTopic()->GetCountTopicsSandboxByUser($xUser);

        $aUserPublicationStats['count_sandbox'] = $iCountTopicsSandbox;
        $aUserPublicationStats['count_created'] += $iCountTopicsSandbox;

        return $aUserPublicationStats;
    }
}

// EOF