<?php
include('../../../appcode/helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/foto.class.php');
include('../model/dockenmerk.class.php');
include('../model/registratie.class.php');
include('../model/transactie.class.php'); 
include('../model/transactiedoc.class.php');
include('../model/transactiepartner.class.php');
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
        $taObject->setTADatum($_POST['datum']);
        $taObject->setOrderBedrag($_POST['prijs']);
        $taObject->setTransportKost($_POST['tpkost']); 
        $taObject->setDueDate(NULL);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(1);//deal
        $taObject->setExchangeStatusId(NULL);
        $taObject->setDealStatusId(3);//goedkeuring
        $taObject->setModifiedBy($_SESSION['username']);
        $taObject->update();

        //2.email en naam van verzender
        if($_SESSION['lidstatus'] == 2)
        {
        $mail->From =  $emailAdresAdmin;
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
        $mail->From = $emailVerzender;//ondanks assignatie verschijnt er hier helaas ron68be@gmail.com in het bericht bij de bestemmeling; niet toevoegen vult ook hetzelfde in
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
        $mail->Body = "Beste, Ik ga akkoord met deze deal. Gelieve te betalen.\n";
        $mail->isHTML(TRUE); 
      
        if($mail->Send())
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is succesvol bericht over de goedkeuring van de deal.";
        } 
        else
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is niet succesvol bericht over de goedkeuring van de deal: ".$mail->ErrorInfo."\n"."Contacteer de administrator.";
        }
        $_SESSION['mailmessagedeal'] = $message;
        $_SESSION['idhidden'] = $_POST['idhidden'];
        header('Location: ../view/hangend_deal_formulier.php');
}
//2. afkeuren
elseif(isset($_POST['btnDeny']))
{
        //records verwijderen in tabel TransactieDoc (zou ook kunnen met cascade als FK constraint van transactieid in TransactieDoc) ?
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
        $taObject->setTADatum($_POST['datum']);
        $taObject->setOrderBedrag($_POST['prijs']);
        $taObject->setTransportKost($_POST['tpkost']); 
        $taObject->setDueDate(NULL);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(1);//deal
        $taObject->setExchangeStatusId(NULL);
        $taObject->setDealStatusId(4);//afgekeurd
        $taObject->setModifiedBy($_SESSION['username']);
        $taObject->update();


        //2.email en naam van verzender
        if($_SESSION['lidstatus'] == 2){
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
        $mail->From = $emailVerzender;//ondanks assignatie verschijnt er hier helaas ron68be@gmail.com in het bericht bij de bestemmeling; niet toevoegen vult ook hetzelfde in
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
        $mail->Body = "Beste, Ik ga niet akkoord met deze deal. De deal is verwijderd van de website.\n";
        $mail->isHTML(TRUE); 
      
        if($mail->Send())
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is succesvol bericht over de afkeuring van het deal voorstel.";
        } 
        else
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is niet succesvol bericht over de afkeuring van het deal voorstel: ".$mail->ErrorInfo."\n"."Contacteer de administrator.";
        }
        $_SESSION['mailmessagedeny'] = $message;
        header('Location: ../view/mijn_hangende_deals.php');
}
//3. transportkost wijzigen
elseif(isset($_POST['btnUpdate']))
{
        $taObject = new Transactie();
        $taObject->setTransactieId($_POST['idhidden']);
        $taObject->setTADatum($_POST['datum']);
        $taObject->setOrderBedrag($_POST['prijs']);
        $taObject->setTransportKost($_POST['tpkost']); 
        $taObject->setDueDate(NULL);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(1);//deal
        $taObject->setExchangeStatusId(NULL);
        $taObject->setDealStatusId(2);//gewijzigd voorstel
        $taObject->setModifiedBy($_SESSION['username']);
        $taObject->update();

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
        $mail->From = $emailVerzender;//ondanks assignatie verschijnt er hier helaas ron68be@gmail.com in het bericht bij de bestemmeling; niet toevoegen vult ook hetzelfde in
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
        $mail->Subject = "Wijziging deal nr. ".$_POST['idhidden'];
        $mail->Body = "Beste, Ik stel nieuwe transport kosten voor bij deze deal.\n";
        $mail->isHTML(TRUE); 
      
        if($mail->Send())
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is succesvol bericht over de wijziging van de deal.";
        } 
        else
        {
            $message = $voornaamOntvanger." ".$naamOntvanger." is niet succesvol bericht over de wijziging van de deal: ".$mail->ErrorInfo."\n"."Contacteer de administrator.";
        }
        $_SESSION['mailmessagedeal'] = $message;
        $_SESSION['idhidden'] = $_POST['idhidden'];
        header('Location: ../view/hangend_deal_formulier.php');
}
//4. status 5, 6 of 7 bevestigen
elseif(isset($_POST['btnAffirm']))
{
        $taObject = new Transactie();
        $taObject->setTransactieId($_POST['idhidden']);
        $taObject->setTADatum($_POST['datum']);
        $taObject->setOrderBedrag($_POST['prijs']);
        $taObject->setTransportKost($_POST['tpkost']); 
        $taObject->setDueDate(NULL);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(1);//deal
        $taObject->setExchangeStatusId(NULL);
        $taObject->setDealStatusId($_POST['newstatus']);
        $taObject->setModifiedBy($_SESSION['username']);//verkoper
        $taObject->update();
        $_SESSION['mailmessagedeal'] = "";//message laten verdwijnen in de affirmatie fase of nog aanpassen naargelang de status
        if($_POST['newstatus'] == 5)//status wijzigen in betaald
        {
            $_SESSION['idhidden'] = $_POST['idhidden'];
            header('Location: ../view/hangend_deal_formulier.php');
        }
        else //eigendomsoverdracht van docs
        {
            header('Location: ../view/mijn_hangende_deals.php'); 
        }
}
else
{}





?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <!--
        <p>update transactie</p>
        <ul>
            <li>Message: <?php echo $taObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $taObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $taObject->getErrorCode(); ?></li>
            <li>TAId: <?php echo $taObject->getTransactieId(); ?></li>
            <li>TA datum: <?php echo $taObject->getTADatum(); ?></li>
            <li>transportkost: <?php echo $taObject->getTransportKost(); ?></li>
            <li>Dealstatus: <?php echo $taObject->getDealStatusId(); ?></li>
        </ul>
        <p>mail verzenden: <?php echo $message;?></p>
        -->

        <!--
        <p>update registratie</p>
        <ul>
            <li>Message: <?php echo $registratieObject2->getFeedback(); ?></li>
            <li>Error message: <?php echo $registratieObject2->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $registratieObject2->getErrorCode(); ?></li>
        </ul>

        <p>mail verzenden: <?php echo $message;?></p>
        -->

        
        
        
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





