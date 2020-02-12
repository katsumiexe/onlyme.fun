<?php

$_POST['top'];
$_POST['left'];
$_POST['vsize'];
$_POST['wsize'];
$_POST['rote'];
$_POST['zoom'];
$_POST['wturn'];
$_POST['vturn'];
$_POST['bright'];
$_POST['sepia'];
$_POST['gray'];

$_POST['tmpl'];


$img = "../images/back2.png";

list($width, $height, $type, $attr) = getimagesize($img);

$p_width	=ceil($width*($_POST["zoom"]/100));
$p_height	=ceil($height*($_POST["zoom"]/100));

$p_top	=($_POST["top"]-10)*(-1);
$p_left	=($_POST["left"]-10)*(-1);

print("width☆".$width."\n");
print("height▼".$height."\n");
print("p_width▽".$p_width."\n");
print("p_height▼".$p_height."\n");
print("p_top▽".$p_top."\n");
print("p_left▼".$p_left."\n");
print("zoom▼".$_POST['zoom']."\n");
print("wturn▼".$_POST['wturn']."\n");
print("vturn▼".$_POST['vturn']."\n");
print("bright▼".$_POST['bright']."\n");
print("sepia▼".$_POST['sepia']."\n");
print("gray▼".$_POST['gray']."\n");



$t_width=ceil(($width*$_POST['zoom'])/100);
$t_height=ceil(($height*$_POST['zoom'])/100);

$t_width2	=275+$p_left;
$t_height2	=455+$p_top;


//$tmp1 = imagecreatefromjpeg($img);

$tmp1 = imagecreatefrompng($img);


if($_POST['wturn']==-1 && $_POST['vturn'] ==-1){
	imageflip($tmp1, IMG_FLIP_BOTH);

}elseif($_POST['vturn'] ==-1){
	imageflip($tmp1, IMG_FLIP_VERTICAL);

}elseif($_POST['wturn']==-1){
	imageflip($tmp1, IMG_FLIP_HORIZONTAL);
}

if($_POST["gray"]){
	imagefilter($tmp1, IMG_FILTER_GRAYSCALE);

}elseif($_POST["sepia"]){
	imagefilter($tmp1, IMG_FILTER_GRAYSCALE);

	$r = ($r * 240) / 255;
	$g = ($g * 200) / 255;
	$b = ($g * 148) / 255;

    // ピクセルの値を変更する
    ImageSetPixel($tmp1, $width, $height, ImageColorResolve($tmp1, $r, $g, $b));

	for ($y=0; $y < 455; $y++) {
		for ($x=0; $x < 275; $x++) {
			// ピクセル値を取得
			$pixel = ImageColorAt($tmp1, $x, $y);

			// グレイスケールなので必ず、R == G == B
			// になるが、RGB説明のために個別に取り出す
			$r = ($pixel >> 16) & 0xff;
			$g = ($pixel >> 8)  & 0xff;
			$b = $pixel & 0xff;

			// セピア調な値にする
			$r = ($r * 240) / 255;
			$g = ($g * 200) / 255;
			$b = ($b * 148) / 255;

			// ピクセルの値を変更する
			ImageSetPixel($tmp1, $x, $y, ImageColorResolve($tmp1, $r, $g, $b));
		}
	}
}

if($_POST["bright"] !=100){
	imagefilter($tmp1, IMG_FILTER_BRIGHTNESS,$_POST["bright"]-100);
}

$tmp2 = imagecreatetruecolor($t_width, $t_height);
$tmp3 = imagecreatetruecolor(275, 455);


ImageCopyResampled($tmp2, $tmp1, 0, 0, 0, 0 , $t_width, $t_height,$width, $height);
ImageCopyResampled($tmp3, $tmp2, 0, 0, $p_left, $p_top, 275, 455, $t_width2, $t_height2);

$font1 = "./font/keifont.ttf";
$text1 = "山田たろすけ";
$color1 = imagecolorallocate($tmp3, 255, 255, 255);
$color2 = imagecolorallocate($tmp3, 255, 30, 50);

$xa=10;
$ya=50;

$xa_1=$xa-1;
$xa_2=$xa;
$xa_3=$xa+1;
$xa_4=$xa+5;

$ya_1=$ya-1;
$ya_2=$ya;
$ya_3=$ya+1;
$ya_4=$ya+5;


imagettftext($tmp3, 35, 0, $xa_4, $ya_4, $color2, $font1, $text1);

imagettftext($tmp3, 35, 0, $xa_1, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 35, 0, $xa_1, $ya_2, $color2, $font1, $text1);
imagettftext($tmp3, 35, 0, $xa_1, $ya_3, $color2, $font1, $text1);
imagettftext($tmp3, 35, 0, $xa_2, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 35, 0, $xa_2, $ya_3, $color2, $font1, $text1);
imagettftext($tmp3, 35, 0, $xa_3, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 35, 0, $xa_3, $ya_2, $color2, $font1, $text1);
imagettftext($tmp3, 35, 0, $xa_3, $ya_3, $color2, $font1, $text1);

