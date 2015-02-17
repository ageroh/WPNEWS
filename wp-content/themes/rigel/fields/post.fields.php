<?php
/*
	Begin creating custom fields
*/

function post_type_galleries() {
	$labels = array(
    	'name' => _x('Galleries', 'post type general name', THEMEDOMAIN),
    	'singular_name' => _x('Gallery', 'post type singular name', THEMEDOMAIN),
    	'add_new' => _x('Add New Gallery', 'book', THEMEDOMAIN),
    	'add_new_item' => __('Add New Gallery', THEMEDOMAIN),
    	'edit_item' => __('Edit Gallery', THEMEDOMAIN),
    	'new_item' => __('New Gallery', THEMEDOMAIN),
    	'view_item' => __('View Gallery', THEMEDOMAIN),
    	'search_items' => __('Search Gallery', THEMEDOMAIN),
    	'not_found' =>  __('No Gallery found', THEMEDOMAIN),
    	'not_found_in_trash' => __('No Gallery found in Trash', THEMEDOMAIN), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail'),
    	'menu_icon' => get_template_directory_uri().'/functions/images/sign.png'
	); 		

	register_post_type( 'galleries', $args );  
} 
								  
add_action('init', 'post_type_galleries');

//Get all published galleries
$args = array(
    'numberposts' => -1,
    'post_type' => array('galleries'),
);

$galleries_arr = get_posts($args);
$galleries_select = array();
$galleries_select[''] = '';

foreach($galleries_arr as $gallery)
{
	$galleries_select[$gallery->ID] = $gallery->post_title;
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
	'Single Post Sidebar' => 'Single Post Sidebar',
	'Gallery Sidebar' => 'Gallery Sidebar'
);
$dynamic_sidebar = get_option('pp_sidebar');

if(!empty($dynamic_sidebar))
{
	foreach($dynamic_sidebar as $sidebar)
	{
		$theme_sidebar[$sidebar] = $sidebar;
	}
}

$postmetas = 
    array (
    	
    	'post' => array(
    		
    		/*
    		    Begin Post custom fields
    		*/
    		array(
    		"section" => "Post Layout", "id" => "post_layout", "type" => "select", "title" => "Post Layout", "description" => "Select single post page layout for this post.", 
				"items" => array(
					"sidebar" => "Right Sidebar",
					"left_sidebar" => "Left Sidebar",
					"fullwidth" => "Fullwidth",
				)),
			array("section" => "Post Sidebar", "id" => "post_sidebar", "type" => "select", "title" => "Post Sidebar", "description" => "You can select a sidebar to display on this post.", "items" => $theme_sidebar),
    		array(
    		"section" => "Featured Content Type", "id" => "post_ft_type", "type" => "select", "title" => "Featured Content Type", "description" => "Select featured content type for this post. Different content type will be displayed on single post page", 
				"items" => array(
					"Standard Image" => "Standard Image",
					"Custom NEWS" => "Custom NEWS",				// Custom. ARG: 17/02/2015 custom post_ft_type 
					"Fullwidth Image" => "Fullwidth Image",
					"Standard Vimeo Video" => "Standard Vimeo Video",
					"Fullwidth Vimeo Video" => "Fullwidth Vimeo Video",
					"Standard Youtube Video" => "Standard Youtube Video",
					"Fullwidth Youtube Video" => "Fullwidth Youtube Video",
					"Self-Hosted Video" => "Self-Hosted Video",
					"Sound Cloud Audio" => "Sound Cloud Audio",
					"Self-Hosted Audio" => "Self-Hosted Audio",
					"Gallery" => "Gallery",
				)),
				
			array("section" => "Gallery", "id" => "post_ft_gallery", "type" => "select", "title" => "Gallery", "description" => "Please select a gallery (*Note enter if you select \"Gallery\" as Featured Content Type))", "items" => $galleries_select),
				
			array("section" => "Vimeo Video ID", "id" => "post_ft_vimeo", "type" => "text", "title" => "Vimeo Video ID", "description" => "Please enter Vimeo Video ID for example 73317780 (*Note enter if you select \"Vimeo Video\" as Featured Content Type)"),
			
			array("section" => "Youtube Video ID", "id" => "post_ft_youtube", "type" => "text", "title" => "Youtube Video ID", "description" => "Please enter Youtube Video ID for example 6AIdXisPqHc (*Note enter if you select \"Youtube Video\" as Featured Content Type)"),
			
			array("section" => "Self-Hosted Video URL", "id" => "post_ft_video", "type" => "file", "title" => "Self-Hosted Video URL", "description" => "Please enter video URL support file type *.mp4 for example http://video-js.zencoder.com/oceans-clip.mp4 (*Note enter if you select \"Self-Hosted Video\" as Featured Content Type)"),
			
			array("section" => "Sound Cloud Widget Code", "id" => "post_ft_sound_cloud", "type" => "textarea", "title" => "Sound Cloud Widget Code", "description" => "Please enter Sound Cloud Widget Code. You can find it on Sould Cloud Audio Page > Share > Widget Code (*Note enter if you select \"Sound Cloud Audio\" as Featured Content Type)"),
			
			array("section" => "Self-Hosted Audio", "id" => "post_ft_audio", "type" => "file", "title" => "Self-Hosted Audio", "description" => "Support file type *.mp3"),
    
    		/*
    		    End Post custom fields
    		*/
    	)
);

