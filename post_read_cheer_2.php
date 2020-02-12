<?

include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$user_id	=$_REQUEST["user_id"];
$card_id	=$_REQUEST["card_id"];
$pg			=$_REQUEST["pg"];
if($pg<1){
	$pg=1;
}
$pg_st=($pg-1)*20;
$sql ="SELECT * FROM me_cheer";
$sql.=" LEFT JOIN `reg` ON user_id=id";
$sql.=" LEFT JOIN `me_iine` ON user_id=i_user_id AND card_id=i_card_id";
$sql.=" WHERE card_id='{$card_id}'";
$sql.=" AND del=0";
$sql.=" AND `com`!=''";
$cnt=0;

if($result = mysqli_query($mysqli,$sql)){
	while ($ch_c = mysqli_fetch_assoc($result)) {

		if($ch_c['user_id']);

		if($ch_c['reg_pic']>0){
			for($n=0;$n<4;$n++){
				$tmp_key=substr($ch_c["user_id"],$n*2,2);
				$tmp_enc[$n]=$enc[$tmp_key];
			}

			$tmp=substr("0".$tmp_key+$ch_c['reg_pic'],-2,2);
			$cheer_enc_id=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
			$cheer_face="./myalbum/{$cheer_enc_id}/{$tmp_enc[3]}{$tmp_enc[2]}/{$enc[$tmp]}.jpg";

			}else{
				$cheer_face="./img/noimage{$ch_c['reg_sex']}.jpg";
			}


			$tmp_date=str_replace("-","/",substr($ch_c["date"],0,-3));
			$tmp_icon="";
			$cherr_color="";
			for($n=0;$n<$ch_c["pritty"]+0;$n++){
				$tmp_icon.="<span class=\"p_cheer_icon\"></span>";
			}	

			for($n=0;$n<$ch_c["smart"]+0;$n++){
				$tmp_icon.="<span class=\"p_cheer_icon\"></span>";
			}	

			for($n=0;$n<$ch_c["funny"]+0;$n++){
				$tmp_icon.="<span class=\"p_cheer_icon\"></span>";
			}	

			for($n=0;$n<$ch_c["sexy"]+0;$n++){
				$tmp_icon.="<span class=\"p_cheer_icon\"></span>";
			}

			if($ch_c['user_id'] == $user["id"]){
				$cherr_color=" p_cheer_me";
			}

			$ch_list	.="<div id="cd{$card_id}" class=\"p_cheer_date\">{$tmp_date}</div>";
			$ch_list	.="<table class=\"p_cheer_cld0 {$cherr_color}\">";
			$ch_list	.="<tr><td colspan=\"2\" class=\"p_cheer_cld1\">{$ch_c["reg_name"]}<div class=\"p_cheer_cld2\">{$tmp_icon}</div></td></tr>";
			$ch_list	.="<tr><td class=\"p_cheer_cld4\"><span class=\"p_cheer_cld4_1\">{$ch_c["com"]}</span></td><td class=\"p_cheer_cld3\"><img src=\"{$cheer_face}\" class=\"p_cheer_face\"></td></tr>";
			$ch_list	.="</table>";
			
			if($user_id == $user["id"]){
				$ch_list.="<input type=\"hidden\" name=\"tmpcheer\" val=\"{$ch_c["com"]}\">";
			}
		}
	}
}

if($cnt==0){
	$ch_list ="<div class=\"p_cheer_cld5\">応援コメントはまだありません</div>";

}elseif($cnt==20){
	$ch_list.="<div class=\"p_cheer_cld6\">もっと読む</div>";
}
echo($ch_list);
?>
