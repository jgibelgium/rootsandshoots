<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/dockenmerk.class.php');
include('../model/foto.class.php');
include('../model/registratie.class.php');
include('../model/transactie.class.php');
include('../model/lid.class.php'); 
include('../help/cleaninput.php');
session_start();



//admin verwijdert lid
if(isset($_GET['lidid']))
{
    $lidId = $_GET['lidid'];
    //vw1: nagaan of lid nog hangende transacties heeft
    $taObject1 = new Transactie();
    $mhd = $taObject1->selectMijnHangendeDeals($lidId);
    if($mhd != NULL && count($mhd) != 0)
    {
        $deleteMessage = "Account verwijdering pas mogelijk als alle transacties van het lid beëindigd zijn.";
        $_SESSION['deletemessage'] = $deleteMessage;
        header('Location: ../../../appcode/webapp/view/leden.php');
        exit;
    }

    $taObject2 = new Transactie();
    $mhe = $taObject2->selectMijnHangendeExchanges($lidId);
    if(count($mhe) != 0)
    {
        $deleteMessage = "Account verwijdering pas mogelijk als alle uitwisselingen van het lid beëindigd zijn.";
        $_SESSION['deletemessage'] = $deleteMessage;
        header('Location: ../../../appcode/webapp/view/leden.php');
        exit;
    }

    //vw2: nagaan of lid nog beschikbare docs heeft
    $docObject3 = new Doc();
    $besdocs = $docObject3->selectDocumentenPerLid($lidId);
    if(count($besdocs) != 0)
    {
        $deleteMessage = "Account verwijdering pas mogelijk als alle beschikbare documenten van het lid gewist zijn.";
        $_SESSION['deletemessage'] = $deleteMessage;
        header('Location: ../../../appcode/webapp/view/leden.php');
        exit;
    }


    //vw3: automatisch verwijderen van de verkochte docs van het lid
    //1. verkoopdeals vh lid ophalen
    $taObject = new Transactie();
    $mijnVorigeVerkopen = $taObject->selectMijnVorigeVerkopen($lidId);


    //2. de verkochte docs van het lid ophalen
    foreach($mijnVorigeVerkopen as $mvv)
    {
        $dealId = $mvv['transactieid'];
        $docObject = new Doc();
        $docsInDeal = $docObject->selectDocsInDeal($dealId);
        
        foreach($docsInDeal as $did)
        {
             //3. de fotos en de dockenmerken vd verkochte docs wissen
             $docId = $did['docid'];
             //1. fotos wissen
             $fotoObject = new Foto();
             $fotoObject->setDocId($docId);
             $fotoRecords = $fotoObject->selectFotoByDocId();
             foreach($fotoRecords as $fotoRecord)
             {
             //fysiek wissen foto
             $fotoNaam = $fotoRecord['FotoNaam'];
             unlink('../../../appcode/webapp/view/fotouploads/thumbs/'.$fotoNaam);
             //data over foto wissen
             $fotoObject2 = new Foto();
             $fotoId = $fotoRecord['FotoId'];
             $fotoObject2->setFotoId($fotoId);
             $fotoObject2->delete();
             }
             //2. dockenmerken wissen
             $docKenmerkObject = new DocKenmerk();
             $docKenmerkObject->setDocId($docId);
             $docKenmerken = $docKenmerkObject->selectDocKenmerkByDocId();
             foreach($docKenmerken as $docKenmerk)
             {
                 $dkId = $docKenmerk['DocKenmerkId'];
                 $dkObject = new DocKenmerk();
                 $dkObject->setDocKenmerkId($dkId);
                 $dkObject->delete();
             }

             //3. docs wissen; ook registratierecords worden gewist gezien on delete cascade
             $docObject2 = new Doc();
             $docObject2->setDocId($docId);
             $docObject2->delete();

        }
    }

    //account wissen in de tabel lid; ook registratierecords en loginattemptrecords worden gewist gezien on delete cascade
    $lidObject = new Lid();
    $lidObject->setLidId($lidId);
    $result = $lidObject->delete();
    
    if($result)
    {
        header('Location: ../../../appcode/webapp/view/leden.php');
    }
    else
    {
        $deleteMessage = "Geen account verwijdering mogelijk. Contacteer de administrator.";//normaal gezien zinloos gezien on delete cascade
        $_SESSION['deletemessage'] = $deleteMessage;//normaal zinloos gezien on delete cascade
        header('Location: ../../../appcode/webapp/view/leden.php');
    }
    
}

