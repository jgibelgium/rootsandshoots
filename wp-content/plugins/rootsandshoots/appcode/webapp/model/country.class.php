<?php
    class Country extends \Base
     {
        public function selectAll()
        {
        $result=FALSE;

        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call countryselectall()');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'All countries read.';
            }
            else
            {
                $this->feedback = 'The table rs_countries is empty.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "The stored procedure countryselectall has not been executed.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

        //retourneert FALSE of 2dim array met één element als resultaat
        public function selectCountryById($countryId)
        {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call countrySelectById(:pId)');
        $preparedStatement -> bindParam(':pId', $countryId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll())
          {
            $this->feedback = "{$preparedStatement->rowCount()} row(s) with id = {$countryId} in the table rs_countries have been found.";
          }
          else
          {
               $this->feedback = "No rows with id = {$countryId} have been found.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
          }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "The stored procedure countryselectbyid has not been executed.";
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



