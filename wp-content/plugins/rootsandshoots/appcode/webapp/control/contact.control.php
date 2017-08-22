<?php
include('../../../appcode/helpers/feedback.class.php');    
include('../../helpers/base.class.php');    
include('../help/class.phpmailer.php');
include('../help/class.smtp.php');
include('../model/lid.class.php'); 
include('../help/cleaninput.php');

session_start();

if(isset($_POST['btnContactVerzend']))
{
    $_POST = opschonenInput($_POST);
    echo "lidid van bestemmeling: ".$_POST['lidid']."<br />";

    $mail = new PHPMailer();
    // connectie properties gmail
    // $mail->isSMTP();//vergt class.smtp.php
    // $mail->SMTPDebug = 2;/*sets the debugging on; niet nodig in productie*/
    // $mail->Host = 'smtp.gmail.com';
    // $mail->SMTPAuth = TRUE;   // Enable SMTP authentication; wellicht na registratie op de SMTP server
    // $mail->Username = 'ron68be@gmail.com';//SMTP username? http://email.about.com/od/accessinggmail/f/Gmail_SMTP_Settings.htm
    // $mail->Password = 'ron7zq01%'; //SMTP wachtwoord bij Google
    // $mail->SMTPSecure = 'ssl';//beveiligingstype
    // $mail->Port = 465;//dezelfde poort bij Google en ovh.net
    // $emailAdresAdmin = 'ron68be@gmail.com';

    // connectie properties ovh.net
    $mail->isSMTP();//vergt class.smtp.php
    $mail->SMTPDebug = 2;/*sets the debugging on; niet nodig in productie*/
    $mail->Host = 'ssl0.ovh.net'; // beveiligde SMTP server bij ovh.net
    $mail->SMTPAuth = TRUE;   // Enable SMTP authentication; wellicht na registratie op de SMTP server
    $mail->Username = 'postmaster@rfewebsites.be';
    $mail->Password = 'dlanor12'; //SMTP wachtwoord bij ovh.net
    $mail->SMTPSecure = 'ssl';//beveiligingstype
    $mail->Port = 465;//dezelfde poort bij Google en ovh.net
    $emailAdresAdmin = 'postmaster@rfewebsites.be';
    



    //email en naam van verzender
    if($_SESSION['lidstatus'] == 2){
        $mail->From = $emailAdresAdmin; //ondanks assignatie verschijnt er hier ron68be@gmail.com in het bericht bij de bestemmeling; misschien nodig om de mailbox van gmail te geruiken; niet toevoegen vult ook hetzelfde in
        $mail->FromName = 'Beheerder vzw Onder Ons Lezen';
        $mail->addReplyTo($emailAdresAdmin);   
    }
    elseif($_SESSION['lidstatus'] == 1){
        //e-mail adres en naam van lid ophalen
        $lidObject = new Lid();
        $lidObject->setLidId($_SESSION['lidid']);
        $lidObject->selectLidById();
        $emailVerzender = $lidObject->getEmail();
        echo "email verzender: ".$emailVerzender."<br />";
        $voornaamVerzender = $lidObject->getLidVoornaam();
        echo $voornaamVerzender;
        $naamVerzender = $lidObject->getLidNaam();
        echo $naamVerzender;
        $mail->From = $emailVerzender;//ondanks assignatie verschijnt er hier helaas ron68be@gmail.com in het bericht bij de bestemmeling; niet toevoegen vult ook hetzelfde in; correct bij ovh.net
        $mail->FromName =  $voornaamVerzender." ".$naamVerzender;
        $mail->addReplyTo($emailVerzender, $voornaamVerzender." ".$naamVerzender);
    }
   
    //e-mail adres en naam van bestemmeling ophalen
    $lidObject1 = new Lid();
    $lidObject1->setLidId($_POST['lidid']);
    $lidObject1->selectLidById();
    $emailOntvanger = $lidObject1->getEmail();
    $voornaamOntvanger = $lidObject1->getLidVoornaam();
    $naamOntvanger = $lidObject1->getLidNaam();
    
    $mail->AddAddress($emailOntvanger, $voornaamOntvanger." ".$naamOntvanger);
    $mail->WordWrap = 50;
    $mail->Subject = $_POST['onderwerp'];
    $mail->Body = $_POST['bericht'];//moet ingevuld zijn
    $mail->isHTML(TRUE); 
      
    if($mail->Send())
    {
        echo "mail verzonden";
        $message = "Uw mail is succesvol verzonden.";
    } 
    else
    {
        echo "mail nt verzonden";
        $message = "De mail is niet verzonden: " .$mail->ErrorInfo. " Contacteer de administrator.";
    }
    $_SESSION['mailmessage'] = $message;
    header('Location: ../view/contact_formulier.php');
}

?>

