<a class="btn btn-default {if $sMenuSubItemSelect=='sandbox'}active{/if}" href="{$oUserProfile->getProfileUrl()}created/sandbox/">
    {$aLang.plugin.sandbox.menu_text}
    {if $aProfileStats['count_sandbox']} ({$aProfileStats['count_sandbox']}) {/if}
</a>
