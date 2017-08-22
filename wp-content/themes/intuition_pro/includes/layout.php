<?php
add_action('wp_head', 'cpotheme_styling_custom', 19);
function cpotheme_styling_custom(){
	
	//Background styling
	$primary_color = cpotheme_get_option('primary_color');
	$slider_height = cpotheme_get_option('slider_height');
	?>
	<style type="text/css">
		<?php if($slider_height != ''):?>
			.slider-slides { height:<?php echo $slider_height; ?>px; }
		<?php endif; ?>
		
		
		<?php if($primary_color != ''): ?>
		.menu-main .current_page_ancestor > a,
		.menu-main .current-menu-item > a { color:<?php echo $primary_color; ?>; }
		.menu-portfolio .current-cat a,
		.pagination .current { background-color:<?php echo $primary_color; ?>; }
		<?php endif; ?>
    </style>
	<?php
}