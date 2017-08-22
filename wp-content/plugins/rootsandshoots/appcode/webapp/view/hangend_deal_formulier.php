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
    $dealId = $taId;
    $docsInDealLijst = $docObject->selectDocsinDeal($dealId);
}

if(isset($_SESSION['idhidden']))
{
    $taObject = new Transactie();
    $taId = $_SESSION['idhidden'];
    $taObject->setTransactieId($taId);
    $taObject->selectTransactieById();
    //docs ophalen
    $docObject = new Doc();
    $dealId = $taId;
    $docsInDealLijst = $docObject->selectDocsinDeal($dealId);
}

function koperOphalen($transactieId) {
    $lidObject = new Lid();
    $koper = $lidObject->selectKoperInDeal($transactieId);
    return $koper;
}

function verkoperOphalen($transactieId) {
    $lidObject = new Lid();
    $verkoper = $lidObject->selectVerkoperInDeal($transactieId);
    return $verkoper;
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
            echo 'Betaald'; break;
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
    $verkoper = $lidObject->selectVerkoperInDeal($taId);
    $koper = $lidObject->selectKoperInDeal($taId);
    if($verzenderId == $verkoper['LidId'])
    {
        echo $koper['LidId'];
    }
    elseif($verzenderId == $koper['LidId'])
    {
        echo $verkoper['LidId'];
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
        <title>Hangend deal formulier</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/hangenddealformulier.css" type="text/css">
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
                $("#frmHangendDeal").on("click", "#imgEdit", updateTPKost);

                //4.tooltip
                $('img').tooltip();

            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });

            function updateTPKost() {
                $("#tpkost").removeAttr('readonly');
                $("#tpkost").focus();
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
             <div class="welcoming"><?php if ($_SESSION['lidstatus'] == 2) {echo "administrator";} elseif($_SESSION['lidstatus'] == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} ?></div>
        </div>
        </div>
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Hangend deal formulier</strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="mijn_hangende_deals.php" class="buttonterug">&nbsp;Terug</a>
        </p>
      
        <form id="frmHangendDeal" method="POST" action="../control/hangende_deal.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
            <div class="control-group_l">
                <label for="nummer" class="control-label">deal NUMMER:</label>
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
                <label for="koper" class="control-label">Koper:</label>
                <div class="controls"><input id="koper" name="koper" type="text" value="<?php $koper = koperOphalen($taObject->getTransactieId()); echo $koper['LidVoornaam']." ".$koper['LidNaam'];?>" readonly="true"></div>
            </div>
            <div class="control-group_r">
                <label for="verkoper" class="control-label">Verkoper:</label>
                <div class="controls"><input id="verkoper" name="verkoper" type="text" value="<?php $verkoper = verkoperOphalen($taObject->getTransactieId()); echo $verkoper['LidVoornaam']." ".$verkoper['LidNaam'];?>" readonly="true"></div>
            </div>
            </div>

            <div class="control-group">
            <div class="control-group_l">
                <label for="status" class="control-label">huidige status:</label>
                <div class="controls"><input id="status" name="status" type="text" value="<?php statusOphalen($taObject->getDealStatusId());?>" readonly="true"></div>
                
            </div>
            <div class="control-group_r">
                <label for="transport" class="control-label">Transport:</label>
                <div class="controls"><input id="transport" name="transport" type="text" value="<?php if($taObject->getTransportKost() != NULL) {echo "Verzenden";} else {echo "Ophalen";}?>" readonly="true"></div>
            </div>
            </div>

            <div class="control-group">
            <div class="control-group_l">
                <label for="prijs" class="control-label">Prijs (€):</label>
                <div class="controls"><input id="prijs" name="prijs" type="text" value="<?php echo $taObject->getOrderBedrag();?>" readonly="true"></div>
            </div>
            <div class="control-group_r">
                <label for="tpkost" class="control-label">Transport kost (€):</label>
                <div class="controls">
                <input id="tpkost" name="tpkost" type="text" value="<?php echo $taObject->getTransportKost();?>" readonly="true">
                <?php
                if($taObject->getDealStatusId() == 1)
                {
                //als verkoper
                $verkoper = verkoperOphalen($taObject->getTransactieId());
                if(($_SESSION['lidid'] == $verkoper['LidId']) && ($taObject->getTransportKost() != NULL))
                {
                ?>
                <img id="imgEdit" src="../../images/IconEdit.png" alt="edit" title="edit">
                <?php
                };
                }//einde 1
                elseif($taObject->getDealStatusId() == 2)
                {
                //als balspelende dealpartner
                //laatste modifiedby ophalen
                //als deze niet gelijk is aan de username van de ingelogde persoon, wordt de onderstaande knoppen getoond
                $laatsteGebruikersNaam = $taObject->getModifiedBy();
                $gebruiker = gebruikerOphalen($_SESSION['lidid']);//retourneert 2dim array
                $ingelogdeGebruikersNaam = $gebruiker[0]['GebruikersNaam'];//databank veld
                if(($laatsteGebruikersNaam !=  $ingelogdeGebruikersNaam) && ($taObject->getTransportKost() != NULL))
                {
                ?>      
                <img id="imgEdit" src="../../images/IconEdit.png" alt="edit" title="edit">
                <?php
                }
                }//einde 2  
                ?>
                </div>
                </div>
                </div><!--einde control group-->

            <div id="divdocs" class="control-group">
                <label for="docs" class="control-label">documenten:</label>
                <div class="controls">
                <table id="docsInDealTabel">
                    <thead>
                        <tr>
                        <th>NR.</th>
                        <th>TITEL</th>
                        <th>AUTEUR</th>
                        <th>DOCUMENT TYPE</th>
                        <th>PRIJS</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    foreach ($docsInDealLijst as $did)
                    {
                    $i=$did['docid'];
                    ?>
                    <tr id="<?php echo "didRij".$i ?>">
                        <td id="<?php echo "didId".$i ?>" class="Id"><?php echo $did['docid'] ?></td>
                        <td id="<?php echo "didTitel".$i ?>" class="Titel"><?php echo $did['titel'] ?></td>
                        <td id="<?php echo "didAuteur".$i ?>" class="Auteur"><?php auteurOphalen($did['auteurid']); ?></td>
                        <td id="<?php echo "didType".$i ?>" class="Type"><?php docTypeOphalen($did['doctypeid']); ?></td>
                        <td id="<?php echo "didPrijs".$i ?>" class="Prijs"><?php echo $did['prijs']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
                </div>
            </div>
            <!--nieuwe deal status ovv ddl-->
            <?php
            if($taObject->getDealStatusId() == 3)
            {
            //als verkoper
            $verkoper = verkoperOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verkoper['LidId'])
            {
            ?>
             <div class="control-group">
             <div class="control-group_l">
                <label for="nieuwstatus" class="control-label">nieuwe status:</label>
                <div class="controls">
                    <select id="nieuwstatus" name="newstatus" required>
                        <option></option>
                        <option value="5">Betaald</option>
                        <option value="6">Afgeleverd</option>
                        <option value="7">Verzonden</option>
                    </select>
                </div>
                 </div>
                 </div>
            <?php
            }//einde 3
            }
            elseif($taObject->getDealStatusId() == 5) //begin 5
            {
            //als verkoper
            $verkoper = verkoperOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verkoper['LidId'])
            {    
            ?>
            <div class="control-group">
            <div class="control-group_l">
                <label for="nieuwstatus" class="control-label">nieuwe status:</label>
                <div class="controls">
                    <select id="nieuwstatus" name="newstatus" required>
                        <option></option>
                        <option value="6">Afgeleverd</option>
                        <option value="7">Verzonden</option>
                    </select>
                </div>
                 </div>
                 </div>
            <?php
            }
            }//einde dealstatusid 5
            ?>

            <input id="idHidden" name="idhidden" type="hidden" value="<?php echo $taObject->getTransactieId(); ?>">
            <input id="idBestemmeling" name="idbestemmeling" type="hidden" value="<?php bestemmelingOphalen($taObject->getTransactieId()); ?>">
            <input id="datum" name="datum" type="hidden" value="<?php echo $taObject->getTADatum();?>">
            <?php
            //
            if($taObject->getDealStatusId() == 1)
            {
            //als verkoper
            $verkoper = verkoperOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verkoper['LidId'])
            {
            ?>
            <div class="control-group"> 
                    <div class="controls"> 
                    <button id="btnAgree" name="btnAgree" type="submit">&nbsp;Goedkeuren</button>
                    <button id="btnDeny" name="btnDeny" type="submit">&nbsp;Afkeuren</button>
                    <button id="btnUpdate" name="btnUpdate" type="submit" disabled>&nbsp;Voorstel wijzigen</button><!--enkel als koper verzenden wilt-->
                    </div>  
            </div>
            <?php
            };
            }//einde status 1
            elseif($taObject->getDealStatusId() == 2)
            {
            //als balspelende dealpartner
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
                    <button id="btnUpdate" name="btnUpdate" type="submit" disabled>&nbsp;Voorstel wijzigen</button><!--enkel als koper verzenden wilt-->
                    </div>  
            </div>
            <?php
            };
            }//einde status 2
            else 
            {
            //als verkoper
            $verkoper = verkoperOphalen($taObject->getTransactieId());
            if($_SESSION['lidid'] == $verkoper['LidId'])
            {
            ?>
            <div class="control-group"> 
                <div class="controls"> 
                <button id="btnAffirm" name="btnAffirm" type="submit">&nbsp;Bevestigen</button>
                <button id="btnCancel" name="btnCancel" type="reset">&nbsp;Annuleren</button>
                </div>  
            </div>
            <?php
            };//einde if verkoper
            }//einde status 3 en 5 
            ?>
         </form>     
         <div id="mailMessage"><?php if(isset ($_SESSION['mailmessagedeal'])) {echo $_SESSION['mailmessagedeal'];}; unset($_SESSION['mailmessagedeal']);?></div>
         <div class="push"></div> 
        </div><!--einde container-->
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>    
    </body>
</html>

