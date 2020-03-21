<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");

$cheer	=$_POST["cheer"];
$n_cheer=$_POST["n_cheer"];
$t_tag	=$_REQUEST["tag"];

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

if($t_tag =="print"){
//■□ネットワークプリントメンテナンス－－－－－
$met	=file_get_contents("https://api.networkprint.jp/rest/webapi/v2/maintenanceInfo");
$met2	=json_decode($met,true);
if($met2["status"] == "emergency"){
	$net_mente=1;

}elseif($met2["status"] == "scheduled"){
	$net_mente=2;

}else{
	if($met2["maintenanceTime"]["from"] <$now && $met2["maintenanceTime"]["to"] > $now){
		$net_mente=3;
	}else{
		$net_mente=0;
	}
}
}



$er_msg[0]="メンテナンス情報はありません。";
$er_msg[1]="ただ今ネットワークプリントはメンテナンス中のため、ご利用いただけません。<br><span style=\"font-weight:600\">終了予定:未定</span>";
$er_msg[2]="ただ今ネットワークプリントはメンテナンス中のため、ご利用いただけません。<br><span style=\"font-weight:600\">終了予定:{$met2["maintenanceTime"]["to"]}</span><br>";
$er_msg[3]="ネットワークプリントは下記の予定でメンテナンスが行われます。<br>一時的にプリントサービスがご利用できなくなることがございます。ご了承ください。<br>メンテナンス期間<br>開始予定：{$met2["maintenanceTime"]["from"]}<br>終了予定：{$met2["maintenanceTime"]["to"]}<br>";

$base_d=date("Y-m-d 23:59:00",time()-518400);
$sql="SELECT p_api_code FROM me_plist_main";
$sql.=" WHERE p_user_id='{$user["id"]}'";
$sql.=" AND p_del=0";
$sql.=" AND p_date>'{$base_d}'";
$sql.=" LIMIT 1";

$result = mysqli_query($mysqli,$sql);

if($dat_list = mysqli_fetch_assoc($result)){	
	$code=$dat_list["p_api_code"];
}

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
<link rel="stylesheet" href="./css/note.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/first.js?_<?=date("YmdHi")?>"></script>
<script src="./js/index.js?_<?=date("YmdHi")?>"></script>
<script src="./js/mydata.js?_<?=date("YmdHi")?>"></script>
<script>
var Next_album	=0;
var Next_notice	=0;
var Next_fav_b	=0;
var Next_fav_c	=0;
var Ck_count	=0;
var PrintCk		=[];
var Maintenance=<?=$net_mente+0?>;

var VwBase =$(window).width()/100;
var VhBase =$(window).height()/100;
var ChBase =(VhBase*100)-(VwBase*101);
var User_id =<?=$user["id"]+0?>;
var iine_Pt =<?=$iine_pt+0?>;

<?if($t_tag=="print"){?>
Ck_count=0;
PrintCk=new Array();	
$('.list_count').text(Ck_count);
$(function(){ 
	$('.album_tag').removeClass('album_tag_sel');
	$('#id_print').addClass('album_tag_sel');


	if(Maintenance>0){
		$('.print_box_out').fadeIn(100);
		$('.notice_box,.fav_b_box,.fav_c_box,.album_box,.print_box').hide();

	}else{
		$('.print_box').fadeIn(100);
		$('.notice_box,.fav_b_box,.fav_c_box,.album_box,.print_box_out').hide();
		$.post({
			url:'post_read_print.php',
			data:{'user_id':User_id},
			dataType: 'json',
			},
			function(data){
				$('#print_in').html(data.list);				

				if(data.code){
					$('.print_list,.print_code_text').hide();
					$('.print_code,.print_code_limit').show();
					$('#id_code_del').addClass('del_on');

					$('.print_code_id').text(data.code);				
					$('#limit_date').text(data.limit);				

				}else{
					$('.print_list,.print_code_text,.pop09').show();
					$('.print_code,.print_code_limit').hide();
					$('#id_code_del').removeClass('del_on');
				}
			}
		);
	}
});

<?}?>
</script>

<style>
<?if($prof['net_kiyaku']!='0000-00-00 00:00:00'){?>

<?}?>

