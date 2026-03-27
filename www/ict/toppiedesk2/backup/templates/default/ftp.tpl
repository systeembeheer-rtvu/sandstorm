<div class="formulier">
    <h1>FTP account</h1>
    <form action="toppiedesk.php?id=ftp&searchoid={$output.ftp.user}" method="post">
        <table>
            <tr>
                <td>User</td>
                <td>{$output.ftp.user}</td>
            </tr>
            <tr>
                <td>Home directory</td>
                <td>{$output.ftp.dir}</td>
            </tr>
            <tr>
                <td style="vertical-align:top;">Commentaar</td>
                <td><textarea name="comment">{$output.ftp.comment}</textarea></td>
            </tr>
            <tr>
                <td>Permanent</td>
                <td><input type="checkbox" name="verlopen" {if $output.ftp.kanverlopen eq 0}checked="checked"{/if} /></td>
            </tr>
            <tr>            
                <td><span id="color">Verloopdatum</span></td>
                <td><input type="text" name="verloopdat" autocomplete="off" value="{$output.ftp.verloopdatum}" /></td>
            </tr>
            <tr>
                <td>Wachtwoord Wijzigen</td>
                <td><input type="text" name="password" autocomplete="off" size="23" /></td>
            </tr>
            <tr>
                <td><a href="toppiedesk.php?id=wijzigingftpaccountbeheer">&lt; Terug</a></td>
                <td style="text-align: right;">
                    <input type="submit" name="submit" value="Opslaan" /><input type="submit" name="opschonen" value="Verwijderen" /><br />
                    <span class="info">Met verwijderen wordt het account verwijderd met de volgende opschoon ronde</span>
                </td>
            </tr>
        </table>
        {if $output.ftp.AangevraagdDoor != ""}<div id="footer">Aangemaakt door <b>{$output.ftp.AangevraagdDoor}</b></div>{/if}
    </form>
</div>
