<?php
define('RS_DIR_PATH', __DIR__."\\");
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_DIR_PATH.'project.class.php';


//insert testen
/*
$project = new Project();
$projectTitle = "plant trees";
$groupName = "RS Asse";
$pplEstimated = 100;
$location = "Leuven";
$objective = "2000 trees";
$means = "";
$startDate = "2018-01-15";
$timeFrameId = 1;
$languageId = 3;
$countryId = 1;
$projectStatusId = 1;
$hoursSpent = 8;
$pplParticipated = 200;
$pplServed= NULL;
$report = "blabla";
$endDate = "2018-01-15";
$insertedBy = "admin";
$project->insert($projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $insertedBy);
*/

//update testen

$project = new Project();
$projectId = 5;
$projectTitle = "plant trees";
$groupName = "RS Asse";
$pplEstimated = 100;
$location = "Leuven";
$objective = "2000 trees";
$means = "";
$startDate = "2018-01-15";
$timeFrameId = 1;
$languageId = 3;
$countryId = 1;
$projectStatusId = 1;
$hoursSpent = 8;
$pplParticipated = 200;
$pplServed= NULL;
$report = "bla";
$endDate = "2018-01-15";
$modifiedBy = "admin";
$project->update($projectId, $projectTitle, $groupName, $pplEstimated, $location, $objective, $means, $startDate, $timeFrameId, $languageId, $countryId, $projectStatusId, $hoursSpent, $pplParticipated, $pplServed, $report, $endDate, $modifiedBy);

/***
 * Opmerking: door de opname van het veld ModifiedOn (timestamp) is er steeds een veld dat wijzigt bij een update stored procedure. In PHP volstaat dan de methode rowCount() 
 * **/

//select all testen
/*
$project = new Project();
$projects = $project->selectAll();
*/

//selectProjectsById testen
/*
$objectS = new Project();
$result = $objectS->selectProjectById(4);
*/

//selectProjectsByMemberId testen
/*
$objectS = new Project();
$projects = $objectS->selectProjectsByMember(1);
print_r($projects);
*/

 //filterprojects1 testen
 /*
 $objectS = new Project();
 $languageId = 1;
 $countryId = 1;
 $projectTypeId = NULL;
 $key = NULL;
 
 $projects = $objectS->filterProjects1($languageId, $countryId, $projectTypeId, $key);
 print_r($projects);
  * */
 /*stored procedure is niet OK*/
 /*
 $objectS = new Project();
 $languageId = 1;
 $countryId = 1;
 $targetGroupId = NULL;
 $key = NULL;
 
  $projects = $objectS->filterProjects2($languageId, $countryId, $targetGroupId, $key);
  print_r($projects);
 /*stored procedure is niet OK*/
 
 ?>
 
 
<p>Test update project</p>
    <ul>
            <li>Message: <?php echo $project->getFeedback(); ?></li>
            <li>Error message: <?php echo $project->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $project->getErrorCode(); ?></li>
    </ul>
 
 
 
 <!--
  <table>
    <thead>
    <tr><th>ProjectId</th><th>ProjectTitle</th><th>GroupName</th><th>PplEstimated</th><th>Location</th><th>Objective</th><th>Means</th><th>StartDate</th><th>TFId</th><th>LId</th><th>CountryId</th><th>TargetGroup</th></tr>
    </thead>
    <tbody>
    <?php
    foreach($projects as $result)        
    {
    ?>
    <tr><td><?php  echo $result['ProjectId']; ?></td><td><?php  echo $result['ProjectTitle']; ?></td><td><?php  echo $result['GroupName']; ?></td><td><?php  echo $result['PplEstimated']; ?></td><td><?php  echo $result['Location']; ?></td><td><?php  echo $result['Objective']; ?></td><td><?php  echo $result['Means']; ?></td><td><?php  echo $result['StartDate']; ?></td><td><?php  echo $result['TimeFrameId']; ?></td><td><?php  echo $result['LanguageId']; ?></td><td><?php  echo $result['CountryId']; ?></td><td><?php  echo $result['TargetGroup']; ?></td></tr>
    <?php
    }//end foreach
    ?>
    </tbody>
  </table>
  
  <p>Test filter projects 2</p>
    <ul>
            <li>Message: <?php echo $objectS->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectS->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectS->getErrorCode(); ?></li>
    </ul>
   -->
 
