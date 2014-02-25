<?php

$message = null;

if (isset($_POST['vote-form-submit']))
	$message = count_votes();



function count_votes () {

	if ($_POST['vote-form-email'] == "")
		return "Please provide your e-mail address.";

	if (!filter_var($_POST['vote-form-email'], FILTER_VALIDATE_EMAIL))
		return "Please provide a valid e-mail address.";

	if (!isset($_POST['vote-form-video']))
		return "You didn't vote!";


	$db = new mysqli("localhost", "osi-admin", "Gold&Black", "kt-videos");

	$check = $db->query("SELECT * FROM `emails` WHERE email='" . $_POST['vote-form-email'] . "';");

	if ($check->num_rows > 0)
		return "You've already voted!";


	$videoID = mysql_real_escape_string($_POST['vote-form-video']);


	$old = get_post_meta(intval($videoID), 'kt-form-votes', true);

	$new = intval($old) + 1;

	if ($new && '' == $old)
		add_post_meta(intval($videoID), 'kt-form-votes', $new, true);
	else if ($new && $new != $old)
		update_post_meta(intval($videoID), 'kt-form-votes', $new);


	$db->query("INSERT INTO `emails` VALUES ('" . $_POST['vote-form-email'] .
									"', " . $_POST['vote-form-video'] . ");");

	return "Thank you!  Your vote has been cast.";
}

?>