<?php
require('../adminautoload.php');
$session->init('ADMIN');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$db = DB::getInstance();
	$sql = "DELETE FROM members WHERE id = :userId";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':userId', $_GET['id']);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
	    $session->setFlash('User Deleted');
	    header('location:index.php');
	    exit;
	} else {
	    $session->setFlash('User Id not found!');
	    header('location:index.php');
	    exit;
	}
} else {
	$session->setFlash('Invalid or non-existent user id');
	header('location:index.php');
	exit;
}