<?php
define('LG_ROOT', dirname(__DIR__));
define('DS', '/');

require_once(LG_ROOT . DS . 'lib' . DS . 'config.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'session.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'db.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'functions.php');

// Get the options from the database
$result = mysql_query("SELECT * FROM options") or die(mysql_error());
$options = array();
while ($row = mysql_fetch_assoc($result)) {
	$options[$row['option']] = $row;
}

?>