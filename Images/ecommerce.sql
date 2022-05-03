-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 14 jan. 2022 à 13:19
-- Version du serveur :  10.4.16-MariaDB
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) NOT NULL,
  `uid` varchar(128) NOT NULL,
  `psw` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `uid`, `psw`) VALUES
(1, 'Administrateur', 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `titre` varchar(128) NOT NULL,
  `description` varchar(528) NOT NULL,
  `prix` decimal(10,2) DEFAULT 0.00,
  `images` varchar(128) DEFAULT NULL,
  `refmarque` int(11) DEFAULT 0,
  `refcategorie` int(11) NOT NULL,
  `refpromotion` int(11) DEFAULT 0,
  `etat` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT 0,
  `datemiseenvente` datetime DEFAULT NULL,
  `datecreation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `titre`, `description`, `prix`, `images`, `refmarque`, `refcategorie`, `refpromotion`, `etat`, `stock`, `datemiseenvente`, `datecreation`) VALUES
(9, 'Sweat Adidas Vert', 'Léger et conçu en molleton a base de coton, ce sweat-shirt à capuche de football hommes est parfait pour te protéger du froid. Il possède des manches raglan ornées de 3 bandes et une poche kangourou pour garder tes mains au chaud. Ne pas utiliser d\'eau de Javel. Ne pas nettoyer à sec. Laver à la machine à chaud', '49.98', '9.jpg', 5, 68, 0, 0, 0, '0000-00-00 00:00:00', '2021-12-08 09:54:34'),
(26, 'Sweat Jack & Jones', '- Parka en queue de poisson avec une capuche pour couvrir votre tête\r\n- Une coupe droite pour qu\'il n\'ait pas l\'air trop encombrant\r\n- Poche Napoléon pratique pour vos essentiels\r\n- Poches zippées pour sécuriser votre téléphone et votre portefeuille\r\n- Fermeture éclair avec patte de boutonnage\r\n- Poignets et poignets coupe-vent réglables pour bloquer le froid\r\n- Cordon de serrage à bascule sur la capuche pour un ajustement individuel\r\n- Coupe classique avec un peu plus de facilité autour du corps\r\n- Le mannequin mesure 187', '49.99', '26.jpg', 5, 17, 0, 0, 10, '0000-00-00 00:00:00', '2021-12-08 10:29:41'),
(27, 'Clée Horizon Zero Dawn', 'Horizon : Zero Dawn sur PS4 est un jeu de type Action-RPG en monde ouvert, jouable en solo. Dans un monde ouvert post-apocalyptique vibrant et luxuriant, de colossales créatures mécaniques parcourent des terres qu\'elles ont arrachées aux mains de l\'humanité. Vous incarnez Aloy, une chasseuse habile qui compte sur sa vitesse, sa ruse et son agilité pour rester en vie et protéger sa tribu des machines, de leur force, de leur taille et de leur puissance brute.', '59.99', '27.jpg', 12, 18, 0, 0, 17, NULL, '2021-12-08 10:35:13'),
(31, 'Lave à linge Candy', 'Type de produit : Lave linge hublot\r\nAvantage : il peut être installé rapidement et simplement n\'importe où. Pour une profondeur mini de 60 cm, vous pourrez y superposer un séche-linge\r\nConseils : prévoir 2 à 3 cms supplémentaires derrière la machine pour le passage des tuyaux et câbles\r\nSens d\'ouverture du hublot : fixation à gauche\r\nCouleur : Blanc', '470.99', '31.jpg', 4, 68, 0, 0, 3, NULL, '2021-12-09 10:44:14'),
(32, 'Four à micro onde Candy', 'Four à micro onde de haute qualité', '124.99', '32.jpg', 4, 68, 0, 0, 8, NULL, '2021-12-09 10:45:34'),
(33, 'Réfrigérateur Samsung', 'Réfrigérateur de haute qualité', '1729.98', '33.jpg', 7, 68, 0, 0, 4, NULL, '2021-12-09 10:46:49'),
(34, 'Clée Days Gone ', 'Jeux de haute qualité', '39.99', '34.jpg', 11, 18, 0, 0, 61, NULL, '2021-12-09 10:57:59'),
(35, 'Clée Word Of Warcraft', 'Jeux de haute qualité', '12.99', '35.jpg', 1, 18, 0, 0, 146, NULL, '2021-12-09 11:05:07'),
(36, 'Clée The Witcher 3', 'Jeux de haute qualité TW3', '59.99', '36.jpg', 10, 18, 0, 0, 129, NULL, '2021-12-09 11:06:30'),
(37, 'Sweat Fila ', 'Sweat de haute qualité', '69.99', '37.jpg', 8, 17, 0, 0, 50, NULL, '2021-12-09 11:07:16'),
(38, 'Clée Dishonored', 'Clée Dishonored Français en ligne', '19.99', '38.jpg', 9, 18, 0, 0, 59, NULL, '2021-12-09 13:50:26');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `photo` varchar(128) NOT NULL,
  `libelle` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `photo`, `libelle`) VALUES
(17, '17.png', 'Vêtement'),
(18, '18.png', 'Jeux'),
(19, '19.png', 'Smartphone'),
(68, '68.png', 'Electromenager');

-- --------------------------------------------------------

--
-- Structure de la table `detailfacture`
--

CREATE TABLE `detailfacture` (
  `id` int(11) NOT NULL,
  `imagesart` varchar(256) DEFAULT NULL,
  `refarticle` int(11) NOT NULL,
  `reffacture` int(11) NOT NULL,
  `prixvente` decimal(10,2) NOT NULL,
  `qte` int(11) NOT NULL,
  `datefacture` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detailfacture`
--

INSERT INTO `detailfacture` (`id`, `imagesart`, `refarticle`, `reffacture`, `prixvente`, `qte`, `datefacture`) VALUES
(46, '27.jpg', 27, 79, '59.99', 1, '2022-01-14 10:33:15'),
(47, '26.jpg', 26, 79, '49.99', 1, '2022-01-14 10:33:15'),
(48, '32.jpg', 32, 80, '124.99', 1, '2022-01-14 10:33:42'),
(49, '38.jpg', 38, 80, '19.99', 1, '2022-01-14 10:33:42'),
(50, '26.jpg', 26, 82, '49.99', 1, '2022-01-14 11:11:30'),
(51, '34.jpg', 34, 82, '39.99', 1, '2022-01-14 11:11:30'),
(52, '31.jpg', 31, 83, '470.99', 1, '2022-01-14 11:12:43'),
(53, '26.jpg', 26, 83, '49.99', 2, '2022-01-14 11:12:43'),
(54, '27.jpg', 27, 83, '59.99', 3, '2022-01-14 11:12:43'),
(55, '26.jpg', 26, 84, '49.99', 1, '2022-01-14 11:32:59'),
(56, '31.jpg', 31, 84, '470.99', 2, '2022-01-14 11:32:59');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `datefacture` datetime NOT NULL DEFAULT current_timestamp(),
  `refclient` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `refarticle` int(11) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `prixtotal` varchar(256) NOT NULL,
  `nom` varchar(256) NOT NULL,
  `prenom` varchar(256) NOT NULL,
  `genre` varchar(5) NOT NULL,
  `adressefac` varchar(256) NOT NULL,
  `postalfac` varchar(256) NOT NULL,
  `villefac` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `tel` varchar(12) NOT NULL,
  `villeliv` varchar(256) NOT NULL,
  `adresseliv` varchar(256) NOT NULL,
  `postalliv` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`id`, `datefacture`, `refclient`, `qte`, `refarticle`, `prix`, `prixtotal`, `nom`, `prenom`, `genre`, `adressefac`, `postalfac`, `villefac`, `email`, `tel`, `villeliv`, `adresseliv`, `postalliv`) VALUES
