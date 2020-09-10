<?php
/*Promo Section Options*/

$wp_customize->add_section( 'springy_promo_section', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Promo Boxes Settings', 'springy' ),
    'panel'          => 'springy_panel',
) );

/*callback functions slider*/
if ( !function_exists('springy_promo_active_callback') ) :
    function springy_promo_active_callback(){
        global $springy_theme_options;
        $enable_promo = absint($springy_theme_options['springy_enable_promo']);
        if( 1 == $enable_promo ){
            return true;
        }
        else{
            return false;
        }
    }
endif;

/*Boxes Enable Option*/
$wp_customize->add_setting( 'springy_options[springy_enable_promo]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy_enable_promo'],
    'sanitize_callback' => 'springy_sanitize_checkbox'
) );

$wp_customize->add_control( 'springy_options[springy_enable_promo]', array(
    'label'     => __( 'Enable Boxes', 'springy' ),
    'description' => __('Enable and select the category to show the boxes below slider.', 'springy'),
    'section'   => 'springy_promo_section',
    'settings'  => 'springy_options[springy_enable_promo]',
    'type'      => 'checkbox',
    'priority'  => 15,

) );

 /*Select the boxes from*/
$wp_customize->add_setting('springy_options[springy-select-boxes-from]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-select-boxes-from'],
    'sanitize_callback' => 'springy_sanitize_select'
));

$wp_customize->add_control('springy_options[springy-select-boxes-from]', array(
    'choices' => array(
        'from-customizer' => __('Boxes From Customizer', 'springy'),
        'from-post-cat' => __('Boxes From Post', 'springy'),
    ),
    'label' => __('Select Boxes From Options', 'springy'),
    'description' => __('You can either select the boxes from post category or customizer.', 'springy'),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-select-boxes-from]',
    'type' => 'select',
    'priority' => 15,
    'active_callback'=> 'springy_promo_active_callback',
));

/*callback functions boxes getting from post*/
if ( !function_exists('springy_boxes_get_from_active_callback') ) :
  function springy_boxes_get_from_active_callback(){
      global $springy_theme_options;
      $enable_boxes = absint($springy_theme_options['springy_enable_promo']);
      $boxes_from = esc_attr($springy_theme_options['springy-select-boxes-from']);
      if( 1 == $enable_boxes && $boxes_from == 'from-post-cat' ){
          return true;
      }
      else{
          return false;
      }
  }
endif; 

/*Boxes Category Selection*/
$wp_customize->add_setting( 'springy_options[springy-promo-select-category]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['springy-promo-select-category'],
    'sanitize_callback' => 'absint'

) );

$wp_customize->add_control(
    new Springy_Customize_Category_Dropdown_Control(
        $wp_customize,
        'springy_options[springy-promo-select-category]',
        array(
            'label'     => __( 'Category For Boxes', 'springy' ),
            'description' => __('From the dropdown select the category for the boxes. Category having post will display in below boxes section.', 'springy'),
            'section'   => 'springy_promo_section',
            'settings'  => 'springy_options[springy-promo-select-category]',
            'type'      => 'category_dropdown',
            'priority'  => 15,
            'active_callback'=>'springy_boxes_get_from_active_callback'
        )
    )
);

/*callback functions boxes getting from customizer*/
if ( !function_exists('springy_boxes_get_from_customizer_active_callback') ) :
  function springy_boxes_get_from_customizer_active_callback(){
      global $springy_theme_options;
      $enable_boxes = absint($springy_theme_options['springy_enable_promo']);
      $boxes_from = esc_attr($springy_theme_options['springy-select-boxes-from']);
      if( 1 == $enable_boxes && $boxes_from == 'from-customizer' ){
          return true;
      }
      else{
          return false;
      }
  }
endif; 

