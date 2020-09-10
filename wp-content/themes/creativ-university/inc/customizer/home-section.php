<?php
/**
 * Home Page Options.
 *
 * @package Creativ University
 */

$default = creativ_university_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'home_page_panel',
	array(
	'title'      => __( 'Front Page Sections', 'creativ-university' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

/**
* Section Customizer Options.
*/
require get_template_directory() . '/inc/customizer/home-sections/slider.php';
require get_template_directory() . '/inc/customizer/home-sections/our-services.php';
require get_template_directory() . '/inc/customizer/home-sections/our-courses.php';
require get_template_directory() . '/inc/customizer/home-sections/team.php';
require get_template_directory() . '/inc/customizer/home-sections/cta.php';
require get_template_directory() . '/inc/customizer/home-sections/blog.php';

