-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: Lendora
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` VALUES (6,23,NULL,NULL,NULL,'2026-04-21'),(7,25,NULL,NULL,NULL,'2026-04-22'),(8,26,NULL,NULL,NULL,'2026-04-22'),(9,27,NULL,NULL,NULL,'2026-04-22'),(10,28,NULL,NULL,NULL,'2026-04-22'),(11,30,NULL,NULL,NULL,'2026-04-22'),(12,33,NULL,NULL,NULL,'2026-04-23');
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku`
--

DROP TABLE IF EXISTS `buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `isbn` varchar(50) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_penulis` int(11) DEFAULT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0,
  `tersedia` int(11) DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_buku`),
  KEY `id_kategori` (`id_kategori`),
  KEY `id_penulis` (`id_penulis`),
  KEY `id_penerbit` (`id_penerbit`),
  CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id_penulis`),
  CONSTRAINT `buku_ibfk_3` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku`
--

LOCK TABLES `buku` WRITE;
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` VALUES (1,'9786020324784','Aku yang rindu',1,1,1,2025,6,6,'Aku mencintainya','1776492855_5f64e153e62b16205b28.png','2026-04-18 05:21:59'),(2,'201256482-4','Wulan Cantikk',4,2,3,2027,10,11,'aku mencintaimu','1776494448_664d59155242d028a9d3.jpg','2026-04-18 06:39:54'),(4,'202507071331','Rumah',1,3,3,2024,3,3,'Singgah di orang yang sama','1776527910_d02d2e92ec10955c3fbb.jpg','2026-04-18 15:55:56'),(5,'8+','Angkot Tua',2,1,2,2026,11,11,'Angkerrrrr','1776527811_82353dbcb6e75f000c87.jpg','2026-04-18 15:56:51'),(6,'20236548','Didit yang ku sayang',4,1,1,2027,3,3,'Dia pemilik hati akuuu','1776527868_fdb4c94d19634709995d.webp','2026-04-18 15:57:48'),(7,'210256','Hujan',4,3,2,2024,4,4,'Hujan','1776660234_18476aaa159e50e9a4cc.jpg','2026-04-20 04:43:54'),(8,'9786230061417','Hewan Aneh Di Bumi',2,4,5,2024,8,7,'Kita sangat beruntung hidup di planet Bumi yang punya jutaan spesies hewan menakjubkan. Di antaranya ada hewan yang mempunyai bentuk dan perilaku sangat aneh, berbeda dengan hewan-hewan yang bisa kita temukan sehari-hari. Ayo, kita jelajahi Bumi bersama Ali si alien, Robi si Robot, serta Dodi dan Dewi untuk mencari hewan-hewan aneh. Kita akan menuju hutan terlebat, gurun terpanas, dan lautan terdalam karena petualangan seru telah menanti.\r\n','1776970378_17b18ac1ae6933e28cab.avif','2026-04-21 14:48:11'),(9,' 978-623-8039-03-6','Pendidikan Karakter',6,5,6,2022,7,6,'Pendidikan Karakter di banyak sekolah pada saat ini belum menemukan format yang pas untuk membentuk karakter-karakter atau nilai-nilai yang ingin ditanamkan. Tampaknya tidak sulit untuk menyimpulkan bahwa pendidikan karakter belum terlaksana secara efektif dalam proses pendidikan. ','1776783107_e059aa5084ddc99e6bc6.png','2026-04-21 14:51:47'),(10,'202156438-09','Buku Saku Dokter',3,6,7,2021,11,11,'Buku Saku Dokter adalah pedoman peresepan yang ringkas dan terkini. Pedoman ini memuat semua informasi \"penting\" yang diperlukan dengan segera oleh para dokter muda, perawat pemberi resep, dan mahasiswa kedokteran.','1776789880_3de7c7b425d67d8325fe.jpg','2026-04-21 16:44:40'),(11,' 9786024251796','Manajemen keuangan : sebagai dasar pengembilan keputusan bisnis',7,7,8,2018,8,10,'Manajemen keuangan adalah keseluruhan aktivitas perusahaan yang berhubungan dengan usaha mendapatkan dana yang diperlukan dengan biaya yang minimal dan syarat-syarat yang paling menguntungkan beserta usaha untuk menggunakan dana tersebut seefisien mungkin. ','1776790063_95ce51450a176283e9be.jpg','2026-04-21 16:47:43');
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buku_rak`
--

DROP TABLE IF EXISTS `buku_rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buku_rak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_buku` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_buku` (`id_buku`),
  KEY `id_rak` (`id_rak`),
  CONSTRAINT `buku_rak_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  CONSTRAINT `buku_rak_ibfk_2` FOREIGN KEY (`id_rak`) REFERENCES `rak` (`id_rak`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buku_rak`
