<?php

namespace App\Controllers;

use App\Database\Connection;
use PDO;

class ClienteController
{
    /**
     * Conexão com o banco de dados.
     *
     * @var PDO
     */
    private PDO $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    /**
     * Lista todos os clientes cadastrados.
     *
     * Os clientes são ordenados pelo nome em ordem alfabética.
     *
     * @return void
     */
    public function index(): void
    {
        $stmt = $this->db->query("SELECT `id`, `nome`, `email`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf` FROM `clientes` ORDER BY `nome` ASC");
        $clientes = $stmt->fetchAll();

        $this->sendJson($clientes, 200);
    }

    /**
     * Exibe os dados de um cliente específico.
     *
     * @param int $id ID do cliente.
     *
     * @return void
     */
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

    /**
     * Cadastra um novo cliente.
     *
     * Os dados são recebidos através do corpo da requisição em formato JSON.
     * Após a validação, o cliente é inserido no banco de dados.
     *
     * @return void
     */
    public function store(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!is_array($data)) {
            http_response_code(400);
            
            $this->sendJson([
                'success' => false,
                'message' => 'O corpo da requisição deve conter um JSON válido.',
            ], 422);
        }

        $this->validateDataBody($data);

        try {
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
        } catch (\PDOException $e) {
            $this->sendJson(['message' => 'Erro ao criar o cliente.'], 500);
        }
    }

    /**
     * Atualiza os dados de um cliente existente.
     *
     * Os dados são recebidos através do corpo da requisição em formato JSON.
     * É realizada uma validação. O cliente deve existir antes que a atualização seja realizada.
     *
     * @param int $id ID do cliente que será atualizado.
     *
     * @return void
     */
    public function update(int $id): void
    {
        $this->validateClient($id);

        $data = json_decode(file_get_contents('php://input'), true);

        if (!is_array($data)) {
            http_response_code(400);
            
            $this->sendJson([
                'success' => false,
                'message' => 'O corpo da requisição deve conter um JSON válido.',
            ], 422);
        }
        
        $this->validateDataBody($data);
        
        try {
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

        } catch (\PDOException $e) {
            $this->sendJson(['message' => 'Erro ao atualizar o cliente.'], 500);
        }
    }

    /**
     * Exclui um cliente pelo ID.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->validateClient($id);

        try {
            $stmt = $this->db->prepare(
                "DELETE FROM `clientes`
                WHERE `id` = :id"
            );

            $stmt->execute([
                ':id' => $id
            ]);

            $this->sendJson(['message' => 'Cliente excluído com sucesso.'], 200);

        } catch (\PDOException $e) {
            $this->sendJson(['message' => 'Erro ao excluir o cliente.'], 500);
        }
    }

    /**
     * Envia uma resposta HTTP no formato JSON.
     *
     * Define o código HTTP e o Content-Type da resposta antes
     * de serializar os dados para JSON.
     *
     * @param mixed $data Dados que serão retornados na resposta.
     * @param int $statusCode Código HTTP da resposta.
     *
     * @return void
     */
    private function sendJson(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Valida os dados obrigatórios recebidos no corpo da requisição.
     *
     * Verifica se os campos obrigatórios estão presentes e não estão vazios.
     * Caso existam erros de validação, retorna uma resposta HTTP 422.
     *
     * @param array $data Dados recebidos na requisição.
     *
     * @return void
     */
    private function validateDataBody(array $data): void
    {
        $requiredFields = ['nome', 'email', 'cep', 'logradouro', 'numero', 'bairro', 'cidade', 'uf'];

        $erros = [];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
                $erros[$field] = "O campo {$field} é obrigatório e não pode estar vazio.";
            }
        }

        if (!empty($erros)) {
            $this->sendJson([
                'message' => 'Dados inválidos.',
                'errors' => $erros
            ], 422);
        }
    }

    /**
     * Verifica se um cliente existe no banco de dados.
     *
     * Caso o cliente não seja encontrado, retorna uma resposta HTTP 404.
     *
     * @param int $clientId ID do cliente que será verificado.
     *
     * @return void
     */
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