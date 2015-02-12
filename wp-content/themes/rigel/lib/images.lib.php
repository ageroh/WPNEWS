<?php
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
}

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'blog_ft', 726, 400, true );
	add_image_size( 'blog_single_full', 960, 430, true );
	add_image_size( 'blog_square', 300, 300, true );
	add_image_size( 'slider_main_ft', 660, 420, true );
}
?>