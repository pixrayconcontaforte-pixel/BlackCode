<?php
// --- Cabeçalhos CORS ---
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

// Pega dados do POST
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['transaction_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'transaction_id é obrigatório']);
    exit;
}

$transactionId = $data['transaction_id'];

// Requisição para a API externa
$ch = curl_init('https://lightpaybr.com/api/verificar/');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['transaction_id' => $transactionId]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic SEU_TOKEN_AQUI' // Coloque seu token aqui
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($httpCode);
echo $response;