(79, '2022-01-14 10:33:00', 0, 0, 0, '0.00', '', 'Parizot', 'Tony', 'Homme', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry', 'shadow02400@gmail.com', '0780527517', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry'),
(80, '2022-01-14 10:33:00', 0, 0, 0, '0.00', '', 'Parizot', 'Tony', 'Homme', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry', 'shadow02400@gmail.com', '0780527517', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry'),
(81, '2022-01-14 10:59:00', 0, 0, 0, '0.00', '', 'Parizot', 'Tony', 'Homme', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry', 'shadow02400@gmail.com', '0780527517', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry'),
(82, '2022-01-14 11:11:00', 0, 0, 0, '0.00', '', 'Parizot', 'Tony', 'Homme', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry', 'shadow02400@gmail.com', '0780527517', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry'),
(83, '2022-01-14 11:12:00', 0, 0, 0, '0.00', '', 'Parizot', 'Tony', 'Homme', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry', 'shadow02400@gmail.com', '0780527517', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry'),
(84, '2022-01-14 11:32:00', 0, 0, 0, '0.00', '', 'Parizot', 'Tony', 'Homme', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry', 'shadow02400@gmail.com', '0780527517', '9 avenue de la mare aux canes', 'apt 35 interphone 5', 'Château-Thierry');

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `id` int(11) NOT NULL,
  `logo` varchar(128) DEFAULT NULL,
  `libellemarque` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `logo`, `libellemarque`) VALUES
