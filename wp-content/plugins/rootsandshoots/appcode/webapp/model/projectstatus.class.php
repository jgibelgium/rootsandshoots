<?php
    class ProjectStatus extends \Base
     {
        //constructor not needed; inherited from class Base

        public function selectAll()
        {
        $result=FALSE;

        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call projectstatusselectall()');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'Read all projectstatuss.';
            }
            else
            {
                $this->feedback = 'The table rs_projectstatuses is empty.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "The stored procedure projectstatusselectall is niet uitgevoerd.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

        //retourneert FALSE of 2dim array met één element als resultaat
        public function selectProjectStatusById($projectStatusId)
        {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call projectstatusSelectById(:pId)');
        $preparedStatement -> bindParam(':pId', $projectStatusId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll())
          {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$projectStatusId} in the tabel rs_projectstatuses found.";
          }
          else
          {
               $this->feedback = "No rows with id = {$projectStatusId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
          }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure projectstatusselectbyid has not been executed.";
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


