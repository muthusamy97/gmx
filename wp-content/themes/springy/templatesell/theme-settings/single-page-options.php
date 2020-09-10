<?php
/*Single Page Options*/
$wp_customize->add_section('springy_single_page_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Single Page Settings', 'springy'),
    'panel' => 'springy_panel',
));


/*Title For Single Page*/
$wp_customize->add_setting('springy_options[springy-single-page-blog-title]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-single-page-blog-title'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-single-page-blog-title]', array(
    'label' => __('Enter the title for the single page', 'springy'),
    'description' => __('This title will come on all the single pages.', 'springy'),
    'section' => 'springy_single_page_section',
    'settings' => 'springy_options[springy-single-page-blog-title]',
    'type' => 'text',
    'priority' => 15,
));

/*banner image single page*/
$wp_customize->add_setting( 'springy_options[springy_single_page_banner_image]', array(
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'esc_url_raw'
) );

$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'springy_options[springy_single_page_banner_image]',
        array(
            'label'     => __( 'Single Page Banner Image', 'springy' ),
            'description' => __('This banner image will appear on all the single post at the top.', 'springy'),
            'section'   => 'springy_single_page_section',
            'settings'  => 'springy_options[springy_single_page_banner_image]',
            'priority'  => 15,
            'description' => __( 'Recommended image size of 1920*500', 'springy' ),
        )
    )
);

/*Featured Image Option*/
$wp_customize->add_setting('springy_options[springy-single-page-featured-image]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-single-page-featured-image'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
));

$wp_customize->add_control('springy_options[springy-single-page-featured-image]', array(
    'label' => __('Enable Featured Image on Single Posts', 'springy'),
    'description' => __('You can hide images on single post from here.', 'springy'),
    'section' => 'springy_single_page_section',
    'settings' => 'springy_options[springy-single-page-featured-image]',
    'type' => 'checkbox',
    'priority' => 15,
));

/*Single Page Sidebar Layout*/
$wp_customize->add_setting('springy_options[springy-sidebar-single-page]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-sidebar-single-page'],
    'sanitize_callback' => 'springy_sanitize_select'
));

$wp_customize->add_control( 
    new Springy_Radio_Image_Control(
        $wp_customize,
    'springy_options[springy-sidebar-single-page]', array(
    'choices' => springy_sidebar_position_array(),
    'label' => __('Select Sidebar', 'springy'),
    'description' => __('From Appearance > Customize > Widgets and add the widgets on the respected widget areas.', 'springy'),
    'section' => 'springy_single_page_section',
    'settings' => 'springy_options[springy-sidebar-single-page]',
    'type' => 'select',
    'priority' => 15,
)));

/*Related Post Options*/
$wp_customize->add_setting('springy_options[springy-single-page-related-posts]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-single-page-related-posts'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
));

$wp_customize->add_control('springy_options[springy-single-page-related-posts]', array(
    'label' => __('Related Posts', 'springy'),
    'description' => __('2 posts of same category will appear.', 'springy'),
    'section' => 'springy_single_page_section',
    'settings' => 'springy_options[springy-single-page-related-posts]',
    'type' => 'checkbox',
    'priority' => 15,
));


/*callback functions related posts*/
if (!function_exists('springy_related_post_callback')) :
    function springy_related_post_callback()
    {
        global $springy_theme_options;
        $related_posts = absint($springy_theme_options['springy-single-page-related-posts']);
        if (1 == $related_posts) {
            return true;
        } else {
            return false;
        }
    }
endif;

/*Related Post Title*/
$wp_customize->add_setting('springy_options[springy-single-page-related-posts-title]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-single-page-related-posts-title'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-single-page-related-posts-title]', array(
    'label' => __('Related Posts Title', 'springy'),
    'description' => __('Enter the suitable title.', 'springy'),
    'section' => 'springy_single_page_section',
    'settings' => 'springy_options[springy-single-page-related-posts-title]',
    'type' => 'text',
    'priority' => 15,
    'active_callback' => 'springy_related_post_callback'
));

/*Social Share Options*/
$wp_customize->add_setting('springy_options[springy-single-social-share]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-single-social-share'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
));

$wp_customize->add_control('springy_options[springy-single-social-share]', array(
    'label' => __('Social Sharing', 'springy'),
    'description' => __('Enable Social Sharing on Single Posts.', 'springy'),
    'section' => 'springy_single_page_section',
    'settings' => 'springy_options[springy-single-social-share]',
    'type' => 'checkbox',
    'priority' => 15,
));
