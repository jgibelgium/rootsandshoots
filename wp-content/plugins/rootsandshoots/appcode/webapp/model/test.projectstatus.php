 <?php

define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'projectstatus.class.php';

//selectAll testen
/*
$psObject = new ProjectStatus();
$statuses = $psObject->selectAll(); 
print_r($statuses);
*/

//selectProjectStatusById testen

$psObject = new ProjectStatus();
$status = $psObject->selectProjectStatusById(2);

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
            <li>Message: <?php echo $psObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $psObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $psObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <caption>Alle projectStati</caption>
            <tr>
                <th>ProjectStatusId</th>
                <th>ProjectStatus</th>
                
            </tr>
            <?php
                foreach ($statuses as $status)
                {
                    ?>
            <tr>
                <td style="width:  100px"><?php echo $status['ProjectStatusId'] ?></td>
                <td style="width:  100px"><?php echo $status['ProjectStatus'] ?></td>
                
            </tr>

            <?php
                }
            ?>
        </table>
        -->
        
         
        <p>Test selectProjectStatusById</p>
        <ul>
            <li>Message: <?php echo $psObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $psObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $psObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <tr>
                <th>ProjectStatusId</th>
                <th>ProjectStatus</th>
                
            </tr>
            <tr>
                <td style="width:  100px"><?php echo $status[0]['ProjectStatusId']; ?></td>
                <td style="width:  100px"><?php echo $status[0]['ProjectStatus']; ?></td>
               
            </tr>
        </table>
           

    </body>
</html>


