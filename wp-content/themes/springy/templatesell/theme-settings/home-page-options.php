<?php 
/*Home Page*/
$wp_customize->add_section( 'springy_home_page', array(
   'priority'       => 20,
   'capability'     => 'edit_theme_options',
   'theme_supports' => '',
   'title'          => __( 'Home Page Settings', 'springy' ),
   'panel' 		 => 'springy_panel',
) );

/*Home Page Title*/
$wp_customize->add_setting( 'springy_options[springy-enable-home-title]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy-enable-home-title'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
) );

$wp_customize->add_control( 'springy_options[springy-enable-home-title]', array(
    'label'     => __( 'Enable Home Page Title', 'springy' ),
    'description' => __('This option will help to enable the home page title.', 'springy'),
    'section'   => 'springy_home_page',
    'settings'  => 'springy_options[springy-enable-home-title]',
    'type'      => 'checkbox',
    'priority'  => 15,
) );