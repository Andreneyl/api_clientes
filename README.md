# API de Clientes

Projeto simples em PHP que expõe uma API REST para gerenciar clientes.

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

- host: `upmobb.tech`
- database: `app_upmobb`
- usuário: `app_user`
- senha: `Application2027!`

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
- Body: JSON com campos `nome` e `email`
- Retorna: JSON com mensagem de sucesso e `id`

Exemplo de body:

```json
{
  "nome": "João Silva",
  "email": "joao@exemplo.com"
}
```

## Observações

- O projeto usa CORS aberto (`*`) e headers JSON globais.
- Campos obrigatórios para criação são `nome` e `email`.
- O controller filtra `nome` e valida `email` antes de inserir no banco.
- Se a rota não for reconhecida, retorna `404` em JSON.

## Como rodar localmente com XAMPP

1. Copie a pasta para `C:\xampp\htdocs\api_clientes`
2. Inicie Apache e MySQL no painel do XAMPP
3. Altere a variável de ambiente PATH para o XAMPP `$env:PATH = "C:\xampp\php;" + $env:PATH`
4. Inicie o servidor: `php -S localhost:8000 -t public`

## Melhorias sugeridas

- separar configuração de ambiente e credenciais sensíveis
- adicionar endpoints de atualização e exclusão
- implementar validações mais robustas
- adicionar testes automatizados
