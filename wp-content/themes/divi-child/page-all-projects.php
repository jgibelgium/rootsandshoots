<?php
/*page template of all projects on behalf of the administrator*/
 get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
<?php
//get projectstatus of project
function getProjectStatus($projectStatusId)
{
    $psObject = new ProjectStatus();
    $result = $psObject->selectProjectStatusById($projectStatusId);
    echo $result[0]['ProjectStatus'];
}

$projectObject = new Project();
$projectsList = $projectObject->selectAll();
   
?>

<div id="redbar" class="alert-info">
                <strong>&nbsp;All projects: <?php echo count($projectsList)?> rows</strong>
                <button id="closeinfo" class="close">&times;</button>    
            </div>
<div class="row-fluid">
                <label id="paginatie">
                    <select size="1" id="aantalPaginas">
                        <option></option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>&nbsp;rows per page
                </label>
                <label id="lblfilter">
                Search:&nbsp;<input type="text" id="filter">
                </label>
            </div>
            
<div id="actionsdiv">
            <a href="http://localhost:8080/rootsandshootseurope/project-form/" class="pull-left buttonadd">&nbsp;Add project</a>
           
            <a onclick="window.print()" class="pull-right btnprint"><i class="icon-print icon-large"></i>&nbsp;Print</a>
            <a id="btnexcel" class="pull-right btnexport">&nbsp;Export to Excel</a>
            </div>
<table id="projectsTable">
                    <thead>
                        <tr>
                        <th class="sorteer getal rs_projectid">PROJECT NR.</th>
                        <th class="sorteer alfabet rs_projecttitle">PROJECT TITLE</th>
                        <th class="sorteer alfabet rs_projectobjective">OBJECTIVE</th>
                        <th class="sorteer alfabet">STATUS</th>
                        <th class="rs_projectaction"></th>
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
                        <td id="<?php echo "status".$i ?>"><?php getProjectStatus($project['ProjectStatusId']); ?></td>
                        <td>
                            <button id="<?php echo "projectBtnDelete".$i?>" class="btndelete">Delete</button>
                            <form method="post" action="http://localhost:8080/rootsandshootseurope/project-form/" class="rs_form_edit">
                              <input name="projectid" value="<?php echo $i; ?>" type="hidden" />
                              <input type="submit" value="Edit" class="btnEdit" title="edit" /> 
                            </form>
                            
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
             </table>
<div class="paging"></div>
              
</section>
    
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>

