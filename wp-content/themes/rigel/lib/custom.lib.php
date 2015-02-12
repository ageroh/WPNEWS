<?php
/**
*	Custom function to get current URL
**/
function curPageURL() {
 	$pageURL = 'http';
 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80") {
 	 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 	} else {
 	 $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 	}
 	return $pageURL;
}
    
function pp_debug($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function gen_permalink($current_url = '', $additional = '')
{
	$current_arr = parse_url($current_url);
	
	$start = '';
	if(isset($current_arr['query']) && !empty($current_arr['query']))
    {
    	$start = '&';
    }
    else
    {
    	$start = '?';
    }
    
    return $current_url.$start.$additional;
}

function gen_pagination($total,$currentPage,$baseLink,$nextPrev=true,$limit=10) 
{ 
    if(!$total OR !$currentPage OR !$baseLink) 
    { 
        return false; 
    } 

    //Total Number of pages 
    $totalPages = ceil($total/$limit); 
     
    //Text to use after number of pages 
    //$txtPagesAfter = ($totalPages==1)? " page": " pages"; 
     
    //Start off the list. 
    //$txtPageList = '<br />'.$totalPages.$txtPagesAfter.' : <br />'; 
     
    //Show only 3 pages before current page(so that we don't have too many pages) 
    $min = ($page - 3 < $totalPages && $currentPage-3 > 0) ? $currentPage-3 : 1; 
     
    //Show only 3 pages after current page(so that we don't have too many pages) 
    $max = ($page + 3 > $totalPages) ? $totalPages : $currentPage+3; 
     
    //Variable for the actual page links 
    $pageLinks = ""; 
    
    $baseLinkArr = parse_url($baseLink);
    $start = '';
    
    if(isset($baseLinkArr['query']) && !empty($baseLinkArr['query']))
    {
    	$start = '&';
    }
    else
    {
    	$start = '?';
    }
     
    //Loop to generate the page links 
    for($i=$min;$i<=$max;$i++) 
    { 
        if($currentPage==$i) 
        { 
            //Current Page 
            $pageLinks .= '<a href="#" class="active">'.$i.'</a>';  
        } 
        elseif($max <= $totalPages OR $i <= $totalPages) 
        { 
            $pageLinks .= '<a href="'.$baseLink.$start.'page='.$i.'" class="slide">'.$i.'</a>'; 
        } 
    } 
     
    if($nextPrev) 
    { 
        //Next and previous links 
        $next = ($currentPage + 1 > $totalPages) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage + 1).'" class="slide">Next</a>'; 
         
        $prev = ($currentPage - 1 <= 0 ) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage - 1).'" class="slide">Previous</a>'; 
    } 
     
    if($totalPages > 1)
    {
    	return '<br class="clear"/><div class="pagination">'.$txtPageList.$prev.$pageLinks.$next.'</div>'; 
    }
    else
    {
    	return '';
    }
     
} 

function count_shortcode($content = '')
{
	$return = array();
	
	if(!empty($content))
	{
		$pattern = get_shortcode_regex();
    	$count = preg_match_all('/'.$pattern.'/s', $content, $matches);
    	
    	$return['total'] = $count;
    	
    	if(isset($matches[0]))
    	{
    		foreach($matches[0] as $match)
    		{
    			$return['content'][] = substr_replace($match ,"",-1);
    		}
    	}
	}
	
	return $return;
}

function dimox_breadcrumbs() {
 
  $delimiter = '';
  $home = __( 'Home', THEMEDOMAIN ); // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $homeLink = home_url();
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . __( 'Archive by category ', THEMEDOMAIN ) . single_cat_title('', false) . '' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_search()) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . __( 'Search results for ', THEMEDOMAIN ) . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . __( 'Posts tagged ', THEMEDOMAIN ). '"' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . __( 'Articles posted by', THEMEDOMAIN ) . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . __( 'Error 404', THEMEDOMAIN ) . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page', THEMEDOMAIN) . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
} // end dimox_breadcrumbs()
    
