<?php
//1. verwijdert querystrings in URL van javascript en css bestandenfunction _remove_script_version( $src ){$parts = explode( '?ver', $src );return $parts[0];}add_filter( 'script_loader_src', '_remove_script_version', 10, 1 );add_filter( 'style_loader_src', '_remove_script_version', 10, 1 );/*2. functions on behalf of the project types template*/
function rs_Style_ProjectTypes(){    if(is_page('project-types')) //slug als argument      {        wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());        wp_enqueue_style('files_style');         wp_register_style('projecttype_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/projecttypes.css','_FILE_'), array());        wp_enqueue_style('projecttype_style');    } }add_action('wp_enqueue_scripts', 'rs_Style_ProjectTypes');/*w wellicht geladen bij activ plugin*/function rs_Script_ProjectTypes(){    if(is_page('project-types')) //slug als argument    {        wp_register_script('projecttype_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/projecttypes.js','_FILE_'), array('jquery'));        wp_enqueue_script('projecttype_script');    }}add_action('wp_enqueue_scripts', 'rs_Script_ProjectTypes');//add_action('admin_enqueue_scripts', 'rs_Script_ProjectTypes');/*3. function on behalf of the project type form template*/
function rs_StyleAndScript_ProjectTypeForm(){        if(is_page('project-type-form')) //slug als argument    {    wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());    wp_enqueue_style('files_style');     wp_register_style('form_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/form.css','_FILE_'), array());    wp_enqueue_style('form_style');     wp_register_script('projecttypeform_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/projecttypeform.js','_FILE_'), array('jquery'));    wp_enqueue_script('projecttypeform_script');    }}add_action('wp_enqueue_scripts', 'rs_StyleAndScript_ProjectTypeForm');/*4. function on behalf of all projects shown to administrator*/function rs_StyleAndScript_AllProjects(){    if(is_page('all-projects')) //slug als argument    {         wp_register_style('form_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/form.css','_FILE_'), array());        wp_enqueue_style('form_style');         wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());        wp_enqueue_style('files_style');         wp_register_style('project_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/allprojects.css','_FILE_'), array());        wp_enqueue_style('project_style');               wp_register_script('project_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/all_projects.js','_FILE_'), array('jquery'));        wp_enqueue_script('project_script');    }}add_action('wp_enqueue_scripts', 'rs_StyleAndScript_AllProjects');/*5. functions on behalf of the project form template*/function rs_StyleAndScript_ProjectForm(){        if(is_page('project-form')) //slug als argument    {    wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());    wp_enqueue_style('files_style');     wp_register_style('projectform_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/projectform.css','_FILE_'), array());    wp_enqueue_style('projectform_style');     wp_register_script('projectform_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/projectform.js','_FILE_'), array('jquery'));    wp_enqueue_script('projectform_script');    }}add_action('wp_enqueue_scripts', 'rs_StyleAndScript_ProjectForm');/*6. function on behalf of projects shown to visitors*/function rs_StyleAndScript_Projects(){    if(is_page('projects')) //slug als argument    {        wp_register_style('files_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/files.css','_FILE_'), array());        wp_enqueue_style('files_style');         wp_register_style('project_style', plugins_url('/rootsandshoots/appcode/webapp/view/css/projects.css','_FILE_'), array());        wp_enqueue_style('project_style');        wp_register_script('project_script', plugins_url('/rootsandshoots/appcode/webapp/view/jquery/all_projects.js','_FILE_'), array('jquery'));        wp_enqueue_script('project_script');    }}add_action('wp_enqueue_scripts', 'rs_StyleAndScript_Projects');/*7. * // Add a custom user role to the WP settings*/$result = add_role( 'client', __('Client' ),array( ) ); // Change the default role in the WP settingsfunction client_default_role($value){    // You can also add conditional tags here and return whatever    //return 'subscriber'; // This is changed    return 'client'; // This allows default};add_filter('pre_option_default_role', 'client_default_role');/*8*/function rs_add_topmenu(){register_nav_menus( array(        'secondary' => 'Top Menu',        'tertiary' => 'Register Menu'    ) );}add_action('after_setup_theme','rs_add_topmenu');/*9 remove admin bar on the front end*/function remove_admin_bar() {if (!current_user_can('administrator') && !is_admin()) {  show_admin_bar(false);}}//add_action('after_setup_theme', 'remove_admin_bar');
?>