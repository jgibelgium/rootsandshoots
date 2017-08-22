<?php
//is needed because there is no reference to this page in the plugin's main file
session_start()  ;

//require_once RS_PLUGIN_PATH.'appcode/webapp/help/cleaninput.php';
//seems to be needed allthough already defined in rootsandshoots.php
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\project.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\projectprojecttype.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\projecttargetgroup.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\help\cleaninput.php';




//add
//$_POST is always set, but its content might be empty.
if(isset($_POST['btnProjectSave']))
{
        $_POST = cleanInput($_POST);
        $projectObject = new Project();
        $projectTitle = $_POST['projecttitle'];
        if(isset($_POST['groupname'])){ $groupName = $_POST['groupname']; } else { $groupName = NULL; };
        if(is_numeric($_POST['pplestimated'])){ $pplEstimated = $_POST['pplestimated']; } else { $pplEstimated = NULL; };
        if(isset($_POST['location'])){ $location = $_POST['location']; } else { $location = NULL; };
        $objective = $_POST['objective'];
        if(isset($_POST['means'])){ $means = $_POST['means']; } else { $means = NULL; };  
        
        //dutch settings for time
        setlocale(LC_TIME, "");  
        setlocale(LC_TIME, "nl_NL");
        $startDate = date('Y-m-d', time()); 
        $timeFrameId = $_POST['timeframeid'];
        $languageId = $_POST['languageid']; 
        $countryId = $_POST['countryid']; 
        $projectStatusId = 1;
        $hoursSpent = NULL;
        $pplParticipated = NULL;
        $pplServed = NULL;
        $report = NULL;
        $endDate = NULL;
        $insertedBy = NULL;
                
        $result = $projectObject->insert($projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $insertedBy );
   
        if($result)
        {
            //save projecttypes
            //1. retrieve last projectId
            $lastId = $projectObject->getProjectId();
        
            //2. save into table projectprojecttypes
            $pptObject = new ProjectProjectType();
            
            //iterate the checked checkboxes: $_POST['projecttype'] is a numeric, onedim array of the value of the checkboxes, here projectTypeId
            $aantalProjectTypes = count($_POST['projecttype']);
            echo "aantalProjecttypes: ".$aantalProjectTypes;
            $result1 = FALSE;
            for($i = 0; $i < $aantalProjectTypes; $i++){
                $projectTypeId = $_POST['projecttype'][$i];
                $insertedBy = "admin";
                $result1 = $pptObject->insert($lastId, $projectTypeId, $insertedBy);
                
            }
            if($result1)
                {
                    //save targetgroups into table projecttargetgroups
                    $ptgObject = new ProjectTargetGroup();
                    //iterate the checked checkboxes: $_POST['targetgroup'] is a numeric, onedim array of the value of the checkboxes, here targetGroupId
                    $aantalTargetGroups = count($_POST['targetgroup']);
                     echo "aantalTargetgroups: ".$aantalTargetGroups;
                    $result2 = FALSE;
                    for($i = 0; $i < $aantalTargetGroups; $i++){
                       $targetGroupId = $_POST['targetgroup'][$i];
                       $insertedBy = "admin";
                       $result2 = $ptgObject->insert($lastId, $targetGroupId, $insertedBy);
                      
                     }
                     if($result2){
                          header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
                          $_SESSION['projectId'] = $lastId;
                     }
                     else 
                     {
                             $message = $ptgObject->getFeedback();
                             $_SESSION['message'] = $message;
                             header('Location: http://localhost:8080/rootsandshootseurope/failure/');
                     }//end if result 2
                     
                }
                else 
                {
                    $message = $pptObject->getFeedback();
                    $_SESSION['message'] = $message;
                    header('Location: http://localhost:8080/rootsandshootseurope/failure/');
                }//end if result1
            
           
        }//end if result
        else
        {
            $message = $projectObject->getFeedback();
            $_SESSION['message'] = $message;
            header('Location: http://localhost:8080/rootsandshootseurope/failure/');
        }
}//end adding


