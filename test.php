<?
$img_link="https://profile.line-scdn.net/0hCnXi9V2yHEFlEDRXGCxjFllVEiwSPhoJHXRSL0MXEXgbKVwWXHMEIkESR3FBIV0RCyVTcElCQXYb";

//$img_link="myalbum/pq/ampqagalpqal/agpq/mfpzmiclre.jpg";

$img_tmp	= getimagesize($img_link);

$pict		= imagecreatefromjpeg($img_link);

$img		= imagecreatetruecolor(400,400);

list($tmp_width, $tmp_height, $type, $attr) = $img_tmp;

print($line_picture."□<br>");
print($tmp_width."□<br>");
print($tmp_height."□<br>");
print($type."□<br>");
print($attr."□<br>");
print($mime."□<br>");

ImageCopyResampled($img, $pict, 0, 0, 0, 0, 400, 400, $tmp_width, $tmp_height);
imagejpeg($img,"myalbum/test.jpg");

?>
<html>
<heaD>
<script src="./js/jquery-3.4.1.min.js"></script>
<script>
$(function(){ 
	$('.btn').on('click',function(){;

	$('#v64').val("aarfaofeqogeagnaegeatgaetairaerfqa");
	$('#v64').select();
	document.execCommand("copy");
	});
});

</script>
</head>
<body>
<img src="https://profile.line-scdn.net/0hCnXi9V2yHEFlEDRXGCxjFllVEiwSPhoJHXRSL0MXEXgbKVwWXHMEIkESR3FBIV0RCyVTcElCQXYb" width="100">
<input id="v64" type="hidden">
<div class="btn">あ</div>
</body>
</html>

