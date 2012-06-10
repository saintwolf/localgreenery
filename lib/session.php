<?php
	session_start();
	if (!isset($_SESSION['user'])){
		header("location:main_login.php");
	} else if ($_SESSION['user']['banned'] == 'Y') {
		unset($_SESSION['user']);
		$_SESSION['flash'] = 'You are banned. Please contact the administrator.';
		header('location:/main_login.php');
		exit;
	}
?>