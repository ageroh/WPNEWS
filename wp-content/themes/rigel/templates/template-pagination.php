<?php
    if($wp_query->max_num_pages > 1)
    {
?>
    <br class="clear"/>
     <?php 
     	if (function_exists("wpapi_pagination")) {
     		$pp_blog_advance_pagination = get_option('pp_blog_advance_pagination');
     		
     		if(!empty($pp_blog_advance_pagination))
     		{
         		wpapi_pagination($wp_query->max_num_pages);
     		}
     		else
     		{
     			posts_nav_link();
     		}
     	}
     ?>
     <div class="pagination_detail">
     	<?php
     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
     	?>
     	<?php _e( 'Page', THEMEDOMAIN ); ?> <?php echo $paged; ?> <?php _e( 'of', THEMEDOMAIN ); ?> <?php echo $wp_query->max_num_pages; ?>
     </div>
 <?php
 	}
 ?>