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
        //1.locaal
        
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

?>


