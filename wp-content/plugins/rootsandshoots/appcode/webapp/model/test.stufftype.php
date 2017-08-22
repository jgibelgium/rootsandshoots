<?php
require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/stufftype.class.php';

function rs_test_SelectStuffTypes() {
$stuffTypeObject = new StuffType();
$stuffTypes = $stuffTypeObject->selectAll();
print_r($stuffTypes);

?>

<p>Test select all stufftypes</p>
<ul>
            <li>Message: <?php echo $stuffTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $stuffTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $stuffTypeObject->getErrorCode(); ?></li>
</ul>
<table border="1">
<caption>All stufftypes</caption>
            <tr>
                <th>StuffTypeId</th>
                <th>StuffType</th>
            </tr>
            <?php
                foreach ($stuffTypes as $stufftype)
                {
            ?>
            <tr>
                <td style="width:  100px"><?php echo $stufftype['StuffTypeId'] ?></td>
                <td style="width:  100px"><?php echo $stufftype['StuffType'] ?></td>
            </tr>
            <?php
                }
            ?>
        </table>


   <?php
}//end function
   ?>
