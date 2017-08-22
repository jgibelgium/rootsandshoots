<?php

class StuffType extends \Base
{
    /*constructor in basisklasse volstaat*/

    public function selectAll()
    {
        $result=FALSE;
        if($this->connect())
        {
            try
            {
            $preparedStatement=$this->pdo->prepare('call stufftypesselectall()');
            $preparedStatement->execute();
            if ($result = $preparedStatement->fetchAll())
            {
                $this->feedback = 'Alle stufftypes ingelezen.';
            }
            else
            {
                $this->feedback = 'De tabel rs_stufftypes is leeg.';
                $sQLErrorInfo = $preparedStatement->errorInfo();
                $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                $this->errorMessage = $sQLErrorInfo[2];
            }
            }
            catch (\PDOException $e)
            {
                $this->feedback = "De stored procedure stufftypesselectall is niet uitgevoerd.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
            }
            $this->close();
        }
        return $result;
    }

    
}
?>



