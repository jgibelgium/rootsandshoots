 <?php
define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'member.class.php';

//insert testen
/*
$member = new Member();
$firstName = "Hanske";
$lastName = "Hanssens";
$birthDate = "1970-10-15";
$notes = "lorem ipsum";
$countryId = 2;
$languageId = 2;
$insertedBy = "admin";

$member->insert($firstName, $lastName, $birthDate, $notes, $countryId, $languageId, $insertedBy);
*/

//update testen
 /*
$memberObject = new Member();
$wpUserId = 103;
$firstName = "Hans";
$lastName = "Vam Perlo";
$birthDate = "2017-02-07";
$notes = "noot";
$languageId = 2;
$countryId = 1;
$modifiedBy = $firstName." ".$lastName;
 
$memberObject->update($wpUserId, $firstName, $lastName, $birthDate, $notes, $countryId, $languageId, $modifiedBy);
*/

//selectAll testen
/*
$object = new Member();
$ledenLijst=$object->selectAll();
print_r($ledenLijst);
*/

 //testen van selectMemberById()
 
 $objectS = new Member();
 $result = $objectS->selectMemberById(102);


 //testen van selectMemberByUserId()
 /*
 $objectS = new Member();
 $resultM = $objectS->selectMemberByUserId(110);
 */
  
 //delete testen
 /*
 $objectD= new Member();
 $objectD->delete(4);
  */  
?>

<p>Test selectMemberById</p>
<ul>
            <li>Feedback: <?php echo $objectS->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectS->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectS->getErrorCode(); ?></li>
</ul>
<table>
    <thead>
    <tr><th>MemberId</th><th>Firstname</th><th>Lastname</th><th>BirthDate</th><th>Email</th><th>WPUserId</th><th>CountryId</th><th>LanguageId</th></tr>
    </thead>
    <tbody>
    <tr><td><?php  echo $result[0]['MemberId']; ?></td><td><?php  echo $result[0]['FirstName']; ?></td><td><?php  echo $result[0]['LastName']; ?></td><td><?php  echo $result[0]['BirthDate']; ?></td><td><?php  echo $result[0]['Email']; ?></td><td><?php  echo $result[0]['WPUserId']; ?></td><td><?php  echo $result[0]['CountryId']; ?></td><td><?php  echo $result[0]['LanguageId']; ?></td></tr>
    </tbody>
</table>
    

<!--
<p>Test update member</p>
        <ul>
            <li>Feedback: <?php echo $memberObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $memberObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $memberObject->getErrorCode(); ?></li>
        </ul>
-->

<!--
<p>Test insert member</p>
        <ul>
            <li>Feedback: <?php echo $member->getFeedback(); ?></li>
            <li>Error message: <?php echo $member->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $member->getErrorCode(); ?></li>
            <li>ID: <?php echo $member->getMemberId(); ?></li>
        </ul>
-->






<!--
<p>Test selectMemberByUserId</p>
<ul>
            <li>Feedback: <?php echo $objectS->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectS->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectS->getErrorCode(); ?></li>
</ul>
<table>
    <thead>
    <tr><th>MemberId</th><th>Firstname</th><th>Lastname</th><th>BirthDate</th><th>Email</th><th>WPUserId</th><th>CountryId</th><th>LanguageId</th></tr>
    </thead>
    <tbody>
    <tr><td><?php  echo $resultM[0]['MemberId']; ?></td><td><?php  echo $resultM[0]['FirstName']; ?></td><td><?php  echo $resultM[0]['LastName']; ?></td><td><?php  echo $resultM[0]['BirthDate']; ?></td><td><?php  echo $resultM[0]['Email']; ?></td><td><?php  echo $resultM[0]['WPUserId']; ?></td><td><?php  echo $resultM[0]['CountryId']; ?></td><td><?php  echo $resultM[0]['LanguageId']; ?></td></tr>
    </tbody>
</table>
 -->
 
 
    





<!--
<p>Test deleting member</p>
        <ul>
            <li>Message: <?php echo $objectD->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectD->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectD->getErrorCode(); ?></li>
        </ul>
</p>
-->
    




<!--
<p>Test selectall</p>
<ul>
            <li>Feedback: <?php echo $object->getFeedback(); ?></li>
            <li>Error message: <?php echo $object->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $object->getErrorCode(); ?></li>
</ul>
 
<table>
<thead>
<tr><th>MemberId</th><th>Username</th><th>Password</th><th>Firstname</th><th>Lastname</th><th>BirthDate</th><th>Email</th><th>LanguageId</th><th>RoleId</th><th>CountryId</th></tr>
</thead>
<tbody>
    <?php
        foreach($ledenLijst as $result)
        {
    ?>
    <tr><td><?php  echo $result['MemberId']; ?></td><td><?php  echo $result['UserName']; ?></td><td><?php  echo $result['Password']; ?></td><td><?php  echo $result['FirstName']; ?></td><td><?php  echo $result['LastName']; ?></td><td><?php  echo $result['BirthDate']; ?></td><td><?php  echo $result['Email']; ?></td><td><?php  echo $result['LanguageId']; ?></td><td><?php  echo $result['RoleId']; ?></td><td><?php  echo $result['CountryId']; ?></td></tr>
    <?php
        }//end foreach
    ?>
</tbody>
</table>
<br />
-->
 

 
