<?php
/**
*	Setup Theme
**/
$theme_obj = wp_get_theme('rigel');

define("THEMENAME", "Rigel");
define("THEMEDEMO", FALSE);
define("SHORTNAME", "pp");
define("THEMEVERSION", $theme_obj['Version']);
define("THEMEDEMOSLIDEOFFSET", 3);
define("THEMEDOMAIN", THEMENAME.'Language');
define("THEMEDEMOURL", 'http://themes.themegoods2.com/rigel');
define("THEMEDATEFORMAT", get_option('date_format'));

//Get default WP uploads folder
$wp_upload_arr = wp_upload_dir();
define("THEMEUPLOAD", $wp_upload_arr['basedir']."/".strtolower(THEMENAME)."/");
define("THEMEUPLOADURL", $wp_upload_arr['baseurl']."/".strtolower(THEMENAME)."/");

/**
*	Defined all custom font elements
**/
$gg_fonts = array(SHORTNAME.'_page_header_font', SHORTNAME.'_ppb_header_font', SHORTNAME.'_ppb_desc_font', SHORTNAME.'_post_header_font', SHORTNAME.'_button_font', SHORTNAME.'_menu_font', SHORTNAME.'_breaking_news_font', SHORTNAME.'_header_tags_font', SHORTNAME.'_sidebar_title_font', SHORTNAME.'_body_font');
global $gg_fonts;

/**
*	Setup CSS and JS compression library
**/

$pp_advance_combine_css = get_option('pp_advance_combine_css');
	    
if (!empty($pp_advance_combine_css) && !class_exists('CSSMin')) 
{
	include (get_template_directory() . "/lib/cssmin.lib.php");
}

$pp_advance_combine_js = get_option('pp_advance_combine_js');
	
if (!empty($pp_advance_combine_js) && !class_exists('JSMin')) 
{
	include (get_template_directory() . "/lib/jsmin.lib.php");
}

/**
*	Setup Translation File
**/
include (get_template_directory() . "/lib/translation.lib.php");

/**
*	Setup Admin Menu
**/
include (get_template_directory() . "/lib/admin.lib.php");

/**
*	Themes API call
**/
include (get_template_directory() . "/lib/api.lib.php");

/**
*	Setup Theme post custom fields
**/
include (get_template_directory() . "/fields/post.fields.php");

/**
*	Setup Theme page custom fields
**/
include (get_template_directory() . "/fields/page.fields.php");

/**
*	Setup Gallery module
**/
include (get_template_directory() . "/fields/gallery/tg-gallery.php");

/**
*	Setup Theme thumbnail and image size
**/
include (get_template_directory() . "/lib/images.lib.php");

/**
*	Setup Sidebar
**/
include (get_template_directory() . "/lib/sidebar.lib.php");

/**
*	Get custom function
**/
include (get_template_directory() . "/lib/custom.lib.php");

/**
* Get Content Builder Module
**/
include (get_template_directory() . "/lib/contentbuilder.lib.php");

/**
*	Get custom shortcode
**/
include (get_template_directory() . "/lib/shortcode.lib.php");

/**
*	Get custom widgets
**/
include (get_template_directory() . "/lib/widgets.lib.php");

/**
*	Setup Menu
**/
include (get_template_directory() . "/lib/menu.lib.php");

/**
*	Setup Theme customizer
**/
include (get_template_directory() . "/lib/customize.lib.php");


/**
*	Setup AJAX search function
**/
add_action('wp_ajax_pp_ajax_search', 'pp_ajax_search');
add_action('wp_ajax_nopriv_pp_ajax_search', 'pp_ajax_search');

