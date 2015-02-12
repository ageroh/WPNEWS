<?php
function themegoods_customize_register( $wp_customize ) {
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('background_image');
}
add_action( 'customize_register', 'themegoods_customize_register' );
?>