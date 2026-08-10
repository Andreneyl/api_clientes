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
        $stmt = $this->db->query("SELECT `id`, `nome`, `email`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf` FROM `clientes` ORDER BY `nome` ASC");
        $clientes = $stmt->fetchAll();

        $this->sendJson($clientes, 200);
    }

    public function show(int $id): void
    {
        $this->validateClient($id);
        
        $stmt = $this->db->prepare("SELECT `id`, `nome`, `email`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf` FROM `clientes` WHERE id = :id");
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

        $this->validateDataBody($data);

        $sql = "
            INSERT INTO `clientes`
                (`nome`, `email`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf`)
            VALUES
                (:nome, :email, :cep, :logradouro, :numero, :complemento, :bairro, :cidade, :uf)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nome'        => trim($data['nome']),
            'email'       => trim($data['email']),
            'cep'         => trim($data['cep']),
            'logradouro'  => trim($data['logradouro']),
            'numero'      => trim($data['numero']),
            'complemento' => !empty($data['complemento'])
                ? trim($data['complemento'])
                : null,
            'bairro'      => trim($data['bairro']),
            'cidade'      => trim($data['cidade']),
            'uf'          => strtoupper(trim($data['uf']))
        ]);

        $id = $this->db->lastInsertId();
        $this->sendJson(['message' => 'Cliente criado com sucesso.', 'id' => $id], 201);
    }

    public function update(int $id): void
    {
        $this->validateClient($id);

        $data = json_decode(file_get_contents('php://input'), true);
        
        $this->validateDataBody($data);

        $sql = "
            UPDATE `clientes`
                SET `nome` = :nome, `email` = :email, `cep` = :cep, `logradouro` = :logradouro, `numero` = :numero
                , `complemento` = :complemento, `bairro` = :bairro, `cidade` = :cidade, `uf` = :uf
            WHERE
                `id` = :id ";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'id' => $id,
                'nome' => trim($data['nome']),
                'email' => trim($data['email']),
                'cep' => trim($data['cep']),
                'logradouro' => trim($data['logradouro']),
                'numero' => trim($data['numero']),
                'complemento' => isset($data['complemento']) ? trim((string) $data['complemento']) : null,
                'bairro' => trim($data['bairro']),
                'cidade' => trim($data['cidade']),
                'uf' => strtoupper(trim($data['uf']))
            ]);
            
            $this->sendJson([ 'id' => $id, 'message' => 'Cliente atualizado com sucesso.'], 200);
    }

    private function sendJson(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    private function validateDataBody(array $data): void
    {
        $requiredFields = ['nome', 'email', 'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'uf'];

        $erros = [];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
                $erros[$field] = "O campo {$field} é obrigatório e não pode estar vazio.";
            }
        }

        $this->sendJson([
            'message' => 'Dados inválidos.',
            'errors' => $erros
        ], 422);
    }

    private function validateClient(int $clientId): void
    {
        $stmt = $this->db->prepare( "SELECT `id` FROM `clientes` WHERE `id` = :id" );

        $stmt->execute(['id' => $clientId]);

        if (!$stmt->fetch()) {
            $this->sendJson([ 'message' => 'Cliente não encontrado.' ], 404);
            return;
        }
    }
}