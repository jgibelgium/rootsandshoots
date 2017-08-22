insert into rs_projectprojecttypes (projectprojecttypeid, projectid, projecttypeid) values(1, 1, 2);
insert into rs_projectprojecttypes (projectprojecttypeid, projectid, projecttypeid) values(2, 1, 3);
insert into rs_projectprojecttypes (projectprojecttypeid, projectid, projecttypeid) values(3, 2, 6);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectProjectTypeInsert;
DELIMITER //
CREATE PROCEDURE ProjectProjectTypeInsert
(
	OUT pProjectProjectTypeId INT ,
	IN pProjectId INT ,
	IN pProjectTypeId INT ,
	IN pInsertedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	INSERT INTO rs_projectprojecttypes
	(
		ProjectId,
        ProjectTypeId,
        InsertedBy,
        InsertedOn
	)
	VALUES
	(
		pProjectId,
        pProjectTypeId,
		pInsertedBy,
		NOW()
	);
	SELECT LAST_INSERT_ID() INTO pProjectProjectTypeId;
END //
DELIMITER ;


call projectprojecttypeinsert(@projectprojecttypeid, 1, 2, 'admin');
call projectprojecttypeinsert(@projectprojecttypeid, 3, 10, 'admin');


USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectProjectTypeUpdate;
DELIMITER //
CREATE PROCEDURE ProjectProjectTypeUpdate
(
	In pProjectProjectTypeId INT ,
	IN pProjectId INT ,
	IN pProjectTypeId INT ,
	IN pModifiedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	UPDATE 	rs_projectprojecttypes
	SET 
		ProjectId = pProjectId,
        ProjectTypeId = pProjectTypeId,
		ModifiedBy = pModifiedBy,
        ModifiedOn = NOW()
	WHERE ProjectProjectTypeId = pProjectProjectTypeId;
END //
DELIMITER ;

call ProjectProjectTypeUpdate(1, 1, 1, 'admin');



/*
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS SelectProjectTypesByProjectId;
DELIMITER //
CREATE PROCEDURE SelectProjectTypesByProjectId
(
    IN pProjectId INT 
)
BEGIN
	select rs_projecttypes.ProjectType as ProjectType from
    rs_projectprojecttypes, rs_projecttypes
    where rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and rs_projectprojecttypes.projectid = pProjectId;
END //
DELIMITER ;

call SelectProjectTypesByProjectId(1); 
*/

/*find projecttypeid's of a project*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectProjectTypesSelectByProjectId;
DELIMITER //
CREATE PROCEDURE ProjectProjectTypesSelectByProjectId
(
    IN pProjectId INT 
)
BEGIN
	select * from rs_projectprojecttypes where projectid = pProjectId;
END //
DELIMITER ;

call ProjectProjectTypesSelectByProjectId(1);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectProjectTypeDelete`;
DELIMITER //
CREATE PROCEDURE `ProjectProjectTypeDelete`
(
	IN pId INT
)
BEGIN
DELETE FROM `rs_projectprojecttypes`
WHERE ProjectProjectTypeId = pId;
END //
DELIMITER ;