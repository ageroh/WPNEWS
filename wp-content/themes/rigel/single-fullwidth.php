<?php
/**
 * The main template file for display single post page fullwidth.
 *
 * @package WordPress
*/

get_header(); 

//Get post's featured content type
$post_ft_type = get_post_meta($post->ID, 'post_ft_type', true);
if(empty($post_ft_type))
{
	$post_ft_type = 'Standard Image';
}

//Cehck if enable post featured image
$pp_blog_single_ft_image = get_option('pp_blog_single_ft_image');
?>
<!-- Begin content -->
<div id="content_wrapper">
    <div class="inner">
    	<?php 
			$getCatID = get_parent_or_child_category( get_the_ID() );
			switch ($getCatID) {
				case '11':
					get_template_part( 'single' , 'sports' );
					break;

				case '5':
					get_template_part( 'single' , 'politikh' );
					break;
				
				default:
					# code...
					break;
			}

		?>
    	<!-- Begin main content -->
    	<div class="inner_wrapper fullwidth">
    			<?php
			     switch($post_ft_type)
			     {
			     	case 'Fullwidth Image':
			         	$image_thumb = '';
											
						if(!empty($pp_blog_single_ft_image) && has_post_thumbnail(get_the_ID(), 'blog_single_full'))
						{
						    $image_id = get_post_thumbnail_id(get_the_ID());
						    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_single_full', true);
						}
				?>
				<?php
				        if(!empty($image_thumb))
				        {
				?>
					    <div class="post_img fullwidth" style="width:<?php echo $image_thumb[1]; ?>px;height:<?php echo $image_thumb[2]; ?>px">
					        <img src="<?php echo $image_thumb[0]; ?>" alt="" class="entry_post"/>
					    </div>
				<?php
				        }
				     break;
			     	
			         case 'Fullwidth Vimeo Video':
			         	$post_ft_vimeo = get_post_meta($post->ID, 'post_ft_vimeo', true);
			?>
			         <iframe src="//player.vimeo.com/video/<?php echo $post_ft_vimeo; ?>?title=0&amp;byline=0&amp;portrait=0" width="960" height="539" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe><br class="clear"/>
			         
			<?php
			         break;
			         
			         case 'Fullwidth Youtube Video':
			         	$post_ft_youtube = get_post_meta($post->ID, 'post_ft_youtube', true);
			?>
			         <iframe width="960" height="540" src="//www.youtube.com/embed/<?php echo $post_ft_youtube; ?>?wmode=transparent&amp;rel=0&amp;autohide=1&amp;egm=0&amp;hd=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;showinfo=0&amp;showsearch=0" frameborder="0" allowfullscreen wmode="Opaque"></iframe><br class="clear"/>
			<?php
			         break;
			         
			         case 'Standard Image':
			         	$image_thumb = '';
											
						if(!empty($pp_blog_single_ft_image) && has_post_thumbnail(get_the_ID(), 'blog_single_full'))
						{
						    $image_id = get_post_thumbnail_id(get_the_ID());
						    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_single_full', true);
						}
				?>
				<?php
				        if(!empty($image_thumb))
				        {
				?>
					    <div class="post_img fullwidth" style="width:<?php echo $image_thumb[1]; ?>px;height:<?php echo $image_thumb[2]; ?>px;margin-bottom:10px;">
					        <img src="<?php echo $image_thumb[0]; ?>" alt="" class="entry_post"/>
					    </div>
				<?php
				        }
				    break;
				    
				    // Custom. ARG. 17/02/2015: add custom image template for articles which have Youtube/Vimeo related video
				    // 							show video normal size in the end of Content along with the image of Article.   
				    case 'Custom NEWS':
			         	$image_thumb = '';
											
						if(!empty($pp_blog_single_ft_image) && has_post_thumbnail(get_the_ID(), 'blog_single_full'))
						{
						    $image_id = get_post_thumbnail_id(get_the_ID());
						    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_single_full', true);
						}
				?>
				<?php
				        if(!empty($image_thumb))
				        {
				?>
					    <div class="post_img fullwidth" style="width:<?php echo $image_thumb[1]; ?>px;height:<?php echo $image_thumb[2]; ?>px">
					        <img src="<?php echo $image_thumb[0]; ?>" alt="" class="entry_post"/>
					    </div>
				<?php
				        }
				     break;
					
					case 'Standard Vimeo Video':
			         	$post_ft_vimeo = get_post_meta($post->ID, 'post_ft_vimeo', true);
			?>
			         <iframe src="//player.vimeo.com/video/<?php echo $post_ft_vimeo; ?>?title=0&amp;byline=0&amp;portrait=0" width="960" height="539" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe><br class="clear"/>
			         
				<?php
			         break;
			         
			         case 'Standard Youtube Video':
			         	$post_ft_youtube = get_post_meta($post->ID, 'post_ft_youtube', true);
			?>
			         <iframe width="960" height="540" src="//www.youtube.com/embed/<?php echo $post_ft_youtube; ?>?wmode=transparent&amp;rel=0&amp;autohide=1&amp;egm=0&amp;hd=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;showinfo=0&amp;showsearch=0" frameborder="0" allowfullscreen wmode="Opaque"></iframe><br class="clear"/>
			<?php
			         break;
			         
			         case 'Self-Hosted Video':
			         	$post_ft_video = get_post_meta($post->ID, 'post_ft_video', true);
			         	
			         	if(!empty($post_ft_video))
			         	{
			         		if(has_post_thumbnail(get_the_ID(), 'blog_ft'))
			         		{
			         		    $image_id = get_post_thumbnail_id(get_the_ID());
			         		    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
			         		}
			?>
			  
			 <?php    			
			         		if(!empty($post_ft_video))
			         		{
			         			echo do_shortcode('[video width="960" video_src="'.$post_ft_video.'" img_src="'.$image_thumb[0].'"]<br class="clear"/>');
			         		}
			         	}
			         break;
			         
			          case 'Sound Cloud Audio':
    		
			         	$post_ft_sound_cloud = get_post_meta($post->ID, 'post_ft_sound_cloud', true); 
			         	
			         	if(!empty($post_ft_sound_cloud))
			         	{
			         		if(has_post_thumbnail(get_the_ID(), 'blog_single_full'))
			         		{
			         		    $image_id = get_post_thumbnail_id(get_the_ID());
			         		    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_single_full', true);
			         		}
				?>
				<?php
				        if(!empty($image_thumb))
				        {
				?>
					    <div class="post_img main_img" style="width:<?php echo $image_thumb[1]; ?>px;height:<?php echo $image_thumb[2]; ?>px">
					        <img src="<?php echo $image_thumb[0]; ?>" alt="" class=""/>
					    </div>
				<?php
				        }
			         		echo '<div class="post_sound_cloud_wrapper">'.$post_ft_sound_cloud.'</div><br class="clear"/>';
			         	}
			         break;
			         
			         case 'Self-Hosted Audio':
			             
			         	$post_ft_audio = get_post_meta($post->ID, 'post_ft_audio', true); 
			         	
			         	if(!empty($post_ft_audio))
			         	{
			         		if(has_post_thumbnail(get_the_ID(), 'blog_single_full'))
			         		{
			         		    $image_id = get_post_thumbnail_id(get_the_ID());
			         		    $image_thumb = wp_get_attachment_image_src($image_id, 'blog_single_full', true);
			         		}
			         		
			         		if(!empty($image_thumb))
					 		{
				?>
						    <div class="post_img main_img" style="width:<?php echo $image_thumb[1]; ?>px;height:<?php echo $image_thumb[2]; ?>px">
						        <img src="<?php echo $image_thumb[0]; ?>" alt="" class=""/>
						    </div>
				<?php
			         		}		
			         		echo '<div class="post_audio_wrapper"><audio id="single_post_audio" src="'.$post_ft_audio.'" type="audio/mp3" controls="controls" width="960"></audio></div><br class="clear"/>';
			         	}
			         break;
			         
			         case 'Gallery':
			         	$post_ft_gallery = get_post_meta(get_the_ID(), 'post_ft_gallery', true);
			         	echo do_shortcode('[tg_gallery_slider gallery_id="'.$post_ft_gallery.'" width="620" height="342"]');
			         	
			         break;
			     }
				?>
    			<div class="post_header_wrapper">
					<h1 class="post_title">
					<?php
					    the_title();
					?>
					</h1>
					<h2 class="subtitle">
					<?php
						// A.GEROGIANNIS ADD BOX Subtitle
						echo get_post_meta($post->ID,'_subtitle_Custom', true);
					?>
					</h2>
				</div>
				<div class="post_detail">
			    	<?php echo get_the_time(THEMEDATEFORMAT); ?>&nbsp;
						
					<?php 
						/* Custom: ARG. 17/02/2015 : show category link */
						echo show_parent_or_child_category(get_the_ID());
					?>

			    	<?php /* Remove Editor Name from Articles 
			    	 	Custom: ARG. 17/02/2015 : show category link 

			    		$author_firstname = get_the_author_meta('first_name', $post->post_author);
			    		$author_lastname = get_the_author_meta('last_name', $post->post_author);
						$author_url = get_author_posts_url($post->post_author);
						
						if(!empty($author_firstname))
						{
					?>
						<?php echo _e( 'By', THEMEDOMAIN ); ?>&nbsp;<a href="<?php echo $author_url; ?>"><?php echo $author_firstname; ?>&nbsp;<?php echo $author_lastname; ?></a>
					<?php
						}
			    	*/ ?>

			    	<?php 
			    	if(comments_open(get_the_ID()))
					{
					?>
				        <div class="post_comment_count"><i class="fa fa-comments-o"></i><?php comments_number(__('0', THEMEDOMAIN), __('1', THEMEDOMAIN), __('%', THEMEDOMAIN)); ?></div>
				    <?php
				    }
				    ?>
				    <?php
				    //Get post type
				    $post_ft_type = get_post_meta(get_the_ID(), 'post_ft_type', true);
				    if(!empty($post_ft_type))
					    {
					    	switch($post_ft_type)
					    	{
					    		case 'Gallery':
					?>
					    <div class="post_type_bg"><i class="fa fa-picture-o"></i></div>
					<?php
					    		break;
					    		
					    		case 'Standard Vimeo Video':
								case 'Fullwidth Vimeo Video':
					    		case 'Standard Youtube Video':
					    		case 'Fullwidth Youtube Video':
					    		case 'Self-Hosted Video':
					?>
					    <div class="post_type_bg"><i class="fa fa-video-camera"></i></div>
					<?php
					    		break;	
					    		
					    		case 'Sound Cloud Audio':
					    		case 'Self-Hosted Audio':
					?>
						<div class="post_type_bg"><i class="fa fa-music"></i></div>
					<?php
					    		break;
					    	}
					    }
					?>
			    </div>
    			<br class="clear"/><br/>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<!-- Begin each blog post -->
						<div class="post_wrapper" style="padding-top:0;">
							<div class="post_inner_wrapper">
						    	<div class="post_wrapper_inner">
									<div class="post_inner_wrapper">
								        
										<?php the_content(); ?>
										<?php 
										// Custom. ARG. 17/02/2015
										// Add iframe video related to article if exists.
										if( $post_ft_type == 'Custom NEWS')
										{

			         						$post_ft_vimeo = get_post_meta($post->ID, 'post_ft_vimeo', true);
			         						if( $post_ft_vimeo != null)
			         						{
			         							?>
			         							<iframe src="//player.vimeo.com/video/<?php echo $post_ft_vimeo; ?>?title=0&amp;byline=0&amp;portrait=0" width="620" height="349" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			         							<?php
			         						}

											$post_ft_youtube = get_post_meta($post->ID, 'post_ft_youtube', true);
			         						if( $post_ft_youtube != null)
			         						{
			         							?>
			         							<iframe width="620" height="349" 
			         								src="//www.youtube.com/embed/<?php echo $post_ft_youtube; ?>?wmode=transparent&amp;rel=0&amp;autohide=1&amp;egm=0&amp;hd=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;showinfo=0&amp;showsearch=0" frameborder="0" allowfullscreen wmode="Opaque"></iframe>
			         							<?php
			         						}
			         					}
										?>

										<div style="height:15px;"></div>
										
										<?php
											//Get Post's Tags
											$pp_blog_tags = get_option('pp_blog_tags');
											
											if(!empty($pp_blog_tags))
											{
												the_tags('<div class="post_tag"><i class="fa fa-tags"></i>', '', '</div>'); 
											}
										?>
										
										<?php
											//Get Post's Categories
											$pp_blog_categories = get_option('pp_blog_categories');
								    		$post_categories = wp_get_post_categories(get_the_ID());
								    		if(!empty($pp_blog_categories) && !empty($post_categories))
											{
										?>
											<div class="post_category">
												<i class="fa fa-clipboard"></i>
										<?php
									    		foreach($post_categories as $c)
									    		{
													$cat = get_category( $c );
										?>
												<a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a>
										<?php
												}
										?>
											</div>
										<?php
											}
								    	?>
										
										<br class="clear"/><hr/>
										<?php
											//Get Social Share
											get_template_part("/templates/template-share");
										?>
										
									</div>
									
								</div>
								<!-- End each blog post -->
								
								<?php
									$pp_blog_display_author = get_option('pp_blog_display_author');
									
									if($pp_blog_display_author)
									{
										$author_url = get_author_posts_url(get_the_author_meta('ID'));
								?>
								
								<div class="post_wrapper author">
									<div class="author_wrapper_inner">
										<div id="about_the_author">
											<div class="gravatar"><a href="<?php echo $author_url; ?>"><?php echo get_avatar( get_the_author_meta('email'), '60' ); ?></a></div>
											<div class="description author">
												<h6><a href="<?php echo $author_url; ?>"><?php the_author_meta('first_name', get_the_author_meta('ID')); ?> <?php the_author_meta('last_name', get_the_author_meta('ID')); ?></a></h6>
												<?php the_author_meta('description'); ?>
												<?php
													$author_url = get_the_author_meta('user_url', get_the_author_meta('ID'));
													
													if(!empty($author_url))
													{
												?>
												<div class="website">
					    							<i class="fa fa-link"></i>
						    						<a href="<?php the_author_meta('user_url', get_the_author_meta('ID')); ?>" target="_blank"><?php the_author_meta('user_url', get_the_author_meta('ID')); ?></a>
						    					</div>
						    					<?php
						    						}
						    					?>
											</div>
										</div><br class="clear"/><br/>
									</div>
								</div>
								<br class="clear"/>
								
								<?php
									}
								?>
						</div>
						
						<?php
							$args = array(
								'before'           => '<p>' . __('Pages:', THEMEDOMAIN),
								'after'            => '</p>',
								'link_before'      => '',
								'link_after'       => '',
								'next_or_number'   => 'number',
								'nextpagelink'     => __('Next page', THEMEDOMAIN),
								'previouspagelink' => __('Previous page', THEMEDOMAIN),
								'pagelink'         => '%',
								'echo'             => 1
							);
							wp_link_pages($args);
						
						    $pp_blog_next_prev = get_option('pp_blog_next_prev');
						    
						    if($pp_blog_next_prev)
						    {
						?>
						<?php
						    	//Get Previous and Next Post
						    	$prev_post = get_previous_post();
						    	$next_post = get_next_post();
						    
						    	//If has previous or next post then add line break
						    	if(!empty($prev_post) OR !empty($next_post))
						    	{
						    		echo '<hr style="margin:0"/>';
						    	}
						?>
						<div style="position:relative;">
						   <div class="post_previous">
						      	<?php
								    //Get Previous Post
								    if (!empty($prev_post)): 
								?>
						      		<span class="post_previous_icon"><i class="fa fa-angle-left"></i></span>
						      		<div class="post_previous_content">
						      			<h6><?php echo _e( 'Previous Article', THEMEDOMAIN ); ?></h6>
						      			<strong><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a></strong>
						      		</div>
						      	<?php endif; ?>
						   </div>
						<span class="separated"></span>
						   <div class="post_next">
						   		<?php
								    //Get Next Post
								    if (!empty($next_post)): 
								?>
						      		<span class="post_next_icon"><i class="fa fa-angle-right"></i></span>
						      		<div class="post_next_content">
						      			<h6><?php echo _e( 'Next Article', THEMEDOMAIN ); ?></h6>
						      			<strong><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a></strong>
						      		</div>
							  	<?php endif; ?>
						   </div>
						</div>
						<?php
						    	//If has previous or next post then add line break
						    	if(!empty($prev_post) OR !empty($next_post))
						    	{
						    		echo '<hr style="margin:0"/><br/>';
						    	}
						?>
						<?php
						    }
						?>

						<div class="post_wrapper" style="padding-top:0">
							<div class="post_wrapper_inner">
								
								<?php
									$pp_blog_display_related = get_option('pp_blog_display_related');
									
									if($pp_blog_display_related)
									{
								?>
								
								<?php
								//for use in the loop, list 9 post titles related to post's tags on current post
								$tags = wp_get_post_tags($post->ID);

								if ($tags) {
								
									$tag_in = array();
								  	//Get all tags
								  	foreach($tags as $tags)
								  	{
									  	$tag_in[] = $tags->term_id;
								  	}

								  	$args=array(
									  	  'tag__in' => $tag_in,
									  	  'post__not_in' => array($post->ID),
									  	  'showposts' => 3,
									  	  'ignore_sticky_posts' => 1,
									  	  'orderby' => 'date',
									  	  'order' => 'DESC'
								  	 );
								  	$my_query = new WP_Query($args);
								  	$post_count = 1;
								  	
								  	if( $my_query->have_posts() ) {
								  	  	echo '<br class="clear"/><h5 class="header_line subtitle"><span>'.__( 'You might also like', THEMEDOMAIN ).'</span></h5><br class="clear"/>';
								 ?>
								  
								 	<div>
										 <?php
										 	global $have_related;
										    while ($my_query->have_posts()) : $my_query->the_post();
										    $have_related = TRUE; 
										 ?>
										    <div class="one_third <?php if($post_count%3==0) { ?>last<?php } ?>">
										    	<?php
										    		if(has_post_thumbnail($post->ID, 'blog_half_ft'))
													{
														$image_id = get_post_thumbnail_id($post->ID);
														$image_url = wp_get_attachment_image_src($image_id, 'blog_half_ft', true);
										    	?>
										    	<div class="post_img">
										    		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img class="post_ft entry_post" src="<?php echo $image_url[0]; ?>" alt="<?php the_title(); ?>"/></a>
										    	</div>
										    	<?php
										    		}
										    	?>
										    	<div class="post_header_wrapper half">
										    		<div class="post_header half">
										    			<strong class="title">
										    				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
										    			</strong>
										    		</div>
										    	</div>
										    	<div class="post_detail half">
											    	<?php echo get_the_time(THEMEDATEFORMAT); ?>&nbsp; 
													<?php 
														/* Custom: ARG. 17/02/2015 : show category link */
														echo show_parent_or_child_category(get_the_ID());
													?>

											    	<?php /* Remove Editor Name from Articles 
											    	 	Custom: ARG. 17/02/2015 : show category link 

											    		$author_firstname = get_the_author_meta('first_name', $post->post_author);
											    		$author_lastname = get_the_author_meta('last_name', $post->post_author);
														$author_url = get_author_posts_url($post->post_author);
														
														if(!empty($author_firstname))
														{
													?>
														<?php echo _e( 'By', THEMEDOMAIN ); ?>&nbsp;<a href="<?php echo $author_url; ?>"><?php echo $author_firstname; ?>&nbsp;<?php echo $author_lastname; ?></a>
													<?php
														}
											    	*/ ?>											    	
	
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
													    		case 'Youtube Video':
													    		case 'Sound Cloud Audio':
													    		case 'Self-Hosted Audio':
													    		case 'Self-Hosted Video':
													?>
													    <div class="post_type_bg"><a href="<?php the_permalink(); ?>"><i class="fa fa-video-camera"></i></a></div>
													<?php
													    		break;	
													    	}
													    }
													?>
											    </div>
											</div>
										  <?php
										  		$post_count++;
												endwhile;
												    
												wp_reset_query();
										  ?>
								    </div>
								<?php
								  	}
								}
								?>
								
								<?php
									} //end if show related
								?>
		
								<br class="clear"/>
								<?php comments_template( '' ); ?><br/>
								<?php 
									$fields =  array('comment_field' => 
								      '<p class="comment-form-comment"><textarea id="comment" placeholder="'.__( 'Comment', THEMEDOMAIN ).'" name="comment"></textarea></p>',
								
								    'comment_notes_after' => '',);
								
									comment_form($fields); 
								?>
								
								<?php wp_link_pages(); endwhile; endif; ?>
							</div>
						</div>
					</div>
				</div>
				<!-- End main content -->
				
				<br class="clear"/>
			</div>
			
		</div>
		<!-- End content -->

		<?php
			//Get More Story Module
			$pp_blog_more_story = get_option('pp_blog_more_story');
			
			if(!empty($prev_post) && !empty($pp_blog_more_story))
			{
				$post_more_image = '';
				if(has_post_thumbnail(get_the_ID(), 'blog_square'))
				{
				    $post_more_image_id = get_post_thumbnail_id($prev_post->ID);
				    $post_more_image = wp_get_attachment_image_src($post_more_image_id, 'blog_square', true);
				}
		?>
		<div id="post_more_wrapper" class="hiding">
			<a href="javascript:;" id="post_more_close"><i class="fa fa-times-circle"></i></a>
			<div class="more_story_title"><?php _e( 'More Story', THEMEDOMAIN ); ?></div>
			<div class="inner">
			<?php
				if(!empty($post_more_image))
				{
			?>
			<div class="post_more_img_wrapper">
				<a href="<?php echo get_permalink($prev_post->ID); ?>">
					<img src="<?php echo $post_more_image[0]; ?>" alt=""/>
				</a>
			</div>
			<?php
				}
			?>
			<a class="post_more_title" href="<?php echo get_permalink($prev_post->ID); ?>">
				<h7 style="display:block;"><?php echo $prev_post->post_title; ?></h7>
			</a>
			<?php echo pp_substr(strip_tags(strip_shortcodes($prev_post->post_content)), 120); ?>
			
			</div>
		</div>
		<?php
			}
		?>

<?php get_footer(); ?>