<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$nextck		=$_REQUEST['nextck']+0;
$chg		=$_REQUEST['chg']+0;
$date_30	=$_REQUEST['date_30']+0;
$last_card	=$_REQUEST['last_card']+0;

$lis="";
$d=0;

if($chg == 1){//0：ふぁぼ順
	$sql ="SELECT *, sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy) as iine, max(me_cheer.cheer_date) as cheer_new FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" LEFT JOIN `me_fav` ON me_making.user_id=fav_host_id";
	$sql.=" LEFT JOIN `me_cheer` ON me_making.making_id=me_cheer.c_card_id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" AND `me_fav`.`fav_user_id`='{$user["id"]}'";
	$sql.=" AND `me_fav`.`fav_set`='1'";
	$sql.=" AND me_making.making_id<{$last_card}";
	$sql.=" GROUP BY me_making.making_id";
	$sql.=" ORDER BY me_making.making_id DESC";
	$sql.=" LIMIT 21";

}elseif($chg == 2){//0：NEWコメ
	$sql ="SELECT *, sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy) as iine, max(me_cheer.cheer_date) as cheer_new FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" LEFT JOIN `me_cheer` ON me_making.making_id=me_cheer.c_card_id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" AND makedate>'{$date_30}'";
	$sql.=" AND me_making.making_id<{$last_card}";
	$sql.=" GROUP BY me_making.making_id";
	$sql.=" ORDER BY iine DESC";
	$sql.=" LIMIT 21";

}elseif($chg == 3){//0：こめ順
	$sql ="SELECT *, sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy) as iine, max(me_cheer.cheer_date) as cheer_new FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" LEFT JOIN `me_cheer` ON me_making.making_id=me_cheer.c_card_id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" AND me_making.making_id<{$last_card}";
	$sql.=" GROUP BY me_making.making_id";
	$sql.=" ORDER BY cheer_new DESC";
	$sql.=" LIMIT 21";

}else{
	$sql ="SELECT * FROM `me_making`";//0：通常
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" AND me_making.making_id<{$last_card}";
	$sql.=" ORDER BY me_making.making_id DESC";
	$sql.=" LIMIT 21";
}

