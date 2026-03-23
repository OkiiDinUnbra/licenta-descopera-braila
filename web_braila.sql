-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 03:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_braila`
--

-- --------------------------------------------------------

--
-- Table structure for table `bilete_achizitionate`
--

CREATE TABLE `bilete_achizitionate` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cod_qr_unic` varchar(100) NOT NULL,
  `data_achizitie` datetime NOT NULL,
  `data_expirare` datetime NOT NULL,
  `status` enum('activ','expirat') DEFAULT 'activ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bilete_achizitionate`
--

INSERT INTO `bilete_achizitionate` (`id`, `user_id`, `cod_qr_unic`, `data_achizitie`, `data_expirare`, `status`) VALUES
(1, 3, 'BR_69A4272014A9D_7587', '2026-03-01 12:46:40', '2026-03-01 13:46:40', 'activ'),
(2, 4, 'BR_69A47898D1098_5757', '2026-03-01 18:34:16', '2026-03-01 19:34:16', 'activ'),
(3, 4, 'BR_69A57E6E88BE7_6329', '2026-03-02 13:11:26', '2026-03-02 14:11:26', 'activ');

-- --------------------------------------------------------

--
-- Table structure for table `evenimente`
--

CREATE TABLE `evenimente` (
  `id` int(11) NOT NULL,
  `titlu` varchar(150) NOT NULL,
  `descriere` text DEFAULT NULL,
  `data_eveniment` date NOT NULL,
  `categorie` enum('cultural','sportiv') NOT NULL,
  `locatie` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evenimente`
--

INSERT INTO `evenimente` (`id`, `titlu`, `descriere`, `data_eveniment`, `categorie`, `locatie`) VALUES
(1, 'Piesă de teatru: Chirița în provincie', 'Teatrul Maria Filotti vă invită la o comedie clasică.', '2026-03-10', 'cultural', 'Teatrul Maria Filotti'),
(2, 'Concert de promenadă', 'Muzică de fanfară în aer liber si voie buna.', '2026-03-15', 'cultural', 'Grădina Mare'),
(5, 'Meci Fotbal: Dacia Unirea Braila-CSM Ramnicul Sarat', 'Ora 11:00 \r\n\r\nBiletul il gasiti la ...', '2026-03-12', 'sportiv', 'Stadionul Municipal Braila');

-- --------------------------------------------------------

--
-- Table structure for table `transport_directii`
--

CREATE TABLE `transport_directii` (
  `id` int(11) NOT NULL,
  `linia_id` int(11) NOT NULL,
  `nume_directie` varchar(150) NOT NULL,
  `sens` enum('dus','intors') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transport_directii`
--

INSERT INTO `transport_directii` (`id`, `linia_id`, `nume_directie`, `sens`) VALUES
(9, 1, 'Dispecerat Vidin -> Hipodrom', 'dus'),
(10, 1, 'Hipodrom -> Dispecerat Vidin', 'intors'),
(11, 2, 'Șos. de Centură -> ANL Brăilița', 'dus'),
(12, 2, 'ANL Brăilița -> Șos. de Centură', 'intors'),
(13, 3, 'Gara CFR -> Șos. de Centură', 'dus'),
(14, 3, 'Șos. de Centură -> Gara CFR', 'intors'),
(15, 4, 'Șos. de Centură -> Soroli Cola', 'dus'),
(16, 4, 'Soroli Cola -> Șos. de Centură', 'intors'),
(17, 5, 'A.N.L. Lacu Dulce -> Școala Nr. 3', 'dus'),
(18, 5, 'Școala Nr. 3 -> A.N.L. Lacu Dulce', 'intors'),
(19, 6, 'Gara CFR -> Șos. de Centură (Zoo)', 'dus'),
(20, 6, 'Șos. de Centură (Zoo) -> Gara CFR', 'intors'),
(21, 7, 'Centru -> Soroli Cola', 'dus'),
(22, 7, 'Soroli Cola -> Centru', 'intors'),
(27, 8, 'Dispecerat Vidin -> Spitalul Județean (Corp B)', 'dus'),
(28, 8, 'Dispecerat Central -> Dispecerat Vidin', 'intors'),
(29, 9, 'Dispecerat Vidin -> Biserica Radu Negru', 'dus'),
(30, 9, 'Biserica Radu Negru -> Dispecerat Vidin', 'intors'),
(35, 10, 'Dispecerat Vidin -> Biserica Radu Negru (via Calea Galați)', 'dus'),
(36, 10, 'Biserica Radu Negru -> Dispecerat Vidin (via Calea Galați)', 'intors'),
(37, 12, 'Dispecerat Vidin -> Gara CFR', 'dus'),
(38, 12, 'Gara CFR -> Dispecerat Vidin', 'intors'),
(39, 13, 'Gara CFR -> Soroli Cola', 'dus'),
(40, 13, 'Soroli Cola -> Gara CFR', 'intors'),
(41, 14, 'Lacu Dulce -> Dispecerat Vidin', 'dus'),
(42, 14, 'Dispecerat Vidin -> Lacu Dulce', 'intors'),
(43, 15, 'Dispecerat Vidin -> Bariera Călărașilor', 'dus'),
(44, 15, 'Bariera Călărașilor -> Dispecerat Vidin', 'intors');

-- --------------------------------------------------------

--
-- Table structure for table `transport_linii`
--

CREATE TABLE `transport_linii` (
  `id` int(11) NOT NULL,
  `numar_linia` varchar(10) NOT NULL,
  `tip_vehicul` enum('autobuz','tramvai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transport_linii`
--

INSERT INTO `transport_linii` (`id`, `numar_linia`, `tip_vehicul`) VALUES
(1, '2', 'autobuz'),
(2, '3', 'autobuz'),
(3, '4', 'autobuz'),
(4, '5', 'autobuz'),
(5, '7', 'autobuz'),
(6, '10', 'autobuz'),
(7, '13', 'autobuz'),
(8, '15', 'autobuz'),
(9, '16', 'autobuz'),
(10, '17', 'autobuz'),
(11, '17', 'autobuz'),
(12, '33', 'autobuz'),
(13, '35', 'autobuz'),
(14, '40', 'autobuz'),
(15, '50', 'autobuz');

-- --------------------------------------------------------

--
-- Table structure for table `transport_rute`
--

CREATE TABLE `transport_rute` (
  `id` int(11) NOT NULL,
  `directie_id` int(11) NOT NULL,
  `statie_id` int(11) NOT NULL,
  `ordine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transport_rute`
--

INSERT INTO `transport_rute` (`id`, `directie_id`, `statie_id`, `ordine`) VALUES
(41, 9, 1, 1),
(42, 9, 2, 2),
(43, 9, 3, 3),
(44, 9, 4, 4),
(45, 9, 5, 5),
(46, 9, 6, 6),
(47, 9, 7, 7),
(48, 9, 8, 8),
(49, 9, 9, 9),
(50, 9, 10, 10),
(51, 9, 11, 11),
(52, 9, 12, 12),
(53, 9, 13, 13),
(54, 9, 14, 14),
(55, 9, 15, 15),
(56, 9, 16, 16),
(57, 9, 17, 17),
(58, 9, 18, 18),
(59, 10, 18, 1),
(60, 10, 17, 2),
(61, 10, 16, 3),
(62, 10, 15, 4),
(63, 10, 27, 5),
(64, 10, 62, 6),
(65, 10, 63, 7),
(66, 10, 64, 8),
(67, 10, 65, 9),
(68, 10, 33, 10),
(69, 10, 7, 11),
(70, 10, 6, 12),
(71, 10, 5, 13),
(72, 10, 4, 14),
(73, 10, 2, 15),
(74, 10, 1, 16),
(75, 11, 20, 1),
(76, 11, 21, 2),
(77, 11, 22, 3),
(78, 11, 23, 4),
(79, 11, 24, 5),
(80, 11, 25, 6),
(81, 11, 26, 7),
(82, 11, 15, 8),
(83, 11, 27, 9),
(84, 11, 28, 10),
(85, 11, 29, 11),
(86, 11, 30, 12),
(87, 11, 31, 13),
(88, 11, 32, 14),
(89, 11, 33, 15),
(90, 11, 110, 16),
(91, 11, 6, 17),
(92, 11, 34, 18),
(93, 11, 35, 19),
(94, 11, 36, 20),
(95, 12, 36, 1),
(96, 12, 35, 2),
(97, 12, 34, 3),
(98, 12, 6, 4),
(99, 12, 110, 5),
(100, 12, 8, 6),
(101, 12, 32, 7),
(102, 12, 31, 8),
(103, 12, 30, 9),
(104, 12, 40, 10),
(105, 12, 111, 11),
(106, 12, 14, 12),
(107, 12, 15, 13),
(108, 12, 26, 14),
(109, 12, 25, 15),
(110, 12, 112, 16),
(111, 12, 23, 17),
(112, 12, 21, 18),
(113, 12, 22, 19),
(114, 12, 20, 20),
(115, 13, 37, 1),
(116, 13, 38, 2),
(117, 13, 39, 3),
(118, 13, 135, 4),
(119, 13, 12, 5),
(120, 13, 136, 6),
(121, 13, 14, 7),
(122, 13, 15, 8),
(123, 13, 26, 9),
(124, 13, 25, 10),
(125, 13, 112, 11),
(126, 13, 23, 12),
(127, 13, 137, 13),
(128, 13, 138, 14),
(129, 13, 20, 15),
(130, 14, 20, 1),
(131, 14, 21, 2),
(132, 14, 138, 3),
(133, 14, 23, 4),
(134, 14, 139, 5),
(135, 14, 25, 6),
(136, 14, 26, 7),
(137, 14, 15, 8),
(138, 14, 27, 9),
(139, 14, 140, 10),
(140, 14, 63, 11),
(141, 14, 64, 12),
(142, 14, 141, 13),
(143, 14, 39, 14),
(144, 14, 38, 15),
(145, 14, 37, 16),
(146, 15, 20, 1),
(147, 15, 21, 2),
(148, 15, 157, 3),
(149, 15, 23, 4),
(150, 15, 24, 5),
(151, 15, 25, 6),
(152, 15, 26, 7),
(153, 15, 15, 8),
(154, 15, 27, 9),
(155, 15, 28, 10),
(156, 15, 40, 11),
(157, 15, 41, 12),
(158, 15, 42, 13),
(159, 15, 43, 14),
(160, 15, 44, 15),
(161, 15, 45, 16),
(162, 15, 46, 17),
(163, 15, 47, 18),
(164, 15, 48, 19),
(165, 15, 49, 20),
(166, 15, 50, 21),
(167, 15, 51, 22),
(168, 15, 52, 23),
(169, 16, 52, 1),
(170, 16, 51, 2),
(171, 16, 50, 3),
(172, 16, 49, 4),
(173, 16, 48, 5),
(174, 16, 47, 6),
(175, 16, 46, 7),
(176, 16, 45, 8),
(177, 16, 44, 9),
(178, 16, 43, 10),
(179, 16, 42, 11),
(180, 16, 41, 12),
(181, 16, 40, 13),
(182, 16, 158, 14),
(183, 16, 14, 15),
(184, 16, 15, 16),
(185, 16, 26, 17),
(186, 16, 25, 18),
(187, 16, 112, 19),
(188, 16, 60, 20),
(189, 16, 21, 21),
(190, 16, 157, 22),
(191, 16, 20, 23),
(192, 17, 19, 1),
(193, 17, 53, 2),
(194, 17, 18, 3),
(195, 17, 184, 4),
(196, 17, 185, 5),
(197, 18, 185, 1),
(198, 18, 184, 2),
(199, 18, 18, 3),
(200, 18, 53, 4),
(201, 18, 19, 5),
(202, 19, 37, 1),
(203, 19, 54, 2),
(204, 19, 39, 3),
(205, 19, 135, 4),
(206, 19, 12, 5),
(207, 19, 136, 6),
(208, 19, 14, 7),
(209, 19, 15, 8),
(210, 19, 55, 9),
(211, 19, 56, 10),
(212, 19, 57, 11),
(213, 19, 58, 12),
(214, 19, 59, 13),
(215, 19, 60, 14),
(216, 19, 61, 15),
(217, 19, 20, 16),
(218, 20, 20, 1),
(219, 20, 61, 2),
(220, 20, 60, 3),
(221, 20, 59, 4),
(222, 20, 58, 5),
(223, 20, 57, 6),
(224, 20, 56, 7),
(225, 20, 189, 8),
(226, 20, 15, 9),
(227, 20, 27, 10),
(228, 20, 140, 11),
(229, 20, 63, 12),
(230, 20, 64, 13),
(231, 20, 141, 14),
(232, 20, 39, 15),
(233, 20, 54, 16),
(234, 20, 37, 17),
(235, 21, 211, 1),
(236, 21, 141, 2),
(237, 21, 10, 3),
(238, 21, 135, 4),
(239, 21, 40, 5),
(240, 21, 41, 6),
(241, 21, 212, 7),
(242, 21, 42, 8),
(243, 21, 213, 9),
(244, 21, 214, 10),
(245, 21, 215, 11),
(246, 21, 216, 12),
(247, 21, 48, 13),
(248, 21, 217, 14),
(249, 21, 50, 15),
(250, 21, 51, 16),
(251, 21, 52, 17),
(252, 22, 52, 1),
(253, 22, 51, 2),
(254, 22, 50, 3),
(255, 22, 217, 4),
(256, 22, 48, 5),
(257, 22, 216, 6),
(258, 22, 215, 7),
(259, 22, 218, 8),
(260, 22, 213, 9),
(261, 22, 42, 10),
(262, 22, 41, 11),
(263, 22, 135, 12),
(264, 22, 211, 13),
(325, 27, 1, 1),
(326, 27, 229, 2),
(327, 27, 230, 3),
(328, 27, 231, 4),
(329, 27, 232, 5),
(330, 27, 233, 6),
(331, 27, 8, 7),
(332, 27, 234, 8),
(333, 27, 37, 9),
(334, 27, 235, 10),
(335, 27, 28, 11),
(336, 27, 236, 12),
(337, 27, 237, 13),
(338, 27, 238, 14),
(339, 27, 239, 15),
(340, 28, 240, 1),
(341, 28, 239, 2),
(342, 28, 238, 3),
(343, 28, 237, 4),
(344, 28, 236, 5),
(345, 28, 28, 6),
(346, 28, 37, 7),
(347, 28, 234, 8),
(348, 28, 241, 9),
(349, 28, 242, 10),
(350, 28, 232, 11),
(351, 28, 231, 12),
(352, 28, 230, 13),
(353, 28, 229, 14),
(354, 28, 1, 15),
(355, 29, 1, 1),
(356, 29, 2, 2),
(357, 29, 3, 3),
(358, 29, 4, 4),
(359, 29, 5, 5),
(360, 29, 6, 6),
(361, 29, 7, 7),
(362, 29, 8, 8),
(363, 29, 9, 9),
(364, 29, 64, 10),
(365, 29, 283, 11),
(366, 29, 284, 12),
(367, 29, 285, 13),
(368, 29, 286, 14),
(369, 29, 58, 15),
(370, 29, 59, 16),
(371, 30, 59, 1),
(372, 30, 58, 2),
(373, 30, 286, 3),
(374, 30, 285, 4),
(375, 30, 284, 5),
(376, 30, 283, 6),
(377, 30, 27, 7),
(378, 30, 140, 8),
(379, 30, 63, 9),
(380, 30, 64, 10),
(381, 30, 65, 11),
(382, 30, 33, 12),
(383, 30, 7, 13),
(384, 30, 6, 14),
(385, 30, 5, 15),
(386, 30, 4, 16),
(387, 30, 1, 17),
(411, 35, 1, 1),
(412, 35, 304, 2),
(413, 35, 305, 3),
(414, 35, 306, 4),
(415, 35, 307, 5),
(416, 35, 308, 6),
(417, 35, 309, 7),
(418, 35, 310, 8),
(419, 35, 311, 9),
(420, 35, 8, 10),
(421, 35, 312, 11),
(422, 35, 9, 12),
(423, 35, 323, 13),
(424, 35, 135, 14),
(425, 35, 12, 15),
(426, 35, 136, 16),
(427, 35, 14, 17),
(428, 35, 15, 18),
(429, 35, 55, 19),
(430, 35, 56, 20),
(431, 35, 57, 21),
(432, 35, 58, 22),
(433, 35, 59, 23),
(434, 36, 59, 1),
(435, 36, 313, 2),
(436, 36, 314, 3),
(437, 36, 25, 4),
(438, 36, 26, 5),
(439, 36, 15, 6),
(440, 36, 27, 7),
(441, 36, 140, 8),
(442, 36, 12, 9),
(443, 36, 135, 10),
(444, 36, 323, 11),
(445, 36, 65, 12),
(446, 36, 33, 13),
(447, 36, 311, 14),
(448, 36, 310, 15),
(449, 36, 309, 16),
(450, 36, 308, 17),
(451, 36, 307, 18),
(452, 36, 306, 19),
(453, 36, 305, 20),
(454, 36, 304, 21),
(455, 36, 1, 22),
(456, 37, 1, 1),
(457, 37, 2, 2),
(458, 37, 354, 3),
(459, 37, 355, 4),
(460, 37, 6, 5),
(461, 37, 356, 6),
(462, 37, 8, 7),
(463, 37, 9, 8),
(464, 37, 283, 9),
(465, 37, 12, 10),
(466, 37, 323, 11),
(467, 37, 54, 12),
(468, 37, 37, 13),
(469, 38, 37, 1),
(470, 38, 54, 2),
(471, 38, 323, 3),
(472, 38, 312, 4),
(473, 38, 7, 5),
(474, 38, 6, 6),
(475, 38, 356, 7),
(476, 38, 8, 8),
(477, 38, 4, 9),
(478, 38, 5, 10),
(479, 38, 3, 11),
(480, 38, 2, 12),
(481, 38, 1, 13),
(482, 39, 37, 1),
(483, 39, 54, 2),
(484, 39, 39, 3),
(485, 39, 135, 4),
(486, 39, 40, 5),
(487, 39, 41, 6),
(488, 39, 42, 7),
(489, 39, 43, 8),
(490, 39, 215, 9),
(491, 39, 216, 10),
(492, 39, 52, 11),
(493, 40, 52, 1),
(494, 40, 51, 2),
(495, 40, 50, 3),
(496, 40, 217, 4),
(497, 40, 48, 5),
(498, 40, 216, 6),
(499, 40, 215, 7),
(500, 40, 43, 8),
(501, 40, 42, 9),
(502, 40, 41, 10),
(503, 40, 37, 11),
(504, 41, 387, 1),
(505, 41, 388, 2),
(506, 41, 57, 3),
(507, 41, 283, 4),
(508, 41, 64, 5),
(509, 41, 9, 6),
(510, 41, 8, 7),
(511, 41, 6, 8),
(512, 41, 355, 9),
(513, 41, 354, 10),
(514, 41, 2, 11),
(515, 41, 1, 12),
(516, 42, 1, 1),
(517, 42, 2, 2),
(518, 42, 354, 3),
(519, 42, 355, 4),
(520, 42, 6, 5),
(521, 42, 8, 6),
(522, 42, 9, 7),
(523, 42, 64, 8),
(524, 42, 283, 9),
(525, 42, 57, 10),
(526, 42, 388, 11),
(527, 42, 387, 12),
(528, 43, 1, 1),
(529, 43, 2, 2),
(530, 43, 354, 3),
(531, 43, 355, 4),
(532, 43, 6, 5),
(533, 43, 356, 6),
(534, 43, 8, 7),
(535, 43, 9, 8),
(536, 43, 312, 9),
(537, 43, 323, 10),
(538, 43, 135, 11),
(539, 43, 40, 12),
(540, 43, 283, 13),
(541, 44, 283, 1),
(542, 44, 40, 2),
(543, 44, 135, 3),
(544, 44, 323, 4),
(545, 44, 312, 5),
(546, 44, 9, 6),
(547, 44, 8, 7),
(548, 44, 356, 8),
(549, 44, 6, 9),
(550, 44, 355, 10),
(551, 44, 354, 11),
(552, 44, 2, 12),
(553, 44, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `transport_statii`
--

CREATE TABLE `transport_statii` (
  `id` int(11) NOT NULL,
  `nume_statie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transport_statii`
--

INSERT INTO `transport_statii` (`id`, `nume_statie`) VALUES
(19, 'A.N.L. LACU DULCE'),
(36, 'ANL BRAILITA'),
(45, 'ARMONIA (cf program)'),
(39, 'B-DUL INDEPENDENTEI'),
(53, 'BARIERA C.F.R.'),
(283, 'BARIERA CALARASILOR'),
(141, 'BISERICA CATOLICA'),
(59, 'BISERICA RADU NEGRU'),
(310, 'BISERICA SF. DUMITRU'),
(9, 'BLOC TURN'),
(111, 'BRAICONF'),
(158, 'BRAINCONF'),
(241, 'CAL. GALATI- STR. PLANTELOR'),
(242, 'CAL. GALATI-STR. M MALAERU'),
(304, 'CALEA GALATI'),
(30, 'CASA CORPULUI DIDACTIC'),
(211, 'CENTRU'),
(189, 'CENTRUL MILITAR'),
(237, 'CIMIT. SF. CONSTANTIN'),
(65, 'CLUBUL PROGRESU'),
(63, 'D.P.M.O.S.'),
(51, 'DEDEMAN'),
(240, 'DISPECERAT CENTRAL'),
(1, 'DISPECERAT VIDIN'),
(284, 'DOROBANTI 1'),
(388, 'DOROBANTI 2'),
(49, 'ELECTRICA'),
(56, 'FABRICA DE COVOARE'),
(48, 'FANARIE'),
(37, 'GARA CFR'),
(61, 'GRADINA ZOO'),
(18, 'HIPODROM'),
(314, 'I.A.S. - I.M.B.'),
(24, 'I.A.S.- I.M.B.'),
(139, 'I.A.S.-I.M.B.'),
(387, 'LACU DULCE'),
(234, 'LIC. ANGHEL SALIGNY'),
(62, 'LIC. GHE. M. MURGOCI'),
(229, 'LIC. PROGRESUL'),
(38, 'LICEUL ANGHEL SALIGNI'),
(54, 'LICEUL ANGHEL SALIGNY'),
(140, 'LICEUL GHE. M. MURGOCI'),
(10, 'LICEUL N. BALCESCU'),
(323, 'LICEUL NICOLAE BALCESCU'),
(2, 'LICEUL PROGRESUL'),
(11, 'MAG. WINMARKT'),
(135, 'MAGAZINUL WINMARKT'),
(50, 'METALURGICA'),
(312, 'MODERN'),
(13, 'PAL. TELEFOANELOR'),
(136, 'PALATUL TELEFOANELOR'),
(311, 'PECO MALAIERU'),
(21, 'PECO MALL'),
(137, 'PECO MOL'),
(44, 'PIATA 2 COCOSI'),
(215, 'PIATA BARAGANULUI'),
(14, 'PIATA CONCORDIA'),
(235, 'PIATA HALELOR-PECO'),
(40, 'PIATA MARE'),
(33, 'PIATA SARACA'),
(64, 'PIATA TRAIAN'),
(355, 'POARTA 1 - PROGRESUL'),
(231, 'POARTA 1 – PROGRESU'),
(354, 'POARTA 2 - PROGRESUL'),
(230, 'POARTA 2 – PROGRESU'),
(217, 'RENEL'),
(16, 'SC. GENERALA NR. 3'),
(313, 'SCOALA NR 1'),
(29, 'SCOALA NR. 10'),
(58, 'SCOALA NR. 2'),
(47, 'SCOALA NR. 24'),
(185, 'SCOALA NR. 3'),
(28, 'SCOALA NR. 8'),
(52, 'SOROLI COLA'),
(20, 'SOS de CENTURA'),
(55, 'SOS. Buzaului LIC. E. Nicolau'),
(286, 'SOS. BUZAULUI-SPITALUL JUDETEAN'),
(46, 'SOS. FOCSANI'),
(41, 'Sos. Rm. Sarat PRAKTIKER'),
(239, 'SPIT. JUD. URGENTA CORP B'),
(184, 'SPIT. SF. SPIRIDON'),
(57, 'SPITALUL JUDETEAN'),
(27, 'SPITALUL NR. 1'),
(17, 'SPITALUL SF. SPIRIDON'),
(3, 'STADIONUL PROGRESUL'),
(35, 'STATIE DUMBRAVA ROSIE'),
(34, 'STATIE MIRCEA CEL MARE'),
(307, 'STR BARSEI'),
(213, 'STR DEVA'),
(31, 'STR. APOLLO'),
(32, 'STR. CARPATI'),
(60, 'STR. CASTANULUI'),
(26, 'STR. CELULOZEI'),
(6, 'STR. CEZAR PETRESCU'),
(232, 'STR. CEZAR PETRESCU (DR.)'),
(23, 'STR. CHISINAU'),
(43, 'STR. DEVA'),
(306, 'STR. EROILOR'),
(15, 'STR. FRANCEZA'),
(216, 'STR. GEORGE COSBUC'),
(25, 'STR. INDUSTRIA SARMEI'),
(233, 'STR. M MALAERU'),
(356, 'STR. M. MALAERU'),
(305, 'STR. MIHAI VITEAZU'),
(112, 'STR. MILCOV'),
(238, 'STR. PIETATII-CUTEZATORILOR'),
(8, 'STR. PLANTELOR'),
(285, 'STR. PLEVNA'),
(12, 'STR. SCOLILOR'),
(236, 'STR. SCOLILOR-B-DUL. DOROB.'),
(308, 'STR. TARGOVISTE'),
(4, 'STR. ULMULUI'),
(5, 'STR. V. CALUGAREASCA'),
(309, 'STR. VALEA CALUGAREASCA'),
(7, 'STR. W. MARACINEANU'),
(110, 'STR. WALTER MARACINEANU'),
(212, 'STR. ZAMBILELOR'),
(218, 'STR.MOLDOVEI ( Str. Lotrului )'),
(214, 'STR.MOLDOVEI ( Str. V. Sarbu)'),
(42, 'TUG CENTER'),
(138, 'YAZAKI (cf prg)'),
(157, 'YAZAKI (cf program)'),
(22, 'YAZAKI(doar cf. program)');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `doreste_newsletter` tinyint(1) DEFAULT 0,
  `data_inregistrare` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume`, `email`, `parola`, `telefon`, `doreste_newsletter`, `data_inregistrare`, `rol`) VALUES
(1, 'Filote Marius-Andrei', 'filotemarius6@gmail.com', '$2y$10$9FTNYX3fiztzdJ/2nY2Gj.BCL4s9VBQqEJAf3rS.DRtG4Wu3fOgY2', '0748297814', 1, '2026-03-01 10:26:49', 'user'),
(3, 'Adminul', 'filotemarius6@braila.com', '$2y$10$nvp2N9nmxCM9D54KUWjrdeRMl.d4WpJRLG/DVtVTED0EZbB4lMlq.', '312312312312', 0, '2026-03-01 10:49:36', 'user'),
(4, 'admin', 'filotemarius6@braila.ro', '$2y$10$B6RKR0vjHVuvZOJM2Ds9q.2QQaOaZDEWIB2nPICgYxJDPOgeEBPzK', '0748297814', 0, '2026-03-01 10:52:28', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bilete_achizitionate`
--
ALTER TABLE `bilete_achizitionate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cod_qr_unic` (`cod_qr_unic`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `evenimente`
--
ALTER TABLE `evenimente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_directii`
--
ALTER TABLE `transport_directii`
  ADD PRIMARY KEY (`id`),
  ADD KEY `linia_id` (`linia_id`);

--
-- Indexes for table `transport_linii`
--
ALTER TABLE `transport_linii`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_rute`
--
ALTER TABLE `transport_rute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `directie_id` (`directie_id`),
  ADD KEY `statie_id` (`statie_id`);

--
-- Indexes for table `transport_statii`
--
ALTER TABLE `transport_statii`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nume_statie` (`nume_statie`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bilete_achizitionate`
--
ALTER TABLE `bilete_achizitionate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evenimente`
--
ALTER TABLE `evenimente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transport_directii`
--
ALTER TABLE `transport_directii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `transport_linii`
--
ALTER TABLE `transport_linii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transport_rute`
--
ALTER TABLE `transport_rute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=554;

--
-- AUTO_INCREMENT for table `transport_statii`
--
ALTER TABLE `transport_statii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bilete_achizitionate`
--
ALTER TABLE `bilete_achizitionate`
  ADD CONSTRAINT `bilete_achizitionate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilizatori` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_directii`
--
ALTER TABLE `transport_directii`
  ADD CONSTRAINT `transport_directii_ibfk_1` FOREIGN KEY (`linia_id`) REFERENCES `transport_linii` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transport_rute`
--
ALTER TABLE `transport_rute`
  ADD CONSTRAINT `transport_rute_ibfk_1` FOREIGN KEY (`directie_id`) REFERENCES `transport_directii` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_rute_ibfk_2` FOREIGN KEY (`statie_id`) REFERENCES `transport_statii` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
