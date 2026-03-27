<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPG Overzicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function autoSubmit() {
            document.getElementById("filterForm").submit();
        }
    </script>
</head>
<body class="container mt-4">

    <h2 class="mb-4">EPG Overzicht EPG Additor</h2>
    <h3 class="mb-4">
        <a href="https://sandstorm.park.rtvutrecht.nl/epg/epgarchief.php">Archief van voor EPG Additor (2022)</a>
    </h3>

    <form method="GET" id="filterForm" class="mb-3">
        <div class="row">
            <!-- Date Selection -->
            <div class="col-md-4">
                <label for="datum" class="form-label">Kies een datum:</label>
                <div class="input-group">
                    <a href="?datum={$prev_date|escape}&zender={$selected_channel|escape}&show_reruns={$show_reruns|escape}" class="btn btn-outline-secondary">← Vorige dag</a>
                    <input type="date" id="datum" name="datum" class="form-control" value="{$selected_date|escape}" onchange="autoSubmit()">
                    <a href="?datum={$next_date|escape}&zender={$selected_channel|escape}&show_reruns={$show_reruns|escape}" class="btn btn-outline-secondary">Volgende dag →</a>
                </div>
                <small class="text-muted">{$display_date|capitalize|escape}</small>
            </div>

            <!-- Channel Selection -->
            <div class="col-md-4">
                <label for="zender" class="form-label">Selecteer een zender:</label>
                {html_options name="zender" id="zender" class="form-select" options=$channels selected=$selected_channel onchange="autoSubmit()"}
            </div>

            <!-- Rerun Toggle -->
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="show_reruns" name="show_reruns" value="1" {if $show_reruns}checked{/if} onchange="autoSubmit()">
                    <label class="form-check-label" for="show_reruns">Toon herhalingen</label>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                {foreach from=$columns item=col_label}
                    <th>{$col_label|escape}</th>
                {/foreach}
            </tr>
        </thead>
        <tbody>
            {if $programs|@count > 0}
                {foreach from=$programs item=prog}
                    {* Bold row if start ends in 00:00 *}
                    {assign var=rowstyle value=''}
                    {if $prog.start|substr:-5 == "00:00"}
                        {assign var=rowstyle value='font-weight: bold;'}
                    {/if}
                    <tr style="{$rowstyle}">
                        {foreach from=$columns key=field item=label}
                            {* Highlight if not a rerun *}
                            {assign var=highlight value=($prog.herhaling == "Nee") ? 'background-color: #40E0D0 !important;' : ''}
                            <td style="{$highlight}">
                                {if $field == 'daletid'}
                                    <a href="https://epg.rtvutrecht.nl/epg-guide/title/{$prog.daletid|escape}" target="_blank">
                                        {$prog.daletid|escape}
                                    </a>
                                {else}
                                    {$prog[$field]|escape}
                                {/if}
                            </td>
                        {/foreach}
                    </tr>
                {/foreach}
            {else}
                <tr>
                    <td colspan="{$columns|@count}" class="text-center">Geen resultaten gevonden voor deze datum.</td>
                </tr>
            {/if}
        </tbody>
    </table>

</body>
</html>
