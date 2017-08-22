<?php
    require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
    require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';
    require_once RS_PLUGIN_PATH.'appcode/webapp/model/projectmember.class.php';

    //insert testen
    /*
    function rs_test_InsertProjectMember($projectId, $memberId, $pending, $insertedBy)
    {
    $projectMember = new ProjectMember();
    $projectMember->insert($projectId, $memberId, $pending, $insertedBy);
?>   
    <p>Test insert projectmember</p>
        <ul>
            <li>Feedback: <?php echo $projectMember->getFeedback(); ?></li>
            <li>Error message: <?php echo $projectMember->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $projectMember->getErrorCode(); ?></li>
            <li>ID: <?php echo $projectMember->getProjectMemberId(); ?></li>
        </ul>
    <?php
    }
    */
    ?>
    
    
<?php
    //update testen
    /*
    function rs_test_UpdateProjectMember($projectMemberId, $projectId, $memberId, $pending, $modifiedBy)
    {
    $pMember = new ProjectMember();
    $pMember->update($projectMemberId, $projectId, $memberId, $pending, $modifiedBy);
?>   
<p>Test update projectmember</p>
        <ul>
            <li>Feedback: <?php echo $pMember->getFeedback(); ?></li>
            <li>Error message: <?php echo $pMember->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $pMember->getErrorCode(); ?></li>
        </ul>
<?php
    }//end rs_UpdateProjectMember
    */
    
    

    //testen van selectproductsByMemberId()
    /*
    function rs_test_SelectProjectsByMemberId($memberId)
    {
    $objectS = new ProjectMember();
    $projectsOfMember = $objectS->selectProjectsByMemberId($memberId);
    ?>
    <table>
    <thead>
    <tr><th>ProjectMemberId</th><th>ProjectId</th><th>MemberId</th><th>Pending</th><th>InsertedBy</th><th>ModifiedBy</th></tr>
    </thead>
    <tbody>
    <?php
    foreach($projectsOfMember as $pom)    
    {
    ?>
    <tr><td><?php  echo $pom['ProjectMemberId']; ?></td><td><?php  echo $pom['ProjectId']; ?></td><td><?php  echo $pom['MemberId']; ?></td><td><?php  echo $pom['Pending']; ?></td><td><?php  echo $pom['InsertedBy']; ?></td><td><?php  echo $pom['ModifiedBy']; ?></td></tr>
    <?php
    }//end foreach
    ?>
    </tbody>
    </table>
    <br />

    <?php
    }//end selectMemberById
    */

    //delete testen
    /*
    function rs_test_DeleteProjectMember($memberId)
    {
    $objectD= new ProjectMember();
    $objectD->delete($memberId);
    ?>
    <p>Test deleting projectmember</p>
        <ul>
            <li>Message: <?php echo $objectD->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectD->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectD->getErrorCode(); ?></li>
        </ul>
    </p
    <?php
    
    }//end function
    */

    //select projectmembers testen
    /*
    function rs_test_SelectProjectMembers()
    {
    $objectS= new ProjectMember();
    $pms = $objectS->selectAll();

    ?>
    <table>
    <thead>
    <tr><th>ProjectMemberId</th><th>ProjectId</th><th>MemberId</th><th>Pending</th><th>InsertedBy</th></tr>
    </thead>
    <tbody>
    <?php
        foreach($pms as $pm)
        {
    ?>
    <tr><td><?php  echo $pm['ProjectMemberId']; ?></td><td><?php  echo $pm['ProjectId']; ?></td><td><?php  echo $pm['MemberId']; ?></td><td><?php  echo $pm['Pending']; ?></td><td><?php  echo $pm['InsertedBy']; ?></td></tr>
    <?php
        }//end foreach
    ?>
    </tbody>
    </table>
    <br />
    
    <p>Test select projectmember</p>
        <ul>
            <li>Message: <?php echo $objectS->getFeedback(); ?></li>
            <li>Error message: <?php echo $objectS->getErrorMessage(); ?></li>
            <li>Error code: <?php echo $objectS->getErrorCode(); ?></li>
        </ul>
    </p
    <?php
    
    }//end function
    */
    ?>



    

