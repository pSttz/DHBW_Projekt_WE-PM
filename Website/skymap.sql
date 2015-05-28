-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 28. Mai 2015 um 21:51
-- Server Version: 5.6.20
-- PHP-Version: 5.5.15

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
  `title` text NOT NULL,
  `href` text NOT NULL,
  `description` text NOT NULL,
  `capture` date NOT NULL,
  `downloadable` tinyint(1) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `galerie`
--

INSERT INTO `galerie` (`id`, `title`, `href`, `description`, `capture`, `downloadable`, `likes`) VALUES
(0, 'Sample', 'all.bmp', 'description very long', '2015-05-28', 0, 1),
(1, 'Beispiel 2', 'all.bmp', 'asdf', '2015-05-14', 1, 111111111);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `galerie`
--
ALTER TABLE `galerie`
 ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
