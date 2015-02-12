<?php
/**
	Get categories
**/
$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array(
	0		=> "Choose a category"
);
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}

$api_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

/*
	Begin creating admin options
*/

$options = array (
 
//Begin admin header
array( 
		"name" => THEMENAME." Options",
		"type" => "title"
),
//End admin header
 

//Begin first tab "General"
array( 
		"name" => "General",
		"type" => "section",
		"icon" => "gear.png",
),

array( "type" => "open"),

array( "name" => "<h2>Website Indentity</h2>Custom Favicon",
	"desc" => "A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image",
	"id" => SHORTNAME."_favicon",
	"type" => "image",
	"std" => "",
),
array( "name" => "<h2>Animation Settings</h2>Use effect in loading animation",
	"desc" => "Enable this to display content with animation",
	"id" => SHORTNAME."_animation_fade",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "<h2>Contact Form Settings</h2>Your email address",
	"desc" => "Enter which email address will be sent from contact form",
	"id" => SHORTNAME."_contact_email",
	"type" => "text",
	"std" => ""
),
array( "name" => "<h2>Advanced Settings</h2>Tracking Code",
	"desc" => "Paste your Google Analytics code (or other) tracking code here. This code will be added into the footer of theme",
	"id" => SHORTNAME."_ga_code",
	"type" => "textarea",
	"std" => ""
),
array( "name" => "Before &lt;/head&gt;",
	"desc" => "This code will be added before &lt;/head&gt; tag",
	"id" => SHORTNAME."_before_head_code",
	"type" => "textarea",
	"std" => ""
),
array( "name" => "Before &lt;/body&gt;",
	"desc" => "This code will be added before &lt;/body&gt; tag",
	"id" => SHORTNAME."_before_body_code",
	"type" => "textarea",
	"std" => ""
),
	
array( "type" => "close"),
//End first tab "General"


//Begin first tab "Header"
array( 
		"name" => "Header",
		"type" => "section",
		"icon" => "layout-select-header.png",
),

array( "type" => "open"),

array( "name" => "<h2>Top Bar Settings</h2>Display Top bar",
	"desc" => "Select to display top bar at the top of every pages",
	"id" => SHORTNAME."_enable_top_bar",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Display social icons",
	"desc" => "Check this to display social icons in top bar",
	"id" => SHORTNAME."_top_bar_social_display",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Display search bar",
	"desc" => "Check this to display search in top bar",
	"id" => SHORTNAME."_top_bar_search_display",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Use instant search",
	"desc" => "Select to enable AJAX instant search result",
	"id" => SHORTNAME."_blog_ajax_search",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Top Bar Background Color",
	"desc" => "Select background color for top bar",
	"id" => SHORTNAME."_top_bar_bg",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),
array( "name" => "Top Bar Border Color",
	"desc" => "Select border color for top bar",
	"id" => SHORTNAME."_top_bar_border",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#666666"
),
array( "name" => "Top Bar Font Color",
	"desc" => "Select font color for top bar",
	"id" => SHORTNAME."_top_bar_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#cccccc"
),
array( "name" => "<h2>Social Icon Settings</h2>Top Bar Social Icon Color",
	"desc" => "Select color for social icon in top bar",
	"id" => SHORTNAME."_top_bar_social_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),
array( "name" => "Use social icon original color",
	"desc" => "Select to use social's original color for social icons",
	"id" => SHORTNAME."_top_bar_social_original",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "<h2>Breaking News Settings</h2>Display breaking news section",
	"desc" => "Select to display breaking news section at the top left on page",
	"id" => SHORTNAME."_enable_breaking",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Breaking news section category",
	"desc" => "Choose a category from which contents in breaking news are drawn",
	"id" => SHORTNAME."_breaking_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"
),
array( "name" => "Breaking news display items",
	"desc" => "Enter number of items for Breaking news",
	"id" => SHORTNAME."_breaking_items",
	"type" => "jslider",
	"size" => "40px",
	"std" => "5",
	"from" => 1,
	"to" => 20,
	"step" => 1,
),
array( "name" => "<h2>Breaking News Font Settings</h2>Breaking News Font Family",
	"desc" => "Select font style for breaking module text",
	"id" => SHORTNAME."_breaking_news_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "Top Bar Breaking News Header Font Color",
	"desc" => "Select font color for breaking news header text in top bar",
	"id" => SHORTNAME."_top_bar_breaking_header_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),
array( "name" => "<h2>Advertisement Settings</h2>468x60 or 728x90 or 970x90 Top Banner Code",
	"desc" => "",
	"id" => SHORTNAME."_top_banner",
	"type" => "textarea",
	"std" => ""
),
array( "name" => "<h2>Logo Settings</h2>Logo",
	"desc" => "Enter the URL of image that you want to use as the logo",
	"id" => SHORTNAME."_logo",
	"type" => "image",
	"std" => "",
),
array( "name" => "Retina Logo",
	"desc" => "Retina Ready Image logo. It should be 2x size of normal logo",
	"id" => SHORTNAME."_retina_logo",
	"type" => "image",
	"std" => "",
),
array( "name" => "Logo Alignment",
	"desc" => "Select alignment for logo image",
	"id" => SHORTNAME."_logo_alignment",
	"type" => "select",
	"options" => array(
		'center' => 'Center',
		'left' => 'Left',
	),
	"std" => 'center'
),
array( "name" => "Logo Area Background Color",
	"desc" => "Select background color for logo area",
	"id" => SHORTNAME."_logo_bg",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),
array( "name" => "Logo Margin Top (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_logo_margintop",
	"type" => "jslider",
	"size" => "40px",
	"std" => "20",
	"from" => 0,
	"to" => 60,
	"step" => 1,
),
array( "name" => "<h2>Menu Settings</h2>Use fixed top menu",
	"desc" => "Enable this to display menu fixed when scrolling",
	"id" => SHORTNAME."_fixed_menu",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Menu Width",
	"desc" => "Select width style for menu",
	"id" => SHORTNAME."_menu_width",
	"type" => "select",
	"options" => array(
		'fullwidth' => 'Fullwidth',
		'fixed_width' => 'Fixed Width',
	),
	"std" => 'fullwidth'
),
array( "name" => "<h2>Menu Font Settings</h2>Menu Font Family",
	"desc" => "Select font style your menu",
	"id" => SHORTNAME."_menu_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "Menu font Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_menu_font_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "14",
	"from" => 11,
	"to" => 24,
	"step" => 1,
),
array( "name" => "Make Menu font uppercase",
	"desc" => "",
	"id" => SHORTNAME."_menu_font_upper",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Make Menu font bold",
	"desc" => "",
	"id" => SHORTNAME."_menu_font_bold",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Sub Menu font Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_submenu_font_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "14",
	"from" => 11,
	"to" => 24,
	"step" => 1,
),
array( "name" => "<h2>Menu Colors Settings</h2>Menu Background Color",
	"desc" => "Select color for menu background color",
	"id" => SHORTNAME."_menu_bg",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),

array( "name" => "Menu Border Bottom (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_menu_border",
	"type" => "jslider",
	"size" => "40px",
	"std" => "0",
	"from" => 0,
	"to" => 10,
	"step" => 1,
),

array( "name" => "Menu Border Color",
	"desc" => "Select color for menu border bottom color",
	"id" => SHORTNAME."_menu_border_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),

array( "name" => "Menu Font Color",
	"desc" => "Select color for menu font color",
	"id" => SHORTNAME."_menu_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),

array( "name" => "Menu Active State Style",
	"desc" => "Select active style for menu",
	"id" => SHORTNAME."_menu_active_style",
	"type" => "select",
	"options" => array(
		'background' => 'Highlight Background',
		'border' => 'Highlight Border',
		'font' => 'Highlight Font',
	),
	"std" => 'background'
),

array( "name" => "Menu Active State Color",
	"desc" => "Select color for active menu color",
	"id" => SHORTNAME."_menu_active_bg_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),

array( "name" => "Menu Active State Font Color",
	"desc" => "Select color for active menu font color",
	"id" => SHORTNAME."_menu_active_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),

array( "name" => "Sub Menu Background Color",
	"desc" => "Select color for sub menu background color",
	"id" => SHORTNAME."_sub_menu_bg",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),

array( "name" => "Sub Menu Border Color",
	"desc" => "Select color for sub menu border color",
	"id" => SHORTNAME."_sub_menu_border",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ebebeb"
),

array( "name" => "Sub Menu Font Color",
	"desc" => "Select color for sub menu font color",
	"id" => SHORTNAME."_sub_menu_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#555555"
),

array( "name" => "Sub Menu Active State Color",
	"desc" => "Select color for active sub menu color",
	"id" => SHORTNAME."_sub_menu_active_bg_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#f4b711"
),

array( "name" => "<h2>Mega Menu Settings</h2>Mega Menu Widget Header Font Color",
	"desc" => "Select color for mega menu widget header font color",
	"id" => SHORTNAME."_mega_menu_widget_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),
	
array( "type" => "close"),
//End first tab "Header"


//Begin second tab "Sidebar"
array( 
	"name" => "Sidebar",
	"type" => "section",
	"icon" => "application-sidebar-expand.png",
),
array( "type" => "open"),

array( "name" => "<h2>Custom Sidebar Settings</h2>Add a new sidebar",
	"desc" => "Enter sidebar name",
	"id" => SHORTNAME."_sidebar0",
	"type" => "text",
	"std" => "",
),
array( "name" => "<h2>Sidebar Font Settings</h2>Widget Title font size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_sidebar_title_font_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "14",
	"from" => 12,
	"to" => 40,
	"step" => 1,
),
array( "name" => "Make Widget Title font uppercase",
	"desc" => "",
	"id" => SHORTNAME."_sidebar_title_upper",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Make Widget Title font bold",
	"desc" => "",
	"id" => SHORTNAME."_sidebar_title_bold",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Widget Title Font",
	"desc" => "Select global font family for all sidebar widget's title",
	"id" => SHORTNAME."_sidebar_title_font",
	"type" => "font",
	"std" => ""
),
array( "name" => "<h2>Sidebar Content Colors Settings</h2>Widget Title Font Color",
	"desc" => "Select font color for widget header",
	"id" => SHORTNAME."_widget_header_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),

array( "name" => "Widget Title Background Color",
	"desc" => "Select background color for widget header",
	"id" => SHORTNAME."_widget_header_bg_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),
array( "type" => "close"),
//End second tab "Sidebar"


array( 
	"name" => "Footer",
	"type" => "section",
	"icon" => "layout-select-footer.png",
),
array( "type" => "open"),

array( "name" => "<h2>Advertisement Settings</h2>468x60 or 728x90 or 970x90 Footer Banner Code",
	"desc" => "",
	"id" => SHORTNAME."_footer_banner",
	"type" => "textarea",
	"std" => ""
),
array( "name" => "<h2>Footer Layouts and Styles Settings</h2>Show Footer Sidebar",
	"desc" => "If you enable this option, you can add widgets to \"Footer Sidebar\" using Appearance > Widgets",
	"id" => SHORTNAME."_footer_display_sidebar",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Footer text",
	"desc" => "Enter footer text ex. copyright description",
	"id" => SHORTNAME."_footer_text",
	"type" => "textarea",
	"std" => ""
),
array( "name" => "<h2>Footer Colors Settings</h2>Footer Background Color",
	"desc" => "Select background color for footer",
	"id" => SHORTNAME."_footer_bg",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),

array( "name" => "Footer Widget Header Font Color",
	"desc" => "Select color for the widget header font in footer",
	"id" => SHORTNAME."_footer_header_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#f4b711"
),

array( "name" => "Footer Font Color",
	"desc" => "Select font color for footer",
	"id" => SHORTNAME."_footer_font",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#cccccc"
),

array( "name" => "Footer Link Color",
	"desc" => "Select color for the link in footer",
	"id" => SHORTNAME."_footer_link_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),

array( "name" => "Footer Hover Link Color",
	"desc" => "Select color for the hover font in footer",
	"id" => SHORTNAME."_footer_hover_link_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#f4b711"
),

array( "name" => "Footer Element Border Color",
	"desc" => "Select border color for footer elements",
	"id" => SHORTNAME."_footer_element_border",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#555555"
),

array( "name" => "<h2>Copyright Bar Colors Settings</h2>Copyright Background Color",
	"desc" => "Select background color for copyright area below footer",
	"id" => SHORTNAME."_copyright_bg",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#212121"
),

array( "name" => "Copyright Font Color",
	"desc" => "Select font color for copyright area below footer",
	"id" => SHORTNAME."_copyright_font",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#cccccc"
),

array( "name" => "Copyright Bar Link Color",
	"desc" => "Select link color for copyright bar",
	"id" => SHORTNAME."_copyright_link_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),

array( "name" => "Copyright Bar Hover Link Color",
	"desc" => "Select hover state link color for copyright bar",
	"id" => SHORTNAME."_copyright_hover_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#212121"
),
//End fifth tab "Footer"

array( "type" => "close"),


//Begin second tab "Mobile"
array( 	"name" => "Mobile",
		"type" => "section",
		"icon" => "phone.png",	
),
array( "type" => "open"),

array( "name" => "<h2>Responsive Layout Settings</h2>Use responsive layout",
	"desc" => "",
	"id" => SHORTNAME."_enable_responsive",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "<h2>Animation Settings</h2>Disable loading animation on mobile",
	"desc" => "",
	"id" => SHORTNAME."_disable_mobile_animation",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "<h2>Mobile Menu Settings</h2>Mobile Menu Background Color",
	"desc" => "Select color for mobile menu background",
	"id" => SHORTNAME."_mobile_menu_bg_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#333333"
),

array( "name" => "Mobile Menu Font Color",
	"desc" => "Select color for mobile menu font",
	"id" => SHORTNAME."_mobile_menu_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#999999"
),

array( "name" => "Mobile Menu Hover State Color",
	"desc" => "Select color for mobile menu in hover state",
	"id" => SHORTNAME."_mobile_menu_hover_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#222222"
),

array( "name" => "Mobile Menu Border Color",
	"desc" => "Select color for mobile menu bottom border",
	"id" => SHORTNAME."_mobile_menu_border_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#d5d5d5"
),

array( "type" => "close"),
//End second tab "Mobile"


//Begin first tab "Background"
array( 
		"name" => "Background",
		"type" => "section",
		"icon" => "paintcan.png",
),

array( "type" => "open"),

array( "name" => "<h2>Layout Settings</h2>Layout",
	"desc" => "Select main content layout style",
	"id" => SHORTNAME."_layout",
	"type" => "select",
	"options" => array(
		'wide' => 'Wide',
		'boxed' => 'Boxed',
	),
	"std" => "wide"
),

array( "name" => "<h2>Boxed Layout Background Settings</h2>Background Image For Outer Areas in Boxed Layout",
	"desc" => "Please upload or insert full image URL to use for background",
	"id" => SHORTNAME."_boxed_bg_image",
	"type" => "image",
	"std" => "",
),

array( "name" => "Use 100% Background Image",
	"desc" => "Check this option to have the background image display at 100% in width and height, scaled according to visitor screen resolution",
	"id" => SHORTNAME."_boxed_bg_image_cover",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "Background Repeat",
	"desc" => "Select how background image repeat",
	"id" => SHORTNAME."_boxed_bg_image_repeat",
	"type" => "select",
	"options" => array(
		'no-repeat' => 'No Repeat',
		'repeat' => 'Repeat',
	),
	"std" => "no-repeat"
),

array( "name" => "Background Color",
	"desc" => "Select background color for boxed layout option",
	"id" => SHORTNAME."_boxed_bg_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#d6d6d6"
),
	
array( "type" => "close"),
//End first tab "Background"


//Begin first tab "Typography"
array( 
		"name" => "Typography",
		"type" => "section",
		"icon" => "text_dropcaps.png",
),

array( "type" => "open"),

array( "name" => "<h2>Google Web Fonts Settings</h2>You can add additional Google Web Font.",
	"desc" => "Enter font name ex. Courgette <a href=\"http://www.google.com/webfonts\">Checkout Google Web Font Directory</a>",
	"id" => SHORTNAME."_ggfont0",
	"type" => "text",
	"std" => "",
),
array( "name" => "<h2>Content Font Settings</h2>Main Content Font Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_body_font_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "14",
	"from" => 11,
	"to" => 20,
	"step" => 1,
),
array( "name" => "Main Content Font Family",
	"desc" => "Select font style your main content text",
	"id" => SHORTNAME."_body_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "<h2>Header Font Settings</h2>Header Tags Font Family",
	"desc" => "Select font style for h1, h2, h3, h4, h5, h6 tags",
	"id" => SHORTNAME."_header_tags_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "Make Header Tags font bold",
	"desc" => "",
	"id" => SHORTNAME."_header_tags_font_bold",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "H1 Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_h1_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "26",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H2 Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_h2_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "24",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H3 Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_h3_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "22",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H4 Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_h4_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "20",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H5 Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_h5_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "18",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H6 Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_h6_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "16",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "<h2>Page/Post Content Font Settings</h2>Content Builder Header Font Family",
	"desc" => "Select font style your content builder module header text",
	"id" => SHORTNAME."_ppb_header_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "Content Builder Header font Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_ppb_header_font_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "26",
	"from" => 20,
	"to" => 60,
	"step" => 1,
),
array( "name" => "Content Builder Description Font Family",
	"desc" => "Select font style your content builder module description text",
	"id" => SHORTNAME."_ppb_desc_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "Content Builder Description font Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_ppb_desc_font_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "11",
	"from" => 11,
	"to" => 30,
	"step" => 1,
),
array( "name" => "Post Title Font Family",
	"desc" => "Select font style your blog post header text",
	"id" => SHORTNAME."_post_header_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "Page Header Font Family",
	"desc" => "Select font style your blog post header text",
	"id" => SHORTNAME."_page_header_font",
	"type" => "font",
	"std" => ''
),
array( "name" => "Page Header font Size (in pixels)",
	"desc" => "",
	"id" => SHORTNAME."_page_header_font_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "26",
	"from" => 16,
	"to" => 60,
	"step" => 1,
),
array( "name" => "Button Font Family",
	"desc" => "Select font style your button text",
	"id" => SHORTNAME."_button_font",
	"type" => "font",
	"std" => ''
),
	
array( "type" => "close"),
//End first tab "Typography"


//Begin first tab "Styling"
array( 
		"name" => "Styling",
		"type" => "section",
		"icon" => "palette.png",
),

array( "type" => "open"),

array( "name" => "<h2>Slider Settings</h2>Use auto slideshow",
	"desc" => "Enable this to slide page slider automatically",
	"id" => SHORTNAME."_slider_auto",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Slideshow items",
	"desc" => "Select number of slider items to display",
	"id" => SHORTNAME."_slider_items",
	"type" => "jslider",
	"size" => "40px",
	"std" => "6",
	"from" => 1,
	"to" => 50,
	"step" => 1,
),
array( "name" => "Slideshow timer (in second)",
	"desc" => "Select number of seconds to switch between each slide",
	"id" => SHORTNAME."_slider_timer",
	"type" => "jslider",
	"size" => "40px",
	"std" => "7",
	"from" => 1,
	"to" => 30,
	"step" => 1,
),

array( "name" => "<h2>Content Colors Settings</h2>Main Skin Color",
	"desc" => "Select color for theme skin",
	"id" => SHORTNAME."_skin_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#f4b711"
),

array( "name" => "Content Font Color",
	"desc" => "Select color for main content text",
	"id" => SHORTNAME."_content_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#555555"
),

array( "name" => "Content Link Color",
	"desc" => "Select color for main content link",
	"id" => SHORTNAME."_content_link_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#000000"
),

array( "name" => "Post/Page Header Font Color",
	"desc" => "Select font color for post/page header",
	"id" => SHORTNAME."_header_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"
),

array( "type" => "close"),
//End first tab "Styling"


//Begin second tab "Blog"
array( 
	"name" => "Blog",
	"type" => "section",
	"icon" => "book-open-bookmark.png",
),
array( "type" => "open"),

array( "name" => "<h2>Archives, Categories, Tags and Search Page Settings</h2>Archive page layout ",
	"desc" => "Select default layout for archive page",
	"id" => SHORTNAME."_archive_layout",
	"type" => "select",
	"options" => array(
		1 => 'Classic Blog',
		'1-search' => 'Classic Search',
		2 => '2 Columns',
		'2-noexcerpt' => '2 Columns No Excerpt',
	),
	"std" => '2'
),
array( "name" => "Category page layout ",
	"desc" => "Select default layout for category page",
	"id" => SHORTNAME."_category_layout",
	"type" => "select",
	"options" => array(
		1 => 'Classic Blog',
		'1-search' => 'Classic Search',
		2 => '2 Columns',
		'2-noexcerpt' => '2 Columns No Excerpt',
	),
	"std" => '2'
),
array( "name" => "Search page layout ",
	"desc" => "Select default layout for search page",
	"id" => SHORTNAME."_search_layout",
	"type" => "select",
	"options" => array(
		1 => 'Classic Blog',
		'1-search' => 'Classic Search',
		2 => '2 Columns',
		'2-noexcerpt' => '2 Columns No Excerpt',
	),
	"std" => '2'
),
array( "name" => "Tag page layout ",
	"desc" => "Select default layout for tag page",
	"id" => SHORTNAME."_tag_layout",
	"type" => "select",
	"options" => array(
		1 => 'Classic Blog',
		'1-search' => 'Classic Search',
		2 => '2 Columns',
		'2-noexcerpt' => '2 Columns No Excerpt',
	),
	"std" => '2'
),
array( "name" => "Author page layout ",
	"desc" => "Select default layout for author page",
	"id" => SHORTNAME."_author_layout",
	"type" => "select",
	"options" => array(
		1 => 'Classic Blog',
		'1-search' => 'Classic Search',
		2 => '2 Columns',
		'2-noexcerpt' => '2 Columns No Excerpt',
	),
	"std" => '2'
),
array( "name" => "<h2>Pagination Settings</h2>Show advanced pagination",
	"desc" => "",
	"id" => SHORTNAME."_blog_advance_pagination",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "<h2>Single Post Page Settings</h2>Show Social share buttons",
	"desc" => "Select to display socials sharing in single post page",
	"id" => SHORTNAME."_social_sharing",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show Editor Rating module",
	"desc" => "Select to display editor rating box in review post.",
	"id" => SHORTNAME."_blog_display_editor_review",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show About author module",
	"desc" => "Select to display about the author in single post page",
	"id" => SHORTNAME."_blog_display_author",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show Related posts module",
	"desc" => "Select to display related posts in single post page",
	"id" => SHORTNAME."_blog_display_related",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show post's featured image on single post page",
	"desc" => "Select to display post's featured image in single post page",
	"id" => SHORTNAME."_blog_single_ft_image",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show more story module on single post page",
	"desc" => "Select to display more story popup in single post page",
	"id" => SHORTNAME."_blog_more_story",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show post's tags on single post page",
	"desc" => "Select to display post's tags in single post page",
	"id" => SHORTNAME."_blog_tags",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show post's categories on single post page",
	"desc" => "Select to display post's categories in single post page",
	"id" => SHORTNAME."_blog_categories",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Show next and previous posts on single post page",
	"desc" => "Select to display next and previous posts in single post page",
	"id" => SHORTNAME."_blog_next_prev",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "type" => "close"),
//End second tab "Blog"

//Begin fifth tab "Social Profiles"
array( 	"name" => "Social-Profiles",
		"type" => "section",
		"icon" => "social.png",
),
array( "type" => "open"),
	
array( "name" => "<h2>Profiles Settings</h2>Facebook Fanpage name (ex. BMW)",
	"desc" => "",
	"id" => SHORTNAME."_facebook_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Twitter Username",
	"desc" => "",
	"id" => SHORTNAME."_twitter_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Google Plus URL",
	"desc" => "",
	"id" => SHORTNAME."_google_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Flickr Username",
	"desc" => "",
	"id" => SHORTNAME."_flickr_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Youtube Channel ID (ex. UCi8e0iOVk1fEOogdfu4YgfA)",
	"desc" => "",
	"id" => SHORTNAME."_youtube_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Vimeo Username",
	"desc" => "",
	"id" => SHORTNAME."_vimeo_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Dribbble Username",
	"desc" => "",
	"id" => SHORTNAME."_dribbble_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Linkedin URL",
	"desc" => "",
	"id" => SHORTNAME."_linkedin_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Tumblr Username",
	"desc" => "",
	"id" => SHORTNAME."_tumblr_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Pinterest Username",
	"desc" => "",
	"id" => SHORTNAME."_pinterest_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "Instagram Username",
	"desc" => "",
	"id" => SHORTNAME."_instagram_username",
	"type" => "text",
	"std" => ""
),
array( "name" => "<h2>Twitter API Settings</h2>Twitter Consumer Key <a href=\"http://support.themegoods.com/?knowledgebase=fix-twitter-widget\">See instructions</a>",
	"desc" => "",
	"id" => SHORTNAME."_twitter_consumer_key",
	"type" => "text",
	"std" => ""
),
array( "name" => "Twitter Consumer Secret",
	"desc" => "",
	"id" => SHORTNAME."_twitter_consumer_secret",
	"type" => "text",
	"std" => ""
),
array( "name" => "Twitter Consumer Token",
	"desc" => "",
	"id" => SHORTNAME."_twitter_consumer_token",
	"type" => "text",
	"std" => ""
),
array( "name" => "Twitter Consumer Token Secret",
	"desc" => "",
	"id" => SHORTNAME."_twitter_consumer_token_secret",
	"type" => "text",
	"std" => ""
),

array( "type" => "close"),
//End fifth tab "Social Profiles"


//Begin second tab "Script"
array( "name" => "Script",
	"type" => "section",
	"icon" => "css.png",
),

array( "type" => "open"),

array( "name" => "<h2>CSS Settings</h2>Custom CSS",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css",
	"type" => "textarea",
	"std" => ""
),
array( "name" => "Combine and compress theme's CSS files",
	"desc" => "Combine and compress all CSS files to one. Help reduce page load time",
	"id" => SHORTNAME."_advance_combine_css",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "<h2>Javascript Settings</h2>Combine and compress theme's javascript files",
	"desc" => "Combine and compress all javascript files to one. Help reduce page load time",
	"id" => SHORTNAME."_advance_combine_js",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "<h2>Cache Settings</h2>Clear Cache",
	"desc" => "Try to clear cache when you enable javascript and CSS compression and theme went wrong",
	"id" => SHORTNAME."_advance_clear_cache",
	"type" => "html",
	"html" => '<a id="'.SHORTNAME.'_advance_clear_cache" href="'.$api_url.'" class="button">Click here to start clearing cache files</a>',
),

array( "type" => "close"),

//Begin second tab "Backup"
array( "name" => "Backup",
	"type" => "section",
	"icon" => "drive_disk.png",
),

array( "type" => "open"),

array( "name" => "<h2>Import Settings</h2>",
	"desc" => "Choose theme export file (.json) from your computer and click \"Import\" button",
	"id" => SHORTNAME."_import_current",
	"type" => "html",
	"html" => '<input type="file" id="'.SHORTNAME.'_import_current" name="'.SHORTNAME.'_import_current"/><input type="submit" id="'.SHORTNAME.'_import_current_button" class="button" value="Import"/>',
),

array( "name" => "<h2>Export Settings</h2>",
	"desc" => "You can click below button to save current backup into .json file so you can import it back any time using restore form below.",
	"id" => SHORTNAME."_export_current",
	"type" => "html",
	"html" => '<input type="submit" id="'.SHORTNAME.'_export_current_button" class="button" value="Export Current Theme Settings"/><input type="hidden" id="'.SHORTNAME.'_export_current" name="'.SHORTNAME.'_export_current" value="0"/>',
),
 
array( "type" => "close")
 
);
?>