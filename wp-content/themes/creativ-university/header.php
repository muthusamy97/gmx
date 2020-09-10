<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Creativ University
 */
/**
* Hook - creativ_university_action_doctype.
*
* @hooked creativ_university_doctype -  10
*/
do_action( 'creativ_university_action_doctype' );
?>
<head>
<?php
/**
* Hook - creativ_university_action_head.
*
* @hooked creativ_university_head -  10
*/
do_action( 'creativ_university_action_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php

/**
* Hook - creativ_university_action_before.
*
* @hooked creativ_university_page_start - 10
*/
do_action( 'creativ_university_action_before' );

/**
*
* @hooked creativ_university_header_start - 10
*/
do_action( 'creativ_university_action_before_header' );

/**
*
*@hooked creativ_university_site_branding - 10
*@hooked creativ_university_header_end - 15 
*/
do_action('creativ_university_action_header');

/**
*
* @hooked creativ_university_content_start - 10
*/
do_action( 'creativ_university_action_before_content' );

/**
 * Banner start
 * 
 * @hooked creativ_university_banner_header - 10
*/
do_action( 'creativ_university_banner_header' );  
