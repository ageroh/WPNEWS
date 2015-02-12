<?php

/**
 * The PHP code for setup Theme page custom fields.
 *
 * @package WordPress
 */


/*
	Begin creating custom fields
*/

//Get all galleries
$args = array(
    'numberposts' => -1,
    'post_type' => array('gallery'),
);

$galleries_arr = get_posts($args);
$galleries_select = array();
$galleries_select[''] = '';

foreach($galleries_arr as $gallery)
{
	$galleries_select[$gallery->ID] = $gallery->post_title;
}

//Get all categories
$categories_arr = get_categories();
$categories_select = array();
$categories_select[''] = '';

foreach ($categories_arr as $cat) {
	$categories_select[$cat->cat_ID] = $cat->cat_name;
}

//Get all sidebars
$theme_sidebar = array(
	'' => '',
	'Home Sidebar' => 'Home Sidebar',
	'Page Sidebar' => 'Page Sidebar', 
	'Contact Sidebar' => 'Contact Sidebar',
	'Category Sidebar' => 'Category Sidebar',
	'Footer Sidebar' => 'Footer Sidebar',
	'Archive Sidebar' => 'Archive Sidebar',
	'Search Sidebar' => 'Search Sidebar',
	'Tag Sidebar' => 'Tag Sidebar', 
	'Single Post Sidebar' => 'Single Post Sidebar'
);
$dynamic_sidebar = get_option('pp_sidebar');

if(!empty($dynamic_sidebar))
{
	foreach($dynamic_sidebar as $sidebar)
	{
		$theme_sidebar[$sidebar] = $sidebar;
	}
}

//Get all slider style
$slider_options = array(
	'slider-full' => '1 Block Posts Slider',
	'slider' => '3 Blocks Posts Slider',
);

$page_postmetas = 
	array (
		/*
			Begin Page custom fields
		*/
		
		array("section" => "Page Header", "id" => "page_hide_header", "type" => "checkbox", "title" => "Hide Page Header", "description" => "Check this option if you want to hide page header. Recommend if you use this page as homepage"),
		
		array("section" => "Page Slider", "id" => "page_slider", "type" => "select", "title" => "Page Slider", "description" => "Check this option if you want to display slider at the top of this page. Please select a category posts to display for the slider", "items" => $categories_select),
		
		array("section" => "Page Slider Style", "id" => "page_slider_style", "type" => "select", "title" => "Page Slider Style", "description" => "Please select slider style for this page", "items" => $slider_options),
		
		array("section" => "Category", "id" => "page_cat", "type" => "select", "title" => "Category", "description" => "Please select a category posts to display on this page (*Note if you select category page template)", "items" => $categories_select),
		
		array("section" => "Page Sidebar", "id" => "page_sidebar", "type" => "select", "title" => "Page Sidebar", "description" => "Please select a sidebar to display on this page (*Note if you select sidebar enabled page template)", "items" => $theme_sidebar),
		
		/*
			End Page custom fields
		*/
		
	);
	
//Check if Layer slider is installed	
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$pp_layerslider_activated = is_plugin_active('LayerSlider/layerslider.php');
	
$wp_layersliders = array();

if(!empty($pp_layerslider_activated))
{
	//Get WPDB Object
	global $wpdb;
	
	//Table name
	$table_name = $wpdb->prefix . "layerslider";
	
	//Get LayerSliders
	$wp_layersliders = array();
	
	$sliders_obj = $wpdb->get_results( "SELECT * FROM $table_name WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY date_c ASC LIMIT 100" );
	$wp_layersliders = array(
	    -1		=> "",
	);
	foreach ($sliders_obj as $slider ) {
	    $wp_layersliders[$slider->id] = $slider->name;
	}
	
	$page_postmetas[] = array("section" => "LayerSlider", "id" => "page_layerslider", "type" => "select", "title" => "Page LayerSlider", "description" => "Select LayerSlider for this page. It will displays at the top of page.", "items" => $wp_layersliders);
}
else
{
	$wp_layersliders[-1] = 'Please Install LayerSlider Plugin to use this option';
}
?>
<?php

function page_create_meta_box() {

	global $page_postmetas;
	if ( function_exists('add_meta_box') && isset($page_postmetas) && count($page_postmetas) > 0 ) {  
		add_meta_box( 'page_metabox', 'Page Options', 'page_new_meta_box', 'page', 'side', 'high' );  
	}

}  

