<?php
/**
 * Dynamic css
 *
 * @since Springy 1.0.0
 *
 * @param null
 * @return null
 *
 */
if (!function_exists('springy_dynamic_css')) :

    function springy_dynamic_css()
    {
        global $springy_theme_options;

        /* Color Options Options */
        $springy_primary_color  = esc_attr($springy_theme_options['springy_primary_color']);
        $springy_slider_overlay  = esc_attr($springy_theme_options['springy_slider_overlay_color']);
        $springy_slider_transparent  = esc_attr($springy_theme_options['springy_slider_overlay_transparent']);

        $custom_css = '';

        //Primary  Background 
        if (!empty($springy_primary_color)) {
            $custom_css .= "
            #toTop,
            .mega_ts_menu .scroll-background,
            a.effect:before,
            .show-more,
            a.link-format,
            .tabs-nav li:before,
            .post-slider-section .s-cat,
            .sidebar-3 .widget-title:after,
            .bottom-caption .slick-current .slider-items span,
            aarticle.format-status .post-content .post-format::after,
            article.format-chat .post-content .post-format::after, 
            article.format-link .post-content .post-format::after,
            article.format-standard .post-content .post-format::after, 
            article.format-image .post-content .post-format::after, 
            article.hentry.sticky .post-content .post-format::after, 
            article.format-video .post-content .post-format::after, 
            article.format-gallery .post-content .post-format::after, 
            article.format-audio .post-content .post-format::after, 
            article.format-quote .post-content .post-format::after{ 
                background-color: ". $springy_primary_color."; 
                border-color: ".$springy_primary_color.";
            }";

        }

        //Primary Color
        if (!empty($springy_primary_color)) {
            $custom_css .= "
            .feature-item i,
            .head-content a:hover, 
            .head-content a:focus, 
            .head-content a:active,
            .main-header a:hover, 
            .main-header a:focus, 
            .main-header a:active,
            .top-menu > ul > li > a:hover,
            .main-menu ul li.current-menu-item > a, 
            .header-2 .main-menu > ul > li.current-menu-item > a,
            .main-menu ul li:hover > a,
            .post-navigation .nav-links a:hover, 
            .post-navigation .nav-links a:focus,
            .tabs-nav li.tab-active a, 
            .tabs-nav li.tab-active,
            .tabs-nav li.tab-active a, 
            .tabs-nav li.tab-active,
            ul.trail-items li a:hover span,
            .author-socials a:hover,
            .post-date a:focus, 
            .post-date a:hover,
            .post-excerpt a:hover, 
            .post-excerpt a:focus, 
            .content a:hover, 
            .content a:focus,
            .post-footer > span a:hover, 
            .post-footer > span a:focus,
            .widget a:hover, 
            .widget a:focus,
            .footer-menu li a:hover, 
            .footer-menu li a:focus,
            .footer-social-links a:hover,
            .footer-social-links a:focus,
            .site-footer a:hover, 
            .site-footer a:focus{ 
                color : ". $springy_primary_color."; 
            }";
        }

        //Slider Overlay
        if (!empty($springy_slider_overlay)) {
            $custom_css .= "
            .slider-overlay { 
                background-color : ". $springy_slider_overlay."; 
            }";
        }

        //Slider Tranparent
        if (!empty($springy_slider_transparent)) {
            $custom_css .= "
            .slider-overlay { 
                opacity : ". $springy_slider_transparent."; 
            }";
        }
        //Slider Tranparent
        if (!empty($springy_primary_color)) {
            $custom_css .= "
            .head-content a:hover { 
                border-color : ". $springy_primary_color."; 
            }";
        }


        wp_add_inline_style('springy-style', $custom_css);
    }
endif;
add_action('wp_enqueue_scripts', 'springy_dynamic_css', 99);