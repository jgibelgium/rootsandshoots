<?php
    require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
    require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
    require_once RS_PLUGIN_PATH.'appcode/webapp/model/stuff.class.php';

    //insert testen
    /*
    function rs_test_InsertStuff($stuffTitle, $projectId, $stuffId, $stuffTypeId, $insertedBy)
    {
    $stuff = new Stuff();
    $stuff->insert($stuffTitle, $projectId, $stuffId, $stuffTypeId, $insertedBy);
?>   
<p>Test insert Stuff</p>
        <ul>
            <li>Feedback: <?php echo $stuff->getFeedback(); ?></li>
            <li>Error message: <?php echo $stuff->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $stuff->getErrorCode(); ?></li>
            <li>ID: <?php echo $stuff->getStuffId(); ?></li>
        </ul>
<?php
    }//end rs_InsertStuff
    */
?>
    
    
<?php
    //update testen
    /*
    function rs_test_UpdateStuff($stuffId, $stuffTitle, $projectId, $memberId, $stuffTypeId, $modifiedBy)
    {
    $stuff = new Stuff();
    $stuff->update($stuffId, $stuffTitle, $projectId, $memberId, $stuffTypeId, $modifiedBy);
?>   
<p>Test update Stuff</p>
        <ul>
            <li>Feedback: <?php echo $stuff->getFeedback(); ?></li>
            <li>Error message: <?php echo $stuff->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $stuff->getErrorCode(); ?></li>
            <li>ID: <?php echo $stuff->getStuffId(); ?></li>
        </ul>
<?php
    }//end rs_UpdateStuff
    */
    
    

    //testen van selectStuffById()
    /*
    function rs_test_SelectStuffById($stuffId)
    {
    $objectS = new Stuff();
    $result = $objectS->selectStuffById(5);
    ?>
    <table>
    <thead>
    <tr><th>StuffId</th><th>StuffTitle</th><th>ProjectId</th><th>MemberId</th><th>StuffTypeId</th></tr>
    </thead>
    <tbody>
    <tr><td><?php  echo $result[0]['StuffId']; ?></td><td><?php  echo $result[0]['StuffTitle']; ?></td><td><?php  echo $result[0]['ProjectId']; ?></td><td><?php  echo $result[0]['MemberId']; ?></td><td><?php  echo $result[0]['StuffTypeId']; ?></td></tr>
    </tbody>
    </table>
    <br />

    <?php
    }//end selectStuffById
    */

    //delete testen
    /*
    function rs_test_DeleteStuff($stuffId)
    {
    $objectD= new Stuff();
    $objectD->delete($stuffId);
    ?>
    <p>Test deleting Stuff</p>
        <ul>
            <li>Message: <?php echo $objectD->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectD->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectD->getErrorCode(); ?></li>
        </ul>
    </p
    <?php
    }//end function
    */
    

    //testen van selectStuffByMemberId()
    /*
    function rs_test_SelectStuffByMemberId($memberId)
    {
        $objectS = new Stuff();
        $resultM = $objectS->selectStuffByMemberId($memberId);
    ?>
    <table>
    <thead>
    <tr><th>StuffId</th><th>StuffTitle</th><th>ProjectId</th><th>MemberId</th><th>StuffTypeId</th></tr>
    </thead>
    <tbody>
    <?php
    foreach($resultM as $stuff)
    {
    ?>
    <tr><td><?php  echo $stuff['StuffId']; ?></td><td><?php  echo $stuff['StuffTitle']; ?></td><td><?php  echo $stuff['ProjectId']; ?></td><td><?php  echo $stuff['MemberId']; ?></td><td><?php  echo $stuff['StuffTypeId']; ?></td></tr>
    <?php
    }//end foreach
    ?>
        </tbody>
    </table>
    <?php
    }//end fc
    */

    function rs_test_SelectStuffByProjectId($projectId)
    {
        $objectS = new Stuff();
        $resultM = $objectS->selectStuffByProjectId($projectId);
    ?>
    <table>
    <thead>
    <tr><th>StuffId</th><th>StuffTitle</th><th>ProjectId</th><th>MemberId</th><th>StuffTypeId</th></tr>
    </thead>
    <tbody>
    <?php
    foreach($resultM as $stuff)
    {
    ?>
    <tr><td><?php  echo $stuff['StuffId']; ?></td><td><?php  echo $stuff['StuffTitle']; ?></td><td><?php  echo $stuff['ProjectId']; ?></td><td><?php  echo $stuff['MemberId']; ?></td><td><?php  echo $stuff['StuffTypeId']; ?></td></tr>
    <?php
    }//end foreach
    ?>
        </tbody>
    </table>
    <?php
    }//end fc

    
    ?>

