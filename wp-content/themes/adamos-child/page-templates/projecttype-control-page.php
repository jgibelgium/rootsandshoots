<?php
/*
 * Template Name: R$S Projecttype_control template
*/


get_header(); ?>

<div id="primary_home" class="content-area">
<div id="content" class="fullwidth" role="main">
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; // end of the loop. ?>
<?php do_action('projecttype_control_hook');?>
</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
