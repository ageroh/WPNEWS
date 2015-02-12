<?php
/**
 * The main template file for display page.
 *
 * @package WordPress
*/

get_header(); 
?>

<!-- Begin content -->
<div id="content_wrapper">
    <div class="inner ">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content">
				<div id="page_caption">
					<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
					<h1><?php _e( 'Shop', THEMEDOMAIN ); ?></h1>
				</div>
				
				<?php woocommerce_content();  ?>
    		</div>
    		
    		<div class="sidebar_wrapper">
	    		<div class="sidebar">
	    			<div class="content">
	    				<ul class="sidebar_widget">
	    					<?php dynamic_sidebar('Shop Sidebar'); ?>
	    				</ul>
	    			</div>
	    		</div>
	    	</div>
	    	<br class="clear"/>
    	</div>
    	<!-- End main content -->
    </div>
</div>
<!-- End content -->
<?php get_footer(); ?>