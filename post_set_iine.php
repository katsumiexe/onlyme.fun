<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
mysqli_set_charset($mysqli,'UTF-8'); 

$own		=$_REQUEST["own"];
$user_id	=$_REQUEST["user_id"];
$card_id	=str_replace("i","",$_REQUEST["card_id"]);
$iine_pt	=$_REQUEST["iine_pt"]+0;
$iine_nm	=$_REQUEST["iine_nm"];

$date=date("Y-m-d H:i:s");
$sql="SELECT * FROM me_iine";
$sql.=" WHERE i_card_id='{$card_id}'";
$sql.=" AND i_user_id='{$user_id}'";
$sql.=" LIMIT 1";

$iine_dt["pritty"]	=0;
$iine_dt["smart"]	=0;
$iine_dt["funny"]	=0;
$iine_dt["sexy"]	=0;

$iine_dt[$iine_nm]=$iine_pt;

$result = mysqli_query($mysqli,$sql);
$res2=mysqli_fetch_assoc($result);

$date=date("Y-m-d H:i:s");
$day=date("Ymd");

if(count($res2)>0){

	$sql_log ="UPDATE me_iine SET";
	$sql_log.=" `pritty`='{$iine_dt["pritty"]}', `smart`='{$iine_dt["smart"]}', `funny`='{$iine_dt["funny"]}', `sexy`='{$iine_dt["sexy"]}',";
	$sql_log.=" `i_date`='{$date}'";
	$sql_log.=" WHERE i_card_id='{$card_id}'";
	$sql_log.=" AND i_user_id='{$user_id}'";

}else{
	$sql_log2="INSERT INTO log(`date`,`day`,`log_no`,`user_id`,`target_id`,`exp`)";
	$sql_log2.=" VALUES('{$date}',{$day},300,{$user_id},{$card_id},1)";
	mysqli_query($mysqli,$sql_log2);

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


	$sql_log="INSERT INTO me_iine(`i_date`,`i_card_id`,`i_host_id`,`i_user_id`,`{$iine_nm}`)";
	$sql_log.=" VALUES('{$date}','{$card_id}','{$own}','{$user_id}','{$iine_pt}')";
}

mysqli_query($mysqli,$sql_log);
echo($exp);
?>
