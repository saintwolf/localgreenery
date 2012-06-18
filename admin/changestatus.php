<?php
include('adminautoload.php');
$session->init('ADMIN');
// Get status first
$db = DB::getInstance();
$sql = "SELECT `value` FROM options WHERE `option` = 'status'";
$stmt = $db->prepare($sql);
$stmt->execute();
$status = $stmt->fetchColumn(0);

if ($status == "Available") {
	$sql = "UPDATE options SET `value` = 'Unavailable' WHERE `option` = 'status'";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	header('location:index.php');
	exit;
} else {
	$sql = "UPDATE options SET `value` = 'Available' WHERE `option` = 'status'";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	header('location:index.php');
	exit;
}
?>