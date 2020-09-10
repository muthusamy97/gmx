<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Springy
 */
global $springy_theme_options;
$copyright = wp_kses_post($springy_theme_options['springy-footer-copyright']);
if ( is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') ) {
	$count = 0;
	for ( $i = 1; $i <= 4; $i++ )
	{
		if ( is_active_sidebar( 'footer-' . $i ) )
		{
			$count++;
		}
	}
	
	$footer_col= 4;
	if( $count == 4 )
	{
		$footer_col= 4;
	}
	elseif( $count == 3)
	{
		$footer_col= 3;
	}
	elseif( $count == 2)
	{
		$footer_col= 2;
	}
	elseif( $count == 1)
	{
		$footer_col= 1;
	}
}

?>
<div class="footer-wrap">
	<div class="container">
		<div class="row">
			<?php
			for ( $i = 1; $i <= 4 ; $i++ ){
				if ( is_active_sidebar( 'footer-' . $i ) )
				{
					?>
					<div class="footer-col-<?php echo $footer_col; ?>">
						<div class="footer-top-box wow fadeInUp">
							<?php dynamic_sidebar( 'footer-' . $i ); ?>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<footer class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="copyright">
						<p>
							<?php echo $copyright; ?>
							<?php
							/* translators: 1: Theme name, 2: Theme author. */
							printf( esc_html__( '- %1$s Theme by : %2$s', 'springy' ), 'Springy', '<a href="https://www.templatesell.com/">Template Sell</a>' );
							?>
						</p>
					</div>
				</div>
				<div class="col-md-6">
					<?php
					if (has_nav_menu('footer')) {
						wp_nav_menu( array(
							'theme_location' => 'footer',
							'menu_id'        => '',
							'container' => 'ul',
							'menu_class'      => 'footer-menu'
						) );
					}
					?>
				</div>
			</div>
		</div>
	</footer>
	<?php do_action('springy_go_to_top_hook'); ?>
</div>
</div><!-- main content -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>