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

class PluginSandbox_ModuleTopic extends PluginSandbox_Inherits_ModuleTopic {

    /**
     * @return array
     */
    public function GetTopicsFilter() {

        $aFilter = parent::GetTopicsFilter();
        if (R::GetAction() == 'index' && R::GetActionEvent() == 'sandbox') {
            $aFilter['topic_status'] = TOPIC_STATUS_SANDBOX;
        } elseif (!(R::GetAction() == 'content' && R::GetActionEvent() == 'drafts')) {
            $aFilter['topic_status_not'] = TOPIC_STATUS_SANDBOX;
        }
        return $aFilter;
    }

    /**
     * @param string $sFilterName
     * @param array  $aParams
     *
     * @return array
     */
    public function GetNamedFilter($sFilterName, $aParams = array()) {

        $aFilter = parent::GetNamedFilter($sFilterName, $aParams);
        if (isset($aParams['sandbox'])) {
            if ($aParams['sandbox']) {
                $aFilter['topic_status'] = TOPIC_STATUS_SANDBOX;
                if (isset($aFilter['topic_status_not'])) {
                    unset($aFilter['topic_status_not']);
                }
            } else {
                $aFilter['topic_status_not'] = TOPIC_STATUS_SANDBOX;
                if (isset($aFilter['topic_status'])) {
                    unset($aFilter['topic_status']);
                }
            }
        }
        return $aFilter;
    }

    /**
     * Получает число новых топиков в коллективных блогах
     *
     * @return int
     */
    public function GetCountTopicsCollectiveNew() {

        $aFilter = $this->GetNamedFilter('new', array('accessible' => true, 'personal' => false, 'sandbox' => false));
        return $this->GetCountTopicsByFilter($aFilter);
    }

    /**
     * Получает число новых топиков в персональных блогах
     *
     * @return int
     */
    public function GetCountTopicsPersonalNew() {

        $aFilter = $this->GetNamedFilter('new', array('personal' => true, 'sandbox' => false));
        return $this->GetCountTopicsByFilter($aFilter);
    }

    /**
     * @param array $aAdditionalOptions
     *
     * @return int
     */
    public function GetCountTopicsSandboxNew($aAdditionalOptions = array()) {

        $sCacheKey = 'count_topics_sandbox_new_' . serialize($aAdditionalOptions) . '-' . E::UserId();

        if (FALSE === ($iCount = E::ModuleCache()->GetTmp($sCacheKey))) {
            $aOptions = array('accessible' => true, 'sandbox' => true);
            if ($aAdditionalOptions && is_array($aAdditionalOptions)) {
                $aOptions = array_merge($aOptions, $aAdditionalOptions);
            }
            $aFilter = $this->GetNamedFilter('new', $aOptions);
            $iCount = $this->GetCountTopicsByFilter($aFilter);
            E::ModuleCache()->SetTmp($iCount, $sCacheKey);
        }

        return $iCount;
    }

    public function GetCountTopicsSandbox($aAdditionalOptions = array()) {

        $sCacheKey = 'count_topics_sandbox_all_' . serialize($aAdditionalOptions) . '-' . E::UserId();

        if (FALSE === ($iCount = E::ModuleCache()->GetTmp($sCacheKey))) {
            $aOptions = array('accessible' => true, 'sandbox' => true);
            if ($aAdditionalOptions && is_array($aAdditionalOptions)) {
                $aOptions = array_merge($aOptions, $aAdditionalOptions);
            }
            $aFilter = $this->GetNamedFilter('new_all', $aOptions);
            $iCount = $this->GetCountTopicsByFilter($aFilter);
            E::ModuleCache()->SetTmp($iCount, $sCacheKey);
        }

        return $iCount;
    }

    /**
     * @param ModuleBlog_EntityBlog|int $xBlog
     * @param array                     $aAdditionalOptions
     *
     * @return int|mixed
     */
    public function GetCountTopicsSandboxByBlog($xBlog, $aAdditionalOptions = array()) {

        $iBlogId = (is_object($xBlog) ? $xBlog->getId() : intval($xBlog));
        $sCacheKey = 'count_topics_sandbox_blog_' . $iBlogId . '_' . E::UserId();

        if (FALSE === ($iCount = E::ModuleCache()->GetTmp($sCacheKey))) {
            $aOptions = array('accessible' => true, 'sandbox' => true, 'blog_id' => $iBlogId);
            if ($aAdditionalOptions && is_array($aAdditionalOptions)) {
                $aOptions = array_merge($aOptions, $aAdditionalOptions);
            }
            $aFilter = $this->GetNamedFilter('new_all', $aOptions);
            $iCount = $this->GetCountTopicsByFilter($aFilter);
            E::ModuleCache()->SetTmp($iCount, $sCacheKey);
        }

        return $iCount;
    }

