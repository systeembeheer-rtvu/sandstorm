{extends file="base.tpl"}

{block name="content"}
<h2 class="mb-4"><i class="bi bi-tools me-2"></i>Rooster Tools</h2>

<div class="row g-4">

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header fw-semibold bg-light"><i class="bi bi-file-earmark-arrow-down me-2"></i>ICS Import</div>
            <div class="card-body d-flex flex-column gap-3">
                <p class="text-muted small mb-0">Downloadt en importeert alle ICS-kalenderbestanden naar de database (volledig bereik).</p>
                <button class="btn btn-primary btn-run" data-action="ics_import">
                    <i class="bi bi-download me-1"></i>Importeer ICS
                </button>
                <div class="output-area d-none">
                    <div class="output-content bg-dark text-light p-3 rounded small"
                         style="max-height:400px;overflow-y:auto;font-family:monospace;white-space:pre-wrap;word-break:break-word"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header fw-semibold bg-light"><i class="bi bi-cloud-download me-2"></i>O365 Read</div>
            <div class="card-body d-flex flex-column gap-3">
                <p class="text-muted small mb-0">Leest kalendergebeurtenissen uit O365-mailboxen en slaat ze op als cache.</p>
                <button class="btn btn-primary btn-run" data-action="365_read">
                    <i class="bi bi-cloud-download me-1"></i>Lees O365
                </button>
                <div class="output-area d-none">
                    <div class="output-content bg-dark text-light p-3 rounded small"
                         style="max-height:400px;overflow-y:auto;font-family:monospace;white-space:pre-wrap;word-break:break-word"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header fw-semibold bg-light"><i class="bi bi-arrow-repeat me-2"></i>Sync</div>
            <div class="card-body d-flex flex-column gap-3">
                <p class="text-muted small mb-0">Vergelijkt ICS-events met O365 en synchroniseert wijzigingen.</p>
                <button class="btn btn-primary btn-run" data-action="sync">
                    <i class="bi bi-arrow-repeat me-1"></i>Synchroniseer
                </button>
                <div class="output-area d-none">
                    <div class="output-content bg-dark text-light p-3 rounded small"
                         style="max-height:400px;overflow-y:auto;font-family:monospace;white-space:pre-wrap;word-break:break-word"></div>
                </div>
            </div>
        </div>
    </div>

</div>
{/block}

{block name="extra_js"}
<script>
document.querySelectorAll('.btn-run').forEach(function(btn) {
    var originalHtml = btn.innerHTML;

    btn.addEventListener('click', async function() {
        var action        = btn.dataset.action;
        var cardBody      = btn.closest('.card-body');
        var outputArea    = cardBody.querySelector('.output-area');
        var outputContent = cardBody.querySelector('.output-content');

        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Bezig\u2026';
        outputArea.classList.remove('d-none');
        outputContent.textContent = '';

        var body = new FormData();
        body.append('action', action);

        try {
            const response = await fetch('rooster_tools_run.php', { method: 'POST', body });
            const reader   = response.body.getReader();
            const decoder  = new TextDecoder();

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                outputContent.textContent += decoder.decode(value, { stream: true });
                outputContent.scrollTop = outputContent.scrollHeight;
            }
        } catch (err) {
            outputContent.textContent = 'Verbindingsfout: ' + err;
        } finally {
            btn.disabled  = false;
            btn.innerHTML = originalHtml;
        }
    });
});
</script>
{/block}
