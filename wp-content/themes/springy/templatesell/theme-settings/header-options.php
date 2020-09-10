<?php
/*Footer Options*/
$wp_customize->add_section('springy_header_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Header Settings', 'springy'),
    'panel' => 'springy_panel',
));

/*Make Primary Menu Transparent or not*/
$wp_customize->add_setting( 'springy_options[springy_primary_menu_transparent]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy_primary_menu_transparent'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
) );

$wp_customize->add_control( 'springy_options[springy_primary_menu_transparent]', array(
    'label'     => __( 'Enable Transparent Menu', 'springy' ),
    'description' => __('This option will help to make the menu transparent or not.', 'springy'),
    'section'   => 'springy_header_section',
    'settings'  => 'springy_options[springy_primary_menu_transparent]',
    'type'      => 'checkbox',
    'priority'  => 5,

) );


/*Header Search Enable Option*/
$wp_customize->add_setting( 'springy_options[springy_enable_search]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy_enable_search'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
) );

$wp_customize->add_control( 'springy_options[springy_enable_search]', array(
    'label'     => __( 'Enable Search', 'springy' ),
    'description' => __('It will help to display the search in Menu.', 'springy'),
    'section'   => 'springy_header_section',
    'settings'  => 'springy_options[springy_enable_search]',
    'type'      => 'checkbox',
    'priority'  => 5,

) );

/*Header Image Text Above*/
$wp_customize->add_setting( 'springy_options[springy_header_image_text]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy_header_image_text'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'springy_options[springy_header_image_text]', array(
    'label'     => __( 'Header Text', 'springy' ),
    'description' => __('If header image is used, this text will appear above it.', 'springy'),
    'section'   => 'header_image',
    'settings'  => 'springy_options[springy_header_image_text]',
    'type'      => 'text',
    'priority'  => 25,

) );

/*Header Image Text Sub heading*/
$wp_customize->add_setting( 'springy_options[springy_header_image_sub_heading]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy_header_image_sub_heading'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'springy_options[springy_header_image_sub_heading]', array(
    'label'     => __( 'Header SubText', 'springy' ),
    'description' => __('If header image is used, this text will appear above it.', 'springy'),
    'section'   => 'header_image',
    'settings'  => 'springy_options[springy_header_image_sub_heading]',
    'type'      => 'text',
    'priority'  => 25,

) );

/*Header Image Button Above*/
$wp_customize->add_setting( 'springy_options[springy_header_image_button_text]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy_header_image_button_text'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'springy_options[springy_header_image_button_text]', array(
    'label'     => __( 'Header Button Text', 'springy' ),
    'description' => __('Enter the text for the button.', 'springy'),
    'section'   => 'header_image',
    'settings'  => 'springy_options[springy_header_image_button_text]',
    'type'      => 'text',
    'priority'  => 25,

) );

/*Header Image Button Link */
$wp_customize->add_setting( 'springy_options[springy_header_image_button_link]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy_header_image_button_link'],
    'sanitize_callback' => 'esc_url_raw'
) );

$wp_customize->add_control( 'springy_options[springy_header_image_button_link]', array(
    'label'     => __( 'Header Button Link', 'springy' ),
    'description' => __('Enter the Link for the button.', 'springy'),
    'section'   => 'header_image',
    'settings'  => 'springy_options[springy_header_image_button_link]',
    'type'      => 'url',
    'priority'  => 25,

) );