function pp_ajax_search() {
	global $wpdb;
	
	if (strlen($_POST['s'])>0) {
		$limit=5;
		$s=strtolower(addslashes($_POST['s']));
		$querystr = "
			SELECT $wpdb->posts.*
			FROM $wpdb->posts
			WHERE 1=1 AND ((lower($wpdb->posts.post_title) like '%$s%'))
			AND (post_status = 'publish')
			ORDER BY $wpdb->posts.post_date DESC
			LIMIT $limit;
		 ";

	 	$pageposts = $wpdb->get_results($querystr, OBJECT);
	 	
	 	if(!empty($pageposts))
	 	{
			echo '<ul>';
	
	 		foreach($pageposts as $result_item) 
	 		{
	 			$post=$result_item;
	 			
	 			$image_thumb = '';
			    if(has_post_thumbnail($post->ID, 'thumbnail'))
				{
				    $image_id = get_post_thumbnail_id($post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
				}
	 			
				echo '<li>';
				
				if(isset($image_thumb[0]) && !empty($image_thumb[0]))
				{
					echo '<a href="'.get_permalink($post->ID).'"><img src="'.$image_thumb[0].'" width="50" height="50" class="alignright" style="margin-top:0;" alt=""/></a>';
				}
				
				echo '<div class="ajax_post" ';
				if(empty($image_thumb[0]))
				{
					echo 'style="width:100%"';
				}
				echo '>';
				echo '<a href="'.get_permalink($post->ID).'"><strong>'.$post->post_title.'</strong><br/>';
				echo '<span class="post_attribute full">'.date(THEMEDATEFORMAT, strtotime($post->post_date)).'</span></a>';
				echo '</div>';
				echo '</li>';
			}
			
			echo '<li class="view_all"><a href="javascript:jQuery(\'#searchform\').submit()">'.__( 'View all results', THEMEDOMAIN ).'</a></li>';
	
			echo '</ul>';
		}

	}
	else 
	{
		echo '';
	}
	die();

}


/**
*	Setup contact form mailing function
**/
add_action('wp_ajax_pp_contact_mailer', 'pp_contact_mailer');
add_action('wp_ajax_nopriv_pp_contact_mailer', 'pp_contact_mailer');

function pp_contact_mailer() {
	global $wpdb;
	
	if (isset($_GET['your_name'])) {
	
		//Get your email address
		$contact_email = get_option('pp_contact_email');
		$pp_contact_thankyou = __( 'Thank you! We will get back to you as soon as possible', THEMEDOMAIN );
		
		//Enter your email address, email from contact form will send to this addresss. Please enter inside quotes ('myemail@email.com')
		define('DEST_EMAIL', $contact_email);
		
		//Thankyou message when message sent
		define('THANKYOU_MESSAGE', $pp_contact_thankyou);
		
		//Error message when message can't send
		define('ERROR_MESSAGE', 'Oops! something went wrong, please try to submit later.');
		
		/*
		|
		| Begin sending mail
		|
		*/
		
		$from_name = $_GET['your_name'];
		$from_email = $_GET['email'];
		
		//Get contact subject
		if(!isset($_GET['subject']))
		{
			$contact_subject = _e( 'Email from contact form', THEMEDOMAIN );
		}
		else
		{
			$contact_subject = $_GET['subject'];
		}
		
		$headers = "";
	   	$headers.= 'From: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
	   	$headers.= 'Reply-To: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
	   	$headers.= 'Return-Path: '.$from_name.'<'.$from_email.'>'.PHP_EOL;        // these two to set reply address
		
		$message = 'Name: '.$from_name.PHP_EOL;
		$message.= 'Email: '.$from_email.PHP_EOL.PHP_EOL;
		$message.= 'Message: '.PHP_EOL.$_GET['message'];
		    
		
		if(!empty($from_name) && !empty($from_email) && !empty($message))
		{
			wp_mail(DEST_EMAIL, $contact_subject, $message, $headers);
			echo '<p>'.THANKYOU_MESSAGE.'</p>';
			
			die;
		}
		else
		{
			echo '<p>'.ERROR_MESSAGE.'</p>';
			
			die;
		}

	}
	else 
	{
		echo '<p>'.ERROR_MESSAGE.'</p>';
	}
	die();

}


/**
*	Setup content builder filterable blog function
**/
add_action('wp_ajax_pp_ajax_filter_blog', 'pp_ajax_filter_blog');
add_action('wp_ajax_nopriv_pp_ajax_filter_blog', 'pp_ajax_filter_blog');

function pp_ajax_filter_blog() {
	$current_page_template = 'page.php';
	if(isset($_POST['current_template']))
	{
		$current_page_template = $_POST['current_template'];
	}
	
	$items = 3;
	if(isset($_POST['items']))
	{
		$items = $_POST['items'];
	}

	//Get recent posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(isset($_POST['cat']) && !empty($_POST['cat']))
	{
		$args['category'] = $_POST['cat'];
	}
	
	$posts_arr = get_posts($args);
	$return_html = '';
	
	$count = 1;
	foreach($posts_arr as $key => $post)
	{
	    $image_thumb = '';
	    $return_html.= '<div class="ppb_column_post ppb_column entry_post slideUp animated'.$count.' ';
	    
	    if($current_page_template != 'page_sidebar.php')
	    {
	    	$return_html.= 'masonry ';
	    }
	    
	    if($current_page_template == 'page_sidebar.php')
	    {
	    	if($count%2==0)
	    	{ 
	    		$return_html.= 'last'; 
	    	}
	    }
	    else
	    {
	    	if($count%3==0)
	    	{ 
	    		$return_html.= 'last'; 
	    	}
	    }
	    
	    $return_html.= '" style="position:relative">';
	    
	    if(has_post_thumbnail($post->ID, 'blog_half_ft'))
	    {
	        $image_id = get_post_thumbnail_id($post->ID);
	        $image_thumb = wp_get_attachment_image_src($image_id, 'blog_half_ft', true);
	    }
	    
	    $return_html.= '<div class="post_wrapper full ppb_columns animated'.$count.' ';
	    
	    if($current_page_template != 'page_sidebar.php')
	    {
	    	$return_html.= 'masonry ';
	    }
	    
	    if($current_page_template == 'page_sidebar.php')
	    {
	    	if($count%2==0)
	    	{ 
	    		$return_html.= 'last'; 
	    	}
	    }
	    else
	    {
	    	if($count%3==0)
	    	{ 
	    		$return_html.= 'last'; 
	    	}
	    }

	    $return_html.= '">';
	    
	    if($current_page_template == 'page_sidebar.php')
	    {
	    	$return_html.= '<div class="post_inner_wrapper half">';
	    }
	    
	    if(isset($image_thumb[0]) && !empty($image_thumb))
	    {
	    	$return_html.= '<div class="post_img ';
	    	
	    	if($current_page_template == 'page_sidebar.php')
	    	{
	    		$return_html.= 'ppb_column_sidebar';
	    	}
	    	else
	    	{
	    		$return_html.= 'ppb_column_fullwidth';
	    	}
	    	
	    	$return_html.= ' " style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px">';
	    	
	    	$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
	    	$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft"/></a>';
	    	
	    	//Get post type
	        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
	    	
	    	//Get Post review score
	    	$post_review_score = get_review_score($post->ID);
	    	$post_percentage_score = $post_review_score*10;
	    	
	    	if(!empty($post_review_score))
	    	{
	    		$return_html.= '<div class="review_score_bg two_cols"><div class="review_point" style="width:'.$post_percentage_score.'%">'.$post_percentage_score.'%</div></div>';
	    	}
	    	
	    	$return_html.= '</div>';
	    }

	    $return_html.= '<div class="post_inner_wrapper half header">';
	    $return_html.= '<div class="post_header_wrapper half">';
	    $return_html.= '<div class="post_header half">';
	    $return_html.= '<h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
	    $return_html.= '</div></div>';
	    $return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 100).'</p>';
	    $return_html.= '<div class="post_detail grey space">';
			
		$return_html.= date(THEMEDATEFORMAT, strtotime($post->post_date));
		
		$author_firstname = get_the_author_meta('first_name', $post->post_author);
		$author_url = get_author_posts_url($post->post_author);
		
		if(!empty($author_firstname))
		{
		    $return_html.= '&nbsp;'.__( 'By', THEMEDOMAIN ).' <a href="'.$author_url.'">'.$author_firstname.'</a>';
		}
		
		if(comments_open($post->ID))
		{
		    $return_html.= '<div class="post_comment_count"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><i class="fa fa-comments-o"></i>'.get_comments_number($post->ID);
		    $return_html.= '</a></div>';
		}
		
		$return_html.= '</div></div><br class="clear"/></div>';
		$return_html.= '</div>';
			
		if($current_page_template != 'page_sidebar.php' && $count%3==0)
		{
		    $return_html.= '<br class="clear"/>';
		}
		
		if($current_page_template == 'page_sidebar.php' && $count%2==0)
		{
		    $return_html.= '<br class="clear"/>';
		}
		
		$count++;
		
		if($current_page_template == 'page_sidebar.php')
		{
		    $return_html.= '</div>';
		}
	}

	if(!empty($_POST['cat']))
	{
		$return_html.= '<a class="button view_all" href="'.get_category_link($_POST['cat']).'">'.__( 'Read Latest Posts From', THEMEDOMAIN ).' '.get_cat_name($_POST['cat']).'</a><br class="clear"/><br/>';
	}
	
	echo $return_html;
	
	die();
}


