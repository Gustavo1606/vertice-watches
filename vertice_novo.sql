-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/11/2026 às 03:28
-- Versão do servidor: 10.11.19-MariaDB
-- Versão do PHP: 8.5.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vertice_novo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Masculinos'),
(2, 'Femininos'),
(3, 'Digitais'),
(4, 'Smartwatches');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--



-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_pedido` datetime DEFAULT current_timestamp(),
  `pagamento` varchar(30) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--


-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int(11) NOT NULL DEFAULT 0,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `estoque`, `imagem`, `categoria_id`, `ativo`) VALUES
(1, 'Orient 3 Estrelas', 'Relogio automatico masculino com design classico.', 649.90, 8, 'orient.jpg', 1, 1),
(2, 'Technos Classic', 'Relogio masculino elegante para o dia a dia.', 379.90, 13, 'technos.jpg', 1, 1),
(3, 'Casio MTP-1302', 'Relogio analogico moderno e minimalista.', 299.90, 12, 'casio-mtp.jpg', 1, 1),
(4, 'Seiko 5 Sports', 'Relogio automatico com estilo esportivo.', 1899.90, 8, 'seiko.jpg', 1, 1),
(5, 'Citizen Eco-Drive', 'Relogio com tecnologia de alimentacao por luz.', 1499.90, 5, 'citizen.jpg', 1, 1),
(6, 'Michael Kors Lexington', 'Relogio feminino com design sofisticado.', 1299.90, 8, 'michael-kors.jpg', 2, 1),
(7, 'Casio Vintage LA670', 'Relogio digital feminino com estilo retro.', 249.90, 15, 'casio-la670.jpg', 2, 1),
(8, 'Mondaine Feminino', 'Relogio feminino classico e versatil.', 199.90, 20, 'mondaine.jpg', 2, 1),
(9, 'Technos Mini', 'Relogio feminino compacto e elegante.', 329.90, 12, 'technos-mini.jpg', 2, 1),
(10, 'Anne Klein Diamond Dial', 'Relogio feminino delicado e sofisticado.', 599.90, 8, 'anne-klein.jpg', 2, 1),
(11, 'Casio F-91W', 'Relogio digital classico e leve.', 129.90, 25, 'casio-f91w.jpg', 3, 1),
(12, 'Casio A168', 'Relogio digital com visual vintage.', 249.90, 18, 'casio-a168.jpg', 3, 1),
(13, 'Casio G-Shock DW-5600', 'Relogio digital resistente e esportivo.', 599.90, 10, 'gshock.jpg', 3, 1),
(14, 'Casio AE-1200WH', 'Relogio digital com horario mundial.', 299.90, 14, 'casio-ae1200.jpg', 3, 1),
(15, 'Casio W-800H', 'Relogio digital pratico para o cotidiano.', 189.90, 16, 'casio-w800h.jpg', 3, 1),
(16, 'Apple Watch SE', 'Smartwatch moderno com monitoramento de atividades.', 2199.90, 7, 'apple-watch.jpg', 4, 1),
(17, 'Samsung Galaxy Watch7', 'Smartwatch com recursos inteligentes.', 1799.90, 8, 'galaxy-watch.jpg', 4, 1),
(18, 'Xiaomi Redmi Watch 5', 'Smartwatch com tela ampla e design moderno.', 499.90, 15, 'redmi-watch.jpg', 4, 1),
(19, 'Huawei Watch GT 5', 'Smartwatch elegante com longa duracao de bateria.', 1399.90, 9, 'huawei-watch.jpg', 4, 1),
(20, 'Amazfit Bip 5', 'Smartwatch leve para atividades diarias.', 399.90, 12, 'amazfit.jpg', 4, 1),
(21, 'Relógio Teste', 'Relógio clássico masculino', 249.90, 10, 'orient.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('cliente','admin') DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--



--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
