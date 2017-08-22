<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/transactie.class.php'); 
include('../model/transactiedoc.class.php');
include('../model/transactiepartner.class.php');
include('../model/lid.class.php'); 
include('../help/class.phpmailer.php');
include('../help/class.smtp.php');

session_start();

//toevoegen
if(isset($_POST['btnLeen']))
{
        //tabel Transactie
        $taObject = new Transactie();
        //nederlandse instellingen voor de tijd
        setlocale(LC_TIME, ""); //onvermijdelijk nodig
        setlocale(LC_TIME, "nl_NL");
        $TADatum = date('Y-m-d', time());
        echo $TADatum;

        $taObject->setTADatum($TADatum);
        $taObject->setOrderBedrag(NULL);
        $taObject->setTransportKost(NULL); 
        $timestampDueDate = strtotime($_POST['duedate']);
        $dueDate = date('Y-m-d', $timestampDueDate);//omzetting in het MySQL string formaat
        $taObject->setDueDate($dueDate);
        $taObject->setDatumUit(NULL);
        $taObject->setDatumTerug(NULL);
        $taObject->setTransactieTypeId(2);//exchange
        $taObject->setDealStatusId(NULL);
        $taObject->setExchangeStatusId(1);//voorstel
        $taObject->setAddedBy($_SESSION['username']);
        $taObject->insert();
        $nieuwTAId = $taObject->getTransactieId();

        //tabel TransactieDoc
        $tdObject = new TransactieDoc();
        //itereren over de aangevinkte checkboxen: $_POST['selector'] is een numerieke, ééndim array van de value van de checkboxen, hier docId

        $aantalDocs = count($_POST['selector']);
        for($i = 0; $i < $aantalDocs; $i++)
        {
            $tdObject->setTransactieId($nieuwTAId);
            $tdObject->setDocId($_POST['selector'][$i]);
            $tdObject->setAddedBy($_SESSION['username']);
            $tdObject->insert();
        }

        //tabel TransactiePartner
        //1. lener
        $tpObject1 = new TransactiePartner();
        $tpObject1->setTransactieId($nieuwTAId);
        $tpObject1->setRolId(1);//lener
        $tpObject1->setLidId($_SESSION['lidid']);
        //setDelStatus() is niet nodig; zit vervat in insert
        $tpObject1->setAddedBy($_SESSION['username']);
        $tpObject1->insert();

        //2. verlener
        $tpObject2 = new TransactiePartner();
        $tpObject2->setTransactieId($nieuwTAId);
        $tpObject2->setRolId(2);//verlener
        $tpObject2->setLidId($_POST['verlenerid']);//grote letter lukt niet in een index van $_POST
        //setDelStatus() is niet nodig; zit vervat in insert
        $tpObject2->setAddedBy($_SESSION['username']);
        $tpObject2->insert();

        //aanpassing tabel Doc gebeurt pas bij goedkeuring

        //mail verzenden
        $mail = new PHPMailer();
        //1. connectie properties gmail
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
        $lidObject->setLidId($_SESSION['lidid']);//altijd kleine letters voor superglobal variabelen
        $lidObject->selectLidById();
        $emailVerzender = $lidObject->getEmail();
        echo $emailVerzender;
        $voornaamVerzender = $lidObject->getLidVoornaam();
        echo $voornaamVerzender;
        $naamVerzender = $lidObject->getLidNaam();
        echo $naamVerzender;
        $mail->From = $emailVerzender;//ondanks assignatie verschijnt er hier helaas ron68be@gmail.com in het bericht bij de bestemmeling; niet toevoegen vult ook hetzelfde in
        $mail->FromName =  $voornaamVerzender." ".$naamVerzender;
        $mail->addReplyTo($emailVerzender, $voornaamVerzender." ".$naamVerzender);
        }
   
        //3.e-mail adres en naam van bestemmeling ophalen
        $lidObject1 = new Lid();
        $lidObject1->setLidId($_POST['verlenerid']);
        $lidObject1->selectLidById();
        $emailOntvanger = $lidObject1->getEmail();
        $voornaamOntvanger = $lidObject1->getLidVoornaam();
        $naamOntvanger = $lidObject1->getLidNaam();
    
        $mail->AddAddress($emailOntvanger, $voornaamOntvanger." ".$naamOntvanger);
        $mail->WordWrap = 50;
        $mail->Subject = "Voorstel tot lenen";
        $mail->Body = "Beste, Ik wens enkele van uw documenten te lenen. Gelieve u aan te melden
        op de website van vzw Onder Ons Lezen om deze uitwisseling al dan niet te bevstigen.\n".$voornaamVerzender. " ".$naamVerzender;
        $mail->isHTML(TRUE); 
      
        if($mail->Send())
        {
        $message = "De verlener is succesvol bericht over uw leen voorstel.";
        } 
        else
        {
        $message = "De mail is niet succesvol verzonden naar de verlener.: ". $mail->ErrorInfo."\n"."Contacteer de administrator.";
        }
        $_SESSION['mailmessageexchange'] = $message;
        header('Location: ../view/start_ontlening.php');
}





?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
        <p>insert ta</p>
        <ul>
            <li>Message: <?php echo $taObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $taObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $taObject->getErrorCode(); ?></li>
            <li>ID: <?php echo $taObject->getTransactieId(); ?></li>
        </ul>
        
        <p>laatste insert tdoc</p>
        <ul>
            <li>Message: <?php echo $tdObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $tdObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tdObject->getErrorCode(); ?></li>
            <li>ID: <?php echo $tdObject->getTDId(); ?></li>
        </ul>

        <p>insert tpartner lener</p>
        <ul>
            <li>Message: <?php echo $tpObject1->getFeedback(); ?></li>
            <li>Error message: <?php echo $tpObject1->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tpObject1->getErrorCode(); ?></li>
            <li>ID: <?php echo $tpObject1->getTPId(); ?></li>
        </ul>

        <p>insert tpartner verlenerr</p>
        <ul>
            <li>Message: <?php echo $tpObject2->getFeedback(); ?></li>
            <li>Error message: <?php echo $tpObject2->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tpObject2->getErrorCode(); ?></li>
            <li>ID: <?php echo $tpObject2->getTPId(); ?></li>
        </ul>

        <p>mail verzenden: <?php echo $message;?></p>


        <!--
        <p>Test delete doc</p>
        <ul>
            <li>Message: <?php echo $objectD->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectD->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectD->getErrorCode(); ?></li>
        </ul>
        -->
       
        <!--
        <p>Test update doc</p>
        <ul>
            <li>Message: <?php echo $objectU->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectU->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectU->getErrorCode(); ?></li>
        </ul>
        -->
        
    </body>
</html>


