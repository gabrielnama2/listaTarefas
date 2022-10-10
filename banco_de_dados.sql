-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Out-2022 às 05:58
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_tarefas`
--
CREATE SCHEMA `sistema_tarefas` ;

--
-- Estrutura da tabela `tarefa`
--

USE sistema_tarefas;

CREATE TABLE `tarefa` (
  `id` int(11) NOT NULL,
  `ordem` int(11) DEFAULT NULL,
  `nome` varchar(45) NOT NULL,
  `custo` double NOT NULL,
  `prazo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Acionadores `tarefa`
--
DELIMITER $$
CREATE TRIGGER `InsertIncrementOrderTrigger` BEFORE INSERT ON `tarefa` FOR EACH ROW BEGIN
    SET NEW.ordem = (SELECT IF(MAX(ordem) + 1, MAX(ordem) + 1, 1) as t FROM tarefa WHERE 1);
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tarefa`
--
ALTER TABLE `tarefa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tarefa`
--
ALTER TABLE `tarefa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

--
-- Extraindo dados da tabela `tarefa`
--

INSERT INTO `tarefa` (`id`, `ordem`, `nome`, `custo`, `prazo`) VALUES
(1, 1, 'Alterar design para Editar', 100, '2022-10-10'),
(2, 2, 'Mudar a cor dos botões', 50, '2022-10-10'),
(3, 3, 'Atualizar o BD', 150, '2022-10-05'),
(4, 4, 'Depurar o código', 200, '2022-10-04');