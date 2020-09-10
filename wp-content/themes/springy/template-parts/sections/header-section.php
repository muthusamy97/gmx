<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Springy
 */
$GLOBALS['springy_theme_options'] = springy_get_options_value();
global $springy_theme_options;
$search_header = absint($springy_theme_options['springy_enable_search']);
$normal_menu = esc_attr($springy_theme_options['springy_primary_menu_transparent']);
$class_menu = ($normal_menu == 1 ) ? 'fixed-nav' : '';
?>

<header class="header-1">		
	<div class="mega_ts_menu">
         <div class="transparent-white <?php echo esc_attr($class_menu); ?>">
            <div class="nav-container clearfix_mn">	
				<div class="logo">
					<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
					else :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					endif;
					$springy_description = get_bloginfo( 'description', 'display' );
					if ( $springy_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $springy_description; /* WPCS: xss ok. */ ?></p>
					<?php endif; ?>
				</div>
				<!-- .site-logo -->
				<!-- hamburger -->
               	<button class="menu-box">
	               	<div class="hum-line line-1"></div>
	               	<div class="hum-line line-2"></div>
	               	<div class="hum-line line-3"></div>
               	</button><!-- end of menu-box -->
				<nav class="main-navigation">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'container' => 'ul',
						'menu_class'      => '',
					));
					?>
					<button class="btnc"><span class="ti-close"></span></button>
				</nav>
				<!-- end of nav -->
				<?php if( 1 == $search_header ){ ?>	               	
					<!-- search box -->
	               	<div class="right-nav">
		               	<div class="search-box-wrapper clearfix_ts">
		   	            	<a href="#0" class="search-box"><i class="ti-search"></i></a>
		   	            	<div class="search-input">
		   	            		<?php echo get_search_form(); ?>
		   	            	</div>
		               	</div>
	               </div>
				<?php } ?>
				
			</div>
		</div>
	</div>
</header>
<div class="main-content">
	

