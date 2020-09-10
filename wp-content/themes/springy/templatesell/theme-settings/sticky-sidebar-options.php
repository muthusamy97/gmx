<?php 
/*Sticky Sidebar*/
$wp_customize->add_section( 'springy_sticky_sidebar', array(
   'priority'       => 20,
   'capability'     => 'edit_theme_options',
   'theme_supports' => '',
   'title'          => __( 'Sticky Sidebar Settings', 'springy' ),
   'panel' 		 => 'springy_panel',
) );

/*Sticky Sidebar Setting*/
$wp_customize->add_setting( 'springy_options[springy-enable-sticky-sidebar]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy-enable-sticky-sidebar'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
) );

$wp_customize->add_control( 'springy_options[springy-enable-sticky-sidebar]', array(
    'label'     => __( 'Enable Sticky Sidebar', 'springy' ),
    'description' => __('Enable and Disable sticky sidebar from this section.', 'springy'),
    'section'   => 'springy_sticky_sidebar',
    'settings'  => 'springy_options[springy-enable-sticky-sidebar]',
    'type'      => 'checkbox',
    'priority'  => 15,
) );