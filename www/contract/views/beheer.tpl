{extends file="base.tpl"}

{block name="extra_css"}
.field-row { display: flex; gap: 8px; align-items: center; margin-bottom: 6px; }
.field-row input { flex: 1; }
{/block}

{block name="content"}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-folder2-open me-2"></i>Contractbeheer</h2>
    <div class="d-flex gap-2">
        <a href="/contract/" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye me-1"></i>Naar invulpagina</a>
        <a href="beheer.php?action=new" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nieuwe template</a>
    </div>
</div>

{if $message}
<div class="alert alert-{$msg_type} mb-4">{$message}</div>
{/if}

{if $edit !== null}
{* ── EDIT / NEW FORM ── *}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header fw-semibold">
        {if $edit.base}{$edit.naam|escape|default:'Template bewerken'}{else}Nieuwe template{/if}
    </div>
    <div class="card-body">
        <form method="post" action="beheer.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="save">

            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Weergavenaam</label>
                    <input type="text" class="form-control" name="naam" value="{$edit.naam|escape}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Bestandsnaam (slug)</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="base" value="{$edit.base|escape}"
                               {if $edit.base}readonly{/if} placeholder="bijv. mijn-contract" required>
                        <span class="input-group-text text-muted">.json / .rtf</span>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="actief" id="actief" {if $edit.actief}checked{/if}>
                        <label class="form-check-label" for="actief">Actief (zichtbaar op invulpagina)</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">RTF template uploaden {if $edit.base && $edit.has_rtf}<span class="badge bg-success ms-1">RTF aanwezig</span>{else}<span class="badge bg-warning text-dark ms-1">Nog geen RTF</span>{/if}</label>
                <input type="file" class="form-control" name="rtf" accept=".rtf">
                <div class="form-text">Gebruik <code>**veldnaam**</code> als plaatshouder in de RTF. Laat leeg om de huidige te bewaren.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Velden</label>
                <div class="form-text mb-2">
                    Veldnaam (interne key, geen spaties) + label (zichtbaar in het formulier).<br>
                    <i class="bi bi-info-circle text-primary me-1"></i>Een veld met de naam <code>datum</code> (hoofdletterongevoelig) krijgt automatisch een datumkiezer.
                </div>
                <div id="fields-container">
                    {foreach $edit.fields as $key => $label}
                    <div class="field-row">
                        <input type="text" class="form-control form-control-sm font-monospace" name="field_key[]" value="{$key|escape}" placeholder="veldnaam">
                        <input type="text" class="form-control form-control-sm" name="field_label[]" value="{$label|escape}" placeholder="Label">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.field-row').remove()"><i class="bi bi-trash"></i></button>
                    </div>
                    {/foreach}
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="add-field">
                    <i class="bi bi-plus-lg me-1"></i>Veld toevoegen
                </button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Opslaan</button>
                <a href="beheer.php" class="btn btn-outline-secondary">Annuleren</a>
            </div>
        </form>
    </div>
</div>

{else}
{* ── TEMPLATE LIJST ── *}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Naam</th>
                    <th>Bestandsnaam</th>
                    <th>Velden</th>
                    <th>RTF</th>
                    <th>Actief</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            {foreach $templates as $t}
            <tr>
                <td class="fw-semibold">{$t.naam|escape}</td>
                <td><code>{$t.base}</code></td>
                <td><span class="badge bg-secondary">{$t.fields|count}</span></td>
                <td>{if $t.has_rtf}<i class="bi bi-check-circle-fill text-success"></i>{else}<i class="bi bi-x-circle-fill text-danger"></i>{/if}</td>
                <td>{if $t.actief}<i class="bi bi-check-circle-fill text-success"></i>{else}<i class="bi bi-dash text-muted"></i>{/if}</td>
                <td class="text-end">
                    <a href="beheer.php?action=edit&base={$t.base}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <a href="/contract/contract.php?template={$t.base}" class="btn btn-sm btn-outline-secondary" target="_blank"><i class="bi bi-eye"></i></a>
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="if(confirm('Template {$t.naam|escape} verwijderen?')) { document.getElementById('del-{$t.base}').submit(); }">
                        <i class="bi bi-trash"></i>
                    </button>
                    <form id="del-{$t.base}" method="post" action="beheer.php" style="display:none">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="base" value="{$t.base}">
                    </form>
                </td>
            </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>
{/if}
{/block}

{block name="extra_js"}
<script>
document.getElementById('add-field')?.addEventListener('click', function() {
    const row = document.createElement('div');
    row.className = 'field-row';
    row.innerHTML = `
        <input type="text" class="form-control form-control-sm font-monospace" name="field_key[]" placeholder="veldnaam">
        <input type="text" class="form-control form-control-sm" name="field_label[]" placeholder="Label">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.field-row').remove()"><i class="bi bi-trash"></i></button>
    `;
    document.getElementById('fields-container').appendChild(row);
    row.querySelector('input').focus();
});
</script>
{/block}
