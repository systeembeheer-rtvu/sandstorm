<div class="formulier">
    <h1>Invoerder</h1>
    <form action="toppiedesk.php" method="get" style="padding: 5px;">
        <input type="hidden" name="id" value="setuser" />
        <div class="float">
            
            <select name="behandelaar" id="behandelaar"  size="10">
                {foreach from=$output.behandelaars item=behandelaar}
                    <option {if $behandelaar.selected eq 'true'} selected="selected" {/if} value="{$behandelaar.id}">{$behandelaar.naam}</option>
                {/foreach}
            </select>
        </div>
        <div class="spacer"></div>
        <input type="submit" value="Ok" name="accept" />
    </form>
</div>