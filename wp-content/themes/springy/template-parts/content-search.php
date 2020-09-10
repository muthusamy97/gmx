<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Springy
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-wrap">
        <div class="post-content">
            <div class="post_title">
                <?php the_title(sprintf('<h2 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
            </div>
            <div class="post-excerpt entry-summary">
                <?php the_excerpt(); ?>
            </div>
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
        </div>
    </div>
</article>

