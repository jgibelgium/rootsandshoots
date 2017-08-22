<?php
include('../../../appcode/helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/doctype.class.php');
include('../model/lid.class.php'); 
include('../help/cleaninput.php');

session_start();
//verwijderen
if(isset($_GET['doctypeid']))
{
    $doctypeObject = new DocType();
    $doctypeId = $_GET['doctypeid'];
    $doctypeObject->setDocTypeId($doctypeId);
    $result = $doctypeObject->delete();
    if($result)
    {
        header('Location: ../../../appcode/webapp/view/documenttypes.php');
    }
    else
    {
        $message = "Geen verwijdering mogelijk.";
        $_SESSION['message'] = $message;
        header('Location: ../../../appcode/webapp/view/documenttypes.php');
    }
}

//toevoegen
//$_POST is always set, but its content might be empty.
if(isset($_POST['btnDocTypeSave']))
{
        $_POST = opschonenInput($_POST);
        $doctypeObject = new DocType();
        $doctypeObject->setDocType($_POST['doctype']);
        $doctypeObject->setAddedBy('admin');
        $result = $doctypeObject->insert();
        if($result)
        {
            header('Location: ../../../appcode/webapp/view/documenttypes.php');
        }
        else
        {
            $message = $doctypeObject->getFeedback();
            $_SESSION['message'] = $message;
            header('Location: ../../../appcode/webapp/view/documenttypes.php');
        }
}
//wijzigen
elseif(isset($_POST['btnDocTypeUpdate']))
{
        $_POST = opschonenInput($_POST);
        $doctypeObject = new DocType();
        $doctypeObject->setDocTypeId($_POST['idHidden']);
        $doctypeObject->setDocType($_POST['doctype']);
        $doctypeObject->setModifiedBy('admin');
        $result = $doctypeObject->update();
        if($result)
        {
            header('Location: ../../../appcode/webapp/view/documenttypes.php');
        }
        else
        {
            $message = $doctypeObject->getFeedback();
            $_SESSION['message'] = $message;
            header('Location: ../../../appcode/webapp/view/documenttypes.php');
        }
}


?>





