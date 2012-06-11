<?php
define('LG_ROOT', dirname(__DIR__));
define('DS', '/');

require_once(LG_ROOT . DS . 'lib' . DS . 'config.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'session.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'db.php');

// Get the options from the database
$result = mysql_query("SELECT * FROM options WHERE `option` = 'status'") or die(mysql_error());
$status = mysql_fetch_assoc($result);

?>