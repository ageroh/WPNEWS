var $j = jQuery.noConflict();

this.imagePreview = function(){	
	/* CONFIG */
		
		xOffset = 0;
		yOffset = 0;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	$j("a.preview").hover(function(e){
		this.t = this.title;
		this.title = "";	
		var this_name = $j(this).attr('data-name');
		var c = (this.t != "") ? "<br/>" + this.t : "";
		$j("#option_wrapper").append("<p id='preview'><img src='"+ this_name +"' alt='Image preview' style='z-index:999999' />"+ c +"</p>");								 
		$j("#preview")
			.css("top",(e.pageY - 50) + "px")
			.css("left",(e.pageX - 20) + "px")
			.fadeIn("fast");						
    },
	function(){
		this.title = this.t;	
		$j("#preview").remove()
    });		
    
    $j("a.preview").mousemove(function(e){
		$j("#preview")
			.css("top",(e.pageY - 50) + "px")
			.css("left",(e.pageX - 20) + "px");
	});	
};

$j.fn.setNav = function(){
	$j('#main_menu li ul').css({display: 'none'});

	$j('#main_menu li').each(function()
	{	
		var $jsublist = $j(this).find('ul:first');
		
		$j(this).hover(function()
		{	
			position = $j(this).position();
			
			$jsublist.stop().css({height:'auto', display:'none'}).fadeIn(200);
		},
		function()
		{	
			$jsublist.stop().css({height:'auto', display:'none'});	
		});

	});
}

$j.fn.setSecondNav = function(){
	
	$j('#second_menu li ul').css({display: 'none'});

	$j('#second_menu li').each(function()
	{
		
		var $jsublist = $j(this).find('ul:first, .mega_menu_wrapper:first');
		
		$j(this).hover(function()
		{	
			$jsublist.stop().css({height:'auto', display:'none', visibility: 'visible'}).fadeIn(200);
		},
		function()
		{	
			$jsublist.stop().css({height:'auto', display:'none'});
		});		
		
	});
	
	$j('#second_menu > li').each(function()
	{
		$j(this).hover(function()
		{	
			$j(this).find('a:first').addClass('hover');
		},
		function()
		{	
			$j(this).find('a:first').removeClass('hover');
		});	
		
	});
}

