<?php
require_once("/mnt/data/include/config.shredder.inc.php");
require_once("/mnt/data/include/mysqlp.inc.php");
$dbh = new sql;
$dbh -> connect();

$date = (string)($_GET['date'] ?? '');

$query = "
	select dalet_id,bericht_id,last_update,website_online,website_offline,website_titel,teletext_titel,teletext_pagina,website_categorie,website_subcategorie,website_outlet,mix_status,rex_rss,errors
	from dalet_berichten
	where website_titel IS NOT NULL AND website_titel != ''
";

if (preg_match('/\A\d{4}-\d\d-\d\d\z/', $date)) {
	$query .= " and website_online like ?";
	$sth = $dbh->do_placeholder_query($query, array($date.'%'), __LINE__, __FILE__);
} else {
	$query .= " and (last_update > DATE_SUB(now(), INTERVAL 7 DAY))";
	$sth = $dbh->do_query($query, __LINE__, __FILE__);
}

$filterLabel = $date ? htmlspecialchars($date) : "laatste 7 dagen";

echo <<<DUMP
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Exchange</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="mix.css?v=<?= filemtime(__DIR__ . '/mix.css') ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="bg-light">
<div class="container-fluid py-3">

    <div class="d-flex align-items-center gap-3 mb-2">
        <h5 class="mb-0">Mini Exchange</h5>
        <a href="?" class="btn btn-sm btn-outline-secondary" onclick="localStorage.removeItem('mix_statusFilter');localStorage.removeItem('mix_outletFilter');">Reset filters</a>
        <div class="dropdown">
            <a class="text-muted text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown">$filterLabel</a>
            <div class="dropdown-menu p-3" style="min-width:280px;">
                <form method="get" action="">
                    <div class="d-flex align-items-center gap-2">
                        <input type="date" name="date" class="form-control form-control-sm" style="width:auto;" value="<?= htmlspecialchars($date) ?>">
                        <button type="submit" class="btn btn-sm btn-primary">OK</button>
                        <a href="?" class="btn btn-sm btn-secondary">Laatste 7 dagen</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="vr"></div>
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="friendlyDates" checked>
            <label class="form-check-label" for="friendlyDates">Vriendelijke datums</label>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3 mb-3">
        <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" id="filterOnlyErrors">
            <label class="form-check-label" for="filterOnlyErrors">Alleen errors</label>
        </div>
        <div class="vr"></div>
        <label class="mb-0 fw-bold">Status:</label>
        <div class="d-flex gap-3">
            <div class="form-check"><input class="form-check-input statusFilter" type="checkbox" value="Gepland" id="filterGepland" checked><label class="form-check-label" for="filterGepland">Gepland</label></div>
            <div class="form-check"><input class="form-check-input statusFilter" type="checkbox" value="Gepubliceerd" id="filterGepubliceerd" checked><label class="form-check-label" for="filterGepubliceerd">Gepubliceerd</label></div>
            <div class="form-check"><input class="form-check-input statusFilter" type="checkbox" value="Draft" id="filterDraft" checked><label class="form-check-label" for="filterDraft">Draft</label></div>
        </div>
        <div class="vr"></div>
        <label class="mb-0 fw-bold">Outlet:</label>
        <div class="d-flex gap-3">
            <div class="form-check"><input class="form-check-input outletFilter" type="checkbox" value="Bingo FM" id="filterBingoFM" checked><label class="form-check-label" for="filterBingoFM">Bingo FM</label></div>
            <div class="form-check"><input class="form-check-input outletFilter" type="checkbox" value="UStad" id="filterUStad" checked><label class="form-check-label" for="filterUStad">UStad</label></div>
            <div class="form-check"><input class="form-check-input outletFilter" type="checkbox" value="RTVUtrecht" id="filterRTVUtrecht" checked><label class="form-check-label" for="filterRTVUtrecht">RTVUtrecht</label></div>
            <div class="form-check"><input class="form-check-input outletFilter" type="checkbox" value="NOS" id="filterNOS" checked><label class="form-check-label" for="filterNOS">NOS</label></div>
            <div class="form-check"><input class="form-check-input outletFilter" type="checkbox" value="NP33" id="filterNP33" checked><label class="form-check-label" for="filterNP33">NP33</label></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-sm mb-0" id="sortTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Last update</th>
                    <th>Online</th>
                    <th>Offline</th>
                    <th>(Sub)Categorie</th>
                    <th>Outlet</th>
                    <th>VP</th>
                    <th>Status</th>
                    <th>RSS</th>
                    <th style="width:1%">Errors</th>
                    <th>Titel</th>
                </tr>
            </thead>
            <tbody>
DUMP;

