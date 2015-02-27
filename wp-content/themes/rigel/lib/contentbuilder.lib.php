<?php
function ppb_text_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one'
	), $atts));

	$return_html = '<div class="'.$size.' withpadding"><div class="standard_wrapper">'.$content.'</div></div>';

	return $return_html;

}

add_shortcode('ppb_text', 'ppb_text_func');


function ppb_divider_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one'
	), $atts));

	$return_html = '<div class="standard_wrapper divider">&nbsp;</div>';

	return $return_html;

}

add_shortcode('ppb_divider', 'ppb_divider_func');


function ppb_classic_blog_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'items' => 4,
		'category' => '',
		'sidebar' => '',
		'link' => '',
		'title_display' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_classic">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
		$return_html.= '<div class="sidebar_content">';
		
		if(!empty($title) && !empty($title_display))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '">';
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$return_html.= '<a class="cat_link" href="'.$category_url.'">'.__( 'Latest In', THEMEDOMAIN ).'&nbsp;'.get_cat_name($category).'</a>';
			}
			
			$return_html.= '<h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($subtitle))
			{
				$return_html.= '<div class="ppb_subtitle">'.urldecode($subtitle).'</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$count = 1;
		foreach($posts_arr as $key => $post)
		{
			$image_thumb = '';

			if(has_post_thumbnail($post->ID, 'blog_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			}

		    $return_html.= '<div class="post_inner_wrapper" style="position:relative">';
		    
		    if(isset($image_thumb[0]) && !empty($image_thumb))
			{
				$return_html.= '<div class="post_img classic ';
				$return_html.= '" ';
				
				$return_html.= '>';
				$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
				$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft entry_post" ';
				$return_html.= 'style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px"';
				$return_html.= '/></a>';
				
				//Get post type
		        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
				
				//Get Post review score
				$post_review_score = get_review_score($post->ID);
				if($post_review_score>10)
			    {
			    	$post_review_score = ($post_review_score/100)*10;
			    }
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg two_cols ppb_classic"><i class="fa fa-star"></i>'.$post_review_score.'</div>';
				}
				
				$return_html.='</div>';
			}
		    	
		    $return_html.= '<div class="post_header_wrapper">';
		    $return_html.= '<div class="post_header single_post">';
		    $return_html.= '<h3><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h3>';
		    $return_html.= '</div></div>';
			$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 250).'</p>';
			$return_html.= '<div class="post_detail half grey space">';
			
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
			
			//Get post type
		    $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
		    if(!empty($post_ft_type))
			{
			    switch($post_ft_type)
			    {
			    	case 'Gallery':
			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-picture-o"></i></a></div>';

			    	break;
			    	
			    	case 'Standard Vimeo Video':
			    	case 'Fullwidth Vimeo Video':
			        case 'Standard Youtube Video':
			        case 'Fullwidth Youtube Video':
			        case 'Self-Hosted Video':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-video-camera"></i></a></div>';

			    	break;
			    	
			    	case 'Sound Cloud Audio':
			        case 'Self-Hosted Audio':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-music"></i></a></div>';

			    	break;
			    }
			}
			$return_html.= '</div><br class="clear"/></div>';
			
			$count++;
		}
		
		$return_html.= '</div>';
		
		$return_html.= '<div class="sidebar_wrapper">
		    		<div class="sidebar">
		    			<div class="content">
		    				<ul class="sidebar_widget">
		    					'.get_dynamic_sidebar(urldecode($sidebar)).'
		    				</ul>
		    			</div>
		    		</div>
		    	</div>';
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';
	
	if($current_page_template != 'page_sidebar.php')
	{
		$return_html.= '<br class="clear"/>';	
	}	

	return $return_html;

}

add_shortcode('ppb_classic_blog', 'ppb_classic_blog_func');