$result = mysqli_query($mysqli,$sql);
while($dat2 = mysqli_fetch_assoc($result)){
	for($n=0;$n<4;$n++){
		$tmp_key=substr($dat2["user_id"],$n*2,2);
		$tmp_enc[$n]=$enc[$tmp_key];
	}

	$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
	$main_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[2]}{$tmp_enc[3]}/{$dat2["img"]}";
	$sub_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$dat2["img2"]}";

	if(file_exists($main_img) && file_exists($sub_img)){

		$sql="SELECT count(making_id) as cnt FROM me_making";
		$sql.=" WHERE user_id>10002014";
		$sql.=" LIMIT 1";

		$res3 = mysqli_query($mysqli,$sql);
		$dat3 = mysqli_fetch_assoc($res3);

		$dat[$d]["info_cnt"]=$dat3["cnt"];

		if($dat2["cate01"] == 1) $tag[$d][].="女子";
		if($dat2["cate02"] == 1) $tag[$d][].="男子";
		if($dat2["cate03"] == 1) $tag[$d][].="和風";
		if($dat2["cate04"] == 1) $tag[$d][].="自然";
		if($dat2["cate05"] == 1) $tag[$d][].="季節";
		if($dat2["cate06"] == 1) $tag[$d][].="厨二";
		if($dat2["cate07"] == 1) $tag[$d][].="限定";
		$tag_c[$d]		=count($tag[$d]);
		$tag_id[$d]		="tag".$dat2["use_tmpl"];
		$tag_code[$d]	=$dat2["tmpl_code"];


		$dat[$d]=$dat2;
		$dat[$d]["mdate"]=substr($dat2["makedate"],5,2)."/".substr($dat2["makedate"],8,2)."　".substr($dat2["makedate"],11,2).":".substr($dat2["makedate"],14,2);
		$tmp_tl=time()-strtotime($dat2["makedate"]);

		if($tmp_tl<60){
			$dat[$d]["tl"]="1分前";

		}elseif($tmp_tl<300){
			$dat[$d]["tl"]=floor($tmp_tl/60)."分前";

		}elseif($tmp_tl<3600){
			$dat[$d]["tl"]=floor($tmp_tl/300)."分前";

		}elseif($tmp_tl<86400){
			$dat[$d]["tl"]=floor($tmp_tl/3600)."時間前";

		}elseif($tmp_tl<259200){
			$dat[$d]["tl"]=floor($tmp_tl/86400)."日前";

		}else{
			$dat[$d]["tl"]="3日以上";
		}	

		for($n=0;$n<4;$n++){
			$tmp_key=substr($dat2["user_id"],$n*2,2);
			$tmp_enc[$n]=$enc[$tmp_key];
		}

		$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
		$dat[$d]["img_url"]	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$dat2["img2"]}";

		$tmp=substr("0".$tmp_key+$dat2["reg_pic"],-2,2);
		if($dat2["reg_pic"]>0){
			$dat[$d]["face"]	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[3]}{$tmp_enc[2]}/{$enc[$tmp]}.jpg";
		}else{
			$dat[$d]["face"]	="./img/noimage{$dat2['reg_sex']}.jpg";
		}

		$sql2="SELECT count(cheer_id) as cnt FROM me_cheer";
		$sql2.=" WHERE c_card_id='{$dat[$d]["making_id"]}'";
		$sql2.=" AND status=1";
		$sql2.=" AND del=0";
		$sql2.=" AND `com`!=''";
		$result2 = mysqli_query($mysqli,$sql2);
		$cheer0 = mysqli_fetch_assoc($result2);

		$dat[$d]['cheer_ct']=$cheer0["cnt"];

		$pritty[$dat[$d]["making_id"]]=0;
		$smart[$dat[$d]["making_id"]]=0;
		$funny[$dat[$d]["making_id"]]=0;
		$sexy[$dat[$d]["making_id"]]=0;


		$sql3="SELECT * FROM me_iine";
		$sql3.=" WHERE i_card_id='{$dat[$d]["making_id"]}'";
		$sql3.=" AND (pritty>0 || smart>0 || funny>0 || sexy>0)";

		$result3 = mysqli_query($mysqli,$sql3);
		while($iine0 = mysqli_fetch_assoc($result3)){

			$pritty[$iine0["i_card_id"]]+=$iine0["pritty"];
			$smart[$iine0["i_card_id"]]	+=$iine0["smart"];
			$funny[$iine0["i_card_id"]]	+=$iine0["funny"];
			$sexy[$iine0["i_card_id"]]	+=$iine0["sexy"];

			if($iine0["i_user_id"] == $user["id"]){

				if($iine0["pritty"]>0){
					$mysel[$iine0["i_card_id"]]	="pritty";
					$minus[$iine0["i_card_id"]]=$iine0["pritty"];

				}elseif($iine0["smart"]>0){
					$mysel[$iine0["i_card_id"]]	="smart";
					$minus[$iine0["i_card_id"]]=$iine0["smart"];

				}elseif($iine0["funny"]>0){
					$mysel[$iine0["i_card_id"]]	="funny";
					$minus[$iine0["i_card_id"]]=$iine0["funny"];

				}elseif($iine0["sexy"]>0){
					$mysel[$iine0["i_card_id"]]	="sexy";
					$minus[$iine0["i_card_id"]]=$iine0["sexy"];
				}
			}
		}
		$all[$dat[$d]["making_id"]]=$pritty[$dat[$d]["making_id"]]+	$smart[$dat[$d]["making_id"]]+$funny[$dat[$d]["making_id"]]+$sexy[$dat[$d]["making_id"]];
		$d++;
		
		$sql4 ="SELECT card_id FROM me_alert";
		$sql4.=" WHERE card_id='{$dat[$iine0["i_card_id"]]}'";
		$sql4.=" AND user_id='{$user["id"]}'";
		$sql4.=" LIMIT 1";
		$result4 = mysqli_query($mysqli,$sql4);
		if($result4){
			$yet_alert[$iine0["i_card_id"]]=1;	
		}
	}
}

