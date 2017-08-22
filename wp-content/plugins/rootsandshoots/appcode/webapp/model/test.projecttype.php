<?php
define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'projecttype.class.php';

/*select all*/
/*
$pTObject = new ProjectType();
$pTypes = $pTObject->selectAll();
print_r($pTypes);
 * */

/*selectprojecttypebyid*/
/*
$projectTypeObject = new ProjectType();
$fpt = $projectTypeObject->selectProjectTypeById(2);
print_r($fpt);
*/

/*insert projecttype*/
/*
$projectTypeObject = new ProjectType();
$projectType = "blabla";
$projectTypeInfo = "test";
$projectTypeObject->insert($projectType, $projectTypeInfo);
*/

/*update projecttype*/
/*
$projectTypeObject = new ProjectType();
$projectTypeId = 14;
$projectType = "blablabla";
$projectTypeInfo = "test";
$projectTypeObject->update($projectTypeId, $projectType, $projectTypeInfo);
 * */

/*delete*/
$projectTypeObject = new ProjectType();
$projectTypeObject->delete(14);

?>



<p>Test deleting  ProjectType</p>
        <ul>
            <li>Message: <?php echo $projectTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $projectTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $projectTypeObject->getErrorCode(); ?></li>
        </ul>
</p>

<!--
<p>Test updating ProjectType</p>
        <ul>
            <li>Message: <?php echo $projectTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $projectTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $projectTypeObject->getErrorCode(); ?></li>
        </ul>
</p>
-->

<!--
<p>Test inserting ProjectType</p>
        <ul>
            <li>Message: <?php echo $projectTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $projectTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $projectTypeObject->getErrorCode(); ?></li>
        </ul>
</p>
-->
 * 
<!--
<p>Test select ProjectTypeById</p>
        <ul>
            <li>Message: <?php echo $projectTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $projectTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $projectTypeObject->getErrorCode(); ?></li>
        </ul>
</p>

<table>
<tbody>
<tr><td><?php  echo $fpt[0]['ProjectTypeId']; ?></td><td><?php  echo $fpt[0]['ProjectType']; ?></td><td><?php  echo $fpt[0]['ProjectTypeInfo']; ?></td></tr>
</tbody>
</table>
<br />
-->




<!--
<table>
<tbody>
<?php
foreach($pTypes as $pType)
{
?>
<tr>
    <td><?php  echo $pType['ProjectTypeId']; ?></td><td><?php  echo $pType['ProjectType']; ?></td><td><?php echo $pType['ProjectTypeInfo']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<br />
<p>Test select projecttypes</p>
        <ul>
            <li>Message: <?php echo $pTObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $pTObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $pTObject->getErrorCode(); ?></li>
        </ul>
</p>
-->




