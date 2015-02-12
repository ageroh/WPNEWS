<?php
//Get all galleries
$args = array(
    'numberposts' => -1,
    'post_type' => array('galleries'),
);

$galleries_arr = get_posts($args);
$galleries_select = array();
$galleries_select[''] = '';

foreach($galleries_arr as $gallery)
{
    $galleries_select[$gallery->ID] = $gallery->post_title;
}

//Get all categories
$categories_arr = get_categories();
$categories_select = array();
$categories_select[''] = '';

foreach ($categories_arr as $cat) {
	$categories_select[$cat->cat_ID] = $cat->cat_name;
}

//Get activate, deactivate options
$activated_arr = array(
	0	=> 	'Deactivate',
	1	=> 	'Activate',
);

//Get all sidebars
$theme_sidebar = array(
	'' => '',
	'Home Sidebar' => 'Home Sidebar',
	'Page Sidebar' => 'Page Sidebar', 
	'Contact Sidebar' => 'Contact Sidebar',
	'Category Sidebar' => 'Category Sidebar',
	'Footer Sidebar' => 'Footer Sidebar',
	'Archive Sidebar' => 'Archive Sidebar',
	'Search Sidebar' => 'Search Sidebar',
	'Tag Sidebar' => 'Tag Sidebar', 
	'Single Post Sidebar' => 'Single Post Sidebar'
);
$dynamic_sidebar = get_option('pp_sidebar');

if(!empty($dynamic_sidebar))
{
	foreach($dynamic_sidebar as $sidebar)
	{
		$theme_sidebar[$sidebar] = $sidebar;
	}
}

