<?php
    //Get social media sharing option
    $pp_social_sharing = get_option('pp_social_sharing');
    
    if(!empty($pp_social_sharing))
    {
?>
<?php
	$pin_thumb = wp_get_attachment_image_src($post->ID, 'gallery_4', true);
    if(!isset($pin_thumb[0]))
    {
	    $pin_thumb[0] = '';
    }
?>
<h5 class="share_label">
<?php _e('Share On', THEMEDOMAIN); ?>
</h5>
<div id="social_share_wrapper">
	<ul>
		<li>
			<a class="facebook_share" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"><i class="fa fa-facebook social_icon"></i></a>
		</li>
		<li>
			<a class="twitter_share" target="_blank" href="https://twitter.com/intent/tweet?original_referer=<?php echo urlencode(get_permalink()); ?>&url=<?php echo urlencode(get_permalink()); ?>"><i class="fa fa-twitter social_icon"></i></a>
		</li>
		<li>
			<a class="pinterest_share" target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode($pin_thumb[0]); ?>"><i class="fa fa-pinterest social_icon"></i></a>
		</li>
		<li>
			<a class="google_share" target="_blank" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>"><i class="fa fa-google-plus social_icon"></i></a>
		</li>
		<li>
			<a class="linkedin_share" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>"><i class="fa fa-linkedin social_icon"></i></a>
		</li>
		<li>
			<a class="tumblr_share" target="_blank" href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>"><i class="fa fa-tumblr social_icon"></i></a>
		</li>
		<li>
			<a class="email_share" target="_blank" href="mailto:?subject=<?php echo get_the_title(); ?>&amp;body=<?php echo urlencode(get_permalink()); ?>"><i class="fa fa-envelope social_icon"></i></a>
		</li>
	</ul>
</div>
<br class="clear"/>
<?php
    }
?>