function create_meta_box() {

	global $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}
	
	if ( function_exists('add_meta_box') && isset($postmetas) && count($postmetas) > 0 ) {  
		foreach($postmetas as $key => $postmeta)
		{
			if($_GET['post_type']==$key && !empty($postmeta))
			{
				add_meta_box( 'metabox', ucfirst($key).' Options', 'new_meta_box', $key, 'side', 'high' );  
			}
		}
	}

}  

function new_meta_box() {
	global $post, $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}

	echo '<input type="hidden" name="myplugin_noncename" id="myplugin_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	$meta_section = '';

	foreach ( $postmetas as $key => $postmeta ) {
	
		if($_GET['post_type'] == $key)
		{
		
			foreach ( $postmeta as $each_meta ) {
		
				$meta_id = $each_meta['id'];
				$meta_title = $each_meta['title'];
				$meta_description = $each_meta['description'];
				
				$meta_section = '';
				if(isset($postmeta['section']))
				{
					$meta_section = $postmeta['section'];
				}
				
				$meta_hide = '';
				if(isset($postmeta['hide']))
				{
					$meta_hide = $each_meta['hide'];
				}
				
				$meta_style = '';
				if($meta_hide)
				{
					$meta_style = 'style="display:none" class="meta_wrapper"';
				}
				
				$meta_type = '';
				if(isset($each_meta['type']))
				{
					$meta_type = $each_meta['type'];
				}
				
				echo '<div id="'.$meta_id.'_wrapper" '.$meta_style.'>';
				echo "<br/><strong>".$meta_title."</strong><hr class='pp_widget_hr'/>";
				echo "<div class='pp_widget_description'>$meta_description</div>";
				
				if ($meta_type == 'checkbox') {
					$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
					echo "<input type='checkbox' class='iphone_checkboxes' name='$meta_id' id='$meta_id' value='1' $checked /><br class='clear'/><br/><br/>";
				}
				else if ($meta_type == 'select') {
					echo "<p><select name='$meta_id' id='$meta_id'>";
					
					if(!empty($each_meta['items']))
					{
						foreach ($each_meta['items'] as $key => $item)
						{
							echo '<option value="'.$key.'"';
							
							if($key == get_post_meta($post->ID, $meta_id, true))
							{
								echo ' selected ';
							}
							
							echo '>'.$item.'</option>';
						}
					}
					
					echo "</select></p>";
					
				}
				else if ($meta_type == 'textarea') {
					echo "<p><textarea name='$meta_id' id='$meta_id' class='code' style='width:100%' rows='3'>".get_post_meta($post->ID, $meta_id, true)."</textarea></p>";
				}
				else if ($meta_type == 'jslider') {
					$slider_value = get_post_meta($post->ID, $meta_id, true);
					if(!empty($slider_value))
					{
						echo "<p><input name='$meta_id' id='$meta_id' type='text' class='jslider' value='".get_post_meta($post->ID, $meta_id, true)."'/></p>";
					}
					else
					{	
						echo "<p><input name='$meta_id' id='$meta_id' type='text' class='jslider' value='0'/></p>";
					}
					echo "<script>jQuery('#".$meta_id."').slider({ from: ".$each_meta['from'].", to: ".$each_meta['to'].", step: ".$each_meta['step'].", smooth: true, skin: 'round_plastic' });</script>";
				}		
				else if ($meta_type == 'date') { 
					echo "<p><input type='text' name='$meta_id' id='$meta_id' class='pp_date' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
				}
				else if ($meta_type == 'date_raw') { 
					echo "<p><input id='".$meta_id."' name='".$meta_id."' type='text' value='".get_post_meta($post->ID, $meta_id, true)."' /></p>";
				}
				else if ($meta_type == 'time') { 
					echo "<p><input type='text' name='$meta_id' id='$meta_id' class='pp_time' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
				}
				else if ($meta_type == 'file') { 
					echo "<p><input type='text' name='$meta_id' id='$meta_id' class='code' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /><input id='".$meta_id."_button' name='".$meta_id."_button' type='button' value='Upload' class='metabox_upload_btn button' readonly='readonly' rel='".$meta_id."' style='margin:7px 0 0 0' /></p>";
				}
				else {
					echo "<p><input type='text' name='$meta_id' id='$meta_id' class='code' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
				}
				
				echo '</div>';
			}
		}
	}

}

