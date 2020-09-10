<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Springy
 */
get_header();

global $springy_theme_options;
$main_title = esc_html($springy_theme_options['springy-single-page-blog-title']);
$page_banner = esc_url($springy_theme_options['springy_single_page_banner_image']);
$def_banner = esc_url(get_template_directory_uri()."/assets/images/page-banner.jpg");
$main_banner = ($page_banner == '') ? $def_banner : $page_banner;
?>
<section  class="page-bg" style="background-image: url('<?php echo $main_banner; ?>');">
	<div class="container">
		<div class="breadcrumbs-wrapper">	
			<div class="archive-heading">
				<h2><?php echo esc_html( $main_title ); ?></h2>
			</div>
			<div class="breadcrumb">
				<?php do_action('springy_breadcrumb_options_hook'); ?> <!-- Breadcrumb hook -->
			</div>
		</div>
	</div>
</section>
<section id="content" class="site-content posts-container">
    <div class="container">
        <div class="row">
			<div id="primary" class="col-lg-8 content-area">
				<main id="main" class="site-main">
					
				<?php

				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					/* Masonry Start Section */
					do_action('springy_masonry_start_hook'); 

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */

						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

					/* Masonry end Section */
					do_action('springy_masonry_end_hook'); 

					/**
		             * springy_action_navigation hook
		             * @since Springy 1.0.0
		             *
		             * @hooked springy_action_navigation -  10
		             */

		            do_action( 'springy_action_navigation');

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>

<?php get_footer();

