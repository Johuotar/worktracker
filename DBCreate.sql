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
values ('workTracker','O')
,('Tilaaja 1','T')
,('Hyvä Asiakas','T');

/*Table structure for table `henkilo` */

DROP TABLE IF EXISTS `henkilo`;

CREATE TABLE `henkilo` (
  `henkiloID` int(11) NOT NULL AUTO_INCREMENT,
  `asiakasID` int(11) NOT NULL,
  ` Etunimi` varchar(60) DEFAULT NULL,
  ` Sukunimi` varchar(60) DEFAULT NULL,
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
  `vanhentunutPvm` date DEFAULT NULL,
  `aikaleima` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kayttajaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `kayttaja` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
