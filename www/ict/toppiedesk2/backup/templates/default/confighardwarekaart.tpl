<div class="formulier">
    <h1 id="js_opslaan">Hardware Kaart</h1>
    {include file='navbar.tpl' output=$output}
    <form id="dataform">
        <input type="hidden" name="id" value="confighardwarekaart" />
        <table style="float:left;">
            <tr>
                <td>Asset tag</td>
                <td><input type="text" name="oid" value="{$output.values.searchoid}" class="input" /></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="hardwaretype" class="input">
                        {foreach from=$output.hardware.types item=type}
                            <option name="{$type.id}" {if $type.type eq $output.values.hardwaretype} selected="selected" {/if} >{$type.type}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <td>Multi</td>
                <td><input type="checkbox" name="multi" {if $output.values.multi eq 1} checked="checked" {/if} class="input" /></td>
            </tr>
            <tr>
                <td>Leverancier</td>
                <td>
                    <select name="leverancier" class="input">
                        {foreach from=$output.leverancier item=leverancier}
                            <option value="{$leverancier.id}" {if $leverancier.id eq $output.values.leverancier} selected="selected" {/if}>{$leverancier.leverancier}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <td>Contract</td>
                <td>
                    <select name="contract" class="input">
                        {foreach from=$output.contract item=contract}
                            <option value="{$contract.id}">{$contract.contractid}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        </table>
        
        <table style="float:left; margin:0 5px;">
            {foreach from=$output.hardware.value item=hardware}
                <tr>
                    <td>{$hardware.label}</td>
                    <td><input type="{$hardware.type}" name="{$hardware.id}" value="{$hardware.value}" class="input" /></td>
                </tr>
            {/foreach}
        </table>
    </form>
</div>

<div class="formulier" id="js_show">
    <h1>Gebruikers</h1>
    <div>
        <form action="toppiedesk.php?id=confighardwarekaart" method="post">
            <input type="hidden" name="searchoid" value="{$output.values.searchoid}" />
            <input type="hidden" name="multi" value="{if $output.values.multi eq 1}1{else}0{/if}" />
            <table>
                <tr>
                    <td>
                        <div id="behandelaars" style="margin:2px; overflow-y:scroll; max-height:500px;">
                            {foreach from=$output.medewerkers.value item=user}
                                <input type="checkbox" value="{$user}" name="medewerkers[]" id="{$user}" /> <label for="{$user}">{$user}</label><br />
                            {/foreach}
                        </div>
                    </td>
                    <td>
                        <input type="submit" name="submit" value="--- Toevoegen -->" /><br />
                        <input type="submit" name="submit" value="<-- Verwijderen --" />
                    </td>
                    <td>
                        <div id="behandelaars" style="margin:2px; overflow-y:scroll; max-height:500px;">
                            {foreach from=$output.user.value item=user}
                                <input type="checkbox" value="{$user}" name="users[]" id="{$user}" /> <label for="{$user}">{$user}</label><br />
                            {/foreach}
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<a href="toppiedesk.php?id=confignieuwhardwaretype" />Nieuw hardware type aanmaken</a><br />