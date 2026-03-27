<?php
/*
  Shared Smarty initializer.
  Usage:
    require_once('/mnt/data/include/smarty.inc.php');
    $smarty = sandstorm_smarty($Auth);
    $smarty->addTemplateDir('/mnt/data/www/myscript/templates/'); // optional extra dir
    $smarty->assign('myvar', $value);
    $smarty->display('mytemplate.tpl');
*/

require_once('/mnt/data/www/vendor/autoload.php');

function sandstorm_smarty($Auth = null, $extraTemplateDir = null) {
    $smarty = new \Smarty\Smarty();
    $smarty->setCompileDir('/mnt/data/www/templates_c/');

    if ($extraTemplateDir) {
        // Module-specific first, shared as fallback (for header.tpl etc.)
        $smarty->setTemplateDir($extraTemplateDir);
        $smarty->addTemplateDir('/mnt/data/www/templates/');
    } else {
        $smarty->setTemplateDir('/mnt/data/www/templates/');
    }

    // Auth info
    $smarty->assign('auth_loggedin',  $Auth ? (bool)$Auth->isLoggedIn  : false);
    $smarty->assign('auth_username',  $Auth ? $Auth->userName           : '');
    $smarty->assign('auth_is_admin',  $Auth ? (bool)$Auth->checkUserRole('Task.Admin') : false);

    return $smarty;
}
