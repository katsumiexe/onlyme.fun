<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=3;
$rate=0.28;

$b=2;

$base_x=275*$b;
$base_y=455*$b;

$print_x0=890*$b;
$print_y0=635*$b;

$now=date("Y/m/d H:i:s");

$sql="SELECT * FROM me_encode";
if($re = mysqli_query($mysqli,$sql)){
	while($de = mysqli_fetch_assoc($re)){
		$me_code[$de["gp"]][$de["value"]]=$de["key"];
	}
}

if($token	 == 3){

$id_zoom	=$_POST["id_zoom"];
$base_zoom	=$_POST["base_zoom"];
$vw_set		=$_POST["vw_set"];
$id_top2	=$_POST["id_top"];
$id_left2	=$_POST["id_left"];
$id_height	=$_POST["id_height"]+0;
$id_width	=$_POST["id_width"]+0;

$id_wturn	=$_POST["id_wturn"];
$id_vturn	=$_POST["id_vturn"];

$id_bright	=$_POST['id_bright']-100;
$id_sepia	=$_POST['id_sepia'];
$id_gray	=$_POST['id_gray'];

$tmpl		=$_POST["tmpl"];
$name		=$_POST["name"];
$orgin		=$_POST["orgin"];
$mail		=$_POST["mail"];
$twitter	=$_POST["twitter"];
$cosp		=$_POST["cosp"];
$insta		=$_POST["insta"];
$url		=$_POST["url"];
$qr			=$_POST["qr"];

$img_url2	=$dir2.$_POST["img_url2"];
$img_url1	=$dir.$_POST["img_url1"];

$img_tmp	= getimagesize($img_url1);

if($img_tmp){
	list($width0, $height0, $type0, $attr0) = $img_tmp;

	$base_img_h=ceil(127.4/$base_zoom*(100/$id_zoom));
	$base_img_w=ceil(77/$base_zoom*(100/$id_zoom));


	if($id_height==0){
		$id_top=0;
	}else{
		$id_top	=ceil($id_top2*$vw_set*$height0/$id_height)*(-1);
	}

	if($id_width==0){
		$id_left=0;
	}else{
		$id_left=ceil($id_left2*$vw_set*$width0/$id_width)*(-1);
	}
}

/*
print("h□".$height0."<br>\n");
print("w□".$width0."<br>\n");
*/

$img_url 	= imagecreatefromjpeg($img_url1);
$qr_center	= imagecreatefrompng("./img/qr_twitter_30.png");

//imagejpeg($img_url,$dir."test.jpg",100);


$sql ="SELECT * FROM me_tmpl";
$sql.=" WHERE tmpl_id='{$tmpl}'";
$sql.=" LIMIT 1";

if($result_tmpl = mysqli_query($mysqli,$sql)){
	$dat_tmpl = mysqli_fetch_assoc($result_tmpl);
}

$name_x		=ceil($dat_tmpl['name_x']*$b);
$name_y		=ceil($dat_tmpl['name_y']*$b);
$name_size	=ceil($dat_tmpl['name_size']*$b*75/100);

$orgin_x	=ceil($dat_tmpl['orgin_x']*$b);
$orgin_y	=ceil($dat_tmpl['orgin_y']*$b);
$orgin_size	=ceil($dat_tmpl['orgin_size']*$b*75/100);

$contact_x	=ceil($dat_tmpl['contact_x']*$b);
$contact_y	=ceil($dat_tmpl['contact_y']*$b);

$wall0		=$dat_tmpl['wall0'];
$wall0_o	=$dat_tmpl['wall0_o'];
$wall0_z	=$dat_tmpl['wall0_z'];
$wall0_w	=ceil($dat_tmpl['wall0_w']*$b);
$wall0_h	=ceil($dat_tmpl['wall0_h']*$b);
$wall0_x	=ceil($dat_tmpl['wall0_x']*$b);
$wall0_y	=ceil($dat_tmpl['wall0_y']*$b);

$wall1		=$dat_tmpl['wall1'];
$wall1_o	=$dat_tmpl['wall1_o'];
$wall1_z	=$dat_tmpl['wall1_z'];
$wall1_w	=ceil($dat_tmpl['wall1_w']*$b);
$wall1_h	=ceil($dat_tmpl['wall1_h']*$b);
$wall1_x	=ceil($dat_tmpl['wall1_x']*$b);
$wall1_y	=ceil($dat_tmpl['wall1_y']*$b);

$wall2		=$dat_tmpl['wall2'];
$wall2_o	=$dat_tmpl['wall2_o'];
$wall2_z	=$dat_tmpl['wall2_z'];
$wall2_w	=ceil($dat_tmpl['wall2_w']*$b);
$wall2_h	=ceil($dat_tmpl['wall2_h']*$b);
$wall2_x	=ceil($dat_tmpl['wall2_x']*$b);
$wall2_y	=ceil($dat_tmpl['wall2_y']*$b);

$wall3		=$dat_tmpl['wall3'];
$wall3_o	=$dat_tmpl['wall3_o'];
$wall3_z	=$dat_tmpl['wall3_z'];
$wall3_x	=ceil($dat_tmpl['wall3_x']*$b);
$wall3_y	=ceil($dat_tmpl['wall3_y']*$b);
$wall3_w	=ceil($dat_tmpl['wall3_w']*$b);
$wall3_h	=ceil($dat_tmpl['wall3_h']*$b);

$frame0_w	=ceil($dat_tmpl['frame0_w']*$b);
$frame1_w	=ceil($dat_tmpl['frame1_w']*$b);

$name_font	="./font/".$font_list[$dat_tmpl['name_font']];
$orgin_font	="./font/".$font_list[$dat_tmpl['orgin_font']];
$cont_font	="./font/RobotoCondensed-Regular.ttf";
$icon_font	="./font/font_01/fonts/icomoon.ttf";

$lay[1]=$dat_tmpl["name_z"];
$lay[2]=$dat_tmpl["orgin_z"];
$lay[3]=$dat_tmpl["contact_z"];

$lay[4]=$dat_tmpl["wall0_z"];
$lay[5]=$dat_tmpl["wall1_z"];
$lay[6]=$dat_tmpl["wall2_z"];
$lay[7]=$dat_tmpl["wall3_z"];
$lay[8]=$dat_tmpl["frame0_z"];
$lay[9]=$dat_tmpl["frame1_z"];


asort($lay);

if(!$result_info || !$result_tmpl){
//	die();
}

$tmp2 	= imagecreatetruecolor($base_x, $base_y);
$tmpn 	= imagecreatetruecolor($base_x, $base_y);

$wh=ImageColorAllocate($tmp2,255,255,255);
imagefill($tmp2, 0, 0, $wh);

$whn=ImageColorAllocate($tmpn,255,255,255);
imagefill($tmpn, 0, 0, $whn);

$o_height	=ceil(($base_y*100)/($id_zoom));
$o_width	=ceil(($base_x*100)/($id_zoom));

if($id_wturn==180 && $id_vturn ==180){
	imageflip($img_url, IMG_FLIP_BOTH);

}elseif($id_vturn ==180){
	imageflip($img_url, IMG_FLIP_VERTICAL);

}elseif($id_wturn==180){
	imageflip($img_url, IMG_FLIP_HORIZONTAL);
}

if($id_gray>0){
	imagefilter($img_url, IMG_FILTER_GRAYSCALE);

}elseif($id_sepia>0){
	imagefilter($img_url, IMG_FILTER_GRAYSCALE);
	$id_bright+=20;

    ImageSetPixel($img_url, $width, $height, ImageColorResolve($img_url, $r1, $g1, $b1));

	for ($y=$id_top; $y < $base_img_h+$id_top; $y++) {
		for ($x=$id_left; $x < $base_img_w+$id_left; $x++) {

			$pixel = ImageColorAt($img_url, $x, $y);
			$r1 = ($pixel >> 16) & 0xff;
			$g1 = ($pixel >> 8)  & 0xff;
			$b1 = $pixel & 0xff;
			$b1+=10;

			$r1 = ($b1 * 245) / 255;
			$g1 = ($b1 * 205) / 255;
			$b1 = ($b1 * 152) / 255;
			ImageSetPixel($img_url, $x, $y, ImageColorResolve($img_url, $r1, $g1, $b1));
		}
	}
}

if($id_bright !=0){
	imagefilter($img_url, IMG_FILTER_BRIGHTNESS,$id_bright);
}

ImageCopyResampled($tmp2, $img_url, 0, 0, $id_left, $id_top, $base_x, $base_y, $base_img_w, $base_img_h);
ImageCopyResampled($tmpn, $img_url, 0, 0, $id_left, $id_top, $base_x, $base_y, $base_img_w, $base_img_h);

//■name-------------------------------
for($n=0;$n<mb_strlen($name);$n++){
    $t_name[].=mb_substr($name,$n,1,"UTF-8");
}

if($dat_tmpl["name_d"] == 1){
    $name = join("\n",$t_name);
}

$name_size_tmp	=ImageTTFBBox($name_size,0,$name_font,$name);
$name_w		=$name_size_tmp[2]-$name_size_tmp[0];
$name_h		=$name_size_tmp[3]-$name_size_tmp[5];

if($dat_tmpl['name_d']==1){
	$name_h1	=floor($name_h/count($t_name));

}else{
	$name_h1	=$name_size_tmp[5]*(-1);
}

if($dat_tmpl['name_p']>=4){
	if($dat_tmpl['name_d']==1){
		$name_y=$base_y-$name_y-$dat_tmpl['name_shadow_size']-$dat_tmpl['name_line_size']-$name_h;
	}else{
		$name_y=$base_y-$name_y-$dat_tmpl['name_shadow_size']-$dat_tmpl['name_line_size'];
	}

}else{
	$name_y-=$name_size_tmp[5]+$dat_tmpl['name_shadow_size']+$dat_tmpl['name_line_size'];
}


if($dat_tmpl['name_p']==2 ||$dat_tmpl['name_p']==5){
	$name_x		=floor(($base_x-$name_w)/2);

}elseif($dat_tmpl['name_p']==3 || $dat_tmpl['name_p']==6){
	$name_x		=$base_x-$name_w-$name_x-$dat_tmpl['name_shadow_size']-$dat_tmpl['name_line_size'];

}else{
	$name_x		+=$dat_tmpl['name_shadow_size']+$dat_tmpl['name_line_size'];
}


//■orgin-------------------------------
for($n=0;$n<mb_strlen($orgin);$n++){
    $t_orgin[].=mb_substr($orgin,$n,1,"UTF-8");
}

if($dat_tmpl["orgin_d"] == 1){
    $orgin = join("\n",$t_orgin);
}

$size_tmp	=ImageTTFBBox($orgin_size,0,$orgin_font,$orgin);
$orgin_w	=$size_tmp[2]-$size_tmp[0];
$orgin_h	=$size_tmp[3]-$size_tmp[5];

if($dat_tmpl['orgin_d']==1){
	$orgin_h1	=floor($orgin_h/count($t_orgin));

}else{
	$orgin_h1	=$size_tmp[5]*(-1);
}

if($dat_tmpl['orgin_p']>=4 && $dat_tmpl['orgin_p']<7 ){
	if($dat_tmpl['orgin_d']==1){
	    $orgin_y=$base_y - $orgin_y-$orgin_h;
	}else{
	    $orgin_y=$base_y - $orgin_y;
	}

}elseif($dat_tmpl['orgin_p']<4){
	$orgin_y-=$size_tmp[5];
}

if($dat_tmpl['orgin_p']==2 ||$dat_tmpl['orgin_p']==5){
	$orgin_x		=floor(($base_x-$orgin_w)/2);

}elseif($dat_tmpl['orgin_p']==3 || $dat_tmpl['orgin_p']==6){
	$orgin_x		=$base_x-$orgin_w-$orgin_x;

}elseif($dat_tmpl['orgin_p']==7){
	$orgin_x		+=$name_x;
	$orgin_y		+=$name_y;
}

//■contact-------------------------------
$cont1=0;
if($mail) $cont1++;
if($twitter) $cont1++;
if($insta) $cont1++;
if($url) $cont1++;
if($cosp) $cont1++;


$f_size	=11*$b;//font-size
$f_margin=18*$b;//font-margin(y)
$i_margin=5*$b;//icon-margin(x)

$leng[0]=strlen($twitter);
$leng[1]=strlen($insta);
$leng[2]=strlen($cosp);

$x_len=max($leng[2]);


$cont_w=150*$b;//box-width

if($dat_tmpl['contact_p']<4){
	$cont_y1=$contact_y;
	$cont_y2=$contact_y+$cont1*$f_margin+floor($f_margin/2)-2;

}else{
	$cont_y2=$base_y-$contact_y;
	$cont_y1=$cont_y2-$cont1*$f_margin-floor($f_margin/2)+2;
}

if($dat_tmpl['contact_p']==1 ||$dat_tmpl['contact_p']==4){
	$cont_x1=$contact_x;
	$cont_x2=$contact_x+$cont_w;

}elseif($dat_tmpl['contact_p']==3 ||$dat_tmpl['contact_p']==6){
	$cont_x1=$base_x-$contact_x-$cont_w;
	$cont_x2=$base_x-$contact_x;

}else{
	$cont_x1=floor(($base_x-$cont_w)/2);
	$cont_x2=$cont_x1+$cont_w;
}


foreach($lay as $a1 => $a2){
	include_once("./inc/inc_{$a1}.php");
}

if($qr !=2){
	include_once("./qr_img.php");
}

$tmp3 =imagecreatetruecolor($print_x0,$print_y0);
$bk=ImageColorAllocate($tmp3,0,0,0);
$wh3=ImageColorAllocate($tmp3,255,255,255);

imagefill($tmp3, 0, 0, $wh3);

$base_x	-= 10;
$base_y	-= 15;

//■縦軸--------------
for($n=0;$n<4;$n++){	
	imageline($tmp3, $base_x*$n+50+$n, 50, $base_x*$n+90+$n, 50, $bk);
	imageline($tmp3, $base_x*$n+70+$n, 50, $base_x*$n+70+$n, 70, $bk);

	imageline($tmp3, $base_x*$n+50+$n, $base_y+140, $base_x*$n+90+$n, $base_y+140, $bk);
	imageline($tmp3, $base_x*$n+70+$n, $base_y+120, $base_x*$n+70+$n, $base_y+140, $bk);
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

$rd=ImageColorAllocate($tmp3,255,0,0);
imagettftext($tmp3, 30, 0, 200, 1150, $rd, $cont_font, $now);

imagejpeg($tmpn,$img_url2,100);
imagejpeg($tmp2,$img_url1,100);
imagejpeg($tmp3,$dir."print.jpg",100);
}

$sql ="INSERT INTO me_making(`use_tmpl`, makedate, user_id, name, orgin, `url`, `insta`, twitter, cosp, img, img2, `top`, `left`, zoom, rote, wturn, vturn, bright, sepia, gray)";
$sql.=" VALUES('{$tmpl}','{$now}','{$_SESSION["id"]}','{$name}','{$orgin}','{$url}','{$insta}','{$twitter}','{$cosp}','{$_POST["img_url1"]}','{$_POST["img_url2"]}','{$id_top}','{$id_left}','{$id_zoom}','{$id_rote}','{$id_wturn}','{$id_vturn}','{$id_bright}','{$id_sepia}','{$id_gray}')";
mysqli_query($mysqli,$sql);

$tmp_auto=mysqli_insert_id($mysqli);	
$tmp_auto=substr("00000".$tmp_auto,-5);

for($r=0;$r<5;$r++){
	$rnd=rand(0,19);
	$tmp=substr($tmp_auto,$r,1);
	$e_code.=$me_code[$rnd][$tmp];
}

$text=urlencode("【Only Me】で名刺を作りました！");
$hash=urlencode("OnlyMe");

$_SESSION["token"]="";
$day=date("Ymd");
$sql_log2="INSERT INTO log(`date`,`day`,`log_no`,`user_id`,`exp`)";
$sql_log2.=" VALUES('{$date}','{$day}','302','{$_SESSION["id"]}',5)";
mysqli_query($mysqli,$sql_log2);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」:making-4</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,画像修正,onlyme,名刺作成,無料,簡単,とうらぶ,ボカロ">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/making.css?_<?=date("YmdHi")?>">
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/first.js?_<?=date("YmdHi")?>"></script>

<script>
$(function(){ 
	$('.ck').fadeIn(500).delay(1000).fadeOut(800);				
});
</script>

<style>
</style>
</head>
<body class="body">
<?include_once("./x_head.php")?>
<div class="main5">
	<img src="<?=$img_url1?>?t=<?=time()?>" class="img_pg">
	<a href="./mydata.php?tag=print" class="ok_btn ok4"></a>
	<a href="https://twitter.com/intent/tweet?text=<?=$text?>&url=https://onlyme.fun/pg.php?es=<?=$e_code?>&related=onlyme_staff&hashtags=<?=$hash?>" target="_BLANK" class="ok_btn ok5"></a>
	</div>

<?include_once("./x_foot.php")?>
</body>
</html>

