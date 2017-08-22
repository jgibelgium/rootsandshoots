<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/lid.class.php'); 

session_start();
;
include('../help/cleaninput.php');

if(isset($_POST['btnLidSave'])) //werkt ondanks foutmelding undefined index
{
        $_POST = opschonenInput($_POST);
        $lidObject = new Lid();
        $lidObject->setGebruikersnaam($_POST['username']);
        $lidObject->setWachtwoord($_POST['password']);
        $lidObject->setLidNaam($_POST['lidNaam']);
        $lidObject->setLidVoornaam($_POST['lidVoornaam']);
        $lidObject->setLidInfo($_POST['lidInfo']);
        $lidObject->setAdres($_POST['lidAdres']);
        $lidObject->setWoonId($_POST['lidWoonplaats']);
        $lidObject->setTelefoon($_POST['lidTelefoon']);
        $lidObject->setEmail($_POST['lidEmail']);
        $lidObject->setSkypeNaam($_POST['lidSkype']);
        $lidObject->setGesloten(FALSE);/*NOT NULL in MySQL*/
        $lidObject->setLidStatus(1);
        $lidObject->setAddedBy($_POST['username']);
       
        $gelukt = $lidObject->insert();
        if($gelukt)
        {
            $nieuwLidId = $lidObject->getLidId();
            $nieuwLidStatus = $lidObject->getLidStatus();
            //$_SESSION['lidid'] = $nieuwLidId;
            //$_SESSION['lidstatus'] = $nieuwLidStatus;
            $_SESSION['inschrijvinggelukt'] = "U schreef zich succesvol in. U kunt nu inloggen";
            header('Location: ../../../index.php');
        }
        
        else//inschrijving niet gelukt
        {
            $_SESSION['lidNaam'] = $_POST['lidNaam'];
            $_SESSION['lidVoornaam'] = $_POST['lidVoornaam'];
            $_SESSION['lidAdres'] = $_POST['lidAdres'];
            $_SESSION['lidTelefoon'] = $_POST['lidTelefoon'];
            $_SESSION['lidEmail'] = $_POST['lidEmail'];
            $_SESSION['lidSkype'] = $_POST['lidSkype'];
            $_SESSION['lidInfo'] = $_POST['lidInfo'];
            $_SESSION['lidWoonplaats'] = $_POST['lidWoonplaats'];

            //nagaan of de substring uc_Gebruikersnaam aanwezig is in error message
            $errorMessage = $lidObject->getErrorMessage();
            $pattern1 = "/"."uc_Gebruikersnaam"."/";
            $pattern2 = "/"."Wachtwoord_UNIQUE"."/";
            if(preg_match($pattern1, $errorMessage))
            {
                 $_SESSION['userMessage'] = "Gebruikersnaam is niet uniek";
            }
            //nagaan of de substring Wachtwoord_UNIQUE aanwezig is in error message
            elseif(preg_match($pattern2, $errorMessage))
            {
                $_SESSION['passMessage'] = "Wachtwoord is niet uniek";
            }
            header('Location: ../view/inschrijving.php');
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

        <p>Test insert Lid</p>
        <ul>
            <li>Message: <?php echo $lidObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $lidObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $lidObject->getErrorCode(); ?></li>
            <li>ID: <?php echo $lidObject->getLidId(); ?></li>
        </ul>
       
    </body>
</html>



