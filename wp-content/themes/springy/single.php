<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', 'single' );
						
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
<?php  get_footer();