function translate_date_format($format) {
        if (function_exists('icl_translate'))
          $format = icl_translate('Formats', $format, $format);
return $format;
}
add_filter('option_date_format', 'translate_date_format');

/**
*	Setup Admin Action
**/
include (get_template_directory() . "/lib/admin-action.lib.php");


/**
*	Setup all theme's plugins
**/
include (get_template_directory() . "/modules/shortcode_generator.php");
include (get_template_directory() . "/modules/content_builder.php");
include (get_template_directory() . "/modules/aq_resizer.php");

// Setup Twitter API
include (get_template_directory() . "/modules/twitteroauth.php");


/**
 * Change default fields, add placeholder and change type attributes.
 *
 * @param  array $fields
 * @return array
 */
function wpse_62742_comment_placeholders( $fields )
{
    $fields['author'] = str_replace('<input', '<input placeholder="'. __('Name', THEMEDOMAIN). '"',$fields['author']);
    $fields['email'] = str_replace('<input id="email" name="email" type="text"', '<input type="email" placeholder="'.__('Email', THEMEDOMAIN).'"  id="email" name="email"',$fields['email']);
    $fields['url'] = str_replace('<input id="url" name="url" type="text"', '<input placeholder="'.__('Website', THEMEDOMAIN).'" id="url" name="url" type="url"',$fields['url']);

    return $fields;
}
add_filter( 'comment_form_default_fields', 'wpse_62742_comment_placeholders' );

