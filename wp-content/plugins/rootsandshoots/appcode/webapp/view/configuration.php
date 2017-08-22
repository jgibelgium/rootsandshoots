<?php
require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/targetgroup.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/timeframe.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/role.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/stufftype.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projectstatus.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/country.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/language.class.php';

function rs_Style_Configuration()
{
    if(is_page('configuration')) //slug als argument
    {
        wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());
        wp_enqueue_style('files_style'); 
        wp_register_style('configuration_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/configuration.css','_FILE_'), array());
        wp_enqueue_style('configuration_style');
    }
}
add_action('wp_enqueue_scripts', 'rs_Style_Configuration');

function rs_Script_Configuration()
{
    if(is_page('configuration')) //slug als argument
    {
        wp_register_script('configuration_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/configuration.js','_FILE_'), array('jquery'));
        wp_enqueue_script('configuration_script');
    }
}
add_action('wp_enqueue_scripts', 'rs_Script_Configuration');
add_action('admin_enqueue_scripts', 'rs_Script_Configuration');


function rs_ShowCountries()
{
   $countryObject = new Country();
   $countries = $countryObject->selectAll();
?>

<div class="redbar alert-info">
                <strong>&nbsp;Countries: <?php echo count($countries)?> rows</strong>
                <button type="button" class="close closeinfo">&times;</button>    
</div>
<table class="configTable">
<thead>
<tr>
<th class="rs_configid">Number</th>
<th class="rs_config">Country</th>
</tr>
</thead>
<tbody>
<?php
foreach($countries as $country)
{
?>
<tr>
<td><?php echo $country['CountryId']; ?></td>
<td><?php echo $country['Country']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<?php
}//end function


function rs_ShowLanguages()
{
   $languageObject = new Language();
   $languages = $languageObject->selectAll();
?>

<div class="redbar alert-info">
                <strong>&nbsp;Languages: <?php echo count($languages)?> rows</strong>
                <button type="button" class="close closeinfo">&times;</button>    
</div>
<table class="configTable">
<thead>
<tr>
<th class="rs_configid">Number</th>
<th>Language</th>
</tr>
</thead>
<tbody>
<?php
foreach($languages as $language)
{
?>
<tr>
<td><?php echo $language['LanguageId']; ?></td>
<td><?php echo $language['Language']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<?php
}//end function


function rs_ShowProjectStatuses()
{
   $psObject = new ProjectStatus();
   $pstati = $psObject->selectAll();
?>

<div class="redbar alert-info">
                <strong>&nbsp;ProjectStatuses: <?php echo count($pstati)?> rows</strong>
                <button type="button" class="close closeinfo">&times;</button>    
</div>
<table  class="configTable">
<thead>
<tr>
<th class="rs_configid">Number</th>
<th>Project Status</th>
</tr>
</thead>
<tbody>
<?php
foreach($pstati as $pstatus)
{
?>
<tr>
<td><?php echo $pstatus['ProjectStatusId']; ?></td>
<td><?php echo $pstatus['ProjectStatus']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<?php
}//end function

function rs_ShowRoles()
{
   $roleObject = new Role();
   $roles = $roleObject->selectAll();
?>

<div class="redbar alert-info">
                <strong>&nbsp;Roles: <?php echo count($roles)?> rows</strong>
                <button type="button" class="close closeinfo">&times;</button>    
</div>
<table  class="configTable">
<thead>
<tr>
<th class="rs_configid">Number</th>
<th>Role</th>
</tr>
</thead>
<tbody>
<?php
foreach($roles as $role)
{
?>
<tr>
<td><?php echo $role['RoleId']; ?></td>
<td><?php echo $role['Role']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<?php
}//end function

function rs_ShowStuffTypes()
{
   $stuffTypeObject = new StuffType();
   $stuffTypes = $stuffTypeObject->selectAll();
?>

<div class="redbar alert-info">
                <strong>&nbsp;Stuff types: <?php echo count($stuffTypes)?> rows</strong>
                <button type="button" class="close closeinfo">&times;</button>    
</div>
<table  class="configTable">
<thead>
<tr>
<th class="rs_configid">Number</th>
<th>Stuff type</th>
</tr>
</thead>
<tbody>
<?php
foreach($stuffTypes as $stuffType)
{
?>
<tr>
<td><?php echo $stuffType['StuffTypeId']; ?></td>
<td><?php echo $stuffType['StuffType']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<?php
}//end function


function rs_ShowTargetGroups()
{
   $targetGroupObject = new TargetGroup();
   $targetGroups = $targetGroupObject->selectAll();
?>

<div class="redbar alert-info">
                <strong>&nbsp;Targetgroups: <?php echo count($targetGroups)?> rows</strong>
                <button type="button" class="close closeinfo">&times;</button>    
</div>
<table  class="configTable">
<thead>
<tr>
<th class="rs_configid">Number</th>
<th>Target group</th>
</tr>
</thead>
<tbody>
<?php
foreach($targetGroups as $targetGroup)
{
?>
<tr>
<td><?php echo $targetGroup['TargetGroupId']; ?></td>
<td><?php echo $targetGroup['TargetGroup']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<?php
}//end function

function rs_ShowTimeFrames()
{
   $timeFrameObject = new TimeFrame();
   $timeFrames = $timeFrameObject->selectAll();
?>

<div class="redbar alert-info">
                <strong>&nbsp;Timeframes: <?php echo count($timeFrames)?> rows</strong>
                <button type="button" class="close closeinfo">&times;</button>    
</div>
<table class="configTable">
<thead>
<tr>
<th class="rs_configid">Number</th>
<th>Timeframe</th>
</tr>
</thead>
<tbody>
<?php
foreach($timeFrames as $timeFrame)
{
?>
<tr>
<td><?php echo $timeFrame['TimeFrameId']; ?></td>
<td><?php echo $timeFrame['TimeFrame']; ?></td>
</tr>
<?php
}//end foreach
?>
</tbody>
</table>
<?php
}//end function

add_action( 'rs_configuration_hook' , 'rs_ShowCountries', 5 );
add_action( 'rs_configuration_hook' , 'rs_ShowLanguages', 6 );
add_action( 'rs_configuration_hook' , 'rs_ShowProjectStatuses', 7 );
add_action( 'rs_configuration_hook' , 'rs_ShowRoles', 8 );
add_action( 'rs_configuration_hook' , 'rs_ShowStuffTypes', 9 );
add_action( 'rs_configuration_hook' , 'rs_ShowTargetGroups', 10 );
add_action( 'rs_configuration_hook' , 'rs_ShowTimeFrames', 11 );

 
?>