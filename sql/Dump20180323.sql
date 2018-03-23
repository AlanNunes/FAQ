-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: localhost    Database: faq
-- ------------------------------------------------------
-- Server version	5.7.14

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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `categoriaId` int(11) NOT NULL AUTO_INCREMENT,
  `categoriaNome` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`categoriaId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Login'),(2,'Integração');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perguntas`
--

DROP TABLE IF EXISTS `perguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perguntas` (
  `perguntaId` int(11) NOT NULL AUTO_INCREMENT,
  `perguntaConteudo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `respostaId` int(11) DEFAULT NULL,
  `categoriaId` int(11) DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`perguntaId`),
  KEY `categoriaId` (`categoriaId`),
  KEY `respostaId` (`respostaId`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perguntas`
--

LOCK TABLES `perguntas` WRITE;
/*!40000 ALTER TABLE `perguntas` DISABLE KEYS */;
INSERT INTO `perguntas` VALUES (1,'Estou com dificuldades para acessor o NEAD',1,1,NULL,NULL,NULL),(2,'Mudei de curso, como faço para receber as mudanças dele no NEAD',2,2,NULL,NULL,NULL),(3,'Esqueci minha senha do Portal UGB',3,1,NULL,NULL,NULL),(22,'Ao contrário do que se acredita, Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina clássica datada de 45 AC. Richard McClintock, um professor de latim do Hampden-Sydney College na Virginia, pesquisou uma das mais obscuras palavras em latim, consectetur, oriunda de uma passagem de Lorem Ipsum, e, procurando por entre citações da palavra na literatura clássica, descobriu a sua indubitável origem. Lorem Ipsum vem das seções 1.10.32 e 1.10.33 do &quot;de Finibus Bonorum et Malorum&quot; (Os Extremos do Bem e do Mal), de Cícero, escrito em 45 AC. Este livro é um tratado de teoria da ética muito popular na época da Renascença. A primeira linha de Lorem Ipsum, &quot;Lorem Ipsum dolor sit amet...&quot; vem de uma linha na seção 1.10.32.',NULL,NULL,'Alan Nunes da Silva','alannunes@ugb.edu.br','2018-03-22'),(21,'Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado. Se popularizou na década de 60, quando a Letraset lançou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editoração eletrônica como Aldus PageMaker.',NULL,NULL,'Alan Nunes da Silva','alannunes@ugb.edu.br','2018-03-22'),(23,'pergunta teste',NULL,1,'','','2018-03-22'),(24,'Cê acredita ?',NULL,1,'','','2018-03-23'),(25,'Cê acredita Brandão ?',NULL,2,'','','2018-03-23'),(26,'Posso testar o som ?',NULL,2,'','','2018-03-23'),(27,'Quer melon ?',NULL,2,'Guy Campos de Britto','guybrito@ugb.edu.br','2018-03-23'),(28,'Quer paçoca ?',4,2,'Guy Campos de Britto','guybrito@ugb.edu.br','2018-03-23');
/*!40000 ALTER TABLE `perguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respostas`
--

DROP TABLE IF EXISTS `respostas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respostas` (
  `respostaId` int(11) NOT NULL AUTO_INCREMENT,
  `respostaConteudo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `data` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`respostaId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respostas`
--

LOCK TABLES `respostas` WRITE;
/*!40000 ALTER TABLE `respostas` DISABLE KEYS */;
INSERT INTO `respostas` VALUES (1,'Para acessar o Portal EaD, você deve primeiro ter seu número de matrícula em mãos... DJFDFdfdkjfgksljgçsdgujewçolgfijewógfiweógiweógkwegjgo',NULL,NULL,NULL),(2,'Nós já estamos cientes da situação, o processo deve demorar no máximo 1 dia para ser realizado.',NULL,NULL,NULL),(3,'Basta clicar em \"Esqueci minha senha\" no botão inferior.',NULL,NULL,NULL),(4,'Quero sim !','guybrito@ugb.edu.br','Guy Campos de Britto','2018-03-23');
/*!40000 ALTER TABLE `respostas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userNome` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userEmail` varchar(255) CHARACTER SET utf8 NOT NULL,
  `userSenha` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Guy Campos de Britto','guybrito@ugb.edu.br','A665A45920422F9D417E4867EFDC4FB8A04A1F3FFF1FA07E998E86F7F7A27AE3');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-23 12:56:25
