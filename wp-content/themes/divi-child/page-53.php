<!--general test page-->
<?php get_header(); ?>

<div id="main" class="main">
<div class="container">
<section id="content" class="rs_content">
<?php echo do_shortcode('[recent-posts]'); ?>
<?php print_r(do_shortcode('[countries]')); ?>
</section>
    
<div class="clear"></div>
</div>
</div>

<?php get_footer(); ?>