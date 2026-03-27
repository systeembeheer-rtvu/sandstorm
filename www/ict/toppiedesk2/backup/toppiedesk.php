<?php
	date_default_timezone_set('Europe/Belgrade');

	$page['root'] = "./";

	require_once("config.inc.php");
	require_once("libs/smarty/Smarty.class.php");
	require_once("libs/mysql.inc.php");
	require_once("libs/phpmailer/class.phpmailer.php");
	require_once("scripts/functions/datahandler.inc.php");
	require_once("scripts/functions/functions.inc.php");
	require_once("scripts/functions/links.inc.php");
	require_once("scripts/functions/sanitizer.inc.php");
	require_once("scripts/functions/security.inc.php");
	require_once("scripts/functions/setbehandelaar.inc.php");
	
	
	$tracer = "***Begin tracing***<br /><br/>";
	
	$page['classes']['smarty'] = new Smarty();
	$page['classes']['smarty']->template_dir = 'templates/default';
	$page['classes']['smarty']->compile_dir = 'templates/compile';
	
	$page['classes']['sql'] = new sql();
	$page['classes']['sql']->connect();
	
	$page['classes']['behandelaar'] = new Behandelaar();
	$page['classes']['behandelaar'] ->check();
	
	$page['classes']['sanitizer'] = new Sanitizer();
	
	//classe voor de links die op de site zichtbaar zijn.
	//wordt verder gebruikt in de DataHandler.
	$page['classes']['links'] = new Links();
	
	$page['classes']['phpmailer'] = new PHPMailer();
	
	//De DataHandler handelt de input en output van de website af.
	//Ook zit er een security check in verwerkt.
	$page['classes']['datahandler'] = new DataHandler($_GET['id']);
	$page['classes']['security'] = new Security();
	$page['classes']['datahandler']->DataInput();
	$page['classes']['datahandler']->Run();
	$page['classes']['datahandler']->DataOutput();
	
	if(isset($page['settings']['debug']['vars']) && $page['settings']['debug']['vars'] == 1)
	{
		echo "Post<br />";
		print_r($_POST);
		echo "<br /><br />";
		echo "Get<br />";
		print_r($_GET);
		echo "<br /><br />";
		echo "Server<br />";
		print_r($_SERVER);
		echo "<br /><br />";
		echo 'Cookie<br />';
		print_r($_COOKIE);
		echo "<br /><br />";
		echo '$input<br />';
		print_r($input);
		echo "<br /><br />";
		echo '$page<br />';
		print_r($page);
		echo "<br /><br />";
		echo '$output<br />';
		print_r($output);
	}
	
	if(isset($page['settings']['debug']['php']) && $page['settings']['debug']['php'] == 1)
	{
		error_reporting(E_ALL);
		ini_set("display_errors", true);
	}
	else
	{
		error_reporting(E_ALL & ~E_DEPRECATED);
		ini_set("display_errors", false);
	}
	
	if(isset($page['settings']['debug']['smarty']) && $page['settings']['debug']['smarty'] == 1)
	{
		$page['classes']['smarty']->debugging = true;
	}
	
	$page['classes']['datahandler']->Show();
?>