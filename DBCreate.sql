/*
SQLyog Community v10.51 
MySQL - 5.5.27 : Database - worktracker
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS `worktracker`;


CREATE DATABASE /*!32312 IF NOT EXISTS*/`worktracker` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `worktracker`;

/*Table structure for table `asiakas` */

DROP TABLE IF EXISTS `asiakas`;

CREATE TABLE `asiakas` (
  `asiakasID` int(11) NOT NULL AUTO_INCREMENT,
  `nimi` varchar(120) NOT NULL,
  `tyyppi` char(1) NOT NULL DEFAULT 'T' COMMENT 'O - oma yritys, T - Tilaajan yritys',
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`asiakasID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='tässä on asaikkaat';

/*Data for the table `asiakas` */

insert  into `asiakas`(`nimi`,`tyyppi`) 
values ('worktracker','O')
,('Tilaaja 1','T')
,('Hyvä Asiakas','T');

/*Table structure for table `henkilo` */

DROP TABLE IF EXISTS `henkilo`;

CREATE TABLE `henkilo` (
  `henkiloID` int(11) NOT NULL AUTO_INCREMENT,
  `asiakasID` int(11) NOT NULL,
  `Etunimi` varchar(60) DEFAULT NULL,
  `Sukunimi` varchar(60) DEFAULT NULL,
  `sposti` varchar(255) NOT NULL,
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`henkiloID`),
  KEY `fk_asiakas` (`asiakasID`),
  CONSTRAINT `fk_asiakas` FOREIGN KEY (`asiakasID`) REFERENCES `asiakas` (`asiakasID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `henkilo` */

/*Table structure for table `kayttaja` */
DROP TABLE IF EXISTS `kayttaja`;

CREATE TABLE `kayttaja` (
  `kayttajaID` int(11) NOT NULL AUTO_INCREMENT,
  `kayttajatunnus` varchar(255) NOT NULL,
  `salasana` varchar(55) NOT NULL,
  `vanhentunutPvm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'lisätään tähän päivään yksi vuosi eteenpäin',
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kayttajaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `kayttaja` */



DROP TABLE IF EXISTS `rooli`;

CREATE TABLE `rooli` (
  `rooliID` int(11) NOT NULL AUTO_INCREMENT,
  `rooli` varchar(80) DEFAULT NULL COMMENT 'Projektipäällikkö, Työntekijä, Asiakas',
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rooliID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


/*Data for the table `rooli` */

insert  into `rooli`(`rooli`) 
values ('Projektipäällikkö')
,('Työntekijä')
,('Asiakas');


/*Table structure for table `henkilonRooli` */

DROP TABLE IF EXISTS `henkilonRooli`;

CREATE TABLE `henkilonRooli` (
  `henkilonRooliID` int(11) NOT NULL AUTO_INCREMENT,
  `henkiloID` int(11) NOT NULL,
  `asiakasID` int(11) NOT NULL,
  `rooliID` int(11) NOT NULL,
  `alkuPvm` date DEFAULT NULL COMMENT 'Henkilön roolin alkupäivä',
  `loppuPvm` date DEFAULT NULL COMMENT 'Henkilön roolin loppupäivä',
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`henkilonRooliID`),
  KEY `fk_hr_henkilo` (`henkiloID`),
  CONSTRAINT `fk_hr_henkilo` FOREIGN KEY (`henkiloID`) REFERENCES `henkilo` (`henkiloID`),
  KEY `fk_hr_asiakas` (`asiakasID`),
  CONSTRAINT `fk_hr_asiakas` FOREIGN KEY (`asiakasID`) REFERENCES `asiakas` (`asiakasID`),
  KEY `fk_hr_rooli` (`rooliID`),
  CONSTRAINT `fk_hr_rooli` FOREIGN KEY (`rooliID`) REFERENCES `rooli` (`rooliID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `henkilonRooli` */


/*Table structure for table `projekti` */

DROP TABLE IF EXISTS `projekti`;

CREATE TABLE `projekti` (
  `projektiID` int(11) NOT NULL AUTO_INCREMENT,
  `asiakasID` int(11) NOT NULL,
  `henkiloID` int(11) NOT NULL COMMENT 'Asiakkaan projektin vastuuhenkilö, Projektipäällikkö',
  `projekti` varchar(200) not null COMMENT 'Projektin otsikko, nimi', 
  `alkuPvm` date DEFAULT NULL COMMENT 'Projektin alkupäivä',
  `loppuPvm` date DEFAULT NULL COMMENT 'Projektin loppupäivä',
  `arkistointiPvm` date DEFAULT NULL COMMENT 'Projektin arkistointi, passivointi päivä, eli ei aktiivinen',
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`projektiID`),
  KEY `fk_pr_asiakas` (`asiakasID`),
  CONSTRAINT `fk_pr_asiakas` FOREIGN KEY (`asiakasID`) REFERENCES `asiakas` (`asiakasID`),
  KEY `fk_pr_henkilo` (`henkiloID`),
  CONSTRAINT `fk_pr_henkilo` FOREIGN KEY (`henkiloID`) REFERENCES `henkilo` (`henkiloID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `projekti` */


/*Table structure for table `projektinTehtava` */

DROP TABLE IF EXISTS `projektinTehtava`;

CREATE TABLE `projektinTehtava` (
  `projektinTehtavaID` int(11) NOT NULL AUTO_INCREMENT,
  `asiakasID` int(11) NOT NULL,
  `projektiID` int(11) NOT NULL,
  `henkiloID` int(11) NOT NULL COMMENT 'Asiakkaan projektin vastuuhenkilö, Työntekija, suorittaja',
  `tehtava` varchar(350) not null COMMENT 'Projektin tehtävä', 
  `alkuPvm` date DEFAULT NULL COMMENT 'Projektin alkupäivä',
  `loppuPvm` date DEFAULT NULL COMMENT 'Projektin loppupäivä',
  `tehtavanStatus` varchar(35) not null DEFAULT 'Uusi' COMMENT 'Projektin tehtävän status, työntekijän tai projektin johtajan asettama. Uusi, Työn alla, Valmis, Ongelma, Palautettu', 
  `hyvaksymisPvm` date DEFAULT NULL COMMENT 'Projektin tehtävän hyväksymis päivä, projektijohtajan asettama',
  `arkistointiPvm` date DEFAULT NULL COMMENT 'Projektin arkistointi, passivointi päivä, eli ei aktiivinen',
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`projektinTehtavaID`),
  KEY `fk_prt_asiakas` (`asiakasID`),
  CONSTRAINT `fk_prt_asiakas` FOREIGN KEY (`asiakasID`) REFERENCES `asiakas` (`asiakasID`),
  KEY `fk_prt_projekti` (`projektiID`),
  CONSTRAINT `fk_prt_projekti` FOREIGN KEY (`projektiID`) REFERENCES `projekti` (`projektiID`),
  KEY `fk_prt_henkilo` (`henkiloID`),
  CONSTRAINT `fk_prt_henkilo` FOREIGN KEY (`henkiloID`) REFERENCES `henkilo` (`henkiloID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `projektinTehtava` */



/*Table structure for table `projektinTehtavanKommentti` */

DROP TABLE IF EXISTS `projektinTehtavanKommentti`;

CREATE TABLE `projektinTehtavanKommentti` (
  `projektinTehtavanKommenttiID` int(11) NOT NULL AUTO_INCREMENT,
  `projektinTehtavaID` int(11) NOT NULL,
  `asiakasID` int(11) NOT NULL,
  `henkiloID` int(11) NOT NULL COMMENT 'Asiakkaan projektin vastuuhenkilö, Työntekija, suorittaja',
  `kommentti` varchar(2500) null COMMENT 'Projektin tehtävän kommentti', 
  `tehtavanStatus` varchar(35) not null COMMENT 'kopioidaan Projektin tehtävän status kentästä', 
  `kommenttiPvm` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Projektin tehtävän kommentin aika',
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`projektinTehtavanKommenttiID`),

  KEY `fk_prtk_projekti` (`projektinTehtavaID`),
  CONSTRAINT `fk_prtk_projekti` FOREIGN KEY (`projektinTehtavaID`) REFERENCES `projektinTehtava` (`projektinTehtavaID`),

  KEY `fk_prtk_asiakas` (`asiakasID`),
  CONSTRAINT `fk_prtk_asiakas` FOREIGN KEY (`asiakasID`) REFERENCES `asiakas` (`asiakasID`),

  KEY `fk_prtk_henkilo` (`henkiloID`),
  CONSTRAINT `fk_prtk_henkilo` FOREIGN KEY (`henkiloID`) REFERENCES `henkilo` (`henkiloID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `projektinTehtavanKommentti` */



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
