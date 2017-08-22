<?php
if(isset($_POST['projectid']))
{
    echo "projectid: ".$_POST['projectid'];
    $projectObject = new Project();
    $projectId = $_POST['projectid'];
    $projectObject->setProjectId($projectId);
   
}
else
{
    $projectObject = new Project();
    $projectObject->setProjectId("");
}

?>
<div id="rodebalk" class="alert-info">
            <strong>&nbsp;Foto toevoegen</strong>
             <button id="sluitinfo" type="button" class="close">&times;</button>    
</div>
        <p>
            <a href="project-form#description" class="buttonterug">&nbsp;Terug</a>
        </p>
       
        <form action="../control/upload.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="control-group">
                <label for="fileToUpload" class="control-label">foto kiezen:</label>
                <div class="controls"><input type="file" name="fileToUpload" id="fileToUpload" required></div>
            </div>
            <div class="control-group">
                <label for="naam" class="control-label">foto opladen:</label>
                <div class="controls"><button type="submit" name="submit">Foto opladen</button></div>
            </div>
            
             <div class="control-group">
                 <input id="idHidden" name="idHidden" type="hidden" value="<?php echo $projectObject->getProjectId(); ?>">
            </div>   

        
        </form>