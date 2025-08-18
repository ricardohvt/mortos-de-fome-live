-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/08/2025 às 21:23
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `code`
--

CREATE TABLE `code` (
  `codeID` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `code` varchar(6) NOT NULL,
  `email` varchar(120) NOT NULL,
  `lido` tinyint(1) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `code`
--

INSERT INTO `code` (`codeID`, `username`, `code`, `email`, `lido`, `userID`) VALUES
(1, 'a', '602109', 'a@a.com', 0, 4),
(3, 'admin.main', '925351', 'admin@admin.com', 0, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `pessoaID` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`pessoaID`, `full_name`) VALUES
(4, 'a'),
(5, 'ba'),
(6, 'ricardo.admin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `post`
--

CREATE TABLE `post` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `nome_post` tinytext NOT NULL,
  `descricao_post` text NOT NULL,
  `criado_em` date NOT NULL DEFAULT current_timestamp(),
  `categoria_post` tinyint(4) NOT NULL COMMENT '0 - Padrao / 1 - Vegetariano / 2 - Vegano / 3 - 0gluten / 4 - 0lactose / 5 - fitness',
  `autorizado` tinyint(4) NOT NULL COMMENT '0 - Não autorizado / 1 - Autorizado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `post_images`
--

CREATE TABLE `post_images` (
  `post_imagesID` int(11) NOT NULL,
  `PostID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `email` varchar(130) NOT NULL,
  `password_main` varchar(60) NOT NULL,
  `pessoaID` int(11) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`userID`, `username`, `email`, `password_main`, `pessoaID`, `isAdmin`) VALUES
(4, 'a', 'a@a.com', '$2y$10$8qfeBju6NWxUlyjRFNNLIurpqKrKGhPmqLwzV8HVfv73nOR9.Zk.G', 4, 1),
(6, 'admin.main', 'admin@admin.com', '$2y$10$UuEr5N2LZpHsuI5.B6cwzOw4i4KqOCMcdbWQvhj2KIj0P5iGmBz7u', 6, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`codeID`),
  ADD KEY `userID` (`userID`);

--
-- Índices de tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`pessoaID`);

--
-- Índices de tabela `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `userID` (`userID`) USING BTREE;

--
-- Índices de tabela `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`post_imagesID`),
  ADD KEY `PostID` (`PostID`) USING BTREE;

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `pessoaID` (`pessoaID`) USING BTREE;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `code`
--
ALTER TABLE `code`
  MODIFY `codeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `pessoaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `post_images`
--
ALTER TABLE `post_images`
  MODIFY `post_imagesID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `code`
--
ALTER TABLE `code`
  ADD CONSTRAINT `code_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Restrições para tabelas `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`PostID`) REFERENCES `post` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`pessoaID`) REFERENCES `pessoa` (`pessoaID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
