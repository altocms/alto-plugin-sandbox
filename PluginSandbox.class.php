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

        return true;
    }

    /**
     * Инициализация плагина
     */
    public function Init() {

        defined('TOPIC_STATUS_SANDBOX') || define('TOPIC_STATUS_SANDBOX', 20);
        E::ModuleViewer()->AppendScript(Plugin::GetTemplatePath(__CLASS__) . 'assets/js/sandbox.js');
        /* !!! */
        //E::ModuleMenu()->ClearMenuCache('topics');
        //E::ModuleMenu()->ResetMenu('topics');

        return true;
    }

}

// EOF