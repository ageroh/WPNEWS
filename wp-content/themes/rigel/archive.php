<?php
/**
 * The main template file for display archive page.
 *
 * @package WordPress
*/

get_header(); 

$post_type = get_post_type();
?>
<br class="clear"/>
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content">
    			<div id="page_caption">
					<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
					<h1>
					<?php if ( is_day() ) : ?>
					    <?php printf( __( '%s', THEMEDOMAIN ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?>
					    <?php printf( __( '%s', THEMEDOMAIN ), get_the_date('F Y') ); ?>
					<?php elseif ( is_year() ) : ?>
					    <?php printf( __( '%s', THEMEDOMAIN ), get_the_date('Y') ); ?>	
					<?php elseif ( $post_type == 'reviews' ) : ?>
					    <?php printf( __( '%s', THEMEDOMAIN ), '' . single_cat_title( '', false ) . '' ); ?>	
					<?php else : ?>
					    <?php _e( 'Blog Archives', THEMEDOMAIN ); ?>
					<?php endif; ?>
					</h1>
				</div>
    		
		    	<?php
		    		$pp_archive_layout = get_option('pp_archive_layout');
		    	
		    		//Get 1 column blog style layout
		    		if(file_exists(get_template_directory() . "/templates/template-blog-".$pp_archive_layout.".php"))
		    		{
			    		get_template_part ("templates/template", "blog-".$pp_archive_layout);
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
		    					<?php dynamic_sidebar('Archive Sidebar'); ?>
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