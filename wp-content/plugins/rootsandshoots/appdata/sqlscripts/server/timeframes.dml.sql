insert into rs_timeframes (timeframeid, timeframe) values('1', '1 week');
insert into rs_timeframes (timeframeid, timeframe) values('2', '1 month');
insert into rs_timeframes (timeframeid, timeframe) values('3', '3 months');
insert into rs_timeframes (timeframeid, timeframe) values('4', '6 months');
insert into rs_timeframes (timeframeid, timeframe) values('5', '1 year');
insert into rs_timeframes (timeframeid, timeframe) values('6', '> 1 year');


USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS TimeFrameSelectById;
DELIMITER //
CREATE PROCEDURE TimeFrameSelectById
(
	IN pId INT
)
BEGIN
	SELECT * FROM rs_timeframes WHERE TimeFrameId = pId;
END //
DELIMITER ;

call TimeFrameSelectById(2);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS TimeFrameSelectAll;
DELIMITER //
CREATE PROCEDURE TimeFrameSelectAll()
BEGIN
	SELECT * FROM rs_timeframes;
END //
DELIMITER ;

call TimeFrameSelectAll();