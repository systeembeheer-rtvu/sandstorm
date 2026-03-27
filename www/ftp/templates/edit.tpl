{extends file="base.tpl"}

{block name="content"}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-person-gear me-2"></i>FTP gebruiker: <code>{$user|escape}</code></h2>
    <a href="ftpusers_list.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Terug</a>
</div>

{if $saved}
<div class="alert alert-success mb-4"><i class="bi bi-check-circle me-2"></i>Wijzigingen opgeslagen.</div>
{/if}
{if $errors}
<div class="alert alert-danger mb-4"><ul class="mb-0">{foreach $errors as $e}<li>{$e|escape}</li>{/foreach}</ul></div>
{/if}

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header fw-semibold bg-light">Gegevens bewerken</div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="csrf" value="{$csrf|escape}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="Enabled" name="Enabled" {if $row.Enabled}checked{/if}>
                                <label class="form-check-label" for="Enabled">Actief</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="KanVerlopen" name="KanVerlopen" {if $row.KanVerlopen}checked{/if}>
                                <label class="form-check-label" for="KanVerlopen">Kan verlopen</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Verloopdatum</label>
                            <input type="date" name="Verloopdatum" class="form-control"
                                   value="{if $row.Verloopdatum && $row.Verloopdatum != '0000-00-00'}{$row.Verloopdatum|escape}{/if}">
                            <div class="form-text">Leeg = geen verloop.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Aangevraagd door</label>
                            <input type="text" name="AangevraagdDoor" class="form-control" value="{$row.AangevraagdDoor|escape}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Omschrijving</label>
                        <textarea name="Comment" class="form-control" rows="3">{$row.Comment|escape}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nieuw wachtwoord</label>
                        <input type="password" name="PasswordClear" class="form-control">
                        <div class="form-text">Laat leeg om het huidige wachtwoord te behouden.</div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i>Opslaan</button>
                </form>

                <hr>
                <form method="post" onsubmit="return confirm('Gebruiker {$user|escape:'javascript'} markeren voor verwijdering?')">
                    <input type="hidden" name="csrf" value="{$csrf|escape}">
                    <input type="hidden" name="action_delete" value="1">
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Markeren voor verwijdering</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header fw-semibold bg-light">Overige informatie</div>
            <div class="card-body">
                <dl class="row mb-0">
                    {foreach $readonly as $label => $value}
                    <dt class="col-sm-4 text-muted">{$label}</dt>
                    <dd class="col-sm-8">{$value|escape|default:'—'}</dd>
                    {/foreach}
                </dl>
            </div>
        </div>
    </div>
</div>
{/block}