while (list($dalet_id,
       $bericht_id,
       $last_update,
       $online,
       $offline,
       $website_titel,
       $teletext_titel,
       $teletext_pagina,
       $website_categorie,
       $website_subcategorie,
       $website_outlet,
       $mix_status,
       $rex_rss,
       $errors) = $dbh -> fetch_array($sth)) {

    $cats = array_filter(explode("|", trim($website_categorie ?? "", "|")));
    $categoriebadges = "";
    foreach ($cats as $cat) {
        $categoriebadges .= "<span class='badge bg-secondary me-1 cat-filter' style='cursor:pointer' data-cat='" . htmlspecialchars($cat, ENT_QUOTES) . "'>" . htmlspecialchars($cat) . "</span>";
    }
    foreach (array_filter(explode("|", trim($website_subcategorie ?? "", "|"))) as $sub) {
        if (in_array($sub, $cats) || $sub === 'NOS' || $sub === 'Voorpagina') continue;
        $categoriebadges .= "<span class='badge me-1 cat-filter' style='background:#bbb;color:#fff;font-weight:normal;cursor:pointer' data-cat='" . htmlspecialchars($sub, ENT_QUOTES) . "'>" . htmlspecialchars($sub) . "</span>";
    }
    $website_categorie = $categoriebadges ?: "&nbsp;";
    $subs = array_filter(explode("|", trim($website_subcategorie ?? "", "|")));
    $voorpagina = in_array('Voorpagina', $subs) ? "<span style='color:var(--rtvu-red)'>&#10003;</span>" : "&nbsp;";

    $outletbadges = "";
    foreach (array_filter(explode("|", trim($website_outlet ?? "", "|"))) as $outlet) {
        $outletbadges .= "<span class='badge bg-secondary me-1'>" . htmlspecialchars($outlet) . "</span>";
    }
    $website_outlet = $outletbadges ?: "&nbsp;";

    $errordata = json_decode($errors, true);
    $errorbadges = "";
    foreach ((array)($errordata['technisch'] ?? []) as $e) {
        $errorbadges .= "<span class='badge bg-danger me-1'>$e</span>";
    }
    foreach ((array)($errordata['inhoud'] ?? []) as $e) {
        $errorbadges .= "<span class='badge bg-warning text-dark me-1'>$e</span>";
    }
    $errors = $errorbadges ?: "&nbsp;";

    if ($rex_rss) {
        $rex_rss = "<span style='color:var(--rtvu-red)'>&#10003;</span>";
    } else {
        $rex_rss = "&nbsp;";
    }

    $online  = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1 \2', $online ?? "");
    $offline = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1 \2', $offline ?? "");

    $dalet_id          = htmlspecialchars($dalet_id);
    $bericht_id        = htmlspecialchars($bericht_id);
    $last_update       = htmlspecialchars($last_update);
    $online            = htmlspecialchars($online);
    $offline           = htmlspecialchars($offline);
    $mix_status_labels = ["FUTURE" => "Gepland", "PUBLISH" => "Gepubliceerd", "UNPUBLISH" => "Draft"];
    $mix_status        = htmlspecialchars($mix_status_labels[$mix_status] ?? $mix_status);
    $titel             = htmlspecialchars($website_titel);

    echo <<<DUMP
                <tr>
                    <td>
                        <a href="detail.php?id=$dalet_id">$dalet_id</a><br>
                        <a href="https://nimbus.rtvutrecht.nl/title/$dalet_id" target="_blank" title="Nimbus"><small>N</small></a>
                        <a href="https://www.rtvutrecht.nl/nieuws/$bericht_id" target="_blank" title="Website">&#127760;</a>
                    </td>
                    <td data-original="$last_update">$last_update</td>
                    <td data-original="$online">$online</td>
                    <td data-original="$offline">$offline</td>
                    <td>$website_categorie</td>
                    <td>$website_outlet</td>
                    <td>$voorpagina</td>
                    <td>{$mix_status}</td>
                    <td>{$rex_rss}</td>
                    <td>{$errors}</td>
                    <td>$titel</td>
                </tr>
DUMP;
}

echo <<<DUMP
            </tbody>
            </table>
        </div>
    </div>


