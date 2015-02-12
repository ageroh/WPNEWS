<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/
$post_type = get_post_type();

//Check if gallery post type
if($post_type == 'galleries')
{
	get_template_part ("gallery");
	exit;
}
else
{
	//Get single post layout
	$pp_single_layout = get_post_meta($post->ID, 'post_layout', true);
	
//	echo "<div><code>";
//	global $wp_rewrite;
//	print_r ($wp_rewrite->rules);
//	echo "</code></div>";

	
	switch($pp_single_layout)
	{
		case "sidebar":
		default:
			get_template_part ("single-sidebar");
		break;
		
		case "left_sidebar":
			get_template_part ("single-left-sidebar");
		break;
		
		case "fullwidth":
			get_template_part ("single-fullwidth");
		break;
	}

	

}

?>