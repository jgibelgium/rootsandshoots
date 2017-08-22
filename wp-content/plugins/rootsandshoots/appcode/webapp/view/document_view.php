<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/auteur.class.php');
include('../model/uitgever.class.php'); 
include('../model/taal.class.php');
include('../model/doctype.class.php');
include('../model/toestand.class.php');
include('../model/registratie.class.php');
include('../model/lid.class.php');

session_start();

if(isset($_SESSION['lidstatus']))
{
    include('../help/sessie.class.php');
    $lidStatus = $_SESSION['lidstatus']; 
    Sessie::checkSessionId();
    Sessie::registerLastActivity();
}

//tbv de welcoming
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

//nagaan of document in transactie is
function transactieChecken($docId)
{
    $docObject = new Doc();
    $docObject->setDocId($docId);
    $jaOfNee = $docObject->isDocInTransaction();
    return $jaOfNee ;
}

if(!empty($_GET['documentid']))
{
    $docObject = new Doc();
    $docId = $_GET['documentid'];
    $docObject->setDocId($docId);
    $docObject->selectDocById();
    if($docObject->selectDocById() == TRUE)//bestaand document
    {
        //nagaan of doc niet verkocht is
        $docObject1 = new Doc();
        $docObject1->setDocId($docId);
        if($docObject1->isDocVerkocht() == FALSE)//doc niet verkocht
        {
            //auteur ophalen
            $auteurId = $docObject->getAuteurId();
            $auteurObject = new Auteur();
            $auteurObject->setAuteurId($auteurId); 
            $auteurObject->selectAuteurById();
            $auteurNaam = $auteurObject->getAuteurNaam();
            $auteurVoornaam = $auteurObject->getAuteurVoornaam();

            //uitgever ophalen
            $uitgeverId = $docObject->getUitgeverId();
            $uitgeverObject = new Uitgever();
            $uitgeverObject->setUitgeverId($uitgeverId);
            $uitgeverObject->selectUitgeverById(); 
            $uitgever = $uitgeverObject->getUitgever();

            //doctype ophalen
            $docTypeId = $docObject->getDocTypeId();
            $docTypeObject = new DocType(); 
            $docTypeObject->setDocTypeId($docTypeId);
            $docTypeObject->selectDocTypeById();
            $docType = $docTypeObject->getDocType();

            $lidId = eigenaarOphalen($docId);
        }
        else//doc welverkocht
        {
            //voor leden en admin diverse wissen
            if(isset($_SESSION['lidstatus']))
            {
                //sessionid wissen
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
            }
            header('Location: ../../../index.php');
        }
    }
    else//onbestaand document
    {
            //voor leden en admin diverse wissen
            if(isset($_SESSION['lidstatus']))
            {
                //sessionid wissen
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
            }
            header('Location: ../../../index.php');
    }
    
}
else//onzinnige en ledige querystring
{
            //voor leden en admin diverse wissen
            if(isset($_SESSION['lidstatus']))
            {
                //sessionid wissen
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
            }
            header('Location: ../../../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Document view</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/formulier.css" type="text/css">
        <link rel="stylesheet" href="css/tabs.css" type="text/css">
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
             <div class="welcoming">
              <?php
              if (isset($_SESSION['lidstatus']))
              {
                  if($_SESSION['lidstatus'] == 2) {echo "administrator";}
                  elseif($_SESSION['lidstatus'] == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} 
              }
              else
              {echo "bezoeker";}?>
             </div>
        </div>
        </div>
        <?php include('../help/tabs.php')?>
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Document view</strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="beschikbare_documenten.php" class="buttonterug">&nbsp;Terug</a>
        </p>
        <form id="frmDocument" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
            <label for="nummer" class="control-label">doc nr:</label>
            <div class="controls">
            <input id="nummer" value="<?php echo $docObject->getDocId(); ?>" readonly="true">
            </div>
            </div>    

            <div class="control-group">
            <label for="titelDoc" class="control-label">TITEL:</label>
            <div class="controls"><input id="titelDoc" type="text" value="<?php echo $docObject->getTitel();?>" readonly="true" style="width: 20em"></div>
            </div>

            <div class="control-group">
            <label for="auteur" class="control-label">AUTEUR:</label>
            <div class="controls">
            <input id="auteur" type="text" readonly="true" value="<?php echo $auteurNaam." ".$auteurVoornaam;?>">
            </div>
            </div>

            <div class="control-group">
            <label for="uitgever" class="control-label">UITGEVER:</label>
            <div class="controls">
            <input id="uitgever" type="text" readonly="true" value="<?php echo $uitgever;?>">
            </div>
            </div>

            <div class="control-group">
            <label for="taal" class="control-label">TAAL:</label>
            <div class="controls">
            <input id="taal" type="text" readonly="true" value="<?php
            $taalId = $docObject->getTaalId();                                                                     
            switch($taalId)
            {
                case '1':
                echo "Nederlands"; break;
                case '2':
                echo "Frans"; break;
                case '3':
                echo "Engels"; break;
                case '4':
                echo "Duits"; break;
                case '5':
                echo "Andere"; break;
            }  
            ?>">
            </div>
            </div>

            <div class="control-group">
            <label for="doctype" class="control-label">DOCUMENT TYPE:</label>
            <div class="controls">
            <input id="doctype" type="text" readonly="true" value="<?php echo $docType;?>">
            </div>
            </div>

            <div class="control-group">
            <label for="toestand" class="control-label">TOESTAND:</label>
            <div class="controls">
            <input id="toestand" type="text" readonly="true" value="<?php
            $toestandId = $docObject->getToestandId();
            switch($toestandId)
            {
                case '1':
                echo "Nieuw"; break;
                case '2':
                echo "Als nieuw"; break;
                case '3':
                echo "Zeer goed"; break;
                case '4':
                echo "Goed"; break;
                case '5':
                echo "Aanvaardbaar"; break;
            }                                                                        
            ;?>">
            </div>
            </div>

            <div class="control-group">
            <label for="info" class="control-label">INFO:</label>
            <div class="controls">
            <textarea id="info" rows="4" cols="25" placeholder="max 255 karakters" style="resize: none" readonly><?php echo $docObject->getDocInfo();?></textarea></div>
            </div>

            <div class="control-group">
            <label for="year" class="control-label">JAAR:</label>
            <div class="controls"><input id="year" type="text" value="<?php echo $docObject->getJaar();?>" readonly="true"></div>
            </div>

            <div class="control-group">
            <label for="ISBN" class="control-label">ISBN:</label>
            <div class="controls"><input id="ISBN" type="text" value="<?php echo $docObject->getISBN();?>" readonly="true"></div>
            </div>

            <div class="control-group">
            <label for="Prijs" class="control-label">PRIJS (€):</label>
            <div class="controls"><input id="Prijs" type="text" value="<?php echo $docObject->getPrijs();?>" readonly="true"></div>
            </div>
            
            <div class="control-group">
                <label for="teKoop" class="control-label">TE KOOP:</label>
                <div class="controls"><div><input id="teKoop" type="checkbox" value="1" <?php echo ($docObject->getTeKoop() == '1')? 'checked' : '' ;?> disabled="disabled"></div></div>
            </div>

            <div class="control-group">
                <label for="teLeen" class="control-label">TE LEEN:</label>
                <div class="controls"><div><input id="teLeen" type="checkbox" value="1" <?php echo ($docObject->getTeLeen() == '1')? 'checked' : '' ;?> disabled="disabled"></div></div>
            </div>

            <!--door de checkbox in een div te plaatsen vervalt de stijl selectie .controls > input-->
         </form>     
         <div class="push"></div>   
        </div><!--einde container-->
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>  
    </body>
</html>

