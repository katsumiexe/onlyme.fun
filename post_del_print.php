<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
$code	=$_POST["code"];
$user_id=$_POST["user_id"];
$cnt=0;

$sql ="UPDATE `me_plist_main` SET";

$sql.=" p_del=1";
$sql.=" WHERE `p_api_code`='{$code}'";
mysqli_query($mysqli,$sql);

$sql ="SELECT * FROM `me_making`";
$sql.=" WHERE `del`='0'";
$sql.=" AND user_id='{$user_id}'";
$sql.=" ORDER BY making_id DESC";
$sql.=" LIMIT 21";

if($result = mysqli_query($mysqli,$sql)){
	while ($dat2 = mysqli_fetch_assoc($result)) {
		$last_id=$dat2['making_id'];

		if($cnt<20){
			$img_url="./{$dir}/{$dat2["img"]}";

			$ch_list["list"]	.="<div class=\"index_frame\" style=\"position:relative\">";
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
	$ch_list["list"].="<div id=\"next_a{$last_id}\" class=\"next_a\">続きを見る</div>";
}

echo json_encode($ch_list);
exit;
?>

