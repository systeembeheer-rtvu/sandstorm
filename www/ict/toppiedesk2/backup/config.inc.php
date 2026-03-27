<?php
    $config = array (
        'DATABASE_SERVER'   => 'mysql',
        'DATABASE_USER'     => 'intranet',
        'DATABASE_PASSWORD' => 'k2ROmx',
        'DATABASE_NAME'     => 'intranet',
    );    
    
    $global_ftp = array (
        'DATABASE_SERVER'   => 'gratiq',
        'DATABASE_USER'     => 'ftpadminintranet',
        'DATABASE_PASSWORD' => 'EVxyEbuywHJNJuan',
        'DATABASE_NAME'     => 'ftpusers',
    );
    
    /*$config = array (
        'DATABASE_SERVER'   => 'homeserver',
        'DATABASE_USER'     => 'rtvutrecht',
        'DATABASE_PASSWORD' => 'maxRQXcAC25aA3Uj',
        'DATABASE_NAME'     => 'rtvu_v1',
    );
    
    $global_ftp = array (
        'DATABASE_SERVER'   => 'homeserver',
        'DATABASE_USER'     => 'rtvutrecht',
        'DATABASE_PASSWORD' => 'maxRQXcAC25aA3Uj',
        'DATABASE_NAME'     => 'gratiq',
    );    */
    
    $page['settings']['locations'] = array(
        'file' => "turbodesk.php",
        'default_site' => array(
            'header' => "headers/header",
            'sidebar' => "sidebars/sidebar2",
            'footer' => "footers/footer",
            'content' => "calloverzicht"
        ), 
        'db_prefix' => "toppie_"
    );    $page['settings']['titles'] = array(
        'header' => "Turbodesk",
        'page' => "Turbodesk"
    );    $page['settings']['datetime'] = "d-m-Y H:i";    $page['settings']['debug'] = array(
        'tracer' => 0,
        'smarty' => 0,
        'vars' => 0,
        'php' => 0
    );?>