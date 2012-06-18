<?php
define('LG_ROOT', dirname(__DIR__));
define('DS', '/');

require_once(LG_ROOT . DS . 'lib' . DS . 'config.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'session.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'db.php');
require_once(LG_ROOT . DS . 'lib' . DS . 'functions.php');

// Get the settings from the database
$pdo = DB::getInstance();
$stmt = $pdo->prepare("SELECT * FROM options");
$stmt->execute();
$options = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$options[$row['option']] = $row;
}

?>