<?php
//is needed because there is no reference to this page in the plugin's main file
session_start()  ;

//require_once RS_PLUGIN_PATH.'appcode/webapp/help/cleaninput.php';
//seems to be needed allthough already defined in rootsandshoots.php
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");
define('RS_WEBSITE_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\");
//define('RS_DIR_PATH', __DIR__."\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/member.class.php';
require_once RS_WEBSITE_PATH.'wp-load.php';
 



//add
//$_POST is always set, but its content might be empty.
if(isset($_POST['btnMemberSave']))
{
	   //1. save into wordpress
	   //$ingelogde_user = wp_get_current_user();
   	   //$userId = $ingelogde_user->ID;
	   $userdata = array(
	   'ID' => $_POST['wpuserid'],
       'first_name'  =>  $_POST['firstname'],
       'last_name'   =>  $_POST['lastname'],
       'user_email' =>  $_POST['email']
       );

		wp_update_user( $userdata );
		
		//2. save into table rs_members		
        //$_POST = cleanInput($_POST);
        $memberObject = new Member();
        $firstName = $_POST['firstname'];
        $lastName = $_POST['lastname'];
		$timestampBirthDate = strtotime($_POST['birthdate']);
        $birthDate = date('Y-m-d', $timestampBirthDate);//omzetting in het MySQL string formaat
		$email = $_POST['email'];
		$wpUserId = $_POST['wpuserid'];
		$countryId = $_POST['countryid'];
		$languageId = $_POST['languageid'];
		$insertedBy = $_POST['firstname']." ".$_POST['lastname'];
		
        $result = $memberObject->insert($firstName, $lastName, $birthDate, $email, $wpUserId, $countryId, $languageId, $insertedBy);
        if($result)
        {
            header('Location: http://localhost:8080/rootsandshootseurope/member-form/');
        }
        else
        {
            $message = $memberObject->getFeedback();
            $_SESSION['message'] = $message;
            echo $message;
            header('Location: http://localhost:8080/rootsandshootseurope/failure/');
        }
}

//update member profile
if(isset($_POST['btnMemberUpdate']))
{
	   //best unique key verwijderen; geeft blijkbaar niet ter zake doende foutmeldingen
			
        //$_POST = cleanInput($_POST);
        $memberObject = new Member();
		$memberId= $_POST['idHidden'];
        $firstName = $_POST['firstname'];
        $lastName = $_POST['lastname'];
		$timestampBirthDate = strtotime($_POST['birthdate']);
        $birthDate = date('Y-m-d', $timestampBirthDate);//omzetting in het MySQL string formaat
		$languageId = $_POST['languageid'];
		$wpUserId = $_POST['wpuserid'];
		echo "wpuserid: ".$wpUserId;
		$countryId = $_POST['countryid'];
	    echo "countryid: ".$countryId;
		$modifiedBy = $_POST['firstname']." ".$_POST['lastname'];
		
		//retrieve notes from the database
		/*
		$searchedMember = $memberObject->selectMemberById($memberId);
		$notes = $searchedMember[0]['Notes'];
		 * */
		 $notes = "geen";
		
		$memberObject1 = new Member();
        $result = $memberObject1->update($memberId, $firstName, $lastName, $birthDate, $notes, $languageId, $wpUserId, $countryId, $modifiedBy);
        if($result)
        {
            //header('Location: http://localhost:8080/rootsandshootseurope/member-form/');
        }
        else
        {
            $message = $memberObject1->getFeedback();
			$errorMessage = $memberObject1->getErrorMessage(); 
            $errorCode = $memberObject1->getErrorCode(); 
       
            $_SESSION['message'] = $message;
            echo $message."<br />";
            echo $errorMessage."<br />";
			echo $errorCode."<br />";
            //header('Location: http://localhost:8080/rootsandshootseurope/failure/');
        }
}


//update notes
if(isset($_POST['btnNotesUpdate']))
{
        //$_POST = cleanInput($_POST);
        //echo "arrived";
       
        $wpUserId = $_POST['memberId'];
		echo $wpUserId."<br />";
        $notes = $_POST['notes'];
		echo $notes."<br />";
		
		$memberObject = new Member();
		
		$searchedMember = $memberObject->selectMemberById($wpUserId);
		$firstName = $searchedMember[0]['FirstName'];
		echo $firstName."<br />";
		$lastName = $searchedMember[0]['LastName'];
		echo $lastName."<br />";
		$birthDate=$searchedMember[0]['BirthDate'];
		echo $birthDate."<br />";
		$languageId = $searchedMember[0]['LanguageId'];
		echo $languageId."<br />";
		
		$countryId = $searchedMember[0]['CountryId'];
		echo $countryId."<br />";
		$modifiedBy = $firstName." ".$lastName;
		echo $modifiedBy."<br />";
		
		/*
		$firstName = "Hans";
		$lastName = "Van Perlo";
		$birthDate= "2017-02-07";
		$languageId = 2;
		$wpUserId = 56;
		$countryId = 1;
		$modifiedBy = $firstName." ".$lastName;
		*/
      
        $result = $memberObject->update($wpUserId, $firstName, $lastName, $birthDate, $notes, $languageId, $countryId, $modifiedBy);
        if($result)
        {
            header('Location: http://localhost:8080/rootsandshootseurope/member-form/');
        }
        else
        {
            $message = $memberObject->getFeedback();
			$errorMessage = $memberObject->getErrorMessage(); 
            $errorCode = $memberObject->getErrorCode(); 
       
            $_SESSION['message'] = $message;
            echo $message."<br />";
            echo $errorMessage."<br />";
			echo $errorCode."<br />";
            header('Location: http://localhost:8080/rootsandshootseurope/failure/');
        }
		 
}


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

if (isset($_GET['action']))
{
    echo "arrived";
	$memberId = $_GET['memberid'];
	echo $memberId;
	$memberObject = new Member();
	$searchedMember = $memberObject->selectMemberById($memberId);
	$notes = $searchedMember[0]['Notes'];
	echo $notes;
}

?>

