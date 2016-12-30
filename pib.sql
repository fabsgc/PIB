-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 30 Décembre 2016 à 23:48
-- Version du serveur :  5.7.9
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pib`
--

-- --------------------------------------------------------

--
-- Structure de la table `creation`
--

DROP TABLE IF EXISTS `creation`;
CREATE TABLE IF NOT EXISTS `creation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `video` int(11) NOT NULL,
  `subtitle` int(11) NOT NULL,
  `music` int(11) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `sum` float NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creation_subtitle_id_fk` (`subtitle`),
  KEY `creation_video_id_fk` (`video`),
  KEY `creation_music_id_fk` (`music`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `creation`
--

INSERT INTO `creation` (`id`, `title`, `video`, `subtitle`, `music`, `score`, `count`, `sum`, `path`, `email`) VALUES
(1, 'Création d''exemple', 1, 1, 1, 3.72727, 11, 41, '/web/pib/file/video.mp4', 'fabien.beaujean@hotmail.fr'),
(9, 'Video test encodage', 1, 1, 1, 0, 0, 0, 'web/pib/file/creation/9.mp4', 'fabienbeaudimi@hotmail.fr');

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

DROP TABLE IF EXISTS `music`;
CREATE TABLE IF NOT EXISTS `music` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `music`
--

INSERT INTO `music` (`id`, `title`, `duration`, `path`) VALUES
(1, 'Musique d''exemple', 167, '/web/pib/file/music/music.mp3');

-- --------------------------------------------------------

--
-- Structure de la table `subelement`
--

DROP TABLE IF EXISTS `subelement`;
CREATE TABLE IF NOT EXISTS `subelement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `subtitle` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subelement_subtitle_id_fk` (`subtitle`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `subelement`
--

INSERT INTO `subelement` (`id`, `time`, `duration`, `content`, `subtitle`) VALUES
(54, 5320, 2040, 'Je suis votre voix', 1),
(55, 9940, 2040, 'Pour toutes les mamounettes', 1),
(56, 12420, 1600, 'qui rêvent d''enfants', 1),
(57, 14740, 1280, 'et tous les papounets', 1),
(58, 16540, 1700, 'qui rêvent de leur argent', 1),
(59, 18860, 3980, 'je vous le dis ce ne sera pas pour ce soir', 1),
(60, 23600, 1020, 'mais', 1),
(61, 25700, 1320, 'grâce à P.I.B.', 1),
(62, 27640, 1940, 'ça va changer', 1),
(63, 44640, 1740, 'A tous les Français ce soir', 1),
(64, 47340, 1460, 'dans tout Villejuif', 1),
(65, 49400, 1400, 'mais surtout a l''EFREI', 1),
(66, 51540, 1700, 'je vous fais cette promesse', 1),
(67, 54740, 1420, 'on va rendre', 1),
(68, 56480, 860, 'le wifi', 1),
(69, 57380, 1020, 'puissant à nouveau', 1),
(70, 60440, 1360, 'on va rendre', 1),
(71, 62180, 1700, 'le wifi stable', 1),
(72, 65400, 1480, 'on va rendre', 1),
(73, 67120, 1800, 'le wifi rapide', 1),
(74, 71120, 1620, 'on va rendre', 1),
(75, 72740, 1820, 'le wifi grave bonnasse', 1),
(76, 74800, 1520, 'Que Meunier vous bénisse', 1),
(77, 76320, 1220, 'bisous sur la fesse droite', 1),
(78, 77560, 840, 'j''aime P.I.B.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `subtitle`
--

DROP TABLE IF EXISTS `subtitle`;
CREATE TABLE IF NOT EXISTS `subtitle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `video` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subtitle_video_id_fk` (`video`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `subtitle`
--

INSERT INTO `subtitle` (`id`, `title`, `video`) VALUES
(1, 'Sous-titres d''exemple', 1);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `video`
--

INSERT INTO `video` (`id`, `title`, `poster`, `duration`, `path`) VALUES
(1, 'Vidéo d''exemple', '/web/pib/file/video/video-poster.png', 119, '/web/pib/file/video/video.mp4');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `creation`
--
ALTER TABLE `creation`
  ADD CONSTRAINT `creation_music_id_fk` FOREIGN KEY (`music`) REFERENCES `music` (`id`),
  ADD CONSTRAINT `creation_subtitle_id_fk` FOREIGN KEY (`subtitle`) REFERENCES `subtitle` (`id`),
  ADD CONSTRAINT `creation_video_id_fk` FOREIGN KEY (`video`) REFERENCES `video` (`id`);

--
-- Contraintes pour la table `subelement`
--
ALTER TABLE `subelement`
  ADD CONSTRAINT `subelement_subtitle_id_fk` FOREIGN KEY (`subtitle`) REFERENCES `subtitle` (`id`);

--
-- Contraintes pour la table `subtitle`
--
ALTER TABLE `subtitle`
  ADD CONSTRAINT `subtitle_video_id_fk` FOREIGN KEY (`video`) REFERENCES `video` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
