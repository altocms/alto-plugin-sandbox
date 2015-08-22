<li {if $sMenuSubItemSelect=='sandbox'}class="active"{/if}>
    <a href="{$oUserProfile->getProfileUrl()}created/sandbox/">
        {$aLang.plugin.sandbox.menu_text}
        {if $aProfileStats['count_sandbox']} ({$aProfileStats['count_sandbox']}) {/if}
    </a>
</li>
