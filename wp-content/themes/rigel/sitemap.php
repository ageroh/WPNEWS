<?php
/**
 * Template Name: Sitemap
 * The main template file for display page.
 *
 * @package WordPress
*/


/**
*	Get Current page object
**/
$page = get_page($post->ID);


/**
*	Get current page id
**/
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

get_header();

//Get page slider setting
$page_slider = get_post_meta($current_page_id, 'page_slider', true);
if(!empty($page_slider))
{
	//Get page slider style
	$page_slider_style = get_post_meta($current_page_id, 'page_slider_style', true);
	
	if(!empty($page_slider_style))
	{
		get_template_part("/templates/template-".$page_slider_style);
	}
	else
	{
		get_template_part("/templates/template-slider");
	}
}
else
{
	echo '<br class="clear"/>';
}
?>
<!-- Begin content -->
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
	    	<div class="sidebar_content">
	    		<?php
				//Get page header display setting
				$page_hide_header = get_post_meta($current_page_id, 'page_hide_header', true);
				
				if(empty($page_hide_header))
				{
				?>
				
				<div id="page_caption">
					<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
					<h1><?php the_title(); ?></h1>
				</div>
				<?php
				}
				?>
	    		
	    		<div class="one_half">
	    			<h3><?php _e( 'Pages', THEMEDOMAIN ); ?></h3>  
				    <ul><?php wp_list_pages("title_li=" ); ?></ul>
	    		</div> 
	    		
	    		<div class="one_half last"> 
					<h3><?php _e( 'Categories', THEMEDOMAIN ); ?></h3>  
				    <ul><?php wp_list_categories('sort_column=name&show_count=1&hierarchical=0&title_li='); ?></ul> 
	    		</div> 
	    		<br class="clear"/>
	    		
	    		<div class="one_half">
					<h3><?php _e( 'Recent Posts', THEMEDOMAIN ); ?></h3>  
				    <ul>
				    	<?php $archive_query = new WP_Query('showposts=1000&cat=-8');  
				            while ($archive_query->have_posts()) : $archive_query->the_post(); ?>  
				                <li>  
				                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>  
				                 (<?php comments_number('0', '1', '%'); ?>)  
				                </li>  
				            <?php endwhile; ?>  
				    </ul>
	    		</div>
				   
				<div class="one_half last">
					<h3><?php _e( 'Archives', THEMEDOMAIN ); ?></h3>  
				    <ul>  
				        <?php wp_get_archives('type=monthly&show_post_count=true'); ?>  
				    </ul> 
				</div>
	    	</div>
	    	<div class="sidebar_wrapper">
	    		<div class="sidebar">
	    			<div class="content">
	    				<ul class="sidebar_widget">
	    					<?php dynamic_sidebar($page_sidebar); ?>
	    				</ul>
	    			</div>
	    		</div>
	    	</div>
	    	<br class="clear"/>
    	</div>
    	<br class="clear"/>
    	<!-- End main content -->
    </div>
    <br class="clear"/>
</div>
<!-- End content -->
<?php get_footer(); ?>