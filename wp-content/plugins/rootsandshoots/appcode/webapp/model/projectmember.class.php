<?php

class ProjectMember extends \Base
{
    private $projectMemberId;

    /*constructor in basisklasse volstaat*/

    /*set $projectMemberId
    return true als nt leeg; return false als leeg
    */
    public function setProjectMemberId($value)
    {
        if (is_numeric($value))
        {
            $this->projectMemberId=$value;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getProjectMemberId()
    {
        return $this->projectMemberId; 
    }

    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function insert($projectId, $memberId, $pending, $insertedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
            $preparedStatement = $this->pdo->prepare('call projectmemberinsert(@pProjectMemberId, :pProjectId, :pMemberId, :pPending, :pInsertedBy)');
            $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pMemberId', $memberId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pPending', $pending, \PDO::PARAM_BOOL);
            $preparedStatement->bindParam(':pInsertedBy', $insertedBy, \PDO::PARAM_STR, 255); 
            $success = $preparedStatement->execute(); 
            if ($success)
            {
                $this->setProjectMemberId($this->pdo->query('select @pProjectMemberId')->fetchColumn()); 
                $this->feedback="The projectmember with id <b> " . $this->getProjectMemberId() . "</b> has been added."; 
                $result = TRUE;
            }
            else
            {
                $this->feedback = "The projectmember has not been added.";
                $sQLErrorInfo = $preparedStatement->errorInfo();//invulling van een array
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
                $result = FALSE;
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback="The stored procedure projectmemberinsert has not succeeded."; 
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function update($projectMemberId, $projectId, $memberId, $pending, $modifiedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {

        try
        {
        $preparedStatement=$this->pdo->prepare('call projectmemberupdate(:pId, :pProjectId, :pMemberId, :pPending, :pModifiedBy)');
        $preparedStatement->bindParam(':pId', $projectMemberId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pMemberId', $memberId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pPending', $pending, \PDO::PARAM_BOOL);
        $preparedStatement->bindParam(':pModifiedBy', $modifiedBy, \PDO::PARAM_STR, 255); 
        $preparedStatement->execute();

        $result = $preparedStatement->rowCount();
        if($result)
        {
            $this->feedback =  "The projectmember {$projectMemberId} has been updated.";
            $result = TRUE;
        }
        else
        {
            $this->feedback = "The projectmember {$projectMemberId} has not been found and has not been updated.";
            $sQLErrorInfo = $preparedStatement->errorInfo();
            $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
            $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
             $this->feedback = "The stored procedure projectmemberupdate has not been executed.";
             $this->errorMessage=$e->getMessage();
             $this->errorCode=$e->getCode();
        }
        $this->close();
        }
        return $result;
    }

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen evenals invulling van alle variabelen
    /*
    public function selectProjectMemberById($projectMemberId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call projectmemberselectbyid(:pId)');
        $preparedStatement -> bindParam(':pId', $projectMemberId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$projectMemberId} in the table ProjectMember has been found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No rows with id = {$projectMemberId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure projectmemberselectbyid has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
    }
    */


    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function delete($projectMemberId)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try{
                $preparedStatement = $this->pdo->prepare('call projectmemberdelete(:pId)');
                /*in stored procedure staat pId als parameter; hoeft hierniet idem te zijn*/
                $preparedStatement->bindParam(':pId', $projectMemberId, \PDO::PARAM_INT, 11);
                $preparedStatement->execute();
                $result = $preparedStatement->rowCount();
                if($result)
                {
                $this->feedback = "projectmember {$projectMemberId} has been deleted.";
                $result = TRUE;
                }
                else
                {
                     $this->feedback = "The projectmember with id = {$projectMemberId} has not been found and is not removed.";
                     $sQLErrorInfo = $preparedStatement->errorInfo();
                     $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                     $this->errorMessage = $sQLErrorInfo[2];
                     $result = FALSE;
                }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "The stored procedure projectmemberdelete has not been executed.";
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
            $preparedStatement=$this->pdo->prepare('call projectmemberselectall');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'All projectmembers read.';
            }
            else
            {
                $this->feedback = 'The table projectmember is empty.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $ex)
            {
                $this->feedback = "De stored procedure projectmemberselectall has not been executed.";
                $this->errorMessage=$ex->getMessage();
                $this->errorCode=$ex->getCode();
            }
            $this->close();
        }
        return $result;
    }
    

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen 
    public function selectProjectsByMemberId($memberId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call SelectProjectsByMemberId(:pMemberId)');
        $preparedStatement -> bindParam(':pMemberId', $memberId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$memberId} in the table ProjectMember has been found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No rows with id = {$memberId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure SelectProjectsByMemberId has not been executed.";
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



