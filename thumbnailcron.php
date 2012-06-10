<?php
require_once('./lib/thumbnail.php');
$pics=dir('./uploads','jpg,JPG,JPEG,jpeg,png,PNG');
if ($pics[0]!='')
{
	foreach ($pics as $p)
	{
		createthumb('uploads/'.$p,'thumbs/tn_'.$p,100,100);
	}
}