    /**
     * @param ModuleBlog_EntityBlog|int $xBlog
     * @param array                     $aAdditionalOptions
     *
     * @return int|mixed
     */
    public function GetCountTopicsSandboxNewByBlog($xBlog, $aAdditionalOptions = array()) {

        $iBlogId = (is_object($xBlog) ? $xBlog->getId() : intval($xBlog));
        $sCacheKey = 'count_topics_sandbox_blog_' . $iBlogId . '_' . E::UserId();

        if (FALSE === ($iCount = E::ModuleCache()->GetTmp($sCacheKey))) {
            $aOptions = array('accessible' => true, 'sandbox' => true, 'blog_id' => $iBlogId);
            if ($aAdditionalOptions && is_array($aAdditionalOptions)) {
                $aOptions = array_merge($aOptions, $aAdditionalOptions);
            }
            $aFilter = $this->GetNamedFilter('new', $aOptions);
            $iCount = $this->GetCountTopicsByFilter($aFilter);
            E::ModuleCache()->SetTmp($iCount, $sCacheKey);
        }

        return $iCount;
    }

    /**
     * @param ModuleUser_EntityUser|int $xUser
     * @param array                     $aAdditionalOptions
     *
     * @return int
     */
    public function GetCountTopicsSandboxByUser($xUser, $aAdditionalOptions = array()) {

        $iUserId = (is_object($xUser) ? $xUser->getId() : intval($xUser));
        $sCacheKey = 'count_topics_sandbox_user_' . $iUserId . '_' . E::UserId();

        if (FALSE === ($iCount = E::ModuleCache()->GetTmp($sCacheKey))) {
            $aOptions = array('accessible' => true, 'sandbox' => true, 'user_id' => $iUserId);
            if ($aAdditionalOptions && is_array($aAdditionalOptions)) {
                $aOptions = array_merge($aOptions, $aAdditionalOptions);
            }
            $aFilter = $this->GetNamedFilter('new_all', $aOptions);
            $iCount = $this->GetCountTopicsByFilter($aFilter);
            E::ModuleCache()->SetTmp($iCount, $sCacheKey);
        }

        return $iCount;
    }

    /**
     * @param ModuleUser_EntityUser|int $xUser
     * @param array                     $aAdditionalOptions
     *
     * @return int
     */
    public function GetCountTopicsSandboxNewByUser($xUser, $aAdditionalOptions = array()) {

        $iUserId = (is_object($xUser) ? $xUser->getId() : intval($xUser));
        $sCacheKey = 'count_topics_sandbox_user_' . $iUserId . '_' . E::UserId();

        if (FALSE === ($iCount = E::ModuleCache()->GetTmp($sCacheKey))) {
            $aOptions = array('accessible' => true, 'sandbox' => true, 'user_id' => $iUserId);
            if ($aAdditionalOptions && is_array($aAdditionalOptions)) {
                $aOptions = array_merge($aOptions, $aAdditionalOptions);
            }
            $aFilter = $this->GetNamedFilter('new', $aOptions);
            $iCount = $this->GetCountTopicsByFilter($aFilter);
            E::ModuleCache()->SetTmp($iCount, $sCacheKey);
        }

        return $iCount;
    }

    /**
     * @param ModuleUser_EntityUser|int $xUser
     * @param int                       $iPage
     * @param int                       $iPerPage
     *
     * @return array
     */
    public function GetTopicsSandboxByUser($xUser, $iPage, $iPerPage) {

        $iUserId = (is_object($xUser) ? $xUser->getId() : intval($xUser));
        $aFilter = $this->GetNamedFilter('default', array('accessible' => true, 'sandbox' => true, 'user_id' => $iUserId));

        return $this->GetTopicsByFilter($aFilter, $iPage, $iPerPage);
    }

    /**
     * @param ModuleBlog_EntityBlog $oBlog
     * @param int                   $iPage
     * @param int                   $iPerPage
     * @param string                $sShowType
     * @param null                  $sPeriod
     *
     * @return array
     */
    public function GetTopicsByBlog($oBlog, $iPage, $iPerPage, $sShowType = 'good', $sPeriod = null) {

        if ($sShowType == 'sandbox') {
            $iBlogId = (is_object($oBlog) ? $oBlog->getId() : intval($oBlog));
            $aFilter = $this->GetNamedFilter('new_all', array('blog_id' => $iBlogId, 'period' => $sPeriod, 'sandbox' => true));
            $aTopics = $this->GetTopicsByFilter($aFilter, $iPage, $iPerPage);
        } else {
            $aTopics = parent::GetTopicsByBlog($oBlog, $iPage, $iPerPage, $sShowType, $sPeriod);
        }
        return $aTopics;
    }
}

// EOF