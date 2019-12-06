jQuery(document).ready(function () {

/*----------------------------------------------------*/

/*	Search box expand Section

/*----------------------------------------------------*/

	    

	jQuery(".search-text-box").focus(function(){

	   jQuery("ul.social").animate({ marginLeft: "-120px"}, 450, "easeInSine")

	});



jQuery('#lname').tooltip();

/*----------------------------------------------------*/

/*	Superfish Mainmenu Section

/*----------------------------------------------------*/

	
    jQuery(function () {

        jQuery('ul.sf-menu').stop().superfish();

    });

	





/*----------------------------------------------------*/

/*	Revolution Slider Nav Arrow Show Hide

/*----------------------------------------------------*/



    jQuery('.fullwidthbanner-container').hover(function () {

        jQuery('.tp-leftarrow').stop().animate({

            "opacity": 1

        }, 'easeIn');

        jQuery('.tp-rightarrow').stop().animate({

            "opacity": 1

        }, 'easeIn');

    }, function () {

        jQuery('.tp-leftarrow').stop().animate({

            "opacity": 0

        }, 'easeIn');

        jQuery('.tp-rightarrow').stop().animate({

            "opacity": 0

        }, 'easeIn');

    }



    );

/*----------------------------------------------------*/

/*	Accordion Section

/*----------------------------------------------------*/




 



});



jQuery(document).ready(function () {


	jQuery('.portfolio-item').hover(function () {

			jQuery(this).find( '.portfolio-item-hover' ).animate({

				"opacity": 0.8

			}, 100, 'easeInOutCubic');

			

			

		}, function () {

			jQuery(this).find( '.portfolio-item-hover' ).animate({

				"opacity": 0

			}, 100, 'easeInOutCubic');

			

	});

	

	

	jQuery('.portfolio-item').hover(function () {

       jQuery(this).find(".fullscreen").stop().animate({'top' : '60%', 'opacity' : 1}, 250, 'easeOutBack');

        

    }, function () {

        jQuery(this).find(".fullscreen").stop().animate({'top' : '65%', 'opacity' : 0}, 150, 'easeOutBack');

        

    });

	

	

	jQuery('.blog-showcase ul li').each(function () {

		jQuery(this).on('hover', function () {

			jQuery(this).siblings('li').removeClass('blog-first-el').end().addClass('blog-first-el');

		});

	});

	

	

	jQuery('.blog-showcase-thumb').hover(function () {

        jQuery(this).find( '.post-item-hover' ).animate({

            "opacity": 0.8

        }, 100, 'easeInOutCubic');

        

    }, function () {

        jQuery(this).find( '.post-item-hover' ).animate({

            "opacity": 0

        }, 100, 'easeInOutCubic');

        

    });

	



	

	jQuery('.blog-showcase-thumb').hover(function () {

       jQuery(this).find(".fullscreen").stop().animate({'top' : '57%', 'opacity' : 1}, 250, 'easeOutBack');

        

    }, function () {

        jQuery(this).find(".fullscreen").stop().animate({'top' : '65%', 'opacity' : 0}, 150, 'easeOutBack');

        

    });







/* Post Image overlay */	

	

	jQuery('.post-image').hover(function () {

        jQuery(this).find( '.img-hover' ).animate({

            "opacity": 0.8

        }, 100, 'easeInOutCubic');

		

        

    }, function () {

        jQuery(this).find( '.img-hover' ).animate({

            "opacity": 0

        }, 100, 'easeInOutCubic');

        

    });

	

	

	jQuery('.post-image').hover(function () {

       jQuery(this).find(".fullscreen").stop().animate({'top' : '55%', 'opacity' : 1}, 250, 'easeOutBack');

        

    }, function () {

        jQuery(this).find(".fullscreen").stop().animate({'top' : '65%', 'opacity' : 0}, 150, 'easeOutBack');

        

    });

	



/*Mobile device topnav opener*/

	

	jQuery( ".down-button" ).click(function() {

    jQuery( ".down-button .icon-current" ).toggleClass("icon-angle-up icon-angle-down");

});







/*----------------------------------------------------*/

/*	Clients section Parallax

/*----------------------------------------------------



	jQuery('.client').parallax("50%", 0.1);

	jQuery('.service-reasons').parallax("50%", 0.1);



	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({overlay_gallery: false});

	

*/	



/*----------------------------------------------------*/

/*	Tootltip Initialize

/*----------------------------------------------------*/







    jQuery("[data-toggle='tooltip']").tooltip();



});

/*----------------------------------------------------*/

