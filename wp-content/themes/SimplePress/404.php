<?php get_header(); ?>
    <div id="content">
        <div class="content_wrap">
            <div class="content_wrap">
                <div id="posts">
                    <h1 class="title"><?php esc_html_e('No Results Found','SimplePress'); ?></h1>
                    <br class="clear" />
                    <div class="post">

                        <div id="breadcrumbs">
                            <?php get_template_part('includes/breadcrumbs'); ?>
                        </div>
                        <br class="clear" />
                        <p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','SimplePress'); ?></p>

                    </div><!-- .post -->
                </div><!-- #posts -->
                <?php get_sidebar(); ?>
            </div><!-- .content_wrap -->
        </div><!-- .content_wrap -->
    </div><!-- #content -->
</div><!-- .wrapper -->
<?php get_footer(); ?>