<?php

function dropcap_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'style' => ''
	), $atts));

	//get first char
	$first_char = substr($content, 0, 1);
	$text_len = strlen($content);
	$rest_text = substr($content, 1, $text_len);

	$return_html = '<span class="dropcap '.$style.'">'.$first_char.'</span>';
	$return_html.= do_shortcode($rest_text);
	$return_html.= '<br class="clear"/><br/>';

	return $return_html;
}
add_shortcode('dropcap', 'dropcap_func');


function quote_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'align' => '',
		'width' => '',
	), $atts));

	$return_html = '<blockquote class="'.$align.'" style="width:'.$width.';">'.do_shortcode($content).'</blockquote>';

	return $return_html;
}
add_shortcode('quote', 'quote_func');


function pre_func($atts, $content) {
	$return_html = '<pre>'.strip_tags($content).'</pre>';

	return $return_html;
}
add_shortcode('pre', 'pre_func');


function button_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'href' => '',
		'align' => '',
		'bg_color' => '',
		'text_color' => '',
		'size' => 'small',
		'style' => '',
		'color' => '',
		'target' => '_self',
	), $atts));

	if(!empty($color))
	{
		switch(strtolower($color))
		{
			case 'black':
				$bg_color = '#000000';
				$text_color = '#ffffff';
			break;

			case 'grey':
				$bg_color = '#7F8C8D';
				$text_color = '#ffffff';
			break;

			case 'white':
				$bg_color = '#f5f5f5';
				$text_color = '#444444';
			break;

			case 'blue':
				$bg_color = '#3498DB';
				$text_color = '#ffffff';
			break;

			case 'yellow':
				$bg_color = '#F1C40F';
				$text_color = '#ffffff';
			break;

			case 'red':
				$bg_color = '#E74C3C';
				$text_color = '#ffffff';
			break;

			case 'orange':
				$bg_color = '#ff9900';
				$text_color = '#ffffff';
			break;

			case 'green':
				$bg_color = '#2ECC71';
				$text_color = '#ffffff';
			break;

			case 'pink':
				$bg_color = '#ed6280';
				$text_color = '#ffffff';
			break;

			case 'purple':
				$bg_color = '#9B59B6';
				$text_color = '#ffffff';
			break;
		}
	}
	
	if(!empty($bg_color))
	{
		$border_color = $bg_color;
	}
	else
	{
		$border_color = 'transparent';
	}
	
	//Get darker shadow color
	$shadow_color = '#'.hex_darker(substr($bg_color, 1), 12);
	
	if(!empty($bg_color))
	{
		$return_html = '<a class="button '.$size.' '.$align.'" style="background-color:'.$bg_color.' !important;border:1px solid '.$border_color.' !important;color:'.$text_color.' !important;'.$style.'"';
	}
	else
	{
		$return_html = '<a class="button '.$size.' '.$align.'"';
	}
	

	if(!empty($href))
	{
		$return_html.= ' onclick="window.open(\''.$href.'\', \''.$target.'\')"';
	}

	$return_html.= '>'.$content.'</a>';

	return $return_html;

}
add_shortcode('button', 'button_func');


function highlight_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'type' => 'yellow',
	), $atts));
	
	$return_html = '';
	$return_html.= '<span class="highlight_'.$type.'">'.strip_tags($content).'</span>';

	return $return_html;
}
add_shortcode('highlight', 'highlight_func');


function one_half_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	$return_html = '<div class="one_half '.$class.'">'.do_shortcode($content).'</div>';

	return $return_html;
}
add_shortcode('one_half', 'one_half_func');


function one_half_last_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	$return_html = '<div class="one_half last '.$class.'">'.do_shortcode($content).'</div><br class="clear"/>';

	return $return_html;
}
add_shortcode('one_half_last', 'one_half_last_func');


function one_third_func($atts, $content) {
	$return_html = '<div class="one_third">'.do_shortcode($content).'</div>';

	return $return_html;
}
add_shortcode('one_third', 'one_third_func');


