-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2011 at 11:34 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `aanmelding`
--

CREATE TABLE IF NOT EXISTS `aanmelding` (
  `studentid` int(11) NOT NULL AUTO_INCREMENT,
  `evenementid` int(11) NOT NULL,
  `aanmeldingsdatum` date NOT NULL,
  PRIMARY KEY (`studentid`,`evenementid`),
  KEY `fk_Aanmelding_Evenement1` (`evenementid`),
  KEY `fk_Aanmelding_Student1` (`studentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `aanmelding`
--


-- --------------------------------------------------------

--
-- Table structure for table `bericht`
--

CREATE TABLE IF NOT EXISTS `bericht` (
  `berichtid` int(11) NOT NULL AUTO_INCREMENT,
  `van` int(11) DEFAULT NULL,
  `onderwerp` varchar(255) DEFAULT NULL,
  `bericht` text,
  `naar` int(11) DEFAULT NULL,
  `groepid` int(11) DEFAULT NULL,
  PRIMARY KEY (`berichtid`),
  KEY `fk_bericht_student1` (`van`),
  KEY `fk_bericht_student2` (`naar`),
  KEY `fk_bericht_groep1` (`groepid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bericht`
--


-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `categorieid` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  PRIMARY KEY (`categorieid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`categorieid`, `naam`) VALUES
(6, 'Sport'),
(7, 'Gaming');

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `evenementid` int(11) NOT NULL AUTO_INCREMENT,
  `categorieid` int(11) NOT NULL,
  `naam` varchar(45) NOT NULL,
  `omschrijving` varchar(150) NOT NULL,
  `begindatum` date NOT NULL,
  `einddatum` date DEFAULT NULL,
  `isaanmeldingverplicht` varchar(45) NOT NULL,
  `organiserendeverenigingid` int(11) NOT NULL,
  PRIMARY KEY (`evenementid`),
  KEY `fk_Evenement_Categorie1` (`categorieid`),
  KEY `fk_Evenement_Vereniging1` (`organiserendeverenigingid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`evenementid`, `categorieid`, `naam`, `omschrijving`, `begindatum`, `einddatum`, `isaanmeldingverplicht`, `organiserendeverenigingid`) VALUES
(1, 7, 'Annual Nerd-Off', '', '2011-12-01', '2011-12-02', 'Ja', 11),
(2, 6, 'Koekhappen', 'Hap hier je koekjes', '2011-02-10', '2011-02-10', 'Ja', 11),
(3, 6, 'Rugby', 'Rugby', '2011-03-12', '2011-03-12', 'Nee', 13);

-- --------------------------------------------------------

--
-- Table structure for table `groep`
--

CREATE TABLE IF NOT EXISTS `groep` (
  `groepid` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL,
  `eigenaar` int(11) NOT NULL,
  PRIMARY KEY (`groepid`,`eigenaar`),
  KEY `fk_groep_student1` (`eigenaar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `groep`
--


-- --------------------------------------------------------

--
-- Table structure for table `groeplid`
--

CREATE TABLE IF NOT EXISTS `groeplid` (
  `groepid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  PRIMARY KEY (`groepid`,`studentid`),
  KEY `fk_groeplid_student1` (`studentid`),
  KEY `fk_groeplid_groep1` (`groepid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groeplid`
--


-- --------------------------------------------------------

--
-- Table structure for table `lidmaatschap`
--

CREATE TABLE IF NOT EXISTS `lidmaatschap` (
  `studentid` int(11) NOT NULL AUTO_INCREMENT,
  `verenigingid` int(11) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`studentid`,`verenigingid`),
  KEY `fk_Lidmaatschap_Vereniging` (`verenigingid`),
  KEY `fk_Lidmaatschap_Student1` (`studentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `lidmaatschap`
--

INSERT INTO `lidmaatschap` (`studentid`, `verenigingid`, `datum`) VALUES
(16, 11, '2011-10-24'),
(22, 11, '2011-10-24'),
(22, 14, '2011-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `profielbericht`
--

CREATE TABLE IF NOT EXISTS `profielbericht` (
  `profielberichtid` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `onderwerp` varchar(45) NOT NULL,
  `inhoud` text NOT NULL,
  `studentid` int(11) NOT NULL,
  PRIMARY KEY (`profielberichtid`),
  KEY `fk_Profielbericht_Student1` (`studentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `profielbericht`
--


-- --------------------------------------------------------

--
-- Table structure for table `reactie`
--

CREATE TABLE IF NOT EXISTS `reactie` (
  `reactieid` int(11) NOT NULL AUTO_INCREMENT,
  `evenementid` int(11) NOT NULL,
  `afzender` varchar(45) NOT NULL,
  `inhoud` varchar(45) NOT NULL,
  `tijdstip` date NOT NULL,
  PRIMARY KEY (`reactieid`),
  KEY `fk_Reactie_Evenement1` (`evenementid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reactie`
--


-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `studentid` int(11) NOT NULL AUTO_INCREMENT,
  `studentnr` varchar(45) NOT NULL,
  `voornaam` varchar(45) NOT NULL,
  `achternaam` varchar(45) NOT NULL,
  `adres` varchar(45) NOT NULL,
  `postcode` varchar(45) NOT NULL,
  `woonplaats` varchar(45) NOT NULL,
  `geslacht` varchar(45) NOT NULL,
  `geboortedatum` date NOT NULL,
  `profielfoto` text,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`studentid`),
  KEY `fk_student_user1` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `studentnr`, `voornaam`, `achternaam`, `adres`, `postcode`, `woonplaats`, `geslacht`, `geboortedatum`, `profielfoto`, `userid`) VALUES
(15, 's1047415', 'Kay', 'van Bree', '', '', '', 'Man', '0000-00-00', NULL, 10),
(16, 's1020304', 'Peter', 'Elgersma', '', '', '', 'Man', '0000-00-00', NULL, 12),
(17, 's1023405', 'Alex', 'Drees', '', '', '', 'Man', '0000-00-00', NULL, 13),
(18, 's1068381', 'Teun', 'Vann', '', '', '', 'Man', '0000-00-00', NULL, 14),
(19, 's2063728', 'Cornelis', 'Alberda', '', '', '', 'Man', '0000-00-00', NULL, 15),
(20, 's1086959', 'Sjors', 'Vroomen', '', '', '', 'Man', '0000-00-00', NULL, 16),
(21, 's1026579', 'Iris', 'Krantz', '', '', '', 'Man', '0000-00-00', NULL, 17),
(22, 's1029878', 'Gilberta', 'Reinder', '', '', '', 'Man', '0000-00-00', NULL, 18);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `salt` varchar(32) DEFAULT NULL,
  `activation` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `salt`, `activation`, `email`, `role`) VALUES
(10, 'mrpaplu', 'a35eb0aa53613401fce20c55ddc318a4', 'KZkipOVmjKkz7AP50aE1l86SaxpoUtol', 'OFfbzuBgIHBUnP5035lvlBseN8iIuM2H', 'mrpaplu@gmail.com', 1),
(11, 'Henk', '4eb57674112e52593dc2e3336abc1362', '1rUiVvWeQnPJEJ5GUjtbHD3udwHmYGIC', 'T1HAzZI3KI0scbX1McMqdy2k8rGa6DgX', 'henk@henker.nl', 0),
(12, 'peter', '136ca2749a3ca0c3512a543616a13032', 'HYzG4WGDl3gKLTeOznfEaGDqUvsq31gy', 'TmJQyAoLaLYVm7C7MiWO6w1CQLX5U6E3', 'peter@gmail.com', 0),
(13, 'alex', 'a243159c3faf360d1876746abe014318', 'qlGcGYp9I0bMgFMroElrtMa7yxq4vW9D', 'KwP4olO0I2PUR2bGi3T65VM6EYHSTunh', 'alex@hotmail.com', 0),
(14, 'teun', '4e4e06f64f4311374f74469a61bb4a9c', 'hA7mtDLzjbGfqtJtExJESYyWdYu99qzo', 'T2sOUZW3ENFxuiWdlWagOioKHVp6yoh1', 'teun@live.nl', 0),
(15, 'cornelis', 'd09d966ccc68d5489d31b9c455a87830', 'BwqznG8YwKGOAf6Py7Qu7s1RMTtGA5g9', 'tmDUQS7eIWOnXQUyz0MsBWoOpkaK7mwn', 'cornelis@live.nl', 0),
(16, 'sjors', 'bcf6924d1dc4093907a38a9057484ce8', 'vhzObmAo5UA8D4ArNyKYRGQoXRLPJsl7', 'ULrtJfJaDMq4z0fd19sUrDZhOEETX85R', 'sjors@sjors.nl', 0),
(17, 'iris', 'd6ad3781d63c690e1dc5a1094a821b29', '4esLTibgevyYJPjGhvqMAde8DCZ4EQ0B', 'IHfnw5wgKs9b1zufnBxYwf1kdU2ES46n', 'iris@hotmail.com', 0),
(18, 'gilberta', '4f8599a9d2334c7f2691dda8ae648032', '4GEfV1t9ikdt9ZwcuPqQws5LeAN1ZEzK', 'DJiLOlwYUkbpCM7Eq2qO9ScARTnfhRf7', 'gilberta@live.nl', 0),
(19, 'melis', '85f5424d38803ff29073a329d846e2e5', '3fi9PDFVKBqnCk8LLosjNnqwcWcgRGc8', '6qNQBCv7MFEnNcufqKO2IR4DFTfag55n', 'info@wandel.nl', 0),
(20, 'eureka', '2aa20ea5abb22f2227116061fb5a39e3', 'qGuCXgH3AnJGkILIBhTBxVLjgYebk6Dn', 'ot90h0eUJq7TM3q2BGRlqHMMue2ynF1x', 'info@eureka.nl', 0),
(21, 'buiten', 'fff9406c87a01ed16929df1e34e6a410', 'SR7nBkz5Y03NYV7gVzdaptdmO0ymam2L', 'FbuqbDU0NnXfNy7lpMxSewV2IcCGBSDR', 'info@buiten.nl', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vereniging`
--

CREATE TABLE IF NOT EXISTS `vereniging` (
  `verenigingid` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(45) NOT NULL,
  `adres` varchar(45) NOT NULL,
  `postcode` varchar(45) NOT NULL,
  `plaats` varchar(45) NOT NULL,
  `aantaleigenleden` varchar(45) DEFAULT NULL,
  `kvk` varchar(45) DEFAULT NULL,
  `telefoonnr` varchar(45) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`verenigingid`),
  KEY `fk_vereniging_user1` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `vereniging`
--

INSERT INTO `vereniging` (`verenigingid`, `naam`, `adres`, `postcode`, `plaats`, `aantaleigenleden`, `kvk`, `telefoonnr`, `userid`) VALUES
(11, 'Gumbo Millenium', 'Ergens 12', '1111IN', 'Zwolle', NULL, NULL, NULL, 11),
(12, 'Wandel Vereniging', 'Puntkroos 115', '8045PJ', 'Zwolle', NULL, NULL, '06-98746331', 19),
(13, 'Eureka', 'Assendorperplein 119', '8045LA', 'Zwolle', NULL, NULL, '06-55583823', 20),
(14, 'De Buitensocieteit', 'Stationsweg 44', '8011CZ', 'Zwolle', NULL, NULL, '06-88473829', 21);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aanmelding`
--
ALTER TABLE `aanmelding`
  ADD CONSTRAINT `fk_Aanmelding_Evenement1` FOREIGN KEY (`evenementid`) REFERENCES `evenement` (`evenementid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aanmelding_Student1` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bericht`
--
ALTER TABLE `bericht`
  ADD CONSTRAINT `fk_bericht_groep1` FOREIGN KEY (`groepid`) REFERENCES `groep` (`groepid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bericht_student1` FOREIGN KEY (`van`) REFERENCES `student` (`studentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bericht_student2` FOREIGN KEY (`naar`) REFERENCES `student` (`studentid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `fk_Evenement_Categorie1` FOREIGN KEY (`categorieid`) REFERENCES `categorie` (`categorieid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Evenement_Vereniging1` FOREIGN KEY (`organiserendeverenigingid`) REFERENCES `vereniging` (`verenigingid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `groep`
--
ALTER TABLE `groep`
  ADD CONSTRAINT `fk_groep_student1` FOREIGN KEY (`eigenaar`) REFERENCES `student` (`studentid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `groeplid`
--
ALTER TABLE `groeplid`
  ADD CONSTRAINT `fk_groeplid_groep1` FOREIGN KEY (`groepid`) REFERENCES `groep` (`groepid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_groeplid_student1` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lidmaatschap`
--
ALTER TABLE `lidmaatschap`
  ADD CONSTRAINT `fk_Lidmaatschap_Student1` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Lidmaatschap_Vereniging` FOREIGN KEY (`verenigingid`) REFERENCES `vereniging` (`verenigingid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `profielbericht`
--
ALTER TABLE `profielbericht`
  ADD CONSTRAINT `fk_Profielbericht_Student1` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reactie`
--
ALTER TABLE `reactie`
  ADD CONSTRAINT `fk_Reactie_Evenement1` FOREIGN KEY (`evenementid`) REFERENCES `evenement` (`evenementid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_user1` FOREIGN KEY (`userid`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vereniging`
--
ALTER TABLE `vereniging`
  ADD CONSTRAINT `fk_vereniging_user1` FOREIGN KEY (`userid`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
