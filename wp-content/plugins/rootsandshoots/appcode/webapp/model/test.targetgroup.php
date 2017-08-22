 <?php

define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'targetgroup.class.php';

//selectAll testen
/*
$tgObject = new TargetGroup();
$targetgroups = $tgObject->selectAll(); 
*/

//selectTargetGroupById testen

$tgObject = new TargetGroup();
$targetgroup = $tgObject->selectTargetGroupById(2);

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
            <li>Message: <?php echo $tgObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $tgObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tgObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <caption>Alle targetgroups</caption>
            <tr>
                <th>TargetGroupId</th>
                <th>TargetGroup</th>
                
            </tr>
            <?php
                foreach ($targetgroups as $targetgroup)
                {
                    ?>
            <tr>
                <td style="width:  100px"><?php echo $targetgroup['TargetGroupId'] ?></td>
                <td style="width:  100px"><?php echo $targetgroup['TargetGroup'] ?></td>
                
            </tr>

            <?php
                }
            ?>
        </table>
        -->
        
         
        <p>Test selectTargetGroupById</p>
        <ul>
            <li>Message: <?php echo $tgObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $tgObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $tgObject->getErrorCode(); ?></li>
        </ul>
        <table border="1">
            <tr>
                <th>TargetGroupId</th>
                <th>TargetGroup</th>
                
            </tr>
            <tr>
                <td style="width:  100px"><?php echo $targetgroup[0]['TargetGroupId'] ?></td>
                <td style="width:  100px"><?php echo $targetgroup[0]['TargetGroup'] ?></td>
                
            </tr>
        </table>
             

    </body>
</html>


