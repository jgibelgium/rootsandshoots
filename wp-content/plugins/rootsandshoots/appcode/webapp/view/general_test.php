<?php
require_once RS_PLUGIN_PATH.'appcode/helpers/feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode/helpers/base.class.php';

function rs_GeneralTest()
{
   $sessionid = session_id();
   echo "sessionid is ".$sessionid;

   session_start();

   echo "lege SESSION superglobal: ";
   print_r($_SESSION);
   echo " ";
   $_SESSION['rs_message'] = "blalla";
   echo "<br />"."de SESSION['rs_message'] is: ";
   print_r($_SESSION['rs_message']); 
}


add_action('rs_generaltest_hook', 'rs_GeneralTest');
?>

