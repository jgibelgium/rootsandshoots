insert into rs_countries (countryid, country) values('1', 'Belgium');
insert into rs_countries (countryid, country) values('2', 'France');
insert into rs_countries (countryid, country) values('3', 'Germany');
insert into rs_countries (countryid, country) values('4', 'Italy');
insert into rs_countries (countryid, country) values('5', 'Netherlands');
insert into rs_countries (countryid, country) values('6', 'Spain');


USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS CountrySelectById;
DELIMITER //
CREATE PROCEDURE CountrySelectById
(
	IN pId INT
)
BEGIN
	SELECT * FROM rs_countries WHERE CountryId = pId;
END //
DELIMITER ;

call CountrySelectById(2);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS CountrySelectAll;
DELIMITER //
CREATE PROCEDURE CountrySelectAll()
BEGIN
	SELECT * FROM rs_countries  order by country;
END //
DELIMITER ;

call CountrySelectAll();