$j(document).ready(function(){ 

	$j(document).setNav();
	
	$j(document).setSecondNav();

	$j(".swipebox, .lightbox_image, .img_frame, .flickr li a").swipebox();
	
	$j('#post_gallery_bg').click(function(){
		$j('#post_img1').trigger('click');
	});
	
	$j('#post_vimeo_video_bg, #post_youtube_video_bg, #post_self-hosted_video_bg').click(function(){
		$j(this).addClass('play');
		$j('.post_type_bg.single').hide();
		$j('#page_caption').hide();
		$j('.post_type_bg_mask').hide();
		
		$j('#post_video_wrapper').show();
	});
	
	if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version < 8)
	{
		var zIndexNumber = 1000;
		$j('div').each(function() {
			$j(this).css('zIndex', zIndexNumber);
			zIndexNumber -= 10;
		});

		$j('#thumbNav').css('zIndex', 1000);
		$j('#thumbLeftNav').css('zIndex', 1000);
		$j('#thumbRightNav').css('zIndex', 1000);
		$j('#fancybox-wrap').css('zIndex', 1001);
		$j('#fancybox-overlay').css('zIndex', 1000);
	}
	
	$j('.thumb li a').tipsy({fade: false, gravity: 's'});
	
	$j('.social_media ul li a').tipsy({fade: true});
	
	$j('input[title!=""]').hint();
	
	$j('textarea[title!=""]').hint();
	
	var siteBaseURL = $j('#pp_homepage_url').val();
	if($j('#pp_blog_ajax_search').val() != '')
    {
		$j('#s').on('input', function() {
			$j.ajax({
				url:siteBaseURL+"/wp-admin/admin-ajax.php",
				type:'POST',
				data:'action=pp_ajax_search&s='+$j('#s').val(),
				success:function(results) {
					$j("#autocomplete").html(results);
				}
			})
		});
		
		$j('#s').focus(function(){
	      $j("#autocomplete").fadeIn();
		});
		
		$j('#s').blur(function(){
	      $j("#autocomplete").fadeOut();
		});
	}
 
	$j('#toTop').click(function() {
		$j('body,html').animate({scrollTop:0},800);
	});
	
	var iframes = document.getElementsByTagName('iframe');
    
    for (var i = 0; i < iframes.length; i++) {
        var iframe = iframes[i];
        var players = /www.youtube.com|player.vimeo.com/;
        if(iframe.src.search(players) !== -1) {
            var videoRatio = (iframe.height / iframe.width) * 100;
            
            iframe.style.position = 'absolute';
            iframe.style.top = '0';
            iframe.style.left = '0';
            iframe.width = '100%';
            iframe.height = '100%';
            
            var div = document.createElement('div');
            div.className = 'video-wrap';
            div.style.width = '100%';
            div.style.position = 'relative';
            div.style.paddingTop = videoRatio + '%';
            
            var parentNode = iframe.parentNode;
            parentNode.insertBefore(div, iframe);
            div.appendChild(iframe);
        }
    }
    
    $j('#header_wrapper #searchform input').focus(function()
	{
	    $j(this).attr('data-default', $j(this).width());
	    $j(this).animate({ width: 150 });
	}).blur(function()
	{
	    var w = $j(this).attr('data-default');
	    $j(this).animate({ width: w });
	});
	
	$j('video#single_post_video,audio#single_post_audio').mediaelementplayer();
	
	$j(window).scroll(function(){
		if($j(this).scrollTop() >= 100){
			$j('#second_menu').addClass('fixed');
			$j('#breaking_wrapper').addClass('fixed');
			$j('#wrapper .menu-secondary-menu-container').addClass('fixed');
	    }
	    else if($j(this).scrollTop() < 100)
	    {
		    $j('#second_menu').removeClass('fixed');
		    $j('#breaking_wrapper').removeClass('fixed');
		    $j('#wrapper .menu-secondary-menu-container').removeClass('fixed');
	    }
	});
	
	$j('#mobile_nav_icon').click(function() {
		$j('body,html').animate({scrollTop:0},100);
		$j('body').toggleClass('js_nav');
	});
	
	$j('#close_mobile_menu').click(function() {
		$j('body').removeClass('js_nav');
	});
	
	$j('#footer .sidebar_widget > li:nth-child(3n)').addClass('nth-child-3n');
	$j('.second_nav li .mega_menu_wrapper ul.sidebar_widget > li:nth-child(4n)').addClass('nth-child-4n');
	$j('.second_nav li .mega_menu_wrapper ul.sidebar_widget > li:nth-child(5n)').addClass('nth-child-5n');
    
    $j('#breaking_new').smarticker({
	    animation: 'slide',
	    pausetime: 5000
    });
	
	if (!"ontouchstart" in document.documentElement)
	{
		$j('div[data-type="background"]').each(function(){
	       var bgobj = $j(this);
	    
	       $j(window).scroll(function() {
	           var yPos = -($j(window).scrollTop() / bgobj.data('speed')); 
	            
	           var coords = '50% '+ yPos + 'px';
	 
	           bgobj.css({ backgroundPosition: coords });
	       }); 
	    });
    }
    
    $j('.review_point').each(function(){
       $j(this).animate({'width':$j(this).data('score')+'%', 'opacity':1}, 600);
    });
    
    var siteBaseURL = $j('#pp_homepage_url').val();
    
    $j('.cat_filter li a').click(function(){
    	var targetWrapper = $j(this).data('wrapper');
    	$j('#'+targetWrapper).html('');
    	$j('#'+targetWrapper).addClass('ppb_filter_loading');
    
	    $j(this).parent('li').parent('ul').children('li').children('a').removeClass('selected');
	    $j(this).addClass('selected');
	    
	    $j.ajax({
		    url:siteBaseURL+"/wp-admin/admin-ajax.php",
		    type:'POST',
		    data:'action=pp_ajax_filter_blog&cat='+$j(this).data('category')+'&current_template='+$j(this).data('template')+'&items='+$j(this).data('items'),
		    success:function(results) {
		    	$j('#'+targetWrapper).removeClass('ppb_filter_loading').html(results).show();
		    	
		    	$j('.entry_post').each(function() {
					$j(this).addClass('slideUp');
				});
		    }
		})
	    
	    return false;
	});
	
});

