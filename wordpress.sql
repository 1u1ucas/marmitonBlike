-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 23 mai 2024 à 12:26
-- Version du serveur : 8.0.36
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wordpress`
--

-- --------------------------------------------------------

--
-- Structure de la table `allComment`
--

CREATE TABLE `allComment` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `recepyid` int NOT NULL,
  `comment` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `allComment`
--

INSERT INTO `allComment` (`id`, `userid`, `recepyid`, `comment`, `timestamp`) VALUES
(3, 1, 5, 'le super comment', '2024-05-06 16:39:47'),
(5, 1, 6, 'ho', '2024-05-06 16:42:45'),
(8, 3, 7, 'c\'est vraiment bon', '2024-05-06 17:37:54'),
(12, 1, 5, 'mais c\'est génial ça', '2024-05-23 11:24:06'),
(13, 2, 5, 'mais c\'est génial', '2024-05-23 11:24:29'),
(14, 3, 5, 'oh', '2024-05-23 11:24:41');

-- --------------------------------------------------------

--
-- Structure de la table `allLike`
--

CREATE TABLE `allLike` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `recepyid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `allLike`
--

INSERT INTO `allLike` (`id`, `userid`, `recepyid`) VALUES
(8, 2, 6),
(13, 3, 7),
(14, 1, 7),
(21, 2, 7);

-- --------------------------------------------------------

--
-- Structure de la table `recepy`
--

CREATE TABLE `recepy` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `ingredient` text NOT NULL,
  `etape` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `userid` int NOT NULL,
  `private` tinyint(1) NOT NULL,
  `liked` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recepy`
--

INSERT INTO `recepy` (`id`, `title`, `ingredient`, `etape`, `image`, `userid`, `private`, `liked`) VALUES
(5, 'ma recette', 'sésame', 'fin du travail', '../../uploads/32481662-bouteille-et-verre-de-rouge-vin-les-raisins-et-des-noisettes-sur-en-bois-arriere-plan-juteux-bleu-les-raisins-et-bouteilles-de-rouge-du-vin-sur-une-marron-arriere-plan-ai-genere-gratuit-photo.jpg', 2, 1, 0),
(6, 'ok', 'test', '1 2 1  2', '../../uploads/emile-coddens-copyright-cyril-chigot-61e8466b128db643628956.jpg', 2, 1, 1),
(7, 'ma super recette', 'tomates;mais;riz', 'etape 1;etape 2;etape 3;c\'est prêt', '../../uploads/photoDeMoi.jpg', 3, 1, 3),
(9, 'hey', 'dzdzd', 'dzdzd', '../../uploads/JFOV377ZGZDOXEKNGU2L67ES4Y.jpg', 1, 1, 0),
(12, 'c\'est moi', 'oignon', 'etape1', '../../uploads/JFOV377ZGZDOXEKNGU2L67ES4Y.jpg', 1, 1, 0),
(13, 'recette de lulu', 'sésame', 'fin du travail', '../../uploads/32481662-bouteille-et-verre-de-rouge-vin-les-raisins-et-des-noisettes-sur-en-bois-arriere-plan-juteux-bleu-les-raisins-et-bouteilles-de-rouge-du-vin-sur-une-marron-arriere-plan-ai-genere-gratuit-photo.jpg', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Onyluka', 'lucasleveque17@gmail.com', '$2y$10$iBtXrUCbveg1ng6356e7a.gPOwIK4jLtWGqqH4bdv5lWNKuTBWt5m'),
(2, 'bonjour', 'bonjour@gmail.com', '$2y$10$Q2EqH7c4i.zPU9n0Cb4PrO31FmArkF3Qcl0aE1Ut78XK//DpKs0.i'),
(3, 'christelle', 'christelle@gmail.com', '$2y$10$NpTrCB4jgarhfqg5oPVRTeoKTRU6XZ05UpiUFCGgjEWCJGs2oksz6');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `allComment`
--
ALTER TABLE `allComment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `allLike`
--
ALTER TABLE `allLike`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recepy`
--
ALTER TABLE `recepy`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `allComment`
--
ALTER TABLE `allComment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `allLike`
--
ALTER TABLE `allLike`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `recepy`
--
ALTER TABLE `recepy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
