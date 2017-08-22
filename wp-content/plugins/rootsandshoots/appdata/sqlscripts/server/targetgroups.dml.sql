insert into rs_targetgroups (targetgroupid, targetgroup) values('1', '0 - 6 years');
insert into rs_targetgroups (targetgroupid, targetgroup) values('2', '6 - 12 years');
insert into rs_targetgroups (targetgroupid, targetgroup) values('3', '12 - 18 years');
insert into rs_targetgroups (targetgroupid, targetgroup) values('4', '18 - 25 years');
insert into rs_targetgroups (targetgroupid, targetgroup) values('5', 'all youngsters');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `TargetGroupSelectById`;
DELIMITER //
CREATE PROCEDURE `TargetGroupSelectById`
(
	IN pId INT
)
BEGIN
	SELECT * FROM rs_targetgroups
	WHERE TargetGroupId = pId;
END //
DELIMITER ;

call TargetGroupSelectById(2);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS TargetGroupSelectAll;
DELIMITER //
CREATE PROCEDURE TargetGroupSelectAll()
BEGIN
	SELECT * FROM rs_targetgroups;
END //
DELIMITER ;

call TargetGroupSelectAll();
