<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/woonplaats.class.php');
include('../model/lid.class.php'); 

session_start();

if(!isset($_SESSION['lidstatus']))
{
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

$lidObject = new Lid();
$lidId = $_SESSION['lidid'];
$lidObject->setLidId($lidId);
$lid = $lidObject->selectLidById();

$woonplaatsObject = new Woonplaats();
$woonplaatsen = $woonplaatsObject->selectAll();

$deleteMessage = isset($_SESSION['deletemessage'])? $_SESSION['deletemessage'] : "";
unset($_SESSION['deletemessage']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Mijn account</title>
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

                //2. opslaan en delete button voorzien van stijl
                $("button[type=submit]").button(
                {
                    icons: { primary: " ui-icon-disk" }
                });
                $("button[id=btnAccountDelete]").button(
                {
                    icons: { primary: " ui-icon-trash" }
                });

                //3. dialog widget no deletion possible
                if ($("#deleteMessage").text().trim().length != 0) {
                    $("#deleteMessage").dialog({
                        buttons: {
                            "OK": function () { $(this).dialog("close"); }
                        }
                    }); //einde dialog
                }; //einde if

                //4. account verwijderen
                $("#btnAccountDelete").on('click',verwijderAccount);

            }); //einde ready event

            $(function () {
                $("#sluitinfo").click(function () {
                    $("#rodebalk").hide();
                });
            });

            function verwijderAccount() {
                var id = $("#idHidden").attr("value");
                $("#warningDeletion").dialog(
                {
                    buttons: [
                {
                    text: "Ja",
                    click: function () { window.location.href = '../control/lid.control.php?accountid=' + id; }
                },
                {
                    text: "Nee",
                    click: function () { $(this).dialog("close"); }
                }]
                });
            };//einde verwijderAccount
          </script>
         
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
            <div class="welcoming"><?php echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];?></div>
        </div>
        </div>
            
        <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Mijn account</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="welkom.php" class="buttonterug">&nbsp;Thuis</a>
        </p>
        <!--action attribuut wordt door elke knop in de frm aangesproken-->
        <form id="frmAccount" method="POST" action="../control/lid.control.php" class="form-horizontal" enctype="multipart/form-data">
            
            <div class="control-group">
                  <label for="username" class="control-label">GEBRUIKERSNAAM:</label><div class="controls"><input id="username" name="username" value="<?php echo $lidObject->getGebruikersNaam();?>" required></div>
            </div>
            <div class="control-group">
                  <label for="password" class="control-label">WACHTWOORD:</label><div class="controls"><input id="password" name="password" value="<?php echo $lidObject->getWachtwoord();?>" required></div>
            </div>
            <div class="control-group">
                 <label for="naamLid" class="control-label">NAAM:</label><div class="controls"><input id="naamLid" name="naamLid" type="text" autofocus="true" value="<?php echo $lidObject->getLidNaam();?>" required></div>
            </div>
            <div class="control-group">
                 <label for="voornaamLid" class="control-label">VOORNAAM:</label><div class="controls"><input id="voornaamLid" name="voornaamLid" type="text" value="<?php echo $lidObject->getLidVoornaam();?>" required></div>
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
                <button id="btnAccountUpdate" name="btnAccountUpdate" type="submit">&nbsp;Wijzigen</button>
               
                </div>
            </div>          
         </form>   
         <button id="btnAccountDelete">&nbsp;Account verwijderen</button> 
         <div id="warningDeletion">Bent u zeker om uw account te verwijderen?</div>
         <div id="deleteMessage"><?php echo $deleteMessage; ?></div>
        </div>
    </body>
</html>
