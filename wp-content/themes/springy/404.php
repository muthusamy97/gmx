<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Springy
 */

get_header();
global $springy_theme_options;
$page_banner = esc_url($springy_theme_options['springy_single_page_banner_image']);
$def_banner = get_template_directory_uri()."/assets/images/page-banner.jpg";
$main_banner = ($page_banner == '') ? $def_banner : $page_banner;
?>
<section  class="page-bg" style="background-image: url('<?php echo $main_banner; ?>');">
	<div class="container">
		<div class="breadcrumbs-wrapper">	
			<div class="archive-heading">
				<h2><?php esc_html_e( '404', 'springy' ); ?></h2>
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
			<div id="primary" class="col-md-12 page-404-container">
				<main id="main" class="site-main">
					<div class="page-404-content">
						<h1 class="error-code"><?php esc_html_e( '404', 'springy' ); ?></h1>
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'springy' ); ?></h1>
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'springy' ); ?></p>
						<?php get_search_form(); ?>
						<div class="back_home">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html_e( 'Back to Home', 'springy' ); ?></a>
						</div>
					</div><!-- .error-404 -->
				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
</section>
<?php
get_footer();
