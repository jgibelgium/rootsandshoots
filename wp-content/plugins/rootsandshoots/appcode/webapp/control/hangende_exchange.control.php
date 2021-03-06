<?php
include('../../../appcode/helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/transactie.class.php'); 
include('../model/transactiedoc.class.php');
include('../help/class.phpmailer.php');
include('../help/class.smtp.php');
include('../model/lid.class.php'); 

session_start();

//mail verzenden naar de andere partner
$mail = new PHPMailer();
//1. connectie properties Gmail
// $mail->isSMTP();//vergt class.smtp.php
// $mail->SMTPDebug = 2;/*sets the debugging on; niet nodig in productie*/
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = TRUE;   // Enable SMTP authentication; wellicht na registratie op de SMTP server
// $mail->Username = 'ron68be@gmail.com';//SMTP username? http://email.about.com/od/accessinggmail/f/Gmail_SMTP_Settings.htm
// $mail->Password = 'ron7zq01%'; //SMTP wachtwoord bij Google
// $mail->SMTPSecure = 'ssl';//beveiligingstype
// $mail->Port = 465;//dezelfde poort bij Google en ovh.net
// $emailAdresAdmin = 'ron68be@gmail.com';

//1.connectie properties ovh
$mail->isSMTP();//vergt class.smtp.php
$mail->SMTPDebug = 2;/*sets the debugging on; niet nodig in productie*/
$mail->Host = 'ssl0.ovh.net'; // beveiligde SMTP server bij ovh.net
$mail->SMTPAuth = TRUE;   // Enable SMTP authentication; wellicht na registratie op de SMTP server
$mail->Username = 'postmaster@rfewebsites.be';
$mail->Password = 'dlanor12'; //SMTP wachtwoord bij ovh.net
$mail->SMTPSecure = 'ssl';//beveiligingstype
$mail->Port = 465;//dezelfde poort bij Google en ovh.net
$emailAdresAdmin = 'postmaster@rfewebsites.be';

