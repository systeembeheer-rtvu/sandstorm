<?php

$url = 'https://rocky.park.rtvutrecht.nl/api/temps';

$who = $_GET['wie'] ?? "";
if ($who=='hansie') $data = '5770709';
if ($who=='gesloten') $data = '6074771';
if ($who=='jurriaan') $data = '5770653';


$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json;charset=UTF-8',
        'Accept: application/json, text/plain, */*',
    ],
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);
?>