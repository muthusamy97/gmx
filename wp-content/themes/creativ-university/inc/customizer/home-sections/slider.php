<?php
/**
 * Featured Slider options.
 *
 * @package Creativ University
 */

$default = creativ_university_get_default_theme_options();

// Featured Slider Section
$wp_customize->add_section( 'section_featured_slider',
	array(
		'title'      => __( 'Featured Slider', 'creativ-university' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

// Enable Featured Slider Section
$wp_customize->add_setting('theme_options[enable_featured_slider]', 
	array(
	'default' 			=> $default['enable_featured_slider'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'creativ_university_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_featured_slider]', 
	array(		
	'label' 	=> __('Enable Featured Slider Section', 'creativ-university'),
	'section' 	=> 'section_featured_slider',
	'settings'  => 'theme_options[enable_featured_slider]',
	'type' 		=> 'checkbox',	
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_slider_items]', 
	array(
	'default' 			=> $default['number_of_slider_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'creativ_university_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_slider_items]', 
	array(
	'label'       => __('Number Of Slides', 'creativ-university'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 3.', 'creativ-university'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[number_of_slider_items]',		
	'type'        => 'number',
	'active_callback' => 'creativ_university_slider_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 3,
			'step'	=> 1,
		),
	)
);

// Content Type
$wp_customize->add_setting('theme_options[slider_content_type]', 
	array(
	'default' 			=> $default['slider_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'creativ_university_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[slider_content_type]', 
	array(
	'label'       => __('Content Type', 'creativ-university'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[slider_content_type]',		
	'type'        => 'select',
	'active_callback' => 'creativ_university_slider_active',
	'choices'	  => array(
			'slider_page'	  => __('Page','creativ-university'),
			'slider_post'	  => __('Post','creativ-university'),
		),
	)
);

$number_of_slider_items = creativ_university_get_option( 'number_of_slider_items' );

for( $i=1; $i<=$number_of_slider_items; $i++ ){

	// Page
	$wp_customize->add_setting('theme_options[slider_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'creativ_university_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[slider_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'creativ-university'), $i),
		'section'     => 'section_featured_slider',   
		'settings'    => 'theme_options[slider_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'creativ_university_slider_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[slider_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'creativ_university_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[slider_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'creativ-university'), $i),
		'section'     => 'section_featured_slider',   
		'settings'    => 'theme_options[slider_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => creativ_university_dropdown_posts(),
		'active_callback' => 'creativ_university_slider_post',
		)
	);
}