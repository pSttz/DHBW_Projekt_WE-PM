-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Jun 2015 um 11:32
-- Server-Version: 5.6.24
-- PHP-Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `skymap`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galerie`
--

CREATE TABLE IF NOT EXISTS `galerie` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `href` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8mb4 NOT NULL,
  `date` date NOT NULL,
  `tags` text CHARACTER SET utf8 NOT NULL,
  `downloadable` tinyint(1) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `galerie`
--

INSERT INTO `galerie` (`id`, `title`, `href`, `description`, `date`, `tags`, `downloadable`, `likes`) VALUES
(0, 'Red auto', 'img1.jpg', 'Red auto description', '2015-05-12', 'autos,tiere', 1, 10),
(1, 'White tiger', 'img2.jpg', 'White tiger description', '2015-05-18', 'tiere', 1, 5);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `galerie`
--
ALTER TABLE `galerie`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