--

LOCK TABLES `buku_rak` WRITE;
/*!40000 ALTER TABLE `buku_rak` DISABLE KEYS */;
INSERT INTO `buku_rak` VALUES (1,1,1),(2,2,2),(4,4,2),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,5),(10,10,2),(11,11,3);
/*!40000 ALTER TABLE `buku_rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denda`
--

DROP TABLE IF EXISTS `denda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denda` (
  `id_denda` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengembalian` int(11) DEFAULT NULL,
  `jumlah_denda` decimal(10,2) DEFAULT NULL,
  `status_denda` enum('belum','menunggu','lunas','ditolak') DEFAULT 'belum',
  `metode_pembayaran` enum('cash','qris') DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `id_petugas_verif` int(11) DEFAULT NULL,
  `tanggal_verifikasi` datetime DEFAULT NULL,
  PRIMARY KEY (`id_denda`),
  KEY `id_pengembalian` (`id_pengembalian`),
  CONSTRAINT `denda_ibfk_1` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id_pengembalian`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denda`
--

LOCK TABLES `denda` WRITE;
/*!40000 ALTER TABLE `denda` DISABLE KEYS */;
INSERT INTO `denda` VALUES (6,21,1000.00,'lunas','cash',NULL,NULL,NULL),(7,22,4000.00,'lunas','qris','1776969727_134d837892c3515c45a4.png',NULL,NULL),(8,24,2000.00,'lunas','qris','1777014114_b739eadfeb2c5d36b6cd.jpg',NULL,'2026-04-24 07:05:35'),(10,26,1000.00,'lunas','qris','1777049434_380ab0f2f24f35b4e64f.jpg',32,NULL),(11,27,2000.00,'belum',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `denda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_peminjaman`
--

DROP TABLE IF EXISTS `detail_peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_peminjaman` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_peminjaman` (`id_peminjaman`),
  KEY `id_buku` (`id_buku`),
  CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  CONSTRAINT `detail_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_peminjaman`
--

LOCK TABLES `detail_peminjaman` WRITE;
/*!40000 ALTER TABLE `detail_peminjaman` DISABLE KEYS */;
INSERT INTO `detail_peminjaman` VALUES (31,79,8,1),(32,79,5,1),(35,81,5,1),(36,81,10,1),(38,83,2,1),(39,83,11,1),(40,84,1,1),(41,84,8,1),(42,85,10,1),(43,85,11,1),(44,86,9,1),(45,86,10,1),(46,87,8,1);
/*!40000 ALTER TABLE `detail_peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Cinta'),(2,'Komik'),(3,'Sains'),(4,'Novel'),(5,'Teknologi'),(6,'Pendidikan'),(7,'Pelajaran');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_aktivitas`
--

DROP TABLE IF EXISTS `log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_log`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_aktivitas`
--

LOCK TABLES `log_aktivitas` WRITE;
/*!40000 ALTER TABLE `log_aktivitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan','terlambat') DEFAULT 'dipinjam',
  `perpanjang` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_peminjaman`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `fk_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_petugas` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_users` FOREIGN KEY (`id_anggota`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (79,25,31,'2026-04-23','2026-04-30','dikembalikan',0),(81,27,31,'2026-04-12','2026-04-19','dikembalikan',0),(83,33,32,'2026-04-15','2026-04-22','dikembalikan',0),(84,28,32,'2026-04-16','2026-04-22','dikembalikan',0),(85,33,32,'2026-04-16','2026-04-23','dikembalikan',0),(86,27,31,'2026-04-24','2026-05-01','dipinjam',0),(87,33,31,'2026-04-24','2026-05-01','dipinjam',0);
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerbit`
--

DROP TABLE IF EXISTS `penerbit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penerbit` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  PRIMARY KEY (`id_penerbit`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerbit`
--

LOCK TABLES `penerbit` WRITE;
/*!40000 ALTER TABLE `penerbit` DISABLE KEYS */;
INSERT INTO `penerbit` VALUES (1,'Greenbook','Bandung'),(2,'Book','Bandung'),(3,'IcaBook','Rancaekek'),(4,'Cv.Cadit','Braga'),(5,'Elex Media Komputindo','Bogor'),(6,'Gramedia','Jakarta'),(7,'Cv.Doktor','Bandung'),(8,'Depok : Rajawali Pers','Depok\r\n');
/*!40000 ALTER TABLE `penerbit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengembalian`
--

DROP TABLE IF EXISTS `pengembalian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int(11) DEFAULT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `denda` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`id_pengembalian`),
  KEY `id_peminjaman` (`id_peminjaman`),
  CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengembalian`
--

LOCK TABLES `pengembalian` WRITE;
/*!40000 ALTER TABLE `pengembalian` DISABLE KEYS */;
INSERT INTO `pengembalian` VALUES (21,83,'2026-04-23',0.00),(22,81,'2026-04-23',0.00),(23,79,'2026-04-23',0.00),(24,84,'2026-04-24',0.00),(26,85,'2026-04-24',0.00),(27,83,'2026-04-24',0.00);
/*!40000 ALTER TABLE `pengembalian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penulis`
--

DROP TABLE IF EXISTS `penulis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penulis` (
  `id_penulis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penulis` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_penulis`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penulis`
--

LOCK TABLES `penulis` WRITE;
/*!40000 ALTER TABLE `penulis` DISABLE KEYS */;
INSERT INTO `penulis` VALUES (1,'Karisa wulan'),(2,'Didit Fathul'),(3,'Tere liye'),(4,'Ali alien'),(5,'Drs. B. Sarta Ketut, M.Pd'),(6,'Timothy RJ Nicholson & Donald RJ Singer'),(7,'Gede Adi Yuniarta');
/*!40000 ALTER TABLE `penulis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_petugas`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `petugas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
INSERT INTO `petugas` VALUES (7,31,NULL),(8,32,NULL);
/*!40000 ALTER TABLE `petugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rak`
--

DROP TABLE IF EXISTS `rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rak` (
  `id_rak` int(11) NOT NULL AUTO_INCREMENT,
  `nama_rak` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_rak`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rak`
--

LOCK TABLES `rak` WRITE;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` VALUES (1,'A 100 - 200','Lantai 1'),(2,'B 200 - 300','Lantai 1'),(3,'C 300 - 400','Lantai 1'),(4,'D 400 - 500','Lantai 2'),(5,'E 500 - 600','Lantai 2');
/*!40000 ALTER TABLE `rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservasi`
--

DROP TABLE IF EXISTS `reservasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservasi` (
  `id_reservasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tanggal_reservasi` date DEFAULT NULL,
  `status` enum('menunggu','disetujui','dibatalkan') DEFAULT 'menunggu',
  PRIMARY KEY (`id_reservasi`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_buku` (`id_buku`),
  CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`),
  CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservasi`
--

LOCK TABLES `reservasi` WRITE;
/*!40000 ALTER TABLE `reservasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int(11) DEFAULT NULL,
  `jenis` enum('denda','pengiriman','penarikan') DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `status` enum('belum_bayar','lunas') DEFAULT 'belum_bayar',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_transaksi`),
  KEY `id_peminjaman` (`id_peminjaman`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ulasan`
--

DROP TABLE IF EXISTS `ulasan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL AUTO_INCREMENT,
  `id_buku` int(11) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_ulasan`),
  KEY `id_buku` (`id_buku`),
  KEY `id_anggota` (`id_anggota`),
  CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ulasan`
--

LOCK TABLES `ulasan` WRITE;
/*!40000 ALTER TABLE `ulasan` DISABLE KEYS */;
/*!40000 ALTER TABLE `ulasan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas','anggota') DEFAULT 'anggota',
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Karisa Wulan Dini','karisa.wulan70@smk.belajar.id','wulndn','$2y$10$2axBs7KGaZd/0FYmF4VjrO3hb3h4xL8lHr4PUlKz./dskilET7Beu','admin','1776754707_b9f2b8e7cb625b5dba7f.jpg','aktif','2026-04-18 05:08:11'),(23,'kiww kiww','kiw@gmail.com','Kiw kiw','$2y$10$f9kaMS3tVbmRJE9x6K.W4eJN/wY6oN.VLoB4dXlOBTWoXZK1rums.','anggota','1776755104_a83cbd132af1e43a6313.jpg','aktif','2026-04-21 07:05:04'),(25,'Siti Kartika','Kartika@gmail.com','tika','$2y$10$Xu5ZPN2GBqYadnT5k52YIeEv74V8tU5IZdEFNJvI8TxfRI8oT4qay','anggota','1776827889_7e1badeb7e02676b115a.png','aktif','2026-04-22 03:18:10'),(26,'Siti Humairah N','Humairah@gmail.com','Umaaa','$2y$10$UGJU4EVd4JVlHfHQdBdKW./pJ4Pm8EvLvCn6imw9f.CtXfZ5qL8DG','anggota','1776828173_60fa52203c2b268d6077.jpg','aktif','2026-04-22 03:22:53'),(27,'Shalisshatul','Shalis@gmail.com','utee','$2y$10$zW7rc5RIyL1Q1na34Tsr9OKSMbZfb3n2Ff0uJWU0rpBDnoKqwQL4q','anggota','1776828204_759ada3c36b0de7a1138.jpg','aktif','2026-04-22 03:23:24'),(28,'Iis Sadiyah','iis@gmail.com','Iis','$2y$10$70wVBE/N4i8LWIrELPeaKum800RNmJoUFOqkN//34tAGaYsBVfdPq','anggota','1776845063_6b3e480f3a44abc540ad.png','aktif','2026-04-22 08:04:23'),(30,'Didit Fathul Mubin','didit.fathul@gmail.com','bangdit','$2y$10$hPVtJzY.UzoUUzjbwBwfeOU239dAb9AzeqACpVHpMtavRARQAA0WS','anggota','1776918031_7e4fbfc3ce3639dea82e.png','aktif','2026-04-22 19:32:20'),(31,'Caca','caca@gmail.com','caca','$2y$10$qzSVDKJDy/ZYr6xS5fiC7.OTt7fGyPxIfWkVod4y4hKw8UatEJO6G','petugas','1776918042_ff2c14554ba44ea36ea2.png','aktif','2026-04-22 20:22:18'),(32,'Ayu Riska','AyuRiska@gmail.com','ayuu','$2y$10$vaMOzGq9Kg3nADjJn7RIXOaBEuU9zrLfdHDNrg64sdp7f9a6Od7jy','petugas',NULL,'aktif','2026-04-23 15:24:03'),(33,'Imey Siti','ImeySiti@gmail.com','imey','$2y$10$m7md7UJsO8/eOQ9CauOEG.uk/GJXAQR73YTTrZRg00mB3Y15e43W2','anggota',NULL,'aktif','2026-04-23 15:26:07');
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

-- Dump completed on 2026-04-25  3:07:52
