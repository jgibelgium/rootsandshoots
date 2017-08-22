<?php
/*
Plugin Name: Rootsandshoots
Description: A plugin for R&S functionality
Author: RE
Version: 1.0
*/

if (!defined('RS_PLUGIN_PATH')) {
    define('RS_PLUGIN_PATH', dirname(__FILE__)."\\");    /*oftewel _DIR_*/
}else
{}

//define('RS_WEBSITE_PATH',"C:\\wamp64\\www\\rootsandshootseurope\\");

//1. needed model files
/*helper klassen dienen voor de modelklassen te staan*/
require_once RS_PLUGIN_PATH.'appcode\helpers\feedback.class.php';
require_once RS_PLUGIN_PATH.'appcode\helpers\base.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\projecttype.class.php';
require_once RS_PLUGIN_PATH.'appcode\webapp\model\project.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projectstatus.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/country.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/language.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projecttype.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/targetgroup.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/timeframe.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projectprojecttype.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/projecttargetgroup.class.php';
require_once RS_PLUGIN_PATH.'appcode/webapp/model/member.class.php';

//2. not needed: control files, because not called from scratch
//require_once RS_PLUGIN_PATH.'appcode\webapp\control\projecttype.control.php';

/*3. You don't have to use session_start() on top of each page instead you should add a function in init hook.*/
function session_initialize() {

    if ( ! session_id() ) {
        session_start();
    }
}
add_action( 'init', 'session_initialize' );

?>