//toevoegen lid door admin
//$_POST is always set, but its content might be empty.
if(isset($_POST['btnLidSave']))
{
        $_POST = opschonenInput($_POST);
        $lidObject = new Lid();
        $lidObject->setLidNaam($_POST['naamLid']);
        $lidObject->setLidVoornaam($_POST['voornaamLid']);
        $lidObject->setLidInfo($_POST['infoLid']);
        $lidObject->setGebruikersNaam($_POST['username']);
        $lidObject->setWachtwoord($_POST['password']);
        $lidObject->setAdres($_POST['adres']);
        $lidObject->setWoonId($_POST['woonid']);
        $lidObject->setTelefoon($_POST['telefoon']);
        $lidObject->setEmail($_POST['email']);
        $lidObject->setSkypeNaam($_POST['skype']);
        $lidObject->setGesloten(FALSE);/*NOT NULL in MySQL*/
        $lidObject->setLidStatus(1);/*NULL in MySQL*/
        $lidObject->setAddedBy('admin');
        $lidObject->insert();
        header('Location: ../../../appcode/webapp/view/leden.php');
}
//admin wijzigt lid: alle argumenten moeten opgegeven worden; is niet zo bij een insert
elseif(isset($_POST['btnLidUpdate']))
{
        $_POST = opschonenInput($_POST);
        $lidObject = new Lid();
        $lidObject->setLidId($_POST['idHidden']);
        $lidObject->setLidNaam($_POST['naamLid']);
        $lidObject->setLidVoornaam($_POST['voornaamLid']);

        $lidObject->setGebruikersNaam($_POST['username']);
        $lidObject->setWachtwoord($_POST['password']);
        $lidObject->setLidInfo($_POST['infoLid']);
        $lidObject->setAdres($_POST['adres']);
        $lidObject->setWoonId($_POST['woonid']);
        $lidObject->setTelefoon($_POST['telefoon']);
        $lidObject->setEmail($_POST['email']);
        $lidObject->setSkypeNaam($_POST['skype']);
        $lidObject->setGesloten(FALSE);/*NOT NULL in MySQL*/
        $lidObject->setLidStatus(1);/*NULL in MySQL*/
        $lidObject->setModifiedBy('admin');
        $lidObject->update();
        header('Location: ../../../appcode/webapp/view/leden.php');
}



//lid wijzigt account
if(isset($_POST['btnAccountUpdate']))
{
        $_POST = opschonenInput($_POST);
        $lidObject = new Lid();
        $lidObject->setLidId($_POST['idHidden']);
        $lidObject->setLidNaam($_POST['naamLid']);
        $lidObject->setLidVoornaam($_POST['voornaamLid']);
        $lidObject->setGebruikersNaam($_POST['username']);
        $lidObject->setWachtwoord($_POST['password']);
        $lidObject->setLidInfo($_POST['infoLid']);
        $lidObject->setAdres($_POST['adres']);
        $lidObject->setWoonId($_POST['woonid']);
        $lidObject->setTelefoon($_POST['telefoon']);
        $lidObject->setEmail($_POST['email']);
        $lidObject->setSkypeNaam($_POST['skype']);
        $lidObject->setGesloten(FALSE);/*NOT NULL in MySQL*/
        $lidObject->setLidStatus(1);/*NULL in MySQL*/
        $lidObject->setModifiedBy($_POST['naamLid']);
        $lidObject->update();
        header('Location: ../../../appcode/webapp/view/welkom.php');
}

