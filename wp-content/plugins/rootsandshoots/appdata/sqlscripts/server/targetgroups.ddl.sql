USE rootsandshoots_europe; 
DROP TABLE IF EXISTS rs_targetgroups; 

CREATE TABLE rs_targetgroups ( 
	TargetGroupId INT NOT NULL AUTO_INCREMENT, 
	CONSTRAINT PRIMARY KEY(TargetGroupId), 
	TargetGroup VARCHAR (50) CHARACTER SET UTF8 NULL
    ) engine=innoDB;