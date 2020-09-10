<?php
/**
 * The template for displaying home page.
 * @package Creativ University
 */

if ( 'posts' != get_option( 'show_on_front' ) ){ 
    get_header(); ?>
    <?php $enabled_sections = creativ_university_get_sections();
    if( is_array( $enabled_sections ) ) {
        foreach( $enabled_sections as $section ) {

            if( ( $section['id'] == 'featured-slider' ) ){ ?>
                <?php $enable_featured_slider = creativ_university_get_option( 'enable_featured_slider' );
                if( true ==$enable_featured_slider): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>">
                        <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'our-services' ) { ?>
                <?php $enable_our_services_section = creativ_university_get_option( 'enable_our_services_section' );
                if( true ==$enable_our_services_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'our-courses' ) { ?>
                <?php $enable_our_courses_section = creativ_university_get_option( 'enable_our_courses_section' );
                if(true ==$enable_our_courses_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'cta' ) { ?>
                <?php $enable_cta_section   = creativ_university_get_option( 'enable_cta_section' );
                $background_cta_section     = creativ_university_get_option( 'background_cta_section' );
                if( true ==$enable_cta_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section" style="background-image: url('<?php echo esc_url( $background_cta_section );?>');">
                        <div class="overlay"></div>
                        <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'team' ) { ?>
                <?php $enable_team_section = creativ_university_get_option( 'enable_team_section' );
                if( true ==$enable_team_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; 
            
            }
            elseif( ( $section['id'] == 'blog' ) ){ ?>
                <?php $enable_blog_section = creativ_university_get_option( 'enable_blog_section' );
                if(true ==$enable_blog_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="blog-posts-wrapper page-section">
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
                <?php endif;
            }
        }
    }
    if( true == creativ_university_get_option('enable_frontpage_content') ) { ?>
        <div class="wrapper page-section">
            <?php include( get_page_template() ); ?>
        </div>
    <?php }
    get_footer();
} 
elseif ('posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} 