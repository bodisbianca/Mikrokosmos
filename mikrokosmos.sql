-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2021 at 07:37 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mikrokosmos`
--

-- --------------------------------------------------------

--
-- Table structure for table `administratori`
--

DROP TABLE IF EXISTS `administratori`;
CREATE TABLE IF NOT EXISTS `administratori` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `prenume` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parola` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `administratori`
--

INSERT INTO `administratori` (`id_admin`, `nume`, `prenume`, `username`, `parola`) VALUES
(1, 'Admin', 'Bianca', 'admin.bianca', '$2y$10$Ce1exOP4MrEaZZCzUAe9JuO6Ny9iILsBfcr74nq7Hs2CPBvJprDK6');

-- --------------------------------------------------------

--
-- Table structure for table `categorii_produse`
--

DROP TABLE IF EXISTS `categorii_produse`;
CREATE TABLE IF NOT EXISTS `categorii_produse` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_categorie`),
  UNIQUE KEY `categorie` (`categorie`),
  KEY `categorie_2` (`categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categorii_produse`
--

INSERT INTO `categorii_produse` (`id_categorie`, `categorie`) VALUES
(1, 'ALBUME'),
(4, 'BT21'),
(5, 'CĂRȚI'),
(2, 'DVD'),
(3, 'MERCHANDISE');

-- --------------------------------------------------------

--
-- Table structure for table `comenzi`
--

DROP TABLE IF EXISTS `comenzi`;
CREATE TABLE IF NOT EXISTS `comenzi` (
  `id_comanda` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `stare` varchar(100) CHARACTER SET utf8 COLLATE utf8_romanian_ci NOT NULL DEFAULT 'Înregistrată',
  `data_comanda` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `suma_plata` decimal(6,2) NOT NULL,
  `judet` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `localitate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `strada` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `numar` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `apartament` int(11) NOT NULL,
  `cod_postal` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_comanda`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comenzi`
--

INSERT INTO `comenzi` (`id_comanda`, `id_user`, `stare`, `data_comanda`, `suma_plata`, `judet`, `localitate`, `strada`, `numar`, `apartament`, `cod_postal`) VALUES
(6, 1, 'Expediată', '2021-06-22 18:11:15', '140.00', 'Cluj', 'Cluj-Napoca', 'Grigore Alexandrescu', '31', 313, '400515'),
(7, 1, 'Anulată', '2021-06-23 23:45:51', '155.00', 'Cluj', 'Cluj-Napoca', 'Grigore Alexandrescu', '13', 11, '400515'),
(8, 1, 'Expediată', '2021-06-24 00:20:08', '63.00', 'Cluj', 'Cluj-Napoca', 'Grigore Alexandrescu', '12', 9, '400515'),
(9, 1, 'Finalizată', '2021-06-25 20:42:52', '220.00', 'Cluj', 'Cluj-Napoca', 'Grigore Alexandrescu', '23', 313, '400515'),
(11, 16, 'Expediată', '2021-06-26 13:47:55', '602.00', 'Alba', 'Alba-Iulia', 'Strada Cetatii', '25', 102, '412565'),
(12, 16, 'Înregistrată', '2021-06-26 14:10:38', '134.00', 'Cluj', 'Cluj-Napoca', 'Strada Apei', '25', 89, '405369'),
(13, 17, 'Înregistrată', '2021-06-26 17:53:31', '599.00', 'Constanta', 'Constanta', 'Strada Falezei', '23', 44, '427896');

-- --------------------------------------------------------

--
-- Table structure for table `comenzi_bilete`
--

