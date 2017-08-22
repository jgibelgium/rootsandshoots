<?php
require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projecttype.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/project.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projectstatus.class.php';



function rs_StyleAndScript_MyProjects()
{
    if(is_page('my-projects')) //slug als argument
    {
        wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());
        wp_enqueue_style('files_style'); 
        wp_register_style('project_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/projects.css','_FILE_'), array());
        wp_enqueue_style('project_style');
        wp_register_script('project_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/my_projects.js','_FILE_'), array('jquery'));
        wp_enqueue_script('project_script');
    }
}
add_action('wp_enqueue_scripts', 'rs_StyleAndScript_MyProjects');


//get projecttypes of project
function rs_GetProjectStatus($projectStatusId)
{
    $psObject = new ProjectStatus();
    $result = $psObject->selectProjectStatusById($projectStatusId);
    echo $result[0]['ProjectStatus'];
}



function rs_ShowMyProjects($memberId)
{
$projectObject = new Project();
$projectsList = $projectObject->selectProjectsByMember($memberId);
   
?>

  
        <div class="menuandwelcome">
       
        </div>
            <div id="redbar" class="alert-info">
                <strong>&nbsp;My projects: <?php echo count($projectsList)?> rows</strong>
                <button id="closeinfo" type="button" class="close">&times;</button>    
            </div>
            <div class="row-fluid">
                <label id="filtering">
                Search:&nbsp;<input type="text" id="filter">
                </label>
            </div>
            <p><a href="http://localhost:8080/rootsandshootseurope/project-form/" class="buttonadd">&nbsp;Start new project</a></p><br />
            <table id="projectsTable">
                    <thead>
                        <tr>
                        <th class="sorteer getal rs_projectid">PROJECT NR.</th>
                        <th class="sorteer alfabet rs_projecttitle">PROJECT TITLE</th>
                        <th class="sorteer alfabet rs_projectobjective">OBJECTIVE</th>
                        <th class="sorteer alfabet">STATUS</th>
                        <th class="rs_projectaction">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    foreach ($projectsList as $project)
                    {
                        $i=$project['ProjectId'];
                    ?>
                    <tr id="<?php echo "projectRow".$i ?>">
                        <td id="<?php echo "projectId".$i ?>"><?php echo $project['ProjectId'] ?></td>
                        <td id="<?php echo "projectTitle".$i ?>"><?php echo $project['ProjectTitle'] ?></td>
                        <td id="<?php echo "objective".$i ?>"><?php echo $project['Objective']; ?></td>
                        <td id="<?php echo "status".$i ?>"><?php rs_GetProjectStatus($project['ProjectStatusId']); ?></td>
                        <td>
                            <a id="<?php echo "projectLinkDelete".$i?>" title="wis"><button id="<?php echo "projectBtnDelete".$i?>" type="button" class="btndelete">Delete</button></a>
                            <form id="<?php echo "projectEdit".$i;?>" method="post" action="http://localhost:8080/rootsandshootseurope/project-form/" class="rs_form_edit"><input id="projectid" name="projectid" value="<?php echo $i;?>" /><button id="<?php echo "projectBtnEdit".$i;?>" type="submit" class="btnedit" title="edit">Edit</button></form>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
               <p id="warningDeletion">Are you sure to delete this project?</p>
               <p id="message"><?php isset($_SESSION['rs_message']) ?  $message = $_SESSION['rs_message'] : $message = ""; echo $message; unset($_SESSION['rs_message']);  ?></p>
<?php
}
//maybe retrieve memberid by a function
add_action( 'rs_my_projects_hook' , 'rs_ShowMyProjects', 10, 1 );//priority 10; 1 argument
 
?>