(1, '1.png', 'Blizzard'),
(4, '4.png', 'Candy'),
(5, '5.png', 'Adidas'),
(6, '6.jpg', 'Jack & Jones'),
(7, '7.jpg', 'Samsung'),
(8, NULL, 'Fila'),
(9, NULL, 'Arkane Studios'),
(10, NULL, 'CD Projekt Red'),
(11, NULL, 'Bend Studio'),
(12, NULL, 'Guerrilla Games'),
(15, '15.jpg', 'eaz');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `idsession` varchar(258) NOT NULL,
  `refarticle` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `dateheure` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `idsession`, `refarticle`, `qte`, `dateheure`) VALUES
(281, 'ifbf37f11ealrfo5g0jk9qlqe2', 26, 1, '2022-01-14 12:00:54'),
(282, 'ifbf37f11ealrfo5g0jk9qlqe2', 27, 1, '2022-01-14 12:00:59');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `uid` varchar(258) NOT NULL,
  `nom` varchar(258) NOT NULL,
  `prenom` varchar(258) NOT NULL,
  `naissance` date NOT NULL,
  `civilite` varchar(5) NOT NULL,
  `email` varchar(258) NOT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `ville` varchar(258) DEFAULT NULL,
  `adresse` varchar(258) DEFAULT NULL,
  `adressepostal` varchar(5) DEFAULT NULL,
  `psw` varchar(258) NOT NULL,
  `tentative` int(11) DEFAULT NULL,
  `acces` int(11) DEFAULT NULL,
  `connexion` datetime NOT NULL DEFAULT current_timestamp(),
  `grade` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `uid`, `nom`, `prenom`, `naissance`, `civilite`, `email`, `telephone`, `ville`, `adresse`, `adressepostal`, `psw`, `tentative`, `acces`, `connexion`, `grade`) VALUES
(1, 'Test', 'TestMoi', 'TestToi', '0000-00-00', 'Homme', '0', '0789654850', 'Château-Thierry', '13 avenue de la rose', '02400', 'Test', 0, 28, '2021-12-16 14:17:00', 0),
(2, 'fesfsfsfesfsefseef', 'feffe', 'fefe', '0000-00-00', 'Homme', 'fefef', '0780956859', NULL, NULL, NULL, 'fesfsfsfesfsefseef', 0, 1, '2021-12-08 15:35:49', 0),
(3, 'Daeron', 'Parizot', 'Tony', '2002-08-13', 'Homme', 'shadow02400@gmail.com', '0780527517', NULL, NULL, NULL, 'daeron', 0, 13, '2022-01-14 09:16:26', 2),
(4, 'TestSto', 'TestStoMe', 'TestStoMet', '0000-00-00', 'Homme', '08/02/1989', '0732659860', NULL, NULL, NULL, 'TestSto', 0, 1, '2022-01-05 09:59:48', 0),
(5, 'JeSuis', 'JeSuisM', 'JeSuisT', '2022-01-12', 'Homme', 'JeSuis@live.fr', '0782598657', NULL, NULL, NULL, 'jesuis', 0, 4, '2022-01-12 15:37:12', 2),
(6, 'admin.', 'admin', 'admin', '1997-06-19', 'Homme', 'admi@gmail.com', 'admin', NULL, NULL, NULL, 'admin', 0, 43, '2022-01-12 15:35:46', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titre` (`titre`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titre` (`libelle`);

--
-- Index pour la table `detailfacture`
--
ALTER TABLE `detailfacture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT pour la table `detailfacture`
--
ALTER TABLE `detailfacture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
