<?php
/**
 * Goto Top functions
 *
 * @since Springy 1.0.0
 *
 */

if (!function_exists('springy_go_to_top')) :
    function springy_go_to_top()
    {
    ?>
            <a id="toTop" class="go-to-top" href="#" title="<?php esc_attr_e('Go to Top', 'springy'); ?>">
                <i class="fa fa-angle-double-up"></i>
            </a>
<?php
    } endif;
add_action('springy_go_to_top_hook', 'springy_go_to_top', 10, 1);