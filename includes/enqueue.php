<?php

if ( !defined('ABSPATH') ) die('This file should not be accessed directly.');

function rst_enqueue_scripts() {
	global $RS_Testimonials;
	
	wp_enqueue_style( 'flickity', $RS_Testimonials->plugin_url . '/assets/flickity.css', array(), '2.1.1' );
	wp_enqueue_script( 'flickity', $RS_Testimonials->plugin_url . '/assets/flickity.pkgd.min.js', array('jquery'), '2.1.1' );
	
	wp_enqueue_style( 'rs-testimonial', $RS_Testimonials->plugin_url . '/assets/rs-testimonial.css', array(), $RS_Testimonials->version );
	wp_enqueue_script( 'rs-testimonial', $RS_Testimonials->plugin_url . '/assets/rs-testimonial.js', array('jquery'), $RS_Testimonials->version );
}
add_action( 'wp_enqueue_scripts', 'rst_enqueue_scripts' );