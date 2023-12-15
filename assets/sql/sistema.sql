-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Dez-2023 às 15:11
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema`
--
CREATE DATABASE IF NOT EXISTS `sistema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistema`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `data_agendamento` datetime DEFAULT NULL,
  `tipo_procedimento` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `finalizar` tinyint(1) DEFAULT NULL,
  `valor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `cliente_id`, `data_agendamento`, `tipo_procedimento`, `observacoes`, `status`, `finalizar`, `valor`) VALUES
(41, 15, '2023-12-13 13:45:00', 'teste', 'oi', 'confirmado', 1, '100'),
(44, 15, '2023-12-14 09:22:00', 'teste', 'oi', 'recusado', 1, '40'),
(47, 15, '2023-12-19 10:05:00', 'teste', 'oioio', NULL, NULL, '20'),
(48, 15, '2023-12-14 10:17:00', 'teste', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'confirmado', 1, '100'),
(49, 16, '2023-12-14 10:35:00', 'teste', 'oioio', 'recusado', 1, '100'),
(50, 15, '2023-12-14 10:58:00', 'teste', 'oio', 'confirmado', 1, '88'),
(51, 16, '2023-12-22 10:59:00', '8', '9', NULL, NULL, '8'),
(52, 15, '2023-12-14 12:58:00', '8', '8', 'confirmado', 1, '8'),
(53, 15, '2023-12-14 13:59:00', '8', '8', 'confirmado', 1, '8'),
(54, 15, '2023-12-14 14:02:00', '8', '8', 'confirmado', 1, '8'),
(55, 15, '2023-12-14 01:59:00', '8', '8', 'confirmado', 1, '8'),
(56, 16, '2023-12-14 11:12:00', 'teste', 'o', 'confirmado', 1, 'o'),
(57, 16, '2023-12-14 06:00:00', '99', '99', 'confirmado', 1, '99'),
(58, 16, '2023-12-14 14:05:00', '9', '9', 'confirmado', 1, '9'),
(59, 16, '2023-12-14 00:04:00', '9', '9', 'confirmado', NULL, '9'),
(60, 15, '2023-12-14 11:22:00', '9', '9', 'confirmado', 1, '9'),
(61, 15, '2023-12-14 15:05:00', '99', '99', 'confirmado', 1, '999');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastro_user`
--

CREATE TABLE `cadastro_user` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `whatsapp` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cadastro_user`
--

INSERT INTO `cadastro_user` (`id`, `nome`, `email`, `senha`, `whatsapp`, `is_admin`) VALUES
(1, 'root', 'root', '$2y$10$eft7PTKsxMEiuzR26kes.e7NqeYDaeS0uL1uzZtEdX.R9RP2w8s/m', '88888888', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(100) NOT NULL,
  `cpf` text DEFAULT NULL,
  `genero` varchar(10) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco_rua` varchar(255) DEFAULT NULL,
  `endereco_cidade` varchar(100) DEFAULT NULL,
  `endereco_estado` varchar(50) DEFAULT NULL,
  `endereco_cep` varchar(15) DEFAULT NULL,
  `historico_medico` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome_completo`, `cpf`, `genero`, `telefone`, `email`, `endereco_rua`, `endereco_cidade`, `endereco_estado`, `endereco_cep`, `historico_medico`) VALUES
(15, 'GABRIEL DE OLIVEIRA', '053.049.853-70', NULL, '(88) 99996-3774', NULL, 'LADEIRA SÃO JOSE N 7', 'Crato', 'CE', '63113-574', NULL),
(16, 'ANDREIA', '999.999.999-99', NULL, '(99) 99999-9999', NULL, 'TEST 123', 'Granjeiro', 'CE', '63230-000', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `galeria`
--

CREATE TABLE `galeria` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` text DEFAULT NULL,
  `data_imagem` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `galeria`
--

INSERT INTO `galeria` (`id`, `usuario_id`, `descricao`, `imagem`, `data_imagem`) VALUES
(16, NULL, 'oi', '../../assets/galeria/Captura de tela 2023-04-05 134137.png', NULL),
(17, NULL, 'oi', '../../assets/galeria/Captura de tela 2023-04-04 092045.png', NULL),
(18, NULL, 'oi', '../../assets/galeria/Captura de tela 2023-04-12 083306.png', NULL),
(20, NULL, 'testandoo', '../../assets/galeria/Captura de tela 2023-04-20 144156.png', NULL),
(21, NULL, 'oi', '../../assets/galeria/Captura de tela 2023-04-05 134137.png', NULL),
(22, NULL, 'oi', '../../assets/galeria/Captura de tela 2023-04-05 134137.png', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Índices para tabela `cadastro_user`
--
ALTER TABLE `cadastro_user`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de tabela `cadastro_user`
--
ALTER TABLE `cadastro_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `galeria`
--
ALTER TABLE `galeria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Limitadores para a tabela `galeria`
--
ALTER TABLE `galeria`
  ADD CONSTRAINT `galeria_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
