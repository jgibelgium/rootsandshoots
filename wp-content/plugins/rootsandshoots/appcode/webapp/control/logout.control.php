<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../help/sessie.class.php');

session_start();

//sessionid wissen
$sessieObject1 = new Sessie();
$sessieObject1->setId(1);
$sessieObject1->setLidId($_SESSION['lidid']);
$sessieObject1->setSessionId(NULL);
$time = time();
$sessieObject1->setLastActivity($time);
$sessieObject1->setModifiedBy($_SESSION['username']);
$sessieObject1->update();

//alle sessie variabelen wissen
session_destroy();

//gecachte bestanden wissen
$files = glob('../view/cached/*');//array van bestanden in de cached folder
foreach($files as $file)
{
    if(is_file($file))
    {
        unlink($file);
    }    
}

header('location: ../../../index.php');

?>

