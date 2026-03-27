<div id="accordion">
    <h3><a href="#">Behandelaars</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">Aanmaken</a></li>
                <li><a href="#tabs-2">Bewerken</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <input type="hidden" name="part" value="behandelaar" />
                    <table>
                        <tr>
                            <td><label for="naam">Naam</label></td>
                            <td><input type="text" name="naam" id="naam" class="naam" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="Aanmaken" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                <form>
                    <input type="hidden" name="part" value="behandelaar" />
                    <table>
                        <tr>
                            <td>Naam</td>
                            <td>
                                <select name="behandelaar">
                                    {foreach from=$output.behandelaars item=behandelaar}
                                        <option {if $output.vars.behandelaar eq $behandelaar.id}selected="selected" {/if} value="{$behandelaar.id}">{$behandelaar.naam}{if $behandelaar.actief eq 1} (inactief){/if}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="(de)activeren" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <h3><a href="#">Status</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">Aanmaken</a></li>
                <li><a href="#tabs-2">Bewerken</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <input type="hidden" name="part" value="status" />
                    <table>
                        <tr>
                            <td>Status</td>
                            <td><input type="text" name="naam" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="submit" value="Aanmaken" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                <form>
                    <input type="hidden" name="part" value="status" />
                    <table>
                        <tr>
                            <td>status</td>
                            <td>
                                <select name="status">
                                    {foreach from=$output.status item=status}
                                        <option value="{$status.id}">{$status.status} {if $status.actief eq 1} (inactief){/if}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="submit" value="(de)activeren" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <h3><a href="#">Categorie&euml;n</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">Aanmaken</a></li>
                <li><a href="#tabs-2">Bewerken</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <input type="hidden" name="part" value="categorie" />
                    <table>
                        <tr>
                            <td>Categorie</td>
                            <td><input type="text" name="catName" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="Aanmaken" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                <form>
                    <input type="hidden" name="part" value="categorie" />
                    <table>
                        <tr>
                            <td>Categorie</td>
                            <td>
                                <select name="categorie">
                                    {foreach from=$output.categorie item=categorie}
                                        <option {if $output.vars.categorie eq $categorie.id}selected="selected" {/if} value="{$categorie.id}">{$categorie.categorie}{if $categorie.actief eq 1} (inactief){/if}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="(de)activeren" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <h3><a href="#">Toegangscontrolle</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">user account aanvragen</a></li>
                <li><a href="#tabs-2">Unknown</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <table>
                        <tr><td><label for="uaa_naam">Naam</label></td><td>Afdeling</td></tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <input type="text" name="naam" class="naam" id="uaa_naam" />
                            </td>
                            <td>
                                <div id="checkbox" style="width:300px;">
                                    <table>
                                        {foreach from=$output.afdeling item=afdeling}
                                            <tr><td><input type="checkbox" name="afdeling" value={$afdeling.id} /></td><td>{$afdeling.afdeling}</td></tr>
                                        {/foreach}
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="Aanpassen" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                
            </div>
        </div>
    </div>
</div>