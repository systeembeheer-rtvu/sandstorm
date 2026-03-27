<div class="formulier">
    <h1>Persoonskaart</h1>
    {include file='navbar.tpl' output=$output}
    <form id="dataform" action="toppiedesk.php?id=configkaart" method="post">
        {if isset($output.config)}
            <input type="hidden" name="searchoid" value="{$output.values.searchoid}" />
            <table>
                <tr>
                    <td>Item</td>
                    <td><input type="text" name="hardware" class="hardware" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Toevoegen" />
                        <input type="submit" name="submit" value="Contract" />
                    </td>
                </tr>
            </table>
        {/if}
    </form>
</div>

<div id="resultaten" style="width:750px;">
    {if $output.values.name != ""}
        Items van {$output.values.name}
    {/if}
    <table id="table">
        <thead>
            <tr>
                <td>Object ID</td>
                <td>Type</td>
                <td><a href="toppiedesk.php?id=configkaart" title="Alles verwijderen" name="archive"><img src="img/delete.png" /></a></td>
            </tr>
        </thead>
        {foreach from=$output.config.items item=config}
            <tr class="{if $config.color eq 1}odd{else}even{/if} pointer" onclick=parent.location.href='toppiedesk.php?id=confighardwarekaart&searchoid={$config.oid}' >
                <td>{$config.oid}</td>
                <td>{$config.type}</td>
                <td><a href="" name="{$config.oid}" title="Item verwijderen" class="js_delete"><img src="img/delete.png" /></a></td>
            </tr>
        {/foreach}
    </table>
</div>