function one_third_last_func($atts, $content) {
	$return_html = '<div class="one_third last">'.do_shortcode($content).'</div><br class="clear"/>';

	return $return_html;
}
add_shortcode('one_third_last', 'one_third_last_func');


function two_third_func($atts, $content) {
	$return_html = '<div class="two_third">'.do_shortcode($content).'</div>';

	return $return_html;
}
add_shortcode('two_third', 'two_third_func');


function two_third_last_func($atts, $content) {
	$return_html = '<div class="two_third last">'.do_shortcode($content).'</div><br class="clear"/>';

	return $return_html;
}
add_shortcode('two_third_last', 'two_third_last_func');


function one_fourth_func($atts, $content) {
	$return_html = '<div class="one_fourth">'.do_shortcode($content).'</div>';

	return $return_html;
}
add_shortcode('one_fourth', 'one_fourth_func');


function one_fourth_last_func($atts, $content) {
	$return_html = '<div class="one_fourth last">'.do_shortcode($content).'</div><br class="clear"/>';

	return $return_html;
}
add_shortcode('one_fourth_last', 'one_fourth_last_func');


function one_fifth_func($atts, $content) {
	$return_html = '<div class="one_fifth">'.do_shortcode($content).'</div>';

	return $return_html;
}
add_shortcode('one_fifth', 'one_fifth_func');


function one_fifth_last_func($atts, $content) {
	$return_html = '<div class="one_fifth last">'.do_shortcode($content).'</div><br class="clear"/>';

	return $return_html;
}
add_shortcode('one_fifth_last', 'one_fifth_last_func');


function one_sixth_func($atts, $content) {
	$return_html = '<div class="one_sixth">'.do_shortcode($content).'</div>';

	return $return_html;
}
add_shortcode('one_sixth', 'one_sixth_func');


function one_sixth_last_func($atts, $content) {
	$return_html = '<div class="one_sixth last">'.do_shortcode($content).'</div><br class="clear"/>';

	return $return_html;
}
add_shortcode('one_sixth_last', 'one_sixth_last_func');


function accordion_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'close' => 0,
	), $atts));

	$close_class = '';

	if(!empty($close))
	{
		$close_class = 'pp_accordion_close';
	}
	else
	{
		$close_class = 'pp_accordion';
	}

	//Add jquery ui script dynamically
	wp_enqueue_script("jquery-ui-core");
	wp_enqueue_script("jquery-ui-accordion");
	wp_enqueue_script('custom-accordion', get_stylesheet_directory_uri()."/js/custom-accordion.js", false, THEMEVERSION, true);

	$return_html = '<div class="'.$close_class.'"><h3><a href="#">'.$title.'</a></h3>';
	$return_html.= '<div><p>';
	$return_html.= do_shortcode($content);
	$return_html.= '</p></div></div>';

	return $return_html;
}

add_shortcode('accordion', 'accordion_func');


function pp_pre_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'close' => 1,
	), $atts));

	$return_html = '';
	$return_html.= '<pre>';
	$return_html.= $content;
	$return_html.= '</pre>';

	return $return_html;
}

add_shortcode('pp_pre', 'pp_pre_func');


function tabs_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'tab1' => '',
		'tab2' => '',
		'tab3' => '',
		'tab4' => '',
		'tab5' => '',
		'tab6' => '',
		'tab7' => '',
		'tab8' => '',
		'tab9' => '',
		'tab10' => '',
	), $atts));
	
	$tab_arr = array(
		$tab1,
		$tab2,
		$tab3,
		$tab4,
		$tab5,
		$tab6,
		$tab7,
		$tab8,
		$tab9,
		$tab10,
	);

	//Add jquery ui script dynamically
	wp_enqueue_script("jquery-ui-core");
	wp_enqueue_script("jquery-ui-tabs");
	wp_enqueue_script('custom-tab', get_stylesheet_directory_uri()."/js/custom-tab.js", false, THEMEVERSION, true);

	$return_html = '<div class="tabs"><ul>';

	foreach($tab_arr as $key=>$tab)
	{
		//display title1
		if(!empty($tab))
		{
			$return_html.= '<li><a href="#tabs-'.($key+1).'">'.$tab.'</a></li>';
		}
	}

	$return_html.= '</ul>';
	$return_html.= do_shortcode($content);
	$return_html.= '</div>';

	return $return_html;
}

