USE `rootsandshoots_europe`;
DROP TABLE IF EXISTS `rs_projectmembers`;
CREATE TABLE `rs_projectmembers` (
  `ProjectMemberId` INT(11) NOT NULL AUTO_INCREMENT,
  `ProjectId` INT(11) NOT NULL,
  `MemberId` INT(11) NULL,
  `Pending` TINYINT(1) NOT NULL,
  `InsertedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `InsertedOn` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ModifiedOn` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProjectMemberId`),
  CONSTRAINT `fkc_projects_projectmembers` FOREIGN KEY (`ProjectId`) REFERENCES `rs_projects` (`ProjectId`) ON UPDATE CASCADE,
  CONSTRAINT `fkc_members_projectmembers` FOREIGN KEY (`MemberId`) REFERENCES `rs_members` (`MemberId`) ON DELETE SET NULL ON UPDATE CASCADE
) engine=innoDB;

    