jQuery(window).load(function() {
	var post_carousel_column = $j('#post_carousel_column').val();
	var post_carousel_column_width = 227;

    if (typeof post_carousel_column == 'undefined')
    {
	    post_carousel_column = 4;
	    var post_carousel_column_width = 227;
    }
    
    if(post_carousel_column == 4)
    {
	    var post_carousel_column_width = 227;
    }
    
    if($j(window).width() <= 768 && $j(window).width() > 480)
    {
    	post_carousel_column = 2;
	    var post_carousel_column_width = 353;
    }
    else if($j(window).width() < 768 && $j(window).width() >= 480)
    {
	    post_carousel_column = 1;
	    var post_carousel_column_width = 440;
    }
    else if($j(window).width() < 480)
    {
	    post_carousel_column = 1;
	    var post_carousel_column_width = 300;
    }

    $j('.post_carousel').flexslider({
	      animation: "slide",
	      animationLoop: false,
	      itemWidth: post_carousel_column_width,
	      itemMargin: 0,
	      slideshow: false,
	      controlNav: false,
	      itemMargin: 20,
	      move: 1
	});
    
    var sliderAuto = '';
    if($j('#pp_slider_auto').val()=="true")
    {
		sliderAuto = true;
    }
    else
    {
	    sliderAuto = false;
    }
    
    var sliderTimer = '';
    if($j('#pp_slider_timer').val()!="")
    {
		sliderTimer = parseInt($j('#pp_slider_timer').val()*1000);
    }
    else
    {
	    sliderTimer = 7000;
    }
    
    var pageSliderHeight = $j('#page_slider').data('height');

    $j('#page_slider').flexslider({
	      animation: "fade",
	      animationLoop: true,
	      itemMargin: 0,
	      minItems: 1,
	      maxItems: 1,
	      slideshow: false,
	      controlNav: false,
	      slideshow: sliderAuto,
	      slideshowSpeed: sliderTimer,
	      move: 1,
	      start: function(){
	      		$j('#page_slider').addClass('visible');
		  		$j('#page_slider').animate({'height': pageSliderHeight+'px'}, 1000, "easeInOutQuart");
		  }
	});
	
	$j('.slider_widget_wrapper').flexslider({
	      animation: "slide",
	      animationLoop: false,
	      itemMargin: 0,
	      minItems: 1,
	      maxItems: 1,
	      slideshow: false,
	      controlNav: false,
	      slideshow: false,
	      slideshowSpeed: sliderTimer,
	      move: 1,
	      start: function(){
	      		$j('.slider_widget_wrapper').find('.post_slideshow_widget').css('display', 'block');
		  		$j('.slider_widget_wrapper').animate({'height': 'auto'}, 1000, "easeInOutQuart");
		  }
	});
	
	$j('.slider_wrapper').flexslider({
	      animation: "fade",
	      animationLoop: true,
	      itemMargin: 0,
	      minItems: 1,
	      maxItems: 1,
	      slideshow: false,
	      controlNav: false,
	      smoothHeight: true,
	      move: 1
	});
	
	$j('#wrapper').waypoint(function(direction) {
		$j('#post_more_wrapper').toggleClass('hiding', direction === "up");
	}, {
		offset: function() {
			return $j.waypoints('viewportHeight') - $j(this).height() + 100;
		}
	});
	
	if($j(window).width() <= 768)
    {
    	$j('.entry_post').addClass('slideUp');
    }
	
	var screenOffset = '40%';
	if($j(window).height() > 1000)
	{
	    var screenOffset = '55%';
	}
	if($j('#page_slider').length == 0)
	{
		if($j(window).height() > 1000)
		{
		    var screenOffset = '85%';
		}
		else
		{
			var screenOffset = '82%';
		}
	}

	$j('.entry_post').waypoint(function(direction) {
		$j(this).addClass('slideUp', direction === 'down');
	} , { offset: screenOffset });
	
	$j('#post_more_close').click(function(){
		$j('#post_more_wrapper').animate({ right: '-360px' }, 300);
		
		return false;
	});
	
	$j('#review_circle').circliful();
	
	var input = document.createElement("input");
 
	if(('placeholder' in input) == false) { 
	  $j('[placeholder]')
	  .each(function(){
	    var i = $j(this);  
	    if(i.val() == '' || i.val() == i.attr('placeholder')) {
	      if(this.type=='password') {
	        i.addClass('password');
	        this.type='text';
	      }
	      i.addClass('placeholder').val(i.attr('placeholder'));
	    }
	  })
	  .focus(function() {
	    var i = $j(this);
	    if(i.val() == i.attr('placeholder')) {
	      i.val('').removeClass('placeholder');
	      if(i.hasClass('password')) {
	        i.removeClass('password');
	        this.type='password';
	      }     
	    }
	  })
	  .blur(function() {
	    var i = $j(this);  
	    if(i.val() == '' || i.val() == i.attr('placeholder')) {
	      if(this.type=='password') {
	        i.addClass('password');
	        this.type='text';
	      }
	      i.addClass('placeholder').val(i.attr('placeholder'));
	    }
	  })
	  .parents('form').submit(function() {
	    $j(this).find('[placeholder]').each(function() {
	      var i = $j(this);
	      if(i.val() == i.attr('placeholder'))
	        i.val('');
	    })
	  });
	}
	
	$j('#option_btn').click(
    	function() {
    		if($j('#option_wrapper').css('left') != '0px')
    		{
 				$j('#option_wrapper').animate({"left": "0px"}, { duration: 500 });
	 			$j(this).animate({"left": "200px"}, { duration: 500 });
	 		}
	 		else
	 		{
	 			$j('#option_wrapper').animate({"left": "-210px"}, { duration: 500 });
    			$j('#option_btn').animate({"left": "-2px"}, { duration: 500 });
	 		}
    	}
    );
    
    $j('#pp_layout').change(function() {
		$j("form#form_option").submit();
	});
});