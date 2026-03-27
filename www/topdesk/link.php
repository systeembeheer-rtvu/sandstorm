<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
// header('content-type: application/json; charset=utf-8');

echo "<html><body>";

echo $_SERVER['REQUEST_METHOD'];

  $request_input = file_get_contents('php://input');
var_dump($request_input);


if ($_SERVER['REQUEST_METHOD'] === "POST") {


}

echo "</body></html>";

?>