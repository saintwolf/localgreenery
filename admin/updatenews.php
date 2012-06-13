<?php
require_once('adminautoload.php');

if (isset($_POST['submit'])) {
    $_POST['newstext'] = mysql_real_escape_string($_POST['newstext']);
	if ($_POST['newstext'] != '') {
		// Post the new status
		$sql = "INSERT INTO news VALUES ('', '" . $_POST['newstext'] . "', " . $_SESSION['user']['id'] . ", " . time() . ")" ;
		$result = mysql_query($sql);
		if (mysql_affected_rows() == 1) {
			$_SESSION['flash'] = 'News added!';
			header('location:/admin/index.php');
			exit;
		} else {
			$_SESSION['flash'] = mysql_error();
			header('location:/admin/index.php');
			exit;
		}
	} else {
		$_SESSION['flash'] = 'You need to put something in the news post';
		header('location:/admin/index.php');
		exit;
	}
} else {
	$_SESSION['flash'] = 'You didn\'t submit the form properly!';
	header('location:/admin/index.php');
	exit;
}
?>