function ppb_category_carousel_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'items' => 5,
		'category' => '',
		'link' => '',
		'title_display' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	
	if($current_page_template == 'page_sidebar.php')
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="3"/>';
	}
	else
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="4"/>';
	}

	$return_html.= '<div class="'.$size.' ppb_carousel">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
	
		if(!empty($title) && !empty($title_display))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '">';
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$return_html.= '<a class="cat_link" href="'.$category_url.'">'.__( 'Latest In', THEMEDOMAIN ).'&nbsp;'.get_cat_name($category).'</a>';
			}
			
			$return_html.= '<h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($subtitle))
			{
				$return_html.= '<div class="ppb_subtitle">'.urldecode($subtitle).'</div>';
			}
			
			$return_html.= '</div><br class="clear"/>';
		}
		
		$return_html.= '<div class="flexslider post_carousel ';
		
		if($current_page_template != 'page_sidebar.php')
		{
			$return_html.= 'post_fullwidth';
		}
		
		$return_html.= '"><ul class="slides">';
		
		foreach($posts_arr as $key => $post)
		{
			$return_html.= '<li>';
			
			$image_thumb = '';
		    if(has_post_thumbnail($post->ID, 'blog_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			}
			
			if(isset($image_thumb[0]) && !empty($image_thumb[0]))
	    	{
	    		$return_html.= '<div class="carousel_img">';
	    	    $return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><img class="post_ft entry_post" src="'.$image_thumb[0].'" alt="'.$post->post_title.'" ';
	    	    
	    	    $return_html.= '/></a>';
	    	    $return_html.= '</div>';
	    	}
	    	
	    	$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><br/>';
	    	$return_html.= '<span class="post_attribute full">'.date(THEMEDATEFORMAT, strtotime($post->post_date));

	    	// Custom. ARG. : 17/02/2015 Remove Author, add category name.
			//$categoryCustom = get_the_category($post->ID); 
			//if($categoryCustom[0]){
			//	$return_html.= ' | <a href="'.get_category_link($categoryCustom[0]->term_id ).'">'.$categoryCustom[0]->cat_name.'</a>';
			//}
			$return_html .=  " | " . show_parent_or_child_category($post->ID);

			/*
	    	$author_firstname = get_the_author_meta('first_name', $post->post_author);
			$author_url = get_author_posts_url($post->post_author);
			
			if(!empty($author_firstname))
			{
				$return_html.= '&nbsp;'.__( 'By', THEMEDOMAIN ).'&nbsp;<a href="'.$author_url.'">'.$author_firstname.'</a>';
			}
			*/
			
			if(comments_open($post->ID))
			{
			    $return_html.= '<div class="post_comment_count" style="margin-right: 8px"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><i class="fa fa-comments-o"></i>'.get_comments_number($post->ID);
			    $return_html.= '</a></div>';
			}
	    	
	    	$return_html.= '</span>';
			
			$return_html.= '</li>';
		}
		
		$return_html.= '</ul></div></div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_category_carousel', 'ppb_category_carousel_func');


function ppb_gallery_carousel_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'items' => 5,
		'gallery' => '',
		'link' => '',
		'title_display' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get gallery images
	$images_arr = get_post_meta($gallery, 'wpsimplegallery_gallery', true);
	$return_html = '';

	if($current_page_template == 'page_sidebar.php')
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="3"/>';
	}
	else
	{
		$return_html.= '<input type="hidden" id="post_carousel_column" name="post_carousel_column" value="4"/>';
	}

	$return_html.= '<div class="'.$size.' ppb_carousel">';

	if(!empty($images_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
	
		if(!empty($title) && !empty($title_display))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '">';
			
			//if activate gallery link
			$gallery_url = '';
			if(!empty($link))
			{
				$gallery_url = get_permalink($gallery);
				$return_html.= '<a class="cat_link" href="'.$gallery_url.'">'.__( 'View Gallery', THEMEDOMAIN ).'</a>';
			}
			
			$return_html.= '<h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($subtitle))
			{
				$return_html.= '<div class="ppb_subtitle">'.urldecode($subtitle).'</div>';
			}
			
			$return_html.= '</div><br class="clear"/>';
		}
		
		$return_html.= '<div class="flexslider post_carousel post_gallery ';
		
		if($current_page_template != 'page_sidebar.php')
		{
			$return_html.= 'post_fullwidth ';
		}
		
		$return_html.= 'post_type_gallery"><ul class="slides">';
		
		foreach($images_arr as $key => $image)
		{
			$return_html.= '<li>';
			
			$image_thumb = wp_get_attachment_image_src($image,'blog_ft');
			$full_image_thumb = wp_get_attachment_image_src($image,'original');
			
			//Get image meta data
    		$image_title = get_the_title($image);
    		$image_desc = get_post_field('post_content', $image);

			
			if(isset($image_thumb[0]) && !empty($image_thumb[0]) && isset($full_image_thumb[0]) && !empty($full_image_thumb[0]))
	    	{
	    		$return_html.= '<div class="carousel_img">';
	    	    $return_html.= '<a class="swipebox" title="'.$image_title.'<div class=\'swipe_desc\''.$image_desc.'</div>" href="'.$full_image_thumb[0].'"><img class="post_ft entry_post" src="'.$image_thumb[0].'" alt="" ';
	    	    
	    	    $return_html.= '/></a>';
	    	    $return_html.= '</div>';
	    	}
			
			$return_html.= '</li>';
		}
		
		$return_html.= '</ul></div></div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';
	$return_html.= '<br class="clear"/>';

	return $return_html;

}

