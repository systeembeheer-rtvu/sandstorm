{extends file="base.tpl"}

{block name="content"}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-hdd-network me-2"></i>FTP Account aanmaken</h2>
    <a href="ftpusers_list.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-list-ul me-1"></i>Alle FTP gebruikers</a>
</div>

{if $message}
<div class="alert alert-{$msg_type} mb-4">{$message nofilter}</div>
{/if}

<div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Gebruikersnaam</label>
                <input type="text" class="form-control" name="username" value="{$username|escape}"
                       required pattern="[a-zA-Z0-9]+" title="Alleen letters en cijfers">
                <div class="form-text">Alleen letters en cijfers, geen spaties.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Omschrijving <span class="text-muted fw-normal">(optioneel)</span></label>
                <textarea class="form-control" name="comment" rows="3">{$comment|escape}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Aangevraagd door / Ticket</label>
                <input type="text" class="form-control" name="requested_by" value="{$requested_by|escape}" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Account aanmaken</button>
        </form>
    </div>
</div>
{/block}
