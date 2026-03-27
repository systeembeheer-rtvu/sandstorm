<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$allowed_models = ['gpt-3.5-turbo', 'gpt-4', 'gpt-4o'];
if (!in_array($input['model'] ?? '', $allowed_models)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid model']);
    exit;
}

$payload = json_encode([
    'model'       => $input['model'],
    'temperature' => (float)($input['temperature'] ?? 1.0),
    'max_tokens'  => (int)($input['max_tokens'] ?? 500),
    'messages'    => $input['messages'] ?? [],
]);

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $OPENAI_API_KEY,
    ],
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($httpcode);
echo $response;
