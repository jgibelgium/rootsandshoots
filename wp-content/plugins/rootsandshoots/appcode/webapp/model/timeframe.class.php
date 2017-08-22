<?php
    class TimeFrame extends \Base
     {
        public function selectAll()
        {
        $result=FALSE;

        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call timeframeselectall()');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'Read all timeframes.';
            }
            else
            {
                $this->feedback = 'The table rs_timeframes is empty.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "De stored procedure timeframeselectall is niet uitgevoerd.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

        //retourneert FALSE of 2dim array met één element als resultaat
        public function selectTimeFrameById($timeFrameId)
        {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call timeframeSelectById(:pId)');
        $preparedStatement -> bindParam(':pId', $timeFrameId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll())
          {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$timeFrameId} in the tabel rs_timeframes found.";
          }
          else
          {
               $this->feedback = "No rows with id = {$timeFrameId} found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
          }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure timeframeselectbyid has not been executed.";
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


