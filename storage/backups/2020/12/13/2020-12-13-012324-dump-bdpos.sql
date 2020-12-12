-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: bdpos
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'beatae','Repellat velit odit non voluptatibus. Eveniet cum ea rerum hic. Quidem iste et aut ex.','2020-11-24 23:08:24','2020-12-06 23:08:25',NULL),(2,'et','Quidem dolorem alias nihil. Et voluptas cumque temporibus dignissimos qui ipsum delectus a.','2021-01-04 23:08:24','2020-12-06 23:08:25',NULL),(3,'vel','Odio adipisci omnis amet distinctio repellat. Error dicta veniam doloribus atque ratione aut.','2020-11-14 23:08:24','2020-12-06 23:08:25',NULL),(4,'dolores','Assumenda minima ut iure laborum. Rem accusamus recusandae temporibus quisquam aut qui.','2020-12-24 23:08:24','2020-12-06 23:08:25',NULL),(5,'voluptates','Ab non doloremque doloremque sit cum. Est saepe nam alias. Dolorum illo nulla dicta.','2020-11-23 23:08:24','2020-12-06 23:08:26',NULL),(6,'aperiam','Deleniti ea non asperiores et. Dicta rerum voluptas dicta possimus illo quo rerum.','2020-12-14 23:08:24','2020-12-06 23:08:26',NULL),(7,'odit','Sit enim optio dolor officia. Corrupti libero quia tenetur voluptas nesciunt labore.','2020-12-30 23:08:24','2020-12-06 23:08:26',NULL),(8,'commodi','Nostrum soluta in officiis. Nam voluptatem quod perferendis beatae minima.','2020-12-05 23:08:24','2020-12-06 23:08:26',NULL),(9,'fuga','Et eos laboriosam cupiditate qui molestiae perspiciatis accusantium. Omnis et blanditiis dolorum.','2020-12-22 23:08:24','2020-12-06 23:08:26',NULL),(10,'quos','Aspernatur tempora sunt maiores et maxime earum aut. Quaerat eius est facilis iusto ut.','2020-11-22 23:08:24','2020-12-06 23:08:27',NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capital_deposits`
--

DROP TABLE IF EXISTS `capital_deposits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capital_deposits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_amount` double NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposited_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capital_deposits`
--

LOCK TABLES `capital_deposits` WRITE;
/*!40000 ALTER TABLE `capital_deposits` DISABLE KEYS */;
/*!40000 ALTER TABLE `capital_deposits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capital_withdraws`
--

DROP TABLE IF EXISTS `capital_withdraws`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capital_withdraws` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_amount` double NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withdrawn_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capital_withdraws`
--

LOCK TABLES `capital_withdraws` WRITE;
/*!40000 ALTER TABLE `capital_withdraws` DISABLE KEYS */;
/*!40000 ALTER TABLE `capital_withdraws` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_subcat_assignments`
--

DROP TABLE IF EXISTS `cat_subcat_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cat_subcat_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `subcategory_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_subcat_assignments`
--

LOCK TABLES `cat_subcat_assignments` WRITE;
/*!40000 ALTER TABLE `cat_subcat_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `cat_subcat_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'non','1444','Quas praesentium ad beatae dolorum. Rerum repellendus minima commodi repudiandae.','2020-12-14 23:08:22','2020-12-06 23:08:23',NULL),(2,'sunt','1871','Placeat qui ad a id repellat est reprehenderit. Repudiandae eum sunt quo ratione.','2020-12-11 23:08:22','2020-12-06 23:08:23',NULL),(3,'qui','1018','Eum velit nisi est vero. Ipsa eius placeat ea et quia ex.','2020-12-04 23:08:22','2020-12-06 23:08:23',NULL),(4,'laudantium','1133','Molestiae provident ex enim ducimus. Quis temporibus unde eligendi aut. Dolor sit at ut.','2020-12-13 23:08:22','2020-12-06 23:08:23',NULL),(5,'aut','1224','Qui quis et quaerat ut. Libero quas at quidem at fugiat amet. Et iste deleniti omnis.','2020-12-17 23:08:22','2020-12-06 23:08:23',NULL),(6,'sunt','1568','Dignissimos et eligendi velit quia facilis quia. Quibusdam doloribus adipisci nulla doloremque.','2020-12-26 23:08:22','2020-12-06 23:08:24',NULL),(7,'animi','1908','Incidunt quos est qui. Vel doloribus et et exercitationem. Tenetur magnam quia enim ea ipsa qui.','2020-12-22 23:08:22','2020-12-06 23:08:24',NULL),(8,'esse','1407','Non sunt vero natus. Nobis id neque et qui architecto velit ipsa quibusdam.','2021-01-04 23:08:22','2020-12-06 23:08:24',NULL),(9,'et','1436','In expedita consequatur veritatis quidem. Officiis autem natus debitis sunt omnis ratione dolorem.','2020-12-25 23:08:22','2020-12-06 23:08:24',NULL),(10,'sapiente','1451','Tenetur iure molestiae et recusandae. Alias iusto quod veniam unde.','2020-12-04 23:08:22','2020-12-06 23:08:24',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thana` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_office` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Katarina Graham','yframi@wehner.info','+19358393042','Ryan LLC','quos','excepturi','94975-2730','aut','634 Adelia View\nNorth Jena, MD 06870-8728',NULL,'2020-12-18 23:08:35','2020-12-06 23:08:35',NULL),(2,'Esther Fay','jaeden.murray@emard.com','(207) 693-5708','Gerhold-McGlynn','beatae','qui','91481','vero','38359 Parisian Grove Apt. 107\nDawsonmouth, PA 79049-2014',NULL,'2020-11-16 23:08:35','2020-12-07 00:21:13','2020-12-07 00:21:13'),(3,'Rasheed Kunde I','josianne.lueilwitz@hotmail.com','(541) 405-6492','Marks, Olson and Hettinger','ut','in','58095','possimus','13163 Kris Forest Suite 193\nWest Marvinland, MT 62850-9863',NULL,'2020-12-26 23:08:35','2020-12-06 23:08:36',NULL),(4,'Kristopher Casper','tfarrell@nicolas.com','+12734854823','Maggio Inc','voluptas','voluptatem','04857','rem','26262 Kutch Inlet Apt. 176\nWest Hilbertmouth, GA 43742-5690',NULL,'2020-11-19 23:08:35','2020-12-06 23:08:36',NULL),(5,'Aylin O\'Hara','stephen49@hotmail.com','505-608-2380 x99920','Stoltenberg PLC','ut','culpa','12401-2942','non','973 Hackett Keys Apt. 889\nNorth Kittybury, IN 31554-6770',NULL,'2020-11-10 23:08:35','2020-12-06 23:08:36',NULL),(6,'Mrs. Shaina Rodriguez II','cameron35@gmail.com','(329) 239-1637','Senger-Turcotte','sed','incidunt','93179-5717','in','28608 Satterfield Track Suite 682\nCharlieberg, ID 34807',NULL,'2020-12-08 23:08:35','2020-12-06 23:08:37',NULL),(7,'Clyde Donnelly','tia46@corwin.com','530-918-8044 x3086','Swaniawski Group','repudiandae','inventore','59659-3318','esse','62545 Jordan Stream Suite 785\nClemmiehaven, MT 53132',NULL,'2020-11-10 23:08:35','2020-12-06 23:08:37',NULL),(8,'Raegan Welch','reyna.collier@gmail.com','(421) 964-3561 x012','Harber Ltd','debitis','qui','01926','et','1583 Blick Prairie\nPredovicmouth, HI 74236',NULL,'2020-11-29 23:08:35','2020-12-06 23:08:37',NULL),(9,'Elyse Beatty','kian78@yahoo.com','257.565.5382 x41429','Bode-Gerlach','qui','maiores','93674-5506','reiciendis','2821 Mertz Views Apt. 600\nBuckridgeborough, CT 78071-2694',NULL,'2020-11-19 23:08:35','2020-12-06 23:08:37',NULL),(10,'Rhett Breitenberg','nmoore@rutherford.info','+1.961.519.6993','McDermott, Quitzon and Ullrich','quibusdam','nisi','77620','distinctio','73276 Kellie Heights Suite 607\nSigurdmouth, OH 41467',NULL,'2020-12-11 23:08:35','2020-12-06 23:08:37',NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_salaries`
--

DROP TABLE IF EXISTS `employee_salaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_salaries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `year` bigint unsigned NOT NULL,
  `month` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_amount` double NOT NULL DEFAULT '0',
  `bank` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_salaries`
--

LOCK TABLES `employee_salaries` WRITE;
/*!40000 ALTER TABLE `employee_salaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_salaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thana` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_office` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `joining_date` date NOT NULL,
  `leaving_date` date DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Miss Corrine Bins V','drippin@hartmann.com','705-310-2672 x811','Padberg PLC','quidem','qui','36639','inventore',1,'1995-10-13',NULL,'Computer Repairer',NULL,46859.23,'2020-12-29 23:08:38','2020-12-06 23:08:38',NULL),(2,'Mrs. Magdalena Wiza','jgutkowski@harber.com','262.254.4846','Fay and Sons','aut','saepe','96947','dignissimos',1,'1996-12-19',NULL,'Respiratory Therapy Technician',NULL,45452.75,'2021-01-04 23:08:38','2020-12-06 23:08:38',NULL),(3,'Kevon Padberg DDS','noemi36@fisher.info','998-783-7268 x4436','Heller-Hintz','quaerat','corrupti','86395','alias',1,'1971-10-06',NULL,'Food Cooking Machine Operators',NULL,36873.5,'2020-12-19 23:08:38','2020-12-06 23:08:38',NULL),(4,'Dr. Rachelle Kautzer II','elise72@zieme.com','224-925-7814','Feil-Schultz','asperiores','neque','51076','eveniet',1,'1992-10-21',NULL,'Radiologic Technologist and Technician',NULL,13203.18,'2020-12-18 23:08:38','2020-12-06 23:08:39',NULL),(5,'Ms. Laury Jenkins','marquise.hill@brakus.com','578.609.7296','Parisian Group','quo','dolore','91509-9825','fugiat',1,'2010-01-18',NULL,'Curator',NULL,30722.49,'2021-01-02 23:08:38','2020-12-06 23:08:39',NULL),(6,'Stanton Wiza','rosina11@auer.com','(542) 438-3337 x68346','Kub-Klein','autem','laudantium','51577-4005','dolore',1,'2019-09-16',NULL,'Farmworker',NULL,16376.34,'2020-11-27 23:08:38','2020-12-06 23:08:39',NULL),(7,'Emelie Wiza','oconnell.karine@bartell.net','740-814-3194 x66272','Schmeler, Bruen and Gottlieb','est','dignissimos','18561-8104','cupiditate',1,'1975-10-04',NULL,'Ophthalmic Laboratory Technician',NULL,12337.36,'2020-12-28 23:08:38','2020-12-06 23:08:39',NULL),(8,'Prof. Jaycee Johns Jr.','xward@balistreri.com','+1.235.321.7762','Haag Group','eos','animi','44443','odit',1,'2019-01-27',NULL,'Occupational Health Safety Specialist',NULL,17112.94,'2020-12-04 23:08:38','2020-12-06 23:08:40',NULL),(9,'Dorothy Jast','brandyn69@dach.com','995-344-9920 x532','Luettgen, Rogahn and Cruickshank','doloribus','repudiandae','37446-3780','autem',1,'1999-04-03',NULL,'Grounds Maintenance Worker',NULL,11549.48,'2020-12-19 23:08:38','2020-12-06 23:08:40',NULL),(10,'Mr. Tobin Leuschke II','kenyatta65@rippin.com','1-624-454-3869 x2098','Hodkiewicz Ltd','qui','dolor','87204-2393','nobis',1,'1998-10-11',NULL,'Photographic Process Worker',NULL,32560.27,'2020-12-09 23:08:38','2020-12-06 23:08:40',NULL);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_categories`
--

DROP TABLE IF EXISTS `expense_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_categories`
--

LOCK TABLES `expense_categories` WRITE;
/*!40000 ALTER TABLE `expense_categories` DISABLE KEYS */;
INSERT INTO `expense_categories` VALUES (1,'quo','Ea nam sint maiores mollitia fugiat. Quos quibusdam ut nisi impedit laudantium.','2020-12-06 23:08:41','2020-12-06 23:08:41',NULL),(2,'quae','Fugit aut quis quod voluptate impedit. Nisi commodi incidunt quia eius nesciunt commodi.','2020-12-06 23:08:41','2020-12-06 23:08:41',NULL),(3,'quos','Sed ipsa in ipsam. Qui saepe id aut aspernatur dicta. Animi a quas a enim molestias adipisci iure.','2020-12-06 23:08:42','2020-12-06 23:08:42',NULL),(4,'accusantium','Quod maiores qui sunt rerum quisquam enim. Rerum iste praesentium occaecati adipisci ea.','2020-12-06 23:08:42','2020-12-06 23:08:42',NULL),(5,'rerum','Omnis vero voluptatem et quia. Non consequuntur provident sit nihil.','2020-12-06 23:08:42','2020-12-06 23:08:42',NULL),(6,'molestiae','Rerum non animi officia adipisci possimus sed. Vero aspernatur maxime quo sint.','2020-12-06 23:08:43','2020-12-06 23:08:43',NULL),(7,'ut','Sed fuga aut sunt quam nihil et. Reprehenderit qui est ducimus. Pariatur iste voluptatem magni.','2020-12-06 23:08:43','2020-12-06 23:08:43',NULL),(8,'quo','Repudiandae voluptas aut ex et vel. Dicta eveniet et qui quae aliquam aut.','2020-12-06 23:08:43','2020-12-06 23:08:43',NULL),(9,'nulla','Quia dolore laborum officiis et eveniet est. Totam rerum modi provident vero qui commodi quidem.','2020-12-06 23:08:44','2020-12-06 23:08:44',NULL),(10,'quos','Ut at dolor at ex tenetur dolor. Sed nesciunt iure aspernatur aut.','2020-12-06 23:08:44','2020-12-06 23:08:44',NULL);
/*!40000 ALTER TABLE `expense_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `expense_category_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `taken_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histories`
--

DROP TABLE IF EXISTS `histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histories`
--

LOCK TABLES `histories` WRITE;
/*!40000 ALTER TABLE `histories` DISABLE KEYS */;
INSERT INTO `histories` VALUES (1,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"site_name\",\"value\":\"WovoPOS\"}','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(2,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"phone\",\"value\":\"123456789\"}','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(3,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"email\",\"value\":\"example@email.com\"}','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(4,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"address\",\"value\":\"Example, Address-5400, Bangladesh\"}','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(5,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"currency\",\"value\":\"BDT\"}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(6,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"locale\",\"value\":\"en-US\"}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(7,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"default_discount\",\"value\":0}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(8,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"default_tax\",\"value\":0}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(9,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"default_customer\",\"value\":1}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(10,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"send_sms_after_sale\",\"value\":false}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(11,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"send_sms_after_order\",\"value\":false}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(12,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"logo\",\"value\":null}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(13,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"timezone\",\"value\":\"Asia\\/Dhaka\"}','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(14,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"language\",\"value\":1}','2020-12-06 23:08:19','2020-12-06 23:08:19',NULL),(15,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"invoice_header\",\"value\":\"\"}','2020-12-06 23:08:19','2020-12-06 23:08:19',NULL),(16,NULL,'created','App\\Models\\Setting','[]','{\"key\":\"invoice_footer\",\"value\":\"\"}','2020-12-06 23:08:19','2020-12-06 23:08:19',NULL),(17,NULL,'created','App\\Models\\Unit','[]','{\"name\":\"kg\",\"description\":\"kilogram\"}','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(18,NULL,'created','App\\Models\\Unit','[]','{\"name\":\"cm\",\"description\":\"centimeter\"}','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(19,NULL,'created','App\\Models\\Unit','[]','{\"name\":\"gm\",\"description\":\"gram\"}','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(20,NULL,'created','App\\Models\\Unit','[]','{\"name\":\"qty\",\"description\":\"Quantity\"}','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(21,NULL,'created','App\\Models\\Category','[]','{\"name\":\"non\",\"code\":1444,\"description\":\"Quas praesentium ad beatae dolorum. Rerum repellendus minima commodi repudiandae.\",\"created_at\":\"2020-12-14T23:08:22.000000Z\"}','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(22,NULL,'created','App\\Models\\Category','[]','{\"name\":\"sunt\",\"code\":1871,\"description\":\"Placeat qui ad a id repellat est reprehenderit. Repudiandae eum sunt quo ratione.\",\"created_at\":\"2020-12-11T23:08:22.000000Z\"}','2020-12-06 23:08:23','2020-12-06 23:08:23',NULL),(23,NULL,'created','App\\Models\\Category','[]','{\"name\":\"qui\",\"code\":1018,\"description\":\"Eum velit nisi est vero. Ipsa eius placeat ea et quia ex.\",\"created_at\":\"2020-12-04T23:08:22.000000Z\"}','2020-12-06 23:08:23','2020-12-06 23:08:23',NULL),(24,NULL,'created','App\\Models\\Category','[]','{\"name\":\"laudantium\",\"code\":1133,\"description\":\"Molestiae provident ex enim ducimus. Quis temporibus unde eligendi aut. Dolor sit at ut.\",\"created_at\":\"2020-12-13T23:08:22.000000Z\"}','2020-12-06 23:08:23','2020-12-06 23:08:23',NULL),(25,NULL,'created','App\\Models\\Category','[]','{\"name\":\"aut\",\"code\":1224,\"description\":\"Qui quis et quaerat ut. Libero quas at quidem at fugiat amet. Et iste deleniti omnis.\",\"created_at\":\"2020-12-17T23:08:22.000000Z\"}','2020-12-06 23:08:23','2020-12-06 23:08:23',NULL),(26,NULL,'created','App\\Models\\Category','[]','{\"name\":\"sunt\",\"code\":1568,\"description\":\"Dignissimos et eligendi velit quia facilis quia. Quibusdam doloribus adipisci nulla doloremque.\",\"created_at\":\"2020-12-26T23:08:22.000000Z\"}','2020-12-06 23:08:24','2020-12-06 23:08:24',NULL),(27,NULL,'created','App\\Models\\Category','[]','{\"name\":\"animi\",\"code\":1908,\"description\":\"Incidunt quos est qui. Vel doloribus et et exercitationem. Tenetur magnam quia enim ea ipsa qui.\",\"created_at\":\"2020-12-22T23:08:22.000000Z\"}','2020-12-06 23:08:24','2020-12-06 23:08:24',NULL),(28,NULL,'created','App\\Models\\Category','[]','{\"name\":\"esse\",\"code\":1407,\"description\":\"Non sunt vero natus. Nobis id neque et qui architecto velit ipsa quibusdam.\",\"created_at\":\"2021-01-04T23:08:22.000000Z\"}','2020-12-06 23:08:24','2020-12-06 23:08:24',NULL),(29,NULL,'created','App\\Models\\Category','[]','{\"name\":\"et\",\"code\":1436,\"description\":\"In expedita consequatur veritatis quidem. Officiis autem natus debitis sunt omnis ratione dolorem.\",\"created_at\":\"2020-12-25T23:08:22.000000Z\"}','2020-12-06 23:08:24','2020-12-06 23:08:24',NULL),(30,NULL,'created','App\\Models\\Category','[]','{\"name\":\"sapiente\",\"code\":1451,\"description\":\"Tenetur iure molestiae et recusandae. Alias iusto quod veniam unde.\",\"created_at\":\"2020-12-04T23:08:22.000000Z\"}','2020-12-06 23:08:24','2020-12-06 23:08:24',NULL),(31,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"beatae\",\"description\":\"Repellat velit odit non voluptatibus. Eveniet cum ea rerum hic. Quidem iste et aut ex.\",\"created_at\":\"2020-11-24T23:08:24.000000Z\"}','2020-12-06 23:08:24','2020-12-06 23:08:24',NULL),(32,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"et\",\"description\":\"Quidem dolorem alias nihil. Et voluptas cumque temporibus dignissimos qui ipsum delectus a.\",\"created_at\":\"2021-01-04T23:08:24.000000Z\"}','2020-12-06 23:08:25','2020-12-06 23:08:25',NULL),(33,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"vel\",\"description\":\"Odio adipisci omnis amet distinctio repellat. Error dicta veniam doloribus atque ratione aut.\",\"created_at\":\"2020-11-14T23:08:24.000000Z\"}','2020-12-06 23:08:25','2020-12-06 23:08:25',NULL),(34,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"dolores\",\"description\":\"Assumenda minima ut iure laborum. Rem accusamus recusandae temporibus quisquam aut qui.\",\"created_at\":\"2020-12-24T23:08:24.000000Z\"}','2020-12-06 23:08:25','2020-12-06 23:08:25',NULL),(35,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"voluptates\",\"description\":\"Ab non doloremque doloremque sit cum. Est saepe nam alias. Dolorum illo nulla dicta.\",\"created_at\":\"2020-11-23T23:08:24.000000Z\"}','2020-12-06 23:08:25','2020-12-06 23:08:25',NULL),(36,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"aperiam\",\"description\":\"Deleniti ea non asperiores et. Dicta rerum voluptas dicta possimus illo quo rerum.\",\"created_at\":\"2020-12-14T23:08:24.000000Z\"}','2020-12-06 23:08:26','2020-12-06 23:08:26',NULL),(37,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"odit\",\"description\":\"Sit enim optio dolor officia. Corrupti libero quia tenetur voluptas nesciunt labore.\",\"created_at\":\"2020-12-30T23:08:24.000000Z\"}','2020-12-06 23:08:26','2020-12-06 23:08:26',NULL),(38,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"commodi\",\"description\":\"Nostrum soluta in officiis. Nam voluptatem quod perferendis beatae minima.\",\"created_at\":\"2020-12-05T23:08:24.000000Z\"}','2020-12-06 23:08:26','2020-12-06 23:08:26',NULL),(39,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"fuga\",\"description\":\"Et eos laboriosam cupiditate qui molestiae perspiciatis accusantium. Omnis et blanditiis dolorum.\",\"created_at\":\"2020-12-22T23:08:24.000000Z\"}','2020-12-06 23:08:26','2020-12-06 23:08:26',NULL),(40,NULL,'created','App\\Models\\Brand','[]','{\"name\":\"quos\",\"description\":\"Aspernatur tempora sunt maiores et maxime earum aut. Quaerat eius est facilis iusto ut.\",\"created_at\":\"2020-11-22T23:08:24.000000Z\"}','2020-12-06 23:08:27','2020-12-06 23:08:27',NULL),(41,NULL,'created','App\\Models\\Product','[]','{\"name\":\"repudiandae\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b34554\",\"cost\":174.27,\"price\":435.54,\"category_id\":3,\"subcategory_id\":5,\"brand_id\":4,\"status\":false,\"unit_id\":2,\"alert_quantity\":18,\"description\":\"Maxime ex similique sequi non sapiente optio. Consequuntur laboriosam est ut.\",\"created_at\":\"2020-11-18T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:27','2020-12-06 23:08:27',NULL),(42,NULL,'created','App\\Models\\Product','[]','{\"name\":\"iusto\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b3591a\",\"cost\":463.86,\"price\":316.09,\"category_id\":4,\"subcategory_id\":4,\"brand_id\":1,\"status\":true,\"unit_id\":2,\"alert_quantity\":31,\"description\":\"Distinctio voluptatem aspernatur qui vitae dolorem. Sit error rerum autem sit et.\",\"created_at\":\"2020-11-21T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:27','2020-12-06 23:08:27',NULL),(43,NULL,'created','App\\Models\\Product','[]','{\"name\":\"magnam\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b3634c\",\"cost\":31.01,\"price\":496.93,\"category_id\":3,\"subcategory_id\":1,\"brand_id\":1,\"status\":false,\"unit_id\":4,\"alert_quantity\":33,\"description\":\"Quis enim et vitae asperiores. Quidem ratione quia qui. Officia quam natus cupiditate est atque.\",\"created_at\":\"2020-11-24T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:27','2020-12-06 23:08:27',NULL),(44,NULL,'created','App\\Models\\Product','[]','{\"name\":\"quos\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b367b6\",\"cost\":167.39,\"price\":40.17,\"category_id\":4,\"subcategory_id\":3,\"brand_id\":1,\"status\":false,\"unit_id\":2,\"alert_quantity\":41,\"description\":\"Nulla quasi non saepe earum quis et. Dolor tempore ut ipsa blanditiis.\",\"created_at\":\"2021-01-02T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:28','2020-12-06 23:08:28',NULL),(45,NULL,'created','App\\Models\\Product','[]','{\"name\":\"aut\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b370b2\",\"cost\":482.75,\"price\":232.84,\"category_id\":5,\"subcategory_id\":2,\"brand_id\":2,\"status\":true,\"unit_id\":4,\"alert_quantity\":10,\"description\":\"Voluptates placeat commodi deserunt. Non beatae est ut aut culpa. Totam autem doloremque omnis.\",\"created_at\":\"2020-11-14T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:28','2020-12-06 23:08:28',NULL),(46,NULL,'created','App\\Models\\Product','[]','{\"name\":\"maiores\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b3747c\",\"cost\":110.62,\"price\":70.4,\"category_id\":3,\"subcategory_id\":3,\"brand_id\":3,\"status\":true,\"unit_id\":2,\"alert_quantity\":12,\"description\":\"Ex placeat tempore distinctio non minima impedit quia. Distinctio enim pariatur reiciendis amet.\",\"created_at\":\"2020-12-06T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:28','2020-12-06 23:08:28',NULL),(47,NULL,'created','App\\Models\\Product','[]','{\"name\":\"mollitia\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b377c5\",\"cost\":73.04,\"price\":234.79,\"category_id\":3,\"subcategory_id\":2,\"brand_id\":3,\"status\":true,\"unit_id\":4,\"alert_quantity\":42,\"description\":\"Nobis velit incidunt et et voluptatum consectetur. Fuga rerum aut ut praesentium.\",\"created_at\":\"2020-12-23T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:28','2020-12-06 23:08:28',NULL),(48,NULL,'created','App\\Models\\Product','[]','{\"name\":\"praesentium\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b379a9\",\"cost\":483.14,\"price\":80.43,\"category_id\":4,\"subcategory_id\":5,\"brand_id\":5,\"status\":false,\"unit_id\":2,\"alert_quantity\":3,\"description\":\"Quasi aut est est. Qui et inventore fuga qui dolorem placeat. Placeat quis in rerum nostrum.\",\"created_at\":\"2020-11-21T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:28','2020-12-06 23:08:28',NULL),(49,NULL,'created','App\\Models\\Product','[]','{\"name\":\"quos\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b37b63\",\"cost\":198.36,\"price\":417.48,\"category_id\":2,\"subcategory_id\":1,\"brand_id\":4,\"status\":true,\"unit_id\":1,\"alert_quantity\":3,\"description\":\"Occaecati veritatis quasi et est qui est ex minus. Aut unde ipsam dolores nihil et.\",\"created_at\":\"2020-11-13T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:29','2020-12-06 23:08:29',NULL),(50,NULL,'created','App\\Models\\Product','[]','{\"name\":\"perferendis\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b37d90\",\"cost\":104.86,\"price\":118.22,\"category_id\":4,\"subcategory_id\":5,\"brand_id\":3,\"status\":false,\"unit_id\":2,\"alert_quantity\":15,\"description\":\"Id laboriosam qui sequi aut explicabo iusto. Tempora voluptates ut sunt.\",\"created_at\":\"2020-12-18T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:29','2020-12-06 23:08:29',NULL),(51,NULL,'created','App\\Models\\Product','[]','{\"name\":\"error\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b380e3\",\"cost\":448.11,\"price\":448.75,\"category_id\":5,\"subcategory_id\":2,\"brand_id\":4,\"status\":false,\"unit_id\":2,\"alert_quantity\":6,\"description\":\"Ea magnam itaque at. Modi enim quos optio quasi.\",\"created_at\":\"2020-11-12T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:29','2020-12-06 23:08:29',NULL),(52,NULL,'created','App\\Models\\Product','[]','{\"name\":\"et\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b38436\",\"cost\":119.96,\"price\":340.18,\"category_id\":2,\"subcategory_id\":1,\"brand_id\":3,\"status\":true,\"unit_id\":4,\"alert_quantity\":9,\"description\":\"Aliquid libero laboriosam quis unde tenetur qui alias. Ut facilis ut et sed architecto a.\",\"created_at\":\"2020-11-27T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:29','2020-12-06 23:08:29',NULL),(53,NULL,'created','App\\Models\\Product','[]','{\"name\":\"necessitatibus\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b38725\",\"cost\":401.24,\"price\":106.01,\"category_id\":2,\"subcategory_id\":4,\"brand_id\":1,\"status\":true,\"unit_id\":4,\"alert_quantity\":3,\"description\":\"Ut reiciendis pariatur eos modi quam rerum. Et veniam consequatur laboriosam aut.\",\"created_at\":\"2021-01-03T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:30','2020-12-06 23:08:30',NULL),(54,NULL,'created','App\\Models\\Product','[]','{\"name\":\"reprehenderit\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b3889f\",\"cost\":235.44,\"price\":318.13,\"category_id\":5,\"subcategory_id\":1,\"brand_id\":3,\"status\":true,\"unit_id\":4,\"alert_quantity\":1,\"description\":\"Alias incidunt ut dolorem consequatur. Tenetur in ut nobis amet placeat.\",\"created_at\":\"2020-12-15T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:30','2020-12-06 23:08:30',NULL),(55,NULL,'created','App\\Models\\Product','[]','{\"name\":\"quam\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b38a30\",\"cost\":103.14,\"price\":492.33,\"category_id\":2,\"subcategory_id\":5,\"brand_id\":4,\"status\":false,\"unit_id\":2,\"alert_quantity\":6,\"description\":\"Et quod natus aut veritatis. Molestias recusandae et asperiores est.\",\"created_at\":\"2020-12-08T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:30','2020-12-06 23:08:30',NULL),(56,NULL,'created','App\\Models\\Product','[]','{\"name\":\"vitae\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b38c18\",\"cost\":313.85,\"price\":397.02,\"category_id\":3,\"subcategory_id\":3,\"brand_id\":5,\"status\":false,\"unit_id\":1,\"alert_quantity\":18,\"description\":\"Optio enim sequi ipsam iure unde. Rerum repudiandae praesentium commodi qui.\",\"created_at\":\"2020-12-14T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:30','2020-12-06 23:08:30',NULL),(57,NULL,'created','App\\Models\\Product','[]','{\"name\":\"quia\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b38e4f\",\"cost\":394.5,\"price\":398.72,\"category_id\":1,\"subcategory_id\":4,\"brand_id\":3,\"status\":false,\"unit_id\":1,\"alert_quantity\":27,\"description\":\"Totam porro corrupti sed omnis eum non odio. Porro aut ipsum et perferendis eius voluptas.\",\"created_at\":\"2020-12-17T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:31','2020-12-06 23:08:31',NULL),(58,NULL,'created','App\\Models\\Product','[]','{\"name\":\"et\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b38fb5\",\"cost\":224.42,\"price\":347.74,\"category_id\":5,\"subcategory_id\":1,\"brand_id\":1,\"status\":false,\"unit_id\":1,\"alert_quantity\":26,\"description\":\"Aut ut culpa ut iusto. Eum adipisci voluptas sit architecto voluptates assumenda.\",\"created_at\":\"2020-12-10T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:31','2020-12-06 23:08:31',NULL),(59,NULL,'created','App\\Models\\Product','[]','{\"name\":\"et\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b3913a\",\"cost\":434.47,\"price\":240.3,\"category_id\":5,\"subcategory_id\":3,\"brand_id\":2,\"status\":false,\"unit_id\":2,\"alert_quantity\":7,\"description\":\"Dolorem delectus veritatis aut maxime sunt. Quam delectus quo quibusdam perspiciatis.\",\"created_at\":\"2020-12-13T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:31','2020-12-06 23:08:31',NULL),(60,NULL,'created','App\\Models\\Product','[]','{\"name\":\"consequatur\",\"barcode_symbology\":\"code128\",\"code\":\"5fcd646b39362\",\"cost\":258.86,\"price\":135.83,\"category_id\":3,\"subcategory_id\":4,\"brand_id\":4,\"status\":true,\"unit_id\":3,\"alert_quantity\":43,\"description\":\"Maiores cumque deserunt quod voluptates error. Eos voluptate ad aut enim et labore quo.\",\"created_at\":\"2020-12-26T23:08:27.000000Z\",\"photo_url\":\"\"}','2020-12-06 23:08:31','2020-12-06 23:08:31',NULL),(61,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Dr. Vanessa Homenick DVM\",\"email\":\"lilian03@gmail.com\",\"phone\":\"+16214557748\",\"company\":\"Paucek and Sons\",\"district\":\"ex\",\"thana\":\"ea\",\"post_office\":\"51490\",\"village\":\"rerum\",\"shipping_address\":\"9238 Tomas Plaza\\nStiedemannhaven, MO 06904-2711\",\"created_at\":\"2020-11-09T23:08:31.000000Z\"}','2020-12-06 23:08:31','2020-12-06 23:08:31',NULL),(62,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Estel Feil\",\"email\":\"johnson.halvorson@hotmail.com\",\"phone\":\"(261) 661-9436 x412\",\"company\":\"Lehner-Ebert\",\"district\":\"ea\",\"thana\":\"voluptas\",\"post_office\":\"21368\",\"village\":\"modi\",\"shipping_address\":\"195 Hills Flat\\nPort Ludwigbury, PA 14608-3026\",\"created_at\":\"2020-12-14T23:08:31.000000Z\"}','2020-12-06 23:08:32','2020-12-06 23:08:32',NULL),(63,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Dr. Clotilde Buckridge\",\"email\":\"allie04@yahoo.com\",\"phone\":\"+1-331-535-7220\",\"company\":\"Nitzsche-Hills\",\"district\":\"illo\",\"thana\":\"officia\",\"post_office\":\"76870-9412\",\"village\":\"qui\",\"shipping_address\":\"3549 O\'Connell Orchard\\nLake Rosaleeberg, NM 65455\",\"created_at\":\"2020-11-30T23:08:31.000000Z\"}','2020-12-06 23:08:32','2020-12-06 23:08:32',NULL),(64,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Prof. Trinity Pfeffer\",\"email\":\"vbahringer@gmail.com\",\"phone\":\"362-549-4334\",\"company\":\"Daugherty-Donnelly\",\"district\":\"error\",\"thana\":\"amet\",\"post_office\":\"46180-6775\",\"village\":\"cumque\",\"shipping_address\":\"710 Holly Flats Suite 695\\nLangbury, MN 17185\",\"created_at\":\"2020-12-09T23:08:31.000000Z\"}','2020-12-06 23:08:32','2020-12-06 23:08:32',NULL),(65,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Prof. Carroll Crist MD\",\"email\":\"samson30@hotmail.com\",\"phone\":\"+19516594720\",\"company\":\"Lueilwitz-Collins\",\"district\":\"harum\",\"thana\":\"quia\",\"post_office\":\"97108\",\"village\":\"est\",\"shipping_address\":\"8105 Volkman Pine Suite 424\\nCarolineborough, CA 15771\",\"created_at\":\"2020-12-14T23:08:31.000000Z\"}','2020-12-06 23:08:32','2020-12-06 23:08:32',NULL),(66,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Renee Padberg\",\"email\":\"miracle76@hotmail.com\",\"phone\":\"1-878-268-3408\",\"company\":\"Mayert, Daugherty and Herzog\",\"district\":\"facilis\",\"thana\":\"velit\",\"post_office\":\"00076\",\"village\":\"ut\",\"shipping_address\":\"4828 Leopold Camp\\nSchoenshire, NM 66892\",\"created_at\":\"2020-12-30T23:08:31.000000Z\"}','2020-12-06 23:08:33','2020-12-06 23:08:33',NULL),(67,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Adrian Wunsch\",\"email\":\"julia.jast@stamm.net\",\"phone\":\"1-856-465-2915 x930\",\"company\":\"Graham, Bauch and Frami\",\"district\":\"enim\",\"thana\":\"nulla\",\"post_office\":\"50531\",\"village\":\"enim\",\"shipping_address\":\"626 Petra Trace Apt. 984\\nLuettgenberg, NJ 13564-3661\",\"created_at\":\"2020-12-23T23:08:31.000000Z\"}','2020-12-06 23:08:33','2020-12-06 23:08:33',NULL),(68,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Dwight Jerde\",\"email\":\"florine.mante@hotmail.com\",\"phone\":\"418-776-2724\",\"company\":\"Goodwin Ltd\",\"district\":\"rem\",\"thana\":\"accusamus\",\"post_office\":\"91541-6024\",\"village\":\"suscipit\",\"shipping_address\":\"579 Dedric Junction Apt. 592\\nSchaeferside, SC 08140\",\"created_at\":\"2020-12-02T23:08:31.000000Z\"}','2020-12-06 23:08:33','2020-12-06 23:08:33',NULL),(69,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Giles Cartwright\",\"email\":\"stehr.margie@treutel.com\",\"phone\":\"+1 (663) 900-8795\",\"company\":\"Rohan and Sons\",\"district\":\"odit\",\"thana\":\"maxime\",\"post_office\":\"99322-5382\",\"village\":\"quo\",\"shipping_address\":\"28726 Kuhn Stream Apt. 595\\nWest Deliatown, WI 98007\",\"created_at\":\"2020-11-25T23:08:31.000000Z\"}','2020-12-06 23:08:33','2020-12-06 23:08:33',NULL),(70,NULL,'created','App\\Models\\Supplier','[]','{\"name\":\"Amanda Watsica\",\"email\":\"sammy97@mclaughlin.net\",\"phone\":\"(257) 236-0913 x428\",\"company\":\"Jacobs Ltd\",\"district\":\"error\",\"thana\":\"rerum\",\"post_office\":\"55043\",\"village\":\"reiciendis\",\"shipping_address\":\"7070 Koch Cape Suite 191\\nAlvahburgh, TN 33038\",\"created_at\":\"2020-12-30T23:08:31.000000Z\"}','2020-12-06 23:08:34','2020-12-06 23:08:34',NULL),(71,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Katarina Graham\",\"email\":\"yframi@wehner.info\",\"phone\":\"+19358393042\",\"company\":\"Ryan LLC\",\"district\":\"quos\",\"thana\":\"excepturi\",\"post_office\":\"94975-2730\",\"village\":\"aut\",\"shipping_address\":\"634 Adelia View\\nNorth Jena, MD 06870-8728\",\"created_at\":\"2020-12-18T23:08:35.000000Z\"}','2020-12-06 23:08:35','2020-12-06 23:08:35',NULL),(72,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Esther Fay\",\"email\":\"jaeden.murray@emard.com\",\"phone\":\"(207) 693-5708\",\"company\":\"Gerhold-McGlynn\",\"district\":\"beatae\",\"thana\":\"qui\",\"post_office\":\"91481\",\"village\":\"vero\",\"shipping_address\":\"38359 Parisian Grove Apt. 107\\nDawsonmouth, PA 79049-2014\",\"created_at\":\"2020-11-16T23:08:35.000000Z\"}','2020-12-06 23:08:35','2020-12-06 23:08:35',NULL),(73,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Rasheed Kunde I\",\"email\":\"josianne.lueilwitz@hotmail.com\",\"phone\":\"(541) 405-6492\",\"company\":\"Marks, Olson and Hettinger\",\"district\":\"ut\",\"thana\":\"in\",\"post_office\":\"58095\",\"village\":\"possimus\",\"shipping_address\":\"13163 Kris Forest Suite 193\\nWest Marvinland, MT 62850-9863\",\"created_at\":\"2020-12-26T23:08:35.000000Z\"}','2020-12-06 23:08:36','2020-12-06 23:08:36',NULL),(74,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Kristopher Casper\",\"email\":\"tfarrell@nicolas.com\",\"phone\":\"+12734854823\",\"company\":\"Maggio Inc\",\"district\":\"voluptas\",\"thana\":\"voluptatem\",\"post_office\":\"04857\",\"village\":\"rem\",\"shipping_address\":\"26262 Kutch Inlet Apt. 176\\nWest Hilbertmouth, GA 43742-5690\",\"created_at\":\"2020-11-19T23:08:35.000000Z\"}','2020-12-06 23:08:36','2020-12-06 23:08:36',NULL),(75,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Aylin O\'Hara\",\"email\":\"stephen49@hotmail.com\",\"phone\":\"505-608-2380 x99920\",\"company\":\"Stoltenberg PLC\",\"district\":\"ut\",\"thana\":\"culpa\",\"post_office\":\"12401-2942\",\"village\":\"non\",\"shipping_address\":\"973 Hackett Keys Apt. 889\\nNorth Kittybury, IN 31554-6770\",\"created_at\":\"2020-11-10T23:08:35.000000Z\"}','2020-12-06 23:08:36','2020-12-06 23:08:36',NULL),(76,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Mrs. Shaina Rodriguez II\",\"email\":\"cameron35@gmail.com\",\"phone\":\"(329) 239-1637\",\"company\":\"Senger-Turcotte\",\"district\":\"sed\",\"thana\":\"incidunt\",\"post_office\":\"93179-5717\",\"village\":\"in\",\"shipping_address\":\"28608 Satterfield Track Suite 682\\nCharlieberg, ID 34807\",\"created_at\":\"2020-12-08T23:08:35.000000Z\"}','2020-12-06 23:08:36','2020-12-06 23:08:36',NULL),(77,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Clyde Donnelly\",\"email\":\"tia46@corwin.com\",\"phone\":\"530-918-8044 x3086\",\"company\":\"Swaniawski Group\",\"district\":\"repudiandae\",\"thana\":\"inventore\",\"post_office\":\"59659-3318\",\"village\":\"esse\",\"shipping_address\":\"62545 Jordan Stream Suite 785\\nClemmiehaven, MT 53132\",\"created_at\":\"2020-11-10T23:08:35.000000Z\"}','2020-12-06 23:08:37','2020-12-06 23:08:37',NULL),(78,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Raegan Welch\",\"email\":\"reyna.collier@gmail.com\",\"phone\":\"(421) 964-3561 x012\",\"company\":\"Harber Ltd\",\"district\":\"debitis\",\"thana\":\"qui\",\"post_office\":\"01926\",\"village\":\"et\",\"shipping_address\":\"1583 Blick Prairie\\nPredovicmouth, HI 74236\",\"created_at\":\"2020-11-29T23:08:35.000000Z\"}','2020-12-06 23:08:37','2020-12-06 23:08:37',NULL),(79,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Elyse Beatty\",\"email\":\"kian78@yahoo.com\",\"phone\":\"257.565.5382 x41429\",\"company\":\"Bode-Gerlach\",\"district\":\"qui\",\"thana\":\"maiores\",\"post_office\":\"93674-5506\",\"village\":\"reiciendis\",\"shipping_address\":\"2821 Mertz Views Apt. 600\\nBuckridgeborough, CT 78071-2694\",\"created_at\":\"2020-11-19T23:08:35.000000Z\"}','2020-12-06 23:08:37','2020-12-06 23:08:37',NULL),(80,NULL,'created','App\\Models\\Customer','[]','{\"name\":\"Rhett Breitenberg\",\"email\":\"nmoore@rutherford.info\",\"phone\":\"+1.961.519.6993\",\"company\":\"McDermott, Quitzon and Ullrich\",\"district\":\"quibusdam\",\"thana\":\"nisi\",\"post_office\":\"77620\",\"village\":\"distinctio\",\"shipping_address\":\"73276 Kellie Heights Suite 607\\nSigurdmouth, OH 41467\",\"created_at\":\"2020-12-11T23:08:35.000000Z\"}','2020-12-06 23:08:37','2020-12-06 23:08:37',NULL),(81,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Miss Corrine Bins V\",\"email\":\"drippin@hartmann.com\",\"phone\":\"705-310-2672 x811\",\"company\":\"Padberg PLC\",\"district\":\"quidem\",\"thana\":\"qui\",\"post_office\":\"36639\",\"village\":\"inventore\",\"joining_date\":\"1995-10-13\",\"is_active\":true,\"position\":\"Computer Repairer\",\"salary\":46859.23,\"created_at\":\"2020-12-29T23:08:38.000000Z\"}','2020-12-06 23:08:38','2020-12-06 23:08:38',NULL),(82,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Mrs. Magdalena Wiza\",\"email\":\"jgutkowski@harber.com\",\"phone\":\"262.254.4846\",\"company\":\"Fay and Sons\",\"district\":\"aut\",\"thana\":\"saepe\",\"post_office\":\"96947\",\"village\":\"dignissimos\",\"joining_date\":\"1996-12-19\",\"is_active\":true,\"position\":\"Respiratory Therapy Technician\",\"salary\":45452.75,\"created_at\":\"2021-01-04T23:08:38.000000Z\"}','2020-12-06 23:08:38','2020-12-06 23:08:38',NULL),(83,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Kevon Padberg DDS\",\"email\":\"noemi36@fisher.info\",\"phone\":\"998-783-7268 x4436\",\"company\":\"Heller-Hintz\",\"district\":\"quaerat\",\"thana\":\"corrupti\",\"post_office\":\"86395\",\"village\":\"alias\",\"joining_date\":\"1971-10-06\",\"is_active\":true,\"position\":\"Food Cooking Machine Operators\",\"salary\":36873.5,\"created_at\":\"2020-12-19T23:08:38.000000Z\"}','2020-12-06 23:08:38','2020-12-06 23:08:38',NULL),(84,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Dr. Rachelle Kautzer II\",\"email\":\"elise72@zieme.com\",\"phone\":\"224-925-7814\",\"company\":\"Feil-Schultz\",\"district\":\"asperiores\",\"thana\":\"neque\",\"post_office\":\"51076\",\"village\":\"eveniet\",\"joining_date\":\"1992-10-21\",\"is_active\":true,\"position\":\"Radiologic Technologist and Technician\",\"salary\":13203.18,\"created_at\":\"2020-12-18T23:08:38.000000Z\"}','2020-12-06 23:08:38','2020-12-06 23:08:38',NULL),(85,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Ms. Laury Jenkins\",\"email\":\"marquise.hill@brakus.com\",\"phone\":\"578.609.7296\",\"company\":\"Parisian Group\",\"district\":\"quo\",\"thana\":\"dolore\",\"post_office\":\"91509-9825\",\"village\":\"fugiat\",\"joining_date\":\"2010-01-18\",\"is_active\":true,\"position\":\"Curator\",\"salary\":30722.49,\"created_at\":\"2021-01-02T23:08:38.000000Z\"}','2020-12-06 23:08:39','2020-12-06 23:08:39',NULL),(86,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Stanton Wiza\",\"email\":\"rosina11@auer.com\",\"phone\":\"(542) 438-3337 x68346\",\"company\":\"Kub-Klein\",\"district\":\"autem\",\"thana\":\"laudantium\",\"post_office\":\"51577-4005\",\"village\":\"dolore\",\"joining_date\":\"2019-09-16\",\"is_active\":true,\"position\":\"Farmworker\",\"salary\":16376.34,\"created_at\":\"2020-11-27T23:08:38.000000Z\"}','2020-12-06 23:08:39','2020-12-06 23:08:39',NULL),(87,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Emelie Wiza\",\"email\":\"oconnell.karine@bartell.net\",\"phone\":\"740-814-3194 x66272\",\"company\":\"Schmeler, Bruen and Gottlieb\",\"district\":\"est\",\"thana\":\"dignissimos\",\"post_office\":\"18561-8104\",\"village\":\"cupiditate\",\"joining_date\":\"1975-10-04\",\"is_active\":true,\"position\":\"Ophthalmic Laboratory Technician\",\"salary\":12337.36,\"created_at\":\"2020-12-28T23:08:38.000000Z\"}','2020-12-06 23:08:39','2020-12-06 23:08:39',NULL),(88,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Prof. Jaycee Johns Jr.\",\"email\":\"xward@balistreri.com\",\"phone\":\"+1.235.321.7762\",\"company\":\"Haag Group\",\"district\":\"eos\",\"thana\":\"animi\",\"post_office\":\"44443\",\"village\":\"odit\",\"joining_date\":\"2019-01-27\",\"is_active\":true,\"position\":\"Occupational Health Safety Specialist\",\"salary\":17112.94,\"created_at\":\"2020-12-04T23:08:38.000000Z\"}','2020-12-06 23:08:39','2020-12-06 23:08:39',NULL),(89,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Dorothy Jast\",\"email\":\"brandyn69@dach.com\",\"phone\":\"995-344-9920 x532\",\"company\":\"Luettgen, Rogahn and Cruickshank\",\"district\":\"doloribus\",\"thana\":\"repudiandae\",\"post_office\":\"37446-3780\",\"village\":\"autem\",\"joining_date\":\"1999-04-03\",\"is_active\":true,\"position\":\"Grounds Maintenance Worker\",\"salary\":11549.48,\"created_at\":\"2020-12-19T23:08:38.000000Z\"}','2020-12-06 23:08:40','2020-12-06 23:08:40',NULL),(90,NULL,'created','App\\Models\\Employee','[]','{\"name\":\"Mr. Tobin Leuschke II\",\"email\":\"kenyatta65@rippin.com\",\"phone\":\"1-624-454-3869 x2098\",\"company\":\"Hodkiewicz Ltd\",\"district\":\"qui\",\"thana\":\"dolor\",\"post_office\":\"87204-2393\",\"village\":\"nobis\",\"joining_date\":\"1998-10-11\",\"is_active\":true,\"position\":\"Photographic Process Worker\",\"salary\":32560.27,\"created_at\":\"2020-12-09T23:08:38.000000Z\"}','2020-12-06 23:08:40','2020-12-06 23:08:40',NULL),(91,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"quo\",\"description\":\"Ea nam sint maiores mollitia fugiat. Quos quibusdam ut nisi impedit laudantium.\"}','2020-12-06 23:08:41','2020-12-06 23:08:41',NULL),(92,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"quae\",\"description\":\"Fugit aut quis quod voluptate impedit. Nisi commodi incidunt quia eius nesciunt commodi.\"}','2020-12-06 23:08:41','2020-12-06 23:08:41',NULL),(93,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"quos\",\"description\":\"Sed ipsa in ipsam. Qui saepe id aut aspernatur dicta. Animi a quas a enim molestias adipisci iure.\"}','2020-12-06 23:08:41','2020-12-06 23:08:41',NULL),(94,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"accusantium\",\"description\":\"Quod maiores qui sunt rerum quisquam enim. Rerum iste praesentium occaecati adipisci ea.\"}','2020-12-06 23:08:42','2020-12-06 23:08:42',NULL),(95,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"rerum\",\"description\":\"Omnis vero voluptatem et quia. Non consequuntur provident sit nihil.\"}','2020-12-06 23:08:42','2020-12-06 23:08:42',NULL),(96,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"molestiae\",\"description\":\"Rerum non animi officia adipisci possimus sed. Vero aspernatur maxime quo sint.\"}','2020-12-06 23:08:43','2020-12-06 23:08:43',NULL),(97,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"ut\",\"description\":\"Sed fuga aut sunt quam nihil et. Reprehenderit qui est ducimus. Pariatur iste voluptatem magni.\"}','2020-12-06 23:08:43','2020-12-06 23:08:43',NULL),(98,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"quo\",\"description\":\"Repudiandae voluptas aut ex et vel. Dicta eveniet et qui quae aliquam aut.\"}','2020-12-06 23:08:43','2020-12-06 23:08:43',NULL),(99,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"nulla\",\"description\":\"Quia dolore laborum officiis et eveniet est. Totam rerum modi provident vero qui commodi quidem.\"}','2020-12-06 23:08:44','2020-12-06 23:08:44',NULL),(100,NULL,'created','App\\Models\\ExpenseCategory','[]','{\"name\":\"quos\",\"description\":\"Ut at dolor at ex tenetur dolor. Sed nesciunt iure aspernatur aut.\"}','2020-12-06 23:08:44','2020-12-06 23:08:44',NULL),(101,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"1\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":435.54,\"payable\":435.54,\"previous_balance\":0,\"current_balance\":435.54}','2020-12-06 23:26:37','2020-12-06 23:26:37',NULL),(102,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":1,\"product_id\":\"1\",\"customer_id\":\"1\",\"quantity\":\"1\",\"price\":435.54}','2020-12-06 23:26:37','2020-12-06 23:26:37',NULL),(103,1,'updated','App\\Models\\Sale','{\"id\":1,\"customer_id\":1,\"total\":435.54,\"tax\":0,\"discount\":0,\"payable\":435.54,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":0,\"current_balance\":435.54,\"paid\":0,\"created_at\":\"2020-12-06T23:26:37.000000Z\",\"updated_at\":\"2020-12-06T23:26:37.000000Z\",\"deleted_at\":null,\"is_modified\":0}','{\"id\":1,\"customer_id\":1,\"total\":435.54,\"tax\":0,\"discount\":0,\"payable\":435.54,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":435.54,\"current_balance\":871.08,\"paid\":0,\"created_at\":\"2020-12-06T23:26:37.000000Z\",\"updated_at\":\"2020-12-06T23:26:37.000000Z\",\"deleted_at\":null,\"is_modified\":true}','2020-12-06 23:27:32','2020-12-06 23:27:32',NULL),(104,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"1\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":435.54,\"payable\":435.54,\"previous_balance\":435.54,\"current_balance\":871.08}','2020-12-06 23:33:59','2020-12-06 23:33:59',NULL),(105,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":2,\"product_id\":\"1\",\"customer_id\":\"1\",\"quantity\":\"1\",\"price\":435.54}','2020-12-06 23:33:59','2020-12-06 23:33:59',NULL),(106,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"1\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":435.54,\"payable\":435.54,\"previous_balance\":871.08,\"current_balance\":1306.62}','2020-12-06 23:41:38','2020-12-06 23:41:38',NULL),(107,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":3,\"product_id\":\"1\",\"customer_id\":\"1\",\"quantity\":\"1\",\"price\":435.54}','2020-12-06 23:41:38','2020-12-06 23:41:38',NULL),(108,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"2\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":751.63,\"payable\":751.63,\"previous_balance\":0,\"current_balance\":751.63}','2020-12-06 23:42:29','2020-12-06 23:42:29',NULL),(109,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":4,\"product_id\":\"1\",\"customer_id\":\"2\",\"quantity\":\"1\",\"price\":435.54}','2020-12-06 23:42:29','2020-12-06 23:42:29',NULL),(110,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":4,\"product_id\":\"2\",\"customer_id\":\"2\",\"quantity\":\"1\",\"price\":316.09}','2020-12-06 23:42:29','2020-12-06 23:42:29',NULL),(111,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"3\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":273.01,\"payable\":273.01,\"previous_balance\":0,\"current_balance\":273.01}','2020-12-06 23:44:09','2020-12-06 23:44:09',NULL),(112,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":5,\"product_id\":\"4\",\"customer_id\":\"3\",\"quantity\":\"1\",\"price\":40.17}','2020-12-06 23:44:09','2020-12-06 23:44:09',NULL),(113,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":5,\"product_id\":\"5\",\"customer_id\":\"3\",\"quantity\":\"1\",\"price\":232.84}','2020-12-06 23:44:09','2020-12-06 23:44:09',NULL),(114,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"1\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":40.17,\"payable\":40.17,\"previous_balance\":1306.62,\"current_balance\":1346.79}','2020-12-06 23:45:33','2020-12-06 23:45:33',NULL),(115,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":6,\"product_id\":\"4\",\"customer_id\":\"1\",\"quantity\":\"1\",\"price\":40.17}','2020-12-06 23:45:33','2020-12-06 23:45:33',NULL),(116,1,'deleted','App\\Models\\Sale','{\"id\":6,\"customer_id\":1,\"total\":40.17,\"tax\":0,\"discount\":0,\"payable\":40.17,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":1306.62,\"current_balance\":1346.79,\"paid\":0,\"created_at\":\"2020-12-06T23:45:33.000000Z\",\"updated_at\":\"2020-12-06T23:45:33.000000Z\",\"deleted_at\":null,\"is_modified\":0}','{\"id\":6,\"customer_id\":1,\"total\":40.17,\"tax\":0,\"discount\":0,\"payable\":40.17,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":1306.62,\"current_balance\":1346.79,\"paid\":0,\"created_at\":\"2020-12-06T23:45:33.000000Z\",\"updated_at\":\"2020-12-06T23:45:33.000000Z\",\"deleted_at\":null,\"is_modified\":0}','2020-12-07 00:18:14','2020-12-07 00:18:14',NULL),(117,1,'deleted','App\\Models\\SaleItem','{\"id\":8,\"sale_id\":6,\"product_id\":4,\"customer_id\":1,\"quantity\":1,\"price\":40.17,\"total\":40.17,\"returned_quantity\":0,\"returned_total\":0,\"created_at\":\"2020-12-06T23:45:33.000000Z\",\"updated_at\":\"2020-12-06T23:45:33.000000Z\",\"deleted_at\":null}','{\"id\":8,\"sale_id\":6,\"product_id\":4,\"customer_id\":1,\"quantity\":1,\"price\":40.17,\"total\":40.17,\"returned_quantity\":0,\"returned_total\":0,\"created_at\":\"2020-12-06T23:45:33.000000Z\",\"updated_at\":\"2020-12-06T23:45:33.000000Z\",\"deleted_at\":null}','2020-12-07 00:18:14','2020-12-07 00:18:14',NULL),(118,1,'deleted','App\\Models\\Customer','{\"id\":2,\"name\":\"Esther Fay\",\"email\":\"jaeden.murray@emard.com\",\"phone\":\"(207) 693-5708\",\"company\":\"Gerhold-McGlynn\",\"district\":\"beatae\",\"thana\":\"qui\",\"post_office\":\"91481\",\"village\":\"vero\",\"shipping_address\":\"38359 Parisian Grove Apt. 107\\nDawsonmouth, PA 79049-2014\",\"photo\":null,\"created_at\":\"2020-11-16T23:08:35.000000Z\",\"updated_at\":\"2020-12-06T23:08:36.000000Z\",\"deleted_at\":null}','{\"id\":2,\"name\":\"Esther Fay\",\"email\":\"jaeden.murray@emard.com\",\"phone\":\"(207) 693-5708\",\"company\":\"Gerhold-McGlynn\",\"district\":\"beatae\",\"thana\":\"qui\",\"post_office\":\"91481\",\"village\":\"vero\",\"shipping_address\":\"38359 Parisian Grove Apt. 107\\nDawsonmouth, PA 79049-2014\",\"photo\":null,\"created_at\":\"2020-11-16T23:08:35.000000Z\",\"updated_at\":\"2020-12-06T23:08:36.000000Z\",\"deleted_at\":null}','2020-12-07 00:21:13','2020-12-07 00:21:13',NULL),(119,1,'created','App\\Models\\Purchase','[]','{\"supplier_id\":\"1\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"total\":174.27,\"payable\":174.27,\"paid\":0,\"previous_balance\":0,\"current_balance\":174.27}','2020-12-07 00:22:29','2020-12-07 00:22:29',NULL),(120,1,'created','App\\Models\\PurchaseItem','[]','{\"purchase_id\":1,\"product_id\":\"1\",\"supplier_id\":\"1\",\"quantity\":\"1\",\"price\":174.27}','2020-12-07 00:22:29','2020-12-07 00:22:29',NULL),(121,1,'created','App\\Models\\PurchaseItem','[]','{\"purchase_id\":1,\"product_id\":8,\"supplier_id\":1,\"quantity\":\"5\",\"price\":80.43,\"total\":402.15}','2020-12-08 00:54:50','2020-12-08 00:54:50',NULL),(122,1,'updated','App\\Models\\Purchase','{\"id\":1,\"supplier_id\":1,\"total\":174.27,\"tax\":0,\"discount\":0,\"payable\":174.27,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":0,\"current_balance\":174.27,\"paid\":0,\"created_at\":\"2020-12-07T00:22:29.000000Z\",\"updated_at\":\"2020-12-07T00:22:29.000000Z\",\"deleted_at\":null,\"is_modified\":0}','{\"id\":1,\"supplier_id\":1,\"total\":576.42,\"tax\":0,\"discount\":0,\"payable\":576.42,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":174.27,\"current_balance\":750.69,\"paid\":0,\"created_at\":\"2020-12-07T00:22:29.000000Z\",\"updated_at\":\"2020-12-07T00:22:29.000000Z\",\"deleted_at\":null,\"is_modified\":true}','2020-12-08 00:54:51','2020-12-08 00:54:51',NULL),(123,1,'updated','App\\Models\\PurchaseItem','{\"id\":2,\"purchase_id\":1,\"product_id\":8,\"supplier_id\":1,\"quantity\":5,\"price\":80.43,\"total\":402.15,\"returned_quantity\":0,\"returned_total\":0,\"created_at\":\"2020-12-08T00:54:51.000000Z\",\"updated_at\":\"2020-12-08T00:54:51.000000Z\",\"deleted_at\":null}','{\"id\":2,\"purchase_id\":1,\"product_id\":8,\"supplier_id\":1,\"quantity\":\"6\",\"price\":80.43,\"total\":482.58,\"returned_quantity\":0,\"returned_total\":0,\"created_at\":\"2020-12-08T00:54:51.000000Z\",\"updated_at\":\"2020-12-08T00:54:51.000000Z\",\"deleted_at\":null}','2020-12-08 01:03:55','2020-12-08 01:03:55',NULL),(124,1,'updated','App\\Models\\Purchase','{\"id\":1,\"supplier_id\":1,\"total\":576.42,\"tax\":0,\"discount\":0,\"payable\":576.42,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":174.27,\"current_balance\":750.69,\"paid\":0,\"created_at\":\"2020-12-07T00:22:29.000000Z\",\"updated_at\":\"2020-12-08T00:54:51.000000Z\",\"deleted_at\":null,\"is_modified\":1}','{\"id\":1,\"supplier_id\":1,\"total\":656.85,\"tax\":0,\"discount\":0,\"payable\":656.85,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":576.42,\"current_balance\":1233.27,\"paid\":0,\"created_at\":\"2020-12-07T00:22:29.000000Z\",\"updated_at\":\"2020-12-08T00:54:51.000000Z\",\"deleted_at\":null,\"is_modified\":true}','2020-12-08 01:03:55','2020-12-08 01:03:55',NULL),(125,1,'deleted','App\\Models\\PurchaseItem','{\"id\":2,\"purchase_id\":1,\"product_id\":8,\"supplier_id\":1,\"quantity\":6,\"price\":80.43,\"total\":482.58,\"returned_quantity\":0,\"returned_total\":0,\"created_at\":\"2020-12-08T00:54:51.000000Z\",\"updated_at\":\"2020-12-08T01:03:55.000000Z\",\"deleted_at\":null}','{\"id\":2,\"purchase_id\":1,\"product_id\":8,\"supplier_id\":1,\"quantity\":6,\"price\":80.43,\"total\":482.58,\"returned_quantity\":0,\"returned_total\":0,\"created_at\":\"2020-12-08T00:54:51.000000Z\",\"updated_at\":\"2020-12-08T01:03:55.000000Z\",\"deleted_at\":null}','2020-12-08 01:05:28','2020-12-08 01:05:28',NULL),(126,1,'updated','App\\Models\\Purchase','{\"id\":1,\"supplier_id\":1,\"total\":656.85,\"tax\":0,\"discount\":0,\"payable\":656.85,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":576.42,\"current_balance\":1233.27,\"paid\":0,\"created_at\":\"2020-12-07T00:22:29.000000Z\",\"updated_at\":\"2020-12-08T01:03:55.000000Z\",\"deleted_at\":null,\"is_modified\":1}','{\"id\":1,\"supplier_id\":1,\"total\":174.27,\"tax\":0,\"discount\":0,\"payable\":174.27,\"returned\":0,\"date\":\"2020-12-07\",\"status\":\"Processed\",\"note\":null,\"previous_balance\":576.42,\"current_balance\":1233.27,\"paid\":0,\"created_at\":\"2020-12-07T00:22:29.000000Z\",\"updated_at\":\"2020-12-08T01:03:55.000000Z\",\"deleted_at\":null,\"is_modified\":1}','2020-12-08 01:05:28','2020-12-08 01:05:28',NULL),(127,1,'created','App\\Models\\SalePayment','[]','{\"customer_id\":1,\"payment_method\":\"Cash\",\"payment_amount\":1306.62,\"bank\":null,\"check\":null,\"transaction_no\":null,\"created_at\":\"2020-12-08T01:24:15.000000Z\"}','2020-12-08 01:24:15','2020-12-08 01:24:15',NULL),(128,1,'created','App\\Models\\SalePayment','[]','{\"customer_id\":1,\"payment_method\":\"Cash\",\"payment_amount\":0,\"bank\":null,\"check\":null,\"transaction_no\":null,\"created_at\":\"2020-12-08T01:24:27.000000Z\"}','2020-12-08 01:24:27','2020-12-08 01:24:27',NULL),(129,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"5\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-08\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":1024.64,\"payable\":1024.64,\"previous_balance\":0,\"current_balance\":1024.64}','2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(130,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":7,\"product_id\":\"1\",\"customer_id\":\"5\",\"quantity\":\"1\",\"price\":435.54}','2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(131,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":7,\"product_id\":\"4\",\"customer_id\":\"5\",\"quantity\":\"1\",\"price\":40.17}','2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(132,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":7,\"product_id\":\"5\",\"customer_id\":\"5\",\"quantity\":\"1\",\"price\":232.84}','2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(133,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":7,\"product_id\":\"2\",\"customer_id\":\"5\",\"quantity\":\"1\",\"price\":316.09}','2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(134,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"5\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-08\",\"status\":\"Processed\",\"note\":null,\"paid\":1754.41,\"total\":729.77,\"payable\":729.77,\"previous_balance\":1024.64,\"current_balance\":0}','2020-12-08 01:26:33','2020-12-08 01:26:33',NULL),(135,1,'created','App\\Models\\SalePayment','[]','{\"customer_id\":5,\"payment_method\":\"Cash\",\"payment_amount\":1754.41,\"bank\":null,\"check\":null,\"transaction_no\":null,\"created_at\":\"2020-12-08T01:26:33.000000Z\"}','2020-12-08 01:26:33','2020-12-08 01:26:33',NULL),(136,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":8,\"product_id\":\"3\",\"customer_id\":\"5\",\"quantity\":\"1\",\"price\":496.93}','2020-12-08 01:26:33','2020-12-08 01:26:33',NULL),(137,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":8,\"product_id\":\"5\",\"customer_id\":\"5\",\"quantity\":\"1\",\"price\":232.84}','2020-12-08 01:26:33','2020-12-08 01:26:33',NULL),(138,1,'created','App\\Models\\Sale','[]','{\"customer_id\":\"8\",\"tax\":\"0\",\"discount\":\"0\",\"date\":\"2020-12-08\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":343.41,\"payable\":343.41,\"previous_balance\":0,\"current_balance\":343.41}','2020-12-08 01:27:33','2020-12-08 01:27:33',NULL),(139,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":9,\"product_id\":\"4\",\"customer_id\":\"8\",\"quantity\":\"1\",\"price\":40.17}','2020-12-08 01:27:33','2020-12-08 01:27:33',NULL),(140,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":9,\"product_id\":\"5\",\"customer_id\":\"8\",\"quantity\":\"1\",\"price\":232.84}','2020-12-08 01:27:33','2020-12-08 01:27:33',NULL),(141,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":9,\"product_id\":\"6\",\"customer_id\":\"8\",\"quantity\":\"1\",\"price\":70.4}','2020-12-08 01:27:33','2020-12-08 01:27:33',NULL),(142,1,'created','App\\Models\\SalePayment','[]','{\"customer_id\":3,\"payment_method\":\"Cash\",\"payment_amount\":73.01,\"bank\":null,\"check\":null,\"transaction_no\":null,\"created_at\":\"2020-12-08T01:36:53.000000Z\"}','2020-12-08 01:36:53','2020-12-08 01:36:53',NULL),(143,1,'created','App\\Models\\SalePayment','[]','{\"customer_id\":5,\"payment_method\":\"Cash\",\"payment_amount\":44,\"bank\":null,\"check\":null,\"transaction_no\":null,\"created_at\":\"2020-12-09T20:01:43.000000Z\"}','2020-12-09 20:01:43','2020-12-09 20:01:43',NULL),(144,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"1\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-06T23:08:19.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":2,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-06T23:08:19.000000Z\",\"deleted_at\":null}','2020-12-11 17:22:15','2020-12-11 17:22:15',NULL),(145,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"2\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:22:15.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":1,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:22:15.000000Z\",\"deleted_at\":null}','2020-12-11 17:22:19','2020-12-11 17:22:19',NULL),(146,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"1\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:22:19.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":2,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:22:19.000000Z\",\"deleted_at\":null}','2020-12-11 17:24:18','2020-12-11 17:24:18',NULL),(147,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"2\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:24:18.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":1,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:24:18.000000Z\",\"deleted_at\":null}','2020-12-11 17:24:31','2020-12-11 17:24:31',NULL),(148,1,'updated','App\\Models\\Setting','{\"id\":16,\"key\":\"invoice_footer\",\"value\":\"\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-06T23:08:19.000000Z\",\"deleted_at\":null}','{\"id\":16,\"key\":\"invoice_footer\",\"value\":null,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-06T23:08:19.000000Z\",\"deleted_at\":null}','2020-12-11 17:40:46','2020-12-11 17:40:46',NULL),(149,1,'updated','App\\Models\\Setting','{\"id\":15,\"key\":\"invoice_header\",\"value\":\"\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-06T23:08:19.000000Z\",\"deleted_at\":null}','{\"id\":15,\"key\":\"invoice_header\",\"value\":null,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-06T23:08:19.000000Z\",\"deleted_at\":null}','2020-12-11 17:40:46','2020-12-11 17:40:46',NULL),(150,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"1\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:24:31.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":\"2\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:24:31.000000Z\",\"deleted_at\":null}','2020-12-11 17:40:46','2020-12-11 17:40:46',NULL),(151,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"2\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:40:46.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":\"1\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:40:46.000000Z\",\"deleted_at\":null}','2020-12-11 17:40:56','2020-12-11 17:40:56',NULL),(152,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"1\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:40:56.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":2,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T17:40:56.000000Z\",\"deleted_at\":null}','2020-12-11 18:20:21','2020-12-11 18:20:21',NULL),(153,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"2\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T18:20:21.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":1,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T18:20:21.000000Z\",\"deleted_at\":null}','2020-12-11 18:20:26','2020-12-11 18:20:26',NULL),(154,1,'updated','App\\Models\\Setting','{\"id\":14,\"key\":\"language\",\"value\":\"1\",\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T18:20:26.000000Z\",\"deleted_at\":null}','{\"id\":14,\"key\":\"language\",\"value\":2,\"created_at\":\"2020-12-06T23:08:19.000000Z\",\"updated_at\":\"2020-12-11T18:20:26.000000Z\",\"deleted_at\":null}','2020-12-11 21:56:00','2020-12-11 21:56:00',NULL),(155,1,'created','App\\Models\\Sale','[]','{\"customer_id\":1,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":0,\"payable\":0,\"previous_balance\":0,\"current_balance\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(156,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":10,\"product_id\":\"1\",\"customer_id\":1,\"quantity\":1,\"price\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(157,1,'created','App\\Models\\Sale','[]','{\"customer_id\":3,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":200,\"payable\":200,\"previous_balance\":0,\"current_balance\":200}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(158,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":11,\"product_id\":\"1\",\"customer_id\":3,\"quantity\":1,\"price\":200}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(159,1,'created','App\\Models\\Sale','[]','{\"customer_id\":4,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":0,\"payable\":0,\"previous_balance\":0,\"current_balance\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(160,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":12,\"product_id\":\"1\",\"customer_id\":4,\"quantity\":1,\"price\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(161,1,'created','App\\Models\\Sale','[]','{\"customer_id\":5,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":-44,\"payable\":-44,\"previous_balance\":0,\"current_balance\":-44}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(162,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":13,\"product_id\":\"1\",\"customer_id\":5,\"quantity\":1,\"price\":-44}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(163,1,'created','App\\Models\\Sale','[]','{\"customer_id\":6,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":0,\"payable\":0,\"previous_balance\":0,\"current_balance\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(164,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":14,\"product_id\":\"1\",\"customer_id\":6,\"quantity\":1,\"price\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(165,1,'created','App\\Models\\Sale','[]','{\"customer_id\":7,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":0,\"payable\":0,\"previous_balance\":0,\"current_balance\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(166,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":15,\"product_id\":\"1\",\"customer_id\":7,\"quantity\":1,\"price\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(167,1,'created','App\\Models\\Sale','[]','{\"customer_id\":8,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":343.41,\"payable\":343.41,\"previous_balance\":0,\"current_balance\":343.41}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(168,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":16,\"product_id\":\"1\",\"customer_id\":8,\"quantity\":1,\"price\":343.41}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(169,1,'created','App\\Models\\Sale','[]','{\"customer_id\":9,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":0,\"payable\":0,\"previous_balance\":0,\"current_balance\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(170,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":17,\"product_id\":\"1\",\"customer_id\":9,\"quantity\":1,\"price\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(171,1,'created','App\\Models\\Sale','[]','{\"customer_id\":10,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":0,\"payable\":0,\"previous_balance\":0,\"current_balance\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(172,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":18,\"product_id\":\"1\",\"customer_id\":10,\"quantity\":1,\"price\":0}','2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(173,1,'created','App\\Models\\Sale','[]','{\"customer_id\":3,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":400,\"payable\":400,\"previous_balance\":0,\"current_balance\":400}','2020-12-12 15:48:59','2020-12-12 15:48:59',NULL),(174,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":19,\"product_id\":\"1\",\"customer_id\":3,\"quantity\":1,\"price\":400}','2020-12-12 15:48:59','2020-12-12 15:48:59',NULL),(175,1,'created','App\\Models\\Sale','[]','{\"customer_id\":8,\"tax\":0,\"discount\":0,\"date\":\"2020-12-12\",\"status\":\"Processed\",\"note\":null,\"paid\":0,\"total\":686.82,\"payable\":686.82,\"previous_balance\":0,\"current_balance\":686.82}','2020-12-12 15:48:59','2020-12-12 15:48:59',NULL),(176,1,'created','App\\Models\\SaleItem','[]','{\"sale_id\":20,\"product_id\":\"1\",\"customer_id\":8,\"quantity\":1,\"price\":686.82}','2020-12-12 15:48:59','2020-12-12 15:48:59',NULL);
/*!40000 ALTER TABLE `histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language_definitions`
--

DROP TABLE IF EXISTS `language_definitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `language_definitions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `language_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=849 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_definitions`
--

LOCK TABLES `language_definitions` WRITE;
/*!40000 ALTER TABLE `language_definitions` DISABLE KEYS */;
INSERT INTO `language_definitions` VALUES (1,'1','dashboard','Dashboard',1,NULL,NULL,NULL),(2,'1','locale','Locale',1,NULL,NULL,NULL),(3,'1','user_management','User Management',1,NULL,NULL,NULL),(4,'1','role_management','Role Management',1,NULL,NULL,NULL),(5,'1','permission_management','Permission Management',1,NULL,NULL,NULL),(6,'1','check_user_ability','Check User Ability',1,NULL,NULL,NULL),(7,'1','check_role_ability','Check Role Ability',1,NULL,NULL,NULL),(8,'1','sales','Sales',1,NULL,NULL,NULL),(9,'1','new_sale','New Sale',1,NULL,NULL,NULL),(10,'1','list_sales','List Sales',1,NULL,NULL,NULL),(11,'1','purchases','Purchases',1,NULL,NULL,NULL),(12,'1','new_purchase','New Purchase',1,NULL,NULL,NULL),(13,'1','list_purchases','List Purchases',1,NULL,NULL,NULL),(14,'1','contacts','Contacts',1,NULL,NULL,NULL),(15,'1','customers','Customers',1,NULL,NULL,NULL),(16,'1','suppliers','Suppliers',1,NULL,NULL,NULL),(17,'1','balance_sheet','Balance Sheet',1,NULL,NULL,NULL),(18,'1','customers_balance','Customers Balance',1,NULL,NULL,NULL),(19,'1','suppliers_balance','Suppliers Balance',1,NULL,NULL,NULL),(20,'1','capital_funds','Capital Funds',1,NULL,NULL,NULL),(21,'1','balance','Balance',1,NULL,NULL,NULL),(22,'1','capital','Capital',1,NULL,NULL,NULL),(23,'1','purchase_amount','Purchase Amount',1,NULL,NULL,NULL),(24,'1','purchase_payable','Purchase Payable',1,NULL,NULL,NULL),(25,'1','sale_amount','Sale Amount',1,NULL,NULL,NULL),(26,'1','others','Others',1,NULL,NULL,NULL),(27,'1','remaining','Remaining',1,NULL,NULL,NULL),(28,'1','previous_balance','Previous Balance',1,NULL,NULL,NULL),(29,'1','current_balance','Current Balance',1,NULL,NULL,NULL),(30,'1','deposits','Deposits',1,NULL,NULL,NULL),(31,'1','withdraws','Withdraws',1,NULL,NULL,NULL),(32,'1','expenses','Expenses',1,NULL,NULL,NULL),(33,'1','list','List',1,NULL,NULL,NULL),(34,'1','code','Code',1,NULL,NULL,NULL),(35,'1','cost','Cost',1,NULL,NULL,NULL),(36,'1','price','Price',1,NULL,NULL,NULL),(37,'1','sales.price','Price',1,NULL,NULL,NULL),(38,'1','barcode_symbology','Barcode Symbology',1,NULL,NULL,NULL),(39,'1','brand','Brand',1,NULL,NULL,NULL),(40,'1','brand_name','Brand Name',1,NULL,NULL,NULL),(41,'1','category','Category',1,NULL,NULL,NULL),(42,'1','category_name','Category Name',1,NULL,NULL,NULL),(43,'1','sub_category','Sub Category',1,NULL,NULL,NULL),(44,'1','sub_category_name','Sub Category Name',1,NULL,NULL,NULL),(45,'1','unit','Unit',1,NULL,NULL,NULL),(46,'1','unit_name','Unit Name',1,NULL,NULL,NULL),(47,'1','status','Status',1,NULL,NULL,NULL),(48,'1','quantity','Quantity',1,NULL,NULL,NULL),(49,'1','alert_quantity','Alert Quantity',1,NULL,NULL,NULL),(50,'1','view_product','View Product',1,NULL,NULL,NULL),(51,'1','select_product','Select Product',1,NULL,NULL,NULL),(52,'1','cart_details','Cart Details',1,NULL,NULL,NULL),(53,'1','created_by','Created By',1,NULL,NULL,NULL),(54,'1','datetime','Datetime',1,NULL,NULL,NULL),(55,'1','reference','Reference',1,NULL,NULL,NULL),(56,'1','supplier','Supplier',1,NULL,NULL,NULL),(57,'1','note','Note',1,NULL,NULL,NULL),(58,'1','amount','Amount',1,NULL,NULL,NULL),(59,'1','taken_by','Taken By',1,NULL,NULL,NULL),(60,'1','total_deposit','Total Deposit',1,NULL,NULL,NULL),(61,'1','total_withdrawals','Total Withdrawals',1,NULL,NULL,NULL),(62,'1','overview','Overview',1,NULL,NULL,NULL),(63,'1','funding_overview','Funding Overview',1,NULL,NULL,NULL),(64,'1','deposit_amount','Deposit Amount',1,NULL,NULL,NULL),(65,'1','withdrawal_amount','Withdrawal Amount',1,NULL,NULL,NULL),(66,'1','payment_amount','Payment Amount',1,NULL,NULL,NULL),(67,'1','sales.payment_amount','Payment Amount',1,NULL,NULL,NULL),(68,'1','employment_salaries.payment_amount','Payment Amount',1,NULL,NULL,NULL),(69,'1','payment_method','Payment Method',1,NULL,NULL,NULL),(70,'1','bank','Bank',1,NULL,NULL,NULL),(71,'1','check_no','Check No',1,NULL,NULL,NULL),(72,'1','transaction_no','Transaction No',1,NULL,NULL,NULL),(73,'1','customer_balance_sheet','Customer Balance Sheet',1,NULL,NULL,NULL),(74,'1','company','Company',1,NULL,NULL,NULL),(75,'1','district','District',1,NULL,NULL,NULL),(76,'1','deposit','Deposit',1,NULL,NULL,NULL),(77,'1','withdrawn','Withdrawn',1,NULL,NULL,NULL),(78,'1','payable','Payable',1,NULL,NULL,NULL),(79,'1','sales.payable','Payable',1,NULL,NULL,NULL),(80,'1','paid','Paid',1,NULL,NULL,NULL),(81,'1','customers.paid','Paid',1,NULL,NULL,NULL),(82,'1','method','Method',1,NULL,NULL,NULL),(83,'1','suppliers.paid','Paid',1,NULL,NULL,NULL),(84,'1','final_balance','Final Balance',1,NULL,NULL,NULL),(85,'1','village','Village',1,NULL,NULL,NULL),(86,'1','thana','Thana',1,NULL,NULL,NULL),(87,'1','post_office','Post Office',1,NULL,NULL,NULL),(88,'1','funds_balance','Funds Balance',1,NULL,NULL,NULL),(89,'1','categories','Categories',1,NULL,NULL,NULL),(90,'1','sub_categories','Sub Categories',1,NULL,NULL,NULL),(91,'1','brands','Brands',1,NULL,NULL,NULL),(92,'1','units','Units',1,NULL,NULL,NULL),(93,'1','main_inventory','Main Inventory',1,NULL,NULL,NULL),(94,'1','products','Products',1,NULL,NULL,NULL),(95,'1','product_id','Product ID',1,NULL,NULL,NULL),(96,'1','send_salary','Send Salary',1,NULL,NULL,NULL),(97,'1','check_ins','Check Ins',1,NULL,NULL,NULL),(98,'1','check_outs','Check Outs',1,NULL,NULL,NULL),(99,'1','settings','Settings',1,NULL,NULL,NULL),(100,'1','languages','Languages',1,NULL,NULL,NULL),(101,'1','add_language','Add Language',1,NULL,NULL,NULL),(102,'1','edit_language','Edit Language',1,NULL,NULL,NULL),(103,'1','view_language','View Language',1,NULL,NULL,NULL),(104,'1','delete_language','Delete Language',1,NULL,NULL,NULL),(105,'1','definitions','Definitions',1,NULL,NULL,NULL),(106,'1','preferences','Preferences',1,NULL,NULL,NULL),(107,'1','address','Address',1,NULL,NULL,NULL),(108,'1','currency','Currency',1,NULL,NULL,NULL),(109,'1','default_customer','Default Customer',1,NULL,NULL,NULL),(110,'1','default_discount','Default Discount',1,NULL,NULL,NULL),(111,'1','default_tax','Default Tax',1,NULL,NULL,NULL),(112,'1','email','Email',1,NULL,NULL,NULL),(113,'1','language','Language',1,NULL,NULL,NULL),(114,'1','logo','Logo',1,NULL,NULL,NULL),(115,'1','phone','Phone',1,NULL,NULL,NULL),(116,'1','send_sms_after_order','Send Sms After Order',1,NULL,NULL,NULL),(117,'1','send_sms_after_sale','Send Sms After Sale',1,NULL,NULL,NULL),(118,'1','site_name','Site Name',1,NULL,NULL,NULL),(119,'1','timezone','Timezone',1,NULL,NULL,NULL),(120,'1','are_you_sure','Are You Sure',1,NULL,NULL,NULL),(121,'1','name','Name',1,NULL,NULL,NULL),(122,'1','photo','Photo',1,NULL,NULL,NULL),(123,'1','key','Key',1,NULL,NULL,NULL),(124,'1','action','Action',1,NULL,NULL,NULL),(125,'1','value','Value',1,NULL,NULL,NULL),(126,'1','description','Description',1,NULL,NULL,NULL),(127,'1','created_at','Created At',1,NULL,NULL,NULL),(128,'1','updated_at','Updated At',1,NULL,NULL,NULL),(129,'1','submit','Submit',1,NULL,NULL,NULL),(130,'1','roles','Roles',1,NULL,NULL,NULL),(131,'1','permissions','Permissions',1,NULL,NULL,NULL),(132,'1','user_abilities','User Abilities',1,NULL,NULL,NULL),(133,'1','role_abilities','Role Abilities',1,NULL,NULL,NULL),(134,'1','add_edit_user','Add Edit User',1,NULL,NULL,NULL),(135,'1','view_user','View User',1,NULL,NULL,NULL),(136,'1','add','Add',1,NULL,NULL,NULL),(137,'1','id','Id',1,NULL,NULL,NULL),(138,'1','per_page','Per Page',1,NULL,NULL,NULL),(139,'1','type_and_hit_enter_to_search_the_table','Type And Hit Enter To Search The Table',1,NULL,NULL,NULL),(140,'1','columns','Columns',1,NULL,NULL,NULL),(141,'1','no_items_found','No Items Found',1,NULL,NULL,NULL),(142,'1','view_role','View Role',1,NULL,NULL,NULL),(143,'1','guard','Guard',1,NULL,NULL,NULL),(144,'1','add_edit_permission','Add Edit Permission',1,NULL,NULL,NULL),(145,'1','view_permission','View Permission',1,NULL,NULL,NULL),(146,'1','assigned_roles','Assigned Roles',1,NULL,NULL,NULL),(147,'1','assigned_users','Assigned Users',1,NULL,NULL,NULL),(148,'1','search_users','Search Users',1,NULL,NULL,NULL),(149,'1','type_and_search_user','Type And Search User',1,NULL,NULL,NULL),(150,'1','search_permissions','Search Permissions',1,NULL,NULL,NULL),(151,'1','type_and_search_permission','Type And Search Permission',1,NULL,NULL,NULL),(152,'1','reset','Reset',1,NULL,NULL,NULL),(153,'1','search_roles','Search Roles',1,NULL,NULL,NULL),(154,'1','type_and_search_role','Type And Search Role',1,NULL,NULL,NULL),(155,'1','email_verified_at','Email Verified At',1,NULL,NULL,NULL),(156,'1','email_address','Email Address',1,NULL,NULL,NULL),(157,'1','password','Password',1,NULL,NULL,NULL),(158,'1','please_select_an_option','Please Select An Option',1,NULL,NULL,NULL),(159,'1','click_to_remove','Click To Remove',1,NULL,NULL,NULL),(160,'1','guard_name','Guard Name',1,NULL,NULL,NULL),(161,'1','revoke_user','Revoke User',1,NULL,NULL,NULL),(162,'1','detach','Detach',1,NULL,NULL,NULL),(163,'1','allowed','Allowed',1,NULL,NULL,NULL),(164,'1','users','Users',1,NULL,NULL,NULL),(165,'1','selected_users','Selected Users',1,NULL,NULL,NULL),(166,'1','search_and_assign_roles','Search And Assign Roles',1,NULL,NULL,NULL),(167,'1','search_and_assign_users','Search And Assign Users',1,NULL,NULL,NULL),(168,'1','cash','Cash',1,NULL,NULL,NULL),(169,'1','card','Card',1,NULL,NULL,NULL),(170,'1','bkash','Bkash',1,NULL,NULL,NULL),(171,'1','rocket','Rocket',1,NULL,NULL,NULL),(172,'1','customer','Customer',1,NULL,NULL,NULL),(173,'1','date','Date',1,NULL,NULL,NULL),(174,'1','returned','Returned',1,NULL,NULL,NULL),(175,'1','returned_total','Returned Total',1,NULL,NULL,NULL),(176,'1','returned_quantity','Returned Qty.',1,NULL,NULL,NULL),(177,'1','processed','Processed',1,NULL,NULL,NULL),(178,'1','cancelled','Cancelled',1,NULL,NULL,NULL),(179,'1','full','Full',1,NULL,NULL,NULL),(180,'1','tax','Tax',1,NULL,NULL,NULL),(181,'1','discount','Discount',1,NULL,NULL,NULL),(182,'1','total','Total',1,NULL,NULL,NULL),(183,'1','sales_note','Sales Note',1,NULL,NULL,NULL),(184,'1','pid','Pid',1,NULL,NULL,NULL),(185,'1','not_selected','Not Selected',1,NULL,NULL,NULL),(186,'1','history','History',1,NULL,NULL,NULL),(187,'1','take_payment','Take Payment',1,NULL,NULL,NULL),(188,'1','payment_history','Payment History',1,NULL,NULL,NULL),(189,'1','view_sale_history','View Sale History',1,NULL,NULL,NULL),(190,'1','edit_the_sale','Edit The Sale',1,NULL,NULL,NULL),(191,'1','delete_the_sale','Delete The Sale',1,NULL,NULL,NULL),(192,'1','check','Check',1,NULL,NULL,NULL),(193,'1','customer_id','Customer Id',1,NULL,NULL,NULL),(194,'1','supplier_name','Supplier Name',1,NULL,NULL,NULL),(195,'1','payment_is_completed_for_this_sale','Payment Is Completed For This Sale',1,NULL,NULL,NULL),(196,'1','view_sale','View Sale',1,NULL,NULL,NULL),(197,'1','customer_details','Customer Details',1,NULL,NULL,NULL),(198,'1','sale_items','Sale Items',1,NULL,NULL,NULL),(199,'1','sale_id','Sale Id',1,NULL,NULL,NULL),(200,'1','product_name','Product Name',1,NULL,NULL,NULL),(201,'1','shipping_address','Shipping Address',1,NULL,NULL,NULL),(202,'1','deleted_at','Deleted At',1,NULL,NULL,NULL),(203,'1','ok','Ok',1,NULL,NULL,NULL),(204,'1','cancel','Cancel',1,NULL,NULL,NULL),(205,'1','purchase_note','Purchase Note',1,NULL,NULL,NULL),(206,'1','list_of_purchases','List Of Purchases',1,NULL,NULL,NULL),(207,'1','view_purchase_history','View Purchase History',1,NULL,NULL,NULL),(208,'1','edit_the_purchase','Edit The Purchase',1,NULL,NULL,NULL),(209,'1','delete_the_purchase','Delete The Purchase',1,NULL,NULL,NULL),(210,'1','payment_is_completed_for_this_purchase','Payment Is Completed For This Purchase',1,NULL,NULL,NULL),(211,'1','given_by','Given By',1,NULL,NULL,NULL),(212,'1','supplier_id','Supplier Id',1,NULL,NULL,NULL),(213,'1','view_purchase','View Purchase',1,NULL,NULL,NULL),(214,'1','supplier_details','Supplier Details',1,NULL,NULL,NULL),(215,'1','purchase_id','Purchase Id',1,NULL,NULL,NULL),(216,'1','add_fund','Add Fund',1,NULL,NULL,NULL),(217,'1','view','View',1,NULL,NULL,NULL),(218,'1','view_customer','View Customer',1,NULL,NULL,NULL),(219,'1','edit','Edit',1,NULL,NULL,NULL),(220,'1','edit_customer','Edit Customer',1,NULL,NULL,NULL),(221,'1','delete','Delete',1,NULL,NULL,NULL),(222,'1','delete_customer','Delete Customer',1,NULL,NULL,NULL),(223,'1','add_customer','Add Customer',1,NULL,NULL,NULL),(224,'1','phone_number','Phone Number',1,NULL,NULL,NULL),(225,'1','withdrawn_amount','Withdrawn Amount',1,NULL,NULL,NULL),(226,'1','sales_payable','Sales Payable',1,NULL,NULL,NULL),(227,'1','sales_paid','Sales Paid',1,NULL,NULL,NULL),(228,'1','sales_returned','Sales Paid',1,NULL,NULL,NULL),(229,'1','sales_balance','Sales Balance',1,NULL,NULL,NULL),(230,'1','view_supplier','View Supplier',1,NULL,NULL,NULL),(231,'1','purchases_payable','Purchases Payable',1,NULL,NULL,NULL),(232,'1','total_purchases','Total Purchases',1,NULL,NULL,NULL),(233,'1','purchases_paid','Purchases Paid',1,NULL,NULL,NULL),(234,'1','purchases_balance','Purchases Balance',1,NULL,NULL,NULL),(235,'1','total_purchased_amount','Total Purchased Amount',1,NULL,NULL,NULL),(236,'1','add_more_fund','Add More Fund',1,NULL,NULL,NULL),(237,'1','make_due_sales_payment_from_available_fund','Make Due Sales Payment From Available Fund',1,NULL,NULL,NULL),(238,'1','make_due_payments','Make Due Payments',1,NULL,NULL,NULL),(239,'1','customer_name','Customer Name',1,NULL,NULL,NULL),(240,'1','available_funds','Available Funds',1,NULL,NULL,NULL),(241,'1','supplier_balance_sheet','Supplier Balance Sheet',1,NULL,NULL,NULL),(242,'1','due_purchases','Due Purchases',1,NULL,NULL,NULL),(243,'1','make_due_purchase_payment_from_available_fund','Make Due Purchase Payment From Available Fund',1,NULL,NULL,NULL),(244,'1','funds','Funds',1,NULL,NULL,NULL),(245,'1','capital_deposits','Capital Deposits',1,NULL,NULL,NULL),(246,'1','capital_withdraws','Capital Withdraws',1,NULL,NULL,NULL),(247,'1','total_number_of_withdrawals','Total Number Of Withdrawals',1,NULL,NULL,NULL),(248,'1','total_withdrawal_amount','Total Withdrawal Amount',1,NULL,NULL,NULL),(249,'1','view_deposit_details','View Deposit Details',1,NULL,NULL,NULL),(250,'1','deposited_by','Deposited By',1,NULL,NULL,NULL),(251,'1','deposit_method','Deposit Method',1,NULL,NULL,NULL),(252,'1','edit_fund','Edit Fund',1,NULL,NULL,NULL),(253,'1','view_withdrawal_details','View Withdrawal Details',1,NULL,NULL,NULL),(254,'1','withdrawn_by','Withdrawn By',1,NULL,NULL,NULL),(255,'1','withdraw_method','Withdraw Method',1,NULL,NULL,NULL),(256,'1','total_expense_amount','Total Expense Amount',1,NULL,NULL,NULL),(257,'1','total_expense_quantity','Total Expense Quantity',1,NULL,NULL,NULL),(258,'1','view_expense','View Expense',1,NULL,NULL,NULL),(259,'1','expense_category_id','Expense Category Id',1,NULL,NULL,NULL),(260,'1','expense_categories','Expense Categories',1,NULL,NULL,NULL),(261,'1','expense_category_name','Expense Category Name',1,NULL,NULL,NULL),(262,'1','taken_by_name','Taken By Name',1,NULL,NULL,NULL),(263,'1','add_expense','Add Expense',1,NULL,NULL,NULL),(264,'1','expense_category','Expense Category',1,NULL,NULL,NULL),(265,'1','expense_amount','Expense Amount',1,NULL,NULL,NULL),(266,'1','expense_reference','Expense Reference',1,NULL,NULL,NULL),(267,'1','edit_expense','Edit Expense',1,NULL,NULL,NULL),(268,'1','view_category','View Category',1,NULL,NULL,NULL),(269,'1','add _category','Add  Category',1,NULL,NULL,NULL),(270,'1','edit_category','Edit Category',1,NULL,NULL,NULL),(271,'1','category_id','Category Id',1,NULL,NULL,NULL),(272,'1','subcategory_id','Subcategory Id',1,NULL,NULL,NULL),(273,'1','brand_id','Brand Id',1,NULL,NULL,NULL),(274,'1','unit_id','Unit Id',1,NULL,NULL,NULL),(275,'1','subcategory_name','Subcategory Name',1,NULL,NULL,NULL),(276,'1','add_product','Add Product',1,NULL,NULL,NULL),(277,'1','barcode_symboloy','Barcode Symboloy',1,NULL,NULL,NULL),(278,'1','code_barcode_sku_upc_isbn','Code Barcode Sku Upc Isbn',1,NULL,NULL,NULL),(279,'1','product_quantity','Product Quantity',1,NULL,NULL,NULL),(280,'1','product_alert_quantity','Product Alert Quantity',1,NULL,NULL,NULL),(281,'1','product_description','Product Description',1,NULL,NULL,NULL),(282,'1','edit_product','Edit Product',1,NULL,NULL,NULL),(283,'1','view_check_in','View Check In',1,NULL,NULL,NULL),(284,'1','SL','SL',1,NULL,NULL,NULL),(285,'1','add_check_in','Add Check In',1,NULL,NULL,NULL),(286,'1','attachment','Attachment',1,NULL,NULL,NULL),(287,'1','check_in_note','Check In Note',1,NULL,NULL,NULL),(288,'1','search_and_select_product','Search And Select Product',1,NULL,NULL,NULL),(289,'1','available','Available',1,NULL,NULL,NULL),(290,'1','edit_check_in','Edit Check In',1,NULL,NULL,NULL),(291,'1','remove_item','Remove Item',1,NULL,NULL,NULL),(292,'1','view_check_out','View Check Out',1,NULL,NULL,NULL),(293,'1','add_check_out','Add Check Out',1,NULL,NULL,NULL),(294,'1','check_out_note','Check Out Note',1,NULL,NULL,NULL),(295,'1','select_and_search_products','Select And Search Products',1,NULL,NULL,NULL),(296,'1','edit_check_out','Edit Check Out',1,NULL,NULL,NULL),(297,'1','Subcategories','Subcategories',1,NULL,NULL,NULL),(298,'1','view_subcategory','View Subcategory',1,NULL,NULL,NULL),(299,'1','view_brand','View Brand',1,NULL,NULL,NULL),(300,'1','add_brand','Add Brand',1,NULL,NULL,NULL),(301,'1','edit_brand','Edit Brand',1,NULL,NULL,NULL),(302,'1','view_unit','View Unit',1,NULL,NULL,NULL),(303,'1','add_unit','Add Unit',1,NULL,NULL,NULL),(304,'1','edit_unit','Edit Unit',1,NULL,NULL,NULL),(305,'1','language_description','Language Description',1,NULL,NULL,NULL),(306,'1','add_new_definition','Add New Definition',1,NULL,NULL,NULL),(307,'1','definition_key','Definition Key',1,NULL,NULL,NULL),(308,'1','definition_value','Definition Value',1,NULL,NULL,NULL),(309,'1','view_employee','View Employee',1,NULL,NULL,NULL),(310,'1','is_active','Is Active',1,NULL,NULL,NULL),(311,'1','joining_date','Joining Date',1,NULL,NULL,NULL),(312,'1','leaving_date','Leaving Date',1,NULL,NULL,NULL),(313,'1','position','Position',1,NULL,NULL,NULL),(314,'1','salary','Salary',1,NULL,NULL,NULL),(315,'1','employees','Employees',1,NULL,NULL,NULL),(316,'1','edit_employee','Edit Employee',1,NULL,NULL,NULL),(317,'1','delete_employee','Delete Employee',1,NULL,NULL,NULL),(318,'1','paid_salary','Paid Salary',1,NULL,NULL,NULL),(319,'1','active','Active',1,NULL,NULL,NULL),(320,'1','inactive','Inactive',1,NULL,NULL,NULL),(321,'1','january','January',1,NULL,NULL,NULL),(322,'1','february','February',1,NULL,NULL,NULL),(323,'1','march','March',1,NULL,NULL,NULL),(324,'1','april','April',1,NULL,NULL,NULL),(325,'1','may','May',1,NULL,NULL,NULL),(326,'1','june','June',1,NULL,NULL,NULL),(327,'1','july','July',1,NULL,NULL,NULL),(328,'1','august','August',1,NULL,NULL,NULL),(329,'1','september','September',1,NULL,NULL,NULL),(330,'1','october','October',1,NULL,NULL,NULL),(331,'1','november','November',1,NULL,NULL,NULL),(332,'1','december','December',1,NULL,NULL,NULL),(333,'1','paid_salaries','Paid Salaries',1,NULL,NULL,NULL),(334,'1','total_paid','Total Paid',1,NULL,NULL,NULL),(335,'1','year','Year',1,NULL,NULL,NULL),(336,'1','month','Month',1,NULL,NULL,NULL),(337,'1','capital_deposited','Capital Deposited',1,NULL,NULL,NULL),(338,'1','capital_withdrawn','Capital Withdrawn',1,NULL,NULL,NULL),(339,'1','capital_balance','Capital Balance',1,NULL,NULL,NULL),(340,'1','sales_due','Sales Due',1,NULL,NULL,NULL),(341,'1','sales_amount','Sales Amount',1,NULL,NULL,NULL),(342,'1','received_amount','Received Amount',1,NULL,NULL,NULL),(343,'1','purchases_due','Purchases Due',1,NULL,NULL,NULL),(344,'1','expenses_amount','Expenses Amount',1,NULL,NULL,NULL),(345,'1','employee_salaries','Employee Salaries',1,NULL,NULL,NULL),(346,'1','total_employees','Total Employees',1,NULL,NULL,NULL),(347,'1','cash_available','Cash Available',1,NULL,NULL,NULL),(348,'1','customer_funds_deposits','Customer Funds Deposits',1,NULL,NULL,NULL),(349,'1','customer_funds_withdrawn','Customer Funds Withdrawn',1,NULL,NULL,NULL),(350,'1','customer_funds_balance','Customer Funds Balance',1,NULL,NULL,NULL),(351,'1','supplier_funds_deposit','Supplier Funds Deposit',1,NULL,NULL,NULL),(352,'1','supplier_funds_withdrawn','Supplier Funds Withdrawn',1,NULL,NULL,NULL),(353,'1','supplier_funds_balance','Supplier Funds Balance',1,NULL,NULL,NULL),(354,'1','funding_source','Funding Source',1,NULL,NULL,NULL),(355,'1','debit','Debit',1,NULL,NULL,NULL),(356,'1','credit','Credit',1,NULL,NULL,NULL),(357,'1','total_financial_report','Total Financial Report',1,NULL,NULL,NULL),(358,'1','total_selling_price','Total Selling Price',1,NULL,NULL,NULL),(359,'1','total_price','Total Price',1,NULL,NULL,NULL),(360,'1','total_buying_cost','Total Cost',1,NULL,NULL,NULL),(361,'1','total_cost','Total Cost',1,NULL,NULL,NULL),(362,'1','probable_profit_loss','Probable Profit & Loss',1,NULL,NULL,NULL),(363,'1','probable_profit','Probable Profit',1,NULL,NULL,NULL),(364,'1','view_sms','View SMS',1,NULL,NULL,NULL),(365,'1','sender','Sender',1,NULL,NULL,NULL),(366,'1','type','Type',1,NULL,NULL,NULL),(367,'1','provider','Provider',1,NULL,NULL,NULL),(368,'1','message','Message',1,NULL,NULL,NULL),(369,'1','delivery','Delivery',1,NULL,NULL,NULL),(370,'1','resend','Resend',1,NULL,NULL,NULL),(371,'1','subcategories','Subcategories',1,NULL,NULL,NULL),(372,'1','daily_transactions','Daily Transactions',1,NULL,NULL,NULL),(373,'1','transaction.income','Income',1,NULL,NULL,NULL),(374,'1','transaction.expense','Expense',1,NULL,NULL,NULL),(375,'1','transaction.customer_payments','Customer Payments',1,NULL,NULL,NULL),(376,'1','transaction.supplier_payments','Supplier Payments',1,NULL,NULL,NULL),(377,'1','exmployee_salaries','Employee Salary',1,NULL,NULL,NULL),(378,'1','exmployee','Employee',1,NULL,NULL,NULL),(379,'1','daily_expenses','Daily Expense',1,NULL,NULL,NULL),(380,'1','customer_sales_report','Customer-wise Sales Report',1,NULL,NULL,NULL),(381,'1','supplier_purchase_report','Supplier-wise Sales Report',1,NULL,NULL,NULL),(382,'1','daily_product_report','Daily Stock Report',1,NULL,NULL,NULL),(383,'1','purchases.paid','Paid',1,NULL,NULL,NULL),(384,'1','sales.paid','Paid',1,NULL,NULL,NULL),(385,'1','capital_deposit','Capital Deposit',1,NULL,NULL,NULL),(386,'1','capital_withdraw','Capital Withdraw',1,NULL,NULL,NULL),(387,'1','purchase_payment','Purchase Payment',1,NULL,NULL,NULL),(388,'1','purchase_return','Purchase Return',1,NULL,NULL,NULL),(389,'1','purchase_balance','Purchase Balance',1,NULL,NULL,NULL),(390,'1','sale_payment','Sale Payment',1,NULL,NULL,NULL),(391,'1','sale_return','Sale Return',1,NULL,NULL,NULL),(392,'1','sale_balance','Sale Balance',1,NULL,NULL,NULL),(393,'1','expense','Daily Expense',1,NULL,NULL,NULL),(394,'1','employee_salary','Employee Salary',1,NULL,NULL,NULL),(395,'1','capital.deposit','Deposit',1,NULL,NULL,NULL),(396,'1','capital.withdraw','Withdraw',1,NULL,NULL,NULL),(397,'1','capital_debit_credit','Capital Debit Credit',1,NULL,NULL,NULL),(398,'1','select_category','Select Category',1,NULL,NULL,NULL),(399,'1','sales_quantity','Sales Quantity',1,NULL,NULL,NULL),(400,'1','list_of_sales','List of Sales',1,NULL,NULL,NULL),(401,'1','purchases_quantity','Purchases Quantity',1,NULL,NULL,NULL),(402,'1','purchases_total','Purchases Total',1,NULL,NULL,NULL),(403,'1','purchases_returned','Purchases Returned',1,NULL,NULL,NULL),(404,'1','add_payment','Add Payment',1,NULL,NULL,NULL),(405,'1','returns_history','Returns History',1,NULL,NULL,NULL),(406,'1','more','More',1,NULL,NULL,NULL),(407,'1','check_users_ability','Check User\'s Ability',1,NULL,NULL,NULL),(408,'1','check_roles_ability','Check User\'s Ability',1,NULL,NULL,NULL),(409,'1','reports','Reports',1,NULL,NULL,NULL),(410,'1','product_report','Product Report',1,NULL,NULL,NULL),(411,'1','income_expense_report','Income / Expense Report',1,NULL,NULL,NULL),(412,'1','income','Income',1,NULL,NULL,NULL),(413,'1','reports.expense','Expense',1,NULL,NULL,NULL),(414,'1','time','Time',1,NULL,NULL,NULL),(415,'1','sl','SL',1,NULL,NULL,NULL),(416,'1','title','Title',1,NULL,NULL,NULL),(417,'1','short_financial_report','Short Financial Report',1,NULL,NULL,NULL),(418,'1','reports.addition','Addition',1,NULL,NULL,NULL),(419,'1','reports.current_stock','Current Stock',1,NULL,NULL,NULL),(420,'1','reports.subtraction','Subtraction',1,NULL,NULL,NULL),(421,'1','reports.remains','Remains',1,NULL,NULL,NULL),(422,'1','reports.stock','Stock',1,NULL,NULL,NULL),(423,'1','export_report','Export Report',1,NULL,NULL,NULL),(424,'1','deposit_payment','Deposit Payment',1,NULL,NULL,NULL),(425,'2','dashboard','ড্যাশবোর্ড',1,NULL,NULL,NULL),(426,'2','locale','আঞ্চলিকতা',1,NULL,NULL,NULL),(427,'2','user_management','ব্যবহারকারী ব্যবস্থাপনা',1,NULL,NULL,NULL),(428,'2','role_management','ভূমিকা ব্যবস্থাপনা',1,NULL,NULL,NULL),(429,'2','permission_management','অনুমতি ব্যবস্থাপনা',1,NULL,NULL,NULL),(430,'2','check_user_ability','ব্যবহারকারীর সক্ষমতা যাচাই',1,NULL,NULL,NULL),(431,'2','check_role_ability','ভূমিকা সক্ষমতা যাচাই',1,NULL,NULL,NULL),(432,'2','sales','বিক্রয়সমূহ',1,NULL,NULL,NULL),(433,'2','new_sale','নতুন বিক্রয়',1,NULL,NULL,NULL),(434,'2','list_sales','বিক্রয়ের তালিকা',1,NULL,NULL,NULL),(435,'2','purchases','ক্রয়সমূহ',1,NULL,NULL,NULL),(436,'2','new_purchase','নতুন ক্রয়',1,NULL,NULL,NULL),(437,'2','list_purchases','ক্রয়ের তালিকা',1,NULL,NULL,NULL),(438,'2','contacts','মানবসম্পদ',1,NULL,NULL,NULL),(439,'2','customers','গ্রাহকের তালিকা',1,NULL,NULL,NULL),(440,'2','suppliers','সরবরাহকারীর তালিকা',1,NULL,NULL,NULL),(441,'2','balance_sheet','ব্যালান্স শিট',1,NULL,NULL,NULL),(442,'2','customers_balance','ক্রেতার আর্থিক ব্যালান্স',1,NULL,NULL,NULL),(443,'2','suppliers_balance','সরবরাহকারীর আর্থিক ব্যালান্স',1,NULL,NULL,NULL),(444,'2','capital_funds','মূলধন ব্যালান্স',1,NULL,NULL,NULL),(445,'2','balance','জের',1,NULL,NULL,NULL),(446,'2','capital','মূলধন',1,NULL,NULL,NULL),(447,'2','purchase_amount','ক্রয়মূল্য',1,NULL,NULL,NULL),(448,'2','purchase_payable','মোট ক্রয়',1,NULL,NULL,NULL),(449,'2','sale_amount','বিক্রয়মূল্য',1,NULL,NULL,NULL),(450,'2','others','অন্যান্য',1,NULL,NULL,NULL),(451,'2','remaining','অবশিষ্ট',1,NULL,NULL,NULL),(452,'2','previous_balance','পূর্বের জের',1,NULL,NULL,NULL),(453,'2','current_balance','বর্তমান জের',1,NULL,NULL,NULL),(454,'2','deposits','জমা',1,NULL,NULL,NULL),(455,'2','withdraws','উত্তোলন',1,NULL,NULL,NULL),(456,'2','expenses','খরচের তালিকা',1,NULL,NULL,NULL),(457,'2','list','তালিকা',1,NULL,NULL,NULL),(458,'2','code','কোড',1,NULL,NULL,NULL),(459,'2','cost','ক্রয়মূল্য',1,NULL,NULL,NULL),(460,'2','price','বিক্রয়মূল্য',1,NULL,NULL,NULL),(461,'2','sales.price','দর',1,NULL,NULL,NULL),(462,'2','barcode_symbology','বারকোডের ধরণ',1,NULL,NULL,NULL),(463,'2','brand','ব্র্যান্ড',1,NULL,NULL,NULL),(464,'2','brand_name','ব্র্যান্ডের নাম',1,NULL,NULL,NULL),(465,'2','category','বিভাগ',1,NULL,NULL,NULL),(466,'2','category_name','বিভাগের নাম',1,NULL,NULL,NULL),(467,'2','sub_category','উপবিভাগ',1,NULL,NULL,NULL),(468,'2','sub_category_name','আন্তবিভাগের নাম',1,NULL,NULL,NULL),(469,'2','unit','একক',1,NULL,NULL,NULL),(470,'2','unit_name','এককের নাম',1,NULL,NULL,NULL),(471,'2','status','অবস্থা',1,NULL,NULL,NULL),(472,'2','quantity','সংখ্যা',1,NULL,NULL,NULL),(473,'2','alert_quantity','সতর্কতার পরিমান',1,NULL,NULL,NULL),(474,'2','view_product','পণ্যের বিবরণ',1,NULL,NULL,NULL),(475,'2','select_product','পণ্য বাছাই করুন',1,NULL,NULL,NULL),(476,'2','cart_details','ক্রয়ের/বিক্রয়ের বিবরণ',1,NULL,NULL,NULL),(477,'2','created_by','প্রস্তুতকারী',1,NULL,NULL,NULL),(478,'2','datetime','সময় ও তারিখ',1,NULL,NULL,NULL),(479,'2','reference','রেফারেন্স',1,NULL,NULL,NULL),(480,'2','supplier','সরবরাহকারি',1,NULL,NULL,NULL),(481,'2','note','নোট',1,NULL,NULL,NULL),(482,'2','amount','অর্থের পরিমান',1,NULL,NULL,NULL),(483,'2','taken_by','গ্রহণকারী',1,NULL,NULL,NULL),(484,'2','total_deposit','সোট জমা',1,NULL,NULL,NULL),(485,'2','total_withdrawals','মোট উত্তোলন',1,NULL,NULL,NULL),(486,'2','overview','সারসংক্ষেপ',1,NULL,NULL,NULL),(487,'2','funding_overview','আর্থিক বিবরণ',1,NULL,NULL,NULL),(488,'2','deposit_amount','আমানত অর্থের পরিমান',1,NULL,NULL,NULL),(489,'2','withdrawal_amount','উত্তোলিত অর্থের পরিমান',1,NULL,NULL,NULL),(490,'2','payment_amount','অর্থের পরিমাণ',1,NULL,NULL,NULL),(491,'2','sales.payment_amount','জমা',1,NULL,NULL,NULL),(492,'2','employment_salaries.payment_amount','প্রদত্ত অর্থ',1,NULL,NULL,NULL),(493,'2','payment_method','পরিশোধের মাধ্যম',1,NULL,NULL,NULL),(494,'2','bank','ব্যাংক',1,NULL,NULL,NULL),(495,'2','check_no','চেক নং',1,NULL,NULL,NULL),(496,'2','transaction_no','লেনদেন নং',1,NULL,NULL,NULL),(497,'2','customer_balance_sheet','ক্গ্রাহকের আর্থিক হিসাবনিকাশ',1,NULL,NULL,NULL),(498,'2','company','কোম্পানি',1,NULL,NULL,NULL),(499,'2','district','জেলা',1,NULL,NULL,NULL),(500,'2','deposit','বিনিয়োগ',1,NULL,NULL,NULL),(501,'2','withdrawn','উত্তোলন',1,NULL,NULL,NULL),(502,'2','payable','মোট',1,NULL,NULL,NULL),(503,'2','sales.payable','মোট',1,NULL,NULL,NULL),(504,'2','paid','পরিশোধিত',1,NULL,NULL,NULL),(505,'2','customers.paid','জমা',1,NULL,NULL,NULL),(506,'2','method','মাধ্যম',1,NULL,NULL,NULL),(507,'2','suppliers.paid','জমা',1,NULL,NULL,NULL),(508,'2','final_balance','সামগ্রিক আর্থিক হিসাবনিকাশ',1,NULL,NULL,NULL),(509,'2','village','গ্রাম',1,NULL,NULL,NULL),(510,'2','thana','থানা',1,NULL,NULL,NULL),(511,'2','post_office','ডাকঘর.',1,NULL,NULL,NULL),(512,'2','funds_balance','আর্থিক হিসাবনিকাশ',1,NULL,NULL,NULL),(513,'2','categories','বিভাগসমূহ',1,NULL,NULL,NULL),(514,'2','sub_categories','আন্তবিভাগসমূহ',1,NULL,NULL,NULL),(515,'2','brands','ব্রান্ডের তালিকা',1,NULL,NULL,NULL),(516,'2','units','এককসমূহ',1,NULL,NULL,NULL),(517,'2','main_inventory','পণ্য তালিকা',1,NULL,NULL,NULL),(518,'2','products','পণ্যের তালিকা',1,NULL,NULL,NULL),(519,'2','product_id','পণ্যের আইডি',1,NULL,NULL,NULL),(520,'2','send_salary','বেতন প্রদান করুন',1,NULL,NULL,NULL),(521,'2','check_ins','চেক-ইন সমূহ',1,NULL,NULL,NULL),(522,'2','check_outs','চেক-আউট সমূহ',1,NULL,NULL,NULL),(523,'2','settings','সেটিংস',1,NULL,NULL,NULL),(524,'2','languages','ভাষাসমূহ',1,NULL,NULL,NULL),(525,'2','add_language','নতুন ভাষা',1,NULL,NULL,NULL),(526,'2','edit_language','ভাষা সম্পাদন',1,NULL,NULL,NULL),(527,'2','view_language','ভাষা বিবরণ',1,NULL,NULL,NULL),(528,'2','delete_language','ভাষা মুছুন',1,NULL,NULL,NULL),(529,'2','definitions','অনুবাদসমূহ',1,NULL,NULL,NULL),(530,'2','preferences','পছন্দসমূহ',1,NULL,NULL,NULL),(531,'2','address','ঠিকানা',1,NULL,NULL,NULL),(532,'2','currency','মুদ্রা',1,NULL,NULL,NULL),(533,'2','default_customer','ডিফল্ট ক্রেতা',1,NULL,NULL,NULL),(534,'2','default_discount','ডিফল্ট ছাড়ের পরিমান',1,NULL,NULL,NULL),(535,'2','default_tax','ডিফল্ট ট্যাক্সের পরিমান',1,NULL,NULL,NULL),(536,'2','email','ইমেইল',1,NULL,NULL,NULL),(537,'2','language','ভাষা',1,NULL,NULL,NULL),(538,'2','logo','লোগো',1,NULL,NULL,NULL),(539,'2','phone','ফোন',1,NULL,NULL,NULL),(540,'2','send_sms_after_order','অর্ডার সম্পন্নের পর এসএমএস (ক্ষুদ্রবার্তা) পাঠাবেন?',1,NULL,NULL,NULL),(541,'2','send_sms_after_sale','বিক্রয় সম্পন্নের পর এসএমএস (ক্ষুদ্রবার্তা) পাঠাবেন?',1,NULL,NULL,NULL),(542,'2','site_name','সাইটের নাম',1,NULL,NULL,NULL),(543,'2','timezone','সময় অঞ্চল',1,NULL,NULL,NULL),(544,'2','are_you_sure','আপনি কি নিশ্চিত?',1,NULL,NULL,NULL),(545,'2','name','নাম',1,NULL,NULL,NULL),(546,'2','photo','ছবি',1,NULL,NULL,NULL),(547,'2','key','শিরোনাম',1,NULL,NULL,NULL),(548,'2','action','ক্রিয়া',1,NULL,NULL,NULL),(549,'2','value','মান',1,NULL,NULL,NULL),(550,'2','description','বর্ণনা',1,NULL,NULL,NULL),(551,'2','created_at','তৈরির সময়',1,NULL,NULL,NULL),(552,'2','updated_at','সম্পাদনের সময়',1,NULL,NULL,NULL),(553,'2','submit','সাবমিট',1,NULL,NULL,NULL),(554,'2','roles','ব্যবহারকারী ভূমিকা',1,NULL,NULL,NULL),(555,'2','permissions','ব্যবহারকারী অনুমতিসমূহ',1,NULL,NULL,NULL),(556,'2','user_abilities','ব্যবহারকারীর সক্ষমতা',1,NULL,NULL,NULL),(557,'2','role_abilities','রোল সক্ষমতা',1,NULL,NULL,NULL),(558,'2','add_edit_user','ব্যবহারকারী যুক্ত / সম্পাদন',1,NULL,NULL,NULL),(559,'2','view_user','ব্যবহারকারীর বিবরণ',1,NULL,NULL,NULL),(560,'2','add','নতুন',1,NULL,NULL,NULL),(561,'2','id','আইডি',1,NULL,NULL,NULL),(562,'2','per_page','প্রতিপেজে',1,NULL,NULL,NULL),(563,'2','type_and_hit_enter_to_search_the_table','টাইপ করে ইন্টার বাটন চাপুন , রিসেট করার জন্য  ESC চাপুন',1,NULL,NULL,NULL),(564,'2','columns','কলামসমূহ',1,NULL,NULL,NULL),(565,'2','no_items_found','কোনো আইটেম খুঁজে পাওয়া যায়নি',1,NULL,NULL,NULL),(566,'2','view_role','ব্যবহারকারীর ভূমিকা',1,NULL,NULL,NULL),(567,'2','guard','Guard',1,NULL,NULL,NULL),(568,'2','add_edit_permission','Permission যুক্ত / সম্পাদন',1,NULL,NULL,NULL),(569,'2','view_permission','Permission এর বিবরণ',1,NULL,NULL,NULL),(570,'2','assigned_roles','অর্পিত ভূমিকা',1,NULL,NULL,NULL),(571,'2','assigned_users','নির্ধারিত ব্যবহারকারী',1,NULL,NULL,NULL),(572,'2','search_users','Search Users',1,NULL,NULL,NULL),(573,'2','type_and_search_user','ব্যবহারকারীদের অনুসন্ধান করুন',1,NULL,NULL,NULL),(574,'2','search_permissions','Permission অনুসন্ধান করুন',1,NULL,NULL,NULL),(575,'2','type_and_search_permission','টাইপ এবং অনুমতি অনুসন্ধান করুন',1,NULL,NULL,NULL),(576,'2','reset','রিসেট করুন',1,NULL,NULL,NULL),(577,'2','search_roles','ভূমিকা অনুসন্ধান করুন',1,NULL,NULL,NULL),(578,'2','type_and_search_role','ভূমিকা অনুসন্ধান করুন',1,NULL,NULL,NULL),(579,'2','email_verified_at','ইমেল যাচাইয়ের সময়',1,NULL,NULL,NULL),(580,'2','email_address','ইমেল ঠিকানা',1,NULL,NULL,NULL),(581,'2','password','পাসওয়ার্ড',1,NULL,NULL,NULL),(582,'2','please_select_an_option','একটি অপশন নির্বাচন করুন',1,NULL,NULL,NULL),(583,'2','click_to_remove','বাদ দেওয়ার জন্য ক্লিক করুন',1,NULL,NULL,NULL),(584,'2','guard_name','Guard Name',1,NULL,NULL,NULL),(585,'2','revoke_user','ব্যবহারকারী প্রত্যাহার করুন',1,NULL,NULL,NULL),(586,'2','detach','বিচ্ছিন্ন করুন',1,NULL,NULL,NULL),(587,'2','allowed','অনুমোদিত',1,NULL,NULL,NULL),(588,'2','users','ব্যবহারকারীসমূহ',1,NULL,NULL,NULL),(589,'2','selected_users','নির্বাচিত ব্যবহারকারী',1,NULL,NULL,NULL),(590,'2','search_and_assign_roles','খুজুন এবং ভূমিকা নির্ধারণ করুন',1,NULL,NULL,NULL),(591,'2','search_and_assign_users','খুজুন এবং ব্যবহারকারী নির্ধারণ করুন',1,NULL,NULL,NULL),(592,'2','cash','নগদ',1,NULL,NULL,NULL),(593,'2','card','কার্ড',1,NULL,NULL,NULL),(594,'2','bkash','বিকাশ',1,NULL,NULL,NULL),(595,'2','rocket','রকেট',1,NULL,NULL,NULL),(596,'2','customer','ক্রেতা',1,NULL,NULL,NULL),(597,'2','date','তারিখ',1,NULL,NULL,NULL),(598,'2','returned','ফেরত',1,NULL,NULL,NULL),(599,'2','returned_total','মোট ফেরত',1,NULL,NULL,NULL),(600,'2','returned_quantity','ফেরতের পরিমাণ',1,NULL,NULL,NULL),(601,'2','processed','প্রক্রিয়াজাত',1,NULL,NULL,NULL),(602,'2','cancelled','বাতিল করা হয়েছে',1,NULL,NULL,NULL),(603,'2','full','সম্পূর্ণ',1,NULL,NULL,NULL),(604,'2','tax','কর',1,NULL,NULL,NULL),(605,'2','discount','ছাড়',1,NULL,NULL,NULL),(606,'2','total','মোট',1,NULL,NULL,NULL),(607,'2','sales_note','বিক্রয় নোট',1,NULL,NULL,NULL),(608,'2','pid','PID',1,NULL,NULL,NULL),(609,'2','not_selected','অনির্বাচিত',1,NULL,NULL,NULL),(610,'2','history','ইতিহাস',1,NULL,NULL,NULL),(611,'2','take_payment','পেমেন্ট নিন',1,NULL,NULL,NULL),(612,'2','payment_history','অর্থ প্রদান ইতিহাস',1,NULL,NULL,NULL),(613,'2','view_sale_history','বিক্রয় বিবরণ দেখুন',1,NULL,NULL,NULL),(614,'2','edit_the_sale','বিক্রয় সম্পাদনা করুন',1,NULL,NULL,NULL),(615,'2','delete_the_sale','বিক্রয় মুছুন',1,NULL,NULL,NULL),(616,'2','check','চেক',1,NULL,NULL,NULL),(617,'2','customer_id','গ্রাহক আইডি',1,NULL,NULL,NULL),(618,'2','supplier_name','সরবরাহকারী নাম',1,NULL,NULL,NULL),(619,'2','payment_is_completed_for_this_sale','এই বিক্রয়টির জন্য অর্থ প্রদান সম্পন্ন হয়েছে। আর কোনও পদক্ষেপের প্রয়োজন নেই।',1,NULL,NULL,NULL),(620,'2','view_sale','বিক্রয় দেখুন',1,NULL,NULL,NULL),(621,'2','customer_details','কাস্টমার বিস্তারিত',1,NULL,NULL,NULL),(622,'2','sale_items','বিক্রয় আইটেম',1,NULL,NULL,NULL),(623,'2','sale_id','বিক্রয় আইডি',1,NULL,NULL,NULL),(624,'2','product_name','পণ্যের নাম',1,NULL,NULL,NULL),(625,'2','shipping_address','প্রেরণের ঠিকানা',1,NULL,NULL,NULL),(626,'2','deleted_at','ডিলিটের সময়',1,NULL,NULL,NULL),(627,'2','ok','ঠিক আছে',1,NULL,NULL,NULL),(628,'2','cancel','বাতিল',1,NULL,NULL,NULL),(629,'2','purchase_note','ক্রয় নোট',1,NULL,NULL,NULL),(630,'2','list_of_purchases','ক্রয়ের তালিকা',1,NULL,NULL,NULL),(631,'2','view_purchase_history','ক্রয়ের বিবরণ দেখুন',1,NULL,NULL,NULL),(632,'2','edit_the_purchase','ক্রয় সম্পাদনা করুন',1,NULL,NULL,NULL),(633,'2','delete_the_purchase','ক্রয় মুছুন',1,NULL,NULL,NULL),(634,'2','payment_is_completed_for_this_purchase','এই ক্রয়ের জন্য অর্থ প্রদান সম্পন্ন হয়েছে। আর কোনও পদক্ষেপের প্রয়োজন নেই।',1,NULL,NULL,NULL),(635,'2','given_by','প্রদানকারী',1,NULL,NULL,NULL),(636,'2','supplier_id','সরবরাহকারী আইডি',1,NULL,NULL,NULL),(637,'2','view_purchase','ক্রয় দেখুন',1,NULL,NULL,NULL),(638,'2','supplier_details','সরবরাহকারী বিবরণ',1,NULL,NULL,NULL),(639,'2','purchase_id','ক্রয় আইডি',1,NULL,NULL,NULL),(640,'2','add_fund','তহবিল যুক্ত করুন',1,NULL,NULL,NULL),(641,'2','view','দেখুন',1,NULL,NULL,NULL),(642,'2','view_customer','গ্রাহক দেখুন',1,NULL,NULL,NULL),(643,'2','edit','সম্পাদনা করুন',1,NULL,NULL,NULL),(644,'2','edit_customer','গ্রাহক সম্পাদনা করুন',1,NULL,NULL,NULL),(645,'2','delete','মুছুন',1,NULL,NULL,NULL),(646,'2','delete_customer','গ্রাহক মুছুন',1,NULL,NULL,NULL),(647,'2','add_customer','গ্রাহক যুক্ত করুন',1,NULL,NULL,NULL),(648,'2','phone_number','ফোন নম্বর',1,NULL,NULL,NULL),(649,'2','withdrawn_amount','উত্তোলনের পরিমাণ',1,NULL,NULL,NULL),(650,'2','sales_payable','মোট বিক্রিয়',1,NULL,NULL,NULL),(651,'2','sales_paid','বিক্রয়মূল্য পরিশোধ',1,NULL,NULL,NULL),(652,'2','sales_returned','বিক্রিত পণ্য ফেরত',1,NULL,NULL,NULL),(653,'2','sales_balance','বিক্রয়মূল্য জের',1,NULL,NULL,NULL),(654,'2','view_supplier','সরবরাহকারী দেখুন',1,NULL,NULL,NULL),(655,'2','purchases_payable','ক্রয়মূল্য প্রদেয়',1,NULL,NULL,NULL),(656,'2','total_purchases','মোট ক্রয়',1,NULL,NULL,NULL),(657,'2','purchases_paid','পরিশোধিত ক্রয়মূল্য',1,NULL,NULL,NULL),(658,'2','purchases_balance','ক্রয়মূল্য জের',1,NULL,NULL,NULL),(659,'2','total_purchased_amount','ক্রয়কৃত পণ্যের মূল্য',1,NULL,NULL,NULL),(660,'2','add_more_fund','আরও তহবিল যুক্ত করুন',1,NULL,NULL,NULL),(661,'2','make_due_sales_payment_from_available_fund','অবশিষ্ট তহবিল থেকে বিক্রয় অর্থ প্রদান করুন',1,NULL,NULL,NULL),(662,'2','make_due_payments','বকেয়া অর্থ প্রদান করুন',1,NULL,NULL,NULL),(663,'2','customer_name','ক্রেতার নাম',1,NULL,NULL,NULL),(664,'2','available_funds','অবশিষ্ট তহবিল',1,NULL,NULL,NULL),(665,'2','supplier_balance_sheet','সরবরাহকারী ব্যালেন্স শীট',1,NULL,NULL,NULL),(666,'2','due_purchases','বকেয়া ক্রয়',1,NULL,NULL,NULL),(667,'2','make_due_purchase_payment_from_available_fund','অবশিষ্ট তহবিল থেকে ক্রয় অর্থ প্রদান করুন',1,NULL,NULL,NULL),(668,'2','funds','তহবিল',1,NULL,NULL,NULL),(669,'2','capital_deposits','মূলধন আমানত',1,NULL,NULL,NULL),(670,'2','capital_withdraws','মূলধন উত্তোলন',1,NULL,NULL,NULL),(671,'2','total_number_of_withdrawals','উত্তোলনের মোট সংখ্যা',1,NULL,NULL,NULL),(672,'2','total_withdrawal_amount','মোট উত্তোলিত অর্থ',1,NULL,NULL,NULL),(673,'2','view_deposit_details','আমানতের/জমার বিস্তারিত দেখুন',1,NULL,NULL,NULL),(674,'2','deposited_by','আমানত প্রদানকারী',1,NULL,NULL,NULL),(675,'2','deposit_method','জমা প্রদান মাধ্যম',1,NULL,NULL,NULL),(676,'2','edit_fund','তহবিল সম্পাদনা করুন',1,NULL,NULL,NULL),(677,'2','view_withdrawal_details','উত্তোলনের বিবরণ দেখুন',1,NULL,NULL,NULL),(678,'2','withdrawn_by','উত্তোলনকারী',1,NULL,NULL,NULL),(679,'2','withdraw_method','উত্তোলন মাধ্যম',1,NULL,NULL,NULL),(680,'2','total_expense_amount','মোট খরচ',1,NULL,NULL,NULL),(681,'2','total_expense_quantity','মোট খরচের সংখ্যা',1,NULL,NULL,NULL),(682,'2','view_expense','ব্যয় দেখুন',1,NULL,NULL,NULL),(683,'2','expense_category_id','ব্যয় বিভাগের আইডি',1,NULL,NULL,NULL),(684,'2','expense_categories','খরচ বিভাগের তালিকা',1,NULL,NULL,NULL),(685,'2','expense_category_name','ব্যয় বিভাগের নাম',1,NULL,NULL,NULL),(686,'2','taken_by_name','গ্রহণকারীর নাম',1,NULL,NULL,NULL),(687,'2','add_expense','ব্যয় যুক্ত করুন',1,NULL,NULL,NULL),(688,'2','expense_category','ব্যয় বিভাগ',1,NULL,NULL,NULL),(689,'2','expense_amount','ব্যয়ের পরিমাণ',1,NULL,NULL,NULL),(690,'2','expense_reference','ব্যয় রেফারেন্স',1,NULL,NULL,NULL),(691,'2','edit_expense','ব্যয় সম্পাদনা করুন',1,NULL,NULL,NULL),(692,'2','view_category','বিভাগ দেখুন',1,NULL,NULL,NULL),(693,'2','add _category','বিভাগ যুক্ত করুন',1,NULL,NULL,NULL),(694,'2','edit_category','বিভাগ সম্পাদনা করুন',1,NULL,NULL,NULL),(695,'2','category_id','বিভাগ আইডি',1,NULL,NULL,NULL),(696,'2','subcategory_id','উপবিভাগ আইডি',1,NULL,NULL,NULL),(697,'2','brand_id','ব্র্যান্ড আইডি',1,NULL,NULL,NULL),(698,'2','unit_id','একক আইডি',1,NULL,NULL,NULL),(699,'2','subcategory_name','উপবিভাগ',1,NULL,NULL,NULL),(700,'2','add_product','পণ্য যুক্ত করুন',1,NULL,NULL,NULL),(701,'2','barcode_symboloy','বারকোড সিম্বোলজি',1,NULL,NULL,NULL),(702,'2','code_barcode_sku_upc_isbn','কোড (বারকোড / এসকিউ / ইউপিসি / আইএসবিএন)',1,NULL,NULL,NULL),(703,'2','product_quantity','পণ্যের পরিমাণ',1,NULL,NULL,NULL),(704,'2','product_alert_quantity','পণ্য সতর্কতা পরিমাণ',1,NULL,NULL,NULL),(705,'2','product_description','পণ্যের বর্ণনা',1,NULL,NULL,NULL),(706,'2','edit_product','পণ্য সম্পাদনা করুন',1,NULL,NULL,NULL),(707,'2','view_check_in','চেক ইন দেখুন',1,NULL,NULL,NULL),(708,'2','SL','ক্র:নং',1,NULL,NULL,NULL),(709,'2','add_check_in','চেক ইন যোগ করুন',1,NULL,NULL,NULL),(710,'2','attachment','সংযুক্তি',1,NULL,NULL,NULL),(711,'2','check_in_note','চেক ইন নোট',1,NULL,NULL,NULL),(712,'2','search_and_select_product','অনুসন্ধান করে পণ্য নির্বাচন করুন',1,NULL,NULL,NULL),(713,'2','available','অবশিষ্ট',1,NULL,NULL,NULL),(714,'2','edit_check_in','চেক ইন সম্পাদন',1,NULL,NULL,NULL),(715,'2','remove_item','আইটেম বাদ দিন',1,NULL,NULL,NULL),(716,'2','view_check_out','চেক আউট দেখুন',1,NULL,NULL,NULL),(717,'2','add_check_out','নতুন চেক আউট',1,NULL,NULL,NULL),(718,'2','check_out_note','চেক আউট নোট',1,NULL,NULL,NULL),(719,'2','select_and_search_products','অনুসন্ধান করে পণ্য নির্বাচন করুন',1,NULL,NULL,NULL),(720,'2','edit_check_out','চেক আউট সম্পাদন',1,NULL,NULL,NULL),(721,'2','Subcategories','উপবিভাগসমূহ',1,NULL,NULL,NULL),(722,'2','view_subcategory','উপবিভাগ দেখুন',1,NULL,NULL,NULL),(723,'2','view_brand','ব্র্যান্ড দেখুন',1,NULL,NULL,NULL),(724,'2','add_brand','নতুন ব্র্যান্ড',1,NULL,NULL,NULL),(725,'2','edit_brand','ব্র্যান্ড সম্পাদন করুন',1,NULL,NULL,NULL),(726,'2','view_unit','একক দেখুন',1,NULL,NULL,NULL),(727,'2','add_unit','নতুন একক',1,NULL,NULL,NULL),(728,'2','edit_unit','একক সম্পাদন করুন',1,NULL,NULL,NULL),(729,'2','language_description','ভাষার বর্ণনা',1,NULL,NULL,NULL),(730,'2','add_new_definition','নতুন অনুবাদ যুক্ত করুন',1,NULL,NULL,NULL),(731,'2','definition_key','অনুবাদ চাবি',1,NULL,NULL,NULL),(732,'2','definition_value','অনুবাদ',1,NULL,NULL,NULL),(733,'2','view_employee','বিস্তারিত দেখুন',1,NULL,NULL,NULL),(734,'2','is_active','সক্রিয়?',1,NULL,NULL,NULL),(735,'2','joining_date','যোগদানের তারিখ',1,NULL,NULL,NULL),(736,'2','leaving_date','ছাড়ার তারিখ',1,NULL,NULL,NULL),(737,'2','position','পদ',1,NULL,NULL,NULL),(738,'2','salary','বেতন',1,NULL,NULL,NULL),(739,'2','employees','কর্মী তালিকা',1,NULL,NULL,NULL),(740,'2','edit_employee','সম্পাদন করুন',1,NULL,NULL,NULL),(741,'2','delete_employee','কর্মচারী মুছুন',1,NULL,NULL,NULL),(742,'2','paid_salary','পরিশোধিত বেতন',1,NULL,NULL,NULL),(743,'2','active','সক্রিয়',1,NULL,NULL,NULL),(744,'2','inactive','নিষ্ক্রিয়',1,NULL,NULL,NULL),(745,'2','january','জানুয়ারী',1,NULL,NULL,NULL),(746,'2','february','ফেব্রুয়ারী',1,NULL,NULL,NULL),(747,'2','march','মার্চ',1,NULL,NULL,NULL),(748,'2','april','এপ্রিল',1,NULL,NULL,NULL),(749,'2','may','মে',1,NULL,NULL,NULL),(750,'2','june','জুন',1,NULL,NULL,NULL),(751,'2','july','জুলাই',1,NULL,NULL,NULL),(752,'2','august','আগস্ট',1,NULL,NULL,NULL),(753,'2','september','সেপ্টেম্বর',1,NULL,NULL,NULL),(754,'2','october','অক্টোবর',1,NULL,NULL,NULL),(755,'2','november','নভেম্বর',1,NULL,NULL,NULL),(756,'2','december','ডিসেম্বর',1,NULL,NULL,NULL),(757,'2','paid_salaries','পরিশোধিত বেতনের তালিকা',1,NULL,NULL,NULL),(758,'2','total_paid','মোট পরিশোধিত অর্থ',1,NULL,NULL,NULL),(759,'2','year','বর্ষ',1,NULL,NULL,NULL),(760,'2','month','মাস',1,NULL,NULL,NULL),(761,'2','capital_deposited','মূলধন আমানত',1,NULL,NULL,NULL),(762,'2','capital_withdrawn','মূলধন প্রত্যাহার',1,NULL,NULL,NULL),(763,'2','capital_balance','মূলধন ব্যালেন্স',1,NULL,NULL,NULL),(764,'2','sales_due','বকেয়া বিক্রয়',1,NULL,NULL,NULL),(765,'2','sales_amount','বিক্রয়য়ের পরিমাণ',1,NULL,NULL,NULL),(766,'2','received_amount','আদায়কৃত অর্থ',1,NULL,NULL,NULL),(767,'2','purchases_due','বকেয়া ক্রয়',1,NULL,NULL,NULL),(768,'2','expenses_amount','ব্যয়ের পরিমাণ',1,NULL,NULL,NULL),(769,'2','employee_salaries','কর্মচারীদের বেতন',1,NULL,NULL,NULL),(770,'2','total_employees','মোট কর্মকর্তা/কর্মচারী',1,NULL,NULL,NULL),(771,'2','cash_available','নগদ অর্থ',1,NULL,NULL,NULL),(772,'2','customer_funds_deposits','গ্রাহক তহবিল জমা',1,NULL,NULL,NULL),(773,'2','customer_funds_withdrawn','গ্রাহক তহবিল উত্তোলন',1,NULL,NULL,NULL),(774,'2','customer_funds_balance','গ্রাহক তহবিলের ভারসাম্য',1,NULL,NULL,NULL),(775,'2','supplier_funds_deposit','সরবরাহকারী তহবিল জমা',1,NULL,NULL,NULL),(776,'2','supplier_funds_withdrawn','সরবরাহকারী তহবিল উত্তোলন',1,NULL,NULL,NULL),(777,'2','supplier_funds_balance','সরবরাহকারী তহবিলের ভারসাম্য',1,NULL,NULL,NULL),(778,'2','funding_source','তহবিলের উৎস',1,NULL,NULL,NULL),(779,'2','debit','ডেবিট',1,NULL,NULL,NULL),(780,'2','credit','ক্রেডিট',1,NULL,NULL,NULL),(781,'2','total_financial_report','মোট আর্থিক প্রতিবেদন',1,NULL,NULL,NULL),(782,'2','total_selling_price','মোট বিক্রয়মূল্য',1,NULL,NULL,NULL),(783,'2','total_price','মোট বিক্রয়মূল্য',1,NULL,NULL,NULL),(784,'2','total_buying_cost','মোট ক্রয়মূল্য',1,NULL,NULL,NULL),(785,'2','total_cost','মোট ক্রয়মূল্য',1,NULL,NULL,NULL),(786,'2','probable_profit_loss','সম্ভাব্য লাভ এবং ক্ষতি',1,NULL,NULL,NULL),(787,'2','probable_profit','সম্ভাব্য লাভ',1,NULL,NULL,NULL),(788,'2','view_sms','এসএমএস দেখুন',1,NULL,NULL,NULL),(789,'2','sender','প্রেরক',1,NULL,NULL,NULL),(790,'2','type','ধরণ',1,NULL,NULL,NULL),(791,'2','provider','বার্তাবাহক',1,NULL,NULL,NULL),(792,'2','message','বার্তা',1,NULL,NULL,NULL),(793,'2','delivery','ডেলিভারি',1,NULL,NULL,NULL),(794,'2','resend','পুনরায় পাঠান',1,NULL,NULL,NULL),(795,'2','subcategories','উপবিভাগসমুহ',1,NULL,NULL,NULL),(796,'2','daily_transactions','দৈনিক লেনদেন',1,NULL,NULL,NULL),(797,'2','transaction.income','জমা',1,NULL,NULL,NULL),(798,'2','transaction.expense','খরচ',1,NULL,NULL,NULL),(799,'2','transaction.customer_payments','বকেয়া আদায়',1,NULL,NULL,NULL),(800,'2','transaction.supplier_payments','বকেয়া প্রদান',1,NULL,NULL,NULL),(801,'2','exmployee_salaries','কর্মকর্তা/কর্মচারীর বেতন',1,NULL,NULL,NULL),(802,'2','exmployee','কর্মকর্তা/কর্মচারীর নাম',1,NULL,NULL,NULL),(803,'2','daily_expenses','দৈনিক খরচ',1,NULL,NULL,NULL),(804,'2','customer_sales_report','ক্রেতা অনুযায়ী বিক্রয় রিপোর্ট',1,NULL,NULL,NULL),(805,'2','supplier_purchase_report','সরবরাহকারী অনুযায়ী ক্রয় রিপোর্ট',1,NULL,NULL,NULL),(806,'2','daily_product_report','দৈনিক পণ্য জমা-খরচ রিপোর্ট',1,NULL,NULL,NULL),(807,'2','purchases.paid','জমা',1,NULL,NULL,NULL),(808,'2','sales.paid','জমা',1,NULL,NULL,NULL),(809,'2','capital_deposit','মূলধন জমা',1,NULL,NULL,NULL),(810,'2','capital_withdraw','মূলধন উত্তোলন',1,NULL,NULL,NULL),(811,'2','purchase_payment','বকেয়া পরিশোধ',1,NULL,NULL,NULL),(812,'2','purchase_return','ক্রয়কৃত মাল ফেরত',1,NULL,NULL,NULL),(813,'2','purchase_balance','ক্রয় জের',1,NULL,NULL,NULL),(814,'2','sale_payment','বকেয়া আদায়',1,NULL,NULL,NULL),(815,'2','sale_return','বিক্রিত মাল ফেরত',1,NULL,NULL,NULL),(816,'2','sale_balance','বিক্রয় জের',1,NULL,NULL,NULL),(817,'2','expense','দৈনিক খরচ',1,NULL,NULL,NULL),(818,'2','employee_salary','কর্মকর্তা/কর্মচারী বেতন',1,NULL,NULL,NULL),(819,'2','capital.deposit','জমা',1,NULL,NULL,NULL),(820,'2','capital.withdraw','উত্তোলন',1,NULL,NULL,NULL),(821,'2','capital_debit_credit','মূলধন জমা ও উত্তোলন',1,NULL,NULL,NULL),(822,'2','select_category','বিভাগ বাছাই করুন',1,NULL,NULL,NULL),(823,'2','sales_quantity','বিক্রয়ের সংখ্যা',1,NULL,NULL,NULL),(824,'2','list_of_sales','বিক্রয়ের তালিকা',1,NULL,NULL,NULL),(825,'2','purchases_quantity','ক্রয়ের সংখ্যা',1,NULL,NULL,NULL),(826,'2','purchases_total','মোট ক্রয়মূল্য',1,NULL,NULL,NULL),(827,'2','purchases_returned','ক্রয়কৃত মাল ফেরত',1,NULL,NULL,NULL),(828,'2','add_payment','নতুন পেমেন্ট',1,NULL,NULL,NULL),(829,'2','returns_history','মাল ফেরতের ইতিহাস',1,NULL,NULL,NULL),(830,'2','more','আরও',1,NULL,NULL,NULL),(831,'2','check_users_ability','ব্যাবহারকারির সক্ষমতা যাচাই',1,NULL,NULL,NULL),(832,'2','check_roles_ability','ব্যাবহারকারি ভূমিকার সক্ষমতা যাচাই',1,NULL,NULL,NULL),(833,'2','reports','রিপোর্টের তালিকা',1,NULL,NULL,NULL),(834,'2','product_report','পণ্য স্টক রিপোর্ট',1,NULL,NULL,NULL),(835,'2','income_expense_report','আয়/ব্যয় রিপোর্ট',1,NULL,NULL,NULL),(836,'2','income','আয়',1,NULL,NULL,NULL),(837,'2','reports.expense','ব্যয়',1,NULL,NULL,NULL),(838,'2','time','সময়',1,NULL,NULL,NULL),(839,'2','sl','ক্রঃনং',1,NULL,NULL,NULL),(840,'2','title','শিরোনাম',1,NULL,NULL,NULL),(841,'2','short_financial_report','সংক্ষিপ্ত আর্থিক বিবরণ',1,NULL,NULL,NULL),(842,'2','reports.addition','জমা',1,NULL,NULL,NULL),(843,'2','reports.current_stock','বর্তমান মজুদ',1,NULL,NULL,NULL),(844,'2','reports.subtraction','খরচ',1,NULL,NULL,NULL),(845,'2','reports.remains','অবশিষ্ট',1,NULL,NULL,NULL),(846,'2','reports.stock','মোট মজুদ',1,NULL,NULL,NULL),(847,'2','export_report','রিপোর্ট এক্সপোর্ট করুন',1,NULL,NULL,NULL),(848,'2','deposit_payment','মূলধন জমা দিন',1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `language_definitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English',NULL,'English Lanuage','2020-12-06 23:08:19','2020-12-06 23:08:19',NULL),(2,'Bengali',NULL,'Bengali Lanuage','2020-12-06 23:08:19','2020-12-06 23:08:19',NULL);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_06_01_000001_create_oauth_auth_codes_table',1),(4,'2016_06_01_000002_create_oauth_access_tokens_table',1),(5,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(6,'2016_06_01_000004_create_oauth_clients_table',1),(7,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(8,'2019_08_19_000000_create_failed_jobs_table',1),(9,'2019_12_14_000001_create_personal_access_tokens_table',1),(10,'2020_03_28_072951_create_permission_tables',1),(11,'2020_07_02_163139_create_customers_table',1),(12,'2020_07_02_163151_create_suppliers_table',1),(13,'2020_07_02_163205_create_categories_table',1),(14,'2020_07_03_112506_create_products_table',1),(15,'2020_07_03_115332_create_units_table',1),(16,'2020_07_03_115348_create_brands_table',1),(17,'2020_07_03_115656_create_subcategories_table',1),(18,'2020_07_03_120206_create_cat_subcat_assignments_table',1),(19,'2020_07_11_162300_create_histories_table',1),(20,'2020_09_05_190042_create_settings_table',1),(21,'2020_09_05_221100_create_sales_table',1),(22,'2020_09_05_221116_create_sale_items_table',1),(23,'2020_09_05_221134_create_sale_payments_table',1),(24,'2020_09_05_221219_create_purchase_payments_table',1),(25,'2020_09_05_221439_create_purchases_table',1),(26,'2020_09_05_221454_create_purchase_items_table',1),(27,'2020_09_07_145356_create_languages_table',1),(28,'2020_09_07_145444_create_language_definitions_table',1),(29,'2020_09_10_131412_create_expenses_table',1),(30,'2020_09_10_131914_create_capital_deposits_table',1),(31,'2020_09_10_131931_create_capital_withdraws_table',1),(32,'2020_09_10_133121_create_expense_categories_table',1),(33,'2020_09_14_162636_create_employees_table',1),(34,'2020_09_14_175528_create_employee_salaries_table',1),(35,'2020_09_21_205536_create_sms_table',1),(36,'2020_10_13_222913_create_sale_returns_table',1),(37,'2020_10_13_222937_create_purchase_returns_table',1),(38,'2020_12_03_011832_remove_column_quantity_from_products',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\User',1),(2,'App\\User',2),(3,'App\\User',3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'has dashboard access','Has Dashboard Access','web','2020-12-06 23:08:20','2020-12-06 23:08:20');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\User',1,'Electron Desktop','9fb739085f2d1dc8eab4030c7146b45547b226f855078b51a67777a59bf2ea2e','[\"*\"]',NULL,'2020-12-09 17:28:41','2020-12-09 17:28:41'),(2,'App\\User',1,'Electron Desktop','81e3e085f40023c553e147be9da86c2434b56878e4483426e3104488673eb545','[\"*\"]',NULL,'2020-12-09 17:28:53','2020-12-09 17:28:53'),(3,'App\\User',1,'Electron Desktop','eda86ac3d6c575b7afec3ec9c31d57710e1a71b5456f5dde59d8ce1c67daf0d8','[\"*\"]',NULL,'2020-12-09 17:36:36','2020-12-09 17:36:36'),(4,'App\\User',1,'Electron Desktop','ab99acda2f92280444d2d5a90b1859cbd6f5e74d44ba447e80f5e72632afb798','[\"*\"]',NULL,'2020-12-09 17:36:44','2020-12-09 17:36:44'),(5,'App\\User',1,'Electron Desktop','a5e010fc4704f532cf6854e1e212a294f9e4000ef84ea386ab6aebd974beeb53','[\"*\"]',NULL,'2020-12-09 17:40:01','2020-12-09 17:40:01'),(6,'App\\User',1,'Electron Desktop','7fd72ecf560a5c1f0800180f091bb944f4b54df3ac33e2fad00bdccbb94405c0','[\"*\"]',NULL,'2020-12-09 17:40:24','2020-12-09 17:40:24'),(7,'App\\User',1,'Electron Desktop','fd28035a760ac2f242172ed808d84a8971b810f429ade0d27ef9b7c194f57a63','[\"*\"]',NULL,'2020-12-09 17:40:53','2020-12-09 17:40:53'),(8,'App\\User',1,'Electron Desktop','acdbf21f8b1ecc1aad9cc2970bd587cf3e2b9f1a3279ddc588add007978414d8','[\"*\"]',NULL,'2020-12-09 17:41:25','2020-12-09 17:41:25'),(9,'App\\User',1,'Electron Desktop','4bb32d4210bca4e932b64f8ee46303f2e1f41c603febbc07f55735ac2f4c049e','[\"*\"]',NULL,'2020-12-09 17:41:43','2020-12-09 17:41:43'),(10,'App\\User',1,'Electron Desktop','9bfd51d571e17d444cb0b7074504e8ce2a4a78c731f34c4f2b578b8931630186','[\"*\"]',NULL,'2020-12-09 17:42:03','2020-12-09 17:42:03'),(11,'App\\User',1,'Electron Desktop','23e6d6e0b0305bc117368683b25b10f444f9c92528cd596b8df2d5aef33a28c0','[\"*\"]',NULL,'2020-12-09 17:42:19','2020-12-09 17:42:19'),(12,'App\\User',1,'Electron Desktop','e0b95b3dae5083888ed91b7e6023f148a98d2588ea09a6f614c8c4aa1a8f7add','[\"*\"]',NULL,'2020-12-09 17:42:24','2020-12-09 17:42:24'),(13,'App\\User',1,'Electron Desktop','edccd75c4d4b0096335315eb332802ae9e8c6e13bbfdd6290b4ba888e471f488','[\"*\"]',NULL,'2020-12-09 17:43:05','2020-12-09 17:43:05'),(14,'App\\User',1,'Electron Desktop','50093a08016f8c443eab1928f27d5c439b852151689648c27e33ccda678df4ba','[\"*\"]',NULL,'2020-12-09 17:43:28','2020-12-09 17:43:28'),(15,'App\\User',1,'Electron Desktop','a481f70f3dc3d8653a5b150531b38350364c9fa022892f0c3c997a503d6e371a','[\"*\"]',NULL,'2020-12-09 17:43:32','2020-12-09 17:43:32'),(16,'App\\User',1,'Electron Desktop','622f543fe6b1c1f542eab229a56cb3c24211623da40a81b31ce96d86d98a98ac','[\"*\"]',NULL,'2020-12-09 17:43:37','2020-12-09 17:43:37'),(17,'App\\User',1,'Electron Desktop','b850e3f3656399fc87fe61d7a18b21bd5463109bd5366bd76f832ad2feebe5c3','[\"*\"]',NULL,'2020-12-09 17:43:54','2020-12-09 17:43:54'),(18,'App\\User',1,'Electron Desktop','2ddd353a50168d934c201d7b55ef0b780601fd5aa0b425265224235e9e788b22','[\"*\"]',NULL,'2020-12-09 17:44:29','2020-12-09 17:44:29'),(19,'App\\User',1,'Desktop APP','91e7af2cb5604b89d87bc1365c48d3a02051075e5c41fcbdefaa546ced6d31da','[\"*\"]',NULL,'2020-12-09 18:27:24','2020-12-09 18:27:24'),(20,'App\\User',1,'Desktop APP','843f241a4ce0845ed9c685802f1f2d50a657483240733b5860f3475eee3d4cc0','[\"*\"]',NULL,'2020-12-09 18:28:19','2020-12-09 18:28:19'),(21,'App\\User',1,'Desktop APP','bfa618683702536c0e501b337ef924c2a4aec82fd695f9bbc640f40ad8c3f27c','[\"*\"]',NULL,'2020-12-09 18:38:11','2020-12-09 18:38:11'),(22,'App\\User',1,'Desktop APP','63ef0c1b45cdefa669262969c1f464ab91a5aaf908c9a6d11109cc7e75a621cc','[\"*\"]',NULL,'2020-12-09 18:40:34','2020-12-09 18:40:34'),(23,'App\\User',1,'Desktop APP','a88745d9cdeb99dafde456f8ad939207dfdce35e77e416d013f7d7ba9eb71e16','[\"*\"]',NULL,'2020-12-09 18:40:41','2020-12-09 18:40:41'),(24,'App\\User',1,'Desktop APP','f7447ef90ceef7069e6e558a219685a1f7c94d72480b2cf9737b845ee7d13840','[\"*\"]',NULL,'2020-12-09 18:40:51','2020-12-09 18:40:51'),(25,'App\\User',1,'Desktop APP','410854ed289bdc1f25ab555c7ed5b6179a00f851365c8a1f443959d1c7969c41','[\"*\"]',NULL,'2020-12-09 18:41:03','2020-12-09 18:41:03'),(26,'App\\User',1,'Desktop APP','66b794a8b75c67f2ce8acfe6a508506542ebf09172592ead4c410a474bf9daa7','[\"*\"]',NULL,'2020-12-09 18:42:11','2020-12-09 18:42:11'),(27,'App\\User',1,'Desktop APP','8853c3dbb41f99dd71aba7a3a946bc3970ea7b0c61b8f643ccea88166e87158f','[\"*\"]',NULL,'2020-12-09 18:42:20','2020-12-09 18:42:20'),(28,'App\\User',1,'Desktop APP','c2b01285ef80e53c63534d657e0773b3acd05ad3417fac44f2c3525eff5855d8','[\"*\"]',NULL,'2020-12-09 18:42:25','2020-12-09 18:42:25'),(29,'App\\User',1,'Desktop APP','49d41cf4bdfc786b909c41faf3bd3e53e24e828c00dbf460e7de495fe2d3af88','[\"*\"]',NULL,'2020-12-09 18:42:30','2020-12-09 18:42:30'),(30,'App\\User',1,'Desktop APP','d3e2ab954a9f05b5ff0745db774e7ee1901e6f131f41cda320fb72788d018231','[\"*\"]',NULL,'2020-12-09 18:44:28','2020-12-09 18:44:28'),(31,'App\\User',1,'Desktop APP','181544eab38e1ed857ca2b3eba05a8082d3ad413f0515619c6e20e7019323e65','[\"*\"]',NULL,'2020-12-09 18:44:32','2020-12-09 18:44:32'),(32,'App\\User',1,'Desktop APP','560855070bd48f0fff77cf1b45c7e0c136bba51973b3dba615e89be81f1d71ce','[\"*\"]','2020-12-09 18:45:24','2020-12-09 18:45:24','2020-12-09 18:45:24'),(33,'App\\User',1,'Desktop APP','c1076795045747fe4a9aae6060c6edaa483c97ebf5a2f232f0208684c2c01896','[\"*\"]','2020-12-09 18:54:14','2020-12-09 18:54:14','2020-12-09 18:54:14'),(34,'App\\User',1,'Desktop APP','5749a6648430ee95922b650601c672dd2f331755cdc2071319cd7ba130f65659','[\"*\"]',NULL,'2020-12-09 18:59:02','2020-12-09 18:59:02'),(35,'App\\User',1,'Desktop APP','6bcdb1df9cd42bbbd7e2dbc04c9031b0666b7adf75bc676d7e8785fe237ec21c','[\"*\"]',NULL,'2020-12-09 18:59:33','2020-12-09 18:59:33'),(36,'App\\User',1,'Desktop APP','39dbe0ba705fe1e3f3fedf8fb737e0ab5fe76e503da68ff9b402e09d71cc9641','[\"*\"]','2020-12-09 19:01:31','2020-12-09 19:01:31','2020-12-09 19:01:31'),(37,'App\\User',1,'Desktop APP','26c6f688e7781704b1227183790cd4f00feaebf6dbcafaad167fe908613c3728','[\"*\"]','2020-12-09 19:01:34','2020-12-09 19:01:34','2020-12-09 19:01:34'),(38,'App\\User',1,'Desktop APP','020e84d0f4efbe1cb7296d392a4989639b0c06a6c450625ae803a81f65d3e870','[\"*\"]','2020-12-09 19:01:42','2020-12-09 19:01:42','2020-12-09 19:01:42'),(39,'App\\User',1,'Desktop APP','9c24ebb13676f7f7a113a81a9180d4dfa6052d332fa39b4c85031fb3cde740d7','[\"*\"]','2020-12-09 19:02:38','2020-12-09 19:02:38','2020-12-09 19:02:38'),(40,'App\\User',1,'Desktop APP','9ddd76fcfe5dc74a8f6740f3dd43df03df0fc7491a7138e08dd93e77b5780310','[\"*\"]','2020-12-09 19:02:59','2020-12-09 19:02:58','2020-12-09 19:02:59'),(41,'App\\User',1,'Desktop APP','165d3df53abc2907aa98513c017f00e6b9a1a363a82e3d6e184885bb35544ba0','[\"*\"]',NULL,'2020-12-09 19:04:56','2020-12-09 19:04:56'),(42,'App\\User',1,'Desktop APP','9ffe535697564ccee8fe7965c57e1abe28ec41fbdadfd366b878504c82a2d9d7','[\"*\"]','2020-12-09 19:05:26','2020-12-09 19:05:26','2020-12-09 19:05:26'),(43,'App\\User',1,'Desktop APP','a1ae27c6bb1a730da9c65241537266e739ced52125d7d5f2d28f3be97ad09f99','[\"*\"]','2020-12-09 19:38:33','2020-12-09 19:38:32','2020-12-09 19:38:33'),(44,'App\\User',1,'Desktop APP','5a5daf85d6f41a2ab36517ad491406cf25cdc53bc168e2a28525ea6b7dd7a669','[\"*\"]','2020-12-09 19:41:38','2020-12-09 19:41:38','2020-12-09 19:41:38'),(45,'App\\User',1,'Desktop APP','66ac419d4512b0085639e3dbf3f16fca6fb37db7cbb7f6fa719bf3aeb4f96ced','[\"*\"]',NULL,'2020-12-09 19:42:45','2020-12-09 19:42:45'),(46,'App\\User',1,'Desktop APP','ef54c81ee694b6784a407d775e0d01b306195be685d9b5f7ce7e66313a339b30','[\"*\"]',NULL,'2020-12-09 19:42:56','2020-12-09 19:42:56'),(47,'App\\User',1,'Desktop APP','8836f98598dea0b3164ecd6740dcdf1cffafa17ebbec3d2e693b74a426436da9','[\"*\"]',NULL,'2020-12-09 19:43:00','2020-12-09 19:43:00'),(48,'App\\User',1,'Desktop APP','cd029d4e56c5872bda85a242c39ea90cbac2376494f7181fef6530df2a2fa888','[\"*\"]',NULL,'2020-12-09 19:46:38','2020-12-09 19:46:38'),(49,'App\\User',1,'Desktop APP','625e06b50315ba1f8d5251c63ae4d29e8aec381acdedd6c1f7078bd21d027787','[\"*\"]',NULL,'2020-12-09 19:46:53','2020-12-09 19:46:53'),(50,'App\\User',1,'Desktop APP','25b66bb50a37b0d29bd23d2ad656848fd0da943ea9d3b20b6d611f48c1dcf9a7','[\"*\"]',NULL,'2020-12-09 19:48:51','2020-12-09 19:48:51'),(51,'App\\User',1,'Desktop APP','196e5713ebc9c5336ac17e952b4ff2fd18fe740b8e830d2061642b3b7701ca5a','[\"*\"]',NULL,'2020-12-09 19:49:45','2020-12-09 19:49:45'),(52,'App\\User',1,'Desktop APP','4580f8e7db1922d53252f7e41791378ad41729c1dd74124ec8dc5d0f561c9092','[\"*\"]',NULL,'2020-12-09 19:49:57','2020-12-09 19:49:57'),(53,'App\\User',1,'Desktop APP','afafa7ecdd3594f66b2558c4e9a6a0a17fd5dfe13d66bbd75a12e3fec90e6826','[\"*\"]',NULL,'2020-12-09 19:50:03','2020-12-09 19:50:03'),(54,'App\\User',1,'Desktop APP','6301607270d1bc32a0acc0454d0e15370c37b01fe520640c1449b6947e5ee9fb','[\"*\"]','2020-12-09 19:51:41','2020-12-09 19:51:41','2020-12-09 19:51:41'),(55,'App\\User',1,'Desktop APP','92350dc904071aaa4b15b373a8517105389f2892c89c39ff63b49bd142331730','[\"*\"]','2020-12-09 19:51:47','2020-12-09 19:51:47','2020-12-09 19:51:47'),(56,'App\\User',1,'Desktop APP','130b171cc8109e4d9857b94b13985a72198669af5b2bab76ad9a6a5528fa471a','[\"*\"]',NULL,'2020-12-09 19:52:32','2020-12-09 19:52:32'),(57,'App\\User',1,'Desktop APP','e9f0c137d428b8de0392ec88070b52624f4f9948bd997c4e446ef25d3feb62a6','[\"*\"]',NULL,'2020-12-09 19:52:37','2020-12-09 19:52:37'),(58,'App\\User',1,'Desktop APP','70e925b3bee7073fe5eaec88d45b9c62e6828a6a028b4eec5f4cfa4d1b60c8c5','[\"*\"]',NULL,'2020-12-09 19:54:24','2020-12-09 19:54:24'),(59,'App\\User',1,'Desktop APP','7a1b1dac60a1e16ab3ca5fad2b3de1f362cbf6e6370c644158187879ce16103d','[\"*\"]','2020-12-09 19:58:56','2020-12-09 19:58:30','2020-12-09 19:58:56'),(60,'App\\User',1,'Desktop APP','36286aeb2b565f48e94932a25c72a0bcb4593f65b82aa59ec13aa28f5dcea31d','[\"*\"]','2020-12-09 19:59:02','2020-12-09 19:59:01','2020-12-09 19:59:02'),(61,'App\\User',1,'Desktop APP','585120f31c541743a981f8bdfde926b582229e96e921ddf3de4aab6ecfd014ec','[\"*\"]','2020-12-09 19:59:23','2020-12-09 19:59:22','2020-12-09 19:59:23'),(62,'App\\User',1,'Desktop APP','f832bd6f88dab618d7a3f04575571776171de6d6a08a076a8e25f5587802d0a6','[\"*\"]','2020-12-09 19:59:34','2020-12-09 19:59:33','2020-12-09 19:59:34'),(63,'App\\User',1,'Desktop APP','b837e1e602478a0ea3bcbd342341867ec3f0df8cfbefa04790424ecba5fdf383','[\"*\"]','2020-12-09 20:00:15','2020-12-09 19:59:46','2020-12-09 20:00:15'),(64,'App\\User',1,'Desktop APP','bd17540aeb72d529000b88cf405fe6c3c5974e0dc7a9f1ecd0917ff45f947e86','[\"*\"]',NULL,'2020-12-09 20:00:33','2020-12-09 20:00:33'),(65,'App\\User',1,'Desktop APP','d0d8e85028ab039a28dbf6a0b73f6ce6fc940344e5a08fd48dc2c447cd4fd0ad','[\"*\"]',NULL,'2020-12-09 20:00:42','2020-12-09 20:00:42'),(66,'App\\User',1,'Desktop APP','0dcd2ea94514edc5b9ef37309199e5b75c9ff3ecdf25c3d1817fe44b09d0541a','[\"*\"]','2020-12-09 20:00:54','2020-12-09 20:00:47','2020-12-09 20:00:54'),(67,'App\\User',1,'Desktop APP','d74128886db5402bcc176e4f1722acd4b6ef1dc2cc84cee3150196c2ab1b4713','[\"*\"]','2020-12-09 20:01:21','2020-12-09 20:01:00','2020-12-09 20:01:21'),(68,'App\\User',1,'Desktop APP','3102374d56946a4021d703ba4903c6ea5aca98548541bbe06896ec1783033f0d','[\"*\"]','2020-12-09 20:02:56','2020-12-09 20:01:29','2020-12-09 20:02:56'),(69,'App\\User',1,'Desktop APP','f6d195a1efa29196f0dbcd3d315d36142ff1bed49fbe9d3d1ddc74da93891ead','[\"*\"]',NULL,'2020-12-09 20:08:42','2020-12-09 20:08:42'),(70,'App\\User',1,'Desktop APP','1d31cb2b798ad82111710f3efc81a1c64029dcc2ee590174c48d3be76b530db3','[\"*\"]','2020-12-09 20:09:11','2020-12-09 20:08:49','2020-12-09 20:09:11'),(71,'App\\User',1,'Desktop APP','27afa236d120016801a17f4fc092b940790cd83b9c14a585faa48d49c4ee6fa3','[\"*\"]','2020-12-09 20:10:10','2020-12-09 20:10:02','2020-12-09 20:10:10'),(72,'App\\User',1,'Desktop APP','25e95c75ba577c482bf01dee69f20b942bc760d07653cba4303ab75aaef25891','[\"*\"]',NULL,'2020-12-09 20:10:14','2020-12-09 20:10:14'),(73,'App\\User',1,'Desktop APP','b29f0bd207968b76836dc7305e8e0cedfd1a22b6a4c67f3cad8c689ee6746fdf','[\"*\"]',NULL,'2020-12-09 20:10:30','2020-12-09 20:10:30'),(74,'App\\User',1,'Desktop APP','6fe1ef3a99a32155c251ffaa059b79b62e69014e3cea072ea6b0c25e2235cb48','[\"*\"]','2020-12-09 20:11:47','2020-12-09 20:11:27','2020-12-09 20:11:47'),(75,'App\\User',1,'Desktop APP','eb99864552e182e515ee4f6c43438074af5663c568afee98eb0d9633c1f06686','[\"*\"]','2020-12-09 20:12:16','2020-12-09 20:12:14','2020-12-09 20:12:16'),(76,'App\\User',1,'Desktop APP','e11ca2a0269b4509806bd733489a3310b4d0e4ad4d0b39774cf6be53bc0f742d','[\"*\"]','2020-12-09 20:12:25','2020-12-09 20:12:21','2020-12-09 20:12:25'),(77,'App\\User',1,'Desktop APP','ea55c755f21d09d329870ee4778f672a171867cc20dd31f7ce97958e6c5327d0','[\"*\"]','2020-12-09 20:15:03','2020-12-09 20:14:38','2020-12-09 20:15:03'),(78,'App\\User',1,'Desktop APP','2873f88dc45e3a03944bfc1dcf5ba5ef24085a7e1e4a19063b92b9b42d20a4b4','[\"*\"]','2020-12-09 20:19:30','2020-12-09 20:17:27','2020-12-09 20:19:30'),(79,'App\\User',1,'Desktop APP','78e27fd8902857a9ae53d2852edc6e45946f57fccfc7ff8e2744c6fdc578b181','[\"*\"]',NULL,'2020-12-09 20:19:37','2020-12-09 20:19:37'),(80,'App\\User',1,'Desktop APP','92a0db7802f0e961749eb474ef0c93f9a7c3c274a6844ff979c864a3573a7dd3','[\"*\"]','2020-12-09 20:24:40','2020-12-09 20:21:46','2020-12-09 20:24:40'),(81,'App\\User',1,'Desktop APP','19576e1bb282620746aa4900c4244a423d0beecd5dbbf457ab3e33d9892e07df','[\"*\"]',NULL,'2020-12-09 20:25:58','2020-12-09 20:25:58'),(82,'App\\User',1,'Desktop APP','2d1e179d97f7815e1ef19773defd3b728c7c3b7b0fa6f573b8f2c76bac790ffb','[\"*\"]',NULL,'2020-12-09 20:26:07','2020-12-09 20:26:07'),(83,'App\\User',1,'Desktop APP','7d08224b7943071ac45c0c6f6d6e5a3ad51e6432c7112898676589f0116988e0','[\"*\"]','2020-12-09 20:40:22','2020-12-09 20:35:47','2020-12-09 20:40:22'),(84,'App\\User',1,'Desktop APP','0b28cd20d77c925ef1ecad158cadda36e8a136e09b9085e3c0f4a1b1568edacf','[\"*\"]','2020-12-09 20:51:14','2020-12-09 20:50:58','2020-12-09 20:51:14'),(85,'App\\User',1,'Desktop APP','bab708596cb0686c323bedd33a74536fe5b57c016cdb3f682d2def710c93495e','[\"*\"]','2020-12-09 20:56:29','2020-12-09 20:54:00','2020-12-09 20:56:29'),(86,'App\\User',1,'Desktop APP','917a10cef9ff6b5dfedf5ed89df8a2ce5e73b5e69e55cf04f423b44823737317','[\"*\"]','2020-12-09 21:00:28','2020-12-09 20:59:09','2020-12-09 21:00:28'),(87,'App\\User',1,'Desktop APP','3e412e31c614db57d008b37dafb9d37cab36e55328227e0167098379646221bd','[\"*\"]','2020-12-09 21:03:40','2020-12-09 21:03:12','2020-12-09 21:03:40'),(88,'App\\User',1,'Desktop APP','f33d52feebdfb2348df1c0adad0e350eaa8549b48c6188ba784524b83673091b','[\"*\"]','2020-12-09 21:04:53','2020-12-09 21:04:29','2020-12-09 21:04:53'),(89,'App\\User',1,'Desktop APP','eb21c01128d4f86c0dcab9df43eb10aeb14d2dc649a33f16ff657d4738641bf5','[\"*\"]','2020-12-11 20:03:16','2020-12-11 20:03:12','2020-12-11 20:03:16'),(90,'App\\User',1,'Desktop APP','9c5e2cb1fdb37220f46a8e59ccac1f349d488a4f032c44b40b6d90d48cf5c8d8','[\"*\"]','2020-12-11 20:04:33','2020-12-11 20:03:12','2020-12-11 20:04:33'),(91,'App\\User',1,'Web App','c13a3edc7160aa1589534aa870232ac21ff6bc868f75eb693889901686d959b6','[\"*\"]',NULL,'2020-12-11 22:52:37','2020-12-11 22:52:37'),(92,'App\\User',1,'Web App','c1fb509e10f306b05947d572a487d3569de98d8962049ebef98228bee9870e05','[\"*\"]',NULL,'2020-12-11 22:52:40','2020-12-11 22:52:40'),(93,'App\\User',1,'Web App','e63d47e8d8fc359737c21af18456a7961168828f87b52795340f89e7aa1351b7','[\"*\"]',NULL,'2020-12-11 22:53:09','2020-12-11 22:53:09'),(94,'App\\User',1,'Web App','0ed26f1c5fce114ebfe5400c4b46cd35570004e0100dfc4db790abf6175a52c5','[\"*\"]',NULL,'2020-12-11 22:55:22','2020-12-11 22:55:22'),(95,'App\\User',1,'Web App','75a7a35818e9a80265d3792f0995a7b1608e8ec44828889538c993667ffcb817','[\"*\"]','2020-12-11 22:57:30','2020-12-11 22:57:29','2020-12-11 22:57:30'),(96,'App\\User',1,'Web App','044c1becb4646d841bad78ad56cd0970e0b19e003344d32bb475807fe4221900','[\"*\"]','2020-12-11 23:06:34','2020-12-11 23:06:34','2020-12-11 23:06:34'),(97,'App\\User',1,'Web App','1cd59f566f2e53486f87efd306e0d76d988211d05a22f86640ac4d671845e228','[\"*\"]','2020-12-11 23:08:53','2020-12-11 23:08:53','2020-12-11 23:08:53'),(98,'App\\User',1,'Web App','f9bbc6c2d20a5054b3f2186c6c42fab57500c3e186f2ff0502cbeb179ae85e04','[\"*\"]','2020-12-11 23:10:40','2020-12-11 23:10:40','2020-12-11 23:10:40'),(99,'App\\User',1,'Web App','b85a89efc972fd456bebc765da881e604e33cac9a5194ec92bcfc1bb73d1fc98','[\"*\"]','2020-12-11 23:11:24','2020-12-11 23:11:23','2020-12-11 23:11:24'),(100,'App\\User',1,'Web App','ca333ed630195a98afc43c1bcb63c2b51bad6d8d47e62e1970269d2ec3816e75','[\"*\"]','2020-12-11 23:11:53','2020-12-11 23:11:53','2020-12-11 23:11:53'),(101,'App\\User',1,'Web App','3fe16869dcef8e657b7978166f056446d23dc11c8aebcb6fcfa15382a0a73911','[\"*\"]','2020-12-11 23:13:03','2020-12-11 23:13:02','2020-12-11 23:13:03'),(102,'App\\User',1,'Web App','9760d33b3850508c615544c2d0da0e0b375fed3f814a2e89dca7f4bdbeacfe95','[\"*\"]',NULL,'2020-12-11 23:26:07','2020-12-11 23:26:07'),(103,'App\\User',1,'Web App','48630191b1e42325a7f34c19757a46b7e74501323a824d7eccb539476fd12397','[\"*\"]',NULL,'2020-12-11 23:29:52','2020-12-11 23:29:52'),(104,'App\\User',1,'Web App','b1eb4082c3dbe01ab2a77106f1324f6f89325905f1e24eec47b49fb162896d46','[\"*\"]',NULL,'2020-12-11 23:31:14','2020-12-11 23:31:14'),(105,'App\\User',1,'Web App','e265a7794fddc042f20f7f94c30c0cde6cb9ffa5dfe12187305071bdf2c40115','[\"*\"]',NULL,'2020-12-11 23:31:47','2020-12-11 23:31:47'),(106,'App\\User',1,'Web App','725528e5400ca001cf123b1d172defabc77621ec74e33a49fb0568e1da4eb9cf','[\"*\"]',NULL,'2020-12-11 23:33:36','2020-12-11 23:33:36'),(107,'App\\User',1,'Web App','d54918bc1457ae29db1f0bc9e56d7ff78ba587ca172784f297b8648a2f73212c','[\"*\"]',NULL,'2020-12-11 23:34:01','2020-12-11 23:34:01'),(108,'App\\User',1,'Web App','94b488b83ca9af7f4616794d65a4d49a6c3b3b31baa4c0824d131ad2dbb61a0a','[\"*\"]','2020-12-11 23:34:36','2020-12-11 23:34:36','2020-12-11 23:34:36'),(109,'App\\User',1,'Web App','d1a27986275ec61fa1bc831cd5aeb6a7e300fcc8b85e900ff5ca3fbd084a6c73','[\"*\"]','2020-12-11 23:49:12','2020-12-11 23:49:12','2020-12-11 23:49:12'),(110,'App\\User',1,'Web App','05df8f063148a6eaed7582fbf4ea85dd855c35431ab061940f58d669245fdd0c','[\"*\"]','2020-12-11 23:49:43','2020-12-11 23:49:42','2020-12-11 23:49:43'),(111,'App\\User',1,'Web App','eab1583ed7877a8774ccf543695c8e9ff91ea6a424b24bb01254817316e6d44c','[\"*\"]','2020-12-11 23:50:50','2020-12-11 23:50:49','2020-12-11 23:50:50'),(112,'App\\User',1,'Web App','38d790eb4e8264fb31bb79f15bc53081c10ce5009f27b06c38f7dbb2c185f596','[\"*\"]','2020-12-11 23:52:41','2020-12-11 23:52:40','2020-12-11 23:52:41'),(113,'App\\User',1,'Web App','891d4ce6945103389573f73415f775b0e3a15dc52a8282c7477e8ac711a38afe','[\"*\"]','2020-12-11 23:53:40','2020-12-11 23:53:39','2020-12-11 23:53:40'),(114,'App\\User',1,'Web App','97c164e33c2c899aab2743821ea0ea8b4d07f044856b6bc3fcde9e4b6f265fbd','[\"*\"]','2020-12-11 23:56:57','2020-12-11 23:56:56','2020-12-11 23:56:57'),(115,'App\\User',1,'Web App','36f0cc5f15787cf1169f9dc63dcf994bf66fd81fb2cdbf492737093562fe472f','[\"*\"]',NULL,'2020-12-12 00:02:50','2020-12-12 00:02:50'),(116,'App\\User',1,'Web App','d6ffce7ef72e49749e2cb7cf88f8923b30d534a9cdfaa71ea868b0197cab84f4','[\"*\"]',NULL,'2020-12-12 00:08:29','2020-12-12 00:08:29'),(117,'App\\User',1,'Web App','d462073a8de00f097b71c5ea7df3c2391ecc2d36600e05b48fa1f12a0729308d','[\"*\"]','2020-12-12 00:10:24','2020-12-12 00:09:54','2020-12-12 00:10:24'),(118,'App\\User',1,'Web App','fc25d2af1e27c79d6241695da009eedc5e5951193c073be31288c59ae624a5b2','[\"*\"]','2020-12-12 00:10:27','2020-12-12 00:10:26','2020-12-12 00:10:27'),(119,'App\\User',1,'Web App','c95b8460264b136c3221b864d66f7a24aba743e7ea31d36ae78e9d222e875991','[\"*\"]','2020-12-12 00:13:26','2020-12-12 00:10:31','2020-12-12 00:13:26'),(120,'App\\User',1,'Web App','75c3dd9b8a908831120e3e6af5f15f7f2f20d54631ddc1b41a980b0d7d6139ef','[\"*\"]','2020-12-12 00:14:35','2020-12-12 00:13:28','2020-12-12 00:14:35'),(121,'App\\User',1,'Web App','b95545991d7bf8b101b2acdf1c30d6d8a5270467512992e21847a53647a007fa','[\"*\"]','2020-12-12 00:14:38','2020-12-12 00:14:37','2020-12-12 00:14:38'),(122,'App\\User',1,'Web App','7b2d0ac30df61ea248cf64861b4ccc673ebce76421316cfc24b11bd682a0b0a8','[\"*\"]','2020-12-12 00:14:40','2020-12-12 00:14:40','2020-12-12 00:14:40'),(123,'App\\User',1,'Web App','13c9e944564f81d262b0b672401a06b1063989726fe101fb442fd5763461534e','[\"*\"]','2020-12-12 00:15:13','2020-12-12 00:14:50','2020-12-12 00:15:13'),(124,'App\\User',1,'Web App','42449272e337cd4b55d5eb9894a7ad1afc746a007a121e67631ebcc7b9d68b6f','[\"*\"]','2020-12-12 00:15:54','2020-12-12 00:15:15','2020-12-12 00:15:54'),(125,'App\\User',1,'Web App','374aca3ce75de033afa38dd397f4cc9ad803fca22cf3b1689ceaef009c432ed7','[\"*\"]','2020-12-12 00:16:28','2020-12-12 00:15:56','2020-12-12 00:16:28'),(126,'App\\User',1,'Web App','7b89b9cc746fd2defce32c0952fe9c650ace9f5a6a9b51eccab663a13687e94a','[\"*\"]','2020-12-12 00:39:17','2020-12-12 00:16:30','2020-12-12 00:39:17'),(127,'App\\User',1,'Web App','4f54350a2e43bbb6437c3d02f5760226b47e24766a201c27181bfd90dae8cddb','[\"*\"]',NULL,'2020-12-12 00:21:47','2020-12-12 00:21:47'),(128,'App\\User',1,'Web App','c44432aab5deecb0d31009aafd0d899504371ae2a03c2fc2a07936c0f24a5f6a','[\"*\"]',NULL,'2020-12-12 00:22:53','2020-12-12 00:22:53'),(129,'App\\User',1,'Web App','6eb395aadba2c87cdf035b7a808090e30e0ecf8fe86f7a498f53e4f8332378f9','[\"*\"]',NULL,'2020-12-12 00:23:15','2020-12-12 00:23:15'),(130,'App\\User',1,'Web App','176b16068bf9c4dab4624a22edb845b66c4f82aff693340269d269f6bf24e1cc','[\"*\"]',NULL,'2020-12-12 00:23:25','2020-12-12 00:23:25'),(131,'App\\User',1,'Web App','63672471fbf825c30d4a2e80e924ce0faed18d20676b44e1457a2e542f77ef33','[\"*\"]',NULL,'2020-12-12 00:24:12','2020-12-12 00:24:12'),(132,'App\\User',1,'Web App','8268156e8aa62076fbde62c301f137b260e3fbcb2f85c60f11709811a07462ba','[\"*\"]',NULL,'2020-12-12 00:27:25','2020-12-12 00:27:25'),(133,'App\\User',1,'Web App','b428080877ec674c96ed07191bb307b55c1f77e2b4440434591bc9e1e2fcf961','[\"*\"]',NULL,'2020-12-12 00:27:38','2020-12-12 00:27:38'),(134,'App\\User',1,'Web App','242a46390e0f9c08ace3b93f959590496dc120d92fff1e4a5a22725d9a047c86','[\"*\"]',NULL,'2020-12-12 00:28:10','2020-12-12 00:28:10'),(135,'App\\User',1,'Web App','c573bcd6dd66dc9e48e6d9945cab1c1f62fb25ef54b24fda446fcfbf39c9860c','[\"*\"]',NULL,'2020-12-12 00:28:59','2020-12-12 00:28:59'),(136,'App\\User',1,'Web App','903d5d3047f3c0cc39386436a6494916350312d932a3b13c352b2c60609ab034','[\"*\"]',NULL,'2020-12-12 00:29:26','2020-12-12 00:29:26'),(137,'App\\User',1,'Web App','9de4fe282364fe3afdca8a4657f2a57af2bbac7129e2f23a66805c609a9d2dfe','[\"*\"]',NULL,'2020-12-12 00:29:35','2020-12-12 00:29:35'),(138,'App\\User',1,'Web App','3e5494e88e8dc89b3586df7cf8da8db66d0b48ca56f17a6eaee77880046b93f9','[\"*\"]',NULL,'2020-12-12 00:31:53','2020-12-12 00:31:53'),(139,'App\\User',1,'Web App','1d3c7116673273820441079ee2d05b963c1db0a88ac03e425eff2543cbf2d9d5','[\"*\"]',NULL,'2020-12-12 00:33:31','2020-12-12 00:33:31'),(140,'App\\User',1,'Web App','a82bc887d160b7bcdf9b4729c461f200c49d905f8f9125818e16b6bf132ec856','[\"*\"]',NULL,'2020-12-12 00:36:37','2020-12-12 00:36:37'),(141,'App\\User',1,'Web App','9ef3103005f506a441ffe3e9ea83bad2b40aaefd31fd3d05bdad19c97dc0002d','[\"*\"]',NULL,'2020-12-12 00:37:46','2020-12-12 00:37:46'),(142,'App\\User',1,'Web App','d88d314b3acb4b9316590cc8bd4a81e97d0dad2bb65701be2b544c01b2357663','[\"*\"]',NULL,'2020-12-12 00:38:47','2020-12-12 00:38:47'),(143,'App\\User',1,'Web App','13064bf9cf517326d81e11564c7096afe55fa0a86a3d7fe6be3d7f1bad5e5133','[\"*\"]',NULL,'2020-12-12 00:39:17','2020-12-12 00:39:17');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_symbology` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `category_id` bigint unsigned DEFAULT NULL,
  `subcategory_id` bigint unsigned DEFAULT NULL,
  `brand_id` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `unit_id` bigint unsigned DEFAULT NULL,
  `alert_quantity` double NOT NULL DEFAULT '0',
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'repudiandae','code128','5fcd646b34554',174.27,435.54,3,5,4,0,2,18,NULL,'Maxime ex similique sequi non sapiente optio. Consequuntur laboriosam est ut.','2020-11-18 23:08:27','2020-12-06 23:08:27',NULL),(2,'iusto','code128','5fcd646b3591a',463.86,316.09,4,4,1,1,2,31,NULL,'Distinctio voluptatem aspernatur qui vitae dolorem. Sit error rerum autem sit et.','2020-11-21 23:08:27','2020-12-06 23:08:27',NULL),(3,'magnam','code128','5fcd646b3634c',31.01,496.93,3,1,1,0,4,33,NULL,'Quis enim et vitae asperiores. Quidem ratione quia qui. Officia quam natus cupiditate est atque.','2020-11-24 23:08:27','2020-12-06 23:08:27',NULL),(4,'quos','code128','5fcd646b367b6',167.39,40.17,4,3,1,0,2,41,NULL,'Nulla quasi non saepe earum quis et. Dolor tempore ut ipsa blanditiis.','2021-01-02 23:08:27','2020-12-06 23:08:28',NULL),(5,'aut','code128','5fcd646b370b2',482.75,232.84,5,2,2,1,4,10,NULL,'Voluptates placeat commodi deserunt. Non beatae est ut aut culpa. Totam autem doloremque omnis.','2020-11-14 23:08:27','2020-12-06 23:08:28',NULL),(6,'maiores','code128','5fcd646b3747c',110.62,70.4,3,3,3,1,2,12,NULL,'Ex placeat tempore distinctio non minima impedit quia. Distinctio enim pariatur reiciendis amet.','2020-12-06 23:08:27','2020-12-06 23:08:28',NULL),(7,'mollitia','code128','5fcd646b377c5',73.04,234.79,3,2,3,1,4,42,NULL,'Nobis velit incidunt et et voluptatum consectetur. Fuga rerum aut ut praesentium.','2020-12-23 23:08:27','2020-12-06 23:08:28',NULL),(8,'praesentium','code128','5fcd646b379a9',483.14,80.43,4,5,5,0,2,3,NULL,'Quasi aut est est. Qui et inventore fuga qui dolorem placeat. Placeat quis in rerum nostrum.','2020-11-21 23:08:27','2020-12-06 23:08:29',NULL),(9,'quos','code128','5fcd646b37b63',198.36,417.48,2,1,4,1,1,3,NULL,'Occaecati veritatis quasi et est qui est ex minus. Aut unde ipsam dolores nihil et.','2020-11-13 23:08:27','2020-12-06 23:08:29',NULL),(10,'perferendis','code128','5fcd646b37d90',104.86,118.22,4,5,3,0,2,15,NULL,'Id laboriosam qui sequi aut explicabo iusto. Tempora voluptates ut sunt.','2020-12-18 23:08:27','2020-12-06 23:08:29',NULL),(11,'error','code128','5fcd646b380e3',448.11,448.75,5,2,4,0,2,6,NULL,'Ea magnam itaque at. Modi enim quos optio quasi.','2020-11-12 23:08:27','2020-12-06 23:08:29',NULL),(12,'et','code128','5fcd646b38436',119.96,340.18,2,1,3,1,4,9,NULL,'Aliquid libero laboriosam quis unde tenetur qui alias. Ut facilis ut et sed architecto a.','2020-11-27 23:08:27','2020-12-06 23:08:30',NULL),(13,'necessitatibus','code128','5fcd646b38725',401.24,106.01,2,4,1,1,4,3,NULL,'Ut reiciendis pariatur eos modi quam rerum. Et veniam consequatur laboriosam aut.','2021-01-03 23:08:27','2020-12-06 23:08:30',NULL),(14,'reprehenderit','code128','5fcd646b3889f',235.44,318.13,5,1,3,1,4,1,NULL,'Alias incidunt ut dolorem consequatur. Tenetur in ut nobis amet placeat.','2020-12-15 23:08:27','2020-12-06 23:08:30',NULL),(15,'quam','code128','5fcd646b38a30',103.14,492.33,2,5,4,0,2,6,NULL,'Et quod natus aut veritatis. Molestias recusandae et asperiores est.','2020-12-08 23:08:27','2020-12-06 23:08:30',NULL),(16,'vitae','code128','5fcd646b38c18',313.85,397.02,3,3,5,0,1,18,NULL,'Optio enim sequi ipsam iure unde. Rerum repudiandae praesentium commodi qui.','2020-12-14 23:08:27','2020-12-06 23:08:31',NULL),(17,'quia','code128','5fcd646b38e4f',394.5,398.72,1,4,3,0,1,27,NULL,'Totam porro corrupti sed omnis eum non odio. Porro aut ipsum et perferendis eius voluptas.','2020-12-17 23:08:27','2020-12-06 23:08:31',NULL),(18,'et','code128','5fcd646b38fb5',224.42,347.74,5,1,1,0,1,26,NULL,'Aut ut culpa ut iusto. Eum adipisci voluptas sit architecto voluptates assumenda.','2020-12-10 23:08:27','2020-12-06 23:08:31',NULL),(19,'et','code128','5fcd646b3913a',434.47,240.3,5,3,2,0,2,7,NULL,'Dolorem delectus veritatis aut maxime sunt. Quam delectus quo quibusdam perspiciatis.','2020-12-13 23:08:27','2020-12-06 23:08:31',NULL),(20,'consequatur','code128','5fcd646b39362',258.86,135.83,3,4,4,1,3,43,NULL,'Maiores cumque deserunt quod voluptates error. Eos voluptate ad aut enim et labore quo.','2020-12-26 23:08:27','2020-12-06 23:08:31',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `returned_quantity` double NOT NULL DEFAULT '0',
  `returned_total` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_items`
--

LOCK TABLES `purchase_items` WRITE;
/*!40000 ALTER TABLE `purchase_items` DISABLE KEYS */;
INSERT INTO `purchase_items` VALUES (1,1,1,1,1,174.27,174.27,0,0,'2020-12-07 00:22:29','2020-12-07 00:22:29',NULL),(2,1,8,1,6,80.43,482.58,0,0,'2020-12-08 00:54:51','2020-12-08 01:05:28','2020-12-08 01:05:28');
/*!40000 ALTER TABLE `purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_payments`
--

DROP TABLE IF EXISTS `purchase_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_amount` double NOT NULL DEFAULT '0',
  `bank` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_payments`
--

LOCK TABLES `purchase_payments` WRITE;
/*!40000 ALTER TABLE `purchase_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_returns`
--

DROP TABLE IF EXISTS `purchase_returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_returns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_returns`
--

LOCK TABLES `purchase_returns` WRITE;
/*!40000 ALTER TABLE `purchase_returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `payable` double NOT NULL DEFAULT '0',
  `returned` double NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `previous_balance` double NOT NULL DEFAULT '0',
  `current_balance` double NOT NULL DEFAULT '0',
  `paid` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_modified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,1,174.27,0,0,174.27,0,'2020-12-07','Processed',NULL,576.42,1233.27,0,'2020-12-07 00:22:29','2020-12-08 01:05:28',NULL,1);
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','Super Admin Manages Everything','web','2020-12-06 23:08:20','2020-12-06 23:08:20'),(2,'User','User Role','web','2020-12-06 23:08:21','2020-12-06 23:08:21'),(3,'Customer','Customer Role','web','2020-12-06 23:08:21','2020-12-06 23:08:21');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_items`
--

DROP TABLE IF EXISTS `sale_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `returned_quantity` double NOT NULL DEFAULT '0',
  `returned_total` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_items`
--

LOCK TABLES `sale_items` WRITE;
/*!40000 ALTER TABLE `sale_items` DISABLE KEYS */;
INSERT INTO `sale_items` VALUES (1,1,1,1,1,435.54,435.54,0,0,'2020-12-06 23:26:37','2020-12-06 23:26:37',NULL),(2,2,1,1,1,435.54,435.54,0,0,'2020-12-06 23:33:59','2020-12-06 23:33:59',NULL),(3,3,1,1,1,435.54,435.54,0,0,'2020-12-06 23:41:38','2020-12-06 23:41:38',NULL),(4,4,1,2,1,435.54,435.54,0,0,'2020-12-06 23:42:29','2020-12-06 23:42:29',NULL),(5,4,2,2,1,316.09,316.09,0,0,'2020-12-06 23:42:29','2020-12-06 23:42:29',NULL),(6,5,4,3,1,40.17,40.17,0,0,'2020-12-06 23:44:09','2020-12-06 23:44:09',NULL),(7,5,5,3,1,232.84,232.84,0,0,'2020-12-06 23:44:09','2020-12-06 23:44:09',NULL),(8,6,4,1,1,40.17,40.17,0,0,'2020-12-06 23:45:33','2020-12-07 00:18:14','2020-12-07 00:18:14'),(9,7,1,5,1,435.54,435.54,0,0,'2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(10,7,4,5,1,40.17,40.17,0,0,'2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(11,7,5,5,1,232.84,232.84,0,0,'2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(12,7,2,5,1,316.09,316.09,0,0,'2020-12-08 01:24:52','2020-12-08 01:24:52',NULL),(13,8,3,5,1,496.93,496.93,0,0,'2020-12-08 01:26:33','2020-12-08 01:26:33',NULL),(14,8,5,5,1,232.84,232.84,0,0,'2020-12-08 01:26:33','2020-12-08 01:26:33',NULL),(15,9,4,8,1,40.17,40.17,0,0,'2020-12-08 01:27:33','2020-12-08 01:27:33',NULL),(16,9,5,8,1,232.84,232.84,0,0,'2020-12-08 01:27:33','2020-12-08 01:27:33',NULL),(17,9,6,8,1,70.4,70.4,0,0,'2020-12-08 01:27:33','2020-12-08 01:27:33',NULL),(18,10,1,1,1,0,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(19,11,1,3,1,200,200,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(20,12,1,4,1,0,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(21,13,1,5,1,-44,-44,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(22,14,1,6,1,0,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(23,15,1,7,1,0,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(24,16,1,8,1,343.41,343.41,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(25,17,1,9,1,0,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(26,18,1,10,1,0,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL),(27,19,1,3,1,400,400,0,0,'2020-12-12 15:48:59','2020-12-12 15:48:59',NULL),(28,20,1,8,1,686.82,686.82,0,0,'2020-12-12 15:48:59','2020-12-12 15:48:59',NULL);
/*!40000 ALTER TABLE `sale_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_payments`
--

DROP TABLE IF EXISTS `sale_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_amount` double NOT NULL DEFAULT '0',
  `bank` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taken_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_payments`
--

LOCK TABLES `sale_payments` WRITE;
/*!40000 ALTER TABLE `sale_payments` DISABLE KEYS */;
INSERT INTO `sale_payments` VALUES (1,1,'Cash',1306.62,NULL,NULL,NULL,1,'2020-12-08 01:24:15','2020-12-08 01:24:15',NULL),(2,1,'Cash',0,NULL,NULL,NULL,1,'2020-12-08 01:24:27','2020-12-08 01:24:27',NULL),(3,5,'Cash',1754.41,NULL,NULL,NULL,1,'2020-12-08 01:26:33','2020-12-08 01:26:33',NULL),(4,3,'Cash',73.01,NULL,NULL,NULL,1,'2020-12-08 01:36:53','2020-12-08 01:36:53',NULL),(5,5,'Cash',44,NULL,NULL,NULL,1,'2020-12-09 20:01:43','2020-12-09 20:01:44',NULL);
/*!40000 ALTER TABLE `sale_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_returns`
--

DROP TABLE IF EXISTS `sale_returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_returns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_returns`
--

LOCK TABLES `sale_returns` WRITE;
/*!40000 ALTER TABLE `sale_returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `payable` double NOT NULL DEFAULT '0',
  `returned` double NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `previous_balance` double NOT NULL DEFAULT '0',
  `current_balance` double NOT NULL DEFAULT '0',
  `paid` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_modified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,1,435.54,0,0,435.54,0,'2020-12-07','Processed',NULL,435.54,871.08,0,'2020-12-06 23:26:37','2020-12-06 23:27:32',NULL,1),(2,1,435.54,0,0,435.54,0,'2020-12-07','Processed',NULL,435.54,871.08,0,'2020-12-06 23:33:59','2020-12-06 23:33:59',NULL,0),(3,1,435.54,0,0,435.54,0,'2020-12-07','Processed',NULL,871.08,1306.62,0,'2020-12-06 23:41:38','2020-12-06 23:41:38',NULL,0),(4,2,751.63,0,0,751.63,0,'2020-12-07','Processed',NULL,0,751.63,0,'2020-12-06 23:42:29','2020-12-06 23:42:29',NULL,0),(5,3,273.01,0,0,273.01,0,'2020-12-07','Processed',NULL,0,273.01,0,'2020-12-06 23:44:09','2020-12-06 23:44:09',NULL,0),(6,1,40.17,0,0,40.17,0,'2020-12-07','Processed',NULL,1306.62,1346.79,0,'2020-12-06 23:45:33','2020-12-07 00:18:14','2020-12-07 00:18:14',0),(7,5,1024.64,0,0,1024.64,0,'2020-12-08','Processed',NULL,0,1024.64,0,'2020-12-08 01:24:52','2020-12-08 01:24:52',NULL,0),(8,5,729.77,0,0,729.77,0,'2020-12-08','Processed',NULL,1024.64,0,1754.41,'2020-12-08 01:26:33','2020-12-08 01:26:33',NULL,0),(9,8,343.41,0,0,343.41,0,'2020-12-08','Processed',NULL,0,343.41,0,'2020-12-08 01:27:33','2020-12-08 01:27:33',NULL,0),(10,1,0,0,0,0,0,'2020-12-12','Processed',NULL,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(11,3,200,0,0,200,0,'2020-12-12','Processed',NULL,0,200,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(12,4,0,0,0,0,0,'2020-12-12','Processed',NULL,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(13,5,-44,0,0,-44,0,'2020-12-12','Processed',NULL,0,-44,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(14,6,0,0,0,0,0,'2020-12-12','Processed',NULL,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(15,7,0,0,0,0,0,'2020-12-12','Processed',NULL,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(16,8,343.41,0,0,343.41,0,'2020-12-12','Processed',NULL,0,343.41,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(17,9,0,0,0,0,0,'2020-12-12','Processed',NULL,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(18,10,0,0,0,0,0,'2020-12-12','Processed',NULL,0,0,0,'2020-12-12 15:47:32','2020-12-12 15:47:32',NULL,0),(19,3,400,0,0,400,0,'2020-12-12','Processed',NULL,0,400,0,'2020-12-12 15:48:59','2020-12-12 15:48:59',NULL,0),(20,8,686.82,0,0,686.82,0,'2020-12-12','Processed',NULL,0,686.82,0,'2020-12-12 15:48:59','2020-12-12 15:48:59',NULL,0);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','WovoPOS','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(2,'phone','123456789','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(3,'email','example@email.com','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(4,'address','Example, Address-5400, Bangladesh','2020-12-06 23:08:17','2020-12-06 23:08:17',NULL),(5,'currency','BDT','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(6,'locale','en-US','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(7,'default_discount','0','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(8,'default_tax','0','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(9,'default_customer','1','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(10,'send_sms_after_sale','0','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(11,'send_sms_after_order','0','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(12,'logo',NULL,'2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(13,'timezone','Asia/Dhaka','2020-12-06 23:08:18','2020-12-06 23:08:18',NULL),(14,'language','2','2020-12-06 23:08:19','2020-12-11 21:56:00',NULL),(15,'invoice_header',NULL,'2020-12-06 23:08:19','2020-12-11 17:40:46',NULL),(16,'invoice_footer',NULL,'2020-12-06 23:08:19','2020-12-11 17:40:46',NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms`
--

DROP TABLE IF EXISTS `sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `sender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacts` text COLLATE utf8mb4_unicode_ci,
  `message` text COLLATE utf8mb4_unicode_ci,
  `delivery` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms`
--

LOCK TABLES `sms` WRITE;
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thana` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_office` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Dr. Vanessa Homenick DVM','lilian03@gmail.com','+16214557748','Paucek and Sons','ex','ea','51490','rerum','9238 Tomas Plaza\nStiedemannhaven, MO 06904-2711',NULL,'2020-11-09 23:08:31','2020-12-06 23:08:32',NULL),(2,'Estel Feil','johnson.halvorson@hotmail.com','(261) 661-9436 x412','Lehner-Ebert','ea','voluptas','21368','modi','195 Hills Flat\nPort Ludwigbury, PA 14608-3026',NULL,'2020-12-14 23:08:31','2020-12-06 23:08:32',NULL),(3,'Dr. Clotilde Buckridge','allie04@yahoo.com','+1-331-535-7220','Nitzsche-Hills','illo','officia','76870-9412','qui','3549 O\'Connell Orchard\nLake Rosaleeberg, NM 65455',NULL,'2020-11-30 23:08:31','2020-12-06 23:08:32',NULL),(4,'Prof. Trinity Pfeffer','vbahringer@gmail.com','362-549-4334','Daugherty-Donnelly','error','amet','46180-6775','cumque','710 Holly Flats Suite 695\nLangbury, MN 17185',NULL,'2020-12-09 23:08:31','2020-12-06 23:08:32',NULL),(5,'Prof. Carroll Crist MD','samson30@hotmail.com','+19516594720','Lueilwitz-Collins','harum','quia','97108','est','8105 Volkman Pine Suite 424\nCarolineborough, CA 15771',NULL,'2020-12-14 23:08:31','2020-12-06 23:08:33',NULL),(6,'Renee Padberg','miracle76@hotmail.com','1-878-268-3408','Mayert, Daugherty and Herzog','facilis','velit','00076','ut','4828 Leopold Camp\nSchoenshire, NM 66892',NULL,'2020-12-30 23:08:31','2020-12-06 23:08:33',NULL),(7,'Adrian Wunsch','julia.jast@stamm.net','1-856-465-2915 x930','Graham, Bauch and Frami','enim','nulla','50531','enim','626 Petra Trace Apt. 984\nLuettgenberg, NJ 13564-3661',NULL,'2020-12-23 23:08:31','2020-12-06 23:08:33',NULL),(8,'Dwight Jerde','florine.mante@hotmail.com','418-776-2724','Goodwin Ltd','rem','accusamus','91541-6024','suscipit','579 Dedric Junction Apt. 592\nSchaeferside, SC 08140',NULL,'2020-12-02 23:08:31','2020-12-06 23:08:33',NULL),(9,'Giles Cartwright','stehr.margie@treutel.com','+1 (663) 900-8795','Rohan and Sons','odit','maxime','99322-5382','quo','28726 Kuhn Stream Apt. 595\nWest Deliatown, WI 98007',NULL,'2020-11-25 23:08:31','2020-12-06 23:08:33',NULL),(10,'Amanda Watsica','sammy97@mclaughlin.net','(257) 236-0913 x428','Jacobs Ltd','error','rerum','55043','reiciendis','7070 Koch Cape Suite 191\nAlvahburgh, TN 33038',NULL,'2020-12-30 23:08:31','2020-12-06 23:08:34',NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'kg','kilogram','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(2,'cm','centimeter','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(3,'gm','gram','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL),(4,'qty','Quantity','2020-12-06 23:08:22','2020-12-06 23:08:22',NULL);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','superadmin@gmail.com','2020-12-06 23:08:21','$2y$10$nr.WpC8qsl1nqolWi/lvoeo.gDkllYdgcGSQLkRsNgvHbVA4wo5m2','ArmEVe5OGqbIfQrjZx9V9pfiO0X5OTH37oAtDc69soWpnT1Xz98bq27kj5s8','2020-12-06 23:08:21','2020-12-06 23:08:21'),(2,'Kelsie Parker','lind.berry@example.net','2020-12-06 23:08:21','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','qgCSz2YbyW','2020-12-06 23:08:21','2020-12-06 23:08:21'),(3,'Dr. Amani Considine','ryley.rohan@example.net','2020-12-06 23:08:21','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','SQEQbZfOgu','2020-12-06 23:08:21','2020-12-06 23:08:21');
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

-- Dump completed on 2020-12-13  1:23:25
