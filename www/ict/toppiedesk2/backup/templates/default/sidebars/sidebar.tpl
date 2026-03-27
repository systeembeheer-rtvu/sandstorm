<div id="sidebar">
    {foreach from=$output.links.sb_links item=url}
        <a href="{$url.url}">{$url.link}</a><br />
    {/foreach}
</div>
<div id="content">