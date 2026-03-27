<form action="toppiedesk.php?id=configcontract" name="contract" id="dataform" method="post">
    <table>
        <tr>
            <td><label for="naam">Naam</label></td>
            <td><input type="hidden" name="naam" value="{$output.contract.naam}" />{$output.contract.naam}</td>
        </tr>
        <tr>
            <td><label for="gebdat">Geb. datum</label></td>
            <td><input size="25" type="text" name="gebdat" id="gebdat" value="{$output.contract.gebdat}" /></td>
        </tr>
        <tr>
            <td><label for="adres">Adres</label></td>
            <td><input size="25" type="text" name="adres" id="adres" value="{$output.contract.adres}" /></td>
        </tr>
        <tr>
            <td><label for="postcode">Postcode</label></td>
            <td><input size="25" type="text" name="postcode" id="postcode" value="{$output.contract.postcode}" /></td>
        </tr>
        <tr>
            <td><label for="plaats">Plaats</label></td>
            <td><input size="25" type="text" name="plaats" id="plaats" value="{$output.contract.plaats}" /></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right"><input type="submit" name="submit" value="Genereer" /></td>
        </tr>
    </table>
</form>