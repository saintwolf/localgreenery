<?php
session_start();
require_once(LG_ROOT . DS . 'lib' . DS . 'db.php');
/*
 * This is where we are going to put the user data from the db into. 
 * This allows us to check bans and change info on every page.
 */
$user = array();

if (!isset($_SESSION['user'])) {
    header("location:main_login.php");
    exit;
} else {
    // Get the user from the DB
    $sql = "SELECT * FROM members WHERE id = '" . $_SESSION['user']['id'] . "'";
    $result = mysql_query($sql);
    if (mysql_num_rows($result) == 0) {
        die(
                'User not found. This really shouldn\'t happen. Please contact the administrator (If you have to ask for contact details, you shouldn\'t be here!');
    } else {
        $user = mysql_fetch_assoc($result);
        // Put the user object into the session
        $_SESSION['user'] = $user;
    }
}
if ($_SESSION['user']['banned'] == 'Y') {
    unset($_SESSION['user']);
    $_SESSION['flash'] = 'You are banned. Please contact the administrator.';
    header('location:/main_login.php');
    exit;
}
?>