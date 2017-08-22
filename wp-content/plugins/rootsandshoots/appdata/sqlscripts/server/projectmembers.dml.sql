insert into rs_projectmembers(projectmemberid, projectid, memberid, pending) values(1, 1, 2, 0);
insert into rs_projectmembers(projectmemberid, projectid, memberid, pending) values(2, 2, 2, 1);
insert into rs_projectmembers(projectmemberid, projectid, memberid, pending) values(3, 2, 3, 0);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectMemberInsert;
DELIMITER //
CREATE PROCEDURE ProjectMemberInsert
(
	OUT pProjectMemberId INT ,
	IN pProjectId INT ,
	IN pMemberId INT ,
	IN pPending TINYINT(1),
	IN pInsertedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	INSERT INTO rs_projectmembers
	(
		ProjectId,
        MemberId,
		Pending,
        InsertedBy,
        InsertedOn
	)
	VALUES
	(
		pProjectId,
        pMemberId,
		pPending,
		pInsertedBy,
		NOW()
	);
	SELECT LAST_INSERT_ID() INTO pProjectMemberId;
END //
DELIMITER 

call projectmemberinsert(@projectmemberid, 1, 2, 0, 'admin');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectMemberUpdate;
DELIMITER //
CREATE PROCEDURE ProjectMemberUpdate
(
	In pProjectMemberId INT ,
	IN pProjectId INT ,
	IN pMemberId INT ,
	IN pPending TINYINT(1),
	IN pModifiedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	UPDATE rs_projectmembers
	SET 
		ProjectId = pProjectId,
        MemberId = pMemberId,
		Pending = pPending,
        ModifiedBy = pModifiedBy,
        ModifiedOn = NOW()
	WHERE ProjectMemberId = pProjectMemberId;
END //
DELIMITER ;

call projectmemberupdate(1, 1, 2, 1, 'admin');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectMemberDelete`;
DELIMITER //
CREATE PROCEDURE `ProjectMemberDelete`
(
	IN pId INT
)
BEGIN
DELETE FROM `rs_projectmembers`
WHERE ProjectMemberId = pId;
END //
DELIMITER ;

call projectmemberdelete(5);

//projecten per lid selecteren
//1ste poging

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `SelectProjectsByMemberId`;
DELIMITER //
CREATE PROCEDURE `SelectProjectsByMemberId`
(
	IN pMemberId INT
)
BEGIN
SELECT rs_projects.ProjectId as ProjectId, rs_projects.ProjectTitle as ProjectTitle, rs_projects.GroupName as GroupName, rs_projects.PplEstimated as PplEstimated,
 rs_projects.Location as Location, rs_projects.Objective as Objective, rs_projects.Means as Means, rs_projects.StartDate as StartDate, rs_projects.TimeFrameId as TimeFrameId,
 rs_projects.LanguageId as LanguageId, rs_projects.CountryId as CountryId, rs_projects.ProjectStatusId as ProjectStatusId, rs_projects.HoursSpent as HoursSpent,
 rs_projects.PplParticipated as PplParticipated, rs_projects.PplServed as PplServed, rs_projects.Report as Report, rs_projects.EndDate as EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, rs_projects.ModifiedBy as ModifiedBy, rs_projects.ModifiedOn as ModifiedOn
from rs_projects, rs_projectmembers, rs_members where rs_projects.ProjectId = rs_projectmembers.ProjectId and rs_members.MemberId = rs_projectmembers.MemberId and rs_members.MemberId = pMemberId;
END //
DELIMITER ;

call SelectProjectsByMemberId(1);


/*2de poging*/
/*
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `SelectProjectsByMemberId`;
DELIMITER //
CREATE PROCEDURE `SelectProjectsByMemberId`
(
	IN pMemberId INT
)
BEGIN
SELECT * from rs_projectmembers where memberid = pMemberId;
END //
DELIMITER ;

call SelectProjectsByMemberId(2);
*/

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectMemberSelectAll`;
DELIMITER //
CREATE PROCEDURE `ProjectMemberSelectAll`
(
	
)
BEGIN
select * FROM `rs_projectmembers`;
END //
DELIMITER ;

call projectmemberselectall();