/**
*	Setup blog comment style
**/
function pp_comment($comment, $args, $depth) 
{
	$GLOBALS['comment'] = $comment; 
?>
   
	<div class="comment" id="comment-<?php comment_ID() ?>">
		<div class="gravatar comment_reply">
         	<?php echo get_avatar($comment,$size='60',$default='' ); ?>
      	</div>
      
		<div class="comment_arrow"></div>
      	<div class="right">
			<?php if ($comment->comment_approved == '0') : ?>
         		<em><?php echo _e('(Your comment is awaiting moderation.)', THEMEDOMAIN) ?></em>
         		<br />
      		<?php endif; ?>
			
			<?php 
			if (!empty($comment->user_id)) { 
				$author_first_name = get_the_author_meta('first_name', $comment->user_id);
				$author_last_name = get_the_author_meta('last_name', $comment->user_id);
			?>
			<a href="<?php echo $comment->comment_author_url; ?>" rel="author">
			<?php
				echo $author_first_name.' '.$author_last_name;
			?>
			</a>
			 <?php } else { ?>
			 <span rel="author">
			 <?php
			 	echo $comment->comment_author;
			 ?>
			 </span>
			 <?php } ?>
			 
			<div class="comment_date"><?php _e( 'on', THEMEDOMAIN ) ?><a href="#comment-<?php echo $comment->comment_ID; ?>"><?php echo date(THEMEDATEFORMAT, strtotime($comment->comment_date)); ?></a></div>
			
			<?php 
      			if($depth < 3)
      			{
      		?>
      			<p class="comment-reply-link"><?php comment_reply_link(array_merge( $args, array('depth' => $depth,
'reply_text' => 'Reply', 'login_text' => 'Log in to reply to this', 'max_depth' => $args['max_depth']))) ?></p>
			<?php
				}
			?>
			<br class="clear"/>
      		<?php comment_text() ?>

      	</div>
    </div>
<?php
}

function pp_ago($timestamp){
   $difference = time() - $timestamp;
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   if($difference != 1) $periods[$j].= "s";
   $text = "$difference $periods[$j] ago";
   return $text;
}


// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function pp_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}

