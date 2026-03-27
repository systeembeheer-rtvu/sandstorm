{extends file="base.tpl"}

{block name="extra_css"}
.template-card { border: none; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.07); transition: transform .15s, box-shadow .15s; text-decoration: none; color: inherit; display: block; }
.template-card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.12); color: inherit; }
{/block}

{block name="content"}
<div class="mb-4">
    <h2><i class="bi bi-file-earmark-text me-2"></i>Contracten</h2>
    <p class="text-muted">Kies een template om in te vullen.</p>
</div>

<div class="row g-3">
{foreach $templates as $t}
    {if $t.actief}
    <div class="col-md-4">
        <a href="/contract/contract.php?template={$t.base|escape:'url'}" class="template-card card p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-file-earmark-richtext fs-2" style="color:var(--ss-red)"></i>
                <span class="fw-semibold">{$t.naam|escape}</span>
            </div>
        </a>
    </div>
    {/if}
{/foreach}
</div>
{/block}
