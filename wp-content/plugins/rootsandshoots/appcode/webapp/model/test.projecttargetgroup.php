<?php
define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projecttargetgroup.class.php';

//insert testen
/*
$targetGroupObject = new ProjectTargetGroup();
$projectId = 20 ;
$targetGroupId = 1;
$insertedBy = 'admin';
$targetGroupObject->insert($projectId, $targetGroupId, $insertedBy);
*/

//update testen
/*
$targetGroupObject = new ProjectTargetGroup();
$projectTargetGroupId = 9;
$projectId = 20 ;
$targetGroupId = 1;
$modifiedBy = 'admin';
$targetGroupObject->update($projectTargetGroupId, $projectId, $targetGroupId, $modifiedBy);
 */

//testen selectTargetGroupsByProjectId
/*
$targetGroupObject = new ProjectTargetGroup();
$targetgroups = $targetGroupObject->selectTargetGroupsByProjectId(20);
print_r($targetgroups);
*/

//delete testen
$targetGroupObject = new ProjectTargetGroup();
$targetGroupObject->delete(9);
 

?>
<p>Test deleting projecttargetgroup</p>
        <ul>
            <li>Message: <?php echo $targetGroupObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $targetGroupObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $targetGroupObject->getErrorCode(); ?></li>
        </ul>
</p>


<!--
<p>Test selectTargetGroupsByProjectId</p>
        <ul>
            <li>Message: <?php echo $targetGroupObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $targetGroupObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $targetGroupObject->getErrorCode(); ?></li>
        </ul>
</p>
-->

<!--
<p>Test inserting  ProjectTargetGroup</p>
        <ul>
            <li>Message: <?php echo $targetGroupObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $targetGroupObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $targetGroupObject->getErrorCode(); ?></li>
        </ul>
</p>
-->

<!--
<p>Test updating  ProjectTargetGroup</p>
        <ul>
            <li>Message: <?php echo $targetGroupObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $targetGroupObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $targetGroupObject->getErrorCode(); ?></li>
        </ul>
</p>
-->