function theme_slug_filter_the_content( $content ) {
	$custom_content = '';
	$pp_blog_display_editor_review = get_option('pp_blog_display_editor_review');
	$post_review_score = get_review_score(get_the_ID());
	
	if(function_exists('get_review_score') && !empty($pp_blog_display_editor_review) && is_single() && !empty($post_review_score)) 
	{
		$post_review_percent = $post_review_score*10;
		
		if($post_review_score>10)
		{
			$post_review_percent = $post_review_score;
		    $post_review_score = ($post_review_score/100)*10;
		}
		
		$get_meta = get_post_custom(get_the_ID());
		$post_review_summary = '';
		
		if(isset($get_meta['taq_review_summary'][0]))
		{
			$post_review_summary = $get_meta['taq_review_summary'][0];
		}
		
		if(THEMEDEMO && isset($_GET['rigelskin']) && !empty($_GET['rigelskin']))
		{
		    $pp_skin_color = '#'.$_GET['rigelskin'];
		}
		else
		{
			$pp_skin_color = get_option('pp_skin_color');
		}
		
		if(empty($pp_skin_color))
		{
			$pp_skin_color = '#f4b711';
		}
	
	    $custom_content = '<div class="edit_review_wrapper">
			<h5 class="edit_review_title">'. __('Editor\'s rating', THEMEDOMAIN).'</h5>
			<div class="edit_review_summary">'.$post_review_summary.'</div>
				<div class="visual_circle">
					<div class="visual_value">'.$post_review_score.'</div>
					<div id="review_circle" data-dimension="100" data-width="10" data-percent="'.$post_review_percent.'" data-fgcolor="'.$pp_skin_color.'" data-bgcolor="#ebebeb"></div>
				</div>
			</div>';
	}
	
	$custom_content .= $content;
	
    return $custom_content;
}
add_filter( 'the_content', 'theme_slug_filter_the_content' );

 
/*
 * Return a new number of maximum columns for shop archives
 * @param int Original value
 * @return int New number of columns
 */
function wc_loop_shop_columns( $number_columns ) {
	return 3;
}
add_filter( 'loop_shop_columns', 'wc_loop_shop_columns', 1, 10 );


