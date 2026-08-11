# API de Clientes

Projeto desenvolvido em PHP que disponibiliza uma API REST para gerenciamento de clientes, permitindo operações de consulta, cadastro, atualização e exclusão.

## Visão geral

* API REST desenvolvida em PHP
* Roteamento básico em `public/index.php`
* Controller principal em `src/Controllers/ClienteController.php`
* Conexão com MySQL em `src/Database/Connection.php`
* Armazenamento de informação através do PDO
* Autoloading PSR-4 configurado em `composer.json`
* Script de criação do banco disponível em `database/dump.sql`

## Tecnologias

* PHP 8.1+
* MySQL
* PDO
* Composer
* Apache / Nginx / XAMPP
* REST API
* JSON

## Requisitos

Para executar o projeto localmente, é necessário ter instalado:

* PHP 8.1 ou superior com extensão PDO MySQL
* Composer
* MySQL
* Servidor web, como Apache ou Nginx
* XAMPP, caso queira utilizar o ambiente local com Apache/MySQL

## Instalação

1. Clone ou copie o projeto para a pasta desejada.

2. Instale as dependências:

```bash
composer install
```

3. Configure o banco de dados utilizando o script:

```text
database/dump.sql
```

4. Configure os dados de conexão com o banco em:

```text
src/Database/Connection.php
```

5. Configure o servidor web para apontar para a pasta:

```text
public/
```

como documento raiz.

## Configuração do banco de dados

O projeto disponibiliza o script de criação da estrutura do banco em:

```text
database/dump.sql
```

O script cria o banco de dados e a tabela necessária para o funcionamento da API.

Para configurar o banco:

1. Abra o MySQL ou phpMyAdmin.
2. Execute o conteúdo de `database/dump.sql`.
3. Verifique as credenciais utilizadas pela aplicação.
4. Configure a conexão em `src/Database/Connection.php`.

### Segurança

As credenciais utilizadas no ambiente de produção não são disponibilizadas neste repositório.

Em um ambiente de produção, recomenda-se utilizar variáveis de ambiente ou outro mecanismo seguro para armazenamento das credenciais.

## Estrutura principal

```text
api_clientes/
├── database/
│   └── dump.sql
├── public/
│   └── index.php
├── src/
│   ├── Controllers/
│   │   └── ClienteController.php
│   └── Database/
│       └── Connection.php
├── composer.json
└── README.md
```

## Endpoints

### Listar clientes

**Método:** `GET`

**URL:**

```text
/api/clientes
```

Retorna todos os clientes cadastrados.

---

### Obter cliente por ID

**Método:** `GET`

**URL:**

```text
/api/clientes/{id}
```

Retorna os dados do cliente informado.

Caso o cliente não exista, a API retorna erro `404`.

---

### Criar cliente

**Método:** `POST`

**URL:**

```text
/api/clientes
```

**Content-Type:**

```text
application/json
```

**Body:**

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

### Campos

Campos obrigatórios:

* `nome`
* `email`
* `cep`
* `logradouro`
* `numero`
* `bairro`
* `cidade`
* `uf`

Campo opcional:

* `complemento`

A API realiza a validação dos campos antes de inserir os dados no banco.

---

### Atualizar cliente

**Método:** `PUT`

**URL:**

```text
/api/clientes/{id}
```

Recebe os dados do cliente em formato JSON e atualiza o registro correspondente ao ID informado.

---

### Excluir cliente

**Método:** `DELETE`

**URL:**

```text
/api/clientes/{id}
```

Exclui o cliente correspondente ao ID informado.

## Respostas

As respostas da API são disponibilizadas em formato JSON.

Em caso de sucesso, a API retorna uma mensagem indicando a operação realizada e, quando aplicável, o ID do registro.

Em caso de erro, a API retorna uma resposta JSON com informações sobre o problema e o respectivo código HTTP.

## CORS

A API está configurada atualmente com CORS aberto (`*`) para permitir o consumo pelo frontend durante o desenvolvimento e demonstração do projeto.

Em um ambiente de produção, recomenda-se restringir os domínios autorizados.

## Como rodar localmente com XAMPP

### 1. Copiar o projeto

Copie a API para:

```text
C:\xampp\htdocs\api_clientes
```

### 2. Iniciar o XAMPP

Inicie:

* Apache
* MySQL

### 3. Configurar o PHP

Caso necessário, adicione o PHP do XAMPP ao `PATH` do PowerShell:

```powershell
$env:PATH = "C:\xampp\php;" + $env:PATH
```

### 4. Iniciar a API

Dentro da pasta do projeto:

```powershell
php -S localhost:8000 -t public
```

Com o servidor iniciado, a API estará disponível em:

```text
http://localhost:8000/
```

### 5. Testar os endpoints

Os endpoints podem ser testados utilizando ferramentas como:

* Postman
* Insomnia
* navegador, para requisições `GET`
* frontend React da aplicação

## Frontend

O projeto possui um frontend desenvolvido em React para consumo da API.

A aplicação permite:

* listar clientes;
* cadastrar clientes;
* editar clientes;
* excluir clientes;
* consultar dados de endereço através do CEP.

## Deploy

O frontend pode ser executado em ambiente de hospedagem como Vercel.

A API pode ser hospedada em um servidor compatível com PHP e MySQL.

As URLs utilizadas no ambiente de produção devem ser configuradas no frontend conforme o ambiente de execução.

## Melhorias futuras

Algumas melhorias que podem ser implementadas:

* utilização de variáveis de ambiente para todas as configurações;
* autenticação utilizando Bearer Token/JWT;
* implementação de testes automatizados;
* validações mais robustas;
* documentação OpenAPI/Swagger;
* tratamento de logs;
* implementação de paginação na listagem de clientes;
* restrição de CORS para os domínios autorizados;
* criação de migrations para controle de evolução do banco.

## Autor

**Andreney Laranjeira**