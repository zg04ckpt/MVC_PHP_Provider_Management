CREATE DATABASE  IF NOT EXISTS `bt3php` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bt3php`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bt3php
-- ------------------------------------------------------
-- Server version	8.0.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `contracts`
--

DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contracts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `signed_date` datetime NOT NULL,
  `expire_date` datetime NOT NULL,
  `contract_url` varchar(255) NOT NULL,
  `provider_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contract_provider_idx` (`provider_id`),
  CONSTRAINT `FK_contract_provider` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contracts`
--

LOCK TABLES `contracts` WRITE;
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;
INSERT INTO `contracts` VALUES (1,'2024-01-01 10:00:00','2025-01-01 10:00:00','https://contracts.com/techsolutions.pdf',1),(2,'2024-01-02 10:00:00','2025-01-02 10:00:00','https://contracts.com/cloudinnovate.pdf',2),(3,'2024-01-03 10:00:00','2025-01-03 10:00:00','https://contracts.com/digitalboost.pdf',3),(4,'2024-01-04 10:00:00','2025-01-04 10:00:00','https://contracts.com/appcreators.pdf',4),(5,'2024-01-05 10:00:00','2025-01-05 10:00:00','https://contracts.com/designstudio.pdf',5),(6,'2024-01-06 10:00:00','2025-01-06 10:00:00','https://contracts.com/itexperts.pdf',6),(7,'2024-01-07 10:00:00','2025-01-07 10:00:00','https://contracts.com/securenet.pdf',7),(8,'2024-01-08 10:00:00','2025-01-08 10:00:00','https://contracts.com/datainsights.pdf',8),(9,'2024-01-09 10:00:00','2025-01-09 10:00:00','https://contracts.com/crmsolutions.pdf',9),(10,'2024-01-10 10:00:00','2025-01-10 10:00:00','https://contracts.com/marketingpros.pdf',10),(11,'2024-01-11 10:00:00','2025-01-11 10:00:00','https://contracts.com/webinnovators.pdf',11),(12,'2024-01-12 10:00:00','2025-01-12 10:00:00','https://contracts.com/cloudexperts.pdf',12),(13,'2024-01-13 10:00:00','2025-01-13 10:00:00','https://contracts.com/seomasters.pdf',13),(14,'2024-01-14 10:00:00','2025-01-14 10:00:00','https://contracts.com/mobileinnovate.pdf',14),(15,'2024-01-15 10:00:00','2025-01-15 10:00:00','https://contracts.com/creativedesigns.pdf',15),(16,'2024-01-16 10:00:00','2025-01-16 10:00:00','https://contracts.com/techadvisors.pdf',16),(17,'2024-01-17 10:00:00','2025-01-17 10:00:00','https://contracts.com/securesolutions.pdf',17),(18,'2024-01-18 10:00:00','2025-01-18 10:00:00','https://contracts.com/dataexperts.pdf',18),(19,'2024-01-19 10:00:00','2025-01-19 10:00:00','https://contracts.com/crmexperts.pdf',19),(20,'2024-01-20 10:00:00','2025-01-20 10:00:00','https://contracts.com/marketingexperts.pdf',20);
/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `provide_deadline` datetime NOT NULL,
  `paid_date` datetime DEFAULT NULL,
  `currency` varchar(15) NOT NULL,
  `vat` float NOT NULL,
  `user_id` int NOT NULL,
  `provider_id` int NOT NULL,
  `service_id` int NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `unit` varchar(45) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_bill_users_idx` (`user_id`),
  KEY `fk_bills_providers1_idx` (`provider_id`),
  KEY `fk_orders_services1_idx` (`service_id`),
  CONSTRAINT `FK_bill_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_bills_providers1` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`),
  CONSTRAINT `fk_orders_services1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'Order 001','Thiết kế website bán hàng','paid','2025-01-01 08:00:00','2025-02-01 08:00:00','2025-01-15 08:00:00','VND',10,1,1,1,5000000.00,'Dự án',1),(2,'Order 002','Lưu trữ đám mây 1 năm','wait','2025-01-03 09:00:00','2025-03-03 09:00:00',NULL,'VND',10,1,2,2,1200000.00,'Tháng',12),(3,'Order 003','Tối ưu SEO từ khóa','wait_pay','2025-01-05 10:00:00','2025-02-15 10:00:00',NULL,'VND',10,1,3,3,3000000.00,'Dịch vụ',1),(4,'Order 004','Phát triển app iOS','paid','2025-01-07 11:00:00','2025-02-20 11:00:00','2025-01-20 11:00:00','VND',10,1,4,4,15000000.00,'Dự án',1),(5,'Order 005','Chiến dịch quảng cáo FB','wait','2025-01-09 12:00:00','2025-01-25 12:00:00',NULL,'VND',10,1,10,5,4000000.00,'Chiến dịch',1),(6,'Order 006','Tư vấn CNTT doanh nghiệp','wait_pay','2025-01-11 13:00:00','2025-02-10 13:00:00',NULL,'VND',10,1,6,6,5000000.00,'Giờ',10),(7,'Order 007','Thiết kế logo thương hiệu','paid','2025-01-13 14:00:00','2025-02-05 14:00:00','2025-01-25 14:00:00','VND',10,1,5,7,1500000.00,'Sản phẩm',2),(8,'Order 008','Phân tích dữ liệu bán hàng','wait','2025-01-15 15:00:00','2025-02-15 15:00:00',NULL,'VND',10,1,8,8,2000000.00,'Báo cáo',1),(9,'Order 009','Bảo mật hệ thống mạng','wait_pay','2025-01-17 16:00:00','2025-03-01 16:00:00',NULL,'VND',10,1,7,9,3500000.00,'Dịch vụ',1),(10,'Order 010','Triển khai CRM','paid','2025-01-19 17:00:00','2025-03-10 17:00:00','2025-02-01 17:00:00','VND',10,1,9,10,8000000.00,'Dự án',1),(11,'Order 011','Thiết kế website doanh nghiệp','wait','2025-01-21 08:00:00','2025-02-20 08:00:00',NULL,'VND',10,1,11,1,6000000.00,'Dự án',1),(12,'Order 012','Dịch vụ cloud 6 tháng','wait_pay','2025-01-23 09:00:00','2025-03-01 09:00:00',NULL,'VND',10,1,12,2,720000.00,'Tháng',6),(13,'Order 013','Tối ưu SEO website','paid','2025-01-25 10:00:00','2025-03-05 10:00:00','2025-02-05 10:00:00','VND',10,1,13,3,3200000.00,'Dịch vụ',1),(14,'Order 014','Phát triển app Android','wait','2025-01-27 11:00:00','2025-03-10 11:00:00',NULL,'VND',10,1,14,4,14000000.00,'Dự án',1),(15,'Order 015','Quảng cáo Google Ads','wait_pay','2025-01-29 12:00:00','2025-02-15 12:00:00',NULL,'VND',10,1,20,5,4500000.00,'Chiến dịch',1),(16,'Order 016','Tư vấn giải pháp CNTT','paid','2025-01-31 13:00:00','2025-03-01 13:00:00','2025-02-10 13:00:00','VND',10,1,16,6,4400000.00,'Giờ',8),(17,'Order 017','Thiết kế banner quảng cáo','wait','2025-02-02 14:00:00','2025-02-25 14:00:00',NULL,'VND',10,1,15,7,2100000.00,'Sản phẩm',3),(18,'Order 018','Phân tích dữ liệu kinh doanh','wait_pay','2025-02-04 15:00:00','2025-03-05 15:00:00',NULL,'VND',10,1,18,8,2500000.00,'Báo cáo',1),(19,'Order 019','Cải thiện bảo mật website','paid','2025-02-06 16:00:00','2025-03-15 16:00:00','2025-02-20 16:00:00','VND',10,1,17,9,4000000.00,'Dịch vụ',1),(20,'Order 020','Triển khai phần mềm CRM','wait','2025-02-08 17:00:00','2025-04-01 17:00:00',NULL,'VND',10,1,19,10,9000000.00,'Dự án',1),(21,'Order 021','Thiết kế website thương mại','wait_pay','2025-02-10 08:00:00','2025-03-10 08:00:00',NULL,'VND',10,1,5,1,4500000.00,'Dự án',1),(22,'Order 022','Lưu trữ đám mây 3 tháng','paid','2025-02-12 09:00:00','2025-03-15 09:00:00','2025-02-25 09:00:00','VND',10,1,12,2,360000.00,'Tháng',3),(23,'Order 023','Tối ưu SEO từ khóa chính','wait','2025-02-14 10:00:00','2025-03-20 10:00:00',NULL,'VND',10,1,3,3,3000000.00,'Dịch vụ',1),(24,'Order 024','Phát triển ứng dụng di động','wait_pay','2025-02-16 11:00:00','2025-03-25 11:00:00',NULL,'VND',10,1,4,4,15000000.00,'Dự án',1),(25,'Order 025','Chiến dịch quảng cáo Instagram','paid','2025-02-18 12:00:00','2025-03-01 12:00:00','2025-02-28 12:00:00','VND',10,1,10,5,4000000.00,'Chiến dịch',1),(26,'Order 026','Tư vấn chiến lược CNTT','wait','2025-02-20 13:00:00','2025-03-20 13:00:00',NULL,'VND',10,1,6,6,5000000.00,'Giờ',10),(27,'Order 027','Thiết kế logo công ty','wait_pay','2025-02-22 14:00:00','2025-03-10 14:00:00',NULL,'VND',10,1,5,7,1500000.00,'Sản phẩm',2),(28,'Order 028','Phân tích dữ liệu khách hàng','paid','2025-02-24 15:00:00','2025-03-25 15:00:00','2025-03-05 15:00:00','VND',10,1,8,8,2000000.00,'Báo cáo',1),(29,'Order 029','Bảo mật hệ thống doanh nghiệp','wait','2025-02-26 16:00:00','2025-04-01 16:00:00',NULL,'VND',10,1,7,9,3500000.00,'Dịch vụ',1),(30,'Order 030','Triển khai hệ thống CRM','wait_pay','2025-02-28 17:00:00','2025-04-10 17:00:00',NULL,'VND',10,1,9,10,8000000.00,'Dự án',1),(31,'Order 031','Thiết kế website doanh nghiệp','paid','2025-03-02 08:00:00','2025-04-01 08:00:00','2025-03-15 08:00:00','VND',10,1,11,1,6000000.00,'Dự án',1),(32,'Order 032','Dịch vụ cloud 12 tháng','wait','2025-03-04 09:00:00','2025-04-15 09:00:00',NULL,'VND',10,1,12,2,1440000.00,'Tháng',12),(33,'Order 033','Tối ưu SEO website','wait_pay','2025-03-06 10:00:00','2025-04-10 10:00:00',NULL,'VND',10,1,13,3,3200000.00,'Dịch vụ',1),(34,'Order 034','Phát triển app Android','paid','2025-03-08 11:00:00','2025-04-20 11:00:00','2025-03-20 11:00:00','VND',10,1,14,4,14000000.00,'Dự án',1),(35,'Order 035','Quảng cáo Google Ads','wait','2025-03-10 12:00:00','2025-03-25 12:00:00',NULL,'VND',10,1,20,5,4500000.00,'Chiến dịch',1),(36,'Order 036','Tư vấn giải pháp CNTT','wait_pay','2025-03-12 13:00:00','2025-04-10 13:00:00',NULL,'VND',10,1,16,6,4400000.00,'Giờ',8),(37,'Order 037','Thiết kế banner quảng cáo','paid','2025-03-14 14:00:00','2025-04-01 14:00:00','2025-03-25 14:00:00','VND',10,1,15,7,2100000.00,'Sản phẩm',3),(38,'Order 038','Phân tích dữ liệu kinh doanh','wait','2025-03-16 15:00:00','2025-04-15 15:00:00',NULL,'VND',10,1,18,8,2500000.00,'Báo cáo',1),(39,'Order 039','Cải thiện bảo mật website','wait_pay','2025-03-18 16:00:00','2025-04-25 16:00:00',NULL,'VND',10,1,17,9,4000000.00,'Dịch vụ',1),(40,'Order 040','Triển khai phần mềm CRM','paid','2025-03-20 17:00:00','2025-05-01 17:00:00','2025-04-01 17:00:00','VND',10,1,19,10,9000000.00,'Dự án',1),(41,'Order 041','Thiết kế website bán hàng','wait','2025-03-22 08:00:00','2025-04-20 08:00:00',NULL,'VND',10,1,1,1,5000000.00,'Dự án',1),(42,'Order 042','Lưu trữ đám mây 6 tháng','wait_pay','2025-03-24 09:00:00','2025-04-25 09:00:00',NULL,'VND',10,1,2,2,720000.00,'Tháng',6),(43,'Order 043','Tối ưu SEO từ khóa','paid','2025-03-26 10:00:00','2025-05-01 10:00:00','2025-04-05 10:00:00','VND',10,1,3,3,3000000.00,'Dịch vụ',1),(44,'Order 044','Phát triển ứng dụng iOS','wait','2025-03-28 11:00:00','2025-05-10 11:00:00',NULL,'VND',10,1,4,4,15000000.00,'Dự án',1),(45,'Order 045','Chiến dịch quảng cáo FB','wait_pay','2025-03-30 12:00:00','2025-04-15 12:00:00',NULL,'VND',10,1,10,5,4000000.00,'Chiến dịch',1),(46,'Order 046','Tư vấn chiến lược CNTT','paid','2025-04-01 13:00:00','2025-05-01 13:00:00','2025-04-10 13:00:00','VND',10,1,6,6,5000000.00,'Giờ',10),(47,'Order 047','Thiết kế logo công ty','wait','2025-04-03 14:00:00','2025-04-25 14:00:00',NULL,'VND',10,1,5,7,1500000.00,'Sản phẩm',2),(48,'Order 048','Phân tích dữ liệu bán hàng','wait_pay','2025-04-05 15:00:00','2025-05-05 15:00:00',NULL,'VND',10,1,8,8,2000000.00,'Báo cáo',1),(49,'Order 049','Bảo mật hệ thống mạng','paid','2025-04-07 16:00:00','2025-05-15 16:00:00','2025-04-20 16:00:00','VND',10,1,7,9,3500000.00,'Dịch vụ',1),(50,'Order 050','Triển khai hệ thống CRM','wait','2025-04-09 17:00:00','2025-05-25 17:00:00',NULL,'VND',10,1,9,10,8000000.00,'Dự án',1),(51,'Order 051','Thiết kế website doanh nghiệp','wait_pay','2025-04-11 08:00:00','2025-05-20 08:00:00',NULL,'VND',10,1,11,1,6000000.00,'Dự án',1),(52,'Order 052','Dịch vụ cloud 3 tháng','paid','2025-04-13 09:00:00','2025-05-15 09:00:00','2025-04-25 09:00:00','VND',10,1,12,2,360000.00,'Tháng',3),(53,'Order 053','Tối ưu SEO website','wait','2025-04-15 10:00:00','2025-05-25 10:00:00',NULL,'VND',10,1,13,3,3200000.00,'Dịch vụ',1),(54,'Order 054','Phát triển app Android','wait_pay','2025-04-17 11:00:00','2025-06-01 11:00:00',NULL,'VND',10,1,14,4,14000000.00,'Dự án',1),(55,'Order 055','Quảng cáo Google Ads','paid','2025-04-19 12:00:00','2025-05-01 12:00:00','2025-04-30 12:00:00','VND',10,1,20,5,4500000.00,'Chiến dịch',1),(56,'Order 056','Tư vấn giải pháp CNTT','wait','2025-04-21 13:00:00','2025-05-20 13:00:00',NULL,'VND',10,1,16,6,4400000.00,'Giờ',8),(57,'Order 057','Thiết kế banner quảng cáo','wait_pay','2025-04-23 14:00:00','2025-05-10 14:00:00',NULL,'VND',10,1,15,7,2100000.00,'Sản phẩm',3),(58,'Order 058','Phân tích dữ liệu kinh doanh','paid','2025-04-25 15:00:00','2025-06-01 15:00:00','2025-05-05 15:00:00','VND',10,1,18,8,2500000.00,'Báo cáo',1),(59,'Order 059','Cải thiện bảo mật website','wait','2025-04-27 16:00:00','2025-06-05 16:00:00',NULL,'VND',10,1,17,9,4000000.00,'Dịch vụ',1),(60,'Order 060','Triển khai phần mềm CRM','wait_pay','2025-04-29 17:00:00','2025-06-10 17:00:00',NULL,'VND',10,1,19,10,9000000.00,'Dự án',1),(61,'Order 061','Thiết kế website bán hàng','paid','2025-05-01 08:00:00','2025-06-01 08:00:00','2025-05-15 08:00:00','VND',10,1,1,1,5000000.00,'Dự án',1),(62,'Order 062','Lưu trữ đám mây 12 tháng','wait','2025-05-03 09:00:00','2025-06-15 09:00:00',NULL,'VND',10,1,2,2,1440000.00,'Tháng',12),(63,'Order 063','Tối ưu SEO từ khóa','wait_pay','2025-05-05 10:00:00','2025-06-20 10:00:00',NULL,'VND',10,1,3,3,3000000.00,'Dịch vụ',1),(64,'Order 064','Phát triển ứng dụng iOS','paid','2025-05-07 11:00:00','2025-06-25 11:00:00','2025-05-20 11:00:00','VND',10,1,4,4,15000000.00,'Dự án',1),(65,'Order 065','Chiến dịch quảng cáo Instagram','wait','2025-05-09 12:00:00','2025-05-25 12:00:00',NULL,'VND',10,1,10,5,4000000.00,'Chiến dịch',1),(66,'Order 066','Tư vấn chiến lược CNTT','wait_pay','2025-05-11 13:00:00','2025-06-15 13:00:00',NULL,'VND',10,1,6,6,5000000.00,'Giờ',10),(67,'Order 067','Thiết kế logo công ty','paid','2025-05-13 14:00:00','2025-06-01 14:00:00','2025-05-25 14:00:00','VND',10,1,5,7,1500000.00,'Sản phẩm',2),(68,'Order 068','Phân tích dữ liệu khách hàng','wait','2025-05-15 15:00:00','2025-06-20 15:00:00',NULL,'VND',10,1,8,8,2000000.00,'Báo cáo',1),(69,'Order 069','Bảo mật hệ thống doanh nghiệp','wait_pay','2025-05-17 16:00:00','2025-06-25 16:00:00',NULL,'VND',10,1,7,9,3500000.00,'Dịch vụ',1),(70,'Order 070','Triển khai hệ thống CRM','paid','2025-05-19 17:00:00','2025-07-01 17:00:00','2025-06-01 17:00:00','VND',10,1,9,10,8000000.00,'Dự án',1),(71,'Order 071','Thiết kế website doanh nghiệp','wait','2025-05-21 08:00:00','2025-06-20 08:00:00',NULL,'VND',10,1,11,1,6000000.00,'Dự án',1),(72,'Order 072','Dịch vụ cloud 6 tháng','wait_pay','2025-05-23 09:00:00','2025-06-25 09:00:00',NULL,'VND',10,1,12,2,720000.00,'Tháng',6),(73,'Order 073','Tối ưu SEO website','paid','2025-05-25 10:00:00','2025-07-01 10:00:00','2025-06-05 10:00:00','VND',10,1,13,3,3200000.00,'Dịch vụ',1),(74,'Order 074','Phát triển app Android','wait','2025-05-27 11:00:00','2025-07-10 11:00:00',NULL,'VND',10,1,14,4,14000000.00,'Dự án',1),(75,'Order 075','Quảng cáo Google Ads','wait_pay','2025-05-29 12:00:00','2025-06-15 12:00:00',NULL,'VND',10,1,20,5,4500000.00,'Chiến dịch',1),(76,'Order 076','Tư vấn giải pháp CNTT','paid','2025-05-31 13:00:00','2025-07-01 13:00:00','2025-06-10 13:00:00','VND',10,1,16,6,4400000.00,'Giờ',8),(77,'Order 077','Thiết kế banner quảng cáo','wait','2025-06-02 14:00:00','2025-06-25 14:00:00',NULL,'VND',10,1,15,7,2100000.00,'Sản phẩm',3),(78,'Order 078','Phân tích dữ liệu kinh doanh','wait_pay','2025-06-04 15:00:00','2025-07-05 15:00:00',NULL,'VND',10,1,18,8,2500000.00,'Báo cáo',1),(79,'Order 079','Cải thiện bảo mật website','paid','2025-06-06 16:00:00','2025-07-15 16:00:00','2025-06-20 16:00:00','VND',10,1,17,9,4000000.00,'Dịch vụ',1),(80,'Order 080','Triển khai phần mềm CRM','wait','2025-06-08 17:00:00','2025-07-25 17:00:00',NULL,'VND',10,1,19,10,9000000.00,'Dự án',1),(81,'Order 081','Thiết kế website bán hàng','wait_pay','2025-06-10 08:00:00','2025-07-20 08:00:00',NULL,'VND',10,1,1,1,5000000.00,'Dự án',1),(82,'Order 082','Lưu trữ đám mây 3 tháng','paid','2025-06-12 09:00:00','2025-07-15 09:00:00','2025-06-25 09:00:00','VND',10,1,2,2,360000.00,'Tháng',3),(83,'Order 083','Tối ưu SEO từ khóa','wait','2025-06-14 10:00:00','2025-07-25 10:00:00',NULL,'VND',10,1,3,3,3000000.00,'Dịch vụ',1),(84,'Order 084','Phát triển ứng dụng iOS','wait_pay','2025-06-16 11:00:00','2025-08-01 11:00:00',NULL,'VND',10,1,4,4,15000000.00,'Dự án',1),(85,'Order 085','Chiến dịch quảng cáo FB','paid','2025-06-18 12:00:00','2025-07-01 12:00:00','2025-06-30 12:00:00','VND',10,1,10,5,4000000.00,'Chiến dịch',1),(86,'Order 086','Tư vấn chiến lược CNTT','wait','2025-06-20 13:00:00','2025-07-20 13:00:00',NULL,'VND',10,1,6,6,5000000.00,'Giờ',10),(87,'Order 087','Thiết kế logo công ty','wait_pay','2025-06-22 14:00:00','2025-07-10 14:00:00',NULL,'VND',10,1,5,7,1500000.00,'Sản phẩm',2),(88,'Order 088','Phân tích dữ liệu khách hàng','paid','2025-06-24 15:00:00','2025-08-01 15:00:00','2025-07-05 15:00:00','VND',10,1,8,8,2000000.00,'Báo cáo',1),(89,'Order 089','Bảo mật hệ thống doanh nghiệp','wait','2025-06-26 16:00:00','2025-08-05 16:00:00',NULL,'VND',10,1,7,9,3500000.00,'Dịch vụ',1),(90,'Order 090','Triển khai hệ thống CRM','wait_pay','2025-06-28 17:00:00','2025-08-10 17:00:00',NULL,'VND',10,1,9,10,8000000.00,'Dự án',1),(91,'Order 091','Thiết kế website doanh nghiệp','paid','2025-06-30 08:00:00','2025-08-01 08:00:00','2025-07-15 08:00:00','VND',10,1,11,1,6000000.00,'Dự án',1),(92,'Order 092','Dịch vụ cloud 12 tháng','wait','2025-07-02 09:00:00','2025-08-15 09:00:00',NULL,'VND',10,1,12,2,1440000.00,'Tháng',12),(93,'Order 093','Tối ưu SEO website','wait_pay','2025-07-04 10:00:00','2025-08-20 10:00:00',NULL,'VND',10,1,13,3,3200000.00,'Dịch vụ',1),(94,'Order 094','Phát triển app Android','paid','2025-07-06 11:00:00','2025-08-25 11:00:00','2025-07-20 11:00:00','VND',10,1,14,4,14000000.00,'Dự án',1),(95,'Order 095','Quảng cáo Google Ads','wait','2025-07-08 12:00:00','2025-07-25 12:00:00',NULL,'VND',10,1,20,5,4500000.00,'Chiến dịch',1),(96,'Order 096','Tư vấn giải pháp CNTT','wait_pay','2025-07-10 13:00:00','2025-08-15 13:00:00',NULL,'VND',10,1,16,6,4400000.00,'Giờ',8),(97,'Order 097','Thiết kế banner quảng cáo','paid','2025-07-12 14:00:00','2025-08-01 14:00:00','2025-07-25 14:00:00','VND',10,1,15,7,2100000.00,'Sản phẩm',3),(98,'Order 098','Phân tích dữ liệu kinh doanh','wait','2025-07-14 15:00:00','2025-08-20 15:00:00',NULL,'VND',10,1,18,8,2500000.00,'Báo cáo',1),(99,'Order 099','Cải thiện bảo mật website','wait_pay','2025-07-16 16:00:00','2025-08-25 16:00:00',NULL,'VND',10,1,17,9,4000000.00,'Dịch vụ',1),(100,'Order 100','Triển khai phần mềm CRM','paid','2025-07-18 17:00:00','2025-09-01 17:00:00','2025-08-01 17:00:00','VND',10,1,19,10,9000000.00,'Dự án',1);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provide_services`
