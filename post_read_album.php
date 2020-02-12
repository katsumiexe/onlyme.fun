<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

$sql="SELECT * FROM me_encode";
if($re = mysqli_query($mysqli,$sql)){
	while($de = mysqli_fetch_assoc($re)){
		$me_code[$de["gp"]][$de["value"]]=$de["key"];
	}
}


$user_id	=$_REQUEST["user_id"];
$next_album	=$_REQUEST["next_album"];
$cnt=0;

if($next_album>0){
	$app =" AND me_making.making_id<'{$next_album}'";
}

$sql ="SELECT *,sum(me_iine.pritty) as s_pritty, sum(me_iine.smart) as s_smart, sum(me_iine.funny) as s_funny, sum(me_iine.sexy) as s_sexy FROM `me_making`";
$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";


$sql.=" WHERE `me_making`.`del`='0'";
$sql.=" AND me_making.user_id='{$user_id}'";
$sql.=$app;

$sql.=" GROUP BY me_making.making_id ";
$sql.=" ORDER BY me_making.making_id DESC";
$sql.=" LIMIT 21";

if($result = mysqli_query($mysqli,$sql)){
	while ($dat2 = mysqli_fetch_assoc($result)) {
		$last_id=$dat2['making_id'];
		if($cnt<20){

			$sql2.=" SELECT count(cheer_id) as cnt FROM `me_cheer`";
			$sql2.=" WHERE `me_cheer`.`del`='0'";
			$sql2.=" AND `me_cheer`.`com`!=''";
			$sql2.=" AND `me_cheer`.`c_card_id`!='{$dat2['making_id']}'";

			$res2 = mysqli_query($mysqli,$sql2);
			$res3 = mysqli_fetch_assoc($res2);

			$cnt++;
			$mdate	=substr($dat2["makedate"],5,2)."/".substr($dat2["makedate"],8,2)."　".substr($dat2["makedate"],11,2).":".substr($dat2["makedate"],14,2);
			$img_url="./{$dir}/{$dat2["img"]}";
			$dat2['s_cheer']+=0;
			$dat2['s_pritty']+=0;
			$dat2['s_smart']+=0;
			$dat2['s_funny']+=0;
			$dat2['s_sexy']+=0;
			$res3['cnt']+=0;
			$s_all	=$dat2['s_pritty']+$dat2['s_smart']+$dat2['s_funny']+$dat2['s_sexy']+0;

			$e_code="";

			$tmp_auto=substr("0000".$dat2['making_id'],-5);
			for($r=0;$r<5;$r++){
				$rnd=rand(0,19);
				$tmp=substr($tmp_auto,$r,1);
				$e_code.=$me_code[$rnd][$tmp];
			}






			$tname=urlencode("【Only Me】で名刺を作りました！");
			$hash=urlencode("OnlyMe");

			$tlink="https://twitter.com/intent/tweet";
			$tlink.="?text={$tname}";
			$tlink.="&url=https://onlyme.fun/pg.php?es={$e_code}";
			$tlink.="&related=onlyme_staff";
			$tlink.="&hashtags={$hash}";


			$ch_list.="<div id=\"f{$dat2["making_id"]}\" class=\"index_frame\">";
			$ch_list.="<input type=\"hidden\" name=\"cheer_ct\" value=\"{$res3['cnt']}\">";
			$ch_list.="<input type=\"hidden\" name=\"mdate\" value=\"{$mdate}\">";

			$ch_list.="<input id=\"pp{$dat2['making_id']}\" type=\"hidden\" name=\"pritty\" value=\"{$dat2['s_pritty']}\">";
			$ch_list.="<input id=\"ss{$dat2['making_id']}\" type=\"hidden\" name=\"smart\" value=\"{$dat2['s_smart']}\">";
			$ch_list.="<input id=\"ff{$dat2['making_id']}\" type=\"hidden\" name=\"funny\" value=\"{$dat2['s_funny']}\">";
			$ch_list.="<input id=\"xx{$dat2['making_id']}\" type=\"hidden\" name=\"sexy\" value=\"{$dat2['s_sexy']}\">";
			$ch_list.="<input id=\"al{$dat2['making_id']}\" type=\"hidden\" name=\"all\" value=\"{$s_all}\">";

			$ch_list.="<input id=\"tl{$dat2['making_id']}\" type=\"hidden\" name=\"tlink\" value=\"{$tlink}\">";

			$ch_list	.="<div class=\"index_frame_day\">{$mdate}</div>";
			$ch_list	.="<img src=\"{$img_url}\" class=\"index_img\">";
			$ch_list	.="</div>";
		}
	}
}

if($cnt==0){
	$ch_list ="<div class=\"p_cheer_cld5\">作成された名刺はまだありません</div>";

}elseif($cnt>=20){
	$ch_list.="<div id=\"next_a{$last_id}\" class=\"next_a\">続きを見る</div>";
}
echo($ch_list);
?>
