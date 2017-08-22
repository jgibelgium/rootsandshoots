<?php
ob_start();  

require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/project.class.php'; 
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projectprojecttype.class.php'; 
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projecttargetgroup.class.php'; 
require_once RS_PLUGIN_PATH.'appcode/webapp/help/cleaninput.php';

add_action('project_control_hook', 'rs_ControlProject');


function rs_ControlProject()
{

if (isset($_GET['projectid']))
{
    echo "aangekomen";
    echo "projectid: ".$_GET['projectid'];
    $projectObject = new Project();
    $projectId = $_GET['projectid'];
    $result = $projectObject->delete($projectId);
    if($result)
    {
         echo "aangekomen2";
         header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
    }
    else
    {
        $message = "No deletion possible.";
        $_SESSION['rs_message'] = $message;
        header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
    } 
}




//add project
//$_POST is always set, but its content might be empty.
if(isset($_POST['btnProjectSave']))
{
        $_POST = cleanInput($_POST);
        //1. registratie van project
        $projectObject = new Project();
        $projectTitle = $_POST['projecttitle'];
        $groupName = $_POST['groupname'];
        $objective = $_POST['objective'];
        $means = $_POST['means'];
        $location = $_POST['location'];
        $pplEstimated = $_POST['pplestimated'];
        $languageId = $_POST['languageid'];
        $countryId = $_POST['countryid'];
        $timeFrameId = $_POST['timeframeid'];
        

        //nederlandse instellingen voor de tijd
        setlocale(LC_TIME, ""); //onvermijdelijk nodig
        setlocale(LC_TIME, "nl_NL");
        $startDate = date('Y-m-d', time());
               
        $projectStatusId = 1;//waiting for approval
        $hoursSpent = NULL;
        $pplParticipated = NULL;
        $pplServed = NULL;
        $report = NULL;
        $endDate = NULL;
        $insertedBy = 'admin';//to be replaced by the name of the member

        $projectObject = new Project();
        $result = $projectObject->insert($projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $insertedBy );
        
        //get new id
        $newProjectId = $projectObject->getProjectId();
        
        //2. registratie van projecttypes; always at least 1 projecttype
        //bij meerdere checkboxen ok; bij 1 checkbox niet OK
        if($result)
        {
        $pptObject = new ProjectProjectType();
        for($i=1; $i <= 13; $i++)
        {
            $postVariable = "projecttype".$i;
            if(isset($_POST[$postVariable]))  //zonder isset is er de foutmelding undefined index       
            {
                $projectTypeId = $_POST[$postVariable];
                echo $projectTypeId."<br />";
                $result1 = $pptObject->insert($newProjectId, $projectTypeId, $insertedBy);
            }
        }//end for
        }//end if
        else
        {
            $message = $projectObject->getFeedback();
            $_SESSION['rs_message'] = $message;
            header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
        }

        //3. registratie van targetgroups; always at least 1 option
        if($result1)
        {
        $ptgObject = new ProjectTargetGroup();
        for($i=1; $i <= 5; $i++)
        {
            $postVariable1 = "targetgroup".$i;
            if(isset($_POST[$postVariable1]))  //zonder isset is er de foutmelding undefined index       
            {
                $targetGroupId = $_POST[$postVariable1];
                echo $targetGroupId."<br />";
                $result2 = $ptgObject->insert($newProjectId, $targetGroupId, $insertedBy);
            }
        }//end for
        }//end if
        else
        {
            $message = $ptgObject->getFeedback();
            $_SESSION['rs_message'] = $message;
            header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
        }


        if($result2)
        {
            header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
        }
        else
        {
            $message = $projectObject->getFeedback();
            $_SESSION['rs_message'] = $message;
            header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
        }
}


//update project
if(isset($_POST['btnProjectUpdate']))
{
        $_POST = cleanInput($_POST);

        //1. updating project
        $projectTitle = $_POST['projecttitle'];
        $groupName = $_POST['groupname'];
        $objective = $_POST['objective'];
        $means = $_POST['means'];
        $location = $_POST['location'];
        $pplEstimated = $_POST['pplestimated'];
        $languageId = $_POST['languageid'];
        $countryId = $_POST['countryid'];
        $timeFrameId = $_POST['timeframeid'];
        $projectId = $_POST['idHidden'];
        $startDate = $_POST['startDate'];
        $projectStatusId = $_POST['projectStatusId'];
        $hoursSpent = NULL;
        $pplParticipated = NULL;
        $pplServed = NULL;
        $report = NULL;
        $endDate = NULL;
        $insertedBy = 'admin';//to be replaced by the name of the member

        $projectObject = new Project();
        $result = $projectObject->update($projectId, $projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $modifiedBy );
        if($result)
        {
            //1. add projecttypes
            $pptObject = new ProjectProjectType();
            //1.1. vorige pptids wissen
            $previousProjectTypeIds = $pptObject->selectProjectTypesByProjectId($projectId);
            foreach($previousProjectTypeIds as $previousPTId)
            {
                $pptId = $previousPTId['ProjectProjectTypeId'];
                $pptObject->delete($pptId);
            }
            //1.2. nieuwe pptids toevoegen
            for($i=1; $i <= 13; $i++)
            {
                $postVariable = "projecttype".$i;
                if(isset($_POST[$postVariable]))  //checks if  checkbox is checked       
                {
                    $projectTypeId = $_POST[$postVariable];
                    $result1 = $pptObject->insert($projectId, $projectTypeId, $insertedBy);//only insertion for checked checkboxes
                }
            }//end for loop

           
            if($result1)
            {
                 //2. add targetgroups
                 $ptgObject = new ProjectTargetGroup();
                 //2.1. vorige ptgids wissen
                 $previousTargetGroupIds = $ptgObject->selectTargetGroupsByProjectId($projectId);
                 foreach($previousTargetGroupIds as $previousTGId)
                 {
                      $ptgId = $previousTGId['ProjectTargetGroupId'];
                      $ptgObject->delete($ptgId);
                 }
                 //2.2. nieuwe ptgids toevoegen
                 for($j=1; $j <= 4; $j++)
                 {
                 $postVariable = "targetgroup".$j;
                 if(isset($_POST[$postVariable]))  //zonder isset is er de foutmelding undefined index       
                 {
                    $targetGroupId = $_POST[$postVariable];
                    echo $targetGroupId."<br />";
                    $result2 = $ptgObject->insert($projectId, $targetGroupId, $insertedBy);
                 }
                 }//end for loop

                 if($result2)
                 {
                      header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
                 }
                 else
                 {
                    $message = $ptgObject->getFeedback();
                    $_SESSION['rs_message'] = $message;
                    header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
                 }
                
            }//end if($result1)
            else
            {
                $message = $pptObject->getFeedback();
                $_SESSION['rs_message'] = $message;
                header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');

            }

        }//end if($result)
        else
        {
            $message = $projectTypeObject->getFeedback();
            $_SESSION['rs_message'] = $message;
            header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
        }
}//end update

}//end fc rs_Control_Project


?>

