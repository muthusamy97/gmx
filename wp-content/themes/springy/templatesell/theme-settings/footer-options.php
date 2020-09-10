<?php
/*Footer Options*/
$wp_customize->add_section('springy_footer_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Footer Settings', 'springy'),
    'panel' => 'springy_panel',
));


/*Copyright Setting*/
$wp_customize->add_setting('springy_options[springy-footer-copyright]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-footer-copyright'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-footer-copyright]', array(
    'label' => __('Copyright Text', 'springy'),
    'description' => __('Enter your own copyright text.', 'springy'),
    'section' => 'springy_footer_section',
    'settings' => 'springy_options[springy-footer-copyright]',
    'type' => 'text',
    'priority' => 15,
));
