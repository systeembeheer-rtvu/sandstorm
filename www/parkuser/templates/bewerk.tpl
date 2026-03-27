{extends file="base.tpl"}

{block name="extra_css"}
.form-label { font-weight: 500; }
.hint { font-size: .82rem; color: #6c757d; }
.card-section { border: none; border-radius: 10px; box-shadow: 0 1px 6px rgba(0,0,0,.07); margin-bottom: 1.25rem; }
{/block}

{block name="content"}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="bi bi-person-gear me-2"></i>
        {if $is_edit}
            {$voornaam|escape} {$tussenvoegsel|escape} {$achternaam|escape}
        {elseif $type == 'dist'}
            Nieuwe distributielijst
        {elseif $type == 'contact'}
            Nieuw contact
        {else}
            Nieuwe user
        {/if}
    </h2>
    <a href="index.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Terug</a>
</div>

{if $message}
<div class="alert alert-{$message_type|default:'info'} d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-{if $message_type == 'success'}check-circle{elseif $message_type == 'warning'}exclamation-triangle{else}info-circle{/if}-fill"></i>
    {$message}
</div>
{/if}

{if $alias_conflict}
<div class="alert alert-danger mb-4">
    <i class="bi bi-exclamation-octagon-fill me-2"></i>
    <strong>Alias bestaat mogelijk al!</strong> Controleer in AD/disk of deze alias al in gebruik is.
    Zo ja: andere alias kiezen. Zo nee: status op goedgekeurd zetten.
</div>
{/if}

<form method="post" action="bewerk.php">
<input type="hidden" name="edit" value="1">
<input type="hidden" name="id" value="{$id}">

<div class="row g-4">
    <div class="col-lg-7">

        <!-- Naam -->
        <div class="card card-section">
            <div class="card-header bg-light fw-semibold"><i class="bi bi-person me-2"></i>Persoonsgegevens</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{if $type == 'dist'}Naam distributielijst{else}Voornaam{/if}</label>
                    <input type="text" class="form-control" name="voornaam" value="{$voornaam|escape}">
                </div>
                {if $type != 'dist'}
                <div class="mb-3">
                    <label class="form-label">Tussenvoegsel</label>
                    <input type="text" class="form-control" name="tussenvoegsel" value="{$tussenvoegsel|escape}">
                    <div class="hint">Volledig uitschrijven — "van der", "van den" etc. hoeft niet afgekort.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Achternaam</label>
                    <input type="text" class="form-control" name="achternaam" value="{$achternaam|escape}">
                </div>
                {/if}
                {if $type == 'user'}
                <div class="mb-3">
                    <label class="form-label">Mobiel nummer</label>
                    <input type="text" class="form-control {if $mobile_invalid}is-invalid{/if}" name="mobilephone" value="{$mobilephone|escape}">
                    {if $mobile_invalid}
                    <div class="invalid-feedback">Mobiel nummer niet correct. Gebruik +31 6XXXXXXXX. Geen normale gebruiker? Gebruik +31 611111111.</div>
                    {/if}
                </div>
                {/if}
            </div>
        </div>

        <!-- Account -->
        <div class="card card-section">
            <div class="card-header bg-light fw-semibold"><i class="bi bi-envelope me-2"></i>Account</div>
            <div class="card-body">
                {if $is_edit || $type != 'user'}
                <div class="mb-3">
                    <label class="form-label">E-mailadres</label>
                    <input type="text" class="form-control" name="emailadres" value="{$emailadres|escape}">
                    {if $type == 'user'}
                    <div class="hint">
                        Altijd een RTV Utrecht adres. Bingo FM medewerkers krijgen achteraf een bingofm.nl alias.<br>
                        Reclame: voornaam@rtvutrecht.nl — overige medewerkers: voornaam.tussenvoegsel.achternaam@rtvutrecht.nl
                    </div>
                    {/if}
                </div>
                {/if}
                {if $type == 'user'}
                <div class="mb-3">
                    <label class="form-label">Alias (inlognaam)</label>
                    <input type="text" class="form-control {if $alias_conflict}is-invalid{/if}" name="alias" value="{$alias|escape}">
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dalet" value="1" id="dalet" {if $dalet}checked{/if}>
                        <label class="form-check-label" for="dalet">Dalet toegang</label>
                        <div class="hint">Voegt user toe aan PG Dalet Client Verslaggeving</div>
                    </div>
                </div>
                {/if}
            </div>
        </div>

    </div>
    <div class="col-lg-5">

        <!-- Status -->
        {if $is_edit}
        <div class="card card-section">
            <div class="card-header bg-light fw-semibold"><i class="bi bi-flag me-2"></i>Status</div>
            <div class="card-body">
                <div class="mb-2">
                    {if $status == 0}
                        <span class="badge bg-danger mb-2">Nog niet goedgekeurd</span>
                    {elseif $status == 8}
                        <span class="badge bg-success mb-2">Done</span>
                    {else}
                        <span class="badge bg-warning text-dark mb-2">Processing</span>
                    {/if}
                </div>
                <select name="status" class="form-select">
                    {foreach $statuses as $sid => $stext}
                    <option value="{$sid}" {if $sid == $status}selected{/if}>{$stext|escape}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        {/if}

        <!-- Groep -->
        <div class="card card-section">
            <div class="card-header bg-light fw-semibold"><i class="bi bi-diagram-3 me-2"></i>{if $type == 'user'}Template groep{else}Actie{/if}</div>
            <div class="card-body" style="max-height:220px;overflow-y:auto;">
                {foreach $groepen as $g}
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="groups" value="{$g|escape}" id="grp_{$g|escape}" {if $g == $groups}checked{/if}>
                    <label class="form-check-label" for="grp_{$g|escape}">{$g|escape}</label>
                </div>
                {/foreach}
            </div>
        </div>

        <!-- Meta -->
        <div class="card card-section">
            <div class="card-header bg-light fw-semibold"><i class="bi bi-info-circle me-2"></i>Overig</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Aangevraagd door</label>
                    <input type="text" class="form-control" name="aangevraagddoor" value="{$aangevraagddoor|escape}">
                </div>
                <div class="mb-3">
                    <label class="form-label">TOPdesk call</label>
                    <input type="text" class="form-control" name="topdeskcall" value="{$topdeskcall|escape}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Aanmaken op <span class="hint ms-1">(vandaag: {$today})</span></label>
                    <input type="date" class="form-control" name="aanmakenop" value="{$aanmakenop|escape}">
                </div>
            </div>
        </div>

    </div>
</div>

<div class="d-flex gap-3 align-items-center mt-2">
    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-floppy me-1"></i>
        {if $is_edit}Opslaan{else}Opslaan en e-mailadres + alias genereren{/if}
    </button>
    {if $is_edit}
    <a href="generate.php?id={$id}" class="btn btn-outline-secondary">
        <i class="bi bi-magic me-1"></i>Genereer e-mailadres &amp; alias
    </a>
    <span class="hint">Eerst opslaan vóór genereren!</span>
    {/if}
</div>

</form>
{/block}
