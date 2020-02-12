<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$_SESSION["id"]){
	$url = 'https://onlyme.fun/index.php';
	header('Location: ' . $url, true, 301);
	exit;
}

$size_x=275;
$size_y=455;
$rate=0.28;
$nowpage=3;

$_SESSION["token"]=3;

$id_top		=$_POST["id_top"]-3;
$id_left	=$_POST["id_left"]-3;

$id_height	=$_POST["id_height"];
$id_width	=$_POST["id_width"];


$id_zoom	=$_POST["id_zoom"];
$base_zoom	=$_POST["base_zoom"];

$id_rote	=$_POST["id_rote"];
$id_wturn	=$_POST["id_wturn"];
$id_vturn	=$_POST["id_vturn"];

$id_bright	=$_POST["id_bright"];
$id_sepia	=$_POST["id_sepia"];
$id_gray	=$_POST["id_gray"];

$name		=$_POST["name"];
$orgin		=$_POST["orgin"];
$mail		=$_POST["mail"];
$url		=$_POST["url"];
$twitter	=$_POST["twitter"];
$insta		=$_POST["insta"];
$cosp		=$_POST["cosp"];
$qr			=$_POST["qr"];
$tmpl		=$_POST["tmpl"]+0;

$img_url1	=$_POST["img_url1"];
$img_url2	=$_POST["img_url2"];

$img_url.=$dir.$img_url1;
$img_tmp = getimagesize($img_url);

if($img_tmp){
	list($width, $height, $type, $attr) = $img_tmp;
	$img_w=$width * $id_zoom * $base_zoom/100;
	$img_h=$height * $id_zoom * $base_zoom/100;

}else{
	$msg="画像ファイルがありません";
}

$sql ="SELECT * FROM me_tmpl";
$sql.=" WHERE tmpl_id='{$tmpl}'";
$sql.=" LIMIT 1";

if($result_tmpl = mysqli_query($mysqli,$sql)){
	$dat_tmpl = mysqli_fetch_assoc($result_tmpl);
}

$name_x=$dat_tmpl['name_x']*$rate;
$name_y=$dat_tmpl['name_y']*$rate;
$name_z=$dat_tmpl['name_z'];
$name_p=$dat_tmpl['name_p'];

$name_r=$dat_tmpl['name_r'];
$name_d=$dat_tmpl['name_d'];

$name_size			=$dat_tmpl['name_size']*$rate;
$name_color			=$dat_tmpl['name_color'];

$name_line_size		=$dat_tmpl['name_line_size']*$rate;
$name_line_color	=$dat_tmpl['name_line_color'];

$name_shadow_size	=$dat_tmpl['name_shadow_size']*$rate;
$name_shadow_color	=$dat_tmpl['name_shadow_color'];

$orgin_x			=$dat_tmpl['orgin_x']*$rate;
$orgin_y			=$dat_tmpl['orgin_y']*$rate;
$orgin_z			=$dat_tmpl['orgin_z'];
$orgin_p			=$dat_tmpl['orgin_p'];

$orgin_r			=$dat_tmpl['orgin_r'];
$orgin_d			=$dat_tmpl['orgin_d'];


$orgin_size			=$dat_tmpl['orgin_size']*$rate;
$orgin_color		=$dat_tmpl['orgin_color'];
$orgin_line_color	=$dat_tmpl['orgin_line_color'];
$orgin_line_size	=$dat_tmpl['orgin_line_size']*$rate;

$contact_x			=$dat_tmpl['contact_x']*$rate;
$contact_y			=$dat_tmpl['contact_y']*$rate;
$contact_z			=$dat_tmpl['contact_z'];
$contact_p			=$dat_tmpl['contact_p'];

$contact_color		=$dat_tmpl['contact_color'];
$contact_line_size	=$dat_tmpl['contact_line_size']*$rate;
$contact_shadow_size=$dat_tmpl['contact_shadow_size']*$rate;

