<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/woonplaats.class.php');

session_start();

if(isset($_SESSION['lidstatus']))
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
    
    session_destroy();
    header('Location: ../../../index.php');
}

$woonplaatsObject = new Woonplaats();
$woonplaatsen = $woonplaatsObject->selectAll();

$usernameMessage = (isset($_SESSION['userMessage']))? $_SESSION['userMessage'] : "";
unset($_SESSION['userMessage']);

$passwordMessage = (isset($_SESSION['passMessage']))? $_SESSION['passMessage'] : "";
unset($_SESSION['passMessage']);

$lidNaam = (isset($_SESSION['lidNaam'])) ? $_SESSION['lidNaam'] : "";
$lidVoornaam = (isset($_SESSION['lidVoornaam'])) ? $_SESSION['lidVoornaam'] : "";
$lidAdres = (isset($_SESSION['lidAdres'])) ? $_SESSION['lidAdres'] : "";
$lidTelefoon = (isset($_SESSION['lidTelefoon'])) ? $_SESSION['lidTelefoon'] : "";
$lidEmail = (isset($_SESSION['lidEmail'])) ? $_SESSION['lidEmail'] : "";
$lidSkype = (isset($_SESSION['lidSkype'])) ? $_SESSION['lidSkype'] : "";
$lidInfo = (isset($_SESSION['lidInfo'])) ? $_SESSION['lidInfo'] : "";
$woonPlaatsId = (isset($_SESSION['lidWoonplaats'])) ? $_SESSION['lidWoonplaats'] : "";
unset($_SESSION['lidNaam']);
unset($_SESSION['lidVoornaam']);
unset($_SESSION['lidAdres']);
unset($_SESSION['lidTelefoon']);
unset($_SESSION['lidEmail']);
unset($_SESSION['lidSkype']);
unset($_SESSION['lidInfo']);
unset($_SESSION['lidWoonplaats']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Inschrijving pagina</title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <link rel="stylesheet" href="css/formulier.css" type="text/css">
        <link rel="stylesheet" href="css/registreer.css" type="text/css">
        <?php include ('../help/jquery.php');?>
        <script>
            function foutBijGebruikersnaam() {
                //plaatst foutmelding en kleurt inputveld geel
                $("#username").after("<br /><span class='foutmelding'>De gebruikersnaam is niet uniek.</span><br />");
                $("#username").addClass("foutveld");
                $("#username").focus();
            }

            function foutBijWachtwoord() {
                //plaatst foutmelding en kleurt inputveld geel
                $("#password").after("<br /><span class='foutmelding'>Het wachtwoord is niet uniek.</span><br />");
                $("#password").addClass("foutveld");
                $("#password").focus();
            }

            function controleerLidInfo() {
                var q = $("#lidInfo").val();
                if (q.length > 255) {
                    return false;
                }
                else {
                    return true;
                }
            }

            function foutBijLidInfo(zichtbaar) {
                if (zichtbaar && $("#lidInfo.foutveld").length == 0) {
                    //plaatst foutmelding en kleurt inputveld geel
                    $("#lidInfo").after("<br /><span class='foutmelding'>De info is te lang.</span><br />");
                    $("#lidInfo").addClass('foutveld');
                    $("#lidInfo").focus();
                }
                //verwijdert foutmelding en ontkleurt inputveld
                if (!zichtbaar && $("#lidInfo.foutveld").length != 0) {
                    $("#lidInfo").next().remove(); //verwijdert de eerste br tag
                    $("#lidInfo").next().remove();
                    $("#lidInfo").next().remove(); //verwijdert de laatste br tag
                    $("#lidInfo").removeClass('foutveld');
                }
            }

            function controleerEmailAdres() {
                var patroon = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/;
                var email = $("#lidEmail").val().toUpperCase();
                if (patroon.test(email))
                    return true;
                else {
                    return false;
                }
            }

            function foutBijEmailAdres(zichtbaar) {
                //plaatst foutmelding en kleurt inputveld geel
                if (zichtbaar && $("#lidEmail.foutveld").length == 0) {
                    $("#lidEmail").after("<br /><span class='foutmelding'>Dit email adres is onjuist.</span><br />");
                    $("#lidEmail").addClass('foutveld');
                    $("#lidEmail").focus();
                }
                //verwijdert foutmelding en ontkleurt inputveld
                if (!zichtbaar && $("#lidEmail.foutveld").length != 0) {
                    $("#lidEmail").next().remove(); //verwijdert de eerste br tag
                    $("#lidEmail").next().remove();
                    $("#lidEmail").next().remove(); //verwijdert de laatste br tag
                    $("#lidEmail").removeClass('foutveld');
                }
            }


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

                //2.
                $("input:first").focus();

                //3.
                $("button[type=submit]").button(
                {
                    icons: { primary: " ui-icon-disk" }
                });
                $("button[type=reset]").button(
                {
                    icons: { primary: " ui-icon-cancel" }
                });

                //4. pre submit validatie
                $("#lidInfo").change(function() {
                    var correctInfo = controleerLidInfo();
                    foutBijLidInfo(!correctInfo);
                })

                //event treedt op 1) als een reeds ingevuld email adres gewijzigd wordt en de cursor uit het input veld gaat
                //2) als een leeg input veld van email adres gewijzigd wordt en de cursor uit het input veld gaat
                $("#lidEmail").change(function () {
                    var correctAdres = controleerEmailAdres();
                    foutBijEmailAdres(!correctAdres);
                });

                //5. post submit feedback van server
                var unMessage = $("#usernameMessage").val().trim().length;
                if (unMessage != 0) {
                    foutBijGebruikersnaam();
                }

                var pwMessage = $("#passwordMessage").val().trim().length;
                if (pwMessage != 0) {
                    foutBijWachtwoord();
                }

            });

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
            <div class="welcoming">Bezoeker</div>
        </div>
        </div>
            
        <div id="rodebalk" class="alert-info">
            <strong>&nbsp;Inschrijving</strong>
            <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        <form id="frmRegistreer" method="post" action="../control/inschrijving.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
                <label for="username" class="control-label">Gebruikersnaam</label>
                <div class="controls"><input id="username" name="username" type="text" autofocus="true" required><span class="asterisk_input"></span></div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">Wachtwoord</label>
                <div class="controls"><input id="password" name="password" type="text" required><span class="asterisk_input"></span></div>
            </div>
            <div class="control-group">
                <label for="lidNaam" class="control-label">Naam</label>
                <div class="controls"><input id="lidNaam" name="lidNaam" type="text" value="<?php echo $lidNaam; ?>" required style="width: 20em"><span class="asterisk_input"></span></div>
            </div>
            <div class="control-group">
                <label for="lidVoornaam" class="control-label">Voornaam</label>
                <div class="controls"><input id="lidVoornaam" name="lidVoornaam" type="text" value="<?php echo $lidVoornaam; ?>" required style="width: 20em"><span class="asterisk_input"></span></div>
            </div>
             <div class="control-group">
                <label for="lidAdres" class="control-label">Adres</label>
                <div class="controls"><input id="lidAdres" name="lidAdres" type="text" value="<?php echo $lidAdres; ?>" required style="width: 20em"><span class="asterisk_input"></span></div>
            </div>
             <div class="control-group">
                <label for="lidWoonplaats" class="control-label">Woonplaats</label>
                <div class="controls"><select id="lidWoonplaats" name="lidWoonplaats" style="width: 13em">
                            <option></option> 
                            <?php
                            foreach($woonplaatsen as $woonplaats)
                            {
                            ?>
                            <option id="<?php echo "woonplaats".$woonplaats['WoonplaatsId']; ?>" value="<?php echo $woonplaats['WoonplaatsId'];?>" <?php if($woonPlaatsId == $woonplaats['WoonplaatsId']){echo "selected";}?>><?php echo $woonplaats['Postcode']." ".$woonplaats['Gemeente'];?></option> 
                            <?php
                            }
                            ?>
            </select></div>
            </div>
            <div class="control-group">
                <label for="lidTelefoon" class="control-label">Telefoon</label>
                <div class="controls"><input id="lidTelefoon" name="lidTelefoon" type="text" value="<?php echo $lidTelefoon; ?>"></div>
            </div>
            <div class="control-group">
                <label for="lidEmail" class="control-label">E-mail adres</label>
                <div class="controls"><input id="lidEmail" name="lidEmail" type="text" value="<?php echo $lidEmail; ?>" required><span class="asterisk_input"></span></div>
            </div>
            <div class="control-group">
                <label for="lidSkype" class="control-label">Skype naam</label>
                <div class="controls"><input id="lidSkype" name="lidSkype" type="text" value="<?php echo $lidSkype; ?>"></div>
            </div>
            <div class="control-group">
                <label for="lidInfo" class="control-label">Info</label>
                <div class="controls"><textarea id="lidInfo" name="lidInfo" rows="5" cols="22" placeholder="max 255 karakters" style="resize: none">
                <?php echo $lidInfo;?></textarea></div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button id="btnLidSave" name="btnLidSave" type="submit">Opslaan</button>
                    <button id="btnLidReset" name="btnLidReset" type="reset">Annuleren</button>
                </div>
            </div>
        </form>
        <input id="usernameMessage" type="hidden" value="<?php echo $usernameMessage; ?>">
        <input id="passwordMessage" type="hidden" value="<?php echo $passwordMessage; ?>">
        <div class="push"></div>       
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>     
    </body>
</html>
