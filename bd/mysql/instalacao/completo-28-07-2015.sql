-- MySQL dump 10.13  Distrib 5.5.38, for osx10.6 (i386)
--
-- Host: localhost    Database: framework3
-- ------------------------------------------------------
-- Server version	5.5.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dl_painel_email_config`
--

DROP TABLE IF EXISTS `dl_painel_email_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_email_config` (
  `config_email_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_email_titulo` varchar(30) NOT NULL,
  `config_email_host` varchar(80) NOT NULL,
  `config_email_porta` int(11) NOT NULL DEFAULT '25',
  `config_email_autent` int(11) NOT NULL,
  `config_email_cripto` varchar(5) NOT NULL,
  `config_email_conta` varchar(100) NOT NULL,
  `config_email_senha` varchar(20) NOT NULL,
  `config_email_de_email` varchar(100) DEFAULT NULL,
  `config_email_de_nome` varchar(100) DEFAULT NULL,
  `config_email_responder_para` varchar(100) DEFAULT NULL,
  `config_email_html` tinyint(1) NOT NULL DEFAULT '1',
  `config_email_principal` tinyint(1) NOT NULL DEFAULT '0',
  `config_email_debug` tinyint(1) NOT NULL DEFAULT '0',
  `config_email_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_email_config`
--

LOCK TABLES `dl_painel_email_config` WRITE;
/*!40000 ALTER TABLE `dl_painel_email_config` DISABLE KEYS */;
INSERT INTO `dl_painel_email_config` VALUES (1,'Gmail','smtp.gmail.com',465,1,'ssl','dlepera88@gmail.com','atabaque@2611','dlepera88@gmail.com','Diego Lepera','dlepera88@gmail.com',1,1,0,0);
/*!40000 ALTER TABLE `dl_painel_email_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_email_logs`
--

DROP TABLE IF EXISTS `dl_painel_email_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_email_logs` (
  `log_email_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_email_config` int(11) DEFAULT NULL,
  `log_email_ip` varchar(80) NOT NULL,
  `log_email_classe` varchar(20) NOT NULL,
  `log_email_tabela` varchar(30) DEFAULT NULL,
  `log_email_idreg` int(11) DEFAULT NULL,
  `log_email_status` char(1) NOT NULL DEFAULT 'S',
  `log_email_mensagem` text,
  PRIMARY KEY (`log_email_id`),
  KEY `FK_log_email_config` (`log_email_config`),
  CONSTRAINT `FK_log_email_config` FOREIGN KEY (`log_email_config`) REFERENCES `dl_painel_email_config` (`config_email_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_email_logs`
--

LOCK TABLES `dl_painel_email_logs` WRITE;
/*!40000 ALTER TABLE `dl_painel_email_logs` DISABLE KEYS */;
INSERT INTO `dl_painel_email_logs` VALUES (1,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(2,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(3,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(4,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(5,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(6,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(7,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(8,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(9,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(10,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(11,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(12,1,'::1','Contato\\Controle\\Con','dl_site_contatos',63,'E',NULL),(13,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(14,1,'::1','Contato\\Controle\\Con','dl_site_contatos',0,'E',NULL),(15,1,'::1','Contato\\Controle\\Con','dl_site_contatos',72,'E',NULL),(16,1,'::1','Contato\\Controle\\Con','dl_site_contatos',73,'E',NULL),(17,1,'::1','Contato\\Controle\\Con','dl_site_contatos',74,'E',NULL),(18,1,'::1','Contato\\Controle\\Con','dl_site_contatos',75,'E',NULL),(19,1,'::1','Contato\\Controle\\Con','dl_site_contatos',76,'E',NULL),(20,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',2,'E',NULL),(21,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',2,'E',NULL),(22,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',2,'E',NULL),(23,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',2,'E',NULL),(24,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',2,'E',NULL),(25,1,'::1','Contato\\Controle\\Con','dl_site_contatos',76,'E',NULL),(26,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',77,'E',NULL),(27,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',78,'E',NULL),(28,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',79,'E',NULL),(29,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',80,'E',NULL),(30,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',81,'E',NULL),(31,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',82,'E',NULL),(32,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',83,'E',NULL),(33,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',84,'E',NULL),(34,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',85,'E',NULL),(35,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',86,'E',NULL),(36,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',87,'E',NULL),(37,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',88,'E',NULL),(38,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',89,'E',NULL),(39,1,'127.0.0.2','Contato\\Controle\\Con','dl_site_contatos',90,'E',NULL),(40,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',0,'E',NULL),(41,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(42,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',0,'E',NULL),(43,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',0,'E',NULL),(44,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',3,'E',NULL),(45,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',4,'E',NULL),(46,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',4,'E',NULL),(47,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',4,'E',NULL),(48,1,'::1','Login\\Controle\\Login','dl_painel_usuarios_recuperacoe',5,'E',NULL),(49,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(50,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(51,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(52,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(53,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(54,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(55,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(56,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(57,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(58,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(59,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(60,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(61,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(62,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(63,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(64,1,'::1','Admin\\Controle\\Confi','dl_painel_email_config',0,'E',NULL),(65,1,'::1','Contato\\Controle\\Con','dl_site_contatos',80,'E',NULL),(66,1,'::1','Contato\\Controle\\Con','dl_site_contatos',81,'E',NULL),(67,1,'::1','Contato\\Controle\\Con','dl_site_contatos',82,'E',NULL),(68,1,'::1','Contato\\Controle\\Con','dl_site_contatos',83,'E',NULL),(69,1,'::1','Contato\\Controle\\Con','dl_site_contatos',84,'E',NULL),(70,1,'::1','Contato\\Controle\\Con','dl_site_contatos',85,'E',NULL),(71,1,'::1','Contato\\Controle\\Con','dl_site_contatos',86,'E',NULL);
/*!40000 ALTER TABLE `dl_painel_email_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_formatos_data`
--

DROP TABLE IF EXISTS `dl_painel_formatos_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_formatos_data` (
  `formato_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `formato_data_descr` varchar(20) NOT NULL,
  `formato_data_completo` varchar(20) NOT NULL,
  `formato_data_data` varchar(10) NOT NULL,
  `formato_data_hora` varchar(10) NOT NULL,
  `formato_data_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `formato_data_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`formato_data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_formatos_data`
--

