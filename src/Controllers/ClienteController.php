<?php

namespace App\Controllers;

use App\Database\Connection;
use PDO;

class ClienteController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function index(): void
    {
        $stmt = $this->db->query("SELECT id, corporate_name, `address` FROM c_client ORDER BY id DESC");
        $clientes = $stmt->fetchAll();

        $this->sendJson($clientes, 200);
    }

    public function show(int $id): void
    {
        $stmt = $this->db->prepare("SELECT id, corporate_name, `address` FROM c_client WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $cliente = $stmt->fetch();

        if (!$cliente) {
            $this->sendJson(['error' => 'Cliente não encontrado.'], 404);
            return;
        }

        $this->sendJson($cliente, 200);
    }

    public function store(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nome']) || empty($data['email'])) {
            $this->sendJson(['error' => 'Campos "nome" e "email" são obrigatórios.'], 422);
            return;
        }

        $stmt = $this->db->prepare("INSERT INTO c_client (nome, email) VALUES (:nome, :email)");
        $stmt->execute([
            'nome'  => filter_var($data['nome'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ]);

        $id = $this->db->lastInsertId();
        $this->sendJson(['message' => 'Cliente criado com sucesso.', 'id' => $id], 201);
    }

    private function sendJson(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}