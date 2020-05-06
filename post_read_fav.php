<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$tag    	=$_REQUEST["tag"];
$user_id	=$_REQUEST["user_id"];

if($tag == "a"){
    $sql ="SELECT reg.reg_name, reg.reg_pic, reg.reg_rank, reg.reg_sex, m1.fav_user_id as my, m1.fav_host_id as you FROM me_fav as m1";
    $sql.=" LEFT JOIN `reg` ON fav_host_id=id";
    $sql.=" LEFT JOIN `me_fav` as m2 ON m1.fav_host_id=m2.fav_user_id AND m2.fav_host_id=m1.fav_user_id";
    $sql.=" WHERE fav_set='1'";
    $sql.=" AND m1.fav_user_id='{$user_id}'";
    $sql.=" ORDER BY m1.fav_id DESC";

}elseif($tag == "b"){
    $sql ="SELECT reg.reg_name, reg.reg_pic, reg.reg_rank, reg.reg_sex, m1.fav_user_id as my, m1.fav_host_id as you FROM me_fav as m1";
    $sql.=" LEFT JOIN `reg` ON fav_host_id=id";
    $sql.=" WHERE m1.fav_set='1'";
    $sql.=" AND m1.fav_user_id='{$user_id}'";
    $sql.=" ORDER BY m1.fav_id DESC";

}elseif($tag == "c"){
    $sql ="SELECT reg.reg_name, reg.reg_pic, reg.reg_rank, reg.reg_sex, m1.fav_host_id as my, m1.fav_user_id as you FROM me_fav as m1";
    $sql.=" LEFT JOIN `reg` ON fav_user_id=id";
    $sql.=" WHERE m1.fav_set='1'";
    $sql.=" AND m1.fav_host_id='{$user_id}'";
    $sql.=" ORDER BY m1.fav_id DESC";
}

$cnt=0;
if($result = mysqli_query($mysqli,$sql)){
	while ($ch_c = mysqli_fetch_assoc($result)) {
		if($cnt<20){
            $cnt++;
	
			if($dat2['reg_rank']>10){
				$sql ="SELECT `date` FROM `log`";
				$sql.=" WHERE user_id='{$ch_c["you"]}'";
				$sql.=" ORDER BY `date` DESC";
				$sql.=" LIMIT 1";

				$last_login1 = mysqli_query($mysqli,$sql);
				$last_login2 = mysqli_fetch_assoc($last_login1);
				if($last_login2 ==""){
					$last_login3 ="----";
				}else{
					$last_login3 =get_after($last_login2["date"]);
				}			

				$sql ="SELECT `date` FROM `log`";
				$sql.=" WHERE user_id='{$ch_c["you"]}'";
				$sql.=" AND log_no='302'";
				$sql.=" ORDER BY `date` DESC";
				$sql.=" LIMIT 1";
			
				$last_use1 = mysqli_query($mysqli,$sql);
				$last_use2 = mysqli_fetch_assoc($last_use1);

				if($last_use2 ==""){
					$last_use3 ="----";
				}else{
					$last_use3 =get_after($last_use2["date"]);
				}			

				if($tag == "b"){
					$sql ="SELECT fav_user_id,fav_host_id  FROM me_fav";
					$sql.=" WHERE fav_host_id='{$user_id}'";
					$sql.=" AND fav_user_id='{$ch_c['you']}'";
					$sql.=" AND fav_set='1'";
					$sql.=" LIMIT 1";
					$friend1 = mysqli_query($mysqli,$sql);
					$friend2 = mysqli_fetch_assoc($friend1);
					if($friend2){
						$friend3="f1";				
					}else{
						$friend3="";				
					}

				}elseif($tag == "c"){
					$sql ="SELECT fav_user_id,fav_host_id  FROM me_fav";
					$sql.=" WHERE fav_user_id='{$user_id}'";
					$sql.=" AND fav_host_id='{$ch_c['you']}'";
					$sql.=" AND fav_set='1'";
					$sql.=" LIMIT 1";
					$friend1 = mysqli_query($mysqli,$sql);
					$friend2 = mysqli_fetch_assoc($friend1);
					if($friend2){
						$friend3="f2";				
					}else{
						$friend3="";				
					}
				}

				for($n=0;$n<4;$n++){
					$tmp_key=substr($ch_c["you"],$n*2,2);
					$tmp_enc[$n]=$enc[$tmp_key];
				}

				$cheer_enc_id=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];

				if($ch_c['reg_pic']>0){
					$tmp=substr("0".$tmp_key+$ch_c['reg_pic'],-2,2);
					$cheer_face="./myalbum/{$tmp_enc[3]}/{$cheer_enc_id}/{$tmp_enc[3]}{$tmp_enc[2]}/{$enc[$tmp]}.jpg";
				}else{
					$cheer_face="./img/noimage{$ch_c['reg_sex']}.jpg";
				}

				$ch_list	.="<div id=\"mb_{$cheer_enc_id}\" class=\"fav_member\">";
				$ch_list	.="<img src=\"{$cheer_face}\" class=\"fav_pic\">";
				$ch_list	.="<div class=\"fav_msg\">";
				$ch_list	.="<span class=\"fav_name\">{$ch_c["reg_name"]}</span>";
				$ch_list	.="<span class=\"fav_last\">最終ログイン:{$last_login3}</span>";
				$ch_list	.="<span class=\"fav_last\">最終作成日:{$last_use3}</span>";
				$ch_list	.="<span id=\"fv_{$cheer_enc_id}\" class=\"fav_fan {$friend3}\">★</span>";
				$ch_list	.="</div>";
				$ch_list	.="</div>";

			}else{
				$ch_list	.="<div id=\"mb_{$cheer_enc_id}\" class=\"fav_remove\">";
				$ch_list	.="<img src=\"./img/remove.jpg\" class=\"notice_list_2\">";

				$ch_list	.="<div class=\"fav_msg\">";
				$ch_list	.="<span >{$ch_c["reg_name"]}</span>";
				$ch_list	.="<span class=\"fav_last\">最終ログイン:----</span>";
				$ch_list	.="<span class=\"fav_last\">最終作成日:----</span>";
				$ch_list	.="<span id=\"fv_{$cheer_enc_id}\" class=\"fav_fan\">★</span>";
				$ch_list	.="</div>";
				$ch_list	.="</div>";

			

			
			
			}
		}
	}
}

if($cnt==0){
	$ch_list ="<div class=\"p_cheer_cld5\">登録はまだありません</div>";

}elseif($cnt==20){
	$ch_list.="<div class=\"p_cheer_cld6\">続きを見る</div>";
}
echo($ch_list);
?>


