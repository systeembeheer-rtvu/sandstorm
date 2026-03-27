<div id="formulier">
    <h1>Aanmaken FTP Account</h1>
    <p>
        Hier kun je een tijdelijk FTP account aanmaken. Dit account zal na 7 dagen verwijderd worden.<br /><br/>
        Mocht een account langer nodig zijn, vul dan de reden in waarvoor het account bedoeld is. De afdeling ICT zal vervolgens de aanvraag verwerken.<br /><br />
        De accountnaam wordt gelijk aan de naam van de map op de T: schijf.<br />
        <br />
        {if $output.setemail eq 1}
            Er zal een mail verstuurd worden naar <b>{$output.email}</b> met de inloggegevens.<br />
        <br />
        {/if}
        <span class="required">*</span> = verplicht.
        {if isset($output.info)}
            <br /><br />
            <span class="required">{$output.info}</span>
        {/if}
    </p>
    
    <div id="hint">
        Geen spaties, geen hoofdletters, alleen a t/m z en cijfers.<br>Maximaal 16 karakters.
    </div>

    <form action="index.php?id=ftp" method="post" id="ftp">
        
        <label for="naam">Accountnaam <span class="required">*</span></label><br />
        <input name="naam" class="account" type="text" id="naam" MAXLENGTH="16" /><br />
        <br />
        {if $output.setemail eq 1}
            <input type="hidden" name="email" value="{$output.email}" />
        {else}
            <label for="email">E-mail <span class="required">*<br/>let op: alleen @rtvutrecht.nl adressen invullen</span></label><br />
            <input type="texy" name="email" id="email" size="40" /><br/><br/>
        {/if}
        <label for="omschrijving">Voor wie of wat is het account bedoeld?</label><br />
        <textarea name="omschrijving" id="omschrijving"></textarea><br />
        <br />
        <input type="submit" name="submit" value="Aanvragen" />
    </form>
</div>

<div id="fout">
    <h1>Fout</h1>
    <p>Niet alle velden hebben geldige waardes.</p>
</div>