<?php
/**
 * Masonry Start Class and Id functions
 *
 * @since Springy 1.0.0
 *
 */
if (!function_exists('springy_masonry_start')) :
    function springy_masonry_start()
    { ?>
        <div class="masonry-start"><div id="masonry-loop">
        
        <?php
    }
endif;
add_action('springy_masonry_start_hook', 'springy_masonry_start', 10, 1);

/**
 * Masonry end Div
 *
 * @since Springy 1.0.0
 *
 */
if (!function_exists('springy_masonry_end')) :
    function springy_masonry_end()
    { ?>
        </div>
        </div>
        
        <?php
    }
endif;
add_action('springy_masonry_end_hook', 'springy_masonry_end', 10, 1);