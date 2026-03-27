<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
	<title>{$output.titles.header}</title>
        
        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="js/ui/jquery.ui.datepicker-nl.js"></script>
        <script type="text/javascript" src="js/jquery.ata.js"></script>
        <script type="text/javascript" src="js/jquery.expander.js"></script>
        <script type="text/javascript" src="js/jquery.preload.js"></script>
        <script type="text/javascript" src="js/functions2.js"></script>
	<script type="text/javascript" src="js/jquery.highlight-3.js"></script>
        
        {if isset($output.script)}
            {$output.script}
        {/if}
        
        <link href="css/reset-min.css" rel="stylesheet" type="text/css" />
        <link href="css/style2.css" rel="stylesheet" type="text/css" />
        <link type="text/css" href="css/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
    </head>
    <body>
        <div id="tester"></div>
        <div id="site">
            <div id="header">
                <div id="options">
                    {foreach from=$output.links.settings item=settings}
                        <a href="{$settings.path}"><img src="img/{$settings.img}" height="25" width="25" alt="{$settings.name}" /></a>
                    {/foreach}
                </div>
                <div id="title">
                    {$output.titles.page}
                </div>
                
                <div id="links">
                    {foreach from=$output.links.top_links item=value}
                        <a href="{$value.path}">{$value.name}</a>
                    {/foreach}
                </div>
                <div class="spacer"></div>
            </div>
            <div id="main">