function pp_posts($sort = 'recent', $items = 3, $echo = TRUE, $show_thumb = TRUE, $highlight_latest = TRUE, $show_title = TRUE) 
{
	$return_html = '';
	
	if($sort == 'recent')
	{
		$query_post = 'numberposts='.$items.'&order=DESC&orderby=date&post_type=post&post_status=publish';
		if(function_exists('icl_object_id'))
		{
			$query_post.= '&suppress_filters=0';
		}
		
		$posts = get_posts($query_post);
		$title = __('Recent Posts', THEMEDOMAIN);
	}
	elseif($sort == 'review')
	{
		$query_post = 'numberposts='.$items.'&orderby=meta_value&meta_key=taq_review_score&post_type=post&post_status=publish';
		if(function_exists('icl_object_id'))
		{
			$query_post.= '&suppress_filters=0';
		}
		
		$posts = get_posts($query_post);
		$title = __('Best Review', THEMEDOMAIN);
	}
	else
	{
		global $wpdb;
		
		$query = "SELECT ID, post_title, post_content FROM {$wpdb->prefix}posts WHERE post_type = 'post' AND post_status= 'publish' ORDER BY comment_count DESC LIMIT 0,".$items;
		
		$posts = $wpdb->get_results($query);
		$title = __('Popular Posts', THEMEDOMAIN); 
	}
	
	if(!empty($posts))
	{
		if($show_title)
		{
			$return_html.= '<h2 class="widgettitle">'.$title.'</h2>';
		}
		$return_html.= '<ul class="posts blog">';
		
		$count_post = count($posts);
		
		$post_to_highlight = 0;
		if(!$highlight_latest)
		{
			$post_to_highlight = -1;
		}

		foreach($posts as $key => $post)
		{
		    if($key > $post_to_highlight)
		    {
		    	$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', true);
		    	$return_html.= '<li>';
		    	
		    	if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'thumbnail'))
		    	{
		    		$image_id = get_post_thumbnail_id($post->ID);
		    		$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
		    		
		    		$return_html.= '<div class="post_circle_thumb"><a href="'.get_permalink($post->ID).'"><img src="'.$image_url[0].'" alt="" />';
		    		//Get Post review score
					$post_review_score = get_review_score($post->ID);
					if($post_review_score>10)
					{
						$post_review_score = ($post_review_score/100)*10;
					}
					
					if(!empty($post_review_score))
					{
						$return_html.= '<div class="review_score_bg">'.$post_review_score.'</div>';
					}
					
					$return_html.= '</a></div>';
		    	}
		    	
		    	$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><span class="post_attribute center';
		    	if(empty($show_thumb))
		    	{
			    	$return_html.= ' full';
		    	}
		    	$return_html.= '">'.get_the_time(THEMEDATEFORMAT, $post->ID);
		    	
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
		    	
		    	$return_html.= '</span>';
		    	$return_html.= '</li>';
		    }
		    else
		    {
		    	$return_html.= '<li>';
		    	
		    	if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'blog_ft'))
		    	{
		    		$image_id = get_post_thumbnail_id($post->ID);
		    		$image_url = wp_get_attachment_image_src($image_id, 'blog_ft', true);
		    		
		    		$return_html.= '<div class="post_circle_thumb large_thumb"><a href="'.get_permalink($post->ID).'"><img src="'.$image_url[0].'" alt="" /></a></div>';
		    	}
		    	
		    	$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><span class="post_attribute full';
		    	if(empty($show_thumb))
		    	{
			    	$return_html.= ' full';
		    	}
		    	$return_html.= '">'.get_the_time(THEMEDATEFORMAT, $post->ID);
		    	
		    	if(comments_open($post->ID))
				{
				    $return_html.= '<div class="post_comment_count"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><i class="fa fa-comments-o"></i>'.get_comments_number($post->ID);
				    $return_html.= '</a></div>';
				}
				
		    	$return_html.= '</span>';
		    	$return_html.= '</li>';
		    }

		}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function pp_tabbed_posts($sort = 'recent', $items = 3, $echo = TRUE, $show_thumb = TRUE, $highlight_latest = TRUE) 
{
	$return_html = '';
	$return_html.= '[tabs tab1="'.__('Popular', THEMEDOMAIN).'" tab2="'.__('Recent', THEMEDOMAIN).'" tab3="'.__('Best Review', THEMEDOMAIN).'"]';
	$return_html.= '[tab id=1]'.pp_posts('popular', $items, FALSE, $show_thumb, $highlight_latest, FALSE).'[/tab]';
	$return_html.= '[tab id=2]'.pp_posts('recent', $items, FALSE, $show_thumb, $highlight_latest, FALSE).'[/tab]';
	$return_html.= '[tab id=3]'.pp_posts('review', $items, FALSE, $show_thumb, $highlight_latest, FALSE).'[/tab]';
	$return_html.= '[/tabs]';
	$return_html = do_shortcode($return_html);
	$return_html = str_ireplace('<p>','',$return_html);
	$return_html = str_ireplace('</p>','',$return_html);   
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function pp_best_review($items = 3, $echo = TRUE) 
{
	$return_html = '';
	
	$query_post = 'numberposts='.$items.'&orderby=meta_value&meta_key=taq_review_score&post_type=post&post_status=publish';
	if(function_exists('icl_object_id'))
	{
	    $query_post.= '&suppress_filters=0';
	}
	
	$posts = get_posts($query_post);
	$title = __('Best Review', THEMEDOMAIN);
	
	if(!empty($posts))
	{
		$return_html.= '<h2 class="widgettitle">'.$title.'</h2>';
		$return_html.= '<ul>';
		
		$count_post = count($posts);

		foreach($posts as $key => $post)
		{
		    $return_html.= '<li>';
		    
		    $post_review_score = get_review_score($post->ID);
		    $post_review_percent = $post_review_score*10;
			if($post_review_score>10)
			{
				$post_review_percent = $post_review_score;
			    $post_review_score = ($post_review_score/100)*10;
			}
		    
		    $return_html.= '<div class="review-item"><span>
			<a href="'.get_permalink($post->ID).'"><strong class="title">'.$post->post_title.'</strong></a><div class="review-point-number">'.$post_review_score.'</div><span class="review-point-wrapper" style=""><span style="width: '.$post_review_percent.'%;"></span></span></span>
		</span></div>';
			
		    $return_html.= '</li>';
		}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function _substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}

function get_the_content_with_formatting ($more_link_text = '', $length = 600, $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = strip_shortcodes($content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = _substr(strip_tags($content), $length);
	
	if(!empty($more_link_text))
	{
		$content.= '<br/><br/><a class="long_button" href="'.get_permalink().'"><span>'.$more_link_text.'</span></a>';
	}
	
	return $content;
}

function image_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}


function select_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);

    // The sizes listed here are the ones Flickr provides by default.  Pass the array index in the

    // 0 for square, 1 for thumb, 2 for small, etc.
    $s = array(
        '_s.', // square
        '_t.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
    );

    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}


