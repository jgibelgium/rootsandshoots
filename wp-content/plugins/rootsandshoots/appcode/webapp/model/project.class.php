<?php

class Project extends \Base
{
    private $projectId;

    /*constructor in basisklasse volstaat*/

    /*set $ProjectId
    return true als nt leeg; return false als leeg
    */
    public function setProjectId($value)
    {
        if (is_numeric($value))
        {
            $this->projectId=$value;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function getProjectId()
    {
        return $this->projectId; 
    }

    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function insert($projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $insertedBy )
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try
            {
            $preparedStatement = $this->pdo->prepare('call projectinsert(@pProjectId, :pProjectTitle, :pGroupName, :pPplEstimated, :pLocation, :pObjective, :pMeans, :pStartDate, :pTimeFrameId, :pLanguageId, :pCountryId, :pProjectStatusId, :pHoursSpent, :pPplParticipated, :pPplServed, :pReport, :pEndDate, :pInsertedBy)');
            $preparedStatement->bindParam(':pProjectTitle', $projectTitle, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pGroupName', $groupName, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pPplEstimated', $pplEstimated, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pLocation', $location, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pObjective', $objective, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pMeans', $means, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pStartDate', $startDate, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pTimeFrameId', $timeFrameId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pLanguageId', $languageId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pCountryId', $countryId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pProjectStatusId', $projectStatusId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pHoursSpent', $hoursSpent, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pPplParticipated', $pplParticipated, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pPplServed', $pplServed, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pReport', $report, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pEndDate', $endDate, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pInsertedBy', $insertedBy, \PDO::PARAM_STR, 255); 
            $success = $preparedStatement->execute(); 
            if ($success == 1)
            {
                $this->setProjectId($this->pdo->query('select @pProjectId')->fetchColumn()); 
                $this->feedback="The project with title '{$projectTitle}' and id <b> " . $this->getProjectId() . "</b> has been added."; 
                $result = TRUE;
            }
            else
            {
                $this->feedback = "The project has not been added. Contact the administrator";
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
                $result = FALSE;
            }
            }
            catch (\PDOException $ex)
            {
            $this->feedback = "The stored procedure projectinsert has not been executed."; 
            $this->errorMessage = $ex->getMessage();
            $this->errorCode = $ex->getCode();
            }
            $this->close();
        }
        return $result;
    }

    /*retourneert steeds boolean; ook feedback is voorzien*/
    public function update($projectId, $projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $modifiedBy )
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {

        try
        {
            $preparedStatement=$this->pdo->prepare('call projectupdate(:pProjectId, :pProjectTitle, :pGroupName, :pPplEstimated, :pLocation, :pObjective, :pMeans, :pStartDate, :pTimeFrameId, :pLanguageId, :pCountryId, :pProjectStatusId, :pHoursSpent, :pPplParticipated, :pPplServed, :pReport, :pEndDate, :pModifiedBy)');
            $preparedStatement->bindParam(':pProjectId', $projectId, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pProjectTitle', $projectTitle, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pGroupName', $groupName, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pPplEstimated', $pplEstimated, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pLocation', $location, \PDO::PARAM_STR, 255); 
            $preparedStatement->bindParam(':pObjective', $objective, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pMeans', $means, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pStartDate', $startDate, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pTimeFrameId', $timeFrameId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pLanguageId', $languageId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pCountryId', $countryId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pProjectStatusId', $projectStatusId, \PDO::PARAM_INT, 11); 
            $preparedStatement->bindParam(':pHoursSpent', $hoursSpent, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pPplParticipated', $pplParticipated, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pPplServed', $pplServed, \PDO::PARAM_INT, 11);
            $preparedStatement->bindParam(':pReport', $report, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pEndDate', $endDate, \PDO::PARAM_STR, 255);
            $preparedStatement->bindParam(':pModifiedBy', $modifiedBy, \PDO::PARAM_STR, 255); 
            $success = $preparedStatement->execute();

            //$result = $preparedStatement->rowCount();
            if($success)
        {
            $this->feedback =  "Projectupdate of project {$projectId} has been executed successfully.";
            $result = TRUE;
        }
        else
        {
            $this->feedback = "Project {$projectId} is not found and has not been updated.";
            $sQLErrorInfo = $preparedStatement->errorInfo();
            $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
            $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
             $this->feedback = "Stored procedure projectupdate is not executed.";
             $this->errorMessage = $e->getMessage();
             $this->errorCode = $e->getCode();
        }
        $this->close();
        }
        return $result;
    }

    /*retourneert true bij slagen en false bij mislukken*/
    public function delete($projectId)
    {
        $result=FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';

        if($this->connect())
        {
            try{
                $preparedStatement = $this->pdo->prepare('call projectdelete(:pId)');
                $preparedStatement->bindParam(':pId', $projectId, \PDO::PARAM_INT, 11);
                $preparedStatement->execute();
                $result = $preparedStatement->rowCount();
                if($result)
                {
                $this->feedback = "Project {$projectId} is verwijderd.";
                $result = TRUE;
                }
                else
                {
                     $this->feedback = "Het project met id = {$projectId} is niet gevonden en dus niet verwijderd.";
                     $sQLErrorInfo = $preparedStatement->errorInfo();
                     $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                     $this->errorMessage = $sQLErrorInfo[2];
                     $result = FALSE;
                }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "Stored proc projectdelete is niet uitgevoerd.";
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
            $preparedStatement=$this->pdo->prepare('call projectselectall');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'All projects read.';
            }
            else
            {
                $this->feedback = 'The table Project is empty.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "Stored procedure projectselectall has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen
    public function selectProjectById($projectId)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call projectselectbyid(:pId)');
        $preparedStatement -> bindParam(':pId', $projectId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$projectId} found in the table Project.";
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
                $this->feedback = "Stored procedure projectselectbyid niet uitgevoerd.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
         
    }
    
    

    

    /*retourneert false bij mislukken; bij slagen een 2dim array*/
    public function selectProjectsByMember($memberId)
    {
        $result=FALSE;
        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call SelectProjectsByMemberId(:pMemberId)');
            $preparedStatement -> bindParam(':pMemberId', $memberId, \PDO::PARAM_INT, 11);
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'All projects from this member read.';
            }
            else
            {
                $this->feedback = 'No projects from member '.$memberId;
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
            }
            $this->close();
        }
        return $result;
    }

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen
    public function filterProjects1($languageId, $countryId, $projectTypeId, $key)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call projectfilter1(:pLanguageId, :pCountryId, :pProjectTypeId, :pProjectTitle)');
        $preparedStatement->bindParam(':pLanguageId', $languageId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pCountryId', $countryId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pProjectTypeId', $projectTypeId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pProjectTitle', $key, \PDO::PARAM_STR, 255); 
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No rows found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure projectfilter1 not executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
         
    }

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen
    public function filterProjects2($languageId, $countryId, $targetGroupId, $key)
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call projectfilter2(:pLanguageId, :pCountryId, :pTargetGroupId, :pProjectTitle)');
        $preparedStatement->bindParam(':pLanguageId', $languageId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pCountryId', $countryId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pTargetGroupId', $targetGroupId, \PDO::PARAM_INT, 11); 
        $preparedStatement->bindParam(':pProjectTitle', $key, \PDO::PARAM_STR, 255);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) found.";
        }
        else //retourneert lege array
        {
               $this->feedback = "No rows found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Stored procedure projectfilter2 not executed.";
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



