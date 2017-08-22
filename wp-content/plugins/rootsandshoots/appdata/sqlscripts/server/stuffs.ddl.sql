USE `rootsandshoots_europe`;
DROP TABLE IF EXISTS `rs_stuffs`;
CREATE TABLE `rs_stuffs` (
  `StuffId` INT(11) NOT NULL AUTO_INCREMENT,
  CONSTRAINT PRIMARY KEY (`StuffId`),
  `StuffTitle` VARCHAR(255) CHARACTER SET utf8 NOT NULL,
  `ProjectId` INT(11) NOT NULL,
  `MemberId` INT(11) NULL,
  `StuffTypeId` INT(11) NOT NULL,
  `InsertedBy` VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL,
  `InsertedOn` timestamp NULL DEFAULT NULL,
  `ModifiedBy` VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL,
  `ModifiedOn` timestamp NULL DEFAULT NULL,
  CONSTRAINT `fkc_projects_stuffs` FOREIGN KEY (`ProjectId`) REFERENCES `rs_projects` (`ProjectId`) ON UPDATE CASCADE,
  CONSTRAINT `fkc_members_stuffs` FOREIGN KEY (`MemberId`) REFERENCES `rs_members` (`MemberId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fkc_stufftypes_stuffs` FOREIGN KEY (`StuffTypeId`) REFERENCES `rs_stufftypes` (`StuffTypeId`) ON UPDATE CASCADE
) engine=innoDB;


  


