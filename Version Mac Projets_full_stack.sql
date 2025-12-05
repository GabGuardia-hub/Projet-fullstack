-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 05 déc. 2025 à 17:43
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Projets_full_stack`
--

-- --------------------------------------------------------

--
-- Structure de la table `assign_to`
--

CREATE TABLE `assign_to` (
  `id_task` int NOT NULL,
  `id_member` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `assign_to`
--

INSERT INTO `assign_to` (`id_task`, `id_member`) VALUES
(1, 14),
(2, 14),
(3, 14),
(4, 15),
(5, 14);

-- --------------------------------------------------------

--
-- Structure de la table `membre_projets`
--

CREATE TABLE `membre_projets` (
  `id` int NOT NULL,
  `projets_id` int NOT NULL,
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  `joined_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `membre_projets`
--

INSERT INTO `membre_projets` (`id`, `projets_id`, `user_id`, `role_id`, `joined_at`) VALUES
(1, 1, 14, 4, '2025-12-02'),
(2, 5, 15, 5, '2025-12-02'),
(3, 5, 14, 6, '2025-12-02'),
(4, 6, 15, 7, '2025-12-03'),
(5, 7, 14, 7, '2025-12-03'),
(6, 7, 15, 8, '2025-12-03'),
(7, 8, 15, 7, '2025-12-04'),
(8, 8, 14, 9, '2025-12-04'),
(9, 9, 17, 7, '2025-12-05'),
(10, 10, 15, 10, '2025-12-05'),
(11, 10, 14, 11, '2025-12-05');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `projets_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `projets_id`, `user_id`, `content`, `created_at`) VALUES
(1, 5, 15, 'gdgdg', '2025-12-04 08:48:04'),
(2, 5, 15, 'GG', '2025-12-04 08:48:10'),
(3, 5, 14, 'Lol', '2025-12-04 08:53:43'),
(4, 5, 15, 'ah ok', '2025-12-04 08:53:59'),
(5, 5, 14, 'rohroh', '2025-12-04 08:56:27'),
(6, 5, 14, 'caca', '2025-12-04 09:00:59'),
(7, 5, 14, 'prout', '2025-12-04 09:01:14'),
(8, 5, 15, 'ah ok', '2025-12-04 09:02:56'),
(9, 5, 15, 'zizi', '2025-12-04 09:05:54'),
(10, 5, 14, 'La contrefaçons de carrefour c\'est rondpoint', '2025-12-04 09:13:01'),
(11, 5, 15, 'Et celle de Ubereat c\'est Hubert Mange', '2025-12-04 09:14:05'),
(13, 5, 15, 'We just better chat en direct LIIIIIIIIIIVE', '2025-12-04 09:15:25'),
(14, 5, 15, 'gggg', '2025-12-04 09:34:57'),
(15, 8, 14, 'Salut', '2025-12-04 12:52:37'),
(16, 8, 15, 'Tu vas bien ?', '2025-12-04 12:52:51'),
(17, 8, 14, 'ça va et toi ?', '2025-12-04 12:53:00'),
(18, 8, 15, 'Ca va bien', '2025-12-04 12:53:13'),
(19, 5, 15, 'rohroh', '2025-12-04 20:11:45'),
(20, 5, 14, 'trou duc', '2025-12-04 20:12:35');

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`) VALUES
(1, 'Membre', 'A accès au projet'),
(2, 'Responsable', 'Peut attribuer des taches'),
(3, 'Owner', 'A toutes les permissions');

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` text NOT NULL,
  `created_by` int NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `fin_prevue` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `name`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `fin_prevue`) VALUES
(1, 'TEST 1 ( Web Fullstack )', 'test', 'En cours', 14, '2025-11-30', '2025-11-30', '2025-12-05'),
(2, 'TEST 2', 'sdd', 'En cours', 14, '2025-12-01', '2025-12-01', '2025-12-05'),
(3, 'TEST 3', '', 'En préparation', 14, '2025-12-04', '2025-12-01', '2025-12-05'),
(4, 'TEST 4', 'Test', 'En préparation', 14, '2025-12-20', '2025-12-01', '2026-01-17'),
(5, 'Web Full Stack', 'Roh Roh', 'En préparation', 15, '2025-12-13', '2025-12-02', '2025-12-18'),
(6, 'Test 2', 'Je ne sais pas', 'En cours', 15, '2025-12-03', '2025-12-03', '2025-12-06'),
(7, 'Test 3', '', 'En préparation', 14, '2025-12-04', '2025-12-03', '2025-12-10'),
(8, '12h50', '', 'En cours', 15, '2025-12-04', '2025-12-04', '2025-12-11'),
(9, 'Test', 'Soutenance', 'En cours', 17, '2025-12-05', '2025-12-05', '2025-12-07'),
(10, 'Lukas V3', '', 'En cours', 15, '2025-12-05', '2025-12-05', '2025-12-13');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `perimission_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `perimission_id`) VALUES
(4, 'Le plus beau', '', 3),
(5, 'Owner', 'Créateur du projet', 1),
(6, 'Moi', '', 2),
(7, 'Owner', 'Créateur du projet', 3),
(8, 'REsponsable', '', 2),
(9, 'Le plus beau', '', 2),
(10, 'Administrateur', 'Créateur du projet', 3),
(11, 'Le plus beau', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id` int NOT NULL,
  `projets_id` int NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` text NOT NULL,
  `created_by` int NOT NULL,
  `date_limite` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `projets_id`, `title`, `description`, `status`, `created_by`, `date_limite`) VALUES
