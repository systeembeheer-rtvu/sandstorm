{extends file="base.tpl"}

{block name="extra_css"}
.card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); transition: transform .15s, box-shadow .15s; }
.card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,.13); }
.card-header { border-radius: 12px 12px 0 0 !important; font-weight: 600; font-size: 1rem; }
.menu-link { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; text-decoration: none; color: #212529; background: #f8f9fa; margin-bottom: 6px; transition: background .12s; font-size: .95rem; }
.menu-link:hover { background: #e2e6ea; color: #000; }
.menu-link i { font-size: 1.15rem; width: 22px; text-align: center; }
{/block}

{block name="content"}
<div class="row g-4">

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header text-white" style="background:#8b0000;"><i class="bi bi-newspaper me-2"></i>Redactie</div>
            <div class="card-body">
                <a class="menu-link" href="/mix/"><i class="bi bi-envelope-open"></i>Mini Exchange</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white"><i class="bi bi-tv me-2"></i>EPG</div>
            <div class="card-body">
                <a class="menu-link" href="/epg/epgarchief.php"><i class="bi bi-archive"></i>EPG Archief</a>
                <a class="menu-link" href="/epg/epgadditorplus.php"><i class="bi bi-pencil-square"></i>EPG Additor Plus</a>
            </div>
        </div>
    </div>

    {if $auth_is_admin}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white"><i class="bi bi-gear me-2"></i>ICT</div>
            <div class="card-body">
                <a class="menu-link" href="/contract/"><i class="bi bi-file-earmark-text"></i>Contracten</a>
                <a class="menu-link" href="/ftp/create_ftp_account.php"><i class="bi bi-hdd-network"></i>FTP Account maken</a>
                <a class="menu-link" href="/parkuser/index.php"><i class="bi bi-person-plus"></i>Parkuser</a>
                <a class="menu-link" href="/rooster/dashboard.php"><i class="bi bi-calendar-week"></i>Roosterscherm</a>
                <a class="menu-link" href="/rooster/rooster_tools.php"><i class="bi bi-tools"></i>Rooster Tools</a>
            </div>
        </div>
    </div>
    {/if}

</div>
{/block}
