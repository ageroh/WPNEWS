<?php
/**
 * Template Name: Contact
 * The main template file for display contact page.
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

//Get page sidebar
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
    			<div id="page_caption">
					<div class="sub_page_caption"><?php echo dimox_breadcrumbs(); ?></div>
					<h1><?php the_title(); ?></h1>
				</div>
	    		<?php 
	    		    if ( have_posts() ) while ( have_posts() ) : the_post(); 
	    		    	the_content();
				    endwhile; 
				    
				    wp_enqueue_script("script-contact-form", get_template_directory_uri()."/templates/script-contact-form.php", false, THEMEVERSION, true);
				?>
	    		<form id="contact_form" method="post" action="/wp-admin/admin-ajax.php">
	    		    <input type="hidden" id="action" name="action" value="pp_contact_mailer"/>
	    		    
	    		    <input id="your_name" name="your_name" type="text" class="required_field" placeholder="<?php echo _e( 'Name', THEMEDOMAIN ); ?>*" style="width:97%"/><br/><br/>
	    		   <input id="email" name="email" type="text" class="required_field email" placeholder="<?php echo _e( 'Email', THEMEDOMAIN ); ?>*" style="width:97%"/><br/><br/>
	    		    <input id="subject" name="subject" type="text" placeholder="<?php echo _e( 'Subject', THEMEDOMAIN ); ?>" style="width:97%"/>
	    		    <br/><br/>
	    		    <textarea id="message" name="message" placeholder="<?php echo _e( 'Message', THEMEDOMAIN ); ?>" rows="7" cols="8" style="width:97%"></textarea>
	    		    <br class="clear"/><br/>
	    		    <input type="submit" value="<?php echo _e( 'Send Message', THEMEDOMAIN ); ?>"/><br/><br/>
	    		</form>
	    		<div id="reponse_msg"></div>
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
    	</div>
    	<!-- End main content -->		
    	<br class="clear"/>
    </div>
</div>
<!-- End content -->
				

<?php get_footer(); ?>