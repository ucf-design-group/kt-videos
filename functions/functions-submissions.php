<?php

/* Add Meta Box to Submissions to collect information for the navigation menu. */

function submission_meta_setup() {

	add_action('add_meta_boxes','submission_meta_add');
	add_action('save_post','submission_meta_save', 10, 2);
}
add_action('load-post.php','submission_meta_setup');
add_action('load-post-new.php','submission_meta_setup');


function submission_meta_add() {

	add_meta_box (
		'ted_submission_meta',
		'Submission Info',
		'ted_submission_meta',
		'submissions',
		'side',
		'default');
}


function ted_submission_meta() {

	// Get current values for all of the meta
	
	global $post;
	wp_nonce_field(basename( __FILE__ ), 'ted-form-nonce' );
	$visible = get_post_meta($post->ID, 'ted-form-visible', true) ? get_post_meta($post->ID, 'ted-form-visible', true) : 'show';
	$order = get_post_meta($post->ID, 'ted-form-order', true) ? get_post_meta($post->ID, 'ted-form-order', true) : '0';
	$video = get_post_meta($post->ID, 'ted-form-video', true) ? get_post_meta($post->ID, 'ted-form-video', true) : '';

	// Make special arrangements for possibly disabling the end date/time fields

	$checked = "checked = 'checked'";
	$disabled = "";
	$style = "";
	if ($visible == "hide") {
		$checked = "";
		$disabled = "disabled='disabled'";
		$style = "style='background-color:#EEEEEE'";	}

	?>
	<style type="text/css">
		#ted-form-main {width: 100%}
		#ted-form-order, #ted-form-video {width: 80px;}
	</style>
	<script type="text/javascript">
		function visibleCheckBox() {
			var checkBox = document.getElementById('ted-form-visible');
			var orderInput = document.getElementById('ted-form-order');
			var videoInput = document.getElementById('ted-form-video');
			if (checkBox.checked) {
				orderInput.disabled = false;
				orderInput.style.backgroundColor = '#FFFFFF';
				
				videoInput.disabled = false;
				videoInput.style.backgroundColor = '#FFFFFF';
			}
			else {
				orderInput.disabled = true;
				orderInput.style.backgroundColor = '#EEEEEE';
				
				videoInput.disabled = true;
				videoInput.style.backgroundColor = '#EEEEEE';
			}
		}
	</script>
	<table id="ted-form-main">
		<tr>
			<th><label for="ted-form-visible">Show in Listing:</label></th>
			<td><input type="checkbox" name="ted-form-visible" id="ted-form-visible" value="show" <?php echo $checked; ?> onchange="visibleCheckBox()"></td>
		</tr><tr>
			<th><label for="ted-form-order">List Position:</label></th>
			<td><input type="text" name="ted-form-order" id="ted-form-order" value="<?php echo $order; ?>" <?php echo $disabled . " " . $style; ?>></td>
		</tr><tr>
			<th><label for="ted-form-video">YouTube ID:</label></th>
			<td><input type="text" name="ted-form-video" id="ted-form-video" value="<?php echo $video; ?>" <?php echo $disabled . " " . $style; ?>></td>
		</tr>
	</table>
	<?php
}


function submission_meta_save($post_id, $post) {

	if ($parent_id = wp_is_post_revision($post_id)) 
		$post_id = $parent_id;

	if (!isset($_POST['ted-form-nonce']) || !wp_verify_nonce($_POST['ted-form-nonce'], basename( __FILE__ ))) {
		return $post_id;
	}

	$post_type = get_post_type_object($post->post_type);

	if (!current_user_can($post_type->cap->edit_post, $post_id)) {
		return $post_id;
	}

	$input = array();

	$input['visible'] = (isset($_POST['ted-form-visible']) && $_POST['ted-form-visible'] == 'show' ? 'show' : 'hide');
	$input['order'] = (isset($_POST['ted-form-order']) ? $_POST['ted-form-order'] : '0');
	$input['video'] = (isset($_POST['ted-form-video']) ? $_POST['ted-form-video'] : get_the_title());

	foreach ($input as $field => $value) {

		$old = get_post_meta($post_id, 'ted-form-' . $field, true);

		if ($value && '' == $old)
			add_post_meta($post_id, 'ted-form-' . $field, $value, true);
		else if ($value && $value != $old)
			update_post_meta($post_id, 'ted-form-' . $field, $value);
		else if ('' == $value && $old)
			delete_post_meta($post_id, 'ted-form-' . $field, $old);
	}
}

?>