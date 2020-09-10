<?php
/**
 * Active callback functions.
 *
 * @package Creativ University
 */

function creativ_university_slider_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_slider]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function creativ_university_slider_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[slider_content_type]' )->value();
    return ( creativ_university_slider_active( $control ) && ( 'slider_page' == $content_type ) );
}

function creativ_university_slider_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[slider_content_type]' )->value();
    return ( creativ_university_slider_active( $control ) && ( 'slider_post' == $content_type ) );
}

function creativ_university_our_services_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_our_services_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function creativ_university_our_services_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[services_content_type]' )->value();
    return ( creativ_university_our_services_active( $control ) && ( 'services_page' == $content_type ) );
}

function creativ_university_our_services_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[services_content_type]' )->value();
    return ( creativ_university_our_services_active( $control ) && ( 'services_post' == $content_type ) );
}

function creativ_university_our_courses_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_our_courses_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function creativ_university_our_courses_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[cs_content_type]' )->value();
    return ( creativ_university_our_courses_active( $control ) && ( 'cs_page' == $content_type ) );
}

function creativ_university_our_courses_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[cs_content_type]' )->value();
    return ( creativ_university_our_courses_active( $control ) && ( 'cs_post' == $content_type ) );
}

function creativ_university_team_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_team_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function creativ_university_team_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[ts_content_type]' )->value();
    return ( creativ_university_team_active( $control ) && ( 'ts_page' == $content_type ) );
}

function creativ_university_team_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[ts_content_type]' )->value();
    return ( creativ_university_team_active( $control ) && ( 'ts_post' == $content_type ) );
}


function creativ_university_cta_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_cta_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function creativ_university_blog_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_blog_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

/**
 * Active Callback for top bar section
 */
function creativ_university_contact_info_ac( $control ) {

    $show_contact_info = $control->manager->get_setting( 'theme_options[show_header_contact_info]')->value();
    $control_id        = $control->id;
         
    if ( $control_id == 'theme_options[header_location]' && $show_contact_info ) return true;
    if ( $control_id == 'theme_options[header_phone]' && $show_contact_info ) return true;

    return false;
}

function creativ_university_social_links_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[show_header_social_links]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}