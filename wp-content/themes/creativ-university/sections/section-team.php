<?php 
/**
 * Template part for displaying Team Section
 *
 *@package Creativ University
 */

    $team_section_title     = creativ_university_get_option( 'team_section_title' );
    $ts_content_type        = creativ_university_get_option( 'ts_content_type' );
    $number_of_ts_items     = creativ_university_get_option( 'number_of_ts_items' );

    if( $ts_content_type == 'ts_page' ) :
        for( $i=1; $i<=$number_of_ts_items; $i++ ) :
            $team_posts[] = creativ_university_get_option( 'team_page_'.$i );
        endfor;  
    elseif( $ts_content_type == 'ts_post' ) :
        for( $i=1; $i<=$number_of_ts_items; $i++ ) :
            $team_posts[] = creativ_university_get_option( 'team_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($team_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($team_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>
    
    <?php if( $ts_content_type == 'ts_page' ) : ?>
        <div class="section-content col-4 clear">
            <?php $args = array (
                'post_type'     => 'page',
                'post_per_page' => count( $team_posts ),
                'post__in'      => $team_posts,
                'orderby'       =>'post__in',
            );       
            $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                    $i=-1;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>
                    
                    <article>
                        <div class="team-wrapper">
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
                                        $excerpt = creativ_university_the_excerpt( 20 );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                </div><!-- .entry-content -->
                            </div><!-- .entry-container -->
                        </div><!-- .team-wrapper -->
                    </article>

                  <?php endwhile;?>
                <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->

    <?php else: ?>
        <div class="section-content col-4 clear">
            
            <?php $args = array (
                'post_type'     => 'post',
                'post_per_page' => count( $team_posts ),
                'post__in'      => $team_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );       
            $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                    $i=-1;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>
                    
                    <article>
                        <div class="team-wrapper">
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
                                        $excerpt = creativ_university_the_excerpt( 20 );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                </div><!-- .entry-content -->
                            </div><!-- .entry-container -->
                        </div><!-- .team-wrapper -->
                    </article>
                  <?php endwhile;?>
                <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;