function get_flickr($settings) {
	if (!function_exists('MagpieRSS')) {
	    // Check if another plugin is using RSS, may not work
	    include_once (ABSPATH . WPINC . '/class-simplepie.php');
	    error_reporting(E_ERROR);
	}
	
	if(!isset($settings['items']) || empty($settings['items']))
	{
		$settings['items'] = 9;
	}
	
	// get the feeds
	if ($settings['type'] == "user") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $settings['id'] . '&tags=' . $settings['tags'] . '&per_page='.$settings['items'].'&format=rss_200'; }
	elseif ($settings['type'] == "favorite") { $rss_url = 'http://api.flickr.com/services/feeds/photos_faves.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "set") { $rss_url = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $settings['set'] . '&nsid=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "group") { $rss_url = 'http://api.flickr.com/services/feeds/groups_pool.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "public" || $settings['type'] == "community") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?tags=' . $settings['tags'] . '&format=rss_200'; }
	else {
	    print '<strong>No "type" parameter has been setup. Check your settings, or provide the parameter as an argument.</strong>';
	    die();
	}
	# get rss file

	$feed = new SimplePie($rss_url);
	$photos_arr = array();
	
	foreach ($feed->get_items() as $key => $item)
	{
		$enclosure = $item->get_enclosure();
		$img = image_from_description($item->get_description()); 
		$thumb_url = select_image($img, 0);
		$large_url = select_image($img, 4);
		
		$photos_arr[] = array(
			'title' => $enclosure->get_title(),
			'thumb_url' => $thumb_url,
			'url' => $large_url,
		);
		
		$current = intval($key+1);
		
		if($current == $settings['items'])
		{
			break;
		}
	}  

	return $photos_arr;
}

