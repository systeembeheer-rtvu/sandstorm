<div class="formulier">
    <h1>User</h1>
    <form action="toppiedesk.php?id=user&searchoid={$output.searchoid}" id="dataform" method="post">
        <table>
            <tr>
                <td><label for="voornaam">Voornaam</label></td>
                <td><input type="text" id="voornaam" name="voornaam" value="{$output.user.voornaam}" /></td>
            </tr>
            <tr>
                <td><label for="tussenvoegsel">Tussenvoegsel</label></td>
                <td><input type="text" id="tussenvoegsel" name="tussenvoegsel" value="{$output.user.tussenvoegsel}" /></td>
            </tr>
            <tr>
                <td><label for="tussenvoegselafk">Tussenvoegsel afkorting</label></td>
                <td><input type="text" id="tussenvoegselafk" name="tussenvoegselafk" value="{$output.user.tussenvoegselafk}" /></td>
                <td><span class="info">Max. 5 characters</span></td>
            </tr>
            <tr>
                <td><label for="achternaam">Achternaam</label></td>
                <td><input type="text" id="achternaam" name="achternaam" value="{$output.user.achternaam}" /></td>
            </tr>
            <tr>
                <td><label for="inlognaam">Inlognaam</label></td>
                <td><input type="text" id="inlognaam" name="inlognaam" value="{$output.user.inlognaam}" /></td>
            </tr>
            <tr>
                <td><label for="adres">Adres</label></td>
                <td><input type="text" id="adres" name="adres" value="{$output.user.adres}" /></td>
            </tr>
            <tr>
                <td><label for="postcode">Postcode</label></td>
                <td><input type="text" id="postcode" name="postcode" value="{$output.user.postcode}" /></td>
            </tr>
            <tr>
                <td><label for="plaats">Plaats</label></td>
                <td><input type="text" id="plaats" name="plaats" value="{$output.user.plaats}" /></td>
            </tr>
            <tr>
                <td><label for="gebdat">Geboortedatum</label></td>
                <td><input type="text" id="gebdat" name="gebdat" value="{$output.user.gebdat}" autocomplete="off" /></td>
            </tr>
            <tr>
                <td><label for="datumindienst">Datum in dienst</label></td>
                <td><input type="text" id="datumindienst" name="datumindienst" value="{$output.user.datumindienst}" autocomplete="off" /></td>
            </tr>
            <tr>
                <td><label for="actief">Actief</label></td>
                <td>
                    <select name="actief">
                        <option value="0" {if $output.user.actief eq 0} selected="selected" {/if}>Aangevraagd</option>
                        <option value="1" {if $output.user.actief eq 1} selected="selected" {/if}>Goedgekeurd</option>
                        <option value="2" {if $output.user.actief eq 2} selected="selected" {/if}>In dienst</option>
                        <option value="3" {if $output.user.actief eq 3} selected="selected" {/if}>Uit dienst</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><a href="toppiedesk.php?id={$output.prevpage}">&lt;Terug</a></td>
                <td style="text-align:right;"><input type="submit" name="submit" value="Opslaan"/></td>
            </tr>
        </table>
    </form>
</div>