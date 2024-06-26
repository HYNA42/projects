CREATE DATABASE IF NOT EXISTS `db_studi_votit`;
USE `db_studi_votit`;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'front-end'),
(2, 'back-end'),
(3, 'devops'),
(4, 'UX/UI');

-- --------------------------------------------------------

--
-- Structure de la table `poll`
--
DROP TABLE IF EXISTS `poll`;
CREATE TABLE IF NOT EXISTS `poll` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `poll`
--

INSERT INTO `poll` (`id`, `title`, `description`, `user_id`, `category_id`) VALUES
(1, 'Quels sont vos languages back-end préférez vous ?', 'Chaque développeur a ses outils et langages de prédilection lorsqu\'il s\'agit de coder côté serveur. Que ce soit pour leur efficacité, leur syntaxe, ou tout autre raison, quelles sont vos préférences personnelles en matière de développement back-end ?', 2, 2),
(2, 'React VS Angular ?', 'Dans l\'arène du développement front-end, deux géants se démarquent : React et Angular. L\'un, une bibliothèque flexible née chez Facebook, l\'autre, un cadre complet soutenu par Google. Chacun a ses avantages, ses particularités et sa courbe d\'apprentissage. Alors, lequel préférez-vous ? Êtes-vous team React avec sa composabilité ou team Angular avec sa structure holistique ? Participez à notre sondage et faites entendre votre voix dans ce débat éternel !', 1, 1),
(3, 'Boostrap vs Tailwind ?', 'Bootstrap ou Tailwind : Deux cadres CSS qui ont fait sensation dans le monde du développement front-end. D\'un côté, Bootstrap, l\'outil éprouvé avec ses composants pré-conçus et son approche orientée grille. De l\'autre, Tailwind, la montée en puissance avec ses classes utilitaires et sa flexibilité sans précédent. Lequel vous fait gagner en productivité et donne vie à vos designs ? Partagez votre point de vue et vos expériences dans notre sondage !', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `poll_item`
--
DROP TABLE IF EXISTS `poll_item`;
CREATE TABLE IF NOT EXISTS `poll_item` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poll_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `poll_item`
--

INSERT INTO `poll_item` (`id`, `name`, `poll_id`) VALUES
(3, 'PHP', 1),
(4, 'Python', 1),
(5, 'Java', 1),
(6, 'Ruby', 1),
(9, 'JavaScript (Node.js)', 1),
(10, 'Rust', 1),
(11, 'Scala', 1),
(12, 'Autre', 1),
(13, 'React', 2),
(14, 'Angular', 2),
(15, 'Boostrap', 3),
(16, 'Tailwind', 3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nickname`) VALUES
(1, 'user@test.com', '$2y$10$lEzMI.H26sDsV4PzhAVBveHiTDBrH0BGSaNDAin.89cP8y/baG0vu', 'John1'),
(2, 'user2@test.com', '$2y$10$lEzMI.H26sDsV4PzhAVBveHiTDBrH0BGSaNDAin.89cP8y/baG0vu', 'John2'),
(3, 'user3@test.com', '$2y$10$lEzMI.H26sDsV4PzhAVBveHiTDBrH0BGSaNDAin.89cP8y/baG0vu', 'John3'),
(4, 'test', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `user_poll_item`
--
DROP TABLE IF EXISTS `user_poll_item`;
CREATE TABLE IF NOT EXISTS `user_poll_item` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `poll_item_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`poll_item_id`),
  KEY `poll_item_id` (`poll_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user_poll_item`
--

INSERT INTO `user_poll_item` (`user_id`, `poll_item_id`) VALUES
(1, 3),
(2, 