//■名前---------------------------------------------
$dat0 =".word1{";
	$dat0.="z-index:".$name_z.";";
	$dat0.="position:absolute;";
	
	$name_font	="./font/".$font_list[$dat_tmpl['name_font']];
	$name_size_tmp	=ImageTTFBBox(floor($name_size*0.75),0,$name_font,$name);
	
	$name_w		=$name_size_tmp[2]-$name_size_tmp[0];
	$name_h		=$name_size_tmp[3]-$name_size_tmp[5];
	
	if($name_d==1){
		$tmp	=$name_w;	
		$name_w	=$name_h;	
		$name_h	=$tmp+mb_strlen($name);	
	
		$dat0.="writing-mode: vertical-rl;";
		$dat0.="text-orientation: upright;";
		$dat0.="letter-spacing:1vw;";
		$dat0.="width:{$name_w}vw;";
	}
	
	if($name_p==2 ||$name_p==5){
		$dat0.="left:0;";
		$dat0.="right:0;";
		$dat0.="margin:auto;";
	
	}elseif($name_p==1 || $name_p==4){
		$dat0.="left:{$name_x}vw;";
	
	}elseif($name_p==3 || $name_p==6){
		$dat0.="right:{$name_x}vw;";
	}
	
	if($name_p<=3){
		$dat0.="top:{$name_y}vw;";
	}else{
		$dat0.="bottom:{$name_y}vw;";
	}
	
	
	$dat0.="color:{$dat_tmpl['name_color']};";
	$dat0.="font-size:{$name_size}vw;";
	$dat0.="font-family:at_name;";
	$dat0.="}";
	
	if($name_line_size>0){
		$tmp=$name_line_size*2;
		$dat0.=".word1_1{";
		$dat0.="text-stroke: {$tmp}vw {$name_line_color};";
		$dat0.="-webkit-text-stroke: {$tmp}vw {$name_line_color};";
		$dat0.="}";
	}
	
	if($name_shadow_size>0){
		$tmp=$name_shadow_size+$name_line_size;
		$dat0.=".word1_2{";
		$dat0.="text-shadow:"; 
		$dat0.="{$tmp}vw {$tmp}vw {$name_shadow_color};";
		$dat0.="}";
	}
	
	//---------------------------------------------
	
	$dat0.=".word2{";
	$dat0.="position:absolute;";
	
	if($contact_p <4){
		$contact_y=$contact_y+$contact_line_size;
		$dat0.="top:{$contact_y}vw;";
		
	}else{
		$contact_y=$contact_y-$contact_line_size;
		$dat0.="bottom:{$contact_y}vw;";
	}
	
	if($contact_p ==1 ||$contact_p ==4){
		$contact_x=$contact_x-$contact_line_size;
		$dat0.="left:{$contact_x}vw;";
	
	}elseif($contact_p ==3 ||$contact_p ==6){
		$contact_x=$contact_x+$contact_line_size;
		$dat0.="right:{$contact_x}vw;";
	
	}else{
		$dat0.="left:0;";
		$dat0.="right:0;";
		$dat0.="margin:auto;";
	}
	
	$dat0.="display:inline-block;";
	
	$dat0.="width:42vw;";
	$dat0.="padding:0.4vw;";
	$dat0.="font-size:3.4vw;";
	$dat0.="line-height:3.4vw;";
	
	$dat0.="font-family:at_contact;";
	$dat0.="text-align:left;";
	
	$dat0.="color:{$dat_tmpl['contact_color']};";
	$dat0.="z-index:{$dat_tmpl['contact_z']};";
	
	if(strpos($dat_tmpl['contact'], "png")){
		$dat0.="background-image: url({$dat_tmpl['contact']});";
	
	}elseif($dat_tmpl['contact']){
		$tmp=str_replace("#","",$dat_tmpl['contact']);
		$r=hexdec(substr($tmp,0,2));
		$g=hexdec(substr($tmp,2,2));
		$b=hexdec(substr($tmp,4,2));
		$o=$dat_tmpl['contact_o'];
		$dat0.="background: rgba({$r},{$g},{$b},{$o});";
	}
	
	if($contact_line_size>0){
		$dat0.="border: {$contact_line_size}vw solid {$dat_tmpl['contact_line_color']};";
	}
	
	if($contact_shadow_size>0){
		$dat0.="box-shadow: {$contact_shadow_size}vw {$contact_shadow_size}vw {$contact_shadow_size}vw {$dat_tmpl['contact_shadow_color']};";
	}
	$dat0.="}";
	
	
	if($dat_tmpl['orgin_p']){
	
		$orgin_font	="./font/".$font_list[$dat_tmpl['name_font']];
		$orgin_size_tmp	=ImageTTFBBox(floor($orgin_size*0.75),0,$orgin_font,$orgin);
		
		$orgin_w		=$orgin_size_tmp[2]-$orgin_size_tmp[0];
		$orgin_h		=$orgin_size_tmp[3]-$orgin_size_tmp[5];
	
		$dat0.=".word3{";
		$dat0.="z-index:{$dat_tmpl['orgin_z']};";
		$dat0.="position:absolute;";
	
		if($orgin_d==1){
			$tmp	=$orgin_w;	
			$orgin_w	=$orgin_h;	
			$orgin_h	=$tmp+mb_strlen($orgin);	
	
			$dat0.="writing-mode: vertical-rl;";
			$dat0.="text-orientation: upright;";
			$dat0.="letter-spacing:1vw;";
			$dat0.="width:{$orgin_w}vw;";
		}
		
		if($dat_tmpl['orgin_p']==1 ||$dat_tmpl['orgin_p']==4){
			$tmp_x=$dat_tmpl['orgin_x']*$rate;
			$dat0.="left:{$tmp_x}vw;";
	
		}elseif($dat_tmpl['orgin_p']==2 ||$dat_tmpl['orgin_p']==5){
			$dat0.="left:0;";
			$dat0.="right:0;";
			$dat0.="margin:auto;";
	
		}elseif($dat_tmpl['orgin_p']==3 ||$dat_tmpl['orgin_p']==6){
			$tmp_x=$dat_tmpl['orgin_x']*$rate;
			$dat0.="right:{$tmp_x}vw;";
	
		}else{
			$tmp_x=$name_x+$dat_tmpl['orgin_x']*$rate;
			$tmp_y=$name_y+$dat_tmpl['orgin_y']*$rate;
			$dat0.="left:{$tmp_x}vw;";
			$dat0.="top:{$tmp_y}vw;";
		}
	
		if($dat_tmpl['orgin_p']<4){
			$tmp_y=$dat_tmpl['orgin_y']*$rate;
			$dat0.="top:{$tmp_y}vw;";
	
		}elseif($dat_tmpl['orgin_p']<7){
			$tmp_y=$dat_tmpl['orgin_y']*$rate;
			$dat0.="bottom:{$tmp_y}vw;";
		}
	
		$dat0.="color:{$dat_tmpl['orgin_color']};";
		$dat0.="font-size:{$orgin_size}vw;";
		$dat0.="font-family:at_orgin;";
		$dat0.="}";
	
		if($orgin_line_size>0){
			$dat0.=".word3_1{";
			$dat0.="text-stroke: {$orgin_line_size}vw {$orgin_line_color};";
			$dat0.="-webkit-text-stroke: {$orgin_line_size}vw {$orgin_line_color};";
			$dat0.="}";
		}
	}

	$w_ar[0]='wall0';
	$w_ar[1]='wall1';
	$w_ar[2]='wall2';
	$w_ar[3]='wall3';
	
	for($w=0;$w<4;$w++){
	if($dat_tmpl[$w_ar[$w]]){
		$dat0.=".{$w_ar[$w]}{";
		if($dat_tmpl[$w_ar[$w].'_l'] == 1){
	
			$w_x	=$name_x -$dat_tmpl[$w_ar[$w].'_x']*$rate;
			$w_y	=$name_y -$dat_tmpl[$w_ar[$w].'_y']*$rate;
	
			$w_w	=$name_w +$dat_tmpl[$w_ar[$w].'_x']*$rate+$dat_tmpl[$w_ar[$w].'_w']*$rate;
			$w_h	=$name_h +$dat_tmpl[$w_ar[$w].'_y']*$rate+$dat_tmpl[$w_ar[$w].'_h']*$rate;
	
			if($name_p ==1 || $name_p ==4){
				$dat0.="left:{$w_x}vw;";
	
			}elseif($name_p ==3 || $name_p ==6){
				$dat0.="right:{$w_x}vw;";
	
			}else{
				$dat0.="right:0;";
				$dat0.="left:0;";
				$dat0.="margin:auto;;";
			}
	
			if($name_p <4){
				$dat0.="top:{$w_y}vw;";
	
			}else{
				$dat0.="bottom:{$w_y}vw;";
			}
	
		}elseif($dat_tmpl[$w_ar[$w].'_l'] == 2){
			$w_x	=$contact_x -$dat_tmpl[$w_ar[$w].'_x']*$rate;
			$w_y	=$contact_y -$dat_tmpl[$w_ar[$w].'_y']*$rate;
			$w_w	=42 +$dat_tmpl[$w_ar[$w].'_x']*$rate+$dat_tmpl[$w_ar[$w].'_w']*$rate;
			$w_h	=17.5 +$dat_tmpl[$w_ar[$w].'_y']*$rate+$dat_tmpl[$w_ar[$w].'_h']*$rate;
	
			if($contact_p ==1 || $contact_p ==4){
				$dat0.="left:{$w_x}vw;";
	
			}elseif($contact_p ==3 || $contact_p ==6){
				$dat0.="right:{$w_x}vw;";
	
			}else{
				$dat0.="right:0;";
				$dat0.="left:0;";
				$dat0.="margin:auto;;";
			}
			if($contact_p <4){
				$dat0.="top:{$w_x}vw;";
	
			}else{
				$dat0.="bottom:{$w_x}vw;";
			}
	
	
		}elseif($dat_tmpl[$w_ar[$w].'_l'] == 3){
			$w_x	=$orgin_x -$dat_tmpl[$w_ar[$w].'_x']*$rate;
			$w_y	=$orgin_y -$dat_tmpl[$w_ar[$w].'_y']*$rate;
			$w_w	=$orgin_w +$dat_tmpl[$w_ar[$w].'_x']*$rate+$dat_tmpl[$w_ar[$w].'_w']*$rate;
			$w_h	=$orgin_h +$dat_tmpl[$w_ar[$w].'_y']*$rate+$dat_tmpl[$w_ar[$w].'_h']*$rate;
	
			if($orgin_p ==1 || $orgin_p ==4){
				$dat0.="left:{$w_x}vw;";
	
			}elseif($orgin_p ==3 || $orgin_p ==6){
				$dat0.="right:{$w_x}vw;";
	
			}else{
				$dat0.="right:0;";
				$dat0.="left:0;";
				$dat0.="margin:auto;;";
			}
	
			if($orgin_p <4){
				$dat0.="top:{$w_y}vw;";
	
			}else{
				$dat0.="bottom:{$w_y}vw;";
			}
	
		}else{
			$w_x	=$dat_tmpl[$w_ar[$w].'_x']*$rate;
			$w_y	=$dat_tmpl[$w_ar[$w].'_y']*$rate;
			$w_w	=$dat_tmpl[$w_ar[$w].'_w']*$rate;
			$w_h	=$dat_tmpl[$w_ar[$w].'_h']*$rate;
			$dat0.="top:{$w_y}vw;";
			$dat0.="left:{$w_x}vw;";
		}
	
	
		$dat0.="width:{$w_w}vw;";
		$dat0.="height:{$w_h}vw;";
	
		$dat0.="display:inline-block;";
		$dat0.="position:absolute;";
		$dat0.="z-index:{$dat_tmpl[$w_ar[$w].'_z']};";
	
		if(strpos($dat_tmpl[$w_ar[$w]], "png")){
			$dat0.="background-image: url(./img/wall/{$dat_tmpl[$w_ar[$w]]});";
			$dat0.="background-size: cover;";
			$dat0.="opacity:{$dat_tmpl[$w_ar[$w].'_o']}";
	
		}else{
			$tmp=str_replace("#","",$dat_tmpl[$w_ar[$w]]);
			$r=hexdec(substr($tmp,0,2));
			$g=hexdec(substr($tmp,2,2));
			$b=hexdec(substr($tmp,4,2));
			$o=$dat_tmpl[$w_ar[$w].'_o'];
			$dat0.="background: rgba({$r},{$g},{$b},{$o});";
		}
			$dat0.="}";
	}
	}
	
	if($qr != 2){
		$dat0.=".qr{";
		$qr_x=$dat_tmpl['qr_x']*$rate;
		$qr_y=$dat_tmpl['qr_y']*$rate;
	
		if($dat_tmpl['qr_p']<=2){
			$inc_1="top:{$qr_y}vw;";
			$inc_2="top:{$qr_y}vw;";
		}else{
			$inc_1="bottom:{$qr_y}vw;";
			$inc_2="bottom:{$qr_y}vw;";
		}
	
		if($dat_tmpl['qr_p']==1 ||$dat_tmpl['qr_p']==3 ){
			$inc_1.="left:{$qr_x}vw;";
			$tmp=$qr_x+40*$rate;
			$inc_2.="left:{$tmp}vw;";
	
		}else{
			$inc_1.="right:{$qr_x}vw;";
			$tmp=$qr_x+40*$rate;
			$inc_2.="right:{$tmp}vw;";
		}
			$dat0.="color:{$dat_tmpl['qr_top']};";
			$dat0.="font-size:3.5vw;";
			$dat0.="}";
	
		$dat0.=".qr_code{";
			$dat0.="z-index:200;";
			$dat0.="position:absolute;";
			$dat0.="background:{$dat_tmpl['qr_base']};";
			$dat0.="font-size:16vw;";
			$dat0.="height:16vw;";
			$dat0.="line-height:16vw;";
			$dat0.="width:16vw;";
			$dat0.="text-algin:center;";
			$dat0.=$inc_1;
		$dat0.="}";
	}
	
	if($dat_tmpl['frame0']){
		if(strpos($dat_tmpl['frame0'], "png")){
			$dat_f0 =".frame0{";
			$dat_f0.="z-index:{$dat_tmpl['frame0_z']};";
			$dat_f0.="background-image: url(./img/frame2/{$dat_tmpl['frame0']});";
			$dat_f0.="background-size:cover;";
			$dat_f0.="position:absolute;";
			$dat_f0.="top:0;";
			$dat_f0.="left:0;";
			$dat_f0.="width:77vw;";
			$dat_f0.="height:127.4vw;";
			$dat_f0.="}";
	
		}else{
			$tmp=str_replace("#","",$dat_tmpl['frame0']);
			$r=hexdec(substr($tmp,0,2));
			$g=hexdec(substr($tmp,2,2));
			$b=hexdec(substr($tmp,4,2));
			$o=$dat_tmpl['frame0_o'];
			$tmp_cl="background: rgba({$r},{$g},{$b},{$o});";
	
			$tmp_n=$dat_tmpl['frame0_w']*$rate;
			$tmp_x=77-$tmp_n-$tmp_n;
			$tmp_y=127.4;
	
			$dat_f0 =".frame0a{";
			$dat_f0.="z-index:{$dat_tmpl['frame0_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="top:0;";
			$dat_f0.="left:{$tmp_n};";
			$dat_f0.="width:{$tmp_x}vw;";
			$dat_f0.="height:{$tmp_n}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
	
			$dat_f0.=".frame0b{";
			$dat_f0.="z-index:{$dat_tmpl['frame0_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="top:0;";
			$dat_f0.="left:0;";
			$dat_f0.="width:{$tmp_n}vw;";
			$dat_f0.="height:{$tmp_y}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
	
			$dat_f0.=".frame0c{";
			$dat_f0.="z-index:{$dat_tmpl['frame0_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="top:0;";
			$dat_f0.="right:0;";
			$dat_f0.="width:{$tmp_n}vw;";
			$dat_f0.="height:{$tmp_y}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
	
			$dat_f0.=".frame0d{";
			$dat_f0.="z-index:{$dat_tmpl['frame0_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="bottom:0;";
			$dat_f0.="left:{$tmp_n};";
			$dat_f0.="width:{$tmp_x}vw;";
			$dat_f0.="height:{$tmp_n}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
		}
	}
	
	if($dat_tmpl['frame1']){
		if(strpos($dat_tmpl['frame1'], "png")){
			$dat_f0.=".frame1{";
			$dat_f0.="z-index:{$dat_tmpl['frame1_z']};";
	
			$dat_f0.="background-image: url(./img/frame2/{$dat_tmpl['frame1']});";
			$dat_f0.="position:absolute;";
			$dat_f0.="background-size:cover;";
			$dat_f0.="top:0;";
			$dat_f0.="left:0;";
			$dat_f0.="width:88vw;";
			$dat_f0.="height:145.6vw;";
			$dat_f0.="}";
	
		}else{
			$tmp=str_replace("#","",$dat_tmpl['frame1']);
			$r=hexdec(substr($tmp,0,2));
			$g=hexdec(substr($tmp,2,2));
			$b=hexdec(substr($tmp,4,2));
			$o=$dat_tmpl['frame1_o'];
			$tmp_cl="background: rgba({$r},{$g},{$b},{$o});";
	
			$tmp_n=$dat_tmpl['frame1_w']*$rate;
			$tmp_x=77-$tmp_n-$tmp_n;
			$tmp_y=127.4;
	
			$dat_f0 =".frame1a{";
			$dat_f0.="z-index:{$dat_tmpl['frame1_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="top:0;";
			$dat_f0.="left:{$tmp_n};";
			$dat_f0.="width:{$tmp_x}vw;";
			$dat_f0.="height:{$tmp_n}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
	
			$dat_f0.=".frame1b{";
			$dat_f0.="z-index:{$dat_tmpl['frame1_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="top:0;";
			$dat_f0.="left:0;";
			$dat_f0.="width:{$tmp_n}vw;";
			$dat_f0.="height:{$tmp_y}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
	
			$dat_f0.=".frame1c{";
			$dat_f0.="z-index:{$dat_tmpl['frame1_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="top:0;";
			$dat_f0.="right:0;";
			$dat_f0.="width:{$tmp_n}vw;";
			$dat_f0.="height:{$tmp_y}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
	
			$dat_f0.=".frame1d{";
			$dat_f0.="z-index:{$dat_tmpl['frame1_z']};";
			$dat_f0.="position:absolute;";
			$dat_f0.="bottom:0;";
			$dat_f0.="left:{$tmp_n};";
			$dat_f0.="width:{$tmp_x}vw;";
			$dat_f0.="height:{$tmp_n}vw;";
			$dat_f0.=$tmp_cl;
			$dat_f0.="}";
		}
	}
	
	$_POST="";
	$_REQUEsT="";
	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」:making-3</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="トライアルその3：PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,onlyme,名刺作成,無料">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/making.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>

