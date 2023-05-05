-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 05 mai 2023 à 22:36
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `my_projeception`
--

DROP SCHEMA IF EXISTS `my_projeception` ;
CREATE SCHEMA IF NOT EXISTS `my_projeception` DEFAULT CHARACTER SET utf8 ;
USE `my_projeception` ;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(55) NOT NULL,
  `description` varchar(2004) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `nom`) VALUES
(1, 'utilisateur'),
(2, 'modérateur'),
(3, 'administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudonyme` varchar(15) NOT NULL,
  `nom` varchar(55) NOT NULL,
  `prenom` varchar(55) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `description` varchar(2004) DEFAULT NULL,
  `est_banni` int NOT NULL,
  `Categorie_id` int DEFAULT NULL,
  `Statut_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_Utilisateur_Categorie1_idx` (`Categorie_id`),
  KEY `fk_Utilisateur_Statut1_idx` (`Statut_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_du_projet`
--

DROP TABLE IF EXISTS `utilisateurs_du_projet`;
CREATE TABLE IF NOT EXISTS `utilisateurs_du_projet` (
  `Utilisateur_id` int NOT NULL,
  `Projet_id` int NOT NULL,
  KEY `fk_Utilisateurs_du_projet_Utilisateur_idx` (`Utilisateur_id`),
  KEY `fk_Utilisateurs_du_projet_Projet1_idx` (`Projet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `fk_Utilisateur_Categorie1` FOREIGN KEY (`Categorie_id`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `fk_Utilisateur_Statut1` FOREIGN KEY (`Statut_id`) REFERENCES `statut` (`id`);

--
-- Contraintes pour la table `utilisateurs_du_projet`
--
ALTER TABLE `utilisateurs_du_projet`
  ADD CONSTRAINT `fk_Utilisateurs_du_projet_Projet1` FOREIGN KEY (`Projet_id`) REFERENCES `projet` (`id`),
  ADD CONSTRAINT `fk_Utilisateurs_du_projet_Utilisateur` FOREIGN KEY (`Utilisateur_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
