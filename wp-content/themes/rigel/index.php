<?php
/**
 * The main template file.
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
    			<?php
	    			//Get default 1 column recent posts
	    			get_template_part ("templates/template", "blog-1");
	    			get_template_part ("templates/template", "pagination");
    			?>
    		</div>
    		<div class="sidebar_wrapper">
    			<div class="sidebar">
    		    	<div class="content">
    		    		<ul class="sidebar_widget">
    		    			<?php dynamic_sidebar('Home Sidebar'); ?>
    		    		</ul>
    		    	</div>
    		    </div>
    		</div>
    		<br class="clear"/>
    	</div>
    	<!-- End main content -->
    </div>
</div>
<?php get_footer(); ?>