<?php
require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/project.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/country.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/language.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projecttype.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/targetgroup.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/timeframe.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projectprojecttype.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projecttargetgroup.class.php';

function rs_StyleAndScript_ProjectDetails()
{
    
    if(is_page('project-details')) //slug als argument
    {
    wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());
    wp_enqueue_style('files_style'); 
    wp_register_style('projectform_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/projectdetails.css','_FILE_'), array());
    wp_enqueue_style('projectform_style'); 
    wp_register_script('projectform_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/projectdetails.js','_FILE_'), array('jquery'));
    wp_enqueue_script('projectform_script');
    }
}
add_action('wp_enqueue_scripts', 'rs_StyleAndScript_ProjectDetails');


function rs_CheckProjectType($projectTypeIds, $projectTypeId)
{
    foreach($projectTypeIds as $pti)
    {
        if($pti == $projectTypeId) {echo "checked";}
    }
}

function rs_CheckTargetGroup($targetGroupIds, $targetGroupId)
{
    foreach($targetGroupIds as $tgi)
    {
        if($tgi == $targetGroupId) {echo "checked";}
    }
}


function rs_ProjectDetails(){

//get countries
$countryObject = new Country(); 
$countries = $countryObject->selectAll(); 

//get languages
$languageObject = new Language(); 
$languages = $languageObject->selectAll(); 

//get projecttypes
$projectTypeObject = new ProjectType(); 
$projectTypes = $projectTypeObject->selectAll(); 

//get targetgroups
$targetGroupObject = new TargetGroup(); 
$targetGroups = $targetGroupObject->selectAll(); 

//get timeframes
$timeFrameObject = new TimeFrame(); 
$timeFrames = $timeFrameObject->selectAll(); 
 
if(isset($_POST['projectid']))
{
    $projectObject = new Project();
    $projectId = $_POST['projectid'];
    $projectObject->setProjectId($projectId);//nodig voor hidden field
    $searchedProject = $projectObject->selectProjectById($projectId);

    //get projecttypes from particular project
    $pptObject = new ProjectProjectType();
    $projectTypesOfProject = $pptObject->selectProjectTypesByProjectId($projectId);
    $projectTypeIds = array();
    foreach($projectTypesOfProject as $pt)
    {
        array_push($projectTypeIds, $pt['ProjectTypeId']);
    }

    //get targetgroups from particular project
    $ptgObject = new ProjectTargetGroup();
    $targetGroupsOfProject = $ptgObject->selectTargetGroupsByProjectId($projectId);
    $targetGroupIds = array();
    foreach($targetGroupsOfProject as $tg)
    {
        array_push($targetGroupIds, $tg['TargetGroupId']);

    }
}
else
{
    $projectObject = new Project();
    $projectObject->setProjectId("");
}
?>
<div id="redbar" class="alert-info">
        <strong>&nbsp;<?php echo "Edit project details"; ?></strong>
        <button id="closeinfo" type="button" class="close">&times;</button>    
</div>
<p>
        <a href="http://localhost:8080/rootsandshootseurope/all-projects/" class="buttonback">&nbsp;Back</a>
</p>
<form id="frmProject" method="POST" action="" class="form-horizontal" enctype="multipart/form-data">
           <div class="control-group">
                 <label for="projectid" class="control-label">PROJECT ID:</label>
                 <div class="controls"><input id="projectid" name="projectid" type="text" value="<?php echo $projectObject->getProjectId(); ?>"></div>
           </div>   

           <div class="control-group">
                 <label for="projecttitle" class="control-label">PROJECT TITLE:</label><div class="controls"><input id="projecttitle" name="projecttitle" type="text" autofocus="true" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['ProjectTitle'];} ?>" placeholder="max 255 characters" required><span class="asterisk_input"></span></div>
            </div>
            
            <div class="control-group">
                 <label for="groupname" class="control-label">GROUP NAME:</label><div class="controls"><input id="groupname" name="groupname" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['GroupName'];} ?>" placeholder="max 255 characters"></div>
            </div>

           <div class="control-group">
                 <label for="objective" class="control-label">OBJECTIVE:</label><div class="controls"><textarea id="objective" name="objective" placeholder="max 65000 characters" required><?php if (isset($searchedProject)) {echo $searchedProject[0]['Objective'];} ?></textarea><span class="asterisk_input"></span></div>
            </div>

           <div class="control-group">
                 <label for="means" class="control-label">MEANS:</label><div class="controls"><textarea id="means" name="means" placeholder="max 65000 characters" ><?php if (isset($searchedProject)) {echo $searchedProject[0]['Means'];} ?></textarea></div>
            </div>

    
           <div class="control-group">
                 <label for="location" class="control-label">LOCATION:</label><div class="controls"><input id="location" name="location" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['Location'];} ?>" ></div>
            </div>

            <div class="control-group">
                 <label for="pplestimated" class="control-label">PEOPLE ESTIMATED:</label><div class="controls"><input id="pplestimated" name="pplestimated" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['PplEstimated'];} ?>" pattern="\d*" title="a number please"></div>
            </div>

            <div class="control-group">
            <label for="language" class="control-label">LANGUAGE:</label>
            <div class="controls">
            <select id="language" name="languageid" required>
                            <option></option> 
                            <?php
                            foreach($languages as $language)
                            {
                            ?>
                            <option value="<?php echo $language['LanguageId'];?>"<?php if(isset($searchedProject)) { if ($searchedProject[0]['LanguageId'] == $language['LanguageId']) echo " selected";}?>><?php echo $language['Language'];?></option> 
                            <?php
                            }
                            ?>
            </select>
                <span class="asterisk_input"></span>
            </div>
            </div> 

            <div class="control-group">
            <label for="country" class="control-label">COUNTRY:</label>
            <div class="controls">
            <select id="country" name="countryid" required>
                            <option></option> 
                            <?php
                            foreach($countries as $country)
                            {
                            ?>
                            <option value="<?php echo $country['CountryId'];?>"<?php if(isset($searchedProject)) { if ($searchedProject[0]['CountryId'] == $country['CountryId']) echo " selected";}?>><?php echo $country['Country'];?></option> 
                            <?php
                            }
                            ?>
            </select>
                 <span class="asterisk_input"></span>
            </div>
            </div> 

            <div class="control-group">
            <label for="timeframe" class="control-label">TIMEFRAME:</label>
            <div class="controls">
            <select id="timeframe" name="timeframeid" required>
                            <option></option> 
                            <?php
                            foreach($timeFrames as $timeFrame)
                            {
                            ?>
                            <option value="<?php echo $timeFrame['TimeFrameId'];?>"<?php if(isset($searchedProject)) { if ($searchedProject[0]['TimeFrameId'] == $timeFrame['TimeFrameId']) {echo " selected";}} ?>><?php echo $timeFrame['TimeFrame'];?></option> 
                            <?php
                            }
                            ?>
            </select>
                 <span class="asterisk_input"></span>
            </div>
            </div> 

            <div class="control-group">
                 <label for="projecttypes" class="control-label">PROJECT TYPES:</label>
                <div class="controls">
                    <div id="projecttypesfieldset">
                    <?php foreach($projectTypes as $projectType)  
                    {
                        $i = $projectType['ProjectTypeId'];
                    ?>
                        <input class="uniform_pt" type="checkbox" name="<?php echo "projecttype".$i; ?>" value="<?php echo $projectType['ProjectTypeId']; ?>" <?php if(isset($projectTypeIds)){ rs_CheckProjectType($projectTypeIds, $i);} ?> > <?php echo $projectType['ProjectType']; ?><br />
                    <?php
                    }
                    ?>
                    </div>
                    <span class="asterisk1_input"></span>
                </div>
            </div>
            
            <div class="control-group">
                 <label for="targetgroups" class="control-label">TARGET GROUPS:</label>
                <div class="controls">
                    <div id="targetgroupsfieldset">
                    <?php foreach($targetGroups as $targetGroup)  
                    {
                        $i = $targetGroup['TargetGroupId'];
                    ?>
                        <input class="uniform_tg" type="checkbox" name="<?php echo "targetgroup".$i; ?>" value="<?php echo $targetGroup['TargetGroupId']; ?>" <?php if(isset($targetGroupIds)){ rs_CheckTargetGroup($targetGroupIds, $i);} ?> > <?php echo $targetGroup['TargetGroup']; ?><br />
                    <?php
                    }
                    ?>
                    </div>
                    <span class="asterisk1_input"></span>
                </div>
            </div>


           

            <div class="control-group">
                  <label for="startDate" class="control-label">START DATE:</label>
                  <div class="controls"><input id="startDate" name="startDate" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['StartDate'];} ?>"></div>
            </div> 
          
            <div class="control-group">
                  <label for="projectStatusId" class="control-label">PROJECT STATUS:</label>
                  <div class="controls"><input id="projectStatusId" name="projectStatusId" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['ProjectStatusId'];} ?>"></div>
            </div> 
          
            <div class="control-group">
                  <label for="hoursSpent" class="control-label">HOURS SPENT:</label>
                  <div class="controls"><input id="hoursSpent" name="hoursSpent" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['HoursSpent'];} ?>"></div>
            </div> 

            <div class="control-group">
                  <label for="pplParticipated" class="control-label">PEOPLE PARTICIPATED:</label>
                  <div class="controls"><input id="pplParticipated" name="pplParticipated" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['PplParticipated'];} ?>"></div>
            </div> 
            
    
            <div class="control-group">
                  <label for="pplServed" class="control-label">PEOPLE SERVED:</label>
                  <div class="controls"><input id="pplServed" name="pplServed" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['PplServed'];} ?>"></div>
            </div> 
            
            <div class="control-group">
                 <label for="report" class="control-label">REPORT:</label><div class="controls"><textarea id="report" name="report" placeholder="max 65000 characters" ><?php if (isset($searchedProject)) {echo $searchedProject[0]['Report'];} ?></textarea></div>
            </div>
              
             <div class="control-group">
                  <label for="endDate" class="control-label">END DATE:</label>
                  <div class="controls"><input id="endDate" name="endDate" type="text" value="<?php if (isset($searchedProject)) {echo $searchedProject[0]['EndDate'];} ?>"></div>
            </div> 
</form>  
<?php       
}
add_action( 'rs_project_details_hook' , 'rs_ProjectDetails' );
?>