DROP TABLE IF EXISTS `comenzi_bilete`;
CREATE TABLE IF NOT EXISTS `comenzi_bilete` (
  `id_rezervare` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_concert` int(11) NOT NULL,
  `id_sectiune` int(11) NOT NULL,
  `loc` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rezervare`),
  KEY `id_user` (`id_user`),
  KEY `id_concert` (`id_concert`),
  KEY `id_sectiune` (`id_sectiune`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comenzi_bilete`
--

INSERT INTO `comenzi_bilete` (`id_rezervare`, `id_user`, `id_concert`, `id_sectiune`, `loc`, `data`) VALUES
(28, 1, 1, 11, '40-9', '2021-06-19 17:45:13'),
(30, 16, 1, 65, '1-4', '2021-06-26 13:49:26'),
(31, 16, 1, 65, '1-5', '2021-06-26 13:49:26'),
(32, 17, 15, 65, '1-6', '2021-06-26 17:55:52'),
(33, 1, 16, 95, '9-5', '2021-06-26 19:34:42'),
(34, 1, 16, 95, '2-13', '2021-06-26 19:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `comenzi_produse`
--

DROP TABLE IF EXISTS `comenzi_produse`;
CREATE TABLE IF NOT EXISTS `comenzi_produse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_comanda` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `id_ver` int(11) DEFAULT NULL,
  `cantitate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_comanda` (`id_comanda`),
  KEY `id_prod` (`id_prod`),
  KEY `id_ver` (`id_ver`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comenzi_produse`
--

INSERT INTO `comenzi_produse` (`id`, `id_comanda`, `id_prod`, `id_ver`, `cantitate`) VALUES
(14, 6, 35, NULL, 1),
(15, 7, 47, 24, 1),
(16, 8, 46, NULL, 1),
(17, 9, 27, NULL, 1),
(18, 9, 35, NULL, 1),
(22, 11, 61, NULL, 2),
(23, 11, 26, NULL, 1),
(24, 11, 56, 38, 1),
(25, 12, 34, NULL, 1),
(26, 13, 71, NULL, 1),
(27, 13, 75, NULL, 1),
(28, 13, 54, 32, 1);

-- --------------------------------------------------------

--
-- Table structure for table `concerte`
--

DROP TABLE IF EXISTS `concerte`;
CREATE TABLE IF NOT EXISTS `concerte` (
  `id_concert` int(11) NOT NULL AUTO_INCREMENT,
  `id_stadion` int(11) NOT NULL,
  `nume_concert` varchar(200) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `durata` int(11) NOT NULL,
  PRIMARY KEY (`id_concert`),
  KEY `id_stadion` (`id_stadion`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `concerte`
--

INSERT INTO `concerte` (`id_concert`, `id_stadion`, `nume_concert`, `poster`, `data`, `ora`, `durata`) VALUES
(1, 1, 'Love Yourself', '../media/Concerte/love_yourself.png', '2021-09-18', '18:00:00', 240),
(13, 1, 'Wings', '../media/Concerte/wings.jpg', '2021-07-10', '20:00:00', 240),
(15, 1, 'Map Of The Soul', '../media/Concerte/mots.jpg', '2021-08-20', '19:00:00', 250),
(16, 18, '2021 MUSTER SOWOOZOO ', '../media/Concerte/muster_sowoozoo.png', '2021-07-03', '18:30:00', 200);

-- --------------------------------------------------------

--
-- Table structure for table `cos_bilete`
--

DROP TABLE IF EXISTS `cos_bilete`;
CREATE TABLE IF NOT EXISTS `cos_bilete` (
  `id_cos` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_concert` int(11) NOT NULL,
  `id_sectiune` int(11) NOT NULL,
  `loc` varchar(10) NOT NULL,
  PRIMARY KEY (`id_cos`),
  KEY `id_user` (`id_user`),
  KEY `id_concert` (`id_concert`),
  KEY `id_sectiune` (`id_sectiune`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cos_client`
--

DROP TABLE IF EXISTS `cos_client`;
CREATE TABLE IF NOT EXISTS `cos_client` (
  `id_cos` int(11) NOT NULL AUTO_INCREMENT,
  `id_prod` int(11) NOT NULL,
  `id_ver` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `cantitate` int(11) NOT NULL,
  PRIMARY KEY (`id_cos`),
  KEY `id_user` (`id_user`),
  KEY `id_prod` (`id_prod`),
  KEY `id_ver` (`id_ver`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `date_biografice`
--

DROP TABLE IF EXISTS `date_biografice`;
CREATE TABLE IF NOT EXISTS `date_biografice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subtitlu` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `informatii` text COLLATE utf8_unicode_ci NOT NULL,
  `imagine` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `date_biografice`
--

INSERT INTO `date_biografice` (`id`, `subtitlu`, `informatii`, `imagine`) VALUES
(1, 'Despre BTS', 'BTS, un acronim pentru Bangtan Sonyeondan sau \"Beyond the scene\", este o trupă  din Coreea de Sud care a capturat inimile a milioane de fani din întreaga lume de la debutul lor din iunie 2013. \\n\r\nMembrii trupei sunt RM, Jin, Suga, J-Hope, Jimin, V și Jung Kook. Fiind renumiți pentru muzica lor autentică. spectacole de primă clasă și felul în care interacționează cu fanii lor, BTS sunt recunoscuți ca și cei mai consacrați artiști pop ai secolului 21.  \\n\r\nRăspândind o influență pozitivă prin activități precum campania LOVE MYSELF și discursul \"Speak Yourself\" din cadrul UN, trupa a mobilizat milioane de fani din toată lumea (numiți ARMY), au fost pe primul loc în topul Biillboard Hot 100 de trei ori doar în anul 2020, au avut spectacole cu casa închisă pe stadioane din toată lumea și au fost numiți artiștii anului 2020 de către revista Time. \\n\r\nBTS au fost nominalizați la categoria Best Pop Duo/Group la cea de-a 63-a ediție a premiilor Grammy și au participat la numeroase premii prestigioase printre care Billboard Music Awards, American Music Awards și MTV Video Music Awards. \\n', '../media/BTS/group-butter.png');

-- --------------------------------------------------------

--
-- Table structure for table `date_video`
--

DROP TABLE IF EXISTS `date_video`;
CREATE TABLE IF NOT EXISTS `date_video` (
  `id_video` int(11) NOT NULL AUTO_INCREMENT,
  `titlu` varchar(200) NOT NULL,
  `data` date DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `categorie` varchar(200) NOT NULL,
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `date_video`
--

INSERT INTO `date_video` (`id_video`, `titlu`, `data`, `link`, `categorie`) VALUES
(1, 'Antrenament coregrafia piesei BUTTER ', '2021-05-30', 'https://www.youtube.com/embed/ujf3iJoWgrM', 'antrenamente'),
(2, 'Antrenament coregrafia piesei Dynamite', '2020-09-02', 'https://www.youtube.com/embed/CN4fffh7gmk', 'antrenamente'),
(3, 'Spectacol ON la Grand Terminal Center, America', '2020-02-25', 'https://www.youtube.com/embed/MZh-w2nysuI', 'spectacole'),
(4, 'Spectacol IDOL la emisiunea The Tonight Show Starring Jimmy Fallon\r\n', '2020-09-29', 'https://www.youtube.com/embed/MXFkjMNXfpY', 'spectacole'),
(5, 'Interviu la emisiunea The Tonight Show Starring Jimmy Fallon', '2018-03-26', 'https://www.youtube.com/embed/W4mmfzFazoI', 'interviuri'),
(6, 'Interviu la emisiunea The Late Late Show with James Corden', '2020-01-29', 'https://www.youtube.com/embed/6_dPHFg7lxo', 'interviuri'),
(7, 'Trailer oficial al filmului \'BRING THE SOUL: THE MOVIE\'', '2019-08-02', 'https://www.youtube.com/embed/JfMZov2GV-Q', 'index'),
(8, 'Antrenament coregrafia piesei ON', '2020-02-25', 'https://www.youtube.com/embed/VkuEzN8IS_o', 'antrenamente'),
(9, 'Antrenament coregrafia piesei Black Swan', '2020-02-07', 'https://www.youtube.com/embed/fTS1jAhWPbw', 'antrenamente'),
(10, 'Antrenament coregrafia piesei Boy With Luv', '2019-04-21', 'https://www.youtube.com/embed/CzvfbRbEjww', 'antrenamente'),
(15, 'Spectacol MIC DROP Remix la Jimmy Kimmel Live', '2017-11-30', 'https://www.youtube.com/embed/pjscAFB-U4o', 'spectacole'),
(16, 'Spectacol BLACK SWAN la  The Late Late Show with James Corden', '2020-01-29', 'https://www.youtube.com/embed/wSNd02kVv8o', 'spectacole'),
(17, 'Spectacol BUTTER la The Late Show with Stephen Colbert', '2021-05-26', 'https://www.youtube.com/embed/3kRl7gkXdXM', 'spectacole'),
(18, 'Interviu la emisiunea  The Late Show with Stephen Colbert', '2019-05-16', 'https://www.youtube.com/embed/LiyPWH6Gm3U', 'interviuri'),
(19, 'Interviu la emisiunea The Graham Norton Show', '2018-10-12', 'https://www.youtube.com/embed/wBEu2Tmy_L4', 'interviuri'),
(20, 'Interviu la emisiunea Good Morning America', '2018-09-26', 'https://www.youtube.com/embed/MvF8-sQqaqY', 'interviuri');

-- --------------------------------------------------------

--
-- Table structure for table `imagini_produse`
--

DROP TABLE IF EXISTS `imagini_produse`;
CREATE TABLE IF NOT EXISTS `imagini_produse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prod` int(11) NOT NULL,
  `poza` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_prod` (`id_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `imagini_produse`
--

INSERT INTO `imagini_produse` (`id`, `id_prod`, `poza`) VALUES
(3, 17, '../media/BT21/ceas_koya_2.jpg'),
(4, 17, '../media/BT21/ceas_koya_3.jpg'),
(5, 20, '../media/BT21/bentita_cooky_2.jpg'),
(6, 20, '../media/BT21/bentita_cooky_3.jpg'),
(9, 21, '../media/BT21/ghiozdan_BT21_2.jpg'),
(10, 21, '../media/BT21/ghiozdan_BT21_3.jpg'),
(15, 22, '../media/BT21/incarcator_mang_2.jpg'),
(16, 22, '../media/BT21/incarcator_mang_3.jpg'),
(17, 23, '../media/BT21/termos_chimmy_2.jpg'),
(18, 23, '../media/BT21/termos_chimmy_3.jpg'),
(19, 24, '../media/BT21/perna_shooky_2.jpg'),
(20, 24, '../media/BT21/perna_shooky_3.jpg'),
(21, 25, '../media/BT21/plus_RJ_2.jpg'),
(22, 26, '../media/BT21/figurina_tata_2.jpg'),
(23, 26, '../media/BT21/figurina_tata_3.jpg'),
(24, 27, '../media/BT21/breloc_van_2.jpg'),
(25, 27, '../media/BT21/breloc_van_3.jpg'),
(26, 28, '../media/Merch/army_bomb_2.jpg'),
(27, 29, '../media/Merch/inel_army_bomb_2.jpg'),
(28, 31, '../media/Merch/colier_2.jpg'),
(29, 33, '../media/Merch/sapca_2.jpg'),
(30, 33, '../media/Merch/sapca_3.jpg'),
(31, 35, '../media/Merch/penar_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `produse`
--

DROP TABLE IF EXISTS `produse`;
CREATE TABLE IF NOT EXISTS `produse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `categorie` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pret` decimal(6,2) NOT NULL,
  `poza` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriere` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cantitate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categorie` (`categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `produse`
--

INSERT INTO `produse` (`id`, `denumire`, `categorie`, `pret`, `poza`, `descriere`, `cantitate`) VALUES
(1, '2 Cool 4 Skool', 'ALBUME', '37.00', '../media/albume/1.2cool4skool/2cool4skool.jpg', '\"2 Cool 4 Skool\" este single-ul de debut al trupei BTS. A fost lansat pe 12 iunie 2013 cu piesa de titlu \"No More Dream\".', NULL),
(2, 'O!RUL8,2?', 'ALBUME', '41.00', '../media/albume/2.rul82/orul82.jpg', '\"O!RUL8,2?\" este primul mini-album al trupei BTS.\r\nA fost lansat pe 11 septembrie 2013 cu piesa de titlu \"N.O\". Albumul a fost pe locul 55 în topul celor mai vândute albume din Coreea de Sud în anul 2013.', NULL),
(3, 'Skool Luv Affair', 'ALBUME', '45.00', '../media/albume/3.sla/skoolluvaffair.jpg', '\"Skool Luv Affair\" este al doilea mini album al trupei BTS. A fost lansat pe 12 februarie 2014 cu piesa de titlu \"Boy In luv\". Albumul a fost pe locul 20 în topul celor mai vândute albume din Coreea de Sud în anul 2014.', NULL),
(4, 'Skool Luv Affair Special Addition', 'ALBUME', '61.00', '../media/albume/4.slaspecial/slaspecial.png', '\"Skool Luv Affair Special Addition\" este varianta repackage a celui de-al doilea mini album al trupei BTS. A fost lansat pe 14 mai 2014 cu piesa de titlu \"Miss Right\" și conține alte două piese noi și șase piese ascunse.', NULL),
(5, 'No More Dream', 'ALBUME', '41.00', '../media/albume/5.nmd_jp/jpn_nomoredream.jpg', 'No More Dream este primul single japonez al trupei BTS. A fost lansat pe 4 iunie 2014 cu piesa de titlu \"No More Dream(varianta japoneză)\".', NULL),
(6, 'Boy In Luv', 'ALBUME', '41.00', '../media/albume/6.bil_jp/jpn_boyinluv.jpg', '\"Boy In Luv\" este al doilea single japonez al trupei BTS. A fost lansat pe 16 iulie 2014 cu piesa de titlu \"Boy In Luv(varianta japoneză)\".', NULL),
(7, 'Dark & Wild', 'ALBUME', '53.00', '../media/albume/7.darknwild/darkandwild.jpg', '\"Dark & Wild\" este primul album studio al trupei BTS. A fost lansat pe 19 august 2014 cu piesa de titlu \"Danger\". Albumul a fost pe locul 14 în topul celor mai vândute albume din Coreea de Sud în anul 2014.', NULL),
(8, 'Danger', 'ALBUME', '45.00', '../media/albume/8.danger_jp/jpn_danger.jpg', '\"Danger\" este al treilea single japonez al trupei BTS. \r\nA fost lansat pe 19 noiembrie 2014 cu piesa de titlu \"Danger(varianta japoneză)\".', NULL),
(9, 'Wake Up', 'ALBUME', '61.00', '../media/albume/9.wakeup_jp/jpn_wakeup.jpg', '\"Wake Up\" este primul album studio în japoneză al trupei BTS. A fost lansat pe 24 decembrie 2014. Albumul conține piesele \"No More Dream\", \"Boy In Luv\" și \"Danger\", precum și piese noi originale în japoneză.', NULL),
(10, 'The Most Beautiful Moment in Life Pt. 1', 'ALBUME', '49.00', '../media/albume/10.hyyh1/hyyh1.jpg', '\"The Most Beautiful Moment in Life Pt.1\"  este al treilea mini album al trupei BTS. A fost lansat pe 29 aprilie 2015 cu piesa de titlu \"I Need U\". Albumul a fost pe locul 6 în topul celor mai vândute albume în Coreea de Sud în anul 2015.', NULL),
(15, 'For You', 'ALBUME', '35.00', '../media/albume/11.foryou_jp/jpn_foryou.jpg', '\"For you\" este al patrulea single japonez al trupei BTS. A fost lansat pe 17 iunie 2015 cu piesa de titlu \"For You\".', NULL),
(16, 'The Most Beautiful Moment in Life Pt.2', 'ALBUME', '35.00', '../media/albume/12.hyyh2/hyyhpt2.jpg', '\"The Most Beautiful Moment in Life Pt.2\" este al patrulea mini album al trupei BTS. A fost lansat pe 30 noiembrie 2015 cu piesa de titlu \"Run\". Albumul a fost pe locul 5 în topul celor mai vândute albume în Coreea de Sud în anul 2015.', NULL),
(17, 'Ceas Koya', 'BT21', '242.00', '../media/BT21/ceas_koya.jpg', '', 0),
(20, 'Bentiță de păr Cooky', 'BT21', '57.50', '../media/BT21/bentita_cooky.jpg', '', 10),
(21, 'Ghiozdan BT21', 'BT21', '243.00', '../media/BT21/ghiozdan_BT21.jpg', '', 10),
(22, 'Încărcător wireless Mang', 'BT21', '170.00', '../media/BT21/incarcator_mang.jpg', '', 10),
(23, 'Termos Chimmy', 'BT21', '202.00', '../media/BT21/termos_chimmy.jpg', '', 5),
(24, 'Pernă pentru gât Shooky', 'BT21', '80.00', '../media/BT21/perna_shooky.jpg', '', 10),
(25, 'Pluș RJ', 'BT21', '121.00', '../media/BT21/plus_RJ.jpg', '', 10),
(26, 'Figurină TATA', 'BT21', '117.00', '../media/BT21/figurina_tata.jpg', '', 10),
(27, 'Breloc VAN', 'BT21', '80.00', '../media/BT21/breloc_van.jpg', '', 10),
(28, 'ARMY Bomb Map of the Soul Special Edition', 'MERCHANDISE', '487.00', '../media/Merch/army_bomb.jpg', '', 20),
(29, 'Mini inel Army Bomb', 'MERCHANDISE', '182.00', '../media/Merch/inel_army_bomb.jpg', '', 20),
(30, 'Cană BTS', 'MERCHANDISE', '194.00', '../media/Merch/cana.jpg', '', 20),
(31, 'Colier argint ARMY', 'MERCHANDISE', '238.00', '../media/Merch/colier.jpg', '', 10),
(32, 'Mască BTS', 'MERCHANDISE', '60.00', '../media/Merch/masca.jpg', '', 20),
(33, 'Șapcă BTS', 'MERCHANDISE', '81.00', '../media/Merch/sapca.jpg', '', 15),
(34, 'Husă Lightstick ver. 2', 'MERCHANDISE', '134.00', '../media/Merch/husa_lightstick.jpg', '', 10),
(35, 'Penar BTS', 'MERCHANDISE', '140.00', '../media/Merch/penar.jpg', '', 5),
(38, 'I Need U', 'ALBUME', '35.00', '../media/Albume/13.ineedu_jp/jpn_ineedyou.jpg', '\"I Need U\" este al cincilea single japonez al trupei BTS. A fost lansat pe 8 decembrie 2015 cu piesa de titlu \"I Need U (varianta japoneză)\".', 5),
(39, 'Run', 'ALBUME', '40.00', '../media/Albume/14.run_jp/jpn_run.jpg', '\"Run\" este al șaselea single japonez al trupei BTS.  \r\nA fost lansat pe 15 martie 2016 cu piesa de titlu \"Run (varianta japoneză)\".', 10),
(40, 'Young Forever', 'ALBUME', '150.00', '../media/Albume/15.youngforever/youngforever.jpg', '\"Young Forever\" ese primul album compilație al trupei BTS. A fost lansat pe 2 mai 2016 cu piesa de titlu \"Fire\". Albumul conține piese din albumele \"The Most Beautiful Moment in Life Pt. 1\" și \"The Most Beautiful Moment in Life Pt. 2\", trei piese noi și căteva remix-uri.', 10),
(41, 'Youth', 'ALBUME', '50.00', '../media/Albume/16.youth_jp/jpn_youth.jpg', '\"Youth\" este al doilea album studio în japoneză al trupei BTS. A fost lansat pe 7 septembrie 2016. Albumul conține piesele \"For You\", \"I Need U\" și \"Run\", precum și alte piese originale în japoneză.', 10),
(42, 'Wings', 'ALBUME', '130.00', '../media/Albume/17.wings/wings.jpg', '\"Wings\" este al doilea album studio în coreeană al trupei BTS. A fost lansat pe 10 octombrie 2016 cu piesa de titlu \"Blood, Sweat & Tears\" și a fost cel mai vândut album al anului în Coreea de Sud.', 10),
(43, 'Wings', 'ALBUME', '130.00', '../media/Albume/17.wings/wings.jpg', '\"Wings\" este al doilea album studio în coreeană al trupei BTS. A fost lansat pe 10 octombrie 2016 cu piesa de titlu \"Blood, Sweat & Tears\" și a fost cel mai vândut album al anului în Coreea de Sud.', 10),
(44, 'Wings', 'ALBUME', '130.00', '../media/Albume/17.wings/wings.jpg', '\"Wings\" este al doilea album studio în coreeană al trupei BTS. A fost lansat pe 10 octombrie 2016 cu piesa de titlu \"Blood, Sweat & Tears\" și a fost cel mai vândut album al anului în Coreea de Sud.', 10),
(45, 'You Never Walk Alone', 'ALBUME', '173.00', '../media/Albume/18.ynwa/ynwa.jpg', '\"You Never Walk Alone\" este varianta repackage a albumului Wings. A fost lansat pe 13 februarie 2017 cu piesa de titlu \"Spring Day\" și a fost al treilea cel mai vândut album al anului în Coreea de Sud.', 10),
(46, 'Blood Sweat & Tears', 'ALBUME', '63.00', '../media/Albume/19.bst_jp/jpn_bst.jpg', '\"Blood, Sweat & Tears\" este al șaptelea single japonez al trupei BTS. A fost lansat pe 10 mai 2017 cu piesa de titlu \"Blood, Sweat & Tears(varianta japoneză)\".', 10),
(47, 'Love Yourself: Her', 'ALBUME', '155.00', '../media/Albume/20.her/her.jpg', '\"Love Yourself:Her\" este al cincilea mini album al trupei BTS. A fost lansat pe 18 septembrie 2017 cu piesa de titlu \"DNA\". Albumul a debutat pe locul 7 în topul Billboard 200 și a fost cel mai vândut album al anului în Coreea de Sud.', 10),
(51, 'MIC Drop/DNA/Crystal Snow', 'ALBUME', '60.00', '../media/Albume/21.micdrop_jp/jpn_micdrop.png', '\"MIC Drop/DNA/Crystal Snow\" este al optulea single japonez al trupei BTS. A fost lansat pe 6 decembrie 2017 cu piesa de titlu \"MIC Drop(varianta japoneză)\".', 12),
(52, 'Face Yourself', 'ALBUME', '54.50', '../media/Albume/22.foryou_jp/jpn_faceyourself.jpg', '\"Face Yourself\" este al treilea album studio în japoneză al trupei BTS. A fost lansat pe 4 aprilie 2018, cu piesele \"Blood Sweat & Tears\", \"MIC Drop/DNA/Crystal Snow\" și alte piese originale în  japoneză.', 2),
(53, 'Love Yourself: Tear', 'ALBUME', '147.00', '../media/Albume/23.tear/tear.jpg', '\"Love Yourself:Tear\" este al treilea album studio în coreeană al trupei BTS. A fost lansat pe 18 mai 2018 cu piesa de titlu \"FAKE LOVE\". Albumul a debutat pe locul 1 în topul Billboard 200 și a fost nominalizat pentru un premiu GRAMMY. ', 20),
(54, 'Love Yourself: Answer', 'albume', '175.00', '../media/Albume/24.answer/answer.jpg', '\"Love Yourself:Answer\" este al doilea album compilație al trupei BTS. A fost lansat pe 24 august 2018 cu piesa de titlu \"IDOL\". Albumul conține piese din cele două albume anterioare, șapte piese noi și trei remix-uri.', 15),
(55, 'FAKE LOVE/Airplane Pt. 2', 'ALBUME', '65.00', '../media/Albume/25.fl_jp/jpn_fakelove.png', '\"FAKE LOVE/Airplane Pt.2\" este al nouălea single japonez al trupei BTS. A fost lansat pe 7 noiembrie 2018 cu piesa de titlu \"Airplane Pt.2(varianta japoneză)\".', 10),
(56, 'Map of the Soul: Persona', 'albume', '145.00', '../media/Albume/26.persona/motspersona.jpg', '\"Map of the Soul: Persona\" este al șaselea mini album al trupei BTS. A fost lansat pe 12 aprilie 2019 cu piesa de titlu \"Boy With Luv (featuring Halsey)\". Albumul a debutat pe primul loc în topul Billboard 200 și a fost cel mai vândut album al anului în Coreea de Sud. ', 25),
(57, 'BTS World: Original Soundtrack', 'ALBUME', '210.00', '../media/Albume/27.btsworld/btsworld.png', 'BTS World: Original Soundtrack este albumul trupei bts pentru jocul pe mobil BTW World realizat de Netmarble. A fost lansat pe 28 iunie 2019 cu piesa de titlu Heartbeat.', 35),
(58, 'Lights/Boy With Luv', 'ALBUME', '75.00', '../media/Albume/28.lights/jpn_lights.jpg', '\"Lights/Boy With Luv\" este al zecelea single japonez al trupei BTS. A fost lansat pe 3 iulie 2019 cu piesa de titlu \"Lights\".', 12),
(59, 'Map of the Soul: 7', 'ALBUME', '170.00', '../media/Albume/29.mots7/mots7.jpg', '\"Map of the Soul:7\" este al patrulea album studio al trupei BTS. A fost lansat pe 21 februrie 2020 cu piesa de titlu \"ON\". Albumul a debutat pe locul 1 în topul Billboard 200 și a fost cel mai vândut album al anului în Coreea de Sud. Albumul este cel mai vândut album din toate timpurile în Coreea de Sud.', 34),
(60, 'Map of the Soul: 7 The Journey', 'albume', '195.00', '../media/Albume/30.mots_jp/jpn_motsjourney.jpg', '\"Map of the Soul: 7 The Journey\" este al patrulea album studio în japoneză al trupei BTS. \r\nA fost lansat pe 15 iulie 2020 cu piesa de titlu \"Stay Gold\" și conține piese noi în japoneză.', 24),
(61, 'BE', 'ALBUME', '170.00', '../media/Albume/31.BE/coperta.jpg', '\"BE\" este primul album auto-regizat și al șaptelea mini album al trupei BTS. A fost lansat pe 20 noiembrie 2020. Albumul a debutat pe locul 1 în topul Billboard 200. Albumul a fost al doilea cel mai vândut album al anului în Coreea de Sud.', 50),
(62, '4TH MUSTER', 'DVD', '162.00', '../media/DVD/BTS_4th_Muster_DVD.jpg', 'BTS 4th Muster: Happy Ever After a fost al patrulea eveniment de tip muster și a avut loc în perioada 13-14 ianuarie 2018 în Coreea de Sud. DVD-ul a fost lansat pe 31 octombrie 2018, iar mai apoi pe 21 noiembrie în varianta Blu-ray.', 40),
(63, '5TH MUSTER', 'DVD', '190.00', '../media/DVD/BTS_5th_Muster_DVD.jpg', 'BTS 5th Muster: Magic Shop a fost al cincilea eveniment de tip muster și a avut loc în perioada 15-23 iunie 2019 în Coreea de Sud. \r\nDVD-ul a fost lansat pe 7 aprilie 2020, iar mai apoi pe 5 mai 2020 în varianta Blu-ray.', 20),
(65, 'MEMORIES OF 2018', 'DVD', '190.00', '../media/DVD/BTS_Memories_2018.jpg', 'BTS Memories of 2019 oferă 480 de minute captivante și pline de viață și filmări cu BTS și ARMY din 2019 pe 4 CD-uri, de la BTS Prom Party, culisele albumelor Love Yourself:Tear și Love Yourself: Answer, turneul mondial Love Yourself și alte momente speciale.', 35),
(66, 'MEMORIES OF 2019', 'DVD', '243.00', '../media/DVD/BTS_Memories_2019.jpg', 'BTS Memories of 2019 oferă 700 de minute captivante și pline de viață și filmări cu BTS și ARMY din 2019 pe 6 CD-uri, de la înregistrearea concertului Rose Bowl din LA, turneul LOVE YOURSELF:SPEAK YOURSELF, filmări din culisele ședinței foto pentru MAP OF THE SOUL:PERSONA și New Year\'s Rockin Eve.', 23),
(67, 'WINTER PACKAGE 2020', 'DVD', '162.00', '../media/DVD/BTS_Winter_Package_2020.jpg', 'Un vlog de iarnă și un album foto cu membri trupei care iau parte la diferite ședințe foto în Helsinki, Finlanda, și un DVD cu filmări din culisele ședințelor foto și diferite jocuri.', 23),
(68, 'SEASON\'S GREETINGS 2020', 'DVD', '158.00', '../media/DVD/BTS_Season_Greetings_2020.jpg', 'Pachetul anual care conține planificatoare și DVD cu filmări din culise.', 10),
(69, 'WINTER PACKAGE 2021', 'DVD', '184.00', '../media/DVD/BTS_Winter_Package_2021.jpg', 'Un vlog de iarnă și un album foto cu membri trupei care iau parte la diferite ședințe foto în Gangwon, Coreea de Sud, și un DVD cu filmări din culisele ședințelor foto și diferite jocuri.', 23),
(70, 'SEASON\'S GREETINGS 2021', 'DVD', '243.00', '../media/DVD/BTS_Season_Greetings_2021.jpg', 'Pachetul anual care conține planificatoare și DVD cu filmări din culise.', 20),
(71, 'The Notes 1 (engleză)', 'CĂRȚI', '174.00', '../media/TheNotes/notes1_eng.png', '', 11),
(72, 'The Notes 1 (japoneză)', 'CĂRȚI', '166.00', '../media/TheNotes/notes1_jap.png', '', 20),
(73, 'The Notes 1 (coreeană)', 'CĂRȚI', '121.00', '../media/TheNotes/notes1_cor.png', '', 20),
(74, 'The Notes 1 (spaniolă)', 'CĂRȚI', '170.00', '../media/TheNotes/notes1_spa.jpg', '', 20),
(75, 'The Notes 2 (engleză)', 'CĂRȚI', '250.00', '../media/TheNotes/notes2_eng.jpg', '', 12),
(76, 'The Notes 2 (japoneză)', 'CĂRȚI', '230.00', '../media/TheNotes/notes2_jap.jpg', '', 24),
(77, 'The Notes 2 (coreeană)', 'CĂRȚI', '175.00', '../media/TheNotes/notes2_cor.jpg', '', 12),
(78, 'The Notes 2 (spaniolă)', 'CĂRȚI', '250.00', '../media/TheNotes/notes2_spa.jpg', '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `prod_albume`
--

DROP TABLE IF EXISTS `prod_albume`;
CREATE TABLE IF NOT EXISTS `prod_albume` (
  `id_alb` int(11) NOT NULL AUTO_INCREMENT,
  `id_prod` int(11) NOT NULL,
  `limba` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `an_aparitie` int(11) DEFAULT NULL,
  `durata` int(11) DEFAULT NULL,
  `nr_cantece` int(11) DEFAULT NULL,
  `tip_album` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `poza_fizic` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poza_grup` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poza_tracklist` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_spotify` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_youtube` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_itunes` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_alb`),
  KEY `prod_albume_ibfk_1` (`id_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `prod_albume`
--

INSERT INTO `prod_albume` (`id_alb`, `id_prod`, `limba`, `an_aparitie`, `durata`, `nr_cantece`, `tip_album`, `poza_fizic`, `poza_grup`, `poza_tracklist`, `link_spotify`, `link_youtube`, `link_itunes`) VALUES
(1, 1, 'coreean', 2013, 27, 7, 'mini', '../media/albume/1.2cool4skool/2cool4skool2.jpg', '../media/albume/1.2cool4skool/grup.jpg', '../media/albume/1.2cool4skool/2cool4skool3.png', ' https://open.spotify.com/album/26z5WolFltYgVMuuJ3c0Am ', 'https://www.youtube.com/embed/rBG5L7UsUxA', 'https://music.apple.com/ca/album/2-cool-4-skool/1274569086'),
(2, 2, 'coreean', 2013, 30, 10, 'mini', '../media/albume/2.rul82/orul822.png', '../media/albume/2.rul82/grup.jpg', '../media/albume/2.rul82/orul823.png', 'https://open.spotify.com/album/7xp8NlqiWjtSJ8oFvyShB2', 'https://www.youtube.com/embed/r5GaAEHvHj0', 'https://music.apple.com/ca/album/o-rul8-2/1274597086'),
(3, 3, 'coreean', 2014, 35, 10, 'mini', '../media/albume/3.sla/skoolluvaffair2.jpg', '../media/albume/3.sla/grup.jpg', '../media/albume/3.sla/skoolluvaffair3.png', 'https://open.spotify.com/album/5DIb84mvBHZnYFpIsdt2tL', 'https://www.youtube.com/embed/m8MfJg68oCs', 'https://music.apple.com/ca/album/skool-luv-affair/1274577701'),
(4, 4, 'coreean', 2014, 43, 12, 'repackage', '../media/albume/4.slaspecial/slaspecial2.jpeg', '../media/albume/4.slaspecial/grup.jpg', '../media/albume/4.slaspecial/slaspecial3.png', 'https://open.spotify.com/album/74mP0wS6SgwNWipY1nKUB9', 'https://www.youtube.com/embed/lvCB1SmzLW8', 'https://music.apple.com/us/album/skool-luv-affair-special-edition/1275387922'),
(5, 5, 'japonez', 2014, 11, 3, 'japonez', '../media/albume/5.nmd_jp/jpn_nomoredream2.jpg', NULL, '../media/albume/5.nmd_jp/jpn_nomoredream3.png', '', '', ''),
(11, 6, 'japonez', 2014, 11, 3, 'japonez', '../media/albume/6.bil_jp/jpn_boyinluv2.jpg', NULL, '../media/albume/6.bil_jp/jpn_boyinluv3.png', 'https://open.spotify.com/album/6l0cl7IM7uuoNtdl9emYbw', '', 'https://music.apple.com/us/album/boy-in-luv-japanese-ver-single/896924982'),
(12, 7, 'coreean', 2014, 51, 14, 'complet', '../media/albume/7.darknwild/darkandwild2.jpg', '../media/albume/7.darknwild/grup.jpg', '../media/albume/7.darknwild/darkandwild3.png', 'https://open.spotify.com/album/7FxxU3EP37uMsZf8FilkDR', 'https://www.youtube.com/embed/bagj78IQ3l0', 'https://music.apple.com/us/album/dark-wild/1275387961'),
(13, 8, 'japonez', 2014, 12, 3, 'japonez', '../media/albume/8.danger_jp/jpn_danger2.jpg', NULL, '../media/albume/8.danger_jp/jpn_danger3.png', '', '', ''),
(14, 9, 'japonez', 2014, 49, 13, 'japonez', '../media/albume/8.danger_jp/jpn_danger2.jpg', NULL, '../media/albume/8.danger_jp/jpn_danger3.png', '', '', ''),
(15, 10, 'coreean', 2015, 31, 9, 'mini', '../media/albume/10.hyyh1/hyyh1_fiz.jpg', NULL, '../products/albume/album10/hyyh1_track.png', 'https://open.spotify.com/album/0Gv6nwfgk6Cy62j0GGITQc', 'https://www.youtube.com/embed/jjskoRh8GTE', 'https://music.apple.com/us/album/the-most-beautiful-moment-in-life-pt-1/1275387553'),
(16, 15, 'japonez', 2015, 13, 3, 'single', '../media/albume/11.foryou_jp/jpn_foryou2.jpg', NULL, '../media/albume/11.foryou_jp/jpn_foryou3.png', '', '', ''),
(17, 16, 'coreean', 2015, 34, 9, 'mini', '../media/albume/12.hyyh2/hyyhpt22.jpg', NULL, '../media/albume/12.hyyh2/hyyhpt23.png', 'https://open.spotify.com/album/4frjaGAtuBmm8CPuYPY4oG', 'https://www.youtube.com/embed/5Wn85Ge22FQ', 'https://music.apple.com/us/album/the-most-beautiful-moment-in-life-pt-2/1275387733'),
(18, 38, 'japonez', 2015, 11, 3, 'single', '../media/Albume/13.ineedu_jp/jpn_ineedyou2.jpg', NULL, '../media/Albume/13.ineedu_jp/jpn_ineedyou3.png', 'https://open.spotify.com/album/71mivOtJblgvlGqvAPRJyw', 'https://www.youtube.com/embed/LYAcYSmaLoc', 'https://music.apple.com/us/album/i-need-u-japanese-ver-%E9%80%9A%E5%B8%B8%E7%9B%A4-single/1062227026'),
(19, 39, 'japonez', 2016, 12, 3, 'single', '../media/Albume/14.run_jp/jpn_run2.jpg', NULL, '../media/Albume/14.run_jp/jpn_run3.png', 'https://open.spotify.com/album/1Za3UxQMhgKeO8QNsVwzRt', 'https://www.youtube.com/embed/a16gTN7kOWU', ' https://music.apple.com/us/album/run-japanese-ver-%E9%80%9A%E5%B8%B8%E7%9B%A4-single/1089866206'),
(20, 40, 'coreean', 2016, 88, 23, 'repackage', '../media/Albume/15.youngforever/youngforever2.jpg', NULL, '../media/Albume/15.youngforever/youngforever3.png', 'https://open.spotify.com/album/7qvA0kf1dkmR1As2gOnBPn', 'https://www.youtube.com/embed/4ujQOR2DMFM', ''),
(21, 41, 'japonez', 2016, 49, 13, 'complet', '../media/Albume/16.youth_jp/jpn_youth2.jpg', NULL, '../media/Albume/16.youth_jp/jpn_youth3.png', ' https://open.spotify.com/album/0nCEuT8Se5895fcucSx2n3', 'https://www.youtube.com/embed/d9lFInrYcHg', 'https://music.apple.com/us/album/youth/1147102999'),
(24, 44, 'coreean', 2016, 53, 15, 'complet', '../media/Albume/17.wings/wings2.jpg', NULL, '../media/Albume/17.wings/wings3.png', 'https://open.spotify.com/album/17FnTn4P3Bkyf6mbNQDhhy', 'https://www.youtube.com/embed/hmE9f-TEutc', 'https://music.apple.com/us/album/wings/1275387598'),
(25, 45, 'coreean', 2017, 66, 18, 'repackage', '../media/Albume/18.ynwa/ynwa2.jpg', '', '../media/Albume/18.ynwa/ynwa3.png', 'https://open.spotify.com/album/7LF4N7lvyDhrPBuCJ1rplJ', 'https://www.youtube.com/embed/xEeFrLSkMm8', 'https://music.apple.com/us/album/you-never-walk-alone/1274676784'),
(26, 46, 'japonez', 2017, 7, 3, 'single', '../media/Albume/19.bst_jp/jpn_bst2.jpg', '', '../media/Albume/19.bst_jp/jpn_bst3.png', '', 'https://www.youtube.com/embed/7OX7dIRReSA', 'https://music.apple.com/us/album/blood-sweat-tears-single/1445297310'),
(27, 47, 'coreean', 2017, 30, 9, 'mini', '../media/Albume/20.her/her2.png', NULL, '../media/Albume/20.her/her3.png', 'https://open.spotify.com/album/2FTS6a6DLXMNp8flyA0HGO', 'https://www.youtube.com/embed/MBdVXkSdhwU', ' https://music.apple.com/ca/album/love-yourself-%E6%89%BF-her/1284477237'),
(31, 51, 'japonez', 2017, 13, 3, 'single', '../media/Albume/21.micdrop_jp/jpn_micdrop2.gif', NULL, '../media/Albume/21.micdrop_jp/jpn_micdrop.png', ' https://open.spotify.com/album/03yfkUHGv0rY49Wz9mzloe', '', 'https://music.apple.com/us/album/mic-drop-dna-crystal-snow-single/1445162410'),
(32, 52, 'japonez', 2018, 44, 12, 'complet', '../media/Albume/22.foryou_jp/jpn_faceyourself2.jpeg', NULL, '../media/Albume/22.foryou_jp/jpn_faceyourself3.png', 'https://open.spotify.com/album/66J1OXSaS3hBZASOV3el8t', '', 'https://music.apple.com/us/album/face-yourself/1361622149'),
(33, 53, 'coreean', 2018, 43, 11, 'complet', '../media/Albume/23.tear/tear2.png', NULL, '../media/Albume/23.tear/tear3.png', ' https://open.spotify.com/album/2jJfnAZE6IG3oYnUv2eCj4', 'https://www.youtube.com/embed/7C2z4GqqS5E', ' https://music.apple.com/us/album/love-yourself-%E8%BD%89-tear/1384386163'),
(34, 54, 'coreean', 2018, 104, 26, 'repackage', '../media/Albume/24.answer/answer2.png', NULL, '../media/Albume/24.answer/answer3.png', 'https://open.spotify.com/album/2lATw9ZAVp7ILQcOKPCPqp', 'https://www.youtube.com/embed/pBuZEGYXA6E', 'https://music.apple.com/us/album/love-yourself-%E7%B5%90-answer/1430129013'),
(35, 55, 'japonez', 2018, 11, 3, 'single', 'media/Albume/25.fl_jp/jpn_fakelove2.jpg', '', 'media/Albume/25.fl_jp/jpn_fakelove3.png', '', '', ''),
(36, 56, 'coreean', 2019, 26, 7, 'mini', '../media/Albume/26.persona/motspersona2.png', NULL, '../media/Albume/26.persona/motspersona3.png', 'https://open.spotify.com/album/1AvXa8xFEXtR3hb4bgihIK', 'https://www.youtube.com/embed/XsX3ATc3FbA', ' https://music.apple.com/us/album/map-of-the-soul-persona/1458938366'),
(37, 57, 'coreean', 2019, 50, 14, 'soundtrack', '../media/Albume/27.btsworld/btsworld2.jpg', '../media/Albume/27.btsworld/grup.jpg', '../media/Albume/27.btsworld/btsworld3.jpg', 'https://open.spotify.com/album/3LgNJmZ4QPkSvdt9JB8Tb8', 'https://www.youtube.com/embed/aKSxbt-O6TA', 'https://music.apple.com/us/album/bts-world-original-soundtrack/1469569320'),
(38, 58, 'japonez', 2019, 12, 3, 'single', '../media/Albume/28.lights/jpn_lights2.jpg', NULL, '../media/Albume/28.lights/jpn_lights3.png', 'https://open.spotify.com/album/0rHMQLHyw0Bt17fRTJEqh6', 'https://www.youtube.com/embed/eaUpme4jalE', 'https://music.apple.com/us/album/lights-boy-with-luv-single/1469320477'),
(39, 59, 'coreean', 2020, 74, 20, 'complet', '../media/Albume/29.mots7/mots72.jpg', NULL, '../media/Albume/29.mots7/mots73.png', 'https://open.spotify.com/album/6mJZTV8lCqnwftYZa94bXS', 'https://www.youtube.com/embed/mPVDGOVjRQ0', ' https://music.apple.com/us/album/map-of-the-soul-7/1499290546'),
(40, 60, 'japonez', 2020, 46, 13, 'complet', '../media/Albume/30.mots_jp/jpn_motsjourney2.png', '', '../media/Albume/30.mots_jp/jpn_motsjourney3.png', 'https://open.spotify.com/album/1nScVw87kRJiT2bg2Kswhp', 'https://www.youtube.com/embed/9IHwqdz8Xhw', 'https://music.apple.com/us/album/map-of-the-soul-7-the-journey/1517969553'),
(41, 61, 'coreean', 2020, 28, 8, 'mini', '../media/Albume/31.BE/fizic.jpeg', '../media/Albume/31.BE/be.jpg', '../media/Albume/31.BE/tracklist.png', 'https://open.spotify.com/album/2qehskW9lYGWfYb0xPZkrS', 'https://www.youtube.com/embed/-5q5mZbe3V8', 'https://music.apple.com/us/album/be/1540647749');

-- --------------------------------------------------------

--
-- Table structure for table `sectionare_stadion`
--

DROP TABLE IF EXISTS `sectionare_stadion`;
CREATE TABLE IF NOT EXISTS `sectionare_stadion` (
  `id_sectiune` int(11) NOT NULL AUTO_INCREMENT,
  `id_stadion` int(11) NOT NULL,
  `zona` varchar(30) NOT NULL,
  `cod_alfa` char(4) NOT NULL,
  `cod_num` int(11) NOT NULL,
  `orientare` char(2) NOT NULL,
  `randuri` int(11) DEFAULT NULL,
  `coloane` int(11) DEFAULT NULL,
  `locuri` int(11) NOT NULL,
  PRIMARY KEY (`id_sectiune`),
  KEY `id_stadion` (`id_stadion`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sectionare_stadion`
--

INSERT INTO `sectionare_stadion` (`id_sectiune`, `id_stadion`, `zona`, `cod_alfa`, `cod_num`, `orientare`, `randuri`, `coloane`, `locuri`) VALUES
(1, 1, 'tribuna', 'A1', 1, 'N', 6, 32, 192),
(2, 1, 'tribuna', 'A2', 1, 'N', 6, 32, 192),
(3, 1, 'tribuna', 'B', 1, 'N', 6, 32, 192),
(4, 1, 'tribuna', 'C', 1, 'N', 6, 32, 192),
(5, 1, 'tribuna', 'D', 1, 'N', 6, 32, 192),
(6, 1, 'tribuna', 'E', 1, 'N', 6, 32, 192),
(7, 1, 'tribuna', 'F', 1, 'N', 6, 32, 192),
(8, 1, 'tribuna', 'A1', 2, 'N', 40, 16, 640),
(9, 1, 'tribuna', 'A2', 2, 'N', 40, 16, 640),
(10, 1, 'tribuna', 'B', 2, 'N', 40, 16, 640),
(11, 1, 'tribuna', 'C', 2, 'N', 40, 16, 640),
(12, 1, 'tribuna', 'D', 2, 'N', 40, 16, 640),
(13, 1, 'tribuna', 'E', 2, 'N', 40, 16, 640),
(14, 1, 'tribuna', 'F', 2, 'N', 40, 16, 640),
(15, 1, 'tribuna', 'S', 1, 'S', 6, 32, 192),
(16, 1, 'tribuna', 'R', 1, 'S', 6, 32, 192),
(17, 1, 'tribuna', 'P', 1, 'S', 6, 32, 192),
(18, 1, 'tribuna', 'O', 1, 'S', 6, 32, 192),
(19, 1, 'tribuna', 'N', 1, 'S', 6, 32, 192),
(20, 1, 'tribuna', 'M2', 1, 'S', 6, 32, 192),
(21, 1, 'tribuna', 'M1', 1, 'S', 6, 32, 192),
(22, 1, 'tribuna', 'S', 2, 'S', 40, 16, 640),
(23, 1, 'tribuna', 'R', 2, 'S', 40, 16, 640),
(24, 1, 'tribuna', 'P', 2, 'S', 40, 16, 640),
(25, 1, 'tribuna', 'O', 2, 'S', 40, 16, 640),
(26, 1, 'tribuna', 'N', 2, 'S', 40, 16, 640),
(27, 1, 'tribuna', 'M2', 2, 'S', 40, 16, 640),
(28, 1, 'tribuna', 'M1', 2, 'S', 40, 16, 640),
(29, 1, 'peluza', 'Y', 1, 'NV', 6, 32, 192),
(30, 1, 'peluza', 'X', 1, 'NV', 6, 32, 192),
(31, 1, 'peluza', 'W', 1, 'V', 6, 32, 192),
(32, 1, 'peluza', 'V2', 1, 'V', 6, 32, 192),
(33, 1, 'peluza', 'V1', 1, 'V', 6, 32, 192),
(34, 1, 'peluza', 'U2', 1, 'V', 6, 32, 192),
(35, 1, 'peluza', 'U1', 1, 'V', 6, 32, 192),
(36, 1, 'peluza', 'T2', 1, 'V', 6, 32, 192),
(37, 1, 'peluza', 'T1', 1, 'V', 6, 32, 192),
(38, 1, 'peluza', 'Y', 2, 'NV', 40, 16, 640),
(39, 1, 'peluza', 'X', 2, 'NV', 40, 16, 640),
(40, 1, 'peluza', 'W', 2, 'V', 25, 32, 800),
(41, 1, 'peluza', 'V2', 2, 'V', 25, 32, 800),
(42, 1, 'peluza', 'V1', 2, 'V', 25, 32, 800),
(43, 1, 'peluza', 'U2', 2, 'V', 25, 32, 800),
(44, 1, 'peluza', 'U1', 2, 'V', 25, 32, 800),
(45, 1, 'peluza', 'T2', 2, 'V', 25, 32, 800),
(46, 1, 'peluza', 'T1', 2, 'V', 25, 32, 800),
(47, 1, 'peluza', 'G1', 1, 'E', 6, 32, 192),
(48, 1, 'peluza', 'G2', 1, 'E', 6, 32, 192),
(49, 1, 'peluza', 'H1', 1, 'E', 6, 32, 192),
(50, 1, 'peluza', 'H2', 1, 'E', 6, 32, 192),
(51, 1, 'peluza', 'I1', 1, 'E', 6, 32, 192),
(52, 1, 'peluza', 'I2', 1, 'E', 6, 32, 192),
(53, 1, 'peluza', 'J', 1, 'E', 6, 32, 192),
(54, 1, 'peluza', 'K', 1, 'SE', 6, 32, 192),
(55, 1, 'peluza', 'L', 1, 'SE', 6, 32, 192),
(56, 1, 'peluza', 'G1', 2, 'E', 25, 32, 800),
(57, 1, 'peluza', 'G2', 2, 'E', 25, 32, 800),
(58, 1, 'peluza', 'H1', 2, 'E', 25, 32, 800),
(59, 1, 'peluza', 'H2', 2, 'E', 25, 32, 800),
(60, 1, 'peluza', 'I1', 2, 'E', 25, 32, 800),
(61, 1, 'peluza', 'I2', 2, 'E', 25, 32, 800),
(62, 1, 'peluza', 'J', 2, 'E', 25, 32, 800),
(63, 1, 'peluza', 'K', 2, 'SE', 40, 16, 640),
(64, 1, 'peluza', 'L', 2, 'SE', 40, 16, 640),
(65, 1, 'etaj-VIP', 'VIP', 0, 'N', 2, 10, 20),
(66, 1, 'gazon', 'GA', -1, 'C', NULL, NULL, 500),
(67, 1, 'gazon-VIP', 'GVIP', -2, 'C', 10, 5, 50),
(68, 18, 'tribuna', 'A1', 2, 'N', 10, 10, 100),
(69, 18, 'tribuna', 'A1', 1, 'N', 5, 10, 50),
(72, 18, 'etaj-VIP', 'VIP', 0, 'N', 3, 10, 30),
(75, 18, 'peluza', 'C1', 1, 'V', 5, 16, 80),
(90, 18, 'gazon', 'GA', -1, 'C', 0, 0, 200),
(95, 18, 'peluza', 'C1', 2, 'V', 10, 16, 160),
(96, 18, 'tribuna', 'A2', 2, 'N', 10, 10, 100),
(97, 18, 'tribuna', 'A3', 2, 'N', 10, 10, 100),
(98, 18, 'tribuna', 'A2', 1, 'N', 5, 10, 50),
(99, 18, 'tribuna', 'A3', 1, 'N', 5, 10, 50),
(100, 18, 'peluza', 'P', 2, 'NV', 10, 10, 100),
(101, 18, 'peluza', 'Q', 2, 'NV', 10, 10, 100),
(102, 18, 'peluza', 'P', 1, 'NV', 5, 10, 50),
(103, 18, 'peluza', 'Q', 1, 'NV', 5, 10, 50),
(104, 18, 'tribuna', 'B1', 1, 'S', 5, 10, 50),
(105, 18, 'tribuna', 'B1', 2, 'S', 10, 10, 100),
(106, 18, 'tribuna', 'B2', 2, 'S', 10, 10, 100),
(107, 18, 'tribuna', 'B3', 2, 'S', 10, 10, 100),
(108, 18, 'tribuna', 'B2', 1, 'S', 5, 10, 50),
(109, 18, 'tribuna', 'B3', 1, 'S', 5, 10, 50),
(110, 18, 'peluza', 'R', 2, 'SE', 10, 10, 100),
(111, 18, 'peluza', 'S', 2, 'SE', 10, 10, 100),
(112, 18, 'peluza', 'R', 1, 'SE', 5, 10, 50),
(113, 18, 'peluza', 'S', 1, 'SE', 5, 10, 50),
(114, 18, 'peluza', 'C2', 2, 'V', 10, 16, 160),
(115, 18, 'peluza', 'C3', 2, 'V', 10, 16, 160),
(116, 18, 'peluza', 'C2', 1, 'V', 5, 16, 80),
(117, 18, 'peluza', 'C3', 1, 'V', 5, 16, 80),
(118, 18, 'tribuna', 'A4', 2, 'N', 10, 10, 100),
(119, 18, 'tribuna', 'A4', 1, 'N', 5, 10, 50),
(120, 18, 'tribuna', 'B4', 2, 'S', 10, 10, 100),
(121, 18, 'tribuna', 'B4', 1, 'S', 5, 10, 50),
(123, 18, 'peluza', 'C4', 2, 'V', 10, 16, 160),
(124, 18, 'peluza', 'C5', 2, 'V', 10, 16, 160),
(125, 18, 'peluza', 'C4', 1, 'V', 5, 10, 50),
(126, 18, 'peluza', 'C5', 1, 'V', 5, 16, 80);

-- --------------------------------------------------------

--
-- Table structure for table `stadioane`
--

DROP TABLE IF EXISTS `stadioane`;
CREATE TABLE IF NOT EXISTS `stadioane` (
  `id_stadion` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(100) NOT NULL,
  `oras` varchar(100) NOT NULL,
  PRIMARY KEY (`id_stadion`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stadioane`
--

INSERT INTO `stadioane` (`id_stadion`, `denumire`, `oras`) VALUES
(1, 'Cluj Arena', 'Cluj-Napoca'),
(18, 'Gruia', 'Cluj-Napoca');

-- --------------------------------------------------------

--
-- Table structure for table `tarife_concerte`
--

DROP TABLE IF EXISTS `tarife_concerte`;
CREATE TABLE IF NOT EXISTS `tarife_concerte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_concert` int(11) NOT NULL,
  `id_sectiune` int(11) NOT NULL,
  `pret` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_concert` (`id_concert`),
  KEY `id_sectiune` (`id_sectiune`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tarife_concerte`
--

INSERT INTO `tarife_concerte` (`id`, `id_concert`, `id_sectiune`, `pret`) VALUES
(1, 1, 1, '300.00'),
(2, 1, 39, '120.00'),
(4, 1, 38, '120.00'),
(5, 1, 8, '250.00'),
(6, 1, 1, '300.00'),
(7, 1, 8, '250.00'),
(8, 1, 9, '250.00'),
(9, 1, 10, '250.00'),
(10, 1, 11, '250.00'),
(11, 1, 12, '250.00'),
(12, 1, 13, '250.00'),
(13, 1, 14, '250.00'),
(14, 1, 2, '300.00'),
(15, 1, 3, '300.00'),
(16, 1, 4, '300.00'),
(17, 1, 5, '300.00'),
(18, 1, 6, '300.00'),
(19, 1, 7, '300.00'),
(20, 1, 40, '150.00'),
(21, 1, 31, '120.00'),
(22, 1, 41, '150.00'),
(23, 1, 42, '150.00'),
(24, 1, 43, '150.00'),
(25, 1, 44, '150.00'),
(26, 1, 45, '150.00'),
(27, 1, 46, '150.00'),
(28, 1, 32, '120.00'),
(29, 1, 33, '120.00'),
(30, 1, 34, '120.00'),
(31, 1, 35, '120.00'),
(32, 1, 36, '120.00'),
(33, 1, 37, '120.00'),
(34, 1, 65, '350.00'),
(35, 1, 66, '50.00'),
(36, 1, 30, '120.00'),
(37, 1, 29, '120.00'),
(38, 1, 67, '400.00'),
(39, 1, 15, '300.00'),
(40, 1, 16, '300.00'),
(41, 1, 17, '300.00'),
(42, 1, 18, '300.00'),
(43, 1, 19, '300.00'),
(44, 1, 20, '300.00'),
(45, 1, 21, '300.00'),
(46, 1, 22, '250.00'),
(47, 1, 23, '250.00'),
(48, 1, 24, '250.00'),
(49, 1, 25, '250.00'),
(50, 1, 26, '250.00'),
(51, 1, 27, '250.00'),
(52, 1, 28, '250.00'),
(53, 1, 63, '120.00'),
(54, 1, 64, '120.00'),
(55, 1, 54, '120.00'),
(56, 1, 55, '120.00'),
(59, 13, 65, '300.00'),
(60, 13, 38, '120.00'),
(61, 13, 29, '100.00'),
(66, 15, 38, '150.00'),
(67, 15, 29, '100.00'),
(68, 15, 39, '150.00'),
(69, 15, 30, '100.00'),
(70, 15, 8, '180.00'),
(71, 15, 9, '180.00'),
(72, 15, 10, '180.00'),
(73, 15, 11, '180.00'),
(74, 15, 12, '180.00'),
(75, 15, 13, '180.00'),
(76, 15, 14, '180.00'),
(77, 15, 1, '120.00'),
(78, 15, 2, '120.00'),
(79, 15, 3, '120.00'),
(80, 15, 4, '120.00'),
(81, 15, 5, '120.00'),
(82, 15, 6, '120.00'),
(83, 15, 7, '120.00'),
(84, 15, 40, '100.00'),
(85, 15, 41, '100.00'),
(86, 15, 42, '100.00'),
(87, 15, 43, '100.00'),
(88, 15, 44, '100.00'),
(89, 15, 45, '100.00'),
(90, 15, 46, '100.00'),
(91, 15, 31, '80.00'),
(92, 15, 32, '80.00'),
(93, 15, 33, '80.00'),
(94, 15, 34, '80.00'),
(95, 15, 35, '80.00'),
(96, 15, 36, '80.00'),
(97, 15, 37, '80.00'),
(98, 15, 65, '400.00'),
(99, 16, 72, '300.00'),
(100, 16, 100, '150.00'),
(101, 16, 101, '150.00'),
(102, 16, 68, '170.00'),
(103, 16, 96, '170.00'),
(104, 16, 97, '170.00'),
(105, 16, 118, '170.00'),
(106, 16, 105, '170.00'),
(107, 16, 106, '170.00'),
(108, 16, 107, '170.00'),
(109, 16, 120, '170.00'),
(110, 16, 110, '150.00'),
(111, 16, 111, '150.00'),
(112, 16, 95, '100.00'),
(113, 16, 114, '100.00'),
(114, 16, 115, '100.00'),
(115, 16, 123, '100.00'),
(116, 16, 124, '100.00'),
(117, 16, 75, '50.00'),
(118, 16, 116, '50.00'),
(119, 16, 117, '50.00'),
(120, 16, 125, '50.00'),
(121, 16, 126, '50.00'),
(122, 16, 102, '50.00'),
(123, 16, 103, '60.00'),
(124, 16, 112, '50.00'),
(125, 16, 113, '60.00'),
(126, 16, 90, '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

DROP TABLE IF EXISTS `utilizatori`;
CREATE TABLE IF NOT EXISTS `utilizatori` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `prenume` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parola` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `data_inreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id_user`, `nume`, `prenume`, `email`, `parola`, `data_inreg`) VALUES
(1, 'Bodis', 'Bianca', 'bianca@gmail.com', '$2y$10$dsZXKY9AmgqS7YBKLTR42.xSASUY55EuJ39ADBghwNioGppMj8NeK', '2021-06-11 23:11:19'),
(10, 'Ana', 'Maria', 'anamaria@gmail.com', '$2y$10$igxrSqRKEZX.5tM/KlzX.OoCD6taB/fM8ih3AJh2ufD7Q40bP34Ge', '2021-06-13 14:54:01'),
(14, 'nume', 'prenume', 'email@email.com', '$2y$10$9vPJt0aUooTAQEXNXl9l0OXH0UUALSRPmnGyflxUhZs7N/7lPVjFW', '2021-06-19 00:08:34'),
(15, 'Coste', 'Cristina', 'cristina.coste@yahoo.com', '$2y$10$7SnrYwdQmL.jMSAN1qAdXeTmLLNx1yOW.cdmSNgwoGZZ0Ko84cMyK', '2021-06-26 16:26:26'),
(16, 'Dumitrescu', 'Diana', 'diana.dia@gmail.com', '$2y$10$x3G7hErW462YuQWNd5GNveqBp84zEWc7lEzOia6FQ8OiHWk.BpNXC', '2021-06-26 16:30:53'),
(17, 'Enescu', 'Eleonora', 'eleonora22@yahoo.com', '$2y$10$3obQKb4GH13borYI5DNtS./StyeFS6iT/vg5075TdXizsqAm1ySHK', '2021-06-26 20:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `ver_albume`
--

DROP TABLE IF EXISTS `ver_albume`;
CREATE TABLE IF NOT EXISTS `ver_albume` (
  `id_ver` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL,
  `versiune` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `poza_ver` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cantitate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ver`),
  KEY `ver_albume_ibfk_1` (`id_album`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ver_albume`
--

INSERT INTO `ver_albume` (`id_ver`, `id_album`, `versiune`, `poza_ver`, `cantitate`) VALUES
(1, 10, 'White', '../media/albume/10.hyyh1/white.jpg', 10),
(2, 10, 'Pink', '../media/albume/10.hyyh1/pink.jpg', 10),
(3, 16, 'Blue', '../media/albume/12.hyyh2/blue.jpg', 10),
(4, 16, 'Peach', '../media/albume/12.hyyh2/peach.jpg', 10),
(13, 40, 'Day', '../media/Albume/15.youngforever/day.jpg', NULL),
(14, 40, 'Night', '../media/Albume/15.youngforever/night.jpg', NULL),
(15, 44, 'W', '../media/Albume/17.wings/W.jpg', NULL),
(16, 44, 'I', '../media/Albume/17.wings/I.jpg', NULL),
(17, 44, 'N', '../media/Albume/17.wings/N.jpg', NULL),
(18, 44, 'G', '../media/Albume/17.wings/G.jpg', NULL),
(19, 45, 'LEFT', '../media/Albume/18.ynwa/LEFT.jpg', NULL),
(20, 45, 'RIGHT', '../media/Albume/18.ynwa/RIGHT.jpg', NULL),
(21, 47, 'L', '../media/Albume/20.her/L.jpg', NULL),
(22, 47, 'O', '../media/Albume/20.her/O.jpg', NULL),
(23, 47, 'V', '../media/Albume/20.her/V.jpg', NULL),
(24, 47, 'E', '../media/Albume/20.her/E.jpg', NULL),
(27, 53, 'Y', '../media/Albume/23.tear/Y.jpg', NULL),
(28, 53, 'O', '../media/Albume/23.tear/O.jpg', NULL),
(29, 53, 'U', '../media/Albume/23.tear/U.jpg', NULL),
(30, 53, 'R', '../media/Albume/23.tear/R.jpg', NULL),
(31, 54, 'S', '../media/Albume/24.answer/S.jpg', NULL),
(32, 54, 'E', '../media/Albume/24.answer/E.jpg', NULL),
(33, 54, 'L', '../media/Albume/24.answer/L.jpg', NULL),
(34, 54, 'F', '../media/Albume/24.answer/F.jpg', NULL),
(35, 56, '1', '../media/Albume/26.persona/1.jpg', NULL),
(36, 56, '2', '../media/Albume/26.persona/2.jpg', NULL),
(37, 56, '3', '../media/Albume/26.persona/3.jpg', NULL),
(38, 56, '4', '../media/Albume/26.persona/4.jpg', NULL),
(39, 59, '1', '../media/Albume/29.mots7/1.jpg', NULL),
(40, 59, '2', '../media/Albume/29.mots7/2.jpg', NULL),
(41, 59, '3', '../media/Albume/29.mots7/3.jpg', NULL),
(42, 59, '4', '../media/Albume/29.mots7/4.jpg', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comenzi`
--
ALTER TABLE `comenzi`
  ADD CONSTRAINT `comenzi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilizatori` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comenzi_bilete`
--
ALTER TABLE `comenzi_bilete`
  ADD CONSTRAINT `comenzi_bilete_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilizatori` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comenzi_bilete_ibfk_2` FOREIGN KEY (`id_concert`) REFERENCES `concerte` (`id_concert`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comenzi_bilete_ibfk_3` FOREIGN KEY (`id_sectiune`) REFERENCES `sectionare_stadion` (`id_sectiune`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comenzi_produse`
--
ALTER TABLE `comenzi_produse`
  ADD CONSTRAINT `comenzi_produse_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `produse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comenzi_produse_ibfk_3` FOREIGN KEY (`id_ver`) REFERENCES `ver_albume` (`id_ver`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comenzi_produse_ibfk_4` FOREIGN KEY (`id_comanda`) REFERENCES `comenzi` (`id_comanda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `concerte`
--
ALTER TABLE `concerte`
  ADD CONSTRAINT `concerte_ibfk_1` FOREIGN KEY (`id_stadion`) REFERENCES `stadioane` (`id_stadion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cos_bilete`
--
ALTER TABLE `cos_bilete`
  ADD CONSTRAINT `cos_bilete_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilizatori` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cos_bilete_ibfk_2` FOREIGN KEY (`id_concert`) REFERENCES `concerte` (`id_concert`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cos_bilete_ibfk_3` FOREIGN KEY (`id_sectiune`) REFERENCES `sectionare_stadion` (`id_sectiune`) ON UPDATE CASCADE;

--
-- Constraints for table `cos_client`
--
ALTER TABLE `cos_client`
  ADD CONSTRAINT `cos_client_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilizatori` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cos_client_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `produse` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cos_client_ibfk_3` FOREIGN KEY (`id_ver`) REFERENCES `ver_albume` (`id_ver`) ON UPDATE CASCADE;

--
-- Constraints for table `imagini_produse`
--
ALTER TABLE `imagini_produse`
  ADD CONSTRAINT `imagini_produse_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `produse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produse`
--
ALTER TABLE `produse`
  ADD CONSTRAINT `produse_ibfk_1` FOREIGN KEY (`categorie`) REFERENCES `categorii_produse` (`categorie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prod_albume`
--
ALTER TABLE `prod_albume`
  ADD CONSTRAINT `prod_albume_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `produse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sectionare_stadion`
--
ALTER TABLE `sectionare_stadion`
  ADD CONSTRAINT `sectionare_stadion_ibfk_1` FOREIGN KEY (`id_stadion`) REFERENCES `stadioane` (`id_stadion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tarife_concerte`
--
ALTER TABLE `tarife_concerte`
  ADD CONSTRAINT `tarife_concerte_ibfk_1` FOREIGN KEY (`id_concert`) REFERENCES `concerte` (`id_concert`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tarife_concerte_ibfk_2` FOREIGN KEY (`id_sectiune`) REFERENCES `sectionare_stadion` (`id_sectiune`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ver_albume`
--
ALTER TABLE `ver_albume`
  ADD CONSTRAINT `ver_albume_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `prod_albume` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
