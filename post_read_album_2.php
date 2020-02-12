<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$img_id =$_POST['img_id']+0;

$sql ="SELECT * FROM `me_making`";
$sql.=" WHERE `del`='0'";
$sql.=" AND making_id='{$img_id}'";
$sql.=" LIMIT 1";

$result = mysqli_query($mysqli,$sql);
$dat_i = mysqli_fetch_assoc($result);

$dat2["madate"]=substr($dat_i["makedate"],5,2)."/".substr($dat_i["makedate"],8,2)."　".substr($dat_i["makedate"],11,2).":".substr($dat_i["makedate"],14,2);
$dat2["url"]=$dat_i["img"];

echo json_encode($dat2);
//echo ($sql);
exit;
?>
