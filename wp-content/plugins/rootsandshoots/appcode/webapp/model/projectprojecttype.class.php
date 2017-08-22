<?php

class ProjectProjectType extends \Base
{
    private $ppTypeId;

    /*constructor in basisklasse volstaat*/

    public function setProjectProjectTypeId($value)
    {
        if (is_numeric($value))
        {
            $this->ppTypeId=$value;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getProjectProjectTypeId()
    {
        return $this->ppTypeId; 
    }

    /*retourneert steeds boolean*/
    public function insert($projectId, $projectTypeId, $insertedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
            $preparedStatement = $this->pdo->prepare('call projectprojecttypeinsert(@pProjectProjectTypeId, :pProjectId, :pProjectTypeId, :pInsertedBy)');
            $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pProjectTypeId', $projectTypeId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pInsertedBy', $insertedBy, \PDO::PARAM_STR, 255);
            $success = $preparedStatement->execute(); 
            if ($success == 1)
            {
                $this->setProjectProjectTypeId($this->pdo->query('select @pProjectProjectTypeId')->fetchColumn()); 
                $this->feedback="The projectprojecttype with id <b> " . $this->getProjectProjectTypeId() . "</b> has been added."; 
                $result = TRUE;
            }
            else
            {
                $this->feedback = "The projectprojecttype has not been added.";
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
                $result = FALSE;
            }
            }
            catch (\PDOException $ex)
            {
            $this->feedback = "The stored procedure projectprojecttypeinsert has not been executed."; 
            $this->errorMessage = $ex->getMessage();
            $this->errorCode = $ex->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert steeds boolean*/
    public function update($ppTypeId, $projectId, $projectTypeId, $modifiedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {

        try
        {
        $preparedStatement=$this->pdo->prepare('call projectprojecttypeupdate(:pId, :pProjectId, :pProjectTypeId, :pModifiedBy)');
        $preparedStatement->bindParam(':pId', $ppTypeId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pProjectTypeId', $projectTypeId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pModifiedBy', $modifiedBy, \PDO::PARAM_STR, 255);
        $preparedStatement->execute();

        $result = $preparedStatement->rowCount();
        if($result)
        {
            $this->feedback =  "The projectprojecttype {$ppTypeId} has been updated successfully.";
            $result = TRUE;
        }
        else
        {
            $this->feedback = "The projectprojecttype {$ppTypeId} has not been found and has not been changed.";
            $sQLErrorInfo = $preparedStatement->errorInfo();
            $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
            $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
             $this->feedback = "Stored procedure projectprojecttypeupdate has not been executed.";
             $this->errorMessage = $e->getMessage();
             $this->errorCode = $e->getCode();
        }
        $this->close();
        }
        return $result;
    }
    
    /*retourneert steeds boolean*/
    public function delete($ppTypeId)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
                $preparedStatement = $this->pdo->prepare('call projectprojecttypedelete(:pId)');
                $preparedStatement->bindParam(':pId', $ppTypeId, \PDO::PARAM_INT, 11);
                $preparedStatement->execute();
                $result = $preparedStatement->rowCount();
                if($result)
                {
                    $this->feedback = "Projectprojecttype {$ppTypeId} has been deleted.";
                    $result = TRUE;
                }
                else
                {
                     $this->feedback = "The projectprojecttype with id = {$ppTypeId} has not been found and is not deleted.";
                     $sQLErrorInfo = $preparedStatement->errorInfo();
                     $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                     $this->errorMessage = $sQLErrorInfo[2];
                     $result = FALSE;
                }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "Stored procedure projectprojecttypedelete has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert false bij mislukken; bij slagen een 2dim array*/
    /*
    public function selectAll()
    {
        $result=FALSE;

        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call projecttypeselectall()');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'All projecttypes read.';
            }
            else
            {
                $this->feedback = 'The table rs_projecttypes is empty.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "The stored procedure projecttypeselectall has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }
    */

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen
    public function selectProjectTypesByProjectId($projectId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call ProjectProjectTypesSelectByProjectId(:pId)');
        $preparedStatement -> bindParam(':pId', $projectId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$projectId} in the table rs_projectprojecttypes found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "Geen rij met id = {$projectId} gevonden.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure ProjectProjectTypesSelectByProjectId not executed.";
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



