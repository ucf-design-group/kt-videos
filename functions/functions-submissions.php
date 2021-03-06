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
		'kt_submission_meta',
		'Submission Info',
		'kt_submission_meta',
		'submissions',
		'side',
		'default');
}


function kt_submission_meta() {

	// Get current values for all of the meta
	
	global $post;
	wp_nonce_field(basename( __FILE__ ), 'kt-form-nonce' );
	$visible = get_post_meta($post->ID, 'kt-form-visible', true) ? get_post_meta($post->ID, 'kt-form-visible', true) : 'show';
	$order = get_post_meta($post->ID, 'kt-form-order', true) ? get_post_meta($post->ID, 'kt-form-order', true) : '0';
	$video = get_post_meta($post->ID, 'kt-form-video', true) ? get_post_meta($post->ID, 'kt-form-video', true) : '';
	$url = get_post_meta($post->ID, 'kt-form-url', true) ? get_post_meta($post->ID, 'kt-form-url', true) : '';

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
		#kt-form-main {width: 100%}
		#kt-form-order, #kt-form-video, #kt-form-url {width: 80px;}
	</style>
	<script type="text/javascript">
		function visibleCheckBox() {
			var checkBox = document.getElementById('kt-form-visible');
			var orderInput = document.getElementById('kt-form-order');

			if (checkBox.checked) {
				orderInput.disabled = false;
				orderInput.style.backgroundColor = '#FFFFFF';
			}
			else {
				orderInput.disabled = true;
				orderInput.style.backgroundColor = '#EEEEEE';
			}
		}
	</script>
	<table id="kt-form-main">
		<tr>
			<th><label for="kt-form-visible">Show in Listing:</label></th>
			<td><input type="checkbox" name="kt-form-visible" id="kt-form-visible" value="show" <?php echo $checked; ?> onchange="visibleCheckBox()"></td>
		</tr><tr>
			<th><label for="kt-form-order">List Position:</label></th>
			<td><input type="text" name="kt-form-order" id="kt-form-order" value="<?php echo $order; ?>" <?php echo $disabled . " " . $style; ?>></td>
		</tr><tr>
			<th><label for="kt-form-video">YouTube ID:</label></th>
			<td><input type="text" name="kt-form-video" id="kt-form-video" value="<?php echo $video; ?>"></td>
		</tr><tr>
			<th><label for="kt-form-url">Team URL:</label></th>
			<td><input type="text" name="kt-form-url" id="kt-form-url" value="<?php echo $url; ?>"></td>
		</tr>
	</table>
	<?php
}


function submission_meta_save($post_id, $post) {

	if ($parent_id = wp_is_post_revision($post_id)) 
		$post_id = $parent_id;

	if (!isset($_POST['kt-form-nonce']) || !wp_verify_nonce($_POST['kt-form-nonce'], basename( __FILE__ ))) {
		return $post_id;
	}

	$post_type = get_post_type_object($post->post_type);

	if (!current_user_can($post_type->cap->edit_post, $post_id)) {
		return $post_id;
	}

	$input = array();

	$input['visible'] = (isset($_POST['kt-form-visible']) && $_POST['kt-form-visible'] == 'show' ? 'show' : 'hide');
	$input['order'] = (isset($_POST['kt-form-order']) ? $_POST['kt-form-order'] : '0');
	$input['video'] = (isset($_POST['kt-form-video']) ? $_POST['kt-form-video'] : '');
	$input['url'] = (isset($_POST['kt-form-url']) ? $_POST['kt-form-url'] : '');

	foreach ($input as $field => $value) {

		$old = get_post_meta($post_id, 'kt-form-' . $field, true);

		if ($value && '' == $old)
			add_post_meta($post_id, 'kt-form-' . $field, $value, true);
		else if ($value && $value != $old)
			update_post_meta($post_id, 'kt-form-' . $field, $value);
		else if ('' == $value && $old)
			delete_post_meta($post_id, 'kt-form-' . $field, $old);
	}
}

?>