$end=$d;
if($end>20) $end=20;

for($n=0;$n<$end;$n++){
$lis.="<div id=\"f{$dat[$n]['making_id']}\" class=\"index_frame\">";
$lis.="<input id=\"mm{$dat[$n]['making_id']}\" type=\"hidden\" name=\"mysel\" value=\"{$mysel[$dat[$n]['making_id']]}\">";
$lis.="<input type=\"hidden\" name=\"own\" value=\"{$dat[$n]['user_id']}\">";
$lis.="<input type=\"hidden\" name=\"pict\" value=\"{$dat[$n]['face']}\">";
$lis.="<input type=\"hidden\" name=\"mdate\" value=\"{$dat[$n]['mdate']}\">";
$lis.="<input type=\"hidden\" name=\"cheer_ct\" value=\"{$dat[$n]['cheer_ct']}\">";
$lis.="<input id=\"mi{$dat[$n]['making_id']}\" type=\"hidden\" name=\"minus\" value=\"{$minus[$dat[$n]['making_id']]}\">";
$lis.="<input id=\"pp{$dat[$n]['making_id']}\" type=\"hidden\" name=\"pritty\" value=\"{$pritty[$dat[$n]['making_id']]}\">";
$lis.="<input id=\"ss{$dat[$n]['making_id']}\" type=\"hidden\" name=\"smart\" value=\"{$smart[$dat[$n]['making_id']]}\">";
$lis.="<input id=\"ff{$dat[$n]['making_id']}\" type=\"hidden\" name=\"funny\" value=\"{$funny[$dat[$n]['making_id']]}\">";
$lis.="<input id=\"xx{$dat[$n]['making_id']}\" type=\"hidden\" name=\"sexy\" value=\"{$sexy[$dat[$n]['making_id']]}\">";
$lis.="<input id=\"al{$dat[$n]['making_id']}\" type=\"hidden\" name=\"all\" value=\"{$all[$dat[$n]['making_id']]}\">";

$lis.="<input type=\"hidden\" name=\"cate_id\" value=\"{$tag_id[$n]}\">";
$lis.="<input type=\"hidden\" name=\"cate_code\" value=\"{$tag_code[$n]}\">";
for($t=0;$t<$tag_c[$n];$t++){
$lis.="<input type=\"hidden\" name=\"cate{$t}\" value=\"{tag[$n][$t]}\">";
}

$lis.="<img src=\"{$dat[$n]['img_url']}\" class=\"index_img\" alt=\"{$dat[$n]['reg_name']}\">";
$lis.="<table class=\"index_frame_ttl\">";
$lis.="<tr>";
$lis.="<td rowspan=\"2\" class=\"ttl_1\"><img id=\"h_face{$n}\" src=\"{$dat[$n]['face']}\" style=\"width:8.5vw;\"></td>";
$lis.="<td class=\"ttl_2\">{$dat[$n]['tl']}</td>";
$lis.="<td class=\"ttl_3\">";
$lis.="<div class=\"ttl_comm\">";
$lis.="<span class=\"icon_img comm_icon\"></span>";
$lis.="<span class=\"comm_cnt\">{$all[$dat[$n]['making_id']]}</span>";
$lis.="</div>";
$lis.="</td>";
$lis.="</tr>";
$lis.="<tr>";
$lis.="<td colspan=\"2\" class=\"ttl_4\">{$dat[$n]['reg_name']}</td>";
$lis.="</tr>";
$lis.="</table>";	
$lis.="</div>";
}
if($d>19){
	$ck=$dat[19]['making_id'];
	$lis.="<div id=\"next_{$ck}\" class=\"next\">続きを見る</div>";
}
echo($lis);
?>
