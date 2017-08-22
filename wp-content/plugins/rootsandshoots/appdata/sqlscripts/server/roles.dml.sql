insert into rs_roles (roleid, role) values('1', 'None');
insert into rs_roles (roleid, role) values('2', 'Project member');
insert into rs_roles (roleid, role) values('3', 'Project head');
insert into rs_roles (roleid, role) values('4', 'Coordinator');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS RoleSelectById;
DELIMITER //
CREATE PROCEDURE RoleSelectById
(
	IN pId INT
)
BEGIN
	SELECT * FROM rs_roles WHERE RoleId = pId;
END //
DELIMITER ;

call RoleSelectById(2);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS RoleSelectAll;
DELIMITER //
CREATE PROCEDURE RoleSelectAll()
BEGIN
	SELECT * FROM rs_roles;
END //
DELIMITER ;

call RoleSelectAll();