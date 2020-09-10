<?php

/**
 * Class WPPopups_Optin
 *
 * @package    WPPopups
 * @author     WPPopups
 * @since      2.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2016, WP Popups LLC
 */
class WPPopups_Builder_Panel_Optin  extends WPPopups_Builder_Panel {

	/**
	 * All systems go.
	 *
	 * @since 2.0.0
	 */
	public function init() {

		// Define panel information.
		$this->name    = esc_html__( 'Optin options', 'wppopups-pro' );
		$this->slug    = 'optin';
		$this->icon    = 'fa-envelope';
		$this->order   = 10;
		$this->sidebar = true;
		$this->display_panel = false;
		
		//add_filter( 'wppopups_builder_panels', [ $this, 'add_builder_panels' ] );

		// only if we have a connection
		if( ! empty( $this->popup_data['providers'] ) ) {
			$this->display_panel = true;
			//add_filter( 'wppopups_builder_panels', [ $this, 'optin_builder_panels' ] );
		}
	}
	/**
	 * Enqueue assets for the Optin panel.
	 *
	 * @since 2.0.0
	 */
	public function enqueues() {

	}


	/**
	 * Outputs the Provider panel sidebar.
	 *
	 * @since 2.0.0
	 */
	public function panel_sidebar() {

		// Sidebar contents are not valid unless we have a popup.
		if ( ! $this->popup ) {
			return;
		}

		$sections = [
			'fields' => esc_html__( 'Fields', 'wppopups-pro' ),
			'optin_styles'  => esc_html__( 'Appearance', 'wppopups-pro' ),
			'success'  => esc_html__( 'Success Message', 'wppopups-pro' ),
			'redirect' => esc_html__( 'Redirect', 'wppopups-pro' ),
		];
		$sections = apply_filters( 'wppopups_builder_optin_sections', $sections, $this->popup_data );
		foreach ( $sections as $slug => $section ) {
			$this->panel_sidebar_section( $section, $slug );
			$func = "panel_sidebar_{$slug}";
			echo sprintf( $this->panel_sidebar_content_section( $slug ), $this->$func( $slug ) ); // phpcs:ignore
		}
		do_action( 'wppopups_optin_panel_sidebar', $this->popup );
	}

	/**
	 * Optin fields and text strings
	 *
	 * @param $slug
	 *
	 * @return false|string
	 */
	public function panel_sidebar_fields( $slug ) {
		ob_start();
		wppopups_panel_field(
			'text',
			$slug,
			'optin_form_css',
			$this->popup_data,
			esc_html__( 'Form CSS class', 'wppopups-pro' ),
			[
				'tooltip'     => esc_html__('Enter CSS class names for the optin form. Multiple names should be separated with spaces.', 'wppopups' ),
			]
		);
		wppopups_panel_field(
			'text',
			$slug,
			'email_field_text',
			$this->popup_data,
			esc_html__( 'Email field placeholder', 'wppopups' ),
			[
				'default'     => wppopups_default_optin_email_text(),
			]
		);
		wppopups_panel_field(
			'select',
			$slug,
			'name_field',
			$this->popup_data,
			esc_html__( 'Ask for name?', 'wppopups' ),
			[
				'default' => '1',
				'options' => [
					'1' => 'Yes',
					'0'  => 'No',
				],
			]
		);

		wppopups_panel_field(
			'text',
			$slug,
			'name_field_text',
			$this->popup_data,
			esc_html__( 'Name placeholder', 'wppopups' ),
			[
				'default'     => wppopups_default_optin_name_text(),
				'data'    => [
					'depend'       => 'wppopups-panel-field-fields-name_field',
					'depend-value' => ['1'],
				],
			]
		);
		wppopups_panel_field(
			'text',
			$slug,
			'submit_text',
			$this->popup_data,
			esc_html__( 'Submit Button Text', 'wppopups-pro' ),
			[
				'default'     => wppopups_default_optin_submit_text(),
			]
		);
		wppopups_panel_field(
			'text',
			$slug,
			'submit_processing_text',
			$this->popup_data,
			esc_html__( 'Submit Button Processing Text', 'wppopups-pro' ),
			[
				'default'     => wppopups_default_optin_submit_processing_text(),
			]
		);
		wppopups_panel_field(
			'text',
			$slug,
			'submit_css',
			$this->popup_data,
			esc_html__( 'Submit Button CSS class', 'wppopups-pro' ),
			[
				'tooltip'     => esc_html__('Enter CSS class names for the form submit button. Multiple names should be separated with spaces.', 'wppopups-pro' ),
			]
		);

		wppopups_panel_field(
			'select',
			$slug,
			'gdpr_field',
			$this->popup_data,
			esc_html__( 'Display GDPR checkbox?', 'wppopups-pro' ),
			[
				'default' => '1',
				'options' => [
					'1' => 'Yes',
					'0'  => 'No',
				],
			]
		);

		wppopups_panel_field(
			'text',
			$slug,
			'gdpr_field_text',
			$this->popup_data,
			esc_html__( 'GPDR checkbox text value', 'wppopups-pro' ),
			[
				'default'     => wppopups_default_optin_gdpr_text(),
				'data'    => [
					'depend'       => 'wppopups-panel-field-fields-gdpr_field',
					'depend-value' => ['1'],
				],
			]
		);

		wppopups_panel_field(
			'text',
			$slug,
			'gdpr_url',
			$this->popup_data,
			esc_html__( 'GPDR text url?', 'wppopups-pro' ),
			[
				'default'     => '',
				'data'    => [
					'depend'       => 'wppopups-panel-field-fields-gdpr_field',
					'depend-value' => ['1'],
				],
				'tooltip' => esc_html__( 'Leave blank or enter a valid url to make the GDPR clickable', 'wppopups-pro' ),
			]
		);
		// Let others add fields.
		do_action( 'wppopups_sidebar_optin_fields', $this );

		return ob_get_clean();
	}

