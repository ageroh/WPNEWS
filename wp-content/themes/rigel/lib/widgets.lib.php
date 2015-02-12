<?php

/**
*	Begin Recent Posts Custom Widgets
**/

class Custom_Recent_Posts extends WP_Widget {
	function Custom_Recent_Posts() {
		$widget_ops = array('classname' => 'Custom_Recent_Posts', 'description' => 'The recent posts with thumbnails' );
		$this->WP_Widget('Custom_Recent_Posts', 'Custom Recent Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		$highlight_latest = empty($instance['highlight_latest']) ? ' ' : apply_filters('widget_title', $instance['highlight_latest']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
			pp_posts('recent', $items, TRUE, trim($show_thumb), trim($highlight_latest));
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);
		$instance['highlight_latest'] = strip_tags($new_instance['highlight_latest']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'show_thumb' => '', 'highlight_latest' => '') );
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);
		$highlight_latest = strip_tags($instance['highlight_latest']);

?>
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 3): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('show_thumb'); ?>">Display Thumbnails: <input class="widefat" id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('highlight_latest'); ?>">Highlight On Latest Post: <input class="widefat" id="<?php echo $this->get_field_id('highlight_latest'); ?>" name="<?php echo $this->get_field_name('highlight_latest'); ?>" type="checkbox" value="1" <?php if(!empty($highlight_latest)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

register_widget('Custom_Recent_Posts');

/**
*	End Recent Posts Custom Widgets
**/


/**
*	Begin Popular Posts Custom Widgets
**/

class Custom_Popular_Posts extends WP_Widget {
	function Custom_Popular_Posts() {
		$widget_ops = array('classname' => 'Custom_Popular_Posts', 'description' => 'The popular posts with thumbnails' );
		$this->WP_Widget('Custom_Popular_Posts', 'Custom Popular Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		$highlight_latest = empty($instance['highlight_latest']) ? ' ' : apply_filters('widget_title', $instance['highlight_latest']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
			pp_posts('popular', $items, TRUE, trim($show_thumb), trim($highlight_latest));
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);
		$instance['highlight_latest'] = strip_tags($new_instance['highlight_latest']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'show_thumb' => '', 'highlight_latest' => '') );
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);
		$highlight_latest = strip_tags($instance['highlight_latest']);

?>
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 3): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('show_thumb'); ?>">Display Thumbnails: <input class="widefat" id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('highlight_latest'); ?>">Highlight On Latest Post: <input class="widefat" id="<?php echo $this->get_field_id('highlight_latest'); ?>" name="<?php echo $this->get_field_name('highlight_latest'); ?>" type="checkbox" value="1" <?php if(!empty($highlight_latest)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

register_widget('Custom_Popular_Posts');

/**
*	End Popular Posts Custom Widgets
**/


/**
*	Begin Best Review Custom Widgets
**/

class Custom_Best_Review extends WP_Widget {
	function Custom_Best_Review() {
		$widget_ops = array('classname' => 'Custom_Best_Review', 'description' => 'The posts order by review points' );
		$this->WP_Widget('Custom_Best_Review', 'Custom Best Review Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
			pp_best_review($items, TRUE);
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '' ) );
		$items = strip_tags($instance['items']);

?>
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 3): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Best_Review');

/**
*	End Best Review Custom Widgets
**/


/**
*	Begin Tabbed Posts Custom Widgets
**/

class Custom_Tabbed_Posts extends WP_Widget {
	function Custom_Tabbed_Posts() {
		$widget_ops = array('classname' => 'Custom_Tabbed_Posts', 'description' => 'The recent, popular and recent review posts with thumbnails' );
		$this->WP_Widget('Custom_Tabbed_Posts', 'Custom Tabbed Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		$highlight_latest = empty($instance['highlight_latest']) ? ' ' : apply_filters('widget_title', $instance['highlight_latest']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
			pp_tabbed_posts('recent', $items, TRUE, trim($show_thumb), trim($highlight_latest));
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);
		$instance['highlight_latest'] = strip_tags($new_instance['highlight_latest']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'show_thumb' => '', 'highlight_latest' => '') );
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);
		$highlight_latest = strip_tags($instance['highlight_latest']);

?>
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 3): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('show_thumb'); ?>">Display Thumbnails: <input class="widefat" id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('highlight_latest'); ?>">Highlight On Latest Post: <input class="widefat" id="<?php echo $this->get_field_id('highlight_latest'); ?>" name="<?php echo $this->get_field_name('highlight_latest'); ?>" type="checkbox" value="1" <?php if(!empty($highlight_latest)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

register_widget('Custom_Tabbed_Posts');

/**
*	End Tabbed Posts Custom Widgets
**/


/**
*	Begin Twitter Feed Custom Widgets
**/

class Custom_Twitter extends WP_Widget {
	function Custom_Twitter() {
		$widget_ops = array('classname' => 'Custom_Twitter', 'description' => 'Display your recent Twitter feed' );
		$this->WP_Widget('Custom_Twitter', 'Custom Twitter', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$twitter_username = empty($instance['twitter_username']) ? ' ' : apply_filters('widget_title', $instance['twitter_username']);
		$title = $instance['title'];
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		
		$consumer_key = get_option(SHORTNAME."_twitter_consumer_key");
		$consumer_secret = get_option(SHORTNAME."_twitter_consumer_secret");
		$access_token = get_option(SHORTNAME."_twitter_consumer_token");;
		$access_token_secret = get_option(SHORTNAME."_twitter_consumer_token_secret");
		
		if(!is_numeric($items))
		{
			$items = 5;
		}
		
		if(empty($title))
		{
			$title = 'Recent Tweets';
		}
		
		if(!empty($items) && !empty($twitter_username))
		{
			// Begin get user timeline
			include_once (get_template_directory() . "/lib/twitter.lib.php");
			$obj_twitter = new Twitter($twitter_username); 
			$obj_twitter->consumer_key = $consumer_key;
			$obj_twitter->consumer_secret = $consumer_secret;
			$obj_twitter->access_token = $access_token;
			$obj_twitter->access_token_secret = $access_token_secret;
			
			$tweets = $obj_twitter->get($items);

			if(!empty($tweets))
			{
				echo '<h2 class="widgettitle">'.$title.'</h2>';
				echo '<ul class="twitter">';
				
				foreach($tweets as $tweet)
				{
					echo '<li>';
					$tweet_replaced = $input = preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i',
                      '<a href="http://www.twitter.com/$1">@$1</a>',
                      $tweet['text']);
					
					if(isset($tweet['text']))
					{
						echo $tweet_replaced;
					}
					
					echo '</li>';
				}
				
				echo '</ul>';
			}
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['twitter_username'] = strip_tags($new_instance['twitter_username']);
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'twitter_username' => '', 'title' => '', 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_token_secret' => '') );
		$items = strip_tags($instance['items']);
		$twitter_username = strip_tags($instance['twitter_username']);
		$title = strip_tags($instance['title']);

?>
			<p>
				<label for="<?php echo $this->get_field_id('twitter_username'); ?>">Twitter Username: <input class="widefat" id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" type="text" value="<?php echo esc_attr($twitter_username); ?>" /></label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('items'); ?>">Items (default 8): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label>
			</p>
<?php
	}
}

register_widget('Custom_Twitter');

/**
*	End Twitter Feed Custom Widgets
**/


/**
*	Begin Flickr Feed Custom Widgets
**/

class Custom_Flickr extends WP_Widget {
	function Custom_Flickr() {
		$widget_ops = array('classname' => 'Custom_Flickr', 'description' => 'Display your recent Flickr photos' );
		$this->WP_Widget('Custom_Flickr', 'Custom Flickr', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$flickr_id = empty($instance['flickr_id']) ? ' ' : apply_filters('widget_title', $instance['flickr_id']);
		$title = $instance['title'];
		$items = $instance['items'];
		
		if(!is_numeric($items))
		{
			$items = 8;
		}
		
		if(empty($title))
		{
			$title = 'Photostream';
		}
		
		if(!empty($items) && !empty($flickr_id))
		{
			$photos_arr = get_flickr(array('type' => 'user', 'id' => $flickr_id, 'items' => $items));
			
			if(!empty($photos_arr))
			{
				echo '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
				echo '<ul class="flickr">';
				
				foreach($photos_arr as $photo)
				{
					echo '<li>';
					echo '<div class="post_circle_thumb"><a href="'.$photo['url'].'"><img class="frame" src="'.$photo['thumb_url'].'" alt="" /></a></div>';
					echo '</li>';
				}
				
				echo '</ul>';
			}
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'flickr_id' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$flickr_id = strip_tags($instance['flickr_id']);
		$title = strip_tags($instance['title']);

?>
			<p><label for="<?php echo $this->get_field_id('flickr_id'); ?>">Flickr ID <a href="http://idgettr.com/">Find your Flickr ID here</a>: <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo esc_attr($flickr_id); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 8): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Flickr');

/**
*	End Flickr Feed Custom Widgets
**/


/**
*	Begin Photo in News Custom Widgets
**/

class Custom_Photos_News extends WP_Widget {
	function Custom_Photos_News() {
		$widget_ops = array('classname' => 'Custom_Photos_News', 'description' => 'Display Photos in News' );
		$this->WP_Widget('Custom_Photos_News', 'Custom Photo in News', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? 0 : $instance['title'];
		$items = empty($instance['items']) ? 0 : $instance['items'];
		
		if(empty($title))
		{
			$title = __('Photo in News', THEMEDOMAIN); 
		}
		
		if(empty($items))
		{
			$items = 8;
		}

		pp_photos_in_news($items, $title);

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['items'] = strip_tags($new_instance['items']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'items' => '') );
		$title = strip_tags($instance['title']);
		$items = strip_tags($instance['items']);

?>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 8): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Photos_News');

/**
*	End Photo in News Custom Widgets
**/


/**
*	Begin Our Authors Custom Widgets
**/

class Custom_Our_Authors extends WP_Widget {
	function Custom_Our_Authors() {
		$widget_ops = array('classname' => 'Custom_Our_Authors', 'description' => 'Display All Authors' );
		$this->WP_Widget('Custom_Our_Authors', 'Custom Our Authors', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? 0 : $instance['title'];
		$items = empty($instance['items']) ? 0 : $instance['items'];
		
		if(empty($title))
		{
			$title = __('Our Authors', THEMEDOMAIN); 
		}
		
		if(empty($items))
		{
			$items = 8;
		}

		pp_authors($items, $title);

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['items'] = strip_tags($new_instance['items']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'items' => '') );
		$title = strip_tags($instance['title']);
		$items = strip_tags($instance['items']);

?>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 8): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Our_Authors');

/**
*	End Our Authors Custom Widgets
**/


/**
*	Begin Category Posts Custom Widgets
**/

class Custom_Cat_Posts extends WP_Widget {
	function Custom_Cat_Posts() {
		$widget_ops = array('classname' => 'Custom_Cat_Posts', 'description' => 'Display category\'s post' );
		$this->WP_Widget('Custom_Cat_Posts', 'Custom Category Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$cat_id = empty($instance['cat_id']) ? 0 : $instance['cat_id'];
		$items = empty($instance['items']) ? 0 : $instance['items'];
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		$highlight_latest = empty($instance['highlight_latest']) ? ' ' : apply_filters('widget_title', $instance['highlight_latest']);
		
		if(empty($items))
		{
			$items = 5;
		}
		
		if(!empty($cat_id))
		{
			pp_cat_posts($cat_id, $items, TRUE, trim($show_thumb), trim($highlight_latest));
		}

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['cat_id'] = strip_tags($new_instance['cat_id']);
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);
		$instance['highlight_latest'] = strip_tags($new_instance['highlight_latest']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'cat_id' => '', 'items' => '', 'show_thumb' => '', 'highlight_latest' => '') );
		$cat_id = strip_tags($instance['cat_id']);
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);
		$highlight_latest = strip_tags($instance['highlight_latest']);
		
		$categories = get_categories('hide_empty=0&orderby=name');
		$wp_cats = array(
			0		=> "Choose a category"
		);
		foreach ($categories as $category_list ) {
			$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
		}

?>
			
			<p><label for="<?php echo $this->get_field_id('cat_id'); ?>">Category: 
				<select  id="<?php echo $this->get_field_id('cat_id'); ?>" name="<?php echo $this->get_field_name('cat_id'); ?>">
				<?php
					foreach($wp_cats as $wp_cat_id => $wp_cat)
					{
				?>
						<option value="<?php echo $wp_cat_id; ?>" <?php if(esc_attr($cat_id) == $wp_cat_id) { echo 'selected="selected"'; } ?>><?php echo $wp_cat; ?></option>
				<?php
					}
				?>
				</select>
			</label></p>
			
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 5): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('show_thumb'); ?>">Display Thumbnails: <input class="widefat" id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('highlight_latest'); ?>">Highlight On Latest Post: <input class="widefat" id="<?php echo $this->get_field_id('highlight_latest'); ?>" name="<?php echo $this->get_field_name('highlight_latest'); ?>" type="checkbox" value="1" <?php if(!empty($highlight_latest)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

register_widget('Custom_Cat_Posts');

/**
*	End Category Posts Custom Widgets
**/

/**
*	Begin Facebook Page Custom Widgets
**/

class Custom_Facebook_Page extends WP_Widget {
	function Custom_Facebook_Page() {
		$widget_ops = array('classname' => 'Custom_Facebook_Page', 'description' => 'Facebook page like box' );
		$this->WP_Widget('Custom_Facebook_Page', 'Custom Facebook Page', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$fb_page_url = $instance['fb_page_url'];
		
		if(!empty($fb_page_url))
		{
			if(isset($_SESSION['pp_menu_style']))
			{
				$pp_menu_style = $_SESSION['pp_menu_style'];
			}
			else
			{
				$pp_menu_style = get_option('pp_menu_style');
			}
			
			$fb_skin = 'light';
			$fb_border = 'ffffff';
			if($pp_menu_style != 3 && $pp_menu_style != 6)
			{
				$fb_skin = 'light';
				$fb_border = 'ffffff';
			}
			else
			{
				$fb_skin = 'dark';
				$fb_border = '191919';
			}
?>
<h2 class="widgettitle">Find us on Facebook</h2>
<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($fb_page_url); ?>&amp;width=295&amp;height=558&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=true&amp;show_border=false&amp;appId=268239076529520" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:558px;" allowTransparency="true"></iframe>
<?php
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['fb_page_url'] = strip_tags($new_instance['fb_page_url']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'fb_page_url' => '') );
		$fb_page_url = strip_tags($instance['fb_page_url']);

?>
			<p><label for="<?php echo $this->get_field_id('fb_page_url'); ?>">Facebook Page URL: <input class="widefat" id="<?php echo $this->get_field_id('fb_page_url'); ?>" name="<?php echo $this->get_field_name('fb_page_url'); ?>" type="text" value="<?php echo esc_attr($fb_page_url); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Facebook_Page');

/**
*	End Facebook Page Custom Widgets
**/


/**
*	Begin Social Counter Custom Widgets
**/

class Custom_Social_Counter extends WP_Widget {
	function Custom_Social_Counter() {
		$widget_ops = array('classname' => 'Custom_Social_Counter', 'description' => 'Display your Feedburner, Twitter and Facebook fans counters' );
		$this->WP_Widget('Custom_Social_Counter', 'Custom Social Counter', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = $instance['title'];
		$pp_twitter_username = get_option(SHORTNAME.'_twitter_username');
		$pp_facebook_username = get_option(SHORTNAME.'_facebook_username');
		$pp_youtube_username = get_option(SHORTNAME.'_youtube_username');
		$consumer_key = get_option(SHORTNAME."_twitter_consumer_key");
		$consumer_secret = get_option(SHORTNAME."_twitter_consumer_secret");
		$access_token = get_option(SHORTNAME."_twitter_consumer_token");;
		$access_token_secret = get_option(SHORTNAME."_twitter_consumer_token_secret");
		
		if(!empty($title))
		{
			echo '<h2 class="widgettitle">'.$title.'</h2>';
		}
		
		$twitter_icon_name = 'social_twitter_light';
		$facebook_icon_name = 'social_facebook_light';
		$youtube_icon_name = 'social_youtube_light';
?>
		    <div class="social_profile">
		    	<?php
		        	if(!empty($pp_facebook_username))
		        	{
		        ?>
		    	<div class="profile">
		        	<a class="social_icon facebook" href="http://www.facebook.com/<?php echo $pp_facebook_username; ?>">
		        		<i class="fa fa-facebook"></i>
		        	</a>
		        	<div class="counter">
		        		<h4><?php pp_facebook_fans(); ?></h4>
		        		<span class="count"><?php _e( 'fans', THEMEDOMAIN ); ?></span>
		        	</div>
		        	<a class="button" href="http://www.facebook.com/<?php echo $pp_facebook_username; ?>"><?php _e( 'Like', THEMEDOMAIN ); ?></a>
		        </div>
		        <?php
		        	}
		        ?>
		        <?php
		        	if(!empty($pp_twitter_username) && !empty($consumer_key) && !empty($consumer_secret) && !empty($access_token) && !empty($access_token_secret))
		        	{
		        ?>
		        <div class="profile">
		        	<a class="social_icon twitter" href="http://twitter.com/<?php echo $pp_twitter_username; ?>">
		        		<i class="fa fa-twitter"></i>
		        	</a>
		        	<div class="counter">
		        		<h4><?php pp_twitter_followers($consumer_key, $consumer_secret, $access_token, $access_token_secret); ?></h4>
		        		<span class="count"><?php _e( 'followers', THEMEDOMAIN ); ?></span>
		        	</div>
		        	<a class="button" href="http://twitter.com/<?php echo $pp_twitter_username; ?>"><?php _e( 'Follow', THEMEDOMAIN ); ?></a>
		        </div>
		        <?php
		        	}
		        ?>
		        <?php
		        	if(!empty($pp_youtube_username))
		        	{
		        ?>
		        <div class="profile">
		        	<a class="social_icon youtube" href="http://www.youtube.com/user/<?php echo $pp_youtube_username; ?>">
		        		<i class="fa fa-youtube-play"></i>
		        	</a>
		        	<div class="counter">
		        		<h4><?php pp_youtube_subscribers(); ?></h4>
		        		<span class="count"><?php _e( 'subscribers', THEMEDOMAIN ); ?></span>
		        	</div>
		        	<a class="button" href="http://www.youtube.com/user/<?php echo $pp_youtube_username; ?>"><?php _e( 'Subscribe', THEMEDOMAIN ); ?></a>
		        </div>
		        <?php
		        	}
		        ?>
		    </div>
<?php
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_token_secret' => '') );
		$title = strip_tags($instance['title']);
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
		</p>
<?php
	}
}

register_widget('Custom_Social_Counter');

/**
*	End Social Counter Custom Widgets
**/

/**
*	Begin Custom Ads Widgets
**/

class Custom_Ads extends WP_Widget {
	function Custom_Ads() {
		$widget_ops = array('classname' => 'Custom_Ads', 'description' => 'Enter your advertisement embed code' );
		$this->WP_Widget('Custom_Ads', 'Custom Ads', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$ads_code = $instance['ads_code'];
		
		if(!empty($ads_code))
		{
			echo stripslashes(html_entity_decode($ads_code));
		}
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['ads_code'] = $new_instance['ads_code'];

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'ads_code' => '') );
		$ads_code = $instance['ads_code'];

?>
			<p><label for="<?php echo $this->get_field_id('ads_code'); ?>">Enter your advertisement embed code below: <textarea class="widefat" id="<?php echo $this->get_field_id('ads_code'); ?>" name="<?php echo $this->get_field_name('ads_code'); ?>"><?php echo esc_attr($ads_code); ?></textarea></label></p>
<?php
	}
}

register_widget('Custom_Ads');

/**
*	End Custom Ads Widgets
**/


/**
*	Begin Category Posts Slideshow Custom Widgets
**/

class Custom_Cat_Slideshow_Posts extends WP_Widget {
	function Custom_Cat_Slideshow_Posts() {
		$widget_ops = array('classname' => 'Custom_Cat_Slideshow_Posts', 'description' => 'Display category\'s post in slideshow' );
		$this->WP_Widget('Custom_Cat_Slideshow_Posts', 'Custom Category Slideshow Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$cat_id = empty($instance['cat_id']) ? 0 : $instance['cat_id'];
		$items = empty($instance['items']) ? 0 : $instance['items'];
		
		if(empty($items))
		{
			$items = 5;
		}
		
		if(!empty($cat_id))
		{
			pp_cat_slideshow_posts($cat_id, $items, TRUE);
		}

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['cat_id'] = strip_tags($new_instance['cat_id']);
		$instance['items'] = strip_tags($new_instance['items']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'cat_id' => '', 'items' => '') );
		$cat_id = strip_tags($instance['cat_id']);
		$items = strip_tags($instance['items']);
		
		$categories = get_categories('hide_empty=0&orderby=name');
		$wp_cats = array(
			0		=> "Choose a category"
		);
		foreach ($categories as $category_list ) {
			$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
		}

?>
			
			<p><label for="<?php echo $this->get_field_id('cat_id'); ?>">Category: 
				<select  id="<?php echo $this->get_field_id('cat_id'); ?>" name="<?php echo $this->get_field_name('cat_id'); ?>">
				<?php
					foreach($wp_cats as $wp_cat_id => $wp_cat)
					{
				?>
						<option value="<?php echo $wp_cat_id; ?>" <?php if(esc_attr($cat_id) == $wp_cat_id) { echo 'selected="selected"'; } ?>><?php echo $wp_cat; ?></option>
				<?php
					}
				?>
				</select>
			</label></p>
			
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 5): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Cat_Slideshow_Posts');

/**
*	End Category Posts Slideshow Custom Widgets
**/


/**
*	Begin Gallery Slideshow Custom Widgets
**/

class Custom_Gallery_Slideshow extends WP_Widget {
	function Custom_Gallery_Slideshow() {
		$widget_ops = array('classname' => 'Custom_Gallery_Slideshow', 'description' => 'Display gallery\'s image in slideshow' );
		$this->WP_Widget('Custom_Gallery_Slideshow', 'Custom Gallery Slideshow', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$gallery_id = empty($instance['gallery_id']) ? 0 : $instance['gallery_id'];
		$items = empty($instance['items']) ? 0 : $instance['items'];
		
		if(empty($items))
		{
			$items = 5;
		}
		
		if(!empty($gallery_id))
		{
			pp_gallery_slideshow($gallery_id, $items, TRUE);
		}

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['gallery_id'] = strip_tags($new_instance['gallery_id']);
		$instance['items'] = strip_tags($new_instance['items']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'gallery_id' => '', 'items' => '') );
		$gallery_id = strip_tags($instance['gallery_id']);
		$items = strip_tags($instance['items']);
		
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

?>
			
			<p><label for="<?php echo $this->get_field_id('gallery_id'); ?>">Category: 
				<select  id="<?php echo $this->get_field_id('gallery_id'); ?>" name="<?php echo $this->get_field_name('gallery_id'); ?>">
				<?php
					foreach($galleries_select as $gallery_select_id => $gallery)
					{
				?>
						<option value="<?php echo $gallery_select_id; ?>" <?php if(esc_attr($gallery_id) == $gallery_select_id) { echo 'selected="selected"'; } ?>><?php echo $gallery; ?></option>
				<?php
					}
				?>
				</select>
			</label></p>
			
			<p><label for="<?php echo $this->get_field_id('items'); ?>">Items (default 5): <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Custom_Gallery_Slideshow');

/**
*	End Gallery Slideshow Custom Widgets
**/
?>