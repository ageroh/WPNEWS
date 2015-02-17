<?php
/**
 * The Sidebar containing the widget areas.
 *
 * @package WordPress
 */
?>


<ul class="sidebar_widget">
	<?php 
		dynamic_sidebar( 'Page Sidebar' ); 
		//$sidebar_id = ( is_category() ) ? sanitize_title( get_cat_name( get_query_var( 'cat' ) ) ) . '-sidebar' : 'sidebar';
		//dynamic_sidebar( $sidebar_id );
	?>
</ul>