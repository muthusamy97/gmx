<?php
/**
 * Remove ... From Excerpt
 *
 * @since 1.0.0
 */
if (!function_exists('springy_excerpt_more')) :
    function springy_excerpt_more($more)
    {
        if (!is_admin()) {
            return '';
        }
    }
endif;
add_filter('excerpt_more', 'springy_excerpt_more');

/**
 * Filter to change excerpt lenght size
 *
 * @since 1.0.0
 */
if (!function_exists('springy_alter_excerpt')) :
    function springy_alter_excerpt($length)
    {
        if (is_admin()) {
            return $length;
        }
        global $springy_theme_options;
        $excerpt_length = absint($springy_theme_options['springy-excerpt-length']);
        if (!empty($excerpt_length)) {
            return $excerpt_length;
        }
        return 50;
    }
endif;
add_filter('excerpt_length', 'springy_alter_excerpt');
