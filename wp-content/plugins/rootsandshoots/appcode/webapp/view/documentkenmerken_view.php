<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/dockenmerk.class.php');
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
    $eigenaarId=$registratieObject->getLidId();
    return $eigenaarId;
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
    $docKenmerkObject = new DocKenmerk();
    $docId = $_GET['documentid'];
    $docKenmerkObject->setDocId($docId);
    //nagaan of doc niet verkocht is
    $docObject1 = new Doc();
    $docObject1->setDocId($docId);
    if($docObject1->isDocVerkocht() == FALSE)//doc niet verkocht
    {
        $docKenmerken = $docKenmerkObject->selectDocKenmerkByDocId();
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
else//onzinnige en lege querystring
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
        <title>Document kenmerken view</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/documentkenmerkformulier.css" type="text/css">
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
            <strong>&nbsp;Document kenmerken view</strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="beschikbare_documenten.php" class="buttonterug">&nbsp;Terug</a>
        </p>
        
        <?php
        if(count($docKenmerken) == 0)
        {
            echo "Er zijn geen specifieke kenmerken.";
        }
        else
        {
        ?>
        <form id="frmDocumentKenmerkW" class="form-horizontal">
        <table id="docKenmerkTabel">
        <thead>
        <tr>
        <th>VELD</th>  
        <th>WAARDE</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
        foreach($docKenmerken as $dk)
        {
        ?>
        <tr>
        <td><input id="<?php echo "tbVeld".$i;?>" name="<?php echo "tbVeld".$i;?>" value="<?php echo $dk['DocKenmerk']; ?>" type="text" readonly="true"></td>
        <td><input id="<?php echo "tbWaarde".$i;?>" name="<?php echo "tbWaarde".$i;?>" value="<?php echo $dk['DocKenmerkValue']; ?>" type="text" readonly="true"></td>
        </tr>
        <?php
        $i++;
        }//einde foreach
        }//einde if   
        
        ?>
        </tbody>
        </table>
        </form>
        <div class="push"></div> 
        </div><!--einde container-->
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>  
    </body>
</html>


