USE rootsandshoots_europe; 
DROP TABLE IF EXISTS rs_projectstatuses; 

CREATE TABLE rs_projectstatuses ( 
	ProjectStatusId INT NOT NULL AUTO_INCREMENT, 
	CONSTRAINT PRIMARY KEY(ProjectStatusId), 
	ProjectStatus VARCHAR (50) CHARACTER SET UTF8 NULL
    ) engine= innoDB;