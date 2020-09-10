<?php
/**
 * Enqueue scripts and styles.
 */
function springy_scripts() {

	/*google font  */
	global $springy_theme_options;
    /*body  */
    wp_enqueue_style('springy-body', '//fonts.googleapis.com/css?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), null);
    /*heading  */
    wp_enqueue_style('springy-heading', '//fonts.googleapis.com/css?family=Hind:wght@300;400;500;600&display=swap', array(), null);
    /*Author signature google font  */
    wp_enqueue_style('springy-sign', '//fonts.googleapis.com/css?family=Monsieur+La+Doulaise&display=swap', array(), null);
    
	//*Font-Awesome-master*/
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.5.0' );
    //*themify*/
    wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), '4.5.0' );

    wp_enqueue_style( 'grid-css', get_template_directory_uri() . '/css/grid.min.css', array(), '4.5.0' );
    
    /*Slick CSS*/
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/css/slick.css', array(), '4.5.0' );
	
    /*mmenu CSS*/
    wp_enqueue_style( 'navbar-style', get_template_directory_uri() . '/assets/menu/navbar.css', array(), '4.5.0' );
    wp_enqueue_style( 'animate-style', get_template_directory_uri() . '/assets/css/animate.css', array(), '4.5.0' );


	$masonry =  esc_attr($springy_theme_options['springy-column-blog-page']);
    if( 'masonry-post' == $masonry )  {
    	wp_enqueue_script( 'masonry' );
    	wp_enqueue_script( 'springy-custom-masonry', get_template_directory_uri() . '/assets/js/custom-masonry.js', array('jquery'), '4.6.0' );
   }

   /*Main CSS*/
    wp_enqueue_style( 'springy-style', get_stylesheet_uri() );

	/*RTL CSS*/
	wp_style_add_data( 'springy-style', 'rtl', 'replace' );


	wp_enqueue_script( 'springy-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20200430', true );

	/*Slick JS*/
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.js', array('jquery'), '4.6.0' );
    
     wp_enqueue_script( 'menu-script', get_template_directory_uri() . '/assets/menu/navbar.js', array('jquery'), '4.6.0' );
    
	/*Custom Scripts*/
	wp_enqueue_script( 'springy-custom', get_template_directory_uri() . '/assets/js/custom.js', array(), '20200430', true );
    
	global $wp_query;
    $paged = ( get_query_var( 'paged' ) > 1 ) ? get_query_var( 'paged' ) : 1;
    $max_num_pages = $wp_query->max_num_pages;

    wp_localize_script( 'springy-custom', 'springy_ajax', array(
        'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
        'paged'     => $paged,
        'max_num_pages'      => $max_num_pages,
        'next_posts'      => next_posts( $max_num_pages, false ),
        'show_more'      => __( 'View More', 'springy' ),
        'no_more_posts'        => __( 'No More', 'springy' ),
    ));

	wp_enqueue_script( 'springy-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20200430', true );

	/*Sticky Sidebar*/
	global $springy_theme_options;
	if( 1 == absint($springy_theme_options['springy-enable-sticky-sidebar'])) {
		wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.js', array(), '20200430', true );
        wp_enqueue_script( 'springy-sticky-sidebar', get_template_directory_uri() . '/assets/js/custom-sticky-sidebar.js', array(), '20200430', true );
	}
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script('comment-reply');
    }
}
add_action( 'wp_enqueue_scripts', 'springy_scripts' );

/**
 * Enqueue fonts for the editor style
 */
function springy_block_styles() {
    wp_enqueue_style( 'springy-editor-styles', get_theme_file_uri( 'css/editor-styles.css' ) );

    wp_enqueue_style('springy-editor-body', '//fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&display=swap', array(), null);
    /*heading  */
    wp_enqueue_style('springy-editor-heading', '//fonts.googleapis.com/css?family=Prata&display=swap', array(), null);

    $springy_custom_css = '
    .edit-post-visual-editor.editor-styles-wrapper{ font-family: Muli;}

    .editor-post-title__block .editor-post-title__input,
    .editor-styles-wrapper h1,
    .editor-styles-wrapper h2,
    .editor-styles-wrapper h3,
    .editor-styles-wrapper h4,
    .editor-styles-wrapper h5,
    .editor-styles-wrapper h6{font-family:Prata;} 
    ';

    wp_add_inline_style( 'springy-editor-styles', $springy_custom_css );
}

add_action( 'enqueue_block_editor_assets', 'springy_block_styles' );