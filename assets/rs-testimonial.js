jQuery(function() {
	var $shortcode_div = jQuery('.rs-testimonial-shortcode');
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
});