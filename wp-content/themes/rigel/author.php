<?php
/**
 * The main template file for display author posts page.
 *
 * @package WordPress
*/

get_header(); 

global $wp_query;
$curauth = $wp_query->get_queried_object();
?>
<br class="clear"/>
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
	    	<div class="sidebar_content">
	    		<div id="page_caption">
					<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
					<h1><?php the_author_meta('first_name', $curauth->data->ID); ?> <?php the_author_meta('last_name', $curauth->data->ID); ?></h1>
				</div>
	    		<div class="post_wrapper author">
	    			<div class="author_wrapper_inner">
	    				<div id="about_the_author">
	    					<div class="gravatar"><?php echo get_avatar( $curauth->data->user_email, '80' ); ?></div>
	    					<div class="description">
	    						<?php the_author_meta('description', $curauth->data->ID); ?>
	    						<div class="website">
	    							<i class="fa fa-link"></i>
		    						<a href="<?php the_author_meta('user_url', $curauth->data->ID); ?>" target="_blank"><?php the_author_meta('user_url', $curauth->data->ID); ?></a>
		    					</div>
	    					</div>
	    				</div><br class="clear"/>
	    			</div>
	    		</div>
	    		<br class="clear"/>
		    	<?php
		    		$pp_author_layout = get_option('pp_author_layout');
		    	
		    		//Get 1 column blog style layout
		    		if(file_exists(get_template_directory() . "/templates/template-blog-".$pp_author_layout.".php"))
		    		{
			    		get_template_part ("templates/template", "blog-".$pp_author_layout);
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
	    					<?php dynamic_sidebar('Author Page Sidebar'); ?>
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
<?php get_footer(); ?>