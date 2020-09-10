<?php 
/**
 * Template part for displaying Courses Section
 *
 *@package Creativ University
 */
    $our_courses_section_title    = creativ_university_get_option( 'our_courses_section_title' );
    $cs_content_type              = creativ_university_get_option( 'cs_content_type' );
    $number_of_cs_items           = creativ_university_get_option( 'number_of_cs_items' );

    if( $cs_content_type == 'cs_page' ) :
        for( $i=1; $i<=$number_of_cs_items; $i++ ) :
            $our_courses_posts[] = creativ_university_get_option( 'our_courses_page_'.$i );
        endfor;  
    elseif( $cs_content_type == 'cs_post' ) :
        for( $i=1; $i<=$number_of_cs_items; $i++ ) :
            $our_courses_posts[] = creativ_university_get_option( 'our_courses_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($our_courses_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($our_courses_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $cs_content_type == 'cs_page' ) : ?>
        <div class="section-content col-4 clear">
            <?php $args = array (
                'post_type'     => 'page',
                'post_per_page' => count( $our_courses_posts ),
                'post__in'      => $our_courses_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                    $i=-1;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>
                    
                    <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                        <div class="featured-course-wrapper">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                    <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                                </div><!-- .featured-image -->
                            <?php endif; ?>

                            <div class="entry-container">
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                </header>

                                <div class="entry-content">
                                    <?php
                                        $excerpt = creativ_university_the_excerpt( 10 );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                </div><!-- .entry-content -->
                            </div><!-- .entry-container -->
                        </div><!-- .featured-course-wrapper -->
                    </article>
                  <?php endwhile;?>
                <?php endif;?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content col-4 clear">
            <?php $args = array (
                'post_type'     => 'post',
                'post_per_page' => count( $our_courses_posts ),
                'post__in'      => $our_courses_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                    $i=-1;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>     
                    
                    <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                        <div class="featured-course-wrapper">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                    <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                                </div><!-- .featured-image -->
                            <?php endif; ?>

                            <div class="entry-container">
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                </header>

                                <div class="entry-content">
                                    <?php
                                        $excerpt = creativ_university_the_excerpt( 10 );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                </div><!-- .entry-content -->
                            </div><!-- .entry-container -->
                        </div><!-- .featured-course-wrapper -->
                    </article>

                  <?php endwhile;?>
                <?php endif;?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;