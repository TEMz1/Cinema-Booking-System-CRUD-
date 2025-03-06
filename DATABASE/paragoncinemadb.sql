-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 08:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paragoncinemadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookid` int(11) NOT NULL,
  `session_id` bigint(20) NOT NULL,
  `custid` int(11) NOT NULL,
  `hallNo` varchar(255) NOT NULL,
  `seatNo` varchar(16) NOT NULL,
  `transaction_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clerk`
--

CREATE TABLE `clerk` (
  `id` int(10) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(50) NOT NULL,
  `icNum` varchar(14) NOT NULL,
  `phoneNum` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clerk`
--

INSERT INTO `clerk` (`id`, `username`, `password`, `name`, `icNum`, `phoneNum`, `gender`, `role`) VALUES
(4, 'admon', '3333', 'Miftahul Tama', '25625-2526-666', '055555', 'Male', 'Clerk');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phoneNo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL,
  `verification_code` varchar(256) NOT NULL,
  `is_verif` int(8) NOT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

CREATE TABLE `hall` (
  `hallNo` varchar(16) NOT NULL,
  `hallName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`hallNo`, `hallName`) VALUES
('HALL-1', 'Regular Hall'),
('HALL-10', 'Regular Hall'),
('Hall-11', 'Regular Hall'),
('Hall-12', 'Regular Hall'),
('Hall-13', 'Regular Hall'),
('HALL-2', 'Regular Hall'),
('HALL-3', 'Regular Hall'),
('HALL-4', 'Regular Hall'),
('HALL-5', 'Regular Hall'),
('HALL-6', 'Regular Hall'),
('HALL-7', 'Regular Hall'),
('HALL-8', 'Regular Hall'),
('HALL-9', 'Regular Hall');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoiceno` int(11) NOT NULL,
  `price` double NOT NULL,
  `custid` int(11) NOT NULL,
  `theaterName` varchar(255) NOT NULL,
  `hallNo` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `showtime` varchar(255) NOT NULL,
  `chosenSeat` varchar(255) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `midtrans_order_id` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','settlement','cancel','failure') DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `payment_time` datetime DEFAULT NULL,
  `isUse` int(8) DEFAULT NULL,
  `useTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(10) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(50) NOT NULL,
  `icNum` varchar(14) NOT NULL,
  `phoneNum` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `username`, `password`, `name`, `icNum`, `phoneNum`, `gender`, `role`) VALUES
(1, 'amin', '123', 'Khairul', '121212-10-0909', '0310310031', 'Male', 'Manager'),
(2, 'tama', '123', 'Miftahul Tama', '212121-22-9871', '013131313', 'Male', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movieid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  `trailer` varchar(255) NOT NULL,
  `language` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movieid`, `title`, `poster`, `genre`, `description`, `duration`, `releaseDate`, `trailer`, `language`) VALUES
