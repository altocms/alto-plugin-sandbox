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

/**
 * Регистрация хука
 *
 */
class PluginSandbox_HookSandbox extends Hook {

    public function RegisterHook() {

        // Хуки для меню
        $this->AddHook('module_menu_createmenu_after', 'onAfterModuleMenuCreate');
        $this->AddHook('module_menu_resetmenu_after', 'onAfterModuleMenuReset');
        $this->AddHook('new_sandbox_count', 'newSandboxCount');
        $this->AddHook('render_init_start', 'renderInitStart');
        $this->AddHook('comment_add_after','clearSandboxCache');

        $this->AddHookTemplate('menu_profile_created_item', Plugin::GetTemplateDir(__CLASS__) . '/tpls/menu_profile_created_item.tpl');
        $this->AddHookTemplate('menu_blog_blog_item', Plugin::GetTemplateDir(__CLASS__) . '/tpls/menu_blog_item.tpl');
    }

    /**
     * @param ModuleMenu_EntityMenu $oMenu
     */
    protected function _addMenuItem($oMenu) {

        // Создадим элемент меню
        $oMenuItem = E::ModuleMenu()->CreateMenuItem('plugin.sandbox.topics', array(
            'text' => array(
                '{{plugin.sandbox.menu_text}}',
                'hook:new_sandbox_count' => array(
                    'red'
                ),
            ),
            'link'    => R::GetPath('index/sandbox'),
            'active'  => array('topic_kind' => array('sandbox')),
            'options' => array(
                'class' => '',
                'link_title' => '{{plugin.sandbox.menu_text}}',
            ),
        ));

        // Добавим в меню
        $oMenu->AddItem($oMenuItem);

        // Сохраним
        E::ModuleMenu()->SaveMenu($oMenu);
    }

    /**
     * Hook after ModuleMenu::CreateMenu()
     */
    public function onAfterModuleMenuCreate() {

        /** @var ModuleMenu_EntityMenu $oMenu */
        $oMenu = $this->GetSourceResult();
        if ($oMenu && $oMenu->getId() == 'topics') {

            // Проверим наличие пункта меню
            if (!$oMenu->GetItemById('plugin.sandbox.topics')) {
                if ($oMenu->GetItemById('plugin_sandbox_topics')) {
                    $oMenu->RemoveItemById('plugin_sandbox_topics', false);
                }
                $this->_addMenuItem($oMenu);
            }
        }
    }

    /**
     * Hook after ModuleMenu::ResetMenu()
     */
    public function onAfterModuleMenuReset() {

        $oMenu = $this->GetHookArgument(0);
        if ($oMenu && $oMenu->getId() == 'topics') {
            if (!$oMenu->GetItemById('plugin.sandbox.topics')) {
                $this->_addMenuItem($oMenu);
            }
        }
    }

    /**
     * @param string $sCssClass
     *
     * @return int|string
     */
    public function newSandboxCount($sCssClass = '') {

        $iCount = E::ModuleTopic()->GetCountTopicsSandboxNew();

        if ($iCount) {
            if ($sCssClass) {
                $sData = '<span class="' . $sCssClass . '"> +' . $iCount . '</span>';
            } else {
                $sData =  $iCount;
            }
        } else {
            $sData = '';
        }

        return $sData;
    }

    public function renderInitStart() {

        if (C::Get('plugin.sandbox.widget_stream_split')) {
            // В шаблоне виджета идет обращение к тестовке через массив, поэтому такой хак
            E::ModuleLang()->AddMessage('widget_stream_comments_sandbox', E::ModuleLang()->Get('plugin.sandbox.widget_stream_comments_sandbox'));
            E::ModuleLang()->AddMessage('widget_stream_topics_sandbox', E::ModuleLang()->Get('plugin.sandbox.widget_stream_topics_sandbox'));

            $aStreamWidgetItems = C::Get('widgets.stream.params.items');
            $aStreamWidgetItems['comments_sandbox'] = array(
                'text' => 'widget_stream_comments_sandbox',
                'type'=>'comment_sandbox',
            );
            $aStreamWidgetItems['topics_sandbox'] = array(
                'text' => 'widget_stream_topics_sandbox',
                'type'=>'topic_sandbox',
            );
            C::Set('widgets.stream.params.items', $aStreamWidgetItems);
        }
    }

    public function clearSandboxCache(){
        E::ModuleCache()->CleanByTags(array("comment_online_update_sandbox"));
    }

}

// EOF