add_shortcode('tabs', 'tabs_func');


function tab_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'id' => '',
	), $atts));
	
	$return_html = '';
	$return_html.= '<div id="tabs-'.$id.'" class="tab_wrapper">'.$content.'</div>';

	return $return_html;
}
add_shortcode('tab', 'tab_func');


function tg_map_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'width' => 400,
		'height' => 300,
		'lat' => 0,
		'long' => 0,
		'zoom' => 12,
		'type' => '',
		'popup' => '',
		'address' => '',
	), $atts));

	$custom_id = time().rand();
	$return_html = '<div class="map_shortcode_wrapper" id="map'.$custom_id.'" style="width:'.$width.'px;height:'.$height.'px"></div>';
	
	$ext_attr = array(
		'id' => 'map'.$custom_id,
		'lat' => $lat,
		'long' => $long,
		'zoom' => $zoom,
		'type' => $type,
		'popup' => $popup,
		'address' => $address,
	);
	
	$ext_attr_serialize = serialize($ext_attr);
	
	wp_enqueue_script("google_maps", "http://maps.google.com/maps/api/js?sensor=false", false, THEMEVERSION, true);
	wp_enqueue_script("gmap_js", get_stylesheet_directory_uri()."/js/gmap.js", false, THEMEVERSION, true);
	wp_enqueue_script("script-contact-map".$custom_id, get_stylesheet_directory_uri()."/templates/script-shortcode-map.php?data=".$ext_attr_serialize, false, THEMEVERSION, true);

	return $return_html;

}

add_shortcode('tg_map', 'tg_map_func');


function tg_gallery_slider_func($atts, $content) {
	extract(shortcode_atts(array(
		'gallery_id' => '',
		'size' => 'blog_f',
	), $atts));

	$images_arr = get_post_meta($gallery_id, 'wpsimplegallery_gallery', true);
	$return_html = '';

	if(!empty($images_arr))
	{
		$return_html.= '<div class="slider_wrapper">';
		$return_html.= '<div class="flexslider">';
		$return_html.= '<ul class="slides">';
		
		foreach($images_arr as $key => $image)
		{
			$image_url = wp_get_attachment_image_src($image, $size, true);
			
			$return_html.= '<li>';
			$return_html.= '<img src="'.$image_url[0].'" alt=""/>';
			$return_html.= '</li>';
		}
		
		$return_html.= '</ul>';
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty gallery item. Please make sure you have upload image to it or check the short code.';
	}

	return $return_html;
}
add_shortcode('tg_gallery_slider', 'tg_gallery_slider_func');


function youtube_func($atts) {
	//extract short code attr
	extract(shortcode_atts(array(
		'width' => 640,
		'height' => 385,
		'video_id' => '',
	), $atts));

	$return_html = '<iframe width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$video_id.'?wmode=transparent&amp;rel=0&amp;autohide=1&amp;egm=0&amp;hd=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;showinfo=0&amp;showsearch=0" frameborder="0" allowfullscreen wmode="Opaque"></iframe>';

	return $return_html;
}
add_shortcode('youtube', 'youtube_func');


function vimeo_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'width' => 640,
		'height' => 385,
		'video_id' => '',
	), $atts));

	$return_html = '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0"></iframe>';
	
	return $return_html;
}
add_shortcode('vimeo', 'vimeo_func');


function divider_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'width' => '',
	), $atts));

	$return_html = '';
	$return_html.= '<br class="clear"/><hr/><br/>';

	return $return_html;

}

add_shortcode('divider', 'divider_func');


