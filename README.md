# API de Clientes

Projeto básico em PHP que disponibiliza uma API REST para a gestão de clientes.

## Visão geral

- Roteamento básico em `public/index.php`
- Controller principal em `src/Controllers/ClienteController.php`
- Conexão com MySQL em `src/Database/Connection.php`
- Autoloading PSR-4 configurado em `composer.json`

## Requisitos

- PHP 8.1+ com PDO MySQL
- Composer
- Servidor web (Apache, Nginx, XAMPP, etc.)
- Banco de dados MySQL

## Instalação

1. Clone ou copie o projeto para a pasta desejada.
2. Execute `composer install` para carregar o autoload.
3. Configure o servidor web para apontar para a pasta `public/` como documento raiz.

## Configuração do banco de dados

A conexão está definida em `src/Database/Connection.php`:

- host: `76.13.88.7`
- database: `u220373856_db_clientes`
- usuário: `u220373856_clientes`
- senha: `F^r$214LFb05!`
- charset: `utf8mb4`

> Recomenda-se mover essas credenciais para variáveis de ambiente ou arquivo de configuração seguro em produção.

## Endpoints

### Listar clientes

- Método: `GET`
- URL: `/api/clientes`
- Retorna: JSON com todos os clientes

### Obter cliente por ID

- Método: `GET`
- URL: `/api/clientes/{id}`
- Retorna: JSON com os dados do cliente ou erro 404

### Criar cliente

- Método: `POST`
- URL: `/api/clientes`
- Body: JSON com os campos `nome`, `email`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade` e `uf`
- Retorna: JSON com mensagem de sucesso e `id`

Exemplo de body:

```json
{
  "nome": "Carlos Eduardo da Silva",
  "email": "carlos.silva@email.com",
  "cep": "80010-010",
  "logradouro": "Rua XV de Novembro",
  "numero": "450",
  "complemento": "Apto 32",
  "bairro": "Centro",
  "cidade": "Curitiba",
  "uf": "PR"
}
```

## Observações

- O projeto usa CORS aberto (`*`) e headers JSON globais.
- Campos obrigatórios para criação são `nome`, `email`, `cep`, `numero`, `complemento`, `bairro`, `cidade` e `uf`.
- Campo não obrigatório `logradouro`
- O controller verifica todos campos obrigatórios antes de inserir no banco.
- Se a rota não for reconhecida, retorna `404` em JSON.

## Como rodar localmente com XAMPP

1. Copie a pasta para `C:\xampp\htdocs\api_clientes`
2. Inicie Apache e MySQL no painel do XAMPP
3. Altere a variável de ambiente PATH para o XAMPP `$env:PATH = "C:\xampp\php;" + $env:PATH`
4. Inicie o servidor: `php -S localhost:8000 -t public`
5. Com o servidor iniciado a base url para teste será: `http://localhost:8000/`

## Melhorias sugeridas

- separar configuração de ambiente e credenciais sensíveis
- melhorar a estrutura adicionando mais camadas
- implementar validações mais robustas
- adicionar testes automatizados