//update
if(isset($_POST['btnProjectUpdate']))
{
        $_POST = cleanInput($_POST);
        $projectObject = new Project();
        $projectId = $_POST['idHidden'];
        $projectTitle = $_POST['projecttitle'];
        if(isset($_POST['groupname'])){ $groupName = $_POST['groupname']; } else { $groupName = NULL; };
        if(is_numeric($_POST['pplestimated'])){ $pplEstimated = $_POST['pplestimated']; } else { $pplEstimated = NULL; };
        if(isset($_POST['location'])){ $location = $_POST['location']; } else { $location = NULL; };
        $objective = $_POST['objective'];
        if(isset($_POST['means'])){ $means = $_POST['means']; } else { $means = NULL; };  
        
        //dutch settings for time
        setlocale(LC_TIME, "");  
        setlocale(LC_TIME, "nl_NL");
        $startDate = date('Y-m-d', time()); 
        $timeFrameId = $_POST['timeframeid'];
        $languageId = $_POST['languageid']; 
        $countryId = $_POST['countryid']; 
        $projectStatusId = 1;
        $hoursSpent = NULL;
        $pplParticipated = NULL;
        $pplServed = NULL;
        $report = NULL;
        $endDate = NULL;
        $modifiedBy = NULL;
                
        $result = $projectObject->update($projectId, $projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $modifiedBy );
   
        if($result == FALSE)
        {
            $message = $projectObject->getFeedback();
            $_SESSION['message'] = $message;
            header('Location: http://localhost:8080/rootsandshootseurope/failure/');
            
        }
        
        //1. delete old projectprojecttypes
        //1.1. get projectprojecttypeids from particular project
        $pptObject = new ProjectProjectType();
        $projectTypesOfProject = $pptObject->selectProjectTypesByProjectId($projectId);
        $projectTypeIds = array();
        foreach($projectTypesOfProject as $pt)
        {
                array_push($projectTypeIds, $pt['ProjectProjectTypeId']);
        }
            
        //1.2. delete the corresponding records in table projectprojecttype
        foreach($projectTypeIds as $value)
        {
                $result1 = $pptObject->delete($value);
                if($result1 == FALSE) {
                    $message = $pptObject->getFeedback();
                    $_SESSION['message'] = $message;
                    header('Location: http://localhost:8080/rootsandshootseurope/failure/');
                }
        }
        echo "end foreach";
            
        //2. save new projectprojecttypes
        $pptObject1 = new ProjectProjectType();
            
        //2.1.iterate the checked checkboxes: $_POST['projecttype'] is a numeric, onedim array of the value of the checkboxes, here projectTypeId
        $aantalProjectTypes = count($_POST['projecttype']);
        for($i = 0; $i < $aantalProjectTypes; $i++){
                $projectTypeId = $_POST['projecttype'][$i];
                $insertedBy = "admin";
                $result2 = $pptObject1->insert($projectId, $projectTypeId, $insertedBy);
                if($result2 == FALSE) {
                    $message = $pptObject1->getFeedback();
                    $_SESSION['message'] = $message;
                    header('Location: http://localhost:8080/rootsandshootseurope/failure/');
                }
        }
            
        //3. delete old projecttargetgroups
        //3.1. get projecttargetgroupids from particular project
        $ptgObject = new ProjectTargetGroup();
        $targetGroupsOfProject = $ptgObject->selectTargetGroupsByProjectId($projectId);
        $targetGroupIds = array();
        foreach($targetGroupsOfProject as $tg)
        {
                array_push($targetGroupIds, $tg['ProjectTargetGroupId']);
        }
            
        //3.2. delete the corresponding records in table projecttargetgroup
        foreach($targetGroupIds as $value)
        {
                $result3 = $ptgObject->delete($value);
                if($result3 == FALSE) {
                    $message = $ptgObject->getFeedback();
                    $_SESSION['message'] = $message;
                    header('Location: http://localhost:8080/rootsandshootseurope/failure/');
                } 
        }
           
        //4. save new projecttargetgroups
        $ptgObject1 = new ProjectTargetGroup();
            
        //4.1.iterate the checked checkboxes: $_POST['targetgroup'] is a numeric, onedim array of the value of the checkboxes, here $targetGroupId
        $aantalTargetGroups = count($_POST['targetgroup']);
        for($i = 0; $i < $aantalTargetGroups; $i++){
                $targetGroupId = $_POST['targetgroup'][$i];
                $insertedBy = "admin";
                $result4 = $ptgObject1->insert($projectId, $targetGroupId, $insertedBy);
                if($result4 == FALSE) {
                    $message = $ptgObject1->getFeedback();
                    $_SESSION['message'] = $message;
                    header('Location: http://localhost:8080/rootsandshootseurope/failure/');
                }
        }
          
        header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');  
 }

//delete
if (isset($_GET['projectid']))
{
    echo "projectid: ".$_GET['projectid'];
    $projectObject = new Project();
    $projectId = $_GET['projectid'];
    $result = $projectObject->delete($projectId);
    if($result)
    {
        header('Location: http://localhost:8080/rootsandshootseurope/all-projects/');
    }
    else
    {
        $message = "The project could not be deleted. Try later again or contact the administrator.";
        $_SESSION['message'] = $message;
        header('Location: http://localhost:8080/rootsandshootseurope/failure/');
    }
}



?>

