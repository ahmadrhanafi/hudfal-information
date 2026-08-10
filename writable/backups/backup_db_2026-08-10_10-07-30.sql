-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: db_hudfal
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `guru`
--

DROP TABLE IF EXISTS `guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_guru` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'L',
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kelas_diampu` int unsigned DEFAULT NULL,
  `status_aktif` enum('Aktif','Non-Aktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_kelas_diampu_foreign` (`id_kelas_diampu`),
  CONSTRAINT `guru_id_kelas_diampu_foreign` FOREIGN KEY (`id_kelas_diampu`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru`
--

LOCK TABLES `guru` WRITE;
/*!40000 ALTER TABLE `guru` DISABLE KEYS */;
INSERT INTO `guru` VALUES (1,'4687353521','Ust. Abdurrohim','L','08946613184',NULL,'Aktif','2026-07-30 12:54:10','2026-08-09 21:33:39'),(2,'1235232342','Ustz. Rosyidah','P','08123456789',5,'Aktif','2026-07-30 12:55:05','2026-07-30 12:55:05'),(3,'3321','Ust. Habibullah','L','08723156462',6,'Aktif','2026-08-02 16:22:26','2026-08-02 16:22:26'),(5,'2026322','Ustz. Maemunah','P','081254234634',4,'Aktif','2026-08-09 19:52:21','2026-08-09 19:52:21'),(9,'2026323','Ust. Ridho','L','0841212443423',3,'Aktif','2026-08-09 20:50:29','2026-08-09 21:11:37');
/*!40000 ALTER TABLE `guru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hafalan`
--

DROP TABLE IF EXISTS `hafalan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hafalan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_santri` int unsigned NOT NULL,
  `id_guru` int unsigned NOT NULL,
  `jenis` enum('ziyadah','murojaah') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ziyadah',
  `juz` int NOT NULL,
  `surah` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ayat_mulai` int NOT NULL,
  `ayat_selesai` int NOT NULL,
  `predikat` enum('Mumtaz','Jayyid Jiddan','Jayyid','Maqbul') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Mumtaz',
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hafalan_id_santri_foreign` (`id_santri`),
  KEY `hafalan_id_guru_foreign` (`id_guru`),
  CONSTRAINT `hafalan_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hafalan_id_santri_foreign` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hafalan`
--

LOCK TABLES `hafalan` WRITE;
/*!40000 ALTER TABLE `hafalan` DISABLE KEYS */;
INSERT INTO `hafalan` VALUES (1,1,1,'ziyadah',30,'Al-Kautsar',1,3,'Mumtaz','Lancar','2026-07-30 13:25:01','2026-07-30 13:25:01'),(2,3,1,'ziyadah',1,'Al-Baqarah',1,50,'Mumtaz','Lancar','2026-08-01 03:58:26','2026-08-01 03:58:26'),(3,1,1,'ziyadah',1,'Al-Baqarah',1,20,'Jayyid','Mantap','2026-08-01 05:28:28','2026-08-01 05:28:28'),(4,3,1,'ziyadah',1,'Al-Baqarah',1,15,'Maqbul','Cukup','2026-08-02 10:28:25','2026-08-02 10:28:25'),(5,3,1,'ziyadah',30,'Al-Asr',11,3,'Jayyid Jiddan','Bagus','2026-08-02 10:50:56','2026-08-02 10:50:56'),(6,3,1,'ziyadah',30,'Al-Ikhlas',1,4,'Jayyid Jiddan','Bagus','2026-08-02 10:52:19','2026-08-02 10:52:19'),(7,3,1,'murojaah',1,'Al-Baqarah',1,20,'Jayyid Jiddan','','2026-08-02 12:05:35','2026-08-02 12:05:35'),(8,4,3,'ziyadah',10,'Al-Kautsar',1,5,'Mumtaz','','2026-08-02 16:23:06','2026-08-02 16:23:06'),(9,4,3,'murojaah',8,'Al-Mu\'min',54,87,'Mumtaz','','2026-08-03 07:11:18','2026-08-03 07:11:18'),(12,2,2,'ziyadah',30,'Al-Fiil',1,5,'Mumtaz','','2026-08-03 15:57:20','2026-08-03 15:57:20'),(13,4,3,'murojaah',1,'Al-Fatihah',1,7,'Mumtaz','','2026-08-03 21:51:27','2026-08-08 14:03:33'),(14,4,3,'murojaah',3,'Ali \'Imran',1,20,'Mumtaz','Lancar','2026-08-04 19:44:44','2026-08-08 14:03:27'),(15,4,3,'ziyadah',2,'Al-Baqarah',142,252,'Mumtaz','','2026-08-08 18:05:12','2026-08-08 18:05:12'),(16,2,2,'ziyadah',2,'Al-Baqarah',169,207,'Mumtaz','','2026-08-08 18:22:10','2026-08-08 18:22:10'),(17,4,3,'ziyadah',8,'Al-An\'am',118,141,'Mumtaz','','2026-08-08 19:42:25','2026-08-08 19:42:25');
/*!40000 ALTER TABLE `hafalan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'1 Ibtida','2026-07-30 12:45:42','2026-07-30 12:45:42'),(2,'2 Ibtida','2026-07-30 12:45:42','2026-08-09 21:21:40'),(3,'3 Ibtida','2026-07-30 12:45:42','2026-08-09 21:11:37'),(4,'4 Ibtida','2026-07-30 12:45:42','2026-07-30 12:45:42'),(5,'5 Ibtida','2026-07-30 12:45:42','2026-07-30 12:45:42'),(6,'6 Ibtida','2026-07-30 12:45:42','2026-07-30 12:45:42'),(7,'1 Ulya','2026-08-09 19:44:09','2026-08-09 19:44:26');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (8,'20260626000001','App\\Database\\Migrations\\CreateKelasTable','default','App',1785415498,1),(9,'20260626000002','App\\Database\\Migrations\\CreateWaliTable','default','App',1785415498,1),(10,'20260626000003','App\\Database\\Migrations\\CreateGuruTable','default','App',1785415498,1),(11,'20260626000004','App\\Database\\Migrations\\CreateSantriTable','default','App',1785415499,1),(12,'20260626000005','App\\Database\\Migrations\\CreateHafalanTable','default','App',1785415500,1),(13,'20260626000006','App\\Database\\Migrations\\CreateUsersTable','default','App',1785415500,1),(14,'2026-07-28-165344','App\\Database\\Migrations\\CreatePembayaranTable','default','App',1785415500,1),(15,'2026-08-03-170754','App\\Database\\Migrations\\TambahKolomPembayaran','default','App',1785776904,2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_santri` int unsigned NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis_pembayaran` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `status` enum('Lunas','Pending','Menunggu Verifikasi','Gagal') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_tujuan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_konfirmasi` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_id_santri_foreign` (`id_santri`),
  CONSTRAINT `pembayaran_id_santri_foreign` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran`
--

LOCK TABLES `pembayaran` WRITE;
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
INSERT INTO `pembayaran` VALUES (3,4,'2026-08-04 00:53:00','Infaq Bangunan',250000.00,'Lunas','','2026-08-04 00:54:07','2026-08-04 01:28:50','1785781695_82afe9012a9566cbf9d8.pdf','BSI - 7123456789 (Yayasan Hudfal)','2026-08-04 01:24:00'),(4,2,'2026-08-04 12:06:00','Ujian Akhir Semester',150000.00,'Lunas','','2026-08-04 12:06:51','2026-08-04 12:28:19','1785820501_3578a3bea6eb8b8f90b6.pdf','BSI - 7123456789 (Yayasan Hudfal)','2026-08-04 12:14:00'),(5,2,'2026-08-04 13:14:00','SPP Bulan Agustus',500000.00,'Pending','','2026-08-04 13:14:52','2026-08-04 13:14:52',NULL,NULL,NULL),(6,3,'2026-08-04 13:14:00','SPP Bulan Agustus',500000.00,'Pending','','2026-08-04 13:14:52','2026-08-04 13:14:52',NULL,NULL,NULL),(7,4,'2026-08-04 13:14:00','SPP Bulan Agustus',500000.00,'Pending','','2026-08-04 13:14:52','2026-08-04 13:14:52',NULL,NULL,NULL),(8,2,'2027-01-04 14:33:00','Infaq Bangunan',250000.00,'Pending','','2026-08-04 14:33:29','2026-08-04 14:33:29',NULL,NULL,NULL);
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `santri`
--

DROP TABLE IF EXISTS `santri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `santri` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_santri` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'L',
  `id_kelas` int unsigned NOT NULL,
  `id_wali` int unsigned NOT NULL,
  `uid_kartu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_aktif` enum('Aktif','Lulus','Keluar') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `santri_id_kelas_foreign` (`id_kelas`),
  KEY `santri_id_wali_foreign` (`id_wali`),
  CONSTRAINT `santri_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `santri_id_wali_foreign` FOREIGN KEY (`id_wali`) REFERENCES `wali` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `santri`
--

LOCK TABLES `santri` WRITE;
/*!40000 ALTER TABLE `santri` DISABLE KEYS */;
INSERT INTO `santri` VALUES (1,'545745453143','Doni Firdaus',NULL,NULL,'L',3,2,NULL,'Lulus','2026-07-30 12:48:33','2026-08-03 17:17:18'),(2,'545645412321','Vira Fiona',NULL,NULL,'P',5,3,NULL,'Aktif','2026-07-30 12:52:46','2026-07-30 12:52:46'),(3,'352473213464','Tino Rosyidi',NULL,NULL,'L',3,1,NULL,'Aktif','2026-07-30 12:53:19','2026-07-30 12:53:19'),(4,'545641','Zulfikar',NULL,NULL,'L',6,1,NULL,'Aktif','2026-08-02 16:17:04','2026-08-02 16:17:04'),(6,'202604001','Dhika Andhika',NULL,NULL,'L',2,4,NULL,'Aktif','2026-08-09 19:49:30','2026-08-09 19:49:37');
/*!40000 ALTER TABLE `santri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','guru','wali') COLLATE utf8mb4_general_ci NOT NULL,
  `ref_id` int unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'Administrator','admin','$2y$12$Ubr698fw0gOshkfeFgQqieCuNv3z1aMpiwqRzUzfWMbva670/LbD.','admin',0,'2026-07-30 12:45:50','2026-07-30 12:45:50'),(4,NULL,'Indra Herlambang','0845434554531','$2y$12$.j1nCNW8wuUloeefa3i5kO3dZPORbqXtxHqgMU9.md.fBW.cLFfcC','wali',1,'2026-07-30 12:46:46','2026-07-30 12:46:46'),(5,NULL,'Raihan Mustofa','0845341454224','$2y$12$/.O6JaTUG8DNRFUpiwz3Zu2POGqhPnHrSzYOOuCxCICdXMe8/a3g6','wali',2,'2026-07-30 12:47:23','2026-07-30 12:47:23'),(6,NULL,'Chika Yuniar','0812335487453','$2y$12$COfUP1fMu1JSIUJ8XQTKFO0vOKEyE..JiKrhnE5727OkRBDeJzJhq','wali',3,'2026-07-30 12:47:52','2026-08-09 22:40:43'),(7,NULL,'Ust. Abdurrohim','4687353521','$2y$12$g7K7ulVqJyhRm9axi.7CZ.GKtTSji7iQk8UournR6TIufOt.7i9eC','guru',1,'2026-07-30 12:54:11','2026-08-09 21:33:39'),(8,NULL,'Ustz. Rosyidah','1235232342','$2y$12$bgitkeq5n2lPrqUkXtE2he8NJ9csJxHzGTpy1Zb2OFEjIKkNZUQv2','guru',2,'2026-07-30 12:55:05','2026-07-30 12:55:05'),(9,NULL,'Ust. Habibullah','3321','$2y$12$FP7EhuA7uKFbylgLk.jzrubA2ORzyY5EZCI2n7uwj1ZjnwLc/pxFy','guru',3,'2026-08-02 16:22:27','2026-08-02 16:22:27'),(10,NULL,'Hermawan','089724241643','$2y$12$mqZ0Rgte7Ck2NB9Bmj12uOhCzKoflCc8.1T9xxEAfPB7iSzwE3VeO','wali',4,'2026-08-09 19:39:00','2026-08-09 19:39:00'),(11,NULL,'Ustz. Maemunah','2026322','$2y$12$9yHjdHMC/m75cp1SDB90OeWTcw8ueLM4wos5DCafKiUd7pDDV9cBi','guru',5,'2026-08-09 19:52:21','2026-08-09 19:52:21'),(12,NULL,'Ust. Ridho','2026323','$2y$12$JST/KraJwwep/UAiqByLkeLp6HDz3zq2SPpUJB1noS3KHPQsAX3Oi','guru',9,'2026-08-09 20:50:29','2026-08-09 20:50:29');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wali`
--

DROP TABLE IF EXISTS `wali`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wali` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_wali` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wali`
--

LOCK TABLES `wali` WRITE;
/*!40000 ALTER TABLE `wali` DISABLE KEYS */;
INSERT INTO `wali` VALUES (1,'Indra Herlambang','0845434554531','Depok, No. 23','2026-07-30 12:46:46','2026-07-30 12:46:46'),(2,'Raihan Mustofa','0845341454224','Bogor, No. 56','2026-07-30 12:47:22','2026-07-30 12:47:22'),(3,'Chika Yuniar','0812335487453','Jakarta, No. 21','2026-07-30 12:47:52','2026-08-09 22:40:43'),(4,'Hermawan','089724241643','Citayem, No. 67','2026-08-09 19:38:59','2026-08-09 19:38:59');
/*!40000 ALTER TABLE `wali` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-10 10:07:34
