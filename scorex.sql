-- Progettazione Web 
DROP DATABASE if exists scorex; 
CREATE DATABASE scorex; 
USE scorex; 
-- MySQL dump 10.13  Distrib 5.6.20, for Win32 (x86)
--
-- Host: localhost    Database: scorex
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `field`
--

DROP TABLE IF EXISTS `field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field` (
  `fieldId` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `descrizione` varchar(4096) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `poster` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `indirizzo` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `cap` int(11) NOT NULL,
  `citta` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `telefono` varchar(11) NOT NULL,
  PRIMARY KEY (`fieldId`)
) ENGINE=InnoDB AUTO_INCREMENT=1007 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field`
--

LOCK TABLES `field` WRITE;
/*!40000 ALTER TABLE `field` DISABLE KEYS */;
INSERT INTO `field` VALUES (1000,'CUS Pisa, Centro Universitario Sportivo','Campi Disponibili da 0 a 4 bellissimi davvero belli','../css/images/fields/campo1000.jpg','Via Federico Chiarugi, 5',56123,'Pisa','05046155'),(1001,'DLF, Dopo Lavoro Ferroviario','Campi all aperto, erba sintetica','../css/images/fields/campo1001.jpg','Piazza della Stazione, 16',56125,'Pisa','05086158'),(1002,'CEP, Circolo Arci','Campo in erba sintetica','N/A','Via Umberto Giordano',56122,'Pisa','05045665'),(1003,'Circolo Arci Alhambra','Campi al chiuso e all aperto','../css/images/fields/campo1003.jpg','Via Enrico Fermi, 27',56126,'Pisa','05086775'),(1004,'Planet Football','Campi al chiuso su parquet','../css/images/fields/campo1004.jpg','Via S. Iacopo 117',56122,'Pisa','050555021'),(1005,'Centro Sportivo GES I Passi','Campi al chiuso su parquet','N/A','Via Galiani 1',56123,'Pisa','05046155'),(1006,'La Cella','Campi al chiuso su parquet','N/A','Via Fiorentina 167',56020,'Pisa','3454266753');
/*!40000 ALTER TABLE `field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_schedule`
--

DROP TABLE IF EXISTS `field_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field_schedule` (
  `scheduleId` int(11) NOT NULL AUTO_INCREMENT,
  `fieldId` int(11) NOT NULL,
  `Monday` tinyint(1) DEFAULT NULL,
  `Tuesday` tinyint(1) DEFAULT NULL,
  `Wednesday` tinyint(1) DEFAULT NULL,
  `Thursday` tinyint(1) DEFAULT NULL,
  `Friday` tinyint(1) DEFAULT NULL,
  `Saturday` tinyint(1) DEFAULT NULL,
  `Sunday` tinyint(1) DEFAULT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  PRIMARY KEY (`scheduleId`)
) ENGINE=InnoDB AUTO_INCREMENT=1014 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_schedule`
--

