<?php
/**
 * The main template file for display search result page.
 *
 * @package WordPress
*/

get_header();
?>
<br class="clear"/>
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content">
    			<div id="page_caption">
					<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
					<h1><?php printf( __( '%s', THEMEDOMAIN ), '' . get_search_query() . '' ); ?></h1>
				</div>
				<div class="search_form_wrapper">
	    			<form role="search" method="get" action="<?php echo home_url(); ?>/">
						<div>
							<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" autocomplete="off" title="<?php _e( 'Search...', THEMEDOMAIN ); ?>" style="width:521px;"/>
							<input type="submit" value="<?php echo _e( 'Search', THEMEDOMAIN ); ?>"/>
						</div>
					</form>
    			</div>
    			<br class="clear"/>
		    	<?php
		    		$pp_search_layout = get_option('pp_search_layout');
		    	
		    		//Get 1 column blog style layout
		    		if(file_exists(get_template_directory() . "/templates/template-blog-".$pp_search_layout.".php"))
		    		{
			    		get_template_part ("templates/template", "blog-".$pp_search_layout);
		    		}
		    		else
		    		{
						get_template_part ("templates/template", "blog-2");
					}
					get_template_part ("templates/template", "pagination");
		    	?>
		    	</div>
		    	<div class="sidebar_wrapper">
		    		<div class="sidebar">
		    			<div class="content">
		    				<ul class="sidebar_widget">
		    					<?php dynamic_sidebar('Search Sidebar'); ?>
		    				</ul>
		    			</div>
		    		</div>
		    		<br class="clear"/>
		    	</div>
				<br class="clear"/>
			</div>
			<!-- End main content -->
		</div>
	</div>
    </div>
</div>
<?php get_footer(); ?>