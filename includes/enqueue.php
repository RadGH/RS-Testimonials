<?php

if ( !defined('ABSPATH') ) die('This file should not be accessed directly.');

function rst_enqueue_scripts() {
	global $RS_Testimonials;
	wp_enqueue_script( 'rs-testimonial', $RS_Testimonials->plugin_url . '/assets/rs-testimonial.js', array('jquery'), $RS_Testimonials->version );
}
add_action( 'wp_enqueue_scripts', 'rst_enqueue_scripts' );