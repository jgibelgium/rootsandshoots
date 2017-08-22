<?php
require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/role.class.php';

function rs_test_SelectRoles()
{
$roleObject = new Role();
$roles = $roleObject->selectAll();
print_r($roles);
?>
<table>
<tbody>
<?php
foreach($roles as $role)
{
?>
<tr><td><?php  echo $role['RoleId']; ?></td><td><?php  echo $role['Role']; ?></td></tr>
<?php
}//end foreach
?>
</tbody>
</table>
<br />
<p>Test select roles</p>
        <ul>
            <li>Message: <?php echo $roleObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $roleObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $roleObject->getErrorCode(); ?></li>
        </ul>
</p
<?php
}//end function  

?>

