
(function ($) {
	'use strict';



	/*============================== ====
		05. Testimonial Activation 
	=====================================*/

	/* Testimonial Slider Active 1 */
	$('.testimonial-activation').slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		centerMode: true,
		centerPadding: '0',
	});


	/* testimonial activation 3 */

	/* testimonial activation 4 */

	$('.testimonial-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		dots: true,
		asNavFor: '.testimonal-nav'
	});

	$('.testimonal-nav').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.testimonial-for',
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',
		arrows: false,

		responsive: [{
				breakpoint: 769,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 769,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 575,
				settings: {
					slidesToShow: 1
				}
			}
		]

	});

	/* Testimonial Slider Active 5 */



	/*==================================
		06. Testimonial Carousel Style
	=====================================*/


	/*Testimonial Carousel 2*/

	$('.testimonial-carousel-2').slick({
		infinite: false,
		speed: 500,
		slidesToShow: 4,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		prevArrow: '<button class="testimonial-arrow-prev"><i class="fa fa-angle-left"></i></button>',
		nextArrow: '<button class="testimonial-arrow-next"><i class="fa fa-angle-right"></i></button>',
		autoplay: false,
		centerMode: true,
		focusOnSelect: true,
		centerPadding: '0',

		responsive: [{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});

	

})(jQuery);