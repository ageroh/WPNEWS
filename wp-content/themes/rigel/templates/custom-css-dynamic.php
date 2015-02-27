<?php header("Content-type: text/css; charset: UTF-8"); ?> 
<?php 
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );

$pp_advance_combine_css = get_option('pp_advance_combine_css');

if(!empty($pp_advance_combine_css))
{
	//Function for compressing the CSS as tightly as possible
	function compress($buffer) {
	    //Remove CSS comments
	    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	    //Remove tabs, spaces, newlines, etc.
	    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	    return $buffer;
	}

	ob_start("compress");
}

	//Hack animation CSS for Safari
	$current_browser = getBrowser();
	
	//If enable fade in animation
	$pp_animation_fade = get_option('pp_animation_fade');
	
	if($pp_animation_fade && isset($current_browser['name']) && $current_browser['name'] != 'Internet Explorer' && $current_browser['name'] != 'Safari')
	{
?>

<?php
	for($i=1;$i<=20;$i++)
	{
?>
.animated<?php echo $i; ?>
{
	-webkit-animation-delay: <?php echo $i/5; ?>s;
	-moz-animation-delay: <?php echo $i/5; ?>s;
	animation-delay: <?php echo $i/5; ?>s;
}
<?php
	}
}		
?>

.entry_post {
	visibility: hidden;
	opacity: 0;
}
<?php
	if(isset($current_browser['name']) && $current_browser['name'] == 'Internet Explorer' && intval($current_browser['version']) < 10)
	{
?>
	.fade-in, .element, .entry_post, .slideUp { opacity: 1 !important; visibility: visible !important; }
	body { overflow-x: auto; }
<?php
	}
?>

<?php
	//If disble animation on mobile
	$pp_disable_mobile_animation = get_option('pp_disable_mobile_animation');
	
	if(!empty($pp_disable_mobile_animation))
	{
?>
@media only screen and (max-width: 768px) {
	.fade-in, .element, .entry_post, .slideUp { opacity: 1 !important; visibility: visible !important; }
}
<?php
	}
?>

<?php
	if(isset($current_browser['name']) && $current_browser['name'] == 'Internet Explorer')
	{
?>
.mobile_menu_wrapper
{
    display: none;
}
body.js_nav .mobile_menu_wrapper 
{
    display: block;
}
body.js_nav #wrapper, body.js_nav .footer_wrapper
{
	margin-left: 70%;
}
<?php
	}
?>

<?php
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
?>

<?php
	$pp_fixed_menu = $import_options_arr['pp_fixed_menu'];
	
	if(!empty($pp_fixed_menu))
	{
		$pp_menu_width = $import_options_arr['pp_menu_width'];
	
		if($pp_menu_width == 'fixed_width')
		{
			$pp_menu_bg = $import_options_arr['pp_menu_bg'];
?>
.menu-secondary-menu-container.fixed
{
	position: fixed;
    top: 0px;
    left: 0;
    z-index: 10000;
    margin: 0;
    width: 100%;
    background: transparent;
}
.second_nav
{
	width: 960px;
	background: <?php echo $pp_menu_bg; ?>
}
<?php
		}
		else
		{
?>
.menu-secondary-menu-container.fixed
{
	position: fixed;
    top: 0px;
    left: 0;
    z-index: 10000;
    margin: 0;
    width: 100%;
}
<?php
		}
	}
?>

<?php
	if(isset($current_browser['name']) && $current_browser['name'] == 'Internet Explorer')
	{
?>
#second_menu.fixed { border-bottom: 1px solid #ccc; }
.flex-direction-nav .flex-prev  { left: 0; }
.flex-direction-nav .flex-next { right: 0; }
<?php
	}
?>

<?php
/**
*	Begin Styling and Typography Setting Section
*/
?>

<?php
	$pp_top_bar_bg = $import_options_arr['pp_top_bar_bg'];
	
	if(!empty($pp_top_bar_bg))
	{
?>
#top_bar, #breaking_wrapper #searchform { background:<?php echo $pp_top_bar_bg; ?>; }
#breaking_wrapper #searchform { border-color:<?php echo $pp_top_bar_bg; ?>; }
<?php
	}
?>

<?php
	$pp_top_bar_border = $import_options_arr['pp_top_bar_border'];
	
	if(!empty($pp_top_bar_border))
	{
?>
#top_bar { border-color:<?php echo $pp_top_bar_border; ?>; }
<?php
	}
