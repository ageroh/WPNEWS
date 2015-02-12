<?php header("content-type: application/x-javascript"); ?> 
<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
?>

$j(document).ready(function() {
	$j('form#contact_form').submit(function() {
		$j('form#contact_form .error').remove();
		var hasError = false;
		$j('.required_field').each(function() {
			if(jQuery.trim($j(this).val()) == '') {
				var labelText = $j(this).prev('label').text();
				$j('#reponse_msg ul').append('<li class="error"><?php echo _e( 'Please enter', THEMEDOMAIN ); ?> '+labelText+'.</li>');
				hasError = true;
			} else if($j(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim($j(this).val()))) {
					var labelText = $j(this).prev('label').text();
					$j('#reponse_msg ul').append('<li class="error"><?php echo _e( 'Please enter valid', THEMEDOMAIN ); ?> '+labelText+'.</li>');
					hasError = true;
				}
			}
		});
		if(!hasError) {
			$j('#contact_submit_btn').fadeOut('normal', function() {
				$j(this).parent().append('<img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" alt="Loading" />');
			});
			
			var siteBaseURL = $j('#pp_homepage_url').val();
			var actionUrl = siteBaseURL+"/wp-admin/admin-ajax.php";

			$j.ajax({
			    type: 'GET',
			    url: actionUrl,
			    data: $j('#contact_form').serialize(),
			    success: function(results){
			    	$j('#contact_form').hide();
			    	$j('#reponse_msg').html(results);
			    }
			});
		}
		
		return false;
		
	});
});