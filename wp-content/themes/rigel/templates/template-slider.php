<?php
global $page_slider;

if(!empty($page_slider))
{
	$pp_slider_items = get_option('pp_slider_items');

	//Get all post from this category
	$args = array(
		'posts_per_page'  	=> $pp_slider_items,
		'category'			=> $page_slider,
	);
	
	$slider_posts = get_posts($args);
	$count_posts = intval(count($slider_posts)/3);
	
	if(!empty($slider_posts))
	{
?>
	<div id="page_slider" class="slider_wrapper three_cols"  data-height="430" data-count="<?php echo $count_posts; ?>">
		<div class="flexslider three_cols">
			<ul class="slides">
<?php
		$count = 1;
		$get_main_ft = TRUE;
		foreach($slider_posts as $key => $slider_post)
		{
			$image_thumb = '';
			if($get_main_ft)
			{
?>
				<li>
<?php
				if(has_post_thumbnail($slider_post->ID, 'large'))
				{
				    $image_id = get_post_thumbnail_id($slider_post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
				}
?>
				<a href="<?php echo get_permalink($slider_post->ID); ?>" title="<?php echo $slider_post->post_title; ?>">
					<div class="main_post" style="background-image:url('<?php echo $image_thumb[0]; ?>');background-position: center top;background-repeat: repeat;">
						<div class="post_title">
							<h3><?php echo $slider_post->post_title; ?></h3>
							<div class="slider_date"><?php echo date(THEMEDATEFORMAT, strtotime($slider_post->post_date)); ?></div>
						    <div class="read_full"><?php _e( 'Read Full Story', THEMEDOMAIN ); ?></div>	
						</div>
					</div>
				</a>
<?php				
				$get_main_ft = FALSE;
			}
			else
			{
				if(has_post_thumbnail($slider_post->ID, 'large'))
				{
				    $image_id = get_post_thumbnail_id($slider_post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
				}
?>			
				<a href="<?php echo get_permalink($slider_post->ID); ?>" title="<?php echo $slider_post->post_title; ?>">
					<div class="sub_post" style="background-image:url('<?php echo $image_thumb[0]; ?>');background-position: center top;background-repeat: repeat;">
						<div class="post_title"><h4><?php echo $slider_post->post_title; ?></h4></div>
					</div>
				</a>
<?php
			}
?>

<?php
			if($count%3==0)
			{
				$get_main_ft = TRUE;
?>
				</li>
<?php
			}
			
			$count++;
		}
?>			</ul>
		</div>
	</div>
<?php
	}
}
?>