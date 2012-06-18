<?php
require_once(__DIR__ . '/autoload.php');
$session->init();

// username and password sent from form 
$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];

$mypassword = md5($mypassword);

$db = DB::getInstance();
$stmt = $db->prepare("SELECT * FROM members WHERE username=:username and password=:password");
$stmt->bindParam(':username', $myusername);
$stmt->bindParam(':password', $mypassword);
$stmt->execute();

// Mysql_num_row is counting table row

// If result matched $myusername and $mypassword, table row must be 1 row
if ($stmt->rowCount() == 1) {
	// Register user to session and redirect to file "login_success.php" 
	$_SESSION['user'] = $stmt->fetch(PDO::FETCH_ASSOC);
	header("location:/index.php");
	exit;
} else {
	$session->setFlash("Wrong Username or Password");
	header('location:/main_login.php');
	exit;
}
?>