CREATE DATABASE  IF NOT EXISTS `AList` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `AList`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: 127.0.0.1    Database: AList
-- ------------------------------------------------------
-- Server version	5.5.29

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
-- Table structure for table `Brands`
--

DROP TABLE IF EXISTS `Brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `allowAnyOne` int(11) DEFAULT NULL COMMENT '(1=yes,0=no)\n',
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Brands`
--

LOCK TABLES `Brands` WRITE;
/*!40000 ALTER TABLE `Brands` DISABLE KEYS */;
INSERT INTO `Brands` VALUES (1,'Mori Sushi','ddddd','http://www.google.com',1,'uploads/48561730152016150'),(2,'Tamara','ddd2','http://www.google.com',0,'https://s3.amazonaws.com/mo4x/stores/tamara.jpg'),(3,'Mince','dd3','http://www.google.com',1,'https://s3.amazonaws.com/mo4x/stores/mince.jpg'),(4,'Nola Cupcakes','dd4','http://www.google.com',0,'https://s3.amazonaws.com/mo4x/stores/nola.jpg'),(5,'Cake','dd5','http://www.google.com',1,'https://s3.amazonaws.com/mo4x/stores/cake.jpg'),(6,'Zooba','ddd6','http://www.google.com',0,'https://s3.amazonaws.com/mo4x/stores/zooba.jpg'),(7,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fName` varchar(255) DEFAULT NULL,
  `lName` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `fbToken` text,
  `isAdmin` int(11) DEFAULT '0',
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (3,'Mohamed','Sakr','https://scontent.xx.fbcdn.net/hprofile-xtf1/v/t1.0-1/p50x50/12002866_10153694624863969_6948848645625206165_n.jpg?oh=c52718943eaa0d8d29ac9bee2858943e&oe=5779CD08','mssakr@hotmail.com','01003601016','CAAMokEFnU3QBAMf5AWUbxZBEGB8uHSiZAsEv3lZCiCV8FS8dUr9ZBuVUAVGvxzZAy6m34KlTH81SwWgkqoxKrFtkPlQZA3yXvmEaxQSl8NRa1Jh5ZCV9obqomAhjpj4EroZC93Lnn6ZCnOClMe5nOli6JxaXXb37Ge4OZCxx79CjV0vCN481tb6hLix4Jq4pZBhktuAu3f6TfrhvVbD3ziUHNYNdA7B3rnwl2wZD',1,'0000-00-00 00:00:00'),(5,'Ahmed','Mohsen','https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xlt1/v/t1.0-1/p50x50/6287_10154958084200397_2045027033619205831_n.jpg?oh=43d8852c4d2cdd5f14646c4dfcad2a0a&oe=57E39C59&__gda__=1469682964_fa0b6efe28cd3d4525b180b17beaefa5','rpm@aucegypt.edu','01200400347','EAAMokEFnU3QBADkiJRMNkRNCyXoGZBShGfP7ncayZBhVB3V7N74SvSNUS2rfz3H6C61AuZBtqZCTs0U6rPbv5ZCR25QoIhiLEGDhDGs3rgeOCrl07QagljKNwZBZAnZAkqFeLrUu8r2Q2PQMRyGfEXh7VmFd566U01u28bQvLeJIV0ndbihGJMicgBFXMHaAZBlkqSb0CETvJCQZDZD',0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `owner_brand_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `obi_idx` (`owner_brand_id`),
  CONSTRAINT `obi` FOREIGN KEY (`owner_brand_id`) REFERENCES `Brands` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` VALUES (2,'aa',3),(14,'aaa',1),(15,'adamteat',1);
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mangers_user_branads`
--

DROP TABLE IF EXISTS `mangers_user_branads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mangers_user_branads` (
  `id_user` int(11) NOT NULL,
  `id_brand` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_brand`),
  KEY `ub_idx` (`id_user`),
  KEY `uu_idx` (`id_brand`),
  CONSTRAINT `ub` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `uu` FOREIGN KEY (`id_brand`) REFERENCES `Brands` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mangers_user_branads`
--

LOCK TABLES `mangers_user_branads` WRITE;
/*!40000 ALTER TABLE `mangers_user_branads` DISABLE KEYS */;
INSERT INTO `mangers_user_branads` VALUES (3,1);
/*!40000 ALTER TABLE `mangers_user_branads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages_user_brands`
--

DROP TABLE IF EXISTS `messages_user_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages_user_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) DEFAULT NULL COMMENT '(1 user , 2 brand)',
  `date` timestamp NULL DEFAULT NULL,
  `message_type` int(11) DEFAULT NULL COMMENT '(1=text,2=image,3=alboum,4=video)',
  `message_data` text,
  `id_user` int(11) DEFAULT NULL,
  `id_brand` int(11) DEFAULT NULL,
  `g_id` int(11) DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `af11_idx` (`id_user`),
  KEY `af22_idx` (`id_brand`),
  CONSTRAINT `af11` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `af22` FOREIGN KEY (`id_brand`) REFERENCES `Brands` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages_user_brands`
--

LOCK TABLES `messages_user_brands` WRITE;
/*!40000 ALTER TABLE `messages_user_brands` DISABLE KEYS */;
INSERT INTO `messages_user_brands` VALUES (13,1,'2016-04-24 09:48:57',2,'http://localhost:8888/Alist/getImage.php?imgPath=uploads/57481124042016114',3,1,-1),(14,1,'2016-04-24 09:49:09',1,'Assassins',3,1,-1),(16,2,'2016-05-15 14:30:21',1,'Aaaaa',5,1,14),(17,2,'2016-05-15 14:30:46',3,'http://192.168.1.11:8888/Alist/getImage.php?imgPath=',5,1,14),(18,2,'2016-05-15 14:30:50',3,'http://192.168.1.11:8888/Alist/getImage.php?imgPath=',5,1,14),(19,2,'2016-05-15 14:31:06',2,'http://192.168.1.11:8888/Alist/getImage.php?imgPath=uploads/6311615052016135',5,1,14),(20,2,'2016-05-15 14:32:43',1,'Help ',5,1,15),(21,2,'2016-05-15 14:34:26',3,'http://192.168.1.11:8888/Alist/getImage.php?imgPath=uploads/25341615052016135,http://192.168.1.11:8888/Alist/getImage.php?imgPath=uploads/26341615052016135',5,1,15),(22,1,'2016-05-30 14:59:22',1,'High',3,1,-1),(23,1,'2016-05-30 15:01:28',1,'Hhh',3,2,-1),(24,1,'2016-05-30 15:02:49',3,'http://localhost:8888/Alist/getImage.php?imgPath=uploads/4821730152016150,http://localhost:8888/Alist/getImage.php?imgPath=uploads/4821730152016150,http://localhost:8888/Alist/getImage.php?imgPath=uploads/4921730152016150',3,1,-1),(25,1,'2016-05-30 15:06:35',1,'Iii',3,1,-1),(26,1,'2016-05-30 15:13:44',2,'http://localhost:8888/Alist/getImage.php?imgPath=uploads/2121730152016150',3,1,-1),(27,1,'2016-05-30 15:14:21',3,'http://localhost:8888/Alist/getImage.php?imgPath=uploads/54131730152016150,http://localhost:8888/Alist/getImage.php?imgPath=uploads/59131730152016150',3,1,-1),(28,2,'2016-05-30 15:41:07',1,'Asa',3,1,-1);
/*!40000 ALTER TABLE `messages_user_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificationss`
--

DROP TABLE IF EXISTS `notificationss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificationss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `notifi_type` int(11) DEFAULT NULL COMMENT '(1=newMessage,2=BrandApproved,3=url)',
  `notifi_data` text,
  `seen` int(11) DEFAULT '0' COMMENT '1 yes\n0 no',
  PRIMARY KEY (`id`),
  KEY `u_idx` (`id_user`),
  CONSTRAINT `uss` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificationss`
--

LOCK TABLES `notificationss` WRITE;
/*!40000 ALTER TABLE `notificationss` DISABLE KEYS */;
INSERT INTO `notificationss` VALUES (1,3,'0000-00-00 00:00:00',1,'1',0),(2,3,'0000-00-00 00:00:00',2,'1',0),(3,3,'0000-00-00 00:00:00',1,'2',0);
/*!40000 ALTER TABLE `notificationss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_user_brand`
--

DROP TABLE IF EXISTS `status_user_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_user_brand` (
  `id_user` int(11) NOT NULL,
  `id_brand` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT '(0=following,1=pending,2=notFollowing)\n',
  PRIMARY KEY (`id_user`,`id_brand`),
  KEY `u_idx` (`id_user`),
  KEY `b_idx` (`id_brand`),
  CONSTRAINT `b` FOREIGN KEY (`id_brand`) REFERENCES `Brands` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `u` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_user_brand`
--

LOCK TABLES `status_user_brand` WRITE;
/*!40000 ALTER TABLE `status_user_brand` DISABLE KEYS */;
INSERT INTO `status_user_brand` VALUES (3,1,0),(3,2,0),(5,1,0),(5,2,1);
/*!40000 ALTER TABLE `status_user_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_auth` (
  `id_user` int(11) NOT NULL,
  `accessToken` text,
  `expires_date` timestamp NULL DEFAULT NULL,
  `pushToken` varchar(512) DEFAULT NULL,
  `deviceType` int(11) DEFAULT NULL COMMENT '2 android\n3 iOS',
  PRIMARY KEY (`id_user`),
  CONSTRAINT `asa` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_auth`
--

LOCK TABLES `user_auth` WRITE;
/*!40000 ALTER TABLE `user_auth` DISABLE KEYS */;
INSERT INTO `user_auth` VALUES (3,'4a4b3cfeb809217dd6ef22d52eb764b7','2016-06-29 15:56:43',NULL,NULL),(5,'a40b9bc618374f72168c36e1cf1f3663','2016-06-14 14:23:51',NULL,NULL);
/*!40000 ALTER TABLE `user_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_in_group`
--

DROP TABLE IF EXISTS `users_in_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_in_group` (
  `id_group` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_group`,`id_user`),
  KEY `iug_idx` (`id_user`),
  KEY `igg_idx` (`id_group`),
  CONSTRAINT `igg` FOREIGN KEY (`id_group`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `iug` FOREIGN KEY (`id_user`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_in_group`
--

LOCK TABLES `users_in_group` WRITE;
/*!40000 ALTER TABLE `users_in_group` DISABLE KEYS */;
INSERT INTO `users_in_group` VALUES (14,5),(15,5);
/*!40000 ALTER TABLE `users_in_group` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-02 16:27:37
