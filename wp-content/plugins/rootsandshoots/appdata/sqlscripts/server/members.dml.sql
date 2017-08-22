/*te wijzigen*/
insert into rs_members(wpuserid, firstname, lastname, birthdate, notes, countryid, languageid) values(1, 'Tania', 'Parys', '1980-02-05', 'taniaparys@yahoo.com', 100, 3, 1);
insert into rs_members(wpuserid, firstname, lastname, birthdate, notes, countryid, languageid) values(2, 'Alicia', 'Van der Stighelen', '1997-10-15', 'aliciavds@live.be', 101, 3, 1);
insert into rs_members(wpuserid, firstname, lastname, birthdate, notes, countryid, languageid) values(3, 'Chris', 'Michel', '1986-04-07', 'chris@janegoodall.be', 102, 3, 1);


USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS MemberInsert;
DELIMITER //
CREATE PROCEDURE MemberInsert
(
	OUT pWPUserId INT ,
	IN pFirstName VARCHAR (255) CHARACTER SET UTF8 ,
	IN pLastName VARCHAR (255) CHARACTER SET UTF8 ,
	IN pBirthDate DATE ,
    IN pNotes TEXT CHARACTER SET UTF8 ,
    IN pCountryId INT,
    IN pLanguageId INT ,
	IN pInsertedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
	INSERT INTO rs_members
	(
		FirstName,
		LastName,
		BirthDate,
        Notes,
        CountryId,
        LanguageId,
        InsertedBy,
        InsertedOn
	)
	VALUES
	(
		pFirstName,
		pLastName,
		pBirthDate,
        pNotes,
        pCountryId,
        pLanguageId,
		pInsertedBy,
		NOW()
	);
	SELECT LAST_INSERT_ID() INTO pWPUserId;
END //
DELIMITER ;

call MemberInsert(@pWPUserId, 'Joost', 'Jolens', '1970-02-02', 'lorem ipsum', 120, 1, 1, 'admin');
call MemberInsert(@pWPUserId, "Hans", "Hanssens", "1970-10-15", "hhh@skynet.be", 110, 2, 2, "admin");



USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS MemberUpdate;
DELIMITER //
CREATE PROCEDURE MemberUpdate
(
	IN pWPUserId INT ,
	IN pFirstName VARCHAR (255) CHARACTER SET UTF8 ,
	IN pLastName VARCHAR (255) CHARACTER SET UTF8 ,
	IN pBirthDate DATE ,
    IN pNotes TEXT CHARACTER SET UTF8 ,
    IN pCountryId INT ,
    IN pLanguageId INT ,
	IN pModifiedBy VARCHAR (255) CHARACTER SET UTF8 
)
BEGIN
UPDATE rs_members
SET
	FirstName = pFirstName,
	LastName = pLastName,
	BirthDate = pBirthDate,
    Notes = pNotes,
   	CountryId = pCountryId,
    LanguageId = pLanguageId,
	ModifiedBy = pModifiedBy,
	ModifiedOn = NOW()
WHERE WPUserId = pWPUserId;
END //
DELIMITER ;

call Memberupdate(1,'Jan', 'Janssens', '1970-02-02', 'lorem ipsum', 100, 1, 1, 'admin'); 


USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `MemberDelete`;
DELIMITER //
CREATE PROCEDURE `MemberDelete`
(
	IN pId INT
)
BEGIN
DELETE FROM rs_members WHERE MemberId = pId;
END //
DELIMITER ;

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS MemberSelectAll;
DELIMITER //
CREATE PROCEDURE MemberSelectAll
(
)
BEGIN
	SELECT * FROM rs_members order by LastName;
END //
DELIMITER ;

call memberselectall();

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `MemberSelectById`;
DELIMITER //
CREATE PROCEDURE `MemberSelectById`
(
	IN pWPUserId INT 
)
BEGIN
	SELECT * FROM rs_members WHERE WPUserId = pWPUserId;
END //
DELIMITER ;

call Memberselectbyid(1);

USE rootsandshoots_europe;
DROP PROCEDURE IF EXISTS `MemberSelectByUserId`;
DELIMITER //
CREATE PROCEDURE `MemberSelectByUserId`
(
	IN pUserId INT 
)
BEGIN
	SELECT * FROM rs_members WHERE WPUserId = pUserId;
END //
DELIMITER ;

call MemberSelectByUserId(53);




