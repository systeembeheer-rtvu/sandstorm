<div class="formulier">
    <h1>Nog goed te keuren gebruikersaccounts</h1>
    <div id="resultaten">
        <form action="toppiedesk.php?id=wijzigingnieuwegebruiker" method="post">
            <table id="table">
                <thead>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="2">Goedkeuren</td>
                    </tr>
                    <tr>
                        <td>Voornaam</td>
                        <td>Tussenvoegsel</td>
                        <td>Achternaam</td>
                        <td>Inlognaam</td>
                        <td>Begin datum</td>
                        <td>Afdeling</td>
                        <td>Ja</td>
                        <td>Nee</td>
                    </tr>
                </thead>
                {if $output.counter.accepteren != 0}
                    {foreach from=$output.accepteren item=user}
                        <tr class="{if $user.color eq 1}odd{elseif $user.color eq 0}even{/if}">
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}'>{$user.voornaam}</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}'>{$user.tussenvoegsel}</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}'>{$user.achternaam}</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}'>{$user.inlognaam}</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}'>{$user.datumindienst}</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}'>{$user.afdeling}</td>
                            <td><input type="radio" name="accept[{$user.id}]" value="ja" /></td>
                            <td><input type="radio" name="accept[{$user.id}]" value="nee" /></td>
                        </tr>
                    {/foreach}
                    <tr><td colspan="8" style="text-align:right;"><input type="submit" name="accepteren" value="Opslaan" /></td></tr>
                {else}
                    <tr>
                        <td colspan="8">Er zijn geen nieuwe aanvragen.</td>
                    </tr>
                {/if}
            </table>
        </form>
    </div>    
</div>

<div class="spacer" />

<div class="formulier">
    <h1>Nieuwe Gebruiker</h1>
    <div id="resultaten">
        <table id="table">
            <thead>
                <tr>
                    <td>Voornaam</td>
                    <td>Tussenvoegsel</td>
                    <td>Achternaam</td>
                    <td>Inlognaam</td>
                    <td>Begin datum</td>
                    <td>Afdeling</td>
                </tr>
            </thead>
            {if $output.counter.userskort != 0}
                <tr style="background-color:black;color:white;font-size:110%;text-align:center;"><td colspan="6">Binnen een week</td></tr>
                {foreach from=$output.userskort item=user}
                    <tr onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}' class="{if $user.color eq 1}odd{elseif $user.color eq 0}even{/if} pointer">
                        <td>{$user.voornaam}</td>
                        <td>{$user.tussenvoegsel}</td>
                        <td>{$user.achternaam}</td>
                        <td>{$user.inlognaam}</td>
                        <td>{$user.datumindienst}</td>
                        <td>{$user.afdeling}</td>
                    </tr>
                {/foreach}
            {/if}
            {if $output.counter.userslang != 0}
                <tr style="background-color:black;color:white;font-size:110%;text-align:center;"><td colspan="6">Later</td></tr>
                {foreach from=$output.userslang item=user}
                    <tr onclick=parent.location.href='toppiedesk.php?id=user&searchoid={$user.id}' class="{if $user.color eq 1}odd{elseif $user.color eq 0}even{/if} pointer">
                        <td>{$user.voornaam}</td>
                        <td>{$user.tussenvoegsel}</td>
                        <td>{$user.achternaam}</td>
                        <td>{$user.inlognaam}</td>
                        <td>{$user.datumindienst}</td>
                        <td>{$user.afdeling}</td>
                    </tr>
                {/foreach}
            {/if}
            {if $output.counter.userskort == 0 && $output.counter.userslang == 0}
                <tr><td colspan="6">Er zijn geen nieuwe accounts die aangemaakt moeten worden.</td></tr>
            {/if}
        </table>
    </div>    
</div>