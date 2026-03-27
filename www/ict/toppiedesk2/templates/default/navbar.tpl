<div id="navbar">
    <form action="" method="get" name="navbar" >
        {if $output.navbar.new != "false"}
            <a href="{$output.navbar.new}" title="Nieuw" name="new"><img src="img/mail_new.png" /></a>
        {/if}
        {if $output.navbar.save != "false"}
            <a href="{$output.navbar.save}" title="Opslaan" name="save"><img src="img/filesave.png" /></a>
        {/if}
        {if $output.navbar.mail != "false"}
            <a href="{$output.navbar.mail}" title="E-mail" name="mail"><img src="img/mail_generic.png" /></a>
        {/if}
        
        {if $output.navbar.search != "false"}
            <input type="hidden" name="id" value="{$output.navbar.id}" />
            <input type="text" name="searchoid" value="{$output.values.searchoid}" {if isset($output.navbar.autocomplete)} class="{$output.navbar.autocomplete}" {/if} />
        {/if}
        
        {if $output.navbar.prev != "false"}
            <a href="{$output.navbar.prev}" title="Vorige" name="prev"><img src="img/1leftarrow.png" /></a>
        {/if}
        {if $output.navbar.next != "false"}
            <a href="{$output.navbar.next}" title="Volgende" name="next"><img src="img/1rightarrow.png" /></a>
        {/if}
        {if $output.navbar.archive != "false"}
            <a href="{$output.navbar.archive}" title="Archiveren" name="archive"><img src="img/delete.png" /></a>
        {/if}
    </form>
</div>