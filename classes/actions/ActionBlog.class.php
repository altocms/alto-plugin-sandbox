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

class PluginSandbox_ActionBlog extends PluginSandbox_Inherits_ActionBlog {

    protected function RegisterEvent() {

        parent::RegisterEvent();
        $this->AddEventPreg('/^[\w\-\_]+$/i', '/^sandbox$/i', '/^(page([1-9]\d{0,5}))?$/i', array('EventShowBlog', 'blog'));
    }

    public function Init() {

        parent::Init();
        $this->aMenuFilters[] = 'sandbox';
    }

    protected function EventShowBlog() {

        parent::EventShowBlog();
    }

    public function EventShutdown() {

        parent::EventShutdown();
        if ($this->oCurrentBlog) {
            $iCountSandboxBlogNew = E::ModuleTopic()->GetCountTopicsSandboxNew(array('blog_id' => $this->oCurrentBlog->getId()));
            E::ModuleViewer()->Assign('iCountSandboxBlogNew', $iCountSandboxBlogNew);
        }
    }

}

// EOF