function save_postdata( $post_id ) {

	global $postmetas;

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

	foreach ( $postmetas as $postmeta ) {
		foreach ( $postmeta as $each_meta ) {
			/*echo '<pre>';
			var_dump($_POST[$each_meta['id']]);
			echo '</pre>';*/
			if (isset($_POST[$each_meta['id']]) && $_POST[$each_meta['id']]) {
				update_custom_meta($post_id, $_POST[$each_meta['id']], $each_meta['id']);
			}
			
			if (isset($_POST[$each_meta['id']]) && $_POST[$each_meta['id']] == "") {
				delete_post_meta($post_id, $each_meta['id']);
			}
			
			if (!isset($_POST[$each_meta['id']])) {
				delete_post_meta($post_id, $each_meta['id']);
			}
		
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
				if(isset($_POST[$ppb_item_arr.'_data']))
				{
					page_update_custom_meta($post_id, $_POST[$ppb_item_arr.'_data'], $ppb_item_arr.'_data');
				}
				
				if(isset($_POST[$ppb_item_arr.'_size']))
				{
					page_update_custom_meta($post_id, $_POST[$ppb_item_arr.'_size'], $ppb_item_arr.'_size');
				}
			}
		}
	}

}

function update_custom_meta($postID, $newvalue, $field_name) {

	if (!get_post_meta($postID, $field_name)) {
		add_post_meta($postID, $field_name, $newvalue);
	} else {
		update_post_meta($postID, $field_name, $newvalue);
	}

}

//init

add_action('admin_menu', 'create_meta_box'); 
add_action('save_post', 'save_postdata'); 

/*
	End creating custom fields
*/

add_filter( 'manage_posts_columns', 'rt_add_gravatar_col');
function rt_add_gravatar_col($cols) {
	$cols['thumbnail'] = __('Thumbnail', THEMEDOMAIN);
	return $cols;
}

add_action( 'manage_posts_custom_column', 'rt_get_author_gravatar');
function rt_get_author_gravatar($column_name ) {
	if ( $column_name  == 'thumbnail'  ) {
		echo get_the_post_thumbnail(get_the_ID(), array(100, 100));
	}
}

?>