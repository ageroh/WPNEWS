<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 */
?>

	<?php
	    $pp_footer_banner = get_option('pp_footer_banner');
	
	    if(!empty($pp_footer_banner))
	    {
	?>
	    <div class="footer_ads">
	<?php
	    	echo stripslashes($pp_footer_banner);
	?>
	    </div>
	<?php
	    }
	?>

    <!-- Begin footer -->
    <div class="footer_wrapper">
    <?php
    	$pp_footer_display_sidebar = get_option('pp_footer_display_sidebar');
	
	    if(!empty($pp_footer_display_sidebar))
	    {
	?>
	    <div id="footer">
	    	<ul class="sidebar_widget">
	    		<?php dynamic_sidebar('Footer Sidebar'); ?>
	    	</ul>
	    	<br class="clear"/>
	    </div>
	<?php
		}
	?>
    
    <div id="copyright">
    	<div class="standard_wrapper wide">
    		<div id="copyright_left">
    	    <?php
    	    	/**
    	    	 * Get footer text
    	    	 */
    
    	    	$pp_footer_text = get_option('pp_footer_text');
    
    	    	if(empty($pp_footer_text))
    	    	{
    	    		$pp_footer_text = 'You can change this text using Theme Setting > Footer';
    	    	}
    	    	
    	    	echo stripslashes(html_entity_decode($pp_footer_text));
    	    ?>
    		</div>
    		<a id="toTop"><?php _e( 'Back to top', THEMEDOMAIN ); ?><i class="fa fa-angle-up"></i></a>
    		<?php 	
		    	if ( has_nav_menu( 'footer-menu' ) ) 
		    	{
		    	    //Get page nav
		    	    wp_nav_menu( 
		    	        	array( 
		    	        		'menu_id'			=> 'footer_menu',
		    	        		'menu_class'		=> 'footer_nav',
		    	        		'theme_location' 	=> 'footer-menu',
		    	        	) 
		    	    ); 
		    	}
		    ?>
    	</div>
    </div>
    
    </div>
    <!-- End footer -->

</div>
<!-- End template wrapper -->

<?php
		/**
    	*	Setup Google Analyric Code
    	**/
    	get_template_part ("google-analytic");
?>

<?php
	/**
    *	Setup code before </body>
    **/
	$pp_before_body_code = get_option('pp_before_body_code');
	
	if(!empty($pp_before_body_code))
	{
		echo stripslashes($pp_before_body_code);
	}
?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
