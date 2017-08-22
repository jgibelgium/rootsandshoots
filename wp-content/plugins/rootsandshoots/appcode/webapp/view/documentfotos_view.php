<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/foto.class.php');
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

if(!empty($_GET['documentid']))
{
    $docId = $_GET['documentid'];
    $docObject = new Doc();
    $docObject->setDocId($docId);
    if($docObject->selectDocById() == TRUE)//bestaand document
    {
        //nagaan of doc niet verkocht is
        $docObject1 = new Doc();
        $docObject1->setDocId($docId);
        if($docObject1->isDocVerkocht() == FALSE)//doc niet verkocht
        {
            $fotoObject = new Foto();
            $fotoObject->setDocId($docId);
            $fotos = $fotoObject->selectFotoByDocId($docId);
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
else//onzinnige of ledige querystring
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

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Foto's view</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/fotos_view.css" type="text/css">
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
                $("img").error(function () {
                    $(this).parent().html("<p>Deze foto is niet gevonden.</p>");
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
              <?php if (isset($_SESSION['lidstatus']))
              {
                  if($_SESSION['lidstatus'] == 2) {echo "administrator";} elseif($_SESSION['lidstatus'] == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} 
              }
              else {echo "bezoeker";}?></div>
        </div>
        </div>
        <?php include('../help/tabs.php')?>
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Document foto's view</strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
        <a href="<?php if(isset($_SESSION['lidstatus'])){ echo "mijn_documenten.php";} else echo "beschikbare_documenten.php";?>" class="buttonterug">&nbsp;Terug</a>&nbsp;&nbsp;&nbsp;
        <?php
        if(isset($_SESSION['lidstatus']))//ontoereikend: alleen eigenaar mag fotos toevoeegn
        {
        if($_SESSION['lidid'] == $lidId)
        {
        if(transactieChecken($docId) != 1)//als doc niet in TA is mogen er foto's toegevoegd worden
        {
        ?>
        <a href="foto_toevoegen.php?documentid=<?php echo $docId;?>" class="buttonadd">&nbsp;Foto toevoegen</a>
        <?php
        }
        }
        }    
        ?>
        </p>
        <?php
        if(count($fotos) == 0)
        {
            echo "Er zijn geen foto's.";
        }
        else
        {
        ?>
        <table id="fotoTabel">
        <thead></thead>
        <tbody>
        <?php
        $teller = 0;
        foreach($fotos as $foto)
        {
        ?>
        <?php
        if($teller % 3 == 0)
        {
        ?>
        <tr>
        <?php
        }
        ?>
            
        <td id="<?php echo $teller;?>">
        <?php
        if(isset($_SESSION['lidstatus']))//ontoereikend: alleen eigenaar mag naar formulier
        {
        if($_SESSION['lidid'] == $lidId) //eigenaar
        {
        ?>
        <a href="foto_formulier.php?documentid=<?php echo $docId;?>&fotoid=<?php echo $foto['FotoId']?>">
        <img id="<?php echo $foto['FotoNaam'];?>" alt="<?php echo $foto['FotoNaam'];?>" title="<?php echo $foto['FotoNaam'];?>" src="<?php echo $foto['URL'].$foto['FotoNaam']?>"/>
        </a>
        <?php
        }
        else //leden die geen eigenaar zijn
        {
        ?>
        <img id="<?php echo $foto['FotoNaam'];?>" alt="<?php echo $foto['FotoNaam'];?>" title="<?php echo $foto['FotoNaam'];?>" src="<?php echo $foto['URL'].$foto['FotoNaam']?>"/>
        <?php   
        }
        }
        else //bezoekers
        {
        ?>
        <img id="<?php echo $foto['FotoNaam'];?>" alt="<?php echo $foto['FotoNaam'];?>" title="<?php echo $foto['FotoNaam'];?>" src="<?php echo $foto['URL'].$foto['FotoNaam']?>"/>
        <?php
        }
        ?>
        </td>
        <?php
        $teller += 1;
        } //einde foreach
        if($teller % 3 == 0)
        {
              
        ?>
        </tr>
        <?php
        }
        ?>
        </tbody>
        </table> 
        <?php
        }
        ?>
            
        <div class="push"></div>  
        </div><!--einde container-->
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>  
    </body>
</html>


