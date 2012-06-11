<?php
require_once('./lib/functions.php');
$dir = opendir('./uploads');
//$pics=dirname();
while ($pic = readdir($dir)) {
	$pics[] = $pic;
}
if ($pics[0]!='')
{
	foreach ($pics as $p)
	{
		echo "Create thumb for $p";
		createthumb('uploads/'.$p,'uploads/thumbs/tn_'.$p,100,100);
	}
}