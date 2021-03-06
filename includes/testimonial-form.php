<?php

if ( !defined('ABSPATH') ) die('This file should not be accessed directly.');

function shortcode_rs_testimonial_form( $atts, $content = '' ) {
	
	$testimonial_added = isset($_REQUEST['rs_testimonial_added']);
	
	ob_start();
	?>
	<div class="rs-testimonial-shortcode <?php echo $testimonial_added ? 'rs-expanded' : 'rs-collapsed'; ?>">
		<div class="rs-inner">
			
			<?php
			if ( !$testimonial_added ) {
				$nonce = wp_create_nonce('rs_testimonial_add');
				
				$name = isset($_REQUEST['rst']['name']) ? stripslashes($_REQUEST['rst']['name']) : false;
				$email = isset($_REQUEST['rst']['email']) ? stripslashes($_REQUEST['rst']['email']) : false;
				$location = isset($_REQUEST['rst']['location']) ? stripslashes($_REQUEST['rst']['location']) : false;
				$content = isset($_REQUEST['rst']['content']) ? stripslashes($_REQUEST['rst']['content']) : false;
				?>
				<div class="rs-form-closed">
					<div class="rs-testimonial-button">
						<a href="#" class="rs-add-testimonial">Submit Your Testimonial</a>
					</div>
				</div>
				
				<div class="rs-form-opened" style="display: none;">
					<div class="rs-testimonial-button">
						<a href="#" class="rs-close-testimonial-form">Close</a>
					</div>
					
					<form action="" method="POST" enctype="multipart/form-data">
						<div class="rs-field rs-field-name">
							<label for="rs-testimonial-name" class="screen-reader-text">Name:</label>
							<input type="text" name="rst[name]" id="rs-testimonial-name" placeholder="Name" value="<?php echo esc_attr($name); ?>" required>
						</div>
						<div class="rs-field rs-field-email">
							<label for="rs-testimonial-email" class="screen-reader-text">Email:</label>
							<input type="email" name="rst[email]" id="rs-testimonial-email" placeholder="Email" value="<?php echo esc_attr($email); ?>" required>
						</div>
						<div class="rs-field rs-field-location">
							<label for="rs-testimonial-location" class="screen-reader-text">Organization / Location:</label>
							<input type="text" name="rst[location]" id="rs-testimonial-location" placeholder="Organization / Location" value="<?php echo esc_attr($location); ?>" required>
						</div>
						<div class="rs-field rs-field-content">
							<label for="rs-testimonial-content" class="screen-reader-text">Your Testimonial:</label>
							<textarea name="rst[content]" id="rs-testimonial-content" placeholder="Your Testimonial" required><?php echo esc_attr($content); ?></textarea>
						</div>
						<div class="rs-image">
							<label for="rs-testimonial-image" class="rs-label">Upload Photo:</label>
							<input type="file" name="rst-image" id="rs-testimonial-image" required>
						</div>
						<div class="rs-submit">
							<input type="hidden" name="rst[nonce]" value="<?php echo esc_attr($nonce); ?>">
							<input type="submit" value="Submit">
						</div>
					</form>
				</div>
				<?php
				
			}else{
				
				?>
				<div class="rs-form-opened">
					<div class="rs-testimonial-button">
						<a href="#" class="rs-close-testimonial-all">Close</a>
					</div>
					
					<div class="rs-testimonial-added-text">
						<p><strong>Testimonial Added</strong></p>
						<p>Thank you for submitting a testimonial. Please note that we will review your testimonial before publishing it to our website.</p>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rs_testimonial_form', 'shortcode_rs_testimonial_form' );


function rst_add_testimonial_from_shortcode() {
	if ( !isset($_POST['rst']) ) return;
	
	$post = stripslashes_deep($_POST['rst']);
	if ( empty($post['nonce']) || !wp_verify_nonce($post['nonce'], 'rs_testimonial_add') ) return;
	
	$errors = array();
	
	if ( empty($post['name']) ) $errors[] = 'Name is required';
	
	if ( empty($post['email']) ) $errors[] = 'Email is required';
	else if ( !is_email($post['email']) ) $errors[] = 'Email appears to be invalid';
	
	if ( empty($post['location']) ) $errors[] = 'Organization / Location is required';
	if ( empty($post['content']) ) $errors[] = 'Testimonial message is required';
	
	if ( empty($_FILES['rst-image']) ) $errors[] = 'Image is required';
	
	// Die for errors
	if ( !empty($errors) ) {
		wp_die('<p><strong>Failed to add testimonial:</strong></p><ul><li>'. implode('</li><li>', $errors) . '</li></ul>');
		exit;
	}
	
	// Create the testimonial
	$args = array(
		'post_type' => 'rs_testimonial',
	    'post_status' => 'pending',
	    'post_title' => esc_html($post['name']),
	    'post_content' => esc_html($post['content']),
	);
	
	$post_id = wp_insert_post( $args );
	
	if ( !$post_id || is_wp_error($post_id) ) {
		if ( !is_wp_error($post_id) ) $post_id = new WP_Error( 'insert_post_failed_generic', 'Failed to insert testimonial into database.' );
		wp_die( $post_id );
		exit;
	}
	
	update_post_meta( $post_id, 'email', esc_html($post['email']) );
	update_post_meta( $post_id, 'organization-location', esc_html($post['location']) );
	
	// Upload the photo
	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	
	$attachment_id = media_handle_upload( 'rst-image', $post_id );
	
	if ( !$attachment_id || is_wp_error($attachment_id) ) {
		if ( !is_wp_error($attachment_id) ) $attachment_id = new WP_Error( 'upload_attachment_failed_generic', 'Failed to upload image to the website.' );
		wp_die( $attachment_id );
		exit;
	}
	
	// Make it the featured image for the post
	set_post_thumbnail( $post_id, $attachment_id );
	
	// Make the shortcode display a message telling the user that the testimonial was added.
	wp_redirect( add_query_arg( array('rs_testimonial_added' => 1) ) );
	exit;
}
add_action( 'init', 'rst_add_testimonial_from_shortcode' );