if(THEMEDEMO)
{
	function add_my_query_var( $link ) 
	{
		$arr_params = array();
	
		if(isset($_GET['rigelstyle'])) 
		{
			$arr_params['rigelstyle'] = $_GET['rigelstyle'];
		}
		else
		{
	    	$arr_params['rigelstyle'] = 1;
	    }
	    
	    if(isset($_GET['rigellayout'])) 
		{
			$arr_params['rigellayout'] = $_GET['rigellayout'];
		}
		
		if(isset($_GET['rigelskin'])) 
		{
			$arr_params['rigelskin'] = $_GET['rigelskin'];
		}
		
		$link = add_query_arg( $arr_params, $link );
	    
	    return $link;
	}
	add_filter('category_link','add_my_query_var');
	
	add_filter('page_link','add_my_query_var');
	add_filter('post_link','add_my_query_var');
	add_filter('term_link','add_my_query_var');
	add_filter('tag_link','add_my_query_var');
	add_filter('category_link','add_my_query_var');
	add_filter('post_type_link','add_my_query_var');
	add_filter('attachment_link','add_my_query_var');
	add_filter('year_link','add_my_query_var');
	add_filter('month_link','add_my_query_var');
	add_filter('day_link','add_my_query_var');
	add_filter('search_link','add_my_query_var');
	
	add_filter('previous_post_link','add_my_query_var');
	add_filter('next_post_link','add_my_query_var');
	add_filter('home_url','add_my_query_var');
}



/**
 

 																		CUSTOM CODDE A.GEROGIANNIS 


 */
//START

add_action( 'init', 'add_custom_Tag_rules' );
function add_custom_Tag_rules() { 
    add_rewrite_rule(
        'tag/([0-9]{1,})/([^/]+).html',
        'index.php?tag=$matches[2]',
        'top');

    add_rewrite_rule(
        '([^/]+)/tag/([0-9]{1,})/([^/]+).html',
        'index.php?tag=$matches[3]',
        'top');

}





/**
Create custom Field over Posts - Display it on Admin edit and save. 	(Add all custom fields this way. :) 
*/

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'news_custom_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'news_custom_post_meta_boxes_setup' );

function news_custom_post_meta_boxes_setup() {
  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'news_custom_add_post_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'news_custom_save_post_class_meta_subtitle', 10, 2);
  add_action( 'save_post', 'news_custom_save_post_class_meta_lead', 10, 2);
  add_action( 'save_post', 'news_custom_save_post_class_meta_ribon', 10, 2);

}



/* Create one or more meta boxes to be displayed on the post editor screen. */
function news_custom_add_post_meta_boxes() {

  add_meta_box(
    '_article_details',      // Unique ID
    esc_html__( 'Τιτλοφορία', 'example' ),  // article details!
    '_article_details_Custom_meta_box',   	// Callback function
    'post',         						// Admin page (or post type)
    'advanced',         					// Context
    'high'         							// Priority
  );

}

