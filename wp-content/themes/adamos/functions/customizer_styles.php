<?php
//////////////////////////////////////////////////////////////////
// Customizer - Add CSS
//////////////////////////////////////////////////////////////////
function adamos_customizer_css() {
$styleOption = get_theme_mod( 'adamos_color_scheme');

if( $styleOption != 'Default'):
?>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/<?php echo strtolower( get_theme_mod( 'adamos_color_scheme', 'black' ) ); ?>.css" type="text/css" media="screen">

<?php 
endif;

	if( get_theme_mod('background_color') ){
?>
		<style>
			#wrap{
				background-color: #<?php echo get_theme_mod( 'background_color' ); ?>;
			}
		</style>
<?php 
	} 

}
add_action( 'wp_head', 'adamos_customizer_css' ); 