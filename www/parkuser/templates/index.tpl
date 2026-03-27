{extends file="base.tpl"}

{block name="extra_css"}
.status-badge { font-size: .8rem; }
.table-hover tbody tr:hover { background: #f1f3f5; }
{/block}

{block name="content"}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Parkuser</h2>
    <div class="d-flex gap-2">
        <a href="bewerk.php?new=user"    class="btn btn-primary"><i class="bi bi-person-plus me-1"></i>Nieuwe user</a>
        <a href="bewerk.php?new=contact" class="btn btn-outline-secondary"><i class="bi bi-person-rolodex me-1"></i>Nieuw contact</a>
        <a href="bewerk.php?new=dist"    class="btn btn-outline-secondary"><i class="bi bi-people me-1"></i>Nieuwe distributielijst</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table id="parkuser-table" class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Naam</th>
                    <th>E-mailadres</th>
                    <th>Aanvrager</th>
                    <th>Groep</th>
                    <th>Dalet</th>
                    <th>Status</th>
                    <th>Alias</th>
                    <th>Aanmaken op</th>
                    <th>Laatste aanpassing</th>
                </tr>
            </thead>
            <tbody>
            {foreach $users as $u}
                <tr>
                    <td><a href="bewerk.php?id={$u.id}" class="text-decoration-none fw-semibold">{$u.naam|escape}</a></td>
                    <td>{$u.emailadres|escape}</td>
                    <td>{$u.aanvrager|escape}</td>
                    <td>{$u.groups|escape}</td>
                    <td>{if $u.dalet}<i class="bi bi-check-circle-fill text-success"></i>{else}<i class="bi bi-dash text-muted"></i>{/if}</td>
                    <td>
                        {if $u.status == 0}
                            <span class="badge bg-danger status-badge">{$statuses[$u.status]|default:'Onbekend'}</span>
                        {elseif $u.status == 8}
                            <span class="badge bg-success status-badge">{$statuses[$u.status]|default:'Onbekend'}</span>
                        {else}
                            <span class="badge bg-warning text-dark status-badge">{$statuses[$u.status]|default:'Onbekend'}</span>
                        {/if}
                    </td>
                    <td><code>{$u.alias|escape}</code></td>
                    <td>{$u.aanmakenop}</td>
                    <td>{$u.lastchange}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>
{/block}

{block name="extra_js"}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(function() {
    $('#parkuser-table').DataTable({
        order: [[5, 'asc'], [7, 'desc']],
        pageLength: 25,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/nl-NL.json' }
    });
});
</script>
{/block}
