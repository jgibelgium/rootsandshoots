insert into rs_stuffs (stuffid, stufftitle, projectid, memberid, stufftypeid) values(1, 'Animals.jpg', 1, 1, 1);
insert into rs_stuffs (stuffid, stufftitle, projectid, memberid, stufftypeid) values(2, 'People.doc', 1, 2, 2);
insert into rs_stuffs (stuffid, stufftitle, projectid, memberid, stufftypeid) values(3, 'Environment', 1, 1, 3);




USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `StuffInsert`;
DELIMITER //
CREATE PROCEDURE `StuffInsert`
(
	OUT pStuffId INT ,
	IN pStuffTitle VARCHAR (255) CHARACTER SET UTF8 ,
	IN pProjectId INT ,
    IN pMemberId INT,
    IN pStuffTypeId INT,
	IN pInsertedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	INSERT INTO rs_stuffs
	(
		StuffTitle,
		ProjectId,
        MemberId,
        StuffTypeId,
		InsertedBy,
		InsertedOn
	)
	VALUES
	(
		pStuffTitle,
		pProjectId,
        pMemberId,
        pStuffTypeId,
		pInsertedBy,
		NOW()
	);
	SELECT LAST_INSERT_ID() INTO pStuffId;
END //
DELIMITER ;

call Stuffinsert(@pStuffId, 'Stuff3.gif', 1, 1, 1, 'Jan');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `StuffUpdate`;
DELIMITER //
CREATE PROCEDURE `StuffUpdate`
(
	IN pStuffId INT ,
	IN pStuffTitle VARCHAR (255) CHARACTER SET UTF8 ,
	IN pProjectId INT ,
    IN pMemberId INT ,
    IN pStuffTypeId INT ,
	IN pModifiedBy VARCHAR (256) CHARACTER SET UTF8 
)
BEGIN
UPDATE rs_stuffs
SET
	StuffTitle = pStuffTitle,
	ProjectId = pProjectId,
    MemberId = pMemberId,
    StuffTypeId = pStuffTypeId,
	ModifiedBy = pModifiedBy,
	ModifiedOn = NOW()
WHERE StuffId = pStuffId;
END //
DELIMITER ;

call Stuffupdate('1', 'Stuff2.gif', 1, 1, 1, 'Jan');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `StuffDelete`;
DELIMITER //
CREATE PROCEDURE `StuffDelete`
(
	IN pId INT
)
BEGIN
DELETE FROM rs_stuffs
WHERE StuffId = pId;
END //
DELIMITER ;

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `StuffSelectAll`;
DELIMITER //
CREATE PROCEDURE `StuffSelectAll`
(
)
BEGIN
	SELECT * FROM rs_stuffs
;
END //
DELIMITER ;

call stuffselectall();

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `StuffSelectById`;
DELIMITER //
CREATE PROCEDURE `StuffSelectById`
(
	IN pStuffId INT 
)
BEGIN
	SELECT * FROM rs_stuffs WHERE StuffId = pStuffId;
END //
DELIMITER ;

call StuffSelectById(1);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `StuffSelectByProjectId`;
DELIMITER //
CREATE PROCEDURE `StuffSelectByProjectId`
(
	IN pProjectId INT 
)
BEGIN
	SELECT * FROM rs_stuffs WHERE ProjectId = pProjectId;
END //
DELIMITER ;

call StuffSelectByProjectId(1);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `StuffSelectByMemberId`;
DELIMITER //
CREATE PROCEDURE `StuffSelectByMemberId`
(
	IN pMemberId INT 
)
BEGIN
	SELECT * FROM rs_stuffs WHERE MemberId = pMemberId;
END //
DELIMITER ;

call StuffSelectByMemberId(1);

