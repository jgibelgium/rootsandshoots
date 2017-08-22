USE `rootsandshoots_europe`;
DROP TABLE IF EXISTS `rs_projecttypes`;
CREATE TABLE `rs_projecttypes` (
	`ProjectTypeId` INT NOT NULL AUTO_INCREMENT,
	CONSTRAINT PRIMARY KEY(ProjectTypeId),
	`ProjectType` VARCHAR (255) CHARACTER SET UTF8 NOT NULL,
    `ProjectTypeInfo` VARCHAR (255) CHARACTER SET UTF8 NULL
) engine=innoDB;






