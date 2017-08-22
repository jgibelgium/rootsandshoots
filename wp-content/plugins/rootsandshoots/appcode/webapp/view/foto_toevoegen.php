<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/lid.class.php');
include('../model/registratie.class.php');

session_start();

if(!isset($_SESSION['lidstatus']))
{
   header('Location: ../../../index.php');
}
else
{
    //ctln of het de eigenaar is die toevoegt
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

//tbv welcoming
if(isset($_SESSION['lidid']))
{
    $lidObject = new Lid();
    $lidObject->setLidId($_SESSION['lidid']);
    $lid = $lidObject->selectLidById();
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

if(isset($_GET['documentid']))
{
    $docId = $_GET['documentid'];
    $_SESSION['docidbijfotoupload'] = $docId;
}

$uploadMessage = isset($_SESSION['uploadmessage'])? $_SESSION['uploadmessage'] : "";
unset($_SESSION['uploadmessage']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Foto formulier</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/fototoevoegen.css" type="text/css">
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
                $("button[type=submit]").button(
                {
                    icons: { primary: " ui-icon-disk" }
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
             <div class="welcoming"><?php if ($lidStatus == 2) {echo "administrator";} elseif($lidStatus == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} elseif($lidStatus == 0) {echo "bezoeker";}?></div>
        </div>
        </div>
     
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Foto toevoegen</strong>
             <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="documentfotos_view.php?documentid=<?php echo $_SESSION['docidbijfotoupload'];?>" class="buttonterug">&nbsp;Terug</a>
        </p>
       
        <form action="../control/upload.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="control-group">
                <label for="fileToUpload" class="control-label">foto kiezen:</label>
                <div class="controls"><input type="file" name="fileToUpload" id="fileToUpload" required></div>
            </div>
            <div class="control-group">
                <label for="naam" class="control-label">foto opladen:</label>
                <div class="controls"><button type="submit" name="submit">Foto opladen</button></div>
            </div>
        
        </form>
        <div id="uploadMessage"><?php echo $uploadMessage; ?></div>
        <div class="push"></div> 
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>  
    </body>
</html>