<!--
 <table>
    <thead>
    <tr><th>ProjectId</th><th>ProjectTitle</th><th>GroupName</th><th>PplEstimated</th><th>Location</th><th>Objective</th><th>Means</th><th>StartDate</th><th>TFId</th><th>LId</th><th>CountryId</th></tr>
    </thead>
    <tbody>
    <?php
    foreach($projects as $result)        
    {
    ?>
    <tr><td><?php  echo $result['ProjectId']; ?></td><td><?php  echo $result['ProjectTitle']; ?></td><td><?php  echo $result['GroupName']; ?></td><td><?php  echo $result['PplEstimated']; ?></td><td><?php  echo $result['Location']; ?></td><td><?php  echo $result['Objective']; ?></td><td><?php  echo $result['Means']; ?></td><td><?php  echo $result['StartDate']; ?></td><td><?php  echo $result['TimeFrameId']; ?></td><td><?php  echo $result['LanguageId']; ?></td><td><?php  echo $result['CountryId']; ?></td></tr>
    <?php
    }//end foreach
    ?>
    </tbody>
    </table>
    <br />
    <p>Test filter projects 1</p>
    <ul>
            <li>Message: <?php echo $objectS->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectS->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectS->getErrorCode(); ?></li>
    </ul>
-->
    
<!--
<p>Test select projects by member</p>
    <ul>
            <li>Message: <?php echo $objectS->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectS->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectS->getErrorCode(); ?></li>
    </ul>
    
    <table>
    <thead>
    <tr><th>ProjectId</th><th>ProjectTitle</th><th>GroupName</th><th>PplEstimated</th><th>Location</th><th>Objective</th><th>Means</th><th>StartDate</th><th>TFId</th><th>LId</th><th>CountryId</th></tr>
    </thead>
    <tbody>
    <?php
    foreach($projects as $result)        
    {
    ?>
    <tr><td><?php  echo $result['ProjectId']; ?></td><td><?php  echo $result['ProjectTitle']; ?></td><td><?php  echo $result['GroupName']; ?></td><td><?php  echo $result['PplEstimated']; ?></td><td><?php  echo $result['Location']; ?></td><td><?php  echo $result['Objective']; ?></td><td><?php  echo $result['Means']; ?></td><td><?php  echo $result['StartDate']; ?></td><td><?php  echo $result['TimeFrameId']; ?></td><td><?php  echo $result['LanguageId']; ?></td><td><?php  echo $result['CountryId']; ?></td></tr>
    <?php
    }//end foreach
    ?>
    </tbody>
    </table>
    <br />
 -->
    

<!--
<p>Test select projectsbyid</p>
<table>
    <thead>
    <tr><th>ProjectId</th><th>ProjectTitle</th><th>GroupName</th><th>PplEstimated</th><th>Location</th><th>Objective</th><th>Means</th><th>StartDate</th><th>TFId</th><th>LId</th><th>CountryId</th></tr>
    </thead>
    <tbody>
    <tr><td><?php  echo $result[0]['ProjectId']; ?></td><td><?php  echo $result[0]['ProjectTitle']; ?></td><td><?php  echo $result[0]['GroupName']; ?></td><td><?php  echo $result[0]['PplEstimated']; ?></td><td><?php  echo $result[0]['Location']; ?></td><td><?php  echo $result[0]['Objective']; ?></td><td><?php  echo $result[0]['Means']; ?></td><td><?php  echo $result[0]['StartDate']; ?></td><td><?php  echo $result[0]['TimeFrameId']; ?></td><td><?php  echo $result[0]['LanguageId']; ?></td><td><?php  echo $result[0]['CountryId']; ?></td></tr>
    </tbody>
    </table>
    <br />
 -->
 
    
<!--
<p>Test select projects</p>
<table>
    <thead>
    <tr><th>ProjectId</th><th>Title</th><th>GroupName</th><th>Location</th><th>Objective</th><th>Means</th><th>StartDate</th><th>TFId</th><th>LId</th><th>CountryId</th><th>PSId</th><th>HoursSpent</th><th>PplP</th></tr>
    </thead>
    <tbody>
    <?php
    foreach($projects as $project)
    {
    ?>
    <tr><td><?php  echo $project['ProjectId']; ?></td><td><?php  echo $project['ProjectTitle']; ?></td><td><?php  echo $project['GroupName']; ?></td><td><?php  echo $project['Location']; ?></td><td><?php  echo $project['Objective']; ?></td><td><?php  echo $project['Means']; ?></td><td><?php  echo $project['StartDate']; ?></td><td><?php  echo $project['TimeFrameId']; ?></td><td><?php  echo $project['LanguageId']; ?></td><td><?php  echo $project['CountryId']; ?></td><td><?php  echo $project['ProjectStatusId']; ?></td><td><?php  echo $project['HoursSpent']; ?></td><td><?php  echo $project['PplParticipated']; ?></td></tr>
    <?php
        }//end foreach
    ?>
    </tbody>
</table>
-->


 
    
<!--
    <p>Test insert project</p>
    <ul>
            <li>Message: <?php echo $project->getFeedback(); ?></li>
            <li>Error message: <?php echo $project->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $project->getErrorCode(); ?></li>
            <li>ID: <?php echo $project->getprojectId(); ?></li>
    </ul>
    
-->
    
    
    
    
    
    

   