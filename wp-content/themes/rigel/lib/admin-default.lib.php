<?php
// Get Twitter Follower count as plain text
add_option('pp_twitter_followers','0','','yes');
add_option('pp_twitter_api_timer',time(),'','yes');

function pp_twitter_followers($consumer_key, $consumer_secret, $access_token, $access_token_secret) {
	$twittercount = get_option('pp_twitter_followers');

    if ( $twittercount == 0 OR get_option(SHORTNAME.'_twitter_api_timer') < (time() - 3600) ) {
        // EDIT your Twitter user name here:
        $twitter_id = get_option(SHORTNAME.'_twitter_username');
        
        $connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);
		$tweets = $connection->get('https://api.twitter.com/1.1/users/show.json?screen_name=' . $twitter_id);
		
		if(!empty($tweets->errors)){
		    if($tweets->errors[0]->message == 'Invalid or expired token'){
		    	echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
		    }else{
		    	echo '<strong>'.$tweets->errors[0]->message.'</strong>';
		    }
		    return;
		}

        if(is_object($tweets) && $tweets->followers_count > 0)
		{
        	update_option('pp_twitter_followers', $tweets->followers_count);
        	update_option('pp_twitter_api_timer', time());
        	$twittercount = $tweets->followers_count;
        }
        else
        {
        	$twittercount = get_option('pp_twitter_followers');
        }
    }
    else
    {
    	$twittercount = get_option('pp_twitter_followers');
    }
    if ( $twittercount != '0' ) { echo number_format($twittercount); }
    else { echo 0; }
}

// Get Facebook fan count as plain text
add_option('pp_facebook_fans','0','','yes');
add_option('pp_facebook_api_timer',time(),'','yes');

function pp_facebook_fans() {
	$fancount = get_option('pp_facebook_fans');
    
    if ( $fancount == 0 OR get_option(SHORTNAME.'pp_facebook_api_timer') < (time() - 3600) ) {
        $page_id = get_option(SHORTNAME.'_facebook_username');
        $page_graph_data = curl("http://graph.facebook.com/".$page_id);
        try {
            $graph_obj = json_decode($page_graph_data);
            $count_fan = 0;
            if(is_object($graph_obj))
            {
				$count_fan = $graph_obj->likes;
			}
            
			if($count_fan > 0)
			{
            	update_option('pp_facebook_fans', $count_fan);
            	update_option('pp_facebook_api_timer', time());
            }
            else
            {
            	$count_fan = get_option('pp_facebook_fans');
            }
        } catch (Exception $e) { }
    }
    else
    {
    	$count_fan = get_option('pp_facebook_fans');
    }
    if ( $count_fan != '0' ) { echo number_format($count_fan); }
    else { echo 0; }
}

// Get Youtube subscribers count as plain text
add_option('pp_youtube_subscribers','0','','yes');
add_option('pp_youtube_api_timer',time(),'','yes');

function pp_youtube_subscribers() {
	$subscribers_count = get_option('pp_youtube_subscribers');
    
    if ( $subscribers_count == 0 OR get_option(SHORTNAME.'pp_youtube_api_timer') < (time() - 3600) ) {
        $youtube_user = get_option(SHORTNAME.'_youtube_username');
        $youtube_user_data = get_youtube_subscribers($youtube_user);
        try {
			$subscribers_count = $youtube_user_data['subscriberCount'];
            
			if($subscribers_count > 0)
			{
            	update_option('pp_youtube_subscribers', $subscribers_count);
            	update_option('pp_youtube_api_timer', time());
            }
            else
            {
            	$subscribers_count = get_option('pp_youtube_subscribers');
            }
        } catch (Exception $e) { }
    }
    else
    {
    	$subscribers_count = get_option('pp_youtube_subscribers');
    }
    if ( $subscribers_count != '0' ) { echo number_format($subscribers_count); }
    else { echo 0; }
}

function wpapi_pagination($pages = '', $range = 4)
{
 $showitems = ($range * 2)+1;
 
 global $paged;
 if(empty($paged)) $paged = 1;
 
 if($pages == '')
 {
 global $wp_query;
 $pages = $wp_query->max_num_pages;
 if(!$pages)
 {
 $pages = 1;
 }
 }
 
 if(1 != $pages)
 {
 echo "<div class=\"pagination\">";
 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
 for ($i=1; $i <= $pages; $i++)
 {
 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
 {
 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
 }
 }
 
 if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
 echo "</div>\n";
 }
}


//Make widget support shortcode
add_filter('widget_text', 'do_shortcode');

//Add custom tag could font size
function pp_tag_cloud_filter($args = array()) {
   $args['smallest'] = 10;
   $args['largest'] = 30;
   $args['unit'] = 'px';
   $args['number'] = 20;
   $args['taxonomy'] = 'post_tag';

   return $args;
}

add_filter('widget_tag_cloud_args', 'pp_tag_cloud_filter', 90);

if (isset($_GET['activated']) && $_GET['activated']){
	global $wpdb;
	
	// Run default settings
	include_once(get_template_directory() . "/default_settings.php");
	
    wp_redirect(admin_url("themes.php?page=admin-action.lib.php&activate=true"));
}
?>