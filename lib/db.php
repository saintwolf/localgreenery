<?php
	require_once(LG_ROOT . DS . 'lib' . DS . 'config.php');
	// Connect to server and select databse.
	$conn = mysql_connect(db_host, db_user, db_pass)or die(mysql_error()); 
	mysql_select_db(db_name, $conn)or die(mysql_error());
?>