function pp_photos_in_news($items = 10, $title = 'Photos In News', $echo = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&suppress_filters=0');
	
	if(!empty($posts))
	{

		$return_html.= '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
		$return_html.= '<ul class="thumb">';

			foreach($posts as $post)
			{
				if(has_post_thumbnail($post->ID, 'thumbnail'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);

					$return_html.= '<li><div class="post_circle_thumb"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><img class="resize frame" src="'.$image_url[0].'" alt="" /></a></div></li>';
				}

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}


function pp_cat_posts($cat_id = '', $items = 5, $echo = TRUE, $show_thumb = TRUE, $highlight_latest = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
	$title = get_cat_name($cat_id);
	$category_link = get_category_link($cat_id);
	$count_post = count($posts);
	
	if(!empty($posts))
	{

		$return_html.= '<h2 class="widgettitle">'.$title.'</h2>';
		$return_html.= '<ul class="posts">';

		$post_to_highlight = 0;
		if(!$highlight_latest)
		{
			$post_to_highlight = -1;
		}

		foreach($posts as $key => $post)
		{
		    if($key > $post_to_highlight)
		    {
		    	$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', true);
		    	$return_html.= '<li>';
		    	
		    	if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'thumbnail'))
		    	{
		    		$image_id = get_post_thumbnail_id($post->ID);
		    		$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
		    		
		    		$return_html.= '<div class="post_circle_thumb"><a href="'.get_permalink($post->ID).'"><img src="'.$image_url[0].'" alt="" /></a></div>';
		    	}
		    	
		    	$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><span class="post_attribute center';
		    	if(empty($show_thumb))
		    	{
			    	$return_html.= ' full';
		    	}
		    	$return_html.= '">'.get_the_time(THEMEDATEFORMAT, $post->ID);
		    	
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
		    	
		    	$return_html.= '</span>';
		    	$return_html.= '</li>';
		    }
		    else
		    {
		    	$return_html.= '<li>';
		    	
		    	if(!empty($show_thumb) && has_post_thumbnail($post->ID, 'blog_ft'))
		    	{
		    		$image_id = get_post_thumbnail_id($post->ID);
		    		$image_url = wp_get_attachment_image_src($image_id, 'blog_ft', true);
		    		
		    		$return_html.= '<div class="post_circle_thumb large_thumb"><a href="'.get_permalink($post->ID).'"><img src="'.$image_url[0].'" alt="" /></a></div>';
		    	}
		    	
		    	$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><span class="post_attribute full';
		    	if(empty($show_thumb))
		    	{
			    	$return_html.= ' full';
		    	}
		    	$return_html.= '">'.get_the_time(THEMEDATEFORMAT, $post->ID);
		    	
		    	if(comments_open($post->ID))
				{
				    $return_html.= '<div class="post_comment_count"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><i class="fa fa-comments-o"></i>'.get_comments_number($post->ID);
				    $return_html.= '</a></div>';
				}
				
		    	$return_html.= '</span>';
		    	$return_html.= '</li>';
		    }
		}	

		$return_html.= '</ul><br class="clear"/>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function pp_cat_slideshow_posts($cat_id = '', $items = 5, $echo = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
	$title = get_cat_name($cat_id);
	$category_link = get_category_link($cat_id);
	$count_post = count($posts);
	
	if(!empty($posts))
	{
		if(!empty($title))
		{
			$return_html.= '<h2 class="widgettitle">'.$title.'</h2>';	
		}
		$return_html.= '<div class="slider_widget_wrapper flexslider">';
		$return_html.= '<ul class="slides post_slideshow_widget">';

			foreach($posts as $key => $post)
			{
				$return_html.= '<li>';
			
				if(has_post_thumbnail($post->ID, 'blog_ft'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'blog_ft', true);
					
					$return_html.= '<a href="'.get_permalink($post->ID).'" title="'.get_permalink($post->post_title).'"><img src="'.$image_url[0].'" alt="" /></a>';
				}
				
				$return_html.= '<h7><a href="'.get_permalink($post->ID).'">'.pp_substr($post->post_title, 50).'</a></h7>';
				$return_html.= '<span class="post_attribute full">'.get_the_time(THEMEDATEFORMAT, $post->ID).'</span>';
				$return_html.= '</li>';
			}	
		
		$return_html.= '</ul>';
		$return_html.= '</div>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function pp_authors($items = 8, $title = 'Our Authors', $echo = TRUE) 
{
	$return_html = '';
	$authors = get_users('orderby=post_count&order=DESC');
	
	if(!empty($authors))
	{

		$return_html.= '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
		$return_html.= '<ul class="thumb">';

			foreach($authors as $author)
			{
				if(!in_array('subscriber', $author->roles ))
				{
					$return_html.= '<li><div class="post_circle_thumb"><a href="'.get_author_posts_url($author->ID).'" title="'.$author->display_name.'">'.get_avatar($author->user_email, '75').'</a></div></li>';
				}

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function pp_gallery_slideshow($gallery_id = '', $items = 5, $echo = TRUE) 
{
	$return_html = '';
	$images_arr = get_post_meta($gallery_id, 'wpsimplegallery_gallery', true);
	$title = get_the_title($gallery_id);
	$gallery_link = get_permalink($gallery_id);
	
	if(!empty($images_arr))
	{
		if(!empty($title))
		{
			$return_html.= '<h2 class="widgettitle">'.$title.'</h2>';	
		}
		$return_html.= '<div class="slider_widget_wrapper flexslider post_gallery">';
		$return_html.= '<ul class="slides post_slideshow_widget">';

			foreach($images_arr as $image_id)
			{
				$return_html.= '<li>';
				$image_url = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			
				if(isset($image_url[0]))
				{
					$return_html.= '<a href="'.$gallery_link.'"><img src="'.$image_url[0].'" alt="" /></a>';
				}
				$return_html.= '</li>';
			}	
		
		$return_html.= '</ul>';
		$return_html.= '</div>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function hex_lighter($hex,$factor = 30) 
    { 
    $new_hex = ''; 
     
    $base['R'] = hexdec($hex{0}.$hex{1}); 
    $base['G'] = hexdec($hex{2}.$hex{3}); 
    $base['B'] = hexdec($hex{4}.$hex{5}); 
     
    foreach ($base as $k => $v) 
        { 
        $amount = 255 - $v; 
        $amount = $amount / 100; 
        $amount = round($amount * $factor); 
        $new_decimal = $v + $amount; 
     
        $new_hex_component = dechex($new_decimal); 
        if(strlen($new_hex_component) < 2) 
            { $new_hex_component = "0".$new_hex_component; } 
        $new_hex .= $new_hex_component; 
        } 
         
    return $new_hex;     
} 

function hex_darker($hex,$factor = 30)
{
	$new_hex = '';
	
	$base['R'] = hexdec($hex{0}.$hex{1});
	$base['G'] = hexdec($hex{2}.$hex{3});
	$base['B'] = hexdec($hex{4}.$hex{5});
	
	foreach ($base as $k => $v)
	        {
	        $amount = $v / 100;
	        $amount = round($amount * $factor);
	        $new_decimal = $v - $amount;
	
	        $new_hex_component = dechex($new_decimal);
	        if(strlen($new_hex_component) < 2)
	                { $new_hex_component = "0".$new_hex_component; }
	        $new_hex .= $new_hex_component;
	        }
	        
	return $new_hex;        
}

function XML2Array ( $xml , $recursive = false )
{
    if ( ! $recursive )
    {
        $array = simplexml_load_string ( $xml ) ;
    }
    else
    {
        $array = $xml ;
    }
    
    $newArray = array () ;
    $array = ( array ) $array ;
    foreach ( $array as $key => $value )
    {
        $value = ( array ) $value ;
        if ( isset ( $value [ 0 ] ) )
        {
            $newArray [ $key ] = trim ( $value [ 0 ] ) ;
        }
        else
        {
            $newArray [ $key ] = XML2Array ( $value , true ) ;
        }
    }
    return $newArray ;
}

/**
 * Converts a simpleXML element into an array. Preserves attributes and everything.
 * You can choose to get your elements either flattened, or stored in a custom index that
 * you define.
 * For example, for a given element
 * <field name="someName" type="someType"/>
 * if you choose to flatten attributes, you would get:
 * $array['field']['name'] = 'someName';
 * $array['field']['type'] = 'someType';
 * If you choose not to flatten, you get:
 * $array['field']['@attributes']['name'] = 'someName';
 * _____________________________________
 * Repeating fields are stored in indexed arrays. so for a markup such as:
 * <parent>
 * <child>a</child>
 * <child>b</child>
 * <child>c</child>
 * </parent>
 * you array would be:
 * $array['parent']['child'][0] = 'a';
 * $array['parent']['child'][1] = 'b';
 * ...And so on.
 * _____________________________________
 * @param simpleXMLElement $xml the XML to convert
 * @param boolean $flattenValues    Choose wether to flatten values
 *                                    or to set them under a particular index.
 *                                    defaults to true;
 * @param boolean $flattenAttributes Choose wether to flatten attributes
 *                                    or to set them under a particular index.
 *                                    Defaults to true;
 * @param boolean $flattenChildren    Choose wether to flatten children
 *                                    or to set them under a particular index.
 *                                    Defaults to true;
 * @param string $valueKey            index for values, in case $flattenValues was set to
        *                            false. Defaults to "@value"
 * @param string $attributesKey        index for attributes, in case $flattenAttributes was set to
        *                            false. Defaults to "@attributes"
 * @param string $childrenKey        index for children, in case $flattenChildren was set to
        *                            false. Defaults to "@children"
 * @return array the resulting array.
 */
function simpleXMLToArray($xml, 
                $flattenValues=true,
                $flattenAttributes = true,
                $flattenChildren=true,
                $valueKey='@value',
                $attributesKey='@attributes',
                $childrenKey='@children'){

    $return = array();
    if(!($xml instanceof SimpleXMLElement)){return $return;}
    $name = $xml->getName();
    $_value = trim((string)$xml);
    if(strlen($_value)==0){$_value = null;};

    if($_value!==null){
        if(!$flattenValues){$return[$valueKey] = $_value;}
        else{$return = $_value;}
    }

    $children = array();
    $first = true;
    foreach($xml->children() as $elementName => $child){
        $value = simpleXMLToArray($child, $flattenValues, $flattenAttributes, $flattenChildren, $valueKey, $attributesKey, $childrenKey);
        if(isset($children[$elementName])){
            if($first){
                $temp = $children[$elementName];
                unset($children[$elementName]);
                $children[$elementName][] = $temp;
                $first=false;
            }
            $children[$elementName][] = $value;
        }
        else{
            $children[$elementName] = $value;
        }
    }
    if(count($children)>0){
        if(!$flattenChildren){$return[$childrenKey] = $children;}
        else{$return = array_merge($return,$children);}
    }

    $attributes = array();
    foreach($xml->attributes() as $name=>$value){
        $attributes[$name] = trim($value);
    }
    if(count($attributes)>0){
        if(!$flattenAttributes){$return[$attributesKey] = $attributes;}
        else{$return = array_merge($return, $attributes);}
    }
    
    return $return;
}

function pp_plugins_url($path)
{
	return get_stylesheet_directory_uri().'/plugins/'.$path;
}

function pp_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}

function curl($url) {
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    // EDIT your domain to the next line:
    curl_setopt($ch,CURLOPT_TIMEOUT,10);
    $data = curl_exec($ch);
    
    if (curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
        $data === false;
    }
    curl_close($ch);
    return $data;
}

function get_youtube_subscribers($channel) {
	$data = @file_get_contents('http://gdata.youtube.com/feeds/api/users/'.$channel);
	if($data === FALSE) 
	{
		return false;
	}
	else
	{
		$xml = new SimpleXMLElement($data);
		$stats_data = (array)$xml->children('yt', true)->statistics->attributes();
		$stats_data = $stats_data['@attributes'];
		
		return $stats_data;
	}
}

function pp_apply_content($pp_content) {
	$pp_content = apply_filters('the_content', $pp_content);
    $pp_content = str_replace(']]>', ']]>', $pp_content);
    
    return $pp_content;
}

function pp_apply_builder($page_id) {
	$ppb_form_data_order = get_post_meta($page_id, 'ppb_form_data_order');
	
	if(isset($ppb_form_data_order[0]))
	{
	    $ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
	}
	
	include (get_template_directory() . "/lib/contentbuilder.shortcode.lib.php");
	//pp_debug($ppb_shortcodes);
	
	if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
	{
	    $ppb_shortcode_code = '';
	
	    foreach($ppb_form_item_arr as $key => $ppb_form_item)
	    {
	    	$ppb_form_item_data = get_post_meta($page_id, $ppb_form_item.'_data');
	    	$ppb_form_item_size = get_post_meta($page_id, $ppb_form_item.'_size');
	    	$ppb_form_item_data_obj = json_decode($ppb_form_item_data[0]);
	    	//pp_debug($ppb_form_item_data_obj);
	    	$ppb_shortcode_content_name = $ppb_form_item_data_obj->shortcode.'_content';
	    	
	    	if(isset($ppb_form_item_data_obj->$ppb_shortcode_content_name))
	    	{
	    		$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
	    		
	    		//Get shortcode title
	    		$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	    		if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	    		{
	    			$ppb_shortcode_code.= 'title="'.urldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name).'" ';
	    		}
	    		
	    		//Get shortcode attributes
	    		$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
	    		
	    		foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
	    		{
	    			$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
	    			
	    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
	    			{
	    				$ppb_shortcode_code.= $attr_name.'="'.$ppb_form_item_data_obj->$ppb_shortcode_attr_name.'" ';
	    			}
	    		}

	    		$ppb_shortcode_code.= ']'.urldecode($ppb_form_item_data_obj->$ppb_shortcode_content_name).'[/'.$ppb_form_item_data_obj->shortcode.']';
	    	}
	    	else
	    	{
	    		$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
	    		
	    		//Get shortcode title
	    		$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	    		if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	    		{
	    			$ppb_shortcode_code.= 'title="'.urldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name).'" ';
	    		}
	    		
	    		//Get shortcode attributes
	    		$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
	    		
	    		foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
	    		{
	    			$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
	    			
	    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
	    			{
	    				$ppb_shortcode_code.= $attr_name.'="'.$ppb_form_item_data_obj->$ppb_shortcode_attr_name.'" ';
	    			}
	    		}
	    		
	    		$ppb_shortcode_code.= ']';
	    	}
	    	
	    	echo pp_apply_content($ppb_shortcode_code);
	    	//echo $ppb_shortcode_code.'<hr/>';
        }
    }
    
    return false;
}

function get_review_score($post_id = false){
	if(function_exists('taqyeem_get_score')) 
	{
		global $post ;
		
		if( empty($post_id) ) $post_id = $post->ID;
		
		$summary = 0;
		$get_meta = get_post_custom( $post_id );
		if( !empty( $get_meta['taq_review_position'][0] ) )
		{
			$total_score = $get_meta['taq_review_score'][0];
			return number_format($total_score/10, 1);
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function auto_link_twitter ($text)
{
    // properly formatted URLs
    $urls = "/(((http[s]?:\/\/)|(www\.))?(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
    $text = preg_replace($urls, " <a href='$1'>$1</a>", $text);

    // URLs without protocols
    $text = preg_replace("/href=\"www/", "href=\"http://www", $text);

    // Twitter usernames
    $twitter = "/@([A-Za-z0-9_]+)/is";
    $text = preg_replace ($twitter, " <a href='http://twitter.com/$1'>@$1</a>", $text);

    // Twitter hashtags
    $hashtag = "/#([A-Aa-z0-9_-]+)/is";
    $text = preg_replace ($hashtag, " <a href='http://hashtags.org/$1'>#$1</a>", $text);
    return $text;
}

function is_layerslider_active() 
{
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$is_layerslider_plugin_active = is_plugin_active('LayerSlider/layerslider.php');
	
	if(!$is_layerslider_plugin_active)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function author_comment_count($author_email)
{
	$oneText = '1 '.__( 'Comment', THEMEDOMAIN );
	$moreText = '% '.__( 'Comments', THEMEDOMAIN );
 
	global $wpdb;
 
	$result = $wpdb->get_var('
		SELECT
			COUNT(comment_ID)
		FROM
			'.$wpdb->comments.'
		WHERE
			comment_author_email = "'.$author_email.'"'
	);
 
	if($result == 1): 
 
		echo str_replace('%', $result, $oneText);
 
	elseif($result > 1): 
 
		echo str_replace('%', $result, $moreText);
 
	endif;
}

function pp_get_image_id($image_url) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $image_url ));
    
    if(isset($attachment[0]))
    {
    	return $attachment[0]; 
    }
    else
    {
	    return '';
    }
}

function HexToRGB($hex) 
{
	$hex = preg_replace("/#/", "", $hex);
	$color = array();
	
	if(strlen($hex) == 3) {
	    $color['r'] = hexdec(substr($hex, 0, 1) . $r);
	    $color['g'] = hexdec(substr($hex, 1, 1) . $g);
	    $color['b'] = hexdec(substr($hex, 2, 1) . $b);
	}
	else if(strlen($hex) == 6) {
	    $color['r'] = hexdec(substr($hex, 0, 2));
	    $color['g'] = hexdec(substr($hex, 2, 2));
	    $color['b'] = hexdec(substr($hex, 4, 2));
	}
	
	return $color;
}

function theme_queue_js(){
  if (!is_admin()){
    if (!is_page() AND is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}
add_action('get_header', 'theme_queue_js');

?>