function page_new_meta_box() {
	global $post, $page_postmetas;

	echo '<input type="hidden" name="myplugin_noncename" id="myplugin_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	echo '<br/>';
	
	$meta_section = '';

	foreach ( $page_postmetas as $postmeta ) {

		$meta_id = $postmeta['id'];
		$meta_title = $postmeta['title'];
		$meta_description = $postmeta['description'];
		$meta_section = $postmeta['section'];
		
		$meta_type = '';
		if(isset($postmeta['type']))
		{
			$meta_type = $postmeta['type'];
		}
		
		echo "<strong>".$meta_title."</strong><hr class='pp_widget_hr'/>";

		echo "<div class='pp_widget_description'>$meta_description</div>";

		if ($meta_type == 'checkbox') {
			$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
			echo "<br style='clear:both'><input type='checkbox' name='$meta_id' id='$meta_id' class='iphone_checkboxes' value='1' $checked /><br style='clear:both'><br/><br/>";
		}
		else if ($meta_type == 'select') {
			echo "<p><select name='$meta_id' id='$meta_id'>";
			
			if(!empty($postmeta['items']))
			{
				foreach ($postmeta['items'] as $key => $item)
				{
					$page_style = get_post_meta($post->ID, $meta_id);
				
					if(isset($page_style[0]) && $key == $page_style[0])
					{
						$css_string = 'selected';
					}
					else
					{
						$css_string = '';
					}
				
					echo '<option value="'.$key.'" '.$css_string.'>'.$item.'</option>';
				}
			}
			
			echo "</select></p><br/>";
		}
		else {
			echo "<p><input type='text' name='$meta_id' id='$meta_id' class='code' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
		}
	}
	
	echo '<br/>';

}

function page_save_postdata( $post_id ) {

	global $page_postmetas;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( isset($_POST['myplugin_noncename']) && !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

	// Check permissions

	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated

	if ( $parent_id = wp_is_post_revision($post_id) )
	{
		$post_id = $parent_id;
	}

	foreach ( $page_postmetas as $postmeta ) {
	
		if (isset($_POST[$postmeta['id']]) && $_POST[$postmeta['id']]) {
			page_update_custom_meta($post_id, $_POST[$postmeta['id']], $postmeta['id']);
		}

		if (isset($_POST[$postmeta['id']]) && $_POST[$postmeta['id']] == "") {
			delete_post_meta($post_id, $postmeta['id']);
		}
		
		if (!isset($_POST[$postmeta['id']])) {
			delete_post_meta($post_id, $postmeta['id']);
		}
	}
	
	// Saving Page Builder Data
	if(isset($_POST['ppb_enable']) && !empty($_POST['ppb_enable']))
	{
		page_update_custom_meta($post_id, $_POST['ppb_enable'], 'ppb_enable');
	}
	else
	{
		delete_post_meta($post_id, 'ppb_enable');
	}
	
	if(isset($_POST['ppb_form_data_order']))
	{
		page_update_custom_meta($post_id, $_POST['ppb_form_data_order'], 'ppb_form_data_order');
		
		$ppb_item_arr = explode(',', $_POST['ppb_form_data_order']);
		if(is_array($ppb_item_arr) && !empty($ppb_item_arr))
		{
			foreach($ppb_item_arr as $key => $ppb_item_arr)
			{
				if(isset($_POST[$ppb_item_arr.'_data']) && !empty($_POST[$ppb_item_arr.'_data']))
				{
					page_update_custom_meta($post_id, $_POST[$ppb_item_arr.'_data'], $ppb_item_arr.'_data');
				}
				
				if(isset($_POST[$ppb_item_arr.'_size']) && !empty($_POST[$ppb_item_arr.'_size']))
				{
					page_update_custom_meta($post_id, $_POST[$ppb_item_arr.'_size'], $ppb_item_arr.'_size');
				}
			}
		}
	}

}

function page_update_custom_meta($postID, $newvalue, $field_name) {

	if (!get_post_meta($postID, $field_name)) {
		add_post_meta($postID, $field_name, $newvalue);
	} else {
		update_post_meta($postID, $field_name, $newvalue);
	}

}

//init

add_action('admin_menu', 'page_create_meta_box'); 
add_action('save_post', 'page_save_postdata'); 

/*
	End creating custom fields
*/

?>
