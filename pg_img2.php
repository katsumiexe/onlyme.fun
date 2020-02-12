<?php
include_once("./library/no_session.php");

$es		=$_REQUEST["es"];
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

for($n=0;$n<4;$n++){
	$tmp_key=substr($de["user_id"],$n*2,2);
	$tmp_enc[$n]=$enc[$tmp_key];
}

$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
$sub_img	="./myalbum/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$de["img2"]}";



$img_url	= imagecreatefromjpeg($sub_img);
$tmp_img	= imagecreatefromjpeg("./img/ttt.jpg");
$img_url	=ImageRotate($img_url, 8, 255);

$m_x=imagesx($img_url); 
$m_y=imagesy($img_url); 

//print($m_x."■".$m_y."■".$sub_img."<br>\n");


ImageCopyResampled($tmp_img, $img_url, 10, 10, 0, 0, 404,  587, $m_x,  $m_y);

header('Content-Type: image/jpeg');
ImageJPEG($tmp_img);
?>