add_shortcode('ppb_gallery_carousel', 'ppb_gallery_carousel_func');


function ppb_columns_blog_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'description' => '',
		'items' => 3,
		'category' => '',
		'link' => '',
		'title_display' => '',
		'excerpt' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	if(!empty($template))
	{
		$current_page_template = $template;
	}
	else
	{
		$current_page_template = basename(get_page_template());
	}

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_column">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
		
		if(!empty($title) && !empty($title_display))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '">';
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$return_html.= '<a class="cat_link" href="'.$category_url.'">'.__( 'Latest In', THEMEDOMAIN ).'&nbsp;'.get_cat_name($category).'</a>';
			}
			
			$return_html.= '<h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($subtitle))
			{
				$return_html.= '<div class="ppb_subtitle">'.urldecode($subtitle).'</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$return_html.= '<div>';
		
		$count = 1;
		$count_posts = count($posts_arr);
		
		foreach($posts_arr as $key => $post)
		{
			$image_thumb = '';
			$return_html.= '<div class="ppb_column_post ppb_column animated'.$count.' ';
			
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
			
			if(has_post_thumbnail($post->ID, 'blog_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			}
			
			$return_html.= '<div class="post_wrapper full ppb_columns ';
			
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
				$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft entry_post"/></a>';
				
				//Get Post review score
				$post_review_score = get_review_score($post->ID);
				if($post_review_score>10)
			    {
			    	$post_review_score = ($post_review_score/100)*10;
			    }
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg two_cols ppb_classic"><i class="fa fa-star"></i>'.$post_review_score.'</div>';
				}
				
				//Get post type
			    $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
			    if(!empty($post_ft_type))
				    {
				    	switch($post_ft_type)
				    	{
				    		case 'Gallery':
								$return_html.= '<div class="post_type_bg"><a href="'.get_the_permalink().'"><i class="fa fa-picture-o"></i></a></div>';
				    		break;
				    		
				    		case 'Vimeo Video':
				    		case 'Youtube Video':
				    		case 'Sound Cloud Audio':
				    		case 'Self-Hosted Audio':
				    		case 'Self-Hosted Video':
								$return_html.= '<div class="post_type_bg"><a href="'.get_the_permalink().'"><i class="fa fa-video-camera"></i></a></div>';
				    		break;	
				    	}
				    }
				
				$return_html.= '</div>';
			}

		    $return_html.= '<div class="post_inner_wrapper half header">';
		    $return_html.= '<div class="post_header_wrapper half">';
		    $return_html.= '<div class="post_header half">';
		    $return_html.= '<h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
		    $return_html.= '</div></div>';
		    
		    if(!empty($excerpt))
		    {
				$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 70).'</p>';
			}
			
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
			
			//Get post type
		    $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
		    if(!empty($post_ft_type))
			{
			    switch($post_ft_type)
			    {
			    	case 'Gallery':
			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-picture-o"></i></a></div>';

			    	break;
			    	
			    	case 'Standard Vimeo Video':
			    	case 'Fullwidth Vimeo Video':
			        case 'Standard Youtube Video':
			        case 'Fullwidth Youtube Video':
			        case 'Self-Hosted Video':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-video-camera"></i></a></div>';

			    	break;
			    	
			    	case 'Sound Cloud Audio':
			        case 'Self-Hosted Audio':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-music"></i></a></div>';

			    	break;
			    }
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
		if($count_posts < 3)
		{
			$return_html.= '<br class="clear"/>';	
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= __( 'Empty blog post Please make sure you have created it.', THEMEDOMAIN );
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_columns_blog', 'ppb_columns_blog_func');


function ppb_filter_blog_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'items' => 3,
		'category' => '',
		'excerpt' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	if(!empty($template))
	{
		$current_page_template = $template;
	}
	else
	{
		$current_page_template = basename(get_page_template());
	}
	
	$category = urldecode($category);
	$category_arr = json_decode($category);

	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_column">';

	if(!empty($category))
	{	
		$return_html.= '<div class="standard_wrapper">';
		
		//Generate unique ID
		$wrapper_id = 'ppb_filter_blog_'.uniqid();
		
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '"><div class="ppb_header_wrapper"><h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($subtitle))
			{
				$return_html.= '<div class="ppb_subtitle">'.urldecode($subtitle).'</div>';
			}
			$return_html.= '</div>';
	
			//Display filterable
			$return_html.= '<ul class="cat_filter">';
			
			$return_html.= '<li><a href="javascript:;" data-wrapper="'.$wrapper_id.'" data-category="0" data-template="'.$current_page_template.'" data-items="'.$items.'" class="selected">'.__( 'All', THEMEDOMAIN ).'</li>';
			foreach($category_arr as $category_each)
			{
				$return_html.= '<li><a href="javascript:;"  data-wrapper="'.$wrapper_id.'" data-category="'.$category_each.'" data-template="'.$current_page_template.'" data-items="'.$items.'">'.get_cat_name($category_each).'</a></li>';
			}
			
			$return_html.= '</ul>';
			
			$return_html.= '</div><br class="clear"/>';
		}
		
		$return_html.= '<div id="'.$wrapper_id.'">';
		
		//Get recent posts
		$args = array(
		    'numberposts' => $items,
		    'order' => 'DESC',
		    'orderby' => 'date',
		    'post_type' => array('post'),
		);
	
		$posts_arr = get_posts($args);
		
		$count = 1;
		$count_posts = count($posts_arr);
		
		foreach($posts_arr as $key => $post)
		{
			$image_thumb = '';
			$return_html.= '<div class="ppb_column_post ppb_column animated'.$count.' ';
			
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
			
			if(has_post_thumbnail($post->ID, 'blog_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			}
			
			$return_html.= '<div class="post_wrapper full ppb_columns ';
			
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
				$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft entry_post"/></a>';
				
				//Get post type
		        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
				
				//Get Post review score
				$post_review_score = get_review_score($post->ID);
				if($post_review_score>10)
			    {
			    	$post_review_score = ($post_review_score/100)*10;
			    }
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg two_cols ppb_classic"><i class="fa fa-star"></i>'.$post_review_score.'</div>';
				}
				
				$return_html.= '</div>';
			}

		    $return_html.= '<div class="post_inner_wrapper half header">';
		    $return_html.= '<div class="post_header_wrapper half">';
		    $return_html.= '<div class="post_header half">';
		    $return_html.= '<h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
		    $return_html.= '</div></div>';
		    if(!empty($excerpt))
		    {
				$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 100).'</p>';
			}
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
			
			//Get post type
		    $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
		    if(!empty($post_ft_type))
			{
			    switch($post_ft_type)
			    {
			    	case 'Gallery':
			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-picture-o"></i></a></div>';

			    	break;
			    	
			    	case 'Standard Vimeo Video':
			    	case 'Fullwidth Vimeo Video':
			        case 'Standard Youtube Video':
			        case 'Fullwidth Youtube Video':
			        case 'Self-Hosted Video':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-video-camera"></i></a></div>';

			    	break;
			    	
			    	case 'Sound Cloud Audio':
			        case 'Self-Hosted Audio':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-music"></i></a></div>';

			    	break;
			    }
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
		if($count_posts < 3)
		{
			$return_html.= '<br class="clear"/>';	
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_filter_blog', 'ppb_filter_blog_func');


function ppb_parallax_bg_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'height' => '300',
		'background' => '',
		'link_text' => '',
		'link_url' => '',
	), $atts));
	
	if(!is_numeric($height))
	{
		$height = 300;
	}
	
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_parallax_bg" ';
	
	if(!empty($background))
	{
		$return_html.= 'style="background-image: url('.$background.');background-attachment: fixed;background-position: center top;background-repeat: no-repeat;background-size: cover;height:'.$height.'px;" data-type="background" data-speed="10"';
	}
	
	$return_html.= '>';
	
	if(!empty($title))
	{
		$return_html.= '<div style="position:relative;width:100%;height:100%">';
		
		$return_html.= '<div class="post_title">';
		$return_html.= '<div class="standard_wrapper">';
		
		if(!empty($title))
		{
			$return_html.= '<h3>'.$title.'</h3>';
		}
		
		if(!empty($description))
		{
			$return_html.= '<div class="post_excerpt"><div class="content">'.urldecode($description).'</div></div>';
		}
		
		if(!empty($link_text))
		{
			$return_html.= '<div class="read_full"><a href="'.$link_url.'">'.urldecode($link_text).'</a></div>';
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
		$return_html.= '</div>';
	}

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_parallax_bg', 'ppb_parallax_bg_func');


function ppb_video_bg_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'height' => '300',
		'mp4_video_url' => '',
		'webm_video_url' => '',
		'link_text' => '',
		'link_url' => '',
		'preview_img' => '',
	), $atts));
	
	if(!is_numeric($height))
	{
		$height = 300;
	}
	
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_video_bg" style="position:relative;height:'.$height.'px;" >';
	
	if(!empty($title))
	{	
		$return_html.= '<div class="post_title">';
		$return_html.= '<div class="standard_wrapper">';
		
		if(!empty($title))
		{
			$return_html.= '<h3>'.$title.'</h3>';
		}
		
		if(!empty($description))
		{
			$return_html.= '<div class="post_excerpt"><div class="content">'.urldecode($description).'</div></div>';
		}
		
		if(!empty($link_text))
		{
			$return_html.= '<div class="read_full"><a href="'.$link_url.'">'.urldecode($link_text).'</a></div>';
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	
	$return_html.= '<div style="position:relative;width:100%;height:100%;overflow:hidden">';
	
	if(!empty($mp4_video_url) OR !empty($webm_video_url))
	{
		//Generate unique ID
		$wrapper_id = 'ppb_video_'.uniqid();
		
		$return_html.= '<video ';
		
		if(!empty($preview_img))
		{
			$return_html.= 'poster="'.$preview_img.'"';
		}
		
		$return_html.= 'id="'.$wrapper_id.'" loop="true" autoplay="true" muted="muted" controls="controls">';
		
		if(!empty($mp4_video_url))
		{
			$return_html.= '<source type="video/mp4" src="'.$mp4_video_url.'" />';
		}
		
		if(!empty($webm_video_url))
		{
			$return_html.= '<source type="video/webm" src="'.$webm_video_url.'" />';
		}
		
		$return_html.= '</video>';
		
		wp_enqueue_script("script-ppb-video-bg".$wrapper_id, get_stylesheet_directory_uri()."/templates/script-ppb-video-bg.php?video_id=".$wrapper_id."&height=".$height, false, THEMEVERSION, true);
	}

	$return_html.= '</div>';

	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_video_bg', 'ppb_video_bg_func');


function ppb_category_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'items' => 4,
		'category' => '',
		'sidebar' => '',
		'link' => '',
		'excerpt' => '',
		'title_display' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	
	//Get current page template
	$current_page_template = basename(get_page_template());

	//Get category posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'date',
	    'post_type' => array('post'),
	);
	
	if(!empty($category))
	{
		$args['category'] = $category;
	}

	$posts_arr = get_posts($args);
	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_classic">';

	if(!empty($posts_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
		$return_html.= '<div class="sidebar_content">';
		
		if(!empty($title) & !empty($title_display))
		{
			$return_html.= '<div class="ppb_header ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'fullwidth';
			}
			
			$return_html.= '">';
			
			//if activate category link
			$category_url = '';
			if(!empty($link))
			{
				$category_url = get_category_link($category);
				$return_html.= '<a class="cat_link" href="'.$category_url.'">'.__( 'Latest In', THEMEDOMAIN ).'&nbsp;'.get_cat_name($category).'</a>';
			}
			
			$return_html.= '<h5 class="header_line ';
			
			if($current_page_template != 'page_sidebar.php')
			{
				$return_html.= 'post_fullwidth';
			}
			
			$return_html.= '">'.$title.'</h5>';
			
			if(!empty($subtitle))
			{
				$return_html.= '<div class="ppb_subtitle">'.urldecode($subtitle).'</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$count = 1;
		foreach($posts_arr as $key => $post)
		{
			$image_thumb = '';

			if(has_post_thumbnail($post->ID, 'blog_ft'))
			{
			    $image_id = get_post_thumbnail_id($post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			}

		    $return_html.= '<div class="element ';
		    if($count%2==0)
		    {
			    $return_html.= 'last';
		    }
		    $return_html.= '" rel="two_columns">';
		    $return_html.= '<div class="post_wrapper full" style="position:relative">';
		    
		    if(isset($image_thumb[0]) && !empty($image_thumb))
			{
				$return_html.= '<div class="post_img ';
				$return_html.= '" ';
				
				$return_html.= '>';
				$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
				$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft entry_post" ';
				$return_html.= 'style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px"';
				$return_html.= '/></a>';
				
				//Get post type
		        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
				
				//Get Post review score
				$post_review_score = get_review_score($post->ID);
				if($post_review_score>10)
			    {
			    	$post_review_score = ($post_review_score/100)*10;
			    }
				
				if(!empty($post_review_score))
				{
					$return_html.= '<div class="review_score_bg two_cols ppb_classic"><i class="fa fa-star"></i>'.$post_review_score.'</div>';
				}
				
				$return_html.='</div>';
			}
		    	
		    $return_html.= '<div class="post_header_wrapper half">';
		    $return_html.= '<div class="post_header half">';
		    $return_html.= '<h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
		    $return_html.= '</div></div>';
		    if(!empty($excerpt))
			{
				$return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 70).'</p>';
			}
			$return_html.= '<div class="post_detail half grey space">';
			
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
			
			//Get post type
		    $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
		    if(!empty($post_ft_type))
			{
			    switch($post_ft_type)
			    {
			    	case 'Gallery':
			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-picture-o"></i></a></div>';

			    	break;
			    	
			    	case 'Standard Vimeo Video':
			    	case 'Fullwidth Vimeo Video':
			        case 'Standard Youtube Video':
			        case 'Fullwidth Youtube Video':
			        case 'Self-Hosted Video':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-video-camera"></i></a></div>';

			    	break;
			    	
			    	case 'Sound Cloud Audio':
			        case 'Self-Hosted Audio':

			    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-music"></i></a></div>';

			    	break;
			    }
			}
			$return_html.= '</div><br class="clear"/></div></div>';
			
			if($count%2==0)
		    {
			    $return_html.= '<br class="clear"/>';
		    }
			
			$count++;
		}
		
		$return_html.= '</div>';
		
		$return_html.= '<div class="sidebar_wrapper">
		    		<div class="sidebar">
		    			<div class="content">
		    				<ul class="sidebar_widget">
		    					'.get_dynamic_sidebar(urldecode($sidebar)).'
		    				</ul>
		    			</div>
		    		</div>
		    	</div>';
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';
	
	if($current_page_template != 'page_sidebar.php')
	{
		$return_html.= '<br class="clear"/>';	
	}	

	return $return_html;

}

add_shortcode('ppb_category_sidebar', 'ppb_category_sidebar_func');


function ppb_categories_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'items' => 4,
		'category' => '',
		'link' => '',
		'sidebar' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 1;
	}
	$category = urldecode($category);
	$category_arr = json_decode($category);

	//Get current page template
	$current_page_template = basename(get_page_template());

	$return_html = '';
	$return_html.= '<div class="'.$size.' ppb_classic">';

	if(!empty($category_arr))
	{	
		$return_html.= '<div class="standard_wrapper">';
		$return_html.= '<div class="sidebar_content">';
		
		$count_categories = 1;
		foreach($category_arr as $category)
		{
			$return_html.= '<div class="element ';
			if($count_categories%2==0)
			{
			    $return_html.= 'last';
			}
			$return_html.= '" rel="two_columns">';
		
			if(!empty($title))
			{
				$return_html.= '<div class="ppb_header ';
				
				if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'fullwidth';
				}
				
				$return_html.= '">';
				$return_html.= '<h5 class="header_line ';
				
				if($current_page_template != 'page_sidebar.php')
				{
					$return_html.= 'post_fullwidth';
				}
				
				//Get category title
				$category_title = get_cat_name($category);
				
				//if activate category link
				$category_url = '';
				if(!empty($link))
				{
					$category_url = get_category_link($category);
					$return_html.= '"><a href="'.$category_url.'">'.$category_title.'</a></h5>';
				}
				else
				{
					$return_html.= '">'.$category_title.'</h5>';
				}
				$return_html.= '</div>';
			}
			
			//Get category posts
			$args = array(
			    'numberposts' => $items,
			    'order' => 'DESC',
			    'orderby' => 'date',
			    'post_type' => array('post'),
			);
			
			if(!empty($category))
			{
				$args['category'] = $category;
			}
		
			$posts_arr = get_posts($args);
			$counte_posts = count($posts_arr);
			$count = 0;
			
			foreach($posts_arr as $post)
			{
				$image_thumb = '';
	
				if($count==0)
				{
					if(has_post_thumbnail($post->ID, 'blog_ft'))
					{
					    $image_id = get_post_thumbnail_id($post->ID);
					    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
					}
		
				    $return_html.= '<div class="post_wrapper full category" style="position:relative">';
				    
				    if(isset($image_thumb[0]) && !empty($image_thumb))
					{
						$return_html.= '<div class="post_img ';
						$return_html.= '" ';
						
						$return_html.= '>';

						$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
						
						// Custom. ARG. 18/02/2015: Bring Video image over Image of Article if article has vimeo-youtube post_meta included.
						$hasVimeo = get_post_meta($post->ID, 'post_ft_vimeo', true);
						$hasYouTube = get_post_meta($post->ID, 'post_ft_youtube', true);
						if( !empty($hasVimeo) || !empty($hasYouTube))
						{
							$return_html.= '<div class="videoIcon"><img src="wp-content/themes/rigel/images/videoIcon.png" alt="Video"></div>';
						}

						$return_html.= '<img src="'.$image_thumb[0].'" alt="" class="post_ft entry_post" ';
						$return_html.= 'style="width:'.$image_thumb[1].'px;height:'.$image_thumb[2].'px"';
						$return_html.= '/></a>';
						
						//Get post type
				        $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
						
						//Get Post review score
						$post_review_score = get_review_score($post->ID);
						if($post_review_score>10)
					    {
					    	$post_review_score = ($post_review_score/100)*10;
					    }
						
						if(!empty($post_review_score))
						{
							$return_html.= '<div class="review_score_bg two_cols ppb_classic"><i class="fa fa-star"></i>'.$post_review_score.'</div>';
						}
						
						$return_html.='</div>';
					}
				    	
				    $return_html.= '<div class="post_header_wrapper half">';
				    $return_html.= '<div class="post_header half">';
				    $return_html.= '<h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
				    $return_html.= '</div></div>';
				    $return_html.= '<p>'.pp_substr(strip_tags(strip_shortcodes($post->post_content)), 70).'</p>';
					$return_html.= '<div class="post_detail half grey space">';
					
					$return_html.= date(THEMEDATEFORMAT, strtotime($post->post_date));

					// Custom: ARG. 17/02/2015 Remove Author name, add first Category found instead.
					
					//$categoryCustom = get_the_category($post->ID); 
					//if($categoryCustom[0]){
					//	$return_html.= ' | <a href="'.get_category_link($categoryCustom[0]->term_id ).'">'.$categoryCustom[0]->cat_name.'</a>';
					//}
					$return_html .= " | " . show_parent_or_child_category($post->ID);


					/*
					$author_firstname = get_the_author_meta('first_name', $post->post_author);
					$author_url = get_author_posts_url($post->post_author);
					
					if(!empty($author_firstname))
					{
						$return_html.= '&nbsp;'.__( 'By', THEMEDOMAIN ).' <a href="'.$author_url.'">'.$author_firstname.'</a>';
					}
					*/
					// Custom: ARG. END
					
					if(comments_open($post->ID))
					{
					    $return_html.= '<div class="post_comment_count"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><i class="fa fa-comments-o"></i>'.get_comments_number($post->ID);
					    $return_html.= '</a></div>';
					}
					
					//Get post type
				    $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
				    if(!empty($post_ft_type))
					{
					    switch($post_ft_type)
					    {
					    	case 'Gallery':
					    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-picture-o"></i></a></div>';
		
					    	break;
					    	
					    	case 'Standard Vimeo Video':
					    	case 'Fullwidth Vimeo Video':
					        case 'Standard Youtube Video':
					        case 'Fullwidth Youtube Video':
					        case 'Self-Hosted Video':
		
					    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-video-camera"></i></a></div>';
		
					    	break;
					    	
					    	case 'Sound Cloud Audio':
					        case 'Self-Hosted Audio':
		
					    	$return_html.= '<div class="post_type_bg"><a href="'.get_permalink($post->ID).'"><i class="fa fa-music"></i></a></div>';
		
					    	break;
					    }
					}
					$return_html.= '<br class="clear"/></div></div>';
				}
				else
				{
					if(has_post_thumbnail($post->ID, 'thumbnail'))
					{
					    $image_id = get_post_thumbnail_id($post->ID);
					    $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					}
					
					if($count==1)
					{
						$return_html.= '<ul class="posts blog">';
					}
					
					$return_html.= '<li><div class="post_circle_thumb"><a href="'.get_permalink($post->ID).'">';
					
					if(isset($image_thumb[0]) && !empty($image_thumb[0]))
					{
						$return_html.='<img src="'.$image_thumb[0].'" alt="" class="entry_post">';
					}
						$return_html.='</a></div>';
						$return_html.='<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><span class="post_attribute">'.date(THEMEDATEFORMAT, strtotime($post->post_date));
						
						$return_html.='<div class="post_comment_count"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><i class="fa fa-comments-o"></i>'.get_comments_number($post->ID).'</a></div></span>';
						$return_html.='</li>';
					
					if(($count+1)==$counte_posts)
					$return_html.= '</ul>';
				}
				
				$count++;
			}
			
			$count_categories++;
			
			$return_html.= '</div>';
			if(($count_categories+1)%2==0)
			{
			    $return_html.= '<br class="clear"/>';
			}
		}
		
		$return_html.= '</div>';
		
		$return_html.= '<div class="sidebar_wrapper">
		    		<div class="sidebar">
		    			<div class="content">
		    				<ul class="sidebar_widget">
		    					'.get_dynamic_sidebar(urldecode($sidebar)).'
		    				</ul>
		    			</div>
		    		</div>
		    	</div>';
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= 'Empty blog post Please make sure you have created it.';
	}

	$return_html.= '</div>';
	
	if($current_page_template != 'page_sidebar.php')
	{
		$return_html.= '<br class="clear"/>';	
	}	

	return $return_html;

}

add_shortcode('ppb_categories_sidebar', 'ppb_categories_sidebar_func');
?>