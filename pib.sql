-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 28 Décembre 2016 à 04:15
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

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

CREATE TABLE `creation` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `video` int(11) NOT NULL,
  `subtitle` int(11) NOT NULL,
  `music` int(11) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `sum` float NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `creation`
--

INSERT INTO `creation` (`id`, `title`, `video`, `subtitle`, `music`, `score`, `count`, `sum`, `path`, `email`) VALUES
(1, 'Création d\'exemple', 1, 1, 1, 3.72727, 11, 41, '/web/pib/file/video.mp4', 'fabien.beaujean@hotmail.fr'),
(2, 'Création d\'exemple 2', 1, 1, 1, 5, 1, 5, '/web/pib/file/video.mp4', 'fabien.beaujean@hotmail.fr'),
(3, 'Titre', 1, 5, 1, 0, 0, 0, '', 'fabien.beaujean@hotmail.fr'),
(4, 'Ma vid&eacute;o', 1, 1, 1, 0, 0, 0, '', 'fabien.beaujean@hotmail.fr'),
(5, 'Titre', 1, 5, 1, 0, 0, 0, '', 'fabienbeaudimi@hotmail.fr');

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

CREATE TABLE `music` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `music`
--

INSERT INTO `music` (`id`, `title`, `duration`, `path`) VALUES
(1, 'Musique d\'exemple', 167, '/web/pib/file/music.mp3');

-- --------------------------------------------------------

--
-- Structure de la table `subelement`
--

CREATE TABLE `subelement` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `subtitle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `subelement`
--

INSERT INTO `subelement` (`id`, `time`, `duration`, `content`, `subtitle`) VALUES
(4, 5320, 2040, 'Je suis votre voix', 1),
(5, 9940, 2040, 'Pour toutes les mamounettes', 1),
(6, 12420, 1600, 'qui rêvent d\'enfants', 1),
(7, 14740, 1280, 'et tous les papounets', 1),
(8, 16540, 1700, 'qui rêvent de leur argent', 1),
(9, 18860, 3980, 'je vous le dis ce ne sera pas pour ce soir', 1),
(10, 23600, 1020, 'mais', 1),
(11, 25700, 1320, 'grâce à P.I.B.', 1),
(12, 27640, 1940, 'ça va changer', 1),
(13, 44640, 1740, 'A tous les Français ce soir', 1),
(14, 47340, 1460, 'dans tout Villejuif', 1),
(15, 49400, 1400, 'mais surtout a l\'EFREI', 1),
(16, 51540, 1700, 'je vous fais cette promesse', 1),
(17, 54740, 1420, 'on va rendre', 1),
(18, 56480, 860, 'le wifi', 1),
(19, 57380, 1020, 'puissant à nouveau', 1),
(20, 60440, 1360, 'on va rendre', 1),
(21, 62180, 1700, 'le wifi stable', 1),
(22, 65400, 1480, 'on va rendre', 1),
(23, 67120, 1800, 'le wifi rapide', 1),
(24, 71120, 1620, 'on va rendre', 1),
(25, 72740, 1820, 'le wifi grave bonnasse', 1),
(26, 74800, 1520, 'Que Meunier vous bénisse', 1),
(27, 76320, 1220, 'bisous sur la fesse droite', 1),
(28, 77560, 840, 'j\'aime P.I.B.', 1),
(45, 1000, 2000, 'Sous-titres 1', 2),
(46, 20000, 30000, 'Sous-titres 2', 2),
(47, 1000, 2000, 'Sous-titres 1', 3),
(48, 20000, 30000, 'Sous-titres 2', 3),
(49, 1000, 2000, 'Sous-titres 1', 4),
(50, 20000, 30000, 'Sous-titres 2', 4),
(51, 1000, 2000, 'Sous-titres 1', 5),
(52, 20000, 30000, 'Sous-titres 2', 5);

-- --------------------------------------------------------

--
-- Structure de la table `subtitle`
--

CREATE TABLE `subtitle` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `subtitle`
--

INSERT INTO `subtitle` (`id`, `title`, `video`) VALUES
(1, 'Sous-titres d\'exemple', 1),
(2, 'Sous-titres', 1),
(3, 'Sous-titres', 1),
(4, 'Sous-titres', 1),
(5, 'Sous-titres', 1);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `video`
--

INSERT INTO `video` (`id`, `title`, `poster`, `duration`, `path`) VALUES
(1, 'Vidéo d\'exemple', '/web/pib/img/static/video-poster.png', 119, '/web/pib/file/video.mp4');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `creation`
--
ALTER TABLE `creation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creation_subtitle_id_fk` (`subtitle`),
  ADD KEY `creation_video_id_fk` (`video`),
  ADD KEY `creation_music_id_fk` (`music`);

--
-- Index pour la table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subelement`
--
ALTER TABLE `subelement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subelement_subtitle_id_fk` (`subtitle`);

--
-- Index pour la table `subtitle`
--
ALTER TABLE `subtitle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtitle_video_id_fk` (`video`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `creation`
--
ALTER TABLE `creation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `music`
--
ALTER TABLE `music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `subelement`
--
ALTER TABLE `subelement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT pour la table `subtitle`
--
ALTER TABLE `subtitle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
