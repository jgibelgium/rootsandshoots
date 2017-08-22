insert into rs_stufftypes (stufftypeid, stufftype) values('1', 'Document');
insert into rs_stufftypes (stufftypeid, stufftype) values('2', 'Image');
insert into rs_stufftypes (stufftypeid, stufftype) values('3', 'Video');







USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS StuffTypesSelectAll;
DELIMITER //
CREATE PROCEDURE StuffTypesSelectAll()
BEGIN
	SELECT * FROM rs_stufftypes;
END //
DELIMITER ;


call StuffTypesSelectAll();
