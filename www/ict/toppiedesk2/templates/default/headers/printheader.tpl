<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
        
        <title>{$output.titles.header}</title>
        
        {if isset($output.script)}
            {$output.script}
        {/if}
        
        <link href="css/reset-min.css" rel="stylesheet" type="text/css" />
        <link href="css/printstyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print()">
        <div id="tester"></div>
        <div id="site">
            <div id="header">
                
                <div class="spacer"></div>
            </div>
            <div id="main">