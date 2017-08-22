<?php
require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\member.class.php';

/*
if(isset($_GET['notes']))
{
	echo "ok";
	//0. vooraf
	$current_user = wp_get_current_user();
 	//echo "username: ".$current_user->user_login;
 	$wpUserId = $current_user->ID;
	$modifiedBy = $current_user->user_firstname." ".$current_user->user_lastname;
	
    $notes = $_GET['q'];
	$memberId = $_GET['memberid'];
    $memberObject = new Member();
	//1. alle waarden van member ophalen
	$selectedMember = $memberObject->selectMemberById($memberId);
	$firstName = $selectedMember[0]['FirstName']; 
	$lastName = $selectedMember[0]['LastName']; 
	$birthDate = $selectedMember[0]['BirthDate']; 
	$languageId = $selectedMember[0]['LanguageId']; 
	$countryId = $selectedMember[0]['CountryId']; 
	
	
	//2. update
	$memberObject->update($memberId, $firstName, $lastName, $birthDate, $notes, $languageId, $wpUserId, $countryId, $modifiedBy);
	
	
	//3. nieuwe notes waarde van member ophalen
	$memberObject1 = new Member();
	//1. alle waarden van member ophalen
	$memberId = $_GET['memberid'];
	$selectedMember1 = $memberObject1->selectMemberById($memberId);
	$notes = $selectedMember1[0]['Notes']; 
	echo $notes;
    
} 
*/


if(isset($_GET['verkoperid']))
{
    $verkoperId = $_GET['verkoperid'];
    $docObject = new Doc();
    $result = $docObject->selectKoopwaarVanVerkoper($verkoperId);//retourneert 2dim array
    $resultInJSON = json_encode($result);
    echo $resultInJSON;//retourneert igv 1dim array een resultaat zonder de omvattende rechte haken; aan AJAX
}

if(isset($_GET['verlenerid']))
{
    $verlenerId = $_GET['verlenerid'];
    $docObject = new Doc();
    $result = $docObject->selectLeenwaarVanVerlener($verlenerId);//retourneert 2dim array
    $resultInJSON = json_encode($result);
    echo $resultInJSON;//retourneert igv 1dim array een resultaat zonder de omvattende rechte haken; aan AJAX
}

if(isset($_GET['notes']))
{
	$result = "ok";
    $resultInJSON = json_encode($result);
    echo $resultInJSON;//retourneert igv 1dim array een resultaat zonder de omvattende rechte haken; aan AJAX
	
    
} 
?>