LOCK TABLES `dl_painel_formatos_data` WRITE;
/*!40000 ALTER TABLE `dl_painel_formatos_data` DISABLE KEYS */;
INSERT INTO `dl_painel_formatos_data` VALUES (1,'dd/mm/aaaa hh:mm','d/m/Y H:i','d/m/Y','H:i',1,0);
/*!40000 ALTER TABLE `dl_painel_formatos_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_funcs_metodos`
--

DROP TABLE IF EXISTS `dl_painel_funcs_metodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_funcs_metodos` (
  `metodo_func` int(11) NOT NULL,
  `metodo_func_id` int(11) NOT NULL AUTO_INCREMENT,
  `metodo_func_descr` varchar(20) NOT NULL,
  PRIMARY KEY (`metodo_func_id`),
  KEY `FK_metodo_func` (`metodo_func`),
  CONSTRAINT `FK_metodo_func` FOREIGN KEY (`metodo_func`) REFERENCES `dl_painel_modulos_funcs` (`func_modulo_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_funcs_metodos`
--

LOCK TABLES `dl_painel_funcs_metodos` WRITE;
/*!40000 ALTER TABLE `dl_painel_funcs_metodos` DISABLE KEYS */;
INSERT INTO `dl_painel_funcs_metodos` VALUES (49,71,'_mostrarlista'),(50,72,'_mostrarlista'),(50,73,'_mostrarform'),(50,74,'_salvar'),(51,75,'_mostrarlista'),(51,76,'_remover'),(52,77,'_mostrarlista'),(52,78,'_testar'),(53,79,'_mostrarlista'),(54,80,'_mostrarlista'),(54,81,'_mostrarform'),(54,82,'_salvar'),(55,83,'_mostrarlista'),(55,84,'_remover'),(56,85,'_mostrarlista'),(57,86,'_mostrarlista'),(57,87,'_mostrarform'),(57,88,'_salvar'),(58,89,'_mostrarlista'),(58,90,'_remover'),(59,91,'_mostrarlista'),(59,92,'_bloquear'),(61,95,'_formalterarsenha'),(61,96,'_alterarsenha'),(62,97,'_mostrarlista'),(63,98,'_mostrarlista'),(63,99,'_mostrarform'),(63,100,'_salvar'),(64,101,'_mostrarlista'),(64,102,'_remover'),(65,103,'_mostrarlista'),(66,104,'_mostrarlista'),(66,105,'_mostrarform'),(66,106,'_salvar'),(68,109,'_mostrarlista'),(68,110,'_remover'),(69,111,'_mostrarform'),(69,112,'_novafunc'),(70,113,'_mostrarform'),(70,114,'_removerfunc'),(71,115,'_mostrarlista'),(72,116,'_mostrarlista'),(72,117,'_mostrarform'),(72,118,'_salvar'),(73,119,'_mostrarlista'),(73,120,'_remover'),(74,121,'_mostrarlista'),(75,122,'_mostrarlista'),(75,123,'_mostrarform'),(75,124,'_salvar'),(76,125,'_mostrarlista'),(76,126,'_remover'),(77,127,'_upload'),(78,128,'_mostrarform'),(78,129,'_salvar'),(79,130,'_remover'),(80,131,'_mostrarlista'),(81,132,'_mostrarlista'),(81,133,'_mostrarform'),(81,134,'_salvar'),(82,135,'_mostrarlista'),(82,136,'_remover'),(83,137,'_minhaconta'),(83,138,'_salvar'),(84,139,'_mostrarlista'),(85,140,'_mostrarlista'),(85,141,'_mostrardetalhes'),(86,142,'_mostrarlista'),(86,143,'_remover'),(87,144,'_mostrarlista'),(88,145,'_mostrarlista'),(88,146,'_mostrarform'),(88,147,'_salvar'),(89,148,'_mostrarlista'),(89,149,'_remover'),(90,150,'_mostrarlista'),(91,151,'_mostrarlista'),(91,152,'_mostrarform'),(91,153,'_salvar'),(92,154,'_mostrarlista'),(92,155,'_remover'),(93,156,'_mostrarlista'),(94,157,'_mostrarlista'),(94,158,'_mostrarform'),(94,159,'_salvar'),(95,160,'_mostrarlista'),(95,161,'_remover'),(98,171,'_mostrarform'),(98,172,'_mostrarlista'),(54,175,'_alternarpublicacao'),(57,176,'_alternarpublicacao'),(63,177,'_alternarpublicacao'),(66,178,'_alternarpublicacao'),(72,179,'_alternarpublicacao'),(75,180,'_alternarpublicacao'),(81,181,'_alternarpublicacao'),(88,182,'_alternarpublicacao'),(91,183,'_alternarpublicacao'),(94,184,'_alternarpublicacao'),(98,185,'_salvar'),(99,190,'_mostrarlista'),(99,191,'_mostrarinfos'),(97,192,'_mostrarform'),(97,193,'_salvar'),(83,194,'_salvar_foto');
/*!40000 ALTER TABLE `dl_painel_funcs_metodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_grupos_funcs`
--

DROP TABLE IF EXISTS `dl_painel_grupos_funcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_grupos_funcs` (
  `grupo_usuario_id` int(11) NOT NULL,
  `func_modulo_id` int(11) NOT NULL,
  PRIMARY KEY (`grupo_usuario_id`,`func_modulo_id`),
  KEY `FK_func_modulo_id` (`func_modulo_id`),
  CONSTRAINT `FK_func_modulo_id` FOREIGN KEY (`func_modulo_id`) REFERENCES `dl_painel_modulos_funcs` (`func_modulo_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_grupo_usuario_id` FOREIGN KEY (`grupo_usuario_id`) REFERENCES `dl_painel_grupos_usuarios` (`grupo_usuario_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_grupos_funcs`
--

LOCK TABLES `dl_painel_grupos_funcs` WRITE;
/*!40000 ALTER TABLE `dl_painel_grupos_funcs` DISABLE KEYS */;
INSERT INTO `dl_painel_grupos_funcs` VALUES (1,49),(3,49),(1,50),(3,50),(1,51),(3,51),(1,52),(3,52),(1,53),(3,53),(1,54),(3,54),(1,55),(3,55),(1,56),(3,56),(1,57),(3,57),(1,58),(3,58),(1,59),(3,59),(1,61),(3,61),(3,62),(3,63),(3,64),(3,65),(3,66),(3,68),(3,69),(3,70),(3,71),(3,72),(3,73),(1,74),(3,74),(1,75),(3,75),(1,76),(3,76),(1,77),(3,77),(1,78),(3,78),(1,79),(3,79),(1,80),(3,80),(1,81),(3,81),(1,82),(3,82),(1,83),(3,83),(1,84),(2,84),(3,84),(1,85),(2,85),(3,85),(1,86),(2,86),(3,86),(1,87),(2,87),(3,87),(1,88),(2,88),(3,88),(1,89),(2,89),(3,89),(1,90),(3,90),(1,91),(3,91),(1,92),(3,92),(1,93),(3,93),(1,94),(3,94),(1,95),(3,95),(1,97),(3,97),(1,98),(3,98),(1,99),(3,99);
/*!40000 ALTER TABLE `dl_painel_grupos_funcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_grupos_usuarios`
--

DROP TABLE IF EXISTS `dl_painel_grupos_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_grupos_usuarios` (
  `grupo_usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_usuario_descr` varchar(30) NOT NULL,
  `grupo_usuario_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `grupo_usuario_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`grupo_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_grupos_usuarios`
--

LOCK TABLES `dl_painel_grupos_usuarios` WRITE;
/*!40000 ALTER TABLE `dl_painel_grupos_usuarios` DISABLE KEYS */;
INSERT INTO `dl_painel_grupos_usuarios` VALUES (1,'Administradores',1,0),(2,'Editores do website',1,0),(3,'Desenvolvedores',1,0);
/*!40000 ALTER TABLE `dl_painel_grupos_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_idiomas`
--

DROP TABLE IF EXISTS `dl_painel_idiomas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_idiomas` (
  `idioma_id` int(11) NOT NULL AUTO_INCREMENT,
  `idioma_descr` varchar(20) NOT NULL,
  `idioma_sigla` varchar(5) NOT NULL,
  `idioma_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `idioma_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idioma_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_idiomas`
--

LOCK TABLES `dl_painel_idiomas` WRITE;
/*!40000 ALTER TABLE `dl_painel_idiomas` DISABLE KEYS */;
INSERT INTO `dl_painel_idiomas` VALUES (1,'Português (Brasil)','pt_BR',1,0),(2,'Inglês (USA)','en_US',1,0);
/*!40000 ALTER TABLE `dl_painel_idiomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_modulos`
--

DROP TABLE IF EXISTS `dl_painel_modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_modulos` (
  `modulo_id` int(20) NOT NULL AUTO_INCREMENT,
  `modulo_pai` int(20) DEFAULT NULL,
  `modulo_nome` varchar(30) NOT NULL,
  `modulo_descr` text,
  `modulo_menu` tinyint(1) NOT NULL DEFAULT '1',
  `modulo_link` varchar(100) NOT NULL,
  `modulo_ordem` int(11) NOT NULL DEFAULT '0',
  `modulo_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `modulo_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`modulo_id`),
  KEY `FK_modulo_pai` (`modulo_pai`),
  CONSTRAINT `FK_modulo_pai` FOREIGN KEY (`modulo_pai`) REFERENCES `dl_painel_modulos` (`modulo_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_modulos`
--

LOCK TABLES `dl_painel_modulos` WRITE;
/*!40000 ALTER TABLE `dl_painel_modulos` DISABLE KEYS */;
INSERT INTO `dl_painel_modulos` VALUES (22,NULL,'Desenvolvedor','Área para desenvolvedores adicionarem módulos, temas e pacote de idiomas.',1,'desenvolvedor',99,1,0),(23,22,'Temas','Gerenciar temas do Painel-DL instalados.',1,'desenvolvedor/temas',0,1,0),(24,22,'Módulos','Gerenciar módulos instalados, ou informar novos módulos do Painel-DL.',1,'desenvolvedor/modulos',0,1,0),(25,22,'Idiomas','Informar pacotes de idiomas instalados.',1,'desenvolvedor/idiomas',0,1,0),(26,NULL,'Admin','',1,'admin',98,1,0),(27,26,'Usuários','Gerenciar contas de usuário.',1,'admin/usuarios',0,1,0),(28,26,'Grupos de usuários','Gerenciar grupos de usuários e suas permissões.',1,'admin/grupos-de-usuarios',0,1,0),(29,26,'Envio de e-mails','Configuração SMTP para envios de e-mails através do sistema.',1,'admin/envio-de-emails',0,1,0),(30,NULL,'Website','',1,'website',0,1,0),(31,30,'Álbuns de fotos','Incluir, editar e remover álbuns de fotos para o site.',1,'website/albuns-de-fotos',0,1,0),(32,30,'Dados para contato','Dados para entrar em contato com o proprietário do site.',1,'website/dados-para-contato',0,1,0),(33,30,'Contatos recebidos','Lista com todos os contatos recebidos através do formulário do web-site.',1,'website/contatos-recebidos',0,1,0),(34,30,'Assuntos de contatos','Assuntos que são exibidos no formulário de contato. São utilizados para categorizar  os contatos recebidos, podendo encaminhar cada assunto para um e-mail específico.',1,'website/assuntos-contato',0,1,0),(35,30,'Google Analytics','Configurações do Google Analytics.',0,'website/google-analytics',0,1,0),(36,30,'Tipos de dados para contato','Tipos de dados para contato. Redes sociais, e-mails, telefones, etc.',0,'website/tipos-de-dados',0,1,0),(37,30,'Institucional','Informações instiucionais sobre a empresa: história, missão, visão e valores.',1,'website/institucional',0,1,0),(38,30,'Configurações do website','Define algumas configurções para o website, como tema, formato para as data, entre outros.',1,'website/configuracoes',0,1,0);
/*!40000 ALTER TABLE `dl_painel_modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_modulos_funcs`
--

DROP TABLE IF EXISTS `dl_painel_modulos_funcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_modulos_funcs` (
  `func_modulo` int(11) NOT NULL,
  `func_modulo_id` int(11) NOT NULL AUTO_INCREMENT,
  `func_modulo_descr` varchar(100) NOT NULL,
  `func_modulo_classe` varchar(100) NOT NULL,
  `func_modulo_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`func_modulo_id`),
  KEY `FK_func_modulo` (`func_modulo`),
  CONSTRAINT `FK_func_modulo` FOREIGN KEY (`func_modulo`) REFERENCES `dl_painel_modulos` (`modulo_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_modulos_funcs`
--

LOCK TABLES `dl_painel_modulos_funcs` WRITE;
/*!40000 ALTER TABLE `dl_painel_modulos_funcs` DISABLE KEYS */;
INSERT INTO `dl_painel_modulos_funcs` VALUES (29,49,'Ver a lista de registros','Admin\\Controle\\ConfigEmail',0),(29,50,'Cadastrar ou editar registros','Admin\\Controle\\ConfigEmail',0),(29,51,'Excluir registros','Admin\\Controle\\ConfigEmail',0),(29,52,'Testar configuração de e-mail','Admin\\Controle\\ConfigEmail',0),(28,53,'Ver a lista de registros','Admin\\Controle\\GrupoUsuario',0),(28,54,'Cadastrar e editar registros','Admin\\Controle\\GrupoUsuario',0),(28,55,'Excluir registros','Admin\\Controle\\GrupoUsuario',0),(27,56,'Ver a lista de registros','Admin\\Controle\\Usuario',0),(27,57,'Cadastrar e editar registros','Admin\\Controle\\Usuario',0),(27,58,'Excluir registros','Admin\\Controle\\Usuario',0),(27,59,'Bloquear ou desbloquear lista','Admin\\Controle\\Usuario',0),(27,61,'Alterar a senha de acesso','Admin\\Controle\\Usuario',0),(25,62,'Ver a lista de registros','Desenvolvedor\\Controle\\Idioma',0),(25,63,'Cadastrar e editar registros','Desenvolvedor\\Controle\\Idioma',0),(25,64,'Excluir registros','Desenvolvedor\\Controle\\Idioma',0),(24,65,'Ver a lista de registros','Desenvolvedor\\Controle\\Modulo',0),(24,66,'Cadastrar e editar registros','Desenvolvedor\\Controle\\Modulo',0),(24,68,'Excluir registros','Desenvolvedor\\Controle\\Modulo',0),(24,69,'Incluir novas funcionalidades','Desenvolvedor\\Controle\\Modulo',0),(24,70,'Excluir funcionalidades','Desenvolvedor\\Controle\\Modulo',0),(23,71,'Ver a lista de registros','Desenvolvedor\\Controle\\Tema',0),(23,72,'Cadastrar e editar registros','Desenvolvedor\\Controle\\Tema',0),(23,73,'Excluir registros','Desenvolvedor\\Controle\\Tema',0),(31,74,'Ver a lista de registros','Website\\Controle\\Album',0),(31,75,'Cadastrar e editar registros','Website\\Controle\\Album',0),(31,76,'Excluir registros','Website\\Controle\\Album',0),(31,77,'Incluir novas fotos','Website\\Controle\\FotoAlbum',0),(31,78,'Editar as informações das fotos','Website\\Controle\\FotoAlbum',0),(31,79,'Excluir fotos','Website\\Controle\\FotoAlbum',0),(34,80,'Ver a lista de registros','Website\\Controle\\AssuntoContato',0),(34,81,'Cadastrar e editar registros','Website\\Controle\\AssuntoContato',0),(34,82,'Excluir registros','Website\\Controle\\AssuntoContato',0),(27,83,'Editar conta de usuário','Admin\\Controle\\Usuario',0),(33,84,'Ver a lista de registros','Website\\Controle\\ContatoSite',0),(33,85,'Ver detalhes dos contatos','Website\\Controle\\ContatoSite',0),(33,86,'Excluir registros','Website\\Controle\\ContatoSite',0),(32,87,'Ver a lista de registros','Website\\Controle\\DadoContato',0),(32,88,'Cadastrar e editar registros','Website\\Controle\\DadoContato',0),(32,89,'Excluir registros','Website\\Controle\\DadoContato',0),(35,90,'Ver a lista de registros','Website\\Controle\\GoogleAnalytics',0),(35,91,'Cadastrar e editar registros','Website\\Controle\\GoogleAnalytics',0),(35,92,'Excluir registros','Website\\Controle\\GoogleAnalytics',0),(36,93,'Ver a lista de registros','Website\\Controle\\TipoDadoContato',0),(36,94,'Cadastrar e editar registros','Website\\Controle\\TipoDadoContato',0),(36,95,'Excluir registros','Website\\Controle\\TipoDadoContato',0),(37,97,'Editar as informações','Website\\Controle\\Institucional',0),(38,98,'Editar as configurções do site','WebSite\\Controle\\ConfiguracaoSite',0),(37,99,'Ver as informações institucionais','Website\\Controle\\Institucional',0);
/*!40000 ALTER TABLE `dl_painel_modulos_funcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_registros_logs`
--

DROP TABLE IF EXISTS `dl_painel_registros_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_registros_logs` (
  `log_registro_tabela` varchar(100) NOT NULL,
  `log_registro_idreg` int(11) NOT NULL,
  `log_registro_data_criacao` datetime NOT NULL,
  `log_registro_data_alteracao` datetime DEFAULT NULL,
  `log_registro_data_exclusao` datetime DEFAULT NULL,
  `log_registro_usuario_criacao` int(11) NOT NULL,
  `log_registro_usuario_nome_criacao` varchar(50) NOT NULL,
  `log_registro_usuario_alteracao` int(11) DEFAULT NULL,
  `log_registro_usuario_nome_alteracao` varchar(50) NOT NULL,
  `log_registro_usuario_exclusao` int(11) DEFAULT NULL,
  `log_registro_usuario_nome_exclusao` varchar(50) NOT NULL,
  `log_registro_ip_criacao` varchar(15) NOT NULL,
  `log_registro_ip_alteracao` varchar(15) DEFAULT NULL,
  `log_registro_ip_exclusao` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`log_registro_tabela`,`log_registro_idreg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_registros_logs`
--

LOCK TABLES `dl_painel_registros_logs` WRITE;
/*!40000 ALTER TABLE `dl_painel_registros_logs` DISABLE KEYS */;
INSERT INTO `dl_painel_registros_logs` VALUES ('',3,'2015-05-19 16:19:27',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('',5,'2015-05-19 15:43:23','2015-05-19 15:56:19',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('',6,'2015-05-19 16:25:42','2015-05-19 16:28:35',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('',7,'2015-05-19 15:41:04',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('',8,'2015-05-19 15:49:34',NULL,'2015-05-19 15:49:38',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_email_config',1,'2015-01-09 23:21:30','2015-07-20 11:52:29',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_email_config',2,'2015-01-09 23:22:32','2015-07-01 10:23:55','2015-07-04 09:44:03',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_painel_email_config',3,'2015-01-12 22:12:24',NULL,'2015-01-14 11:32:29',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',4,'2015-01-12 22:41:57',NULL,'2015-01-14 11:32:29',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',5,'2015-01-12 22:42:53',NULL,'2015-01-14 11:32:29',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',6,'2015-01-12 22:43:38',NULL,'2015-01-14 11:51:49',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',7,'2015-01-12 22:44:13',NULL,'2015-01-14 11:35:40',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',8,'2015-01-12 22:44:28',NULL,'2015-01-14 11:35:22',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',9,'2015-01-12 22:45:37',NULL,'2015-01-14 11:33:55',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',10,'2015-01-12 22:49:11',NULL,'2015-01-14 11:33:45',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_config',11,'2015-01-12 22:50:39',NULL,'2015-01-14 11:33:21',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_email_logs',1,'2015-01-06 17:34:51',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',2,'2015-01-06 17:36:41',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',3,'2015-01-06 17:48:14',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',4,'2015-01-06 17:49:52',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',5,'2015-01-06 19:48:59',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',6,'2015-01-06 19:50:57',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',7,'2015-01-06 19:57:22',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',8,'2015-01-06 20:12:13',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',9,'2015-01-06 20:12:42',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',10,'2015-01-06 20:18:40',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',11,'2015-01-07 14:07:01',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',12,'2015-01-07 14:07:57',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',13,'2015-01-20 15:08:33',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',14,'2015-01-20 15:24:41',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',15,'2015-01-20 15:28:44',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',16,'2015-01-20 18:04:12',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',17,'2015-01-20 18:04:47',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',18,'2015-01-20 18:05:31',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',19,'2015-01-20 18:06:02',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',23,'2015-01-28 13:25:40',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',24,'2015-01-28 13:26:27',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',25,'2015-05-15 11:41:23',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',26,'2015-05-27 18:26:07',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',27,'2015-05-27 18:34:04',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',28,'2015-05-27 18:37:02',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',29,'2015-05-27 18:40:10',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',30,'2015-05-27 18:40:41',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',31,'2015-05-27 18:42:27',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',32,'2015-05-27 18:44:21',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',33,'2015-05-27 18:46:58',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',34,'2015-05-27 18:48:07',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',35,'2015-05-27 18:50:10',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',36,'2015-05-27 18:50:36',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',37,'2015-05-27 18:51:52',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',38,'2015-05-27 23:06:12',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',39,'2015-05-28 00:11:08',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_painel_email_logs',40,'2015-07-14 15:24:20',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',41,'2015-07-14 15:26:16',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',42,'2015-07-14 15:42:15',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',43,'2015-07-14 15:42:45',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',44,'2015-07-14 15:44:16',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',45,'2015-07-14 16:23:46',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',46,'2015-07-14 16:24:59',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',47,'2015-07-14 16:25:54',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',48,'2015-07-14 16:33:43',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',49,'2015-07-17 21:16:34',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',50,'2015-07-20 09:57:56',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',51,'2015-07-20 09:59:51',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',52,'2015-07-20 10:00:04',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',53,'2015-07-20 10:07:59',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',54,'2015-07-20 10:16:20',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',55,'2015-07-20 10:28:04',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',56,'2015-07-20 10:31:06',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',57,'2015-07-20 10:33:32',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',58,'2015-07-20 10:35:35',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',59,'2015-07-20 10:35:49',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',60,'2015-07-20 10:45:37',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',61,'2015-07-20 10:46:29',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',62,'2015-07-20 10:48:00',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',63,'2015-07-20 11:52:19',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',64,'2015-07-20 11:52:38',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',65,'2015-07-25 22:23:56',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',66,'2015-07-25 22:24:37',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',67,'2015-07-26 10:18:50',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',68,'2015-07-27 14:57:35',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',69,'2015-07-27 15:17:06',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',70,'2015-07-27 15:17:51',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_email_logs',71,'2015-07-27 15:33:41',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_grupos_usuarios',1,'2015-01-09 10:41:41','2015-01-09 11:31:32',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_grupos_usuarios',2,'2015-01-09 11:31:58','2015-01-26 18:16:19','2015-01-09 11:32:58',-1,'Super Admin',2,'Diego Lepera',0,'','::1','::1','::1'),('dl_painel_grupos_usuarios',3,'2015-01-26 11:26:11',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_grupos_usuarios',4,'2015-01-29 08:07:35',NULL,'2015-01-29 08:24:25',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_grupos_usuarios',5,'2015-01-29 08:13:20',NULL,'2015-01-29 08:24:25',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_grupos_usuarios',6,'2015-01-29 08:13:38',NULL,'2015-01-29 08:24:25',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_grupos_usuarios',7,'2015-01-29 08:14:05',NULL,'2015-01-29 08:24:25',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_grupos_usuarios',8,'2015-01-29 08:18:49',NULL,'2015-01-29 08:24:25',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_grupos_usuarios',9,'2015-01-29 08:20:11',NULL,'2015-01-29 08:24:25',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_idiomas',1,'2015-01-08 21:48:05',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_idiomas',2,'2015-01-08 21:49:15',NULL,'2015-01-29 08:46:29',-1,'Super Admin',-1,'Super Admin',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_idiomas',3,'2015-01-08 21:49:34','2015-01-29 08:44:04','2015-01-29 08:46:29',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_painel_idiomas',4,'2015-01-29 08:44:33',NULL,'2015-01-29 08:46:29',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_idiomas',5,'2015-01-29 08:45:32',NULL,'2015-01-29 08:46:29',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos',14,'2015-01-08 01:34:29','2015-01-08 02:27:01','2015-01-08 14:36:47',-1,'Super Admin',-1,'Super Admin',0,'','::1','::1','::1'),('dl_painel_modulos',15,'2015-01-08 13:03:29',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_modulos',16,'2015-01-08 13:09:04','2015-01-08 14:06:47','2015-01-08 14:36:40',-1,'Super Admin',-1,'Super Admin',0,'','::1','::1','::1'),('dl_painel_modulos',17,'2015-01-08 14:37:06',NULL,'2015-01-08 14:37:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_modulos',18,'2015-01-08 14:37:17',NULL,'2015-01-08 14:37:35',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_modulos',19,'2015-01-08 14:37:22',NULL,'2015-01-08 14:37:35',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_modulos',20,'2015-01-08 14:37:24',NULL,'2015-01-08 14:37:58',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_modulos',21,'2015-01-08 14:37:27',NULL,'2015-01-08 14:37:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_painel_modulos',22,'2015-01-08 18:10:02','2015-01-14 16:59:03',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos',23,'2015-01-14 17:00:36','2015-01-21 14:36:53',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos',24,'2015-01-14 17:00:57','2015-01-16 09:48:22',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos',25,'2015-01-14 17:02:04','2015-01-16 09:47:37',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos',26,'2015-01-14 17:02:20','2015-05-19 15:10:59',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_modulos',27,'2015-01-14 17:02:39','2015-01-21 14:36:13',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos',28,'2015-01-14 17:03:14','2015-01-21 14:37:22',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos',29,'2015-01-14 17:05:07','2015-07-04 00:40:44',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_modulos',30,'2015-01-14 17:06:44',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_painel_modulos',31,'2015-01-14 17:07:58','2015-05-13 15:44:51',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_modulos',32,'2015-01-14 17:09:35','2015-01-19 13:42:26',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos',33,'2015-01-16 09:36:24','2015-01-19 10:40:21','2015-01-16 09:43:28',-1,'Super Admin',-1,'Super Admin',0,'','::1','::1','::1'),('dl_painel_modulos',34,'2015-01-16 09:36:45','2015-01-19 10:47:23','2015-01-16 09:43:28',-1,'Super Admin',-1,'Super Admin',0,'','::1','::1','::1'),('dl_painel_modulos',35,'2015-01-28 19:35:54','2015-01-28 20:09:05',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_modulos',36,'2015-01-28 23:39:57',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos',37,'2015-03-04 19:33:53','2015-03-04 19:36:39',NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1','::1',NULL),('dl_painel_modulos_funcs',1,'2015-01-24 20:54:37',NULL,'2015-01-24 22:05:01',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',2,'2015-01-24 21:37:12',NULL,'2015-01-24 22:05:07',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',3,'2015-01-24 21:38:36',NULL,'2015-01-24 22:01:59',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',4,'2015-01-24 21:41:15',NULL,'2015-01-24 22:03:08',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',5,'2015-01-24 21:42:07',NULL,'2015-01-24 22:05:21',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',6,'2015-01-24 21:42:25',NULL,'2015-01-24 22:05:18',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',7,'2015-01-24 21:44:46',NULL,'2015-01-24 22:05:15',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',8,'2015-01-24 21:45:32',NULL,'2015-01-24 22:05:13',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',9,'2015-01-24 21:46:57',NULL,'2015-01-24 22:05:10',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',10,'2015-01-24 22:10:53',NULL,'2015-01-24 22:12:43',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',11,'2015-01-24 22:12:34',NULL,'2015-01-26 17:04:00',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',12,'2015-01-24 22:16:13',NULL,'2015-01-26 17:04:03',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',13,'2015-01-24 22:16:55',NULL,'2015-01-26 17:04:05',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',14,'2015-01-24 22:21:36',NULL,'2015-01-26 17:04:08',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',15,'2015-01-24 22:25:31',NULL,'2015-01-26 17:10:24',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',16,'2015-01-24 22:26:07',NULL,'2015-01-26 17:10:26',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',17,'2015-01-24 22:26:23',NULL,'2015-01-26 17:10:29',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',18,'2015-01-24 22:28:26',NULL,'2015-01-26 17:13:19',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',19,'2015-01-24 22:29:22',NULL,'2015-01-26 17:13:22',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',20,'2015-01-24 22:40:22',NULL,'2015-01-26 17:13:26',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',21,'2015-01-24 22:43:50',NULL,'2015-01-26 17:13:28',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',22,'2015-01-24 22:44:33',NULL,'2015-01-26 17:13:32',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',23,'2015-01-24 23:15:34',NULL,'2015-01-26 12:54:38',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',24,'2015-01-24 23:16:13',NULL,'2015-01-26 11:08:11',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',25,'2015-01-24 23:16:26',NULL,'2015-01-26 11:08:07',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',26,'2015-01-26 11:09:06',NULL,'2015-01-26 17:23:28',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',27,'2015-01-26 11:09:26',NULL,'2015-01-26 17:23:31',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',28,'2015-01-26 11:10:33',NULL,'2015-01-26 17:27:53',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',29,'2015-01-26 11:11:04',NULL,'2015-01-26 17:27:47',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',30,'2015-01-26 11:11:49',NULL,'2015-01-26 17:27:50',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',31,'2015-01-26 11:12:36',NULL,'2015-01-26 17:32:14',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',32,'2015-01-26 11:13:22',NULL,'2015-01-26 17:32:11',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',33,'2015-01-26 11:13:45',NULL,'2015-01-26 17:32:09',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',34,'2015-01-26 11:14:15',NULL,'2015-01-26 17:35:23',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',35,'2015-01-26 11:14:43',NULL,'2015-01-26 17:35:27',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',36,'2015-01-26 11:15:04',NULL,'2015-01-26 11:15:08',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',37,'2015-01-26 11:15:26',NULL,'2015-01-26 17:35:30',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',38,'2015-01-26 11:16:00',NULL,'2015-01-26 17:40:55',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',39,'2015-01-26 11:16:38',NULL,'2015-01-26 17:40:49',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',40,'2015-01-26 11:17:10',NULL,'2015-01-26 17:40:52',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',41,'2015-01-26 11:17:38',NULL,'2015-01-26 19:32:37',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',42,'2015-01-26 11:18:34',NULL,'2015-01-26 19:32:40',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',43,'2015-01-26 11:18:54',NULL,'2015-01-26 19:32:33',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',44,'2015-01-26 11:19:47',NULL,'2015-01-26 19:34:45',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',45,'2015-01-26 11:20:32',NULL,'2015-01-26 19:34:38',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',46,'2015-01-26 11:21:09',NULL,'2015-01-26 11:21:14',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',47,'2015-01-26 11:21:30',NULL,'2015-01-26 19:34:42',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',48,'2015-01-26 12:54:57',NULL,'2015-01-26 17:23:25',2,'Diego Lepera',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',49,'2015-01-26 17:05:39',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',50,'2015-01-26 17:08:34',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',51,'2015-01-26 17:09:00',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',52,'2015-01-26 17:09:42',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',53,'2015-01-26 17:11:33',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',54,'2015-01-26 17:12:18',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',55,'2015-01-26 17:12:46',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',56,'2015-01-26 17:19:32',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',57,'2015-01-26 17:20:09',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',58,'2015-01-26 17:21:05',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',59,'2015-01-26 17:21:41',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',60,'2015-01-26 17:22:17',NULL,'2015-01-26 18:13:25',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',61,'2015-01-26 17:23:08',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',62,'2015-01-26 17:25:49',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',63,'2015-01-26 17:26:18',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',64,'2015-01-26 17:26:40',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',65,'2015-01-26 17:29:12',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',66,'2015-01-26 17:29:45',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',67,'2015-01-26 17:30:39',NULL,'2015-01-26 17:30:45',-1,'Super Admin',NULL,'',-1,'Super Admin','::1',NULL,'::1'),('dl_painel_modulos_funcs',68,'2015-01-26 17:31:03',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',69,'2015-01-26 17:31:32',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',70,'2015-01-26 17:31:57',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',71,'2015-01-26 17:32:32',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',72,'2015-01-26 17:32:55',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',73,'2015-01-26 17:34:24',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',74,'2015-01-26 17:35:13',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',75,'2015-01-26 17:36:26',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',76,'2015-01-26 17:36:54',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',77,'2015-01-26 17:37:42',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',78,'2015-01-26 17:38:09',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',79,'2015-01-26 17:38:33',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',80,'2015-01-26 17:41:29',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',81,'2015-01-26 17:41:59',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',82,'2015-01-26 17:42:25',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',83,'2015-01-26 18:13:48',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',84,'2015-01-26 19:33:15',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',85,'2015-01-26 19:33:46',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',86,'2015-01-26 19:34:14',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',87,'2015-01-26 19:35:02',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',88,'2015-01-26 19:35:32',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',89,'2015-01-26 19:35:54',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',90,'2015-01-28 19:40:24',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',91,'2015-01-28 19:42:08',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',92,'2015-01-28 19:42:29',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',93,'2015-01-28 23:40:39',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',94,'2015-01-28 23:41:18',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',95,'2015-01-28 23:41:42',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',96,'2015-03-04 19:34:29',NULL,'2015-05-15 11:53:58',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_modulos_funcs',97,'2015-03-04 19:35:53',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_modulos_funcs',99,'2015-05-13 15:40:11',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_temas',1,'2015-01-08 18:42:13','2015-07-01 10:14:22',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_temas',2,'2015-01-08 19:05:35','2015-07-04 10:19:24','2015-03-26 08:58:25',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_painel_temas',3,'2015-05-14 23:44:07',NULL,'2015-05-15 09:56:04',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_painel_usuarios',1,'2015-01-09 19:39:26','2015-07-19 19:59:04',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_usuarios',2,'2015-01-10 11:54:49','2015-07-27 10:22:45',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_painel_usuarios',3,'2015-01-14 13:32:48','2015-01-26 18:16:01','2015-01-14 13:42:21',-1,'Super Admin',2,'Diego Lepera',0,'','::1','::1','::1'),('dl_painel_usuarios_recuperacoes',2,'2015-01-28 15:47:36',NULL,NULL,0,'',NULL,'',NULL,'','::1',NULL,NULL),('dl_painel_usuarios_recuperacoes',3,'2015-07-14 15:44:07','2015-07-14 16:00:58',NULL,0,'',0,'',NULL,'','::1','::1',NULL),('dl_painel_usuarios_recuperacoes',4,'2015-07-14 16:23:38','2015-07-14 16:32:50',NULL,0,'',0,'',NULL,'','::1','::1',NULL),('dl_painel_usuarios_recuperacoes',5,'2015-07-14 16:33:37','2015-07-14 16:34:00',NULL,0,'',0,'',NULL,'','::1','::1',NULL),('dl_site_albuns',1,'2015-01-12 15:46:49',NULL,'2015-01-12 15:55:33',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_albuns',2,'2015-01-12 15:57:50','2015-07-12 13:26:39',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_albuns',3,'2015-05-15 10:34:09',NULL,'2015-07-05 18:55:58',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns',4,'2015-07-05 18:17:08',NULL,'2015-07-05 18:27:38',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns',5,'2015-07-05 18:30:13',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns',6,'2015-07-05 18:34:46',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',1,'2015-05-29 21:58:58','2015-07-13 20:33:46',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_albuns_fotos',2,'2015-01-20 11:32:47','2015-07-19 15:44:53','2015-06-15 15:51:31',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_albuns_fotos',3,'2015-01-12 21:22:57','2015-07-19 15:45:08','2015-06-15 15:51:34',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_albuns_fotos',4,'2015-01-20 09:55:09','2015-07-26 12:27:00','2015-05-29 21:59:08',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_albuns_fotos',5,'2015-01-20 10:27:31','2015-07-26 12:29:50','2015-06-15 15:51:36',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_albuns_fotos',6,'2015-01-20 09:54:51','2015-01-20 10:39:06','2015-06-15 15:51:38',-1,'Super Admin',-1,'Super Admin',2,'Diego Lepera','::1','::1','::1'),('dl_site_albuns_fotos',7,'2015-05-29 21:59:13',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',8,'2015-01-20 10:03:26',NULL,'2015-05-29 21:59:16',-1,'Super Admin',-1,'Super Admin',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns_fotos',9,'2015-01-26 18:28:02',NULL,'2015-07-01 15:49:46',3,'Editor do WebSite',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns_fotos',10,'2015-01-20 11:32:58','2015-05-15 12:16:05','2015-05-29 22:00:37',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_albuns_fotos',11,'2015-05-15 10:38:09',NULL,'2015-05-29 22:00:34',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns_fotos',16,'2015-07-01 15:50:06',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',20,'2015-07-01 15:50:11',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',21,'2015-07-01 15:50:15',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',25,'2015-07-01 16:00:22',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',26,'2015-07-01 16:00:41',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',27,'2015-07-01 16:00:16',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',28,'2015-07-01 16:00:33',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',29,'2015-07-01 15:57:09',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_albuns_fotos',30,'2015-07-01 15:59:47','2015-07-05 18:14:01',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_albuns_fotos',31,'2015-07-01 16:02:16','2015-07-04 10:07:10',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_albuns_fotos',46,'2015-07-05 18:44:07',NULL,'2015-07-05 18:49:52',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns_fotos',47,'2015-07-05 18:49:02',NULL,'2015-07-05 18:49:54',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns_fotos',48,'2015-07-05 18:49:08',NULL,'2015-07-05 18:49:49',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_albuns_fotos',49,'2015-07-05 18:52:07','2015-07-05 18:54:13','2015-07-05 18:55:42',2,'Diego Lepera',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_assuntos_contato',1,'2015-01-10 20:03:56','2015-01-19 10:47:54','2015-01-19 11:00:42',-1,'Super Admin',-1,'Super Admin',0,'','::1','::1','192.168.2.2'),('dl_site_assuntos_contato',2,'2015-01-10 20:11:14','2015-07-19 18:17:58',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_assuntos_contato',3,'2015-01-10 20:11:38','2015-07-12 13:23:07','2015-01-10 20:11:47',-1,'Super Admin',2,'Diego Lepera',0,'','::1','::1','::1'),('dl_site_assuntos_contato',4,'2015-01-19 10:49:55',NULL,'2015-01-19 10:50:02',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_assuntos_contato',5,'2015-01-19 11:01:11',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','192.168.2.2',NULL,NULL),('dl_site_assuntos_contato',6,'2015-04-30 10:06:14','2015-05-19 16:29:43',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_assuntos_contato',7,'2015-07-04 10:09:57','2015-07-17 21:07:52','2015-07-17 21:07:57',2,'Diego Lepera',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_assuntos_contato',8,'2015-07-17 21:10:31','2015-07-17 21:10:39','2015-07-17 21:10:50',2,'Diego Lepera',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_assuntos_contato',9,'2015-07-17 21:11:04','2015-07-17 21:11:14','2015-07-17 21:11:24',2,'Diego Lepera',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_configuracoes',1,'2015-05-15 10:15:27','2015-07-05 18:59:37',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_contatos',6,'2015-01-06 01:11:36',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',7,'2015-01-06 01:12:14',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',8,'2015-01-06 01:13:07',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',9,'2015-01-06 01:13:28',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',10,'2015-01-06 01:14:35',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',11,'2015-01-06 01:15:26',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',12,'2015-01-06 01:16:30',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',13,'2015-01-06 01:21:07',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',14,'2015-01-06 01:24:58',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',15,'2015-01-06 01:25:19',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',16,'2015-01-06 01:26:37',NULL,'2015-01-10 19:22:49',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',17,'2015-01-06 14:38:31',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',18,'2015-01-06 14:40:26',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',19,'2015-01-06 14:43:04',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',20,'2015-01-06 14:44:26',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',21,'2015-01-06 16:29:00',NULL,'2015-01-20 15:08:46',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',22,'2015-01-06 16:34:56',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',23,'2015-01-06 16:35:07',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',24,'2015-01-06 16:36:24',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',25,'2015-01-06 16:36:43',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',26,'2015-01-06 16:37:21',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',27,'2015-01-06 16:37:59',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',28,'2015-01-06 17:14:04',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',29,'2015-01-06 17:19:35',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',30,'2015-01-06 17:20:06',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',31,'2015-01-06 17:21:40',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',32,'2015-01-06 17:26:23',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',33,'2015-01-06 17:27:59',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',34,'2015-01-06 17:28:29',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',35,'2015-01-06 17:28:54',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',36,'2015-01-06 17:29:09',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',37,'2015-01-06 17:29:37',NULL,'2015-01-20 14:55:42',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',38,'2015-01-06 17:30:08',NULL,'2015-01-20 14:55:42',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',39,'2015-01-06 17:30:29',NULL,'2015-01-20 14:55:42',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',40,'2015-01-06 17:30:50',NULL,'2015-01-20 14:55:42',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',41,'2015-01-06 17:31:12',NULL,'2015-01-20 14:55:42',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',42,'2015-01-06 17:31:41',NULL,'2015-01-20 14:55:42',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',43,'2015-01-06 17:32:17',NULL,'2015-01-20 14:55:42',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',44,'2015-01-06 17:33:22',NULL,'2015-01-20 14:55:25',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',45,'2015-01-06 17:33:39',NULL,'2015-01-20 14:55:25',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',46,'2015-01-06 17:34:38',NULL,'2015-01-20 14:54:52',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',47,'2015-01-06 17:36:35',NULL,'2015-01-20 14:54:52',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',48,'2015-01-06 17:48:04',NULL,'2015-01-20 14:54:52',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',49,'2015-01-06 17:49:47',NULL,'2015-01-20 14:54:52',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',50,'2015-01-06 18:04:10',NULL,'2015-01-20 14:55:17',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',51,'2015-01-06 19:48:50',NULL,'2015-01-20 14:55:17',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',52,'2015-01-06 19:50:48',NULL,'2015-01-20 14:55:17',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',53,'2015-01-06 19:51:12',NULL,'2015-01-20 14:55:17',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',54,'2015-01-06 19:51:47',NULL,'2015-01-20 14:55:17',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',55,'2015-01-06 19:52:03',NULL,'2015-01-20 14:55:17',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',56,'2015-01-06 19:52:19',NULL,'2015-01-20 14:55:17',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',57,'2015-01-06 19:52:39',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',58,'2015-01-06 19:53:43',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',59,'2015-01-06 19:53:56',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',60,'2015-01-06 19:54:27',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',61,'2015-01-06 19:54:52',NULL,'2015-01-20 14:58:48',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',62,'2015-01-06 19:57:00',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',63,'2015-01-06 19:57:15',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',64,'2015-01-06 20:10:55',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',65,'2015-01-06 20:12:06',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',66,'2015-01-06 20:12:37',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',67,'2015-01-06 20:18:23',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',68,'2015-01-07 14:06:56',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',69,'2015-01-07 14:07:53',NULL,'2015-01-20 14:56:10',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',70,'2015-01-20 15:08:26',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_site_contatos',71,'2015-01-20 15:24:32',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_site_contatos',72,'2015-01-20 15:28:40',NULL,'2015-01-21 10:54:26',-1,'Super Admin',-1,'Super Admin',0,'','::1',NULL,'::1'),('dl_site_contatos',73,'2015-01-20 18:04:08',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_site_contatos',74,'2015-01-20 18:04:43',NULL,'2015-07-27 13:59:15',-1,'Super Admin',-1,'Super Admin',2,'Diego Lepera','::1',NULL,'10.8.2.221'),('dl_site_contatos',75,'2015-01-20 18:05:28',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_site_contatos',76,'2015-01-20 18:05:57','2015-05-15 11:41:19','2015-05-01 15:59:56',-1,'Super Admin',0,'',2,'Diego Lepera','::1','::1','::1'),('dl_site_contatos',77,'2015-05-27 18:26:01',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_site_contatos',78,'2015-05-27 18:34:00',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_site_contatos',79,'2015-05-27 18:36:57',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_site_contatos',80,'2015-05-27 18:40:06','2015-07-25 22:23:50','2015-07-05 18:59:49',0,'',0,'',2,'Diego Lepera','127.0.0.2','::1','::1'),('dl_site_contatos',81,'2015-05-27 18:40:37','2015-07-25 22:24:32','2015-07-05 18:59:49',0,'',0,'',2,'Diego Lepera','127.0.0.2','::1','::1'),('dl_site_contatos',82,'2015-05-27 18:42:23','2015-07-26 10:18:44','2015-07-05 18:59:49',0,'',0,'',2,'Diego Lepera','127.0.0.2','::1','::1'),('dl_site_contatos',83,'2015-05-27 18:44:17','2015-07-27 14:57:28','2015-07-01 12:10:43',0,'',0,'',2,'Diego Lepera','127.0.0.2','::1','::1'),('dl_site_contatos',84,'2015-05-27 18:46:55','2015-07-27 15:17:00','2015-07-01 12:10:43',0,'',0,'',2,'Diego Lepera','127.0.0.2','::1','::1'),('dl_site_contatos',85,'2015-05-27 18:48:03','2015-07-27 15:17:46','2015-07-01 12:10:33',0,'',0,'',2,'Diego Lepera','127.0.0.2','::1','::1'),('dl_site_contatos',86,'2015-05-27 18:50:07','2015-07-27 15:33:35','2015-07-01 12:10:33',0,'',0,'',2,'Diego Lepera','127.0.0.2','::1','::1'),('dl_site_contatos',87,'2015-05-27 18:50:32',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_site_contatos',88,'2015-05-27 18:51:48',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_site_contatos',89,'2015-05-27 23:06:06',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_site_contatos',90,'2015-05-28 00:11:01',NULL,NULL,0,'',NULL,'',NULL,'','127.0.0.2',NULL,NULL),('dl_site_contatos_leitura',1,'2015-02-10 12:58:48',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',9,'2015-02-10 13:12:53',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',10,'2015-02-11 15:19:47',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',11,'2015-02-16 11:48:23',NULL,NULL,-1,'Super Admin',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',12,'2015-05-01 14:52:21',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',13,'2015-05-14 10:31:58',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',14,'2015-05-15 11:41:43',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',15,'2015-05-27 23:30:57','2015-07-19 16:51:23',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','127.0.0.2','::1',NULL),('dl_site_contatos_leitura',16,'2015-07-27 13:47:46',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',17,'2015-07-27 13:59:05',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','10.8.2.221',NULL,NULL),('dl_site_contatos_leitura',18,'2015-07-27 14:57:56',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_contatos_leitura',19,'2015-07-27 15:18:09',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_dados_contato',1,'2015-01-12 09:39:43','2015-05-14 10:57:20',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_dados_contato',2,'2015-01-12 10:14:16','2015-01-17 13:46:07','2015-01-12 10:15:17',-1,'Super Admin',-1,'Super Admin',0,'','::1','::1','::1'),('dl_site_dados_contato',3,'2015-02-10 14:41:09',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_dados_contato',4,'2015-05-15 10:42:26','2015-05-15 10:43:33',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_dados_contato',5,'2015-07-05 19:01:00',NULL,'2015-07-05 19:03:21',2,'Diego Lepera',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_dados_contato_tipos',1,'2015-02-10 14:42:07','2015-02-10 14:42:50',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_dados_contato_tipos',2,'2015-02-10 13:46:22','2015-02-10 14:42:33',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_dados_contato_tipos',3,'2015-02-10 14:43:36',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_dados_contato_tipos',4,'2015-07-28 08:56:20','2015-07-28 08:56:52',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_dados_contato_tipos',5,'2015-02-10 16:07:28','2015-07-14 16:41:15',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_dados_contato_tipos',6,'2015-07-14 16:41:31','2015-07-28 08:13:46',NULL,2,'Diego Lepera',2,'Diego Lepera',NULL,'','::1','::1',NULL),('dl_site_dados_contato_tipos',7,'2015-07-14 16:41:41',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_dados_contato_tipos',8,'2015-07-14 16:40:49',NULL,NULL,2,'Diego Lepera',NULL,'',NULL,'','::1',NULL,NULL),('dl_site_dados_contato_tipos',10,'2015-01-11 16:46:40','2015-07-05 19:01:33','2015-07-14 16:41:01',-1,'Super Admin',2,'Diego Lepera',2,'Diego Lepera','::1','::1','::1'),('dl_site_dados_contato_tipos',11,'2015-01-29 08:57:30',NULL,'2015-01-29 09:10:07',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_dados_contato_tipos',12,'2015-01-29 08:57:42',NULL,'2015-01-29 09:10:07',-1,'Super Admin',NULL,'',2,'Diego Lepera','::1',NULL,'::1'),('dl_site_google_analytics',1,'2015-01-11 17:48:13',NULL,NULL,-1,'Super Admin',-1,'Super Admin',NULL,'','::1',NULL,NULL),('dl_site_institucional',1,'2015-03-04 19:58:09','2015-05-27 23:34:59',NULL,-1,'Super Admin',2,'Diego Lepera',NULL,'','::1','127.0.0.2',NULL);
/*!40000 ALTER TABLE `dl_painel_registros_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_temas`
--

DROP TABLE IF EXISTS `dl_painel_temas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_temas` (
  `tema_id` int(11) NOT NULL AUTO_INCREMENT,
  `tema_descr` varchar(20) NOT NULL,
  `tema_diretorio` varchar(10) NOT NULL,
  `tema_padrao` tinyint(1) NOT NULL DEFAULT '0',
  `tema_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `tema_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_temas`
--

LOCK TABLES `dl_painel_temas` WRITE;
/*!40000 ALTER TABLE `dl_painel_temas` DISABLE KEYS */;
INSERT INTO `dl_painel_temas` VALUES (1,'Painel-DL 3','painel-dl',0,1,0),(2,'Painel-DL 3.2','painel-dl3',1,1,0);
/*!40000 ALTER TABLE `dl_painel_temas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_usuarios`
--

DROP TABLE IF EXISTS `dl_painel_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_info_grupo` int(11) NOT NULL,
  `usuario_info_nome` varchar(50) NOT NULL,
  `usuario_info_email` varchar(100) NOT NULL,
  `usuario_info_telefone` varchar(16) DEFAULT NULL,
  `usuario_info_sexo` char(1) NOT NULL,
  `usuario_info_login` varchar(20) NOT NULL,
  `usuario_info_senha` varchar(32) NOT NULL,
  `usuario_pref_idioma` int(11) NOT NULL DEFAULT '1',
  `usuario_pref_tema` int(11) NOT NULL DEFAULT '1',
  `usuario_pref_formato_data` int(11) NOT NULL DEFAULT '1',
  `usuario_pref_num_registros` int(11) NOT NULL DEFAULT '20',
  `usuario_pref_exibir_id` tinyint(1) NOT NULL DEFAULT '1',
  `usuario_pref_filtro_menu` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_conf_bloq` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_conf_reset` tinyint(1) NOT NULL DEFAULT '0',
  `usuario_perfil_foto` varchar(255) DEFAULT NULL,
  `usuario_ultimo_login` datetime NOT NULL,
  `usuario_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_info_email` (`usuario_info_email`),
  UNIQUE KEY `usuario_info_login` (`usuario_info_login`),
  KEY `FK_usuario_info_grupo` (`usuario_info_grupo`),
  KEY `FK_usuario_pref_idioma` (`usuario_pref_idioma`),
  KEY `FK_usuario_pref_tema` (`usuario_pref_tema`),
  KEY `FK_usuario_pref_formato_data` (`usuario_pref_formato_data`),
  CONSTRAINT `FK_usuario_info_grupo` FOREIGN KEY (`usuario_info_grupo`) REFERENCES `dl_painel_grupos_usuarios` (`grupo_usuario_id`),
  CONSTRAINT `FK_usuario_pref_formato_data` FOREIGN KEY (`usuario_pref_formato_data`) REFERENCES `dl_painel_formatos_data` (`formato_data_id`),
  CONSTRAINT `FK_usuario_pref_idioma` FOREIGN KEY (`usuario_pref_idioma`) REFERENCES `dl_painel_idiomas` (`idioma_id`),
  CONSTRAINT `FK_usuario_pref_tema` FOREIGN KEY (`usuario_pref_tema`) REFERENCES `dl_painel_temas` (`tema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_painel_usuarios`
--

LOCK TABLES `dl_painel_usuarios` WRITE;
/*!40000 ALTER TABLE `dl_painel_usuarios` DISABLE KEYS */;
INSERT INTO `dl_painel_usuarios` VALUES (1,1,'Administrador','dlepera88@gmail.com','(61) 8350-3517','M','admin','29dec529c33a3f746e2d5a1bacf50ea1',1,1,1,5,0,1,0,0,'/web/imgs/usuario-sem-foto.png','0000-00-00 00:00:00',0),(2,3,'Diego Lepera','d_lepera@hotmail.com','','M','diego.lepera','29dec529c33a3f746e2d5a1bacf50ea1',1,2,1,5,1,1,0,0,'/web/uploads/usuarios/diego-lepera.jpg','2015-07-27 14:53:09',0),(3,2,'Editor do WebSite','dlepera88@yahoo.com.br','','M','editor.website','29dec529c33a3f746e2d5a1bacf50ea1',1,1,1,20,1,0,0,0,'/web/imgs/usuario-sem-foto.png','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `dl_painel_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_painel_usuarios_recuperacoes`
--

DROP TABLE IF EXISTS `dl_painel_usuarios_recuperacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_painel_usuarios_recuperacoes` (
  `recuperacao_id` int(11) NOT NULL AUTO_INCREMENT,
  `recuperacao_usuario` int(11) NOT NULL,
  `recuperacao_hash` varchar(32) NOT NULL,
  `recuperacao_status` char(1) DEFAULT 'E',
  PRIMARY KEY (`recuperacao_id`),
  UNIQUE KEY `recuperacao_hash` (`recuperacao_hash`),
  KEY `FK_recuperacao_usuario` (`recuperacao_usuario`),
  CONSTRAINT `FK_recuperacao_usuario` FOREIGN KEY (`recuperacao_usuario`) REFERENCES `dl_painel_usuarios` (`usuario_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dl_site_albuns`
--

DROP TABLE IF EXISTS `dl_site_albuns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_albuns` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_nome` varchar(50) NOT NULL,
  `album_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `album_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dl_site_albuns_fotos`
--

DROP TABLE IF EXISTS `dl_site_albuns_fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_albuns_fotos` (
  `foto_album` int(11) NOT NULL,
  `foto_album_id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_album_titulo` varchar(50) DEFAULT NULL,
  `foto_album_descr` text,
  `foto_album_imagem` text NOT NULL,
  `foto_album_capa` tinyint(1) NOT NULL DEFAULT '0',
  `foto_album_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `foto_album_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`foto_album_id`),
  KEY `FK_foto_album` (`foto_album`),
  CONSTRAINT `FK_foto_album` FOREIGN KEY (`foto_album`) REFERENCES `dl_site_albuns` (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dl_site_assuntos_contato`
--

DROP TABLE IF EXISTS `dl_site_assuntos_contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_assuntos_contato` (
  `assunto_contato_id` int(11) NOT NULL AUTO_INCREMENT,
  `assunto_contato_descr` varchar(80) NOT NULL,
  `assunto_contato_email` varchar(100) NOT NULL,
  `assunto_contato_cor` varchar(7) NOT NULL DEFAULT '#000',
  `assunto_contato_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `assunto_contato_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`assunto_contato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_assuntos_contato`
--

LOCK TABLES `dl_site_assuntos_contato` WRITE;
/*!40000 ALTER TABLE `dl_site_assuntos_contato` DISABLE KEYS */;
INSERT INTO `dl_site_assuntos_contato` VALUES (2,'Elogios','dlepera88@gmail.com','#009193',1,0),(3,'Dúvidas','dlepera88@gmail.com','#7a81ff',1,0),(5,'Reclamações','dlepera88@gmail.com','#ff0000',1,0),(6,'Outros','dlepera88@gmail.com','#797979',1,0);
/*!40000 ALTER TABLE `dl_site_assuntos_contato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_site_configuracoes`
--

DROP TABLE IF EXISTS `dl_site_configuracoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_configuracoes` (
  `configuracao_id` int(11) NOT NULL,
  `configuracao_tema` int(11) NOT NULL DEFAULT '1',
  `configuracao_formato_data` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`configuracao_id`),
  KEY `FK_configuracao_tema` (`configuracao_tema`),
  KEY `FK_configuracao_formato_data` (`configuracao_formato_data`),
  CONSTRAINT `FK_configuracao_formato_data` FOREIGN KEY (`configuracao_formato_data`) REFERENCES `dl_painel_formatos_data` (`formato_data_id`),
  CONSTRAINT `FK_configuracao_tema` FOREIGN KEY (`configuracao_tema`) REFERENCES `dl_painel_temas` (`tema_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_configuracoes`
--

LOCK TABLES `dl_site_configuracoes` WRITE;
/*!40000 ALTER TABLE `dl_site_configuracoes` DISABLE KEYS */;
INSERT INTO `dl_site_configuracoes` VALUES (0,1,1),(1,2,1);
/*!40000 ALTER TABLE `dl_site_configuracoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_site_contatos`
--

DROP TABLE IF EXISTS `dl_site_contatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_contatos` (
  `contato_site_id` int(11) NOT NULL AUTO_INCREMENT,
  `contato_site_nome` varchar(80) NOT NULL,
  `contato_site_email` varchar(100) NOT NULL,
  `contato_site_telefone` varchar(16) DEFAULT NULL,
  `contato_site_assunto` int(11) DEFAULT NULL,
  `contato_site_mensagem` longtext NOT NULL,
  `contato_site_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`contato_site_id`),
  KEY `FK_contato_site_assunto` (`contato_site_assunto`),
  CONSTRAINT `FK_contato_site_assunto` FOREIGN KEY (`contato_site_assunto`) REFERENCES `dl_site_assuntos_contato` (`assunto_contato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dl_site_contatos_leitura`
--

DROP TABLE IF EXISTS `dl_site_contatos_leitura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_contatos_leitura` (
  `leitura_contato` int(11) NOT NULL,
  `leitura_contato_id` int(11) NOT NULL AUTO_INCREMENT,
  `leitura_contato_usuario` int(11) NOT NULL,
  `leitura_contato_data` datetime NOT NULL,
  PRIMARY KEY (`leitura_contato_id`),
  UNIQUE KEY `leitura_contato` (`leitura_contato`,`leitura_contato_usuario`),
  CONSTRAINT `FK_leitura_contato` FOREIGN KEY (`leitura_contato`) REFERENCES `dl_site_contatos` (`contato_site_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dl_site_dados_contato`
--

DROP TABLE IF EXISTS `dl_site_dados_contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_dados_contato` (
  `dado_contato_id` int(11) NOT NULL AUTO_INCREMENT,
  `dado_contato_tipo` int(11) NOT NULL,
  `dado_contato_descr` varchar(100) NOT NULL,
  `dado_contato_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `dado_contato_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dado_contato_id`),
  KEY `FK_dado_contato_tipo` (`dado_contato_tipo`),
  CONSTRAINT `FK_dado_contato_tipo` FOREIGN KEY (`dado_contato_tipo`) REFERENCES `dl_site_dados_contato_tipos` (`tipo_dado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dl_site_dados_contato_tipos`
--

DROP TABLE IF EXISTS `dl_site_dados_contato_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_dados_contato_tipos` (
  `tipo_dado_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_dado_descr` varchar(30) NOT NULL,
  `tipo_dado_icone` varchar(255) DEFAULT NULL,
  `tipo_dado_rede_social` tinyint(1) NOT NULL DEFAULT '0',
  `tipo_dado_mascara` varchar(100) DEFAULT NULL,
  `tipo_dado_expreg` varchar(200) DEFAULT NULL,
  `tipo_dado_publicar` tinyint(1) NOT NULL DEFAULT '1',
  `tipo_dado_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tipo_dado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_dados_contato_tipos`
--

LOCK TABLES `dl_site_dados_contato_tipos` WRITE;
/*!40000 ALTER TABLE `dl_site_dados_contato_tipos` DISABLE KEYS */;
INSERT INTO `dl_site_dados_contato_tipos` VALUES (1,'Fone fixo',NULL,0,'(##) ####-####','^\\([0-9]{2}\\)\\s{1}[2-5]{1}[0-9]{3}\\-[0-9]{4}$',1,0),(2,'Fone celular',NULL,0,'(##) ####-####','^\\([0-9]{2}\\)\\s{1}[6-9]{1}[0-9]{3}\\-[0-9]{4}$',1,0),(3,'Fone comercial',NULL,0,'(##) ####-####','^\\([0-9]{2}\\)\\s{1}[2-9]{1}[0-9]{3}\\-[0-9]{4}$',1,0),(4,'E-mail',NULL,0,'','',1,0),(5,'Facebook','/web/uploads/contatos/facebook.png',1,'https://facebook.com/############','^(https://facebook.com/)([a-z0-9\\.\\-]+)$',1,0),(6,'Google Plus','/web/uploads/contatos/google+.png',1,'undefined','undefined',1,0),(7,'Instagram','/web/uploads/contatos/instagram.png',1,'','',1,0),(8,'Twitter','/web/uploads/contatos/twitter.png',1,'','',1,0),(9,'Youtube','/web/uploads/contatos/youtube.png',0,NULL,NULL,1,0);
/*!40000 ALTER TABLE `dl_site_dados_contato_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_site_google_analytics`
--

DROP TABLE IF EXISTS `dl_site_google_analytics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_google_analytics` (
  `ga_id` int(11) NOT NULL AUTO_INCREMENT,
  `ga_apelido` varchar(100) DEFAULT NULL,
  `ga_usuario` varchar(100) NOT NULL,
  `ga_senha` varchar(100) NOT NULL,
  `ga_perfil_id` int(11) NOT NULL,
  `ga_codigo_ua` varchar(15) NOT NULL,
  `ga_principal` tinyint(1) NOT NULL DEFAULT '0',
  `ga_delete` tinyint(1) NOT NULL DEFAULT '0',
  `ga_publicar` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ga_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dl_site_institucional`
--

DROP TABLE IF EXISTS `dl_site_institucional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_institucional` (
  `instit_id` int(11) NOT NULL AUTO_INCREMENT,
  `instit_historia` longtext,
  `instit_missao` longtext,
  `instit_visao` longtext,
  `instit_valores` longtext,
  `instit_publicar` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`instit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_institucional`
--

LOCK TABLES `dl_site_institucional` WRITE;
/*!40000 ALTER TABLE `dl_site_institucional` DISABLE KEYS */;
INSERT INTO `dl_site_institucional` VALUES (1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',0);
/*!40000 ALTER TABLE `dl_site_institucional` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-28 17:47:34