/*	Scroll To Top Section

/*----------------------------------------------------*/

	jQuery(document).ready(function () {

	

		jQuery(window).scroll(function () {

			if (jQuery(this).scrollTop() > 100) {

				jQuery('.scrollup').fadeIn();

			} else {

				jQuery('.scrollup').fadeOut();

			}

		});

	

		jQuery('.scrollup').click(function () {

			jQuery("html, body").animate({

				scrollTop: 0

			}, 600);

			return false;

		});

	

	});

	/*----------------------------------------------------*/

	/*	Jquery Google map Section

	/*----------------------------------------------------*/

		

	//Google map

	jQuery('#maps').gMap({

		address: "Khulna Division, Bangladesh",

		zoom: 10,

		markers: [{

			latitude: 22.816694,

			longitude: 89.549904,

			html: "<h4>FIFO Themes</h4>Wordpress, HTML5/CSS Themes",

			popup: true

		}]

	});







	/*----------------------------------------------------*/

	/*	Contact Form Section

	/*----------------------------------------------------*/

$("#contact").submit(function (e) {

    e.preventDefault();

    var name = $("#name").val();

    var email = $("#email").val();

	var subject = $("#subject").val();

    var text = $("#text").val();

    var dataString = 'name=' + name + '&email=' + email + '&subject=' + subject + '&text=' + text;

	



    function isValidEmail(emailAddress) {

        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

        return pattern.test(emailAddress);

    };



    if (isValidEmail(email) && (text.length > 100) && (name.length > 1)) {

        $.ajax({

            type: "POST",

            url: "ajax/process.php",

            data: dataString,

            success: function () {

                $('.success').fadeIn(1000).delay(3000).fadeOut(1000);

                $('#contact')[0].reset();

            }

        });

    } else {

        $('.error').fadeIn(1000).delay(5000).fadeOut(1000);



    }



    return false;

});



/* ------------------------------------------------------------- 
	LOADER
 ------------------------------------------------------------- */
 
function generateLoader(size, speed){
	var default_size = 100;
	var default_speed = 1.5;
	size = size || default_size;
	speed = speed || default_speed;
	var html = '<svg width="'+size+'px"  height="'+size+'px"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-double-ring" style="background: none;"><circle cx="50" cy="50" ng-attr-r="{{config.radius}}" ng-attr-stroke-width="{{config.width}}" ng-attr-stroke="{{config.c1}}" ng-attr-stroke-dasharray="{{config.dasharray}}" fill="none" stroke-linecap="round" r="40" stroke-width="4" stroke="#ec407a" stroke-dasharray="62.83185307179586 62.83185307179586" transform="rotate(238.536 50 50)"><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;360 50 50" keyTimes="0;1" dur="'+default_speed+'s" begin="0s" repeatCount="indefinite"></animateTransform></circle><circle cx="50" cy="50" ng-attr-r="{{config.radius2}}" ng-attr-stroke-width="{{config.width}}" ng-attr-stroke="{{config.c2}}" ng-attr-stroke-dasharray="{{config.dasharray2}}" ng-attr-stroke-dashoffset="{{config.dashoffset2}}" fill="none" stroke-linecap="round" r="35" stroke-width="4" stroke="#000" stroke-dasharray="54.97787143782138 54.97787143782138" stroke-dashoffset="54.97787143782138" transform="rotate(-238.536 50 50)"><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;-360 50 50" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animateTransform></circle></svg>';

	return html;
}
 
function showLoader(container, type, container_h){
	var loader = generateLoader();
	container_h = container_h || 100;
	if(type == 'sm'){
		loader = generateLoader(25);
	}else if(type == 'lg'){
		loader = generateLoader(100);
	}else if(type == 'md'){
		loader = generateLoader(80);
	}else{
		loader = generateLoader(50);
	}
	
	$(container).html('<div class="loader" style="height:'+container_h+'px">'+loader+'</div>');
	
}
 
 
 /* ------------------------------------------------------------- 
	NEW WINDOW 
 ------------------------------------------------------------- */
function newWindow(url) {
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=700,height=400");
}
 
 
 /* ------------------------------------------------------------- 
	AJAX MODAL
 ------------------------------------------------------------- */
function load_ajax_modal(url){
	showLoader($('#ajaxModal').find('.modal-content'), '', 100);
	$('#ajaxModal').modal('show');
	setTimeout(function(){
		$.get(url, function(res){
			$('#ajaxModal').find('.modal-content').html(res);
		});
	}, 700);
};


 /* ------------------------------------------------------------- 
	AJAX URL
 ------------------------------------------------------------- */
function load_ajax_url(url, container){
	showLoader($(container), '', 100);
	setTimeout(function(){
	$.get(url, function(res){
		$(container).html(res);
	});
}, 700);
	
}

 /* ------------------------------------------------------------- 
	LOADING ALL AJAX URL
 ------------------------------------------------------------- */

function init_ajax_loading(){
	$('[data-ajaxify]').each(function(index, item){
		var url = $(item).data('ajaxify');
		var container = $(item);
		load_ajax_url(url, container);
	});
} 

$(document).ready(function(){
	init_ajax_loading();
});

 

 /* ------------------------------------------------------------- 
	FAVORITE
 ------------------------------------------------------------- */

 
