<?php
/**
 * Team options.
 *
 * @package Creativ University
 */

$default = creativ_university_get_default_theme_options();

// Featured team Section
$wp_customize->add_section( 'section_home_team',
	array(
		'title'      => __( 'Expert Teacher', 'creativ-university' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

// Disable Team Section
$wp_customize->add_setting('theme_options[enable_team_section]', 
	array(
	'default' 			=> $default['enable_team_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'creativ_university_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_team_section]', 
	array(		
	'label' 	=> __('Enable Expert Teacher Section', 'creativ-university'),
	'section' 	=> 'section_home_team',
	'settings'  => 'theme_options[enable_team_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[team_section_title]', 
	array(
	'default'           => $default['team_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[team_section_title]', 
	array(
	'label'       => __('Section Title', 'creativ-university'),
	'section'     => 'section_home_team',   
	'settings'    => 'theme_options[team_section_title]',	
	'active_callback' => 'creativ_university_team_active',		
	'type'        => 'text'
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_ts_items]', 
	array(
	'default' 			=> $default['number_of_ts_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'creativ_university_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_ts_items]', 
	array(
	'label'       => __('Number Of Teams', 'creativ-university'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 4.', 'creativ-university'),
	'section'     => 'section_home_team',   
	'settings'    => 'theme_options[number_of_ts_items]',		
	'type'        => 'number',
	'active_callback' => 'creativ_university_team_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 4,
			'step'	=> 1,
		),
	)
);


// Content Type
$wp_customize->add_setting('theme_options[ts_content_type]', 
	array(
	'default' 			=> $default['ts_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'creativ_university_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[ts_content_type]', 
	array(
	'label'       => __('Content Type', 'creativ-university'),
	'section'     => 'section_home_team',   
	'settings'    => 'theme_options[ts_content_type]',		
	'type'        => 'select',
	'active_callback' => 'creativ_university_team_active',
	'choices'	  => array(
			'ts_page'	  => __('Page','creativ-university'),
			'ts_post'	  => __('Post','creativ-university'),
		),
	)
);

$number_of_ts_items = creativ_university_get_option( 'number_of_ts_items' );

for( $i=1; $i<=$number_of_ts_items; $i++ ){

	// Additional Information First Page
	$wp_customize->add_setting('theme_options[team_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'creativ_university_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[team_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'creativ-university'), $i),
		'section'     => 'section_home_team',   
		'settings'    => 'theme_options[team_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'creativ_university_team_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[team_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'creativ_university_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[team_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'creativ-university'), $i),
		'section'     => 'section_home_team',   
		'settings'    => 'theme_options[team_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => creativ_university_dropdown_posts(),
		'active_callback' => 'creativ_university_team_post',
		)
	);
}
