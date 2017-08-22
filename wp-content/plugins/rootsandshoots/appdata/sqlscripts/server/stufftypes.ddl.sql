USE rootsandshoots_europe; 
DROP TABLE IF EXISTS rs_stufftypes; 

CREATE TABLE rs_stufftypes ( 
	StuffTypeId INT NOT NULL AUTO_INCREMENT, 
	CONSTRAINT PRIMARY KEY(StuffTypeId), 
	StuffType VARCHAR (50) CHARACTER SET UTF8 NULL
    ) engine=innoDB;  

