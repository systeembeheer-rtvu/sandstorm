<div id="formulier">
    <h1>Aanmaken User Account</h1>
    <p>
        Hier kun je een useraccount aanmaken.<br />
        <br />
        <span class="required">*</span> = verplicht.
    </p>
    <form style="width: auto;" action="index.php?id=user" method="post" />
        <input type="hidden" name="id" value="user" />
        <label for="voornaam">Voornaam <span class="required">*</span></label><br />
        <input type="text" name="voornaam" id="voornaam" /><br />
        <br />
        <label for="tussenvoegsel">Tussenvoegsel</label><br />
        <input type="text" name="tussenvoegsel" id="tussenvoegsel" /><br />
        <br />
        <label for="achternaam">Achternaam <span class="required">*</span></label><br />
        <input type="text" name="achternaam" id="achternaam" /><br />
        <br />
        <br/>
        <label for="adres">Adres <span class="required">*</span></label><br />
        <input type="text" name="adres" id="adres" /><br />
        <br />
        <label for="postcode">Postcode <span class="required">*</span></label><br />
        <input type="text" name="postcode" id="postcode" /><br />
        <br />
        <label for="plaats">Plaats <span class="required">*</span></label><br />
        <input type="text" name="plaats" id="plaats" /><br />
        <br />
        <label for="gebdat">Geboortedatum <span class="required">*</span></label><br />
        <input type="text" autocomplete="off" name="gebdat" id="gebdat" /> <span class="info">Bijv: 01-01-2011</span><br />
        <br />
        <br />
        <label for="begindatum">Begin datum <span class="required">*</span></label><br />
        <input type="text" autocomplete="off" name="begindatum" id="begindatum" /> <span class="info">Bijv: 01-01-2011</span><br />
        <br />
        <label for="afdeling">Afdeling <span class="required">*</span></label><br />
        <select name="afdeling">
            <option value="0"></option>
            {foreach from=$output.afdeling item=afdeling}
                <option value="{$afdeling.id}">{$afdeling.afdeling}</option>
            {/foreach}
        </select>
        <input style="float:right;" name='submit' type="submit" value="Opslaan" />
    </form>
</div>

<div style="position:absolute; top:410px; left:540px;" id="fout">
    <h1>Fout</h1>
    <p></p>
</div>