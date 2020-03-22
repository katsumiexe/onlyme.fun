<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
$base_d=date("Y-m-d 23:59:00",time()-604800);
$ch_list=array();
$user_id	=$_REQUEST["user_id"];
$next_print	=$_REQUEST["next_print"]+0;
$cnt=0;


$met	=file_get_contents("https://api.networkprint.jp/rest/webapi/v2/maintenanceInfo");
$met2	=json_decode($met,true);

if($met2["status"] == "emergency"){
	$ch_list["mente"]=1;
}elseif($met2["status"] == "available"){
}elseif($met2["status"] == "scheduled"){
	$ch_list["mente"]=2;

}else{
	if($met2["maintenanceTime"]["from"] <$now && $met2["maintenanceTime"]["to"] > $now){
		$ch_list["mente"]=3;
	}
}

if(!$ch_list["mente"]){

$ck_css[0]=" ck_mes c_wt";
$ck_css[1]=" ck_mes c_ok";
$ck_css[2]=" ck_mes c_ng";

$ck_msg[0]="<span class=\"ck_icon\"></span><span class=\"ck_text\">転送中</span>";
$ck_msg[1]="<span class=\"ck_icon\"></span><span class=\"ck_text\">印刷可能</span>";
$ck_msg[2]="<span class=\"ck_icon\"></span><span class=\"ck_text\">転送失敗</span>";


if($next_print>0){
	$app =" AND making_id<'{$next_print}'";
}
$sql ="SELECT * FROM `me_plist_main`";
$sql.=" WHERE `p_date`>'{$base_d}'";
$sql.=" AND p_user_id='{$user_id}'";
$sql.=" AND `p_del`=0";
$sql.=" LIMIT 1";


$result = mysqli_query($mysqli,$sql);
if($dat = mysqli_fetch_assoc($result)){

	$url = "https://api.networkprint.jp/rest/webapi/v2";

	$dat_e["token"]	= $dat["api_token"];
	$dat_e["M"]		= "getFileList";

	$content = http_build_query($dat_e);
	$dat_e2 = array(
		'http' => array(
			'method' => 'POST',
			'content'=> $content
		)
	);

	if($e_token = file_get_contents($url, false, stream_context_create($dat_e2))){
		$err_check =json_decode($e_token,true);

		for($n=0;$n<$err_check["totalFiles"];$n++){
			$er[$err_check["fileList"][$n]["fileID"]]=$err_check["fileList"][$n]["status"];
		}
	}

	$ch_list["code"]=$dat["p_api_code"];
	$ch_list["limit"]=date("m月d日 23:59",strtotime($dat["p_date"])+518400);

	$sql2 ="SELECT * FROM `me_plist_sub`";
	$sql2.=" WHERE main_id='{$dat["p_main_id"]}'";
	$sql2.=" ORDER BY p_sub_id DESC";

	if($result2 = mysqli_query($mysqli,$sql2)){
		while($dat2 = mysqli_fetch_assoc($result2)){

			$sql3 ="SELECT * FROM `me_making`";
			$sql3.=" WHERE `making_id`='{$dat2["p_making_id"]}'";
			$sql3.=" LIMIT 1";

			$result3 = mysqli_query($mysqli,$sql3);
			$dat3 = mysqli_fetch_assoc($result3);

			$img_url="./{$dir}/{$dat3["img"]}";

			$ch_list["list"]	.="<div class=\"index_frame_print\">";
			$ch_list["list"]	.="<span class=\"{$ck_css[$er[$dat2["p_file_id"]]]}\">{$ck_msg[$er[$dat2["p_file_id"]]]}</span>";
			$ch_list["list"]	.="<img src=\"{$img_url}\" class=\"index_img\">";
			$ch_list["list"]	.="</div>";
		}
	}

}else{
	$sql ="SELECT * FROM `me_making`";
	$sql.=" WHERE `del`='0'";
	$sql.=" AND user_id='{$user_id}'";
	$sql.=$app;
	$sql.=" ORDER BY making_id DESC";
	$sql.=" LIMIT 21";

	if($result = mysqli_query($mysqli,$sql)){
		while ($dat2 = mysqli_fetch_assoc($result)) {
			$last_id=$dat2['making_id'];

			if($cnt<20){
				$img_url="./{$dir}/{$dat2["img"]}";
				$ch_list["list"]	.="<div id=\"fn{$dat2["making_id"]}\" class=\"index_frame_print\" style=\"position:relative\">";
				$ch_list["list"]	.="<img src=\"{$img_url}\" class=\"index_img\">";
				$ch_list["list"]	.="<div id=\"f{$dat2["making_id"]}\" class=\"p_btn\"></div>";
				$ch_list["list"]	.="</div>";
			}
			$cnt++;
		}
	}

	if($cnt==0){
		$ch_list["list"] ="<div class=\"p_cheer_cld5\">作成された名刺はまだありません</div>";

	}elseif($cnt>=20){
		$ch_list["list"].="<div id=\"next_p{$last_id}\" class=\"next_a\">続きを見る</div>";
	}
}
}

echo json_encode($ch_list);

exit;
?>
