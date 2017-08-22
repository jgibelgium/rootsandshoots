<?php 

//Top elements
add_action('cpotheme_top', 'cpotheme_top_menu');
add_action('cpotheme_top', 'cpotheme_cart');
add_action('cpotheme_top', 'cpotheme_languages');
add_action('cpotheme_top', 'cpotheme_social_links');

//Header elements
add_action('cpotheme_header', 'cpotheme_logo');
add_action('cpotheme_header', 'cpotheme_menu_toggle');
add_action('cpotheme_header', 'cpotheme_menu');

//Before main elements
add_action('cpotheme_before_main', 'cpotheme_home_slider');
add_action('cpotheme_before_main', 'cpotheme_home_tagline');
add_action('cpotheme_before_main', 'cpotheme_home_features');
add_action('cpotheme_before_main', 'cpotheme_home_portfolio');

//Page title elements
add_action('cpotheme_title', 'cpotheme_page_title');
add_action('cpotheme_title', 'cpotheme_breadcrumb');

//After main elements

//Subfooter elements
add_action('cpotheme_subfooter', 'cpotheme_subfooter');

//Footer elements
add_action('cpotheme_footer', 'cpotheme_footer_menu');
add_action('cpotheme_footer', 'cpotheme_footer');


//Add homepage slider
function cpotheme_home_slider(){ 
	if(is_front_page()) get_template_part('homepage', 'slider'); 
}

//Add homepage features
function cpotheme_home_features(){ 
	if(is_front_page()) get_template_part('homepage', 'features'); 
}

//Add homepage tagline
function cpotheme_home_tagline(){ 
	if(is_front_page()) cpotheme_block('home_tagline', 'tagline', 'container'); 
}

//Add homepage portfolio
function cpotheme_home_portfolio(){ 
	if(is_front_page()) get_template_part('homepage', 'portfolio'); 
}

//set settings defaults
add_filter('cpotheme_customizer_controls', 'cpotheme_customizer_controls');
function cpotheme_customizer_controls($data){ 
	//Layout
	$data['home_posts']['default'] = true;
	$data['slider_height']['default'] = 500;
	$data['slider_speed']['default'] = 1500;
	$data['features_columns']['default'] = 3;
	$data['portfolio_columns']['default'] = 3;
	//Typography
	$data['type_headings']['default'] = 'Open+Sans:300';
	$data['type_nav']['default'] = 'Open+Sans:300';
	$data['type_body']['default'] = 'Open+Sans';
	//Colors
	$data['primary_color']['default'] = '#ff5000';
	$data['secondary_color']['default'] = '#333333';
	$data['type_headings_color']['default'] = '#666666';
	$data['type_widgets_color']['default'] = '#666666';
	$data['type_nav_color']['default'] = '#666666';
	$data['type_body_color']['default'] = '#666666';
	$data['type_link_color']['default'] = '#ff5000';
	
	$data['layout_style'] = array(
	'label' => __('Layout Style', 'cpotheme'),
	'section' => 'cpotheme_layout_general',
	'type' => 'select',
	'choices' => cpotheme_metadata_layoutstyle(),
	'default' => 'fixed');
	
	return $data;
}


add_filter('body_class', 'cpotheme_theme_body_class');
function cpotheme_theme_body_class($body_classes){
	$body_classes[] = ' wrapper-'.cpotheme_get_option('layout_style');
	return $body_classes;
}


add_filter('cpotheme_background_args', 'cpotheme_background_args');
function cpotheme_background_args($data){ 
	$data = array(
	'default-color' => 'eeeeee',
	'default-image' => get_template_directory_uri().'/images/background.jpg',
	'default-repeat' => 'repeat',
	'default-position-x' => 'center',
	'default-attachment' => 'fixed',
	);
	return $data;
}