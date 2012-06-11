<?php
require_once('adminautoload.php');

if (isset($_POST['submit'])) {
	if ($_POST['status'] != '') {
		// Post the new status
		$sql = "UPDATE options SET `value` = '" . $_POST['status'] . "', `user_id` = '" . $_SESSION['user']['id'] . "', `updated_at` = '" . time() . "' WHERE `option` = 'statustext'" ;
		$result = mysql_query($sql);
		if (mysql_affected_rows() == 1) {
			$_SESSION['flash'] = 'Status updated!';
			header('location:/admin/index.php');
			exit;
		} else {
			$_SESSION['flash'] = mysql_error();
			header('location:/admin/index.php');
			exit;
		}
	} else {
		$_SESSION['flash'] = 'You need to put something in the status';
		header('location:/admin/index.php');
		exit;
	}
} else {
	$_SESSION['flash'] = 'You didn\'t submit the form properly!';
	header('location:/admin/index.php');
	exit;
}
?>