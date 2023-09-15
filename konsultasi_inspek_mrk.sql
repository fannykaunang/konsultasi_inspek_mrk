-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Sep 15, 2023 at 06:09 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konsultasi_inspek_mrk`
--

-- --------------------------------------------------------

--
-- Table structure for table `aplikasi_skpd`
--

CREATE TABLE `aplikasi_skpd` (
  `IDSKPD` int(11) NOT NULL,
  `NoTelp` text NOT NULL,
  `Alamat` text NOT NULL,
  `NamaSKPD` text NOT NULL,
  `TglInput` datetime NOT NULL,
  `TglUpdate` datetime NOT NULL,
  `UserID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aplikasi_skpd`
--

INSERT INTO `aplikasi_skpd` (`IDSKPD`, `NoTelp`, `Alamat`, `NamaSKPD`, `TglInput`, `TglUpdate`, `UserID`) VALUES
(1, '0971321840', 'JL. TMP TRIKORA No. 78\nMERAUKE', 'DINAS KOMUNIKASI DAN INFORMATIKA', '2015-03-17 08:34:51', '2015-03-17 08:34:51', '8'),
(2, '0971325474', 'JL. MISSI No. 03 - KELURAHAN MANDALA MERAUKE', 'DINAS KEPENDUDUKAN DAN CATATAN SIPIL', '2015-03-17 08:38:55', '2015-03-17 08:38:55', '8'),
(4, '0971321356 - 0971324414', 'JL. Garuda Mopah Lama', 'DINAS KESEHATAN', '2015-03-17 09:07:48', '2015-03-17 09:13:32', '31'),
(5, '0971325949', 'Jl. Trikora, No.15 - Merauke', 'DINAS PERTAMBANGAN DAN ENERGI', '2015-03-17 09:12:26', '2015-03-17 09:12:26', '31'),
(6, '0971321137, Fax. 0971321373', 'Jl. Missi No 1, Merauke', 'DINAS PENDIDIKAN DAN PENGAJARAN', '2015-03-17 09:16:48', '2015-03-17 10:03:12', '31'),
(7, '0971326164, Fax. 323484', 'Jl. Prajurit , Kompleks Gedung Olah Raga Head Sai Merauke', 'DINAS PEMUDA DAN OLAH RAGA', '2015-03-17 09:18:34', '2015-03-17 10:00:51', '31'),
(8, '0971321350', 'Jl. RE Marthadinata Merauke', 'DINAS SOSIAL', '2015-03-17 09:19:40', '2015-03-17 09:43:21', '31'),
(9, '0971321485 - Fax 0971323386', 'Jl. Mayor Wiratno Merauke', 'DINAS TENAGA KERJA DAN TRANSMIGRASI', '2015-03-17 09:21:14', '2015-03-17 09:46:12', '31'),
(10, '0971321929, 0971321681 - Fax. 0971323871', 'Jl.Ermasu No. 67 Merauke\n', 'DINAS PERHUBUNGAN', '2015-03-17 09:21:37', '2015-03-17 09:45:43', '31'),
(11, '0971321031  Fax. 0971323840', 'Jl. TMP. Merauke\n', 'DINAS PENDAPATAN DAERAH', '2015-03-17 09:23:58', '2015-03-17 10:09:54', '31'),
(12, '0971324738', 'Jl. Yos Sudarso No.14 Merauke', 'DINAS KEBUDAYAAN DAN PARIWISATA', '2015-03-17 09:25:55', '2015-03-17 09:58:44', '31'),
(13, '0971325559, FAX. 097132572', 'Jl. Ermasu No.1, Merauke\n', 'DINAS PEKERJAAN UMUM', '2015-03-17 09:26:27', '2015-03-17 10:04:03', '31'),
(14, '0971321722', 'Jl. RE. Marthadinata Merauke', 'DINAS KOPERASI, USAHA MIKRO, KECIL, DAN MENENGAH, PERINDUSTRIAN, DAN PERDAGANGAN', '2015-03-17 09:27:16', '2015-03-17 10:05:16', '31'),
(15, '0971', 'Jl. Ahmad Yani Merauke', 'DINAS TANAMAN PANGAN DAN HORTIKULTURA', '2015-03-17 09:28:00', '2015-03-17 09:53:58', '31'),
(16, '0971321113, 0971325220, Fax 0971323875', 'Jl. Peternakan Merauke', 'DINAS PETERNAKAN DAN KESEHATAN HEWAN', '2015-03-17 09:29:10', '2015-03-17 10:07:54', '31'),
(17, '0971324346', 'Jalan Perikanan Kelapa Lima Merauke\n', 'DINAS KELAUTAN DAN PERIKANAN', '2015-03-17 09:29:45', '2015-03-17 10:08:28', '31'),
(18, '0971321869  - Fax. 0971321985', 'Jl. Ahmad Yani', 'DINAS KEHUTANAN DAN PERKEBUNAN', '2015-03-17 09:30:21', '2015-03-17 09:55:04', '31'),
(19, '0971321154', 'Jl. Trikora No.1, Merauke', 'DINAS TATA KOTA DAN PEMAKAMAN', '2015-03-17 09:30:50', '2015-03-17 10:10:23', '31'),
(20, '0971322968', 'Jl. Spadem', 'INSPEKTORAT', '2015-03-17 10:16:38', '2015-03-17 10:16:38', '31'),
(21, '0971', 'Merauke', 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', '2015-03-17 10:17:30', '2015-03-17 10:17:30', '31'),
(22, '0971321613', 'Jl. Ahmad Yani Merauke', 'BADAN KESATUAN BANGSA DAN POLITIK', '2015-03-17 10:21:38', '2015-03-17 10:21:38', '31'),
(23, '0971321177', 'Merauke', 'BADAN PENANAMAN MODAL DAN PELAYANAN PERIJINAN TERPADU', '2015-03-17 10:23:24', '2015-03-17 10:23:24', '31'),
(24, '0971', 'Merauke', 'BADAN PEMBERDAYAAN MASYARAKAT KAMPUNG', '2015-03-17 10:24:13', '2015-03-17 10:24:13', '31'),
(25, '0971', 'Jl. Yobar 1 Merauke', 'BADAN KEPEGAWAIAN< PENDIDIKAN< DAN PELATIHAN', '2015-03-17 10:25:19', '2015-03-17 10:25:19', '31'),
(26, '0971321228', 'Jl. Peternakan Mopah Lama Merauke', 'BADAN LINGKUNGAN HIDUP', '2015-03-17 10:26:31', '2015-03-17 10:26:31', '31'),
(27, '0971321525', 'Jl.Prajurit No. 5 Merauke', 'Badan Pengelolaan Perbatasan Daerah', '2015-03-17 10:28:16', '2015-03-17 10:28:16', '31'),
(28, '0971', 'Jl. Trikora Merauke', 'BADAN PEMBERDAYAAN PEREMPUAN DAN KELUARGA BERENCANA', '2015-03-17 10:29:20', '2015-03-17 10:29:20', '31'),
(29, '0971', 'Jl. Ahmad Yani Merauke', 'BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH', '2015-03-17 10:30:06', '2015-03-17 10:30:06', '31'),
(30, '0971', 'Merauke', 'BADAN PELAKSANAAN PENYULUHAN PERTANIAN, PERIKANAN, DAN KEHUTANAN', '2015-03-17 10:31:03', '2015-03-17 10:31:03', '31'),
(31, '0971326054', 'Jl. Missi No.5 Merauke', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', '2015-03-17 10:31:55', '2015-03-17 10:31:55', '31'),
(32, '0971', 'Jl. Prajurit Merauke', 'SATUAN POLISI PAMONG PRAJA', '2015-03-17 10:32:53', '2015-03-17 10:32:53', '31'),
(33, '0971', 'Merauke', 'RUMAH SAKIT UMUM DAERAH', '2015-03-17 10:33:40', '2015-03-17 10:33:40', '31'),
(34, '0971323481', 'Jl. Sukarelawati Merauke', 'SETDA BAGIAN PEMERINTAHAN', '2015-03-17 10:36:58', '2015-03-17 10:36:58', '31'),
(35, '0971', 'Merauke', 'SETDA BAGIAN PEMERINTAHAN KAMPUNG', '2015-03-17 10:37:25', '2015-03-17 10:37:25', '31'),
(36, '0971', 'Jl. Parakomando Merauke', 'SETDA BAGIAN ADMINISTRASI KEEJAHTERAAN RAKYAT', '2015-03-17 10:38:39', '2015-03-17 10:38:39', '31'),
(37, '0971', 'Jl. Raya Mandala Merauke', 'SETDA BAGIAN HUMAS DAN PROTOKOLER', '2015-03-17 10:39:15', '2015-03-17 10:39:15', '31'),
(38, '0971', 'Jl. RE. Marthadinata Merauke', 'SETDA BAGIAN ADMINISTRASI PEMBANGUNAN', '2015-03-17 10:40:06', '2015-03-17 10:40:06', '31'),
(39, '0971', 'Jl. Parakomando Merauke', 'SETDA BAGIAN ADMINISTRASI PEREKONOMIAN', '2015-03-17 10:41:13', '2015-03-17 10:41:13', '31'),
(40, '0971', 'Merauke', 'SETDA BAGIAN HUKUM', '2015-03-17 10:42:05', '2015-03-17 10:42:05', '31'),
(41, '0971', 'Merauke', 'SETDA BAGIAN ORGANISASI', '2015-03-17 10:42:29', '2015-03-17 10:42:29', '31'),
(42, '0971', 'Merauke', 'SETDA BAGIAN UMUM', '2015-03-17 10:43:07', '2015-03-17 10:43:07', '31');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `IdCategory` bigint(20) NOT NULL,
  `NameCategory` varchar(100) NOT NULL,
  `NoteCategory` varchar(100) NOT NULL,
  `FlagPublish` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emailresetpassword`