<style>
@font-face {
	font-family: at_name;
	src: url(./font/<?=$font_list[$dat_tmpl['name_font']]?>) format('truetype');
}

@font-face {
	font-family: at_orgin;
	src: url(./font/<?=$font_list[$dat_tmpl['orgin_font']]?>) format('truetype');
}

.trim_img {
	z-index:0;
	position: absolute;
	top: <?=$id_top?>vw;
	left: <?=$id_left?>vw;
	width:<?=$img_w?>vw;
	height:<?=$img_h?>vw;
	filter: brightness(<?=$id_bright?>%)
	<?if($id_sepia>0){?> sepia(100%)<?}?>
	<?if($id_gray>0){?> grayscale(100%)<?}?>;

	<?if($id_wturn==180 && $id_vturn==180){?>
		transform: scale(-1, -1);

	<?}elseif($id_wturn==180){?>
		transform: scale(-1, 1);

	<?}elseif($id_vturn==180){?>
		transform: scale(1, -1);
	<?}?>	
}

<?if(!$twitter && !$insta && !$cosp){?>
		.word2{
			display:none;
		}

<?}else{?>
	<?if(!$twitter){?>
		.word2_twitter{display:none;}
	<? } ?>

	<?if(!$insta){?>
		.word2_insta{display:none;}
	<? } ?>

	<?if(!$cosp){?>
		.word2_cosp{display:none;}
	<? } ?>
<? } ?>

