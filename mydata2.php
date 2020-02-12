<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");

$cheer	=$_POST["cheer"];
$n_cheer=$_POST["n_cheer"];

$nowpage=2;
$ex=8;
$d=0;
$c=0;
$date=date("Y-m-d H:i:s");
$sql ="SELECT * FROM `me_notice`";
$sql.=" LEFT JOIN `me_notice_list` ON me_notice.notice_log=me_notice_list.list_id";
$sql.=" LEFT JOIN `reg` ON `me_notice`.`n_user_id`=`reg`.`id`";
$sql.=" LEFT JOIN `me_making` ON `me_notice`.`use_id`=`me_making`.`making_id`";
$sql.=" WHERE `me_notice`.`del`='0'";
$sql.=" AND `me_notice`.`n_target_id`='{$user["id"]}'";
$sql.=" AND (`me_making`.`del`=0 OR `me_notice`.`use_id`=0)";
$sql.=" ORDER BY notice_id DESC";
$sql.=" LIMIT 21";

$datn = mysqli_query($mysqli,$sql);
while($dat2 = mysqli_fetch_assoc($datn)){
	if($dat2["id"]>0){

		for($n=0;$n<4;$n++){
			$tmp_key=substr($dat2['id'],$n*2,2);
			$tmp_enc[$n]=$enc[$tmp_key];
		}

		$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
		$tmp=substr("0".$tmp_key+$dat2["reg_pic"],-2,2);
		$prof_1=$enc[$tmp].".jpg";

		if($dat2['reg_pic']>0){
			$notice[$c]['face']="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[3]}{$tmp_enc[2]}/".$prof_1;

		}else{
			$notice[$c]['face']="./img/noimage{$dat2['reg_sex']}.jpg";
		}

		if($dat2['check_date'] == '0000-00-00 00:00:00'){
			$notice[$c]['notice_yet']="notice_yet";
		}

		$tmp="<span id=\"p{$dat2['notice_id']}\" class=\"prof_jump\">{$dat2['reg_name']}さん</span>";
		$tmp2="<span id=\"c{$dat2['making_id']}\" class=\"prof_jump2\">応援されました</span>";

		$notice[$c]['notice_id']=$dat2['notice_id'];
		$notice[$c]['user_id']=$dat2['user_id'];
		$notice[$c]['target_id']=$dat2['target_id'];
		$notice[$c]['date']=substr($dat2["date"],5,2)."/".substr($dat2["date"],8,2)."　".substr($dat2["date"],11,2).":".substr($dat2["date"],14,2);
		$notice[$c]['notice_log']=str_replace("■target■",$tmp,$dat2['notice_log']);
		$notice[$c]['notice_log']=str_replace("■act■",$tmp2,$notice[$c]['notice_log']);
		$notice[$c]['check_date']=$dat2['check_date'];
		$c++;
	}
}

$sql ="UPDATE `me_notice` SET";
$sql.=" check_date='{$date}'";
$sql.=" WHERE `n_target_id`='{$user["id"]}'";
$sql.=" AND check_date='0000-00-00 00:00:00'";
mysqli_query($mysqli,$sql);

$n_max=$c;
if($n_max>20) $n_max=20;

//■□ネットワークプリントメンテナンス－－－－－

