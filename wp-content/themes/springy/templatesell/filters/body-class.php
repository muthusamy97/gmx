<?php
/**
 * Add sidebar class in body
 *
 * @since Springy 1.0.0
 *
 */

add_filter('body_class', 'springy_body_class');
function springy_body_class($classes)
{
    $classes[] = 'at-sticky-sidebar';
    global $springy_theme_options;
    
    if (is_singular()) {
        $sidebar = $springy_theme_options['springy-sidebar-single-page'];
        if ($sidebar == 'single-no-sidebar') {
            $classes[] = 'single-no-sidebar';
        } elseif ($sidebar == 'single-left-sidebar') {
            $classes[] = 'single-left-sidebar';
        } elseif ($sidebar == 'single-middle-column') {
            $classes[] = 'single-middle-column';
        } else {
            $classes[] = 'single-right-sidebar';
        }
    }
    
    $sidebar = $springy_theme_options['springy-sidebar-blog-page'];
    if ($sidebar == 'no-sidebar') {
        $classes[] = 'no-sidebar';
    } elseif ($sidebar == 'left-sidebar') {
        $classes[] = 'left-sidebar';
    } elseif ($sidebar == 'middle-column') {
        $classes[] = 'middle-column';
    } else {
        $classes[] = 'right-sidebar';
    }
    return $classes;
}

/**
 * Add layout class in body
 *
 * @since Springy 1.0.0
 *
 */

add_filter('body_class', 'springy_layout_body_class');
function springy_layout_body_class($classes)
{
    global $springy_theme_options;
    $layout = $springy_theme_options['springy-column-blog-page'];
    if ($layout == 'masonry-post') {
        $classes[] = 'masonry-post';
    } else {
        $classes[] = 'one-column';
    }    
    return $classes;
}