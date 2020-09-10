<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Springy
 */
get_header();
global $springy_theme_options;
$page_banner = esc_url($springy_theme_options['springy_single_page_banner_image']);
$home_banner = absint($springy_theme_options['springy-enable-home-title']);
$def_banner = esc_url(get_template_directory_uri()."/assets/images/page-banner.jpg");
$main_banner = ($page_banner == '') ? $def_banner : $page_banner;
?>
<section  class="page-bg" style="background-image: url('<?php echo $main_banner; ?>');">
	<div class="container">
		<div class="breadcrumbs-wrapper">	
			<div class="archive-heading">
				<?php the_title('<h2 class="post-title entry-title">', '</h2>'); ?>
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
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
				</main><!-- #main -->
			</div><!-- #primary -->
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer();
