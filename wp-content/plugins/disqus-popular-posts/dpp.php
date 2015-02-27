<?php

/*
	Plugin Name: Disqus Popular Posts
	Plugin URI: http://creativetwilight.com/
	Description: Shows the most popular posts by comments.
	Author: Thor
	Version: 1.2.4
	Author URI: http://creativetwilight.com/
*/

/**
 * Register the widget with WordPress
 */
function dpp_widget_init() {
	register_widget('dpp_widget');
}
/**
 * @package Main
 */
class dpp_widget extends WP_Widget {
	/**
	 * @var Tracks the database version of the stored results
	 */
	private $dpp_db_version = 2;

	function __construct() {
		parent::__construct(
			'dpp_widget', // Base ID
			__('Disqus Popular Posts', 'dpp_domain'), // Name
			array( 'description' => __( 'Shows the most popular posts by comments.', 'dpp_domain' ), ) // Args
		);
	}
	/**
	 * Renders the widget on the site.
	 * @param array $args Any arguments passed to the widget.
	 * @param array $instance The saved variables from the widget setup.
	 */
	public function widget($args, $instance) {
		$db_update = false;
		$dpp_db_version = get_option('dpp_db_version');

		if($dpp_db_version != $this->dpp_db_version) $db_update = true;

		$query_disqus = true;
		$now = date('Y-m-d H:i');
		$save_hours = $instance['save_hours'];

		$title = apply_filters('widget_title', $instance['title']);

		echo $args['before_widget'];

		if(!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

		// Only bother if I have proper variables and I'm not forcing a database update
		if($instance['save_results'] && $save_hours && !$db_update) {
			$last_run = get_option('dpp_last_run');

			if($last_run) { // It's run previously
			    $datetime1 = date_create($now);
			    $datetime2 = date_create($last_run);
			    $interval = date_diff($datetime1, $datetime2);

			    if($interval->format('%h') < $save_hours) $query_disqus = false;
			}
		}
		if(!$query_disqus) {
			$sorted_results = get_option('dpp_results');
			if($sorted_results) $sorted_results = unserialize($sorted_results);
			else $query_disqus = true; // No results so fetch them from Disqus
		}
		if($query_disqus && $instance['api_key'] && $instance['forum'] && $instance['interval'] && $instance['how_many']) {
			$url_call = "http://disqus.com/api/3.0/threads/listPopular.json?api_key=" . $instance['api_key'] . "&forum=" .$instance['forum'] . "&interval=" . $instance['interval'] . "d&limit=" . $instance[ 'how_many'];

			$get_contents = file_get_contents($url_call);
			if($get_contents) $results = json_decode($get_contents);

			if($results) {
				foreach($results->response as $key=>$fields) {
					$posts_by_count[$key] = $fields->posts;
				}

				arsort($posts_by_count);

				foreach($posts_by_count as $key=>$posts) {
					$sorted_results[$key] = $results->response[$key];
				}
			}
		}
		if($sorted_results) {
			if($query_disqus && $instance['save_results'] && $save_hours) {
				update_option('dpp_last_run', $now);
				update_option('dpp_results', serialize($sorted_results));
			}
			elseif(!$instance['save_results']) { // Unset the previous options if not saving
				update_option('dpp_last_run','');
				update_option('dpp_results','');
			}
			foreach($sorted_results as $key=>$fields) {
				$page_string = $fields->identifiers[0];
				$page_parts = explode(' ', $page_string);
				$post_id = $page_parts[0];
				$image = get_the_post_thumbnail($post_id, array($instance['size_w'], $instance['size_h']));

				$list .= '<div style="clear: both; margin-bottom: 10px;">' . (($instance['featured_image'] && $instance['size_w'] && $instance['size_h']) ? '<div style="float: ' . $instance['align_image'] . '; margin-' . (($instance['align_image'] == 'left') ? 'right' : 'left') . ': 5px;"><a href="' . $fields->link . '">' . $image . '</a></div>' : '') . '<div><strong><a href="' . $fields->link . '">' . $fields->title . '</a></strong>' . (($instance['show_date']) ? '<br />' . get_the_date('', $post_id ) : '') . '<br /><a href="' . $fields->link . '#disqus_thread">' . $fields->posts . ' Comments</a></div></div>';
			}

			echo $list;
		}

		echo $args['after_widget'];

		if($db_update) update_option('dpp_db_version', $this->dpp_db_version);
	}
	/**
	 * The form shown in the Admin->Widgets area.
	 * @param array $instance The variables for the widget which are saved.
	 */
	public function form($instance) {
		if(isset($instance[ 'title' ])) $title = $instance['title'];
		else $title = __('Popular Posts','dpp_domain');

		if(isset($instance['how_many'])) $how_many = $instance['how_many'];
		else $how_many = __('5','dpp_domain');

		if(isset($instance['api_key'])) $api_key = $instance['api_key'];
		else $api_key = __('Disqus API Key','dpp_domain');

		if(isset($instance['forum'])) $forum = $instance['forum'];
		else $forum = __('Disqus Shortname','dpp_domain');

		if(isset($instance['interval'])) $interval = $instance['interval'];
		else $interval = __('90','dpp_domain');

		if(isset($instance['size_w'])) $size_w = $instance['size_w'];
		else $size_w = __('100','dpp_domain');

		if(isset($instance['size_h'])) $size_h = $instance['size_h'];
		else $size_h = __('100','dpp_domain');

		if(isset($instance['align_image'])) $align_image = $instance['align_image'];
		else $align_image = __('left','dpp_domain');

		if(isset($instance['save_hours'])) $save_hours = $instance['save_hours'];
		else $save_hours = __('24','dpp_domain');

		?>
		<p>
		If you haven't yet then you will need to register a new application with the <a href="https://disqus.com/api/applications/" target="_blank">Disqus API</a> to obtain an API key to enter below.
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'featured_image' ); ?>"><?php _e( 'Show Featured Image:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'featured_image' ); ?>" name="<?php echo $this->get_field_name( 'featured_image' ); ?>" type="checkbox" value="1"<?php if(esc_attr($instance['featured_image']) == 1) echo " checked"; ?>> Yes
		</p>
		<p>
		<?php _e( 'Featured Image Size:' ); ?><br />
		Width (pixels): <input style="width: 50px;" id="<?php echo $this->get_field_id( 'size_w' ); ?>" name="<?php echo $this->get_field_name( 'size_w' ); ?>" type="text" value="<?php echo esc_attr( $size_w ); ?>">
		Height (pixels): <input style="width: 50px;" id="<?php echo $this->get_field_id( 'size_h' ); ?>" name="<?php echo $this->get_field_name( 'size_h' ); ?>" type="text" value="<?php echo esc_attr( $size_h ); ?>">
		</p>
		<p>
		<?php _e( 'Featured Image Alignment:' ); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('align_image'); ?>-left" name="<?php echo $this->get_field_name('align_image'); ?>" type="radio" value="left"<?php if($align_image == 'left') echo ' checked'; ?>> <label for="<?php echo $this->get_field_id('align_image'); ?>-left">Left</label> <input class="widefat" id="<?php echo $this->get_field_id('align_image'); ?>-right" name="<?php echo $this->get_field_name('align_image'); ?>" type="radio" value="right"<?php if($align_image == 'right') echo ' checked'; ?>> <label for="<?php echo $this->get_field_id('align_image'); ?>-right">Right</label>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show Post Date:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" type="checkbox" value="1"<?php if(esc_attr($instance['show_date']) == 1) echo " checked"; ?>> Yes
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'how_many' ); ?>"><?php _e( 'How Many Posts to Show:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'how_many' ); ?>" name="<?php echo $this->get_field_name( 'how_many' ); ?>" type="text" value="<?php echo esc_attr( $how_many ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'interval' ); ?>"><?php _e( 'Count Over How Many Days:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'interval' ); ?>" name="<?php echo $this->get_field_name( 'interval' ); ?>" type="text" value="<?php echo esc_attr( $interval ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('api_key'); ?>"><?php _e('Disqus API Key:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo esc_attr($api_key); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('forum'); ?>"><?php _e('Disqus Shortname:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('forum'); ?>" name="<?php echo $this->get_field_name('forum'); ?>" type="text" value="<?php echo esc_attr($forum); ?>"><br />
		<i>You can find this by <a href="https://disqus.com/admin/" target="_blank">logging into Disqus</a> and going to Settings for your site.</i>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('save_results'); ?>"><?php _e('Save the Results:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('save_results'); ?>" name="<?php echo $this->get_field_name('save_results'); ?>" type="checkbox" value="1"<?php if(esc_attr($instance['save_results']) == 1) echo " checked"; ?>> Yes<br />
		<i>This will save the results so that it does not have to query Disqus every time it loads.</i>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('save_hours'); ?>"><?php _e('Save Results for How Many Hours?:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('save_hours'); ?>" name="<?php echo $this->get_field_name('save_hours'); ?>" type="text" value="<?php echo esc_attr($save_hours); ?>"><br />
		<i>If you save the results then they will be saved for this many hours and rechecked when that time is met.</i>
		</p>
		<p>
		Please <a href="https://wordpress.org/support/view/plugin-reviews/disqus-popular-posts" target="_blank">rate and review</a>. I'd greatly appreciate it!
		</p>
		<?php
	}
	/**
	 * Handles updating the widget variables.
	 * @param array $new_instance The new variables.
	 * @param array $old_instance The old variables.
	 * @return array The variables to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['how_many'] = (!empty( $new_instance['how_many'])) ? strip_tags($new_instance['how_many']) : '';
		$instance['api_key'] = (!empty( $new_instance['api_key'])) ? strip_tags($new_instance['api_key']) : '';
		$instance['forum'] = (!empty( $new_instance['forum'])) ? strip_tags($new_instance['forum']) : '';
		$instance['interval'] = (!empty( $new_instance['interval'])) ? strip_tags($new_instance['interval']) : '';
		$instance['featured_image'] = (!empty( $new_instance['featured_image'])) ? strip_tags( $new_instance['featured_image']) : '';
		$instance['size_w'] = (!empty( $new_instance['size_w'])) ? strip_tags($new_instance['size_w']) : '';
		$instance['size_h'] = (!empty( $new_instance['size_h'])) ? strip_tags($new_instance['size_h']) : '';
		$instance['show_date'] = (!empty( $new_instance['show_date'])) ? strip_tags($new_instance['show_date']) : '';
		$instance['align_image'] = (!empty( $new_instance['align_image'])) ? strip_tags($new_instance['align_image']) : '';
		$instance['save_results'] = (!empty( $new_instance['save_results'])) ? strip_tags($new_instance['save_results']) : '';
		$instance['save_hours'] = (!empty( $new_instance['save_hours'])) ? strip_tags(ceil($new_instance['save_hours'])) : '';

		return $instance;
	}
}

add_action('widgets_init', 'dpp_widget_init');

?>