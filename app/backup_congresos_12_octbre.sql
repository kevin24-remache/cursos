-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: congresos
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB-0+deb12u1

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
-- Current Database: `congresos`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `congresos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `congresos`;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `cantidad_dinero` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'DOCENTES UEB','',40.59,'2024-10-02 23:47:09','2024-10-02 23:47:09',NULL),
(2,'PARTICIPANTES EXTERNOS','',50.59,'2024-10-02 23:47:32','2024-10-02 23:47:32',NULL),
(3,'ESTUDIANTES POSGRADO UEB','',50.59,'2024-10-02 23:48:03','2024-10-02 23:48:03',NULL),
(4,'ESTUDIANTES UEB','',10.59,'2024-10-02 23:48:23','2024-10-02 23:48:23',NULL),
(5,'ESTUDIANTES DE PRE-GRADO UEB','',10.59,'2024-10-02 23:49:06','2024-10-02 23:49:06',NULL),
(6,'ESTUDIANTES POSGRADO UEB','',20.59,'2024-10-02 23:49:24','2024-10-02 23:49:24',NULL),
(7,'DOCENTES UEB','',30.59,'2024-10-02 23:49:57','2024-10-02 23:49:57',NULL),
(8,'ASISTENTES DE OTRAS INSTITUCIONES','',50.59,'2024-10-02 23:50:27','2024-10-02 23:50:27',NULL),
(9,'ESTUDIANTES UEB','ESTUDIANTES PREGRADO IV SEMINARIO METODOLOGÍA',15.59,'2024-10-07 20:08:09','2024-10-07 20:08:09',NULL),
(10,'DOCENTES UEB','ESTUDIANTES PREGRADO IV SEMINARIO METODOLOGÍA',25.59,'2024-10-07 20:08:26','2024-10-07 20:08:26',NULL),
(11,'PROFESIONALES','ESTUDIANTES PREGRADO IV SEMINARIO METODOLOGÍA',30.59,'2024-10-07 20:08:46','2024-10-07 20:08:46',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES
(1,'additional_charge','0.59','Monto adicional por cada pago','2024-10-02 23:43:34','2024-10-12 18:30:36');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deposits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) unsigned NOT NULL,
  `deposit_cedula` varchar(20) NOT NULL,
  `codigo_pago` int(11) NOT NULL,
  `monto_deposito` decimal(10,2) NOT NULL,
  `comprobante_pago` varchar(255) NOT NULL,
  `num_comprobante` varchar(100) NOT NULL,
  `date_deposito` date NOT NULL,
  `status` enum('Pendiente','Incompleto','Aprobado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  `approved_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deposits_payment_id_foreign` (`payment_id`),
  KEY `deposits_approved_by_foreign` (`approved_by`),
  CONSTRAINT `deposits_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `deposits_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposits`
--