?>

<?php
	$pp_top_bar_social_color = $import_options_arr['pp_top_bar_social_color'];
	
	if(!empty($pp_top_bar_social_color))
	{
?>
.social_wrapper ul li a i { color:<?php echo $pp_top_bar_social_color; ?>; }
<?php
	}
?>

<?php
	$pp_top_bar_social_original = $import_options_arr['pp_top_bar_social_original'];
	
	if(!empty($pp_top_bar_social_original))
	{
?>
.social_wrapper ul li
{
	margin-right: 3px;
	margin-top: 8px;
	padding: 0;
	width: 24px;
}

.social_wrapper ul li a i
{
	color: #fff;
	line-height: 20px;
	font-size: .9em;
}

.social_wrapper ul li.instagram
{
	background: #1c5380;
}

.social_wrapper ul li.youtube
{
	background: #cc181e;
}

.social_wrapper ul li.twitter
{
	background: #33ccff;
}

.social_wrapper ul li.facebook
{
	background: #4c66a4;
}

.social_wrapper ul li.flickr
{
	background: #ff0084;
}

.social_wrapper ul li.vimeo
{
	background: #17b3e8;
}

.social_wrapper ul li.tumblr
{
	background: #6aa5cf;
}

.social_wrapper ul li.google
{
	background: #dd4b39;
}

.social_wrapper ul li.dribbble
{
	background: #ea4c89;
}

.social_wrapper ul li.linkedin
{
	background: #007bb6;
}

.social_wrapper ul li.pinterest
{
	background: #ab171e;
}
<?php
	}
?>