/* Display the post meta box. */
function _article_details_Custom_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), '_subtitle_Custom_nonce' ); ?>

  <p>
    <label for="_subtitle_Custom"><?php _e( "Υπότιτλος", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="_subtitle_Custom" id="_subtitle_Custom" value="<?php echo esc_attr( get_post_meta( $object->ID, '_subtitle_Custom', true ) ); ?>" size="80" />
  </p>

  <p>
    <label for="_lead_Custom"><?php _e( "Περίληψη", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="_lead_Custom" id="_lead_Custom" value="<?php echo esc_attr( get_post_meta( $object->ID, '_lead_Custom', true ) ); ?>" size="200" />
  </p>

   <p>
    <label for="_ribon_Custom"><?php _e( "Ribon Φωτογραφίας", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="_ribon_Custom" id="_ribon_Custom" value="<?php echo esc_attr( get_post_meta( $object->ID, '_ribon_Custom', true ) ); ?>" size="50" />
  </p>

<?php }



function news_custom_save_post_class_meta_subtitle( $post_id, $post)
{
	return news_custom_save_post_class_meta( $post_id, $post, '_subtitle_Custom');
}


function news_custom_save_post_class_meta_lead( $post_id, $post)
{
	return news_custom_save_post_class_meta( $post_id, $post, '_lead_Custom');
}

function news_custom_save_post_class_meta_ribon( $post_id, $post)
{
	return news_custom_save_post_class_meta( $post_id, $post, '_ribon_Custom');
}


/* Save the meta box's post metadata. */
function news_custom_save_post_class_meta( $post_id, $post, $meta_key ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['_subtitle_Custom_nonce'] ) || !wp_verify_nonce( $_POST['_subtitle_Custom_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST[$meta_key] ) ? $_POST[$meta_key]  : '' );

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );

}



/**
Add a custom CSS and JS on HEADER 
*/
// Add custom CSS Class to BODY
function my_plugin_body_class($classes) {
    $classes[] = 'fooARGI';
    return $classes;
}
add_filter('body_class', 'my_plugin_body_class');

// Add some JS to header 
function wptuts_scripts_load_cdn()
{

    // Register the library 
    wp_register_script( 'custom_fonc_js_Alex', 'http://fast.fonts.net/jsapi/055aa3ff-1162-42a7-b6c4-6dc11489926a.js', array(), null, false );
     
    // Register the script like this for a plugin:
    //wp_register_script( 'custom-script', plugins_url( '/js/custom-script.js', __FILE__ ), array( 'jquery' ) );
    // or
    // Register the script like this for a theme:
    //wp_register_script( 'custom-script', get_template_directory_uri() . '/js/custom-script.js', array( 'jquery' ) );
 
 	wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom_script.css');

    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-style' );						// custom STYLE SHEET !!
    wp_enqueue_script( 'custom_fonc_js_Alex' );
}
add_action( 'wp_enqueue_scripts', 'wptuts_scripts_load_cdn' );


// Add custom MENU IMPORTANT TAGS TO HEADER OF EACH PAGE !
add_action('wp_head', 'wpse_Importantheader_wp_head');
function wpse_Importantheader_wp_head(){

	wp_nav_menu(
	    array(
		'menu' => 'ImportantHeader'
		// do not fall back to first non-empty menu
		, 'theme_location' => '__no_such_location'
		// do not fall back to wp_page_menu()
		, 'fallback_cb' => false
		, 'container_class' => 'navmenuImportant'
	  )
	);
	
}




/**
Replace "Posts" label with "Articles" in Admin Panel 
*/

// Replace Posts label as Articles in Admin Panel 
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Articles';
    $submenu['edit.php'][5][0] = 'Articles';
    $submenu['edit.php'][10][0] = 'Add Articles';
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Articles';
        $labels->singular_name = 'Article';
        $labels->add_new = 'Add Article';
        $labels->add_new_item = 'Add Article';
        $labels->edit_item = 'Edit Article';
        $labels->new_item = 'Article';
        $labels->view_item = 'View Article';
        $labels->search_items = 'Search Articles';
        $labels->not_found = 'No Articles found';
        $labels->not_found_in_trash = 'No Articles found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );





/**
								
								!!!!!	CUSTOM FUNTCTION TO CALL AND REMOVE ALL IMAGES FROM SERVER !!!!!	
(please remove completely when go live !! )  call: /?delete-featured-images=1 to delete all.
*/

add_action('init', 'foo_bar_delete_featured', 0);
function foo_bar_delete_featured(){

    # Check for logged in state
    if(!is_user_logged_in())
        return;

    # Check for admin role
    if(!current_user_can('manage_options'))
        return;

    # Check for query string
    if(isset($_GET['delete-featured-images']) && $_GET['delete-featured-images'] == 1){
        global $wpdb;

        # Run a DQL to get all featured image rows
        $attachments = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id'");

        foreach($attachments as $attachment){

            # Run a DML to remove this featured image row
            $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_id = '$attachment->meta_id' LIMIT 1");

            # Delete attachment DB rows and files
            wp_delete_attachment($attachment->meta_value, true);

            # Print to screen
            show_message('Attachment #$attachment->meta_value deleted.');
        }
        exit;
    }
}




//END
/**


 																	CUSTOM CODDE A.GEROGIANNIS 


 */



/**
*	Setup Admin Default Value and Formatter
**/
include (get_template_directory() . "/lib/admin-default.lib.php");
?>