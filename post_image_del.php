<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

$img_url= $_REQUEST['img_url'];
$img_id	= $_REQUEST['img_id'];

$sql1  ="UPDATE me_making SET";
$sql1 .=" `del`=1";
$sql1 .=" WHERE making_id='{$img_id}'";
mysqli_query($mysqli,$sql1);

$sql ="UPDATE me_cheer SET";
$sql .=" `del`=1";
$sql .=" WHERE c_card_id='{$img_id}'";
mysqli_query($mysqli,$sql);

$sql ="UPDATE me_iine SET";
$sql .=" `pritty`=0,";
$sql .=" `smart``=0,";
$sql .=" `funny`=0,";
$sql .=" `sexy`=0";
$sql .=" WHERE i_card_id='{$img_id}'";
mysqli_query($mysqli,$sql);
/*
$sql ="SELECT user_id, `img`, img2 FROM me_making";
$sql .=" WHERE making_id='{$img_id}'";
$sql .=" LIMIT 1";

$re1=mysqli_query($mysqli,$sql);
$dat2=mysqli_fetch_assoc($re1);

for($n=0;$n<4;$n++){
    $tmp_key=substr($dat2["user_id"],$n*2,2);
    $tmp_enc[$n]=$enc[$tmp_key];
}
$list_enc   =$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
$main_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[2]}{$tmp_enc[3]}/{$dat2["img"]}";
$sub_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$dat2["img2"]}";

unlink($main_img);
unlink($sub_img);
*/

?>