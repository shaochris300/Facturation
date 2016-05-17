-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 04 Octobre 2015 à 16:41
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `maisondesligues`
--

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `numfacture` int(11) NOT NULL,
  `datefacture` date NOT NULL,
  `echeance` date NOT NULL,
  `compte_ligue` int(11) NOT NULL,
  PRIMARY KEY (`numfacture`),
  KEY `compte_ligue` (`compte_ligue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`numfacture`, `datefacture`, `echeance`, `compte_ligue`) VALUES
(5180, '2014-01-15', '2014-01-31', 411007);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_facture`
--

CREATE TABLE IF NOT EXISTS `ligne_facture` (
  `numfacture` int(11) NOT NULL,
  `code_prestation` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`numfacture`,`code_prestation`),
  KEY `code_prestation` (`code_prestation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ligne_facture`
--

INSERT INTO `ligne_facture` (`numfacture`, `code_prestation`, `quantite`) VALUES
(5180, 1, 40),
(5180, 2, 2),
(5180, 3, 250),
(5180, 4, 30),
(5180, 5, 1),
(5180, 6, 10);

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

CREATE TABLE IF NOT EXISTS `ligue` (
  `numcompte` int(11) NOT NULL,
  `intitule` varchar(30) NOT NULL,
  `nomtresorier` varchar(20) NOT NULL,
  `adrue` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `ville` varchar(20) NOT NULL,
  PRIMARY KEY (`numcompte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ligue`
--

INSERT INTO `ligue` (`numcompte`, `intitule`, `nomtresorier`, `adrue`, `cp`, `ville`) VALUES
(411007, 'Ligue Lorraine de Judo', 'Gilles', '12 route de Woippy ', 57050, 'METZ'),
(411008, 'Ligue Lorraine de Natation', 'Jean-Michel MATHI', '13 rue Jean Moulin - BP 70001', 54510, 'TOMBLAINE'),
(411009, 'Ligue Lorraine de Basket Ball', 'Mohamed BOURGARD', 'Rue d''Amaville', 57689, 'NOVEANT'),
(411010, 'Ligue Lorraine d''athletisme', 'Sylvain DELAHOUSSE', '13 rue Jean Moulin', 54510, 'TOMBLAINE');

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

CREATE TABLE IF NOT EXISTS `prestation` (
  `codepres` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL,
  `prix_unitaire` float NOT NULL,
  PRIMARY KEY (`codepres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `prestation`
--

INSERT INTO `prestation` (`codepres`, `libelle`, `prix_unitaire`) VALUES
(1, 'Affanchissement', 3.34),
(2, 'Photocopies couleur', 0.24),
(3, 'Photocopies N&amp;B', 0.06),
(4, 'Gestion des Colis', 8.24),
(5, 'Reservation de salle', 50),
(6, 'acces wifi', 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`compte_ligue`) REFERENCES `ligue` (`numcompte`);

--
-- Contraintes pour la table `ligne_facture`
--
ALTER TABLE `ligne_facture`
  ADD CONSTRAINT `ligne_facture_ibfk_1` FOREIGN KEY (`numfacture`) REFERENCES `facture` (`numfacture`),
  ADD CONSTRAINT `ligne_facture_ibfk_2` FOREIGN KEY (`code_prestation`) REFERENCES `prestation` (`codepres`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
