<?php
//is needed because there is no reference to this page in the plugin's main file
session_start()  ;

//require_once RS_PLUGIN_PATH.'appcode/webapp/help/cleaninput.php';
//seems to be needed allthough already defined in rootsandshoots.php
define('RS_PLUGIN_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\wp-content\\plugins\\rootsandshoots\\");

require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\project.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\stuff.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\lid.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\help\thumbnail.php';


$bericht;
$target_dir = "../view/fotouploads/";//map van originele foto's
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$target_file_name = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $bericht = "Bestand File is geen foto.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file))
{
    $bericht = "Sorry, bestand ".$target_file." bestaat al.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000)
{
    $bericht = "Sorry, uw bestand is te groot. Het moet kleiner zijn dan 0.5MByte.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
{
    $bericht = "Sorry, enkel jpg, jpeg, png & gif bestanden zijn toegelaten.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) 
{
    $bericht .= "Uw bestand werd niet opgeladen.";
}
else // if everything is ok, try to upload file
 {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
    {
        //1. thumbnail genereren
        createThumbnail($target_file_name, 300);

        //2. databank data toevoegen
        $stuffObject = new Stuff();
        $stuffTitle = $target_file_name;
        echo "stufftitle: ".$stuffTitle;
        $projectId = $_POST['idHidden'];
        echo "projectId: ".$projectId;
        //$memberId = ;
        
        $fotoObject->insert();
        $bericht = "Het bestand ". basename( $_FILES["fileToUpload"]["name"]). " is opgeladen.";

        //3. originele grote foto wissen
        unlink('../../../appcode/webapp/view/fotouploads/'.$target_file_name);
    } 
    else
    {
        $bericht = "Sorry, er is een fout bij het opladen van uw bestand.";
    }
}
$_SESSION['uploadmessage'] = $bericht;
header('Location: ../view/foto_toevoegen.php?documentid='.$_SESSION['docidbijfotoupload']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <p>Test insert foto</p>
        <ul>
            <li>Message: <?php echo $fotoObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $fotoObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $fotoObject->getErrorCode(); ?></li>
            <li>ID: <?php echo $fotoObject->getFotoId(); ?></li>
        </ul>
    </body>
</html>
        