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

class PluginSandbox extends Plugin {

    protected $aInherits
        = array(
            'action' => array(
                'ActionIndex',
                'ActionContent',
                'ActionBlog',
                'ActionProfile',
                'ActionAjax',
            ),
            'module' => array(
                'ModuleTopic',
                'ModuleUser',
            ),
            'mapper' => array(
                'ModuleTopic_MapperTopic',
                'ModuleComment_MapperComment',
            ),
            'entity' => array(
                'ModuleTopic_EntityTopic',
            ),
        );


    /**
     * Активация плагина
     */
    public function Activate() {

        if (!$this->isFieldExists('?_topic', 'topic_status')) {
            $this->ExportSQL(__DIR__ . '/install/db/init.sql');
        }
        E::ModuleMenu()->ClearMenuCache('topics');

        return true;
    }

    /**
     * Деактивация плагина
     *
     * @return bool
     */
    public function Deactivate() {

        /** @var ModuleMenu_EntityMenu $oMenu */
        $oMenu = E::ModuleMenu()->GetMenu('topics');
        $oMenu->RemoveItemById(array('plugin.sandbox.topics', 'plugin_sandbox_topics'), true);
        E::ModuleMenu()->SaveMenu($oMenu);
        //E::ModuleMenu()->ClearMenuCache('topics');
        //Config::ResetCustomConfig('plugin.sandbox');

        return true;
    }

    /**
     * Инициализация плагина
     */
    public function Init() {

        defined('TOPIC_STATUS_SANDBOX') || define('TOPIC_STATUS_SANDBOX', 20);
        E::ModuleViewer()->AppendScript(Plugin::GetTemplatePath(__CLASS__) . 'assets/js/sandbox.js');

        return true;
    }

}

// EOF