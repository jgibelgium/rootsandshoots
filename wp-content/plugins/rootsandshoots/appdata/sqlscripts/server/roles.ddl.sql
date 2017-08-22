USE rootsandshoots_europe; 
DROP TABLE IF EXISTS rs_roles; 

CREATE TABLE rs_roles ( 
	RoleId INT NOT NULL AUTO_INCREMENT, 
	CONSTRAINT PRIMARY KEY(RoleId), 
	Role VARCHAR (50) CHARACTER SET UTF8 NULL
    ) engine=innoDB;  