</div>
<script>
$(document).ready(function () {
  var dagNamen = ['zondag','maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag'];

  function relativeDate(str) {
    if (!str || !str.trim()) return str;
    var m = str.trim().match(/^(\d{4}-\d{2}-\d{2})\s(\d{2}:\d{2})$/);
    if (!m) return str;
    var today = new Date(); today.setHours(0,0,0,0);
    var d = new Date(m[1]); d.setHours(0,0,0,0);
    var diff = Math.round((d - today) / 86400000);
    var labels = { 2:'Overmorgen', 1:'Morgen', 0:'Vandaag', '-1':'Gisteren', '-2':'Eergisteren' };
    var label = labels[diff] !== undefined ? labels[diff] : (diff > -7 ? dagNamen[d.getDay()] : m[1]);
    return label + ' ' + m[2];
  }

  function timeAgo(str) {
    if (!str || !str.trim()) return str;
    var m = str.trim().match(/^(\d{4}-\d{2}-\d{2})\s(\d{2}:\d{2}(:\d{2})?)$/);
    if (!m) return str;
    var then = new Date(m[1] + 'T' + m[2]);
    var diff = Math.round((new Date() - then) / 1000);
    if (diff < 60)        return diff + ' sec. geleden';
    if (diff < 3600)      return Math.floor(diff / 60) + ' min. geleden';
    if (diff < 86400)     return Math.floor(diff / 3600) + ' uur geleden';
    if (diff < 7 * 86400) return Math.floor(diff / 86400) + ' dagen geleden';
    return m[1];
  }

  function withDayName(str) {
    var m = str.match(/^(\d{4}-\d{2}-\d{2})/);
    if (!m) return str;
    var day = dagNamen[new Date(m[1]).getDay()];
    return day.charAt(0).toUpperCase() + day.slice(1) + ' ' + str;
  }

  function applyDateDisplay(friendly) {
    $('td[data-original]').each(function() {
      var td = $(this);
      var orig = td.attr('data-original');
      var isLastUpdate = td.closest('tr').find('td').index(td) === 1;
      var friendlyVal = isLastUpdate ? timeAgo(orig) : relativeDate(orig);
      var show    = friendly ? friendlyVal : orig;
      var tooltip = friendly ? withDayName(orig) : friendlyVal;
      td.text(show);
      td.attr('title', tooltip).attr('data-bs-toggle', 'tooltip');
      var existing = bootstrap.Tooltip.getInstance(this);
      if (existing) existing.dispose();
      new bootstrap.Tooltip(this);
    });
    localStorage.setItem('mix_friendlyDates', friendly ? '1' : '0');
  }

  var table = $('#sortTable').DataTable({
    "order": [[ 1, "desc" ]],
    "pageLength": 50,
    "drawCallback": function() { applyDateDisplay($('#friendlyDates').is(':checked')); }
  });
  $('.dataTables_length').addClass('bs-select');

  function loadFilters() {
    ['statusFilter', 'outletFilter'].forEach(function(cls) {
      var saved = localStorage.getItem('mix_' + cls);
      if (saved !== null) {
        var vals = JSON.parse(saved);
        $('.' + cls).each(function() {
          $(this).prop('checked', vals.indexOf(this.value) !== -1);
        });
      }
    });
  }

  function applyFilters() {
    var status = $('.statusFilter:checked').map(function() { return '^' + this.value + '$'; }).get();
    table.column(7).search(status.length ? status.join('|') : '^$', true, false);

    var outlets = $('.outletFilter:checked').map(function() { return this.value; }).get();
    table.column(5).search(outlets.length ? outlets.join('|') : '^$', true, false);

    table.draw();
  }

  function saveAndApply(cls) {
    var vals = $('.' + cls + ':checked').map(function() { return this.value; }).get();
    localStorage.setItem('mix_' + cls, JSON.stringify(vals));
    applyFilters();
  }

  loadFilters();
  applyFilters();

  $('.statusFilter').on('change', function() { saveAndApply('statusFilter'); });
  $('.outletFilter').on('change', function() { saveAndApply('outletFilter'); });

  $.fn.dataTable.ext.search.push(function(settings, data) {
    if (!$('#filterOnlyErrors').is(':checked')) return true;
    return data[9].trim().replace(/\u00a0/g, '').length > 0;
  });

  $('#filterOnlyErrors').on('change', function() { table.draw(); });

  var activeCatFilter = null;

  $.fn.dataTable.ext.search.push(function(settings, data) {
    if (!activeCatFilter) return true;
    return data[4].indexOf(activeCatFilter) !== -1;
  });

  $(document).on('click', '.cat-filter', function() {
    var cat = $(this).data('cat');
    if (activeCatFilter === cat) {
      activeCatFilter = null;
      $('.cat-filter').removeClass('cat-filter-active');
    } else {
      activeCatFilter = cat;
      $('.cat-filter').removeClass('cat-filter-active');
      $(".cat-filter[data-cat='" + cat + "']").addClass('cat-filter-active');
    }
    table.draw();
  });


  var savedFriendly = localStorage.getItem('mix_friendlyDates');
  var friendlyOn = savedFriendly === null ? true : savedFriendly === '1';
  $('#friendlyDates').prop('checked', friendlyOn);
  applyDateDisplay(friendlyOn);

  $('#friendlyDates').on('change', function() { applyDateDisplay(this.checked); });
});
</script>
</body>
</html>
DUMP;
?>
