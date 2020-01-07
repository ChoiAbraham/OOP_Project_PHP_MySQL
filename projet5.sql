-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 07 jan. 2020 à 07:25
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet5`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `commentdate` datetime DEFAULT NULL,
  `postId` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `valid` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `commentdate`, `postId`, `userId`, `valid`) VALUES
(1, 'what a good article!', '2020-01-07 07:23:14', 50, 31, 1),
(2, 'This is a very interesting article', '2020-01-07 07:23:38', 51, 31, 0),
(3, 'Very interesting.', '2020-01-07 07:23:53', 52, 31, 0);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `author` varchar(255) DEFAULT NULL,
  `standfirst` text,
  `content` longtext,
  `lastdate` datetime DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `valid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`userId`),
  KEY `fk_posts_users1_idx` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `author`, `standfirst`, `content`, `lastdate`, `userId`, `valid`) VALUES
(50, 'Sony surprises with an electric concept car called the Vision-S', 'CHOI Abraham', 'Sony just made what might be one of the biggest surprise announcements at this year’s CES: a car. Called the Sony Vision-S, it’s an electric concept sedan that is meant to showcase the Japanese tech conglomerate’s many different strengths, from entertainment products to camera sensors and more.', '“This prototype embodies our contribution to the future of mobility,” Sony CEO Kenichiro Yoshida said.\r\n\r\nThe company announced the car at the tail end of its CES press conference, where it also unveiled the logo for the upcoming PlayStation 5. Sony only spent a minute or two discussing the car before ending the press conference, too, and so it left tons of questions unanswered. Does Sony (or Magna) intend to put this into production, or is it just meant to be a reference car? Will Magna let other companies build their own prototypes or reference cars on the platform?\r\n\r\nAnd, of course: will we be able to play it in Gran Turismo?', '2020-01-07 07:17:19', 31, 1),
(51, 'Samsung’s ‘artificial humans’ are just digital avatars', 'CHOI Abi', 'Samsung subsidiary STAR Labs has officially unveiled its mysterious “artificial human” project, Neon. As far as we can tell, though, there’s no mystery here at all. Neon is just digital avatars — computer-animated human likenesses about as deserving of the “artificial human” moniker as Siri or the Tupac hologram.', 'In fairness to STAR Labs, the company does seem to be trying something new with its avatars. But exactly what it’s doing we can’t tell, as its first official press release today fails to explain the company’s underlying tech and instead relies solely on jargon and hype.\r\n\r\n“Neon is like a new kind of life,” says STAR Labs CEO Pranav Mistry in the release. “There are millions of species on our planet and we hope to add one more.” (Because nothing says “grounded and reasonable” like a tech executive comparing his work to the creation of life.).\r\n\r\nWe’ve reached out to STAR Labs with our questions, but it seems we’ll have to wait to see the technology in person to get a better understanding. The firm is offering private demos of its avatars at CES this week, and The Verge is scheduled to check out the technology.\r\n\r\nWe look forward to giving you our hands-on impressions later this week, but until then, don’t worry about any “AI android uprising” — these aren’t the artificial humans you’re looking for.', '2020-01-07 07:18:48', 31, 1),
(52, 'Facebook bans deepfake videos ahead of the 2020 election', 'CHOI Abi', 'With a presidential election campaign underway in the United States, Facebook announced Monday that it has banned manipulated videos and photos, often called deepfakes, from its platforms.\r\n\r\nThe policy change was announced through a blog post late Monday night, confirming an earlier report from The Washington Post. In the post, Facebook said that it would begin removing content that has been edited “in ways that aren’t apparent to an average person and would likely mislead someone” or are created by artificial intelligence or machine learning algorithms', 'This policy change comes ahead of a House Energy and Commerce hearing on manipulated media that is scheduled for Wednesday. The author of Monday’s post — Monika Bickert, Facebook’s vice president of global policy management — is set to represent Facebook in front of lawmakers at this week’s hearing.\r\n\r\nThe deepfakes ban comes after an altered video of House Speaker Nancy Pelosi (D-CA) went viral on social media platforms last summer. This video was widely viewed on Facebook, and when reached for comment by The Verge at the time, the company said that it did not violate any of the company’s policies. And Monday’s ban against deepfakes doesn’t appear to cover videos like the viral Pelosi clip, either. That video wasn’t created by AI, but was likely edited using readily available software to slur her speech.\r\n\r\nOther platforms were also caught in the crossfire following the Pelosi video, including Twitter. In November, Twitter began crafting its own deepfakes policy and requested feedback from users concerning the platform’s future rules. The company has yet to issue any new guidance on manipulated media.', '2020-01-07 07:19:58', 31, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `email` varchar(1024) DEFAULT NULL,
  `salt` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `joined` datetime DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `hash` char(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `salt`, `password`, `firstname`, `lastname`, `joined`, `role`, `hash`) VALUES
(31, 'abraham', 'choi.abri@gmail.com', 'faa6dc4ed256e62b7c848e1633399dcc04b1ae6fb701d0ebd50488f7ed789d5d', 'e259a39a033b9c1266d27bf3307797a17db2f0779875c130991053837147e9e2', 'Abraham', 'Choi', '2019-12-19 13:03:20', 'admin', NULL),
(33, 'Odette', 'odette@gmail.com', '9dec13ca0773f6b2daca01b30a5955fd45a99f069ea209f201b6602e074dd8dd', 'd63a63a657cb8d5b89092a874007860fef921b244f7663e7547d5d5a1cf91287', '', '', '2019-12-19 14:23:25', 'user', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users_session`
--

DROP TABLE IF EXISTS `users_session`;
CREATE TABLE IF NOT EXISTS `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(100) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`,`userId`),
  KEY `fk_users_session_users1_idx` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_users1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users_session`
--
ALTER TABLE `users_session`
  ADD CONSTRAINT `fk_users_session_users1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
