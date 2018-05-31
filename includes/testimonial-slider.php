<?php

if ( !defined('ABSPATH') ) die('This file should not be accessed directly.');

function shortcode_rs_testimonial_slider( $atts, $content = '' ) {
	$args = array(
		'post_type' => 'rs_testimonial',
		'posts_per_page' => 5,
		'orderby' => 'rand',
	);
	
	$testimonials = new WP_Query($args);
	
	if ( !$testimonials->have_posts() ) return '';
	
	ob_start();
	?>
	<div class="rs-testimonial-shortcode rs-testimonial-slider">
		<div class="rs-inner">
			
			<div class="rs-testimonial-items">
				<?php
				while( $testimonials->have_posts() ): $testimonials->the_post();
					?>
					<div class="rs-testimonial">
						<div class="-item-inner">
							<div class="-photo"><?php the_post_thumbnail('medium'); ?></div>
							<div class="-content">
								<blockquote>
									<?php echo wpautop( '&ldquo;' . get_the_content() . '&rdquo;' ); ?>
									<cite><span class="-ndash">&ndash;</span> <span class="-author"><?php the_title(); ?></span></cite>
								</blockquote>
							</div>
						</div>
					</div>
					<?php
				
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rs_testimonial_slider', 'shortcode_rs_testimonial_slider' );