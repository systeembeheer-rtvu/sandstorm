<div id="sidebar">
    <ul>
        {foreach from=$output.links.sb_links item=url}
            <li><a href="{$url.url}" target="_{$url.target}">{$url.link}</a></li>
        {/foreach}
    </ul>
</div>
<div id="content">