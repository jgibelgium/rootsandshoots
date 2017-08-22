USE rootsandshoots_europe; 
DROP TABLE IF EXISTS rs_languages; 

CREATE TABLE rs_languages ( 
	LanguageId INT NOT NULL AUTO_INCREMENT, 
	CONSTRAINT PRIMARY KEY(LanguageId), 
	Language VARCHAR (50) CHARACTER SET UTF8 NULL
    ) engine=innoDB;  