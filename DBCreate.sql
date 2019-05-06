CREATE DATABASE worktracker /*!40100 DEFAULT CHARACTER SET utf8mb4 */	
;


CREATE TABLE worktracker.asiakas (
  asiakasID int(11) NOT NULL,
  nimi varchar(120) NOT NULL,
  tyyppi char(1) NOT NULL DEFAULT 'T',
  aikaleima datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COMMENT='tässä on asaikkaat';
/* asiakas.tyyppi: O - oma yritys, T - Tilaajan yritys */



CREATE TABLE henkilo (
  henkiloID int(11) NOT NULL AUTO_INCREMENT,
  asiakasID int(11) NOT NULL COMMENT 'viiteavain asiakas tauluun ',
  Etunimi varchar(60) DEFAULT NULL,
  Sukunimi varchar(60) DEFAULT NULL,
  PRIMARY KEY (henkiloID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4	
;


CREATE TABLE IF NOT EXISTS kayttaja (
    kayttajaID INT AUTO_INCREMENT,
    kayttajatunnus VARCHAR(255) NOT NULL,
    salasana varchar(35) not null,
    vanhentunutPvm DATE,
    aikaleima DATETIME default CURRENT_TIMESTAMP(),
    PRIMARY KEY (kayttajaID)
)  ENGINE=INNODB;






/* populointi */
INSERT INTO asiakas(nimi, tyyppi) 
VALUES ('workTracker','O'), ('Tilaaja 1','T')
;


