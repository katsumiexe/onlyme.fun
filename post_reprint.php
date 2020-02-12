<?php
include_once("./library/no_session.php");
$cont_font	="./font/RobotoCondensed-Regular.ttf";

$img_id=$_POST["img_id"];

$sql ="SELECT user_id,img FROM `me_making`";
$sql.=" WHERE making_id='{$img_id}'";
$sql.=" LIMIT 1";

$res = mysqli_query($mysqli,$sql);
$des = mysqli_fetch_assoc($res);

for($n=0;$n<4;$n++){	
	$tmp_key=substr($des["user_id"],$n*2,2);
	$tmp_enc[$n]=$enc[$tmp_key];
}

$list_enc	=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
$main_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[2]}{$tmp_enc[3]}/{$des["img"]}";
$dir		="myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[2]}{$tmp_enc[3]}/";//album

$tmp2= imagecreatefromjpeg($main_img);

$img_x=imagesx($tmp2);
$img_y=imagesy($tmp2);

$rate	=0.28;
$b		=2;
$base_x	=275*$b;
$base_y	=455*$b;
$print_x0=890*$b;
$print_y0=635*$b;

$now=date("Y/m/d H:i:s");

$tmp3	=imagecreatetruecolor($print_x0,$print_y0);
$bk		=ImageColorAllocate($tmp3,0,0,0);
$wh		=ImageColorAllocate($tmp3,255,255,255);
$rd		=ImageColorAllocate($tmp3,0,0,255);

imagefill($tmp3, 0, 0, $wh);



$base_x	-= 10;
$base_y	-= 15;

//■縦軸--------------
for($n=0;$n<4;$n++){	
	imageline($tmp3, $base_x*$n+50+$n, 50, $base_x*$n+90+$n, 50, $bk);
	imageline($tmp3, $base_x*$n+70+$n, 50, $base_x*$n+70+$n, 70, $bk);

	imageline($tmp3, $base_x*$n+50+$n, $base_y+140, $base_x*$n+90+$n, $base_y+140, $bk);
	imageline($tmp3, $base_x*$n+70+$n, $base_y+120,  $base_x*$n+70+$n, $base_y+140, $bk);
}

//■横軸左--------------
imageline($tmp3, 30, 89, 50, 89, $bk);
imageline($tmp3, 30, 70, 30, 110, $bk);

imageline($tmp3, 30, $base_y+90, 50, $base_y+90, $bk);
imageline($tmp3, 30, $base_y+70, 30, $base_y+110, $bk);

imageline($tmp3, $base_x*3+60+30, 89, $base_x*3+60+50, 89, $bk);
imageline($tmp3, $base_x*3+60+50, 70, $base_x*3+60+50, 110, $bk);

imageline($tmp3, $base_x*3+60+30, $base_y+90, $base_x*3+60+50, $base_y+90, $bk);
imageline($tmp3, $base_x*3+60+50, $base_y+70, $base_x*3+60+50, $base_y+110, $bk);

//■main--------------
ImageCopyResampled($tmp3, $tmp2, ($base_x+1)*0+71, 90, 0, 0, $base_x, $base_y, $base_x+10, $base_y+15);
ImageCopyResampled($tmp3, $tmp2, ($base_x+1)*1+71, 90, 0, 0, $base_x, $base_y, $base_x+10, $base_y+15);
ImageCopyResampled($tmp3, $tmp2, ($base_x+1)*2+71, 90, 0, 0, $base_x, $base_y, $base_x+10, $base_y+15);

imagettftext($tmp3, 30, 0, 200, 1150, $rd, $cont_font, $now);

imagejpeg($tmp3,$dir."/print.jpg");
echo($main_img);
?>

