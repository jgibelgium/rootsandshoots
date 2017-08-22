<?php
include('../../../appcode/helpers/feedback.class.php');    
include('../../helpers/base.class.php');
include('../model/dockenmerk.class.php');
include('../model/lid.class.php'); 
include('../help/cleaninput.php');

session_start();


$_POST = opschonenInput($_POST);
$docKenmerkObject = new DocKenmerk();

    if(empty($_POST['tbDocKenmerkId1']))//1ste kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld1']) && !empty($_POST['tbWaarde1']))//validatie serverside
        {
        //1ste kenmerk toevoegen
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld1']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde1']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
    }
    else
    {
        if(!empty($_POST['tbVeld1']) && !empty($_POST['tbWaarde1']))//1ste kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId1']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld1']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde1']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld1']) && empty($_POST['tbWaarde1']))//verwijderen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId1']);
        $docKenmerkObject->delete();
        }
    }


    if(empty($_POST['tbDocKenmerkId2']))//2de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld2']) && !empty($_POST['tbWaarde2']))//validatie serverside
        {
        //2de kenmerk toevoegen
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld2']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde2']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
    }
    else
    {
        if(!empty($_POST['tbVeld2']) && !empty($_POST['tbWaarde2']))//2de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId2']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld2']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde2']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld2']) && empty($_POST['tbWaarde2']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId2']);
         $docKenmerkObject->delete();
        }
     }

    if(empty($_POST['tbDocKenmerkId3']))//3de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld3']) && !empty($_POST['tbWaarde3']))//validatie serverside
        {
        //3de kenmerk toevoegen
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld3']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde3']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
    }
    else
    {
        if(!empty($_POST['tbVeld3']) && !empty($_POST['tbWaarde3']))//3de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId3']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld3']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde3']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld3']) && empty($_POST['tbWaarde3']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId3']);
         $docKenmerkObject->delete();
        }
    }

    if(empty($_POST['tbDocKenmerkId4']))//4de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld4']) && !empty($_POST['tbWaarde4']))//validatie serverside
        {
        //4de kenmerk toevoegen
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld4']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde4']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
    }
    else
    {

        if(!empty($_POST['tbVeld4']) && !empty($_POST['tbWaarde4']))//4de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId4']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld4']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde4']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld4']) && empty($_POST['tbWaarde4']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId4']);
         $docKenmerkObject->delete();
        }
    }

   
    if(empty($_POST['tbDocKenmerkId5']))//5de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld5']) && !empty($_POST['tbWaarde5']))//validatie serverside
        {
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld5']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde5']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
     }
     else
     {
        if(!empty($_POST['tbVeld5']) && !empty($_POST['tbWaarde5']))//5de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId5']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld5']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde5']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld5']) && empty($_POST['tbWaarde5']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId5']);
         $docKenmerkObject->delete();
        }
    }


    if(empty($_POST['tbDocKenmerkId6']))//6de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld6']) && !empty($_POST['tbWaarde6']))//validatie serverside
        {
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld6']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde6']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
     }
     else
     {

        if(!empty($_POST['tbVeld6']) && !empty($_POST['tbWaarde6']))//6de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId6']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld6']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde6']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld6']) && empty($_POST['tbWaarde6']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId6']);
         $docKenmerkObject->delete();
        }
     }


     if(empty($_POST['tbDocKenmerkId7']))//7de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld7']) && !empty($_POST['tbWaarde7']))//validatie serverside
        {
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld7']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde7']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
     }
     else
     {

        if(!empty($_POST['tbVeld7']) && !empty($_POST['tbWaarde7']))//7de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId7']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld7']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde7']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld7']) && empty($_POST['tbWaarde7']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId7']);
         $docKenmerkObject->delete();
        }
     }


     if(empty($_POST['tbDocKenmerkId8']))//8de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld8']) && !empty($_POST['tbWaarde8']))//validatie serverside
        {
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld8']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde8']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
     }
     else
     {
        if(!empty($_POST['tbVeld8']) && !empty($_POST['tbWaarde8']))//8de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId8']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld8']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde8']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld8']) && empty($_POST['tbWaarde8']))//verwijderen
        {   
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId8']);
         $docKenmerkObject->delete();
        }
     }


     if(empty($_POST['tbDocKenmerkId9']))//9de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld9']) && !empty($_POST['tbWaarde9']))//validatie serverside
        {
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld9']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde9']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
     }
     else
     {


        if(!empty($_POST['tbVeld9']) && !empty($_POST['tbWaarde9']))//9de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId9']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld9']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde9']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld9']) && empty($_POST['tbWaarde9']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId9']);
         $docKenmerkObject->delete();
        }
     }


    if(empty($_POST['tbDocKenmerkId10']))//10de kenmerk toevoegen
    {
        if(!empty($_POST['tbVeld10']) && !empty($_POST['tbWaarde10']))//validatie serverside
        {
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld10']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde10']);
        $docKenmerkObject->setAddedBy($_SESSION['username']);
        $docKenmerkObject->insert();
        }
     }
     else
     {
        if(!empty($_POST['tbVeld10']) && !empty($_POST['tbWaarde10']))//10de kenmerk wijzigen
        {
        $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId10']);
        $docKenmerkObject->setDocKenmerk($_POST['tbVeld10']);
        $docKenmerkObject->setDocKenmerkValue($_POST['tbWaarde10']);
        $docKenmerkObject->setDocId($_POST['idHidden']);
        $docKenmerkObject->setModifiedBy($_SESSION['username']);
        $docKenmerkObject->update();
        }
        elseif(empty($_POST['tbVeld10']) && empty($_POST['tbWaarde10']))//verwijderen
        {
         $docKenmerkObject->setDocKenmerkId($_POST['tbDocKenmerkId10']);
         $docKenmerkObject->delete();
        }
     }

      header('Location: ../../../appcode/webapp/view/mijn_documenten.php');
?>
<!--
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
        <p>Test update doc</p>
        <ul>
            <li>Message: <?php echo $docKenmerkObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $docKenmerkObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $docKenmerkObject->getErrorCode(); ?></li>
            <li>$_POST['tbDocKenmerkId1']: <?php echo $_POST['tbDocKenmerkId1'];?></li>
        </ul>
        
        <p>Test delete doc</p>
        <ul>
            <li>Message: <?php echo $docKenmerkObject->getFeedback(); ?></li>
            <li>Error message: <?php echo $docKenmerkObject->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $docKenmerkObject->getErrorCode(); ?></li>
        </ul>
       
    </body>
</html>

-->

