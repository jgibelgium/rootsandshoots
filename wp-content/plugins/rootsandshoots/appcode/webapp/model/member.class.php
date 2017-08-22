<?php

class Member extends \Base
{
    private $memberId;

    /*constructor in basisklasse volstaat*/

    /*set $memberId
    return true als nt leeg; return false als leeg
    */
    public function setMemberId($value)
    {
        if (is_numeric($value))
        {
            $this->memberId=$value;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getMemberId()
    {
        return $this->memberId; 
    }

    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function insert($firstName, $lastName, $birthDate, $notes, $countryId, $languageId, $insertedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
            $preparedStatement = $this->pdo->prepare('call memberinsert(@pWPUserId, :pFirstName, :pLastName, :pBirthDate, :pNotes, :pCountryId, :pLanguageId, :pInsertedBy)');
            $preparedStatement->bindParam(':pFirstName', $firstName, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pLastName', $lastName, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pBirthDate', $birthDate, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pNotes', $notes, \PDO::PARAM_STR); 
            $preparedStatement->bindParam(':pCountryId', $countryId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pLanguageId', $languageId, \PDO::PARAM_INT, 11);    
            $preparedStatement->bindParam(':pInsertedBy', $insertedBy, \PDO::PARAM_STR, 255); 
            $success = $preparedStatement->execute(); 
            if ($success)
            {
                $this->setMemberId($this->pdo->query('select @pWPUserId')->fetchColumn()); 
                $this->feedback="The member {$firstName} {$lastName} with id <b> " . $this->getMemberId() . "</b> has been added."; 
                $result = TRUE;
            }
            else
            {
                $this->feedback = "The member {$firstName} {$lastName} has not been added.";
                $sQLErrorInfo = $preparedStatement->errorInfo();//invulling van een array
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
                $result = FALSE;
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback="The stored procedure memberinsert has not succeeded."; 
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function update($wpUserId, $firstName, $lastName, $birthDate, $notes, $languageId, $countryId, $modifiedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {

        try
        {
        $preparedStatement=$this->pdo->prepare('call memberupdate(:pId, :pFirstName, :pLastName, :pBirthDate, :pNotes, :pLanguageId, :pCountryId, :pModifiedBy)');
        $preparedStatement->bindParam(':pId', $wpUserId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pFirstName', $firstName, \PDO::PARAM_STR, 255);
        $preparedStatement->bindParam(':pLastName', $lastName, \PDO::PARAM_STR, 255);
        $preparedStatement->bindParam(':pBirthDate', $birthDate, \PDO::PARAM_STR, 255);
        $preparedStatement->bindParam(':pNotes', $notes, \PDO::PARAM_STR);
        $preparedStatement->bindParam(':pLanguageId', $languageId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pCountryId', $countryId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pModifiedBy', $modifiedBy, \PDO::PARAM_STR, 255); 
        $success = $preparedStatement->execute();

        //$result = $preparedStatement->rowCount();
        if($success)
        {
            $this->feedback =  "The member {$wpUserId} has been updated.";
            $result = TRUE;
        }
        else
        {
            $this->feedback = "The member {$wpUserId} has not been found and has not been updated.";
            $sQLErrorInfo = $preparedStatement->errorInfo();
            $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
            $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
             $this->feedback = "The stored procedure memberupdate has not been executed.";
             $this->errorMessage=$e->getMessage();
             $this->errorCode=$e->getCode();
        }
        $this->close();
        }
        return $result;
    }

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen evenals invulling van alle variabelen
    public function selectMemberById($wpUserId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call memberselectbyid(:pId)');
        $preparedStatement -> bindParam(':pId', $wpUserId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$wpUserId} in the table Member has been found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No rows with id = {$wpUserId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure memberselectbyid has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
    }



    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function delete($wpUserId)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try{
                $preparedStatement = $this->pdo->prepare('call memberdelete(:pId)');
                /*in stored procedure staat pId als parameter; hoeft hierniet idem te zijn*/
                $preparedStatement->bindParam(':pId', $wpUserId, \PDO::PARAM_INT, 11);
                $preparedStatement->execute();
                $result = $preparedStatement->rowCount();
                if($result)
                {
                $this->feedback = "Member {$wpUserId} has been deleted.";
                $result = TRUE;
                }
                else
                {
                     $this->feedback = "The member with id = {$wpUserId} has not been found and is not removed.";
                     $sQLErrorInfo = $preparedStatement->errorInfo();
                     $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                     $this->errorMessage = $sQLErrorInfo[2];
                     $result = FALSE;
                }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "The stored procedure memberdelete has not been executed.";
                $this->errorMessage = $e->getMessage();
                $this->errorCode = $e->getCode();
            }
            $this->close();
        }
        return $result;
    }


    

    /*retourneert false bij mislukken; bij slagen een 2dim array*/
    public function selectAll()
    {
        $result=FALSE;

        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call Memberselectall');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'Alle leden ingelezen.';
            }
            else
            {
                $this->feedback = 'De tabel Member is leeg.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $ex)
            {
                $this->feedback = "De stored procedure Memberselectall is niet uitgevoerd.";
                $this->errorMessage=$ex->getMessage();
                $this->errorCode=$ex->getCode();
            }
            $this->close();
        }
        return $result;
    }
    

      
    //retourneert FALSE bij mislukken en een 2dimens array bij slagen evenals invulling van alle variabelen
    /*
    public function selectMemberByUserId($userId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call memberselectbyuserid(:pUserId)');
        $preparedStatement -> bindParam(':pUserId', $userId,  \PDO::PARAM_STR, 255);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with userid = {$userId} found in table Member.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No rows with userid = {$userId}.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure memberselectbyuserid has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
    }
     */
     
}
?>



