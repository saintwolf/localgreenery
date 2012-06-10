<?php
function createthumb($name, $filename, $new_w, $new_h) {
	$system = explode('.', $name);
	$src_img = imagecreatefromjpeg($name);
	
	$old_x = imageSX($src_img);
	$old_y = imageSY($src_img);
	if ($old_x > $old_y) {
		$thumb_w = $new_w;
		$thumb_h = $old_y * ($new_h / $old_x);
	}
	if ($old_x < $old_y) {
		$thumb_w = $old_x * ($new_w / $old_y);
		$thumb_h = $new_h;
	}
	if ($old_x == $old_y) {
		$thumb_w = $new_w;
		$thumb_h = $new_h;
	}
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
		imagejpeg($dst_img, $filename);
	imagedestroy($dst_img);
	imagedestroy($src_img);
}

?>