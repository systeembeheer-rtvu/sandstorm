<div class="formulier">
    <h1>Project</h1>
    <form action="toppiedesk.php?id=projectnieuw" {if $output.project.id != 0}class="selected"{/if} id="dataform" method="post">
        <input type="hidden" name="oid" value="{$output.project.id}" />
        <input type="hidden" name="prevAfgemeld" value="{$output.project.afgemeld}" />
        <table>
            <tr>
                <td>Titel</td>
                <td><input type="text" name="titel" size="50" value="{$output.project.titel}" /></td>
                <td rowspan="4" style="vertical-align: top;">
                    <table style="float:right; margin: 0 5px;">
                        {foreach from=$output.bestedetijd.users item=user}
                            <tr>
                                <td>{$user.naam}</td>
                                <td style="text-align:right; padding-right:3px;">{$user.bestedetijd}</td>
                            </tr>
                        {/foreach}
                        <tr style="border-top: solid 1px #000">
                            <td>Bestede tijd</td>
                            <td style="text-align:right; padding-right:3px;">{$output.bestedetijd.totaal}</td>
                        </tr>
                        <tr>
                            <td>Geplande tijd</td>
                            <td style="text-align:right;"><input style="text-align:right;" type="text" size="5" name="geplandetijd" value="{$output.project.geplandetijd}" /></td>
                        </tr>
                        <tr style="border-top: solid 1px #000">
                            <td>Over</td>
                            <td style="text-align:right; padding-right:3px; color:{if $output.bestedetijd.over > 0}#339933{elseif $output.bestedetijd.over < 0}#FF0000{else}#000{/if}">{$output.bestedetijd.over}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Deadline</td>
                <td><input type="text" name="deadline" value="{$output.project.deadline}" /></td>
            </tr>
            <tr>
                <td>Begroting</td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="begroting" class="js_resize">{$output.project.begroting} </textarea></td>
            </tr>
            <tr>
                <td>Doel</td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="doel" class="js_resize">{$output.project.doel}</textarea></td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align:top">
                    <table>
                        <tr>
                            <td colspan="2">Nieuwe activiteit</td>
                        </tr>
                        <tr>
                            <td><input type="text" name="date" value="{$output.project.date}" /></td>
                            <td colspan="1" style="text-align:right;">
                                bestede tijd <input type="text" name="bestedetijd" size="5" value="0:15" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><textarea name="activiteit" class="js_resize"></textarea></td>
                        </tr>
                        {if $output.project.activiteiten|@count gt 0}
                            <tr>
                                <td>Vorige activiteit(en)</td>
                            </tr>
                            {foreach from=$output.project.activiteiten item=a}
                                <tr>
                                    <td colspan="2" style="text-align:right;">
                                        <input type="hidden" name="act_id[]" value="{$a.id}" />
                                        bestede tijd
                                        <input type="text" class="old_incident" name="act_tijd[{$a.id}]" size="5" value="{$a.bestedetijd}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="old_incident" name="act_datum[{$a.id}]" value="{$a.datum}" /></td>
                                    <td style="text-align:right;"><input class="old_incident" type="text" name="act_behandelaar[{$a.id}]" value="{$a.behandelaar}" /></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><textarea name="act_omschrijving[{$a.id}]" class="old_incident js_resize">{$a.omschrijving}</textarea></td>
                                </tr>
                            {/foreach}
                        {/if}
                    </table>
                </td>
                <td style="vertical-align:top; padding: 5px;">
                    <div>
                        Opdrachtgever<br />
                        <input type="text" name="opdrachtgever" size="25" class="naam" value="{$output.project.opdrachtgever}" />
                    </div>
                    <div>
                        Verantwoordelijke<br />
                        <select name="verantwoordelijk">
                            <option value="0"></option>
                            {foreach from=$output.behandelaars item=behandelaar}
                                {if $behandelaar.actief eq 0 or $behandelaar.selected eq "true"}
                                    <option value="{$behandelaar.id}" {if $output.project.verantwoordelijk eq $behandelaar.id} selected="selected" {/if}>{$behandelaar.naam}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                    Medewerkers<br/>
                    <div id="behandelaars">
                        {foreach from=$output.behandelaars item=behandelaar}
                            {if $behandelaar.actief eq 0 or $behandelaar.selected eq "true"}
                                <input type="checkbox" name="behandelaar[]" {if $behandelaar.selected eq 'true'} checked="checked" {/if} value="{$behandelaar.id}" />{$behandelaar.naam}<br />
                            {/if}
                        {/foreach}
                    </div>
                    <div style="float:right;">
                        Top 10 <input type="checkbox" name="top10" {if $output.project.top10}checked="checked"{/if} />
                    </div>
                    <div style="clear:both;"></div>
                    <div style="float:right;">
                        <input type="submit" name="submit" value="Opslaan" />
                        <input type="submit" name="o&a" value="Sluiten" />
                        <input type="checkbox" name="gesloten" {if $output.project.afgemeld}checked="checked"{/if} />
                    </div>
                </td>
            </tr>
        </table>
        
    </form>
    <div style="clear:both;"></div>
    {if isset($output.project.aangemaaktdoor)}
        <div id="footer">
            Aangemaakt door: <b>{$output.project.aangemaaktdoor}</b> op <b>{$output.project.aangemaaktop}</b>
        </div>
    {/if}
</div>