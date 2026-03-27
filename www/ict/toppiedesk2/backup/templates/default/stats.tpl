<form action="toppiedesk.php" method="get">
    <input type="hidden" name="id" value="stats" />
    <select size="5" name="stat">
        {foreach from=$output.stats.menu item=menu}
            <option value="{$menu.id}">{$menu.title}</option>
        {/foreach}
    </select>
    <input type="submit" value="Toon" name="submit" />
</form>