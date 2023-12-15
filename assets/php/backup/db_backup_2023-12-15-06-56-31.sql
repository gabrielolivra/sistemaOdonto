DROP TABLE IF EXISTS agendamentos;
CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `data_agendamento` datetime DEFAULT NULL,
  `tipo_procedimento` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `finalizar` tinyint(1) DEFAULT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS backup_control;
CREATE TABLE `backup_control` (
  `backup_id` int(11) NOT NULL AUTO_INCREMENT,
  `data_backup` timestamp NOT NULL DEFAULT current_timestamp(),
  `caminho_backup` varchar(255) NOT NULL,
  PRIMARY KEY (`backup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO backup_control VALUES("1","2023-12-15 14:28:35","backup/db_backup_2023-12-15-06-28-35.sql");
INSERT INTO backup_control VALUES("2","2023-12-15 14:34:13","backup/db_backup_2023-12-15-06-34-13.sql");
INSERT INTO backup_control VALUES("3","2023-12-15 14:36:26","backup/db_backup_2023-12-15-06-36-26.sql");
INSERT INTO backup_control VALUES("4","2023-12-15 14:42:25","backup/db_backup_2023-12-15-06-42-25.sql");
INSERT INTO backup_control VALUES("5","2023-12-15 14:43:24","backup/db_backup_2023-12-15-06-43-24.sql");
INSERT INTO backup_control VALUES("6","2023-12-15 14:44:14","backup/db_backup_2023-12-15-06-44-14.sql");
INSERT INTO backup_control VALUES("7","2023-12-15 14:45:20","backup/db_backup_2023-12-15-06-45-20.sql");
INSERT INTO backup_control VALUES("8","2023-12-15 14:45:23","backup/db_backup_2023-12-15-06-45-23.sql");
INSERT INTO backup_control VALUES("9","2023-12-15 14:48:34","backup/db_backup_2023-12-15-06-48-34.sql");
INSERT INTO backup_control VALUES("10","2023-12-15 14:49:58","backup/db_backup_2023-12-15-06-49-58.sql");
INSERT INTO backup_control VALUES("11","2023-12-15 14:50:09","backup/db_backup_2023-12-15-06-50-09.sql");
INSERT INTO backup_control VALUES("12","2023-12-15 14:51:02","backup/db_backup_2023-12-15-06-51-02.sql");
INSERT INTO backup_control VALUES("13","2023-12-15 14:52:54","backup/db_backup_2023-12-15-06-52-54.sql");
INSERT INTO backup_control VALUES("14","2023-12-15 14:53:02","backup/db_backup_2023-12-15-06-53-02.sql");
INSERT INTO backup_control VALUES("15","2023-12-15 14:53:32","backup/db_backup_2023-12-15-06-53-32.sql");

DROP TABLE IF EXISTS cadastro_user;
CREATE TABLE `cadastro_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text NOT NULL,
  `email` text NOT NULL,
  `senha` text NOT NULL,
  `whatsapp` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO cadastro_user VALUES("1","root","root","$2y$10$eft7PTKsxMEiuzR26kes.e7NqeYDaeS0uL1uzZtEdX.R9RP2w8s/m","88888888","1");

DROP TABLE IF EXISTS clientes;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(100) NOT NULL,
  `cpf` text DEFAULT NULL,
  `genero` varchar(10) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco_rua` varchar(255) DEFAULT NULL,
  `endereco_cidade` varchar(100) DEFAULT NULL,
  `endereco_estado` varchar(50) DEFAULT NULL,
  `endereco_cep` varchar(15) DEFAULT NULL,
  `historico_medico` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS galeria;
CREATE TABLE `galeria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` text DEFAULT NULL,
  `data_imagem` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `galeria_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO galeria VALUES("16",NULL,"oi","../../assets/galeria/Captura de tela 2023-04-05 134137.png",NULL);
INSERT INTO galeria VALUES("17",NULL,"oi","../../assets/galeria/Captura de tela 2023-04-04 092045.png",NULL);
INSERT INTO galeria VALUES("18",NULL,"oi","../../assets/galeria/Captura de tela 2023-04-12 083306.png",NULL);
INSERT INTO galeria VALUES("20",NULL,"testandoo","../../assets/galeria/Captura de tela 2023-04-20 144156.png",NULL);
INSERT INTO galeria VALUES("21",NULL,"oi","../../assets/galeria/Captura de tela 2023-04-05 134137.png",NULL);
INSERT INTO galeria VALUES("22",NULL,"oi","../../assets/galeria/Captura de tela 2023-04-05 134137.png",NULL);

