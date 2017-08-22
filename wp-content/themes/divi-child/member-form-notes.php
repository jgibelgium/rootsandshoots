<?php
//retrieve username and pasword? 
 $current_user = wp_get_current_user();
 echo "username: ".$current_user->user_login;
 $userId = $current_user->ID;
 echo "userid: ".$current_user->ID;
  
 echo "userpass: ".$current_user->user_pass;
 
 //get memberId
 $memberObject = new Member();
 $searchedMember = $memberObject->selectMemberById($userId);
 //print_r($searchedMember);
 if(!empty($searchedMember))
 {
 	$notes = $searchedMember[0]['Notes'];
 }
 else
 {
 		 $notes = "";
 }

?>

<div id="redbar" class="alert-info">
        <strong>&nbsp;<?php echo "Add personal notes"; ?></strong>
        <button id="closeinfo" type="button" class="close">&times;</button>    
</div>

<!--<form id="frmMemberRemarks" method="POST" class="form-horizontal" enctype="multipart/form-data">-->
            <div class="control-group">
                 <label for="notes" class="control-label">NOTES:</label>
                 <div class="controls">
                 	<textarea id="notes" name="notes" type="text" autofocus="true" cols="100" rows="20"><?php echo $notes;?></textarea>
                 </div>
            </div>
            
            <div class="control-group">
                 <input id="userId" name="userId" type="hidden" value="<?php echo $userId; ?>">
            </div>   
                  
            <div class="control-group">
                <div class="controls">
                <?php
                if(empty($notes))
                {    
                ?>
                <input id="btnNotesSave" name="btnNotesSave" type="submit" class="btnsave" value="Save">
                <?php
                }
                else
                {
                ?>
                <input id="btnNotesUpdate" name="btnNotesUpdate" type="submit" class="btnupdate" value="Update"/>
                <?php
                }
                ?>
                </div>
            </div>          
<!--</form>-->

