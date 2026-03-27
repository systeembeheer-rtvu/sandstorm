<?php
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

$action = $_POST['action'] ?? '';

$scripts = [
    'ics_import' => '/mnt/data/www/rooster/rooster_ics_import.php',
    '365_read'   => '/mnt/data/www/rooster/rooster_365_read.php',
    'sync'       => '/mnt/data/www/rooster/rooster_sync.php',
];

if (!array_key_exists($action, $scripts)) {
    http_response_code(400);
    echo "Onbekende actie";
    exit;
}

// Stream the script output directly to the browser
while (ob_get_level()) ob_end_clean();
header('Content-Type: text/plain; charset=utf-8');
header('X-Accel-Buffering: no');
header('Cache-Control: no-cache');

$cmd  = 'cd ' . escapeshellarg('/mnt/data/www/rooster')
      . ' && /usr/bin/php -f ' . escapeshellarg($scripts[$action])
      . ' 2>&1';

$proc = proc_open($cmd, [0 => ['pipe', 'r'], 1 => ['pipe', 'w']], $pipes);

if (!is_resource($proc)) {
    echo "Kon script niet starten.";
    exit;
}

while (!feof($pipes[1])) {
    $chunk = fread($pipes[1], 512);
    if ($chunk !== false && $chunk !== '') {
        echo $chunk;
        flush();
    }
}

fclose($pipes[1]);
proc_close($proc);
