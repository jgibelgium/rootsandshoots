<?php
    class Language extends \Base
     {
        public function selectAll()
        {
        $result=FALSE;

        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call languageselectall()');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'Alle talen ingelezen.';
            }
            else
            {
                $this->feedback = 'De tabel rs_languages is leeg.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "De stored procedure languageselectall is niet uitgevoerd.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

        //retourneert FALSE of 2dim array met één element als resultaat
        public function selectLanguageById($languageId)
        {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
       
        $preparedStatement = $this->pdo->prepare('call LanguageSelectById(:pId)');
        $preparedStatement -> bindParam(':pId', $languageId, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll())
          {
            $this->feedback = "{$preparedStatement->rowCount()} rij(en) met id = {$languageId} in de tabel language gevonden.";
          }
          else
          {
               $this->feedback = "Geen rijen met id = {$languageId} gevonden.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
          }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "De stored procedure languageselectbyid is niet uitgevoerd.";
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


