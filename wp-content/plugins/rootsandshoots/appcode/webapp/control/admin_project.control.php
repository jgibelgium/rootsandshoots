<?php
ob_start();  

require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/project.class.php'; 

add_action('rs_admin_project_control_hook', 'rs_Admin_ControlProject');

function rs_Admin_ControlProject()
{

if (isset($_GET['projectid']))
{
    $projectObject = new Project();
    $projectId = $_GET['projectid'];
    $result = $projectObject->delete($projectId);
    //wegens on delete cascade ook alle childrecords gewist
    if($result)
    {
          header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
    }
    else
    {
        $message = "No deletion possible.";
        $_SESSION['rs_message'] = $message;
        header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
    } 
}

}//end fc rs_Control_Project


?>


