-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Jun 2015 um 22:21
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `galerie`
--

INSERT INTO `galerie` (`id`, `title`, `href`, `description`, `date`, `tags`, `downloadable`, `likes`) VALUES
(1, 'Rotes Auto', 'img1.jpg', 'Rotes Auto Beschreibung', '2015-05-12', 'autos', 1, 10),
(2, 'Weißer Tiger', 'img2.jpg', 'Weißer Tiger Beschreibung', '2015-05-18', 'tiere', 1, 5),
(3, 'Sternenhimmel', 'img3.jpg', 'Sternenhimmel Beschreibung', '2015-05-20', 'natur', 1, 0),
(4, 'Rote Blumen', 'img4.jpg', 'Rote Blumen Beschreibung', '2015-05-26', 'natur,blumen', 1, 5),
(5, 'Regenbogen', 'img5.jpg', 'Regenbogen Beschreibung', '2015-05-26', 'natur', 1, 2),
(6, 'Schiff', 'img6.jpg', 'Schiff Beschreibung', '2015-05-26', 'natur,schiffe', 1, 3),
(7, 'Sonnenuntergang und Vogel', 'img7.jpg', 'Sonnenuntergang und Vogel Beschreibung', '2015-05-27', 'natur,tiere,voegel', 1, 0),
(8, 'Feuerwerk', 'img8.jpg', 'Feuerwerk Beschreibung', '2015-05-27', 'feier,nacht', 0, 0),
(9, 'altes Auto', 'img9.jpg', 'Altes Auto Beschreibung', '2015-05-28', 'autos', 1, 0),
(10, 'See', 'img10.jpg', 'See Beschreibung', '2015-05-26', 'natur', 1, 0),
(11, 'Berge und Fluss', 'img11.jpg', 'Berge und Fluss Beschreibung', '2015-06-01', 'natur,berge', 1, 1),
(12, 'Feld mit Blumen', 'img12.jpg', 'Feld mit Blumen Beschreibung', '2015-06-01', 'natur,blumen', 0, 230),
(13, 'Berge im Nebel', 'img13.jpg', 'Berge im Nebel Beschreibung', '2015-06-03', 'natur,berge', 0, 1345),
(14, 'Blumen auf dem Tisch', 'img14.jpg', 'Blumen auf dem Tisch Beschreibung', '2015-06-05', 'blumen', 1, 32),
(15, 'See', 'img15.jpg', 'See Beschreibung', '2015-06-05', 'natur', 1, 7),
(16, 'Strand bei Sonnenuntergang', 'img16.jpg', 'Strand bei Sonnenuntergang Beschreibung', '2015-06-05', 'natur', 0, 11),
(17, 'Vogel', 'img17.jpg', 'Vogel Beschreibung', '2015-06-07', 'tiere,voegel', 1, 8),
(18, 'Insel bei Sonnenuntergang', 'img18.jpg', 'Insel bei Sonnenuntergang Beschreibung', '2015-06-10', 'natur', 0, 98),
(19, 'Stadt bei Sonnenuntergang', 'img19.jpg', 'Stadt bei Sonnenuntergang Beschreibung', '2015-06-12', 'natur,stadt', 1, 18),
(20, 'Blumen', 'img20.jpg', 'Blumen Beschreibung', '2015-06-14', 'blumen', 1, 56),
(21, 'Haus auf der Insel', 'img21.jpg', 'Haus auf der Insel Beschreibung', '2015-06-14', 'natur', 1, 32),
(22, 'Insel bei Sonnenuntergang', 'img22.jpg', 'Insel bei Sonnenuntergang Beschreibung', '2015-06-16', 'natur', 0, 17),
(23, 'Blumen', 'img23.jpg', 'Blumen Beschreibung', '2015-06-20', 'blumen', 0, 78),
(24, 'Wald im Herbst', 'img24.jpg', 'Wald im Herbst Beschreibung', '2015-06-21', 'natur', 1, 45),
(25, 'Hündchen', 'img25.jpg', 'Hündchen Beschreibung', '2015-06-23', 'tiere', 1, 14);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `galerie`
--
ALTER TABLE `galerie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `galerie`
--
ALTER TABLE `galerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
