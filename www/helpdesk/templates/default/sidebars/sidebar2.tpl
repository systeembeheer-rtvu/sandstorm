<div id="sidebar">
    <ul>
        {foreach from=$output.links.sb_links item=url}
            <li><a href="{$url.url}">{$url.link}</a></li>
        {/foreach}
    </ul>
</div>
<div id="content">