</style>
</head>
<body class="body">
<?include_once("./x_head.php")?>
<div class="main">
	<div id="id_notice" class="album_tag album_tag_sel">お知らせ</div>
	<div id="id_album" class="album_tag">アルバム</div>
	<div id="fav_b" class="album_tag">フォロー</div>
	<div id="fav_c" class="album_tag">フォロワー</div>
<?if($user["id"] < "10002016"){?>
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
			名刺データ右上の『<span class="icon_img"></span>』をタップすることで、印刷リストに追加できます（最大10個）。<br>
		</div>

		<div class="print_code_print"><span class="print_icon"></span>プリント方法</div>

		<div id="id_code_del" class="print_code_del"><span class="print_icon"></span>リストの削除</div>

		<div id="print_in" class="index_box"></div>
		<div class="print_list">
			<span class="print_icon"></span>
			<div class="print_list_id">印刷リスト作成</div>
			<span class="list_count">0</span>
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
	<div id="p_page_info" class="info">
		<span class="icon_img"></span>
	</div>
	<div class="info_list">
	<div class="info_list_code">T00001</div>
	<div class="info_list_flex"></div>
	<a href="" class="info_list_btn">このデザインを使う</a>
	</div>


	<span class="p_date" style="left:32.5vw;"></span>
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
	</div>
</div>
</div>

<div class="pop06">
	一度に選択できるのは10個までです。
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
		<span style="font-weight:600">プリントリストの作成</span><br>
		ネットワークプリントのご利用規約を確認し、同意いただく必要があります。<br>
		<a href="./inkiyaku_sharp.php"><span class="icon_img" style="font-size:4.5vw"></span>ご利用規約の確認</a><br>
	<div class="pop09_b">
<span id="kiyaku_ck" class="icon_img" style="font-size:5.5vw"></span> 規約に同意する<br>
	</div>
	</div>
</div>


<div class="pop10">
<div class="page_top2"><span class="print_return icon_img"></span><span class="page_title">コンビニでの印刷方法について</span></div>
<div class="page_main">
<h2 class="h2">印刷可能なコンビニ</h2>
<div class="exp_box1">
<span class="ok1">ファミリーマート</span>と<span class="ok1">ローソン</span>のマルチコピー機で印刷可能です。<br>
<span class="ng1">セイコーマートのマルチコピー機、セブンイレブンのネットプリントはご利用いただけません。</span>ご注意ください。<br>
※一部対応していない店舗もございます。<br>
</div>

<h2 class="h2">プリントリスト作成</h2>
<div class="exp_box1">
<span class="ok2"><span class="icon_img"></span>Album</span>⇒<span class="ok2">「プリント」</span>を選択してください。<br>
プリントしたい名刺データの右上の『<span class="icon_img"></span>』をタップしますと、プリントリストに追加できます。<br>
プリントリストには最大10枚までの名刺データを追加できます。<br>
プリントリストは一つしか作成できません。新たに作成する場合は、既存のプリントリストを削除する必要があります。<br>
プリントリストの使用期限は作成日含め、7日間です。<br>
</div>
<h2 class="h2">プリント手順</h2>

<div class="exp_box1">
マルチコピー機での操作方法です。<br>
※写真はファミリーマートのものです。
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_01.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・<span style="font-weight:600">【プリントサービス】</span>を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_02.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・<span style="font-weight:600">【ネットワークプリント】</span>を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_03.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・<span style="font-weight:600">【ユーザー番号】</span>を入力。<br>
<?if($code){?>
		※ユーザー番号<br><span class="exp_code">[<?=$code?>]</span>
<?}else{?>		
		※ユーザー番号は<a href="./mydata.php?tag=print"><span class="exp_code">プリントリスト作成</span></a>のページに表示されます。
<?}?>

	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_04.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・<span style="font-weight:600">【L版写真プリント】</span>を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_05.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・<span style="font-weight:600">【2L】</span>を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_06.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・印刷したい名刺デザインと枚数を選択し、表示された金額をコインベンダーに投入。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_07.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・設定は変更せず、<span style="font-weight:600">【プリント開始】</span>を押してください。<br>
		※1枚の印刷時間は約1分30秒です。
	</div>
</div>
<br>
</div>
</div>

<form id="reload" action="./mydata.php" method="post">
	<input type="hidden" name="tag" value="print">
</form>

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
