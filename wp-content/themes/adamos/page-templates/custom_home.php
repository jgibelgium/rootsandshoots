<?php
/*
 * Template Name: Custom Home Page
 * Description: A home page with featured slider and widgets.
 *
 * @package adamos
 * @since adamos 1.0
 */

get_header(); ?>
        
  <div id="primary_home" class="content-area">
		
    <div id="content" class="fullwidth" role="main">
  

      <?php if(! get_theme_mod('homepage_service_bool')): ?>

        <div class="section group">
          <div class="featuretext_middle animated" data-fx="fadeInUp">
            
            <?php if(! get_theme_mod('homepage_service_title_bool')): ?>
              <h3><?php if(get_theme_mod('homepage_service_title')){ echo esc_html(get_theme_mod('homepage_service_title')); } else { _e('Services', 'adamos'); }?></h3>
            <?php endif; ?>

            <div class="unity-separator"></div>

            <div class="col span_1_of_3 box-1">        
              <div class="featuretext">
                <?php if ( get_theme_mod( 'header-one-file-upload' ) ) : ?>
                  <h3><a href="<?php echo esc_url( get_theme_mod( 'header_one_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-one-file-upload' ) ); ?>"  alt="feature one"></a></h3>
                <?php endif; ?>
                <h4><a href="<?php echo esc_url( get_theme_mod( 'header_one_url' ) ); ?>"><?php echo esc_html(get_theme_mod( 'featured_textbox_header_one' ) ); ?></a></h4>
                <p><?php echo esc_html(get_theme_mod( 'featured_textbox_text_one' ) ); ?></p>
              </div>
            </div>

            <div class="col span_1_of_3 box-2">         
              <div class="featuretext">
              <?php if ( get_theme_mod( 'header-two-file-upload' ) ) : ?>
                <h3><a href="<?php echo esc_url( get_theme_mod( 'header_two_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-two-file-upload' ) ); ?>"  alt="feature two"></a></h3>
              <?php endif; ?>
              <h4><a href="<?php echo esc_url( get_theme_mod( 'header_two_url' ) ); ?>"><?php echo esc_html(get_theme_mod( 'featured_textbox_header_two' ) ); ?></a></h4>
              <p><?php echo esc_html(get_theme_mod( 'featured_textbox_text_two' ) ); ?></p>
              </div>
            </div>

            <div class="col span_1_of_3 box-3">         
              <div class="featuretext">
              <?php if ( get_theme_mod( 'header-three-file-upload' ) ) : ?>
                <h3><a href="<?php echo esc_url( get_theme_mod( 'header_three_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-three-file-upload' ) ); ?>"  alt="feature three"></a></h3>
              <?php endif; ?>
              <h4><a href="<?php echo esc_url( get_theme_mod( 'header_three_url' ) ); ?>"><?php echo esc_html(get_theme_mod( 'featured_textbox_header_three' ) ); ?></a></h4>
              <p><?php echo esc_html(get_theme_mod( 'featured_textbox_text_three' ) ); ?></p>
              </div>
            </div>

        </div> 
      </div> 

    <?php endif; ?>

    <?php if(! get_theme_mod('homepage_recent_bool')): ?>

      <div class="section_thumbnails group">

        <h3><?php if(get_theme_mod('homepage_recent_title')){ echo esc_html(get_theme_mod('homepage_recent_title')); } else { _e('Recent Posts', 'adamos'); }?></h3>

        <?php 

          $recent_cat   =   get_theme_mod( 'homepage_recent_cat' );

          $the_query = new WP_Query(array(
            'cat'             => $recent_cat, 
            'showposts'       => 2,
            'post__not_in'    => get_option("sticky_posts"),
          ));

        ?>
      
        <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

          <div class="col span_1_of_2">
            <article class="recent">

              <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

              <?php
                if ( has_post_thumbnail() ) {
                  $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'featured' );
                  echo '<img alt="post" class="imagerct" src="' . $image_src[0] . '">';
                }
              ?>

              <?php echo adamos_content(50); ?><div class="thumbs-more-link"><a href="<?php the_permalink() ?>"> <?php echo __('More', 'adamos'); ?></a></div>

            </article>
          </div>	

        <?php endwhile; ?>

      </div>

    <?php endif; ?>

    
    </div><!-- #content .site-content -->

</div><!-- #primary .content-area -->

<?php get_footer(); ?>