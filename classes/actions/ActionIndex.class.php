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

class PluginSandbox_ActionIndex extends PluginSandbox_Inherits_ActionIndex {

    protected function RegisterEvent() {

        parent::RegisterEvent();
        $this->AddEventPreg('/^sandbox$/i', '/^(page([1-9]\d{0,5}))?$/i', 'EventSandbox');
    }

    public function EventSandbox() {

        // * Меню
        $this->sMenuSubItemSelect = 'sandbox';

        // * Передан ли номер страницы
        $iPage = $this->GetParamEventMatch(0, 2) ? $this->GetParamEventMatch(0, 2) : 1;

        // * Получаем список топиков
        $aResult = E::ModuleTopic()->GetTopicsNewAll($iPage, Config::Get('module.topic.per_page'));
        $aTopics = $aResult['collection'];

        // * Вызов хуков
        E::ModuleHook()->Run('topics_list_show', array('aTopics' => $aTopics));

        // * Формируем постраничность
        $aPaging = E::ModuleViewer()->MakePaging(
            $aResult['count'], $iPage, Config::Get('module.topic.per_page'), Config::Get('pagination.pages.count'),
            R::GetPath('index/sandbox')
        );

        E::ModuleViewer()->AddHtmlTitle(E::ModuleLang()->Get('plugin.sandbox.menu_text')  . ($iPage>1 ? (' (' . $iPage . ')') : ''));

        // * Загружаем переменные в шаблон
        E::ModuleViewer()->Assign('aTopics', $aTopics);
        E::ModuleViewer()->Assign('aPaging', $aPaging);

        // * Устанавливаем шаблон вывода
        $this->SetTemplateAction('index');
    }

}

// EOF