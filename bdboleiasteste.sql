-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14-Dez-2025 às 23:19
-- Versão do servidor: 9.1.0
-- versão do PHP: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdboleiasteste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1765745837);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('acederAvaliacao', 2, 'Aceder ás avaliacoes', NULL, NULL, 1765745837, 1765745837),
('acederBackend', 2, 'Aceder ao backend', NULL, NULL, 1765745837, 1765745837),
('acederBoleia', 2, 'Aceder ás boleias', NULL, NULL, 1765745837, 1765745837),
('acederDocumento', 2, 'Aceder aos documentos', NULL, NULL, 1765745837, 1765745837),
('acederEstatistica', 2, 'Aceder ás estatisticas', NULL, NULL, 1765745837, 1765745837),
('acederFavorito', 2, 'Aceder aos destinos favoritos', NULL, NULL, 1765745837, 1765745837),
('acederFrontend', 2, 'Aceder ao frontend', NULL, NULL, 1765745837, 1765745837),
('acederPerfil', 2, 'Aceder aos perfis', NULL, NULL, 1765745837, 1765745837),
('acederReserva', 2, 'Aceder ás reservas', NULL, NULL, 1765745837, 1765745837),
('acederViatura', 2, 'Aceder ás viaturas', NULL, NULL, 1765745837, 1765745837),
('adicionarFavorito', 2, 'Adicionar um destino favorito', NULL, NULL, 1765745837, 1765745837),
('admin', 1, NULL, NULL, NULL, 1765745837, 1765745837),
('cancelarReserva', 2, 'Cancelar uma Reserva', NULL, NULL, 1765745837, 1765745837),
('condutor', 1, NULL, NULL, NULL, 1765745837, 1765745837),
('criarAdmin', 2, 'Criar um  perfil de Administrador', NULL, NULL, 1765745837, 1765745837),
('criarAvaliacao', 2, 'Criar uma Avaliacao', NULL, NULL, 1765745837, 1765745837),
('criarBoleia', 2, 'Criar uma Boleia', NULL, NULL, 1765745837, 1765745837),
('criarCondutor', 2, 'Criar um  perfil de Condutor', NULL, NULL, 1765745837, 1765745837),
('criarDocumento', 2, 'Criar um Documento', NULL, NULL, 1765745837, 1765745837),
('criarEstatistica', 2, 'Criar uma estatistica', NULL, NULL, 1765745837, 1765745837),
('criarPassageiro', 2, 'Criar um  perfil de Passageiro', NULL, NULL, 1765745837, 1765745837),
('criarReserva', 2, 'Criar uma Reserva', NULL, NULL, 1765745837, 1765745837),
('criarViatura', 2, 'Criar uma Viatura', NULL, NULL, 1765745837, 1765745837),
('editarAdmin', 2, 'Editar um perfil de Administrador', NULL, NULL, 1765745837, 1765745837),
('editarAvaliacao', 2, 'Editar uma Avaliacao', NULL, NULL, 1765745837, 1765745837),
('editarBoleia', 2, 'Editar uma Boleia', NULL, NULL, 1765745837, 1765745837),
('editarCondutor', 2, 'Editar um perfil de Condutor', NULL, NULL, 1765745837, 1765745837),
('editarDocumento', 2, 'Editar um Documento', NULL, NULL, 1765745837, 1765745837),
('editarPassageiro', 2, 'Editar um  perfil de Passageiro', NULL, NULL, 1765745837, 1765745837),
('editarViatura', 2, 'Editar uma Viatura', NULL, NULL, 1765745837, 1765745837),
('eliminarAdmin', 2, 'Eliminar um perfil de Administrador', NULL, NULL, 1765745837, 1765745837),
('eliminarAvaliacao', 2, 'Eliminar uma Avaliacao', NULL, NULL, 1765745837, 1765745837),
('eliminarBoleia', 2, 'Eliminar uma Boleia', NULL, NULL, 1765745837, 1765745837),
('eliminarCondutor', 2, 'Eliminar um perfil de Condutor', NULL, NULL, 1765745837, 1765745837),
('eliminarDocumento', 2, 'Eliminar um Documento', NULL, NULL, 1765745837, 1765745837),
('eliminarEstatistica', 2, 'Eliminar uma estatistica', NULL, NULL, 1765745837, 1765745837),
('eliminarPassageiro', 2, 'Eliminar um  perfil de Passageiro', NULL, NULL, 1765745837, 1765745837),
('eliminarViatura', 2, 'Eliminar uma Viatura', NULL, NULL, 1765745837, 1765745837),
('passageiro', 1, NULL, NULL, NULL, 1765745837, 1765745837),
('removerFavorito', 2, 'Remover um destino favorito', NULL, NULL, 1765745837, 1765745837),
('updateEstatistica', 2, 'Dar update a uma estatistica', NULL, NULL, 1765745837, 1765745837),
('verMinhasReservas', 2, 'Ver as minhas Reservas', NULL, NULL, 1765745837, 1765745837);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('passageiro', 'acederAvaliacao'),
('admin', 'acederBackend'),
('admin', 'acederBoleia'),
('condutor', 'acederBoleia'),
('passageiro', 'acederBoleia'),
('condutor', 'acederDocumento'),
('passageiro', 'acederFavorito'),
('passageiro', 'acederFrontend'),
('passageiro', 'acederPerfil'),
('passageiro', 'acederReserva'),
('condutor', 'acederViatura'),
('passageiro', 'adicionarFavorito'),
('passageiro', 'cancelarReserva'),
('admin', 'condutor'),
('admin', 'criarAdmin'),
('passageiro', 'criarAvaliacao'),
('condutor', 'criarBoleia'),
('condutor', 'criarCondutor'),
('condutor', 'criarDocumento'),
('passageiro', 'criarPassageiro'),
('passageiro', 'criarReserva'),
('condutor', 'criarViatura'),
('admin', 'editarAdmin'),
('passageiro', 'editarAvaliacao'),
('condutor', 'editarBoleia'),
('condutor', 'editarCondutor'),
('condutor', 'editarDocumento'),
('passageiro', 'editarPassageiro'),
('condutor', 'editarViatura'),
('admin', 'eliminarAdmin'),
('passageiro', 'eliminarAvaliacao'),
('condutor', 'eliminarBoleia'),
('condutor', 'eliminarCondutor'),
('condutor', 'eliminarDocumento'),
('passageiro', 'eliminarPassageiro'),
('condutor', 'eliminarViatura'),
('admin', 'passageiro'),
('condutor', 'passageiro'),
('passageiro', 'removerFavorito'),
('passageiro', 'verMinhasReservas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `perfil_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-avaliacoes-perfil_id` (`perfil_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `boleias`
--

DROP TABLE IF EXISTS `boleias`;
CREATE TABLE IF NOT EXISTS `boleias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `origem` varchar(255) NOT NULL,
  `destino` varchar(255) NOT NULL,
  `data_hora` datetime NOT NULL,
  `lugares_disponiveis` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `viatura_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-boleias-viatura_id` (`viatura_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `condutores_favoritos`
--

DROP TABLE IF EXISTS `condutores_favoritos`;
CREATE TABLE IF NOT EXISTS `condutores_favoritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `perfil_id_user` int NOT NULL,
  `perfil_id_condutor` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-condutores_favoritos-perfil_id_user` (`perfil_id_user`),
  KEY `idx-condutores_favoritos-perfil_id_condutor` (`perfil_id_condutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destinos_favoritos`
--

DROP TABLE IF EXISTS `destinos_favoritos`;
CREATE TABLE IF NOT EXISTS `destinos_favoritos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `boleia_id` int DEFAULT NULL,
  `perfil_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-destinos_favoritos-boleia_id` (`boleia_id`),
  KEY `idx-destinos_favoritos-perfil_id` (`perfil_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `documentos`
--

DROP TABLE IF EXISTS `documentos`;
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `carta_conducao` varchar(255) DEFAULT NULL,
  `cartao_cidadao` varchar(255) DEFAULT NULL,
  `valido` tinyint(1) NOT NULL,
  `perfil_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-documentos-perfil_id` (`perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1765739804),
('m130524_201442_init', 1765739806),
('m190124_110200_add_verification_token_column_to_user_table', 1765739806),
('m251006_195135_create_perfis_table', 1765739806),
('m251006_195150_create_viaturas_table', 1765739806),
('m251006_195228_create_boleias_table', 1765739806),
('m251006_195237_create_reservas_table', 1765739806),
('m251006_195245_create_avaliacoes_table', 1765739806),
('m251006_195258_create_documentos_table', 1765739806),
('m251006_195315_create_destinos_favoritos_table', 1765739807),
('m251204_131327_create_condutor_favorito_table', 1765739807),
('m140506_102106_rbac_init', 1765745831),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1765745831),
('m180523_151638_rbac_updates_indexes_without_prefix', 1765745831),
('m200409_110543_rbac_update_mssql_trigger', 1765745831);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfis`
--

DROP TABLE IF EXISTS `perfis`;
CREATE TABLE IF NOT EXISTS `perfis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `telefone` int NOT NULL,
  `morada` varchar(50) NOT NULL,
  `genero` varchar(30) NOT NULL,
  `data_nascimento` date NOT NULL,
  `condutor` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-perfis-user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ponto_encontro` text NOT NULL,
  `contacto` int NOT NULL,
  `reembolso` float NOT NULL DEFAULT '0',
  `estado` varchar(255) NOT NULL DEFAULT 'Pendente',
  `perfil_id` int NOT NULL,
  `boleia_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-reservas-perfil_id` (`perfil_id`),
  KEY `idx-reservas-boleia_id` (`boleia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `viaturas`
--

DROP TABLE IF EXISTS `viaturas`;
CREATE TABLE IF NOT EXISTS `viaturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `matricula` varchar(15) NOT NULL,
  `cor` varchar(20) NOT NULL,
  `perfil_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `idx-viaturas-perfil_id` (`perfil_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `boleias`
--
ALTER TABLE `boleias`
  ADD CONSTRAINT `fk-boleias-viatura_id` FOREIGN KEY (`viatura_id`) REFERENCES `viaturas` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `condutores_favoritos`
--
ALTER TABLE `condutores_favoritos`
  ADD CONSTRAINT `fk-condutores_favoritos-perfil_id_condutor` FOREIGN KEY (`perfil_id_condutor`) REFERENCES `perfis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-condutores_favoritos-perfil_id_user` FOREIGN KEY (`perfil_id_user`) REFERENCES `perfis` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `destinos_favoritos`
--
ALTER TABLE `destinos_favoritos`
  ADD CONSTRAINT `fk-destinos_favoritos-boleia_id` FOREIGN KEY (`boleia_id`) REFERENCES `boleias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-destinos_favoritos-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `fk-documentos-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `perfis`
--
ALTER TABLE `perfis`
  ADD CONSTRAINT `fk-perfis-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk-reservas-boleia_id` FOREIGN KEY (`boleia_id`) REFERENCES `boleias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-reservas-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `viaturas`
--
ALTER TABLE `viaturas`
  ADD CONSTRAINT `fk-viaturas-perfil_id` FOREIGN KEY (`perfil_id`) REFERENCES `perfis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