function pp_gallery_func($atts, $content) {
	//extract short code attr
	extract(shortcode_atts(array(
		'gallery_id' => '',
		'width' => 205,
		'height' => 205,
	), $atts));

	//Get gallery images
	$images_arr = get_post_meta($gallery_id, 'wpsimplegallery_gallery', true);
	$return_html = '';

	if(!empty($images_arr))
	{
		$return_html.= '<div class="pp_gallery">';
		foreach($images_arr as $key => $image)
		{
			$img_url = wp_get_attachment_url($image,'original');
			$image_resized = aq_resize( $img_url, $width, $height, true );
			
			//Get image meta data
    		$image_title = get_the_title($image);
    		$image_desc = get_post_field('post_content', $image);
			
			$return_html.= '<div style="float:left;margin-right:5px;">';
			$return_html.= '<a title="'.$image_title.'" class="swipebox" href="'.$img_url.'">';
			$return_html.= '<img src="'.$image_resized.'" alt="" />';
			$return_html.= '</a>';
			$return_html.= '</div>';
		}
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty gallery item. Please make sure you have upload image to it or check the short code.';
	}

	$return_html.= '<br class="clear"/>';

	return $return_html;

}

add_shortcode('pp_gallery', 'pp_gallery_func');


function audio_func($atts, $content) {


	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'width' => '100',
		'height' => '30',
	), $atts));

	$return_html = '<audio src="'.$src.'" width="'.$width.'"></audio>';

	return $return_html;
}

add_shortcode('audio', 'audio_func');


function video_func($atts) {
	extract(shortcode_atts(array(
		'width' => 640,
		'height' => 385,
		'img_src' => '',
		'video_src' => '',
	), $atts));

	$custom_id = time().rand();

	$return_html = '<div class="video_shortcode_wrapper" style="width:'.$width.'px;overflow:hidden;">';
	$return_html.= '<video id="video_self_'.$custom_id.'" src="'.$video_src.'" width="'.$width.'" height="'.$height.'" controls="controls" poster="'.$img_src.'"/>';
	$return_html.= '</div>';
	
	wp_enqueue_script("script-ppb-video-bg".$custom_id, get_stylesheet_directory_uri()."/templates/script-ppb-video-bg.php?video_id=video_self_".$custom_id."&height=".$height."&width=".$width."&autoplay=false", false, THEMEVERSION, true);

	return $return_html;
}
add_shortcode('video', 'video_func');


function googlefont_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'font' => '',
		'fontsize' => '',
	), $atts));

	$return_html = '';

	if(!empty($font))
	{
		$encoded_font = urlencode($font);
		wp_enqueue_style($encoded_font, "http://fonts.googleapis.com/css?family=".$encoded_font, false, "", "all");
		
		$return_html = '<div class="googlefont" style="font-family:'.$font.';font-size:'.$fontsize.'px">'.$content.'</div>';
	}

	return $return_html;
}

add_shortcode('googlefont', 'googlefont_func');


