<?php

/**
 * Class WPPopups_Optin_Fields adds optins fields into popups
 */
class WPPopups_Optin_Fields {
	/**
	 * WPPopups_Optin_Fields constructor.
	 */
	public function __construct() {
		add_action( 'wppopups_popup_content_after', [ $this, 'add_optin_fields' ] );
	}

	/**
	 * Add optin fields in popup
	 * @param $popup
	 */
	public function add_optin_fields( $popup ){
		if( empty( $popup->data['providers'] ) ) {
			return;
		}
		// fields settings
		$fields = isset( $popup->data['fields'] ) ? $popup->data['fields'] : [];
		$email_placeholder = isset( $fields['email_field_text'] ) ? $fields['email_field_text'] : wppopups_default_optin_email_text();
		$display_name = ( ! isset( $fields['name_field'] ) || '1' == $fields['name_field'] );
		$name_placeholder = isset( $fields['name_field_text'] ) ? $fields['name_field_text'] : wppopups_default_optin_name_text();
		$submit_placeholder = isset( $fields['submit_text'] ) ? $fields['submit_text'] : wppopups_default_optin_submit_text();
		$gdpr = ( ! isset( $fields['gdpr_field'] ) || '1' == $fields['gdpr_field'] );
		$gdpr_text = isset( $fields['gdpr_field_text'] ) ? $fields['gdpr_field_text'] : wppopups_default_optin_gdpr_text();
		if( !empty( $fields['gdpr_url'] ) ) {
			$gdpr_text = '<a href="'. esc_url( $fields['gdpr_url'] ) . '" target="_blank" rel="nofollow">' . esc_attr( $gdpr_text ) .'</a>';
		}
		// optin style
		$optin_styles = isset( $popup->data['optin_styles'] ) ? $popup->data['optin_styles'] : [];
		$inline_fields = ( ! isset( $optin_styles['inline_fields'] ) || '1' == $optin_styles['inline_fields'] );
		$submit_bg = isset( $optin_styles['submit_bg_color'] ) ? $optin_styles['submit_bg_color'] : wppopups_default_optin_submit_color( $popup->data['settings'] )[0];
		$submit_hover = isset( $optin_styles['submit_bg_color_hover'] ) ? $optin_styles['submit_bg_color_hover'] : wppopups_default_optin_submit_color( $popup->data['settings'] )[1];
		$submit_border = isset( $optin_styles['submit_border_color'] ) ? $optin_styles['submit_border_color'] : wppopups_default_optin_submit_color( $popup->data['settings'] )[2];
		$submit_color = isset( $optin_styles['submit_text_color'] ) ? $optin_styles['submit_text_color'] : wppopups_default_optin_submit_color( $popup->data['settings'] )[3];
		$tag = function_exists('wppopups_is_builder_page') && wppopups_is_builder_page() ? 'div' : 'form';
		?>
		<div class="spu-fields-container <?=  $display_name ? 'with-spu-name' : '' ?>">
			<<?= $tag;?> id="spu-optin-form-<?= $popup->id;?>" class="spu-optin-form" action="" method="post">
				<input type="email" name="email" class="spu-helper-fields"/>
				<input type="text" name="name" class="spu-helper-fields"/>
				<input type="hidden" name="popup" value="<?= esc_attr( $popup->id );?>"/>

				<div class="spu-optin-fields <?= $inline_fields ? 'spu-inline-fields' : '' ;?>">
					<?php if( $display_name ) : ?>
						<input type="text" name="spu-name" class="spu-fields spu-name" placeholder="<?= esc_attr( $name_placeholder );?>"/>
					<?php endif; ?>
					<input type="email" name="spu-email" class="spu-fields spu-email" placeholder="<?= esc_attr( $email_placeholder );?>" required/>
				</div>

				<?php if( $gdpr ) : ?>
					<label class="spu-fields spu-gdpr"><input type="checkbox" name="gdpr" value="1" required /><?=  $gdpr_text ;?></label>
				<?php endif; ?>

				<button type="submit" class="spu-fields spu-submit">
					<span><?= esc_attr( $submit_placeholder );?></span>
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					     width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
      <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
          s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
          c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
						<path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
          C22.32,8.481,24.301,9.057,26.013,10.047z">
							<animateTransform attributeType="xml"
							                  attributeName="transform"
							                  type="rotate"
							                  from="0 20 20"
							                  to="360 20 20"
							                  dur="0.5s"
							                  repeatCount="indefinite"/>
						</path>
    </svg>
				</button>
				<div class="optin-errors" style="display: none"></div>
			</<?= $tag;?>>
			<?php
			$popup_id = $popup->id;
			?>
			<style type="text/css">
				#spu-<?php echo esc_attr( $popup_id ); ?> .spu-submit {
					background-color: <?= esc_attr( $submit_bg );?>;
					border-color: <?= esc_attr( $submit_border );?>;
					color: <?= esc_attr( $submit_color );?>;
				}
				#spu-<?php echo esc_attr( $popup_id ); ?> .spu-submit:hover {
					background-color: <?= esc_attr( $submit_hover );?>;
				}

				#spu-<?php echo esc_attr( $popup_id ); ?> .spu-fields.spu-submit svg path,
				#spu-<?php echo esc_attr( $popup_id ); ?> .spu-fields.spu-submit svg rect{
					fill: <?= esc_attr( $submit_color );?>;
				}
			</style>
		</div>
		<?php
	}
}
new WPPopups_Optin_Fields();