$ppb_shortcodes = array(
    'ppb_text' => array(
    	'title' =>  'Text Block',
    	'attr' => array(),
    	'desc' => array(),
    	'content' => TRUE
    ),
    'ppb_divider' => array(
    	'title' =>  'Divider',
    	'attr' => array(),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_classic_blog' => array(
    	'title' =>  'Classic Blog',
    	'attr' => array(
    		'subtitle' => array(
    			'type' => 'text',
    			'desc' => 'Enter subtitle of this content',
    		),
    		'title_display' => array(
    			'Title' => 'Display title and subtitle',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title and subtitle will display at the top of this content',
    		),
    		'category' => array(
    			'Title' => 'Filter by category',
    			'type' => 'select',
    			'options' => $categories_select,
    			'desc' => 'You can choose to display only some posts from selected category',
    		),
    		'items' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
    		'sidebar' => array(
    			'Title' => 'Content Sidebar',
    			'type' => 'select',
    			'options' => $theme_sidebar,
    			'desc' => 'You can select sidebar to display next to classic blog content',
    		),
    		'link' => array(
    			'Title' => 'Link title to selected category page',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title will link to selected category page',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_category_sidebar' => array(
    	'title' =>  'Category Posts With Sidebar',
    	'attr' => array(
    		'subtitle' => array(
    			'type' => 'text',
    			'desc' => 'Enter subtitle of this content',
    		),
    		'title_display' => array(
    			'Title' => 'Display title and subtitle',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title and subtitle will display at the top of this content',
    		),
    		'category' => array(
    			'Title' => 'Filter by category',
    			'type' => 'select',
    			'options' => $categories_select,
    			'desc' => 'You can choose to display only some posts from selected category',
    		),
    		'items' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
    		'sidebar' => array(
    			'Title' => 'Content Sidebar',
    			'type' => 'select',
    			'options' => $theme_sidebar,
    			'desc' => 'You can select sidebar to display next to classic blog content',
    		),
    		'link' => array(
    			'Title' => 'Link title to selected category page',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title will link to selected category page',
    		),
    		'excerpt' => array(
    			'Title' => 'Display post\'s excerpt',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Post\'s excerpt text display under post\'s title',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_categories_sidebar' => array(
    	'title' =>  'Multiple Categories Posts With Sidebar',
    	'attr' => array(
    		'subtitle' => array(
    			'type' => 'text',
    			'desc' => 'Enter subtitle of this content',
    		),
    		'category' => array(
    			'Title' => 'Filter by category',
    			'type' => 'select_multiple',
    			'options' => $categories_select,
    			'desc' => 'You can choose to display only some posts from selected category',
    		),
    		'items' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of posts to display (number value only) per category',
    		),
    		'sidebar' => array(
    			'Title' => 'Content Sidebar',
    			'type' => 'select',
    			'options' => $theme_sidebar,
    			'desc' => 'You can select sidebar to display next to classic blog content',
    		),
    		'link' => array(
    			'Title' => 'Link title to selected category page',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title will link to selected category page',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_category_carousel' => array(
    	'title' =>  'Category Carousel',
    	'attr' => array(
    		'subtitle' => array(
    			'type' => 'text',
    			'desc' => 'Enter subtitle of this content',
    		),
    		'title_display' => array(
    			'Title' => 'Display title and subtitle',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title and subtitle will display at the top of this content',
    		),
    		'category' => array(
    			'Title' => 'Filter by category',
    			'type' => 'select',
    			'options' => $categories_select,
    			'desc' => 'You can choose to display only some posts from selected category',
    		),
    		'items' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
    		'link' => array(
    			'Title' => 'Link title to selected category page',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title will link to selected category page',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_gallery_carousel' => array(
    	'title' =>  'Gallery Carousel',
    	'attr' => array(
    		'subtitle' => array(
    			'type' => 'text',
    			'desc' => 'Enter subtitle of this content',
    		),
    		'title_display' => array(
    			'Title' => 'Display title and subtitle',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title and subtitle will display at the top of this content',
    		),
    		'gallery' => array(
    			'Title' => 'Filter by gallery',
    			'type' => 'select',
    			'options' => $galleries_select,
    			'desc' => 'You can choose to display only some images from selected gallery',
    		),
    		'items' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of images to display (number value only)',
    		),
    		'link' => array(
    			'Title' => 'Link title to gallery page',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title will link to selected gallery page',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_columns_blog' => array(
    	'title' =>  'Columns Blog',
    	'attr' => array(
    		'subtitle' => array(
    			'type' => 'text',
    			'desc' => 'Enter subtitle of this content',
    		),
    		'title_display' => array(
    			'Title' => 'Display title and subtitle',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title and subtitle will display at the top of this content',
    		),
    		'category' => array(
    			'Title' => 'Filter by category',
    			'type' => 'select',
    			'options' => $categories_select,
    			'desc' => 'You can choose to display only some posts from selected category',
    		),
    		'items' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
    		'link' => array(
    			'Title' => 'Link title to selected category page',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Title will link to selected category page',
    		),
    		'excerpt' => array(
    			'Title' => 'Display post\'s excerpt',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Post\'s excerpt text display under post\'s title',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_filter_blog' => array(
    	'title' =>  'Filterable Blog',
    	'attr' => array(
    		'subtitle' => array(
    			'type' => 'text',
    			'desc' => 'Enter subtitle of this content',
    		),
    		'category' => array(
    			'Title' => 'Filter by category',
    			'type' => 'select_multiple',
    			'options' => $categories_select,
    			'desc' => 'You can choose to display only some posts from selected category',
    		),
    		'items' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
    		'excerpt' => array(
    			'Title' => 'Display post\'s excerpt',
    			'type' => 'select',
    			'options' => $activated_arr,
    			'desc' => 'If you activate this option. Post\'s excerpt text display under post\'s title',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_parallax_bg' => array(
    	'title' =>  'Parallax Background Image',
    	'attr' => array(
    		'background' => array(
    			'Title' => 'Background Image',
    			'type' => 'file',
    			'desc' => 'Upload background image you want to display for this content',
    		),
    		'height' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of height for background image (in pixel)',
    		),
    		'link_text' => array(
    			'title' => 'Link Text',
    			'type' => 'text',
    			'desc' => 'Enter background link text (For example "Read Full Story")',
    		),
    		'link_url' => array(
    			'title' => 'Link URL',
    			'type' => 'text',
    			'desc' => 'Enter background link URL',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_video_bg' => array(
    	'title' =>  'Video Background',
    	'attr' => array(
    		'mp4_video_url' => array(
    			'title' => 'MP4 Video URL',
    			'type' => 'file',
    			'desc' => 'Upload .mp4 video file you want to display for this content',
    		),
    		'webm_video_url' => array(
    			'title' => 'WebM Video URL',
    			'type' => 'file',
    			'desc' => 'Upload .webm video file you want to display for this content',
    		),
    		'preview_img' => array(
    			'title' => 'Preview Image URL',
    			'type' => 'file',
    			'desc' => 'Upload preview image for this video',
    		),
    		'height' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of height for background image (in pixel)',
    		),
    		'link_text' => array(
    			'title' => 'Link Text',
    			'type' => 'text',
    			'desc' => 'Enter video link text (For example "Read Full Story")',
    		),
    		'link_url' => array(
    			'title' => 'Link URL',
    			'type' => 'text',
    			'desc' => 'Enter video link URL',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
);

ksort($ppb_shortcodes);
?>