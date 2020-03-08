<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");

$user_id	=$_REQUEST["user_id"];
$card_id	=$_REQUEST["card_id"];
$chg		=$_REQUEST["chg"];
$pg			=$_REQUEST["pg"]+0;


$sql ="SELECT * FROM me_cheer";
$sql.=" LEFT JOIN `reg` ON c_user_id=`reg`.`id`";
$sql.=" LEFT JOIN `me_iine` ON c_user_id=i_user_id AND c_card_id=i_card_id";
$sql.=" WHERE c_card_id='{$card_id}'";
$sql.=" AND `me_cheer`.`del`=0";
$sql.=" AND `com`!=''";
$sql.=" ORDER BY `cheer_date` DESC";

$cnt=0;
if($result = mysqli_query($mysqli,$sql)){
	while ($ch_c = mysqli_fetch_assoc($result)) {
		if($cnt<20){
			$cnt++;
			if($ch_c['reg_pic']>0){
				for($n=0;$n<4;$n++){
					$tmp_key=substr($ch_c["c_user_id"],$n*2,2);
					$tmp_enc[$n]=$enc[$tmp_key];
				}

				$tmp=substr("0".$tmp_key+$ch_c['reg_pic'],-2,2);
				$cheer_enc_id=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
				$cheer_face="./myalbum/{$tmp_enc[3]}/{$cheer_enc_id}/{$tmp_enc[3]}{$tmp_enc[2]}/{$enc[$tmp]}.jpg";

			}else{
				$cheer_face="./img/noimage{$ch_c['reg_sex']}.jpg";
			}

			$tmp_date=str_replace("-","/",substr($ch_c["cheer_date"],0,-3));
			$tmp_icon="";
			$cherr_color="";
			for($n=0;$n<$ch_c["pritty"]+0;$n++){
				$tmp_icon.="";
			}	

			for($n=0;$n<$ch_c["smart"]+0;$n++){
				$tmp_icon.="";
			}	

			for($n=0;$n<$ch_c["funny"]+0;$n++){
				$tmp_icon.="";
			}	

			for($n=0;$n<$ch_c["sexy"]+0;$n++){
				$tmp_icon.="";
			}

			if($ch_c['c_user_id'] == $user_id){
				$cheer_color=" p_cheer_me";
				$ch_list.="<input type=\"hidden\" name=\"tmpcheer\" value=\"{$ch_c["com"]}\">";

			}else{
				$cheer_color=" ";
			}

			$ch_list	.="<div class=\"p_cheer_date\">{$tmp_date}</div>";

			$ch_list	.="<table class=\"p_cheer_cld0 {$cheer_color}\">";
			$ch_list	.="<tr><td colspan=\"2\" class=\"p_cheer_cld1\">{$ch_c["reg_name"]}<div class=\"p_cheer_cld2\">{$tmp_icon}</div></td></tr>";
			$ch_list	.="<tr><td class=\"p_cheer_cld4\"><span class=\"p_cheer_cld4_1\">{$ch_c["com"]}</span></td><td class=\"p_cheer_cld3\"><img src=\"{$cheer_face}\" class=\"p_cheer_face\"></td></tr>";
			$ch_list	.="</table>";
		}
	}
}

if($cnt==0){
	$ch_list ="<div class=\"p_cheer_cld5\">応援コメントはまだありません</div>";

}elseif($cnt>=20){
	$ch_list.="<div class=\"p_cheer_cld6\">続きを見る</div>";
}
echo($ch_list);
?>