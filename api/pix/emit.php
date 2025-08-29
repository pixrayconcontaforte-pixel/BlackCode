<?php
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['amount'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Parâmetro amount é obrigatório']);
    exit;
}

$valor = intval($data['amount'] * 100);

$payload = [
    "nome" => "Joao Dos Testes da Silva",
    "cpf" => "00000000000",
    "celular" => "11999999999",
    "email" => "joao@email.com",
    "valor" => $valor,
    "rua" => "Rua Teste",
    "numero" => "123",
    "cep" => "12345678",
    "bairro" => "Centro",
    "cidade" => "São Paulo",
    "estado" => "SP"
];

// Executa o cURL
$ch = curl_init("https://lightpaybr.com/api/v2/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic Y2xpZW50XzY4YTVlMzZlMDQ0NmI6NmVjNDNlYzczNTQ4OTUwZDkxMTk5ZGQxMzIyMzY4MmI=",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Retorna o JSON para o frontend
if ($httpCode >= 200 && $httpCode < 300) {
    $json = json_decode($response, true);
    echo json_encode(['success' => true, 'data' => $json]);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao gerar PIX', 'response' => $response]);
}
