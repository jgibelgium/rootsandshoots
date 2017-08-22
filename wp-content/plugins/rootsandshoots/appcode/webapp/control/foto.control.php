<?php
include('../../../appcode/helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/foto.class.php');
include('../model/lid.class.php'); 

session_start();

//verwijderen
if(isset($_GET['fotoid']))
{
    $fotoId = $_GET['fotoid'];
    //1. fysieke verwijdering van bestand uit tree
    $fotoObject2 = new Foto();
    $fotoObject2->setFotoId($fotoId);
    $fotoObject2->selectFotoById();
    $fotoNaam = $fotoObject2->getFotoNaam();
    $fotoURL = $fotoObject2->getURL();
    $fotoPad = $fotoURL.$fotoNaam;
    echo $fotoPad;
    //unlink('../../../appcode/webapp/view/fotouploads/'.$fotoNaam); //reeds verwijderd na thumnail creatie
    unlink('../../../appcode/webapp/view/fotouploads/thumbs/'.$fotoNaam);

    //2. verwijdering uit databank
    $fotoObject1 = new Foto();
    $fotoObject1->setFotoId($fotoId);
    $result = $fotoObject1->delete();
    //fysieke verwijdering uit de map fotouploads

    if($result)
    {
        header('Location: ../../../appcode/webapp/view/documentfotos_view.php?documentid='.$_SESSION['docidbijfotoupload']);
    }
    else
    {
        $deleteMessage = "Geen verwijdering mogelijk. Contacteer de beheerder";
        $_SESSION['deletemessage'] = $deleteMessage;
        header('Location: ../../../appcode/webapp/view/foto_formulier.php');
    }
}




?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
        <p>Test update foto</p>
        <ul>
            <li>Message: <?php echo $fotoObject1->getFeedback(); ?></li>
            <li>Error message: <?php echo $fotoObject1->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $fotoObject1->getErrorCode(); ?></li>
        </ul>
        
       

    </body>
</html>



