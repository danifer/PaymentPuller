-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: paymentpuller
-- ------------------------------------------------------
-- Server version	5.1.49-3

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
-- Table structure for table `authorize_net_batch`
--

DROP TABLE IF EXISTS `authorize_net_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authorize_net_batch` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `batch_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `settlement_time_utc` datetime DEFAULT NULL,
  `settlement_time_local` datetime DEFAULT NULL,
  `settlement_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authorize_net_batch`
--

LOCK TABLES `authorize_net_batch` WRITE;
/*!40000 ALTER TABLE `authorize_net_batch` DISABLE KEYS */;
/*!40000 ALTER TABLE `authorize_net_batch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authorize_net_transaction`
--

DROP TABLE IF EXISTS `authorize_net_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authorize_net_transaction` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `batch_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submit_time_utc` datetime DEFAULT NULL,
  `submit_time_local` datetime DEFAULT NULL,
  `transaction_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `settle_amount` float(18,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authorize_net_transaction`
--

LOCK TABLES `authorize_net_transaction` WRITE;
/*!40000 ALTER TABLE `authorize_net_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `authorize_net_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paypal_transaction`
--

DROP TABLE IF EXISTS `paypal_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paypal_transaction` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timestamp` datetime DEFAULT NULL,
  `timezone` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` float(18,2) DEFAULT NULL,
  `currency_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee_amount` float(18,2) DEFAULT NULL,
  `net_amount` float(18,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paypal_transaction`
--

LOCK TABLES `paypal_transaction` WRITE;
/*!40000 ALTER TABLE `paypal_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `paypal_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variable`
--

DROP TABLE IF EXISTS `variable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variable` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variable`
--

LOCK TABLES `variable` WRITE;
/*!40000 ALTER TABLE `variable` DISABLE KEYS */;
/*!40000 ALTER TABLE `variable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-20 23:19:38
