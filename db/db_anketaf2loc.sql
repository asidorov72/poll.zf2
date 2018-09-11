-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия на сървъра:            5.7.21 - MySQL Community Server (GPL)
-- ОС на сървъра:                Win64
-- HeidiSQL Версия:              9.5.0.5289
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дъмп структура за таблица db_anketazf2loc.question
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('list','match') DEFAULT 'match',
  `title` mediumtext,
  `question` text NOT NULL,
  `answer` tinytext,
  `prompts` text,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица db_anketazf2loc.question: 7 rows
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` (`id`, `date`, `type`, `title`, `question`, `answer`, `prompts`, `user_id`) VALUES
	(72, '2018-08-29 18:55:24', NULL, 'First name of Vazov', 'What is the first name of the Bulgarian writer Vazov?', 'a:1:{i:0;s:1:"1";}', 'a:3:{i:0;a:1:{s:6:"prompt";s:7:"Patrick";}i:1;a:1:{s:6:"prompt";s:4:"Ivan";}i:2;a:1:{s:6:"prompt";s:7:"Nikolai";}}', 1),
	(73, '2018-08-29 18:53:21', NULL, 'Access modifiers', 'Which the Access modifiers do you know?', 'a:1:{i:0;s:1:"0";}', 'a:3:{i:0;a:1:{s:6:"prompt";s:26:"Private, protected, public";}i:1;a:1:{s:6:"prompt";s:25:"Restricted, common, final";}i:2;a:1:{s:6:"prompt";s:0:"";}}', 1),
	(74, '2018-08-29 18:52:54', NULL, 'Color of the Sun', 'What is a color of the Sun?', 'a:1:{i:0;s:1:"2";}', 'a:3:{i:0;a:1:{s:6:"prompt";s:5:"Green";}i:1;a:1:{s:6:"prompt";s:4:"Blue";}i:2;a:1:{s:6:"prompt";s:6:"Yellow";}}', 1),
	(75, '2018-08-29 22:19:41', NULL, 'Name of the framework', 'What\'s the name of the php framework which was used?', 'a:1:{i:0;s:1:"1";}', 'a:3:{i:0;a:1:{s:6:"prompt";s:7:"Laravel";}i:1;a:1:{s:6:"prompt";s:14:"Zend Framework";}i:2;a:1:{s:6:"prompt";s:8:"Symphony";}}', 1),
	(76, '2018-08-29 22:43:33', NULL, 'Number of the soviet republics', 'What is a number of republics of the Soviet Union?', 'a:1:{i:0;s:1:"1";}', 'a:3:{i:0;a:1:{s:6:"prompt";s:2:"10";}i:1;a:1:{s:6:"prompt";s:2:"15";}i:2;a:1:{s:6:"prompt";s:2:"16";}}', 1),
	(79, '2018-08-30 08:43:05', NULL, 'RGB', 'Which colors does RGB contain?', 'a:1:{i:0;s:1:"1";}', 'a:3:{i:0;a:1:{s:6:"prompt";s:16:"Red, Grey, Brown";}i:1;a:1:{s:6:"prompt";s:16:"Red, Green, Blue";}i:2;a:1:{s:6:"prompt";s:17:"Rose, Green, Blue";}}', 1);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;

-- Дъмп структура за таблица db_anketazf2loc.result
CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `question_id` int(11) DEFAULT NULL,
  `result` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дъмп данни за таблица db_anketazf2loc.result: 8 rows
/*!40000 ALTER TABLE `result` DISABLE KEYS */;
INSERT INTO `result` (`id`, `user_id`, `question_id`, `result`, `date`) VALUES
	(57, 1, 72, 'incorrect', '2018-08-30 08:45:35'),
	(56, 1, 73, 'correct', '2018-08-30 08:45:32'),
	(55, 1, 74, 'correct', '2018-08-30 08:45:27'),
	(54, 1, 75, 'incorrect', '2018-08-30 08:45:20'),
	(53, 1, 76, 'correct', '2018-08-30 08:45:10'),
	(52, 1, 79, 'correct', '2018-08-30 08:45:06');
/*!40000 ALTER TABLE `result` ENABLE KEYS */;

-- Дъмп структура за таблица db_anketazf2loc.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица db_anketazf2loc.user: ~3 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `email`, `display_name`, `password`, `state`) VALUES
	(1, NULL, 'alexsidorov1972@gmail.com', 'Alejandro', '$2y$14$Xi/LCLNcpvo69G/Gk96VXOQlYOGZNxZbk4PaXrRQYtbQ8pyjhOJZy', NULL),
	(3, 'vasyapupkin', 'vpupkin@gmail.com', 'Vasya Pupkin', '$2y$14$TpFJBdcWrZP7AVWZPBaWGeev9sCFkI6zFPnHmCdKgw5YmjFDB4fl.', NULL),
	(4, 'aaa', 'aaa@hhh.bb', 'aaa', '$2y$14$qd9cy9RqMSrYPA1FxPrQ0ODCwJ1RPZsEpXjseD75KURUYgQ/Yo4EK', NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
