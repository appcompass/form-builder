(function($) {

	var breakpoints = {large: 1200, medium: 992, small:768 , xsmall:767 };


	/* Navigation
	---------------------------------------------------------------------- */

	$('.main-nav-trigger').on('click', function() {
		$(this).toggleClass('is-open');
		$('.main-nav').toggleClass('is-open');
	});

	$('.nav-dropdown-arrow').on('click', function(e) {
		e.preventDefault();
		$(this).parent().parent().toggleClass('is-open');
	});

	/* Slideshows
	---------------------------------------------------------------------- */
	$('.work-slideshow').slick({
		dots: true,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		arrows: false,
		mobileFirst: true,
		customPaging : function(slider, i) {
			var num = i + 1;
			return '<button type="button" data-role="none" role="button" tabindex="0">0'+ num + '</button>';
		},
	});

	$('.facebook-slideshow').slick({
		centerMode: true,
  		centerPadding: '20px',
  		infinite:false,
		speed: 300,
		arrows: false,
		mobileFirst: true,
		responsive: [
			{
				breakpoint: breakpoints.xsmall,
				settings: {
					variableWidth: true,
					centerMode: false,
				}
			},
			{
				breakpoint: breakpoints.medium - 1,
				settings: {
					variableWidth: true,
					centerMode: false,
					arrows: true,
					appendArrows: '.facebook-slideshow-controls',
					prevArrow: '<button type="button" class="slick-prev"><span class="icon-arrow"></span></button>',
					nextArrow: '<button type="button" class="slick-next"><span class="icon-arrow"></span></button>',
				}
			}

		]
	});

	$('.review-slideshow').slick({
		fade:true,
		autoplay:true,
		autoplaySpeed: 4000,
		dots: true,
		infinite: true,
		speed: 1000,
		slidesToShow: 1,
		arrows: false	
	});

	/* Match Heights
	---------------------------------------------------------------------- */
	$('.home-solution-box').matchHeight();
	$('.home-solution-front').matchHeight();
	$('.facebook-slide').matchHeight();

	if ($(window).width() < breakpoints.small) {
		$('.home-solution-box, .home-solution-front, .facebook-slide').matchHeight({ remove: true });
	}

})(jQuery);