<?=$dat0?>
<?=$dat_w0?>
<?=$dat_f0?>
</style>
<script src="./js/first.js?_<?=date("YmdHi")?>"></script>
<script src="./js/trial.js?_<?=date("YmdHi")?>"></script>
</head>
<body class="body">
<div class="main5">
	<form id="forms" method="post">
		<input type="hidden" value="1" name="ck">
		<div class="ok_btn ok1" id="ok">作成</div>
		<div class="ok_btn ok2" id="ch">修正</div>
		<div class="ok_btn ok3" id="no">破棄</div>
		<div class="trim_ck dark">
			<img src="<?=$img_url?>" alt="" class="trim_img">
			<div class="word1 word1_1 word1_2"><?=$name?></div>
			<div class="word1"><?=$name?></div>
			<div class="word2">
				<span class="word2_twitter"><span class="icons3"></span><span class="contact_twitter"><?=$twitter?></span><br></span>
				<span class="word2_insta"><span class="icons3"></span><span class="contact_insta"><?=$insta?></span><br></span>
				<span class="word2_cosp"><span class="icons3"></span><span class="contact_cosp"><?=$cosp?></span><br></span>
			</div>
			<div class="word3 word3_1"><?=$orgin?></div>

			<div class="wall0"></div>
			<div class="wall1"></div>
			<div class="wall2"></div>
			<div class="wall3"></div>
			<div class="frame1"></div>
			<div class="frame1a"></div>
			<div class="frame1b"></div>
			<div class="frame1c"></div>
			<div class="frame1d"></div>
			<div class="frame0"></div>
			<div class="frame0a"></div>
			<div class="frame0b"></div>
			<div class="frame0c"></div>
			<div class="frame0d"></div>
		<?if($qr != 2){?><div class="qr"><span class="icon_img qr_code"></span></div><?}?>
		</div>

		<input type="hidden" name="name"	value="<?=$name?>">
		<input type="hidden" name="orgin"	value="<?=$orgin?>">
		<input type="hidden" name="mail"	value="<?=$mail?>">
		<input type="hidden" name="twitter"	value="<?=$twitter?>">
		<input type="hidden" name="cosp"	value="<?=$cosp?>">
		<input type="hidden" name="url"		value="<?=$url?>">
		<input type="hidden" name="qr"		value="<?=$qr?>">
		<input type="hidden" name="insta"	value="<?=$insta?>">

		<input id="id_top" type="hidden" name="id_top" value="<?=$id_top?>"><!--top--->
		<input id="id_left" type="hidden" name="id_left" value="<?=$id_left?>"><!--left-->

		<input id="id_height" type="hidden" name="id_height" value="<?=$id_height?>"><!--top--->
		<input id="id_width" type="hidden" name="id_width" value="<?=$id_width?>"><!--left-->

		<input id="id_zoom" type="hidden" name="id_zoom" value="<?=$id_zoom?>"><!--zoom-->
		<input id="id_rote" type="hidden" name="id_rote" value="<?=$id_rote?>"><!--rote-->
		<input id="id_wturn" type="hidden" name="id_wturn" value="<?=$id_wturn?>"><!--wturn-->
		<input id="id_vturn" type="hidden" name="id_vturn" value="<?=$id_vturn?>"><!--vturn-->
		<input id="id_bright" type="hidden" name="id_bright" value="<?=$id_bright?>"><!--bright-->
		<input id="id_sepia" type="hidden" name="id_sepia" value="<?=$id_sepia?>"><!--sepia-->
		<input id="id_gray" type="hidden" name="id_gray" value="<?=$id_gray?>"><!--gray-->

		<input type="hidden" name="img_url1" value="<?=$img_url1?>">
		<input type="hidden" name="img_url2" value="<?=$img_url2?>">
		<input type="hidden" name="tmpl" value="<?=$tmpl?>">
		<input type="hidden" name="base_zoom" value="<?=$base_zoom?>">

		<input id="vw_set" type="hidden" name="vw_set" value="">
	</form>
</div>
	<form id="forms2" method="post" action="./index.php">
		<input type="hidden" name="img_url1" value="<?=$img_url1?>">
		<input type="hidden" name="img_url2" value="<?=$img_url2?>">
	</form>

<?include_once("./x_foot.php")?>
</body>
</html>
