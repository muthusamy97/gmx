<?php
/**
 * Springy Promo Unique
 * @since Springy 1.0.0
 *
 * @param null
 * @return void
 *
 */
global $springy_theme_options;
$promo_cat = absint($springy_theme_options['springy-promo-select-category']);

?>
<section class="springy-promo-section">
    <div class="container">
        <div class="promo-section promo-three">
            <?php
            $args = array(
                'cat' => $promo_cat ,
                'posts_per_page' => 3,
                'order'=> 'DESC'
            );
            
            $query = new WP_Query($args);
            
            if($query->have_posts()):                        
                while($query->have_posts()):
                    $query->the_post();
                    ?>                            
                    <div class="item">
                        <div class="post-wrap">
                            <div class="post-media-part">
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    
                                    if(has_post_thumbnail())
                                    {
                                        
                                        $image_id  = get_post_thumbnail_id();
                                        $image_url = wp_get_attachment_image_src($image_id,'springy-promo-post',true);
                                        ?>
                                        
                                        <div class="post-media">
                                            <img src="<?php echo esc_url($image_url[0]);?>">
                                        </div>
                                    <?php   } ?>
                                </a>
                            </div>
                            <div class="post-meta-info">
                                <div class="meta-wrapper">
                                    <div class="meta-categories">
                                        <div class="post-cats">
                                                <?php
                                                $categories = get_the_category();
                                                if ( ! empty( $categories ) ) {
                                                  echo '<a class="s-cat" href="'.esc_url( get_category_link( $categories[0]->term_id ) ).'" title="Lifestyle">'.esc_html( $categories[0]->name ).'</a>';
                                              }                                 
                                              ?>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <div class="promo-content">    
                                <h3 class="post-title entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <!-- .entry-content end -->
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
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; endif; wp_reset_postdata(); ?>
                </div>
            </div>
</section>
