<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Springy
 */
global $springy_theme_options;
$social_share = absint($springy_theme_options['springy-single-social-share']);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-post-wrap">
        <div class="post-media-part">
            <div class="post-media">
                <?php springy_post_thumbnail(); ?>
            </div>
        </div>
        <div class="post-meta-info">
            <div class="meta-wrapper">
                <div class="meta-categories">
                    <div class="post-cats">
                        <?php springy_entry_meta(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="post-content">
            <?php
            if (is_singular()) :
                the_title('<h1 class="post-title entry-title">', '</h1>');
            else :
                the_title('<h2 class="post-title entry-title text-center"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                ?>
            <?php endif; ?>
            <div class="post-meta-desc">  
                <div class="post-meta">
                    <?php
                    if ('post' === get_post_type()) :
                        ?>
                        <div class="post-author">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
                            <?php springy_posted_by(); ?>
                        </div>
                        <div class="post-date">
                            <div class="entry-meta">
                                <span class="ti-calendar"></span><?php  springy_posted_on();  ?>
                            </div><!-- .entry-meta -->
                        </div>
                        <div class="reading-time">
                            <span class="ti-time"></span> <?php echo springy_reading_time(); ?>
                        </div>
                        <div class="comment-num">
                            <?php echo get_comments_number($post->ID);?> <span class="ti-comment"></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content post-excerpt entry-content clearfix <?php echo $drop_cap_class; ?>">
                <?php
                the_content(sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'springy'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                    
                ));
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'springy'),
                    'after' => '</div>',
                    
                ));
                ?>
            </div><!-- .entry-content -->
            <div class="single-post-info">
                <div class="tags">
                    <?php the_tags('', ''); ?>
                </div>
                <?php 
                if( 1 == $social_share ){
                    do_action( 'springy_social_sharing' ,get_the_ID() );
                }
                ?>
            </div>
        </div>
    </div>
    <div class="post-navigation-wrapper">
        <?php do_action('springy_action_previous_next_post_pagination'); ?>
    </div>
    <div class="related-posts clearfix">
        <?php do_action( 'springy_related_posts' ,get_the_ID() ); ?>
    </div>
</article>