(1, 5, 'je sais pas', 'ddd', 'En retard', 14, '2025-12-02'),
(2, 5, 'gg', 'gg', 'Terminé', 14, '2025-12-05'),
(3, 10, 'Test', 'Juste pour test', 'En cours', 15, '2025-12-13'),
(4, 10, 'Test', 'Juste pour test', 'En retard', 15, '2025-12-05'),
(5, 10, 'Lukas', 'Juste pour test', 'En cours', 15, '2025-12-19');

-- --------------------------------------------------------

--
-- Structure de la table `timeline`
--

CREATE TABLE `timeline` (
  `id` int NOT NULL,
  `projets_id` int NOT NULL,
  `label` varchar(255) NOT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `timeline`
--

INSERT INTO `timeline` (`id`, `projets_id`, `label`, `event_date`) VALUES
(1, 10, 'Test', '2025-12-26'),
(2, 10, 'Test2', '2025-12-07'),
(3, 10, 'Lancement grand publique', '2026-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `lastName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `lastName`, `firstName`, `email`, `password`, `phone`, `is_verified`, `token`) VALUES
(14, 'crdr', 'lksh', 'lc@guardiaschool.fr', '$2y$10$EWkcnqgcNKiovuvqbZNMtuLQHLjZYGjYSXmfgE1u6L60Br7FiwT9i', '+33 6 00 00 00 00', 0, NULL),
(15, 'Courdier', 'Lukas', 'l@g', '$2y$10$gOMvoTC3yexZbU0UX427jOZuX30O0Tc68tIHrWF/fFvdl241TOBaS', NULL, 0, NULL),
(16, 'Crdr', 'Lukas', 'lukas.courdier@gmail.com', '$2y$10$BgGbk7gyTOIwPChmmHazQewq3O2OKAK5dM1YVuv0TfvXmhU1eNAxS', NULL, 0, 'ad34935b7135837cf1ca429fe1621eae694fe51e0deb21b4d2f4349820ce0e5e'),
(17, 'JOURDAIN', 'Leandre', 'l@gmail.com', '$2y$10$5JtDSIf8LJWOrCim65N0TO2bRHCkS6psGZHwWfjMKyTqtt/ejnNKy', NULL, 0, 'c25951ff41c8c7029e84a51231fcb64a601aefe7cb3e222212de74b65228d097'),
(18, 'dupont', 'jean', 'jd@g', '$2y$10$n667gVSAZkOKBMAoZpU4RePcMoP9/zuJz9mqcyTdg.i4rPmopVMTm', NULL, 0, '033aa53cc792c913f1bc4935be7847aadb34e4d415540ca45a789630cdf91e72');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `assign_to`
--
ALTER TABLE `assign_to`
  ADD KEY `id_task` (`id_task`,`id_member`),
  ADD KEY `id_member` (`id_member`);

--
-- Index pour la table `membre_projets`
--
ALTER TABLE `membre_projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projets_id` (`projets_id`,`user_id`,`role_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projets_id` (`projets_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `created_by_2` (`created_by`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `perimission_id` (`perimission_id`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`projets_id`,`created_by`),
  ADD KEY `projets_id` (`projets_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Index pour la table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projets_id` (`projets_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`(50)),
  ADD UNIQUE KEY `phone` (`phone`(10));

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `membre_projets`
--
ALTER TABLE `membre_projets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `assign_to`
--
ALTER TABLE `assign_to`
  ADD CONSTRAINT `assign_to_ibfk_1` FOREIGN KEY (`id_task`) REFERENCES `task` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_to_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `membre_projets`
--
ALTER TABLE `membre_projets`
  ADD CONSTRAINT `membre_projets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `membre_projets_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `membre_projets_ibfk_3` FOREIGN KEY (`projets_id`) REFERENCES `projets` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`projets_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `projets_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`perimission_id`) REFERENCES `permissions` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`projets_id`) REFERENCES `projets` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `timeline`
--
ALTER TABLE `timeline`
  ADD CONSTRAINT `timeline_ibfk_1` FOREIGN KEY (`projets_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
