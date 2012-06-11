<?php
session_start();
define('LG_ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
require_once(__DIR__ . DS . 'lib' . DS . 'db.php');
// username and password sent from form 
$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$mypassword = md5($mypassword);
$sql = "SELECT * FROM members WHERE username='$myusername' and password='$mypassword'";
$result = mysql_query($sql);

// Mysql_num_row is counting table row
$count = mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if ($count == 1) {
	// Register user to session and redirect to file "login_success.php" 
	$user = array();
	$user = mysql_fetch_assoc($result);
	$_SESSION['user'] = $user;
	header("location:index.php");
} else {
	$_SESSION['flash'] = "Wrong Username or Password";
	header('location:/main_login.php');
	exit;
}
?>