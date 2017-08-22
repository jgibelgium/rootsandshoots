<?php
define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'timeframe.class.php';


//selectAll testen
/*
$tfObject = new TimeFrame();
$timeframes = $tfObject->selectAll(); 
print_r($timeframes);
*/

//selectLanguageById testen

$tfObject = new TimeFrame();
$timeframe = $tfObject->selectTimeFrameById(2);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <!--
        <p>Test select all</p>
        <ul>
            <li>Message: <?php echo $tfObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $tfObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tfObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <caption>Alle timeframes</caption>
            <tr>
                <th>TimeFrameId</th>
                <th>TimeFrame</th>
                
            </tr>
            <?php
                foreach ($timeframes as $timeframe)
                {
                    ?>
            <tr>
                <td style="width:  100px"><?php echo $timeframe['TimeFrameId'] ?></td>
                <td style="width:  100px"><?php echo $timeframe['TimeFrame'] ?></td>
                
            </tr>

            <?php
                }
            ?>
        </table>
        -->
        
         
        <p>Test selectTimeFrameById</p>
        <ul>
            <li>Message: <?php echo $tfObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $tfObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tfObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <tr>
                <th>TimeFrameId</th>
                <th>TimeFrame</th>
                
            </tr>
            <tr>
                <td style="width:  100px"><?php echo $timeframe[0]['TimeFrameId']; ?></td>
                <td style="width:  100px"><?php echo $timeframe[0]['TimeFrame']; ?></td>
               
            </tr>
        </table>
         

    </body>
</html>


?>