$met	=file_get_contents("https://api.networkprint.jp/rest/webapi/v2/maintenanceInfo");
$met2	=json_decode($met,true);
/*
print("■".$met2["status"]."▲<br>\n");
print("■".$met2["announcementHours"]."▲<br>\n");
print("■".$met2["maintenanceTime"]["type"]."▲<br>\n");
print("■".$met2["maintenanceTime"]["from"]."▲<br>\n");
print("■".$met2["maintenanceTime"]["to"]."▲<br>\n");
*/
if($met2["status"] == "emergency"){
	$net_mente=1;

}elseif($met2["status"] == "scheduled"){
	$net_mente=2;

}else{
	if($met2["maintenanceTime"]["from"] >$now && $met2["maintenanceTime"]["to"] > $now){
		$net_mente=3;
	}else{
		$net_mente=0;
	}
}
$er_msg[0]="メンテナンス情報はありません。";
$er_msg[1]="ただ今ネットワークプリントはメンテナンス中のため、ご利用いただけません。<br><span style=\"font-weight:600\">終了予定:未定</span>";
$er_msg[2]="ただ今ネットワークプリントはメンテナンス中のため、ご利用いただけません。<br><span style=\"font-weight:600\">終了予定:{$met2["maintenanceTime"]["to"]}</span><br>";
$er_msg[3]="ネットワークプリントは下記の予定でメンテナンスが行われます。<br>一時的にプリントサービスがご利用できなくなることがございます。ご了承ください。<br>メンテナンス期間<br>開始予定：{$met2["maintenanceTime"]["from"]}<br>終了予定：{$met2["maintenanceTime"]["to"]}<br>"
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,画像修正,onlyme,名刺作成,無料,簡単">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/index.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/mydata.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/first.js?_<?=date("YmdHi")?>"></script>
<script src="./js/index.js?_<?=date("YmdHi")?>"></script>
<script src="./js/mydata.js?_<?=date("YmdHi")?>"></script>
<script>
var Next_album=0;
var Next_notice=0;
var Next_fav_b=0;
var Next_fav_c=0;
var Ck_count=0;
var PrintCk=[];
var Maintenance=<?=$net_mente+0?>;

var VwBase =$(window).width()/100;
var VhBase =$(window).height()/100;
var ChBase =(VhBase*100)-(VwBase*101);
var User_id =<?=$user["id"]+0?>;
var iine_Pt =<?=$iine_pt+0?>;
</script>

<style>
</style>
</head>

<body class="body">
<?include_once("./x_head.php")?>
<div class="main">
	<div id="id_notice" class="album_tag album_tag_sel">お知らせ</div>
	<div id="id_album" class="album_tag">アルバム</div>
	<div id="fav_b" class="album_tag">フォロー</div>
	<div id="fav_c" class="album_tag">フォロワー</div>
<?if($user["id"] == "10002011"){?>
	<div id="id_print" class="album_tag">プリント</div>
<? } ?>

<!--■■■■■■■■■■■■■■■■■■■■■■■■-->
	<div class="notice_box">
		<div id="notice_in">
			<?for($n=0;$n<count($notice);$n++){?>

				<?if($n>=20){
					$n_next=$notice[$n]['no tice_id'];	
					break;
				}?>
				<div class="notice_list_1 <?=$notice[$n]['notice_yet']?>">
					<img src="<?=$notice[$n]['face']?>" class="notice_list_2">
					<div class="notice_list_3"><?=$notice[$n]['date']?></div>
					<div class="notice_list_4"><?=$notice[$n]['notice_log']?></div>
				</div>
			<? } ?>
			<?if($n_next){?>
				<div id="next_n<?=$n_next?>" class="next_n">続きを見る</div>
			<? } ?>

			<?if(count($notice)==0){?>
				<div class="p_cheer_cld5">お知らせはまだありません</div>
			<? } ?>
		</div>
	</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■-->
	<div class="album_box">
		<div id="album_in" class="index_box"></div>
	</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■-->	
	<div class="fav_b_box">
		<!--span class="fav_top"><?=$user["reg_name"]?>さんがファン登録している方です</span-->
		<div id="fav_in_b" class="fav_in"></div>
	</div>

	<div class="fav_c_box">
		<!--span class="fav_top"><?=$user["reg_name"]?>さんをファン登録している方です</span-->
		<div id="fav_in_c" class="fav_in"></div>
	</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■-->
	<div class="print_box">
		<div class="print_code">
			<div class="print_code_icon"></div>
			<div class="print_code_id"></div>
		</div>
		<div class="print_code_limit">
		使用期限：<span id="limit_date"></span><br>
		</div>
		<div class="print_code_text">
			プリントしたい印刷データを選んでください。<br>
			最大10個まで選択できます<br>
		</div>
		<div class="print_code_print"><span class="print_icon"></span>プリント方法</div>
		<div id="id_code_del" class="print_code_del"><span class="print_icon"></span>リストの削除</div>
		<div id="print_in" class="index_box"></div>
		<div class="print_list">
			<span class="print_icon"></span><div class="print_list_id">プリントリストを作成する</div>
		</div>
		<br><br><br>
	</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■-->
	<div class="print_box_out">
		<div class="print_err">
		<?=$er_msg[$net_mente]?>
		</div>
	</div>
