<div class="formulier">
    <h1>Nieuw Contract</h1>
    {include file='navbar.tpl' output=$output}
    
    <form action="toppiedesk.php?id=contractnieuw" id="dataform" method="post">
        <input type="hidden" name="oid" value="{$output.contract.id}" />
        
        <table>
            <tr>
                <td><label for="contractnummer">Contractnummer</label></td>
                <td><input name="contractnummer" id="contractnummer" type="text" value="{$output.contract.contractid}" /></td>
            </tr>
            <tr>
                <td><label for="begindatum">Begin datum</label></td>
                <td><input name="begindatum" autocomplete="off" id="begindatum" type="text" value="{$output.contract.begindatum}" /></td>
            </tr>
            <tr>
                <td><label for="einddatum">Eind datum</label></td>
                <td><input name="einddatum" autocomplete="off" id="einddatum" type="text" value="{$output.contract.einddatum}" /></td>
            </tr>
            <tr>
                <td><label for="contracttype">Contracttype</label></td>
                <td>
                    <select name="contracttype" id="contracttype">
                        {foreach from=$output.contracttype item=contracttype}
                            <option value="{$contracttype.id}" {if $contracttype.id eq $output.contract.contracttype}selected="selected"{/if}>{$contracttype.contracttype}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="leverancier">Leverancier</label></td>
                <td>
                    <select name="leverancier" id="leverancier">
                        {foreach from=$output.leverancier item=leverancier}
                            <option value="{$leverancier.id}" {if $leverancier.id eq $output.contract.leverancier}selected="selected"{/if}>{$leverancier.leverancier}</option>
                        {/foreach}
                    </select>
            </tr>
            <tr>
                <td><label for="opmerking">Opmerking</label></td>
                <td><textarea name="opmerking" id="opmerking">{$output.contract.opmerking}</textarea></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:right"><input type="submit" name="submit" value="Opslaan" /></td>
            </tr>
        </table>
    </form>
    
    <div class="spacer"></div>
    {if $output.contract.actief eq 1}
        <div id="footer">
            Dit contract is gearchiveerd
        </div>
    {/if}
</div>

<div class="formulier">
    <h1>Assets</h1>
    
    <form action="toppiedesk.php?id=contractnieuw" method="post">
        <input type="hidden" name="searchoid" value="{$output.values.searchoid}" />
        <input type="hidden" name="multi" value="{if $output.values.multi eq 1}1{else}0{/if}" />
        <table>
            <tr>
                <td>
                    <div id="behandelaars" style="margin:2px; overflow-y:scroll; max-height:500px;">
                        {foreach from=$output.assets.value item=user}
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
                        {foreach from=$output.gekoppeld.value item=user}
                            <input type="checkbox" value="{$user}" name="users[]" id="{$user}" /> <label for="{$user}">{$user}</label><br />
                        {/foreach}
                    </div>
                </td>
            </tr>
        </table>
    </form>
    
</div>