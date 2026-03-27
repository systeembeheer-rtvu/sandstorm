<?php
    $page['root'] = "../ict/toppiedesk2/";

    $config = array (
        'DATABASE_SERVER'   => 'db.example.local',
        'DATABASE_USER'     => 'db_user',
        'DATABASE_PASSWORD' => 'db_password',
        'DATABASE_NAME'     => 'db_name',
    );

    $global_ftp = array (
        'DATABASE_SERVER'   => 'ftp-db.example.local',
        'DATABASE_USER'     => 'ftp_db_user',
        'DATABASE_PASSWORD' => 'ftp_db_password',
        'DATABASE_NAME'     => 'ftpusers',
    );

    $page['settings']['locations'] = array(
        'root' => "website/itsm/",
        'file' => "index.php",
        'default_site' => array(
            'header' => "headers/header",
            'sidebar' => "sidebars/sidebar",
            'footer' => "footers/footer",
            'content' => "home"
        ),
        'db_prefix' => "toppie_"
    );

    $page['settings']['titles'] = array(
        'header' => "Servicedesk",
        'page' => "Servicedesk"
    );

    $page['settings']['datetime'] = "d-m-Y H:i";

    $page['settings']['debug'] = array(
        'tracer' => 0,
        'smarty' => 0,
        'vars' => 0,
        'php' => 0
    );
?>