</div>

<div class="p_page">
	<div id="p_page_out" class="back"><span class="icon_img"></span></div>
	<span class="p_date" style="left:30.5vw;"></span>
	<img id="tmpl" class="p_page_img">
	<div class="box_iine">
	<a href="" target="_BLANK" class="iine_twitter icon_img"></a>
	<div id="p_page_print" class="a_menu_list2"><span class="p_icon2 icon_img"></span><span class="p_icon_comment">印刷</span></div>
	<div id="p_page_comment2" class="a_menu_list3"><span class="p_icon2 icon_img"></span><span class="p_icon_comment">応援<span id="cheer_ct"></span></span></div>
	<div id="p_page_del" class="p_menu_del"><span class="p_icon3 icon_img"></span><span class="p_icon_comment2">削除</span></div>

	<div id="pritty" class="p_page_msg_a_my my_1">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">カワイイ</span>
		<span id="e_pritty" class="p_page_msg_c iine_my_c2"></span>
	</div>

	<div id="smart" class="p_page_msg_a_my my_2">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">イケメン</span>
		<span id="e_smart" class="p_page_msg_c iine_my_c2"></span>
	</div>

	<div id="funny" class="p_page_msg_a_my my_3">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">ユニーク</span>
		<span id="e_funny" class="p_page_msg_c iine_my_c2"></span>
	</div>

	<div id="sexy" class="p_page_msg_a_my my_4">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">セクシー</span>
		<span id="e_sexy" class="p_page_msg_c iine_my_c2"></span>
	</div>

	</div>
	<div class="p_cheer">
		<div class="cheer_list"></div>
		<div class="set_cheer"><span class="icon_img"></span>応援！</div>
	</div>
</div>
</div>
<div class="pop07">
	<div class="pop07_a">
		<div class="pop01_d1">
			削除します。よろしいですか。<br>
			一度削除されますと元には戻せません<br>
			応援、評価も消えてしまいます。ご注意ください<br>
		</div>

		<div class="pop01_d2">
			<div id="del_yes" class="btn c2">削除</div>　
			<div id="del_no" class="btn c1">取消</div>
		</div>

		<div class="pop01_d3">
			削除しました。<br><br>
		</div>
	
		<div class="pop01_d4">
			<div id="del_back" class="btn c1">戻る</div>
		</div>
	</div>
</div>

<div class="pop08">
	<div class="pop08_a">
		<div class="pop08_d1">
			印刷リストを削除します<br>
			※名刺データは削除されません<br>
		</div>
		<div class="pop08_d2">
			<div id="del_yes2" class="btn c2">削除</div>　
			<div id="del_no2" class="btn c1">取消</div>
		</div>
		<div class="pop08_d3">
			削除しました。<br><br>
		</div>
		<div class="pop08_d4">
			<div id="del_back2" class="btn c1">戻る</div>
		</div>
	</div>
</div>

<div class="pop09">
	<div class="pop09_a">
		<span style="font-weight:600">印刷データの作成</span><br>
		ネットワークプリントのご利用規約を確認し、同意いただく必要があります。<br>
		<a href="./inkiyaku_sharp.php"><span class="icon_img" style="font-size:4.5vw"></span>ご利用規約の確認</a><br>
	<div class="pop09_b">
<span class="icon_img" style="font-size:5.5vw"></span> 規約に同意する<br>
	</div>
	</div>
</div>

<div class="pop06">
	一度に選択できるのは10個までです。
</div>

<form id="p_jump" action="./profile.php" method="post">
	<input id="p_jump_id" type="hidden" name="n_host" value="">
</form>

<form id="f_jump" action="./profile.php" method="post" class="forms">
	<input id="f_jump_id" type="hidden" name="e_host" value="">
</form>
<div id="wait"><span id="wait_in"></span></div>
<?include_once("./x_foot.php")?>
</body>
</html>
