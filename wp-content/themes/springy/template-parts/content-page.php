<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Springy
 */
global $springy_theme_options;
$image_option = absint($springy_theme_options['springy-single-page-featured-image']);
$social_share = absint($springy_theme_options['springy-single-social-share']);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-post-wrap">
        <div class="post-media-part">
            <div class="post-media">
                <?php
                if ($image_option == 1) {
                    springy_post_thumbnail();
                }
                ?>
            </div>
        </div>
        <div class="post-content">
            <div class="post-excerpt entry-content">
                <?php
                
                the_content();
                
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'springy'),
                    'after' => '</div>',
                ));
                ?>
                <!-- read more -->
                <?php if (!empty($read_more)): ?>
                    <a class="more-link" href="<?php the_permalink(); ?>"><?php echo esc_html($read_more); ?> <i
                                class="fa fa-long-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <!-- .entry-content end -->
            <div class="single-post-info">
                <?php 
                if( 1 == $social_share ){
                    do_action( 'springy_social_sharing' ,get_the_ID() );
                }
                ?>
            </div>
        </div>
    </div>
</article><!-- #post-->

