<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$last_id	=$_REQUEST["last_id"];
$last_id=20;

$sql ="SELECT * FROM `me_making`";
$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
//$sql.=" LEFT JOIN `me_plof` ON me_making.user_id=prof.id";
$sql.=" WHERE `me_making`.`del`='0'";
$sql.=" AND me_making.making_id<'{$last_id}'";
$sql.=" ORDER BY me_making.making_id DESC";
$sql.=" LIMIT 21";
if($result = mysqli_query($mysqli,$sql)){
	while ($app = mysqli_fetch_assoc($result)) {
		$n=$last_id;
$docs .= <<< EOF
			<div id="f{$app["making_id"]}" class="index_frame">
				<input id="mm{$app["making_id"]}" type="hidden" name="mysel" value="{$mysel[$app["making_id"]}">
				<input type="hidden" name="own" value="{$app["user_id"]+0}">
				<input type="hidden" name="pict" value="{$app["face"]}">
				<input type="hidden" name="mdate" value="{$app["mdate"]}">
				<input id="mi{$app["making_id"]}" type="hidden" name="minus" value="{$minus[$app["making_id"]]+0}">
				<input id="pp{$app["making_id"]}" type="hidden" name="pritty" value="{$pritty[$app["making_id"]]+0}">
				<input id="ss{$app["making_id"]}" type="hidden" name="smart" value="{$smart[$app["making_id"]]+0}">
				<input id="ff{$app]["making_id"]}" type="hidden" name="funny" value="{$funny[$app["making_id"]]+0}">
				<input id="xx{$app["making_id"]}" type="hidden" name="sexy" value="{$sexy[$app["making_id"]]+0}">
				<input id="al{$app["making_id"]}" type="hidden" name="all" value="{$pritty[$app["making_id"]]+$smart[$app["making_id"]]+$funny[$app["making_id"]]+$sexy[$app["making_id"]]+0}">
				<img src="{$app["img_url"]}" class="index_img" alt="{$app["reg_name"]}">
	
				<table class="index_frame_ttl">
					<tr>
						<td rowspan="2" class="ttl_1"><img id="h_face{$n}" src="{$app["face"]}" style="width:8.5vw;"></td>
						<td class="ttl_2">{$app["tl"]}</td>
						<td class="ttl_3">
						<div class="ttl_comm">
						<span class="icon_img comm_icon"></span>
						<span class="comm_cnt">{$pritty[$app["making_id"]]+$smart[$app["making_id"]]+$funny[$app["making_id"]]+$sexy[$app["making_id"]]+$plus[$app["making_id"]]+0}</span>
						</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="ttl_4">{=$app["reg_name"]}</td>
					</tr>
				</table>	
			</div>
EOF;
		$n++;			
	}
}
echo($docs);
?>