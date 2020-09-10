<?php
/**
 * Custom theme hooks
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Springy
 */
if (!function_exists('springy_add_main_header')) :

    /**
     * Add main header.
     *
     * @since 1.0.0
     */
    function springy_add_main_header()
    {
        get_template_part('template-parts/sections/header', 'section');        
    }
endif;
add_action('springy_action_header', 'springy_add_main_header', 10);

/**
 * Custom theme hook for slider
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Springy
 */
if (!function_exists('springy_add_main_slider')) :

    /**
     * Add main slider.
     *
     * @since 1.0.0
     */
    function springy_add_main_slider()
    {

        get_template_part('template-parts/sections/slider', 'section');
    }
endif;
add_action('springy_action_slider', 'springy_add_main_slider', 10);


/**
 * Custom theme hook for slider page
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Springy
 */
if (!function_exists('springy_add_main_slider_page')) :

    /**
     * Add main slider from page.
     *
     * @since 1.0.0
     */
    function springy_add_main_slider_page()
    {

        get_template_part('template-parts/sections/slider', 'page');
    }
endif;
add_action('springy_action_slider_page', 'springy_add_main_slider_page', 10);

/**
 * Custom theme hook for promo section
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Springy
 */
if (!function_exists('springy_boxes_section')) :

    /**
     * Add main slider.
     *
     * @since 1.0.0
     */
    function springy_boxes_section()
    {       

        get_template_part('template-parts/sections/boxes', 'section');
    }
endif;
add_action('springy_action_boxes', 'springy_boxes_section', 10);

/**
 * Custom theme hook for boxes section from customizer
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Springy
 */
if (!function_exists('springy_boxes_customizer_section')) :

    /**
     * Boxes from the customizer.
     *
     * @since 1.0.0
     */
    function springy_boxes_customizer_section()
    {       

        get_template_part('template-parts/sections/boxes', 'customizer');
    }
endif;
add_action('springy_action_customizer_boxes', 'springy_boxes_customizer_section', 10);

/**
 * Only for blog and archive page
 *
 * Function for the sidebar.
 *
 * @package Springy
 */
if( !function_exists( 'springy_blog_sidebar_position_array' ) ) :
    /*
     * Function to get blog categories
     */
    function springy_blog_sidebar_position_array() {

        $sidebar_positions = array(
            'right-sidebar'  => get_template_directory_uri() . '/assets/images/right-sidebar.png',
            'left-sidebar' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
            'no-sidebar'  => get_template_directory_uri() . '/assets/images/no-sidebar.png',
            'middle-column'  => get_template_directory_uri() . '/assets/images/middle-content.png',
        );
        
        return $sidebar_positions;

    }
endif;


//only for single page
if( !function_exists( 'springy_sidebar_position_array' ) ) :
    /*
     * Function to get blog categories
     */
    function springy_sidebar_position_array() {

        $sidebar_positions = array(
            'single-right-sidebar'  => get_template_directory_uri() . '/assets/images/right-sidebar.png',
            'single-left-sidebar' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
            'single-no-sidebar'  => get_template_directory_uri() . '/assets/images/no-sidebar.png',
            'single-middle-column'  => get_template_directory_uri() . '/assets/images/middle-content.png',
        );
        
        return $sidebar_positions;

    }
endif;


/**
 * Hooks for the header image only
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Springy
 */
if (!function_exists('springy_main_header_hooks')) :

    /**
     * Add main header.
     *
     * @since 1.0.0
     */
    function springy_main_header_hooks()
    {
        global $springy_theme_options;
        $header_text = esc_html($springy_theme_options['springy_header_image_text']);
        $header_subtext = esc_html($springy_theme_options['springy_header_image_sub_heading']);
        $header_btn = esc_html($springy_theme_options['springy_header_image_button_text']);
        $header_link = esc_url($springy_theme_options['springy_header_image_button_link']);
        $header_image = esc_url(get_header_image());
        $header_class = ($header_image == "") ? '' : 'header-image';
        ?>
        <div class="main-header <?php echo esc_attr($header_class); ?>" style="background-image:url(<?php echo esc_url($header_image) ?>); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div class="container">
                <div class="head-img-wrapper">
                    <div class="head-content">
                        <?php if(!empty($header_text)){ ?>
                                <h1 class="wel-title"><?php echo esc_html($header_text); ?></h1>
                         <?php   }else{ ?>
                           <h1 class="wel-title"><?php bloginfo( 'name' ); ?></h1>
                        <?php }?>

                        <?php if(!empty($header_subtext)){ ?>
                        <p class="wel-title"><?php echo esc_html($header_subtext); ?></p>
                    <?php }else{ ?>
                        <p class="wel-title"><?php bloginfo( 'description' ); ?></p>
                    <?php } ?>
                    <?php if(!empty($header_btn)) { ?>
                        <a href="<?php echo esc_url($header_link); ?>"><?php echo esc_html($header_btn); ?></a>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div><!-- #masthead -->            
    <?php   }
endif;
add_action('springy_action_main_header_header', 'springy_main_header_hooks', 10);


/**
 * Hooks for the previous and next post
 *
 * This will help to get the next post image and the date of it
 *
 * @package Springy
 */
if (!function_exists('springy_previous_next_post_pagination')) :

    /**
     * Add on single page.
     *
     * @since 1.0.0
     */
    function springy_previous_next_post_pagination()
    { ?>

        <?php $prevPost = get_previous_post(true);
        if($prevPost) { ?>
        <div class="post-prev-wrapper">
            <div class="nav-box previous">
                <?php $prevthumbnail = get_the_post_thumbnail($prevPost->ID, array(100,100) );?>
                 <span class="img-prev"><?php previous_post_link("$prevthumbnail", TRUE); ?></span>
                  <span class="prev-link">
                     <span class="prev-title"><?php previous_post_link('%link',"<p>%title</p>", TRUE); ?></span>
                 </span>
            </div>
        </div>
        <?php } ?>
        <?php $nextPost = get_next_post(true);
        if($nextPost) { ?>
            <div class="post-next-wrapper">
                <div class="nav-box next">
                    <?php $nextthumbnail = get_the_post_thumbnail($nextPost->ID, array(150,100) ); ?>
                     <span class="next-link">
                        <span class="next-title"><?php next_post_link('%link',"<p>%title</p>", TRUE); ?></span>
                     </span>
                    <span class="img-next"><?php previous_post_link("$nextthumbnail", TRUE); ?></span>
                </div>
            </div>
        <?php } ?>

    <?php  }
    endif;
    add_action('springy_action_previous_next_post_pagination', 'springy_previous_next_post_pagination', 10);