//1. goedkeuren
if(isset($_POST['btnAgree']))
{
        //tabel Transactie
        $taObject = new Transactie();
        $taObject->setTransactieId($_POST['idhidden']);
        $taObject->setTADatum($_POST['datum']);//reeds MySQL datum formaat
        $taObject->setOrderBedrag(NULL);
        $taObject->setTransportKost(NULL); 
        $timestampDueDate = strtotime($_POST['duedate']);
        $dueDate = date('Y-m-d', $timestampDueDate);//omzetting in het MySQL string formaat
        $taObject->setDueDate($dueDate);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(2);//exchange
        $taObject->setExchangeStatusId(3);//aanvaard
        $taObject->setDealStatusId(NULL);
        $taObject->setModifiedBy($_SESSION['username']);
        $taObject->update();


        //mail verzenden naar de andere partner

        //2.email en naam van verzender
        if($_SESSION['lidstatus'] == 2)
        {
        $mail->From = $emailAdresAdmin; 
        $mail->FromName = 'Beheerder vzw Onder Ons Lezen';
        $mail->addReplyTo($emailAdresAdmin); 
        }
        elseif($_SESSION['lidstatus'] == 1)
        {
        //e-mail adres en naam van lid ophalen
        $lidObject = new Lid();
        $lidObject->setLidId($_SESSION['lidid']);
        $lidObject->selectLidById();
        $emailVerzender = $lidObject->getEmail();
        $voornaamVerzender = $lidObject->getLidVoornaam();
        $naamVerzender = $lidObject->getLidNaam();
        $mail->From = $emailVerzender;
        $mail->FromName =  $voornaamVerzender." ".$naamVerzender;
        $mail->addReplyTo($emailVerzender, $voornaamVerzender." ".$naamVerzender);
        }
   
        //3.e-mail adres en naam van bestemmeling ophalen
        $lidObject1 = new Lid();
        $lidObject1->setLidId($_POST['idbestemmeling']);
        $lidObject1->selectLidById();
        $emailOntvanger = $lidObject1->getEmail();
        $voornaamOntvanger = $lidObject1->getLidVoornaam();
        $naamOntvanger = $lidObject1->getLidNaam();
    
        $mail->AddAddress($emailOntvanger, $voornaamOntvanger." ".$naamOntvanger);
        $mail->WordWrap = 50;
        $mail->Subject = "Goedkeuring deal nr. ".$_POST['idhidden'];
        $mail->Body = "Beste, Ik ga akkoord met deze uitwisseling. Gelieve te verder af te spreken.\n";
        $mail->isHTML(TRUE); 
      
        if($mail->Send())
        {
        $message = $voornaamOntvanger." ".$naamOntvanger." is succesvol bericht over de goedkeuring van de uitwisseling.";
        } 
        else
        {
        $message = $voornaamOntvanger." ".$naamOntvanger." is niet succesvol bericht over de goedkeuring van de uitwisseling: ".$mail->ErrorInfo."\n"."Contacteer de administrator.";
        }
        $_SESSION['mailmessageexchange'] = $message;
        $_SESSION['idhidden'] = $_POST['idhidden'];
        header('Location: ../view/hangend_uitwisseling_formulier.php');
}
//2. afkeuren
elseif(isset($_POST['btnDeny']))
{
        //records verwijderen in tabel TransactieDoc ?
        //$tdObject = new TransactieDoc();
        //$tdObject->setTransactieId($_POST['idhidden']);
        //$tdObject->deleteTransactieDocByTransactieId();

        //record verwijderen in tabel Transactie ?
        //$taObject = new Transactie();
        //$taObject->setTransactieId($_POST['idhidden']);
        //$taObject->delete();

        //op status 4 zetten
        $taObject = new Transactie();
        $taObject->setTransactieId($_POST['idhidden']);
        $taObject->setTADatum($_POST['datum']);//reeds MySQL datum formaat
        $taObject->setOrderBedrag(NULL);
        $taObject->setTransportKost(NULL); 
        $timestampDueDate = strtotime($_POST['duedate']);
        $dueDate = date('Y-m-d', $timestampDueDate);//omzetting in het MySQL string formaat
        $taObject->setDueDate($dueDate);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(2);
        $taObject->setExchangeStatusId(4);//afgekeurd
        $taObject->setDealStatusId(NULL);
        $taObject->setModifiedBy($_SESSION['username']);
        $taObject->update();


        //mail verzenden naar de andere partner

        //2.email en naam van verzender
        if($_SESSION['lidstatus'] == 2){
        $mail->From = $emailAdresAdmin; 
        $mail->FromName = 'Beheerder vzw Onder Ons Lezen';
        $mail->addReplyTo($emailAdresAdmin);  
        }
        elseif($_SESSION['lidstatus'] == 1){
        //e-mail adres en naam van lid ophalen
        $lidObject = new Lid();
        $lidObject->setLidId($_SESSION['lidid']);
        $lidObject->selectLidById();
        $emailVerzender = $lidObject->getEmail();
        $voornaamVerzender = $lidObject->getLidVoornaam();
        $naamVerzender = $lidObject->getLidNaam();
        $mail->From = $emailVerzender;
        $mail->FromName =  $voornaamVerzender." ".$naamVerzender;
        $mail->addReplyTo($emailVerzender, $voornaamVerzender." ".$naamVerzender);
        }
   
        //3.e-mail adres en naam van bestemmeling ophalen
        $lidObject1 = new Lid();
        $lidObject1->setLidId($_POST['idbestemmeling']);
        $lidObject1->selectLidById();
        $emailOntvanger = $lidObject1->getEmail();
        $voornaamOntvanger = $lidObject1->getLidVoornaam();
        $naamOntvanger = $lidObject1->getLidNaam();
    
        $mail->AddAddress($emailOntvanger, $voornaamOntvanger." ".$naamOntvanger);
        $mail->WordWrap = 50;
        $mail->Subject = "Afkeuring deal nr. ".$_POST['idhidden'];
        $mail->Body = "Beste, Ik ga niet akkoord met deze uitwisseling. De uitwisseling is verwijderd van de website.\n";
        $mail->isHTML(TRUE); 
      
        if($mail->Send())
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is succesvol bericht over de afkeuring van het uitwisseling voorstel.";
        } 
        else
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is niet succesvol bericht over de afkeuring van het uitwisseling voorstel: ".$mail->ErrorInfo."\n"."Contacteer de administrator.";
        }
        $_SESSION['mailmessagedeny'] = $message;
        header('Location: ../view/mijn_hangende_uitwisselingen.php');
}
//3. voorstel due datum wijzigen
elseif(isset($_POST['btnUpdate']))
{
        $taObject = new Transactie();
        $taObject->setTransactieId($_POST['idhidden']);
        $taObject->setTADatum($_POST['datum']);//reeds MySQL datum formaat
        $taObject->setOrderBedrag(NULL);
        $taObject->setTransportKost(NULL); 
        $timestampDueDate = strtotime($_POST['duedate']);
        $dueDate = date('Y-m-d', $timestampDueDate);//omzetting in het MySQL string formaat
        $taObject->setDueDate($dueDate);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(2);
        $taObject->setExchangeStatusId(2);//gewijzigd voorstel
        $taObject->setDealStatusId(NULL);
        $taObject->setModifiedBy($_SESSION['username']);
        $taObject->update();


        //mail verzenden naar de andere partner

        //2.email en naam van verzender
        if($_SESSION['lidstatus'] == 2)
        {
        $mail->From = $emailAdresAdmin; 
        $mail->FromName = 'Beheerder vzw Onder Ons Lezen';
        $mail->addReplyTo($emailAdresAdmin);
        }
        elseif($_SESSION['lidstatus'] == 1)
        {
        //e-mail adres en naam van lid ophalen
        $lidObject = new Lid();
        $lidObject->setLidId($_SESSION['lidid']);
        $lidObject->selectLidById();
        $emailVerzender = $lidObject->getEmail();
        $voornaamVerzender = $lidObject->getLidVoornaam();
        $naamVerzender = $lidObject->getLidNaam();
        $mail->From = $emailVerzender;
        $mail->FromName =  $voornaamVerzender." ".$naamVerzender;
        $mail->addReplyTo($emailVerzender, $voornaamVerzender." ".$naamVerzender);
        }
   
        //3.e-mail adres en naam van bestemmeling ophalen
        $lidObject1 = new Lid();
        $lidObject1->setLidId($_POST['idbestemmeling']);
        $lidObject1->selectLidById();
        $emailOntvanger = $lidObject1->getEmail();
        $voornaamOntvanger = $lidObject1->getLidVoornaam();
        $naamOntvanger = $lidObject1->getLidNaam();
    
        $mail->AddAddress($emailOntvanger, $voornaamOntvanger." ".$naamOntvanger);
        $mail->WordWrap = 50;
        $mail->Subject = "Wijziging uitwisseling nr. ".$_POST['idhidden'];
        $mail->Body = "Beste, Ik stel een nieuwe due datum voor bij deze uitwisseling."."<br />".$voornaamVerzender." ".$naamVerzender;
        $mail->isHTML(TRUE); 
      
        if($mail->Send())
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is succesvol bericht over de wijziging van de uitwisseling.";
        } 
        else
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is niet succesvol bericht over de wijziging van de uitwisseling: ".$mail->ErrorInfo."\n"."Contacteer de administrator.";
        }
        $_SESSION['mailmessageexchange'] = $message;
        $_SESSION['idhidden'] = $_POST['idhidden'];
        header('Location: ../view/hangend_uitwisseling_formulier.php');
}
//4. bevestigen
elseif(isset($_POST['btnAffirm']))
{
        $taObject = new Transactie();
        $taObject->setTransactieId($_POST['idhidden']);
        $taObject->setTADatum($_POST['datum']);//reeds MySQL datum formaat
        $taObject->setOrderBedrag(NULL);
        $taObject->setTransportKost(NULL);
         
        $timestampDueDate = strtotime($_POST['duedate']);
        $dueDate = date('Y-m-d', $timestampDueDate);//omzetting in het MySQL string formaat
        $taObject->setDueDate($dueDate);
       
        $taObject->setTransactieTypeId(2);//exch
        if(isset($_POST['newstatus']))
        {
            $taObject->setExchangeStatusId($_POST['newstatus']);//in uitwisseling of teruggekeerd
            if($_POST['newstatus'] == 5)
            {
                //nederlandse instellingen voor de tijd
                setlocale(LC_TIME, ""); //onvermijdelijk nodig
                setlocale(LC_TIME, "nl_NL");
                $datumUit = date('Y-m-d', time());
                $taObject->setDatumUit($datumUit);
                $taObject->setDatumTerug(NULL);
            }
            else//$_POST['newstatus'] == 6
            {
                $taObject->setDatumUit($_POST['datumuit']);//reeds MySQL datum formaat
                setlocale(LC_TIME, ""); //onvermijdelijk nodig
                setlocale(LC_TIME, "nl_NL");
                $datumTerug = date('Y-m-d', time());
                $taObject->setDatumUit($datumTerug);
                $taObject->setDatumTerug($datumTerug);
            }
        }
        else
        {
            $taObject->setExchangeStatusId(3);//aanvaard   
            $taObject->setDatumUit(NULL); 
            $taObject->setDatumTerug(NULL);
        }
       
        $taObject->setDealStatusId(NULL);
        $taObject->setModifiedBy($_SESSION['username']);
        $taObject->update();

        $_SESSION['mailmessageexchange'] = "";//message laten verdwijnen in de affirmatie fase
        if($_POST['newstatus'] == 5)
        {
            $_SESSION['idhidden'] = $_POST['idhidden'];
            header('Location: ../view/hangend_uitwisseling_formulier.php');
        }
        else
        {
            header('Location: ../view/mijn_hangende_uitwisselingen.php'); 
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
        <p>update transactie</p>

        <ul>
            <li>Message: <?php echo $taObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $taObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $taObject->getErrorCode(); ?></li>
        </ul>

        <p>mail verzenden: <?php echo $message;?></p>

        <!--
        <p>delete transactiedoc</p>
        <ul>
            <li>Message: <?php echo $tdObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $tdObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tdObject->getErrorCode(); ?></li>
        </ul>

        <p>delete transactie</p>
        <ul>
            <li>Message: <?php echo $taObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $taObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $taObject->getErrorCode(); ?></li>
        </ul>
       
        <p>mail verzenden: <?php echo $message;?></p>
        -->
        
        
    </body>
</html>






