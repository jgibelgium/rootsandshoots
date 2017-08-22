<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package adamos
 * @since adamos 2.0
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

<?php if(get_theme_mod('adamos_global_favicon')) : ?>
    <link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod('adamos_global_favicon')); ?>" />
<?php endif; ?>

<?php if(get_theme_mod('adamos_global_apple_icon')) : ?>
    <link rel="apple-touch-icon" href="<?php echo esc_url(get_theme_mod('adamos_global_apple_icon')); ?>">
<?php endif; ?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrap">
<div id="page" class="hfeed site">

	<?php do_action( 'before' ); ?>
    
        <?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
    
    <div id="masthead-wrap">

        <?php if( get_theme_mod('adamos_show_topbar')): ?>
            <div class="topbar">
                <div class="topbar-wrap">
                    <div class="contact-info">
                        <?php get_template_part( 'inc/contact-details' ); ?>
                    </div>
                    <div class="social-media">
                        <?php get_template_part( 'inc/socmed' ); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <header id="masthead" class="site-header header_container" role="banner">

            <?php if ( get_theme_mod( 'adamos_logo' ) ) : ?>

                <div class="site-logo">

                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_theme_mod( 'adamos_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>

                </div>

            <?php else : ?>

                <div class="site-introduction">

                    <h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <p class="site-description"><?php bloginfo( 'description' ); ?></p> 

                </div>

            <?php endif; ?>

            <nav role="navigation" class="site-navigation main-navigation">

                <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

            </nav><!-- .site-navigation .main-navigation -->

        </header><!-- #masthead .site-header -->


	</div><!-- #masthead-wrap -->

    <?php 
        $header_image = get_header_image();
        if ( ! empty( $header_image ) ) : ?>

            <div class="header-image">
    			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
    				<img src="<?php header_image(); ?>"/>
    			</a>
        	</div>

    <?php 
        endif; 
    ?>


    <?php if(is_front_page()):?>

        <?php if(! get_theme_mod('homepage_slider_hide')): ?>

            <?php

              $featured_cat   =   get_theme_mod( 'homepage_slider_cat' );
              $number         =   get_theme_mod( 'homepage_slider_slide_no' );

              $the_query     =   new WP_Query( array( 
                'cat'             => $featured_cat, 
                'posts_per_page'  => $number,
                'meta_query'      => array(
                    array(
                      'key'           => '_thumbnail_id',
                      'compare'       => 'EXISTS',
                    ),
                ), 
              ));
              
            ?>
                
            <div class="flex-container">
              <div class="flexslider">
                <ul class="slides">
                  <?php  while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
                    <li>
                      <?php the_post_thumbnail(); ?>
                      <div class="caption_wrap">
                        <div class="flex-caption">
                          <div class="flex-caption-title">
                            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                          </div>
                          <p><?php echo esc_html(adamos_get_slider_excerpt()); ?> <a href="<?php the_permalink() ?>">...</a></p>
                        </div>
                      </div>
                    </li>
                  <?php endwhile; ?>
                </ul>
              </div>
            </div>

        <?php endif; ?><!-- End Flexslider -->



        <?php if(! get_theme_mod('homepage_promotional_bool')): ?>

            <div class="featuretext_top">

                <h3><?php if( get_theme_mod( 'featured_textbox' ) ){ echo esc_html(get_theme_mod( 'featured_textbox' ) ); } else { _e( 'Promotional Bar', 'adamos' ); } ?></h3>
                
                <?php if ( get_theme_mod( 'featured_button_url' ) ) : ?>
                  <p><a href="<?php echo esc_url( get_theme_mod( 'featured_button_url' ) ); ?>" ><?php echo esc_attr(get_theme_mod( 'featured_button_txt' )); ?></a></p>
                <?php endif; ?>

            </div>

        <?php endif; ?><!-- End Promo Bar -->

    <?php endif; ?>


	<div id="main" class="site-main">