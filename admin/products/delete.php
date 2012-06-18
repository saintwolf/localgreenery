<?php
require('../adminautoload.php');
$session->init('ADMIN');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$db = DB::getInstance();
	$sql = "DELETE FROM products WHERE id = :productId";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':productId', $_GET['id']);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
	    $session->setFlash('Product Deleted');
	    header('location:index.php');
	    exit;
	} else {
	    $session->setFlash('Product Id not found!');
	    header('location:index.php');
	    exit;
	}
} else {
	$session->setFlash('Invalid or non-existent product id');
	header('location:index.php');
	exit;
}