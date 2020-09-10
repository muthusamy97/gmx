<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.5
 * @access public
 */
final class Springy_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.5
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.5
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.5
	 * @access public
	 * @param object $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'templatesell/upgrade/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Springy_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Springy_Customize_Section_Pro(
				$manager,
				'springy_plus',
				array(
					'pro_text2' => esc_html__( 'Upgrade to Pro and Get More Features', 'springy' ),
					'pro_url2'  => 'https://www.templatesell.com/item/springy-plus/',
					'pro_text'  => esc_html__( 'Get Support', 'springy' ),
					'pro_url'   => 'https://www.templatesell.com/contact-us/',
					'priority' => '1',
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'springy-customize-controls', trailingslashit( get_template_directory_uri() ) . '/templatesell/upgrade/customize-controls.js', array( 'customize-controls' ) );
	}
}

// Doing this customizer thang!
Springy_Customize::get_instance();
