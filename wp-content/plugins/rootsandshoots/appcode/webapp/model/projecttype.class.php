<?php

class ProjectType extends \Base
{
    private $projectTypeId;

    /*constructor in basisklasse volstaat*/

    public function setProjectTypeId($value)
    {
        if (is_numeric($value))
        {
            $this->projectTypeId=$value;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getProjectTypeId()
    {
        return $this->projectTypeId; 
    }

    /*retourneert steeds boolean*/
    public function insert($projectType, $projectTypeInfo)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
            $preparedStatement = $this->pdo->prepare('call projecttypeinsert(@pProjectTypeId, :pProjectType, :pProjectTypeInfo)');
            $preparedStatement->bindParam(':pProjectType', $projectType, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pProjectTypeInfo', $projectTypeInfo, \PDO::PARAM_STR, 255);
            $success = $preparedStatement->execute(); 
            if ($success == 1)
            {
                $this->setProjectTypeId($this->pdo->query('select @pProjectTypeId')->fetchColumn()); 
                $this->feedback="The projecttype '{$projectType}' and its id <b> " . $this->getProjectTypeId() . "</b> have been added."; 
                $result = TRUE;
            }
            else
            {
                $this->feedback = "The projecttype has not been added. Contact the administrator.";
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
                $result = FALSE;
            }
            }
            catch (\PDOException $ex)
            {
            $this->feedback = "The stored procedure projecttypeinsert has not been executed."; 
            $this->errorMessage = $ex->getMessage();
            $this->errorCode = $ex->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert steeds boolean*/
    public function update($projectTypeId, $projectType, $projectTypeInfo)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {

        try
        {
        $preparedStatement=$this->pdo->prepare('call projecttypeupdate(:pId, :pProjectType, :pProjectTypeInfo)');
        $preparedStatement->bindParam(':pId', $projectTypeId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pProjectType', $projectType, \PDO::PARAM_STR, 255); 
        $preparedStatement->bindParam(':pProjectTypeInfo', $projectTypeInfo, \PDO::PARAM_STR, 255); 
        $preparedStatement->execute();

        $result = $preparedStatement->rowCount();
        if($result)
        {
            $this->feedback =  "Projecttype {$projectTypeId} is updated successfully.";
            $result = TRUE;
        }
        else
        {
            $this->feedback = "The projecttype {$projectTypeId} has not been found and has not been changed.";
            $sQLErrorInfo = $preparedStatement->errorInfo();
            $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
            $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
             $this->feedback = "The stored procedure projecttypeupdate has not been executed.";
             $this->errorMessage = $e->getMessage();
             $this->errorCode = $e->getCode();
        }
        $this->close();
        }
        return $result;
    }
    
    /*retourneert steeds boolean*/
    public function delete($projectTypeId)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
                $preparedStatement = $this->pdo->prepare('call projecttypedelete(:pId)');
                /*in stored procedure staat pId als parameter; hoeft hier niet idem te zijn*/
                $preparedStatement->bindParam(':pId', $projectTypeId, \PDO::PARAM_INT, 11);
                $preparedStatement->execute();
                $result = $preparedStatement->rowCount();
                if($result)
                {
                    $this->feedback = "Projecttype {$projectTypeId} has been deleted.";
                    $result = TRUE;
                }
                else
                {
                     $this->feedback = "The projecttype with id = {$projectTypeId} has not been found and is not deleted.";
                     $sQLErrorInfo = $preparedStatement->errorInfo();
                     $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                     $this->errorMessage = $sQLErrorInfo[2];
                     $result = FALSE;
                }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "Stored procedure projecttypedelete has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
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
            $preparedStatement=$this->pdo->prepare('call projecttypeselectall');
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

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen
    public function selectProjectTypeById($projectTypeId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call projecttypeselectbyid(:pId)');
        $preparedStatement -> bindParam(':pId', $projectTypeId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$projectTypeId} in the table rs_projecttype found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No row with id = {$projectTypeId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure projecttypeselectbyid not executed.";
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