function pp_social_icons_func($atts, $content) {

	$return_html = '<div class="social_wrapper shortcode"><ul>';
	
	$pp_facebook_username = get_option('pp_facebook_username');		    		
	if(!empty($pp_facebook_username))
	{
		$return_html.='<li class="facebook"><a target="_blank" title="Facebook" href="http://facebook.com/'.$pp_facebook_username.'"><i class="fa fa-facebook"></i></a></li>';
	}
	
	$pp_twitter_username = get_option('pp_twitter_username');
	if(!empty($pp_twitter_username))
	{
		$return_html.='<li class="twitter"><a target="_blank" title="Twitter" href="http://twitter.com/'.$pp_twitter_username.'"><i class="fa fa-twitter"></i></a></li>';
	}
	
	$pp_flickr_username = get_option('pp_flickr_username');
		    		
	if(!empty($pp_flickr_username))
	{
		$return_html.='<li class="flickr"><a target="_blank" title="Flickr" href="http://flickr.com/people/'.$pp_flickr_username.'"><i class="fa fa-flickr"></i></a></li>';
	}
		    		
	$pp_youtube_username = get_option('pp_youtube_username');
	if(!empty($pp_youtube_username))
	{
		$return_html.='<li class="youtube"><a target="_blank" title="Youtube" href="http://youtube.com/user/'.$pp_youtube_username.'"><i class="fa fa-youtube"></i></a></li>';
	}

	$pp_vimeo_username = get_option('pp_vimeo_username');
	if(!empty($pp_vimeo_username))
	{
		$return_html.='<li class="vimeo"><a target="_blank" title="Vimeo" href="http://vimeo.com/'.$pp_vimeo_username.'"><i class="fa fa-vimeo-square"></i></a></li>';
	}

	$pp_tumblr_username = get_option('pp_tumblr_username');
	if(!empty($pp_tumblr_username))
	{
		$return_html.='<li class="tumblr"><a target="_blank" title="Tumblr" href="http://'.$pp_tumblr_username.'.tumblr.com"><i class="fa fa-tumblr"></i></a></li>';
	}
	
	$pp_google_username = get_option('pp_google_username');
		    		
	if(!empty($pp_google_username))
	{
		$return_html.='<li class="google"><a target="_blank" title="Google+" href="'.$pp_google_username.'"><i class="fa fa-google-plus"></i></a></li>';
	}
		    		
	$pp_dribbble_username = get_option('pp_dribbble_username');
	if(!empty($pp_dribbble_username))
	{
		$return_html.='<li class="dribbble"><a target="_blank" title="Dribbble" href="http://dribbble.com/'.$pp_dribbble_username.'"><i class="fa fa-dribbble"></i></a></li>';
	}
	
	$pp_linkedin_username = get_option('pp_linkedin_username');
	if(!empty($pp_linkedin_username))
	{
		$return_html.='<li class="linkedin"><a target="_blank" title="Linkedin" href="'.$pp_linkedin_username.'"><i class="fa fa-linkedin"></i></a></li>';
	}
		            
	$pp_pinterest_username = get_option('pp_pinterest_username');
	if(!empty($pp_pinterest_username))
	{
		$return_html.='<li class="pinterest"><a target="_blank" title="Pinterest" href="http://pinterest.com/'.$pp_pinterest_username.'"><i class="fa fa-pinterest"></i></a></li>';
	}
		        	
	$pp_instagram_username = get_option('pp_instagram_username');
	if(!empty($pp_instagram_username))
	{
		$return_html.='<li class="instagram"><a target="_blank" title="Instagram" href="http://instagram.com/'.$pp_instagram_username.'"><i class="fa fa-instagram"></i></a></li>';
	}
	
	$return_html.= '</ul></div>';

	return $return_html;

}
add_shortcode('pp_social_icons', 'pp_social_icons_func');


// Actual processing of the shortcode happens here
function pp_last_run_shortcode( $content ) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();
 
    add_shortcode( 'one_half', 'one_half_func' );
    add_shortcode( 'one_half_last', 'one_half_last_func' );
    add_shortcode( 'one_third', 'one_third_func' );
    add_shortcode( 'one_third_last', 'one_third_last_func' );
    add_shortcode( 'two_third', 'two_third_func' );
    add_shortcode( 'two_third_last', 'two_third_last_func' );
    add_shortcode( 'one_fourth', 'one_fourth_func' );
    add_shortcode( 'one_fourth_last', 'one_fourth_last_func' );
    add_shortcode( 'one_fifth', 'one_fifth_func' );
    add_shortcode( 'one_fifth_last', 'one_fifth_last_func' );
    add_shortcode( 'pp_gallery', 'pp_gallery_func' );
    add_shortcode( 'tabs', 'tabs_func' );
    add_shortcode( 'tab', 'tab_func' );
    add_shortcode( 'accordion', 'accordion_func' );
    add_shortcode( 'pp_pre', 'pp_pre_func' );
    add_shortcode( 'testimonial', 'testimonial_func' );
    
    add_shortcode( 'ppb_text', 'ppb_text_func' );
    add_shortcode( 'ppb_divider', 'ppb_divider_func' );
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
 
add_filter( 'the_content', 'pp_last_run_shortcode', 7 );

?>