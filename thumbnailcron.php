<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(__DIR__ . DS . 'lib' . DS . 'functions.php');
$dir = opendir('./uploads');
//$pics=dirname();
while ($pic = readdir($dir)) {
	$pics[] = $pic;
}
if ($pics[0]!='')
{
	foreach ($pics as $p)
	{
		if ($p != '' && $p != '.' && $p !=  '..' && $p !=  'thumbs') {
		echo "Create thumb for $p\n";
		createthumb('uploads/'.$p,'uploads/thumbs/tn_'.$p,100,100);
		}
	}
	echo 'Thumbs have been created!';
}