<?php
include_once("./library/no_session.php");

$es		=$_REQUEST["es"];
//6wylmln8bj
$sql ="SELECT * FROM `me_encode`";
if($re = mysqli_query($mysqli,$sql)){
	while($de = mysqli_fetch_assoc($re)){
		$me_enc[$de["key"]]=$de["value"];
	}
}

$t=strlen($es)/2;
for($n=0;$n<$t;$n++){
    $t2=substr($es,$n*2,2);
    $jump_id.=$me_enc[$t2];			
}
$jump_id+=0;

$sql ="SELECT user_id, img2 FROM `me_making`";
$sql.=" WHERE making_id='{$jump_id}'";
$sql.=" AND del='0'";
$sql.=" LIMIT 1";

$re = mysqli_query($mysqli,$sql);
$de = mysqli_fetch_assoc($re);
if($de["img2"]){
	for($n=0;$n<4;$n++){
		$tmp_key=substr($de["user_id"],$n*2,2);
		$tmp_enc[$n]=$enc[$tmp_key];
	}

	$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
	$sub_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$de["img2"]}";
}else{
	$sub_img	="./myalbum/tw/amtwagaltwal/agtw/mfcvpfbxai.jpg";
}


$tmp_img=imagecreatetruecolor(1200,630);

$img_url	= imagecreatefromjpeg($sub_img);
$img_url	=ImageRotate($img_url, 8, 255);
$img_card	= imagecreatefrompng("./img/twittercard.png");

$m_x=imagesx($img_url); 
$m_y=imagesy($img_url); 

//print($m_x."■".$m_y."■".$sub_img."<br>\n");

ImageCopyResampled($tmp_img, $img_url, 134, 24, 0, 0, 404,  587, $m_x,  $m_y);
ImageCopy($tmp_img, $img_card, 0, 0, 0, 0, 1200,  630);


header('Content-Type: image/png');
Imagepng($tmp_img);
?>
