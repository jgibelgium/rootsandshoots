<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/auteur.class.php');   

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

if(isset($_POST['auteurid']))
{
    $auteurObject = new Auteur();
    $auteurId = $_POST['auteurid'];
    $auteurObject->setAuteurId($auteurId);
    $auteurObject->selectAuteurById();
}
else
{
    $auteurObject = new Auteur();
    $auteurObject->setAuteurId("");
    $auteurObject->setAuteurNaam("");
    $auteurObject->setAuteurVoornaam("");
    $auteurObject->setAuteurInfo("");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Auteur formulier</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/formulier.css" type="text/css">
        <link rel="stylesheet" href="css/registreer.css" type="text/css">
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
                /*
                if (window.location.href.indexOf('?') != '-1') {//nagaan of er een querystring is
                    var alertTekst = $("strong").text();
                    var nieuweString = alertTekst.replace("toevoegen", "wijzigen"); //retourneert een nieuwe string
                    $("strong").text(nieuweString);
                    $("#btnAuteurSave").text("Wijzigen");
                    $("#btnAuteurCancel").remove();
                    $("#btnAuteurSave").attr(
                    {
                        id: "btnAuteurUpdate",
                        name: "btnAuteurUpdate"
                    });
                }
                */

                //2. opslaan en cancel button voorzien van stijl
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
                <strong>&nbsp;<?php if(empty($_POST['auteurid'])){echo "Auteur toevoegen";} else {echo "Auteur wijzigen";}?></strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="auteurs.php" class="buttonterug">&nbsp;Terug</a>
        </p>
        <form id="frmAuteur" method="POST" action="../control/auteur.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
                 <label for="naamAuteur" class="control-label">NAAM:</label><div class="controls"><input id="naamAuteur" name="naamAuteur" type="text" autofocus="true" value="<?php echo $auteurObject->getAuteurNaam();?>" required></div>
            </div>
            <div class="control-group">
                 <label for="voornaamAuteur" class="control-label">VOORNAAM:</label><div class="controls"><input id="voornaamAuteur" name="voornaamAuteur" type="text" value="<?php echo $auteurObject->getAuteurVoornaam();?>"></div>
            </div>
            <div class="control-group">
                  <label for="infoAuteur" class="control-label">INFO:</label><div class="controls"><textarea id="infoAuteur" name="infoAuteur" rows="5" cols="40" placeholder="max 255 karakters" style="resize: none"><?php echo $auteurObject->getAuteurInfo();?></textarea></div>
            </div>
            <div class="control-group">
                 <input id="idHidden" name="idHidden" value="<?php echo $auteurObject->getAuteurId(); ?>">
            </div>         
            <div class="control-group">
                <div class="controls">
                <?php
                if(empty($_POST['auteurid']))
                {    
                ?>
                <button id="btnAuteurSave" name="btnAuteurSave" type="submit">&nbsp;Opslaan</button>
                <button id="btnAuteurCancel" type="reset">&nbsp;Annuleren</button>
                <?php
                }
                else
                {
                ?>
                <button id="btnAuteurUpdate" name="btnAuteurUpdate" type="submit">&nbsp;Wijzigen</button>
                <?php
                }
                ?>
                </div>
            </div>          
         </form>     
           <div class="push"></div> 
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>         
    </body>
</html>
