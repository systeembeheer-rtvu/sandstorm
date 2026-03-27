<div class="formulier">
    <h1>{$output.title}</h1>
    <form id="dataform" action="" method="post">
        <table>
            <tr>
                <td>
                    Begin datum:
                </td>
                <td>
                    <select>
                        {section name=day loop=31} 
                            <option {if $output.vars.van.dag eq $smarty.section.day.iteration} selected="selected" {/if} value="{$smarty.section.day.iteration}">{$smarty.section.day.iteration}</option>
                        {/section}
                    </select>
                </td>
                <td>
                    <select>
                        {section name=month loop=12} 
                            <option {if $output.vars.van.maand eq $smarty.section.month.iteration} selected="selected" {/if} value="{$smarty.section.month.iteration}">{$smarty.section.month.iteration}</option>
                        {/section}
                    </select>
                </td>
                <td>
                    <select>
                        {section name=year start=2010 loop=$output.vars.huidig.jaar+1}
                            <option {if $output.vars.van.jaar eq $smarty.section.year.index} selected="selected" {/if} value="{$smarty.section.year.index}">{$smarty.section.year.index}</option>
                        {/section}
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Eind datum:
                </td>
                <td>
                    <select>
                        {section name=day loop=31} 
                            <option {if $output.vars.van.dag eq $smarty.section.day.iteration} selected="selected" {/if} value="{$smarty.section.day.iteration}">{$smarty.section.day.iteration}</option>
                        {/section}
                    </select>
                </td>
                <td>
                    <select>
                        {section name=month loop=12} 
                            <option {if $output.vars.van.maand eq $smarty.section.month.iteration} selected="selected" {/if} value="{$smarty.section.month.iteration}">{$smarty.section.month.iteration}</option>
                        {/section}
                    </select>
                </td>
                <td>
                    <select>
                        {section name=year start=2010 loop=$output.vars.huidig.jaar+1}
                            <option {if $output.vars.van.jaar eq $smarty.section.year.index} selected="selected" {/if} value="{$smarty.section.year.index}">{$smarty.section.year.index}</option>
                        {/section}
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right"><input type="submit" value="Toon" /></td>
            </tr>
        </table>
    </form>
</div>

<div id="resultaten">
    <table id="table">
        <tr>
            <thead>
                <td>uur</td>
                <td>aantal</td>
            </thead>
        </tr>
        {foreach from=$output.time item=test}
            <tr class="{if $test.color eq 1}odd{else}even{/if}">
                <td>{$test.title}</td>
                <td>{$test.count}</td>
            </tr>
        {/foreach}
    </table>
</div>