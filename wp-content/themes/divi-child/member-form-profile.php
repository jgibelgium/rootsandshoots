 <?php
//1. situation 1: member consults his profile
//retrieve userid
$current_user = wp_get_current_user();
$userId = $current_user->ID;
//echo $userId;
$userEmail = $current_user->user_email;
  
//talen ophalen
$languageObject = new Language(); 
$languages = $languageObject->selectAll(); 

//get countries
$countryObject = new Country(); 
$countries = $countryObject->selectAll(); 

//retrieve user by his wpuserid
 

//$_POST['memberid'] is set by a coordinator consulting a member profile
if ($userId != 0)
{
	//heeft geen zin want er is nog geen record in rs_members
    $memberObject = new Member();
    //$memberObject->setMemberId($memberId);//nodig voor hidden field
    $searchedMember = $memberObject->selectMemberById($userId);
	//$memberId = $searchedMember[0]['MemberId']; memberId kan niet gevonden worden want is nog niet ingevuld
    //print_r($searchedMember);
}
else
{
    $memberObject = new Member();
    $memberObject->setMemberId("");
}

//2. situation 2: coordinator looks at profile of member
?>
<div id="redbar" class="alert-info">
        <strong>&nbsp;<?php if(empty($searchedMember)){echo "Add member profile";} else {echo "Update member profile";}?></strong>
        <button id="closeinfo" type="button" class="close">&times;</button>    
</div>

<form id="frmMemberProfile" method="POST" action="http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/control/memberprofile.control.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
                 <label for="firstname" class="control-label">FIRST NAME:</label><div class="controls"><input id="firstname" name="firstname" type="text" autofocus="true" value="<?php if(!empty($searchedMember)){ echo $searchedMember[0]['FirstName']; }?>" required></div>
            </div>
            
            <div class="control-group">
                 <label for="lastname" class="control-label">LAST NAME:</label><div class="controls"><input id="lastname" name="lastname" type="text" value="<?php if(!empty($searchedMember)){ echo $searchedMember[0]['LastName']; }?>" required></div>
            </div>
            
            <div class="control-group">
                 <label for="birthdate" class="control-label">BIRTH DATE:</label><div class="controls"><input id="birthdate" name="birthdate" type="date" value="<?php if(!empty($searchedMember)){ echo $searchedMember[0]['BirthDate']; }?>" required></div>
            </div>
            
            <div class="control-group">
                 <label for="email" class="control-label">EMAIL ADDRESS:</label><div class="controls"><input id="email" name="email" type="text" value="<?php if(!empty($current_user)) {echo $userEmail;} ?>" required></div><span><?php echo "ophalen van bij de registratie "; ?></span>
            </div>
            
            <div class="control-group">
                 <input id="userId" name="userId" type="hidden" value="<?php echo $userId; ?>"><!--is dit veld nodig?-->
            </div>
            
            <div class="control-group">
            <label for="languageid" class="control-label">LANGUAGE:</label>
            <div class="controls">
            <select id="language" name="languageid" required>
                <option></option>
                <?php
                    foreach($languages as $taal)
                    {
                ?>
                <option value="<?php echo $taal['LanguageId'];?>" <?php if(!empty($searchedMember)){ if($searchedMember[0]['LanguageId'] == $taal['LanguageId']){echo "selected";} }?>><?php echo $taal['Language'];?></option>
                <?php
                    }
                ?>
            </select>
            </div>
            </div>

			 <div class="control-group">
            <label for="countryid" class="control-label">COUNTRY:</label>
            <div class="controls">
            <select id="country" name="countryid" required>
                <option></option>
                <?php
                    foreach($countries as $country)
                    {
                ?>
               <option value="<?php echo $country['CountryId'];?>" <?php if(!empty($searchedMember)){ if($searchedMember[0]['CountryId'] == $country['CountryId']){echo "selected";} }?>><?php echo $country['Country'];?></option>
                <?php
                    }
                ?>
            </select>
            </div>
            </div>
            
            <div class="control-group">
                 <input id="idHidden" name="idHidden" type="hidden" value="<?php if(!empty($searchedMember)){ echo $searchedMember[0]['WPUserId']; }?>">
            </div>         
            <div class="control-group">
                <div class="controls">
                <?php
                if(empty($searchedMember))
                {    
                ?>
                <input id="btnMemberSave" name="btnMemberSave" type="submit" class="btnsave" />
                <input id="btnMemberCancel" name="btnMemberCancel" type="reset" class="btncancel" />
                <?php
                }
                else
                {
                ?>
                <input id="btnMemberUpdate" name="btnMemberUpdate" type="submit" class="btnupdate" value="Update" />
                <?php
                }
                ?>
                </div>
            </div>          
</form>  

<?php


?>