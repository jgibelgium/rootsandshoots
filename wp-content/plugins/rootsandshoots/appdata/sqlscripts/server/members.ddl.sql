USE `rootsandshoots_europe`;
DROP TABLE IF EXISTS `rs_members`;
CREATE TABLE `rs_members` (
  `WPMemberId` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `LastName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `BirthDate` date NOT NULL,
  `Notes` text CHARACTER SET utf8 NOT NULL,
  `CountryId` int(11) NOT NULL,
  `LanguageId` int(11) NOT NULL,
  `InsertedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `InsertedOn` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ModifiedOn` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`MemberId`),
  UNIQUE KEY `uc_WPMemberId` (`WPMemberId`),
  CONSTRAINT `fkc_members_languages` FOREIGN KEY (`LanguageId`) REFERENCES `rs_languages` (`LanguageId`) ON UPDATE CASCADE,
  CONSTRAINT `fkc_members_roles` FOREIGN KEY (`RoleId`) REFERENCES `rs_roles` (`RoleId`) ON UPDATE CASCADE,
  CONSTRAINT `fkc_members_countries` FOREIGN KEY (`CountryId`) REFERENCES `rs_countries` (`CountryId`) ON UPDATE CASCADE
) engine=innoDB;

/*BOOL type wordt in mySQL omgezet in TINYINT(1)*/
