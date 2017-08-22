insert into rs_projecttargetgroups (projecttargetgroupid, projectid, targetgroupid) values(1, 1, 1);
insert into rs_projecttargetgroups (projecttargetgroupid, projectid, targetgroupid) values(2, 1, 4);
insert into rs_projecttargetgroups (projecttargetgroupid, projectid, targetgroupid) values(3, 1, 2);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectTargetGroupInsert;
DELIMITER //
CREATE PROCEDURE ProjectTargetGroupInsert
(
	OUT pProjectTargetGroupId INT ,
	IN pProjectId INT ,
	IN pTargetGroupId INT ,
	IN pInsertedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	INSERT INTO rs_projecttargetgroups
	(
		ProjectId,
        TargetGroupId,
        InsertedBy,
        InsertedOn
	)
	VALUES
	(
		pProjectId,
        pTargetGroupId,
		pInsertedBy,
		NOW()
	);
	SELECT LAST_INSERT_ID() INTO pProjectTargetGroupId;
END //
DELIMITER ;


call projecttargetgroupinsert(@projecttargetgroupid, 1, 2, 'admin');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectTargetGroupUpdate;
DELIMITER //
CREATE PROCEDURE ProjectTargetGroupUpdate
(
	In pProjectTargetGroupId INT ,
	IN pProjectId INT ,
	IN pTargetGroupId INT ,
	IN pModifiedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	UPDATE 	rs_projecttargetgroups
	SET 
		ProjectId = pProjectId,
        TargetGroupId = pTargetGroupId,
		ModifiedBy = pModifiedBy,
        ModifiedOn = NOW()
	WHERE ProjectTargetGroupId = pProjectTargetGroupId;
END //
DELIMITER ;

call ProjectTargetGroupUpdate(1, 1, 1, 'admin');



/*find targetgroupid's of a project*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS SelectTargetGroupsByProjectId;
DELIMITER //
CREATE PROCEDURE SelectTargetGroupsByProjectId
(
    IN pProjectId INT 
)
BEGIN
	select rs_targetgroups.TargetGroup as TargetGroup from
    rs_projecttargetgroups, rs_targetgroups
    where rs_targetgroups.targetgroupid = rs_projecttargetgroups.targetgroupid and rs_projecttargetgroups.projectid = pProjectId;
END //
DELIMITER ;

call SelectTargetGroupsByProjectId(1); 

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectTargetGroupsSelectByProjectId;
DELIMITER //
CREATE PROCEDURE ProjectTargetGroupsSelectByProjectId
(
    IN pProjectId INT 
)
BEGIN
	select * from rs_projecttargetgroups where projectid = pProjectId;
END //
DELIMITER ;

call ProjectTargetGroupsSelectByProjectId(1);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectTargetGroupDelete`;
DELIMITER //
CREATE PROCEDURE `ProjectTargetGroupDelete`
(
	IN pId INT
)
BEGIN
DELETE FROM `rs_projecttargetgroups`
WHERE ProjectTargetGroupId = pId;
END //
DELIMITER ;