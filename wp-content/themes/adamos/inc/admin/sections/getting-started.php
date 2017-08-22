<?php
/**
 * Welcome screen getting started template
 */
?>
<?php
// get theme customizer url
$url 	= admin_url() . 'customize.php?';
$url 	.= '&return=' . urlencode( admin_url() . 'themes.php?page=adamos-welcome' );
$url 	.= '&adamos-customizer=true';
?>
<div id="getting_started" class="col two-col panel" style="margin-bottom: 1.618em; padding-top: 1.618em; overflow: hidden;">

	<h2><?php echo sprintf( esc_html__( '%sAdamos%s works for you', 'adamos' ), '<strong>', '</strong>'); ?></h2>
	<p class="tagline"><?php _e( 'We\'ve made this theme simple and enjoyable to configure.', 'adamos' ); ?></p>

	<div class="col-1">

		<!-- DOCUMENTATION -->
		<h4><?php _e( 'View documentation <span class="dashicons dashicons-welcome-learn-more"></span>', 'adamos' ); ?></h4>
		<p><?php _e( 'You can read detailed information on Adamos\'s features and how to develop on top of it in the documentation.', 'adamos' ); ?></p>
		<p><?php echo sprintf( esc_html('%sView documentation%s', 'adamos'), '<a target="_blank" href="http://templateexpress.com/docs/adamos/" class="button button-primary">', '</a>'); ?></p>

		<!-- HOMEPAGE -->
		<div class="section homepage">
			<h4><?php _e( 'Setup the homepage <span class="dashicons dashicons-admin-home"></span>', 'adamos' ); ?></h4>
			<p><?php echo sprintf( esc_html__( 'Adamos includes a custom homepage template that can be seen in use on our %sdemo site%s', 'adamos' ), '<a target="_blank" href="' . esc_url('http://demos.templateexpress.com/adamos/') . '">', '</a>'); ?></p>
			<p><?php echo sprintf( esc_html__( 'Create a new page and assign the %sCustom Home Page%s Template. Then set this new page as your Front page in the %sReading%s settings.', 'adamos'), '<strong>', '</strong>', '<a href="' . esc_url( self_admin_url( 'options-reading.php' ) ) . '">', '</a>'); ?></p>
			<p><?php echo sprintf( esc_html__( 'You can then customize the homepage sections through the %scustomize section%s.', 'adamos'),  '<a href="' . esc_url( self_admin_url( 'customize.php' ) ) . '">', '</a>'); ?></p>
			<p><a href="<?php echo esc_url( $url ); ?>" class="button"><?php _e( 'Open the Customizer', 'adamos' ); ?></a></p>
		</div>

	</div>

	<div class="col-2 last-feature">
		<!-- CUSTOMIZER -->
		<h4><?php _e( 'Hundreds of options available <span class="dashicons dashicons-admin-generic"></span>' ,'adamos' ); ?></h4>
		<p><?php _e( 'Using the WordPress Customizer you can change Adamos\'s appearance to match your brand and create a unique look.', 'adamos' ); ?></p>
		<p><a href="<?php echo esc_url( $url ); ?>" class="button"><?php _e( 'Open the Customizer', 'adamos' ); ?></a></p>

		<!-- MENUS -->
		<h4><?php _e( 'Configure menu location <span class="dashicons dashicons-menu"></span>' ,'adamos' ); ?></h4>
		<p><?php _e( 'Adamos includes the ability to customize your menu structure. Add pages, custom links, categories to your menu then assign it to the Primary Menu Location.', 'adamos' ); ?></p>
		<p><a href="<?php echo esc_url( self_admin_url( 'nav-menus.php' ) ); ?>" class="button"><?php _e( 'Configure menus', 'adamos' ); ?></a></p>

	</div>
</div>
