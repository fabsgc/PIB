-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 27 Décembre 2016 à 01:42
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
  `sum` float DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `creation_video_id_fk` (`video`),
  KEY `creation_subtitle_id_fk` (`subtitle`),
  KEY `creation_music_id_fk` (`music`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `creation`
--

INSERT INTO `creation` (`id`, `title`, `video`, `subtitle`, `music`, `score`, `count`, `sum`) VALUES
(1, 'Création d''exemple 1', 1, 1, 1, 4, 1, 4),
(2, 'Création d''exemple 2', 1, 1, 1, 5, 1, 5);

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
(1, 'Musique d''exemple', 167, '/web/pib/file/music.mp3');

-- --------------------------------------------------------

--
-- Structure de la table `subelement`
--

DROP TABLE IF EXISTS `subelement`;
CREATE TABLE IF NOT EXISTS `subelement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `content` text NOT NULL,
  `subtitle` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subelement_subtitle_id_fk` (`subtitle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `duration` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `video`
--

INSERT INTO `video` (`id`, `title`, `duration`, `path`, `poster`) VALUES
(1, 'Video d''exemple', 119, '/web/pib/file/video.mp4', '/web/pib/img/static/video-poster.png');

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
