<?php 
/*Extra Options*/

        $wp_customize->add_section( 'springy_extra_options', array(
            'priority'       => 20,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __( 'Breadcrumb Settings', 'springy' ),
            'panel'          => 'springy_panel',
        ) );



        /*Breadcrumb Enable*/
        $wp_customize->add_setting( 'springy_options[springy-extra-breadcrumb]', array(
            'capability'        => 'edit_theme_options',
            'transport' => 'refresh',
            'default'           => $default['springy-extra-breadcrumb'],
            'sanitize_callback' => 'springy_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'springy_options[springy-extra-breadcrumb]', array(
            'label'     => __( 'Enable Breadcrumb', 'springy' ),
            'description' => __( 'Breadcrumb will appear on all pages except home page. More settings will be on the premium version.', 'springy' ),
            'section'   => 'springy_extra_options',
            'settings'  => 'springy_options[springy-extra-breadcrumb]',
            'type'      => 'checkbox',
            'priority'  => 15,
        ) );