-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 30/08/2023 às 14:59
-- Versão do servidor: 8.0.33
-- Versão do PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `test_drive`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `token`
--

CREATE TABLE `token` (
  `id` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `tempo` datetime DEFAULT ((now() + interval 5 minute))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `token`
--

INSERT INTO `token` (`id`, `id_user`, `token`, `tempo`) VALUES
(32, 31, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbC5jb20iLCJhdWQiOiJsb2NhbC5jb20iLCJpYXQiOjE2OTM0MDc0OTEsImV4cCI6MTY5MzQxMTA5MSwiZGF0YSI6eyJ1c2VySWQiOjMxLCJ1c2VybmFtZSI6ImZhdXN0aW5vcHN5In19.7vufyv_rSLDR7ncKMgTMtbBjCHADCjnppUfseSBjm2Q', '2023-08-30 12:03:11'),
(33, 31, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbC5jb20iLCJhdWQiOiJsb2NhbC5jb20iLCJpYXQiOjE2OTM0MDc1MzQsImV4cCI6MTY5MzQxMTEzNCwiZGF0YSI6eyJ1c2VySWQiOjMxLCJ1c2VybmFtZSI6ImZhdXN0aW5vcHN5In19.EyiqnzJNBr1yb0HHCn1g9sxV5PPd7H4PZPGzFNnxJGQ', '2023-08-30 12:03:54');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `token` text,
  `tempo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `senha`, `token`, `tempo`) VALUES
(31, 'faustinopsy', NULL, '$2y$10$Q32pFbtZVo6DxA5osKfh1.nNxL/Bdl/jX2GSvHvWrK7TJouou2ooy', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbC5jb20iLCJhdWQiOiJsb2NhbC5jb20iLCJpYXQiOjE2OTM0MDUyOTQsImV4cCI6MTY5MzQwODg5NCwiZGF0YSI6eyJ1c2VySWQiOjMxLCJ1c2VybmFtZSI6ImZhdXN0aW5vcHN5In19._TFQlvrJlL2pJMTCoecFx1YFh90Y0zTiK-QtkmvquJ4', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser_idx` (`id_user`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `token`
--
ALTER TABLE `token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `iduser` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `update_tokens` ON SCHEDULE EVERY 3 MINUTE STARTS '2023-08-30 11:36:07' ON COMPLETION PRESERVE ENABLE DO DELETE from token WHERE tempo <= NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
