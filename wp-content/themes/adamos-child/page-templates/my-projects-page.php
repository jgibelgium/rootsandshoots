<?php

/*
 * Template Name: R&S My Projects template
*/

get_header(); ?>
<div id="primary_home" class="content-area">
<div id="content" class="fullwidth" role="main">
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content', 'page' ); ?>
<?php comments_template( '', true );?>
<?php 
do_action('rs_my_projects_hook');
?>
<?php endwhile; // end of the loop. ?>
</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
