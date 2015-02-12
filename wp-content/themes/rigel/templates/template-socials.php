<div class="social_wrapper">
    <ul>
    	<?php
    		$pp_facebook_username = get_option('pp_facebook_username');
    		
    		if(!empty($pp_facebook_username))
    		{
    	?>
    	<li class="facebook"><a target="_blank" title="Facebook" href="http://facebook.com/<?php echo $pp_facebook_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/facebook.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_twitter_username = get_option('pp_twitter_username');
    		
    		if(!empty($pp_twitter_username))
    		{
    	?>
    	<li class="twitter"><a target="_blank" title="Twitter" href="http://twitter.com/<?php echo $pp_twitter_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/twitter.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_flickr_username = get_option('pp_flickr_username');
    		
    		if(!empty($pp_flickr_username))
    		{
    	?>
    	<li class="flickr"><a target="_blank" title="Flickr" href="http://flickr.com/people/<?php echo $pp_flickr_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/flickr.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_youtube_username = get_option('pp_youtube_username');
    		
    		if(!empty($pp_youtube_username))
    		{
    	?>
    	<li class="youtube"><a target="_blank" title="Youtube" href="http://youtube.com/channel/<?php echo $pp_youtube_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/youtube.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_vimeo_username = get_option('pp_vimeo_username');
    		
    		if(!empty($pp_vimeo_username))
    		{
    	?>
    	<li class="vimeo"><a target="_blank" title="Vimeo" href="http://vimeo.com/<?php echo $pp_vimeo_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/vimeo.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_tumblr_username = get_option('pp_tumblr_username');
    		
    		if(!empty($pp_tumblr_username))
    		{
    	?>
    	<li class="tumblr"><a target="_blank" title="Tumblr" href="http://<?php echo $pp_tumblr_username; ?>.tumblr.com"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/tumblr.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_google_username = get_option('pp_google_username');
    		
    		if(!empty($pp_google_username))
    		{
    	?>
    	<li class="google"><a target="_blank" title="Google+" href="<?php echo $pp_google_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/google.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_dribbble_username = get_option('pp_dribbble_username');
    		
    		if(!empty($pp_dribbble_username))
    		{
    	?>
    	<li class="dribbble"><a target="_blank" title="Dribbble" href="http://dribbble.com/<?php echo $pp_dribbble_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/dribbble.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
    		$pp_linkedin_username = get_option('pp_linkedin_username');
    		
    		if(!empty($pp_linkedin_username))
    		{
    	?>
    	<li class="linkedin"><a target="_blank" title="Linkedin" href="<?php echo $pp_linkedin_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/linkedin.png" alt=""/></a></li>
    	<?php
    		}
    	?>
    	<?php
            $pp_pinterest_username = get_option('pp_pinterest_username');
            
            if(!empty($pp_pinterest_username))
            {
        ?>
        <li class="pinterest"><a target="_blank" title="Pinterest" href="http://pinterest.com/<?php echo $pp_pinterest_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/pinterest.png" alt=""/></a></li>
        <?php
            }
        ?>
        <?php
        	$pp_instagram_username = get_option('pp_instagram_username');
        	
        	if(!empty($pp_instagram_username))
        	{
        ?>
        <li class="instagram"><a target="_blank" title="Instagram" href="http://instagram.com/<?php echo $pp_instagram_username; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/social_black/instagram.png" alt=""/></a></li>
        <?php
        	}
        ?>
    </ul>
</div>