//lid verwijdert zijn account
if(isset($_GET['accountid']))
{
    //vw1: nagaan of lid nog hangende transacties heeft
    $taObject1 = new Transactie();
    $mhd = $taObject1->selectMijnHangendeDeals($_SESSION['lidid']);
    if(count($mhd) != 0)
    {
        $deleteMessage = "Account verwijdering pas mogelijk als alle transacties beêindigd zijn.";
        $_SESSION['deletemessage'] = $deleteMessage;
        header('Location: ../../../appcode/webapp/view/mijn_account.php');
        exit;
    }

    $taObject2 = new Transactie();
    $mhe = $taObject2->selectMijnHangendeExchanges($_SESSION['lidid']);
    if(count($mhe) != 0)
    {
        $deleteMessage = "Account verwijdering pas mogelijk als alle uitwisselingen beëindigd zijn.";
        $_SESSION['deletemessage'] = $deleteMessage;
        header('Location: ../../../appcode/webapp/view/mijn_account.php');
        exit;
    }

    //vw2: nagaan of lid nog beschikbare docs heeft
    $docObject4 = new Doc();
    $besdocs = $docObject4->selectDocumentenPerLid($_SESSION['lidid']);
    if(count($besdocs) != 0)
    {
        $deleteMessage = "Account verwijdering pas mogelijk als al uw beschikbare documenten gewist zijn.";
        $_SESSION['deletemessage'] = $deleteMessage;
        header('Location: ../../../appcode/webapp/view/mijn_account.php');
        exit;
    }


    //vw3: automatisch verwijderen van de verkochte docs van het lid
    //1. verkoopdeals vh lid ophalen
    $taObject = new Transactie();
    $mijnVorigeVerkopen = $taObject->selectMijnVorigeVerkopen($_SESSION['lidid']);


    //2. de verkochte docs van het lid ophalen
    foreach($mijnVorigeVerkopen as $mvv)
    {
        $dealId = $mvv['transactieid'];
        $docObject = new Doc();
        $docsInDeal = $docObject->selectDocsInDeal($dealId);
        
        foreach($docsInDeal as $did)
        {
             //3. de fotos en de dockenmerken vd verkochte docs wissen
             $docId = $did['docid'];
             //1. fotos wissen
             $fotoObject = new Foto();
             $fotoObject->setDocId($docId);
             $fotoRecords = $fotoObject->selectFotoByDocId();
             foreach($fotoRecords as $fotoRecord)
             {
             //fysiek wissen foto
             $fotoNaam = $fotoRecord['FotoNaam'];
             unlink('../../../appcode/webapp/view/fotouploads/thumbs/'.$fotoNaam);
             //data over foto wissen
             $fotoObject2 = new Foto();
             $fotoId = $fotoRecord['FotoId'];
             $fotoObject2->setFotoId($fotoId);
             $fotoObject2->delete();
             }
             //2. dockenmerken wissen
             $docKenmerkObject = new DocKenmerk();
             $docKenmerkObject->setDocId($docId);
             $docKenmerken = $docKenmerkObject->selectDocKenmerkByDocId();
             foreach($docKenmerken as $docKenmerk)
             {
                 $dkId = $docKenmerk['DocKenmerkId'];
                 $dkObject = new DocKenmerk();
                 $dkObject->setDocKenmerkId($dkId);
                 $dkObject->delete();
             }

             //3. docs wissen; ook registratierecords worden gewist gezien on delete cascade
             $docObject2 = new Doc();
             $docObject2->setDocId($docId);
             $docObject2->delete();

        }
    }

    //account wissen in de tabel lid; ook registratierecords en loginattemptrecords worden gewist gezien on delete cascade
    $lidObject = new Lid();
    $lidId = $_GET['accountid'];
    $lidObject->setLidId($lidId);
    $result = $lidObject->delete();
    
    if($result)
    {
        header('Location: ../../../appcode/webapp/control/logout.control.php');
    }
    else
    {
        $deleteMessage = "Geen account verwijdering mogelijk. Contacteer de administrator.";//normaal gezien zinloos gezien on delete cascade
        $_SESSION['deletemessage'] = $deleteMessage;//normaal zinloos gezien on delete cascade
        header('Location: ../../../appcode/webapp/view/mijn_account.php');
    }
}

?>





