<?php
require_once('config.php');
require_once('session.php');
require_once('db.php');

define('LG_ROOT', dirname(__DIR__ . '../'));
define('DS', '/');

// Get the options from the database
$result = mysql_query("SELECT * FROM options WHERE `option` = 'status'") or die(mysql_error());
$status = mysql_fetch_assoc($result);

?>