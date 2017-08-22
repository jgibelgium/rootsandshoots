<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/lid.class.php');
include('../../webapp/help/class.loginattempt.php');
include('../../webapp/help/sessie.class.php');
include('../help/class.phpmailer.php');
include('../help/class.smtp.php');

session_start();

function isBruteForceAttack($userId) 
{
            // Get timestamp of current time
            $now = time();
            // All login attempts are counted from the past 2 hours. 
            $twohoursago = $now - (2 * 60 * 60); 

            $loginAttempt = new LoginAttempt();
            $loginAttempt->SetIdMember($userId);
            $loginAttempt->SetTime($twohoursago);
            $count = $loginAttempt->CountIdMemberByTime();
            echo "aantal: ".$count[0];
            if($count[0] > 10)
            {
                return "true";
            }
            else
            {
                return "false";
            }
}

//1. vorige user heeft netjes uitgelogd
$sessieObject = new Sessie();
$sessieObject->setId(1);
$sessieObject->selectSessieById();
if($sessieObject->getSessionId() == NULL)//wel toegang
{
//1.1. check gebruikersnaam 
$lidObject = new Lid();
$lidObject->setGebruikersNaam($_POST['gebruikersnaam']);
$result = $lidObject->selectLidByGebruikersNaam();
if($result == FALSE)
{
    $_SESSION['foutmeldinggebruikersnaam'] = "Gebruikersnaam niet gekend.";
    //herladen loginformulier met foutmelding over gebruikersnaam
    header('Location: ../../../index.php');
}
else
{
    //1.2. nagaan of het account van de gebruiker open is
    $lidId = $result[0]['LidId'];
    $gesloten = $result[0]['Gesloten'];
    if($gesloten != 0) //account is niet open
    {
         $_SESSION['melding'] = "Account gesloten";
         header('Location: ../../../index.php');
    }
    else //account open
    {
    $laObject1 = new loginAttempt();
    $laObject1->setIdMember($lidId);
    $laObject1->setTime(time());
    $laObject1->setInsertedBy('admin');
    $laObject1->insert();

    //1.3. check wachtwoord
    if($result[0]['Wachtwoord'] == $_POST['wachtwoord']) 
    {
        //toegang verleend
        $_SESSION['lidstatus'] = $result[0]['LidStatus'];
        $_SESSION['lidid'] =  $result[0]['LidId'];
        $_SESSION['username'] = $result[0]['GebruikersNaam'];//tbv AddedBy en ModifiedBy

        //registratie in de tabel Sessie;
        $sessieObject1 = new Sessie();
        $sessieObject1->setId(1);
        $sessieObject1->setLidId( $_SESSION['lidid']);
        $sessieObject1->setSessionId(session_id());
        $time = time();
        $sessieObject1->setLastActivity($time);
        $sessieObject1->setModifiedBy($_SESSION['username']);
        $sessieObject1->update();
        header('Location: ../../../appcode/webapp/view/welkom.php');
    }
    else
    {
        //1.4. controleren op brute force attack
        $bfa = isBruteForceAttack($lidId);
        if($bfa == "true")
        {
        //mail verzenden
        $mail = new PHPMailer();
        $mail->isSMTP();//vergt class.smtp.php
        $mail->SMTPDebug = 2;/*sets the debugging on; niet nodig in productie*/
        $mail->Host = 'ssl0.ovh.net'; // beveiligde SMTP server bij ovh.net
        $mail->SMTPAuth = TRUE;   // Enable SMTP authentication; wellicht na registratie op de SMTP server
        $mail->Username = 'postmaster@rfewebsites.be';
        $mail->Password = 'dlanor12'; //SMTP wachtwoord bij ovh.net
        $mail->SMTPSecure = 'ssl';//beveiligingstype
        $mail->Port = 465;//dezelfde poort bij Google en ovh.net
        $emailAdresAdmin = 'postmaster@rfewebsites.be';
        $mail->From =  $emailAdresAdmin;
        $mail->FromName = 'Beheerder vzw Onder Ons Lezen';
        $mail->addReplyTo($emailAdresAdmin); 
        $lidObject1 = new Lid();
        $lidObject1->setLidId($lidId);
        $lidObject1->selectLidById();
        $emailOntvanger = $lidObject1->getEmail();
        $voornaamOntvanger = $lidObject1->getLidVoornaam();
        $naamOntvanger = $lidObject1->getLidNaam();
        $mail->AddAddress($emailOntvanger, $voornaamOntvanger." ".$naamOntvanger);
        $mail->WordWrap = 50;
        $mail->Subject = "Sluiten van uw account bij Onder Ons Lezen";
        $mail->Body = "Beste, wegens een brute aanval op uw account is uw account tijdelijk gesloten. Contacteer de administrator."."\n"."Beheerder Onder Ons Lezen";
        $mail->isHTML(TRUE); 
        $mail->Send();


        //account sluiten
        $lidObject2 = new Lid();
        $lidObject2->setLidId($lidId);
        $lidObject2->setGesloten(TRUE);
        $lidObject2->setmodifiedBy('admin');
        $lidObject2->closeAccount();
        //melding
        $_SESSION['melding'] = "Account gesloten. Contacteer administrator";
        header('Location: ../../../index.php');
        }
        else
        {   
        $_SESSION['gebruikersnaam'] = $_POST['gebruikersnaam'];
        $_SESSION['foutmeldingwachtwoord'] = "Ongeldig wachtwoord";
        //herladen loginformulier met foutmelding over wachtwoord en gebruikersnaam
        header('Location: ../../../index.php');
        }
    }

    }

}
}//einde sessionId == NULL

