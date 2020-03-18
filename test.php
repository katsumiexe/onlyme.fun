<?
$img_link="https://profile.line-scdn.net/0hCnXi9V2yHEFlEDRXGCxjFllVEiwSPhoJHXRSL0MXEXgbKVwWXHMEIkESR3FBIV0RCyVTcElCQXYb.jpg";

$pict= imagecreatefromjpeg($img_link);

$img= imagecreatetruecolor(400,400);

$img_tmp	= getimagesize($img_link);

list($tmp_width, $tmp_height, $type, $attr) = $img_tmp;

print($line_picture."□<br>");
print($tmp_width."□<br>");
print($tmp_height."□<br>");
print($type."□<br>");
print($attr."□<br>");


?>
<img src="https://profile.line-scdn.net/0hCnXi9V2yHEFlEDRXGCxjFllVEiwSPhoJHXRSL0MXEXgbKVwWXHMEIkESR3FBIV0RCyVTcElCQXYb" width="100">
