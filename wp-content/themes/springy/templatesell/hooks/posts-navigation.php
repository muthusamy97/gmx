<?php
/**
 * Post Navigation Function
 *
 * @since Springy 1.0.0
 *
 * @param null
 * @return void
 *
 */
if (!function_exists('springy_posts_navigation')) :
    function springy_posts_navigation()
    {
        global $springy_theme_options;
        $springy_pagination_option = $springy_theme_options['springy-pagination-options'];
        if ('numeric' == $springy_pagination_option) {
            echo "<div class='pagination'>";
             the_posts_pagination();
            echo "<div>";
        } elseif ('default' == $springy_pagination_option) {
           the_post_navigation();
        } else {
            return false;
        }
    }
endif;
add_action('springy_action_navigation', 'springy_posts_navigation', 10);