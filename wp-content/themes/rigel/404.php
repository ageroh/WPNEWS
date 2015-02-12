<?php
/**
 * The main template file for display error page.
 *
 * @package WordPress
*/

get_header(); 

?>
<br class="clear"/>
<!-- Begin content -->
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper fullwidth">
    		<div class="page_fullwidth">
    			<div style="text-align:center;">
    				<h1 class="error"><?php _e( 'Sorry... Page Not Found', THEMEDOMAIN ); ?></h1>
    				<div style="color:#999;margin-top:-15px;font-size:16px;"><?php _e( 'We\'re sorry, but the content you are looking for doesn\'t exist. Perhaps searching could help', THEMEDOMAIN ); ?></div><br/>
    				<div class="search_form_wrapper">
		    			<form role="search" method="get" action="<?php echo home_url(); ?>/">
							<div>
								<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" autocomplete="off" title="<?php _e( 'Search...', THEMEDOMAIN ); ?>" style="width:521px;"/>
								<input type="submit" value="<?php echo _e( 'Search', THEMEDOMAIN ); ?>"/>
							</div>
						</form>
	    			</div>
    			</div>
    			<br class="clear"/><br/>
    			
    			<?php echo do_shortcode('[ppb_columns_blog title="'.__( 'Latest Posts', THEMEDOMAIN ).'" subtitle="'.__( 'Our latest news update', THEMEDOMAIN ).'" items="6" template="page_fullwidth.php"]'); ?>
    		</div>
    	</div>
    	<!-- End main content -->
    	<br class="clear"/>
    </div>
</div>
<!-- End content -->
<?php get_footer(); ?>