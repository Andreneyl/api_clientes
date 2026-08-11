-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11/08/2026 às 16:51
-- Versão do servidor: 11.8.8-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u220373856_db_clientes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(191) NOT NULL,
  `cep` char(8) NOT NULL,
  `logradouro` varchar(120) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(80) NOT NULL,
  `cidade` varchar(80) NOT NULL,
  `uf` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf`) VALUES
(1, 'João da Silva', 'joao.silva@email.com', '80010000', 'Rua XV de Novembro', '123', NULL, 'Centro', 'Curitiba', 'PR'),
(2, 'Maria Oliveira', 'maria.oliveira@email.com', '80020000', 'Rua Marechal Deodoro', '456', 'Apto 12', 'Centro', 'Curitiba', 'PR'),
(3, 'Carlos Eduardo Santos', 'carlos.santos@email.com', '80030000', 'Rua Emiliano Perneta', '789', NULL, 'Centro', 'Curitiba', 'PR'),
(4, 'Ana Paula Santos', 'ana.souza@email.com', '80035260', 'Rua Abílio Peixoto', '801', 'Casa 2', 'Cabral', 'Curitiba', 'PR'),
(6, 'Juliana Martins', 'juliana.martins@email.com', '80060000', 'Rua Brigadeiro Franco', '987', 'Apto 304', 'Centro', 'Curitiba', 'PR'),
(7, 'Rafael Pereira', 'rafael.pereira@email.com', '80070000', 'Rua Desembargador Westphalen', '147', NULL, 'Rebouças', 'Curitiba', 'PR'),
(8, 'Camila Rodrigues', 'camila.rodrigues@email.com', '80080000', 'Rua Chile', '258', 'Apto 501', 'Rebouças', 'Curitiba', 'PR'),
(9, 'Lucas Ferreira', 'lucas.ferreira@email.com', '80210000', 'Rua Itupava', '369', NULL, 'Alto da Glória', 'Curitiba', 'PR'),
(10, 'Beatriz Costa', 'beatriz.costa@email.com', '80220000', 'Rua Augusto Stresser', '741', 'Fundos', 'Alto da Glória', 'Curitiba', 'PR'),
(11, 'Gustavo Mendes', 'gustavo.mendes@email.com', '80230000', 'Rua João Gualberto', '852', NULL, 'Juvevê', 'Curitiba', 'PR'),
(12, 'Larissa Almeida', 'larissa.almeida@email.com', '80240000', 'Rua Rocha Pombo', '963', 'Apto 203', 'Juvevê', 'Curitiba', 'PR'),
(13, 'Bruno Carvalho', 'bruno.carvalho@email.com', '80300000', 'Rua Francisco Derosso', '159', NULL, 'Xaxim', 'Curitiba', 'PR'),
(14, 'Mariana Lima', 'mariana.lima@email.com', '80310000', 'Rua Coronel Dulcídio', '357', 'Casa', 'Água Verde', 'Curitiba', 'PR'),
(16, 'Patrícia Gomes', 'patricia.gomes@email.com', '80330000', 'Rua Petit Carneiro', '579', NULL, 'Água Verde', 'Curitiba', 'PR'),
(17, 'André Barbosa', 'andre.barbosa@email.com', '80400000', 'Rua Padre Anchieta', '681', 'Apto 402', 'Bigorrilho', 'Curitiba', 'PR'),
(18, 'Renata Moreira', 'renata.moreira@email.com', '80410000', 'Rua Martim Afonso', '792', NULL, 'São Francisco', 'Curitiba', 'PR'),
(19, 'Lucas Gabriel Matos', 'lucas.oliveira@email.com', '80530-00', 'Avenida Cândido de Abreu', '535', 'Conjunto 604', 'Centro Cívico', 'Curitiba', 'PR'),
(20, 'Isabela Teixeira', 'isabela.teixeira@email.com', '80520000', 'Rua Conselheiro Laurindo', '924', NULL, 'Centro', 'Curitiba', 'PR'),
(21, 'Lucas Gabriel Santos', 'lucas.oliveira@email.com', '80530-00', 'Avenida Cândido de Abreu', '535', 'Conjunto 604', 'Centro Cívico', 'Curitiba', 'PR'),
(22, 'Mariana Souza Oliveira', 'mariana.oliveira@email.com', '80030-00', 'Avenida João Gualberto', '1280', 'Conjunto 504', 'Alto da Glória', 'Curitiba', 'PR');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