--

DROP TABLE IF EXISTS `provide_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provide_services` (
  `service_id` int NOT NULL,
  `provider_id` int NOT NULL,
  `provide_price` decimal(18,2) NOT NULL,
  `currency` varchar(15) NOT NULL,
  `contract_id` int DEFAULT NULL,
  PRIMARY KEY (`service_id`,`provider_id`),
  KEY `FK_provideService_provide_idx` (`provider_id`),
  KEY `fk_provide_services_contracts1_idx` (`contract_id`),
  CONSTRAINT `fk_provide_services_contracts1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`),
  CONSTRAINT `FK_provideService_provide` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`),
  CONSTRAINT `FK_provideService_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provide_services`
--

LOCK TABLES `provide_services` WRITE;
/*!40000 ALTER TABLE `provide_services` DISABLE KEYS */;
INSERT INTO `provide_services` VALUES (1,1,32000000.00,'VNĐ',NULL),(5,8,320000.00,'VNĐ',NULL),(8,1,3000000.00,'VNĐ',NULL),(10,8,12333344.00,'VNĐ',NULL);
/*!40000 ALTER TABLE `provide_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `providers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `tax_code` varchar(15) NOT NULL,
  `des` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `reputation` int DEFAULT NULL,
  `pay_account_number` varchar(45) NOT NULL,
  `logo_url` varchar(45) NOT NULL,
  `banner_url` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
INSERT INTO `providers` VALUES (1,'Tech Solutions','TAX001','Cung cấp giải pháp công nghệ toàn diện','active','123 Đường Láng, Hà Nội','tech@company.com','0901234567','2024-01-01 10:00:00','2025-06-25 04:57:14','https://techsolutions.com',85,'1234567890','/public/uploads/685b17cca91b6.jpg','/public/uploads/685b17cca9f3c.jpg'),(2,'Cloud Innovate','TAX002','Dịch vụ đám mây tiên tiến','active','456 Nguyễn Trãi, TP.HCM','cloud@innovate.com','0902345678','2024-01-02 10:00:00','2025-06-25 04:31:19','https://cloudinnovate.com',90,'2345678901','/public/uploads/685b19274f25e.jpg','/public/uploads/685b19274fa58.jpg'),(3,'Digital Boost','TAX003','Tiếp thị số và SEO','active','789 Lê Lợi, Đà Nẵng','digital@boost.com','0903456789','2024-01-03 10:00:00','2025-06-25 04:34:19','https://digitalboost.com',88,'3456789012','/public/uploads/685b19db59d84.jpg','/public/uploads/685b19db5a510.jpg'),(4,'App Creators','TAX004','Phát triển ứng dụng di động','active','101 Trần Phú, Nha Trang','app@creators.com','0904567890','2024-01-04 10:00:00','2025-06-25 04:36:55','https://appcreators.com',92,'4567890123','/public/uploads/685b1a776ec93.jpg','/public/uploads/685b1a776f5ce.jpg'),(5,'Design Studio','TAX005','Thiết kế đồ họa và website','active','222 Phạm Văn Đồng, Hải Phòng','design@studio.com','0905678901','2024-01-05 10:00:00','2025-06-25 04:37:07','https://designstudio.com',87,'5678901234','/public/uploads/685b1a8327947.jpg','/public/uploads/685b1a83280fe.jpg'),(6,'IT Experts','TAX006','Tư vấn CNTT chuyên sâu','active','333 Nguyễn Huệ, Huế','it@experts.com','0906789012','2024-01-06 10:00:00','2025-06-25 04:37:18','https://itexperts.com',89,'6789012345','/public/uploads/685b1a8e00ad0.jpg','/public/uploads/685b1a8e01148.jpg'),(7,'Secure Net','TAX007','Giải pháp an ninh mạng','active','444 Tôn Đức Thắng, Cần Thơ','secure@net.com','0907890123','2024-01-07 10:00:00','2025-06-25 04:37:28','https://securenet.com',91,'7890123456','/public/uploads/685b1a987a1ab.jpg','/public/uploads/685b1a987a917.jpg'),(8,'Data Insights','TAX008','Phân tích dữ liệu doanh nghiệp','active','555 Lê Văn Sỹ, TP.HCM','data@insights.com','0908901234','2024-01-08 10:00:00','2025-06-25 04:52:42','https://datainsights.com',86,'8901234567','/public/uploads/685b1aa26585c.jpg','/public/uploads/685b1aa265f9b.jpg'),(9,'CRM Solutions','TAX009','Triển khai hệ thống CRM','active','666 Bà Triệu, Hà Nội','crm@solutions.com','0909012345','2024-01-09 10:00:00','2025-06-25 04:37:48','https://crmsolutions.com',90,'9012345678','/public/uploads/685b1aac37e36.jpg','/public/uploads/685b1aac38339.jpg'),(10,'Marketing Pros','TAX010','Chiến lược tiếp thị số','active','777 Nguyễn Đình Chiểu, Đà Lạt','marketing@pros.com','0910123456','2024-01-10 10:00:00','2025-06-25 04:37:57','https://marketingpros.com',88,'0123456789','/public/uploads/685b1ab57dbd0.jpg','/public/uploads/685b1ab57e114.jpg'),(11,'Web Innovators','TAX011','Thiết kế và phát triển web','active','888 Hùng Vương, Vinh','web@innovators.com','0911234567','2024-01-11 10:00:00','2025-06-25 04:49:16','https://webinnovators.com',87,'1234567891','/public/uploads/685b1d5c7eff9.jpg','/public/uploads/685b1d5c7fb7a.jpg'),(12,'Cloud Experts','TAX012','Giải pháp đám mây tùy chỉnh','active','999 Lý Thường Kiệt, Quy Nhơn','cloud@experts.com','0912345678','2024-01-12 10:00:00','2025-06-25 04:49:33','https://cloudexperts.com',89,'2345678902','/public/uploads/685b1d6d5fada.jpg','/public/uploads/685b1d6d6047d.jpg'),(13,'SEO Masters','TAX013','Chuyên gia tối ưu hóa SEO','active','1010 Trần Hưng Đạo, Hải Dương','seo@masters.com','0913456789','2024-01-13 10:00:00','2025-06-25 04:49:46','https://seomasters.com',90,'3456789013','/public/uploads/685b1d7a35986.jpg','/public/uploads/685b1d7a360f6.jpg'),(14,'Mobile Innovate','TAX014','Phát triển ứng dụng di động sáng tạo','active','1111 Nguyễn Văn Cừ, Long Xuyên','mobile@innovate.com','0914567890','2024-01-14 10:00:00','2025-06-25 04:49:58','https://mobileinnovate.com',88,'4567890124','/public/uploads/685b1d8674b65.jpg','/public/uploads/685b1d867589d.jpg'),(15,'Creative Designs','TAX015','Thiết kế đồ họa và thương hiệu','active','1212 Lê Đại Hành, Vũng Tàu','creative@designs.com','0915678901','2024-01-15 10:00:00','2025-06-25 04:50:09','https://creativedesigns.com',86,'5678901235','/public/uploads/685b1d9169305.jpg','/public/uploads/685b1d916996b.jpg'),(16,'Tech Advisors','TAX016','Tư vấn công nghệ doanh nghiệp','active','1313 Nguyễn Thị Minh Khai, TP.HCM','tech@advisors.com','0916789012','2024-01-16 10:00:00','2025-06-25 04:50:20','https://techadvisors.com',89,'6789012346','/public/uploads/685b1d9c1bdcf.jpg','/public/uploads/685b1d9c1c6a4.jpg'),(17,'Secure Solutions','TAX017','Bảo mật và an ninh mạng','active','1414 Phạm Ngũ Lão, Hà Nội','secure@solutions.com','0917890123','2024-01-17 10:00:00','2025-06-25 04:50:31','https://securesolutions.com',91,'7890123457','/public/uploads/685b1da7d9d0b.jpg','/public/uploads/685b1da7da60b.jpg'),(18,'Data Experts','TAX018','Chuyên gia phân tích dữ liệu','active','1515 Lê Thánh Tôn, Đà Nẵng','data@experts.com','0918901234','2024-01-18 10:00:00','2025-06-25 04:50:43','https://dataexperts.com',87,'8901234568','/public/uploads/685b1db34731a.jpg','/public/uploads/685b1db347907.jpg'),(19,'CRM Experts','TAX019','Triển khai giải pháp CRM','active','1616 Nguyễn Văn Linh, Cần Thơ','crm@experts.com','0919012345','2024-01-19 10:00:00','2025-06-25 04:50:54','https://crmexperts.com',90,'9012345679','/public/uploads/685b1dbe4fd02.jpg','/public/uploads/685b1dbe50516.jpg'),(20,'Marketing Experts','TAX020','Tiếp thị số chuyên sâu','active','1717 Võ Văn Kiệt, TP.HCM','marketing@experts.com','0920123456','2024-01-20 10:00:00','2025-06-25 04:51:04','https://marketingexperts.com',88,'0123456790','/public/uploads/685b1dc895071.jpg','/public/uploads/685b1dc89545f.jpg');
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `des` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Web Design','Dịch vụ thiết kế website chuyên nghiệp','signed','Dự án','2024-01-01 10:00:00','2024-01-01 10:00:00'),(2,'Cloud Hosting','Dịch vụ lưu trữ đám mây tốc độ cao','signed','Tháng','2024-01-02 10:00:00','2024-01-02 10:00:00'),(3,'SEO Optimization','Tối ưu hóa công cụ tìm kiếm cho website','signed','Dịch vụ','2024-01-03 10:00:00','2024-01-03 10:00:00'),(4,'Mobile App Development','Phát triển ứng dụng di động đa nền tảng','signed','Dự án','2024-01-04 10:00:00','2024-01-04 10:00:00'),(5,'Digital Marketing','Quảng cáo và tiếp thị số','signed','Chiến dịch','2024-01-05 10:00:00','2024-01-05 10:00:00'),(6,'IT Consulting','Tư vấn giải pháp công nghệ thông tin','signed','Giờ','2024-01-06 10:00:00','2024-01-06 10:00:00'),(7,'Graphic Design','Thiết kế đồ họa sáng tạo','signed','Sản phẩm','2024-01-07 10:00:00','2024-01-07 10:00:00'),(8,'Data Analysis','Phân tích dữ liệu kinh doanh','signed','Báo cáo','2024-01-08 10:00:00','2024-01-08 10:00:00'),(9,'Cybersecurity','Dịch vụ bảo mật và an ninh mạng','signed','Dịch vụ','2024-01-09 10:00:00','2024-01-09 10:00:00'),(10,'CRM Implementation','Triển khai hệ thống quản lý khách hàng','signed','Dự án','2024-01-10 10:00:00','2024-01-10 10:00:00');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$12$6rFQ49M9NPTOOy9e9SfKJugdXe/dnSvoEP9HG6LTjlFDeIz7GpxfS','admin@example.com','Admin');
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

-- Dump completed on 2025-06-25  5:20:36
