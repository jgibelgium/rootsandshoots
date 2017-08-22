<?php

class ProjectTargetGroup extends \Base
{
    private $projectTargetGroupId;

    /*constructor in basisklasse volstaat*/

    public function setProjectTargetGroupId($value)
    {
        if (is_numeric($value))
        {
            $this->projectTargetGroupId=$value;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getProjectTargetGroupId()
    {
        return $this->projectTargetGroupId; 
    }

    /*retourneert steeds boolean*/
    public function insert($projectId, $targetGroupId, $insertedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
            $preparedStatement = $this->pdo->prepare('call projecttargetgroupinsert(@pProjectTargetGroupId, :pProjectId, :pTargetGroupId, :pInsertedBy)');
            $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pTargetGroupId', $targetGroupId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pInsertedBy', $insertedBy, \PDO::PARAM_STR, 255);
            $success = $preparedStatement->execute(); 
            if ($success == 1)
            {
                $this->setProjectTargetGroupId($this->pdo->query('select @pProjectTargetGroupId')->fetchColumn()); 
                $this->feedback="The projecttargetgroup with id <b> " . $this->getProjectTargetGroupId() . "</b> has been added."; 
                $result = TRUE;
            }
            else
            {
                $this->feedback = "The projecttargetgroup has not been added.";
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
                $result = FALSE;
            }
            }
            catch (\PDOException $ex)
            {
            $this->feedback = "The stored procedure projecttargetgroupinsert has not been executed."; 
            $this->errorMessage = $ex->getMessage();
            $this->errorCode = $ex->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert steeds boolean*/
    public function update($projectTargetGroupId, $projectId, $targetGroupId, $modifiedBy)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {

        try
        {
        $preparedStatement=$this->pdo->prepare('call projecttargetgroupupdate(:pId, :pProjectId, :pTargetGroupId, :pModifiedBy)');
        $preparedStatement->bindParam(':pId', $projectTargetGroupId, \PDO::PARAM_INT, 11);
        $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pTargetGroupId', $targetGroupId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pModifiedBy', $modifiedBy, \PDO::PARAM_STR, 255);
        $preparedStatement->execute();

        $result = $preparedStatement->rowCount();
        if($result)
        {
            $this->feedback =  "The projecttargetgroup {$projectTargetGroupId} has been updated successfully.";
            $result = TRUE;
        }
        else
        {
            $this->feedback = "The projecttargetgroup {$projectTargetGroupId} has not been found and has not been changed.";
            $sQLErrorInfo = $preparedStatement->errorInfo();
            $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
            $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
             $this->feedback = "Stored procedure projecttargetgroupupdate has not been executed.";
             $this->errorMessage = $e->getMessage();
             $this->errorCode = $e->getCode();
        }
        $this->close();
        }
        return $result;
    }
    
    /*retourneert steeds boolean*/
    public function delete($projectTargetGroupId)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
                $preparedStatement = $this->pdo->prepare('call projecttargetgroupdelete(:pId)');
                $preparedStatement->bindParam(':pId', $projectTargetGroupId, \PDO::PARAM_INT, 11);
                $preparedStatement->execute();
                $result = $preparedStatement->rowCount();
                if($result)
                {
                    $this->feedback = "Projecttargetgroup {$projectTargetGroupId} has been deleted.";
                    $result = TRUE;
                }
                else
                {
                     $this->feedback = "The Projecttargetgroup with id = {$projectTargetGroupId} has not been found and is not deleted.";
                     $sQLErrorInfo = $preparedStatement->errorInfo();
                     $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                     $this->errorMessage = $sQLErrorInfo[2];
                     $result = FALSE;
                }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "Stored procedure projecttargetgroupdelete has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

    

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen
    public function selectTargetGroupsByProjectId($projectId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call ProjectTargetGroupsSelectByProjectId(:pId)');
        $preparedStatement -> bindParam(':pId', $projectId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$projectId} in the table rs_projecttargetgroups found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No row with id = {$projectId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure ProjectTargetGroupsSelectByProjectId not executed.";
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




