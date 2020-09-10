<?php

if ( ! function_exists( 'springy_load_widgets' ) ) :

    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function springy_load_widgets() {

        // Highlight Post.
        register_widget( 'Springy_Featured_Post' );

        // Author Widget.
        register_widget( 'Springy_Author_Widget' );
		
		// Social Widget.
        register_widget( 'Springy_Social_Widget' );
    }
endif;
add_action( 'widgets_init', 'springy_load_widgets' );