imagettftext($tmp3, 35, 0, $xa, $ya, $color1, $font1, $text1);


//-------------------------------

$xa=10;
$ya=100;

$xa_1=$xa-1;
$xa_2=$xa;
$xa_3=$xa+1;
$xa_4=$xa+5;

$ya_1=$ya-1;
$ya_2=$ya;
$ya_3=$ya+1;
$ya_4=$ya+5;



imagettftext($tmp3, 25, 0, $xa_4, $ya_4, $color2, $font1, $text1);

imagettftext($tmp3, 25, 0, $xa_1, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 25, 0, $xa_1, $ya_2, $color2, $font1, $text1);
imagettftext($tmp3, 25, 0, $xa_1, $ya_3, $color2, $font1, $text1);
imagettftext($tmp3, 25, 0, $xa_2, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 25, 0, $xa_2, $ya_3, $color2, $font1, $text1);
imagettftext($tmp3, 25, 0, $xa_3, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 25, 0, $xa_3, $ya_2, $color2, $font1, $text1);
imagettftext($tmp3, 25, 0, $xa_3, $ya_3, $color2, $font1, $text1);

imagettftext($tmp3, 25, 0, $xa, $ya, $color1, $font1, $text1);

//--------------------------


$xa=5;
$ya=170;

$xa_1=$xa-1;
$xa_2=$xa;
$xa_3=$xa+1;
$xa_4=$xa+5;

$ya_1=$ya-1;
$ya_2=$ya;
$ya_3=$ya+1;
$ya_4=$ya+3;



imagettftext($tmp3, 15, 0, $xa_4, $ya_4, $color2, $font1, $text1);

imagettftext($tmp3, 15, 0, $xa_1, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 15, 0, $xa_1, $ya_2, $color2, $font1, $text1);
imagettftext($tmp3, 15, 0, $xa_1, $ya_3, $color2, $font1, $text1);
imagettftext($tmp3, 15, 0, $xa_2, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 15, 0, $xa_2, $ya_3, $color2, $font1, $text1);
imagettftext($tmp3, 15, 0, $xa_3, $ya_1, $color2, $font1, $text1);
imagettftext($tmp3, 15, 0, $xa_3, $ya_2, $color2, $font1, $text1);
imagettftext($tmp3, 15, 0, $xa_3, $ya_3, $color2, $font1, $text1);

imagettftext($tmp3, 15, 0, $xa, $ya, $color1, $font1, $text1);

//--------------------------
/*
$item3 = ImageCreate(500,200);
$red2 = ImageColorAllocate($tmp3, 150, 0, 0);
//ImageFilledRectangle($tmp3, 40, 280, 245, 430, $red2);

$item2 = ImageCreate(500,200);
$item1 = ImageCreate(390,240);
*/

$red1 = ImageColorAllocate($tmp3, 255, 79, 159);
$pink1 = ImageColorAllocate($tmp3, 255, 225, 245);
$pink2 = ImageColorAllocate($tmp3, 255, 192, 208);


ImageFilledRectangle($tmp3, 20, 325, 255, 425, $pink2);
ImageFilledRectangle($tmp3, 30, 335, 245, 415, $pink1);

$font3 = "./font/mushin.otf";
$font4 = "./font/Nyashi_Friends.ttf";

$fonta = "./font/RobotoCondensed-Bold.ttf";
$fontb = "./font/font_01/fonts/icomoon.ttf";
$fontc = "./font/Caveat-Regular.ttf";
$fontd = "./font/RobotoCondensed-Regular.ttf";
$fonte = "./font/RobotoCondensed-Light.ttf";
$fontf = "./font/Teko-SemiBold.ttf";


$text2 = "yadayoyadayo123@gmail.com";
$text2 = "itainotondeke_ponpon@hotmail.co.jp";
$text3 = '\e90d';
$text4 = '\e90d';

imagettftext($tmp3, 10, 0, 35, 365, $red1, $fontb, $text3);
imagettftext($tmp3, 10, 0, 45, 365, $red1, $fonta, $text2);
imagettftext($tmp3, 10, 0, 35, 380, $red1, $fontd, $text2);
imagettftext($tmp3, 11, 0, 35, 395, $red1, $fonta, $text2);
imagettftext($tmp3, 11, 0, 35, 410, $red1, $fontd, $text2);



$frame = "./images/bk.png";
$frame2 = imagecreatefrompng($frame);

ImageCopyResampled($tmp3, $frame2, 0, 0, 0, 0 , 275, 455,275, 455);


//imagejpeg($tmp3, "to.jpg", 100);
imagepng($tmp3, "to.png");

imagedestroy($tmp1);
imagedestroy($tmp2);
imagedestroy($tmp3);


?>

