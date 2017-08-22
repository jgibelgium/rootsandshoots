<?php

function register_my_session()
{
  if( !session_id() )
  {
    session_start();
  }
}

add_action('init', 'register_my_session');

function rs_add_topmenu(){
register_nav_menus( array(
		'secondary' => 'Top Menu'
	) );
}
add_action('after_setup_theme','rs_add_topmenu');
?>