<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/foto.class.php');
include('../model/lid.class.php');
include('../model/registratie.class.php');

session_start();

if(!isset($_SESSION['lidstatus']))
{
   header('Location: ../../../index.php');
}
else
{
    //ctln of het de eigenaar is die inkijkt
    $docId =  $_GET['documentid'];
    $lidId = eigenaarOphalen($docId);//ook bij onbestaande docid wordt er uitgelogd
    if($lidId != $_SESSION['lidid'])
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
}

//eigenaar van het getoonde doc ophalen
function eigenaarOphalen($docId)
{
    $registratieObject = new Registratie();
    $registratieObject->setDocId($docId);
    $registratieObject->selectRegistratieByDocId();
    $lidId=$registratieObject->getLidId();
    return $lidId;
}

//tbv welcoming
if(isset($_SESSION['lidid']))
{
    $lidObject = new Lid();
    $lidObject->setLidId($_SESSION['lidid']);
    $lid = $lidObject->selectLidById();
}

if(isset($_GET['fotoid']))
{
    $fotoId = $_GET['fotoid'];
    $fotoObject = new Foto();
    $fotoObject->setFotoId($fotoId);
    $foto = $fotoObject->selectFotoById();
    $fotoNaam = $fotoObject->getFotoNaam();
    $fotoURL = $fotoObject->getURL();
    $docId = $fotoObject->getDocId();
}

if(isset($_GET['documentid']))
{
    $docId = $_GET['documentid'];
    $_SESSION['docidbijfotoupload'] = $docId;
}

//nagaan of document in transactie is
function transactieChecken($docId)
{
    $docObject = new Doc();
    $docObject->setDocId($docId);
    $jaOfNee = $docObject->isDocInTransaction();
    return $jaOfNee ;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Foto formulier</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/fotoformulier.css" type="text/css">
        <?php include ('../help/jquery.php');?>
        <script type="text/javascript">
            $(document).ready(function () {
                //1. hoofdmenu
                $("#jMenu").jMenu(
                {
                    ulWidth: '220px',
                    effects: {
                        effectSpeedOpen: 300,
                        effectTypeClose: 'slide'
                    },
                    animatedText: true
                });

                //2. buttons
                $("button[id=btnFotoWijzig]").button(
                {
                    icons: { primary: " ui-icon-disk" }
                });
                $("button[id=btnFotoDelete]").button(
                {
                    icons: { primary: " ui-icon-trash" }
                });

                //3. foto verwijderen
                $("#btnFotoDelete").on('click', verwijderFoto);
            }); //einde ready event

            function verwijderFoto() {
                var id = $("#fotoid").attr("value"); //waarde van attribuut lezen in jQuery
                //dialog widget bij verwijderen record
                $("#warningDeletion").dialog(
                {
                    buttons: [
                {
                    text: "Ja",
                    click: function () { window.location.href = '../control/foto.control.php?fotoid=' + id; }
                },
                {
                    text: "Nee",
                    click: function () { $(this).dialog("close"); }
                }]
                });
            } //einde verwijderFoto

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
             <div class="welcoming"><?php if ($lidStatus == 2) {echo "administrator";} elseif($lidStatus == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} elseif($lidStatus == 0) {echo "bezoeker";}?></div>
        </div>
        </div>
     
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Foto formulier</strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="documentfotos_view.php?documentid=<?php echo $docId;?>" class="buttonterug">&nbsp;Terug</a>
        </p>
        <form class="form-horizontal">
            <?php
            if(isset($_GET['documentid']))
            {
            ?>
            <div class="control-group">
                <label for="fotoid" class="control-label">foto nr:</label>
                <div class="controls"><input id="fotoid" name="fotoid" type="text" value="<?php echo $fotoObject->getFotoId();?>" readonly="true"></div>
            </div>
            <?php
            }
            ?>
            
            <div class="control-group">
                <label for="nieuwenaam" class="control-label">naam:</label>
                <div class="controls"><input id="nieuwenaam" name="nieuwenaam" type="text" value="<?php echo $fotoNaam;?>" readonly="true"></div>
            </div>
            
            <div class="control-group">
                <div class="controls">
                    <img id="<?php echo $fotoNaam;?>" alt="<?php echo $fotoNaam;?>" title="<?php echo $fotoNaam;?>" src="<?php echo $fotoURL.$fotoNaam;?>"/>
                </div>
            </div>

            
            <input type="hidden" id="url" name="url" value="<?php echo $fotoURL;?>" /> 
            <input type="hidden" id="docid" name="docid" value="<?php echo $docId;?>" />
            </form>
            <?php
            if(transactieChecken($docId) != 1)
            {
            ?>
            <button id="btnFotoDelete">&nbsp;Foto wissen</button>
            <?php
            }
            ?>
            <div id="warningDeletion">Bent u zeker om deze foto te verwijderen?</div>
            <div class="push"></div>  
    </div>
    <div id="footer" class="footer">vzw Onder Ons Lezen</div>  
</body>
</html>
