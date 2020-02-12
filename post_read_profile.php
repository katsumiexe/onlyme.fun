<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 

$n=0;
$dat_p="";
$dat_c="";

$img_id		=$_POST["img_id"];
$user_id	=$_POST["user_id"];

$dat_p["exp"]	=0;
$dat_p["pritty"]=0;
$dat_p["smart"]	=0;
$dat_p["funny"]	=0;
$dat_p["sexy"]	=0;



//-------------------------------------------------------
$sql ="SELECT pritty, smart, funny, sexy, i_user_id FROM me_iine";
$sql.=" WHERE i_card_id='{$img_id}'";
$sql.=" AND(pritty>0 OR smart>0 OR funny>0 OR sexy>0)";

if($result = mysqli_query($mysqli,$sql)){
	while ($re = mysqli_fetch_assoc($result)) {

		$dat_p["pritty"]	+=$re["pritty"];
		$dat_p["smart"]		+=$re["smart"];
		$dat_p["funny"]		+=$re["funny"];
		$dat_p["sexy"]		+=$re["sexy"];

		if($re["pritty"]>0){
			$dat_s[$re["i_user_id"]]["select"]	="<span class=\"p_cheer_icon\"></span>";
			$dat_s[$re["i_user_id"]]["pts"]		=$re["pritty"];

			if($re["i_user_id"] == $user_id){
				$dat_p["minus"]=$re["pritty"];
				$dat_p["mysel"]="pritty";
			}

		}elseif($re["smart"]>0){
			$dat_s[$re["i_user_id"]]["select"]	="<span class=\"p_cheer_icon\"></span>";
			$dat_s[$re["i_user_id"]]["pts"]		=$re["smart"];

			if($re["i_user_id"] == $user_id){
				$dat_p["minus"]=$re["smart"];
				$dat_p["mysel"]="smart";
			}

		}elseif($re["funny"]>0){
			$dat_s[$re["i_user_id"]]["select"]	="<span class=\"p_cheer_icon\"></span>";
			$dat_s[$re["i_user_id"]]["pts"]		=$re["funny"];

			if($re["i_user_id"] == $user_id){
				$dat_p["minus"]=$re["funny"];
				$dat_p["mysel"]="funny";
			}

		}elseif($re["sexy"]>0){
			$dat_s[$re["i_user_id"]]["select"]	="<span class=\"p_cheer_icon\"></span>";
			$dat_s[$re["i_user_id"]]["pts"]		=$re["sexy"];

			if($re["i_user_id"] == $user_id){
				$dat_p["minus"]=$re["sexy"];
				$dat_p["mysel"]="sexy";
			}
		}
	}
}

//-------------------------------------------------------
$sql ="SELECT cheer_id, user_id, com, reg_sex  FROM me_cheer";
$sql.=" LEFT JOIN reg ON user_id=reg.id";
$sql.=" WHERE card_id='{$img_id}'";
$sql.=" AND me_cheer.del='0'";
$sql.=" AND me_cheer.status='1'";
$sql.=" AND `com`!=''";
$sql.=" ORDER BY `me_cheer`.`date` DESC";
$sql.=" LIMIT 21";

if($result = mysqli_query($mysqli,$sql)){
	while ($re = mysqli_fetch_assoc($result)) {
		$n++;
		if($n >=21){
			$next="<div class=\"next\">次へ</div>";
			break;
		}
		//■------------------------
		$sql ="SELECT * FROM encode"; 
		$result = mysqli_query($mysqli,$sql);

		while($row = mysqli_fetch_assoc($result)){
			$enc[$row["key"]]=$row["value"];
		}

		for($n=0;$n<4;$n++){
			$tmp_key=substr($user["id"],$n*2,2);
			$tmp_enc[$n]=$enc[$tmp_key];
		}
		//■------------------------

		$user_enc_id=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
		$dir3="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[3]}{$tmp_enc[2]}/";//prof

		if($re["user_id"] == $user_id){
			$app="<input type=\"hidden\" id=\"mycheer\" value=\"{$re["com"]}\">";
		}

		for($k=0;$k<$dat_s[$re["i_user_id"]]["pts"];$k++){
			$dat_c[$re["cheer_id"]]["iine"].=$dat_s[$re["i_user_id"]]["select"];
		}

		if($re['reg_pic']>0){
			$tmp=substr("0".$tmp_key+3,-2,2);
			$prof_3=$enc[$tmp].".jpg";
			$dat_c[$re["cheer_id"]]["face"]	==$dir3.$prof_3;
	
		}else{
			$dat_c[$re["cheer_id"]]["face"]	="./img/noimage{$re['reg_sex']}.jpg";
		}

		$dat_c[$re["cheer_id"]]["comment"]		=$re["com"];
		$dat_c[$re["cheer_id"]]["comment_date"]	=$re["date"];
		$dat_c[$re["cheer_id"]]["name"]			=$re["reg_name"];


		$ch_list	.="<div class=\"p_cheer_date\">{$tmp_date}</div>";
		$ch_list	.="<table class=\"p_cheer_cld0 {$cherr_color}\">";
		$ch_list	.="<tr><td colspan=\"2\" class=\"p_cheer_cld1\">{$ch_c["reg_name"]}<div class=\"p_cheer_cld2\">{$tmp_icon}</div></td></tr>";
		$ch_list	.="<tr><td class=\"p_cheer_cld4\"><span class=\"p_cheer_cld4_1\">{$ch_c["com"]}</span></td><td class=\"p_cheer_cld3\"><img src=\"{$cheer_face}\" class=\"p_cheer_face\"></td></tr>";
		$ch_list	.="</table>";



	}
}


echo json_encode($dat_p);
exit;
?>




