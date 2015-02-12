<?php if( comments_open() ) : 
	$pp_single_layout = get_option('pp_single_layout');
?> 
<div class="comment_inner <?php echo $pp_single_layout; ?>">
	<?php
	if ( post_password_required() ) { ?>
		<p><?php _e( 'This post is password protected. Enter the password to view comments.', THEMEDOMAIN ); ?></p>
	<?php
		return;
	}
	?>
	<?php
		if(get_comments_number() > 0)
		{
	?>
	<br/><br/><h5 class="header_line subtitle"><span><?php comments_number(__('0 Comment', THEMEDOMAIN), __('1 Comment', THEMEDOMAIN), __('% Comments', THEMEDOMAIN)); ?></span></h5>
	<?php
		}
	?>
	
	<?php
	if( have_comments() ) : ?> 
		<?php wp_list_comments( array('callback' => 'pp_comment', 'avatar_size' => '50') ); ?>
	<?php endif; ?>  
	
	
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
				<div class="pagination"><p><?php previous_comments_link(); ?> <?php next_comments_link(); ?></p></div><br class="clear"/><div class="line"></div><br/><br/>
	<?php endif; // check for comment navigation ?>
	
	<br class="clear"/>
</div>
<?php endif; ?>