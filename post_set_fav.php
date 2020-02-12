<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 

$user_id	=$_REQUEST["user_id"];
$host_id	=$_REQUEST["host_id"];
$fav_set	=$_REQUEST["fav_set"]+0;

$date=date("Y-m-d H:i:s");
$day=date("Ymd");

$sql ="SELECT fav_id FROM me_fav";
$sql.=" WHERE `fav_user_id`='{$user_id}'";
$sql.=" AND `fav_host_id`='{$host_id}'";
$re = mysqli_query($mysqli,$sql);
$re2 = mysqli_fetch_assoc($re);

if($re2["fav_id"]>0){
	$sql_log ="UPDATE `me_fav` SET";
	$sql_log.=" `fav_date`='{$date}',";
	$sql_log.=" `fav_set`='{$fav_set}'";
	$sql_log.=" WHERE fav_host_id='{$host_id}'";
	$sql_log.=" AND fav_user_id='{$user_id}'";
	mysqli_query($mysqli,$sql_log);

}else{
	$sql_log="INSERT INTO me_fav(`fav_date`,`fav_host_id`,`fav_user_id`,`fav_set`)";
	$sql_log.=" VALUES('{$date}','{$host_id}','{$user_id}','{$fav_set}')";
	mysqli_query($mysqli,$sql_log);

	$sql ="SELECT notice_id FROM me_notice";
	$sql.=" WHERE `n_user_id`='{$user_id}'";
	$sql.=" AND `n_target_id`='{$host_id}'";
	$de = mysqli_query($mysqli,$sql);
	$de2 = mysqli_fetch_assoc($de);

	if(!$re2["notice_id"]){

		$sql ="SELECT fav_id FROM me_fav";
		$sql.=" WHERE `fav_user_id`='{$host_id}'";
		$sql.=" AND `fav_host_id`='{$user_id}'";
		$se = mysqli_query($mysqli,$sql);
		$se2 = mysqli_fetch_assoc($se);

		if($se2["fav_id"]>0){
			$log=3;
		}else{
			$log=2;
		}

		$sql_log="INSERT INTO me_notice(`date`,`notice_log`,`n_user_id`,`n_target_id`)";
		$sql_log.=" VALUES('{$date}','{$log}','{$user_id}','{$host_id}')";
		mysqli_query($mysqli,$sql_log);
	}
}

?>