function mark_fav(object_id, type, callBack, cmd){
	var URL = '';
	if(cmd == 'remove'){
		URL = VPATH + 'favourite/remove_fav';
	}else{
		URL = VPATH + 'favourite/add_fav';
	} 
	
	$.ajax({
		url : URL,
		data: {type: type, object_id: object_id},
		type: 'POST',
		dataType: 'json',
		success: function(res){
			if(typeof callBack == 'function'){
				callBack(res);
			}
		}
	});
}

function addToFav(object_id, type, callBack){
	var fav_type = ['JOB', 'FREELANCER', 'AGENCY', 'PROJECT'];
	var default_type = 'JOB';
	
	if(type && fav_type.indexOf(type) == -1){
		return false;
	}else if(typeof type == 'undefined'){
		type = default_type;
	}
	
	mark_fav(object_id, type, callBack, 'add');
	
}



function removeFav(object_id, type, callBack){
	var fav_type = ['JOB', 'FREELANCER', 'AGENCY', 'PROJECT'];
	var default_type = 'JOB';
	
	if(type && fav_type.indexOf(type) == -1){
		return false;
	}else if(typeof type == 'undefined'){
		type = default_type;
	}
	
	mark_fav(object_id, type, callBack, 'remove');
}

/* -------------------------------------------------------------------- */


/* ------------------------------------------------------------- 
	ADD AND REMOVE FAVOURITE
 ------------------------------------------------------------- */
$(document).on('click', '.mark-fav-button', function(e){
	e.preventDefault();
	var action = $(this).data('action');
	var object_id = $(this).data('objectId');
	var object_type = $(this).data('objectType');
	var ele = $(this);
	
	if(action && object_id && object_type){
		if(action == 'add'){
			addToFav(object_id, object_type, function(res){
				if(res.status == 1){
					ele.addClass('bookmarked');
					ele.data('action', 'remove');
				}
			});
		}else if(action == 'remove'){
			removeFav(object_id, object_type, function(res){
				if(res.status == 1){
					ele.removeClass('bookmarked');
					ele.data('action', 'add');
				}
			});
		}
	}
	
});

jQuery(window).scroll(function(){

		if (jQuery(this).scrollTop() > 1) {

			jQuery('.gotop').css({bottom:"50px"});

		} else {

			jQuery('.gotop').css({bottom:"-200px"});

		}

	});

	jQuery('.gotop').click(function(){

		jQuery('html, body').animate({scrollTop: '0px'}, 800);

		return false;

	});
	
	
/*--------------------------------------------------*/
	/*  Star Rating
	/*--------------------------------------------------*/
	function starRating(ratingElem) {

		$(ratingElem).each(function() {

			var dataRating = $(this).attr('data-rating');

			// Rating Stars Output
			function starsOutput(firstStar, secondStar, thirdStar, fourthStar, fifthStar) {
				return(''+
					'<span class="'+firstStar+'"></span>'+
					'<span class="'+secondStar+'"></span>'+
					'<span class="'+thirdStar+'"></span>'+
					'<span class="'+fourthStar+'"></span>'+
					'<span class="'+fifthStar+'"></span>');
			}

			var fiveStars = starsOutput('star','star','star','star','star');

			var fourHalfStars = starsOutput('star','star','star','star','star half');
			var fourStars = starsOutput('star','star','star','star','star empty');

			var threeHalfStars = starsOutput('star','star','star','star half','star empty');
			var threeStars = starsOutput('star','star','star','star empty','star empty');

			var twoHalfStars = starsOutput('star','star','star half','star empty','star empty');
			var twoStars = starsOutput('star','star','star empty','star empty','star empty');

			var oneHalfStar = starsOutput('star','star half','star empty','star empty','star empty');
			var oneStar = starsOutput('star','star empty','star empty','star empty','star empty');

			// Rules
	        if (dataRating >= 4.75) {
	            $(this).append(fiveStars);
	        } else if (dataRating >= 4.25) {
	            $(this).append(fourHalfStars);
	        } else if (dataRating >= 3.75) {
	            $(this).append(fourStars);
	        } else if (dataRating >= 3.25) {
	            $(this).append(threeHalfStars);
	        } else if (dataRating >= 2.75) {
	            $(this).append(threeStars);
	        } else if (dataRating >= 2.25) {
	            $(this).append(twoHalfStars);
	        } else if (dataRating >= 1.75) {
	            $(this).append(twoStars);
	        } else if (dataRating >= 1.25) {
	            $(this).append(oneHalfStar);
	        } else if (dataRating < 1.25) {
	            $(this).append(oneStar);
	        }

		});

	} starRating('.star-rating');
	
	
	
function confirm_first(ele){
	var next = $(ele).data('next');
	var confirm_text = $(ele).data('confirmText');
	$.confirm({
		title: 'Confirm!',
		content: confirm_text,
		buttons: {
			confirm: function () {
				window.location.href = next;
			},
			cancel: function () {
				
			}
			
		}
	});
}
	
