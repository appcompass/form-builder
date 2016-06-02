(function($) {

	//var breakpoints = {large: 1200, medium: 992, small:768 , xsmall:767 };


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

})(jQuery);