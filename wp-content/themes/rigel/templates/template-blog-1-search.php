<?php
//Check if include from custom category page
global $page_cat;
	
if(!empty($page_cat))
{
	//Get current page number
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	global $wp_query;
	global $more;
	$more = 0;
	
	$query_string = 'paged='.$paged.'&orderby=date&order=DESC';
	
	if(isset($page_cat) && !empty($page_cat))
	{
		$query_string .= '&cat='.$page_cat;
	}
	query_posts($query_string);
}

$count = 0;
$num_of_posts = $wp_query->post_count;
if (have_posts()) : while (have_posts()) : the_post();
    $count++;
    $image_thumb = '';
    							
    if(has_post_thumbnail(get_the_ID(), 'thumbnail'))
    {
        $image_id = get_post_thumbnail_id(get_the_ID());
        $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
    }
?> 
<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" class="element animated<?php echo $count; ?> search_item" style="<?php if($count==1) { ?>padding-top:0;<?php } ?> <?php if($count == $num_of_posts) { ?>border:0;<?php } ?> <?php if(empty($image_thumb)) { ?>width:100%<?php }?>">
	<div class="search_thumb_wrapper">
		<?php
    		if(!empty($image_thumb))
    		{
    	?>
    	<div class="half post_circle_thumb search_thumb">
	    	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
	    	    <img src="<?php echo $image_thumb[0]; ?>" alt="" class="entry_post"/>
	    	    <?php
				    //Get Post review score
				    $post_review_score = get_review_score($post->ID);
				    if($post_review_score>10)
				    {
				    	$post_review_score = ($post_review_score/100)*10;
				    }
				    
				    if(!empty($post_review_score))
				    {
				?>
				    	<div class="review_score_bg"><?php echo $post_review_score;?></div>
				<?php
				    }
				?>
	    	</a>
    	</div>
	    <?php
	        }
	    ?>
	</div>
    <div class="search_content" <?php if(empty($image_thumb)) { ?>style="width:100%"<?php }?>>
    	<div class="post_inner_wrapper half header">
    	<div class="post_header_wrapper half">
    		<div class="post_header half">
    			<h4>
    				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
    			</h4>
    		</div>
    	</div>
    	<?php
            echo pp_substr(strip_tags(strip_shortcodes(get_the_content())), 120);
        ?>
    	<div class="post_detail large_space">
	    	<?php echo get_the_time(THEMEDATEFORMAT); ?>
	    	<?php
	    		/* 
				Custom: ARG. 17/02/2015 : remove post Author

	    		$author_firstname = get_the_author_meta('first_name', $post->post_author);
	    		$author_lastname = get_the_author_meta('last_name', $post->post_author);
				$author_url = get_author_posts_url($post->post_author);
				
				if(!empty($author_firstname))
				{
			?>
				<?php echo _e( 'By', THEMEDOMAIN ); ?>&nbsp;<a href="<?php echo $author_url; ?>"><?php echo $author_firstname; ?>&nbsp;<?php echo $author_lastname; ?></a>
			<?php
				}
				*/
	    	?>
	    	<?php 
	    	if(comments_open(get_the_ID()))
			{
			?>
		        <div class="post_comment_count"><a href="<?php the_permalink(); ?>"><i class="fa fa-comments-o"></i><?php comments_number(__('0', THEMEDOMAIN), __('1', THEMEDOMAIN), __('%', THEMEDOMAIN)); ?></a></div>
		    <?php
		    }
		    ?>
		    <?php
		    //Get post type
		    $post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
		    if(!empty($post_ft_type))
			    {
			    	switch($post_ft_type)
			    	{
			    		case 'Gallery':
			?>
			    <div class="post_type_bg"><a href="<?php the_permalink(); ?>"><i class="fa fa-picture-o"></i></a></div>
			<?php
			    		break;
			    		
			    		case 'Standard Vimeo Video':
						case 'Fullwidth Vimeo Video':
					    case 'Standard Youtube Video':
					    case 'Fullwidth Youtube Video':
					    case 'Self-Hosted Video':
			?>
			    <div class="post_type_bg"><a href="<?php the_permalink(); ?>"><i class="fa fa-video-camera"></i></a></div>
			<?php
			    		break;
			    		
			    		case 'Sound Cloud Audio':
					    case 'Self-Hosted Audio':
			?>
			    <div class="post_type_bg"><a href="<?php the_permalink(); ?>"><i class="fa fa-music"></i></a></div>
			<?php
			    		break;
			    	}
			    }
			?>
	    </div>
	    
    	</div>
    </div>
</div>
<!-- End each blog post -->

<?php endwhile; ?>
<?php endif; ?>