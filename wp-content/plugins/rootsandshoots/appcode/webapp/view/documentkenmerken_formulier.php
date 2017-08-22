<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/dockenmerk.class.php');
include('../model/registratie.class.php');
include('../model/lid.class.php');

session_start();

if(!isset($_SESSION['lidstatus']))
{
   header('Location: ../../../index.php');
}
else //enkel leden hebben toegang tot document kenmerken formulier
{
    //ctln of er een documentid in de querystring is
    if(isset($_GET['documentid']))
    {
        //ctln of het de eigenaar is die inkijkt en geen ander lid
        $docId =  $_GET['documentid'];
        $lidId = eigenaarOphalen($docId);//ook bij onbestaande docid wordt er uitgelogd
        if($lidId != $_SESSION['lidid'])//geen eigenaar
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
        else//wel eigenaar
        {
                //nagaan of doc niet verkocht is
                $docObject1 = new Doc();
                $docObject1->setDocId($docId);
                if($docObject1->isDocVerkocht() == FALSE)//doc niet verkocht
                {
                    $lidStatus = $_SESSION['lidstatus']; 
                    include('../help/sessie.class.php');
                    Sessie::checkSessionId();
                    Sessie::registerLastActivity();//heeft $_SESSION['lidid'] nodig
                }
                else//doc welverkocht
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
        }
    }
    else //leeg formulier getoond
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

//nagaan of document in transactie is
function transactieChecken($docId)
{
    $docObject = new Doc();
    $docObject->setDocId($docId);
    $jaOfNee = $docObject->isDocInTransaction();
    return $jaOfNee ;
}

if(isset($_GET['documentid']))//isset is true als documentid in de querystring voorkomt; aldus laat deze conditie toe dat de programmeur de pagina bekijkt zonder voorgaande
{
    $docKenmerkObject = new DocKenmerk();
    $docId = $_GET['documentid'];
    $docKenmerkObject->setDocId($docId);
    $docKenmerken = $docKenmerkObject->selectDocKenmerkByDocId();
    $lidId = eigenaarOphalen($docId);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Document kenmerken formulier</title>
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

                //2. opslaan button voorzien van stijl
                $("button[type=submit]").button(
                {
                    icons: { primary: " ui-icon-disk" }
                });

                //3. btnSave enabelen igv documentdetails
                $("#tbVeld1").on('blur', function () {
                    if ($("#tbVeld1").val().trim().length > 0) {
                       $("#btnSave").prop('disabled', false).button('refresh');
                    }
                });



            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });

            function validateFrm() {
                //generiek
                /*
                for (var i = 1; i <= 10; i++) {
                var x = "veld" + i;
                var y = "waarde" + i;
                var selectorx = "\#tbVeld" + i;
                var selectory = "\#tbWaarde" + i;
                x = $("selectorx").val().length;//de selector kan niet generiek ingevuld worden
                y = $("selectory").val().length;
                if (x == 0 ^ y == 0) {
                if (x == 0) {
                $("selectorx").attr("value", "Vul mij in");
                }
                if (y == 0) {
                $("selectory").attr("value", "Vul mij in");
                }
                return false;
                exit;
                }
                }
                return true;
                */

                veld1 = $("#tbVeld1").val().length;
                waarde1 = $("#tbWaarde1").val().length;
                veld2 = $("#tbVeld2").val().length;
                waarde2 = $("#tbWaarde2").val().length;
                veld3 = $("#tbVeld3").val().length;
                waarde3 = $("#tbWaarde3").val().length;
                veld4 = $("#tbVeld4").val().length;
                waarde4 = $("#tbWaarde4").val().length;
                veld5 = $("#tbVeld5").val().length;
                waarde5 = $("#tbWaarde5").val().length;
                veld6 = $("#tbVeld6").val().length;
                waarde6 = $("#tbWaarde6").val().length;
                veld7 = $("#tbVeld7").val().length;
                waarde7 = $("#tbWaarde7").val().length;
                veld8 = $("#tbVeld8").val().length;
                waarde8 = $("#tbWaarde8").val().length;
                veld9 = $("#tbVeld9").val().length;
                waarde9 = $("#tbWaarde9").val().length;
                veld10 = $("#tbVeld10").val().length;
                waarde10 = $("#tbWaarde10").val().length;

                if (veld1 == 0 ^ waarde1 == 0) {
                    if (veld1 == 0) {
                        $("#tbVeld1").attr("value", "Vul mij in");

                    }
                    if (waarde1 == 0) {
                        $("#tbWaarde1").attr("value", "Vul mij in");

                    }
                    return false;
                }
                else if (veld2 == 0 ^ waarde2 == 0) {
                    if (veld2 == 0) {
                        $("#tbVeld2").attr("value", "Vul mij in");
                    }
                    if (waarde2 == 0) {
                        $("#tbWaarde2").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld3 == 0 ^ waarde3 == 0) {
                    if (veld3 == 0) {
                        $("#tbVeld3").attr("value", "Vul mij in");
                    }
                    if (waarde3 == 0) {
                        $("#tbWaarde3").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld4 == 0 ^ waarde4 == 0) {
                    if (veld4 == 0) {
                        $("#tbVeld4").attr("value", "Vul mij in");
                    }
                    if (waarde4 == 0) {
                        $("#tbWaarde4").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld5 == 0 ^ waarde5 == 0) {
                    if (veld5 == 0) {
                        $("#tbVeld5").attr("value", "Vul mij in");
                    }
                    if (waarde5 == 0) {
                        $("#tbWaarde5").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld6 == 0 ^ waarde6 == 0) {
                    if (veld6 == 0) {
                        $("#tbVeld6").attr("value", "Vul mij in");
                    }
                    if (waarde6 == 0) {
                        $("#tbWaarde6").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld7 == 0 ^ waarde7 == 0) {
                    if (veld7 == 0) {
                        $("#tbVeld7").attr("value", "Vul mij in");
                    }
                    if (waarde3 == 0) {
                        $("#tbWaarde7").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld8 == 0 ^ waarde8 == 0) {
                    if (veld8 == 0) {
                        $("#tbVeld8").attr("value", "Vul mij in");
                    }
                    if (waarde8 == 0) {
                        $("#tbWaarde8").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld9 == 0 ^ waarde9 == 0) {
                    if (veld9 == 0) {
                        $("#tbVeld9").attr("value", "Vul mij in");
                    }
                    if (waarde9 == 0) {
                        $("#tbWaarde9").attr("value", "Vul mij in");
                    }
                    return false;
                }
                else if (veld10 == 0 ^ waarde10 == 0) {
                    if (veld10 == 0) {
                        $("#tbVeld10").attr("value", "Vul mij in");
                        $("#tbVeld1").addClass("warning");
                    }
                    if (waarde10 == 0) {
                        $("#tbWaarde10").attr("value", "Vul mij in");
                        $("#tbWaarde1").addClass("warning");
                    }
                    return false;
                }

                else {
                    return true;
                }

            }

        </script>
        
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
             <div class="welcoming"><?php if($lidStatus == 1){ echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} elseif($lidStatus == 2){echo "administrator";}?></div>
        </div>
        </div>
        <?php include('../help/tabs.php')?>
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Document kenmerken <?php if(empty($docKenmerken)){echo "toevoegen";} else {echo "wijzigen";}?></strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="mijn_documenten.php" class="buttonterug">&nbsp;Terug</a>
        </p>
        <?php
        if(!empty($docKenmerken))
        {
        ?>
        <form id="frmDocumentKenmerkW" method="POST" class="form-horizontal" onsubmit="return validateFrm()" action="../control/documentkenmerken.control.php">
        <table id="docKenmerkTabel">
        <thead>
        <tr>
        <th class="docKenmerkTabelIdCel"></th>
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
        <td class="docKenmerkTabelIdCel"><input id="<?php echo "tbDocKenmerkId".$i;?>" name="<?php echo "tbDocKenmerkId".$i;?>" value="<?php echo $dk['DocKenmerkId'];?>" type="text"></td>
        <td><input id="<?php echo "tbVeld".$i;?>" name="<?php echo "tbVeld".$i;?>" value="<?php echo $dk['DocKenmerk']; ?>" type="text"></td>
        <td><input id="<?php echo "tbWaarde".$i;?>" name="<?php echo "tbWaarde".$i;?>" value="<?php echo $dk['DocKenmerkValue']; ?>" type="text"></td>
        </tr>
        <?php
        $i++;
        }//einde foreach
             
        //lege rijen toevoegen tot aan 10
        $getal = count($docKenmerken);
        $k=$getal+1;
        for($k; $k <= 10; $k++)
        {
        ?>
        <tr>
        <td class="docKenmerkTabelIdCel"><input id="<?php echo "tbDocKenmerkId".$k;?>" name="<?php echo "tbDocKenmerkId".$k;?>" value="" type="text"></td>
        <td><input id="<?php echo "tbVeld".$k;?>" name="<?php echo "tbVeld".$k; ?>" value="" type="text"></td>
        <td><input id="<?php echo "tbWaarde".$k;?>" name="<?php echo "tbWaarde".$k; ?>" value="" type="text"></td>
        </tr>
        <?php        
        }//einde for voor bijkomende lege rijen
        ?>
         <tr><td id="laatstecel" colspan="2"><button id="btnUpdate" name="btnUpdate" type="submit">Wijzigen</button></td></tr> 
         </tbody>
         </table>
         <input id="idHidden" name="idHidden" type="hidden" value="<?php echo $docId; ?>">
         </form>
         <?php
         }//einde if
         else//lege tabel
         {
         ?>
         <form id="frmDocumentKenmerkA" method="POST" class="form-horizontal" action="../control/documentkenmerken.control.php" onsubmit="return validateFrm()">
         <table id="docKenmerkTabel">
         <thead>
         <tr>
         <th class="docKenmerkTabelIdCel"></th>
         <th>VELD</th>  
         <th>WAARDE</th>
         </tr>
         </thead>
         <tbody>
         <?php
         for ($j = 1; $j <= 10; $j++)
         {    
         ?>
         <tr>
         <td class="docKenmerkTabelIdCel"><input id="<?php echo "tbDocKenmerkId".$j;?>" name="<?php echo "tbDocKenmerkId".$j;?>" value="" type="hidden"></td>
         <td><input id="<?php echo "tbVeld".$j;?>" name="<?php echo "tbVeld".$j; ?>" value="" type="text"></td>
         <td><input id="<?php echo "tbWaarde".$j;?>" name="<?php echo "tbWaarde".$j; ?>" value="" type="text"></td>
         </tr>
         <?php
         }//einde for lus
         ?>
         <tr><td id="laatstecel" colspan="2"><button id="btnSave" name="btnSave" type="submit" disabled>Opslaan</button></td></tr>
         </table>
         <input id="idHidden" name="idHidden" value="<?php echo $docId; ?>" type="hidden">
         </form>
         <?php
         }//einde else   
         ?>
         <div class="push"></div>  
        </div><!--einde container-->
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>  
    </body>
</html>


