<?php
/**
 * Welcome screen intro template
 */
?>
<?php
$adamos = wp_get_theme( 'adamos' );

?>
<div class="col two-col" style="margin-bottom: 1.618em; overflow: hidden;">
	<div class="col">
		<h1 style="margin-right: 0;"><?php echo '<strong>Adamos</strong> <sup style="font-weight: bold; font-size: 50%; padding: 5px 10px; color: #666; background: #fff;">' . esc_attr( $adamos['Version'] ) . '</sup>'; ?></h1>
		<p style="font-size: 1.2em;"><?php _e( 'Excellent! You\'ve activated <strong>Adamos</strong>, we hope you enjoy this free portfolio theme.', 'adamos' ); ?></p>
		<p><?php _e( 'This page will help you get up and running quickly with <strong>Adamos</strong>. Please use the <a href="https://wordpress.org/support/theme/adamos">Wordpress Support Forums</a> if you have experience issues with this theme.', 'adamos' ); ?></p>
	</div>

	<div class="col last-feature">
		<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" alt="adamos" class="image-50" width="440" />
	</div>
</div>
