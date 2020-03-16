<?
include_once("./library/no_session.php");

$img_url 	= imagecreatefromjpeg("./myalbum/qr.jpg");
$base		=imagecreate(108,108);
$black		=ImageColorAllocate($base,255,0,0);
$white		=ImageColorAllocate($base,255,255,255);

$ck=0;
for($y=0;$y<34;$y++){
	for($x=0;$x<34;$x++){
		$pixel = ImageColorAt($img_url, $x*26+13, $y*26+13);

		if($pixel ==0){
			$s_code.=1;		
		}else{
			$s_code.=0;		

		}
	}
}

for($y=0;$y<36;$y++){
	for($x=0;$x<36;$x++){
		$code_ck=substr($s_code,$ck,1);

		$x1=$x*3;
		$x2=$x*3+2;
		$y1=$y*3;
		$y2=$y*3+2;

		if($code_ck == 1){
			imagefilledrectangle($base, $x1, $y1, $x2, $y2, $black);
		}else{
			imagefilledrectangle($base, $x1, $y1, $x2, $y2, $white);
		}
		$ck++;
	}
}

imagepng($base,"./myalbum/test.png");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
</head>
<body>
</body>
</html>
