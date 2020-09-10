<?php
/**
 * Default theme options.
 *
 * @package Creativ University
 */

if ( ! function_exists( 'creativ_university_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function creativ_university_get_default_theme_options() {

	$defaults = array();

	// Top Bar
	$defaults['show_header_contact_info'] 		= false;
    $defaults['show_header_social_links'] 		= false;
    $defaults['header_social_links']			= array();

    // Homepage Options
	$defaults['enable_frontpage_content'] 		= false;

	// Featured Slider Section
	$defaults['enable_featured_slider']			= false;
	$defaults['number_of_slider_items']			= 3;
	$defaults['slider_content_type']			= 'slider_page';

	// Our Services Section
	$defaults['enable_our_services_section']	= false;
	$defaults['our_services_section_title']		= esc_html__( 'Why Choose Us', 'creativ-university' );
	$defaults['number_of_items']				= 4;
	$defaults['services_content_type']			= 'services_page';

	//Our Courses Section	
	$defaults['enable_our_courses_section']		= false;
	$defaults['our_courses_section_title']		= esc_html__( 'Our Departments', 'creativ-university' );
	$defaults['number_of_cs_items']				= 4;
	$defaults['cs_content_type']				= 'cs_page';

	// Our Team Section
	$defaults['enable_team_section']			= false;
	$defaults['team_section_title']				= esc_html__( 'Expert Teacher', 'creativ-university' );
	$defaults['number_of_ts_items']				= 4;
	$defaults['ts_content_type']				= 'ts_page';

	//Call To Action Section	
	$defaults['enable_cta_section']	   			= false;
	$defaults['cta_title']	   	 				= esc_html__( 'Are You Ready To Know Our University', 'creativ-university' );
	$defaults['cta_button_label']	   	 		= esc_html__( 'Get In Touch', 'creativ-university' );
	$defaults['cta_button_url']	   	 			= '#';

	// Blog Section
	$defaults['enable_blog_section']			= false;
	$defaults['blog_section_title']				= esc_html__( 'Education News', 'creativ-university' );
	$defaults['blog_category']	   				= 0; 
	$defaults['blog_number']					= 3;	

	//General Section
	$defaults['readmore_text']					= esc_html__('Read More','creativ-university');
	$defaults['your_latest_posts_title']		= esc_html__('Blog','creativ-university');
	$defaults['excerpt_length']					= 15;
	$defaults['layout_options_blog']			= 'right-sidebar';
	$defaults['layout_options_archive']			= 'right-sidebar';
	$defaults['layout_options_page']			= 'right-sidebar';	
	$defaults['layout_options_single']			= 'right-sidebar';	

	//Footer section 		
	$defaults['copyright_text']					= esc_html__( 'Copyright &copy; All rights reserved.', 'creativ-university' );

	// Pass through filter.
	$defaults = apply_filters( 'creativ_university_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'creativ_university_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function creativ_university_get_option( $key ) {

		$default_options = creativ_university_get_default_theme_options();
		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;