	/**
	 * Appeareance sidebar panel
	 * @param $slug
	 *
	 * @return false|string
	 */
	public function panel_sidebar_optin_styles( $slug ) {
		ob_start();

		wppopups_panel_field(
			'select',
			$slug,
			'inline_fields',
			$this->popup_data,
			esc_html__( 'Display fields inline?', 'wppopups-pro' ),
			[
				'default' => '1',
				'options' => [
					'1' => 'Yes',
					'0'  => 'No',
				],
				'tooltip' => esc_html__( 'When you have multiple fields, you can choose between showing them in one line or multiple lines', 'wppopups-pro' ),
			]
		);

		wppopups_panel_field(
			'text',
			$slug,
			'submit_text_color',
			$this->popup_data,
			esc_html__( 'Submit Text Color', 'wppopups-pro' ),
			[
				'input_class' => 'wppopups-color-picker',
				'default'     => wppopups_default_optin_submit_color( $this->popup_data['settings'] )[3],
			]
		);

		wppopups_panel_field(
			'text',
			$slug,
			'submit_bg_color',
			$this->popup_data,
			esc_html__( 'Submit Background Color', 'wppopups-pro' ),
			[
				'input_class' => 'wppopups-color-picker',
				'default'     => wppopups_default_optin_submit_color( $this->popup_data['settings'] )[0],
			]
		);


		wppopups_panel_field(
			'text',
			$slug,
			'submit_bg_color_hover',
			$this->popup_data,
			esc_html__( 'Submit Hover Color', 'wppopups-pro' ),
			[
				'input_class' => 'wppopups-color-picker',
				'default'     => wppopups_default_optin_submit_color( $this->popup_data['settings'] )[1],
			]
		);

		wppopups_panel_field(
			'text',
			$slug,
			'submit_border_color',
			$this->popup_data,
			esc_html__( 'Submit Border Color', 'wppopups-pro' ),
			[
				'input_class' => 'wppopups-color-picker',
				'default'     => wppopups_default_optin_submit_color( $this->popup_data['settings'] )[2],
			]
		);

		// Let others add fields.
		do_action( 'wppopups_sidebar_optin_styles', $this );

		return ob_get_clean();
	}

	/**
	 * Success message sidebar panel
	 * @param $slug
	 *
	 * @return false|string
	 */
	public function panel_sidebar_success( $slug ) {
		ob_start();
		wppopups_panel_field(
			'tinymce',
			'success',
			'optin_success',
			$this->popup_data,
			esc_html__( 'Content', 'wppopups-pro' ),
			[
				'default' => esc_html__( 'Thanks for subscribing! Please check your email for further instructions.', 'wppopups-pro' ),
				'tinymce' => [
					'media_buttons' => true,
				],
			]
		);

		wppopups_panel_field(
			'text',
			$slug,
			'optin_success_seconds',
			$this->popup_data,
			esc_html__( 'Automatically close popup after success', 'wppopups-pro' ),
			[
				'default'     => '0',
				'type'      => 'number',
				'after'    => esc_html__( 'seconds', 'wppopups-pro' ),
				'tooltip' => esc_html__( 'Leave 0 seconds to keep popup open', 'wppopups-pro' ),
			]
		);

		// Let others add fields.
		do_action( 'wppopups_sidebar_optin_success', $this );

		return ob_get_clean();
	}

	/**
	 * Redirect sidebar panel
	 * @param $slug
	 *
	 * @return false|string
	 */
	public function panel_sidebar_redirect( $slug ) {
		ob_start();
		wppopups_panel_field(
			'text',
			$slug,
			'optin_redirect',
			$this->popup_data,
			esc_html__( 'Redirect URL', 'wppopups-pro' ),
			[
				'tooltip'     => esc_html__('Enter a URL to redirect users after success submission.', 'wppopups-pro' ),
			]
		);
		wppopups_panel_field(
			'select',
			$slug,
			'pass_lead_data',
			$this->popup_data,
			esc_html__( 'Pass lead data to redirect url ?', 'wppopups-pro' ),
			[
				'default' => '0',
				'options' => [
					'1' => 'Yes',
					'0'  => 'No',
				],
				'tooltip'     => esc_html__('You can pass email and name as query string data to the redirect url.', 'wppopups-pro' ),
			]
		);
		// Let others add fields.
		do_action( 'wppopups_sidebar_optin_redirect', $this );

		return ob_get_clean();
	}
}

new WPPopups_Builder_Panel_Optin();