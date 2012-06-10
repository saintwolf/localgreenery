<?php
require('../adminautoload.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$productId = mysql_real_escape_string($_GET['id']);
	$sql = "DELETE FROM products WHERE id = '$productId'";
	$result = mysql_query($sql);
	if (mysql_affected_rows() > 0) {
		$_SESSION['flash'] = 'Product Deleted';
		header('location:index.php');
	} else {
		$_SESSION['flash'] = 'Product Id not found';
		header('location:index.php');
	}
} else {
	$_SESSION['flash'] = 'Invalid or non-existent product id';
	header('location:index.php');
}