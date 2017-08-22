<?php
define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\projectprojecttype.class.php';

//insert testen
/*
$ppTypeObject = new ProjectProjectType();
$projectId = 5;
$projectTypeId = 1;
$insertedBy = "admin";
$ppTypeObject->insert($projectId, $projectTypeId, $insertedBy);
*/

//update testen
/*
$ppTypeObject = new ProjectProjectType();
$ppTypeId = 5;
$projectId = 5;
$projectTypeId = 2;
$modifiedBy = "admin";
$ppTypeObject->update($ppTypeId, $projectId, $projectTypeId, $modifiedBy);
*/

//selectProjectTypesByProjectId testen
/*
$ppTypeObject = new ProjectProjectType();
$projectTypes = $ppTypeObject->selectProjectTypesByProjectId(1);
print_r($projectTypes);
*/

//delete 
$ppTypeObject = new ProjectProjectType();
$ppTypeObject->delete(5);

?>

<p>Test deleting  ProjectProjectType</p>
        <ul>
            <li>Message: <?php echo $ppTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $ppTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $ppTypeObject->getErrorCode(); ?></li>
        </ul>
</p>


<!--
<p>Test selectProjectTypesByProjectId</p>
        <ul>
            <li>Message: <?php echo $ppTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $ppTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $ppTypeObject->getErrorCode(); ?></li>
        </ul>
</p>

<table>
<tbody>
<?php
foreach($projectTypes as $projectType)        
{
?>
<tr><td><?php  echo $projectType['ProjectTypeId']; ?></td></tr>
<?php
}
?>
</tbody>
</table>
<br />
-->

<!--
<p>Test updating  ProjectprojectType</p>
        <ul>
            <li>Message: <?php echo $ppTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $ppTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $ppTypeObject->getErrorCode(); ?></li>
        </ul>
</p>
-->

<!--
<br />
<p>Test inserting  ProjectprojectType</p>
        <ul>
            <li>Message: <?php echo $ppTypeObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $ppTypeObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $ppTypeObject->getErrorCode(); ?></li>
            <li>Error code: <?php echo $ppTypeObject->getProjectProjectTypeId(); ?></li>
        </ul>
</p>
-->



