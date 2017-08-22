<?php
include('../../../appcode/helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/auteur.class.php');
include('../model/lid.class.php'); 
include('../help/cleaninput.php');

session_start();
//verwijderen
if(isset($_GET['auteurid']))
{
    $auteurObject = new Auteur();
    $auteurId = $_GET['auteurid'];
    $auteurObject->setAuteurId($auteurId);
    $result = $auteurObject->delete();
    if($result)
    {
        header('Location: ../../../appcode/webapp/view/auteurs.php');
    }
    else
    {
        $message = "Geen verwijdering van deze auteur mogelijk.";
        $_SESSION['message'] = $message;
        header('Location: ../../../appcode/webapp/view/auteurs.php');
    }
}

//toevoegen
//$_POST is always set, but its content might be empty.
if(isset($_POST['btnAuteurSave']))
{
        $_POST = opschonenInput($_POST);
        $auteurObject = new Auteur();
        $auteurObject->setAuteurNaam($_POST['naamAuteur']);
        $auteurObject->setAuteurVoornaam($_POST['voornaamAuteur']);
        $auteurObject->setAuteurInfo($_POST['infoAuteur']);
        $auteurObject->setAddedBy('admin');
        $reult = $auteurObject->insert();
        if($result)
        {
            header('Location: ../../../appcode/webapp/view/auteurs.php');
        }
        else
        {
            $message = $auteurObject->getFeedback();;
            $_SESSION['message'] = $message;
            header('Location: ../../../appcode/webapp/view/auteurs.php');
        }
}
//wijzigen
elseif(isset($_POST['btnAuteurUpdate']))
{
        $_POST = opschonenInput($_POST);
        $auteurObject = new Auteur();
        $auteurObject->setAuteurId($_POST['idHidden']);
        $auteurObject->setAuteurNaam($_POST['naamAuteur']);
        $auteurObject->setAuteurVoornaam($_POST['voornaamAuteur']);
        $auteurObject->setAuteurInfo($_POST['infoAuteur']);
        $auteurObject->setModifiedBy('admin');
        $result = $auteurObject->update();
        if($result)
        {
            header('Location: ../../../appcode/webapp/view/auteurs.php');
        }
        else
        {
            $message = $auteurObject->getFeedback();;
            $_SESSION['message'] = $message;
            header('Location: ../../../appcode/webapp/view/auteurs.php');
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
        
        <p>Test update auteur</p>
        <ul>
            <li>Message: <?php echo $auteurObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $auteurObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $auteurObject->getErrorCode(); ?></li>
        </ul>
        
       

    </body>
</html>


