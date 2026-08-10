<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Headers globais de CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Roteamento via REGEX simples
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

use App\Controllers\ClienteController;

$controller = new ClienteController();

if ($uri === '/api/clientes' && $method === 'GET') {
    $controller->index();
} elseif ($uri === '/api/clientes' && $method === 'POST') {
    $controller->store();
} elseif (preg_match('/^\/api\/clientes\/(\d+)$/', $uri, $matches) && $method === 'GET') {
    $controller->show((int)$matches[1]);
} elseif (preg_match('/^\/api\/clientes\/(\d+)$/', $uri, $matches) && $method === 'PUT') {
    $controller->update((int) $matches[1]);
}else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Rota não encontrada.']);
}