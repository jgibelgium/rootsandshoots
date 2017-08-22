USE rootsandshoots_europe; 
DROP TABLE IF EXISTS rs_countries; 

CREATE TABLE rs_countries ( 
	CountryId INT NOT NULL AUTO_INCREMENT, 
	CONSTRAINT PRIMARY KEY(CountryId), 
	Country VARCHAR (50) CHARACTER SET UTF8 NULL
    ) engine=innoDB;  