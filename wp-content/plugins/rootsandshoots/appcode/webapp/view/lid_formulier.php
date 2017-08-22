<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/woonplaats.class.php'); 
include('../model/lid.class.php');

session_start();

if(!isset($_SESSION['lidstatus']) || $_SESSION['lidstatus'] == 1)
{
   if($_SESSION['lidstatus'] == 1)
   {
       //sessionid wissen
       include('../help/sessie.class.php');
       $sessieObject1 = new Sessie();
       $sessieObject1->setId(1);
       $sessieObject1->setLidId($_SESSION['lidid']);
       $sessieObject1->setSessionId(NULL);
       $time = time();
       $sessieObject1->setLastActivity($time);
       $sessieObject1->setModifiedBy($_SESSION['username']);
       $sessieObject1->update();

       //gecachte bestanden wissen
       $files = glob('../view/cached/*');//array van bestanden in de cached folder
       foreach($files as $file)
       {
        if(is_file($file))
        {
            unlink($file);
        }    
       }
      }
   //alle sessie variabelen wissen
   session_destroy();
   header('Location: ../../../index.php');
}
else
{
    $lidStatus = $_SESSION['lidstatus']; 
    include('../help/sessie.class.php');
    Sessie::checkSessionId();
    Sessie::registerLastActivity();//heeft $_SESSION['lidid'] nodig
}

if(isset($_GET['lidid']))
{
    $lidObject = new Lid();
    $lidId = $_GET['lidid'];
    $lidObject->setLidId($lidId);
    $lidObject->selectLidById();
    /*alle variabelen ingevuld in het model*/
}
else{
    $lidObject = new Lid();
    $lidObject->setLidId("");
    $lidObject->setLidNaam("");
    $lidObject->setLidVoornaam("");
    $lidObject->setLidInfo("");
    $lidObject->setAdres("");
    $lidObject->setTelefoon("");
    $lidObject->setEmail("");
    $lidObject->setSkypeNaam("");
    $lidObject->setWoonId("");
    $lidObject->setGebruikersNaam("");
    $lidObject->setWachtwoord("");
}

$woonplaatsObject = new Woonplaats();
$woonplaatsen = $woonplaatsObject->selectAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Lid formulier</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/formulier.css" type="text/css">
        <?php include ('../help/jquery.php');?>
        <script type="text/javascript">
            $(document).ready(function () {
                //1. menu
                $("#jMenu").jMenu(
                {
                    ulWidth: '220px',
                    effects: {
                        effectSpeedOpen: 300,
                        effectTypeClose: 'slide'
                    },
                    animatedText: true
                });

                //2. aanpassingen igv wijzigen
                if (window.location.href.indexOf('?') != '-1') {//nagaan of er een querystring is
                    var alertTekst = $("strong").text();
                    var nieuweString = alertTekst.replace("toevoegen", "wijzigen"); //retourneert een nieuwe string
                    $("strong").text(nieuweString);
                    $("#btnLidSave").text("Wijzigen");
                    $("#btnLidCancel").remove();
                    $("#btnLidSave").attr(
                    {
                       id: "btnLidUpdate",
                       name: "btnLidUpdate" 
                    });
                }

                //3. opslaan en cancel button voorzien van stijl
                $("button[type=submit]").button(
                {
                    icons: { primary: " ui-icon-disk" }
                });
                $("button[type=reset]").button(
                {
                    icons: { primary: " ui-icon-cancel" }
                });

            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
            <div class="welcoming">Administrator</div>
        </div>
        </div>
            
        <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Lid toevoegen</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="leden.php" class="buttonterug">&nbsp;Terug</a>
        </p>
        <form id="frmLid" method="POST" action="../control/lid.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
                 <label for="naamLid" class="control-label">NAAM:</label><div class="controls"><input id="naamLid" name="naamLid" type="text" autofocus="true" value="<?php echo $lidObject->getLidNaam();?>" required></div>
            </div>
            <div class="control-group">
                 <label for="voornaamLid" class="control-label">VOORNAAM:</label><div class="controls"><input id="voornaamLid" name="voornaamLid" type="text" value="<?php echo $lidObject->getLidVoornaam();?>" required></div>
            </div>
            <div class="control-group">
                  <label for="username" class="control-label">GEBRUIKERSNAAM:</label><div class="controls"><input id="username" name="username" value="<?php echo $lidObject->getGebruikersNaam();?>" required></div>
            </div>
            <div class="control-group">
                  <label for="password" class="control-label">WACHTWOORD:</label><div class="controls"><input id="password" name="password" value="<?php echo $lidObject->getWachtwoord();?>" required></div>
            </div>
            <div class="control-group">
                 <label for="infoLid" class="control-label">INFO:</label><div class="controls"><input id="infoLid" name="infoLid" type="text" value="<?php echo $lidObject->getLidInfo();?>"></div>
            </div>
            <div class="control-group">
                 <label for="adres" class="control-label">ADRES:</label><div class="controls"><input id="adres" name="adres" type="text" value="<?php echo $lidObject->getAdres();?>"></div>
            </div>
            <div class="control-group">
            <label for="woonid" class="control-label">WOONPLAATS:</label><div class="controls">
            <select id="woonid" name="woonid">
                            <option id="woonplaats0" value="0"></option> 
                            <?php
                            foreach($woonplaatsen as $woonplaats)
                            {
                            ?>
                            <option id="<?php echo "woonplaats".$woonplaats['WoonplaatsId']; ?>" value="<?php echo $woonplaats['WoonplaatsId'];?>" <?php if($lidObject->getWoonId() == $woonplaats['WoonplaatsId']) {echo "selected";}?>><?php echo $woonplaats['Postcode']." ".$woonplaats['Gemeente'];?></option> 
                            <?php
                            }
                            ?>
            </select>
            </div>
            </div>
            <div class="control-group">
                 <label for="telefoon" class="control-label">TELEFOON:</label><div class="controls"><input id="telefoon" name="telefoon" type="text" value="<?php echo $lidObject->getTelefoon();?>"></div>
            </div>
            <div class="control-group">
                 <label for="email" class="control-label">E-MAIL:</label><div class="controls"><input id="email" name="email" type="text" value="<?php echo $lidObject->getEmail();?>" required></div>
            </div>
            <div class="control-group">
                 <label for="skype" class="control-label">SKYPE NAAM:</label><div class="controls"><input id="skype" name="skype" type="text" value="<?php echo $lidObject->getSkypeNaam();?>"></div>
            </div>

            <div class="control-group">
                 <input id="idHidden" name="idHidden" value="<?php echo $lidObject->getLidId(); ?>">
            </div>         
            <div class="control-group">
                <div class="controls">
                <button id="btnLidSave" name="btnLidSave" type="submit">&nbsp;Opslaan</button>
                <button id="btnLidCancel" type="reset">&nbsp;Annuleren</button>
                </div>
            </div>          
         </form>     
         <div class="push"></div>     
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>    
    </body>
</html>
