USE `rootsandshoots_europe`;
DROP TABLE IF EXISTS `rs_projectprojecttypes`;
CREATE TABLE `rs_projectprojecttypes` (
  `ProjectProjectTypeId` INT(11) NOT NULL AUTO_INCREMENT,
  `ProjectId` INT(11) NOT NULL,
  `ProjectTypeId` INT(11) NOT NULL,
  `InsertedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `InsertedOn` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ModifiedOn` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProjectProjectTypeId`),
  CONSTRAINT `fkc_projects_projectprojecttypes` FOREIGN KEY (`ProjectId`) REFERENCES `rs_projects` (`ProjectId`) ON UPDATE CASCADE,
  CONSTRAINT `fkc_projecttypes_projectprojecttypes` FOREIGN KEY (`ProjectTypeId`) REFERENCES `rs_projecttypes` (`ProjectTypeId`) ON UPDATE CASCADE
) engine=innoDB;

    