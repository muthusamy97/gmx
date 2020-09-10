<?php
/**
 * Social Sharing Hook *
 * @since 1.0.0
 *
 * @param int $post_id
 * @return void
 *
 */
if (!function_exists('springy_social_sharing')) :
    function springy_social_sharing($post_id)
    {
        $springy_url = get_the_permalink($post_id);
        $springy_title = get_the_title($post_id);
        $springy_image = get_the_post_thumbnail_url($post_id);
        
        //sharing url
        $springy_twitter_sharing_url = esc_url('http://twitter.com/share?text=' . $springy_title . '&url=' . $springy_url);
        $springy_facebook_sharing_url = esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $springy_url);
        $springy_pinterest_sharing_url = esc_url('http://pinterest.com/pin/create/button/?url=' . $springy_url . '&media=' . $springy_image . '&description=' . $springy_title);
        $springy_linkedin_sharing_url = esc_url('http://www.linkedin.com/shareArticle?mini=true&title=' . $springy_title . '&url=' . $springy_url);
        
        ?>
        <div class="meta-bottom">
            <a href="#"></a>
            <div class="post-share-wrapper">
                <div class="post-share">
                <a class="share-facebook" target="_blank" href="<?php echo $springy_facebook_sharing_url; ?>">
                    <i class="fa fa-facebook"></i>
                    <span><?php _e('Facebook','springy');?></span>
                </a>
                <a class="share-twitter" target="_blank" href="<?php echo $springy_twitter_sharing_url; ?>">
                    <i class="fa fa-twitter"></i>
                    <span><?php _e('Twitter','springy');?></span>
                </a>
                <a class="share-pinterest" target="_blank" href="<?php echo $springy_pinterest_sharing_url; ?>">
                    <i class="fa fa-pinterest"></i>
                    <span><?php _e('Pinterest','springy');?></span>
                </a>
                <a class="share-linkedin" target="_blank" href="<?php echo $springy_linkedin_sharing_url; ?>">
                    <i class="fa fa-linkedin"></i>
                    <span><?php _e('Linkedin','springy');?></span>
                </a>
            </div>
            </div>
        </div>
        <?php
    }
endif;
add_action('springy_social_sharing', 'springy_social_sharing', 10);