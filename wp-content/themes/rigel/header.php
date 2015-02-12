<!DOCTYPE html>
<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */

if(session_id() == '') 
{
	//session_start();
}

if ( ! isset( $content_width ) ) $content_width = 960;
?>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<title><?php wp_title('&lsaquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
	/**
	*	Get favicon URL
	**/
	$pp_favicon = get_option('pp_favicon');
	
	if(!empty($pp_favicon))
	{
?>
		<link rel="shortcut icon" href="<?php echo $pp_favicon; ?>" />
<?php
	}
?>

<?php
if(is_single())
{
	$fb_thumb = wp_get_attachment_image_src($post->ID, 'blog_square', true);
	if(isset($fb_thumb[0]) && !empty($fb_thumb[0]))
	{
		$image_desc = get_the_excerpt();
	?>
	<meta property="og:image" content="<?php echo $fb_thumb[0]; ?>"/>
	<meta property="og:title" content="<?php the_title(); ?>"/>
	<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>"/>
	<meta property="og:description" content="<?php echo strip_tags($image_desc); ?>"/>
	<?php
	}
}
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<?php
	/**
    *	Setup code before </head>
    **/
	$pp_before_head_code = get_option('pp_before_head_code');
	
	if(!empty($pp_before_head_code))
	{
		echo stripslashes($pp_before_head_code);
	}
?>

<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?> 

</head>

<body <?php body_class(); ?>>
	<?php
		$pp_ajax_search = get_option('pp_ajax_search');
	?>
	<input type="hidden" id="pp_ajax_search" name="pp_ajax_search" value="<?php echo $pp_ajax_search; ?>"/>
	<input type="hidden" id="pp_homepage_url" name="pp_homepage_url" value="<?php echo site_url(); ?>"/>
	<?php
		//Check footer sidebar columns
		$pp_slider_auto = get_option('pp_slider_auto');
	?>
	<input type="hidden" id="pp_slider_auto" name="pp_slider_auto" value="<?php echo $pp_slider_auto; ?>"/>
	<?php
		//Check footer sidebar columns
		$pp_slider_timer = get_option('pp_slider_timer');
	?>
	<input type="hidden" id="pp_slider_timer" name="pp_slider_timer" value="<?php echo $pp_slider_timer; ?>"/>
	<?php
		//Get animation type
		$pp_animation_type = get_option('pp_animation_type');
		if(empty($pp_animation_type))
		{
			$pp_animation_type = 'slideUp';
		}
	?>
	<input type="hidden" id="pp_animation_type" name="pp_animation_type" value="<?php echo $pp_animation_type; ?>"/>
	
	<!-- Begin mobile menu -->
	<div class="mobile_menu_wrapper">
		<a id="close_mobile_menu" href="#top"><i class="fa fa-times-circle"></i></a>
	    <?php 	
	    	if ( has_nav_menu( 'second-menu' ) ) 
	    	{
	    	    //Get page nav
	    	    wp_nav_menu( 
	    	        	array( 
	    	        		'menu_id'			=> 'mobile_second_menu',
	    	        		'menu_class'		=> 'mobile_main_nav',
	    	        		'theme_location' 	=> 'second-menu',
	    	        	) 
	    	    ); 
	    	}
	    ?>
	</div>
	<!-- End mobile menu -->
	
	<!-- Begin template wrapper -->
	<div id="wrapper">
		<div class="mobile_nav_icon_bg">
			<div id="mobile_nav_icon"></div>
		</div>
		
		<?php
			//If enable top bar
			$pp_enable_top_bar = get_option('pp_enable_top_bar');

			if(!empty($pp_enable_top_bar))
			{
		?>
			
		
		<div id="top_bar">
			<div id="breaking_wrapper">
				<?php
					//Check if enable breaking news section
					$pp_enable_breaking = get_option('pp_enable_breaking');
					
					if(!empty($pp_enable_breaking))
					{
				?>
			    <h2 class="breaking"><?php _e( 'Must Read', THEMEDOMAIN ); ?></h2>
			    <?php
				$pp_enable_breaking = get_option('pp_enable_breaking');
				$pp_enable_breaking = TRUE;
				
				if(!empty($pp_enable_breaking))
				{
				    // Get featured posts
				    $pp_breaking_cat = get_option('pp_breaking_cat');
				    $pp_breaking_items = get_option('pp_breaking_items');
				    if(empty($pp_breaking_items))
				    {
				    	$pp_breaking_items = 5;
				    }
				    $breaking_posts_arr = get_posts('numberposts='.$pp_breaking_items.'&order=DESC&orderby=date&category='.$pp_breaking_cat);
				    
				    if(!empty($breaking_posts_arr) && !empty($breaking_posts_arr))
				    {
				?>
			    <div id="breaking_new">
			    	<ul>
			    	<?php
			        	foreach($breaking_posts_arr as $key => $breaking_post)
			            {
			            	$hyperlink_url = get_permalink($breaking_post->ID);
			        ?>
			    		<li><a href="<?php echo $hyperlink_url;?>"><?php echo $breaking_post->post_title; ?></a></li>
			    	<?php
			    		}
			    	?>
			    	</ul>
			    </div>
			    <?php
				    }
				}
				
				} //If enable breaking news
				?>
				
				<?php
					//if display search
					$pp_top_bar_search_display = get_option('pp_top_bar_search_display');
					
					if(!empty($pp_top_bar_search_display))
					{
				?>
				<form role="search" method="get" name="searchform" id="searchform" action="<?php echo site_url(); ?>/">
				    <div>
				    	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" autocomplete="off" title="<?php _e( 'Search...', THEMEDOMAIN ); ?>"/>
				    	<button type="submit">
				        	<i class="fa fa-search"></i>
				        </button>
				    </div>
				    <div id="autocomplete"></div>
				</form>
				<?php
					}
				?>
				
				<?php
					//if display social icons
					$pp_top_bar_social_display = get_option('pp_top_bar_social_display');
					
					if(!empty($pp_top_bar_social_display))
					{
				?>
				<div class="social_wrapper">
				    <ul>
				    	<?php
				    		$pp_twitter_username = get_option('pp_twitter_username');
				    		
				    		if(!empty($pp_twitter_username))
				    		{
				    	?>
				    	<li class="twitter"><a title="Twitter" href="http://twitter.com/<?php echo $pp_twitter_username; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_facebook_username = get_option('pp_facebook_username');
				    		
				    		if(!empty($pp_facebook_username))
				    		{
				    	?>
				    	<li class="facebook"><a title="Facebook" href="http://facebook.com/<?php echo $pp_facebook_username; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_flickr_username = get_option('pp_flickr_username');
				    		
				    		if(!empty($pp_flickr_username))
				    		{
				    	?>
				    	<li class="flickr"><a title="Flickr" href="http://flickr.com/people/<?php echo $pp_flickr_username; ?>" target="_blank"><i class="fa fa-flickr"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_youtube_username = get_option('pp_youtube_username');
				    		
				    		if(!empty($pp_youtube_username))
				    		{
				    	?>
				    	<li class="youtube"><a title="Youtube" href="http://youtube.com/channel/<?php echo $pp_youtube_username; ?>" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_vimeo_username = get_option('pp_vimeo_username');
				    		
				    		if(!empty($pp_vimeo_username))
				    		{
				    	?>
				    	<li class="vimeo"><a title="Vimeo" href="http://vimeo.com/<?php echo $pp_vimeo_username; ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_tumblr_username = get_option('pp_tumblr_username');
				    		
				    		if(!empty($pp_tumblr_username))
				    		{
				    	?>
				    	<li class="tumblr"><a title="Tumblr" href="http://<?php echo $pp_tumblr_username; ?>.tumblr.com" target="_blank"><i class="fa fa-tumblr"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_google_username = get_option('pp_google_username');
				    		
				    		if(!empty($pp_google_username))
				    		{
				    	?>
				    	<li class="google"><a title="Google+" href="<?php echo $pp_google_username; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_dribbble_username = get_option('pp_dribbble_username');
				    		
				    		if(!empty($pp_dribbble_username))
				    		{
				    	?>
				    	<li class="dribbble"><a title="Dribbble" href="http://dribbble.com/<?php echo $pp_dribbble_username; ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_linkedin_username = get_option('pp_linkedin_username');
				    		
				    		if(!empty($pp_linkedin_username))
				    		{
				    	?>
				    	<li class="linkedin"><a title="Linkedin" href="<?php echo $pp_linkedin_username; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_pinterest_username = get_option('pp_pinterest_username');
				    		
				    		if(!empty($pp_pinterest_username))
				    		{
				    	?>
				    	<li class="pinterest"><a title="Pinterest" href="http://pinterest.com/<?php echo $pp_pinterest_username; ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_instagram_username = get_option('pp_instagram_username');
				    		
				    		if(!empty($pp_instagram_username))
				    		{
				    	?>
				    	<li class="instagram"><a title="Instagram" href="http://instagram.com/<?php echo $pp_instagram_username; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
				    	<?php
				    		}
				    	?>
				    </ul>
				</div>
				<?php
				} //if enable social icons
				?>
			</div>
		</div>
		<?php
		} //if enable top bar
		?>
		
		<div id="header_bg">
			
			<div id="boxed_wrapper">
				<?php
					if(THEMEDEMO)
					{
						$rigelstyle = 1;
						//Get style value from query
						if(isset($_GET['rigelstyle']) && is_numeric($_GET['rigelstyle']) &&  1 <= $_GET['rigelstyle'] && $_GET['rigelstyle'] <= 15)
						{
						    $rigelstyle = $_GET['rigelstyle'];
						}
						
						if(file_exists(get_template_directory().'/cache/styles/style'.$rigelstyle.'.json'))
						{
						    $import_options_json = file_get_contents(get_template_directory().'/cache/styles/style'.$rigelstyle.'.json');
						    $import_options_arr = json_decode($import_options_json, true);
						}
						else
						{
						    $import_options_json = file_get_contents(get_template_directory().'/cache/styles/style1.json');
						    $import_options_arr = json_decode($import_options_json, true);
						}
					}
					
					if(THEMEDEMO && isset($import_options_arr['pp_top_banner']))
					{
						$pp_top_banner = $import_options_arr['pp_top_banner'];
					}
					else
					{
				    	$pp_top_banner = get_option('pp_top_banner');
				    }
				
				    if(!empty($pp_top_banner))
				    {
				    	echo '<div class="header_ads">'.stripslashes($pp_top_banner).'</div>';
				    }
				?>
				<div class="logo">
					<!-- Begin logo -->	
					<?php
						//get custom logo
						$pp_logo = get_option('pp_logo');
						
						if(THEMEDEMO && isset($import_options_arr['pp_retina_logo']))
						{	
							$pp_retina_logo = $import_options_arr['pp_retina_logo'];
						}
						else
						{
							$pp_retina_logo = get_option('pp_retina_logo');
						}
						$pp_retina_logo_width = 0;
						$pp_retina_logo_height = 0;
									
						if(empty($pp_logo) && empty($pp_retina_logo))
						{
							$pp_retina_logo = get_template_directory_uri().'/images/logo@2x.png';
							$pp_retina_logo_width = 247;
							$pp_retina_logo_height = 80;
						}
						
						if(!empty($pp_retina_logo))
						{
							if(empty($pp_retina_logo_width) && empty($pp_retina_logo_height))
							{
								//Get image width and height
								$pp_retina_logo_id = pp_get_image_id($pp_retina_logo);
								$image_logo = wp_get_attachment_image_src($pp_retina_logo_id, 'original');
								$pp_retina_logo = $image_logo[0];
								$pp_retina_logo_width = $image_logo[1]/2;
								$pp_retina_logo_height = $image_logo[2]/2;
							}
					?>		
						<a id="custom_logo" class="logo_wrapper" href="<?php echo home_url(); ?>">
							<img src="<?php echo $pp_retina_logo; ?>" alt="" width="<?php echo $pp_retina_logo_width; ?>" height="<?php echo $pp_retina_logo_height; ?>"/>
						</a>
					<?php
						}
						else //if not retina logo
						{
					?>
						<a id="custom_logo" class="logo_wrapper" href="<?php echo home_url(); ?>">
							<img src="<?php echo $pp_logo?>" alt=""/>
						</a>
					<?php
						}
					?>
					<!-- End logo -->
				</div>
				
			</div>
		
		</div>
		
		<?php 	
		if ( has_nav_menu( 'second-menu' ) ) 
		{
		    //Get page nav
		    wp_nav_menu( 
		        	array( 
		        		'menu_id'			=> 'second_menu',
		        		'menu_class'		=> 'second_nav',
		        		'theme_location' 	=> 'second-menu',
		        		'container_class' => 'menu-secondary-menu-container',
		        		'walker' => new tg_walker(),
		        	) 
		    ); 
		}
		else
		   {
		    		echo '<div class="secondmenu notice">Please setup "Secondary Menu" using Wordpress Dashboard > Appearance > Menus</div>';
		   }
		?>
		
		<?php
			//Check if theme demo then enable layout switcher
			if(THEMEDEMO)
		    {
		?>
		<form action="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php" method="get" id="form_option" name="form_option">
		    <div id="option_wrapper">
		    <div class="inner">
		    	<h6>Style Switcher</h6>
		    	
		    	Choose Theme Layout<br/>
		    	<?php
		    		if(isset($_GET['rigellayout']) && !empty($_GET['rigellayout']))
					{
						$pp_layout = $_GET['rigellayout'];
					}
					elseif(isset($import_options_arr['pp_layout']))
					{
						$pp_layout = $import_options_arr['pp_layout'];
					}
					else
					{
						$pp_layout = get_option('pp_layout');
					}
		    	?>
		    	<select name="pp_layout" id="pp_layout" style="margin-top:5px">
		    	    <option value="wide" <?php if($pp_layout == 'wide') { ?>selected=selected<?php } ?>>Wide</option>
		    	    <option value="boxed" <?php if($pp_layout == 'boxed') { ?>selected=selected<?php } ?>>Boxed</option>
		    	</select>
		    	
		    	<br/><br/>
		    	Sample Skin Colors<br/>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=ff9900" title="Orange" style="background:#ff9900"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=3498db" title="Blue" style="background:#3498db"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=000000" title="Black" style="background:#000000"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=76bb2c" title="Green" style="background:#76bb2c"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=e74d3c" title="Red" style="background:#e74d3c"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=ed6280" title="Pink" style="background:#ed6280"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=1abc9c" title="Ocean" style="background:#1abc9c"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=34495e" title="Asphalt" style="background:#34495e"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=9c59b6" title="Purple" style="background:#9c59b6"></a>
		    	<a class="skin_box" href="<?php echo get_stylesheet_directory_uri(); ?>/switcher.php?pp_skin=7dadff" title="Purple Blue" style="background:#7dadff"></a>
		    	
		    	<br class="clear"/><br/>
		    	<a class="reset" href="http://themes.themegoods2.com/rigel/#">Select Layout Styles</a>
		    </div>
		    </div>
		    <div id="option_btn">
		    	<i class="fa fa-chevron-right"></i>
		    </div>
		</form>
		<?php
		    }
		?>