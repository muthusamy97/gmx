<?php
/**
 * Springy Promo from customizer
 * @since Springy 1.0.0
 *
 * @param null
 * @return void
 *
 */          
global $springy_theme_options;
$icon_one = esc_attr($springy_theme_options['springy-promo-icon-class-one']);
$icon_two = esc_attr($springy_theme_options['springy-promo-icon-class-two']);
$icon_three = esc_attr($springy_theme_options['springy-promo-icon-class-three']);

$title_one = esc_html($springy_theme_options['springy-promo-icon-title-one']);
$title_two = esc_html($springy_theme_options['springy-promo-icon-title-two']);
$title_three = esc_html($springy_theme_options['springy-promo-icon-title-three']);

$desc_one = wp_kses_post($springy_theme_options['springy-promo-icon-text-one']);
$desc_two = wp_kses_post($springy_theme_options['springy-promo-icon-text-two']);
$desc_three = wp_kses_post($springy_theme_options['springy-promo-icon-text-three']);
?>
<section class="springy-promo-section">
    <div class="container">
        <div class="row promo-boxes">                         
            <div class="col-sm-4 col-md-4">
                <div class="feature-item">
                    <span class="first-icon"><i class="<?php echo esc_attr($icon_one); ?>"></i></span>
                    <h4 class="first-icon-title"><?php echo esc_html($title_one); ?></h4>
                    <p class="first-icon-desc"><?php echo esc_html($desc_one); ?></p>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="feature-item">
                    <span class="second-icon"><i class="<?php echo esc_attr($icon_two); ?>"></i></span>
                    <h4 class="second-icon-title"><?php echo esc_html($title_two); ?></h4>
                    <p class="second-icon-desc"><?php echo esc_html($desc_two); ?></p>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="feature-item">
                    <span class="third-icon"><i class="<?php echo esc_attr($icon_three); ?>"></i></span>
                    <h4 class="third-icon-title"><?php echo esc_html($title_three); ?></h4>
                    <p class="third-icon-desc"><?php echo esc_html($desc_three); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