--

CREATE TABLE `emailresetpassword` (
  `IDEmail` int(11) NOT NULL,
  `Email` text NOT NULL,
  `TglQueryReset` datetime NOT NULL,
  `TglExpired` datetime NOT NULL,
  `Key` text NOT NULL,
  `Status` text NOT NULL,
  `IPAddress` text NOT NULL,
  `Browser` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emailsettings`
--

CREATE TABLE `emailsettings` (
  `smtp_host` text NOT NULL,
  `smtp_port` int(5) NOT NULL,
  `smtp_user` text NOT NULL,
  `smtp_pass` text NOT NULL,
  `protocol` text NOT NULL,
  `mailtype` text NOT NULL,
  `wordwrap` text NOT NULL,
  `smtp_crypto` text DEFAULT NULL,
  `charset` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emailsettings`
--

INSERT INTO `emailsettings` (`smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `protocol`, `mailtype`, `wordwrap`, `smtp_crypto`, `charset`) VALUES
('mail.merauke.go.id', 587, 'webmaster@merauke.go.id', 'webmaster_2011', 'smtp', 'html', 'true', 'tls', 'utf-8');

-- --------------------------------------------------------

--
-- Table structure for table `filemanager`
--

CREATE TABLE `filemanager` (
  `IdFile` bigint(20) NOT NULL,
  `Filename` text DEFAULT NULL,
  `Dirname` text DEFAULT NULL,
  `Extension` text DEFAULT NULL,
  `Basename` text DEFAULT NULL,
  `Fullpath` text DEFAULT NULL,
  `Filesize` text DEFAULT NULL,
  `Status` text DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `IdUser` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `irban`
--

CREATE TABLE `irban` (
  `IdIrban` bigint(20) NOT NULL,
  `Time` datetime DEFAULT NULL,
  `NamaPegawai` text DEFAULT NULL,
  `NoTelp` text NOT NULL,
  `IdCategory` int(10) NOT NULL,
  `IdSkpd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `irban_category`
--

CREATE TABLE `irban_category` (
  `IdCategory` int(10) NOT NULL,
  `NameCategory` varchar(100) DEFAULT NULL,
  `Description` text NOT NULL,
  `Time` datetime DEFAULT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `IdKonsultasi` bigint(20) UNSIGNED NOT NULL,
  `Author` varchar(20) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Content` longtext NOT NULL,
  `Time` datetime NOT NULL,
  `FlagPublish` tinyint(1) NOT NULL,
  `Category` varchar(35) NOT NULL,
  `IdUser` int(10) DEFAULT NULL,
  `IdCategory` int(10) DEFAULT NULL,
  `FlagPublishInspektur` tinyint(4) NOT NULL,
  `FlagAcceptInspektur` tinyint(4) NOT NULL,
  `CatatanInspektur` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `logssystem`
--

CREATE TABLE `logssystem` (
  `IdLog` bigint(12) NOT NULL,
  `IdUser` bigint(12) DEFAULT NULL,
  `IPAddress` text DEFAULT NULL,
  `Url` text DEFAULT NULL,
  `Browser` text DEFAULT NULL,
  `TimeStamp` datetime DEFAULT NULL,
  `Platform` text DEFAULT NULL,
  `Referer` text DEFAULT NULL,
  `AgentString` text DEFAULT NULL,
  `TypeLog` text DEFAULT NULL,
  `ContentLog` text DEFAULT NULL,
  `StatusLog` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logssystem`
--

INSERT INTO `logssystem` (`IdLog`, `IdUser`, `IPAddress`, `Url`, `Browser`, `TimeStamp`, `Platform`, `Referer`, `AgentString`, `TypeLog`, `ContentLog`, `StatusLog`) VALUES
(1, NULL, '::1', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', 'Chrome', '2023-09-03 11:53:07', 'Windows 10', NULL, NULL, 'SystemLog', 'Halaman login', 'akses'),
(2, NULL, '::1', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', 'Chrome', '2023-09-03 11:54:07', 'Windows 10', NULL, NULL, 'SystemLog', 'Halaman login', 'akses'),
(3, NULL, '::1', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', 'Chrome', '2023-09-03 12:27:37', 'Windows 10', NULL, NULL, 'SystemLog', 'Halaman login', 'akses');

-- --------------------------------------------------------

--
-- Table structure for table `logsuser`
--

CREATE TABLE `logsuser` (
  `IdLog` bigint(12) NOT NULL,
  `IdUser` bigint(12) DEFAULT NULL,
  `IPAddress` text DEFAULT NULL,
  `Url` text DEFAULT NULL,
  `Browser` text DEFAULT NULL,
  `TimeStamp` datetime DEFAULT NULL,
  `Platform` text DEFAULT NULL,
  `Referer` text DEFAULT NULL,
  `AgentString` text DEFAULT NULL,
  `TypeLog` text DEFAULT NULL,
  `ContentLog` text DEFAULT NULL,
  `StatusLog` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logsuser`
--

INSERT INTO `logsuser` (`IdLog`, `IdUser`, `IPAddress`, `Url`, `Browser`, `TimeStamp`, `Platform`, `Referer`, `AgentString`, `TypeLog`, `ContentLog`, `StatusLog`) VALUES
(1, 1, '::1', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', 'Chrome', '2023-09-03 11:53:09', 'Windows 10', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'system', 'User: Fanny Alfa Kaunang', 'login success'),
(2, 1, '::1', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', 'Chrome', '2023-09-03 11:54:09', 'Windows 10', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'system', 'User: Fanny Alfa Kaunang', 'login success'),
(3, 1, '::1', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', 'Chrome', '2023-09-03 12:27:39', 'Windows 10', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', 'system', 'User: Fanny Alfa Kaunang', 'login success');

-- --------------------------------------------------------

--
-- Table structure for table `logsvisitor`
--

CREATE TABLE `logsvisitor` (
  `IdLog` bigint(12) NOT NULL,
  `IPAddress` text NOT NULL,
  `Browser` text DEFAULT NULL,
  `TimeStamp` datetime DEFAULT NULL,
  `URL` text DEFAULT NULL,
  `Mobile` text DEFAULT NULL,
  `Version` text DEFAULT NULL,
  `Robot` text DEFAULT NULL,
  `Platform` text DEFAULT NULL,
  `Referer` text DEFAULT NULL,
  `AgentString` text DEFAULT NULL,
  `IsMobile` text DEFAULT NULL,
  `IsBrowser` text DEFAULT NULL,
  `IsRobot` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logsvisitor`
--

INSERT INTO `logsvisitor` (`IdLog`, `IPAddress`, `Browser`, `TimeStamp`, `URL`, `Mobile`, `Version`, `Robot`, `Platform`, `Referer`, `AgentString`, `IsMobile`, `IsBrowser`, `IsRobot`) VALUES
(1, '::1', 'Chrome', '2023-09-03 11:53:07', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', '', '116.0.0.0', '', 'Windows', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '0', '1', '0'),
(2, '::1', 'Chrome', '2023-09-03 11:54:07', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', '', '116.0.0.0', '', 'Windows', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '0', '1', '0'),
(3, '::1', 'Chrome', '2023-09-03 12:27:37', 'http://localhost:9090/konsultasi_inspek_mrk/backend/login.html', '', '116.0.0.0', '', 'Windows', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '0', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `IdNews` bigint(20) UNSIGNED NOT NULL,
  `AuthorNews` varchar(20) NOT NULL,
  `TitleNews` varchar(200) NOT NULL,
  `ContentNews` longtext NOT NULL,
  `CreatedNews` datetime NOT NULL,
  `UpdatedNews` datetime NOT NULL,
  `FlagPublish` tinyint(1) NOT NULL,
  `FlagComment` tinyint(1) NOT NULL,
  `FlagEditByOther` tinyint(4) NOT NULL,
  `CategoryNews` varchar(35) NOT NULL,
  `UpdatedBy` varchar(20) NOT NULL,
  `FlagDate` tinyint(4) NOT NULL,
  `ReadRating` int(20) NOT NULL,
  `Thumbnail` text DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `IdUser` int(10) DEFAULT NULL,
  `IdCategory` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `onlineuser`
--

CREATE TABLE `onlineuser` (
  `UserName` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `ID` int(3) NOT NULL,
  `Author` text NOT NULL,
  `Quote` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quote`
--

INSERT INTO `quote` (`ID`, `Author`, `Quote`) VALUES
(1, 'Stephen Hawking', 'Betapapun sulitnya hidup, selalu ada sesuatu yang dapat kamu lakukan dan berhasil.'),
(2, 'Albert Einstein', 'Kegilaan adalah melakukan hal yang sama berulang-ulang dan mengharapkan hasil yang berbeda.'),
(3, 'Paus Fransiskus ', 'Tuhan tidak pernah lelah mengampuni kita; kita adalah orang-orang yang lelah mencari belas kasihan-Nya.');

-- --------------------------------------------------------

--
-- Table structure for table `settingbackend`
--

CREATE TABLE `settingbackend` (
  `MaxDataPerPage` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settingbackend`
--

INSERT INTO `settingbackend` (`MaxDataPerPage`) VALUES
(10),
(10);

-- --------------------------------------------------------

--
-- Table structure for table `settingfrontend`
--

CREATE TABLE `settingfrontend` (
  `VisitorLog` text NOT NULL,
  `ShowMaxNews` int(3) NOT NULL,
  `CommentModule` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settingfrontend`
--

INSERT INTO `settingfrontend` (`VisitorLog`, `ShowMaxNews`, `CommentModule`) VALUES
('ON', 5, 'ON'),
('OFF', 5, 'ON');

-- --------------------------------------------------------

--
-- Table structure for table `settinggeneral`
--

CREATE TABLE `settinggeneral` (
  `WebStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settinggeneral`
--

INSERT INTO `settinggeneral` (`WebStatus`) VALUES
('ONLINE'),
('ONLINE');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `SiteMode` text DEFAULT NULL,
  `MaxLogs` int(10) DEFAULT NULL,
  `Email` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`SiteMode`, `MaxLogs`, `Email`) VALUES
('online', 1000000, 'pupr@merauke.go.id');

-- --------------------------------------------------------

--
-- Table structure for table `settingsfrontslider`
--

CREATE TABLE `settingsfrontslider` (
  `Image` text NOT NULL,
  `Caption` text NOT NULL,
  `Deskripsi` text NOT NULL,
  `Flag` tinyint(1) NOT NULL,
  `IdSlide` int(11) NOT NULL,
  `FirstSlide` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `skpd`
--

CREATE TABLE `skpd` (
  `IdSkpd` int(11) NOT NULL,
  `NamaSkpd` text NOT NULL,
  `SkpdAlias` text NOT NULL,
  `NoTelp` text NOT NULL,
  `Author` text NOT NULL,
  `Email` text NOT NULL,
  `UpdatedBy` text NOT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL,
  `FlagPublish` tinyint(4) NOT NULL,
  `Alamat` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skpd`
--

INSERT INTO `skpd` (`IdSkpd`, `NamaSkpd`, `SkpdAlias`, `NoTelp`, `Author`, `Email`, `UpdatedBy`, `DateCreated`, `LastUpdated`, `FlagPublish`, `Alamat`) VALUES
(1, 'DINAS KOMUNIKASI & INFORMARTIKA', 'DISKOMINFO', '3336611', '', 'KOMINFO@MERAUKE.GO.ID', '', '2023-06-27 07:48:27', NULL, 0, 'JALAN TMP POLDER');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `IdFile` bigint(20) NOT NULL,
  `Filename` text DEFAULT NULL,
  `Dirname` text DEFAULT NULL,
  `Extension` text DEFAULT NULL,
  `Basename` text DEFAULT NULL,
  `Fullpath` text DEFAULT NULL,
  `Filesize` bigint(50) DEFAULT NULL,
  `FlagPublish` tinyint(1) DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `IdUser` text DEFAULT NULL,
  `Caption` text DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `telepon_penting`
--

CREATE TABLE `telepon_penting` (
  `IdFile` bigint(20) NOT NULL,
  `Name` text DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `NoTelp` text DEFAULT NULL,
  `FlagPublish` tinyint(1) DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `IdUser` text DEFAULT NULL,
  `IdCategory` int(10) NOT NULL,
  `TglInput` datetime NOT NULL,
  `TglUpdate` datetime NOT NULL,
  `ReadRating` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `telepon_penting_category`
--

CREATE TABLE `telepon_penting_category` (
  `IdCategory` int(10) NOT NULL,
  `NameCategory` text DEFAULT NULL,
  `Description` text NOT NULL,
  `FlagPublish` int(1) NOT NULL,
  `Time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `telepon_penting_category`
--

INSERT INTO `telepon_penting_category` (`IdCategory`, `NameCategory`, `Description`, `FlagPublish`, `Time`) VALUES
(1, 'SKPD', 'Alamat dan nomor telepon SKPD kab. Merauke', 1, '2015-11-20 06:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IdUser` bigint(3) NOT NULL,
  `NameUser` varchar(30) DEFAULT NULL,
  `PasswordUser` text DEFAULT NULL,
  `EmailUser` varchar(30) DEFAULT NULL,
  `PhoneUser` text DEFAULT NULL,
  `LevelUser` text DEFAULT NULL,
  `RecordPerPage` tinyint(4) NOT NULL DEFAULT 10,
  `LandingPage` varchar(20) NOT NULL DEFAULT 'default',
  `AddressUser` varchar(200) DEFAULT NULL,
  `PictureUser` text DEFAULT NULL,
  `StatusUser` varchar(10) DEFAULT 'aktif',
  `AboutMe` text DEFAULT NULL,
  `Theme` text DEFAULT NULL,
  `FullName` text DEFAULT NULL,
  `LastSeen` datetime DEFAULT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `IdSkpd` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IdUser`, `NameUser`, `PasswordUser`, `EmailUser`, `PhoneUser`, `LevelUser`, `RecordPerPage`, `LandingPage`, `AddressUser`, `PictureUser`, `StatusUser`, `AboutMe`, `Theme`, `FullName`, `LastSeen`, `LastLogin`, `IdSkpd`) VALUES
(1, 'Fanny', '$2y$10$Mu1Gukt2ektd8NbvOAZY.uVxnX7Z24t0I8x4jWg2qETf3dXgDHcFe', 'fannykaunang59@gmail.com', '0', 'superadmin', 10, 'default', '-', 'user/Iron-Man-3-Iron-Man-Mark-42-Life-Size-Sideshow-Collectibles-Statue-Pic-11.jpg', 'aktif', '-', 'green', 'Fanny Alfa Kaunang', '2023-05-03 22:39:16', '2023-09-03 12:27:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userrole`
--

CREATE TABLE `userrole` (
  `IdRole` int(11) NOT NULL,
  `LevelUser` text DEFAULT NULL,
  `NewsView` text DEFAULT NULL,
  `NewsCreate` text DEFAULT NULL,
  `NewsUpdate` text DEFAULT NULL,
  `NewsDelete` text DEFAULT NULL,
  `CategoryView` text DEFAULT NULL,
  `CategoryCreate` text DEFAULT NULL,
  `CategoryUpdate` text DEFAULT NULL,
  `CategoryDelete` text DEFAULT NULL,
  `CommentView` text DEFAULT NULL,
  `CommentCreate` text DEFAULT NULL,
  `CommentUpdate` text DEFAULT NULL,
  `CommentDelete` text DEFAULT NULL,
  `CaptchaView` text DEFAULT NULL,
  `CaptchaCreate` text DEFAULT NULL,
  `CaptchaUpdate` text DEFAULT NULL,
  `CaptchaDelete` text DEFAULT NULL,
  `UserView` text DEFAULT NULL,
  `UserCreate` text DEFAULT NULL,
  `UserUpdate` text DEFAULT NULL,
  `UserDelete` text DEFAULT NULL,
  `FileView` text DEFAULT NULL,
  `FileCreate` text DEFAULT NULL,
  `FileUpdate` text DEFAULT NULL,
  `FileDelete` text DEFAULT NULL,
  `UserRoleView` text DEFAULT NULL,
  `UserRoleCreate` text DEFAULT NULL,
  `UserRoleUpdate` text DEFAULT NULL,
  `UserRoleDelete` text DEFAULT NULL,
  `ToolsBackupDatabase` text DEFAULT NULL,
  `SettingsView` text DEFAULT NULL,
  `SettingsCreate` text DEFAULT NULL,
  `SettingsUpdate` text DEFAULT NULL,
  `SettingsDelete` text DEFAULT NULL,
  `LogsView` text DEFAULT NULL,
  `LogsCreate` text DEFAULT NULL,
  `LogsUpdate` text DEFAULT NULL,
  `LogsDelete` text DEFAULT NULL,
  `ReportView` text DEFAULT NULL,
  `ReportCreate` text DEFAULT NULL,
  `ReportUpdate` text DEFAULT NULL,
  `ReportDelete` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userrole`
--

INSERT INTO `userrole` (`IdRole`, `LevelUser`, `NewsView`, `NewsCreate`, `NewsUpdate`, `NewsDelete`, `CategoryView`, `CategoryCreate`, `CategoryUpdate`, `CategoryDelete`, `CommentView`, `CommentCreate`, `CommentUpdate`, `CommentDelete`, `CaptchaView`, `CaptchaCreate`, `CaptchaUpdate`, `CaptchaDelete`, `UserView`, `UserCreate`, `UserUpdate`, `UserDelete`, `FileView`, `FileCreate`, `FileUpdate`, `FileDelete`, `UserRoleView`, `UserRoleCreate`, `UserRoleUpdate`, `UserRoleDelete`, `ToolsBackupDatabase`, `SettingsView`, `SettingsCreate`, `SettingsUpdate`, `SettingsDelete`, `LogsView`, `LogsCreate`, `LogsUpdate`, `LogsDelete`, `ReportView`, `ReportCreate`, `ReportUpdate`, `ReportDelete`) VALUES
(1, 'superadmin', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes'),
(2, 'IRBAN', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes'),
(3, 'SKPD', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', NULL, 'no', 'no', 'no', NULL, 'no', 'no', 'no', 'no', 'no', 'no'),
(4, 'INSPEKTUR', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `user_portal`
--

CREATE TABLE `user_portal` (
  `userPortalId` int(11) NOT NULL,
  `userPortalName` varchar(100) NOT NULL,
  `userPortalPass` varchar(100) NOT NULL,
  `userPortalEmail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_portal`
--

INSERT INTO `user_portal` (`userPortalId`, `userPortalName`, `userPortalPass`, `userPortalEmail`) VALUES
(2, '0', '0', '0'),
(3, '0', '0', '0'),
(4, 'fannykk', 'sss', 'ddd'),
(5, 'as', 'dddd', 'hh'),
(6, 'gfgfg', '123', 'fanny@gmail.com'),
(7, 'hey', 'pass', 'tayo'),
(8, 'fann', '111111', 'kk@gmail.com'),
(9, 'Fanny%20Kaunang', '123456', 'fannykaunang59@gmail.com'),
(0, 'Eko%20purnomo', 'purnomo89', 'echoefebrie@gmail.com'),
(0, 'deinkrisye%20Timotius', '13desember', 'dein799@gmail.com'),
(0, 'Muslimin', 'muslimin11', 'rtmuslimin85@gmail.com'),
(0, 'muslimin', 'muslimin11', 'rtmuslimin85@gmail.com'),
(0, 'muslimin', 'muslimin11', 'rtmuslimin85@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aplikasi_skpd`
--
ALTER TABLE `aplikasi_skpd`
  ADD PRIMARY KEY (`IDSKPD`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`IdCategory`);

--
-- Indexes for table `filemanager`
--
ALTER TABLE `filemanager`
  ADD PRIMARY KEY (`IdFile`);

--
-- Indexes for table `irban`
--
ALTER TABLE `irban`
  ADD PRIMARY KEY (`IdIrban`);

--
-- Indexes for table `irban_category`
--
ALTER TABLE `irban_category`
  ADD PRIMARY KEY (`IdCategory`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`IdKonsultasi`);
ALTER TABLE `konsultasi` ADD FULLTEXT KEY `Title` (`Title`,`Content`);
ALTER TABLE `konsultasi` ADD FULLTEXT KEY `Title_2` (`Title`,`Content`);

--
-- Indexes for table `logssystem`
--
ALTER TABLE `logssystem`
  ADD PRIMARY KEY (`IdLog`);

--
-- Indexes for table `logsuser`
--
ALTER TABLE `logsuser`
  ADD PRIMARY KEY (`IdLog`);

--
-- Indexes for table `logsvisitor`
--
ALTER TABLE `logsvisitor`
  ADD PRIMARY KEY (`IdLog`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`IdNews`);
ALTER TABLE `news` ADD FULLTEXT KEY `TitleNews` (`TitleNews`,`ContentNews`);
ALTER TABLE `news` ADD FULLTEXT KEY `TitleNews_2` (`TitleNews`,`ContentNews`);

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `skpd`
--
ALTER TABLE `skpd`
  ADD PRIMARY KEY (`IdSkpd`);

--
-- Indexes for table `telepon_penting`
--
ALTER TABLE `telepon_penting`
  ADD PRIMARY KEY (`IdFile`);

--
-- Indexes for table `telepon_penting_category`
--
ALTER TABLE `telepon_penting_category`
  ADD PRIMARY KEY (`IdCategory`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IdUser`);

--
-- Indexes for table `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`IdRole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aplikasi_skpd`
--
ALTER TABLE `aplikasi_skpd`
  MODIFY `IDSKPD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `IdCategory` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filemanager`
--
ALTER TABLE `filemanager`
  MODIFY `IdFile` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `irban`
--
ALTER TABLE `irban`
  MODIFY `IdIrban` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `irban_category`
--
ALTER TABLE `irban_category`
  MODIFY `IdCategory` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `IdKonsultasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logssystem`
--
ALTER TABLE `logssystem`
  MODIFY `IdLog` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logsuser`
--
ALTER TABLE `logsuser`
  MODIFY `IdLog` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logsvisitor`
--
ALTER TABLE `logsvisitor`
  MODIFY `IdLog` bigint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `IdNews` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `skpd`
--
ALTER TABLE `skpd`
  MODIFY `IdSkpd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `telepon_penting`
--
ALTER TABLE `telepon_penting`
  MODIFY `IdFile` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `telepon_penting_category`
--
ALTER TABLE `telepon_penting_category`
  MODIFY `IdCategory` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `IdUser` bigint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `userrole`
--
ALTER TABLE `userrole`
  MODIFY `IdRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
