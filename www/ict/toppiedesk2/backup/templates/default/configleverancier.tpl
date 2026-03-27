<div class="formulier">
    <h1>Leverancier</h1>
    {include file='navbar.tpl' output=$output}
    <form id="dataform">
        <input type="hidden" name="oid" value="{if isset($output.leverancier.id)}{$output.leverancier.id}{else}0{/if}" />
        <table>
            <tr>
                <td><label for="leverancier">Leverancier</label></td>
                <td><input type="text" id="leverancier" name="leverancier" value="{$output.leverancier.leverancier}" /></td>
            </tr>
            <tr>
                <td><label for="klantnummer">Klantnummer</label></td>
                <td><input type="text" name="klantnummer" value="{$output.leverancier.klantnummer}" /></td>
            </tr>
            <tr>
                <td><label for="Contactpersoon">Contactpersoon</label></td>
                <td><input type="text" name="contactpersoon" value="{$output.leverancier.contactpersoon}" /></td>
            </tr>
            <tr>
                <td><label for="Telefoonnummer">Telefoonnummer</label></td>
                <td><input type="text" name="telefoonnummer" value="{$output.leverancier.telefoonnummer}" /></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:right;"><input type="button" name="opslaan" value="Opslaan" /></td>
            </tr>
        </table>
    </form>
</div>