{extends file="base.tpl"}

{block name="content"}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-hdd-network me-2"></i>FTP Gebruikers</h2>
    <a href="create_ftp_account.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Nieuw account</a>
</div>

{if $flash}
<div class="alert alert-{$flash_type} mb-4"><i class="bi bi-info-circle me-2"></i>{$flash|escape}</div>
{/if}

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table id="ftpTable" class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Gebruiker</th>
                    <th>Actief</th>
                    <th>Kan verlopen</th>
                    <th>Verloopdatum</th>
                    <th>Laatste login</th>
                    <th>Omschrijving</th>
                </tr>
            </thead>
            <tbody>
            {foreach $rows as $row}
                <tr style="cursor:pointer" onclick="location.href='ftpusers_edit.php?User={$row.User|escape:'url'}'">
                    <td class="fw-semibold">{$row.User|escape}</td>
                    <td>{if $row.Enabled}<i class="bi bi-check-circle-fill text-success"></i>{else}<i class="bi bi-x-circle-fill text-danger"></i>{/if}</td>
                    <td>{if $row.KanVerlopen}<i class="bi bi-check-circle-fill text-success"></i>{else}<i class="bi bi-dash text-muted"></i>{/if}</td>
                    <td>{if $row.Verloopdatum && $row.Verloopdatum != '0000-00-00'}{$row.Verloopdatum}{else}<span class="text-muted">—</span>{/if}</td>
                    <td>{$row.LastLogin|escape|default:'—'}</td>
                    <td>{$row.Comment|escape}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>
{/block}

{block name="extra_js"}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function() {
    $('#ftpTable').DataTable({
        order: [[0, 'asc']],
        pageLength: 25,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/nl-NL.json' }
    });
});
</script>
{/block}
