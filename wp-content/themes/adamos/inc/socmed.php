<?php 

	$list_social_networks = array(
		array( 'twitter', 'Twitter', 'twitter' ),
		array( 'facebook', 'Facebook', 'facebook-square' ),
		array( 'pinterest', 'Pinterest', 'pinterest' ),
		array( 'linkedin', 'LinkedIn', 'linkedin' ),
		array( 'googleplus', 'Google Plus', 'google-plus-square' ),
		array( 'flickr', 'Flickr', 'flickr' ),
		array( 'youtube', 'Youtube', 'youtube-play' ),
		array( 'vimeo', 'Vimeo', 'vimeo-square' ),
		array( 'dribble', 'Dribbble', 'dribbble' ),
		array( 'tumblr', 'Tumblr', 'tumblr-square' ),
		array( 'github', 'Github', 'github' ),
		array( 'instagram', 'Instagram', 'instagram' ),
		array( 'xing', 'Xing', 'xing' ),
	);

	$socialList = count($list_social_networks);
	for ($row = 0; $row <  $socialList; $row++) {
		if( get_theme_mod( $list_social_networks[$row][0] ) ){
			echo '<a class="nav-social-btn ' . $list_social_networks[$row][0] . '-icon" title="' . $list_social_networks[$row][1] . '" href="' . esc_url( get_theme_mod( $list_social_networks[$row][0] ) ) . '" target="_blank"><span class="fa fa-' . $list_social_networks[$row][2] . '"></span></a>';
		}
	}