(32, '2ND MIRACLE IN CELL NO. 7', 'miracle.jpg', 'Family, Drama', 'Dua tahun setelah Ayah Dodo (Vino G Bastian) dihukum mati. Kartika (Graciella Abigail) tinggal bersama Hendro (Denny Sumargo) dan Linda (Agla Artalidia). Kartika masih diselundupkan untuk bertemu dengan para napi di sel no.7. Semua sepakat untuk merahasia', '2 jam 27 menit', '2024-12-25', 'https://www.youtube.com/watch?v=EnQntzbV62E', 'IDN'),
(33, 'MUFASA: THE LION KING', '466640229_1002179395270766_3632536314943460164_n (1).jpg', 'Animation, adventure', 'Mufasa, seekor anak singa yang tersesat dan sendirian, bertemu dengan seekor singa bernama Taka, pewaris garis keturunan bangsawan. Pertemuan tak disengaja ini memulai perjalanan kelompok yang unik namun luar biasa dalam mencari takdir mereka.', '1 jam 58 menit', '2024-12-18', 'https://www.youtube.com/watch?v=o17MF9vnabg', 'ENG'),
(34, 'HEAR ME: OUR SUMMER', 'hearme.jpg', 'Romance', 'Berekspresi dengan tangan dan merasakan dengan hati, Kumpulan momen indah yang hangat. Yongjun (HONG Kyung) khawatir karena kehidupan perkuliahannya telah berakhir, tetapi dia tidak melakukan atau menjadi apa pun. Yongjun, yang terpaksa bekerja paruh wakt', '1 jam 50 menit', '2025-01-08', 'https://www.youtube.com/watch?v=lV64qzRhfZY', 'KOR'),
(35, 'SOROP', 'sorop.jpg', 'Horror', 'Berniat kembali ke rumah masa kecilnya, Hanif (Hana Malasan) dan Isti (Yasamin Jasem) justru harus dikejutkan dengan kematian Pakde(Egi Fedly) yang terjadi tepat di hadapan mereka. Kematian Pakde rupanya membawa sesuatu yang lebih gelap datang ke rumah me', '1 jam 43 menit', '2024-12-19', 'https://www.youtube.com/watch?v=JRfq7INa2Mg', 'IDN'),
(36, 'UTUSAN IBLIS', 'utusaniblis.jpeg', 'Horor, Psikologi', 'Olivia (Shareefa Daanish) seorang psikiater spesialis penyakit jiwa mencoba membantu Rendy (Dimas Aditya) seorang polisi dalam menginvestigasi kasus pembantaian yang dilakukan oleh Cantika (Cindy Nirmala) terhadap seluruh keluarganya. Awalnya Rendy mendug', '1 jam 30 menit', '2025-01-02', 'https://www.youtube.com/watch?v=Fg8SPqun7W0', 'IDN'),
(37, ' ZANNA: WHISPER OF VOLCANO ISLE', 'zanna.jpeg', 'Animasi, Fantasi, Petualangan', 'mengisahkan seorang gadis bernama Zanna yang terpisah dengan keluarganya. Suatu ketika, ia tak sengaja masuk ke dunia yang penuh keajaiban. Bersama dua peri cantik, Dinda dan Novi, Zanna memberanikan diri untuk menjelajah berbagai hal baru yang menantang,', '1 jam 34 menit', '2025-01-02', 'https://www.youtube.com/watch?v=D9qMyVvfT04', 'IDN'),
(38, 'HARBIN', 'harbin.jpg', 'Drama', 'Pada tahun 1908, pejuang kemerdekaan Korea yang dipimpin oleh Ahn Jung-geun, meraih kemenangan penting dalam pertempuran melawan tentara Jepang di Gunung Sina, dekat perbatasan utara Korea. Letnan Jenderal Ahn Jung-geun dari Tentara Kemerdekaan Korea, yan', '1 jam 54 menit', '2025-01-01', 'https://www.youtube.com/watch?v=yySkfE3jZeM', 'KOR'),
(39, 'MODAL NEKAD', 'modal nekat.jpeg', 'Drama, Komedi', 'Tiga bersaudara, Saipul (Gading Marten), Jamal (Tarra Budiman) dan Marwan (Fatih Unru) terpaksa akur kembali untuk melunasi hutang tagihan Rumah Sakit Ayahnya. Dengan modal nekad mereka memutuskan untuk mencuri TV di sebuah rumah kosong. Sampai tiba-tiba ', '1 jam 47 menit', '2024-12-19', 'https://www.youtube.com/watch?v=P8DQLxGFIsI', 'IDN'),
(40, '1 KAKAK 7 PONAKAN', '1 kakak.jpg', 'Drama', 'Setelah kematian mendadak kakak-kakaknya, Hendarmoko (Chicco Kurniawan) seorang arsitek muda yang sedang berjuang, tiba-tiba menjadi orangtua tunggal bagi keponakan-keponakannya. Ketika kesempatan untuk kehidupan yang lebih baik muncul, dia harus memilih ', '2 jam 9 menit', '2025-01-23', 'https://www.youtube.com/watch?v=LkUsJMFngiI', 'IDN'),
(41, 'ANAK KUNTI', 'anak kunti.jpg', 'Horor', 'Di tengah kehidupan pesantren yang religius, SARAH (Gisellma Firmansyah), seorang santriwati, diusik oleh serangkaian mimpi buruk tentang KUNTILANAK yang mengancamnya. Sesuai petunjuk sang pengasuh pesantren, Nyai Fatima, Sara pergi ke sebuah kampung yang', '1 jam 35 menit', '2025-02-20', 'https://www.youtube.com/watch?v=KhDS7vGTBpY', 'IDN'),
(42, '1 IMAM 2 MAKMUM', '1 imam.jpg', 'Drama', 'Terinspirasi dari kisah nyata, 1 Imam 2 Makmum bercerita tentang Anika (Amanda Manopo) yang berusaha membuat suaminya, Arman (Fedi Nuril), jatuh cinta, sedangkan Arman belum mengikhlaskan mendiang istrinya, Leila (Revalina S.Temat). Mampukah Anika bertaha', '1 jam 52 menit', '2025-01-16', 'https://www.youtube.com/watch?v=l5YVYWIfh8k', 'IDN'),
(43, 'SONIC THE HEDGEHOG', 'sonic3.jpg', 'Aksi, Fantasi', 'Sonic, Knuckles, dan Tails bersatu melawan musuh baru yang kuat, Shadow, penjahat misterius dengan kekuatan yang belum pernah mereka hadapi sebelumnya. Karena kemampuan musuh tidak tertandingi, Tim Sonic harus mencari teman lain yang tidak terduga.', '1 jam 50 menit', '2024-12-25', 'https://www.youtube.com/watch?v=qSu6i2iFMO0', 'ENG'),
(44, 'PERAYAAN MATI RASA', 'prm-poster.jpg', 'Drama, Keluarga', 'Film ini mengisahkan perjalanan hidup Ian Antono (diperankan oleh Iqbaal Ramadhan), seorang anak sulung yang berjuang meraih mimpinya bersama band-nya, Midnight Serenade. Ian sering dibandingkan dengan adiknya, Uta (Umay Shahab), yang dianggap lebih sukse', '1 jam 45 menit', '2025-01-29', 'https://www.youtube.com/watch?v=-SqqreFK47E', 'IDN'),
(45, 'PABRIK GULA', 'pabrik_gula.jpeg', 'Horor', 'Sekelompok buruh musiman, termasuk Endah, Fadhil, Dwi, Hendra, Wati, Ningsih, dan Franky, bekerja di sebuah pabrik gula untuk mempercepat proses penggilingan tebu selama musim panen. Awalnya, pekerjaan berjalan lancar, namun situasi berubah ketika Endah m', '1 Jam 30 Menit', '2025-04-01', 'https://www.youtube.com/watch?v=c2hqNsBdc60', 'IDN'),
(56, 'DARK NUNS', 'dark_nuns.jpg', 'Thriller Supernatural', ' Film ini berfokus pada dua biarawati, Suster Junia dan Suster Michaela, yang berusaha menyelamatkan seorang anak laki-laki bernama Hee-joon yang dirasuki roh jahat. Suster Junia, didorong oleh iman dan belas kasihnya, bertekad untuk menyelamatkan anak te', '1 Jam 30 Menit', '2025-01-24', 'https://www.youtube.com/watch?v=hJT_zC94TjI', 'KOR');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_request`
--

CREATE TABLE `password_reset_request` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(256) NOT NULL,
  `token` varchar(256) NOT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `is_change` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_request`
--

