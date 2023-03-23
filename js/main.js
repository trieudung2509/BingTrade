$(function() {
	/* -----------------------------------------------------------
		Header fixed
	----------------------------------------------------------- */
	$(window).on('scroll', function() {
		if ($(window).scrollTop() > 0) {
			$('body').addClass('fixed-header').css('padding-top', $('.main-header').outerHeight());
		} else {
			$('body').removeClass('fixed-header').css('padding-top', '');
		}
	});
});