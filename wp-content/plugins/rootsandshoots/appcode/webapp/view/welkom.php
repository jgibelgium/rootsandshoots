<?php
include('../../helpers/feedback.class.php');    
include('../../helpers/base.class.php');
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

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Welkom <?php if ($lidStatus == 2) {echo "administrator";} elseif($lidStatus == 1) {echo "lid";} elseif($lidStatus == 0) {echo "bezoeker";}?></title>
        <link rel="stylesheet" href="css/files.css" type="text/css">
        <?php include ('../help/jquery.php');?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#jMenu").jMenu(
                {
                    ulWidth: '220px',
                    effects: {
                        effectSpeedOpen: 300,
                        effectTypeClose: 'slide'
                    },
                    animatedText: true
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
        <div class="menuenwelkom">
        <?php include('../help/dashboard.php');?>
        <div class="pull-right">
             <div class="welcoming">
              <?php if (isset($_SESSION['lidstatus']))
              {
                  if($_SESSION['lidstatus'] == 2) {echo "administrator";} elseif($_SESSION['lidstatus'] == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} 
              }
              else {echo "bezoeker";}?></div>
        </div>
        </div>

        <div>
        <h2>WELKOM <?php if (isset($_SESSION['lidstatus']))
              {
                  if($_SESSION['lidstatus'] == 2) {echo "administrator";} elseif($_SESSION['lidstatus'] == 1) {echo $lid[0]['LidVoornaam']." ".$lid[0]['LidNaam'];} 
              }
              else {echo "bezoeker";}?></h2>
        </div>
        <div class="push"></div>   
        </div>
        <div id="footer" class="footer">vzw Onder Ons Lezen</div>  
    </body>
</html>


