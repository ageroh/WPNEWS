<?php
/**
 * The main template file for display error page.
 *
 * @package WordPress
*/

get_header(); 

/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}
?>
<br class="clear"/>
<!-- Begin content -->
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content">
    			<div id="page_caption">
					<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
					<h1><?php the_title(); ?></h1>
				</div>
    			<?php echo do_shortcode('[pp_gallery gallery_id="'.get_the_ID().'" width="150" height="150"]'); ?>
	    	</div>
	    	<div class="sidebar_wrapper">
	    		<div class="sidebar">
	    			<div class="content">
	    				<ul class="sidebar_widget">
	    					<?php dynamic_sidebar('Gallery Sidebar'); ?>
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