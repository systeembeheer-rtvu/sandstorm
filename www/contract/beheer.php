<?php
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) {
    echo "Computer says no!";
    exit;
}

$action   = $_POST['action'] ?? $_GET['action'] ?? null;
$base     = $_POST['base']   ?? $_GET['base']   ?? null;
$tplDir   = '/mnt/data/www/contract/templates/';
$message  = null;
$msgType  = 'success';

// ── Opslaan / aanmaken ────────────────────────────────────────────────────────
if ($action === 'save' && $base) {
    $base = preg_replace('/[^a-z0-9\-]/', '', strtolower($base));
    if (!$base) {
        $message = 'Bestandsnaam (slug) is verplicht en mag alleen letters, cijfers en koppeltekens bevatten.';
        $msgType = 'danger';
        $action  = null;
    }
}
if ($action === 'save' && $base) {

    // RTF upload
    if (!empty($_FILES['rtf']['tmp_name'])) {
        move_uploaded_file($_FILES['rtf']['tmp_name'], $tplDir . $base . '.rtf');
    }

    // Velden opbouwen
    $fields = [];
    $keys   = $_POST['field_key']   ?? [];
    $labels = $_POST['field_label'] ?? [];
    foreach ($keys as $i => $k) {
        $k = trim($k);
        $l = trim($labels[$i] ?? '');
        if ($k !== '') $fields[$k] = $l;
    }

    $json = [
        'template' => $base . '.rtf',
        'naam'     => trim($_POST['naam']),
        'actief'   => isset($_POST['actief']),
        'fields'   => $fields,
    ];
    file_put_contents($tplDir . $base . '.json', json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $message = 'Template opgeslagen.';
    $base = null; // terug naar lijst
}

// ── Verwijderen ───────────────────────────────────────────────────────────────
if ($action === 'delete' && $base) {
    $base = preg_replace('/[^a-z0-9\-]/', '', strtolower($base));
    @unlink($tplDir . $base . '.json');
    @unlink($tplDir . $base . '.rtf');
    $message = 'Template verwijderd.';
    $base = null;
}

// ── Templates laden ───────────────────────────────────────────────────────────
$templates = [];
foreach (scandir($tplDir, SCANDIR_SORT_ASCENDING) as $f) {
    if (pathinfo($f, PATHINFO_EXTENSION) !== 'json') continue;
    $data = json_decode(file_get_contents($tplDir . $f), true);
    $data['base'] = pathinfo($f, PATHINFO_FILENAME);
    $data['has_rtf'] = file_exists($tplDir . $data['base'] . '.rtf');
    $templates[] = $data;
}

// ── Edit: bestaande template laden ────────────────────────────────────────────
$edit = null;
if ($base && $action === 'edit') {
    $base = preg_replace('/[^a-z0-9\-]/', '', strtolower($base));
    if (file_exists($tplDir . $base . '.json')) {
        $edit = json_decode(file_get_contents($tplDir . $base . '.json'), true);
        $edit['base'] = $base;
    }
}
if ($action === 'new') {
    $edit = ['base' => '', 'naam' => '', 'actief' => true, 'fields' => []];
}

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/contract/views/');
$smarty->assign('page_title', 'Contractbeheer');
$smarty->assign('templates', $templates);
$smarty->assign('edit', $edit);
$smarty->assign('message', $message);
$smarty->assign('msg_type', $msgType);
$smarty->display('beheer.tpl');
