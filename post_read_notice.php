<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$next_notice=$_REQUEST["next_notice"];
$user_id	=$_REQUEST["user_id"];
$date=date("Y-m-d H:i:s");

if($next_notice>0){
	$app.=" AND `notice_id`<'{$next_notice}'";
}

$sql ="SELECT * FROM `me_notice`";
$sql.=" LEFT JOIN `me_notice_list` ON me_notice.notice_log=me_notice_list.list_id";
$sql.=" LEFT JOIN `reg` ON `me_notice`.`n_user_id`=`reg`.`id`";
$sql.=" LEFT JOIN `me_making` ON `me_notice`.`use_id`=`me_making`.`making_id`";
$sql.=" WHERE `me_notice`.`del`='0'";
$sql.=" AND `me_notice`.`n_target_id`='{$user_id}'";
$sql.=" AND (`me_making`.`del`=0 OR `me_notice`.`use_id`=0)";
$sql.=$app;	
$sql.=" ORDER BY notice_id DESC";
$sql.=" LIMIT 21";

$cnt=0;
if($result = mysqli_query($mysqli,$sql)){
	while ($dat2 = mysqli_fetch_assoc($result)) {
		$last_id=$dat2['notice_id'];
		if($cnt<20){
			$cnt++;

			if($dat2['reg_rank']>10){

				for($n=0;$n<4;$n++){
					$tmp_key=substr($dat2['id'],$n*2,2);
					$tmp_enc[$n]=$enc[$tmp_key];
				}
		
				$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
				$tmp=substr("0".$tmp_key+$dat2["reg_pic"],-2,2);
				$prof_1=$enc[$tmp].".jpg";
		
				if($dat2['reg_pic']>0){
					$notice_face="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[3]}{$tmp_enc[2]}/".$prof_1;
		
				}else{
					$notice_face="./img/noimage{$dat2['reg_sex']}.jpg";
				}

				if($dat2['check_date'] == '0000-00-00 00:00:00'){
					$notice_yet="notice_yet";
				}

				$tmp="<span id=\"p{$dat2['notice_id']}\" class=\"prof_jump\">{$dat2['reg_name']}さん</span>";
				$tmp2="<span id=\"c{$dat2['use_id']}\" class=\"prof_jump2\">応援されました。</span>";
		
				$notice_date=substr($dat2["date"],5,2)."/".substr($dat2["date"],8,2)."　".substr($dat2["date"],11,2).":".substr($dat2["date"],14,2);
				$notice_log=str_replace("■target■",$tmp,$dat2['notice_log']);
				$notice_log=str_replace("■act■",$tmp2,$notice_log);
				$check_date=$dat2['check_date'];
				
				$ch_list	.="<div class=\"notice_list_1 {$notice_yet}\">";
				$ch_list	.="<img src=\"{$notice_face}\" class=\"notice_list_2\">";
				$ch_list	.="<div class=\"notice_list_3\">{$notice_date}</div>";
				$ch_list	.="<div class=\"notice_list_4\">{$notice_log}</div>";
				$ch_list	.="</div>";

			}else{
				if($dat2['check_date'] == '0000-00-00 00:00:00'){
					$notice_yet="notice_yet";
				}
		
				$tmp="<span id=\"p{$dat2['notice_id']}\">{$dat2['reg_name']}さん</span>";
				$tmp2="<span id=\"c{$dat2['use_id']}\">応援されました</span>";
		
				$notice_date=substr($dat2["date"],5,2)."/".substr($dat2["date"],8,2)."　".substr($dat2["date"],11,2).":".substr($dat2["date"],14,2);
				$notice_log=str_replace("■target■",$tmp,$dat2['notice_log']);
				$notice_log=str_replace("■act■",$tmp2,$notice_log);
				$check_date=$dat2['check_date'];
				
				$ch_list	.="<div class=\"notice_list_1 {$notice_yet}\">";
				$ch_list	.="<img src=\"./img/remove.jpg\" class=\"notice_list_2\">";
				$ch_list	.="<div class=\"notice_list_3\">{$notice_date}</div>";
				$ch_list	.="<div class=\"notice_list_4\">{$notice_log}</div>";
				$ch_list	.="</div>";
			}
		}
	}
}

if($cnt==0){
	$ch_list ="<div class=\"p_cheer_cld5\">お知らせはまだありません</div>";

}elseif($cnt>=20){
	$ch_list.="<div id=\"next_n{$last_id}\" class=\"next_n\">続きを見る</div>";
}
echo($ch_list);
?>
