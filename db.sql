-- Adminer 4.8.1 MySQL 5.7.36 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `job` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `wage` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `room` (`room`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`room`) REFERENCES `room` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `employee` (`employee_id`, `name`, `surname`, `job`, `wage`, `room`, `login`, `password`, `admin`) VALUES
(1,	'František',	'Netěsný',	'ředitel',	65000,	1,	NULL,	NULL,	NULL),
(3,	'Alena',	'Netěsná',	'ekonomka',	42000,	5,	NULL,	NULL,	NULL),
(4,	'Jiřina',	'Hamáčková',	'ekonomka',	32000,	5,	NULL,	NULL,	NULL),
(5,	'Stanislav',	'Lorenc',	'skladník',	14000,	8,	NULL,	NULL,	NULL),
(6,	'Martina',	'Marková',	'skladnice',	14500,	8,	NULL,	NULL,	NULL),
(7,	'Tomáš',	'Kalousek',	'technik',	23000,	7,	NULL,	NULL,	NULL),
(8,	'Jindřich',	'Holzer',	'technik',	22000,	7,	NULL,	NULL,	NULL),
(9,	'Alena',	'Krátká',	'technik',	24000,	7,	NULL,	NULL,	NULL),
(10,	'Stanislav',	'Janovič',	'technik',	22000,	7,	NULL,	NULL,	NULL),
(11,	'Milan',	'Steiner',	'mistr',	29000,	7,	NULL,	NULL,	NULL),
(12,	'Lukáš',	'Bien',	'student',	0,	1,	'admin',	'admin',	1),
(13,	'Sebastian',	'Bukai',	'student',	0,	7,	'user',	'user',	0),
(16,	'Jmeno',	'Prijmeni',	'Zamestnani',	20,	15,	NULL,	NULL,	NULL)
ON DUPLICATE KEY UPDATE `employee_id` = VALUES(`employee_id`), `name` = VALUES(`name`), `surname` = VALUES(`surname`), `job` = VALUES(`job`), `wage` = VALUES(`wage`), `room` = VALUES(`room`), `login` = VALUES(`login`), `password` = VALUES(`password`), `admin` = VALUES(`admin`);

DROP TABLE IF EXISTS `key`;
CREATE TABLE `key` (
  `key_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  PRIMARY KEY (`key_id`),
  UNIQUE KEY `employee_room` (`employee`,`room`),
  KEY `room` (`room`),
  CONSTRAINT `key_ibfk_1` FOREIGN KEY (`employee`) REFERENCES `employee` (`employee_id`),
  CONSTRAINT `key_ibfk_2` FOREIGN KEY (`room`) REFERENCES `room` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `key` (`key_id`, `employee`, `room`) VALUES
(1,	1,	1),
(19,	1,	2),
(20,	1,	3),
(21,	1,	4),
(22,	1,	5),
(23,	1,	6),
(16,	1,	7),
(17,	1,	8),
(18,	1,	11),
(46,	3,	1),
(47,	3,	2),
(6,	3,	5),
(35,	3,	6),
(48,	4,	2),
(7,	4,	5),
(36,	4,	6),
(38,	5,	6),
(9,	5,	8),
(50,	5,	11),
(39,	6,	6),
(10,	6,	8),
(51,	6,	11),
(37,	7,	6),
(8,	7,	7),
(52,	7,	11),
(31,	8,	6),
(2,	8,	7),
(53,	8,	11),
(32,	9,	6),
(3,	9,	7),
(54,	9,	11),
(33,	10,	6),
(4,	10,	7),
(55,	10,	11),
(49,	11,	2),
(34,	11,	6),
(5,	11,	7),
(56,	11,	11)
ON DUPLICATE KEY UPDATE `key_id` = VALUES(`key_id`), `employee` = VALUES(`employee`), `room` = VALUES(`room`);

DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(15) COLLATE utf8mb4_czech_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_czech_ci DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `no` (`no`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `room` (`room_id`, `no`, `name`, `phone`) VALUES
(1,	'101',	'Ředitelna',	'2292'),
(2,	'102',	'Kuchyňka',	'2293'),
(3,	'104',	'Zasedací místnost',	'2294'),
(4,	'201',	'Xerox',	'2296'),
(5,	'202',	'Ekonomické',	'2295'),
(6,	'203',	'Toalety',	NULL),
(7,	'001',	'Dílna',	'2241'),
(8,	'002',	'Sklad',	'2243'),
(11,	'003',	'Šatna',	NULL),
(12,	'333',	'TestRoom',	'123 456 789'),
(15,	'334',	'TestRoom2',	'123456789')
ON DUPLICATE KEY UPDATE `room_id` = VALUES(`room_id`), `no` = VALUES(`no`), `name` = VALUES(`name`), `phone` = VALUES(`phone`);

-- 2023-04-01 14:00:11
