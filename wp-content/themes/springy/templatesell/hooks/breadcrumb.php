<?php
/**
 * Functions to manage breadcrumbs
 */
if (!function_exists('springy_breadcrumb_options')) :
    function springy_breadcrumb_options()
    {
        global $springy_theme_options;
        if (1 == $springy_theme_options['springy-extra-breadcrumb']) {
            springy_breadcrumbs();
        }
    }
endif;
add_action('springy_breadcrumb_options_hook', 'springy_breadcrumb_options');

/**
 * BreadCrumb Settings
 */
if (!function_exists('springy_breadcrumbs')):
    function springy_breadcrumbs()
    {
        if (!function_exists('springy_breadcrumb_trail')) {
            require get_template_directory() . '/templatesell/breadcrumbs/breadcrumbs.php';
        }
        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false
        );        
        springy_breadcrumb_trail($breadcrumb_args);
    }
endif;
add_action('springy_breadcrumbs_hook', 'springy_breadcrumbs');