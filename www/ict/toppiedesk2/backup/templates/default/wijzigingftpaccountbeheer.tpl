<div class="formulier">
    <h1>FTP accounts</h1>
    <div id="resultaten">
        <table id="table">
            <tr>
                <thead>
                    <td>User</td>
                    <td>Home directory</td>
                    <td>Commentaar</td>
                    <td>Verloopdatum</td>
                </thead>
            </tr>
            {foreach from=$output.ftp item=ftp}
                <tr class="{if $ftp.color eq 1}odd{elseif $ftp.color eq 0}even{elseif $ftp.color eq 3}user{/if} pointer" onclick=parent.location.href='toppiedesk.php?id=ftp&searchoid={$ftp.user}'>
                    <td>{$ftp.user}</td>
                    <td>{$ftp.dir}</td>
                    <td>{$ftp.comment}</td>
                    <td>{$ftp.verloopdatum}</td>
                </tr>
            {/foreach}
        </table>
    </div>
</div>