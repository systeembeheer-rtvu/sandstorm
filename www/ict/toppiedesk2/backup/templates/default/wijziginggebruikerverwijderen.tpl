<div class="formulier">
    <h1>Verwijder Gebruiker</h1>
    <div id="resultaten">
        <table id="table">
            <tr>
                <td>Voornaam</td>
                <td>Tussenvoegsel</td>
                <td>Achternaam</td>
                <td>Inlognaam</td>
                <td>Eind datum</td>
                <td>Afdeling</td>
                <td>Afgehandeld?</td>
            </tr>
            {foreach from=$output.users item=user}
                <tr>
                    <td>{$user.voornaam}</td>
                    <td>{$user.tussenvoegsel}</td>
                    <td>{$user.achternaam}</td>
                    <td>{$user.inlognaam}</td>
                    <td>{$user.einddatum}</td>
                    <td>{$user.afdeling}</td>
                    <td><img src="img/finish.png" alt="{$user.id}" title="Afmelden" /></td>
                </tr>
            {/foreach}
        </table>
    </div>
</div>