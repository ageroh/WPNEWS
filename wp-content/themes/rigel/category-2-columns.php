<?php
/**
 * Template Name: Category 2 Columns
 * The main template file for display category page.
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
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

//Get page sidebar
$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

//Get page category ID
$page_cat = get_post_meta($current_page_id, 'page_cat', true);

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
			    <?php
			        //Get 2 columns blog style layout
				    get_template_part ("templates/template", "blog-2");
				    get_template_part ("templates/template", "pagination");
			    ?>
		    </div>
		    	<div class="sidebar_wrapper">
		    		<div class="sidebar">
		    			<div class="content">
		    				<ul class="sidebar_widget">
		    					<?php dynamic_sidebar($page_sidebar); ?>
		    				</ul>
		    			</div>
		    		</div>
		    		<br class="clear"/>
		    	</div>
			</div>
			<!-- End main content -->
		</div>
	</div>
    </div>
</div>
<?php get_footer(); ?>