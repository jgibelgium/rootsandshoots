<?php

//require_once RS_PLUGIN_PATH.'appcode/webapp/help/cleaninput.php';
//seems to be needed allthough already defined in rootsandshoots.php

define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");
define('RS_WEBSITE_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\member.class.php';
//require_once RS_WEBSITE_PATH.'wp-load.php'; gaat niet in ajax
 

if(isset($_GET['notes']))
{
	//echo "ok";
	//0. vooraf
	//$current_user = wp_get_current_user();
 	//echo "username: ".$current_user->user_login;
 	//$wpUserId = $current_user->ID;
	//$modifiedBy = $current_user->user_firstname." ".$current_user->user_lastname;
	//$wpUserId = 56;
	$modifiedBy = "re";
	
    $notes = $_GET['notes'];
	$wpUserId = $_GET['userid'];
    $memberObject = new Member();
	//1. alle waarden van member ophalen
	$selectedMember = $memberObject->selectMemberById($wpUserId);
	$firstName = $selectedMember[0]['FirstName']; 
	$lastName = $selectedMember[0]['LastName']; 
	$birthDate = $selectedMember[0]['BirthDate']; 
	$languageId = $selectedMember[0]['LanguageId']; 
	$countryId = $selectedMember[0]['CountryId']; 
	
	
	//2. update
	$success = $memberObject->update($wpUserId, $firstName, $lastName, $birthDate, $notes, $languageId, $countryId, $modifiedBy);
	
	if($success)
	{
	//3. nieuwe notes waarde van member ophalen
	$memberObject1 = new Member();
	//1. alle waarden van member ophalen
	$selectedMember1 = $memberObject1->selectMemberById($wpUserId);
	$result = $selectedMember1[0]['Notes'];  
	echo $result;
	}
	else
	{
		echo "niet gelukt";
	}
}




?>