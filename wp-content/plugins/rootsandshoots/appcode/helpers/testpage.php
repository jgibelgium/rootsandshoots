<?php
class Base extends \Feedback
{

protected $pdo;
protected $rowCount;


public function __construct()
{
    \Feedback::__construct();
}


public function connect()
{
    $result=FALSE;
    try
    {
        //1.locaal op wampserver
        
        $connectionString = 'mysql:host=localhost:3306;dbname=rootsandshoots_europe';
        $userName="root";   
        $password="";
        $this->pdo = new \PDO($connectionString, $userName, $password);
        $this->feedback = 'Met databank verbonden.';
        $result=TRUE;
        

        //2. testing: op OVH server met $connectionString
        /*
        $connectionString = 'mysql:host=studiogryfmod1.mysql.db;dbname=studiogryfmod1';
        $password='Ron68Studio';
        $userName="studiogryfmod1";
        $this->pdo = new \PDO($connectionString, $userName, $password);
        $this->feedback = 'Met databank verbonden.';
        $result=TRUE;
        */

        //3. OVH server met rootsandshoots-europe.org
        //$connectionString = 'mysql:host=rootsandvt4.mysql.db;dbname=rootsandvt4';
        //$password='Tanz1991';
        //$userName="rootsandvt4";
        //$this->pdo = new \PDO($connectionString, $userName, $password);
        //$this->feedback = 'Met databank verbonden.';
        //$result=TRUE;
              
    }
    catch(\PDOException $e)
    {
        $this->feedback='Niet met databank verbonden.';
        $this->errorMessage=$e->getMessage();
        $this->errorCode=$e->getCode();
    }
    return $result;
}


//close methode sluit de databankverbinding
public function close()
{
    $this->pdo=NULL;
}

}


class Feedback
{
    protected $feedback;
    protected $errorMessage;
    protected $errorCode;
    protected $isError;
    protected $messages;

    public function __construct()
    {
        $this->errorReset();
    }

    public function errorReset()
    {
        $this->feedback = 'none';
        $this->errorMessage = 'none';
        $this->errorCode = 'none';
        $this->isError = FALSE;
        $this->messages = array();
    }

    public function getFeedback()
    {
        return $this->feedback;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getIsError()
    {
        return $this->isError;
    }

    public function getMessages()
    {
        return $this->messages;
    }

}

$object = new \Base(); 
$object->connect();
echo "Feedback: ".$object->getFeedback();
echo "<br />";
echo "Error message: ".$object->getErrorMessage();
echo "<br />";
echo "Error code: ".$object->getErrorCode();
echo "<br />";

echo dirname(__FILE__) . "\\";
echo "<br />";
echo __DIR__ . "\\";
echo "<br />";
define('RS_PLUGIN_PATH', dirname(__FILE__)."\\");
echo RS_PLUGIN_PATH;

?>


