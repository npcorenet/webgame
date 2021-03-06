-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-1:10.3.34+maria~focal-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Account`
--

DROP TABLE IF EXISTS `Account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `registered` datetime NOT NULL,
  `type` int(11) NOT NULL DEFAULT 3,
  `level` int(11) NOT NULL DEFAULT 1,
  `experience` int(11) NOT NULL DEFAULT 0,
  `coins` bigint(11) NOT NULL DEFAULT 0,
  `diamonds` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `Type_FK` (`type`),
  CONSTRAINT `Type_FK` FOREIGN KEY (`type`) REFERENCES `AccountType` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Account`
--

--
-- Table structure for table `AccountType`
--

DROP TABLE IF EXISTS `AccountType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AccountType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AccountType`
--

LOCK TABLES `AccountType` WRITE;
/*!40000 ALTER TABLE `AccountType` DISABLE KEYS */;
INSERT INTO `AccountType` VALUES (1,'Admin'),(2,'Moderator'),(3,'User');
/*!40000 ALTER TABLE `AccountType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Area`
--

DROP TABLE IF EXISTS `Area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `minlevel` int(11) NOT NULL,
  `buildTime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Area`
--

LOCK TABLES `Area` WRITE;
/*!40000 ALTER TABLE `Area` DISABLE KEYS */;
INSERT INTO `Area` VALUES (1,'Wald','Aus dem Wald bekommst du Nahrung und Holz',0,0),(2,'Fluss','Aus dem Fluss kannst du Fische aber auch seltene Items angeln',0,0),(3,'Mine','Aus der Mine bekommst du Metalle sowie Stein',1,43200);
/*!40000 ALTER TABLE `Area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AreaAccount`
--

DROP TABLE IF EXISTS `AreaAccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AreaAccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `areaId` int(11) NOT NULL,
  `unlocked` datetime NOT NULL,
  `blockedUntil` datetime NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `experience` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `areaId` (`areaId`),
  KEY `accountId` (`userId`),
  CONSTRAINT `accountId` FOREIGN KEY (`userId`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `areaId` FOREIGN KEY (`areaId`) REFERENCES `Area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `AreaEarning`
--

DROP TABLE IF EXISTS `AreaEarning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AreaEarning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Account_FK` (`userId`),
  KEY `Item_FK` (`itemId`),
  KEY `Area_FK` (`areaId`),
  CONSTRAINT `Account_FK` FOREIGN KEY (`userId`) REFERENCES `Account` (`id`),
  CONSTRAINT `Area_FK` FOREIGN KEY (`areaId`) REFERENCES `AreaAccount` (`id`),
  CONSTRAINT `Item_FK` FOREIGN KEY (`itemId`) REFERENCES `Item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AreaEarning`
--

LOCK TABLES `AreaEarning` WRITE;
/*!40000 ALTER TABLE `AreaEarning` DISABLE KEYS */;
/*!40000 ALTER TABLE `AreaEarning` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Inventory`
--

DROP TABLE IF EXISTS `Inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `itemId` (`itemId`),
  KEY `userId` (`userId`),
  CONSTRAINT `itemId` FOREIGN KEY (`itemId`) REFERENCES `Item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userId` FOREIGN KEY (`userId`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Item`
--

DROP TABLE IF EXISTS `Item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `iconUrl` text NOT NULL,
  `statpoint` int(11) NOT NULL,
  `typeId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typeId` (`typeId`),
  CONSTRAINT `typeId` FOREIGN KEY (`typeId`) REFERENCES `ItemType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Item`
--

LOCK TABLES `Item` WRITE;
/*!40000 ALTER TABLE `Item` DISABLE KEYS */;
INSERT INTO `Item` VALUES (-4,'Bereich / Geb??ude Erfahrungspunkte','Die Erfahrungspunkte f??r Geb??ude oder Bereiche','',0,8),(-3,'Erfahrungspunkte','Erfahrungspunkte f??r den Spieler','',0,8),(-2,'Diamanten','Diamanten sind die Sekund??rw??hrung des Spiels','',0,8),(-1,'M??nzen','M??nzen sind die Hauptw??hrung im Spiel','',0,8),(1,'Holzkohle','Kohle wird aus der Mine gef??rdert. Diese kann ab dem Minenlevel 1 gef??rdert werden. ','',1,3),(2,'Holz','Wird aus dem Wald gef??rdert und ist Grundbaustoff f??r verschiedene Werkzeuge','',1,3),(3,'Stein','Wird aus der Mine gef??rdert und wird f??r den Aufbau neuer Geb??ude erfordert.\r\nNebenprodukt anderer gef??rderter Materialien','',1,3),(4,'Kupfer','Kohle wird aus der Mine gef??rdert. Diese kann ab dem Level 3 gef??rdert werden und kann vom Schmied ab Level 2 verarbeitet werden','',1,3),(5,'Bronze','Bronze wird aus der Mine gef??rdert. Diese kann ab dem Level 3 gef??rdert werden und kann vom Schmied ab Level 2 varbeitet werden ','',1,3),(6,'Metall','Metall wird aus der Mine gef??rdert. Diese kann ab dem Level 5 gef??rdert werden und kann vom Schmied ab Level 4 verarbeitet werden','',1,3),(7,'Eisen','Metall wird aus der Minegef??rdert. Diese kann ab dem Level 8 gef??rdert werden und kann vom Schmied ab Level 6 verarbeitet werden','',1,3),(8,'Gold','Metall wird aus der Mine gef??rdert. Diese kann ab dem Level 10 gef??rdert werden und kann vom Schmied ab Level  verarbeitet werden','',1,3),(9,'Holzschwert','Das einfachste Schwert, welches als einziges im Shop erh??ltlich ist','',1,4),(10,'Kupferschwert','Das g??nstigste Schwert, welches selbst hergestellt wird','',1,4),(11,'Bronze','Ein teures Schwert, welches es aufgrund der F??rderkosten nicht wert ist','',1,4),(12,'Metall','Das bessere Bronzeschwert, nur dass es aus Metall ist','',1,4),(13,'Eisenschwert','Ein Schwert aus Eisen, welches sehr effektiv einzusetzen ist','',1,4),(14,'Gold','Ein Schwert, welches aus Gold besteht.','',1,4),(15,'Lederr??stung','Die simpelste R??stung, welche im Shop erh??ltlich ist.','',1,5),(16,'Holzr??stung','Eine R??stung aus Holz. Keine Ahnung warum man das machen sollte.','',1,5),(17,'Kupferr??stung','Eine R??stung aus Kupfer, welche sich deutlich mehr lohnt als die aus Holz','',1,5),(18,'Bronzer??stung','Es gibt keinen Grund diese R??stung herzustellen, da diese zu hohe F??rder und Verarbeitungskosten hat','',1,5),(19,'Metallr??stung','Die bessere Bronzer??stung, ernsthaft ','',1,5),(20,'Eisenr??stung','Eine R??stung aus Eisen, welche mehr als eine Ber??hrung mit dem kleinen Finger aush??lt','',1,5),(21,'Goldr??stung','Eine R??stung aus Gold, welche sich genau so wenig lohnt wie die Bronzer??stung','',1,5);
/*!40000 ALTER TABLE `Item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ItemType`
--

DROP TABLE IF EXISTS `ItemType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemType`
--

LOCK TABLES `ItemType` WRITE;
/*!40000 ALTER TABLE `ItemType` DISABLE KEYS */;
INSERT INTO `ItemType` VALUES (1,'Spitzhacke'),(2,'Axt'),(3,'Rohstoffe'),(4,'Schwerter'),(5,'R??stung'),(6,'Nahrung'),(7,'Verbrauchsg??ter'),(8,'Placeholder Items');
/*!40000 ALTER TABLE `ItemType` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-20 11:52:40
