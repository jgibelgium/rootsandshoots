<?php
?>

<form id="frmMemberAge" method="POST" action="http://localhost:8080/rootsandshootseurope/wp-content/plugins/rootsandshoots/appcode/webapp/control/memberage.control.php" class="form-horizontal" enctype="multipart/form-data">
<div class="rs_question">Are you above 16 years of age? *</div>
 
<div class="mafradio">
  <input id="optionyes" type="radio" name="memberformage" value="1" checked>
  <label for="optionyes"><span class="radio">Yes</span></label>
</div>   
 
<div class="mafradio">
  <input id="optionno" type="radio" name="memberformage" value="0" checked>
  <label for="optionno"><span class="radio">No</span></label>
</div>  

<input type="submit" name="memberAgeBtn" value="Submit" class="btnsignin">


</form>

<?php
?>