//2. vorige user sloot browser: sessionid != null
else 
{
        $nieuweUsername = $_POST['gebruikersnaam'];
        $lidObject3 = new Lid();
        $lidObject3->setGebruikersNaam($_POST['gebruikersnaam']);
        $nieuwLid = $lidObject3->selectLidByGebruikersNaam();
        $nieuwLidId = $nieuwLid[0]['LidId'];
        
        $sessieObject3 = new Sessie();
        $sessieObject3->setId(1);
        $sessie = $sessieObject3->selectSessieById();
        $oudLidId =$sessie[0]['LidId'];

        if($nieuwLidId == $oudLidId)//lidid gelijk aan dat in databank: sessionid hernieuwen; wel toegang
        {
            //toegang verleend
            $_SESSION['lidstatus'] = $nieuwLid[0]['LidStatus'];
            $_SESSION['lidid'] =  $nieuwLid[0]['LidId'];
            $_SESSION['username'] = $nieuwLid[0]['GebruikersNaam'];//tbv AddedBy en ModifiedBy

            $sessieObject2 = new Sessie();
            $sessieObject2->setId(1);
            $sessieObject2->setLidId($oudLidId);
            $sessieObject2->setSessionId(session_id());
            $time = time();
            $sessieObject2->setLastActivity($time);
            $sessieObject2->setModifiedBy($nieuweUsername);
            $sessieObject2->update();
            header('Location: ../../../appcode/webapp/view/welkom.php');
        }
        else//lidid niet gelijk aan dat in databank: sessionid hernieuwen
        {
            $sessieObject4= new Sessie();
            $sessieObject4->setId(1);
            $sessie = $sessieObject4->selectSessieById();
            $lastAct = $sessie[0]['LastActivity'];
            echo $lastAct;
            $now = time();
            if($lastAct < $now - 1200)
            {
                //last activity > 20 minute geleden; overschrijven van lidid en sessionid; wel toegang verleend
                //toegang verleend
                $_SESSION['lidstatus'] = $nieuwLid[0]['LidStatus'];
                $_SESSION['lidid'] =  $nieuwLid[0]['LidId'];
                $_SESSION['username'] = $nieuwLid[0]['GebruikersNaam'];//tbv AddedBy en ModifiedBy

                $sessieObject4->setLidId($nieuwLidId);
                $sessieObject4->setSessionId(session_id());
                $time = time();
                $sessieObject4->setLastActivity($time);
                $sessieObject4->setModifiedBy($nieuweUsername);
                $sessieObject4->update();

                //gecachte bestanden van de vorige gebruiker wissen
                $files = glob('../view/cached/*');//array van bestanden in de cached folder
                foreach($files as $file)
                {
                    if(is_file($file))
                    {
                        unlink($file);
                    }    
                }
                header('Location: ../../../appcode/webapp/view/welkom.php');
            }
            else
            {
                //last activity < 20 minuten geleden; melding iemand is bezig; geen toegang
                header('Location: ../view/website_bezet.php');
            }
        }
}





?>


