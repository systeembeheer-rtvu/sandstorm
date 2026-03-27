<?php
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) {
    echo "Computer says no!";
    exit;
}

include("/mnt/data/include/formr/class.formr.php");
$form = new Formr\Formr('bootstrap4');

$prefill = $_GET['prefill'] ?? '';
if ($prefill) {
    $prefilldata = json_decode(file_get_contents("/mnt/data/www/contract/contracten/$prefill.json"), true);
    $_POST    = $prefilldata;
    $_REQUEST = $prefilldata;
    $prefilled = 1;
} else {
    $prefilled = 0;
}

$template = $_REQUEST['template'] ?? '';
if (!$template) {
    echo "Geen template!";
    exit;
}

$data                 = json_decode(file_get_contents("/mnt/data/www/contract/templates/$template.json"), true);
$contracttemplate     = $data['template'];
$contracttemplatenaam = $data['naam'];
$vandaag              = date("Y-m-d");

// Capture Formr output
ob_start();
$form->open();
foreach ($data['fields'] as $key => $value) {
    if (strtoupper($key) == "DATUM") {
        $form->date($key, $value, $vandaag);
    } else {
        $form->text($key, $value);
    }
    $form->hidden("template", $template);
}
$form->submit_button("Maak contract");

if ($form->submitted() || $prefilled) {
    $search = $replace = [];
    foreach ($data['fields'] as $key => $value) {
        $search[] = "**$key**";
        $repl = $_POST[$key];
        if (strtoupper($key) == "DATUM") {
            $repl = preg_replace('/(\d{4})-(\d\d)-(\d\d)/i', '\3-\2-\1', $repl);
        }
        $replace[] = $repl;
    }
    $file = str_ireplace($search, $replace, file_get_contents("/mnt/data/www/contract/templates/$contracttemplate"));
    $filename = md5(serialize($_POST));
    file_put_contents("/mnt/data/www/contract/contracten/$filename.rtf", $file);
    file_put_contents("/mnt/data/www/contract/contracten/$filename.json", json_encode($_REQUEST, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));

    $url = "https://sandstorm.park.rtvutrecht.nl/contract/contracten/$filename";
    $form->success_message = "Download <a href='$url.rtf'>hier</a> het contract!<br><br><a href='contract.php?prefill=$filename'>Link</a> om dit contract te delen";
    echo $form->messages();
}
$form_html = ob_get_clean();

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/contract/views/');
$smarty->assign('page_title', $contracttemplatenaam);
$smarty->assign('contracttemplatenaam', $contracttemplatenaam);
$smarty->assign('form_html', $form_html);
$smarty->display('contract.tpl');
