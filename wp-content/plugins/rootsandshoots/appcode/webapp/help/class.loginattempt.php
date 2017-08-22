<?php

class LoginAttempt extends \Base
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

    public function insert($memberId, $time)
	{
		$result = FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
		if($this->connect())
		{
			try
			{
                $preparedStatement = $this->pdo->prepare('call loginattemptinsert(@pId, :pMemberId, :pTime)');
				$preparedStatement->bindParam(':pMemberId', $memberId, \PDO::PARAM_INT);
                $preparedStatement->bindParam(':pTime', $time, \PDO::PARAM_STR);
				$result = $preparedStatement->execute();
				$this->rowCount = $preparedStatement->rowCount();
				if ($result)
				{
					$this->setId($this->pdo->query('select @pId')->fetchColumn());
					$this->feedback = 'Rij met id <b> ' . $this->getId() . '</b> is toegevoegd.';
					$result = TRUE;
				}
				else
				{
					$this->feedback = 'Fout in stored procedure loginattemptinsert(). Rij is niet toegevoegd.';
					$sQLErrorInfo = $preparedStatement->errorInfo();
					$this->errorCode = $sQLErrorInfo[0];
					$this->errorCodeDriver = $sQLErrorInfo[1];
					$this->errorMessage = $sQLErrorInfo[2];
				}
			}
			catch (\PDOException $ex)
			{
				$this->feedback = 'Rij is niet toegevoegd.';
				$this->errorCode = $sQLErrorInfo[0];
				$this->errorCodeDriver = $sQLErrorInfo[1];
				$this->errorMessage = $sQLErrorInfo[2];
			}
             $this->close();
		}
		return $result;
	}

    /*retourneert 1dim array*/
    public function countMemberIdByTime($memberId, $time)
    {
		$result = FALSE;
        $this->errorCode='none';
        $this->errorMessage='none';
        $this->feedback='none';
		if($this->connect())
		{
			try
			{
				$preparedStatement = $this->pdo->prepare("CALL loginAttemptCountMemberIdByTime(:pMemberId, :pTime)");
                $preparedStatement->bindParam(':pMemberId', $memberId, \PDO::PARAM_STR);
				$preparedStatement->bindParam(':pTime', $time, \PDO::PARAM_STR);
				$preparedStatement->execute();
				$result = $preparedStatement->fetch();
				if ($result)
				{
					$this->feedback = "Rij(en) met tijd >= $time in tabel LoginAttempt gevonden.";
				}
				else
				{
					$this->feedback = "Tabel LoginAttempt is leeg.";
					$this->errorCode = $sQLErrorInfo[0];
					$this->errorCodeDriver = $sQLErrorInfo[1];
					$this->errorMessage = $sQLErrorInfo[2];
				}
			}
			catch (\PDOException $ex)
			{
				$this->feedback = 'Geen rijen is niet gevonden.';
				$this->errorMessage = $ex->getMessage();
				$this->errorCodeDriver = $ex->getCodeDriver();
				$this->errorCode = $ex->getCode();
			}
           $this->close();
		}
		return $result;
    }
}

?>



