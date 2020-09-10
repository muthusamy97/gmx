<?php
/*Blog Page Options*/
$wp_customize->add_section('springy_blog_page_section', array(
    'priority' => 20,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Blog Settings', 'springy'),
    'panel' => 'springy_panel',
));
/*Blog Page Sidebar Layout*/

$wp_customize->add_setting('springy_options[springy-sidebar-blog-page]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-sidebar-blog-page'],
    'sanitize_callback' => 'springy_sanitize_select'
));

$wp_customize->add_control( new Springy_Radio_Image_Control(
        $wp_customize,
    'springy_options[springy-sidebar-blog-page]', array(
    'choices' => springy_blog_sidebar_position_array(),
    'label' => __('Blog and Archive Sidebar', 'springy'),
    'description' => __('This sidebar will work blog and archive pages.', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-sidebar-blog-page]',
    'type' => 'select',
    'priority' => 15,
)));


/*Blog Page column number*/
$wp_customize->add_setting('springy_options[springy-column-blog-page]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-column-blog-page'],
    'sanitize_callback' => 'springy_sanitize_select'
));

$wp_customize->add_control('springy_options[springy-column-blog-page]', array(
    'choices' => array(
        'one-column' => __('Single Layout', 'springy'),
        'masonry-post' => __('Masonry Layout', 'springy'),
    
    ),
    'label' => __('Blog Layout Options', 'springy'),
    'description' => __('Change your blog or archive page layout.', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-column-blog-page]',
    'type' => 'select',
    'priority' => 15,
));


/*Image Layout Options For Blog Page*/
$wp_customize->add_setting('springy_options[springy-blog-image-layout]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-blog-image-layout'],
    'sanitize_callback' => 'springy_sanitize_select'
));

$wp_customize->add_control('springy_options[springy-blog-image-layout]', array(
    'choices' => array(
        'full-image' => __('Full Layout', 'springy'),
        'left-image' => __('Grid Layout', 'springy'),
    
    ),
    'label' => __('Blog Page Layout', 'springy'),
    'description' => __('This will work only on Full layout Option', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-blog-image-layout]',
    'type' => 'select',
    'priority' => 15,
));

/*Blog Page Show content from*/
$wp_customize->add_setting('springy_options[springy-content-show-from]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-content-show-from'],
    'sanitize_callback' => 'springy_sanitize_select'
));

$wp_customize->add_control('springy_options[springy-content-show-from]', array(
    'choices' => array(
        'excerpt' => __('Show from Excerpt', 'springy'),
        'content' => __('Show from Content', 'springy'),
    ),
    'label' => __('Select Content Display From', 'springy'),
    'description' => __('You can enable excerpt from Screen Options inside post section of dashboard', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-content-show-from]',
    'type' => 'select',
    'priority' => 15,
));


/*Blog Page excerpt length*/
$wp_customize->add_setting('springy_options[springy-excerpt-length]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-excerpt-length'],
    'sanitize_callback' => 'absint'

));

$wp_customize->add_control('springy_options[springy-excerpt-length]', array(
    'label' => __('Excerpt Length', 'springy'),
    'description' => __('Enter the number per Words to show the content in blog page.', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-excerpt-length]',
    'type' => 'number',
    'priority' => 15,
));

/*Blog Page Pagination Options*/
$wp_customize->add_setting('springy_options[springy-pagination-options]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-pagination-options'],
    'sanitize_callback' => 'springy_sanitize_select'

));

$wp_customize->add_control('springy_options[springy-pagination-options]', array(
    'choices' => array(
        'numeric' => __('Numeric Pagination', 'springy'),
        'default' => __('Previous and Next Post Pagination', 'springy'),
    ),
    'label' => __('Pagination Types', 'springy'),
    'description' => __('Choose Required Pagination Type', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-pagination-options]',
    'type' => 'select',
    'priority' => 15,
));

/*Blog Page read more text*/
$wp_customize->add_setting('springy_options[springy-read-more-text]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-read-more-text'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-read-more-text]', array(
    'label' => __('Read More Text', 'springy'),
    'description' => __('Read more text for blog and archive page.', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-read-more-text]',
    'type' => 'text',
    'priority' => 15,
));


/*Social Share in blog page*/
$wp_customize->add_setting('springy_options[springy-show-hide-share]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-show-hide-share'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
));

$wp_customize->add_control('springy_options[springy-show-hide-share]', array(
    'label' => __('Show Social Share', 'springy'),
    'description' => __('Options to Enable Social Share in blog and archive page.', 'springy'),
    'section' => 'springy_blog_page_section',
    'settings' => 'springy_options[springy-show-hide-share]',
    'type' => 'checkbox',
    'priority' => 15,
));

