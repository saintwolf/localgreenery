<?php
require_once('adminautoload.php');
$session->init('ADMIN');

if (isset($_POST['submit'])) {
    $newsText = trim($_POST['newstext']);
	if ($newsText != '') {
		// Post the new status
		$db = DB::getInstance();
		$sql = "INSERT INTO news VALUES ('', ':newsText', ':userId', ':time')";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':newsText', $newsText);
		$stmt->bindParam(':userId', $_SESSION['user']['id']);
		$stmt->bindValue(':time', time());

		if ($stmt->execute()) {
			$session->setFlash('News added!');
			header('location:/admin/index.php');
			exit;
		} else {
			$session->setFlash('Something wrong happened. Contact the admin');
			header('location:/admin/index.php');
			exit;
		}
	} else {
		$session->setFlash('You need to put something in the news post');
		header('location:/admin/index.php');
		exit;
	}
} else {
	$session->setFlash('You didn\'t submit the form properly!');
	header('location:/admin/index.php');
	exit;
}
?>