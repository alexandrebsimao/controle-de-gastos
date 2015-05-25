-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.17 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para controle
CREATE DATABASE IF NOT EXISTS `controle` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `controle`;


-- Copiando estrutura para tabela controle.controle_fixo
CREATE TABLE IF NOT EXISTS `controle_fixo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL DEFAULT '0',
  `codigo` varchar(250) DEFAULT NULL,
  `descricao` varchar(250) DEFAULT NULL,
  `valor` varchar(50) DEFAULT NULL,
  `observacao` text NOT NULL,
  `data` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_controle_fixo_usuario` (`id_usuario`),
  CONSTRAINT `FK_controle_fixo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela controle.controle_fixo: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `controle_fixo` DISABLE KEYS */;
INSERT INTO `controle_fixo` (`id`, `tipo`, `codigo`, `descricao`, `valor`, `observacao`, `data`, `id_usuario`) VALUES
	(1, 'credito', '001', 'Sálario', '1300.00', '', 5, 2),
	(2, 'debito', '002', 'Faculdade', '-800', '', 15, 2);
/*!40000 ALTER TABLE `controle_fixo` ENABLE KEYS */;


-- Copiando estrutura para tabela controle.controle_mensal
CREATE TABLE IF NOT EXISTS `controle_mensal` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(10) DEFAULT '0' COMMENT '0 - Crédito/ 1 - Débito',
  `codigo` varchar(250) NOT NULL DEFAULT '0',
  `descricao` varchar(250) NOT NULL DEFAULT '0',
  `valor` varchar(50) NOT NULL DEFAULT '0.00',
  `observacao` text NOT NULL,
  `efetuado` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - Não Efetuada / 1 - Efetuada',
  `data` int(2) NOT NULL,
  `mes_ano_referente` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_controle_mensal_usuario` (`id_usuario`),
  CONSTRAINT `FK_controle_mensal_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela controle.controle_mensal: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `controle_mensal` DISABLE KEYS */;
INSERT INTO `controle_mensal` (`id`, `tipo`, `codigo`, `descricao`, `valor`, `observacao`, `efetuado`, `data`, `mes_ano_referente`, `id_usuario`) VALUES
	(1, 'credito', '001', 'Sálario', '1300.00', '', 1, 5, '2015-05-05', 2),
	(2, 'debito', '002', 'Faculdade', '-800', '', 1, 15, '2015-05-15', 2),
	(3, 'debito', '003', 'Cartão de Crédito', '-350', '', 0, 15, '2015-05-15', 2);
/*!40000 ALTER TABLE `controle_mensal` ENABLE KEYS */;


-- Copiando estrutura para tabela controle.fechamento_mes
CREATE TABLE IF NOT EXISTS `fechamento_mes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mes_ano_referencia` date NOT NULL,
  `observacao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela controle.fechamento_mes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `fechamento_mes` DISABLE KEYS */;
/*!40000 ALTER TABLE `fechamento_mes` ENABLE KEYS */;


-- Copiando estrutura para tabela controle.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL DEFAULT '0',
  `usuario` varchar(50) NOT NULL DEFAULT '0',
  `senha` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(250) NOT NULL DEFAULT '0',
  `ip` varchar(250) NOT NULL DEFAULT '0',
  `acesso_atual` varchar(50) NOT NULL DEFAULT '0',
  `ultimo_acesso` varchar(50) NOT NULL DEFAULT '0',
  `recuperacao_senha` varchar(250) NOT NULL DEFAULT '0',
  `hash` varchar(250) DEFAULT '0',
  `lembrar` tinyint(1) NOT NULL DEFAULT '0',
  `ativado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela controle.usuario: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id`, `nome`, `usuario`, `senha`, `email`, `ip`, `acesso_atual`, `ultimo_acesso`, `recuperacao_senha`, `hash`, `lembrar`, `ativado`) VALUES
	(1, 'Administrador', 'admin', '81a107a5fe5953c61e9a38846066c8e4de484025', 'alexandre.b.simao@gmail.com', '0', '0', '0', '0', NULL, 0, 1),
	(2, 'Alexandre', 'alexandre', '102936b27ed12357616cbf604b351f22da492314', 'alexandre.b.simao@gmail.com', '0', '0', '0', '0', 'f3a5da422cd8e728e80a808377f5c788', 0, 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