LOCK TABLES `field_schedule` WRITE;
/*!40000 ALTER TABLE `field_schedule` DISABLE KEYS */;
INSERT INTO `field_schedule` VALUES (1000,1000,1,1,1,1,1,0,0,10,23),(1001,1000,0,0,0,0,0,1,1,12,23),(1002,1001,1,1,1,1,1,0,0,10,23),(1003,1001,0,0,0,0,0,1,1,12,23),(1004,1002,1,1,1,1,1,0,0,10,23),(1005,1002,0,0,0,0,0,1,1,12,23),(1006,1003,1,1,1,1,1,0,0,10,23),(1007,1003,0,0,0,0,0,1,1,12,23),(1008,1004,1,1,1,1,1,0,0,10,23),(1009,1004,0,0,0,0,0,1,1,12,23),(1010,1005,1,1,1,1,1,0,0,10,23),(1011,1005,0,0,0,0,0,1,1,12,23),(1012,1006,1,1,1,1,1,0,0,10,23),(1013,1006,0,0,0,0,0,1,1,12,23);
/*!40000 ALTER TABLE `field_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `my_field`
--

DROP TABLE IF EXISTS `my_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `fieldId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `my_field_pair` (`userId`,`fieldId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_field`
--

LOCK TABLES `my_field` WRITE;
/*!40000 ALTER TABLE `my_field` DISABLE KEYS */;
INSERT INTO `my_field` VALUES (10,1,1000);
/*!40000 ALTER TABLE `my_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prenotazione`
--

DROP TABLE IF EXISTS `prenotazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prenotazione` (
  `idPrenotazione` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `fieldId` int(11) NOT NULL,
  `dataP` date NOT NULL,
  `dalle` int(2) NOT NULL,
  `alle` int(2) NOT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`idPrenotazione`),
  UNIQUE KEY `idPrenotazione_UNIQUE` (`idPrenotazione`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prenotazione`
--

LOCK TABLES `prenotazione` WRITE;
/*!40000 ALTER TABLE `prenotazione` DISABLE KEYS */;
INSERT INTO `prenotazione` VALUES (100,1,1000,'2020-08-08',15,16,'3338382143'),(101,1,1001,'2020-08-08',15,16,'3338382143'),(102,1,1002,'2020-08-09',15,16,'3338382143'),(103,1,1003,'2020-08-10',15,16,'3338382143'),(104,2,1000,'2020-08-09',15,16,'3338382143'),(105,2,1001,'2020-08-09',15,16,'3338382143'),(106,2,1002,'2020-08-10',15,16,'3338382143'),(107,2,1003,'2020-08-11',15,16,'3338382143');
/*!40000 ALTER TABLE `prenotazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `idReview` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `fieldId` int(11) NOT NULL,
  `IdPrenotazione` int(11) NOT NULL,
  `rating` int(2) NOT NULL,
  `dataR` date NOT NULL,
  `reviewTitle` varchar(100) DEFAULT NULL,
  `review` text,
  PRIMARY KEY (`idReview`),
  UNIQUE KEY `idReview_UNIQUE` (`idReview`)
) ENGINE=InnoDB AUTO_INCREMENT=1016 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (1000,1,1000,101,5,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1001,2,1000,102,4,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1002,3,1000,103,3,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1003,4,1000,104,5,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1004,5,1000,105,5,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1005,6,1000,106,4,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1006,7,1000,107,5,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1007,8,1000,108,4,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1008,1,1001,101,3,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1009,2,1001,102,4,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1010,3,1001,103,3,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1011,4,1001,104,1,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1012,5,1001,105,2,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1013,6,1001,106,3,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1014,7,1001,107,5,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto'),(1015,8,1001,108,4,'2020-08-05','Campo Molto Bello','Ottimo manto erboso, illuminazione non perfetta, prezzo onesto');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userType` varchar(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'socio','pippo','pippo@gmail.com','3338382143','0c88028bf3aa6a6a143ed846f2be1ea4'),(2,'cliente','pluto','pluto@ymail.com','3236382693','pluto'),(3,'cliente','john92','john92@hotmail.it','3398682113','john92'),(4,'cliente','mark_71','m.mark@gmail.com','3138782159','mark_71'),(5,'cliente','Fefuzz','fefuzz97@gmail.com','3368322173','Fefuzz'),(6,'cliente','paperino','paperino@disney.com','3328392143','paperino'),(7,'cliente','minny_52','minny_52@disney.com','3548362883','minny_52'),(8,'cliente','test','test@test.com','3230322153','test'),(9,'cliente','pweb','pweb@pweb.com','3394362500','pweb');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_field`
--

DROP TABLE IF EXISTS `user_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `fieldId` int(11) NOT NULL,
  `favorite` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `user_field_pair` (`userId`,`fieldId`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_field`
--

LOCK TABLES `user_field` WRITE;
/*!40000 ALTER TABLE `user_field` DISABLE KEYS */;
INSERT INTO `user_field` VALUES (142,1,1000,0),(143,1,1001,0),(144,1,1002,1),(145,1,1003,1);
/*!40000 ALTER TABLE `user_field` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-25 10:01:11
