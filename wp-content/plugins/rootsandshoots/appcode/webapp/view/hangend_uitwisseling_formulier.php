<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doc.class.php');
include('../model/transactie.class.php');
include('../model/transactiepartner.class.php');
include('../help/time.php');
include('../model/lid.class.php');

session_start();

if(!isset($_SESSION['lidstatus']))
{
   header('Location: ../../../index.php');
}
else
{
    if(isset($_POST['transactieid']) || isset($_SESSION['idhidden']))
    {
        include('../help/sessie.class.php');
        Sessie::checkSessionId();
        Sessie::registerLastActivity();//heeft $_SESSION['lidid'] nodig
    }
    else
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

//tbv welcoming
if(isset($_SESSION['lidid']))
{
    $lidObject = new Lid();
    $lidObject->setLidId($_SESSION['lidid']);
    $lid = $lidObject->selectLidById();
}

if(isset($_POST['transactieid']))
{
    $taObject = new Transactie();
    $taId = $_POST['transactieid'];
    $taObject->setTransactieId($taId);
    $taObject->selectTransactieById();
    //docs ophalen
    $docObject = new Doc();
    $exchangeId = $taId;
    $docsInExchangeLijst = $docObject->selectDocsInExchange($exchangeId);
}

if(isset($_SESSION['idhidden']))
{
    $taObject = new Transactie();
    $taId = $_SESSION['idhidden'];
    $taObject->setTransactieId($taId);
    $taObject->selectTransactieById();
    //docs ophalen
    $docObject = new Doc();
    $exchangeId = $taId;
    $docsInExchangeLijst = $docObject->selectDocsInExchange($exchangeId);
}

function lenerOphalen($transactieId) {
    $lidObject = new Lid();
    $lener = $lidObject->selectLenerInExchange($transactieId);
    return $lener;
}

function verlenerOphalen($transactieId) {
    $lidObject = new Lid();
    $verlener = $lidObject->selectVerlenerInExchange($transactieId);
    return $verlener;
}

function statusOphalen($dsId)
{
    switch ($dsId)
    {
        case '1':
            echo 'Voorstel'; break;
        case '2':
            echo 'Gewijzigd voorstel'; break;
        case '3':
            echo 'Aanvaard'; break;
        case '4':
            echo 'Afgekeurd'; break;
        case '5':
            echo 'In uitwisseling'; break;
    }
}

//auteur ophalen
include('../model/auteur.class.php');
function auteurOphalen($auteurId)
{
    $auteurObject = new Auteur();
    if($auteurId != NULL)
    {
       $auteurObject->setAuteurId($auteurId);
       $auteur = $auteurObject->selectAuteurById();
       echo $auteur[0]['AuteurNaam'];     
    }
}

//uitgever ophalen
include('../model/uitgever.class.php');
function uitgeverOphalen($uitgeverId)
{
    $uitgeverObject = new Uitgever();
    if($uitgeverId != NULL)
    {
       $uitgeverObject->setUitgeverId($uitgeverId);
       $uitgever = $uitgeverObject->selectUitgeverById();
       echo $uitgever[0]['Uitgever'];     
    }
}

//doctype ophalen
include('../model/doctype.class.php');
function docTypeOphalen($docTypeId)
{
    $docTypeObject = new DocType(); 
    $docTypeObject->setDocTypeId($docTypeId);
    $docType = $docTypeObject->selectDocTypeById();     
    echo $docType[0]['DocType'];
}

function bestemmelingOphalen($taId)
{
    $lidObject = new Lid();
    $verzenderId = $_SESSION['lidid'];
    $verlener = $lidObject->selectVerlenerInExchange($taId);
    $lener = $lidObject->selectLenerInExchange($taId);
    if($verzenderId == $verlener['LidId'])
    {
        echo $lener['LidId'];
    }
    elseif($verzenderId == $lener['LidId'])
    {
        echo $verlener['LidId'];
    }
}

function gebruikerOphalen($lidId)
{
     $lidObject = new Lid();
     $lidObject->setLidId($lidId);
     $gebruiker = $lidObject->selectLidById();
     return $gebruiker;//2dim array
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Hangend uitwisseling formulier</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/hangendexchangeformulier.css" type="text/css">
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

                //2. buttons voorzien van stijl
                $("#btnAgree").button(
                {
                    icons: { primary: " ui-icon-check" }
                });
                $("#btnDeny").button(
                {
                    icons: { primary: " ui-icon-close" }
                });
                $("#btnUpdate").button(
                {
                    icons: { primary: " ui-icon-pencil" }
                });
                $("#btnAffirm").button(
                {
                    icons: { primary: " ui-icon-check" }
                });
                $("#btnCancel").button(
                {
                    icons: { primary: " ui-icon-cancel" }
                });

                //3.
                $("#frmHangendExchange").on("click", "#imgEdit", updateDueDate);

                //4. kalender
                $("#dueDate").datepicker({inline:true });

                //5.tooltip
                $('img').tooltip();

            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });

            function updateDueDate() {
                $("#dueDate").removeAttr('readonly');
                $("#dueDate").focus();
                //not working
                /*
                $("#btnAgree").prop('disabled', 'disabled');
                $("#btnDeny").prop('disabled', 'disabled');
                $("#btnUpdate").removeAttr('disabled');
                */
                //working
                $("#btnAgree").button("disable");
                $("#btnDeny").button("disable");
                $("#btnUpdate").button("enable");
            }
        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
             <div class="welcoming"><?php if ($_SESSION['lidstatus'] == 2) {echo "administrator";} elseif($_SESSION['lidstatus'] == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];}?></div>
        </div>
        </div>
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Hangend uitwisseling formulier</strong>
             <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="mijn_hangende_uitwisselingen.php" class="buttonterug">&nbsp;Terug</a>
        </p>
       
        <form id="frmHangendExchange" method="POST" action="../control/hangende_exchange.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
            <div class="control-group_l">
                <label for="nummer" class="control-label">uitwisseling nr:</label>
                <div class="controls"><input id="nummer" name="nummer" type="text" value="<?php echo $taObject->getTransactieId();?>" readonly="true"></div>
            </div>
            <div class="control-group_r">
                <label for="datum" class="control-label">DATUM:</label>
                <div class="controls">
                    <input id="localdate" name="localdate" type="text" value="<?php makeLocalTime($taObject->getTADatum());?>" readonly="true">
                    
                </div>
            </div>
            </div>

            <div class="control-group">
             <div class="control-group_l">
                <label for="lener" class="control-label">Lener:</label>
                <div class="controls"><input id="lener" name="lener" type="text" value="<?php $lener = lenerOphalen($taObject->getTransactieId()); echo $lener['LidVoornaam']." ".$lener['LidNaam'];?>" readonly="true"></div>
            </div>
            <div class="control-group_r">
                <label for="verlener" class="control-label">Verlener:</label>
                <div class="controls"><input id="verlener" name="verlener" type="text" value="<?php $verlener = verlenerOphalen($taObject->getTransactieId()); echo $verlener['LidVoornaam']." ".$verlener['LidNaam'];?>" readonly="true"></div>
            </div>
            </div>

            <div class="control-group">
            <div class="control-group_l">
                <label for="status" class="control-label">huidige status:</label>
                <div class="controls"><input id="status" name="status" type="text" value="<?php statusOphalen($taObject->getExchangeStatusId());?>" readonly="true"></div>
            </div>
            <div class="control-group_r">
                <label for="duedate" class="control-label">Due date:</label>
                <div class="controls">
                <input id="dueDate" name="duedate" value="<?php echo $taObject->getDueDate();?>" readonly="true">
               
                <?php
                if($taObject->getExchangeStatusId() == 1)
                {
                //als verlener
                $verlener = verlenerOphalen($taObject->getTransactieId());
                if($_SESSION['lidid'] == $verlener['LidId']) 
                {
                ?>
                <img id="imgEdit" src="../../images/IconEdit.png" alt="edit" title="edit">
                <?php
                };
                }//einde 1
                elseif($taObject->getExchangeStatusId() == 2)
                {
                //als balspelende uitwisselingpartner
                //laatste modifiedby ophalen
                //als deze niet gelijk is aan de username van de ingelogde persoon, wordt de onderstaande knoppen getoond
                $laatsteGebruikersNaam = $taObject->getModifiedBy();
                $gebruiker = gebruikerOphalen($_SESSION['lidid']);//retourneert 2dim array
                $ingelogdeGebruikersNaam = $gebruiker[0]['GebruikersNaam'];//databank veld
                if($laatsteGebruikersNaam !=  $ingelogdeGebruikersNaam)
                {
                ?>      
                <img id="imgEdit" src="../../images/IconEdit.png" alt="edit" title="edit">
                <?php
                };
                }//einde 2  
                ?>
                     </div><!--einde controls-->
                </div><!--einde control group r-->
            </div><!--einde control group-->

            <?php
            if($taObject->getExchangeStatusId() == 5)
            {
            ?>
            <div class="control-group">
             <div class="control-group_l">
                <label for="datumUit" class="control-label">datum uit:</label>
                <div class="controls">
                    <input id="datumUit" name="datumuit" type="text" value="<?php makeLocalTime($taObject->getDatumUit());?>" readonly="true">
                </div>
                </div>
                </div>
            <?php
            }
            ?>
            <div id="divdocs" class="control-group">
                <label for="docs" class="control-label">documenten:</label>
                <div class="controls">
                <table id="docsInExchangeTabel">
                    <thead>
                        <tr>
                        <th>DOC NR.</th>
                        <th>TITEL</th>
                        <th>AUTEUR</th>
                        <th>UITGEVER</th>
                        <th>DOCUMENT TYPE</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    foreach ($docsInExchangeLijst as $die)
                    {
                    $i=$die['docid'];
                    ?>
                    <tr id="<?php echo "dieRij".$i ?>">
                        <td id="<?php echo "dieId".$i ?>" class="Id"><?php echo $die['docid'] ?></td>
                        <td id="<?php echo "dieTitel".$i ?>" class="Titel"><?php echo $die['titel'] ?></td>
                        <td id="<?php echo "dieAuteur".$i ?>" class="Auteur"><?php auteurOphalen($die['auteurid']); ?></td>
                        <td id="<?php echo "dieUitgever".$i ?>" class="Uitgever"><?php uitgeverOphalen($die['uitgeverid']); ?></td>
                        <td id="<?php echo "dieType".$i ?>" class="Type"><?php docTypeOphalen($die['doctypeid']); ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
                </div>
            </div>

            <!--nieuwe uitwisseling status ovv ddl-->
            <?php
            if($taObject->getExchangeStatusId() == 3)
            {
            //als verlener
            $verlener = verlenerOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verlener['LidId'])
            {
            ?>
             <div class="control-group">
             <div class="control-group_l">
                <label for="nieuwstatus" class="control-label">nieuwe status:</label>
                <div class="controls">
                    <select id="nieuwstatus" name="newstatus" required>
                        <option></option>
                        <option value="5">In uitwisseling</option>
                        <option value="6">Teruggekeerd</option>
                    </select>
                </div>
                 </div>
                 </div>
            <?php
            }//einde 3
            }
            elseif($taObject->getExchangeStatusId() == 5) //begin 5
            {
            //als verlener
            $verlener = verlenerOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verlener['LidId'])
            {    
            ?>
            <div class="control-group">
            <div class="control-group_l">
                <label for="nieuwstatus" class="control-label">nieuwe status:</label>
                <div class="controls">
                    <select id="nieuwstatus" name="newstatus" required>
                        <option></option>
                        <option value="6">Teruggekeerd</option>
                    </select>
                </div>
                </div>
                </div>
            <?php
            }
            }//einde Exchangestatusid 5
            ?>

            <input id="idHidden" name="idhidden" type="hidden" value="<?php echo $taObject->getTransactieId(); ?>">
            <input id="idBestemmeling" name="idbestemmeling" type="hidden" value="<?php bestemmelingOphalen($taObject->getTransactieId()); ?>">
            <input id="datum" name="datum" type="hidden" value="<?php echo $taObject->getTADatum();?>">
            <?php
            //
            if($taObject->getExchangeStatusId() == 1)
            {
            //als verlener
            $verlener = verlenerOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verlener['LidId'])
            {
            ?>
            <div class="control-group"> 
                    <div class="controls"> 
                    <button id="btnAgree" name="btnAgree" type="submit">&nbsp;Goedkeuren</button>
                    <button id="btnDeny" name="btnDeny" type="submit">&nbsp;Afkeuren</button>
                    <button id="btnUpdate" name="btnUpdate" type="submit" disabled>&nbsp;Voorstel wijzigen</button>
                    </div>  
            </div>
            <?php
            };
            }//einde status 1
            elseif($taObject->getExchangeStatusId() == 2)
            {
            //als balspelende Exchangepartner
            //laatste modifiedby ophalen
            //als deze niet gelijk is aan de username van de ingelogde persoon, wordt de onderstaande knoppen getoond
            $laatsteGebruikersNaam = $taObject->getModifiedBy();
            $gebruiker = gebruikerOphalen($_SESSION['lidid']);//retourneert 2dim array
            $ingelogdeGebruikersNaam = $gebruiker[0]['GebruikersNaam'];//databank veld
            if($laatsteGebruikersNaam !=  $ingelogdeGebruikersNaam)
            {
            ?>    
            <div class="control-group"> 
                    <div class="controls"> 
                    <button id="btnAgree" name="btnAgree" type="submit">&nbsp;Goedkeuren</button>
                    <button id="btnDeny" name="btnDeny" type="submit">&nbsp;Afkeuren</button>
                    <button id="btnUpdate" name="btnUpdate" type="submit" disabled>&nbsp;Voorstel wijzigen</button>
                    </div>  
            </div>
            <?php
            };
            }//einde status 2
            else 
            {
            //als verlener
            $verlener = verlenerOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verlener['LidId'])
            {
            ?>
            <div class="control-group"> 
                <div class="controls"> 
                <button id="btnAffirm" name="btnAffirm" type="submit">&nbsp;Bevestigen</button>
                <button id="btnCancel" name="btnCancel" type="reset">&nbsp;Annuleren</button>
                </div>  
            </div>
            <?php
            };//einde if verlener
            }//einde status 3 en 5
            ?>
         </form>     
         <div id="mailMessage"><?php if(isset ($_SESSION['mailmessageexchange'])) {echo $_SESSION['mailmessageexchange'];}; unset($_SESSION['mailmessageexchange']);?></div>
         <div class="push"></div>    
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>       
    </body>
</html>


