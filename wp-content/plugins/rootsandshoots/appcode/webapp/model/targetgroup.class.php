<?php
    class TargetGroup extends \Base
     {
        public function selectAll()
        {
        $result=FALSE;

        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call targetgroupselectall()');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'All targetgroups read.';
            }
            else
            {
                $this->feedback = 'The table rs_targetgroups is empty.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "The stored procedure targetgroupselectall has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

        //retourneert FALSE of 2dim array met één element als resultaat
        public function selectTargetGroupById($targetGroupId)
        {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call targetgroupSelectById(:pId)');
        $preparedStatement -> bindParam(':pId', $targetGroupId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll())
          {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$targetGroupId} in the table rs_targetgroups have been found.";
          }
          else
          {
               $this->feedback = "No rows with id = {$targetGroupId} have been found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
          }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure targetgroupselectbyid has not been executed.";
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




