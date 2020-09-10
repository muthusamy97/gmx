<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Springy
 */
$GLOBALS['springy_theme_options'] = springy_get_options_value();
global $springy_theme_options;
$enable_slider = absint($springy_theme_options['springy_enable_slider']);
$slider_from = esc_attr($springy_theme_options['springy-select-slider-from']);
$enable_box = absint($springy_theme_options['springy_enable_promo']);
$boxes_from = esc_attr($springy_theme_options['springy-select-boxes-from']);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
//wp_body_open hook from WordPress 5.2
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}else { 
    do_action( 'wp_body_open' ); 
}
?>
<div id="page" class="site ">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'springy' ); ?></a>

	<?php
    /**
     * Hook - springy_action_header.
     *
     * @hooked springy_add_main_header - 10
     */
    do_action( 'springy_action_header' );

    /**
     * Hook - springy_action_main_header.
     *
     * @hooked springy_action_main_header_header - 10
     */
    if( $enable_slider == 0  && ( is_front_page() ) ){
     do_action('springy_action_main_header_header');
    }
    ?>
    <div class="clear-fix"></div>
	 <?php if ($enable_slider == 1 && (is_front_page() ) ) { ?>
        <section class="slider-wrapper">
            <?php
            /*
            * Slider Section Hook
            */
            if($slider_from == 'from-post'){
                do_action('springy_action_slider');
            }else{
                do_action('springy_action_slider_page');
            }
            ?>
        </section>
    <?php } ?>
    <?php if ($enable_box == 1 && ( is_front_page() ) )  { ?>
        <section class="promo-slider-wrapper">
            <?php
            
            /*
            * Boxes Section Hook
            */
            if( $boxes_from == 'from-customizer'){
                do_action('springy_action_customizer_boxes');
            }else{
                do_action('springy_action_boxes');
            }
            ?>
        </section>
    <?php } ?>