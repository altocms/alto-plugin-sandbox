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

class PluginSandbox_ActionProfile extends PluginSandbox_Inherits_ActionProfile {

    protected function RegisterEvent() {

        parent::RegisterEvent();
        $this->AddEventPreg('/^.+$/i', '/^created/i', '/^sandbox/i', '/^(page([1-9]\d{0,5}))?$/i', 'EventCreatedSandbox');
    }

    public function EventCreatedSandbox() {

        if (!$this->CheckUserProfile()) {
            return parent::EventNotFound();
        }
        $this->sMenuSubItemSelect = 'sandbox';

        // * Передан ли номер страницы
        $iPage = $this->GetParamEventMatch(2, 2) ? $this->GetParamEventMatch(2, 2) : 1;

        // * Получаем список топиков
        $aResult = E::ModuleTopic()->GetTopicsSandboxByUser($this->oUserProfile->getId(), $iPage, Config::Get('module.topic.per_page'));
        $aTopics = $aResult['collection'];

        // * Вызов хуков
        E::ModuleHook()->Run('topics_list_show', array('aTopics' => $aTopics));

        // * Формируем постраничность
        $aPaging = E::ModuleViewer()->MakePaging(
            $aResult['count'], $iPage, Config::Get('module.topic.per_page'), Config::Get('pagination.pages.count'),
            $this->oUserProfile->getUserUrl() . 'created/sandbox'
        );

        // * Загружаем переменные в шаблон
        E::ModuleViewer()->Assign('aPaging', $aPaging);
        E::ModuleViewer()->Assign('aTopics', $aTopics);
        E::ModuleViewer()->AddHtmlTitle(E::ModuleLang()->Get('user_menu_publication') . ' ' . $this->oUserProfile->getLogin());
        E::ModuleViewer()->AddHtmlTitle(E::ModuleLang()->Get('plugin.sandbox.menu_text'));

        // * Устанавливаем шаблон вывода
        $this->SetTemplateAction('created_topics');
    }

}

// EOF