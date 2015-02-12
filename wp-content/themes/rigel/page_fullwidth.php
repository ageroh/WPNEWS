<?php
/**
 * Template Name: Page Fullwidth
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

<?php
	//Check if use page builder
	$ppb_form_data_order = '';
	$ppb_form_item_arr = array();
	$ppb_enable = get_post_meta($current_page_id, 'ppb_enable', true);
?>
<!-- Begin content -->
<?php
if(empty($ppb_enable))
{
?>
<div id="content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper fullwidth">
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
    			if ( empty($ppb_enable) && have_posts() ) {
    		    while ( have_posts() ) : the_post(); ?>		
    	
    		    <?php the_content(); break;  ?>

    		<?php endwhile; 
	    	    }
    		?>
    	</div>
    	<!-- End main content -->
    	<br class="clear"/><br/>
    </div> 
</div>
<?php
}
else
{
	if(empty($page_slider))
	{
		echo '<br class="clear"/>';
	}
	pp_apply_builder($current_page_id);
	echo '<br class="clear"/>';
}
?>
<!-- End content -->
<?php get_footer(); ?>