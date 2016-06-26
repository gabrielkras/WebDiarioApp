-- MySQL dump 10.13  Distrib 5.6.31, for Linux (x86_64)
--
-- Host: localhost    Database: web_diario
-- ------------------------------------------------------
-- Server version	5.6.31

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
-- Table structure for table `classroom`
--

DROP TABLE IF EXISTS `classroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_497D309D591CC992` (`course_id`),
  KEY `IDX_497D309D23EDC87` (`subject_id`),
  KEY `IDX_497D309D7D2D84D5` (`professor_id`),
  CONSTRAINT `FK_497D309D23EDC87` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  CONSTRAINT `FK_497D309D591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `FK_497D309D7D2D84D5` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classroom`
--

LOCK TABLES `classroom` WRITE;
/*!40000 ALTER TABLE `classroom` DISABLE KEYS */;
INSERT INTO `classroom` VALUES (1,1,1,8,2016,0,1),(2,1,2,2,2016,0,1),(3,1,3,3,2016,0,1),(4,1,3,4,2016,0,1),(5,1,4,5,2016,0,1),(6,1,5,6,2016,0,1),(7,1,5,7,2016,0,1),(8,1,6,1,2016,0,1);
/*!40000 ALTER TABLE `classroom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classroom_students`
--

DROP TABLE IF EXISTS `classroom_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classroom_students` (
  `student_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`classroom_id`),
  KEY `IDX_9156D489CB944F1A` (`student_id`),
  KEY `IDX_9156D4896278D5A8` (`classroom_id`),
  CONSTRAINT `FK_9156D4896278D5A8` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`id`),
  CONSTRAINT `FK_9156D489CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classroom_students`
--

LOCK TABLES `classroom_students` WRITE;
/*!40000 ALTER TABLE `classroom_students` DISABLE KEYS */;
INSERT INTO `classroom_students` VALUES (1,1),(1,2),(1,3),(1,5),(1,6),(1,8),(2,1),(2,2),(2,4),(2,5),(2,7),(2,8);
/*!40000 ALTER TABLE `classroom_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `time_code` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Tecnologia em Análise e Desenvolvimento de Sistemas','TADS','CMP-TADS',2);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fouls`
--

DROP TABLE IF EXISTS `fouls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fouls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E16B3C336278D5A8` (`classroom_id`),
  KEY `IDX_E16B3C33CB944F1A` (`student_id`),
  CONSTRAINT `FK_E16B3C336278D5A8` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`id`),
  CONSTRAINT `FK_E16B3C33CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fouls`
--

LOCK TABLES `fouls` WRITE;
/*!40000 ALTER TABLE `fouls` DISABLE KEYS */;
/*!40000 ALTER TABLE `fouls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professors`
--

DROP TABLE IF EXISTS `professors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registry` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status_code` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professors`
--

LOCK TABLES `professors` WRITE;
/*!40000 ALTER TABLE `professors` DISABLE KEYS */;
INSERT INTO `professors` VALUES (1,'tiago','e10adc3949ba59abbe56e057f20f883e','Tiago Carvalho',1),(2,'pedro','e10adc3949ba59abbe56e057f20f883e','Pedro Fantinatti',1),(3,'andreiwid','e10adc3949ba59abbe56e057f20f883e','Andreiwid Sheffer Correa',1),(4,'americo','e10adc3949ba59abbe56e057f20f883e','José Américo dos Santos Mendonça',1),(5,'alencar','e10adc3949ba59abbe56e057f20f883e','Alencar Melo Junior',1),(6,'sovat','e10adc3949ba59abbe56e057f20f883e','Ricardo Barz Sovat',1),(7,'celso','e10adc3949ba59abbe56e057f20f883e','Celso',1),(8,'andre','e10adc3949ba59abbe56e057f20f883e','Andre Valenti',1);
/*!40000 ALTER TABLE `professors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registry` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status_code` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'135025-1','e10adc3949ba59abbe56e057f20f883e','Gabriel Sousa Kraszczuk',1),(2,'135020-x','e10adc3949ba59abbe56e057f20f883e','Bruno Belotti',1);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB259917591CC992` (`course_id`),
  CONSTRAINT `FK_AB259917591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,1,'Desenvolvimento de Sistemas Web','DSW6'),(2,1,'Empreendedorismo','EMP6'),(3,1,'Programação para Dispositivos Móveis','PDM6'),(4,1,'Projeto de Sistemas II','PSII6'),(5,1,'Segurança da Informação','SGI6'),(6,1,'Tópicos Especiais','TPE6');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `tokens` int(11) NOT NULL AUTO_INCREMENT,
  `professor_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `expire` datetime NOT NULL,
  PRIMARY KEY (`tokens`),
  UNIQUE KEY `UNIQ_AA5A118E7D2D84D5` (`professor_id`),
  UNIQUE KEY `UNIQ_AA5A118ECB944F1A` (`student_id`),
  CONSTRAINT `FK_AA5A118E7D2D84D5` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`id`),
  CONSTRAINT `FK_AA5A118ECB944F1A` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
INSERT INTO `tokens` VALUES (1,NULL,2,'A695CFD2FBCF7A32248EF8D3F7817904','2016-06-26 01:05:21','2016-06-26 02:05:21'),(2,8,NULL,'8AE4BEA39CA89D70AFD8C041BC05353B','2016-06-26 01:10:35','2016-06-26 02:10:35'),(3,3,NULL,'1727342C48B8C9CFCDA148BC3DE97BAD','2016-06-26 01:14:14','2016-06-26 02:14:14'),(4,2,NULL,'FED380AED05DC2FFF18D47924BA0C643','2016-06-26 01:17:47','2016-06-26 02:17:47'),(7,NULL,1,'8EF83D49BCDA694C61D6EFD665CF7DA8','2016-06-26 03:19:48','2016-06-26 04:19:48');
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-26  3:25:05
