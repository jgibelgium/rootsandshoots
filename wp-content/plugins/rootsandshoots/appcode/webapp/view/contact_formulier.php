<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/lid.class.php');

session_start();

if(!isset($_SESSION['lidstatus']))
{
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
$lidObject->setLidId($_SESSION['lidid']);
$lid = $lidObject->selectLidById();//tbv welcoming
$leden = $lidObject->selectAll();

$mailMessage = isset($_SESSION['mailmessage'])? $_SESSION['mailmessage'] :  "";
unset($_SESSION['mailmessage']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Contact formulier</title>
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

                //2. verzend en reset button voorzien van stijl
                $("button[type=submit]").button(
                {
                    icons: { primary: " ui-icon-mail-closed" }
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

            //ajax ter invulling van email adres
            function showEmailLid(str) {
                var xmlhttp;
                if (str == "") {
                    document.getElementById("emailBestemmeling").value = "";
                }
                else
                {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("emailBestemmeling").value = xmlhttp.responseText; //responseText is in string formaat
                        //readyState, status en responseText zijn wellicht standaardvariabelen van het http
                    }
                }
                xmlhttp.open("GET", "ajax.view.php?q=" + str, true); //get duidt op gebruik van querystring; true duidt op ansynchroniciteit
                xmlhttp.send();
                }
            }
        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php')?>
        <div class="pull-right">
             <div class="welcoming"><?php if ($lidStatus == 2) {echo "administrator";} elseif($lidStatus == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];}?></div>
        </div>
        </div>
        <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Contactformulier</strong>
                <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <p>
            <a href="leden.php" class="buttonterug">&nbsp;Alle leden</a>
        </p>
        <form id="frmContact" method="POST" action="../control/contact.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
            <label for="lidId" class="control-label">NAAM BESTEMMELING:</label>
            <div class="controls">
            <select id="lidid" name="lidid" onchange="showEmailLid(this.value)">
                            <option id="eb0" value="0"></option> 
                            <?php
                            foreach($leden as $lid)
                            {
                            ?>
                            <option id="<?php echo "eb".$lid['LidId']; ?>" value="<?php echo $lid['LidId'];?>"><?php echo $lid['LidNaam']." ".$lid['LidVoornaam'];?></option> 
                            <?php
                            }
                            ?>
            </select>
            </div>
            </div>

            <div class="control-group">
                 <label class="control-label">E-MAIL BESTEMMELING:</label><div class="controls"><input id="emailBestemmeling" type="text" value="" readonly="readonly"></div>
            </div>
            <div class="control-group">
                 <label for="onderwerp" class="control-label">ONDERWERP:</label><div class="controls"><input id="onderwerp" name="onderwerp" type="text"></div>
            </div>
            <div class="control-group">
                  <label for="bericht" class="control-label">BERICHT:</label><div class="controls"><textarea id="bericht" name="bericht" rows="10" cols="40" placeholder="een bericht kan niet leeg zijn" style="resize: none"></textarea></div>
            </div>
                     
            <div class="control-group">
                <div class="controls">
                <button id="btnContactVerzend" name="btnContactVerzend" type="submit">&nbsp;Verzenden</button>
                <button id="btnContactCancel" type="reset">&nbsp;Annuleren</button>
                </div>
            </div>          
         </form>     
         <div id="mailMessage"><?php echo $mailMessage;?></div>
         <div class="push"></div>     
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>    
    </body>
</html>

