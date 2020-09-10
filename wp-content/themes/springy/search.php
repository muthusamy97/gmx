<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
				<h2><?php esc_html_e( 'Search', 'springy' ); ?></h2>
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
        	<div class="col-sm-12 col-md-12">
				<div class="search-heading">
					<h2 class="search-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for : %s', 'springy' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h2>
				</div>
			</div>
			<div id="primary" class="col-sm-12 col-md-12 content-area">
				<main id="main" class="site-main">
					<?php if ( have_posts() ) : ?>
					<?php
						/* Masonry Start Section */
						do_action('springy_masonry_start_hook'); 

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */

							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						/* Masonry end Section */
						do_action('springy_masonry_end_hook');
						
						else :

						get_template_part( 'template-parts/content', 'none' );
						endif;
					?>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
</section>
<?php get_footer();

