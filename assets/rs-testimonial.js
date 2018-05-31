jQuery(function() {
	rs_testimonial_init_submit_form();
	rs_testimonial_init_slider();
});

function rs_testimonial_init_slider() {
	var $sliders = jQuery('.rs-testimonial-slider');
	if ( $sliders.length < 1 ) return;

	$sliders.find('.rs-testimonial-items').flickity({
		cellSelector: '.rs-testimonial',
		contain: true,
		pageDots: false,
		arrowShape: {
			x0: 10,
			x1: 80, y1: 50,
			x2: 80, y2: 40,
			x3: 25
		},
		wrapAround: true,
		adaptiveHeight: true
	});
}

function rs_testimonial_init_submit_form() {
	var $shortcode_div = jQuery('.rs-testimonial-submit-form');
	if ( $shortcode_div.length < 1 ) return;

	$shortcode_div.each(function() {

		// Open the box
		$shortcode_div.on('click', '.rs-add-testimonial', function() {
			$shortcode_div
				.toggleClass('rs-expanded', true)
				.toggleClass('rs-collapsed', false);
		});

		// Close the box
		$shortcode_div.on('click', '.rs-close-testimonial-form', function() {
			$shortcode_div
				.toggleClass('rs-expanded', false)
				.toggleClass('rs-collapsed', true);
		});

		// Remove all (available after submitting testimonial)
		$shortcode_div.on('click', '.rs-close-testimonial-all', function() {
			$shortcode_div.remove();
		});

	});
}