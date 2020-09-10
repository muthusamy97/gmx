<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Springy
 */

get_header();
global $springy_theme_options;
$page_banner = esc_url($springy_theme_options['springy_single_page_banner_image']);
$def_banner = esc_url(get_template_directory_uri()."/assets/images/page-banner.jpg");
$main_banner = ($page_banner == '') ? $def_banner : $page_banner;
?>
<section  class="page-bg" style="background-image: url('<?php echo $main_banner; ?>');">
	<div class="container">
		<div class="breadcrumbs-wrapper">	
			<div class="archive-heading">
				<?php
				the_archive_title( '<h2 class="archive-title">', '</h2>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</div>

			<div class="breadcrumbs-wrap">
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
					<?php if ( have_posts() ) : ?>

						<?php

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
