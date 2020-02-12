<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$host_id	=$_POST["host_id"];
$img_id		=$_POST["img_id"];

$dat_p["exp"]	=0;
$dat_p["pritty"]=0;
$dat_p["smart"]	=0;
$dat_p["funny"]	=0;
$dat_p["sexy"]	=0;
$dat_p["fab"]	=0;
$dat_p["cheer"]	=0;

$sql2 ="SELECT count(log_id) as cnt, max(exp) as m_exp, max(date) as log_in, day, action FROM log"; 
$sql2.=" WHERE user_id='{$host_id}'";
$sql2.=" GROUP BY day,action";
$sql2.=" ORDER BY log_id DESC";

$result2 = mysqli_query($mysqli,$sql2);
while($row2 = mysqli_fetch_assoc($result2)){
	if(!$dat_p["login"]){
		$dat_p["login"]=	$row2["log_in"];
	}

	if($row2["action"] == 1){
		$dat_p["exp"]+=	$row2["m_exp"];

	}elseif($row2["action"] == 2){
		$making+=$row2["cnt"];
		if($row2["cnt"]>2){
			$row2["cnt"]=2;
		}
		$dat_p["exp"]+=	$row2["cnt"]*5;

	}elseif($row2["action"] == 3){
		if($row2["cnt"]>10){
			$row2["cnt"]=10;
		}
		$dat_p["exp"]+=	$row2["cnt"];

	}elseif($row2["action"] == 4){
		if($row2["cnt"]>5){
			$row2["cnt"]=5;
		}
		$dat_p["exp"]+=	$row2["cnt"]*2;
	}		
}
$dat_p["lv"]=floor($exp/500)+1;

//-------------------------------------------------------
$sql ="SELECT sum(pritty) AS s_pritty, sum(smart) AS s_smart, sum(funny) AS s_funny,sum(sexy) AS s_sexy, i_user_id FROM me_iine";
$sql.=" WHERE i_host_id='{$host_id}'";
$sql.=" GROUP BY i_host_id";

if($result = mysqli_query($mysqli,$sql)){
	while ($re = mysqli_fetch_assoc($result)) {
		$dat_p["pritty"]	+=$re["s_pritty"];
		$dat_p["smart"]		+=$re["s_smart"];
		$dat_p["funny"]		+=$re["s_funny"];
		$dat_p["sexy"]		+=$re["s_sexy"];
	}
}

//-------------------------------------------------------
$sql ="SELECT count(fav_id) AS cnt FROM me_fav";
$sql.=" WHERE target_id='{$host_id}'";
$sql.=" AND fav_set>1";
$sql.=" GROUP BY target_id";

if($result = mysqli_query($mysqli,$sql)){
	$re = mysqli_fetch_assoc($result);
	$dat_p["fab"]	=$re["cnt"];
}

//-------------------------------------------------------
$sql ="SELECT count(cheer_id) AS cnt FROM me_cheer";
$sql.=" WHERE card_id='{$img_id}'";
$sql.=" AND del='0'";
$sql.=" AND status='1'";
$sql.=" AND `com`!=''";
$sql.=" GROUP BY card_id";

if($result = mysqli_query($mysqli,$sql)){
	$re = mysqli_fetch_assoc($result);
	$dat_p["cheer"]	=$re["cnt"]+0;
}

//-------------------------------------------------------
$sql ="SELECT * FROM me_prof";
$sql.=" WHERE prof_id='{$host_id}'";
$sql.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$re = mysqli_fetch_assoc($result);

	if($re["open_twitter"] == 1){
		$dat_p["twitter"]	=str_replace("@","","https://mobile.twitter.com/".$re["twitter"]);
	}

	if($re["open_fb"] == 1){
		$dat_p["fb"]	=str_replace("@","","https://facebook.com/".$re["fb"]);
	}

	if($re["open_cosp"] == 1){
		$dat_p["cosp"]	="https://sp.cosp.jp/prof.aspx?id=".$re["cosp"];
	}

	if($re["open_insta"] == 1){
		$dat_p["insta"]	=str_replace("@","","https://instagram.com/".$re["insta"]);
	}
	if($re["open_url"] == 1){
		$dat_p["url"]	=$re["url"];
	}
}

echo json_encode($dat_p);
exit;
?>




