/*inserting data via phpmyadmin does not provide the same encoding as with a pdo object. This becomes clear with French characters.*/

insert into `rs_projects` (ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId,
    ProjectStatusId, HoursSpent, PplParticipated, PplServed, Report, EndDate, InsertedBy, InsertedOn, ModifiedBy, ModifiedOn) 
    values(1, 'Happy seeds for happy needs', 'Freinetschool', NULL, 'Mechelen', 'Planting seed bombs in and around the school to increase wild flowers for the pollinators',
    NULL, '2016-10-10', 5, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'admin', NOW(), NULL, NULL);

insert into `rs_projects` (ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId,
    ProjectStatusId, HoursSpent, PplParticipated, PplServed, Report, EndDate, InsertedBy, InsertedOn, ModifiedBy, ModifiedOn) 
    values(2, 'Friday the 13th challenge', 'Roots & Shoots STJ', NULL, 'Aalst', 'Have people do small environmental changes on every friday the 13th',
    NULL, '2016-07-10', 6, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'admin', NOW(), NULL, NULL);

insert into `rs_projects` (ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId,
    ProjectStatusId, HoursSpent, PplParticipated, PplServed, Report, EndDate, InsertedBy, InsertedOn, ModifiedBy, ModifiedOn) 
    values(3, 'Propreté et tri des déchets aux Collège', 'Roots & Shoots CSCG', NULL, 'Ganshoren', 'Clean-up and recycling project for the whole school',
    NULL, '2015-01-20', 5, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, 'admin', NOW(), NULL, NULL);





USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectInsert`;
DELIMITER //
CREATE PROCEDURE `ProjectInsert`
(
	OUT pProjectId INT ,
	IN pProjectTitle VARCHAR (255) CHARACTER SET UTF8 ,
	IN pGroupName VARCHAR (255) CHARACTER SET UTF8 ,
    IN pPplEstimated INT,
    IN pLocation VARCHAR (255) CHARACTER SET UTF8 ,
    IN pObjective TEXT CHARACTER SET UTF8 ,
    IN pMeans TEXT CHARACTER SET UTF8 ,
    IN pStartDate DATE ,
    IN pTimeFrameId INT,
    IN pLanguageId INT ,
    IN pCountryId INT ,
    IN pProjectStatusId INT,
    IN pHoursSpent INT ,
    IN pPplParticipated INT,
    IN pPplServed INT,
    IN pReport TEXT CHARACTER SET UTF8 ,
	IN pEndDate DATE ,
	IN pInsertedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	INSERT INTO rs_projects
	(
		ProjectTitle,
	    GroupName, 
        PplEstimated,
        Location,
        Objective,
        Means,
        StartDate,
        TimeFrameId,
        LanguageId,
        CountryId,
        ProjectStatusId,
        HoursSpent,
        PplParticipated,
        PplServed,
        Report,
	    EndDate,
	    InsertedBy, 
		InsertedOn
	)
	VALUES
	(
		pProjectTitle,
	    pGroupName,
        pPplEstimated,
        pLocation,
        pObjective,
        pMeans,
        pStartDate,
        pTimeFrameId,
        pLanguageId,
        pCountryId,
        pProjectStatusId,
        pHoursSpent,
        pPplParticipated,
        pPplServed,
        pReport,
	    pEndDate,
	    pInsertedBy, 
		NOW()
	);
	SELECT LAST_INSERT_ID() INTO pProjectId;
END //
DELIMITER ;

call ProjectInsert(@pProjectId, 'éliminer déchêts', 'Nettoyage sans frontières', 20, 'Louvain-la-neuve', '1ha ', 'Manuelement', '2016-10-10', 1, 1, 1, 1, NULL, NULL, NULL, NULL, '2016-10-10', 'admin'); 
call ProjectInsert(@pProjectId, 'éliminer déchêts', NULL, NULL, NULL, '1ha ', NULL, '2016-10-10', 1, 1, 1, 1, NULL, NULL, NULL, NULL, '2016-10-10', 'admin'); 

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectUpdate`;
DELIMITER //
CREATE PROCEDURE `ProjectUpdate`
(
	IN pProjectId INT ,
	IN pProjectTitle VARCHAR (255) CHARACTER SET UTF8 ,
	IN pGroupName VARCHAR (255) CHARACTER SET UTF8 ,
    IN pPplEstimated INT,
    IN pLocation VARCHAR (255) CHARACTER SET UTF8 ,
    IN pObjective TEXT CHARACTER SET UTF8 ,
    IN pMeans TEXT CHARACTER SET UTF8 ,
    IN pStartDate DATE ,
    IN pTimeFrameId INT,
    IN pLanguageId INT ,
    IN pCountryId INT ,
    IN pProjectStatusId INT,
    IN pHoursSpent INT ,
    IN pPplParticipated INT,
    IN pPplServed INT,
    IN pReport TEXT CHARACTER SET UTF8 ,
	IN pEndDate DATE ,
	IN pModifiedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
UPDATE `rs_projects`
SET
	ProjectTitle = pProjectTitle,
	GroupName = pGroupName, 
    PplEstimated = pPplEstimated,
    Location = pLocation,
    Objective = pObjective,
    Means = pMeans,
    StartDate = pStartDate,
    TimeFrameId = pTimeFrameId,
    LanguageId = pLanguageId,
    CountryId = pCountryId,
    ProjectStatusId = pProjectStatusId,
    HoursSpent = pHoursSpent,
    PplParticipated = pPplParticipated,
    PplServed = pPplServed,
    Report = pReport,
	EndDate = pEndDate,
	ModifiedBy = pModifiedBy, 
	ModifiedOn = NOW()
WHERE ProjectId = pProjectId;
END //
DELIMITER ;

call ProjectUpdate(1, 'Wilgen planten', 'De Boomplanters', 20, 'Sint-Truiden', '1ha ', 'Manueel', '2016-10-10', 1, 1, 1, 1, 8, NULL, NULL, 'Good working', '2016-10-10', 'admin'); 
call ProjectUpdate(1, 'Beek opkuisen', NULL, 20, 'Veurne', '2 km lang ', 'Met cano', '2014-02-10', 1, 1, 1, 1, 8, NULL, NULL, 'Good working', '2016-10-10', 'admin'); 

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectDelete`;
DELIMITER //
CREATE PROCEDURE `ProjectDelete`
(
	IN pId INT
)
BEGIN
DELETE FROM `rs_projects`
WHERE ProjectId = pId;
END //
DELIMITER ;



USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectSelectAll`;
DELIMITER //
CREATE PROCEDURE `ProjectSelectAll`
(
)
BEGIN
	SELECT * FROM rs_projects;
END //
DELIMITER ;

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectSelectById`;
DELIMITER //
CREATE PROCEDURE `ProjectSelectById`
(
	IN pProjectId INT 
)
BEGIN
	SELECT * FROM rs_projects WHERE ProjectId = pProjectId;
END //
DELIMITER ;

call ProjectSelectById(2);

/*projecten selecteren van één projecttype*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `SelectProjectsByProjectTypeId`;
DELIMITER //
CREATE PROCEDURE SelectProjectsByProjectTypeId
(
	IN pProjectTypeId INT 
)
BEGIN
	SELECT * FROM rs_projects, rs_projectprojecttypes WHERE rs_projects.ProjectId = rs_projectprojecttypes.ProjectId and projecttypeid = pProjectTypeId;
END //
DELIMITER ;

call SelectProjectsByProjectTypeId(1); 

/*projecten selecteren van één lid*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `SelectProjectsByMemberId`;
DELIMITER //
CREATE PROCEDURE SelectProjectsByMemberId
(
	IN pMemberId INT 
)
BEGIN
	SELECT * FROM rs_projects, rs_projectmembers WHERE rs_projects.ProjectId = rs_projectmembers.ProjectId and projectmemberid = pMemberId;
END //
DELIMITER ;

call SelectProjectsByMemberId(1); 

/*projecten selecteren van één land*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectSelectByCountryId`;
DELIMITER //
CREATE PROCEDURE `ProjectSelectByCountryId`
(
	IN pCountryId INT 
)
BEGIN
	SELECT * FROM rs_projects WHERE CountryId = pCountryId;
END //
DELIMITER ;

call ProjectSelectByCountryId(2);

/*projecten selecteren van één taal*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectSelectByLanguageId`;
DELIMITER //
CREATE PROCEDURE `ProjectSelectByLanguageId`
(
	IN pLanguageId INT 
)
BEGIN
	SELECT * FROM rs_projects WHERE LanguageId = pLanguageId;
END //
DELIMITER ;

call ProjectSelectByLanguageId(2);

/*projecten selecteren op basis van een keyword*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectSelectByKeyWord`;
DELIMITER //
CREATE PROCEDURE `ProjectSelectByKeyWord`
(
	IN pKeyWord VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
  SELECT ProjectTitle,
	    GroupName, 
        PplEstimated,
        Location,
        Objective,
        Means,
        StartDate,
        TimeFrameId,
        LanguageId,
        CountryId,
        ProjectStatusId,
        HoursSpent,
        PplParticipated,
        PplServed,
        Report,
	    EndDate,
	    rs_projects.InsertedBy as InsertedBy, 
		rs_projects.InsertedOn as InsertedOn
        FROM rs_projects WHERE ProjectTitle like CONCAT('%', pKeyWord,'%');
END //
DELIMITER ;  

call ProjectSelectByKeyWord('ee');

/*projecten selecteren op basis van een key, land, taal, projecttype*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectFilter1`;
DELIMITER //
CREATE PROCEDURE `ProjectFilter1`
(
   IN pLanguageId INT,
   IN pCountryId INT,
   IN pProjectTypeId INT,
   IN pTitle VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
if ((pLanguageId is NULL) AND (pCountryId is NULL) AND (pProjectTypeId is NULL) AND (pTitle is not NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pProjectTypeId is NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and LanguageId = pLanguageId;

elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pProjectTypeId is NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and CountryId = pCountryId;

elseif ((pLanguageId is NULL) AND (pCountryId is NULL) AND (pProjectTypeId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and rs_projecttypes.ProjectTypeId = pProjectTypeId;

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pProjectTypeId is NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and LanguageId = pLanguageId and ProjectTitle like CONCAT('%', pTitle,'%');


elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pProjectTypeId is NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and CountryId = pCountryId and ProjectTitle like CONCAT('%', pTitle,'%');


elseif ((pLanguageId is NOT NULL) AND (pCountryId is NOT NULL) AND (pProjectTypeId is NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and CountryId = pCountryId and LanguageId = pLanguageId;


elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pProjectTypeId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and rs_projecttypes.ProjectTypeId = pProjectTypeId and LanguageId = pLanguageId;

elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pProjectTypeId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and CountryId = pCountryId and rs_projecttypes.ProjectTypeId = pProjectTypeId;

elseif ((pLanguageId is NULL) AND (pCountryId is NULL) AND (pProjectTypeId is NOT NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and rs_projecttypes.ProjectTypeId = pProjectTypeId and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NOT NULL) AND (pProjectTypeId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and LanguageId = pLanguageId and CountryId = pCountryId and rs_projecttypes.ProjectTypeId = pProjectTypeId;

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NOT NULL) AND (pProjectTypeId is NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and LanguageId = pLanguageId and CountryId = pCountryId and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pProjectTypeId is NOT NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and LanguageId = pLanguageId and rs_projecttypes.ProjectTypeId = pProjectTypeId and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pProjectTypeId is NOT NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and CountryId = pCountryId and rs_projecttypes.ProjectTypeId = pProjectTypeId and ProjectTitle like CONCAT('%', pTitle,'%');

else
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_projecttypes.projecttype as ProjectType FROM rs_projects, rs_projectprojecttypes, rs_projecttypes WHERE 
        rs_projects.projectid = rs_projectprojecttypes.projectid and rs_projecttypes.projecttypeid = rs_projectprojecttypes.projecttypeid and ProjectTitle like CONCAT('%', pTitle,'%') and LanguageId = pLanguageId and CountryId = pCountryId and rs_projecttypes.ProjectTypeId = pProjectTypeId;

end if;
END //
DELIMITER ;
/*elseif in één woord is de juiste mySQL syntax alhoewel niet blauw opkleurend in Webmatrix*/

call projectfilter1(NULL, NULL, NULL, 'op');
call projectfilter1(NULL, NULL, 1, NULL);
call projectfilter1(NULL, 1, NULL, NULL);
call projectfilter1(1, NULL, NULL, NULL);

call projectfilter1(NULL, NULL, 1, 'op');
call projectfilter1(NULL, 1, NULL, 'op');
call projectfilter1(1, NULL, NULL, 'op');

call projectfilter1(NULL, 1, 1, NULL);
call projectfilter1(1, NULL, 1, NULL);
call projectfilter1(1, 1, NULL, NULL);

call projectfilter1(NULL, 1, 1, 'op');
call projectfilter1(1, NULL, 1, 'op');
call projectfilter1(1, 1, NULL, 'op');
call projectfilter1(1, 1, 1, NULL);

call projectfilter1(1, 1, 1, 'op');




/*projecten selecteren op basis van een key, land, taal, targetgroup*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectFilter2`;
DELIMITER //
CREATE PROCEDURE `ProjectFilter2`
(
   IN pLanguageId INT,
   IN pCountryId INT,
   IN pTargetGroupId INT,
   IN pTitle VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
if ((pLanguageId is NULL) AND (pCountryId is NULL) AND (pTargetGroupId is NULL) AND (pTitle is not NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pTargetGroupId is NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and LanguageId = pLanguageId;

elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pTargetGroupId is NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and CountryId = pCountryId;

elseif ((pLanguageId is NULL) AND (pCountryId is NULL) AND (pTargetGroupId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and rs_targetgroups.TargetGroupId = pTargetGroupId;

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pTargetGroupId is NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and LanguageId = pLanguageId and ProjectTitle like CONCAT('%', pTitle,'%');


elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pTargetGroupId is NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and CountryId = pCountryId and ProjectTitle like CONCAT('%', pTitle,'%');


elseif ((pLanguageId is NOT NULL) AND (pCountryId is NOT NULL) AND (pTargetGroupId is NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and CountryId = pCountryId and LanguageId = pLanguageId;


elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pTargetGroupId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and rs_targetgroups.TargetGroupId = pTargetGroupId and LanguageId = pLanguageId;

elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pTargetGroupId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and CountryId = pCountryId and rs_targetgroups.TargetGroupId = pTargetGroupId;

elseif ((pLanguageId is NULL) AND (pCountryId is NULL) AND (pTargetGroupId is NOT NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and rs_targetgroups.TargetGroupId = pTargetGroupId and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NOT NULL) AND (pTargetGroupId is NOT NULL) AND (pTitle is NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and LanguageId = pLanguageId and CountryId = pCountryId and rs_targetgroups.TargetGroupId = pTargetGroupId;

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NOT NULL) AND (pTargetGroupId is NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.targetgroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and LanguageId = pLanguageId and CountryId = pCountryId and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NOT NULL) AND (pCountryId is NULL) AND (pTargetGroupId is NOT NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.TargetGroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and LanguageId = pLanguageId and rs_targetgroups.TargetGroupId = pTargetGroupId and ProjectTitle like CONCAT('%', pTitle,'%');

elseif ((pLanguageId is NULL) AND (pCountryId is NOT NULL) AND (pTargetGroupId is NOT NULL) AND (pTitle is NOT NULL)) then 
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.TargetGroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and CountryId = pCountryId and rs_targetgroups.TargetGroupId = pTargetGroupId and ProjectTitle like CONCAT('%', pTitle,'%');

else
SELECT rs_projects.ProjectId as ProjectId, ProjectTitle, GroupName, PplEstimated, Location, Objective, Means, StartDate, TimeFrameId, LanguageId, CountryId, ProjectStatusId,
        HoursSpent, PplParticipated, PplServed, Report, EndDate, rs_projects.InsertedBy as InsertedBy, rs_projects.InsertedOn as InsertedOn, 
        rs_targetgroups.TargetGroup as TargetGroup FROM rs_projects, rs_projecttargetgroups, rs_targetgroups WHERE 
        rs_projects.projectid = rs_projecttargetgroups.projectid and rs_targetgroups.TargetGroupId = rs_projecttargetgroups.TargetGroupId and ProjectTitle like CONCAT('%', pTitle,'%') and LanguageId = pLanguageId and CountryId = pCountryId and rs_targetgroups.TargetGroupId = pTargetGroupId;

end if;
END //
DELIMITER ;
/*elseif in één woord is de juiste mySQL syntax alhoewel niet blauw opkleurend in Webmatrix*/

call projectfilter2(NULL, NULL, NULL, 'op');
call projectfilter2(NULL, NULL, 1, NULL);
call projectfilter2(NULL, 1, NULL, NULL);
call projectfilter2(1, NULL, NULL, NULL);

call projectfilter2(NULL, NULL, 1, 'op');
call projectfilter2(NULL, 1, NULL, 'op');
call projectfilter2(1, NULL, NULL, 'op');

call projectfilter2(NULL, 1, 1, NULL);
call projectfilter2(1, NULL, 1, NULL);
call projectfilter2(1, 1, NULL, NULL);

call projectfilter2(NULL, 1, 1, 'op');
call projectfilter2(1, NULL, 1, 'op');
call projectfilter2(1, 1, NULL, 'op');
call projectfilter2(1, 1, 1, NULL);

call projectfilter2(1, 1, 1, 'op');
