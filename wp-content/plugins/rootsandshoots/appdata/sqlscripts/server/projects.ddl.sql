USE `rootsandshoots_europe`;
DROP TABLE IF EXISTS `rs_projects`;
CREATE TABLE `rs_projects` (
	`ProjectId` INT NOT NULL AUTO_INCREMENT,
	 CONSTRAINT PRIMARY KEY(ProjectId),
	`ProjectTitle` VARCHAR (255) CHARACTER SET UTF8 NOT NULL,
	`GroupName` VARCHAR (255) CHARACTER SET UTF8 NULL,
    `PplEstimated` INT(11) NULL,
    `Location` VARCHAR (255) CHARACTER SET UTF8 NULL,
    `Objective` TEXT CHARACTER SET UTF8 NOT NULL,
    `Means` TEXT CHARACTER SET UTF8 NULL,
	`StartDate` DATE NULL,
	`TimeFrameId` INT(11) NOT NULL,
	`LanguageId` INT(11) NOT NULL,
    `CountryId` INT(11) NOT NULL,
    `ProjectStatusId` INT(11) NOT NULL,
    `HoursSpent` INT(11) NULL,
    `PplParticipated` INT(11) NULL,
    `PplServed` INT(11) NULL,
    `Report` TEXT CHARACTER SET UTF8 NULL,
    `EndDate` DATE NULL,
	`InsertedBy` VARCHAR (255) CHARACTER SET UTF8 NULL,
	`InsertedOn` TIMESTAMP NULL,
	`ModifiedBy` VARCHAR (255) CHARACTER SET UTF8 NULL,
	`ModifiedOn` TIMESTAMP NULL,
	CONSTRAINT `fkc_projects_timeframes` FOREIGN KEY (`TimeFrameId`) REFERENCES `rs_timeframes` (`TimeFrameId`) ON UPDATE CASCADE,
	CONSTRAINT `fkc_projects_languages` FOREIGN KEY (`LanguageId`) REFERENCES `rs_languages` (`LanguageId`) ON UPDATE CASCADE,
    CONSTRAINT `fkc_projects_countries` FOREIGN KEY (`CountryId`) REFERENCES `rs_countries` (`CountryId`) ON UPDATE CASCADE,
    CONSTRAINT `fkc_projects_projectstatuses` FOREIGN KEY (`ProjectStatusId`) REFERENCES `rs_projectstatuses` (`ProjectStatusId`) ON UPDATE CASCADE
    ) engine=innoDB;






