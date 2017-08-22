<?php
//is needed because there is no reference to this page in the plugin's main file
session_start()  ;

//require_once RS_PLUGIN_PATH.'appcode/webapp/help/cleaninput.php';
//seems to be needed allthough already defined in rootsandshoots.php
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\projecttype.class.php';

//delete
if (isset($_GET['projecttypeid']))
{
    echo "projecttypeid: ".$_GET['projecttypeid'];
    $projectTypeObject = new projectType();
    $projectTypeId = $_GET['projecttypeid'];
    $result = $projectTypeObject->delete($projectTypeId);
    if($result)
    {
        header('Location: http://localhost:8080/rootsandshootseurope/project-types/');
    }
    else
    {
        $message = "The project type could not be deleted. Try later again or contact the administrator.";
        $_SESSION['message'] = $message;
        header('Location: http://localhost:8080/rootsandshootseurope/failure/');
    }
}




//add
//$_POST is always set, but its content might be empty.
if(isset($_POST['btnProjectTypeSave']))
{
        //$_POST = cleanInput($_POST);
        $projectTypeObject = new ProjectType();
        $projectType = $_POST['projecttype'];
        $projectTypeInfo = $_POST['projecttypeinfo'];
        $result = $projectTypeObject->insert($projectType, $projectTypeInfo);
        if($result)
        {
            header('Location: http://localhost:8080/rootsandshootseurope/project-types/');
        }
        else
        {
            $message = $projectTypeObject->getFeedback();
            $_SESSION['message'] = $message;
            echo $message;
            header('Location: http://localhost:8080/rootsandshootseurope/failure/');
        }
}


//update
if(isset($_POST['btnProjectTypeUpdate']))
{
        //$_POST = cleanInput($_POST);
        $projectTypeObject = new ProjectType();
        $projectTypeId = $_POST['idHidden'];
        $projectType = $_POST['projecttype'];
        $projectTypeInfo = $_POST['projecttypeinfo'];
        $result = $projectTypeObject->update($projectTypeId, $projectType, $projectTypeInfo);
        if($result)
        {
            header('Location: http://localhost:8080/rootsandshootseurope/project-types/');
        }
        else
        {
            $message = $projectTypeObject->getFeedback();
            $_SESSION['message'] = $message;
            header('Location: http://localhost:8080/rootsandshootseurope/failure/');
        }
}


?>

