<?
	include_once("./library/session.php");
	$line_qr=$dir3.$tmp_enc[2]."s".$tmp_enc[3].".png";
/*
    move_uploaded_file($_FILES["qr_files"]["tmp_name"],$line_qr);//画像を保存。
	echo($line_qr);
*/

$at			=array(14,39,65,90,118,137,167);
$at_lim		=array(0,27,51,78,102,129,153);
$at_point	=array(27,24,27,24,27,24,27);

//move_uploaded_file($_FILES["qr_files"]["tmp_name"],$line_qr);

//$img_url 	= imagecreatefromjpeg("./myalbum/qr.jpg");
//$img_url=$_FILES["qr_files"]["tmp_name"];
$img_url 	= imagecreatefromjpeg($_FILES["qr_files"]["tmp_name"]);

$base		=imagecreate(40,40);
$black		=ImageColorAllocate($base,0,0,0);
$white		=ImageColorAllocate($base,255,255,255);
$red		=ImageColorAllocate($base,255,0,0);

ImageFilledRectangle($base,0,0,40,40,$white);

$ck=0;
for($y=0;$y<35;$y++){
		$y_pt=$y%7;
		$y_point=($y_point+$at_point[$y_pt]);
		$x_point="";

	for($x=0;$x<35;$x++){
		$x_pt=$x%7;
		$x_point=($x_point+$at_point[$x_pt]);

//echo $x_point."<br>\n";

		$pixel = ImageColorAt($img_url, $x_point-10, $y_point-10);
		
		if($pixel==0){
			$s_code.=1;		
		}else{
			$s_code.=0;		
		}
	}
}

print($s_code);
for($y=0;$y<35;$y++){
	for($x=0;$x<35;$x++){
		$code_ck=substr($s_code,$ck,1);

		if($code_ck == 1){
		    ImageSetPixel($base,$x+2,$y+2,$black); 

		}else{
		    ImageSetPixel($base,$x+2,$y+2,$white); 

		}
		$ck++;
	}
}
imagepng($base,$line_qr);
?>