/*Promo Section Font Icon Class one*/
$wp_customize->add_setting('springy_options[springy-promo-icon-class-one]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-class-one'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-promo-icon-class-one]', array(
    'label' => __('Enter Themify Class Icons Icon One', 'springy'),
    'description' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
        __( 'Check', 'springy' ),
        esc_url('https://themify.me/themify-icons'),
        __('Themify Class Icons' , 'springy'),
        __('and copy the class and paste here. Example ti-layout, ti-bar-chart.' ,'springy')
    ),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-class-one]',
    'type' => 'text',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));

$wp_customize->add_setting('springy_options[springy-promo-icon-title-one]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-title-one'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-promo-icon-title-one]', array(
    'label' => __('Title for first icon', 'springy'),
    'description' => __('Enter the title for the icon.', 'springy'),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-title-one]',
    'type' => 'text',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));

$wp_customize->add_setting('springy_options[springy-promo-icon-text-one]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-text-one'],
    'sanitize_callback' => 'wp_kses_post'
));

$wp_customize->add_control('springy_options[springy-promo-icon-text-one]', array(
    'label' => __('Description for first icon', 'springy'),
    'description' => __('Enter the short description for the icon.', 'springy'),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-text-one]',
    'type' => 'textarea',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));


/*Promo Section Font Icon Class two*/
$wp_customize->add_setting('springy_options[springy-promo-icon-class-two]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-class-two'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-promo-icon-class-two]', array(
    'label' => __('Enter Font Awesome Class Two', 'springy'),
    'description' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
        __( 'Check', 'springy' ),
        esc_url('https://themify.me/themify-icons'),
        __('Themify Class Icons' , 'springy'),
        __('and copy the class and paste here. Example ti-layout, ti-bar-chart.' ,'springy')
    ),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-class-two]',
    'type' => 'text',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));

$wp_customize->add_setting('springy_options[springy-promo-icon-title-two]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-title-two'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-promo-icon-title-two]', array(
    'label' => __('Title for second icon', 'springy'),
    'description' => __('Enter the Title for the icon.', 'springy'),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-title-two]',
    'type' => 'text',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));

$wp_customize->add_setting('springy_options[springy-promo-icon-text-two]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-text-two'],
    'sanitize_callback' => 'wp_kses_post'
));

$wp_customize->add_control('springy_options[springy-promo-icon-text-two]', array(
    'label' => __('Description for second icon', 'springy'),
    'description' => __('Enter the short description for the icon.', 'springy'),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-text-two]',
    'type' => 'textarea',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));

/*Promo Section Font Icon Class three*/
$wp_customize->add_setting('springy_options[springy-promo-icon-class-three]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-class-three'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-promo-icon-class-three]', array(
    'label' => __('Enter Font Awesome Class Three', 'springy'),
    'description' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
        __( 'Check', 'springy' ),
        esc_url('https://themify.me/themify-icons'),
        __('Themify Class Icons' , 'springy'),
        __('and copy the class and paste here. Example ti-layout, ti-bar-chart.' ,'springy')
    ),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-class-three]',
    'type' => 'text',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));


$wp_customize->add_setting('springy_options[springy-promo-icon-title-three]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-title-three'],
    'sanitize_callback' => 'sanitize_text_field'
));

$wp_customize->add_control('springy_options[springy-promo-icon-title-three]', array(
    'label' => __('Title for third icon', 'springy'),
    'description' => __('Enter the title for the icon.', 'springy'),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-title-three]',
    'type' => 'text',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));

$wp_customize->add_setting('springy_options[springy-promo-icon-text-three]', array(
    'capability' => 'edit_theme_options',
    'transport' => 'refresh',
    'default' => $default['springy-promo-icon-text-three'],
    'sanitize_callback' => 'wp_kses_post'
));

$wp_customize->add_control('springy_options[springy-promo-icon-text-three]', array(
    'label' => __('Description for third icon', 'springy'),
    'description' => __('Enter the short description for the icon.', 'springy'),
    'section' => 'springy_promo_section',
    'settings' => 'springy_options[springy-promo-icon-text-three]',
    'type' => 'textarea',
    'priority' => 15,
    'active_callback'=> 'springy_boxes_get_from_customizer_active_callback',
));