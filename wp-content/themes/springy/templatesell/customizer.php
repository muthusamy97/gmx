<?php
/**
 * Springy Theme Customizer
 *
 * @package Springy
 */

if ( !function_exists('springy_default_theme_options_values') ) :

    function springy_default_theme_options_values() {

        $default_theme_options = array(

          /*Header Options*/
            'springy_enable_search'  => 1,
            'springy_primary_menu_transparent'=> 1,
            'springy_header_image_text'=> '',
            'springy_header_image_sub_heading' => '',
            'springy_header_image_button_link'=> '#',
            'springy_header_image_button_text'=> esc_html__('Get Started','springy'),

            /*Home Page Options*/
            'springy-enable-home-title' => 0,

            /*Colors Options*/
            'springy_primary_color'              => '#d42929',

            /*Slider Options*/
            'springy_enable_slider'      => 0,
            'springy-select-slider-from'=>'from-page',
            'springy-select-category'    => 0,
            'springy-select-slider-from-page-one'=> 0,
            'springy-select-slider-from-page-two'=> 0,
            'springy-select-slider-from-page-three'=> 0,
            'springy_enable_slider_overlay'=> 0,
            'springy_slider_overlay_color'=> '#ffffff',
            'springy_slider_overlay_transparent'=> '0.3',
    
            /*Boxes Section */
            'springy_enable_promo'       => 0,
            'springy-promo-select-category'=> 0,
            'springy-select-boxes-from'=> 'from-customizer',
            'springy-promo-icon-class-one'=> 'ti-layout',
            'springy-promo-icon-class-two'=> 'ti-bar-chart',
            'springy-promo-icon-class-three'=> 'ti-support',
            'springy-promo-icon-text-one'=> esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','springy'),
            'springy-promo-icon-text-two'=> esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','springy'),
            'springy-promo-icon-text-three'=> esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.','springy'),
            'springy-promo-icon-title-one'=> esc_html__('Mount Everest ','springy'),
            'springy-promo-icon-title-two'=> esc_html__('Mount Annapurna','springy'),
            'springy-promo-icon-title-three'=> esc_html__('Mount Makalu','springy'),
            
            /*Blog Page*/
            'springy-sidebar-blog-page' => 'right-sidebar',
            'springy-column-blog-page'  => 'one-column',
            'springy-blog-image-layout' => 'full-image',
            'springy-content-show-from' => 'excerpt',
            'springy-excerpt-length'    => 25,
            'springy-pagination-options'=> 'numeric',
            'springy-read-more-text'    => '',
            'springy-show-hide-share'   => 1,

            /*Single Page */
            'springy-single-page-featured-image' => 1,
            'springy-single-page-related-posts'  => 0,
            'springy-single-page-related-posts-title' => esc_html__('Related Posts','springy'),
            'springy-sidebar-single-page'=> 'single-right-sidebar',
            'springy-single-social-share' => 1,
            'springy-single-page-blog-title' =>  esc_html__('Blog','springy'),
            'springy_single_page_banner_image'=> get_template_directory_uri()."/assets/images/page-banner.jpg",


            /*Sticky Sidebar*/
            'springy-enable-sticky-sidebar' => 1,

            /*Footer Section*/
            'springy-footer-copyright'  => esc_html__('Copyright All Rights Reserved 2020','springy'),

            /*Breadcrumb Options*/
            'springy-extra-breadcrumb' => 1,

        );
return apply_filters( 'springy_default_theme_options_values', $default_theme_options );
}
endif;
/**
 *  Springy Theme Options and Settings
 *
 * @since Springy 1.0.0
 *
 * @param null
 * @return array springy_get_options_value
 *
 */
if ( !function_exists('springy_get_options_value') ) :
    function springy_get_options_value() {
        $springy_default_theme_options_values = springy_default_theme_options_values();
        $springy_get_options_value = get_theme_mod( 'springy_options');
        if( is_array( $springy_get_options_value )){
            return array_merge( $springy_default_theme_options_values, $springy_get_options_value );
        }
        else{
            return $springy_default_theme_options_values;
        }
    }
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function springy_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
    if ( isset( $wp_customize->selective_refresh ) ) {
      $wp_customize->selective_refresh->add_partial( 'blogname', array(
         'selector'        => '.site-title a',
         'render_callback' => 'springy_customize_partial_blogname',
     ) );
      $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
         'selector'        => '.site-description',
         'render_callback' => 'springy_customize_partial_blogdescription',
     ) );
  }
  $default = springy_default_theme_options_values();

  require get_template_directory() . '/templatesell/theme-settings/theme-settings.php';
}
add_action( 'customize_register', 'springy_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function springy_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function springy_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function springy_customize_preview_js() {
	wp_enqueue_script( 'springy-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20200412', true );
}
add_action( 'customize_preview_init', 'springy_customize_preview_js' );

/*
** Customizer Styles
*/
function springy_panels_css() {
     wp_enqueue_style('springy-customizer-css', get_template_directory_uri() . '/css/customizer-style.css', array(), '4.5.0');
}
add_action( 'customize_controls_enqueue_scripts', 'springy_panels_css' );
