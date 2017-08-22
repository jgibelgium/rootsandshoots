insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(1, 'Air', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(2, 'Beautification', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(3, 'Climate actions', 'Comes from JGIE' );
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(4, 'Energy', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(5, 'Food and Health', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(6, 'Human Community and Human Condition', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(7, 'Landscapes, Trees and Plants', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(8, 'Peace', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(9, 'Pets and Domestic Animals', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(10, 'Reduce, Reuse, Recycle', 'Comes from JGIE');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(11, 'Sustainable development goals', 'Comes from JGIE');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(12, 'Water', 'Inspired by US');
insert into rs_projecttypes (projecttypeid, projecttype, projecttypeinfo) values(13, 'Wildlife', 'Inspired by US');





USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectTypeInsert`;
DELIMITER //
CREATE PROCEDURE `ProjectTypeInsert`
(
	OUT pProjectTypeId INT ,
	IN pProjectType VARCHAR (255) CHARACTER SET UTF8,
    IN pProjectTypeInfo VARCHAR (255) CHARACTER SET UTF8
)
BEGIN
	INSERT INTO rs_projecttypes
	(
		ProjectType, ProjectTypeInfo
	)
	VALUES
	(
		pProjectType, pProjectTypeInfo
	);
	SELECT LAST_INSERT_ID() INTO pProjectTypeId;
END //
DELIMITER ;

call ProjectTypeInsert(@pProjectTypeId, 'Test type', 'Comes from JGIE');


USE rootsandshoots_europe ;
DROP PROCEDURE IF EXISTS `ProjectTypeUpdate`;
DELIMITER //
CREATE PROCEDURE `ProjectTypeUpdate`
(
	IN pProjectTypeId INT ,
	IN pProjectType VARCHAR (255) CHARACTER SET UTF8,
    IN pProjectTypeInfo VARCHAR (255) CHARACTER SET UTF8  
)
BEGIN
UPDATE rs_projecttypes
SET
	ProjectType = pProjectType,
    ProjectTypeInfo = pProjectTypeInfo
WHERE ProjectTypeId = pProjectTypeId;
END //
DELIMITER ;

call ProjectTypeUpdate(14,'test type', 'Comes from JGIE');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectTypeDelete`;
DELIMITER //
CREATE PROCEDURE `ProjectTypeDelete`
(
	IN pProjectTypeId INT
)
BEGIN
DELETE FROM rs_projecttypes
WHERE ProjectTypeId = pProjectTypeId;
END //
DELIMITER ;

call ProjectTypeDelete(15);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `ProjectTypeSelectAll`;
DELIMITER //
CREATE PROCEDURE `ProjectTypeSelectAll`
(
)
BEGIN
	SELECT * FROM rs_projecttypes;
END //
DELIMITER ;

call projecttypeselectall();

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectTypeSelectById;
DELIMITER //
CREATE PROCEDURE ProjectTypeSelectById
(
	IN pProjectTypeId INT 
)
BEGIN
	SELECT * FROM rs_projecttypes WHERE ProjectTypeId = pProjectTypeId;
END //
DELIMITER ;

call Projecttypeselectbyid(2);


/*testmethode*/
USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectTypeSelectByPTI;
DELIMITER //
CREATE PROCEDURE ProjectTypeSelectByPTI
(
	IN pProjectTypeInfo VARCHAR (255) CHARACTER SET UTF8
)
BEGIN
	SELECT * FROM rs_projecttypes WHERE ProjectTypeInfo = pProjectTypeInfo;
END //
DELIMITER ;

call Projecttypeselectbypti('Comes from JGIE');

