<?php
/*page template of project type form*/
get_header(); ?>

<div id="main" class="main">
    <div class="container">
        <section id="content" class="rs_content">
<?php
if(isset($_POST['projecttypeid'])) //fill in form
{
    $projectTypeObject = new ProjectType();
    $projectTypeId = $_POST['projecttypeid'];
    $projectTypeObject->setProjectTypeId($projectTypeId);//nodig voor hidden field
    $searchedProjectType = $projectTypeObject->selectProjectTypeById($projectTypeId);
   
}
else //empty form
{
    $projectTypeObject = new ProjectType();
    $projectTypeObject->setProjectTypeId("");
}
?>
<div id="redbar" class="alert-info">
        <strong>&nbsp;<?php if(empty($_POST['projecttypeid'])){echo "Add project type";} else {echo "Update project type";}?></strong>
        <button id="closeinfo" type="button" class="close">&times;</button>    
</div>
<p>
        <a href="http://localhost:8080/rootsandshootseurope/project-types/" class="buttonback">&nbsp;Back</a>
</p>
<form id="frmProjectType" method="POST" action="http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/control/projecttype.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
                 <label for="projecttype" class="control-label">PROJECT TYPE:</label><div class="controls"><input id="projecttype" name="projecttype" type="text" autofocus="true" value="<?php if (isset($searchedProjectType)) {echo $searchedProjectType[0]['ProjectType'];} ?>" required></div>
            </div>
            
            <div class="control-group">
                 <label for="projecttypeinfo" class="control-label">PROJECT TYPE INFO:</label><div class="controls"><input id="projecttypeinfo" name="projecttypeinfo" type="text" value="<?php if (isset($searchedProjectType)) {echo $searchedProjectType[0]['ProjectTypeInfo'];} ?>" required></div>
            </div>

            <div class="control-group">
                 <input id="idHidden" name="idHidden" type="hidden" value="<?php echo $projectTypeObject->getProjectTypeId(); ?>">
            </div>         
            <div class="control-group">
                <div class="controls">
                <?php
                if(empty($_POST['projecttypeid']))
                {    
                ?>
                <input id="btnProjectTypeSave" name="btnProjectTypeSave" type="submit" class="btnsave" />
                <input id="btnprojectTypeCancel" name="btnProjectTypeCancel" type="reset" class="btncancel" />
                <?php
                }
                else
                {
                ?>
                <input id="btnProjectTypeUpdate" name="btnProjectTypeUpdate" type="submit" class="btnupdate" value="Update" />
                <?php
                }
                ?>
                </div>
            </div>          
</form>  
</section>
        
      <div class="clear"></div>
    </div>
</div>

<?php get_footer(); ?>