INSERT INTO `password_reset_request` (`id`, `customer_id`, `token`, `token_expiry`, `is_change`) VALUES
(1, '14', '1058a1ca27bc1acba5652b2a7914749842313fdac7fda0bdd602dff30a839dc5', '2025-02-15 08:22:05', NULL),
(2, '14', 'cd5d968094e44956443366aff658c79d5ad15d06c4132f523e3e9c6bc083a71b', '2025-02-15 09:05:19', NULL),
(3, '14', '0b9515c8af84f00d7c969304f79b04ad7bcd0985452347a6bb3116d5f1e5152e', '2025-02-15 09:29:38', NULL),
(4, '15', '98fd23f34720ee34f6b4f04fa49dcc11ae98352573e2deb7dd3c824620ab41ce', '2025-02-15 09:44:02', 1),
(5, '16', 'ad216da0f5216b9434eb965b56bebd10b6742e1b5c749c16b51e94c7bccba5d4', '2025-02-17 00:30:45', 1),
(6, '15', '5d340e12e6966f539f97f3574b6da791c921a767944f9778512f3a0a42cc63f6', '2025-02-17 09:41:52', 1),
(7, '18', '6c3c6935c47fa802d7884db85e9fbdff8c7409852f1d39c8f0b53a52bc4c97d4', '2025-02-27 07:51:39', 1),
(8, '18', '203e6ee3c8652b38f54cc8da1393a92196470e32aa00582d89009810c0f327f4', '2025-02-27 08:06:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seatid` int(11) NOT NULL,
  `seatNo` varchar(16) NOT NULL,
  `hallNo` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seatid`, `seatNo`, `hallNo`) VALUES
(1, 'A1', 'HALL-1'),
(2, 'A2', 'HALL-1'),
(3, 'A3', 'HALL-1'),
(4, 'A4', 'HALL-1'),
(5, 'A5', 'HALL-1'),
(6, 'A6', 'HALL-1'),
(7, 'B1', 'HALL-1'),
(8, 'B2', 'HALL-1'),
(9, 'B3', 'HALL-1'),
(10, 'B4', 'HALL-1'),
(11, 'B5', 'HALL-1'),
(12, 'B6', 'HALL-1'),
(13, 'C1', 'HALL-1'),
(14, 'C2', 'HALL-1'),
(15, 'C3', 'HALL-1'),
(16, 'C4', 'HALL-1'),
(17, 'C5', 'HALL-1'),
(18, 'C6', 'HALL-1'),
(19, 'D1', 'HALL-1'),
(20, 'D2', 'HALL-1'),
(21, 'D3', 'HALL-1'),
(22, 'D4', 'HALL-1'),
(23, 'D5', 'HALL-1'),
(24, 'D6', 'HALL-1'),
(25, 'E1', 'HALL-1'),
(26, 'E2', 'HALL-1'),
(27, 'E3', 'HALL-1'),
(28, 'E4', 'HALL-1'),
(29, 'E5', 'HALL-1'),
(30, 'E6', 'HALL-1'),
(31, 'F1', 'HALL-1'),
(32, 'F2', 'HALL-1'),
(33, 'F3', 'HALL-1'),
(34, 'F4', 'HALL-1'),
(35, 'F5', 'HALL-1'),
(36, 'F6', 'HALL-1'),
(37, 'A1', 'HALL-2'),
(38, 'A2', 'HALL-2'),
(39, 'A3', 'HALL-2'),
(40, 'A4', 'HALL-2'),
(41, 'A5', 'HALL-2'),
(42, 'A6', 'HALL-2'),
(49, 'B1', 'HALL-2'),
(50, 'B2', 'HALL-2'),
(51, 'B3', 'HALL-2'),
(52, 'B4', 'HALL-2'),
(53, 'B5', 'HALL-2'),
(54, 'B6', 'HALL-2'),
(55, 'C1', 'HALL-2'),
(56, 'C2', 'HALL-2'),
(57, 'C3', 'HALL-2'),
(58, 'C4', 'HALL-2'),
(59, 'C5', 'HALL-2'),
(60, 'C6', 'HALL-2'),
(61, 'D1', 'HALL-2'),
(62, 'D2', 'HALL-2'),
(63, 'D3', 'HALL-2'),
(64, 'D4', 'HALL-2'),
(65, 'D5', 'HALL-2'),
(66, 'D6', 'HALL-2'),
(67, 'E1', 'HALL-2'),
(68, 'E2', 'HALL-2'),
(69, 'E3', 'HALL-2'),
(70, 'E4', 'HALL-2'),
(71, 'E5', 'HALL-2'),
(72, 'E6', 'HALL-2'),
(73, 'F1', 'HALL-2'),
(74, 'F2', 'HALL-2'),
(75, 'F3', 'HALL-2'),
(76, 'F4', 'HALL-2'),
(77, 'F5', 'HALL-2'),
(78, 'F6', 'HALL-2'),
(79, 'G1', 'HALL-2'),
(80, 'G2', 'HALL-2'),
(81, 'G3', 'HALL-2'),
(82, 'G4', 'HALL-2'),
(83, 'G5', 'HALL-2'),
(84, 'G6', 'HALL-2'),
(85, 'H1', 'HALL-2'),
(87, 'H2', 'HALL-2'),
(88, 'H3', 'HALL-2'),
(89, 'H4', 'HALL-2'),
(90, 'H5', 'HALL-2'),
(91, 'H6', 'HALL-2'),
(92, 'A1', 'HALL-3'),
(93, 'A2', 'HALL-3'),
(94, 'A3', 'HALL-3'),
(95, 'A4', 'HALL-3'),
(96, 'A5', 'HALL-3'),
(97, 'A6', 'HALL-3'),
(98, 'B1', 'HALL-3'),
(99, 'B2', 'HALL-3'),
(100, 'B3', 'HALL-3'),
(101, 'B4', 'HALL-3'),
(102, 'B5', 'HALL-3'),
(103, 'B6', 'HALL-3'),
(104, 'C1', 'HALL-3'),
(105, 'C2', 'HALL-3'),
(106, 'C3', 'HALL-3'),
(107, 'C4', 'HALL-3'),
(108, 'C5', 'HALL-3'),
(109, 'C6', 'HALL-3'),
(110, 'D1', 'HALL-3'),
(111, 'D2', 'HALL-3'),
(112, 'D3', 'HALL-3'),
(113, 'D4', 'HALL-3'),
(114, 'D5', 'HALL-3'),
(115, 'D6', 'HALL-3'),
(116, 'E1', 'HALL-3'),
(117, 'E2', 'HALL-3'),
(118, 'E3', 'HALL-3'),
(119, 'E4', 'HALL-3'),
(120, 'E5', 'HALL-3'),
(121, 'E6', 'HALL-3'),
(122, 'F1', 'HALL-3'),
(123, 'F2', 'HALL-3'),
(124, 'F3', 'HALL-3'),
(125, 'F4', 'HALL-3'),
(126, 'F5', 'HALL-3'),
(127, 'F6', 'HALL-3'),
(128, 'G1', 'HALL-3'),
(129, 'G2', 'HALL-3'),
(130, 'G3', 'HALL-3'),
(131, 'G4', 'HALL-3'),
(132, 'G5', 'HALL-3'),
(133, 'G6', 'HALL-3'),
(134, 'A1', 'HALL-4'),
(135, 'A2', 'HALL-4'),
(136, 'A3', 'HALL-4'),
(137, 'A4', 'HALL-4'),
(138, 'A5', 'HALL-4'),
(139, 'A6', 'HALL-4'),
(140, 'B1', 'HALL-4'),
(141, 'B2', 'HALL-4'),
(142, 'B3', 'HALL-4'),
(143, 'B4', 'HALL-4'),
(144, 'B5', 'HALL-4'),
(145, 'B6', 'HALL-4'),
(146, 'C1', 'HALL-4'),
(147, 'C2', 'HALL-4'),
(148, 'C3', 'HALL-4'),
(149, 'C4', 'HALL-4'),
(150, 'C5', 'HALL-4'),
(151, 'C6', 'HALL-4'),
(152, 'D1', 'HALL-4'),
(153, 'D2', 'HALL-4'),
(154, 'D3', 'HALL-4'),
(155, 'D4', 'HALL-4'),
(156, 'D5', 'HALL-4'),
(157, 'D6', 'HALL-4'),
(158, 'E1', 'HALL-4'),
(159, 'E2', 'HALL-4'),
(160, 'E3', 'HALL-4'),
(161, 'E4', 'HALL-4'),
(162, 'E5', 'HALL-4'),
(163, 'E6', 'HALL-4'),
(164, 'F1', 'HALL-4'),
(165, 'F2', 'HALL-4'),
(166, 'F3', 'HALL-4'),
(167, 'F4', 'HALL-4'),
(168, 'F5', 'HALL-4'),
(169, 'F6', 'HALL-4'),
(170, 'G1', 'HALL-4'),
(171, 'G2', 'HALL-4'),
(172, 'G3', 'HALL-4'),
(173, 'G4', 'HALL-4'),
(174, 'G5', 'HALL-4'),
(175, 'G6', 'HALL-4'),
(176, 'A1', 'HALL-5'),
(177, 'A2', 'HALL-5'),
(178, 'A3', 'HALL-5'),
(179, 'A4', 'HALL-5'),
(180, 'A5', 'HALL-5'),
(181, 'A6', 'HALL-5'),
(182, 'B1', 'HALL-5'),
(183, 'B2', 'HALL-5'),
(184, 'B3', 'HALL-5'),
(185, 'B4', 'HALL-5'),
(186, 'B5', 'HALL-5'),
(187, 'B6', 'HALL-5'),
(188, 'C1', 'HALL-5'),
(189, 'C2', 'HALL-5'),
(190, 'C3', 'HALL-5'),
(191, 'C4', 'HALL-5'),
(192, 'C5', 'HALL-5'),
(193, 'C6', 'HALL-5'),
(194, 'D1', 'HALL-5'),
(195, 'D2', 'HALL-5'),
(196, 'D3', 'HALL-5'),
(197, 'D4', 'HALL-5'),
(198, 'D5', 'HALL-5'),
(199, 'D6', 'HALL-5'),
(200, 'E1', 'HALL-5'),
(201, 'E2', 'HALL-5'),
(202, 'E3', 'HALL-5'),
(203, 'E4', 'HALL-5'),
(204, 'E5', 'HALL-5'),
(205, 'E6', 'HALL-5'),
(206, 'F1', 'HALL-5'),
(207, 'F2', 'HALL-5'),
(208, 'F3', 'HALL-5'),
(209, 'F4', 'HALL-5'),
(210, 'F5', 'HALL-5'),
(211, 'F6', 'HALL-5'),
(212, 'G1', 'HALL-5'),
(213, 'G2', 'HALL-5'),
(214, 'G3', 'HALL-5'),
(215, 'G4', 'HALL-5'),
(216, 'G5', 'HALL-5'),
(217, 'G6', 'HALL-5'),
(218, 'H1', 'HALL-5'),
(219, 'H2', 'HALL-5'),
(220, 'H3', 'HALL-5'),
(221, 'H4', 'HALL-5'),
(222, 'H5', 'HALL-5'),
(223, 'H6', 'HALL-5'),
(224, 'H1', 'HALL-3'),
(225, 'H2', 'HALL-3'),
(226, 'H3', 'HALL-3'),
(227, 'H4', 'HALL-3'),
(228, 'H5', 'HALL-3'),
(229, 'H6', 'HALL-3'),
(230, 'H1', 'HALL-4'),
(231, 'H2', 'HALL-4'),
(232, 'H3', 'HALL-4'),
(233, 'H4', 'HALL-4'),
(234, 'H5', 'HALL-4'),
(235, 'H6', 'HALL-4'),
(236, 'A1', 'HALL-6'),
(237, 'A2', 'HALL-6'),
(238, 'A3', 'HALL-6'),
(239, 'A4', 'HALL-6'),
(240, 'A5', 'HALL-6'),
(241, 'A6', 'HALL-6'),
(242, 'B1', 'HALL-6'),
(243, 'B2', 'HALL-6'),
(244, 'B3', 'HALL-6'),
(245, 'B4', 'HALL-6'),
(246, 'B5', 'HALL-6'),
(247, 'B6', 'HALL-6'),
(248, 'C1', 'HALL-6'),
(249, 'C2', 'HALL-6'),
(250, 'C3', 'HALL-6'),
(251, 'C4', 'HALL-6'),
(252, 'C5', 'HALL-6'),
(253, 'C6', 'HALL-6'),
(254, 'D1', 'HALL-6'),
(255, 'D2', 'HALL-6'),
(256, 'D3', 'HALL-6'),
(257, 'D4', 'HALL-6'),
(258, 'D5', 'HALL-6'),
(259, 'D6', 'HALL-6'),
(260, 'E1', 'HALL-6'),
(261, 'E2', 'HALL-6'),
(262, 'E3', 'HALL-6'),
(263, 'E4', 'HALL-6'),
(264, 'E5', 'HALL-6'),
(265, 'E6', 'HALL-6'),
(266, 'F1', 'HALL-6'),
(267, 'F2', 'HALL-6'),
(268, 'F3', 'HALL-6'),
(269, 'F4', 'HALL-6'),
(270, 'F5', 'HALL-6'),
(271, 'F6', 'HALL-6'),
(272, 'G1', 'HALL-6'),
(273, 'G2', 'HALL-6'),
(274, 'G3', 'HALL-6'),
(275, 'G4', 'HALL-6'),
(276, 'G5', 'HALL-6'),
(277, 'G6', 'HALL-6'),
(278, 'H1', 'HALL-6'),
(279, 'H2', 'HALL-6'),
(280, 'H3', 'HALL-6'),
(281, 'H4', 'HALL-6'),
(282, 'H5', 'HALL-6'),
(283, 'H6', 'HALL-6'),
(284, 'A1', 'HALL-7'),
(285, 'A2', 'HALL-7'),
(286, 'A3', 'HALL-7'),
(287, 'A4', 'HALL-7'),
(288, 'A5', 'HALL-7'),
(289, 'A6', 'HALL-7'),
(290, 'B1', 'HALL-7'),
(291, 'B2', 'HALL-7'),
(292, 'B3', 'HALL-7'),
(293, 'B4', 'HALL-7'),
(294, 'B5', 'HALL-7'),
(295, 'B6', 'HALL-7'),
(296, 'C1', 'HALL-7'),
(297, 'C2', 'HALL-7'),
(298, 'C3', 'HALL-7'),
(299, 'C4', 'HALL-7'),
(300, 'C5', 'HALL-7'),
(301, 'C6', 'HALL-7'),
(302, 'D1', 'HALL-7'),
(303, 'D2', 'HALL-7'),
(304, 'D3', 'HALL-7'),
(305, 'D4', 'HALL-7'),
(306, 'D5', 'HALL-7'),
(307, 'D6', 'HALL-7'),
(308, 'E1', 'HALL-7'),
(309, 'E2', 'HALL-7'),
(310, 'E3', 'HALL-7'),
(311, 'E4', 'HALL-7'),
(312, 'E5', 'HALL-7'),
(313, 'E6', 'HALL-7'),
(314, 'F1', 'HALL-7'),
(315, 'F2', 'HALL-7'),
(316, 'F3', 'HALL-7'),
(317, 'F4', 'HALL-7'),
(318, 'F5', 'HALL-7'),
(319, 'F6', 'HALL-7'),
(320, 'G1', 'HALL-7'),
(321, 'G2', 'HALL-7'),
(322, 'G3', 'HALL-7'),
(323, 'G4', 'HALL-7'),
(324, 'G5', 'HALL-7'),
(325, 'G6', 'HALL-7'),
(326, 'H1', 'HALL-7'),
(327, 'H2', 'HALL-7'),
(328, 'H3', 'HALL-7'),
(329, 'H4', 'HALL-7'),
(330, 'H5', 'HALL-7'),
(331, 'H6', 'HALL-7'),
(332, 'A1', 'HALL-8'),
(333, 'A2', 'HALL-8'),
(334, 'A3', 'HALL-8'),
(335, 'A4', 'HALL-8'),
(336, 'A5', 'HALL-8'),
(337, 'A6', 'HALL-8'),
(338, 'B1', 'HALL-8'),
(339, 'B2', 'HALL-8'),
(340, 'B3', 'HALL-8'),
(341, 'B4', 'HALL-8'),
(342, 'B5', 'HALL-8'),
(343, 'B6', 'HALL-8'),
(344, 'C1', 'HALL-8'),
(345, 'C2', 'HALL-8'),
(346, 'C3', 'HALL-8'),
(347, 'C4', 'HALL-8'),
(348, 'C5', 'HALL-8'),
(349, 'C6', 'HALL-8'),
(350, 'D1', 'HALL-8'),
(351, 'D2', 'HALL-8'),
(352, 'D3', 'HALL-8'),
(353, 'D4', 'HALL-8'),
(354, 'D5', 'HALL-8'),
(355, 'D6', 'HALL-8'),
(356, 'E1', 'HALL-8'),
(357, 'E2', 'HALL-8'),
(358, 'E3', 'HALL-8'),
(359, 'E4', 'HALL-8'),
(360, 'E5', 'HALL-8'),
(361, 'E6', 'HALL-8'),
(362, 'F1', 'HALL-8'),
(363, 'F2', 'HALL-8'),
(364, 'F3', 'HALL-8'),
(365, 'F4', 'HALL-8'),
(366, 'F5', 'HALL-8'),
(367, 'F6', 'HALL-8'),
(368, 'G1', 'HALL-8'),
(369, 'G2', 'HALL-8'),
(370, 'G3', 'HALL-8'),
(371, 'G4', 'HALL-8'),
(372, 'G5', 'HALL-8'),
(373, 'G6', 'HALL-8'),
(374, 'H1', 'HALL-8'),
(375, 'H2', 'HALL-8'),
(376, 'H3', 'HALL-8'),
(377, 'H4', 'HALL-8'),
(378, 'H5', 'HALL-8'),
(379, 'H6', 'HALL-8'),
(380, 'A1', 'Hall-11'),
(381, 'A2', 'Hall-11'),
(382, 'A3', 'Hall-11'),
(383, 'A4', 'Hall-11'),
(384, 'A5', 'Hall-11'),
(385, 'A6', 'Hall-11'),
(386, 'B1', 'Hall-11'),
(387, 'B2', 'Hall-11'),
(388, 'B3', 'Hall-11'),
(389, 'B4', 'Hall-11'),
(390, 'B5', 'Hall-11'),
(391, 'B6', 'Hall-11'),
(392, 'C1', 'Hall-11'),
(393, 'C2', 'Hall-11'),
(394, 'C3', 'Hall-11'),
(395, 'C4', 'Hall-11'),
(396, 'C5', 'Hall-11'),
(397, 'C6', 'Hall-11'),
(398, 'D1', 'Hall-11'),
(399, 'D2', 'Hall-11'),
(400, 'D3', 'Hall-11'),
(401, 'D4', 'Hall-11'),
(402, 'D5', 'Hall-11'),
(403, 'D6', 'Hall-11'),
(404, 'E1', 'Hall-11'),
(405, 'E2', 'Hall-11'),
(406, 'E3', 'Hall-11'),
(407, 'E4', 'Hall-11'),
(408, 'E5', 'Hall-11'),
(409, 'E6', 'Hall-11'),
(410, 'F1', 'Hall-11'),
(411, 'F2', 'Hall-11'),
(412, 'F3', 'Hall-11'),
(413, 'F4', 'Hall-11'),
(414, 'F5', 'Hall-11'),
(415, 'F6', 'Hall-11'),
(416, 'G1', 'Hall-11'),
(417, 'G2', 'Hall-11'),
(418, 'G3', 'Hall-11'),
(419, 'G4', 'Hall-11'),
(420, 'G5', 'Hall-11'),
(421, 'G6', 'Hall-11'),
(422, 'H1', 'Hall-11'),
(423, 'H2', 'Hall-11'),
(424, 'H3', 'Hall-11'),
(425, 'H4', 'Hall-11'),
(426, 'H5', 'Hall-11'),
(427, 'H6', 'Hall-11'),
(428, 'A1', 'Hall-12'),
(429, 'A2', 'Hall-12'),
(430, 'A3', 'Hall-12'),
(431, 'A4', 'Hall-12'),
(432, 'A5', 'Hall-12'),
(433, 'A6', 'Hall-12'),
(434, 'B1', 'Hall-12'),
(435, 'B2', 'Hall-12'),
(436, 'B3', 'Hall-12'),
(437, 'B4', 'Hall-12'),
(438, 'B5', 'Hall-12'),
(439, 'B6', 'Hall-12'),
(440, 'C1', 'Hall-12'),
(441, 'C2', 'Hall-12'),
(442, 'C3', 'Hall-12'),
(443, 'C4', 'Hall-12'),
(444, 'C5', 'Hall-12'),
(445, 'C6', 'Hall-12'),
(446, 'D1', 'Hall-12'),
(447, 'D2', 'Hall-12'),
(448, 'D3', 'Hall-12'),
(449, 'D4', 'Hall-12'),
(450, 'D5', 'Hall-12'),
(451, 'D6', 'Hall-12'),
(452, 'E1', 'Hall-12'),
(453, 'E2', 'Hall-12'),
(454, 'E3', 'Hall-12'),
(455, 'E4', 'Hall-12'),
(456, 'E5', 'Hall-12'),
(457, 'E6', 'Hall-12'),
(458, 'F1', 'Hall-12'),
(459, 'F2', 'Hall-12'),
(460, 'F3', 'Hall-12'),
(461, 'F4', 'Hall-12'),
(462, 'F5', 'Hall-12'),
(463, 'F6', 'Hall-12'),
(464, 'G1', 'Hall-12'),
(465, 'G2', 'Hall-12'),
(466, 'G3', 'Hall-12'),
(467, 'G4', 'Hall-12'),
(468, 'G5', 'Hall-12'),
(469, 'G6', 'Hall-12'),
(470, 'H1', 'Hall-12'),
(471, 'H2', 'Hall-12'),
(472, 'H3', 'Hall-12'),
(473, 'H4', 'Hall-12'),
(474, 'H5', 'Hall-12'),
(475, 'H6', 'Hall-12'),
(476, 'A1', 'Hall-13'),
(477, 'A2', 'Hall-13'),
(478, 'A3', 'Hall-13'),
(479, 'A4', 'Hall-13'),
(480, 'A5', 'Hall-13'),
(481, 'A6', 'Hall-13'),
(482, 'B1', 'Hall-13'),
(483, 'B2', 'Hall-13'),
(484, 'B3', 'Hall-13'),
(485, 'B4', 'Hall-13'),
(486, 'B5', 'Hall-13'),
(487, 'B6', 'Hall-13'),
(488, 'C1', 'Hall-13'),
(489, 'C2', 'Hall-13'),
(490, 'C3', 'Hall-13'),
(491, 'C4', 'Hall-13'),
(492, 'C5', 'Hall-13'),
(493, 'C6', 'Hall-13'),
(494, 'D1', 'Hall-13'),
(495, 'D2', 'Hall-13'),
(496, 'D3', 'Hall-13'),
(497, 'D4', 'Hall-13'),
(498, 'D5', 'Hall-13'),
(499, 'D6', 'Hall-13'),
(500, 'E1', 'Hall-13'),
(501, 'E2', 'Hall-13'),
(502, 'E3', 'Hall-13'),
(503, 'E4', 'Hall-13'),
(504, 'E5', 'Hall-13'),
(505, 'E6', 'Hall-13'),
(506, 'F1', 'Hall-13'),
(507, 'F2', 'Hall-13'),
(508, 'F3', 'Hall-13'),
(509, 'F4', 'Hall-13'),
(510, 'F5', 'Hall-13'),
(511, 'F6', 'Hall-13'),
(512, 'G1', 'Hall-13'),
(513, 'G2', 'Hall-13'),
(514, 'G3', 'Hall-13'),
(515, 'G4', 'Hall-13'),
(516, 'G5', 'Hall-13'),
(517, 'G6', 'Hall-13'),
(518, 'H1', 'Hall-13'),
(519, 'H2', 'Hall-13'),
(520, 'H3', 'Hall-13'),
(521, 'H4', 'Hall-13'),
(522, 'H5', 'Hall-13'),
(523, 'H6', 'Hall-13'),
(524, 'A1', 'HALL-9'),
(525, 'A2', 'HALL-9'),
(526, 'A3', 'HALL-9'),
(527, 'A4', 'HALL-9'),
(528, 'A5', 'HALL-9'),
(529, 'A6', 'HALL-9'),
(530, 'B1', 'HALL-9'),
(531, 'B2', 'HALL-9'),
(532, 'B3', 'HALL-9'),
(533, 'B4', 'HALL-9'),
(534, 'B5', 'HALL-9'),
(535, 'B6', 'HALL-9'),
(536, 'C1', 'HALL-9'),
(537, 'C2', 'HALL-9'),
(538, 'C3', 'HALL-9'),
(539, 'C4', 'HALL-9'),
(540, 'C5', 'HALL-9'),
(541, 'C6', 'HALL-9'),
(542, 'D1', 'HALL-9'),
(543, 'D2', 'HALL-9'),
(544, 'D3', 'HALL-9'),
(545, 'D4', 'HALL-9'),
(546, 'D5', 'HALL-9'),
(547, 'D6', 'HALL-9'),
(548, 'E1', 'HALL-9'),
(549, 'E2', 'HALL-9'),
(550, 'E3', 'HALL-9'),
(551, 'E4', 'HALL-9'),
(552, 'E5', 'HALL-9'),
(553, 'E6', 'HALL-9'),
(554, 'F1', 'HALL-9'),
(555, 'F2', 'HALL-9'),
(556, 'F3', 'HALL-9'),
(557, 'F4', 'HALL-9'),
(558, 'F5', 'HALL-9'),
(559, 'F6', 'HALL-9'),
(560, 'E2', 'HALL-10'),
(561, 'E1', 'HALL-10'),
(562, 'D6', 'HALL-10'),
(563, 'D5', 'HALL-10'),
(564, 'D4', 'HALL-10'),
(565, 'D3', 'HALL-10'),
(566, 'D2', 'HALL-10'),
(567, 'E3', 'HALL-10'),
(568, 'E4', 'HALL-10'),
(569, 'E5', 'HALL-10'),
(570, 'E6', 'HALL-10'),
(571, 'F1', 'HALL-10'),
(572, 'F2', 'HALL-10'),
(573, 'F3', 'HALL-10'),
(574, 'F4', 'HALL-10'),
(575, 'F5', 'HALL-10'),
(576, 'F6', 'HALL-10'),
(577, 'D1', 'HALL-10'),
(578, 'C6', 'HALL-10'),
(579, 'A2', 'HALL-10'),
(580, 'A3', 'HALL-10'),
(581, 'A4', 'HALL-10'),
(582, 'A5', 'HALL-10'),
(583, 'A6', 'HALL-10'),
(584, 'B1', 'HALL-10'),
(585, 'B2', 'HALL-10'),
(586, 'B3', 'HALL-10'),
(587, 'B4', 'HALL-10'),
(588, 'B5', 'HALL-10'),
(589, 'B6', 'HALL-10'),
(590, 'C1', 'HALL-10'),
(591, 'C2', 'HALL-10'),
(592, 'C3', 'HALL-10'),
(593, 'C4', 'HALL-10'),
(594, 'C5', 'HALL-10'),
(595, 'A1', 'HALL-10');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` bigint(20) NOT NULL,
  `hallNo` varchar(16) NOT NULL,
  `movieid` int(11) NOT NULL,
  `showtime_start` datetime DEFAULT NULL,
  `showtime_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `hallNo`, `movieid`, `showtime_start`, `showtime_end`) VALUES
(58, 'HALL-1', 32, '2025-01-09 12:00:00', '2025-01-09 14:30:00'),
(59, 'HALL-1', 32, '2025-01-09 15:00:00', '2025-01-10 01:30:00'),
(60, 'HALL-1', 32, '2025-01-09 18:00:00', '2025-01-09 20:30:00'),
(61, 'HALL-1', 32, '2025-01-09 21:00:00', '2025-01-09 23:30:00'),
(65, 'HALL-2', 32, '2025-01-09 10:00:00', '2025-01-09 12:30:00'),
(66, 'HALL-2', 32, '2025-01-09 13:00:00', '2025-01-09 15:30:00'),
(67, 'HALL-2', 32, '2025-01-09 16:00:00', '2025-01-09 18:30:00'),
(68, 'HALL-3', 32, '2025-01-09 15:30:00', '2025-01-09 18:00:00'),
(70, 'HALL-2', 32, '2025-01-09 18:30:00', '2025-01-09 21:00:00'),
(72, 'HALL-4', 33, '2025-01-09 09:00:00', '2025-01-09 11:30:00'),
(74, 'HALL-4', 33, '2025-01-09 15:00:00', '2025-01-09 17:30:00'),
(75, 'HALL-4', 33, '2025-01-09 18:00:00', '2025-01-09 20:30:00'),
(76, 'HALL-4', 33, '2025-01-09 21:00:00', '2025-01-09 23:30:00'),
(77, 'HALL-5', 33, '2025-01-09 10:00:00', '2025-01-09 12:30:00'),
(79, 'HALL-5', 33, '2025-01-09 15:00:00', '2025-01-09 17:30:00'),
(80, 'HALL-6', 33, '2025-01-09 16:00:00', '2025-01-09 18:30:00'),
(81, 'HALL-6', 33, '2025-01-09 19:00:00', '2025-01-09 21:30:00'),
(82, 'HALL-6', 33, '2025-01-09 22:00:00', '2025-01-09 00:30:00'),
(83, 'HALL-7', 34, '2025-01-09 09:00:00', '2025-01-09 11:30:00'),
(84, 'HALL-7', 34, '2025-01-09 12:00:00', '2025-01-09 14:30:00'),
(85, 'HALL-7', 34, '2025-01-09 15:00:00', '2025-01-09 17:30:00'),
(86, 'HALL-7', 34, '2025-01-09 18:00:00', '2025-01-09 20:30:00'),
(87, 'HALL-7', 34, '2025-01-09 21:00:00', '2025-01-09 23:30:00'),
(88, 'HALL-8', 34, '2025-01-09 10:00:00', '2025-01-09 12:30:00'),
(89, 'HALL-8', 34, '2025-01-09 13:00:00', '2025-01-09 15:30:00'),
(90, 'HALL-8', 34, '2025-01-09 16:00:00', '2025-01-09 18:30:00'),
(91, 'HALL-8', 34, '2025-01-09 19:00:00', '2025-01-09 21:30:00'),
(93, 'HALL-9', 35, '2025-01-09 09:00:00', '2025-01-09 11:00:00'),
(94, 'HALL-9', 35, '2025-01-09 11:30:00', '2025-01-10 13:30:00'),
(95, 'HALL-9', 35, '2025-01-09 14:00:00', '2025-01-09 16:00:00'),
(96, 'HALL-9', 35, '2025-01-09 16:30:00', '2025-01-09 18:30:00'),
(97, 'HALL-9', 35, '2025-01-09 19:00:00', '2025-01-09 21:00:00'),
(98, 'HALL-9', 35, '2025-01-09 21:30:00', '2025-01-09 23:30:00'),
(103, 'HALL-10', 36, '2025-01-09 09:00:00', '2025-01-09 10:30:00'),
(104, 'HALL-10', 36, '2025-01-09 11:00:00', '2025-01-09 00:30:00'),
(105, 'HALL-10', 36, '2025-01-09 13:00:00', '2025-01-09 14:30:00'),
(106, 'HALL-10', 36, '2025-01-09 15:00:00', '2025-01-09 16:30:00'),
(107, 'HALL-10', 36, '2025-01-09 17:00:00', '2025-01-09 18:30:00'),
(108, 'HALL-10', 36, '2025-01-09 19:00:00', '2025-01-09 20:30:00'),
(109, 'HALL-10', 36, '2025-01-09 21:00:00', '2025-01-09 22:30:00'),
(110, 'HALL-10', 36, '2025-01-09 23:00:00', '2025-01-09 12:30:00'),
(111, 'Hall-11', 38, '2025-01-09 09:00:00', '2025-01-09 11:00:00'),
(112, 'Hall-11', 38, '2025-01-09 11:30:00', '2025-01-09 13:30:00'),
(113, 'Hall-11', 38, '2025-01-09 14:00:00', '2025-01-09 16:00:00'),
(114, 'Hall-11', 38, '2025-01-09 16:30:00', '2025-01-09 18:30:00'),
(115, 'Hall-11', 38, '2025-01-09 19:00:00', '2025-01-09 21:00:00'),
(116, 'Hall-11', 38, '2025-01-09 21:30:00', '2025-01-09 23:30:00'),
(117, 'HALL-1', 32, '2025-01-10 10:00:00', '2025-01-09 00:00:00'),
(119, 'HALL-1', 32, '2025-01-12 09:00:00', '2025-01-12 11:30:00'),
(120, 'HALL-1', 32, '2025-01-12 12:00:00', '2025-01-12 14:30:00'),
(121, 'HALL-1', 32, '2025-01-12 15:00:00', '2025-01-12 17:30:00'),
(122, 'HALL-1', 34, '2025-01-12 18:00:00', '2025-01-12 20:00:00'),
(123, 'HALL-1', 34, '2025-01-12 20:30:00', '2025-01-12 22:30:00'),
(124, 'HALL-1', 34, '2025-01-12 23:00:00', '2025-01-12 01:00:00'),
(125, 'HALL-2', 36, '2025-01-12 09:00:00', '2025-01-12 10:30:00'),
(126, 'HALL-2', 36, '2025-01-12 11:00:00', '2025-01-12 12:30:00'),
(127, 'HALL-2', 36, '2025-01-12 13:00:00', '2025-01-12 14:30:00'),
(128, 'HALL-2', 37, '2025-01-12 15:00:00', '2025-01-12 17:00:00'),
(129, 'HALL-2', 37, '2025-01-12 17:30:00', '2025-01-12 19:30:00'),
(130, 'HALL-2', 37, '2025-01-12 20:00:00', '2025-01-12 22:00:00'),
(131, 'HALL-2', 37, '2025-01-12 22:30:00', '2025-01-12 00:30:00'),
(134, 'HALL-2', 38, '2025-01-12 09:00:00', '2025-01-12 11:00:00'),
(135, 'HALL-2', 38, '2025-01-12 11:30:00', '2025-01-12 13:30:00'),
(136, 'HALL-2', 38, '2025-01-12 14:00:00', '2025-01-12 16:00:00'),
(137, 'HALL-2', 39, '2025-01-12 16:30:00', '2025-01-12 18:30:00'),
(138, 'HALL-2', 39, '2025-01-12 19:00:00', '2025-01-12 21:00:00'),
(139, 'HALL-2', 39, '2025-01-12 21:30:00', '2025-01-12 23:30:00'),
(140, 'HALL-3', 43, '2025-01-12 09:00:00', '2025-01-12 11:00:00'),
(141, 'HALL-3', 43, '2025-01-12 11:30:00', '2025-01-12 13:30:00'),
(142, 'HALL-3', 43, '2025-01-12 14:00:00', '2025-01-12 16:00:00'),
(143, 'HALL-3', 35, '2025-01-12 16:30:00', '2025-01-12 18:30:00'),
(144, 'HALL-3', 35, '2025-01-12 19:00:00', '2025-01-12 21:00:00'),
(145, 'HALL-3', 35, '2025-01-12 21:30:00', '2025-01-12 23:30:00'),
(146, 'HALL-1', 32, '2025-01-21 09:48:00', '2025-01-21 11:48:00'),
(147, 'HALL-10', 35, '2025-01-21 15:09:00', '2025-01-21 16:09:00'),
(148, 'HALL-1', 32, '2025-02-15 19:27:00', '2025-02-15 22:27:00'),
(149, 'HALL-1', 32, '2025-02-16 21:42:00', '2025-02-16 23:42:00'),
(150, 'HALL-1', 32, '2025-02-17 21:20:00', '2025-02-17 23:20:00'),
(151, 'HALL-1', 32, '2025-02-20 16:50:00', '2025-02-20 18:50:00'),
(152, 'HALL-1', 32, '2025-02-22 09:54:00', '2025-02-22 00:54:00'),
(153, 'HALL-1', 32, '2025-02-22 19:17:00', '2025-02-22 23:17:00'),
(154, 'HALL-1', 33, '2025-02-23 23:50:00', '2025-02-24 04:47:00'),
(155, 'HALL-1', 33, '2025-02-24 16:44:00', '2025-02-24 21:45:00'),
(156, 'Hall-11', 34, '2025-02-24 12:15:00', '2025-02-24 03:15:00'),
(157, 'HALL-1', 34, '2025-02-24 23:15:00', '2025-02-24 02:16:00'),
(158, 'HALL-1', 32, '2025-02-27 09:00:00', '2025-02-27 11:30:00'),
(159, 'HALL-1', 32, '2025-02-27 12:00:00', '2025-02-27 14:30:00'),
(160, 'HALL-1', 33, '2025-02-27 15:00:00', '2025-02-27 17:35:00'),
(161, 'HALL-1', 33, '2025-02-27 18:00:00', '2025-02-27 20:30:00'),
(162, 'HALL-1', 33, '2025-02-27 21:00:00', '2025-02-27 23:40:00'),
(163, 'HALL-6', 33, '2025-02-27 06:30:00', '2025-02-27 08:40:00'),
(164, 'HALL-1', 44, '2025-03-01 21:40:00', '2025-03-01 23:40:00'),
(165, 'HALL-1', 32, '2025-03-02 00:11:00', '2025-03-02 15:11:00'),
(166, 'HALL-1', 32, '2025-03-02 11:12:00', '2025-03-02 15:12:00'),
(167, 'HALL-1', 32, '2025-03-02 17:26:00', '2025-03-02 21:26:00'),
(168, 'HALL-10', 33, '2025-03-02 23:52:00', '2025-03-02 02:52:00'),
(169, 'HALL-1', 33, '2025-03-02 23:54:00', '2025-03-02 03:54:00'),
(170, 'HALL-9', 33, '2025-03-02 23:52:00', '2025-03-02 01:01:00'),
(171, 'HALL-10', 33, '2025-03-03 02:13:00', '2025-03-03 04:13:00'),
(172, 'HALL-10', 32, '2025-03-03 11:30:00', '2025-03-03 13:21:00'),
(173, 'HALL-10', 32, '2025-03-03 16:42:00', '2025-03-03 18:42:00'),
(174, 'HALL-1', 32, '2025-03-04 23:21:00', '2025-03-04 02:21:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookid`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `custid` (`custid`),
  ADD KEY `bookings_ibfk_3` (`hallNo`);

--
-- Indexes for table `clerk`
--
ALTER TABLE `clerk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custid`);

--
-- Indexes for table `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`hallNo`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoiceno`),
  ADD KEY `FK_custid` (`custid`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movieid`);

--
-- Indexes for table `password_reset_request`
--
ALTER TABLE `password_reset_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seatid`),
  ADD KEY `FK_hallNo` (`hallNo`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `movieid` (`movieid`),
  ADD KEY `sessions_ibfk_1` (`hallNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=819;

--
-- AUTO_INCREMENT for table `clerk`
--
ALTER TABLE `clerk`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `custid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoiceno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movieid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `password_reset_request`
--
ALTER TABLE `password_reset_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=596;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`custid`) REFERENCES `customer` (`custid`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`hallNo`) REFERENCES `hall` (`hallNo`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `FK_custid` FOREIGN KEY (`custid`) REFERENCES `customer` (`custid`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `FK_hallNo` FOREIGN KEY (`hallNo`) REFERENCES `hall` (`hallNo`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`hallNo`) REFERENCES `hall` (`hallNo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`movieid`) REFERENCES `movie` (`movieid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
