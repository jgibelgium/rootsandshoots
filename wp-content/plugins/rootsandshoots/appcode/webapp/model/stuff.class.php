<?php

class Stuff extends \Base
{
    private $stuffId;

    /*constructor in basisklasse volstaat*/

    /*set $stuffId
    return true als nt leeg; return false als leeg
    */
    public function setStuffId($value)
    {
        if (is_numeric($value))
        {
            $this->stuffId=$value;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getStuffId()
    {
        return $this->stuffId; 
    }

    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function insert($stuffTitle, $projectId, $memberId, $stuffTypeId, $insertedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
            $preparedStatement = $this->pdo->prepare('call stuffinsert(@pStuffId, :pStuffTitle, :pProjectId, :pMemberId, :pStuffTypeId, :pInsertedBy)');
            $preparedStatement->bindParam(':pStuffTitle', $stuffTitle, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pMemberId', $memberId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pStuffTypeId', $stuffTypeId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pInsertedBy', $insertedBy, \PDO::PARAM_STR, 255); 
            $success = $preparedStatement->execute(); 
            if ($success)
            {
                $this->setStuffId($this->pdo->query('select @pStuffId')->fetchColumn()); 
                $this->feedback="The stuff with id <b> " . $this->getStuffId() . "</b> has been added."; 
                $result = TRUE;
            }
            else
            {
                $this->feedback = "The stuff has not been added.";
                $sQLErrorInfo = $preparedStatement->errorInfo();//invulling van een array
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
                $result = FALSE;
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback="The stored procedure stuffinsert has not succeeded."; 
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert steeds boolean*/
    public function update($stuffId, $stuffTitle, $projectId, $memberId, $stuffTypeId, $modifiedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {

        try
        {
        $preparedStatement=$this->pdo->prepare('call stuffupdate(:pId, :pStuffTitle, :pProjectId, :pMemberId, :pStuffTypeId, :pModifiedBy)');
        $preparedStatement->bindParam(':pId', $stuffId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pStuffTitle', $stuffTitle, \PDO::PARAM_STR, 255); 
        $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pMemberId', $memberId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pStuffTypeId', $stuffTypeId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pModifiedBy', $modifiedBy, \PDO::PARAM_STR, 255); 
        $success = $preparedStatement->execute();

        //$result = $preparedStatement->rowCount();
        if($success)
        {
            $this->feedback =  "The stuff {$stuffId} has been updated successfully.";
            $result = TRUE;
        }
        else
        {
            $this->feedback = "The stuff {$stuffId} has not been found and has not been updated.";
            $sQLErrorInfo = $preparedStatement->errorInfo();
            $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
            $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
             $this->feedback = "The stored procedure stuffupdate has not been executed.";
             $this->errorMessage=$e->getMessage();
             $this->errorCode=$e->getCode();
        }
        $this->close();
        }
        return $result;
    }

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen evenals invulling van alle variabelen
    public function selectStuffById($stuffId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call stuffselectbyid(:pId)');
        $preparedStatement -> bindParam(':pId', $stuffId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$stuffId} in the table Stuff has been found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No row with id = {$stuffId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure stuffselectbyid has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
    }



    /*retourneert steeds boolean*/
    public function delete($stuffId)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
                $preparedStatement = $this->pdo->prepare('call stuffdelete(:pId)');
                $preparedStatement->bindParam(':pId', $stuffId, \PDO::PARAM_INT, 11);
                $preparedStatement->execute();
                $result = $preparedStatement->rowCount();
                if($result)
                {
                $this->feedback = "Stuff {$stuffId} has been deleted.";
                $result = TRUE;
                }
                else
                {
                     $this->feedback = "The stuff with id = {$stuffId} has not been found and is not removed.";
                     $sQLErrorInfo = $preparedStatement->errorInfo();
                     $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                     $this->errorMessage = $sQLErrorInfo[2];
                     $result = FALSE;
                }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "The stored procedure stuffdelete has not been executed.";
                $this->errorMessage = $e->getMessage();
                $this->errorCode = $e->getCode();
            }
            $this->close();
        }
        return $result;
    }


    

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen
    public function selectStuffByMemberId($memberId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call StuffSelectByMemberId(:pMemberId)');
        $preparedStatement -> bindParam(':pMemberId', $memberId,  \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with memberid = {$memberId} found in table Member.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No rows with memberid = {$memberId}.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure StuffSelectByMemberId has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
    }

    //returns FALSE i case of failure and a 2dimens array in case of success
    public function selectStuffByProjectId($projectId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call StuffSelectByProjectId(:pProjectId)');
        $preparedStatement -> bindParam(':pProjectId', $projectId,  \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with projectid = {$projectId} found in table Project.";
        }
        else //returns empty array
        {
               $this->feedback = "No rows with projectid = {projectId}.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure StuffSelectByprojectId has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
    }

}
?>



