<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/taal.class.php');
include('../model/doc.class.php');
include('../model/doctype.class.php');
include('../model/toestand.class.php');
include('../model/lid.class.php');

session_start();

if(isset($_SESSION['lidstatus']))
{
    include('../help/sessie.class.php');
    Sessie::checkSessionId();
    Sessie::registerLastActivity();//heeft $_SESSION['lidid'] nodig
}

//tbv welcoming
if(isset($_SESSION['lidid']))
{
    $lidObject = new Lid();
    $lidObject->setLidId($_SESSION['lidid']);
    $lid = $lidObject->selectLidById();
}

$lidObject = new Lid();
$leden = $lidObject->selectAll();

$taalObject = new Taal(); 
$talen = $taalObject->selectAll(); 

$docTypeObject = new DocType(); 
$docTypes = $docTypeObject->selectAll(); 

$toestandObject = new Toestand(); 
$toestanden = $toestandObject->selectAll(); 

if(isset($_POST['btnZoek']))
{
    $docObject = new Doc();
    $titel = $_POST['titel'];
    if(isset($_POST['jaar']))
    {
        $jaar = $_POST['jaar'];
    }
    else
    {
         $jaar = NULL;
    }
    if(!empty($_POST['taalid']))
    {
        $taalId = $_POST['taalid'];
    }
    else
    {
         $taalId = NULL;
    }
    if(isset($_POST['toestandid']))
    {
        $toestandId = $_POST['toestandid'];
    }
    else
    {
         $toestandId = NULL;
    }
    if(!empty($_POST['doctypeid']))
    {
        $docTypeId = $_POST['doctypeid'];
    }
    else{
         $docTypeId = NULL;
    }
    
    if(isset($_POST['lidid']))
    {
        $lidId = $_POST['lidid'];
    }
    else
    {
         $lidId = NULL;
    }
    
    $documentenLijst = $docObject->filterAllAvailable($titel, $taalId, $docTypeId);
    print_r($documentenLijst);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Zoek formulier</title>
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
                    icons: { primary: " ui-icon-search" }
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
        <div id="rodebalk" class="alert-info">
                <strong>&nbsp;Zoek formulier</strong>
                 <button id="sluitinfo" type="button" class="close">&times;</button>    
        </div>
        
        <form id="frmZoek" method="POST" action="geavanceerde_zoek_resultaat.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
            <label class="control-label" for="titel">Titel</label>
            <div class="controls">
            <input type="text" name="titel" id="titel" required><span class="asterisk_input"></span>
            </div>
            </div>
        
            <div class="control-group">
                 <label class="control-label" for="docTypeId">document type:</label>
                 <div class="controls">
                    <select id="docTypeId" name="doctypeid">
                            <option></option> 
                            <?php
                            foreach($docTypes as $docType)
                            {
                            ?>
                            <option id="<?php echo "dt".$docType['DocTypeId']; ?>" value="<?php echo $docType['DocTypeId']; ?>"><?php echo $docType['DocType'];?></option> 
                            <?php
                            }
                            ?>
                    </select>
                 </div>
            </div>

            <div class="control-group">
                 <label class="control-label" for="taalId">taal:</label>
                 <div class="controls">
                    <select id="taalId" name="taalid">
                            <option></option> 
                            <?php
                            foreach($talen as $taal)
                            {
                            ?>
                            <option id="<?php echo "dt".$taal['TaalId']; ?>" value="<?php echo $taal['TaalId']; ?>"><?php echo $taal['Taal'];?></option> 
                            <?php
                            }
                            ?>
                    </select>
                 </div>
            </div>
            <!--
            <div class="control-group">
                 <label class="control-label" for="toestandId">toestand:</label>
                 <div class="controls">
                    <select id="toestandId" name="toestandid">
                            <option></option> 
                            <?php
                            foreach($toestanden as $toestand)
                            {
                            ?>
                            <option id="<?php echo "t".$toestand['ToestandId']; ?>" value="<?php echo $toestand['ToestandId']; ?>"><?php echo $toestand['Toestand'];?></option> 
                            <?php
                            }
                            ?>
                    </select>
                 </div>
            </div>
            
            <div class="control-group">
            <label for="lidId" class="control-label">eigenaar:</label>
            <div class="controls">
            <select id="lidId" name="lidid">
                            <option></option> 
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
               -->    
            <div class="control-group">
                <div class="controls">
                <button id="btnZoek" name="btnZoek" type="submit">&nbsp;Zoeken</button>
                <button id="btnCancel" type="reset">&nbsp;Annuleren</button>
                </div>
            </div>          
         </form>
          <div class="push"></div>         
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>   
    </body>
</html>

