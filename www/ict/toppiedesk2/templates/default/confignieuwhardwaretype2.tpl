<div class="formulier">
    <h1>Nieuw hardware type</h1>
    <div id="velden">
        <form action="toppiedesk.php?id=confignieuwhardwaretype" method="post">
            <input type="hidden" name="aantal" value="{$output.vars.aantal}" />
            
            <table>
                <tr>
                    <td><label for="typenaam">Type naam</label></td>
                    <td><input type="text" name="typenaam" /></td>
                </tr>
                {section name=foo loop=$output.vars.aantal}
                    <tr>
                        <td><label for="naam[{$smarty.section.foo.iteration}]">Veld naam</label></td>
                        <td><input type="naam" name="naam[{$smarty.section.foo.iteration}]" id="naam" /></td>
                        <td><label for="type[{$smarty.section.foo.iteration}]">Type</label></td>
                        <td>
                            <select name="type[{$smarty.section.foo.iteration}]" id="type">
                                <option value="text">Text</option>
                            </select>
                        </td>
                    </tr>
                {/section}
            </table>
            <br />
            <input type="submit" name="submit" value="Aanmaken" />
            <input type="submit" name="submit" value="Annuleren" />
        </form>
    </div>
</div>