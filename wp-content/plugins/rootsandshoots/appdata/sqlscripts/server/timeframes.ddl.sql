USE rootsandshoots_europe; 
DROP TABLE IF EXISTS rs_timeframes; 

CREATE TABLE rs_timeframes ( 
	TimeFrameId INT NOT NULL AUTO_INCREMENT, 
	CONSTRAINT PRIMARY KEY(TimeFrameId), 
	TimeFrame VARCHAR (50) CHARACTER SET UTF8 NULL
    ) engine=innoDB;