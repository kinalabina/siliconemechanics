-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (i686)
--
-- Host: mysql1.cak3sdr7sm6p.us-west-2.rds.amazonaws.com    Database: ride_log
-- ------------------------------------------------------
-- Server version	5.5.27-log

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
-- Table structure for table `bike`
--

DROP TABLE IF EXISTS `bike`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bike` (
  `bike_id` int(11) NOT NULL AUTO_INCREMENT,
  `style_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model` varchar(45) DEFAULT NULL,
  `nickname` varchar(45) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bike_id`),
  KEY `fk_new_table_1_idx` (`style_id`),
  KEY `fk_new_table_2_idx` (`brand_id`),
  KEY `fk_bike_1_idx` (`owner_id`),
  CONSTRAINT `fk_bike_1` FOREIGN KEY (`owner_id`) REFERENCES `rider` (`rider_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_new_table_1` FOREIGN KEY (`style_id`) REFERENCES `style` (`style_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_new_table_2` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bike`
--

LOCK TABLES `bike` WRITE;
/*!40000 ALTER TABLE `bike` DISABLE KEYS */;
INSERT INTO `bike` VALUES (1,1,2,'Bottle Rocket','my mountain bike',1),(2,3,4,'Speedster','my 3 Speed',1),(5,4,3,'C\'Mute','my touring bike',1),(6,5,7,'','the Water Buffalo',1),(7,6,1,'','my purple fixie',1),(8,7,5,'Grand Prix','the Raleigh',1),(9,8,1,'','the tandem',1),(10,9,8,'Antelope','Bobs Trek',2);
/*!40000 ALTER TABLE `bike` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'Unknown'),(2,'Transition'),(3,'Pake'),(4,'Schwinn'),(5,'Raleigh'),(6,'Humber'),(7,'Apollo'),(8,'Trek'),(9,'Specialized');
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride`
--

DROP TABLE IF EXISTS `ride`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ride` (
  `ride_id` int(11) NOT NULL AUTO_INCREMENT,
  `bike_id` int(11) NOT NULL,
  `rider_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `distance` int(11) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ride_id`),
  KEY `fk_ride_1_idx` (`rider_id`),
  KEY `fk_ride_2_idx` (`bike_id`),
  CONSTRAINT `fk_ride_1` FOREIGN KEY (`rider_id`) REFERENCES `rider` (`rider_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ride_2` FOREIGN KEY (`bike_id`) REFERENCES `bike` (`bike_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride`
--

LOCK TABLES `ride` WRITE;
/*!40000 ALTER TABLE `ride` DISABLE KEYS */;
INSERT INTO `ride` VALUES (1,6,1,'2014-02-15 00:00:00','2014-02-15 00:00:00',10,'fun one'),(2,5,2,'2014-01-13 00:00:00','2014-01-13 00:00:00',35,'long one'),(3,9,3,'2013-12-31 00:00:00',NULL,22,''),(7,7,5,'2014-03-22 00:00:00','0000-00-00 00:00:00',65,'Port Townsend'),(8,6,4,'2014-02-28 00:00:00',NULL,45,'Anacortes'),(9,10,2,'2014-04-13 00:00:00',NULL,8,'early morning ride');
/*!40000 ALTER TABLE `ride` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider`
--

DROP TABLE IF EXISTS `rider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rider` (
  `rider_id` int(11) NOT NULL AUTO_INCREMENT,
  `rider_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`rider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider`
--

LOCK TABLES `rider` WRITE;
/*!40000 ALTER TABLE `rider` DISABLE KEYS */;
INSERT INTO `rider` VALUES (1,'Victor'),(2,'Bob'),(3,'Sally'),(4,'Sarah'),(5,'Fred');
/*!40000 ALTER TABLE `rider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `style`
--

DROP TABLE IF EXISTS `style`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `style` (
  `style_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`style_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `style`
--

LOCK TABLES `style` WRITE;
/*!40000 ALTER TABLE `style` DISABLE KEYS */;
INSERT INTO `style` VALUES (1,'downhill mt. bike'),(2,'road bike'),(3,'cruiser'),(4,'touring bike'),(5,'single speed'),(6,'fixie'),(7,'vintage'),(8,'tandem'),(9,'hybrid');
/*!40000 ALTER TABLE `style` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-30  0:03:47
