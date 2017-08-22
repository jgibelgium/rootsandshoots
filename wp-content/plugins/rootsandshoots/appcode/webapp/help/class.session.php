<?php

class Session extends \Base
{
	protected $id;

	public function getId()
	{
		return $this->id;
	}

	public function setId($value)
	{
		if (is_numeric($value))
        {
            $this->id = $value;
            return TRUE;
        }
        else
		{
			return FALSE;
		}
	}

    public function update($id, $sessionId, $memberId, $lastActivity, $modifiedBy)
	{
		$result = FALSE;
        $this->errorCode = 'none';
        $this->errorMessage = 'none';
        $this->feedback = 'none';
		if($this->connect())
		{
			try
			{
                $preparedStatement = $this->pdo->prepare('CALL sessionupdate(:pId, :pSessionId, :pMemberId, :pLastActivity, :pModifiedBy)');
                $preparedStatement->bindParam(':pId', $id, \PDO::PARAM_INT);
                $preparedStatement->bindParam(':pSessionId', $sessionId, \PDO::PARAM_STR);
				$preparedStatement->bindParam(':pMemberId', $memberId, \PDO::PARAM_INT);
                $preparedStatement->bindParam(':pLastActivity', $lastActivity, \PDO::PARAM_STR);
				$preparedStatement->bindParam(':pModifiedBy', $modifiedBy, \PDO::PARAM_STR);
				$preparedStatement->execute();
				$result = $preparedStatement->rowCount();
                if($result)
                {
                    $this->feedback =  "Session {$id} is gewijzigd.";
                    $result = TRUE;
                }
                else
                {
                    $this->feedback = "Session {$id} is niet gevonden en dus niet gewijzigd.";
                    $sQLErrorInfo = $preparedStatement->errorInfo();
                    $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
                    $this->errorMessage = $sQLErrorInfo[2];
                }
			}
			catch (\PDOException $e)
			{
				$this->feedback = 'Stored pr sessionupdate is niet uitgevoerd.';
				$this->errorCode = $sQLErrorInfo[0];
				$this->errorCodeDriver = $sQLErrorInfo[1];
				$this->errorMessage = $sQLErrorInfo[2];
			}
             $this->close();
		}
		return $result;
	}

    //retourneert FALSE bij mislukken en een 2dimens array bij slagen evenals een set van alle variabelen
    public function selectSessionById()
    {
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
        $result=FALSE;

        if($this -> connect())
        {
        try 
        {
        $preparedStatement = $this->pdo->prepare('call Sessionselectbyid(:pId)');
        $preparedStatement -> bindParam(':pId', $this->id, \PDO::PARAM_INT, 11);
        $preparedStatement->execute();
        $this->rowCount = $preparedStatement->rowCount();
        //fetch the output
        if($result = $preparedStatement->fetchAll()) //Returns an array containing all of the result set rows 
        {
            $this->feedback = "{$preparedStatement->rowCount()} rij(en) met id = {$this->id} in de tabel Session gevonden.";
        }
        else //retourneert lege array
        {
               $this->feedback = "Geen rijen met id = {$this->id} gevonden.";
               $sQLErrorInfo = $preparedStatement->errorInfo();
               $this->errorCode = $sQLErrorInfo[0].'/'.$sQLErrorInfo[1];
               $this->errorMessage = $sQLErrorInfo[2];
        }
        }
        catch (\PDOException $e)
        {
                $this->feedback = "Fout => rij is niet gevonden.";
                $this->errorMessage=$e->getMessage();
                $this->errorCode=$e->getCode();
                $this->rowCount = -1;
        }
        $this->close();
        return $result;
        }
         
    }

    static function checkSessionId()
    {
        $SessionObject = new Session();
        $SessionObject->setId(1);
        $SessionObject->selectSessionById();
        if($SessionObject->getSessionId() != NULL)
        {
            if(session_id() != $SessionObject->getSessionId())
            {
                header('Location: website_bezet.php');
                exit;
            }
        }
        
    }

    static function registerLastActivity()
    {
        $SessionObject = new Session();
        $SessionObject->setId(1);
        $SessionObject->setLidId($_SESSION['lidid']);//levert probleem bij afmelden en wildvreemde toegang
        $SessionObject->setSessionId(session_id());
        $SessionObject->setLastActivity(time());
        $SessionObject->update();
    }
}



?>



