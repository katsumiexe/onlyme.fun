<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$day = date("Ymd");
$date = date("Y-m-d H:i:s");

$sql ="SELECT * FROM encode"; 
$result = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_assoc($result)){
	$enc[$row["key"]]=$row["value"];
	$dec[$row["value"]]=$row["key"];
}

$sql ="SELECT * FROM me_encode"; 
$result = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_assoc($result)){
	$me_enc[$row["key"]]=$row["value"];
}

function get_after($get_time){
	$tmp_tl=time()-strtotime($get_time);
	if($tmp_tl<60){
		return "1分前";
	}elseif($tmp_tl<300){
		return  floor($tmp_tl/60)."分前";

	}elseif($tmp_tl<3600){
		return floor($tmp_tl/300)."分前";

	}elseif($tmp_tl<86400){
		return floor($tmp_tl/3600)."時間前";

	}elseif($tmp_tl<604800){
		return floor($tmp_tl/86400)."日前";
	}else{
		return "7日以上";
	}	
}

if($_SESSION){
	$_SESSION = array();
	session_destroy(); 
}
?>