<?php
	$pp_top_bar_breaking_header_font_color = $import_options_arr['pp_top_bar_breaking_header_font_color'];
	
	if(!empty($pp_top_bar_breaking_header_font_color))
	{
?>
h2.breaking { color:<?php echo $pp_top_bar_breaking_header_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_top_bar_font_color = $import_options_arr['pp_top_bar_font_color'];
	
	if(!empty($pp_top_bar_font_color))
	{
?>
#breaking_new a, #searchform input.blur { color:<?php echo $pp_top_bar_font_color; ?>; }
#mobile_nav_icon { border-color:<?php echo $pp_top_bar_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_logo_bg = $import_options_arr['pp_logo_bg'];
	
	if(!empty($pp_logo_bg))
	{
?>
#header_bg { background:<?php echo $pp_logo_bg; ?>; }
<?php
	}
?>

<?php
	$pp_logo_margintop = $import_options_arr['pp_logo_margintop'];
	
	if(!empty($pp_logo_margintop))
	{
?>
.logo { margin-top:<?php echo $pp_logo_margintop; ?>px; }
<?php
	}
?>

<?php
	$pp_menu_bg = $import_options_arr['pp_menu_bg'];
	
	if(!empty($pp_menu_bg))
	{
?>
.menu-secondary-menu-container, .mobile_menu_wrapper, body.js_nav, .menu-secondary-menu-container { background:<?php echo $pp_menu_bg; ?>; }
<?php
	}
?>

<?php
	$pp_menu_font_color = $import_options_arr['pp_menu_font_color'];
	
	if(!empty($pp_menu_font_color))
	{
?>
.second_nav > li > a, .second_nav li ul.sub-menu li a:hover, .second_nav > li > a i { color:<?php echo $pp_menu_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_sub_menu_bg = $import_options_arr['pp_sub_menu_bg'];
	
	if(!empty($pp_sub_menu_bg))
	{
?>
#menu_wrapper div .nav li ul.sub-menu, .second_nav li ul.sub-menu, .second_nav li .mega_menu_wrapper .mega_menu_bg { background:<?php echo $pp_sub_menu_bg; ?>; }
<?php
	}
?>

<?php
	$pp_sub_menu_border = $import_options_arr['pp_sub_menu_border'];
	
	if(!empty($pp_sub_menu_border))
	{
?>
#menu_wrapper div .nav li ul.sub-menu, .second_nav li ul.sub-menu, .second_nav ul li ul.sub-menu li a, .second_nav li ul.sub-menu li a, #menu_wrapper div .nav li .mega_menu_wrapper ul li ul li, .second_nav li .mega_menu_wrapper ul li ul li { border-color:<?php echo $pp_sub_menu_border; ?>; }
<?php
	}
?>

<?php
	$pp_sub_menu_font_color = $import_options_arr['pp_sub_menu_font_color'];
	
	if(!empty($pp_sub_menu_font_color))
	{
?>
.second_nav ul li ul.sub-menu li a, .second_nav li ul.sub-menu li a, .second_nav li .mega_menu_wrapper ul li ul.menu li a, #menu_wrapper div .nav li .mega_menu_wrapper, .second_nav li .mega_menu_wrapper, .mega_menu_wrapper a, .mega_menu_wrapper a:hover, .mega_menu_wrapper a:active { color:<?php echo $pp_sub_menu_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_sub_menu_active_bg_color = $import_options_arr['pp_sub_menu_active_bg_color'];
	
	if(!empty($pp_sub_menu_active_bg_color))
	{
?>
.second_nav ul li ul li a:hover,  .second_nav li ul li a:hover, .second_nav ul li ul li a.hover,  .second_nav li ul li a.hover { background:<?php echo $pp_sub_menu_active_bg_color; ?>; }
<?php
	}
?>

<?php
	$pp_menu_active_style = $import_options_arr['pp_menu_active_style'];
	$pp_menu_active_bg_color = $import_options_arr['pp_menu_active_bg_color'];
	$pp_menu_active_font_color = $import_options_arr['pp_menu_active_font_color'];
	
	switch($pp_menu_active_style) 
	{
		case 'background':
		default:
?>
.second_nav ul > li a:hover, .second_nav > li a:hover, .second_nav ul > li a.hover, .second_nav > li a.hover, .second_nav ul > li a:active, .second_nav > li a:active, .second_nav > li.current-menu-item > a, .second_nav > li.current-menu-parent > a, .second_nav > li.current-menu-ancestor > a { background:<?php echo $pp_menu_active_bg_color; ?>; color:<?php echo $pp_menu_active_font_color; ?>; }
.second_nav > li > a:hover i { color:<?php echo $pp_menu_active_font_color; ?>; }
<?php
		break;
		
		case 'border':
?>
.second_nav ul > li a:hover, .second_nav > li a:hover, .second_nav ul > li a.hover, .second_nav > li a.hover, .second_nav ul > li a:active, .second_nav > li a:active, .second_nav > li.current-menu-item > a, .second_nav > li.current-menu-parent > a, .second_nav > li.current-menu-ancestor > a { background:transparent; border-bottom: 3px solid <?php echo $pp_menu_active_bg_color; ?>; color:<?php echo $pp_menu_active_font_color; ?>; }
.second_nav > li > a { border-bottom: 3px solid transparent; }
<?php
		break;
		
		case 'font':
?>
.second_nav ul > li a:hover, .second_nav > li a:hover, .second_nav ul > li a.hover, .second_nav > li a.hover, .second_nav ul > li a:active, .second_nav > li a:active, .second_nav > li.current-menu-item > a, .second_nav > li.current-menu-parent > a, .second_nav > li.current-menu-ancestor > a { background:transparent; color:<?php echo $pp_menu_active_font_color; ?>; }
.second_nav > li > a:hover i { color:<?php echo $pp_menu_active_font_color; ?>; }
<?php
		break;
	}
?>

<?php
	$pp_menu_border = $import_options_arr['pp_menu_border'];
	$pp_menu_border_color = $import_options_arr['pp_menu_border_color'];
	
	if(!empty($pp_menu_border) && !empty($pp_menu_border_color))
	{
?>
.menu-secondary-menu-container { border-bottom: <?php echo $pp_menu_border; ?>px solid <?php echo $pp_menu_border_color; ?> }
<?php
	}
?>

<?php
	$pp_mega_menu_widget_font_color = $import_options_arr['pp_mega_menu_widget_font_color'];
	
	if(!empty($pp_mega_menu_widget_font_color))
	{
?>
.second_nav li .mega_menu_wrapper ul li h2.widgettitle { color:<?php echo $pp_mega_menu_widget_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_menu_width = $import_options_arr['pp_menu_width'];
	
	if($pp_menu_width == 'fixed_width')
	{
?>
.menu-secondary-menu-container { width: 960px; margin: auto; }
<?php
	}
?>

<?php
	$pp_footer_bg = $import_options_arr['pp_footer_bg'];
	
	if(!empty($pp_footer_bg))
	{
?>
.footer_wrapper { background:<?php echo $pp_footer_bg; ?>; }
<?php
	}
?>

<?php
	$pp_footer_header_color = $import_options_arr['pp_footer_header_color'];
	
	if(!empty($pp_footer_header_color))
	{
?>
#footer .sidebar_widget li h2.widgettitle { color:<?php echo $pp_footer_header_color; ?>; }
<?php
	}
?>

<?php
	$pp_footer_font = $import_options_arr['pp_footer_font'];
	
	if(!empty($pp_footer_font))
	{
?>
#footer, #copyright, #footer i { color:<?php echo $pp_footer_font; ?>; }
<?php
	}
?>

<?php
	$pp_footer_link_color = $import_options_arr['pp_footer_link_color'];
	
	if(!empty($pp_footer_link_color))
	{
?>
#footer a { color:<?php echo $pp_footer_link_color; ?>; }
<?php
	}
?>

<?php
	$pp_footer_hover_link_color = $import_options_arr['pp_footer_hover_link_color'];
	
	if(!empty($pp_footer_hover_link_color))
	{
?>
#footer a:hover, #footer a:active { color:<?php echo $pp_footer_hover_link_color; ?>; }
<?php
	}
?>

<?php
	$pp_footer_element_border = $import_options_arr['pp_footer_element_border'];
	
	if(!empty($pp_footer_element_border))
	{
?>
#footer .post_attribute, #footer_menu li, #footer input[type=text], #footer input[type=password], #footer textarea, #footer .sidebar_widget li form#searchform input[type=text], #footer .sidebar_widget li ul li, #footer .widget_tag_cloud div a { border-color:<?php echo $pp_footer_element_border; ?>; }
<?php
	}
?>

<?php
	$pp_copyright_bg = $import_options_arr['pp_copyright_bg'];
	
	if(!empty($pp_copyright_bg))
	{
?>
#copyright { background:<?php echo $pp_copyright_bg; ?>; }
<?php
	}
?>

<?php
	$pp_copyright_font_color = $import_options_arr['pp_copyright_font_color'];
	
	if(!empty($pp_copyright_font_color))
	{
?>
#copyright, #copyright i { color:<?php echo $pp_copyright_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_copyright_link_color = $import_options_arr['pp_copyright_link_color'];
	
	if(!empty($pp_copyright_link_color))
	{
?>
#copyright a { color:<?php echo $pp_copyright_link_color; ?>; }
<?php
	}
?>

<?php
	$pp_copyright_hover_color = $import_options_arr['pp_copyright_hover_color'];
	
	if(!empty($pp_copyright_hover_color))
	{
?>
#copyright a:hover, #copyright a:active { color:<?php echo $pp_copyright_hover_color; ?>; }
<?php
	}
?>

<?php
	$pp_widget_header_font_color = $import_options_arr['pp_widget_header_font_color'];
	
	if(!empty($pp_widget_header_font_color))
	{
?>
#content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h2.widgettitle a, #content_wrapper .inner .inner_wrapper ul.cat_filter li a.selected, ul.cat_filter li a.selected, ul.cat_filter li a:hover, #content_wrapper .inner .inner_wrapper ul.cat_filter li a:hover, .tabs .ui-state-active a { color:<?php echo $pp_widget_header_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_widget_header_bg_color = $import_options_arr['pp_widget_header_bg_color'];
	
	if(!empty($pp_widget_header_bg_color))
	{
?>
#content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, #content_wrapper .inner .inner_wrapper ul.cat_filter li a.selected, ul.cat_filter li a.selected, ul.cat_filter li a:hover, #content_wrapper .inner .inner_wrapper ul.cat_filter li a:hover, .tabs .ui-state-active, .tabs .ui-widget-header, #content_wrapper .inner .inner_wrapper .sidebar_content .tabs .ui-widget-header { background:<?php echo $pp_widget_header_bg_color; ?>; }
#content_wrapper .sidebar .content .sidebar_widget > li, .sidebar_widget > li { border-color:<?php echo $pp_widget_header_bg_color; ?>; }
<?php
	}
?>

<?php
	$pp_sidebar_title_font_size = $import_options_arr['pp_sidebar_title_font_size'];
	
	if(!empty($pp_sidebar_title_font_size))
	{
?>
#content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h2.widgettitle a, #content_wrapper .inner .inner_wrapper ul.cat_filter li a, .ui-tabs .ui-tabs-nav li a, .second_nav li .mega_menu_wrapper ul li h2.widgettitle { font-size:<?php echo $pp_sidebar_title_font_size; ?>px; }
<?php
	}
?>

<?php
	$pp_sidebar_title_upper = $import_options_arr['pp_sidebar_title_upper'];

	if(empty($pp_sidebar_title_upper))
	{
?>
#content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h2.widgettitle a, #content_wrapper .inner .inner_wrapper ul.cat_filter li a, .ui-tabs .ui-tabs-nav li a, .second_nav li .mega_menu_wrapper ul li h2.widgettitle  { text-transform: none; }		
<?php
	}
?>

<?php
	$pp_sidebar_title_bold = $import_options_arr['pp_sidebar_title_bold'];

	if(empty($pp_sidebar_title_bold))
	{
?>
#content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h2.widgettitle a, #content_wrapper .inner .inner_wrapper ul.cat_filter li a, .ui-tabs .ui-tabs-nav li a, .second_nav li .mega_menu_wrapper ul li h2.widgettitle  { font-weight: normal; }		
<?php
	}
?>

<?php
	$pp_sidebar_title_font = $import_options_arr['pp_sidebar_title_font'];
	
	if(!empty($pp_sidebar_title_font))
	{
?>
#content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h2.widgettitle a, #content_wrapper .inner .inner_wrapper ul.cat_filter li a, ul.cat_filter li a.selected, ul.cat_filter li a, #content_wrapper .inner .inner_wrapper ul.cat_filter li a:active ul.cat_filter li a:active, .ui-tabs .ui-tabs-nav li a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce-page div.product .woocommerce-tabs ul.tabs li a { font-family: '<?php echo urldecode($pp_sidebar_title_font); ?>' !important; }		
<?php
	}
?>

<?php
$pp_breaking_news_font = $import_options_arr['pp_breaking_news_font'];

if(!empty($pp_breaking_news_font))
{
?>
h2.breaking, #autocomplete li.view_all { font-family: '<?php echo urldecode($pp_breaking_news_font); ?>' !important; }		
<?php
}
?>

<?php
$pp_menu_font = $import_options_arr['pp_menu_font'];

if(!empty($pp_menu_font))
{
?>
.second_nav > li > a, .second_nav ul li ul.sub-menu li a, .second_nav li ul.sub-menu li a, .second_nav li .mega_menu_wrapper ul li ul.menu li a, .mobile_main_nav li a, .mobile_main_nav li a { font-family: '<?php echo urldecode($pp_menu_font); ?>' !important; }		
<?php
}
?>

<?php
	$pp_menu_font_size = $import_options_arr['pp_menu_font_size'];
	
	if(!empty($pp_menu_font_size))
	{
?>
.second_nav > li > a { font-size:<?php echo $pp_menu_font_size; ?>px; }
<?php
		$cal_sub_menu_margin = 47 - (26 - $pp_menu_font_size);
?>
#menu_wrapper div .nav li ul, .second_nav li ul { margin-top: <?php echo $cal_sub_menu_margin; ?>px; }
<?php
	}
	
?>

<?php
	$pp_submenu_font_size = $import_options_arr['pp_submenu_font_size'];
	
	if(!empty($pp_submenu_font_size))
	{
?>
.second_nav ul li ul.sub-menu li a, .second_nav li ul.sub-menu li a { font-size:<?php echo $pp_submenu_font_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_menu_font_upper = $import_options_arr['pp_menu_font_upper'];

	if(empty($pp_menu_font_upper))
	{
?>
.second_nav > li > a { text-transform: none; }		
<?php
	}
?>

<?php
	$pp_menu_font_bold = $import_options_arr['pp_menu_font_bold'];

	if(empty($pp_menu_font_bold))
	{
?>
.second_nav > li > a { font-weight: normal; }		
<?php
	}
?>

<?php
	$pp_body_font_size = $import_options_arr['pp_body_font_size'];
	
	if(!empty($pp_body_font_size))
	{
?>
body { font-size:<?php echo $pp_body_font_size; ?>px; }
<?php
	}
?>

<?php
$pp_body_font = $import_options_arr['pp_body_font'];

if(!empty($pp_body_font))
{
?>
body, input[type=text], input[type=password], input[type=email], input[type=url], #contact_form textarea, #commentform textarea, #searchform input[type=text] { font-family: '<?php echo urldecode($pp_body_font); ?>' !important; }		
<?php
}
?>

<?php
$pp_header_tags_font = $import_options_arr['pp_header_tags_font'];

if(!empty($pp_header_tags_font))
{
?>
h1, h2, h3, h4, h5, h6, h7, span[rel=author], a[rel=author], strong.title, a.post_title, .cat_link, blockquote:before, blockquote, ul.posts li h3, .second_nav li .mega_menu_wrapper ul li.widget_tag_cloud div.tagcloud a, .widget_tag_cloud div a, .meta-tags a, a.meta-tags, .more_story_title, .slider_wrapper .main_post_full .read_full, .slider_wrapper .main_post .read_full, .ppb_parallax_bg .post_title .read_full a, .ppb_video_bg .post_title .read_full a, .ppb_video_bg .post_title .read_full , .edit_review_wrapper .visual,.post_tag a, .post_category a, #copyright, .woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3, .woocommerce-page ul.product_list_widget li a, .woocommerce ul.product_list_widget li a { font-family: '<?php echo urldecode($pp_header_tags_font); ?>' !important; }		
<?php
}
?>

<?php
	$pp_header_tags_font_bold = $import_options_arr['pp_header_tags_font_bold'];
	
	if(!empty($pp_header_tags_font_bold))
	{
?>
h1, h2, h3, h4, h5, h6, h7, strong.title { font-weight: 600 !important; }
<?php
	}
	
?>


<?php
	$pp_h1_size = $import_options_arr['pp_h1_size'];
	
	if(!empty($pp_h1_size))
	{
?>
h1 { font-size:<?php echo $pp_h1_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h2_size = $import_options_arr['pp_h2_size'];
	
	if(!empty($pp_h2_size))
	{
?>
h2 { font-size:<?php echo $pp_h2_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h3_size = $import_options_arr['pp_h3_size'];
	
	if(!empty($pp_h3_size))
	{
?>
h3 { font-size:<?php echo $pp_h3_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h4_size = $import_options_arr['pp_h4_size'];
	
	if(!empty($pp_h4_size))
	{
?>
h4 { font-size:<?php echo $pp_h4_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h5_size = $import_options_arr['pp_h5_size'];
	
	if(!empty($pp_h5_size))
	{
?>
h5 { font-size:<?php echo $pp_h5_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h6_size = $import_options_arr['pp_h6_size'];
	
	if(!empty($pp_h6_size))
	{
?>
h6 { font-size:<?php echo $pp_h6_size; ?>px; }
<?php
	}	
?>

<?php
$pp_ppb_header_font = $import_options_arr['pp_ppb_header_font'];

if(!empty($pp_ppb_header_font))
{
?>
h5.header_line { font-family: '<?php echo urldecode($pp_ppb_header_font); ?>' !important; }		
<?php
}
?>

<?php
$pp_ppb_desc_font = $import_options_arr['pp_ppb_desc_font'];

if(!empty($pp_ppb_desc_font))
{
?>
.ppb_header .ppb_desc { font-family: '<?php echo urldecode($pp_ppb_desc_font); ?>' !important; }		
<?php
}
?>

<?php
	$pp_ppb_header_font_size = $import_options_arr['pp_ppb_header_font_size'];
	
	if(!empty($pp_ppb_header_font_size))
	{
?>
h5.header_line { font-size:<?php echo $pp_ppb_header_font_size; ?>px; }
<?php
	}
?>

<?php
	$pp_ppb_desc_font_size = $import_options_arr['pp_ppb_desc_font_size'];
	
	if(!empty($pp_ppb_desc_font_size))
	{
?>
.ppb_header .ppb_subtitle { font-size:<?php echo $pp_ppb_desc_font_size; ?>px; }
<?php
	}
?>

<?php
$pp_post_header_font = $import_options_arr['pp_post_header_font'];

if(!empty($pp_post_header_font))
{
?>
.post_header.half h4, h5.ppb_classic_title, h5.ppb_classic_title, ul.posts li h3, .post_header h3, h3.title, h3.title a, .post_header.half h4, h5.ppb_classic_title, h5.ppb_classic_title, ul.posts li h3, .post_header h3, h3.title, h3.title a, .woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3, .ppb_transparent_video_bg .post_title h3, strong.title, a.post_title, h1.post_title, #post_more_wrapper h4, .review-item .review-point-number, .edit_review_wrapper .visual_value, #review-box.review-percentage .review-item h5, #review-box.review-percentage .review-item h5, #review-box .review-item h5 { font-family: '<?php echo urldecode($pp_post_header_font); ?>' !important; }		
<?php
}
?>

<?php
$pp_page_header_font = $import_options_arr['pp_page_header_font'];

if(!empty($pp_page_header_font))
{
?>
#page_caption h1 { font-family: '<?php echo urldecode($pp_page_header_font); ?>' !important; }		
<?php
}
?>

<?php
	$pp_page_header_font_size = $import_options_arr['pp_page_header_font_size'];
	
	if(!empty($pp_page_header_font_size))
	{
?>
#page_caption h1, #page_caption h2, .slider_wrapper .main_post_full .post_title h3, .ppb_parallax_bg .post_title h3, .ppb_video_bg .post_title h3 { font-size:<?php echo $pp_page_header_font_size; ?>px; }
#page_caption h1, #page_caption h2, .slider_wrapper .main_post_full .post_title h3, .ppb_parallax_bg .post_title h3, .ppb_video_bg .post_title h3 { line-height:<?php echo $pp_page_header_font_size+6; ?>px; }
<?php
	}
?>

<?php
$pp_button_font = $import_options_arr['pp_button_font'];

if(!empty($pp_button_font))
{
?>
input[type=submit], input[type=button], a.button, a.button:hover, a.button:active, .btn2 a, .btn2 a:hover, button, button:hover, #autocomplete li.view_all { font-family: '<?php echo urldecode($pp_button_font); ?>' !important; }		
<?php
}
?>

<?php
	if(isset($_GET['rigelskin']) && !empty($_GET['rigelskin']))
	{
	    $pp_skin_color = '#'.$_GET['rigelskin'];
	}
	elseif(isset($import_options_arr['pp_skin_color']))
	{
	    $pp_skin_color = $import_options_arr['pp_skin_color'];
	}

	if(!empty($pp_skin_color))
	{
?>
.slider_wrapper .main_post_full .read_full, .slider_wrapper .main_post .read_full { color: <?php echo $pp_skin_color; ?>; }
.flex-control-paging li a.flex-active, .review_score_bg, .review-item span span span, input[type=submit], input[type=button], a.button, a.button:hover, a.button:active, .btn2 a, .btn2 a:hover, button, button:hover, .slider_widget_wrapper .flex-direction-nav a:hover, #autocomplete li.view_all { background: <?php echo $pp_skin_color; ?>; }
.post_carousel .flex-direction-nav a:hover, .slider_widget_wrapper.post_gallery .flex-direction-nav a:hover, .mega_menu_wrapper ul li .slider_widget_wrapper .flex-direction-nav li a:hover, #content_wrapper .inner .inner_wrapper .sidebar_content ul.flex-direction-nav li a:hover, .woocommerce-page a.button:hover, .woocommerce-page a.button:active, .woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .review-item span span span { background: <?php echo $pp_skin_color; ?> !important; }
.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, .woocommerce-page ul.product_list_widget li ins, .woocommerce-page div.product p.price ins, .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price, .ppb_parallax_bg .post_title .read_full a, .ppb_video_bg .post_title .read_full a, .ppb_video_bg .post_title .read_full { color: <?php echo $pp_skin_color; ?>;  }
<?php
	}
?>

<?php
	$pp_content_font_color = $import_options_arr['pp_content_font_color'];
	
	if(!empty($pp_content_font_color))
	{
?>
body { color:<?php echo $pp_content_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_content_link_color = $import_options_arr['pp_content_link_color'];
	
	if(!empty($pp_content_link_color))
	{
?>
a, a:hover, a:active { color:<?php echo $pp_content_link_color; ?>; }
<?php
	}
?>

<?php
	$pp_header_font_color = $import_options_arr['pp_header_font_color'];
	
	if(!empty($pp_header_font_color))
	{
?>
h1, h2, h3, h4, h5, h6, h7 { color:<?php echo $pp_header_font_color; ?>; }
<?php
	}
?>

<?php
	$pp_mobile_menu_bg_color = $import_options_arr['pp_mobile_menu_bg_color'];

	if(!empty($pp_mobile_menu_bg_color))
	{
	
?>
body.js_nav, #close_mobile_menu
{
	background: <?php echo $pp_mobile_menu_bg_color; ?>;
}
@media only screen and (max-width: 960px) {
	.mobile_menu_wrapper .menu-secondary-menu-container
	{
		background: <?php echo $pp_mobile_menu_bg_color; ?>;
	}
}
<?php
	}
?>

<?php
	$pp_mobile_menu_font_color = $import_options_arr['pp_mobile_menu_font_color'];

	if(!empty($pp_mobile_menu_font_color))
	{
	
?>
.mobile_main_nav li a
{
	color: <?php echo $pp_mobile_menu_font_color; ?> !important;
}
<?php
	}
?>

<?php
	$pp_mobile_menu_hover_font_color = $import_options_arr['pp_mobile_menu_hover_font_color'];

	if(!empty($pp_mobile_menu_hover_font_color))
	{
	
?>
.mobile_main_nav li a:hover
{
	background: <?php echo $pp_mobile_menu_hover_font_color; ?>;
	color: #ffffff;
}
<?php
	}
?>

<?php
	$pp_mobile_menu_border_color = $import_options_arr['pp_mobile_menu_border_color'];

	if(!empty($pp_mobile_menu_border_color))
	{
	
?>
.mobile_main_nav li, .mobile_main_nav, mobile_main_nav li ul
{
	border-color: <?php echo $pp_mobile_menu_border_color; ?> !important;
}
<?php
	}
?>

<?php
	//Get content layout
	if(isset($_GET['rigellayout']) && !empty($_GET['rigellayout']))
	{
	    $pp_layout = $_GET['rigellayout'];
	}
	elseif(isset($import_options_arr['pp_layout']))
	{
	    $pp_layout = $import_options_arr['pp_layout'];
	}
	
	if($pp_layout=='boxed')
	{
?>
#wrapper, .footer_wrapper { width: 1020px; margin: auto; float: none; }
body[data-style=fullscreen] #wrapper, body[data-style=flip] #wrapper, body[data-style=flow] #wrapper, body[data-style=fullscreen_video] #wrapper { width: 100%; }
.top_bar.fixed { width: 1020px; }

@media only screen and (min-width: 768px) and (max-width: 960px) {
	#wrapper, .footer_bar { width: 100%; }
}

@media only screen and (max-width: 767px) {
	#wrapper, .footer_bar { width: 100%; }
}

.footer_bar { margin-top: -15px; }
body { background: #d6d6d6; background-position: center center; }

	<?php
		$pp_boxed_bg_image = $import_options_arr['pp_boxed_bg_image'];
	
		if(!empty($pp_boxed_bg_image))
		{
	?>
	body
	{
		background-image: url('<?php echo $pp_boxed_bg_image; ?>');
		background-size: contain;
	}
	<?php
		}
	?>
	
	<?php
		$pp_boxed_bg_image_cover = $import_options_arr['pp_boxed_bg_image_cover'];
	
		if(!empty($pp_boxed_bg_image_cover))
		{
	?>
	body
	{
		background-size: cover !important;
		background-attachment:fixed;
	}
	<?php
		}
	?>
	
	<?php
		$pp_boxed_bg_image_repeat = $import_options_arr['pp_boxed_bg_image_repeat'];
	
		if(empty($pp_boxed_bg_image_repeat))
		{
			$pp_boxed_bg_image_repeat = 'no-repeat';
		}
	?>
	body
	{
		background-repeat: <?php echo $pp_boxed_bg_image_repeat; ?>;
	}

	<?php
		$pp_boxed_bg_color = $import_options_arr['pp_boxed_bg_color'];
	
		if(!empty($pp_boxed_bg_color))
		{
	?>
	body
	{
		background-color: <?php echo $pp_boxed_bg_color; ?>;
	}
	<?php
		}
	?>
	
<?php
	} //End if boxed layout
?>

<?php
/**
*	End Styling and Typography Setting Section
*/
?>

<?php
/**
* Header Stling
**/

$pp_logo_alignment = $import_options_arr['pp_logo_alignment'];
if($pp_logo_alignment == 'left')
{
?>
.logo { text-align: left; float: left; }
#header_bg { float: left; width: 100%; padding: 20px 0 20px 0; }
.menu-secondary-menu-container { clear: both; }
.second_nav { width: 960px; text-align: left; }
.header_ads { float: right; text-align: right; margin-bottom: 0; margin-top: 15px; }
<?php
}
?>

<?php
/**
*	Begin custom CSS section
**/
$pp_custom_css = get_option('pp_custom_css');


if(!empty($pp_custom_css))
{
    echo stripslashes($pp_custom_css);
}

/**
*	End custom CSS section
**/
?>

<?php
if(!empty($pp_advance_combine_css))
{
	ob_end_flush();
}
?>