LOCK TABLES `deposits` WRITE;
/*!40000 ALTER TABLE `deposits` DISABLE KEYS */;
INSERT INTO `deposits` VALUES
(1,9,'0202639282',7821695,10.59,'uploads/comprobantes/1728236854_6f33f126c95d7e56a32a.jpg','94182220','2024-10-06','Aprobado',1,'2024-10-06 17:47:34','2024-10-07 14:05:08'),
(2,40,'1250827043',1444893,10.59,'uploads/comprobantes/1728401977_d7b3a9b15e42e7f0ef8a.jpg','21456500','2024-10-08','Aprobado',1,'2024-10-08 15:39:37','2024-10-08 21:41:41'),
(3,46,'0202199089',7063487,10.59,'uploads/comprobantes/1728423826_3d487886954892275002.jpg','786529','2024-10-08','Aprobado',1,'2024-10-08 21:43:46','2024-10-08 21:44:05'),
(4,76,'1754442497',8713608,10.59,'uploads/comprobantes/1728516383_2dd1492f7795bd207ff9.jpg','72996846','2024-10-09','Aprobado',1,'2024-10-09 23:26:23','2024-10-10 14:14:29'),
(5,4,'1728414382',2758085,10.59,'uploads/comprobantes/1728533358_1dc53a348143d7d75028.jpeg','867892','2024-10-09','Aprobado',1,'2024-10-10 04:09:18','2024-10-10 14:13:09'),
(6,90,'0202608949',8312829,10.59,'uploads/comprobantes/1728568816_145205b462ad85eeb1ce.jpg','0002581050','2024-10-10','Aprobado',1,'2024-10-10 14:00:16','2024-10-10 14:13:55'),
(7,19,'0202292322',5633215,10.59,'uploads/comprobantes/1728582747_6a8997293f22bc3657e4.jpg','744944','2024-10-09','Aprobado',1,'2024-10-10 17:52:27','2024-10-10 21:39:42'),
(8,28,'1727709808',5954525,10.59,'uploads/comprobantes/1728596264_5b7a6aab6e8ad6d48fec.jpg','346101','2024-10-10','Aprobado',1,'2024-10-10 21:37:44','2024-10-10 21:40:14'),
(9,29,'0705635647',5950017,10.00,'uploads/comprobantes/1728598190_1df9cda7b0543f668e4c.png','867974','2024-10-10','Incompleto',NULL,'2024-10-10 22:09:50','2024-10-10 22:10:15'),
(10,107,'1723594857',8629533,0.00,'uploads/comprobantes/1728599695_8669a16128b928fc41e2.jpg','103748','2024-10-10','Incompleto',NULL,'2024-10-10 22:34:55','2024-10-10 22:34:55'),
(11,10,'0250021490',6085330,0.00,'uploads/comprobantes/1728600079_f9f0b9d9583d173626fe.jpg','409808','2024-10-10','Rechazado',NULL,'2024-10-10 22:41:19','2024-10-10 22:41:19'),
(12,50,'0202275871',7895765,10.59,'uploads/comprobantes/1728602764_01ff1df5d1b085859960.jpg','128696','2024-10-10','Aprobado',1,'2024-10-10 23:26:04','2024-10-10 23:45:05'),
(13,201,'1250748280',4222791,10.59,'uploads/comprobantes/1728614889_2a6d960e36d616d20b7a.jpg','91259978','2024-10-10','Aprobado',1,'2024-10-11 02:48:09','2024-10-11 03:17:17'),
(14,179,'0202274049',5185261,15.59,'uploads/comprobantes/1728658523_59e41f12c92081645c36.png','14894403','2024-10-11','Aprobado',1,'2024-10-11 14:55:23','2024-10-11 19:10:29'),
(15,59,'1727443846',8613594,10.59,'uploads/comprobantes/1728660258_039dacc1b1d0e22f3bdf.jpg','949592','2024-10-10','Aprobado',1,'2024-10-11 15:24:18','2024-10-11 19:09:49'),
(16,106,'0202204848',5178195,20.59,'uploads/comprobantes/1728674935_0ada858c1f6f1d10f210.jpg','80094223','2024-10-10','Aprobado',1,'2024-10-11 19:28:55','2024-10-12 17:53:07'),
(17,259,'0202174652',1113327,15.59,'uploads/comprobantes/1728686135_9560ed1607950e82f6e4.jpeg','61619592','2024-10-11','Aprobado',1,'2024-10-11 22:35:35','2024-10-12 17:47:59'),
(18,228,'0202418711',7673969,0.00,'uploads/comprobantes/1728744588_2aeee59dbd704bd6734c.jpg','1','2024-10-12','Pendiente',NULL,'2024-10-12 14:49:48','2024-10-12 14:49:48'),
(19,320,'1728578194',7483615,10.59,'uploads/comprobantes/1728770762_3ba184491db5af331091.jpg','11934837','2024-10-09','Aprobado',1,'2024-10-12 22:06:02','2024-10-13 01:36:48'),
(20,276,'1850677491',6972087,15.59,'uploads/comprobantes/1728774630_0a6a8b3877f0ccabf82a.jpg','0010113170','2024-10-12','Aprobado',1,'2024-10-12 23:10:30','2024-10-13 01:36:19');
/*!40000 ALTER TABLE `deposits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_category`
--

DROP TABLE IF EXISTS `event_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `cat_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_category_event_id_foreign` (`event_id`),
  KEY `event_category_cat_id_foreign` (`cat_id`),
  CONSTRAINT `event_category_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `event_category_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_category`
--

LOCK TABLES `event_category` WRITE;
/*!40000 ALTER TABLE `event_category` DISABLE KEYS */;
INSERT INTO `event_category` VALUES
(9,2,5),
(10,2,6),
(11,2,7),
(12,2,8),
(13,1,1),
(14,1,2),
(15,1,3),
(16,1,4),
(26,3,9),
(27,3,10),
(28,3,11);
/*!40000 ALTER TABLE `event_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `modality` enum('Presencial','Virtual','Hibrida') NOT NULL,
  `event_duration` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `registrations_start_date` date DEFAULT NULL,
  `registrations_end_date` date DEFAULT NULL,
  `event_status` enum('Activo','Desactivado') NOT NULL DEFAULT 'Desactivado',
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES
(1,'XI CTIE - II CIVS','XI Congreso Internacional Ciencia, Tecnología, Innovación y Emprendimiento, XI CTIE y II Congreso Internacional de Vinculación con la Sociedad , II CIVS','2024-10-22','Presencial',0,'GUANUJO','2024-10-03','2024-10-21','Activo','assets/images/events/1727913753_2c6fb8982f4c9f901ba5.jpeg','2024-10-03 00:02:33','2024-10-03 00:09:19',NULL,1,NULL,NULL),
(2,'V CIPEC','V CONGRESO INTERNACIONAL DE POSGRADO Y EDUCACIÓN CONTINUA \"La Ciencia con Enfoque Social\"','2024-10-16','Presencial',0,'GUANUJO','2024-10-03','2024-10-15','Activo','assets/images/events/1727914136_05569be75a482dea3422.jpg','2024-10-03 00:08:56','2024-10-03 00:09:08',NULL,1,NULL,NULL),
(3,'VI SEMINARIO INVESTIGACIÓN','VI SEMINARIO - METODOLOGÍA DE LA INVESTIGACIÓN CIENTIFICA','2024-10-14','Virtual',50,'ONLINE','2024-10-08','2024-10-14','Activo','assets/images/events/1728332064_ee72742b513c1df4fca1.png','2024-10-07 20:14:24','2024-10-12 19:04:23',NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion_pagos`
--

DROP TABLE IF EXISTS `inscripcion_pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscripcion_pagos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pago_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inscripcion_pagos_pago_id_foreign` (`pago_id`),
  KEY `inscripcion_pagos_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `inscripcion_pagos_pago_id_foreign` FOREIGN KEY (`pago_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inscripcion_pagos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion_pagos`
--

LOCK TABLES `inscripcion_pagos` WRITE;
/*!40000 ALTER TABLE `inscripcion_pagos` DISABLE KEYS */;
INSERT INTO `inscripcion_pagos` VALUES
(1,9,1,'2024-10-07 14:05:13','0000-00-00 00:00:00',NULL,NULL),
(2,37,1,'2024-10-08 13:26:14','0000-00-00 00:00:00',NULL,NULL),
(3,3,NULL,'2024-10-08 15:11:57','0000-00-00 00:00:00',NULL,NULL),
(4,3,NULL,'2024-10-08 15:12:17','0000-00-00 00:00:00',NULL,NULL),
(5,38,2,'2024-10-08 16:00:20','0000-00-00 00:00:00',NULL,NULL),
(6,39,2,'2024-10-08 16:01:41','0000-00-00 00:00:00',NULL,NULL),
(7,43,2,'2024-10-08 16:02:10','0000-00-00 00:00:00',NULL,NULL),
(8,40,1,'2024-10-08 21:41:45','0000-00-00 00:00:00',NULL,NULL),
(9,46,1,'2024-10-08 21:44:20','0000-00-00 00:00:00',NULL,NULL),
(10,1,NULL,'2024-10-08 22:42:48','0000-00-00 00:00:00',NULL,NULL),
(12,1,NULL,'2024-10-09 13:42:31','0000-00-00 00:00:00',NULL,NULL),
(13,1,NULL,'2024-10-09 13:42:51','0000-00-00 00:00:00',NULL,NULL),
(14,74,2,'2024-10-09 16:16:43','0000-00-00 00:00:00',NULL,NULL),
(15,73,2,'2024-10-09 20:58:40','0000-00-00 00:00:00',NULL,NULL),
(16,64,NULL,'2024-10-09 08:41:42','2024-10-09 21:32:06',NULL,NULL),
(17,27,2,'2024-10-09 23:02:44','0000-00-00 00:00:00',NULL,NULL),
(18,4,1,'2024-10-10 14:13:17','0000-00-00 00:00:00',NULL,NULL),
(19,90,1,'2024-10-10 14:13:58','0000-00-00 00:00:00',NULL,NULL),
(20,76,1,'2024-10-10 14:14:33','0000-00-00 00:00:00',NULL,NULL),
(21,61,2,'2024-10-10 19:58:59','0000-00-00 00:00:00',NULL,NULL),
(22,75,2,'2024-10-10 20:06:04','0000-00-00 00:00:00',NULL,NULL),
(23,108,3,'2024-10-10 21:38:04','0000-00-00 00:00:00',NULL,NULL),
(24,19,1,'2024-10-10 21:39:47','0000-00-00 00:00:00',NULL,NULL),
(25,28,1,'2024-10-10 21:40:20','0000-00-00 00:00:00',NULL,NULL),
(26,109,2,'2024-10-10 21:55:22','0000-00-00 00:00:00',NULL,NULL),
(27,2,3,'2024-10-10 22:33:02','0000-00-00 00:00:00',NULL,NULL),
(28,1,NULL,'2024-10-10 23:09:42','0000-00-00 00:00:00',NULL,NULL),
(29,1,NULL,'2024-10-10 23:09:46','0000-00-00 00:00:00',NULL,NULL),
(30,1,NULL,'2024-10-10 23:09:47','0000-00-00 00:00:00',NULL,NULL),
(31,1,NULL,'2024-10-10 23:09:47','0000-00-00 00:00:00',NULL,NULL),
(32,1,NULL,'2024-10-10 23:10:02','0000-00-00 00:00:00',NULL,NULL),
(33,93,3,'2024-10-10 23:19:17','0000-00-00 00:00:00',NULL,NULL),
(34,116,3,'2024-10-10 23:22:20','0000-00-00 00:00:00',NULL,NULL),
(35,92,3,'2024-10-10 23:24:40','0000-00-00 00:00:00',NULL,NULL),
(36,119,3,'2024-10-10 23:27:24','0000-00-00 00:00:00',NULL,NULL),
(37,117,3,'2024-10-10 23:28:14','0000-00-00 00:00:00',NULL,NULL),
(38,50,1,'2024-10-10 23:45:12','0000-00-00 00:00:00',NULL,NULL),
(39,1,NULL,'2024-10-11 00:02:24','0000-00-00 00:00:00',NULL,NULL),
(40,1,NULL,'2024-10-11 00:02:29','0000-00-00 00:00:00',NULL,NULL),
(41,1,NULL,'2024-10-11 00:02:29','0000-00-00 00:00:00',NULL,NULL),
(42,1,NULL,'2024-10-11 00:02:30','0000-00-00 00:00:00',NULL,NULL),
(43,1,NULL,'2024-10-11 00:02:44','0000-00-00 00:00:00',NULL,NULL),
(44,120,3,'2024-10-11 00:06:35','0000-00-00 00:00:00',NULL,NULL),
(45,125,3,'2024-10-11 00:08:22','0000-00-00 00:00:00',NULL,NULL),
(46,127,3,'2024-10-11 00:09:01','0000-00-00 00:00:00',NULL,NULL),
(47,129,3,'2024-10-11 00:10:56','0000-00-00 00:00:00',NULL,NULL),
(48,132,3,'2024-10-11 00:28:06','0000-00-00 00:00:00',NULL,NULL),
(49,1,NULL,'2024-10-11 01:29:01','0000-00-00 00:00:00',NULL,NULL),
(50,1,NULL,'2024-10-11 01:29:06','0000-00-00 00:00:00',NULL,NULL),
(51,1,NULL,'2024-10-11 01:29:07','0000-00-00 00:00:00',NULL,NULL),
(52,1,NULL,'2024-10-11 01:29:07','0000-00-00 00:00:00',NULL,NULL),
(53,1,NULL,'2024-10-11 01:29:08','0000-00-00 00:00:00',NULL,NULL),
(54,1,NULL,'2024-10-11 01:29:14','0000-00-00 00:00:00',NULL,NULL),
(55,1,NULL,'2024-10-11 01:29:21','0000-00-00 00:00:00',NULL,NULL),
(56,1,NULL,'2024-10-11 01:30:19','0000-00-00 00:00:00',NULL,NULL),
(57,1,NULL,'2024-10-11 01:30:22','0000-00-00 00:00:00',NULL,NULL),
(58,1,NULL,'2024-10-11 01:30:23','0000-00-00 00:00:00',NULL,NULL),
(59,1,NULL,'2024-10-11 01:30:24','0000-00-00 00:00:00',NULL,NULL),
(60,1,NULL,'2024-10-11 01:30:24','0000-00-00 00:00:00',NULL,NULL),
(61,1,NULL,'2024-10-11 01:30:38','0000-00-00 00:00:00',NULL,NULL),
(62,1,NULL,'2024-10-11 01:39:52','0000-00-00 00:00:00',NULL,NULL),
(63,1,NULL,'2024-10-11 01:40:11','0000-00-00 00:00:00',NULL,NULL),
(64,1,NULL,'2024-10-11 01:40:46','0000-00-00 00:00:00',NULL,NULL),
(65,1,NULL,'2024-10-11 01:47:11','0000-00-00 00:00:00',NULL,NULL),
(66,1,NULL,'2024-10-11 01:47:31','0000-00-00 00:00:00',NULL,NULL),
(67,1,NULL,'2024-10-11 01:47:40','0000-00-00 00:00:00',NULL,NULL),
(68,1,NULL,'2024-10-11 01:47:43','0000-00-00 00:00:00',NULL,NULL),
(69,1,NULL,'2024-10-11 02:15:17','0000-00-00 00:00:00',NULL,NULL),
(70,1,NULL,'2024-10-11 02:15:34','0000-00-00 00:00:00',NULL,NULL),
(71,201,1,'2024-10-11 03:17:21','0000-00-00 00:00:00',NULL,NULL),
(72,2,NULL,'2024-10-11 05:54:48','0000-00-00 00:00:00',NULL,NULL),
(73,2,NULL,'2024-10-11 05:55:08','0000-00-00 00:00:00',NULL,NULL),
(74,2,NULL,'2024-10-11 14:22:05','0000-00-00 00:00:00',NULL,NULL),
(75,2,NULL,'2024-10-11 14:22:10','0000-00-00 00:00:00',NULL,NULL),
(76,2,NULL,'2024-10-11 14:22:10','0000-00-00 00:00:00',NULL,NULL),
(77,2,NULL,'2024-10-11 14:22:10','0000-00-00 00:00:00',NULL,NULL),
(78,2,NULL,'2024-10-11 14:22:25','0000-00-00 00:00:00',NULL,NULL),
(79,6,NULL,'2024-10-11 16:24:23','0000-00-00 00:00:00',NULL,NULL),
(80,6,NULL,'2024-10-11 16:24:43','0000-00-00 00:00:00',NULL,NULL),
(81,2,NULL,'2024-10-11 16:42:06','0000-00-00 00:00:00',NULL,NULL),
(82,2,NULL,'2024-10-11 16:42:26','0000-00-00 00:00:00',NULL,NULL),
(83,1,NULL,'2024-10-11 16:43:42','0000-00-00 00:00:00',NULL,NULL),
(84,1,NULL,'2024-10-11 16:43:47','0000-00-00 00:00:00',NULL,NULL),
(85,1,NULL,'2024-10-11 16:43:47','0000-00-00 00:00:00',NULL,NULL),
(86,1,NULL,'2024-10-11 16:43:51','0000-00-00 00:00:00',NULL,NULL),
(87,1,NULL,'2024-10-11 16:43:53','0000-00-00 00:00:00',NULL,NULL),
(88,2,NULL,'2024-10-11 17:23:12','0000-00-00 00:00:00',NULL,NULL),
(89,2,NULL,'2024-10-11 17:23:17','0000-00-00 00:00:00',NULL,NULL),
(90,2,NULL,'2024-10-11 17:23:19','0000-00-00 00:00:00',NULL,NULL),
(91,2,NULL,'2024-10-11 17:23:31','0000-00-00 00:00:00',NULL,NULL),
(92,59,1,'2024-10-11 19:10:01','0000-00-00 00:00:00',NULL,NULL),
(93,179,1,'2024-10-11 19:10:33','0000-00-00 00:00:00',NULL,NULL),
(94,252,3,'2024-10-11 21:06:23','0000-00-00 00:00:00',NULL,NULL),
(95,253,3,'2024-10-11 21:08:26','0000-00-00 00:00:00',NULL,NULL),
(96,254,3,'2024-10-11 21:09:26','0000-00-00 00:00:00',NULL,NULL),
(97,162,3,'2024-10-11 23:34:39','0000-00-00 00:00:00',NULL,NULL),
(98,6,NULL,'2024-10-12 01:07:01','0000-00-00 00:00:00',NULL,NULL),
(99,6,NULL,'2024-10-12 01:07:12','0000-00-00 00:00:00',NULL,NULL),
(100,6,NULL,'2024-10-12 01:07:16','0000-00-00 00:00:00',NULL,NULL),
(101,6,NULL,'2024-10-12 01:07:20','0000-00-00 00:00:00',NULL,NULL),
(102,6,NULL,'2024-10-12 01:11:19','0000-00-00 00:00:00',NULL,NULL),
(103,2,NULL,'2024-10-12 02:54:21','0000-00-00 00:00:00',NULL,NULL),
(104,2,NULL,'2024-10-12 02:54:28','0000-00-00 00:00:00',NULL,NULL),
(105,2,NULL,'2024-10-12 02:54:41','0000-00-00 00:00:00',NULL,NULL),
(106,1,NULL,'2024-10-12 03:08:34','0000-00-00 00:00:00',NULL,NULL),
(107,1,NULL,'2024-10-12 03:08:38','0000-00-00 00:00:00',NULL,NULL),
(108,1,NULL,'2024-10-12 03:08:38','0000-00-00 00:00:00',NULL,NULL),
(109,1,NULL,'2024-10-12 03:08:38','0000-00-00 00:00:00',NULL,NULL),
(110,1,NULL,'2024-10-12 03:08:53','0000-00-00 00:00:00',NULL,NULL),
(111,2,NULL,'2024-10-12 03:08:56','0000-00-00 00:00:00',NULL,NULL),
(112,2,NULL,'2024-10-12 03:09:15','0000-00-00 00:00:00',NULL,NULL),
(113,2,NULL,'2024-10-12 03:31:06','0000-00-00 00:00:00',NULL,NULL),
(114,2,NULL,'2024-10-12 03:31:26','0000-00-00 00:00:00',NULL,NULL),
(115,205,1,'2024-10-12 13:01:36','0000-00-00 00:00:00',NULL,NULL),
(116,221,1,'2024-10-12 13:02:28','0000-00-00 00:00:00',NULL,NULL),
(117,2,NULL,'2024-10-12 13:47:50','0000-00-00 00:00:00',NULL,NULL),
(118,2,NULL,'2024-10-12 13:48:10','0000-00-00 00:00:00',NULL,NULL),
(119,170,2,'2024-10-12 13:58:54','0000-00-00 00:00:00',NULL,NULL),
(120,2,NULL,'2024-10-12 14:36:00','0000-00-00 00:00:00',NULL,NULL),
(121,2,NULL,'2024-10-12 14:36:03','0000-00-00 00:00:00',NULL,NULL),
(123,220,2,'2024-10-12 14:47:43','0000-00-00 00:00:00',NULL,NULL),
(124,293,1,'2024-10-12 14:55:41','0000-00-00 00:00:00',NULL,NULL),
(125,302,2,'2024-10-12 16:03:39','0000-00-00 00:00:00',NULL,NULL),
(126,291,2,'2024-10-12 16:20:27','0000-00-00 00:00:00',NULL,NULL),
(127,144,2,'2024-10-12 16:47:02','0000-00-00 00:00:00',NULL,NULL),
(128,259,1,'2024-10-12 17:48:04','0000-00-00 00:00:00',NULL,NULL),
(129,106,1,'2024-10-12 17:53:11','0000-00-00 00:00:00',NULL,NULL),
(130,279,1,'2024-10-12 17:59:45','0000-00-00 00:00:00',NULL,NULL),
(131,168,1,'2024-10-12 18:17:26','0000-00-00 00:00:00',NULL,NULL),
(132,156,1,'2024-10-12 18:22:19','0000-00-00 00:00:00',NULL,NULL),
(133,224,1,'2024-10-12 18:22:36','0000-00-00 00:00:00',NULL,NULL),
(134,197,1,'2024-10-12 18:24:12','0000-00-00 00:00:00',NULL,NULL),
(135,181,1,'2024-10-12 18:26:32','0000-00-00 00:00:00',NULL,NULL),
(136,304,1,'2024-10-12 18:40:42','0000-00-00 00:00:00',NULL,NULL),
(137,303,1,'2024-10-12 18:41:01','0000-00-00 00:00:00',NULL,NULL),
(138,307,1,'2024-10-12 18:45:01','0000-00-00 00:00:00',NULL,NULL),
(139,104,1,'2024-10-12 18:53:43','0000-00-00 00:00:00',NULL,NULL),
(140,309,1,'2024-10-12 19:03:05','0000-00-00 00:00:00',NULL,NULL),
(141,103,1,'2024-10-12 19:05:07','0000-00-00 00:00:00',NULL,NULL),
(142,301,1,'2024-10-12 19:10:42','0000-00-00 00:00:00',NULL,NULL),
(144,158,1,'2024-10-12 19:19:04','0000-00-00 00:00:00',NULL,NULL),
(145,180,1,'2024-10-12 19:19:49','0000-00-00 00:00:00',NULL,NULL),
(146,159,1,'2024-10-12 19:20:08','0000-00-00 00:00:00',NULL,NULL),
(147,53,1,'2024-10-12 19:32:18','0000-00-00 00:00:00',NULL,NULL),
(148,96,1,'2024-10-12 19:34:32','0000-00-00 00:00:00',NULL,NULL),
(149,97,1,'2024-10-12 19:34:55','0000-00-00 00:00:00',NULL,NULL),
(150,77,1,'2024-10-12 19:35:46','0000-00-00 00:00:00',NULL,NULL),
(151,15,1,'2024-10-12 19:36:22','0000-00-00 00:00:00',NULL,NULL),
(152,14,1,'2024-10-12 19:36:54','0000-00-00 00:00:00',NULL,NULL),
(154,173,1,'2024-10-12 19:44:03','0000-00-00 00:00:00',NULL,NULL),
(155,164,1,'2024-10-12 19:44:18','0000-00-00 00:00:00',NULL,NULL),
(156,196,NULL,'2024-10-12 19:45:37','0000-00-00 00:00:00',NULL,NULL),
(157,196,NULL,'2024-10-12 19:45:57','0000-00-00 00:00:00',NULL,NULL),
(158,228,NULL,'2024-10-12 19:57:05','0000-00-00 00:00:00',NULL,NULL),
(159,257,1,'2024-10-12 20:21:13','0000-00-00 00:00:00',NULL,NULL),
(160,312,3,'2024-10-12 20:35:31','0000-00-00 00:00:00',NULL,NULL),
(161,313,3,'2024-10-12 20:36:49','0000-00-00 00:00:00',NULL,NULL),
(162,314,3,'2024-10-12 20:38:24','0000-00-00 00:00:00',NULL,NULL),
(163,278,3,'2024-10-12 20:39:27','0000-00-00 00:00:00',NULL,NULL),
(164,315,3,'2024-10-12 20:42:55','0000-00-00 00:00:00',NULL,NULL),
(165,264,3,'2024-10-12 21:36:19','0000-00-00 00:00:00',NULL,NULL),
(166,323,3,'2024-10-12 22:38:35','0000-00-00 00:00:00',NULL,NULL),
(167,261,3,'2024-10-12 23:29:05','0000-00-00 00:00:00',NULL,NULL),
(168,276,1,'2024-10-13 01:36:22','0000-00-00 00:00:00',NULL,NULL),
(169,320,1,'2024-10-13 01:36:51','0000-00-00 00:00:00',NULL,NULL),
(170,124,NULL,'2024-10-13 02:46:36','0000-00-00 00:00:00',NULL,NULL),
(171,157,NULL,'2024-10-13 02:54:14','0000-00-00 00:00:00',NULL,NULL),
(172,152,NULL,'2024-10-13 03:02:27','0000-00-00 00:00:00',NULL,NULL),
(173,171,NULL,'2024-10-13 03:07:02','0000-00-00 00:00:00',NULL,NULL),
(174,191,NULL,'2024-10-13 03:12:58','0000-00-00 00:00:00',NULL,NULL),
(175,219,NULL,'2024-10-13 03:38:12','0000-00-00 00:00:00',NULL,NULL),
(176,237,NULL,'2024-10-13 03:41:25','0000-00-00 00:00:00',NULL,NULL),
(177,185,NULL,'2024-10-13 03:47:50','0000-00-00 00:00:00',NULL,NULL),
(178,241,NULL,'2024-10-13 03:50:42','0000-00-00 00:00:00',NULL,NULL),
(179,244,NULL,'2024-10-13 03:53:35','0000-00-00 00:00:00',NULL,NULL),
(180,271,NULL,'2024-10-13 03:58:38','0000-00-00 00:00:00',NULL,NULL),
(181,273,NULL,'2024-10-13 04:02:24','0000-00-00 00:00:00',NULL,NULL),
(182,282,NULL,'2024-10-13 04:04:40','0000-00-00 00:00:00',NULL,NULL),
(183,289,NULL,'2024-10-13 04:07:23','0000-00-00 00:00:00',NULL,NULL),
(184,55,NULL,'2024-10-13 04:31:46','0000-00-00 00:00:00',NULL,NULL),
(185,95,NULL,'2024-10-13 04:40:09','0000-00-00 00:00:00',NULL,NULL),
(186,11,NULL,'2024-10-13 04:43:21','0000-00-00 00:00:00',NULL,NULL),
(187,114,NULL,'2024-10-13 04:45:03','0000-00-00 00:00:00',NULL,NULL);
/*!40000 ALTER TABLE `inscripcion_pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(97,'2024-05-01-151946','App\\Database\\Migrations\\CreateTableEvents','default','App',1727912614,1),
(98,'2024-05-01-164157','App\\Database\\Migrations\\CreateTableCategories','default','App',1727912614,1),
(99,'2024-05-01-165915','App\\Database\\Migrations\\CreateTableRegistrations','default','App',1727912614,1),
(100,'2024-05-02-202913','App\\Database\\Migrations\\CreateTableUser','default','App',1727912614,1),
(101,'2024-06-02-201851','App\\Database\\Migrations\\CreateTableEventCategory','default','App',1727912614,1),
(102,'2024-06-07-141940','App\\Database\\Migrations\\CreateTablePayments','default','App',1727912614,1),
(103,'2024-06-07-143103','App\\Database\\Migrations\\CreateTablePaymentMethod','default','App',1727912614,1),
(104,'2024-06-13-142101','App\\Database\\Migrations\\CreateTableInscripcionPagos','default','App',1727912614,1),
(105,'2024-06-18-140952','App\\Database\\Migrations\\CreateTableDeposits','default','App',1727912614,1),
(106,'2024-06-25-152230','App\\Database\\Migrations\\CreateTableConfig','default','App',1727912614,1),
(107,'2024-06-25-155252','App\\Database\\Migrations\\CreateTableRejectionReasons','default','App',1727912614,1),
(108,'2024-08-24-023800','App\\Database\\Migrations\\CreateTablePagoLinea','default','App',1727912614,1),
(109,'2021-07-04-041948','CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable','default','CodeIgniter\\Settings',1727912635,2),
(110,'2021-11-14-143905','CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn','default','CodeIgniter\\Settings',1727912635,2),
(111,'2023-10-12-112040','CodeIgniter\\Queue\\Database\\Migrations\\AddQueueTables','default','CodeIgniter\\Queue',1727912635,2),
(112,'2023-11-05-064053','CodeIgniter\\Queue\\Database\\Migrations\\AddPriorityField','default','CodeIgniter\\Queue',1727912635,2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago_linea`
--

DROP TABLE IF EXISTS `pago_linea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_linea` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) unsigned NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `client_transaction_id` varchar(50) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `status_code` int(11) NOT NULL,
  `transaction_status` varchar(20) NOT NULL,
  `authorization_code` varchar(50) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `message_code` int(11) DEFAULT NULL,
  `transaction_id` int(11) NOT NULL,
  `document` varchar(50) DEFAULT NULL,
  `currency` varchar(3) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `card_type` varchar(50) DEFAULT NULL,
  `card_brand` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_id` (`payment_id`),
  CONSTRAINT `pago_linea_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_linea`
--

LOCK TABLES `pago_linea` WRITE;
/*!40000 ALTER TABLE `pago_linea` DISABLE KEYS */;
INSERT INTO `pago_linea` VALUES
(1,3,'totoyanderson7@gmail.com','1144','3620241008150948','593986763881',3,'Approved','W39206063',NULL,0,39206063,'0606248003','USD','2024-10-08 10:10:56','Debit','Visa Pichincha','2024-10-08 15:11:57',NULL,NULL,1,NULL,NULL),
(3,1,'arelisa462@gmail.com','1144','1850273291','593983861766',3,'Approved','W39235896',NULL,0,39235896,'1850273291','USD','2024-10-08 17:41:56','Debit','Visa Pichincha','2024-10-08 22:42:48',NULL,NULL,1,NULL,NULL),
(7,64,'ismaelmasabanda43@gmail.com','1144','1805064167','593960997783',3,'Approved','W39262884',NULL,0,39262884,'1805064167','USD','2024-10-09 08:41:42','Debit','Visa Pichincha','2024-10-09 21:31:42',NULL,NULL,1,NULL,NULL),
(40,2,'Marvoalvarez666@gmail.com','1684','2190250055209','593989047422',3,'Approved','W39366560',NULL,0,39366560,'0250055209','USD','2024-10-11 00:54:43','Debit','Visa Pichincha','2024-10-11 05:54:48',NULL,NULL,1,NULL,NULL),
(47,6,'dianajep23@gmail.com','1144','670605344340','593979515789',3,'Approved','W39376978',NULL,0,39376978,'1805064167','USD','2024-10-11 11:24:17','Debit','Visa Pichincha','2024-10-11 16:24:23',NULL,NULL,1,NULL,NULL),
(81,196,'Colomaalan13@gmail.com','1684','19600000000000202155743','593993759637',3,'Approved','W39425139',NULL,0,39425139,'0202155743','USD','2024-10-12 14:45:32','Debit','Visa Pichincha','2024-10-12 19:45:37',NULL,NULL,1,NULL,NULL),
(83,228,'marie_beve@hotmail.com','3305','2280202418711','593995979152',3,'Approved','W39410767',NULL,0,39410767,'1722532007','USD','2024-10-12 09:35:37','Debit','Visa Pichincha','2024-10-12 19:57:05',NULL,NULL,1,NULL,NULL),
(84,124,'carmen.leon@ueb.edu.ec','1684','1240605589076','593986466029',3,'Approved','W39356244',NULL,0,39356244,'0605589076','USD','2024-10-10 19:02:18','Credit','Mastercard Austro','2024-10-13 02:46:36',NULL,NULL,1,NULL,NULL),
(85,157,'shulizaacurio@gmail.com','1684','1570202496261','593992494186',3,'Approved','W39359822',NULL,0,39359822,'0202496261','USD','2024-10-10 20:30:13','Debit','Visa Pichincha','2024-10-13 02:54:14',NULL,NULL,1,NULL,NULL),
(86,152,'freddybenavides069@gmail.com','1684','1520202167896','593990750385',3,'Approved','W39360111',NULL,0,39360111,'0202167896','USD','2024-10-10 20:39:46','Debit','Visa Pichincha','2024-10-13 03:02:27',NULL,NULL,1,NULL,NULL),
(87,171,'scarlethbonilla068@gmail.com','1684','1710202406724','593988476445',3,'Approved','W39360363',NULL,0,39360363,'0202406732','USD','2024-10-10 20:47:05','Debit','Visa Pichincha','2024-10-13 03:07:02',NULL,NULL,1,NULL,NULL),
(88,191,'erikita.1999020@gmail.com','1684','1910202327086','593969669873',3,'Approved','W39361227',NULL,0,39361227,'0202216313','USD','2024-10-10 21:15:08','Debit','Visa Pichincha','2024-10-13 03:12:58',NULL,NULL,1,NULL,NULL),
(89,219,'Marvoalvarez666@gmail.com','1684','2190250055209','593989047422',3,'Approved','W39366560',NULL,0,39366560,'0250055209','USD','2024-10-11 00:54:43','Debit','Visa Pichincha','2024-10-13 03:38:12',NULL,NULL,1,NULL,NULL),
(90,237,'lorenavlsc787@gmail.com','1684','2370202059481','593991912914',3,'Approved','W39371907',NULL,0,39371907,'0202283727','USD','2024-10-11 09:21:59','Debit','Visa Pichincha','2024-10-13 03:41:25',NULL,NULL,1,NULL,NULL),
(91,185,'kareliyanez@mailes.ueb.edu.ec','1684','1850202384004','593962896268',3,'Approved','W39377799',NULL,0,39377799,'0202384004','USD','2024-10-11 11:43:27','Debit','Visa Pichincha','2024-10-13 03:47:50',NULL,NULL,1,NULL,NULL),
(92,241,'maikelsalguero08@gmail.com','1684','2410250133527','593990589618',3,'Approved','W39377752',NULL,0,39377752,'0250133527','USD','2024-10-11 11:42:01','Debit','Visa Pichincha','2024-10-13 03:50:42',NULL,NULL,1,NULL,NULL),
(93,244,'mirleyfranco08@gmail.com','1684','2440202210530','593960068935',3,'Approved','W39379558',NULL,0,39379558,'0202210530','USD','2024-10-11 12:23:06','Debit','Visa Pichincha','2024-10-13 03:53:35',NULL,NULL,1,NULL,NULL),
(94,271,'davidbacan2003@gmail.com','1684','2711805291919','593984186984',3,'Approved','W39400324',NULL,0,39400324,'1805291919','USD','2024-10-11 21:54:16','Debit','Visa Pichincha','2024-10-13 03:58:38',NULL,NULL,1,NULL,NULL),
(95,273,'rafael13cando@gmail.com','1684','2730953087459','593992030729',3,'Approved','W39400674',NULL,0,39400674,'0953087459','USD','2024-10-11 22:08:50','Debit','Visa Pichincha','2024-10-13 04:02:24',NULL,NULL,1,NULL,NULL),
(96,282,'ceciliameneses1984@gmail.com','1684','2821251110118','593992055980',3,'Approved','W39401290',NULL,0,39401290,'1205133612','USD','2024-10-11 22:31:00','Debit','Mastercard Guayaquil','2024-10-13 04:04:40',NULL,NULL,1,NULL,NULL),
(97,289,'franklinquishpe04@gmail.com','1684','2890550157200','593959456333',3,'Approved','W39409241',NULL,0,39409241,'0550157200','USD','2024-10-12 08:47:45','Debit','Visa Pichincha','2024-10-13 04:07:23',NULL,NULL,1,NULL,NULL),
(98,55,'arelisa462@gmail.com','1144','1850273291','593983861766',3,'Approved','W39235896',NULL,0,39235896,'1850273291','USD','2024-10-08 17:41:56','Debit','Visa Pichincha','2024-10-13 04:31:46',NULL,NULL,1,NULL,NULL),
(99,95,'valeriaemely@gmail.com','1144','951750947630','593985515325',3,'Approved','W39332317',NULL,0,39332317,'1716094956','USD','2024-10-10 14:05:11','Credit','Mastercard BANCO DEL PACIFICO, S.A. (EC)','2024-10-13 04:40:09',NULL,NULL,1,NULL,NULL),
(100,11,'maria.viera@ueb.edu.ec','1144','1141804522850','593994400003',3,'Approved','W39353345',NULL,0,39353345,'1804522850','USD','2024-10-10 18:09:35','Debit','Visa Pichincha','2024-10-13 04:43:21',NULL,NULL,1,NULL,NULL),
(101,114,'maria.viera@ueb.edu.ec','1144','1141804522850','593994400003',3,'Approved','W39353345',NULL,0,39353345,'1804522850','USD','2024-10-10 18:09:35','Debit','Visa Pichincha','2024-10-13 04:45:03',NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `pago_linea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES
(1,'Deposito','Pago por deposito',1),
(2,'Pago físico','Pago en puntos de pago',1),
(3,'Pago en linea','Pago en el sistema de inscripción',1);
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_register` int(10) unsigned DEFAULT NULL,
  `amount_pay` decimal(10,2) DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL COMMENT 'Estado del pago (Pendiente,Completado,Fallido,EnProceso,Cancelado)',
  `date_time_payment` date DEFAULT NULL,
  `payment_cod` int(11) NOT NULL,
  `address_payment` int(11) DEFAULT NULL,
  `payment_time_limit` date NOT NULL,
  `payment_method_id` int(10) unsigned DEFAULT NULL,
  `num_autorizacion` varchar(50) DEFAULT NULL,
  `precio_unitario` double(10,2) DEFAULT NULL,
  `valor_total` double(10,2) DEFAULT NULL,
  `total` double(10,2) DEFAULT NULL,
  `sub_total` double(10,2) DEFAULT NULL,
  `sub_total_0` double(10,2) DEFAULT NULL,
  `sub_total_15` double(10,2) DEFAULT NULL,
  `iva` double(10,2) DEFAULT NULL,
  `send_email` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_id_register_foreign` (`id_register`),
  KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  CONSTRAINT `payments_id_register_foreign` FOREIGN KEY (`id_register`) REFERENCES `registrations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES
(1,1,20.59,2,'2024-10-12',9070746,NULL,'2024-10-11',3,'81733039451677637262697990005126190294157619289012',0.51,0.51,0.59,20.51,20.00,0.51,0.08,NULL,'2024-10-04 00:57:23','2024-10-12 03:08:53',NULL,1,NULL,NULL),
(2,2,10.59,2,'2024-10-12',8741313,NULL,'2024-10-11',3,'69059744665277098504218444749210381291660197637736',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-04 22:10:38','2024-10-12 14:36:03',NULL,1,NULL,NULL),
(3,3,10.59,2,'2024-10-08',6931490,NULL,'2024-10-12',3,'78510399377913034363861041718724134995693669642875',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-05 02:00:51','2024-10-08 15:12:17',NULL,1,NULL,NULL),
(4,4,10.59,2,'2024-10-10',2758085,NULL,'2024-10-13',1,'79432678950808401779965962165508925896839223613816',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-06 00:57:44','2024-10-10 14:13:19',NULL,1,NULL,NULL),
(6,6,10.59,2,'2024-10-12',1705747,NULL,'2024-10-13',3,'25252713857498225858072091188582287085808305713712',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-06 01:05:42','2024-10-12 01:11:19',NULL,1,NULL,NULL),
(7,7,NULL,1,NULL,6253051,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-06 01:27:33','2024-10-06 01:27:33',NULL,1,NULL,NULL),
(8,8,NULL,1,NULL,2041586,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-06 01:32:38','2024-10-06 01:32:38',NULL,1,NULL,NULL),
(9,9,10.59,2,'2024-10-07',7821695,NULL,'2024-10-13',1,'72836733181407160422967042208933181785963043547405',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-06 17:38:15','2024-10-07 14:05:17',NULL,1,NULL,NULL),
(10,10,NULL,6,NULL,6085330,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 00:17:59','2024-10-10 22:41:19',NULL,1,NULL,NULL),
(11,11,NULL,1,'2024-10-13',5466528,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 00:19:16','2024-10-13 04:43:21',NULL,1,NULL,NULL),
(12,12,NULL,1,NULL,4577808,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 00:24:19','2024-10-07 00:24:19',NULL,1,NULL,NULL),
(13,13,NULL,1,NULL,2927162,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 18:17:29','2024-10-07 18:17:29',NULL,1,NULL,NULL),
(14,14,10.59,2,'2024-10-12',9427819,NULL,'2024-10-14',2,'43120612648118048949640926602001140806501348276472',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-07 18:31:50','2024-10-12 19:36:54',NULL,1,NULL,NULL),
(15,15,10.59,2,'2024-10-12',1158397,NULL,'2024-10-14',2,'25415389609194853711849919480915784154702374341102',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-07 18:34:14','2024-10-12 19:36:22',NULL,1,NULL,NULL),
(16,16,NULL,1,NULL,9027437,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 19:00:40','2024-10-07 19:00:40',NULL,1,NULL,NULL),
(17,17,NULL,1,NULL,4321137,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 19:10:26','2024-10-07 19:10:26',NULL,1,NULL,NULL),
(18,18,NULL,1,NULL,1543448,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 19:36:30','2024-10-07 19:36:30',NULL,1,NULL,NULL),
(19,19,10.59,2,'2024-10-10',5633215,NULL,'2024-10-14',1,'61782653683581992091395351909950041939928417156646',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-07 21:01:02','2024-10-10 21:39:49',NULL,1,NULL,NULL),
(20,20,NULL,1,NULL,7093067,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 21:10:50','2024-10-07 21:10:50',NULL,1,NULL,NULL),
(21,21,NULL,1,NULL,7856954,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 21:12:05','2024-10-07 21:12:05',NULL,1,NULL,NULL),
(22,22,NULL,1,NULL,2097222,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 21:19:07','2024-10-07 21:19:07',NULL,1,NULL,NULL),
(23,23,NULL,1,NULL,2010888,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 21:41:35','2024-10-07 21:41:35',NULL,1,NULL,NULL),
(24,24,NULL,1,NULL,6952393,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 22:32:17','2024-10-07 22:32:17',NULL,1,NULL,NULL),
(25,25,NULL,1,NULL,7859024,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 22:32:55','2024-10-07 22:32:55',NULL,1,NULL,NULL),
(26,26,NULL,1,NULL,3756623,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-07 22:34:09','2024-10-07 22:34:09',NULL,1,NULL,NULL),
(27,27,10.59,2,'2024-10-09',2980098,NULL,'2024-10-14',2,'98325710735556884298444834105996642083057719119475',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-07 22:56:01','2024-10-09 23:02:44',NULL,1,NULL,NULL),
(28,28,10.59,2,'2024-10-10',5954525,NULL,'2024-10-15',1,'24519481622264120270512550514484391714439303860822',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-08 00:32:47','2024-10-10 21:40:22',NULL,1,NULL,NULL),
(29,29,NULL,5,NULL,5950017,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 00:54:58','2024-10-10 22:09:50',NULL,1,NULL,NULL),
(30,30,NULL,1,NULL,2804230,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 01:10:50','2024-10-08 01:10:50',NULL,1,NULL,NULL),
(31,31,NULL,1,NULL,5036217,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 01:19:26','2024-10-08 01:19:26',NULL,1,NULL,NULL),
(32,32,NULL,1,NULL,7268423,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 01:20:20','2024-10-08 01:20:20',NULL,1,NULL,NULL),
(33,33,NULL,1,NULL,1444442,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 02:09:52','2024-10-08 02:09:52',NULL,1,NULL,NULL),
(34,34,NULL,1,NULL,5553753,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 12:56:33','2024-10-08 12:56:33',NULL,1,NULL,NULL),
(35,35,NULL,1,NULL,5675365,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 12:56:57','2024-10-08 12:56:57',NULL,1,NULL,NULL),
(36,36,NULL,1,NULL,8426627,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 12:57:48','2024-10-08 12:57:48',NULL,1,NULL,NULL),
(37,37,20.59,2,'2024-10-08',4099928,NULL,'2024-10-15',2,'43329577048533240350792605574480679777908650907313',0.51,0.51,0.59,20.51,20.00,0.51,0.08,NULL,'2024-10-08 13:24:53','2024-10-08 13:26:14',NULL,1,NULL,NULL),
(38,38,10.59,2,'2024-10-08',4989162,NULL,'2024-10-15',2,'44221933387375219912540591518693444603172760831687',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-08 15:17:54','2024-10-08 16:00:20',NULL,1,NULL,NULL),
(39,39,10.59,2,'2024-10-08',4408884,NULL,'2024-10-15',2,'11946259434741690556858637341584839279583368314591',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-08 15:19:12','2024-10-08 16:01:41',NULL,1,NULL,NULL),
(40,40,10.59,2,'2024-10-08',1444893,NULL,'2024-10-15',1,'03106652062829373238316190519276436289459051894100',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-08 15:21:03','2024-10-08 21:41:50',NULL,1,NULL,NULL),
(41,41,NULL,1,NULL,6948600,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 15:24:49','2024-10-08 15:24:49',NULL,1,NULL,NULL),
(42,42,NULL,1,NULL,6343389,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 15:32:00','2024-10-08 15:32:00',NULL,1,NULL,NULL),
(43,43,10.59,2,'2024-10-08',9057047,NULL,'2024-10-15',2,'92560317455949986944092461152036987586732033634388',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-08 15:36:16','2024-10-08 16:02:10',NULL,1,NULL,NULL),
(44,44,NULL,1,NULL,7581063,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 15:38:43','2024-10-08 15:38:43',NULL,1,NULL,NULL),
(45,45,NULL,1,NULL,2000129,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 16:47:34','2024-10-08 16:47:34',NULL,1,NULL,NULL),
(46,46,10.59,2,'2024-10-08',7063487,NULL,'2024-10-15',1,'89740025064966316214804072505118693571058340682110',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-08 21:04:28','2024-10-08 21:44:22',NULL,1,NULL,NULL),
(47,47,NULL,1,NULL,7084570,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 21:53:03','2024-10-08 21:53:03',NULL,1,NULL,NULL),
(48,48,NULL,1,NULL,1815472,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 21:53:21','2024-10-08 21:53:21',NULL,1,NULL,NULL),
(49,49,NULL,1,NULL,7175183,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 21:58:58','2024-10-08 21:58:58',NULL,1,NULL,NULL),
(50,50,10.59,2,'2024-10-10',7895765,NULL,'2024-10-15',1,'43609599714513413943344532886455896175672604068630',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-08 21:59:10','2024-10-10 23:45:14',NULL,1,NULL,NULL),
(51,51,NULL,1,NULL,1515995,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 21:59:42','2024-10-08 21:59:42',NULL,1,NULL,NULL),
(52,52,NULL,1,NULL,5895825,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 22:01:32','2024-10-08 22:01:32',NULL,1,NULL,NULL),
(53,53,10.59,2,'2024-10-12',9894968,NULL,'2024-10-15',2,'88903440279723238197719890722777753969747169835803',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-08 22:03:45','2024-10-12 19:32:18',NULL,1,NULL,NULL),
(54,54,NULL,1,NULL,6282499,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 22:12:10','2024-10-08 22:12:10',NULL,1,NULL,NULL),
(55,55,10.59,2,'2024-10-13',4202753,NULL,'2024-10-15',3,'68420343793630000415338508923915051170348968372015',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-08 22:37:48','2024-10-13 04:31:46',NULL,1,NULL,NULL),
(56,56,NULL,1,NULL,9691418,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 22:47:48','2024-10-08 22:47:48',NULL,1,NULL,NULL),
(57,57,NULL,1,NULL,5689908,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 23:24:44','2024-10-08 23:24:44',NULL,1,NULL,NULL),
(58,58,NULL,1,NULL,4825251,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-08 23:26:44','2024-10-08 23:26:44',NULL,1,NULL,NULL),
(59,59,10.59,2,'2024-10-11',8613594,NULL,'2024-10-15',1,'34466800284253620131178671278840128809609076738154',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-09 00:07:47','2024-10-11 19:10:03',NULL,1,NULL,NULL),
(60,60,NULL,1,NULL,2376575,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 00:10:04','2024-10-09 00:10:04',NULL,1,NULL,NULL),
(61,61,10.59,2,'2024-10-10',6668521,NULL,'2024-10-15',2,'81674957597405146811417005850934740585143143998322',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-09 00:30:21','2024-10-10 19:58:59',NULL,1,NULL,NULL),
(62,62,NULL,1,NULL,6675685,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 00:32:31','2024-10-09 00:32:31',NULL,1,NULL,NULL),
(63,63,NULL,1,NULL,9716927,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 03:18:21','2024-10-09 03:18:21',NULL,1,NULL,NULL),
(64,64,10.59,2,'2024-10-09',5438211,NULL,'2024-10-15',3,'06538002174995087537800873894837440966702173169501',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-09 10:46:21','2024-10-09 10:46:21',NULL,1,NULL,NULL),
(65,65,NULL,1,NULL,2519371,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 10:54:34','2024-10-09 10:54:34',NULL,1,NULL,NULL),
(66,66,NULL,1,NULL,8044955,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 12:57:55','2024-10-09 12:57:55',NULL,1,NULL,NULL),
(67,67,NULL,1,NULL,2125860,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 13:06:14','2024-10-09 13:06:14',NULL,1,NULL,NULL),
(68,68,NULL,1,NULL,5970139,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 15:37:45','2024-10-09 15:37:45',NULL,1,NULL,NULL),
(69,69,NULL,1,NULL,3756796,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 15:38:20','2024-10-09 15:38:20',NULL,1,NULL,NULL),
(70,70,NULL,1,NULL,8037380,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 15:39:08','2024-10-09 15:39:08',NULL,1,NULL,NULL),
(71,71,NULL,1,NULL,2454850,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 15:40:37','2024-10-09 15:40:37',NULL,1,NULL,NULL),
(72,72,NULL,1,NULL,8906563,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 15:41:09','2024-10-09 15:41:09',NULL,1,NULL,NULL),
(73,73,10.59,2,'2024-10-09',4405151,NULL,'2024-10-15',2,'92825021020854155392347984228681803852225636568210',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-09 15:53:54','2024-10-09 20:58:40',NULL,1,NULL,NULL),
(74,74,10.59,2,'2024-10-09',1565232,NULL,'2024-10-15',2,'38323494812502844786768153829257728643391879191807',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-09 16:10:03','2024-10-09 16:16:43',NULL,1,NULL,NULL),
(75,75,20.59,2,'2024-10-10',3247253,NULL,'2024-10-15',2,'54229571953080980874662867750262513384806684741356',0.51,0.51,0.59,20.51,20.00,0.51,0.08,NULL,'2024-10-09 22:29:51','2024-10-10 20:06:04',NULL,1,NULL,NULL),
(76,76,10.59,2,'2024-10-10',8713608,NULL,'2024-10-15',1,'01096634636782553282980600695583061572194464898958',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-09 22:52:23','2024-10-10 14:14:35',NULL,1,NULL,NULL),
(77,77,10.59,2,'2024-10-12',2851900,NULL,'2024-10-15',2,'42298466405936258237028147555105725549912815611815',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-09 22:57:10','2024-10-12 19:35:46',NULL,1,NULL,NULL),
(78,78,NULL,1,NULL,5473148,NULL,'2024-10-16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-09 23:36:37','2024-10-09 23:36:37',NULL,1,NULL,NULL),
(79,79,NULL,1,NULL,8314862,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 00:40:21','2024-10-10 00:40:21',NULL,1,NULL,NULL),
(80,80,NULL,1,NULL,2727196,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 00:41:45','2024-10-10 00:41:45',NULL,1,NULL,NULL),
(81,81,NULL,1,NULL,2512707,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 00:42:13','2024-10-10 00:42:13',NULL,1,NULL,NULL),
(82,82,NULL,1,NULL,5962615,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 03:08:57','2024-10-10 03:08:57',NULL,1,NULL,NULL),
(83,83,NULL,1,NULL,5796547,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 03:15:20','2024-10-10 03:15:20',NULL,1,NULL,NULL),
(84,84,NULL,1,NULL,3784953,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 11:31:57','2024-10-10 11:31:57',NULL,1,NULL,NULL),
(85,85,NULL,1,NULL,1457960,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 11:51:14','2024-10-10 11:51:14',NULL,1,NULL,NULL),
(86,86,NULL,1,NULL,9263036,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 11:58:36','2024-10-10 11:58:36',NULL,1,NULL,NULL),
(87,87,NULL,1,NULL,9475884,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 12:26:16','2024-10-10 12:26:16',NULL,1,NULL,NULL),
(88,88,NULL,1,NULL,6868329,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 12:29:01','2024-10-10 12:29:01',NULL,1,NULL,NULL),
(89,89,NULL,1,NULL,8402297,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 13:29:07','2024-10-10 13:29:07',NULL,1,NULL,NULL),
(90,90,10.59,2,'2024-10-10',8312829,NULL,'2024-10-15',1,'75849400254965383422161296668303765695030339781604',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-10 13:49:07','2024-10-10 14:14:00',NULL,1,NULL,NULL),
(91,91,NULL,1,NULL,3542662,NULL,'2024-10-17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 14:42:00','2024-10-10 14:42:00',NULL,1,NULL,NULL),
(92,92,15.59,2,'2024-10-10',7872521,NULL,'2024-10-13',2,'23779774849254712434280350574755683547641659035470',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 15:48:25','2024-10-10 23:24:40',NULL,1,NULL,NULL),
(93,93,15.59,2,'2024-10-10',7916105,NULL,'2024-10-13',2,'06246027647020432891540197512616329461339578978706',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 15:50:51','2024-10-10 23:19:17',NULL,1,NULL,NULL),
(94,94,NULL,1,NULL,8768691,NULL,'2024-10-17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 18:24:39','2024-10-10 18:24:39',NULL,1,NULL,NULL),
(95,95,10.59,2,'2024-10-13',6330850,NULL,'2024-10-17',3,'48002473112396872618559419481804991536026121564453',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-10 18:59:16','2024-10-13 04:40:09',NULL,1,NULL,NULL),
(96,96,20.59,2,'2024-10-12',6564238,NULL,'2024-10-15',2,'93938659895610451375304107594506669474913408979595',0.51,0.51,0.59,20.51,20.00,0.51,0.08,NULL,'2024-10-10 19:13:38','2024-10-12 19:34:32',NULL,1,NULL,NULL),
(97,97,20.59,2,'2024-10-12',4451551,NULL,'2024-10-15',2,'09668954654916372813354325216306787015521731753551',0.51,0.51,0.59,20.51,20.00,0.51,0.08,NULL,'2024-10-10 19:15:35','2024-10-12 19:34:55',NULL,1,NULL,NULL),
(98,98,NULL,1,NULL,9904136,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 19:26:33','2024-10-10 19:26:33',NULL,1,NULL,NULL),
(99,99,NULL,1,NULL,4397328,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 19:34:45','2024-10-10 19:34:45',NULL,1,NULL,NULL),
(100,100,NULL,1,NULL,3734297,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 19:52:43','2024-10-10 19:52:43',NULL,1,NULL,NULL),
(101,101,NULL,1,NULL,9534733,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 19:53:46','2024-10-10 19:53:46',NULL,1,NULL,NULL),
(102,102,NULL,1,NULL,8992193,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 19:58:01','2024-10-10 19:58:01',NULL,1,NULL,NULL),
(103,103,20.59,2,'2024-10-12',4930103,NULL,'2024-10-15',2,'80243564105506476796467663043570078677348260907514',0.51,0.51,0.59,20.51,20.00,0.51,0.08,NULL,'2024-10-10 20:28:17','2024-10-12 19:05:07',NULL,1,NULL,NULL),
(104,104,20.59,2,'2024-10-12',2018164,NULL,'2024-10-15',2,'97025841262827447667838634407115905214855354642233',0.51,0.51,0.59,20.51,20.00,0.51,0.08,NULL,'2024-10-10 20:31:21','2024-10-12 18:53:43',NULL,1,NULL,NULL),
(105,105,NULL,1,NULL,2083204,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 20:37:41','2024-10-10 20:37:41',NULL,1,NULL,NULL),
(106,106,20.59,2,'2024-10-12',5178195,NULL,'2024-10-15',1,'29503966667922306077891513433089435415320603348478',0.51,0.51,0.59,20.51,20.00,0.51,0.08,1,'2024-10-10 21:08:33','2024-10-12 17:53:12',NULL,1,NULL,NULL),
(107,107,NULL,5,NULL,8629533,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 21:08:40','2024-10-10 22:34:55',NULL,1,NULL,NULL),
(108,108,15.59,2,'2024-10-10',1280631,NULL,'2024-10-13',2,'46817071679476159170537171398091987892262327234744',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 21:36:40','2024-10-10 21:38:04',NULL,1,NULL,NULL),
(109,109,15.59,2,'2024-10-10',6500339,NULL,'2024-10-13',2,'28502330189135389327854415384390904992140574424610',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 21:54:16','2024-10-10 21:55:22',NULL,1,NULL,NULL),
(110,110,NULL,1,NULL,9148572,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 22:01:23','2024-10-10 22:01:23',NULL,1,NULL,NULL),
(111,111,NULL,1,NULL,2812743,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 22:31:33','2024-10-10 22:31:33',NULL,1,NULL,NULL),
(112,112,NULL,1,NULL,4802875,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 22:36:35','2024-10-10 22:36:35',NULL,1,NULL,NULL),
(113,113,NULL,1,NULL,3262991,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 22:42:01','2024-10-10 22:42:01',NULL,1,NULL,NULL),
(114,114,10.59,2,'2024-10-13',6044248,NULL,'2024-10-17',3,'08643331016968953405640535204271210314126993223955',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-10 22:46:14','2024-10-13 04:45:03',NULL,1,NULL,NULL),
(115,115,NULL,1,NULL,2515995,NULL,'2024-10-17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 23:05:04','2024-10-10 23:05:04',NULL,1,NULL,NULL),
(116,116,15.59,2,'2024-10-10',1664251,NULL,'2024-10-13',2,'46848798572297612070383897917427530053368275190386',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 23:07:24','2024-10-10 23:22:20',NULL,1,NULL,NULL),
(117,117,15.59,2,'2024-10-10',5293165,NULL,'2024-10-13',2,'36533741152268827496603237915594591186078104555655',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 23:07:27','2024-10-10 23:28:14',NULL,1,NULL,NULL),
(118,118,NULL,1,NULL,3114235,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 23:07:33','2024-10-10 23:07:33',NULL,1,NULL,NULL),
(119,119,15.59,2,'2024-10-10',4514064,NULL,'2024-10-13',2,'55050127650591893036007460622195647563660131497418',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 23:08:05','2024-10-10 23:27:24',NULL,1,NULL,NULL),
(120,120,10.59,2,'2024-10-11',4875446,NULL,'2024-10-17',2,'52372991574014730889594221357743865228649704173403',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-10 23:44:24','2024-10-11 00:06:35',NULL,1,NULL,NULL),
(121,121,NULL,1,NULL,6905163,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 23:45:48','2024-10-10 23:45:48',NULL,1,NULL,NULL),
(122,122,NULL,1,NULL,4831753,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 23:46:09','2024-10-10 23:46:09',NULL,1,NULL,NULL),
(123,123,NULL,1,NULL,8820118,NULL,'2024-10-17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-10 23:51:45','2024-10-10 23:51:45',NULL,1,NULL,NULL),
(124,124,15.59,2,'2024-10-13',6940611,NULL,'2024-10-13',3,'72208080736170192414547074690310580830543204694836',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-10 23:59:06','2024-10-13 02:46:36',NULL,1,NULL,NULL),
(125,125,15.59,2,'2024-10-11',6325103,NULL,'2024-10-13',2,'73304731075988644083471992958026954847408654915527',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 00:03:05','2024-10-11 00:08:22',NULL,1,NULL,NULL),
(126,126,NULL,1,NULL,2076547,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:03:28','2024-10-11 00:03:28',NULL,1,NULL,NULL),
(127,127,15.59,2,'2024-10-11',1338193,NULL,'2024-10-13',2,'25629723218830767705974647538051902877974220166580',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 00:03:50','2024-10-11 00:09:01',NULL,1,NULL,NULL),
(128,128,NULL,1,NULL,9629779,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:04:01','2024-10-11 00:04:01',NULL,1,NULL,NULL),
(129,129,15.59,2,'2024-10-11',2706524,NULL,'2024-10-13',2,'76984138336283460396731150399678242607864920533515',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 00:04:18','2024-10-11 00:10:56',NULL,1,NULL,NULL),
(130,130,NULL,1,NULL,4934689,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:11:18','2024-10-11 00:11:18',NULL,1,NULL,NULL),
(131,131,NULL,1,NULL,5043118,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:22:41','2024-10-11 00:22:41',NULL,1,NULL,NULL),
(132,132,10.59,2,'2024-10-11',4725530,NULL,'2024-10-18',2,'79460920162225849321031103870640249234829713450744',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-11 00:25:39','2024-10-11 00:28:06',NULL,1,NULL,NULL),
(133,133,NULL,1,NULL,7838694,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:37:56','2024-10-11 00:37:56',NULL,1,NULL,NULL),
(134,134,NULL,1,NULL,2669576,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:39:52','2024-10-11 00:39:52',NULL,1,NULL,NULL),
(135,135,NULL,1,NULL,9034108,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:40:55','2024-10-11 00:40:55',NULL,1,NULL,NULL),
(136,136,NULL,1,NULL,6033375,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:42:00','2024-10-11 00:42:00',NULL,1,NULL,NULL),
(137,137,NULL,1,NULL,3534645,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:44:41','2024-10-11 00:44:41',NULL,1,NULL,NULL),
(138,138,NULL,1,NULL,6305982,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:44:43','2024-10-11 00:44:43',NULL,1,NULL,NULL),
(139,139,NULL,1,NULL,9157200,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:45:32','2024-10-11 00:45:32',NULL,1,NULL,NULL),
(140,140,NULL,1,NULL,9305477,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 00:45:46','2024-10-11 00:45:46',NULL,1,NULL,NULL),
(141,141,NULL,1,NULL,5986067,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:03:39','2024-10-11 01:03:39',NULL,1,NULL,NULL),
(142,142,NULL,1,NULL,9302467,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:17:24','2024-10-11 01:17:24',NULL,1,NULL,NULL),
(143,143,NULL,1,NULL,9482353,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:19:26','2024-10-11 01:19:26',NULL,1,NULL,NULL),
(144,144,15.59,2,'2024-10-12',3190433,NULL,'2024-10-13',2,'43015921419394091626004954902548234252151885498735',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:21:44','2024-10-12 16:47:02',NULL,1,NULL,NULL),
(145,145,NULL,1,NULL,1961228,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:22:08','2024-10-11 01:22:08',NULL,1,NULL,NULL),
(146,146,NULL,1,NULL,1577384,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:22:12','2024-10-11 01:22:12',NULL,1,NULL,NULL),
(147,147,NULL,1,NULL,2168347,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:22:18','2024-10-11 01:22:18',NULL,1,NULL,NULL),
(148,148,NULL,1,NULL,7128007,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:22:44','2024-10-11 01:22:44',NULL,1,NULL,NULL),
(150,150,NULL,1,NULL,3320788,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:23:45','2024-10-11 01:23:45',NULL,1,NULL,NULL),
(151,151,NULL,1,NULL,3677237,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:24:03','2024-10-11 01:24:03',NULL,1,NULL,NULL),
(152,152,15.59,2,'2024-10-13',5677673,NULL,'2024-10-13',3,'88386355603851672488177716308810815957209713860396',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:24:49','2024-10-13 03:02:27',NULL,1,NULL,NULL),
(153,153,NULL,1,NULL,6981795,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:24:51','2024-10-11 01:24:51',NULL,1,NULL,NULL),
(154,154,NULL,1,NULL,7624486,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:25:00','2024-10-11 01:25:00',NULL,1,NULL,NULL),
(155,155,NULL,1,NULL,8442574,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:26:53','2024-10-11 01:26:53',NULL,1,NULL,NULL),
(156,156,15.59,2,'2024-10-12',5956376,NULL,'2024-10-13',2,'43183497874749022778817621610361107898831853362958',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:27:38','2024-10-12 18:22:19',NULL,1,NULL,NULL),
(157,157,15.59,2,'2024-10-13',5997042,NULL,'2024-10-13',3,'21672022406717429428411088271677081502486041752918',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:27:41','2024-10-13 02:54:14',NULL,1,NULL,NULL),
(158,158,15.59,2,'2024-10-12',5266761,NULL,'2024-10-13',2,'38012101060523277630533156655019318232135545609746',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:29:24','2024-10-12 19:19:04',NULL,1,NULL,NULL),
(159,159,15.59,2,'2024-10-12',2221294,NULL,'2024-10-13',2,'33284331011858796941183992659404681243175849446473',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:30:42','2024-10-12 19:20:08',NULL,1,NULL,NULL),
(160,160,NULL,1,NULL,7791081,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:33:28','2024-10-11 01:33:28',NULL,1,NULL,NULL),
(161,161,NULL,1,NULL,1916308,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:34:07','2024-10-11 01:34:07',NULL,1,NULL,NULL),
(162,162,15.59,2,'2024-10-11',9053179,NULL,'2024-10-13',2,'25955988354946137322303757734786112106379452189700',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:34:35','2024-10-11 23:34:39',NULL,1,NULL,NULL),
(163,163,NULL,1,NULL,8344428,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:35:55','2024-10-11 01:35:55',NULL,1,NULL,NULL),
(164,164,15.59,2,'2024-10-12',9944838,NULL,'2024-10-13',2,'35871554651980350235177424917350275866673027735484',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:36:00','2024-10-12 19:44:18',NULL,1,NULL,NULL),
(166,166,NULL,1,NULL,4725664,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:36:38','2024-10-11 01:36:38',NULL,1,NULL,NULL),
(167,167,NULL,1,NULL,3262523,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:37:08','2024-10-11 01:37:08',NULL,1,NULL,NULL),
(168,168,15.59,2,'2024-10-12',2956153,NULL,'2024-10-13',2,'03600517054709074756589194653651512759875507715608',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:38:25','2024-10-12 18:17:26',NULL,1,NULL,NULL),
(169,169,NULL,1,NULL,2917239,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:38:56','2024-10-11 01:38:56',NULL,1,NULL,NULL),
(170,170,15.59,2,'2024-10-12',7406949,NULL,'2024-10-13',2,'84928073771348396824304817142619354536324614605070',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:39:02','2024-10-12 13:58:54',NULL,1,NULL,NULL),
(171,171,15.59,2,'2024-10-13',3916868,NULL,'2024-10-13',3,'95044422114038300483925388856245776567643801011773',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:40:34','2024-10-13 03:07:02',NULL,1,NULL,NULL),
(172,172,NULL,1,NULL,2363481,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:42:09','2024-10-11 01:42:09',NULL,1,NULL,NULL),
(173,173,15.59,2,'2024-10-12',5605138,NULL,'2024-10-13',2,'22121666849416701598830438222670570702340746908152',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:42:45','2024-10-12 19:44:02',NULL,1,NULL,NULL),
(174,174,NULL,1,NULL,9993608,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:46:25','2024-10-11 01:46:25',NULL,1,NULL,NULL),
(175,175,NULL,1,NULL,4731519,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:47:30','2024-10-11 01:47:30',NULL,1,NULL,NULL),
(176,176,NULL,1,NULL,1472315,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:47:31','2024-10-11 01:47:31',NULL,1,NULL,NULL),
(177,177,NULL,1,NULL,1471778,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:47:41','2024-10-11 01:47:41',NULL,1,NULL,NULL),
(178,178,NULL,1,NULL,4952941,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:48:11','2024-10-11 01:48:11',NULL,1,NULL,NULL),
(179,179,15.59,2,'2024-10-11',5185261,NULL,'2024-10-13',1,'93168516272889323546677129713380130328175652921132',0.51,0.51,0.59,15.51,15.00,0.51,0.08,1,'2024-10-11 01:49:31','2024-10-11 19:10:35',NULL,1,NULL,NULL),
(180,180,15.59,2,'2024-10-12',7636971,NULL,'2024-10-13',2,'46016531676757244745617696461894338026621606476501',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:51:18','2024-10-12 19:19:49',NULL,1,NULL,NULL),
(181,181,15.59,2,'2024-10-12',2701269,NULL,'2024-10-13',2,'43662635720149972351252190737625664340667166277136',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 01:53:41','2024-10-12 18:26:32',NULL,1,NULL,NULL),
(182,182,NULL,1,NULL,6760249,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 01:58:19','2024-10-11 01:58:19',NULL,1,NULL,NULL),
(183,183,NULL,1,NULL,6606898,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:01:50','2024-10-11 02:01:50',NULL,1,NULL,NULL),
(184,184,NULL,1,NULL,6831430,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:01:57','2024-10-11 02:01:57',NULL,1,NULL,NULL),
(185,185,15.59,2,'2024-10-13',4826989,NULL,'2024-10-13',3,'93397868825113712281580544342258614995631712703966',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 02:01:57','2024-10-13 03:47:50',NULL,1,NULL,NULL),
(186,186,NULL,1,NULL,1273230,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:02:03','2024-10-11 02:02:03',NULL,1,NULL,NULL),
(187,187,NULL,1,NULL,7332562,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:02:06','2024-10-11 02:02:06',NULL,1,NULL,NULL),
(188,188,NULL,1,NULL,6478933,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:02:21','2024-10-11 02:02:21',NULL,1,NULL,NULL),
(189,189,NULL,1,NULL,4099786,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:04:23','2024-10-11 02:04:23',NULL,1,NULL,NULL),
(190,190,NULL,1,NULL,2535122,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:05:27','2024-10-11 02:05:27',NULL,1,NULL,NULL),
(191,191,15.59,2,'2024-10-13',6642806,NULL,'2024-10-13',3,'81120304193297289268621575066360397685094971892512',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 02:10:28','2024-10-13 03:12:58',NULL,1,NULL,NULL),
(192,192,NULL,1,NULL,2584111,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:10:34','2024-10-11 02:10:34',NULL,1,NULL,NULL),
(193,193,NULL,1,NULL,2588587,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:10:56','2024-10-11 02:10:56',NULL,1,NULL,NULL),
(194,194,NULL,1,NULL,2862401,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:12:51','2024-10-11 02:12:51',NULL,1,NULL,NULL),
(195,195,NULL,1,NULL,5235694,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:13:40','2024-10-11 02:13:40',NULL,1,NULL,NULL),
(196,196,15.59,2,'2024-10-12',1890453,NULL,'2024-10-13',3,'71471139946820228439259082449173370530063134896330',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 02:13:52','2024-10-12 19:45:57',NULL,1,NULL,NULL),
(197,197,15.59,2,'2024-10-12',7065458,NULL,'2024-10-13',2,'28350184665512904309600950481444719569319702888329',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 02:17:43','2024-10-12 18:24:12',NULL,1,NULL,NULL),
(198,198,NULL,1,NULL,6914518,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:18:20','2024-10-11 02:18:20',NULL,1,NULL,NULL),
(199,199,NULL,1,NULL,2167505,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:20:37','2024-10-11 02:20:37',NULL,1,NULL,NULL),
(200,200,NULL,1,NULL,6051187,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:27:10','2024-10-11 02:27:10',NULL,1,NULL,NULL),
(201,201,10.59,2,'2024-10-11',4222791,NULL,'2024-10-15',1,'60052556193748523531973031667425410495537236014680',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-11 02:41:47','2024-10-11 03:17:23',NULL,1,NULL,NULL),
(202,202,NULL,1,NULL,7288390,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 02:59:20','2024-10-11 02:59:20',NULL,1,NULL,NULL),
(203,203,NULL,1,NULL,3779086,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:01:38','2024-10-11 03:01:38',NULL,1,NULL,NULL),
(204,204,NULL,1,NULL,7717505,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:05:26','2024-10-11 03:05:26',NULL,1,NULL,NULL),
(205,205,15.59,2,'2024-10-12',8149088,NULL,'2024-10-13',2,'56742696401354787640748839963560524650901100175343',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 03:06:58','2024-10-12 13:01:36',NULL,1,NULL,NULL),
(206,206,NULL,1,NULL,1629887,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:12:39','2024-10-11 03:12:39',NULL,1,NULL,NULL),
(207,207,NULL,1,NULL,6096221,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:12:44','2024-10-11 03:12:44',NULL,1,NULL,NULL),
(208,208,NULL,1,NULL,9701213,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:13:36','2024-10-11 03:13:36',NULL,1,NULL,NULL),
(209,209,NULL,1,NULL,8697271,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:13:47','2024-10-11 03:13:47',NULL,1,NULL,NULL),
(210,210,NULL,1,NULL,6928698,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:14:14','2024-10-11 03:14:14',NULL,1,NULL,NULL),
(211,211,NULL,1,NULL,9622378,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:16:57','2024-10-11 03:16:57',NULL,1,NULL,NULL),
(212,212,NULL,1,NULL,7353836,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:24:14','2024-10-11 03:24:14',NULL,1,NULL,NULL),
(213,213,NULL,1,NULL,3315022,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:25:29','2024-10-11 03:25:29',NULL,1,NULL,NULL),
(214,214,NULL,1,NULL,3210931,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:29:38','2024-10-11 03:29:38',NULL,1,NULL,NULL),
(215,215,NULL,1,NULL,6966719,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:31:20','2024-10-11 03:31:20',NULL,1,NULL,NULL),
(216,216,NULL,1,NULL,9220094,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 03:33:12','2024-10-11 03:33:12',NULL,1,NULL,NULL),
(217,217,NULL,1,NULL,2288419,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 05:09:58','2024-10-11 05:09:58',NULL,1,NULL,NULL),
(218,218,NULL,1,NULL,2222155,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 05:20:42','2024-10-11 05:20:42',NULL,1,NULL,NULL),
(219,219,15.59,2,'2024-10-13',6099231,NULL,'2024-10-13',3,'88014272492105365046913027597117710615323056648275',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 05:45:34','2024-10-13 03:38:12',NULL,1,NULL,NULL),
(220,220,15.59,2,'2024-10-12',3817011,NULL,'2024-10-13',2,'55249939000501816294547040928064472915222161028885',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 06:48:46','2024-10-12 14:47:43',NULL,1,NULL,NULL),
(221,221,15.59,2,'2024-10-12',6007261,NULL,'2024-10-13',2,'00011649357280553484273465276107664471932877020015',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 08:33:25','2024-10-12 13:02:28',NULL,1,NULL,NULL),
(222,222,NULL,1,NULL,8451250,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 08:52:26','2024-10-11 08:52:26',NULL,1,NULL,NULL),
(223,223,NULL,1,NULL,6331523,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 11:21:42','2024-10-11 11:21:42',NULL,1,NULL,NULL),
(224,224,15.59,2,'2024-10-12',7287341,NULL,'2024-10-13',2,'61390369215620078875360324832770840459934759211153',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 11:36:11','2024-10-12 18:22:36',NULL,1,NULL,NULL),
(225,225,NULL,1,NULL,7658329,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 12:32:01','2024-10-11 12:32:01',NULL,1,NULL,NULL),
(226,226,NULL,1,NULL,2018139,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 12:54:43','2024-10-11 12:54:43',NULL,1,NULL,NULL),
(227,227,NULL,1,NULL,6676064,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 13:01:12','2024-10-11 13:01:12',NULL,1,NULL,NULL),
(228,228,30.59,2,'2024-10-12',7673969,NULL,'2024-10-13',3,'30794167892065627449549148211866884295806280629029',0.51,0.51,0.59,30.51,30.00,0.51,0.08,NULL,'2024-10-11 13:03:40','2024-10-12 19:57:05',NULL,1,NULL,NULL),
(229,229,NULL,1,NULL,1279719,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 13:24:58','2024-10-11 13:24:58',NULL,1,NULL,NULL),
(230,230,NULL,1,NULL,6011114,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 13:40:47','2024-10-11 13:40:47',NULL,1,NULL,NULL),
(231,231,NULL,1,NULL,5573835,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 13:41:14','2024-10-11 13:41:14',NULL,1,NULL,NULL),
(232,232,NULL,1,NULL,7625616,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 14:02:26','2024-10-11 14:02:26',NULL,1,NULL,NULL),
(233,233,NULL,1,NULL,3686946,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 14:07:05','2024-10-11 14:07:05',NULL,1,NULL,NULL),
(234,234,NULL,1,NULL,4056566,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 14:15:25','2024-10-11 14:15:25',NULL,1,NULL,NULL),
(235,235,NULL,1,NULL,5764666,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 14:17:43','2024-10-11 14:17:43',NULL,1,NULL,NULL),
(236,236,NULL,1,NULL,7038799,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 14:17:56','2024-10-11 14:17:56',NULL,1,NULL,NULL),
(237,237,15.59,2,'2024-10-13',7299775,NULL,'2024-10-13',3,'55489015233324668835522608933705265990161380086686',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 14:19:25','2024-10-13 03:41:25',NULL,1,NULL,NULL),
(238,238,NULL,1,NULL,2120419,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 14:19:56','2024-10-11 14:19:56',NULL,1,NULL,NULL),
(239,239,NULL,1,NULL,5361974,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 14:23:35','2024-10-11 14:23:35',NULL,1,NULL,NULL),
(240,240,NULL,1,NULL,2542318,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 16:31:29','2024-10-11 16:31:29',NULL,1,NULL,NULL),
(241,241,15.59,2,'2024-10-13',6729390,NULL,'2024-10-13',3,'99145989717277811506581388335979267784722962725098',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 16:39:28','2024-10-13 03:50:42',NULL,1,NULL,NULL),
(242,242,NULL,1,NULL,6511628,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 16:59:45','2024-10-11 16:59:45',NULL,1,NULL,NULL),
(243,243,NULL,1,NULL,1677276,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 17:10:00','2024-10-11 17:10:00',NULL,1,NULL,NULL),
(244,244,15.59,2,'2024-10-13',1794541,NULL,'2024-10-13',3,'15721722722456075125301385019378508733591213665887',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 17:18:03','2024-10-13 03:53:35',NULL,1,NULL,NULL),
(245,245,NULL,1,NULL,7284216,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 17:26:58','2024-10-11 17:26:58',NULL,1,NULL,NULL),
(246,246,NULL,1,NULL,5625017,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 17:30:09','2024-10-11 17:30:09',NULL,1,NULL,NULL),
(247,247,NULL,1,NULL,9033532,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 17:34:52','2024-10-11 17:34:52',NULL,1,NULL,NULL),
(248,248,NULL,1,NULL,5297082,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 18:24:22','2024-10-11 18:24:22',NULL,1,NULL,NULL),
(249,249,NULL,1,NULL,2170078,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 18:24:40','2024-10-11 18:24:40',NULL,1,NULL,NULL),
(250,250,NULL,1,NULL,4255679,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 19:30:44','2024-10-11 19:30:44',NULL,1,NULL,NULL),
(251,251,NULL,1,NULL,2610851,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 19:31:54','2024-10-11 19:31:54',NULL,1,NULL,NULL),
(252,252,15.59,2,'2024-10-11',3026557,NULL,'2024-10-13',2,'22528180228237052096976426074180658396205931770885',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 21:05:58','2024-10-11 21:06:23',NULL,1,NULL,NULL),
(253,253,15.59,2,'2024-10-11',8657794,NULL,'2024-10-13',2,'51469385747562673688706811110970222012118049393874',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 21:06:48','2024-10-11 21:08:26',NULL,1,NULL,NULL),
(254,254,15.59,2,'2024-10-11',4642037,NULL,'2024-10-13',2,'24940816974540347103771598541273277871449624697426',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 21:07:58','2024-10-11 21:09:26',NULL,1,NULL,NULL),
(255,255,NULL,1,NULL,3582107,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 22:10:08','2024-10-11 22:10:08',NULL,1,NULL,NULL),
(256,256,NULL,1,NULL,1981279,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 22:12:30','2024-10-11 22:12:30',NULL,1,NULL,NULL),
(257,257,15.59,2,'2024-10-12',9451178,NULL,'2024-10-13',2,'21317453737878213458471575769465854547784023037309',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 22:17:44','2024-10-12 20:21:13',NULL,1,NULL,NULL),
(259,259,15.59,2,'2024-10-12',1113327,NULL,'2024-10-13',1,'08396415573390229890287469721509895804910237833838',0.51,0.51,0.59,15.51,15.00,0.51,0.08,1,'2024-10-11 22:32:18','2024-10-12 17:48:06',NULL,1,NULL,NULL),
(260,260,NULL,1,NULL,8838682,NULL,'2024-10-18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 23:30:27','2024-10-11 23:30:27',NULL,1,NULL,NULL),
(261,261,15.59,2,'2024-10-12',9699397,NULL,'2024-10-13',2,'77455427968515655793027375818424963672669773101523',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-11 23:58:13','2024-10-12 23:29:05',NULL,1,NULL,NULL),
(262,262,NULL,1,NULL,1660367,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-11 23:59:03','2024-10-11 23:59:03',NULL,1,NULL,NULL),
(263,263,NULL,1,NULL,6340857,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 00:01:04','2024-10-12 00:01:04',NULL,1,NULL,NULL),
(264,264,15.59,2,'2024-10-12',9045899,NULL,'2024-10-13',2,'17105688554308360961030222645557739741055003401399',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 00:03:41','2024-10-12 21:36:19',NULL,1,NULL,NULL),
(265,265,NULL,1,NULL,4631914,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 00:33:21','2024-10-12 00:33:21',NULL,1,NULL,NULL),
(266,266,NULL,1,NULL,8989045,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 00:38:13','2024-10-12 00:38:13',NULL,1,NULL,NULL),
(267,267,NULL,1,NULL,2358449,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 00:56:51','2024-10-12 00:56:51',NULL,1,NULL,NULL),
(268,268,NULL,1,NULL,1007471,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 01:35:30','2024-10-12 01:35:30',NULL,1,NULL,NULL),
(269,269,NULL,1,NULL,7691189,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 02:51:30','2024-10-12 02:51:30',NULL,1,NULL,NULL),
(270,270,NULL,1,NULL,4853156,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 02:52:47','2024-10-12 02:52:47',NULL,1,NULL,NULL),
(271,271,15.59,2,'2024-10-13',2740853,NULL,'2024-10-13',3,'09026888264125814862478395156252792052670920635204',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 02:53:18','2024-10-13 03:58:38',NULL,1,NULL,NULL),
(272,272,NULL,1,NULL,5491689,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 02:57:30','2024-10-12 02:57:30',NULL,1,NULL,NULL),
(273,273,15.59,2,'2024-10-13',3548940,NULL,'2024-10-13',3,'87376584759460998886247089655429635569459983125663',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 02:59:27','2024-10-13 04:02:24',NULL,1,NULL,NULL),
(274,274,NULL,1,NULL,3947755,NULL,'2024-10-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 03:02:43','2024-10-12 03:02:43',NULL,1,NULL,NULL),
(275,275,NULL,1,NULL,6755046,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 03:03:32','2024-10-12 03:03:32',NULL,1,NULL,NULL),
(276,276,15.59,2,'2024-10-13',6972087,NULL,'2024-10-13',1,'20415338789924668086080658725507222557613438827524',0.51,0.51,0.59,15.51,15.00,0.51,0.08,1,'2024-10-12 03:08:36','2024-10-13 01:36:26',NULL,1,NULL,NULL),
(277,277,NULL,1,NULL,4325683,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 03:08:45','2024-10-12 03:08:45',NULL,1,NULL,NULL),
(278,278,15.59,2,'2024-10-12',3342865,NULL,'2024-10-13',2,'61687898516337282371322498448935922185200652837167',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 03:10:03','2024-10-12 20:39:27',NULL,1,NULL,NULL),
(279,279,15.59,2,'2024-10-12',5763510,NULL,'2024-10-13',2,'92468525033674425247620312301531591540821199603469',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 03:12:46','2024-10-12 17:59:45',NULL,1,NULL,NULL),
(280,280,NULL,1,NULL,3959905,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 03:16:01','2024-10-12 03:16:01',NULL,1,NULL,NULL),
(281,281,NULL,1,NULL,1810760,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 03:19:57','2024-10-12 03:19:57',NULL,1,NULL,NULL),
(282,282,15.59,2,'2024-10-13',8630864,NULL,'2024-10-13',3,'70010567778530256724755865726391252945641880111464',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 03:20:59','2024-10-13 04:04:40',NULL,1,NULL,NULL),
(283,283,NULL,1,NULL,5020708,NULL,'2024-10-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 03:36:19','2024-10-12 03:36:19',NULL,1,NULL,NULL),
(284,284,NULL,1,NULL,7065520,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 08:28:48','2024-10-12 08:28:48',NULL,1,NULL,NULL),
(285,285,NULL,1,NULL,3912466,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 09:51:04','2024-10-12 09:51:04',NULL,1,NULL,NULL),
(286,286,NULL,1,NULL,5362392,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 12:28:33','2024-10-12 12:28:33',NULL,1,NULL,NULL),
(287,287,NULL,1,NULL,9943953,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 13:21:51','2024-10-12 13:21:51',NULL,1,NULL,NULL),
(288,288,NULL,1,NULL,9314706,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 13:41:27','2024-10-12 13:41:27',NULL,1,NULL,NULL),
(289,289,15.59,2,'2024-10-13',5433614,NULL,'2024-10-13',3,'78639813873766065920291168617815154846515289822653',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 13:45:05','2024-10-13 04:07:23',NULL,1,NULL,NULL),
(290,290,NULL,1,NULL,8367200,NULL,'2024-10-19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 13:46:47','2024-10-12 13:46:47',NULL,1,NULL,NULL),
(291,291,10.59,2,'2024-10-12',2916260,NULL,'2024-10-15',2,'34482618361144954581092671964703352178114553859940',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-12 13:49:31','2024-10-12 16:20:27',NULL,1,NULL,NULL),
(293,293,15.59,2,'2024-10-12',7690012,NULL,'2024-10-13',2,'69566191206513872866378310905527559712485788393993',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 14:42:57','2024-10-12 14:55:41',NULL,1,NULL,NULL),
(294,294,NULL,1,NULL,2479554,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 14:44:26','2024-10-12 14:44:26',NULL,1,NULL,NULL),
(295,295,NULL,1,NULL,9846564,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 14:45:06','2024-10-12 14:45:06',NULL,1,NULL,NULL),
(296,296,NULL,1,NULL,1545671,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 15:03:40','2024-10-12 15:03:40',NULL,1,NULL,NULL),
(297,297,NULL,1,NULL,2211343,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 15:19:39','2024-10-12 15:19:39',NULL,1,NULL,NULL),
(298,298,NULL,1,NULL,1359806,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 15:31:37','2024-10-12 15:31:37',NULL,1,NULL,NULL),
(299,299,NULL,1,NULL,7397030,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 15:32:26','2024-10-12 15:32:26',NULL,1,NULL,NULL),
(300,300,NULL,1,NULL,7655668,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 15:47:23','2024-10-12 15:47:23',NULL,1,NULL,NULL),
(301,301,10.59,2,'2024-10-12',4249121,NULL,'2024-10-15',2,'99862379894042431738736239503340812403396522307023',0.51,0.51,0.59,10.51,10.00,0.51,0.08,NULL,'2024-10-12 16:00:19','2024-10-12 19:10:42',NULL,1,NULL,NULL),
(302,302,15.59,2,'2024-10-12',9534740,NULL,'2024-10-13',2,'59004444315766523272559415056428338065088341273235',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 16:01:43','2024-10-12 16:03:39',NULL,1,NULL,NULL),
(303,303,15.59,2,'2024-10-12',4050114,NULL,'2024-10-13',2,'78103580570413829539922760592970843273225635630268',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 16:27:21','2024-10-12 18:41:01',NULL,1,NULL,NULL),
(304,304,15.59,2,'2024-10-12',5220411,NULL,'2024-10-13',2,'08641682811715696256158594219071473820173976312278',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 16:34:49','2024-10-12 18:40:42',NULL,1,NULL,NULL),
(305,305,NULL,1,NULL,9726592,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 17:29:09','2024-10-12 17:29:09',NULL,1,NULL,NULL),
(306,306,NULL,1,NULL,6180537,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 17:34:09','2024-10-12 17:34:09',NULL,1,NULL,NULL),
(307,307,15.59,2,'2024-10-12',5219776,NULL,'2024-10-13',2,'54289335587468430780687990460100928572655216080829',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 18:43:58','2024-10-12 18:45:01',NULL,1,NULL,NULL),
(308,308,NULL,1,NULL,3783963,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 18:59:08','2024-10-12 18:59:08',NULL,1,NULL,NULL),
(309,309,15.59,2,'2024-10-12',4170360,NULL,'2024-10-13',2,'47713663299036415034091341985022474134630696260661',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 19:01:39','2024-10-12 19:03:05',NULL,1,NULL,NULL),
(310,310,NULL,1,NULL,3299487,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 19:28:09','2024-10-12 19:28:09',NULL,1,NULL,NULL),
(311,311,NULL,1,NULL,7785322,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 20:20:27','2024-10-12 20:20:27',NULL,1,NULL,NULL),
(312,312,15.59,2,'2024-10-12',1291496,NULL,'2024-10-13',2,'36189493827528202510567851162058833283880386725355',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 20:34:34','2024-10-12 20:35:31',NULL,1,NULL,NULL),
(313,313,15.59,2,'2024-10-12',7828739,NULL,'2024-10-13',2,'49693230564553107038230991140219325246496346167554',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 20:35:47','2024-10-12 20:36:49',NULL,1,NULL,NULL),
(314,314,15.59,2,'2024-10-12',1219962,NULL,'2024-10-13',2,'21409631627216058573467336850061065477343579379890',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 20:37:28','2024-10-12 20:38:24',NULL,1,NULL,NULL),
(315,315,15.59,2,'2024-10-12',8794485,NULL,'2024-10-13',2,'79633655779884367105477742507592109058280914379526',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 20:41:19','2024-10-12 20:42:55',NULL,1,NULL,NULL),
(316,316,NULL,1,NULL,3903913,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 21:14:37','2024-10-12 21:14:37',NULL,1,NULL,NULL),
(317,317,NULL,1,NULL,4351887,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 21:23:19','2024-10-12 21:23:19',NULL,1,NULL,NULL),
(318,318,NULL,1,NULL,8699679,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 21:34:26','2024-10-12 21:34:26',NULL,1,NULL,NULL),
(319,319,NULL,1,NULL,6715709,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 21:43:45','2024-10-12 21:43:45',NULL,1,NULL,NULL),
(320,320,10.59,2,'2024-10-13',7483615,NULL,'2024-10-15',1,'65887233124173281521088590793260591876120108892503',0.51,0.51,0.59,10.51,10.00,0.51,0.08,1,'2024-10-12 22:03:09','2024-10-13 01:36:54',NULL,1,NULL,NULL),
(321,321,NULL,1,NULL,7244884,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 22:15:40','2024-10-12 22:15:40',NULL,1,NULL,NULL),
(322,322,NULL,1,NULL,9668772,NULL,'2024-10-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-12 22:16:03','2024-10-12 22:16:03',NULL,1,NULL,NULL),
(323,323,15.59,2,'2024-10-12',6559514,NULL,'2024-10-13',2,'08631334876285345865742561118263214917923034113583',0.51,0.51,0.59,15.51,15.00,0.51,0.08,NULL,'2024-10-12 22:20:20','2024-10-12 22:38:35',NULL,1,NULL,NULL),
(324,324,NULL,1,NULL,2099828,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 00:25:51','2024-10-13 00:25:51',NULL,1,NULL,NULL),
(325,325,NULL,1,NULL,4224570,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 00:29:43','2024-10-13 00:29:43',NULL,1,NULL,NULL),
(326,326,NULL,1,NULL,3026458,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 00:33:45','2024-10-13 00:33:45',NULL,1,NULL,NULL),
(327,327,NULL,1,NULL,9693425,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 00:45:32','2024-10-13 00:45:32',NULL,1,NULL,NULL),
(328,328,NULL,1,NULL,6325700,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 00:49:39','2024-10-13 00:49:39',NULL,1,NULL,NULL),
(329,329,NULL,1,NULL,8433200,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 01:00:14','2024-10-13 01:00:14',NULL,1,NULL,NULL),
(330,330,NULL,1,NULL,6210280,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 01:48:42','2024-10-13 01:48:42',NULL,1,NULL,NULL),
(331,331,NULL,1,NULL,3865959,NULL,'2024-10-20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 03:43:40','2024-10-13 03:43:40',NULL,1,NULL,NULL),
(332,332,NULL,1,NULL,4217670,NULL,'2024-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 03:45:36','2024-10-13 03:45:36',NULL,1,NULL,NULL),
(333,333,NULL,1,NULL,8038370,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 03:52:23','2024-10-13 03:52:23',NULL,1,NULL,NULL),
(334,334,NULL,1,NULL,1880785,NULL,'2024-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-10-13 03:52:44','2024-10-13 03:52:44',NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue_jobs`
--

DROP TABLE IF EXISTS `queue_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queue_jobs` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(64) NOT NULL,
  `payload` text NOT NULL,
  `priority` varchar(64) NOT NULL DEFAULT 'default',
  `status` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `attempts` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `queue_priority_status_available_at` (`queue`,`priority`,`status`,`available_at`)
) ENGINE=InnoDB AUTO_INCREMENT=506 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queue_jobs`
--

LOCK TABLES `queue_jobs` WRITE;
/*!40000 ALTER TABLE `queue_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queue_jobs_failed`
--

DROP TABLE IF EXISTS `queue_jobs_failed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queue_jobs_failed` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `connection` varchar(64) NOT NULL,
  `queue` varchar(64) NOT NULL,
  `payload` text NOT NULL,
  `priority` varchar(64) NOT NULL DEFAULT 'default',
  `exception` text NOT NULL,
  `failed_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `queue` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queue_jobs_failed`
--

LOCK TABLES `queue_jobs_failed` WRITE;
/*!40000 ALTER TABLE `queue_jobs_failed` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue_jobs_failed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_cod` int(10) unsigned DEFAULT NULL,
  `cat_id` int(10) unsigned DEFAULT NULL,
  `full_name_user` varchar(250) NOT NULL,
  `ic` varchar(10) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `monto_category` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_event_cod_foreign` (`event_cod`),
  KEY `registrations_cat_id_foreign` (`cat_id`),
  CONSTRAINT `registrations_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `registrations_event_cod_foreign` FOREIGN KEY (`event_cod`) REFERENCES `events` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrations`
--

LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
INSERT INTO `registrations` VALUES
(1,2,6,'JUAN MESíAS CORO CANDO','0604938704','Riobamba','0981847813','coro94@hotmail.com','V CIPEC',20.59,'2024-10-04 00:57:23','2024-10-04 00:57:23',NULL,1,NULL,NULL),
(2,1,4,'DIANA VERONICA ORTIZ ALMEIDA','1207274919','Nuevo guanujo ','0990427601','do1207274919@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-04 22:10:38','2024-10-04 22:10:38',NULL,1,NULL,NULL),
(3,1,4,'ESTEFANYA NICOLE MUGUICHA HINOJOZA','0202659827','Vinchoa central ','0980186170','estefymuguicha@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-05 02:00:51','2024-10-05 02:00:51',NULL,1,NULL,NULL),
(4,1,4,'SCARLET ANABEL ERAZO NAVARRETE','1728414382','Guaranda ','0993706464','anabe.erazo@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-06 00:57:44','2024-10-06 00:57:44',NULL,1,NULL,NULL),
(6,2,5,'DAMARY SIREY HINOJOSA PILCO','0250326444','Guaranda ','0991784959','pilcoyeris@gmail.com','V CIPEC',10.59,'2024-10-06 01:05:42','2024-10-06 01:05:42',NULL,1,NULL,NULL),
(7,1,4,'NOEMí ZAIDEé AGUILAR TIRIRA','1600682593','Puyo','0961011100','noemi.zaidee@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-06 01:27:33','2024-10-06 01:27:33',NULL,1,NULL,NULL),
(8,1,4,'SHEYLA NICOLE ANDACHI OROZCO','0250256427','GUARANDA','0959995577','ANDACHISHEYLA@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-06 01:32:38','2024-10-06 01:32:38',NULL,1,NULL,NULL),
(9,1,4,'WILBER DAVID SOLIZ QUIJANO','0202639282','AGUACOTO','0959724834','WILBER.SOLIZ@UEB.EDU.EC','XI CTIE - II CIVS',10.59,'2024-10-06 17:38:15','2024-10-06 17:38:15',NULL,1,NULL,NULL),
(10,2,5,'MAURICIO ALEJANDRO GóMEZ TENESACA','0250021490','5 de junio','0988493886','mg4014423@gmail.com','V CIPEC',10.59,'2024-10-07 00:17:59','2024-10-07 00:17:59',NULL,1,NULL,NULL),
(11,2,5,'JEREMY ARIEL PENA SALAZAR','0250120946','Guaranda ','0988962940','jeremy.pena@ueb.edu.ec','V CIPEC',10.59,'2024-10-07 00:19:16','2024-10-07 00:19:16',NULL,1,NULL,NULL),
(12,1,4,'CRISTIAN DANIEL VALENCIA SILVA','1600820177','GUARANDA','0991416266','cv76101@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-07 00:24:19','2024-10-07 13:58:44',NULL,1,NULL,NULL),
(13,2,6,'ROLANDO GUSTAVO VALVERDE VALVERDE','0201532058','Av Elisa Mariño de Carvajal ','0989883870','rvalverde2009@gmail.com','V CIPEC',20.59,'2024-10-07 18:17:29','2024-10-07 18:17:29',NULL,1,NULL,NULL),
(14,2,5,'DAPFNE RUBI CAYAMBE ARIAS','1750129361','MERCED BAJA','0987445605','DAPFNERUBI@GMAIL.COM','V CIPEC',10.59,'2024-10-07 18:31:50','2024-10-07 18:31:50',NULL,1,NULL,NULL),
(15,2,5,'JAMILETH ALEJANDRA TORRES ALARCóN','1004361083','San José de chimbo guaranda ','0986891344','torresjamileth735@gmail.com','V CIPEC',10.59,'2024-10-07 18:34:14','2024-10-07 18:34:14',NULL,1,NULL,NULL),
(16,1,3,'JHON PATRICIO CAJO VEGA','0250147667','KM 1 1/2 PANAMERICANA SUR','0968540395','JHONCPC99@GMAIL.COM','XI CTIE - II CIVS',50.59,'2024-10-07 19:00:40','2024-10-07 19:00:40',NULL,1,NULL,NULL),
(17,2,6,'JHON PATRICIO CAJO VEGA','0250147667','KM 1 1/2 PANAMERICANA SUR','0968540395','JHONCPC99@GMAIL.COM','V CIPEC',20.59,'2024-10-07 19:10:26','2024-10-07 19:10:26',NULL,1,NULL,NULL),
(18,2,6,'MARLON XAVIER VILLARES JIBAJA','0202285037','CIUDADELA LA PLAYA','0991716465','MALOMVX@HOTMAIL.COM','V CIPEC',20.59,'2024-10-07 19:36:30','2024-10-07 19:36:30',NULL,1,NULL,NULL),
(19,1,4,'SEGUNDO ADOLFO MUÑOZ ALARCON','0202292322','SAN MIGUEL','0994587011','SEGUNDOMUNOZ865@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-07 21:01:02','2024-10-07 21:01:02',NULL,1,NULL,NULL),
(20,2,5,'VICTORIA NAYELI RIVADENEIRA RODRIGUEZ','1600867467','TARQUI','0993857542','VICKYNAYELI24@GMAIL.COM','V CIPEC',10.59,'2024-10-07 21:10:50','2024-10-07 21:10:50',NULL,1,NULL,NULL),
(21,2,5,'JESSICA MILENA SANGUANO BOLAGAY','1728578194','Laguacoto ','0962546692','jessimile335@gmail.com','V CIPEC',10.59,'2024-10-07 21:12:05','2024-10-07 21:12:05',NULL,1,NULL,NULL),
(22,2,5,'NANCY DANIELA PUCHA PARCO','0202199089','San Pablo de Atenas ','0997975197','puchadaniela79@gmail.com','V CIPEC',10.59,'2024-10-07 21:19:07','2024-10-08 21:34:48','2024-10-08 21:34:48',1,NULL,NULL),
(23,2,5,'NANCY DANIELA PUCHA PARCO','0202199089','San Pablo de Atenas ','0997975197','puchadaniela79@gmail.com','V CIPEC',10.59,'2024-10-07 21:41:35','2024-10-08 21:35:11','2024-10-08 21:35:11',1,NULL,NULL),
(24,3,9,'CARLOS ALBERTO PEÑA PIZARRO','0704805795','URBANIZACION MIRACIELO','0987414852','capenapizarro@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-07 22:32:17','2024-10-07 22:32:17',NULL,1,NULL,NULL),
(25,2,6,'CARLOS ALBERTO PEÑA PIZARRO','0704805795','URBANIZACION MIRACIELO','0987414852','capenapizarro@gmail.com','V CIPEC',20.59,'2024-10-07 22:32:55','2024-10-07 22:32:55',NULL,1,NULL,NULL),
(26,1,3,'CARLOS ALBERTO PEÑA PIZARRO','0704805795','URBANIZACION MIRACIELO','0987414852','capenapizarro@gmail.com','XI CTIE - II CIVS',50.59,'2024-10-07 22:34:09','2024-10-07 22:34:09',NULL,1,NULL,NULL),
(27,2,5,'XAVIER ROBERTO LLUMIGUANO FERNáNDEZ','0250142270','Guaranda','0981498041','xavier.llumiguano@ueb.edu.ec','V CIPEC',10.59,'2024-10-07 22:56:01','2024-10-07 22:56:01',NULL,1,NULL,NULL),
(28,2,5,'EMILY CAMILA FARINANGO PUSDá','1727709808','Guaranda ','0994712279','camifar20@gmail.com','V CIPEC',10.59,'2024-10-08 00:32:47','2024-10-08 00:32:47',NULL,1,NULL,NULL),
(29,2,5,'SAMUEL ANDRES CHICA RAMIREZ','0705635647','Guanujo, calle Jaime Velasco, barrio cooperativa defensa del pueblo','0959780789','samuel.chica@ueb.edu.ec','V CIPEC',10.59,'2024-10-08 00:54:58','2024-10-08 00:54:58',NULL,1,NULL,NULL),
(30,1,3,'ISRAEL ALEXIS GONZABAY QUIÑONEZ','0926066895','GUAYAQUIL-ECUADOR','3937923513','izzydorogqz@gmail.com','XI CTIE - II CIVS',50.59,'2024-10-08 01:10:50','2024-10-08 21:49:32','2024-10-08 21:49:32',1,NULL,NULL),
(31,2,6,'FABRICIO ADRIAN TACO NUÑEZ','0201515186','GUANUJO BARRIO EL CHORRO','0999393697','fabricio.taco@ueb.edu.ec','V CIPEC',20.59,'2024-10-08 01:19:26','2024-10-08 01:19:26',NULL,1,NULL,NULL),
(32,3,11,'ISRAEL ALEXIS GONZABAY QUIÑONEZ','0926066895','GUAYAQUIL-ECUADOR','3937923513','izzydorogqz@gmail.com','VI SEMINARIO INVESTIGACIÓN',30.59,'2024-10-08 01:20:20','2024-10-08 01:20:20',NULL,1,NULL,NULL),
(33,2,5,'ADONIS ELIAN CAIZAGUANO MASABANDA','0202634085','Guaranda','0988554408','adoniscaizaguano504@gmail.com','V CIPEC',10.59,'2024-10-08 02:09:52','2024-10-08 02:09:52',NULL,1,NULL,NULL),
(34,2,5,'TOTOY AMAGUAYA ANDERSON SEBASTIAN','0606248003','San José de Chimbo','0986763881','anderson.totoy@ueb.edu.ec','V CIPEC',10.59,'2024-10-08 12:56:33','2024-10-08 12:56:33',NULL,1,NULL,NULL),
(35,2,5,'TOTOY AMAGUAYA ANDERSON SEBASTIAN','0606248003','San José de Chimbo','0986763881','anderson.totoy@ueb.edu.ec','V CIPEC',10.59,'2024-10-08 12:56:57','2024-10-08 12:56:57',NULL,1,NULL,NULL),
(36,2,5,'TOTOY AMAGUAYA ANDERSON SEBASTIAN','0606248003','San José de Chimbo','0986763881','anderson.totoy@ueb.edu.ec','V CIPEC',10.59,'2024-10-08 12:57:48','2024-10-08 12:57:48',NULL,1,NULL,NULL),
(37,2,6,'KEVIN JESUS BONILLA VISCARRA','0202543682','GUARANDA','0939010838','KEVINJESUSBONILLAVISCARRA3@GMAIL.COM','V CIPEC',20.59,'2024-10-08 13:24:53','2024-10-08 13:24:53',NULL,1,NULL,NULL),
(38,2,5,'SCARLETH JORETT GARCIA MORA','0250166204','GUARANDA, 10 DE NOVIEMBRE','0985038790','SCARLETH.GARCIA@UEB.EDU.EC','V CIPEC',10.59,'2024-10-08 15:17:54','2024-10-08 15:17:54',NULL,1,NULL,NULL),
(39,2,5,'JUANA ALEXANDRA CAIZA CAIZA','0550529234','Guaranda ','0962633735','alexandracaiza930@gmail.com','V CIPEC',10.59,'2024-10-08 15:19:12','2024-10-08 15:19:12',NULL,1,NULL,NULL),
(40,2,5,'BYRON FRANCISCO LOPEZ NARANJO','1250827043','GUARANDA','0999593284','BYRONLOPEZNARANJO2006@GMAIL.COM','V CIPEC',10.59,'2024-10-08 15:21:03','2024-10-08 15:21:03',NULL,1,NULL,NULL),
(41,2,5,'GENESIS DALINDA PALACIOS ZAMBRANO','1207439462','MARCOMPAMBA','0997462494','SISENEGPALACIOS39@GMAIL.COM','V CIPEC',10.59,'2024-10-08 15:24:49','2024-10-08 15:24:49',NULL,1,NULL,NULL),
(42,2,5,'JORDY JAIR TUAPANTA VERA','0202708541','Terminal terrestre ','0985948033','jairvera600@gmail.com','V CIPEC',10.59,'2024-10-08 15:32:00','2024-10-08 15:32:00',NULL,1,NULL,NULL),
(43,1,4,'VILMA VIVIANA CAGUANA CHILQUIGUA','0605815562','Guaranda','0985513376','vilmacaguana84@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-08 15:36:16','2024-10-08 15:36:16',NULL,1,NULL,NULL),
(44,2,5,'JOSE GABRIEL BORJA ULLOA','0202666798','LAS COCHAS','0990167754','BORJAGABRIEL55@GAMIL.COM','V CIPEC',10.59,'2024-10-08 15:38:43','2024-10-08 15:38:43',NULL,1,NULL,NULL),
(45,2,6,'LISETH MARIELA CARVAJAL GUERRERO','0202342853','Guanujo',NULL,'marielacarvajal8@gmail.com','V CIPEC',20.59,'2024-10-08 16:47:34','2024-10-08 16:47:34',NULL,1,NULL,NULL),
(46,2,5,'NANCY DANIELA PUCHA PARCO','0202199089','San Pablo de Atenas ','0997975197','puchadaniela79@gmail.com','V CIPEC',10.59,'2024-10-08 21:04:28','2024-10-08 21:04:28',NULL,1,NULL,NULL),
(47,1,4,'SANDY NICOLE PILAMUNGA LASTRA','1752394385','QUITO','0986665035','SANDYNICOL800@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-08 21:53:03','2024-10-08 21:53:03',NULL,1,NULL,NULL),
(48,1,4,'SANDY NICOLE PILAMUNGA LASTRA','1752394385','QUITO','0986665035','SANDYNICOL800@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-08 21:53:21','2024-10-08 21:53:21',NULL,1,NULL,NULL),
(49,1,4,'DAYANA MAYERLI PILCO CHELE','1250790076','Guaranda avenida 15 de Junio y los Lirios','0990296446','dayanapilco7@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-08 21:58:58','2024-10-08 21:58:58',NULL,1,NULL,NULL),
(50,1,4,'LEYDI ARACELY VASQUEZ CHARIGUAMAN','0202275871','GUARANDA','0987712706','VASQUEZARACELY028@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-08 21:59:10','2024-10-08 21:59:10',NULL,1,NULL,NULL),
(51,1,4,'DAYANA MAYERLI PILCO CHELE','1250790076','Guaranda avenida 15 de Junio y los Lirios','0990296446','dayanapilco7@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-08 21:59:42','2024-10-08 21:59:42',NULL,1,NULL,NULL),
(52,1,4,'DAYANA MAYERLI PILCO CHELE','1250790076','Guaranda avenida 15 de Junio y los Lirios','0990296446','dayanapilco7@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-08 22:01:32','2024-10-08 22:01:32',NULL,1,NULL,NULL),
(53,1,4,'IRMA PAOLA CHIDA LUMBE','0250153632','GUARANDA','0958635658','CHIDAIRMA08@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-08 22:03:45','2024-10-08 22:03:45',NULL,1,NULL,NULL),
(54,2,5,'JOAO ALEXANDER IGLESIAS INCA','0604383471','Veloz y Rocafuerte - Riobamba','0987752444','joaoalexander@hotmail.es','V CIPEC',10.59,'2024-10-08 22:12:10','2024-10-08 22:12:10',NULL,1,NULL,NULL),
(55,2,5,'ARELIS NICOLE AGUILAR SANTANA','1850273291','AMBATO, PARROQUIA A.N.MARTINEZ','0983861766','ARELISA462@GMAIL.COM','V CIPEC',10.59,'2024-10-08 22:37:48','2024-10-08 22:37:48',NULL,1,NULL,NULL),
(56,2,5,'ARELIS NICOLE AGUILAR SANTANA','1850273291','AMBATO, PARROQUIA A.N.MARTINEZ','0983861766','ARELISA462@GMAIL.COM','V CIPEC',10.59,'2024-10-08 22:47:48','2024-10-13 04:32:13','2024-10-13 04:32:13',1,NULL,NULL),
(57,1,4,'JOSEPH DAMIáN SANCHEZ ANILEMA','0202086419','Guaranda ','0994843595','joseph.sanchez@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-08 23:24:44','2024-10-08 23:24:44',NULL,1,NULL,NULL),
(58,2,5,'JOSEPH DAMIáN SANCHEZ ANILEMA','0202086419','Guaranda ','0994843595','joseph.sanchez@ueb.edu.ec','V CIPEC',10.59,'2024-10-08 23:26:44','2024-10-08 23:26:44',NULL,1,NULL,NULL),
(59,2,5,'GABRIELA MISHELLE CRUZ GARCIA','1727443846','Guaranda','0998652480','mishellegarcia54@gmail.com','V CIPEC',10.59,'2024-10-09 00:07:47','2024-10-09 00:07:47',NULL,1,NULL,NULL),
(60,3,9,'IRLANDA VERONICA YUMISIBA YEPEZ','0202106381','LA TRONCAL','0983679701','VERONICA.YUMISIBA@UEB.EDU.EC','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-09 00:10:04','2024-10-09 00:10:04',NULL,1,NULL,NULL),
(61,2,5,'FERNANDA ANAHI ALBAN MANOBANDA','0250223369','GUARANDA, ALPACHACA','0959603007','FERNANDA.ALBAN2020@GMAIL.COM','V CIPEC',10.59,'2024-10-09 00:30:21','2024-10-09 00:30:21',NULL,1,NULL,NULL),
(62,3,9,'KATERINE KAROLINA COLOMA RAMIREZ','0202014932','MONTALVO','0991771582','KACOLOMA@MAILES.UEB.EDU.EC','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-09 00:32:31','2024-10-09 00:32:31',NULL,1,NULL,NULL),
(63,2,6,'LEONOR JACQUELINE GUZñAY APUGLLòN','0604607895','Riobamba','0985863085','leonorjacqueline187@gmail.com','V CIPEC',20.59,'2024-10-09 03:18:21','2024-10-09 03:18:21',NULL,1,NULL,NULL),
(64,2,5,'ISMAEL ALEJANDRO MASABANDA PAREDES','1805064167','Tisaleo','0960997783','ismaelmasabanda43@gmail.com','V CIPEC',10.59,'2024-10-09 10:46:21','2024-10-09 10:46:21',NULL,1,NULL,NULL),
(65,2,5,'TABATA CAROLINA YANZA GUAMAN','0107919409','CRUZ LOMA','0988402527','TABATA.YANZA@UEB.EDU.EC','V CIPEC',10.59,'2024-10-09 10:54:34','2024-10-09 10:54:34',NULL,1,NULL,NULL),
(66,2,5,'NAHOMY DANIELA TIXILEMA HEREDIA','0202173050','Riobamba','0980511429','nahomy17tixilema@gmail.com','V CIPEC',10.59,'2024-10-09 12:57:55','2024-10-09 12:57:55',NULL,1,NULL,NULL),
(67,2,5,'DIANA JAQUELINE ESPINOZA PINGOS','0605344340','Av Pedro Vicente y Cofanes ','0979515786','dianajep23@gmail.com','V CIPEC',10.59,'2024-10-09 13:06:14','2024-10-09 13:06:14',NULL,1,NULL,NULL),
(68,2,5,'BIANCA LISBETH MUñOZ SILVA','2450149345','Barrio Unión y progreso ','0995730984','biancalismusi@gmail.com','V CIPEC',10.59,'2024-10-09 15:37:45','2024-10-09 15:37:45',NULL,1,NULL,NULL),
(69,2,5,'BIANCA LISBETH MUñOZ SILVA','2450149345','Barrio Unión y progreso ','0995730984','biancalismusi@gmail.com','V CIPEC',10.59,'2024-10-09 15:38:20','2024-10-09 15:38:20',NULL,1,NULL,NULL),
(70,2,5,'BIANCA LISBETH MUñOZ SILVA','2450149345','Barrio Unión y progreso ','0995730984','biancalismusi@gmail.com','V CIPEC',10.59,'2024-10-09 15:39:08','2024-10-09 15:39:08',NULL,1,NULL,NULL),
(71,2,5,'BIANCA LISBETH MUñOZ SILVA','2450149345','Barrio Unión y progreso ','0995730984','biancalismusi@gmail.com','V CIPEC',10.59,'2024-10-09 15:40:37','2024-10-09 15:40:37',NULL,1,NULL,NULL),
(72,2,5,'BIANCA LISBETH MUñOZ SILVA','2450149345','Barrio Unión y progreso ','0995730984','biancalismusi@gmail.com','V CIPEC',10.59,'2024-10-09 15:41:09','2024-10-09 15:41:09',NULL,1,NULL,NULL),
(73,2,5,'CRISTIAN ALEXANDER RAMíREZ ROSERO','0250264587','Av magisterio ','0993120877','cristianrosero96@gmail.com','V CIPEC',10.59,'2024-10-09 15:53:54','2024-10-09 15:53:54',NULL,1,NULL,NULL),
(74,2,5,'SANTIAGO ISMAEL LóPEZ GALARZA','1850265214','Laguacoto bajo','0987160911','sl7203364@gmail.com','V CIPEC',10.59,'2024-10-09 16:10:03','2024-10-09 16:10:03',NULL,1,NULL,NULL),
(75,2,6,'VICTOR HUGO CABEZAS SISALEMA','0201132255','CIUDADELA JUAN XXIII','0997527681','VICTOR.CABEZAS@UEB.EDU.EC','V CIPEC',20.59,'2024-10-09 22:29:51','2024-10-09 22:29:51',NULL,1,NULL,NULL),
(76,2,5,'ANAIS SALOME CORONEL ESCUDERO','1754442497','Guaranda ','0989007419','anais.coronel@ueb.edu.ec','V CIPEC',10.59,'2024-10-09 22:52:23','2024-10-09 22:52:23',NULL,1,NULL,NULL),
(77,2,5,'YOSLIN ADRIANA JIMENEZ GIRON','1950097392','Loja ','0983039930','liderrenej@gmail.com','V CIPEC',10.59,'2024-10-09 22:57:10','2024-10-09 22:57:10',NULL,1,NULL,NULL),
(78,1,1,'LISSETTE SARA AGUILAR WILCA','0927529578','3 PASEO 24B','0999638709','LISSETTE.AGUILAR@UEB.EDU.EC','XI CTIE - II CIVS',40.59,'2024-10-09 23:36:37','2024-10-09 23:36:37',NULL,1,NULL,NULL),
(79,2,6,'ISABEL SOLANO MARCIA','0201312444','CHILLANES','0980023315','MARCIA.SOLANO@UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 00:40:21','2024-10-10 00:40:21',NULL,1,NULL,NULL),
(80,2,6,'IRLANDA VERONICA YUMISIBA YEPEZ','0202106381','LA TRONCAL','0983679701','VERONICA.YUMISIBA@UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 00:41:45','2024-10-10 00:41:45',NULL,1,NULL,NULL),
(81,2,6,'KATERINE KAROLINA COLOMA RAMIREZ','0202014932','MONTALVO','0991771582','KACOLOMA@MAILES.UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 00:42:13','2024-10-10 00:42:13',NULL,1,NULL,NULL),
(82,2,6,'WILLIAM PATRICIO MAZABANDA QUIQUINTUÑA','1804809976','PILAHUIN-TAMBOLOMA','0988661737','WILMAZABANDA@MAILES.UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 03:08:57','2024-10-10 03:08:57',NULL,1,NULL,NULL),
(83,2,6,'BRAYAN PATRICIO AGUALONGO AREVALO','0202361440','SAN SIMON','0986449343','BRAGUALONGO@MAILES.UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 03:15:20','2024-10-10 03:15:20',NULL,1,NULL,NULL),
(84,2,5,'DENNIS KENNETH QUILLE CHIDA','1805726245','Chalata','0969232720','dennis.quille@ueb.edu.ec','V CIPEC',10.59,'2024-10-10 11:31:57','2024-10-10 11:31:57',NULL,1,NULL,NULL),
(85,2,6,'MARíA AUGUSTA SERRANO BONILLA','0201582384','Guaranda','0993645354','magustyta80@gmail.com','V CIPEC',20.59,'2024-10-10 11:51:14','2024-10-10 11:51:14',NULL,1,NULL,NULL),
(86,2,5,'HEYDY LARITZA VILLAMAR BUÑAY','1251034391','JUAQUINA GALARZA GUARANDA','0989540038','HEYDY.VILLAMAR@UEB.EDU.EC','V CIPEC',10.59,'2024-10-10 11:58:36','2024-10-10 11:58:36',NULL,1,NULL,NULL),
(87,2,5,'HEYDY LARITZA VILLAMAR BUÑAY','1251034391','JUAQUINA GALARZA GUARANDA','0989540038','HEYDY.VILLAMAR@UEB.EDU.EC','V CIPEC',10.59,'2024-10-10 12:26:16','2024-10-10 12:26:16',NULL,1,NULL,NULL),
(88,2,5,'HEYDY LARITZA VILLAMAR BUÑAY','1251034391','JUAQUINA GALARZA GUARANDA','0989540038','HEYDY.VILLAMAR@UEB.EDU.EC','V CIPEC',10.59,'2024-10-10 12:29:01','2024-10-10 12:29:01',NULL,1,NULL,NULL),
(89,2,6,'SELENITA MIRELLA ORTEGA MINAYA','1202972384','CANTóN ECHEANDIA','0991722121','ORTEGA_1969@HOTMAIL.ES','V CIPEC',20.59,'2024-10-10 13:29:07','2024-10-10 13:29:07',NULL,1,NULL,NULL),
(90,2,5,'NATALY MONSERRAT TIPANTUñA GUERRA','0202608949','Izamba','0980544233','nataly.tipantuna@ueb.edu.ec','V CIPEC',10.59,'2024-10-10 13:49:07','2024-10-10 13:49:07',NULL,1,NULL,NULL),
(91,1,3,'MOREJON GARCíA MARíA FELICIDAD','0201658630','Guanujo ','0959867412','mmorejonregion5@gmail.com','XI CTIE - II CIVS',50.59,'2024-10-10 14:42:00','2024-10-10 14:42:00',NULL,1,NULL,NULL),
(92,3,9,'STEFANY ALEJANDRA MEDINA PAZOS','0202446266','San Miguel ','0967639176','stefanymedinapazos@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 15:48:25','2024-10-10 15:48:25',NULL,1,NULL,NULL),
(93,3,9,'NATALY PAULINA GUANIPATIN AGUILAR','0202432928','Guaranda ','0993225501','nataly.guanipatin@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 15:50:51','2024-10-10 15:50:51',NULL,1,NULL,NULL),
(94,1,4,'ALISSON MICAELA GAVI CAPITO','0202055943','Avenida 3 De Marzo','0989811578','gavimicaela8@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-10 18:24:39','2024-10-10 18:24:39',NULL,1,NULL,NULL),
(95,1,4,'VALERIA THAIZ LóPEZ IRIARTE','1750947630','Guaranda ','0989525077','valerialopez06042006@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-10 18:59:16','2024-10-10 18:59:16',NULL,1,NULL,NULL),
(96,2,6,'MARIA GRACIELA ALULEMA MOYOLEMA','0604608919','RIOBAMBA','0993980232','MARYALULEMA@YAHOO.ES','V CIPEC',20.59,'2024-10-10 19:13:38','2024-10-10 19:13:38',NULL,1,NULL,NULL),
(97,2,6,'NORMA ISABEL TACURI CEPEDA','0603594193','RIOBAMBA','0983516257','ISABELTACURI@GMAIL.COM','V CIPEC',20.59,'2024-10-10 19:15:35','2024-10-10 19:15:35',NULL,1,NULL,NULL),
(98,2,6,'LILIANA DEL ROSARIO VILLACIS URREA','0201291093','GUARANDA','0989476309','LILIANA.VILLACIS@UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 19:26:33','2024-10-10 19:26:33',NULL,1,NULL,NULL),
(99,2,6,'SILVIA GALUTH SANGACHA MOYANO','0201454477','SAN MIGUEL','0969699179','SILVIA.SANGACHA@EDUCACION.GOB.EC','V CIPEC',20.59,'2024-10-10 19:34:45','2024-10-10 19:34:45',NULL,1,NULL,NULL),
(100,2,6,'SEGUNDO ASENCIO CAIZA PUNINA','0200992915','SIMIÁTUG','0985343873','ASENCIOCAIZA71@GMAIL.COM','V CIPEC',20.59,'2024-10-10 19:52:43','2024-10-10 19:52:43',NULL,1,NULL,NULL),
(101,2,6,'GUDBERTO GABRIEL LUNA PANATA','0201267416','SAN MIGUEL DE BOLIVAR',NULL,'betoluna35@gmail.com','V CIPEC',20.59,'2024-10-10 19:53:46','2024-10-10 19:53:46',NULL,1,NULL,NULL),
(102,2,6,'BLANCA JANETH MORA SALTOS','0201802444','SAN MIGUEL DE BOLIVAR','0989157137','MORABLANCA134@GMAIL.COM','V CIPEC',20.59,'2024-10-10 19:58:01','2024-10-10 19:58:01',NULL,1,NULL,NULL),
(103,2,6,'JOSE MANUEL GUAMAN CUZCO','0604293688','COLTA','0993595050','JOSE.GUAMAN@UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 20:28:17','2024-10-10 20:28:17',NULL,1,NULL,NULL),
(104,2,6,'MARIA CECILIA ILLAPA CAIZAGUANO','0603491432','COLTA','0967101170','MARIA.ILLAPA@UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 20:31:21','2024-10-10 20:31:21',NULL,1,NULL,NULL),
(105,2,6,'LAURA VICTORIA BONILLA LOPEZ','0201899242','PICHINCHA Y SOLANDA','0986953206','LABONILLA@MAILES.UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 20:37:41','2024-10-10 20:37:41',NULL,1,NULL,NULL),
(106,2,6,'ESTELA GERMANIA MIÑO GUAMAN','0202204848','CHILLANES','0991240168','EMINO@MAILES.UEB.EDU.EC','V CIPEC',20.59,'2024-10-10 21:08:33','2024-10-10 21:08:33',NULL,1,NULL,NULL),
(107,3,9,'LEIDY ESTEFANIA ROBALINO LAJE','1723594857','GUARANDA',NULL,'leydirl1605@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 21:08:40','2024-10-10 21:08:40',NULL,1,NULL,NULL),
(108,3,9,'CHIGUANO YANZA LIZETH MARISOL','0250019155','SAN MIGUEL','0986416343','lizeth.chiguano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 21:36:40','2024-10-10 21:36:40',NULL,1,NULL,NULL),
(109,3,9,'JESSICA VIVIANA YAUQUI USHCA','0250215308','Guaranda','0983214969','jessica.yauqui@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 21:54:16','2024-10-10 21:54:16',NULL,1,NULL,NULL),
(110,3,9,'IVAN PATRICIO CHACHA CHACHA','0202173555','Guaranda','0994995580','patriciochacha33@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 22:01:23','2024-10-10 22:01:23',NULL,1,NULL,NULL),
(111,2,5,'DIANA VERONICA ORTIZ ALMEIDA','1207274919','Nuevo guanujo ','0990427601','do1207274919@gmail.com','V CIPEC',10.59,'2024-10-10 22:31:33','2024-10-10 22:31:33',NULL,1,NULL,NULL),
(112,2,6,'LEIDY ESTEFANIA ROBALINO LAJE','1723594857','GUARANDA',NULL,'leydirl1605@gmail.com','V CIPEC',20.59,'2024-10-10 22:36:35','2024-10-10 22:36:35',NULL,1,NULL,NULL),
(113,2,5,'MAURICIO ALEJANDRO GóMEZ TENESACA','0250021490','5 de junio','0988493886','mg4014423@gmail.com','V CIPEC',10.59,'2024-10-10 22:42:01','2024-10-10 22:42:01',NULL,1,NULL,NULL),
(114,1,4,'MARíA JOSé VIERA SáNCHEZ','1804522850','Píllaro Barrio San Marcos Calle Bolivar y Los Atis','0994400003','maria.viera@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-10 22:46:14','2024-10-10 22:46:14',NULL,1,NULL,NULL),
(115,1,4,'ROLANDO JAHIR SáNCHEZ ROMERO','1207723683','GUARANDA','0988226934','ROLANDOJHANIRS@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-10 23:05:04','2024-10-10 23:05:04',NULL,1,NULL,NULL),
(116,3,9,'JOSUE DAVID ALVAREZ GALEAS','0202421434','San Miguel ','0986399019','josue.alvarez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 23:07:24','2024-10-10 23:07:24',NULL,1,NULL,NULL),
(117,3,9,'MAYERLI JAMILETH BARRAGAN GAVILANES','0202245981','Guanujo Barrio la Botica','0968883892','mayerli.barragan@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 23:07:27','2024-10-10 23:07:27',NULL,1,NULL,NULL),
(118,3,9,'ANABEL ANAYS ACAN TOAPANTA','0605382886','Boyaca y alvarado',NULL,'anabelanaysacantoapanta@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 23:07:33','2024-10-10 23:07:33',NULL,1,NULL,NULL),
(119,3,9,'JENIFER KASANDRA SOLANO GUEVARA','0202433678','San Miguel de Bolivar','0990725058','jenifer.solano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 23:08:05','2024-10-10 23:08:05',NULL,1,NULL,NULL),
(120,1,4,'MAYRA ISABEL GAROFALO HIDALGO','0202541090','GUARANDA','0995770146','mayra.garofalo@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-10 23:44:24','2024-10-10 23:44:24',NULL,1,NULL,NULL),
(121,3,9,'MELANIE NAHOMY GAVIDIA GAVIDIA','0202211512','SAN JOSé DEL TAMBO','0981879320','GAVIDIAMELANIE@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 23:45:48','2024-10-10 23:45:48',NULL,1,NULL,NULL),
(122,3,9,'CAROL FABIOLA RAMIREZ FIERRO','0250045424','Guaranda','0968741662','carramirez@mailes.ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 23:46:09','2024-10-10 23:46:09',NULL,1,NULL,NULL),
(123,1,4,'SHIRLEY JALEC MARTINEZ GANCHOZO','1250875521','GRAMALOTE GRANDE VIA VENTANAS ECHEANDIA','0985009055','1996.JALECGANCHOZO@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-10 23:51:45','2024-10-12 17:58:43','2024-10-12 17:58:43',1,NULL,NULL),
(124,3,9,'CARMEN LISBETH LEÓN VACACELA','0605589076','Yaruquies - Capitan Lucas Pendi y 24 de Mayo','0986466029','carmen.leon@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-10 23:59:06','2024-10-10 23:59:06',NULL,1,NULL,NULL),
(125,3,9,'MARIA JOSE QUINATOA SISALEMA','0202175410','Guaranda','0993449490','maria.quinatoa@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:03:05','2024-10-11 00:03:05',NULL,1,NULL,NULL),
(126,3,9,'ESCARLETH LIZBETH PUCHA GUAILLA','0250012812','Guaranda ','0982639023','escarlethpucha16@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:03:28','2024-10-11 00:03:28',NULL,1,NULL,NULL),
(127,3,9,'ANDY DEYVISON CARVAJAL PAZMIñO','0202267936','San Miguel ','0993186867','andy.carvajal@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:03:50','2024-10-11 00:03:50',NULL,1,NULL,NULL),
(128,3,9,'ESCARLETH LIZBETH PUCHA GUAILLA','0250012812','Guaranda ','0982639023','escarlethpucha16@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:04:01','2024-10-11 00:04:01',NULL,1,NULL,NULL),
(129,3,9,'AMY MICAELA LóPEZ ESCOBAR','0250043353','Cdla. Los Trigales','0993949781','amy.lopez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:04:18','2024-10-11 00:04:18',NULL,1,NULL,NULL),
(130,3,9,'NEIVER RAFAEL GARCIA CANDO','0953087459','CALLE ESMERALDAS','0992030729','RAFAEL13CANDO@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:11:18','2024-10-13 04:02:52','2024-10-13 04:02:52',1,NULL,NULL),
(131,3,10,'KARLA ERENIA JACOME GUERRERO','0201951431','Cdla. Coloma Roman, Solano y Dávila esquina','0990135761','karla.jacome@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',25.59,'2024-10-11 00:22:41','2024-10-11 00:22:41',NULL,1,NULL,NULL),
(132,1,4,'ALISON LISBETH REINO ALDAZ','0202240149','Loma del Chorro ','0990066096','alisonreino14@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 00:25:39','2024-10-11 00:25:39',NULL,1,NULL,NULL),
(133,3,9,'DIANA VANESA CALLAN CHELA','0202610168','Guaranda ','0986277061','diana.callan@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:37:56','2024-10-11 00:37:56',NULL,1,NULL,NULL),
(134,1,4,'KEVIN FABRICIO SIGCHA RAMOS','0504212630','ALPACHACA','0960519630','KEVINSIGCHA4@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-11 00:39:52','2024-10-11 00:39:52',NULL,1,NULL,NULL),
(135,1,4,'KATHERYN VIVIANA MACAS RAMIREZ','0605620988','Guaranda','0983672657','katheryn.macas@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 00:40:55','2024-10-11 00:40:55',NULL,1,NULL,NULL),
(136,3,9,'KATHERYN VIVIANA MACAS RAMIREZ','0605620988','Guaranda','0983672657','katheryn.macas@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:42:00','2024-10-11 00:42:00',NULL,1,NULL,NULL),
(137,3,9,'KEVIN FABRICIO SIGCHA RAMOS','0504212630','ALPACHACA','0960519630','KEVINSIGCHA4@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:44:41','2024-10-11 00:44:41',NULL,1,NULL,NULL),
(138,1,4,'ERIKA TATIANA TUGLEMA MONTOYA','0250323888','San José de Chimbo - Tamban ','0967172115','erikatatianat35@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 00:44:43','2024-10-11 00:44:43',NULL,1,NULL,NULL),
(139,3,9,'CHARLY ANDRIW MOREJóN LLUMIGUANO','0250315439','SELVA ALEGRE Y CORONEL GARCIA','0995139835','CHARLYMOREJON759@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:45:32','2024-10-11 00:45:32',NULL,1,NULL,NULL),
(140,3,9,'ERIKA TATIANA TUGLEMA MONTOYA','0250323888','San José de Chimbo - Tamban ','0967172115','erikatatianat35@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 00:45:46','2024-10-11 00:45:46',NULL,1,NULL,NULL),
(141,1,4,'VANESSA WENDI ALARCòN ARèVALO','0202174652','Guaranda','0991976563','vanessa.alarcon@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 01:03:39','2024-10-11 01:03:39',NULL,1,NULL,NULL),
(142,1,4,'ESTEFANIA LISBETH SEGURA VILLACRES','0250177920','ECHEANDIA','0968915896','LISBETHSEGURA78@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-11 01:17:24','2024-10-11 01:17:24',NULL,1,NULL,NULL),
(143,3,9,'MARIANA DE JESúS YáNEZ','0202173522','Cdla. Las colinas','0986960005','mariana.yanez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:19:26','2024-10-11 01:19:26',NULL,1,NULL,NULL),
(144,3,9,'DAYANETH ANDREíNA QUINTANA COLOMA','0250031531','San Miguel ','0981198459','dayanethquintana@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:21:44','2024-10-11 01:21:44',NULL,1,NULL,NULL),
(145,3,9,'ANABEL MARISOL GUALLI IBARRA','0250132651','Guaranda ','0968901108','anabelgualli@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:22:08','2024-10-11 01:22:08',NULL,1,NULL,NULL),
(146,3,9,'HEYDI VANESA AYALA VILLA','0202407383','Guaranda','0990882664','heydi.ayala@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:22:12','2024-10-11 01:22:12',NULL,1,NULL,NULL),
(147,1,4,'NATALIA MARILIN VARGAS CARRERA','0202059481','La Magdalena ','0967244501','natalia.vargas@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 01:22:18','2024-10-13 03:42:02','2024-10-13 03:42:02',1,NULL,NULL),
(148,1,3,'RICHARD JHAIR BONILLA MORA','0202406724','San Miguel ','0989268083','richard.bonilla@ueb.edu.ec','XI CTIE - II CIVS',50.59,'2024-10-11 01:22:44','2024-10-11 01:22:44',NULL,1,NULL,NULL),
(150,1,4,'KENYA LEXAMARY BARRAGáN DELGADO','0250042546','San Miguel ','0991010560','kenyibarragan182@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 01:23:45','2024-10-11 01:23:45',NULL,1,NULL,NULL),
(151,1,4,'MARIANA ELIZABETH CRUZ ALLAN','0202054276','Chimbo','0979790241','mariana.cruz@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 01:24:03','2024-10-11 01:24:03',NULL,1,NULL,NULL),
(152,3,9,'FREDDY ANDRéS BENAVIDES ABRIL','0202167896','Recinto Llacan','0990750385','freddy.benavides@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:24:49','2024-10-11 01:24:49',NULL,1,NULL,NULL),
(153,1,4,'MARIANA ELIZABETH CRUZ ALLAN','0202054276','Chimbo','0979790241','mariana.cruz@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 01:24:51','2024-10-11 01:24:51',NULL,1,NULL,NULL),
(154,3,9,'WENDY SHULIZA TAPIA ACURIO','0202496261','La Magdalena ','0992494186','wendy.tapia@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:25:00','2024-10-13 02:55:02','2024-10-13 02:55:02',1,NULL,NULL),
(155,1,4,'ADRIAN ALBERTO RIOS PUJOS','0202176632','General Salazar y sucre ','0984507028','adrian.rios@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 01:26:53','2024-10-11 01:26:53',NULL,1,NULL,NULL),
(156,3,9,'NAYELI LIZBETH ZARUMA QUILLE','0202166062','Cdla. El Balcon El Libertador ','0994672503','nayeli.zaruma@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:27:38','2024-10-11 01:27:38',NULL,1,NULL,NULL),
(157,3,9,'WENDY SHULIZA TAPIA ACURIO','0202496261','La Magdalena ','0992494186','wendy.tapia@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:27:41','2024-10-11 01:27:41',NULL,1,NULL,NULL),
(158,3,9,'ANA GABRIELA ULLOA MENTA','0250043205','Azuay y 23 de Abril','0988280818','anita-ulloa101@hotmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:29:24','2024-10-11 01:29:24',NULL,1,NULL,NULL),
(159,3,9,'KEN ARMANDO SACAN PEñA','0202202016','Guaranda ','0968522715','ken.sacan@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:30:42','2024-10-11 01:30:42',NULL,1,NULL,NULL),
(160,3,9,'DAYANETH ANDREíNA QUINTANA COLOMA','0250031531','San Miguel ','0981198459','dayanethquintana@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:33:28','2024-10-11 01:33:28',NULL,1,NULL,NULL),
(161,3,9,'MAYERLY BRILLITH GUAILLA DURAN','0202271276','San pablo','0969346235','mayerly.guailla@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:34:07','2024-10-11 01:34:07',NULL,1,NULL,NULL),
(162,3,9,'NAYELI MARIBEL ESPIN OCAMPO','0202232153','Guanujo ','0990661980','nayelimaribelespinocampo@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:34:35','2024-10-11 01:34:35',NULL,1,NULL,NULL),
(163,1,4,'EVELYN ADRIANA BARRAGáN INFANTE','0202269007','Barrio la Victoria ','0997683928','evelyn.barragan@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 01:35:55','2024-10-11 01:35:55',NULL,1,NULL,NULL),
(164,3,9,'SAIRA KASANDRA CALERO AVEROS','0202515946','Guaranda ','0988866222','saira.calero@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:36:00','2024-10-11 01:36:00',NULL,1,NULL,NULL),
(166,3,9,'NATALIA MARILIN VARGAS CARRERA','0202059481','La Magdalena ','0967244501','natalia.vargas@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:36:38','2024-10-13 03:42:17','2024-10-13 03:42:17',1,NULL,NULL),
(167,3,9,'JESSICA STHEFANIA PASTO PATIN','0250306354','4 esquinas ','0994355815','jessica.pasto@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:37:08','2024-10-11 01:37:08',NULL,1,NULL,NULL),
(168,3,9,'CYNTHIA LISBETH TARIS ARELLANO','0202170916','Tolapungo ','0994248747','cynthia.taris@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:38:25','2024-10-11 01:38:25',NULL,1,NULL,NULL),
(169,3,9,'PUENTE VARGAS SILVIA LORENA','0202503454','San Miguel ','0980719695','silvia.puente@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:38:56','2024-10-11 01:38:56',NULL,1,NULL,NULL),
(170,3,9,'KARLA ANDREINA REA CABEZAS','0202367215','Llacan ','0993048004','karla.rea@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:39:02','2024-10-11 01:39:02',NULL,1,NULL,NULL),
(171,3,9,'RICHARD JHAIR BONILLA MORA','0202406724','San Miguel ','0989268083','richard.bonilla@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:40:34','2024-10-11 01:40:34',NULL,1,NULL,NULL),
(172,3,9,'ADRIAN ALBERTO RIOS PUJOS','0202176632','General Salazar y sucre ','0984507028','adrian.rios@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:42:09','2024-10-11 01:42:09',NULL,1,NULL,NULL),
(173,3,9,'JOHANNA YAMILETH LISCANO PEñAFIEL','0202170718','Las Naves ','0963146449','johanna.liscano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:42:45','2024-10-11 01:42:45',NULL,1,NULL,NULL),
(174,1,4,'VERóNICA ALEXANDRA MORA MONAR','0202271854','San Pablo de Atenas ','0989551681','veronica.mora@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 01:46:25','2024-10-11 01:46:25',NULL,1,NULL,NULL),
(175,3,9,'SHIRLEY KATERINE GUAILLA DURAN','0202271268','San Pablo de Atenas','0993700025','shirley.guailla@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:47:30','2024-10-11 01:47:30',NULL,1,NULL,NULL),
(176,3,9,'NATALIA MARILIN VARGAS CARRERA','0202059481','La Magdalena ','0967244501','natalia.vargas@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:47:31','2024-10-13 03:41:53','2024-10-13 03:41:53',1,NULL,NULL),
(177,3,9,'JURLENDY GABRIELA ESPIN ESTRADA','1250834916','LOS RíOS','0984231185','JURLENDY.ESPIN@UEB.EDU.EC','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:47:41','2024-10-11 01:47:41',NULL,1,NULL,NULL),
(178,3,9,'CHACHA CHIMBO JHOEL REMIGIO','0202495230','Barrio san Miguelito ','0963826149','jhoel.chacha@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:48:11','2024-10-11 01:48:11',NULL,1,NULL,NULL),
(179,3,9,'GABRIELA LISSETH GARCíA GARCíA','0202274049','San Miguel de Bolivar ','0997946798','lisseth.garcia@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:49:31','2024-10-11 01:49:31',NULL,1,NULL,NULL),
(180,3,9,'BRITHANY ADRIANA ESTRADA AGUILAR','1724759905','San Miguel ','0989968624','brithanye253@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:51:18','2024-10-11 01:51:18',NULL,1,NULL,NULL),
(181,3,9,'ERIKA NAYELI MARTINEZ GUERRERO','0202338786','Av. Simón bolivar ','0984832805','janeth246792@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:53:41','2024-10-11 01:53:41',NULL,1,NULL,NULL),
(182,3,9,'MAYRA ISABEL GAROFALO HIDALGO','0202541090','GUARANDA','0995770146','mayra.garofalo@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 01:58:19','2024-10-11 01:58:19',NULL,1,NULL,NULL),
(183,1,4,'LISBETH ROCIO SANTILLáN CAIZA','0250273836','Guaranda','0981120150','lisbeth.santillan@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 02:01:50','2024-10-11 02:01:50',NULL,1,NULL,NULL),
(184,3,9,'VERóNICA ALEXANDRA MORA MONAR','0202271854','San Pablo de Atenas ','0989551681','veronica.mora@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:01:57','2024-10-11 02:01:57',NULL,1,NULL,NULL),
(185,3,9,'KARELIS STHEFANIA YANEZ VEGA','0202384004','Guanujo','0962896268','kareliyanez@mailes.ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:01:57','2024-10-11 02:01:57',NULL,1,NULL,NULL),
(186,1,4,'CRISTINA YULICENTH TOABANDA QUINTANILLA','0202443313','Guaranda ','0994244606','cristinatoabanda5@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 02:02:03','2024-10-11 02:02:03',NULL,1,NULL,NULL),
(187,3,9,'DORYS JANNETH QUILLE CHELA','0250141124','Guaranda ','0992252705','doquille@mailes.ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:02:06','2024-10-11 02:02:06',NULL,1,NULL,NULL),
(188,3,9,'JENNY ESTEFANIA PILCO IZA','1850896273','Guaranda /Alpachaca ','0939603878','jenny.pilco@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:02:21','2024-10-11 02:02:21',NULL,1,NULL,NULL),
(189,3,9,'LISBETH ROCIO SANTILLáN CAIZA','0250273836','Guaranda','0981120150','lisbeth.santillan@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:04:23','2024-10-11 02:04:23',NULL,1,NULL,NULL),
(190,3,9,'CRISTINA YULICENTH TOABANDA QUINTANILLA','0202443313','Guaranda ','0994244606','cristinatoabanda5@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:05:27','2024-10-11 02:05:27',NULL,1,NULL,NULL),
(191,3,9,'GERMANIA INéS MARTíNEZ VáSQUEZ','0202327086','Centenario ','0939157436','germania4233z@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:10:28','2024-10-11 02:10:28',NULL,1,NULL,NULL),
(192,3,9,'DANIELA ALEJANDRA RIBADENEIRA PAZMIÑO','0201745890','GUARANDA','0997110596','dribadeneira@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:10:34','2024-10-11 02:10:34',NULL,1,NULL,NULL),
(193,3,9,'KENYA LEXAMARY BARRAGáN DELGADO','0250042546','San Miguel ','0991010560','kenyibarragan182@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:10:56','2024-10-11 02:10:56',NULL,1,NULL,NULL),
(194,3,9,'CRISTINA YULICENTH TOABANDA QUINTANILLA','0202443313','Guaranda ','0994244606','cristinatoabanda5@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:12:51','2024-10-11 02:12:51',NULL,1,NULL,NULL),
(195,2,6,'KARINA DEL ROCíO CRUZ','0202186755','CHIMBO ','0980381672','kacruz@mailes.ueb.edu.ec','V CIPEC',20.59,'2024-10-11 02:13:40','2024-10-11 02:13:40',NULL,1,NULL,NULL),
(196,3,9,'ALAN GEOVANY COLOMA LóPEZ','0202155743','10 de agosto ','0993759637','alan.coloma@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:13:52','2024-10-11 02:13:52',NULL,1,NULL,NULL),
(197,3,9,'MERY ALEXANDRA TARIZ LLUMIGUANO','0250266616','Tolapungo ','0986133866','mery.tariz@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:17:43','2024-10-11 02:17:43',NULL,1,NULL,NULL),
(198,3,9,'VIVIANA JESUS MARTINEZ VASQUEZ','0202327078','SAN MIGUEL','0984467107','viviana.martinez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:18:20','2024-10-11 02:18:20',NULL,1,NULL,NULL),
(199,2,5,'MAURICIO ALEJANDRO GóMEZ TENESACA','0250021490','5 de junio','0988493886','mg4014423@gmail.com','V CIPEC',10.59,'2024-10-11 02:20:37','2024-10-11 02:20:37',NULL,1,NULL,NULL),
(200,3,9,'MAYRA MARLENE VASCONEZ DURAN','0202242889','Guaranda ','0980307073','mayra.vasconez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 02:27:10','2024-10-11 02:27:10',NULL,1,NULL,NULL),
(201,2,5,'ANDERSON FRANCISCO LOMBEIDA RAMOS','1250748280','Guaranda ','0969749958','anderson.lombeida@ueb.edu.ec','V CIPEC',10.59,'2024-10-11 02:41:47','2024-10-11 02:41:47',NULL,1,NULL,NULL),
(202,1,4,'ALEX AGUSTIN MANOBANDA CALERO','0250326196','Guaranda','0983353478','alex.manobanda@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 02:59:20','2024-10-11 02:59:20',NULL,1,NULL,NULL),
(203,3,9,'ALEX AGUSTIN MANOBANDA CALERO','0250326196','Guaranda','0983353478','alex.manobanda@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:01:38','2024-10-11 03:01:38',NULL,1,NULL,NULL),
(204,3,9,'ALEX AGUSTIN MANOBANDA CALERO','0250326196','Guaranda','0983353478','alex.manobanda@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:05:26','2024-10-11 03:05:26',NULL,1,NULL,NULL),
(205,3,9,'GENARO FABRICIO NUñEZ ROSERO','0202487278','Barrrio Jesús del Gran Poder','0967294937','fabricio.nunez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:06:58','2024-10-11 03:06:58',NULL,1,NULL,NULL),
(206,3,9,'ELIAS DAVID TARIS QUILLE','0202175964','Vinchoa Sector la Y','0991362351','elias.taris@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:12:39','2024-10-11 03:12:39',NULL,1,NULL,NULL),
(207,2,6,'ESTELA GERMANIA MIÑO GUAMAN','0202204848','CHILLANES','0991240168','EMINO@MAILES.UEB.EDU.EC','V CIPEC',20.59,'2024-10-11 03:12:44','2024-10-11 03:12:44',NULL,1,NULL,NULL),
(208,1,4,'ROSA JANNETH LLUMIGUANO CHIMBO','0250156551','Pircapamba ','0989733658','janneth.llumiguano@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 03:13:36','2024-10-11 03:13:36',NULL,1,NULL,NULL),
(209,3,9,'EDWIN ARIEL CHANAGUANO AYME','0250345840','Guaranda','0991701882','edwin.chanaguano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:13:47','2024-10-11 03:13:47',NULL,1,NULL,NULL),
(210,3,9,'EDWIN ARIEL CHANAGUANO AYME','0250345840','Guaranda','0991701882','edwin.chanaguano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:14:14','2024-10-11 03:14:14',NULL,1,NULL,NULL),
(211,2,6,'OLGA ISA','0201502200','CHUNCHI','0988176079','OLGAISA350@GMAIL.COM','V CIPEC',20.59,'2024-10-11 03:16:57','2024-10-11 03:16:57',NULL,1,NULL,NULL),
(212,2,6,'FABIOLA MARGARITA AGUILAR SISA','0250010261','Vinchoa','0993164419','faaguilar@mailes.ueb.edu.ec','V CIPEC',20.59,'2024-10-11 03:24:14','2024-10-11 03:24:14',NULL,1,NULL,NULL),
(213,2,6,'FABIOLA MARGARITA AGUILAR SISA','0250010261','Vinchoa','0993164419','faaguilar@mailes.ueb.edu.ec','V CIPEC',20.59,'2024-10-11 03:25:29','2024-10-11 03:25:29',NULL,1,NULL,NULL),
(214,3,9,'JESSICA ADRIANA QUICALIQUIN ROCHINA','0250328580','Guanujo','0978966696','jessica.quicaliquin@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:29:38','2024-10-11 03:29:38',NULL,1,NULL,NULL),
(215,1,4,'CHIMBORAZO CHANAGUANO GLORIA NATALIA','0250338167','Guaranda ','0980336519','gloria.chimborazo@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 03:31:20','2024-10-11 03:31:20',NULL,1,NULL,NULL),
(216,3,9,'CHIMBORAZO CHANAGUANO GLORIA NATALIA','0250338167','Guaranda ','0980336519','gloria.chimborazo@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 03:33:12','2024-10-11 03:33:12',NULL,1,NULL,NULL),
(217,3,9,'KRISTEL MILENA PASTO PAZTO','0250179413','GUANUJO - A UNA CUADRA MáS ABAJO DE LA ENTRADA ALPACHACA','0967836252','KRISTELPASTO2@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 05:09:58','2024-10-11 05:09:58',NULL,1,NULL,NULL),
(218,1,4,'ANGELA DEL ROCíO YáNEZ','0202268793','San Miguel de Bolívar ','0990810227','angelayanez125@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 05:20:42','2024-10-11 05:20:42',NULL,1,NULL,NULL),
(219,3,9,'ALVAREZ NUñEZ MARCO VINICIO','0250055209','San Miguel','0989047422','marco.alvarez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 05:45:34','2024-10-11 05:45:34',NULL,1,NULL,NULL),
(220,3,9,'KELVIN ALEXANDER YAZUMA GUAMBUGUETE','0202337077','Guaranda','0988319320','kelvin.yazuma@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 06:48:46','2024-10-11 06:48:46',NULL,1,NULL,NULL),
(221,3,9,'DEIVI GREGORIO SINALUISA LÓPEZ','0202277141','San Miguel ','0968846414','deivi.sinaluisa@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 08:33:25','2024-10-11 08:33:25',NULL,1,NULL,NULL),
(222,3,9,'MERY ALEXANDRA TARIZ LLUMIGUANO','0250266616','Tolapungo ','0986133866','mery.tariz@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 08:52:26','2024-10-11 08:52:26',NULL,1,NULL,NULL),
(223,3,9,'MOYON ABRIL JENNY ALEXANDRA','0202052403','Guaranda ','0992846828','alemoyon.18@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 11:21:42','2024-10-11 11:21:42',NULL,1,NULL,NULL),
(224,3,9,'VIVIANA YAMILET BASANTES GóMEZ','1250944533','Alpachaca ','0990849459','viviana.basantes@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 11:36:11','2024-10-11 11:36:11',NULL,1,NULL,NULL),
(225,2,6,'EDUARDO YáNEZ','0201358371','SAN MIGUEL','0986230490','EDUARDMIGUELYANEZ@GMAIL.COM','V CIPEC',20.59,'2024-10-11 12:32:01','2024-10-11 12:32:01',NULL,1,NULL,NULL),
(226,3,9,'ROSA JANNETH LLUMIGUANO CHIMBO','0250156551','Pircapamba ','0989733658','janneth.llumiguano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 12:54:43','2024-10-11 12:54:43',NULL,1,NULL,NULL),
(227,2,6,'NELLY NARCIZA GUARANDA AGUILAR','0201901675','ECHEANDíA.','0980613894','NENAGA33@YAHOO.ES','V CIPEC',20.59,'2024-10-11 13:01:12','2024-10-11 13:01:12',NULL,1,NULL,NULL),
(228,3,11,'JEFFERSON BENITO GARCÍA VEGA','0202418711','QUITO','0958870583','JEFF_G24@HOTMAIL.ES','VI SEMINARIO INVESTIGACIÓN',30.59,'2024-10-11 13:03:40','2024-10-11 13:03:40',NULL,1,NULL,NULL),
(229,3,9,'CRISTIAN STEVEN CASTILLO CASTELLANO','1723329007','Alpachaca','0989202917','cristian.castillo@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 13:24:58','2024-10-11 13:24:58',NULL,1,NULL,NULL),
(230,2,5,'FREDDY JOEL MERINO GUALANCAñAY','0604759555','RIOBAMBA','0993142796','FREDDY.MERINO@UEB.EDU.EC','V CIPEC',10.59,'2024-10-11 13:40:47','2024-10-11 13:40:47',NULL,1,NULL,NULL),
(231,3,9,'RONAL GERMáN CHILENO GUAMAN','0202699609','Floresta alta','0985484216','ronal.chileno@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 13:41:14','2024-10-11 13:41:14',NULL,1,NULL,NULL),
(232,3,9,'MARIANA ELIZABETH CRUZ ALLAN','0202054276','Chimbo','0979790241','mariana.cruz@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 14:02:26','2024-10-11 14:02:26',NULL,1,NULL,NULL),
(233,3,9,'MARIANA ELIZABETH CRUZ ALLAN','0202054276','Chimbo','0979790241','mariana.cruz@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 14:07:05','2024-10-11 14:07:05',NULL,1,NULL,NULL),
(234,3,9,'NATALIA MARILIN VARGAS CARRERA','0202059481','La Magdalena ','0967244501','natalia.vargas@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 14:15:25','2024-10-13 03:42:10','2024-10-13 03:42:10',1,NULL,NULL),
(235,3,9,'VANESSA BRIGGITTE FREIRE NARANJO','0954093472','Echeandía ',NULL,'vfreire@mailes.ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 14:17:43','2024-10-11 14:17:43',NULL,1,NULL,NULL),
(236,1,4,'BARRENO COCA ROMMEL ANDRES','1805443544','Victor hugo ','0983937179','rommelbarreno01@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 14:17:56','2024-10-11 14:17:56',NULL,1,NULL,NULL),
(237,3,9,'NATALIA MARILIN VARGAS CARRERA','0202059481','La Magdalena ','0967244501','natalia.vargas@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 14:19:25','2024-10-11 14:19:25',NULL,1,NULL,NULL),
(238,2,5,'BARRENO COCA ROMMEL ANDRES','1805443544','Victor hugo ','0983937179','rommelbarreno01@gmail.com','V CIPEC',10.59,'2024-10-11 14:19:56','2024-10-11 14:19:56',NULL,1,NULL,NULL),
(239,3,9,'NATALIA MARILIN VARGAS CARRERA','0202059481','La Magdalena ','0967244501','natalia.vargas@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 14:23:35','2024-10-13 03:42:26','2024-10-13 03:42:26',1,NULL,NULL),
(240,3,9,'WENDY ELIZABETH CALUÑA PEREZ','0250024295','BARRIO LAS PALMAS','0984372944','WENDY.CALUNA@UEB.EDU.EC','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 16:31:29','2024-10-11 16:31:29',NULL,1,NULL,NULL),
(241,3,9,'MAIKEL ANDRéS SALGUERO MORA','0250133527','San Miguel ','0990589618','maikelsalguero08@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 16:39:28','2024-10-11 16:39:28',NULL,1,NULL,NULL),
(242,1,4,'MARíA LUISA CHACHA PATIN','0202662052','Quinuacorral ','0998156961','maria.chacha@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 16:59:45','2024-10-11 16:59:45',NULL,1,NULL,NULL),
(243,3,9,'DAYANA MARISOL GAIBOR FUENTES','0202430237','BALSAPAMBA','0999628581','DAYANITAGAIBOR18@GMAILL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 17:10:00','2024-10-11 17:10:00',NULL,1,NULL,NULL),
(244,3,9,'MALLERLY MIRLEY FRANCO TROYA','0202210530','Guaranda','0960068935','mirley.franco@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 17:18:03','2024-10-11 17:18:03',NULL,1,NULL,NULL),
(245,1,4,'ROBINSON STEVEN ALBIñO NARANJO','0202472163','Guaranda ','0961923680','royalbino0416@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 17:26:58','2024-10-11 17:26:58',NULL,1,NULL,NULL),
(246,2,5,'ROBINSON STEVEN ALBIñO NARANJO','0202472163','Guaranda ','0961923680','royalbino0416@gmail.com','V CIPEC',10.59,'2024-10-11 17:30:09','2024-10-11 17:30:09',NULL,1,NULL,NULL),
(247,1,4,'JHONNY AURELIO ALVAREZ PAZMIñO','0202340345','Terminal ','0979434884','jhonny.alvarez@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-11 17:34:52','2024-10-11 17:34:52',NULL,1,NULL,NULL),
(248,3,9,'MAYRA ISABEL TIBANLOMBO CHACHA','0202477360','Guaranda','0979552790','mayra.tibanlombo@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 18:24:22','2024-10-11 18:24:22',NULL,1,NULL,NULL),
(249,3,9,'GISSELLA ALEXANDRA VEGA LOPEZ','0202428975','Guaranda ','0985522997','gissellavega249@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 18:24:40','2024-10-11 18:24:40',NULL,1,NULL,NULL),
(250,3,9,'JONATHAN ROLANDO UQUILLAS MONAR','0250280195','Complejo ','0939872066','jonathanuquillas4@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 19:30:44','2024-10-11 19:30:44',NULL,1,NULL,NULL),
(251,3,9,'EVELYN ADRIANA BARRAGáN INFANTE','0202269007','Barrio la Victoria ','0997683928','evelyn.barragan@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 19:31:54','2024-10-11 19:31:54',NULL,1,NULL,NULL),
(252,3,9,'MARLENE GUADALUPE VáSCONEZ MERA','0202218038','Guanujo- Alpachaca','0960164236','marlene.vasconez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 21:05:58','2024-10-11 21:05:58',NULL,1,NULL,NULL),
(253,3,9,'LISSETH CAROLINA TOAQUIZA NINASUNTA','0550004592','Alpachaca ','0981968156','lisseth.toaquiza@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 21:06:48','2024-10-11 21:06:48',NULL,1,NULL,NULL),
(254,3,9,'CARMEN GUISSELA TANDAPILCO MUñOZ','0250328770','Los tanques','0983193243','carmen.tandapilco@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 21:07:58','2024-10-11 21:07:58',NULL,1,NULL,NULL),
(255,3,9,'ELVIA JEANNETH RUMIGUANO SANTILLAN','0250240132','San juan de Llullundongo','0987110796','elvia.rumiguano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 22:10:08','2024-10-11 22:10:08',NULL,1,NULL,NULL),
(256,3,9,'ELVIA JEANNETH RUMIGUANO SANTILLAN','0250240132','San juan de Llullundongo','0987110796','elvia.rumiguano@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 22:12:30','2024-10-11 22:12:30',NULL,1,NULL,NULL),
(257,3,9,'ERIKA NAYELI MARTINEZ GUERRERO','0202338786','Av. Simón bolivar ','0984832805','janeth246792@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 22:17:44','2024-10-11 22:17:44',NULL,1,NULL,NULL),
(259,3,9,'VANESSA WENDI ALARCòN ARèVALO','0202174652','Guaranda','0991976563','vanessa.alarcon@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 22:32:18','2024-10-11 22:32:18',NULL,1,NULL,NULL),
(260,1,4,'SANDRA MORELLYA NOBOA LARA','0250149234','Coronel García y García Moreno','0961896411','sandramore.noboa@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-11 23:30:27','2024-10-11 23:30:27',NULL,1,NULL,NULL),
(261,3,9,'COELLO GUEVARA CRISBEL DAYANARA','0504445867','Latacunga ','0983117717','crisbel.coello@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 23:58:13','2024-10-11 23:58:13',NULL,1,NULL,NULL),
(262,3,9,'DORIAN ANTUAN YACCHIREMA TARAGUAY','0250139250','5 de junio y los lirios ','0999981366','yacchiremaanthuan@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-11 23:59:03','2024-10-11 23:59:03',NULL,1,NULL,NULL),
(263,3,9,'EVELYN NAHOMY VALVERDE REMACHE','0250140803','Ciudadela Marcopamba ','0987120112','evelyn.valverde@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 00:01:04','2024-10-12 00:01:04',NULL,1,NULL,NULL),
(264,3,9,'EVELYN NAHOMY VALVERDE REMACHE','0250140803','Ciudadela Marcopamba ','0987120112','evelyn.valverde@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 00:03:41','2024-10-12 00:03:41',NULL,1,NULL,NULL),
(265,3,9,'BRIGITTE NAHOMI NARANJO MEDINA','0504086901','Salcedo','0984553992','brigitte.naranjo@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 00:33:21','2024-10-12 00:33:21',NULL,1,NULL,NULL),
(266,3,9,'JOSELYN GEOMAYRA MORENO CRUZ','0550520654','Latacunga ','0961966048','joselyn.moreno@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 00:38:13','2024-10-12 00:38:13',NULL,1,NULL,NULL),
(267,2,7,'RENATO ESTUARDO PAREDES CRUZ','1710052661','Guanujo-guaranda','0999166979','rparedes@ueb.edu.ec','V CIPEC',30.59,'2024-10-12 00:56:51','2024-10-12 00:56:51',NULL,1,NULL,NULL),
(268,3,9,'MARCELO JOEL MOREJóN LLUMIGUANO','0250267374','Selva Alegre y coronel García ',NULL,'marcmorejon@mailes.ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 01:35:30','2024-10-12 01:35:30',NULL,1,NULL,NULL),
(269,3,9,'JOSé CARLOS GUERRERO GUERRERO','0250010337','Guaranda','0989285252','calin7155@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 02:51:30','2024-10-12 02:51:30',NULL,1,NULL,NULL),
(270,3,9,'DAVID ALEXANDER LLERENA CALERO','1805291919','Dr, Alfaro Agusto del Pozo','0984186984','david.llerena@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 02:52:47','2024-10-13 03:59:07','2024-10-13 03:59:07',1,NULL,NULL),
(271,3,9,'DAVID ALEXANDER LLERENA CALERO','1805291919','Dr, Alfaro Agusto del Pozo','0984186984','david.llerena@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 02:53:18','2024-10-12 02:53:18',NULL,1,NULL,NULL),
(272,3,9,'LETICIA LIZBETH OCAñA QUILLIGANA','1850766997','Ambato ','0985259209','ocanalizbeth@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 02:57:30','2024-10-12 02:57:30',NULL,1,NULL,NULL),
(273,3,9,'NEIVER RAFAEL GARCIA CANDO','0953087459','CALLE ESMERALDAS','0992030729','RAFAEL13CANDO@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 02:59:27','2024-10-12 02:59:27',NULL,1,NULL,NULL),
(274,1,4,'MARíA LUISA CHACHA PATIN','0202662052','Quinuacorral ','0998156961','maria.chacha@ueb.edu.ec','XI CTIE - II CIVS',10.59,'2024-10-12 03:02:43','2024-10-12 03:02:43',NULL,1,NULL,NULL),
(275,3,9,'JOSUE ALEXANDER CHáVEZ CHáVEZ','0250041357','Gustavo Lemos y Ambato','0984361970','josuechavez719@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:03:32','2024-10-12 03:03:32',NULL,1,NULL,NULL),
(276,3,9,'OLGA JACQUELINE GUACHI GUANíN','1850677491','Pillaro-Tungurahua ','0981401901','jackelineguachi@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:08:36','2024-10-12 03:08:36',NULL,1,NULL,NULL),
(277,3,9,'YULEXI YAMILEX ROCHA RAMIREZ','1251110118','MONTALVO','0969184221','YULEXIROCHA2512@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:08:45','2024-10-13 04:05:18','2024-10-13 04:05:18',1,NULL,NULL),
(278,3,9,'KARLA MAYERLY PéREZ TOALOMBO','0202364295','Guaranda ','0993036414','karla.perez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:10:03','2024-10-12 03:10:03',NULL,1,NULL,NULL),
(279,3,9,'SHIRLEY JALEC MARTINEZ GANCHOZO','1250875521','GRAMALOTE GRANDE VIA VENTANAS ECHEANDIA','0985009055','1996.JALECGANCHOZO@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:12:46','2024-10-12 03:12:46',NULL,1,NULL,NULL),
(280,3,9,'YULEXI YAMILEX ROCHA RAMIREZ','1251110118','MONTALVO','0969184221','YULEXIROCHA2512@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:16:01','2024-10-13 04:05:07','2024-10-13 04:05:07',1,NULL,NULL),
(281,3,9,'YULEXI YAMILEX ROCHA RAMIREZ','1251110118','MONTALVO','0969184221','YULEXIROCHA2512@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:19:57','2024-10-13 04:04:59','2024-10-13 04:04:59',1,NULL,NULL),
(282,3,9,'YULEXI YAMILEX ROCHA RAMIREZ','1251110118','MONTALVO','0969184221','YULEXIROCHA2512@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 03:20:59','2024-10-12 03:20:59',NULL,1,NULL,NULL),
(283,1,4,'SOFIA NATALY CANDO CHELA','0250320579','GUARANDA','0994718630','SOFIACANDO37@GMAIL.COM','XI CTIE - II CIVS',10.59,'2024-10-12 03:36:19','2024-10-12 03:36:19',NULL,1,NULL,NULL),
(284,3,9,'JHOSELYN MISHELL BENAVIDES PANTE','0250330150','VIA A LA GUITARRA','0993600737','JHOSELYNB0107@HOTMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 08:28:48','2024-10-12 08:28:48',NULL,1,NULL,NULL),
(285,3,9,'SANDY MIKAELA CADENA GOMEZ','0250173580','GUANUJO','0990873669','CADENASANDY466@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 09:51:04','2024-10-12 09:51:04',NULL,1,NULL,NULL),
(286,3,9,'VIVIANA ALEXANDRA REMACHE ATI','0604643841','Guaranda','0969838182','viremache@mailes.ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 12:28:33','2024-10-12 12:28:33',NULL,1,NULL,NULL),
(287,3,9,'SHEYLA ESTEFANNIA PAREDES HARO','1804512380','Píllaro ','0990887557','sheyla.paredes@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 13:21:51','2024-10-12 13:21:51',NULL,1,NULL,NULL),
(288,3,9,'FRANKLIN DAVID QUISHPE PILATASIG','0550157200','Pilalo ','0959456333','franklin.quishpe@ueb.edu.ece','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 13:41:27','2024-10-13 04:07:43','2024-10-13 04:07:43',1,NULL,NULL),
(289,3,9,'FRANKLIN DAVID QUISHPE PILATASIG','0550157200','Pilalo ','0959456333','franklin.quishpe@ueb.edu.ece','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 13:45:05','2024-10-12 13:45:05',NULL,1,NULL,NULL),
(290,1,4,'ANA OFELIA RUMIGUANO AUCATOMA','0202161857','Via Echiandia ','0939143653','rumiguanoana890@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-12 13:46:47','2024-10-12 17:29:13','2024-10-12 17:29:13',1,NULL,NULL),
(291,2,5,'ANA OFELIA RUMIGUANO AUCATOMA','0202161857','Via Echiandia ','0939143653','rumiguanoana890@gmail.com','V CIPEC',10.59,'2024-10-12 13:49:31','2024-10-12 13:49:31',NULL,1,NULL,NULL),
(293,3,9,'JOSELYN ALEXANDRA BRITO NUñEZ','1850420553','Guanujo ','0983391426','joselyn.brito@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 14:42:57','2024-10-12 14:42:57',NULL,1,NULL,NULL),
(294,3,11,'JEFFERSON BENITO GARCÍA VEGA','0202418711','QUITO','0958870583','JEFF_G24@HOTMAIL.ES','VI SEMINARIO INVESTIGACIÓN',30.59,'2024-10-12 14:44:26','2024-10-12 14:44:26',NULL,1,NULL,NULL),
(295,3,11,'JEFFERSON BENITO GARCÍA VEGA','0202418711','QUITO','0958870583','JEFF_G24@HOTMAIL.ES','VI SEMINARIO INVESTIGACIÓN',30.59,'2024-10-12 14:45:06','2024-10-12 14:45:06',NULL,1,NULL,NULL),
(296,3,9,'GABRIELA MABEL VELOZ MORA','0202166922','Alpachaca ','0992844357','gabyveloz2405@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 15:03:40','2024-10-12 15:03:40',NULL,1,NULL,NULL),
(297,3,9,'DARLA YAMELL GALARZA NUñEZ','0202555447','San José de Chimbo/circunvalación ',NULL,'darlagalarza@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 15:19:39','2024-10-12 15:19:39',NULL,1,NULL,NULL),
(298,3,9,'ERIKA ANDREA VARGAS RIVERA','1755087606','VIA GUARANDA-AMBATO','5949699592','LEIDYADJE7846@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 15:31:37','2024-10-12 15:31:37',NULL,1,NULL,NULL),
(299,3,9,'ERIKA ANDREA VARGAS RIVERA','1755087606','VIA GUARANDA-AMBATO','5949699592','LEIDYADJE7846@GMAIL.COM','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 15:32:26','2024-10-12 15:32:26',NULL,1,NULL,NULL),
(300,2,6,'KERLY BRIGITH NARANJO AGUIRRE','0202172045','GUARANDA','0987704598','KERNARANJO@MAILES.UEB.EDU.EC','V CIPEC',20.59,'2024-10-12 15:47:23','2024-10-12 15:47:23',NULL,1,NULL,NULL),
(301,2,5,'GENESIS DALINDA PALACIOS ZAMBRANO','1207439462','MARCOMPAMBA','0997462494','SISENEGPALACIOS39@GMAIL.COM','V CIPEC',10.59,'2024-10-12 16:00:19','2024-10-12 19:10:29',NULL,1,NULL,NULL),
(302,3,9,'ANTHONY SEBASTIáN CHáVEZ CASTILLO','0250033198','Barrio El Peñon','0968105586','anthony.chavez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 16:01:43','2024-10-12 16:01:43',NULL,1,NULL,NULL),
(303,3,9,'DANIELA ALEXANDRA ALARCON VELOZ','0250022209','Guaranda','0981873315','daniela.alarcon@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 16:27:21','2024-10-12 16:27:21',NULL,1,NULL,NULL),
(304,3,9,'KERLY JOHANNA AGUALONGO PACHALA','0250266293','Guaranda','0992100950','kerly.agualongo@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 16:34:49','2024-10-12 16:34:49',NULL,1,NULL,NULL),
(305,3,9,'NAYDELIN ANDRIVEL BONILLA CHILENO','0202171550','GUANUJO','0939086214','NAYDELIN.BONILLA@UEB.EDU.EC','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 17:29:09','2024-10-12 17:29:09',NULL,1,NULL,NULL),
(306,3,9,'NAYDELIN ANDRIVEL BONILLA CHILENO','0202171550','GUANUJO','0939086214','NAYDELIN.BONILLA@UEB.EDU.EC','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 17:34:09','2024-10-12 17:34:09',NULL,1,NULL,NULL),
(307,3,9,'MARILYN JAMILET CUNALATA USHCA','0250234929','El Castillo ','0990999113','marilyncunalata6@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 18:43:58','2024-10-12 18:43:58',NULL,1,NULL,NULL),
(308,2,6,'CRISTINA BEATRIZ GARCIA ORTIZ','0602616039','SIMIATUG','0985591561','BEATRIZ.GARCIAA32@GMAIL.COM','V CIPEC',20.59,'2024-10-12 18:59:08','2024-10-12 18:59:08',NULL,1,NULL,NULL),
(309,3,9,'BRITHANY ALEJANDRA GUTIéRREZ NAULA','0250191830','Guanujo','0997898178','brithany.gutierrez@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 19:01:39','2024-10-12 19:01:39',NULL,1,NULL,NULL),
(310,2,6,'SILVIA ENITH CAMPOVERDE MERINO','2100421441','NUEVA LOJA, PROVINCIA DE SUCUMBíOS','0997759084','SILVIACAMPOVERDE964@GMAIL.COM','V CIPEC',20.59,'2024-10-12 19:28:09','2024-10-12 19:28:09',NULL,1,NULL,NULL),
(311,3,9,'ERIKA NAYELI MARTINEZ GUERRERO','0202338786','Av. Simón bolivar ','0984832805','janeth246792@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 20:20:27','2024-10-12 20:20:27',NULL,1,NULL,NULL),
(312,3,9,'JOHANA PATRICIA ESPINOZA GUERRERO','0202150389','Chimbo ','0989277675','johana.espinoza@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 20:34:34','2024-10-12 20:34:34',NULL,1,NULL,NULL),
(313,3,9,'SELENA ARACELI FUENTES GARCíA','0202055414','Llacan ','0985824480','selena.fuentes@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 20:35:47','2024-10-12 20:35:47',NULL,1,NULL,NULL),
(314,3,9,'ALEX PATRICIO LEMA LEóN','0202438578','Parroquia Santiago, Canton San Miguel, Provincia Bolivar ','0984105481','alexlema2330@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 20:37:28','2024-10-12 20:37:28',NULL,1,NULL,NULL),
(315,3,9,'LIZBETH MICAELA YANZA LEóN','0202269866','San Miguel de bolivar ','0980600187','lizbeth.yanza@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 20:41:19','2024-10-12 20:41:19',NULL,1,NULL,NULL),
(316,3,9,'ANABEL ANAYS ACAN TOAPANTA','0605382886','Boyaca y alvarado',NULL,'anabelanaysacantoapanta@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 21:14:37','2024-10-12 21:14:37',NULL,1,NULL,NULL),
(317,3,9,'ANABEL ANAYS ACAN TOAPANTA','0605382886','Boyaca y alvarado',NULL,'anabelanaysacantoapanta@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 21:23:19','2024-10-12 21:23:19',NULL,1,NULL,NULL),
(318,3,9,'ALEXANDRA ELIZABETH ESPIN CHALAN','1804411864','SANTA ROSA','0983838614','alexandra.espin@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 21:34:26','2024-10-12 21:34:26',NULL,1,NULL,NULL),
(319,3,9,'PATRICIA MARIBEL ACOSTA CARVAJAL','0504872789','Guanujo ','0983494626','patricia.acosta@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 21:43:45','2024-10-12 21:43:45',NULL,1,NULL,NULL),
(320,2,5,'JESSICA MILENA SANGUANO BOLAGAY','1728578194','Laguacoto ','0962546692','jessimile335@gmail.com','V CIPEC',10.59,'2024-10-12 22:03:09','2024-10-12 22:03:09',NULL,1,NULL,NULL),
(321,3,9,'LORENA BELéN ROJAS VACA','1207213578','Av. Ernesto Che Guevara','0985242825','rojas.lorena@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 22:15:40','2024-10-12 22:15:40',NULL,1,NULL,NULL),
(322,3,9,'LORENA BELéN ROJAS VACA','1207213578','Av. Ernesto Che Guevara','0985242825','rojas.lorena@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 22:16:03','2024-10-12 22:16:03',NULL,1,NULL,NULL),
(323,3,9,'BRENDA ANDREA BASANTES TúQUERRES','1755516505','Entrada 1 y Dr. Jaime Velasco','0999779965','brenda.basantes@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-12 22:20:20','2024-10-12 22:20:20',NULL,1,NULL,NULL),
(324,3,9,'KAREN ELENA GAVILANES RIVERA','0202170403','Guanujo ',NULL,'karenelena2008@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-13 00:25:51','2024-10-13 00:25:51',NULL,1,NULL,NULL),
(325,2,6,'MARITZA JANETH CARRILLO NARANJO','0201062874','EL PEñON BAJO','0939018947','CARRILLONARANJOMARITZAJANETH@GMAIL.COM','V CIPEC',20.59,'2024-10-13 00:29:43','2024-10-13 00:29:43',NULL,1,NULL,NULL),
(326,2,6,'MARTHA TERESA CHÁVEZ CARRILLO','0201236999','GUARANDA','0989496113','CHAVEZMARTHA2106@GMAIL.COM','V CIPEC',20.59,'2024-10-13 00:33:45','2024-10-13 00:33:45',NULL,1,NULL,NULL),
(327,3,9,'WENDY SHULIZA TAPIA ACURIO','0202496261','La Magdalena ','0992494186','wendy.tapia@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-13 00:45:32','2024-10-13 02:55:21','2024-10-13 02:55:21',1,NULL,NULL),
(328,3,9,'WENDY SHULIZA TAPIA ACURIO','0202496261','La Magdalena ','0992494186','wendy.tapia@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-13 00:49:39','2024-10-13 02:54:53','2024-10-13 02:54:53',1,NULL,NULL),
(329,3,9,'WENDY SHULIZA TAPIA ACURIO','0202496261','La Magdalena ','0992494186','wendy.tapia@ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-13 01:00:14','2024-10-13 02:55:13','2024-10-13 02:55:13',1,NULL,NULL),
(330,3,9,'NEIVA LIZBETH GUZMAN ARBOLEDA','2200329866','Guaranda','0969150120','neguzman@mailes.ueb.edu.ec','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-13 01:48:42','2024-10-13 01:48:42',NULL,1,NULL,NULL),
(331,1,4,'KERLY GENESIS COLCHA GUASHPA','0803472190','Propicia #2','0967081247','kerlygenesis2001@gmail.com','XI CTIE - II CIVS',10.59,'2024-10-13 03:43:40','2024-10-13 03:43:40',NULL,1,NULL,NULL),
(332,3,9,'KERLY GENESIS COLCHA GUASHPA','0803472190','Propicia #2','0967081247','kerlygenesis2001@gmail.com','VI SEMINARIO INVESTIGACIÓN',15.59,'2024-10-13 03:45:36','2024-10-13 03:45:36',NULL,1,NULL,NULL),
(333,2,6,'ANA LUCIA ARMIJO VILLEGAS','0502462054','GUARANDA','0999195354','ALUCIAARMIJO@YAHOO.ES','V CIPEC',20.59,'2024-10-13 03:52:23','2024-10-13 03:52:23',NULL,1,NULL,NULL),
(334,2,6,'ANA LUCIA ARMIJO VILLEGAS','0502462054','GUARANDA','0999195354','ALUCIAARMIJO@YAHOO.ES','V CIPEC',20.59,'2024-10-13 03:52:44','2024-10-13 03:52:44',NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejection_reasons`
--

DROP TABLE IF EXISTS `rejection_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rejection_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `reason` text NOT NULL,
  `rejection_date` datetime NOT NULL,
  `rejection_type` enum('General','Incompleto') NOT NULL DEFAULT 'General',
  `send_email` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rejection_reasons_payment_id_foreign` (`payment_id`),
  KEY `rejection_reasons_user_id_foreign` (`user_id`),
  CONSTRAINT `rejection_reasons_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rejection_reasons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rejection_reasons`
--

LOCK TABLES `rejection_reasons` WRITE;
/*!40000 ALTER TABLE `rejection_reasons` DISABLE KEYS */;
INSERT INTO `rejection_reasons` VALUES
(1,29,1,'EL VALOR DEL PAGO ES INCOMPLETO, DEBE DEPOSITAR 0.59 CENTAVOS PENDIENTES Y SUBIR SU DEPOSITO EN EL SISTEMA.','2024-10-10 22:10:50','Incompleto',1),
(2,10,1,'DEBE CARGAR SU COMPROBANTE DE DEPOSITO.','2024-10-10 23:14:15','General',1),
(3,107,1,'EL VALOR PAGADO ES SUPERIOR AL VALOR DE LA INSCRIPCIÓN, FAVOR COMUNICARSE CON NOSOTROS AL 0989026071 PARA VERIFICAR MANUALMENTE A QUE EVENTO Y CATEGORÍA DESEA INSCRIBIRSE','2024-10-11 19:09:11','Incompleto',1);
/*!40000 ALTER TABLE `rejection_reasons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol_id` int(10) unsigned NOT NULL,
  `ic` varchar(10) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `email` text NOT NULL,
  `password` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,1,'0000000000','Softec','Sistema','0989026071','info@softecsa.com','$2y$10$yrCY9v3tJuhqz9FTrE1IlO9EyWL6J6Y/qI8BCVHD4.3RCafMQbVvW','Guaranda','0000-00-00 00:00:00',NULL,NULL,1,NULL,NULL),
(2,2,'0202545150','Maria','Camacho','0963666452','maria@softecsa.com','$2y$10$Pp.fHb/9vSd2B17cnV05QuEEr56o3m2KlD6eEDSs9jBJH8Km.RIeu','Guaranda','0000-00-00 00:00:00',NULL,NULL,1,NULL,NULL),
(3,2,'0250054855','Daniela','Ocampo','0980109532','aliss@proserviueb.com','$2y$10$pKFXhRtQkP5kNf1/uqZlQuScOu.0yepy2PSsCKaKc/DVIwtM8f4uG','Guaranda','0000-00-00 00:00:00',NULL,NULL,1,NULL,NULL),
(4,3,'0202061321','CHRISTIAN','GUERRERO','0987898113','christomgue@gmail.com','$2y$10$6LvOXWwokAhOIgSohSycqOKkaJ/YyPIt6dxjH6adlFw5xEBRvgFDW','Guaranda','0000-00-00 00:00:00',NULL,NULL,1,NULL,NULL),
(5,3,'1758404071','Jorge A','Briceño C','0963350492','jbriceno@ueb.edu.ec','$2y$10$MEaAOsixOfc5P4W2ufu3vOTBBi.9iJm7w5cO2oQMEAXTI9.dxjtsC','Ambato','0000-00-00 00:00:00',NULL,NULL,1,NULL,NULL),
(6,2,'0202687570','Mishell','Naranjo','0985746584','mishell@proserviueb.com','$2y$10$2ynOTEvqJcRxEpyLsf6Ay.Hyp61ZmP.NqOiMVPnBHYKDdiCVOSjXy','Guaranda','0000-00-00 00:00:00',NULL,NULL,1,NULL,NULL);
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

-- Dump completed on 2024-10-13  4:58:14
