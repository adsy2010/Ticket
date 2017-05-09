-- MySQL dump 10.13  Distrib 5.7.18, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: test
-- ------------------------------------------------------
-- Server version	5.7.18-log

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
-- Table structure for table `authusers`
--

DROP TABLE IF EXISTS `authusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authusers` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `emailAddress` varchar(128) DEFAULT NULL,
  `serviceDesk` int(11) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `authusers_userID_uindex` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cartridge`
--

DROP TABLE IF EXISTS `cartridge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cartridge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `printerId` int(11) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `color` varchar(24) DEFAULT NULL,
  `stock` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cartridge_id_uindex` (`id`),
  UNIQUE KEY `cartridge_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cartridgelog`
--

DROP TABLE IF EXISTS `cartridgelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cartridgelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cartridgeId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `actionedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cost` double DEFAULT NULL,
  `archived` int(11) DEFAULT NULL,
  `costDept` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cartridgeLog_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT NULL,
  `desk` int(11) DEFAULT NULL,
  `statusType` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_department_uindex` (`department`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `desks`
--

DROP TABLE IF EXISTS `desks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `desks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `desks_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `printer`
--

DROP TABLE IF EXISTS `printer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make` varchar(64) DEFAULT NULL,
  `model` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `printer_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servicestatus`
--

DROP TABLE IF EXISTS `servicestatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicestatus` (
  `name` varchar(128) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  UNIQUE KEY `serviceStatus_name_uindex` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `situatedprinter`
--

DROP TABLE IF EXISTS `situatedprinter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `situatedprinter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printerId` int(11) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `exemption` int(11) DEFAULT '0',
  `costingdepartment` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ticketcomments`
--

DROP TABLE IF EXISTS `ticketcomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(24) DEFAULT NULL,
  `logId` int(11) DEFAULT NULL,
  `commentDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` blob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticketComments_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `assignedTo` int(11) DEFAULT NULL,
  `closedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` blob,
  `contentType` varchar(64) DEFAULT NULL,
  `department` varchar(32) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `loggedBy` varchar(32) DEFAULT NULL,
  `serviceDesk` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ticketDatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `closedBy` varchar(12) DEFAULT NULL,
  `closedWhy` varchar(256) DEFAULT NULL,
  `closedReason` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT '1',
  PRIMARY KEY (`logId`),
  UNIQUE KEY `tickets_logId_uindex` (`logId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-09 10:00:10
