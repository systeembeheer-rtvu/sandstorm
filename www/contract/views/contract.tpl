{extends file="base.tpl"}

{block name="content"}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-earmark-fill me-2"></i>{$contracttemplatenaam|escape}</h2>
    <a href="/contract/" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Terug</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        {$form_html nofilter}
    </div>
</div>
{/block}
