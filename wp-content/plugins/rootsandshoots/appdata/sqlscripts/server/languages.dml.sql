insert into rs_languages (languageid, language) values('1', 'English');
insert into rs_languages (languageid, language) values('2', 'Dutch');
insert into rs_languages (languageid, language) values('3', 'French');
insert into rs_languages (languageid, language) values('4', 'German');
insert into rs_languages (languageid, language) values('5', 'Spanish');
insert into rs_languages (languageid, language) values('6', 'Italian');
insert into rs_languages (languageid, language) values(7, 'Other');

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS LanguageSelectById;
DELIMITER //
CREATE PROCEDURE LanguageSelectById
(
	IN pId INT
)
BEGIN
	SELECT * FROM rs_languages WHERE LanguageId = pId;
END //
DELIMITER ;

call LanguageSelectById(2);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS LanguageSelectAll;
DELIMITER //
CREATE PROCEDURE LanguageSelectAll()
BEGIN
	SELECT * FROM rs_languages;
END //
DELIMITER ;

call LanguageSelectAll();

