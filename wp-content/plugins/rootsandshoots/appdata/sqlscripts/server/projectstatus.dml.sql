insert into rs_projectstatuses (projectstatusid, projectstatus) values(1, 'Waiting for approval');
insert into rs_projectstatuses (projectstatusid, projectstatus) values(2, 'Approved');
insert into rs_projectstatuses (projectstatusid, projectstatus) values(3, 'Denied');
insert into rs_projectstatuses (projectstatusid, projectstatus) values(4, 'In progress');
insert into rs_projectstatuses (projectstatusid, projectstatus) values(5, 'Finished');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectStatusSelectById;
DELIMITER //
CREATE PROCEDURE ProjectStatusSelectById
(
	IN pId INT
)
BEGIN
	SELECT * FROM rs_projectstatuses WHERE ProjectStatusId = pId;
END //
DELIMITER ;

call ProjectStatusSelectById(2);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS ProjectStatusSelectAll;
DELIMITER //
CREATE PROCEDURE ProjectStatusSelectAll()
BEGIN
	SELECT * FROM rs_projectstatuses  order by ProjectStatusId;
END //
DELIMITER ;

call ProjectStatusSelectAll();
