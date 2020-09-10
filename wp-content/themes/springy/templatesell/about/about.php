<?php
/**
 * Added springy Page.
*/

/**
 * Add a new page under Appearance
 */
function springy_menu() {
	add_theme_page( __( 'Springy Options', 'springy' ), __( 'Springy Options', 'springy' ), 'edit_theme_options', 'springy-theme', 'springy_page' );
}
add_action( 'admin_menu', 'springy_menu' );

/**
 * Enqueue styles for the help page.
 */
function springy_admin_scripts( $hook ) {
	if ( 'appearance_page_springy-theme' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'springy-admin-style', get_template_directory_uri() . '/templatesell/about/about.css', array(), '' );
}
add_action( 'admin_enqueue_scripts', 'springy_admin_scripts' );

/**
 * Add the theme page
 */
function springy_page() {
	?>
	<div class="das-wrap">
		<div class="springy-panel">
			<div class="springy-logo">
				<img class="ts-logo" src="<?php echo esc_url( get_template_directory_uri() . '/templatesell/about/images/springy-logo.png' ); ?>" alt="Logo">
			</div>
			<p>
			<?php esc_html_e( 'A perfect theme for blog and magazine site. With masonry layout and multiple blog page layout, this theme is the awesome and minimal theme.', 'springy' ); ?></p>
			<a class="btn btn-primary" href="<?php echo esc_url (admin_url( '/customize.php?' ));
				?>"><?php esc_html_e( 'Theme Options - Click Here', 'springy' ); ?></a>
		</div>

		<div class="springy-panel">
			<div class="springy-panel-content">
				<div class="theme-title">
					<h3><?php esc_html_e( 'Looking for theme Documentation?', 'springy' ); ?></h3>
				</div>
				<a href="http://www.docs.templatesell.net/springy" target="_blank" class="btn btn-secondary"><?php esc_html_e( 'Documentation - Click Here', 'springy' ); ?></a>
			</div>
		</div>
		<div class="springy-panel">
			<div class="springy-panel-content">
				<div class="theme-title">
					<h3><?php esc_html_e( 'If you like the theme, please leave a review', 'springy' ); ?></h3>
				</div>
				<a href="https://wordpress.org/support/theme/springy/reviews/#new-post" target="_blank" class="btn btn-secondary"><?php esc_html_e( 'Rate this theme', 'springy' ); ?></a>
			</div>
		</div>
	</div>
	<?php
}
