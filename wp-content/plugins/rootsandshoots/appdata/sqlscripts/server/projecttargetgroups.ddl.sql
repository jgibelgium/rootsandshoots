USE `rootsandshoots_europe`;
DROP TABLE IF EXISTS `rs_projecttargetgroups`;
CREATE TABLE `rs_projecttargetgroups` (
  `ProjectTargetGroupId` INT(11) NOT NULL AUTO_INCREMENT,
  `ProjectId` INT(11) NOT NULL,
  `TargetGroupId` INT(11) NOT NULL,
  `InsertedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `InsertedOn` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ModifiedOn` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProjectTargetGroupId`),
  CONSTRAINT `fkc_projects_projecttargetgroups` FOREIGN KEY (`ProjectId`) REFERENCES `rs_projects` (`ProjectId`) ON UPDATE CASCADE,
  CONSTRAINT `fkc_targetgroups_projecttargetgroups` FOREIGN KEY (`TargetGroupId`) REFERENCES `rs_targetgroups` (`TargetGroupId`) ON UPDATE CASCADE
) engine=innoDB;

    