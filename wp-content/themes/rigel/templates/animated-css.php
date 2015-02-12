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
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:0.99; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:0.99; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:0.99; } }
 
.fade-in {
    opacity:0; 
    -webkit-animation:fadeIn ease-in 1;  
    -moz-animation:fadeIn ease-in 1;
    animation:fadeIn ease-in 1;
 
    -webkit-animation-fill-mode:forwards; 
    -moz-animation-fill-mode:forwards;
    animation-fill-mode:forwards;
 
    -webkit-animation-duration:0.5s;
    -moz-animation-duration:0.5s;
    animation-duration:0.5s;
}
 
.fade-in.one {
	-webkit-animation-delay: 0.5s;
	-moz-animation-delay: 0.5s;
	animation-delay: 0.5s;
}

.fade-in.two {
	-webkit-animation-delay: 1.2s;
	-moz-animation-delay:1.2s;
	animation-delay: 1.2s;
}
 
.fade-in.three {
	-webkit-animation-delay: 1.6s;
	-moz-animation-delay: 1.6s;
	animation-delay: 1.6s;
}

.fade-in.four {
	-webkit-animation-delay: 2s;
	-moz-animation-delay: 2s;
	animation-delay: 2s;
}

.entry_img {
	opacity:0;
}

.in-view {
	-webkit-animation:fadeIn ease-in 1;  
    -moz-animation:fadeIn ease-in 1;
    animation:fadeIn ease-in 1;
 
    -webkit-animation-duration:0.5s;
    -moz-animation-duration:0.5s;
    animation-duration:0.5s;
    
	opacity: 1;
}

#content_wrapper .inner .inner_wrapper .sidebar_content ul.slides, .flexslider .slides
{
	margin: 0 !important;
}
<?php
	}
	else
	{
?>
	.fade-in, .element, .entry_img { opacity: 1 !important; }
	body { overflow-x: auto; }
<?php
	}
?>

<?php
	for($i=1;$i<=10;$i++)
	{
?>
.animated<?php echo $i; ?>
{
	-webkit-animation-delay: <?php echo $i/2; ?>s;
	-moz-animation-delay: <?php echo $i/2; ?>s;
	animation-delay: <?php echo $i/2; ?>s;
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
	$pp_fixed_menu = get_option('pp_fixed_menu');
	
	if(!empty($pp_fixed_menu))
	{
?>
#second_menu.fixed
{
	background: #fff;
	background: rgba(256,256,256,.95);
	opacity: 1;
	-webkit-animation:fadeIn ease-in 1;  
    -moz-animation:fadeIn ease-in 1;
    animation:fadeIn ease-in 1;
 
    -webkit-animation-duration:0.3s;
    -moz-animation-duration:0.3s;
    animation-duration:0.3s;
    
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1001;
    border: 0;
    margin: 0;
    width: 100%;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.second_nav.fixed ul li a, .second_nav.fixed li a
{
	padding: 11px 15px 7px 15px;
	font-size: 13px !important;
}

.second_nav.fixed ul li > ul, .second_nav.fixed li > ul
{
	margin-top: 37px;
	border: 0;
	background: #fff;
	background: rgba(256,256,256,.95);
}

.second_nav.fixed ul li ul li > ul, .second_nav.fixed li ul li > ul
{
	margin-top: -5px;
}

.second_nav.fixed ul li ul li a, .second_nav.fixed li ul li a
{
	padding: 6px 19px 6px 16px;
	font-size: 11px !important;
}

.second_nav.fixed li .mega_menu_wrapper
{
	width: 100%;
}

.second_nav.fixed li .mega_menu_wrapper ul.sidebar_widget
{
	width: 960px;
	margin: auto;
	left: -10px;
}

.second_nav.fixed li .mega_menu_wrapper ul > li .slider_widget_wrapper
{
	max-width: 280px;
}
<?php
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
if(!empty($pp_advance_combine_css))
{
	ob_end_flush();
}