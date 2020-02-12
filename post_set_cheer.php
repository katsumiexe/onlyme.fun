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
$card_id	=$_REQUEST["card_id"];
$host_id	=$_REQUEST["host_id"];
$com		=$_REQUEST["com"];

$status		=$_REQUEST["status"]+0;
$del		=$_REQUEST["del"];

$date=date("Y-m-d H:i:s");
$day=date("Ymd");

if($com){
	$sql ="SELECT cheer_id FROM me_cheer";
	$sql.=" WHERE `c_card_id`='{$card_id}'";
	$sql.=" AND `c_user_id`='{$user_id}'";

	$re = mysqli_query($mysqli,$sql);
	$re2 = mysqli_fetch_assoc($re);

	if($re2["cheer_id"]>0){
		$sql_log="UPDATE me_cheer SET";
		$sql_log.=" com='{$com}',";
		$sql_log.=" status='{$status}',";
		$sql_log.=" del='{$del}',";
		$sql_log.=" cheer_date='{$date}'";

		$sql_log.=" WHERE c_card_id='{$card_id}'";
		$sql_log.=" AND c_user_id='{$user_id}'";
		mysqli_query($mysqli,$sql_log);	

	}else{
		$sql_log="INSERT INTO me_cheer(`cheer_date`,`c_card_id`,`c_host_id`,`c_user_id`,`com`,`status`,`del`)";
		$sql_log.=" VALUES('{$date}','{$card_id}','{$host_id}','{$user_id}','{$com}','{$status}','{$del}')";
		mysqli_query($mysqli,$sql_log);

		$sql_log2="INSERT INTO log(`date`,`day`,`log_no`,`user_id`,`target_id`,`exp`)";
		$sql_log2.=" VALUES('{$date}','{$day}','301','{$user_id}','{$card_id}',2)";
		mysqli_query($mysqli,$sql_log2);

		$sql_log="INSERT INTO me_notice(`date`,`notice_log`,`n_user_id`,`n_target_id`,`use_id`)";
		$sql_log.=" VALUES('{$date}','1','{$user_id}','{$host_id}','{$card_id}')";
		mysqli_query($mysqli,$sql_log);


		$sql2 ="SELECT count(log_id) as cnt, log_no, max(exp) as m_exp, day, action FROM log"; 
		$sql2.=" WHERE user_id='{$user_id}'";
		$sql2.=" GROUP BY day,log_no";

		$result2 = mysqli_query($mysqli,$sql2);
		while($row2 = mysqli_fetch_assoc($result2)){

			if($row2["log_no"] == 300){
				if($row2["cnt"]>10){
					$row2["cnt"]=10;
				}
				$exp+=	$row2["cnt"];

			}elseif($row2["log_no"] == 301){

				if($row2["cnt"]>5){
					$row2["cnt"]=5;
				}
				$exp+=	$row2["cnt"]*2;

			}elseif($row2["log_no"] == 302){
				$making+=$row2["cnt"];
				if($row2["cnt"]>2){
					$row2["cnt"]=2;
				}
				$exp+=	$row2["cnt"]*5;

			}else{
				$exp+=	$row2["m_exp"];
			}
		}
	}
}
echo($exp+0);
?>
