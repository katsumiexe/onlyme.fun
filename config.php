<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=4;

if($_POST["send"]){
	$open_fb	=$_POST["open_fb"];
	$open_url	=$_POST["open_url"];
	$open_cosp	=$_POST["open_cosp"];
	$open_insta	=$_POST["open_insta"];
	$open_twitter=$_POST["open_twitter"];

	$twitter	=$_POST["twitter"];
	$mail		=$_POST["mail"];
	$cosp		=$_POST["cosp"];
	$url		=$_POST["url"];
	$name		=$_POST["name"];
	$qr			=$_POST["qr"];
	$insta		=$_POST["insta"];
	$orgin		=$_POST["orgin"];
	$quality	=$_POST["quality"]+0;

	$twitter=mb_convert_kana($twitter,'rans');
	$twitter=str_replace(" ","",$twitter);

	$insta=mb_convert_kana($insta,'rans');
	$insta=str_replace(" ","",$insta);

	$cosp=mb_convert_kana($cosp,'rans');
	$cosp=str_replace(" ","",$cosp);

	$sql ="UPDATE me_prof SET";
	$sql.=" `name`='{$name}',";
	$sql.=" `orgin`='{$orgin}',";
	$sql.=" `mail`='{$mail}',";
	$sql.=" `qr`='{$qr}',";

	$sql.=" `fb`='{$fb}',";
	$sql.=" `twitter`='{$twitter}',";
	$sql.=" `cosp`='{$cosp}',";
	$sql.=" `url`='{$url}',";
	$sql.=" `insta`='{$insta}',";

	$sql.=" `open_fb`='{$open_fb}',";
	$sql.=" `open_url`='{$open_url}',";
	$sql.=" `open_cosp`='{$open_cosp}',";
	$sql.=" `open_insta`='{$open_insta}',";
	$sql.=" `open_twitter`='{$open_twitter}',";
	$sql.=" `quality`='{$quality}'";

	$sql.=" WHERE prof_id='{$user["id"]}'";
	mysqli_query($mysqli,$sql);

	$prof["name"]	=$_POST["name"];
	$prof["orgin"]	=$_POST["orgin"];
	$prof["qr"]		=$_POST["qr"];
	$prof["mail"]	=$_POST["mail"];

	$prof["twitter"]=$_POST["twitter"];
	$prof["insta"]	=$_POST["insta"];
	$prof["cosp"]	=$_POST["cosp"];
	$prof["url"]	=$_POST["url"];
	$prof["fb"]		=$_POST["fb"];

	$prof["quality"]=$_POST["quality"];

	$prof["open_twitter"]=$_POST["open_twitter"];
	$prof["open_insta"]	=$_POST["open_insta"];
	$prof["open_cosp"]	=$_POST["open_cosp"];
	$prof["open_url"]	=$_POST["open_url"];
	$prof["open_fb"]	=$_POST["open_fb"];
}

$line_qr=$dir3.$tmp_enc[2]."s".$tmp_enc[3].".png";

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
<link rel="canonical" href="http://onlyme.fun/index.php">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/config.css?_<?=date("YmdHi")?>">
<style>
.q_off{
	background:linear-gradient(#e0e0e0,#cccccc);
	<?if($prof["quality"] != 1){?>display:none;<?}?>
}

.q_on{
	background:linear-gradient(#9000a0,#600090);
	<?if($prof["quality"] == 1){?>display:none;<?}?>
}
</style>
<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/jquery.exif.js"></script>
<script>
var User_id =<?=$user["id"]+0?>;
var NoImg ='./img/noimage<?=$user['reg_sex']?>.jpg';
$(function(){ 
<?if(!$prof["twitter"]){?>
	$('#switch1').prop('disabled', true);
<?}else{?>
	$('#qr3').removeClass('sel_off');
<?}?>

<?if(!$prof["insta"]){?>
	$('#switch2').prop('disabled', true);
<?}else{?>
	$('#qr4').removeClass('sel_off');
<?}?>

<?if(!$prof["fb"]){?>
	$('#switch3').prop('disabled', true);
<?}else{?>
	$('#qr5').removeClass('sel_off');
<?}?>

<?if(!$prof["cosp"]){?>
	$('#switch4').prop('disabled', true);
<?}else{?>
	$('#qr6').removeClass('sel_off');
<?}?>

<?if(!$prof["url"]){?>
	$('#switch5').prop('disabled', true);
<?}else{?>
	$('#qr7').removeClass('sel_off');
<?}?>
<?if($prof["qr"]>0){?>
	Clr2 =$('#qr'+<?=$prof["qr"]?>).html();
	$('#qr_select').html(Clr2);
<?}?>
});
</script>
<script src="./js/config.js?_<?=date("YmdHi")?>"></script>
<script src="./js/first.js?_<?=date("YmdHi")?>"></script>
</head>
<body class="body">
<?include_once("./x_head.php")?>
<div class="main">
<H1 class="h1"><span class="h1_title">登録情報変更</span></h1>
<form id="form1" action="mail_chg.php" method="post">
<input type="hidden" value="1" name="send">

<div class="config_id">
	<span style="font-weight:600;">ID:</span><?=$user["id"]?>　 
	<span style="font-weight:600;">性別:</span><?=$l_sex[$user["reg_sex"]]?>　
	<span style="font-weight:600;">誕生日:</span><?=substr($user["reg_birth"],0,4)?>年<?=substr($user["reg_birth"],5,2)?>月<?=substr($user["reg_birth"],8,2)?>日
</div>

<table class="config_img">
	<tr>
		<td class="config_img_a" rowspan="3"><img src="<?=$user_face?>?t=<?=time()?>" class="config_img_a1"></td>
		<td class="config_img_b">
			<img id="sumb1" src="<?=$prof_img[1]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 1){?> img_sel<?}?>">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t1" class="img_btn1 btn_set">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="config_img_b">
			<img id="sumb2" src="<?=$prof_img[2]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s2" class="img_btn1<?if(strpos($prof_img[2],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 2){?> img_sel<?}?>">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t2" class="img_btn1 btn_set">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d2" class="img_btn1<?if(strpos($prof_img[2],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="config_img_b">
			<img id="sumb3" src="<?=$prof_img[3]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s3" class="img_btn1<?if(strpos($prof_img[3],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 3){?> img_sel<?}?>">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t3" class="img_btn1 btn_set">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d3" class="img_btn1<?if(strpos($prof_img[3],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="icon_img icon_5s img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
</table>

<h2 class="h1"><span class=h1_title>テンプレート</span></h2>
<div class="fbox">
<!--
	<div class="item1"><span class="icon_img icon_5" style="margin:0 1.5vw"></span>メール</div><div class="item3">携帯、PC可。50字以内</div>
	<div class="item2"><input id="ck_mail" type="email" value="<?=$prof["mail"]?>" name="mail" class="item2_box"></div>
	<div class="item2">
		<div class="item2_1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>画質設定</div>
		<div class="item2_2">
			<span class="img_q q_on">高画質 ON</span>
			<span class="img_q q_off">高画質 OFF</span>
		</div>
		<input id="q_on_off" type="hidden" value="<?=$prof["quality"]+0?>" name="quality">
	</div>
-->
<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>QRコード</div><div class="item3"><?if($exp>=100){?>QRコードの設定<?}else{?>LVアップで変更可能<?}?></div>
<div class="item2">
	<div id="qr_select" class="item2_box"><span class="qr_option_icon"></span><span class="qr_option_txt">onlyme</span></div>
	<div class="item2_box_d">▼</div>
	<?if($exp>=100){?>
		<div id="qr_option" class="qr_option">
			<span id="qr1" class="qr_option_a"><span class="qr_option_icon"></span><span class="qr_option_txt">onlyme</span></span>
<?if(file_exists($line_qr)){?>
			<span id="qr6" class="qr_option_a word2_c6"><span class="qr_option_icon"></span><span class="qr_option_txt">LINE</span></span>
<?}?>
			<span id="qr3" class="qr_option_a word2_c3"><span class="qr_option_icon"></span><span class="qr_option_txt">twitter</span></span>
			<span id="qr4" class="qr_option_a word2_c4"><span class="qr_option_icon"></span><span class="qr_option_txt">Instagram</span></span>
			<span id="qr5" class="qr_option_a word2_c5"><span class="qr_option_icon"></span><span class="qr_option_txt">Cosplayer Archive</span></span>
			<span id="qr2" class="qr_option_a"><span class="qr_option_icon"></span><span class="qr_option_txt">未使用</span></span>
		</div>
	<?}?>
	<input type="hidden" id="qr" value="<?=$prof["qr"]?>" name="qr">
</div>

<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>ハンドル</div>
<div class="item3">10字まで</div>
<div class="item2"><input id="ck_name" type="text" name="name" value="<?=$prof["name"]?>" class="item2_box" maxlength="10"></div>

<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>作品名</div>
<div class="item3">12字まで</div>
<div class="item2"><input id="ck_orgin" type="text" name="orgin" value="<?=$prof["orgin"]?>" class="item2_box" maxlength="12"></div>


<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>Twitter</div>
<div class="item3">
	<div class="switch">
		<input type="checkbox" value="1" name="open_twitter" id="switch1" class="switch_ck"<?if($prof["open_twitter"] == 1){?> checked="checked"<? } ?>>
		<label for="switch1" class="switch_label"><span></span></label>
		<div class="sw_img"></div>
	</div>
</div>
<div class="item2"><input id="ck_twitter" type="text" name="twitter" value="<?=$prof["twitter"]?>" class="item2_box"></div>


<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>Instagram</div>
<div class="item3">
	<div class="switch">
		<input type="checkbox" value="1" name="open_insta" id="switch2" class="switch_ck"<?if($prof["open_insta"] == 1){?> checked="checked"<? } ?>>
		<label for="switch2" class="switch_label"><span></span></label>
		<div class="sw_img"></div>
	</div>
</div>
<div class="item2"><input id="ck_insta" type="text" name="insta" value="<?=$prof["insta"]?>" class="item2_box"></div>

<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>Cosp</div>
<div class="item3">
	<div class="switch">
		<input type="checkbox" value="1" name="open_cosp" id="switch4" class="switch_ck"<?if($prof["open_cosp"] == 1){?> checked="checked"<? } ?>>
		<label for="switch4" class="switch_label"><span></span></label>
		<div class="sw_img"></div>
	</div>
</div>
<div class="item2"><input id="ck_cosp" type="number" name="cosp" value="<?=$prof["cosp"]?>" class="item2_box"></div>
</div>
<div id="set2" class="set_btn">変更する</div>

<h2 class="h1"><span class=h1_title>基本情報</span></h2>
<table class="config_table1">
	<tr>
		<td class="item1_n"><span class="icon_img icon_5" style="margin:0 1.5vw"></span><span class="item3_n">name/登録名</span></td>
	</tr>
	<tr>
		<td class="item3_n"><input type="text" id="p_name" name="p_name" value="<?=$user["reg_name"]?>" class="item2_box"></td>
	</tr>
	<tr>
		<td class="item4_n"></td>
	</tr>

	<tr>
		<td class="item1_n"><span class="icon_img icon_5" style="margin:0 1.5vw"></span><span class="item3_n">mail/メールアドレス</span></td>
	</tr>
	<tr>
		<td class="item3_n"><input type="text" id="p_mail" name="p_mail" value="<?=$user["reg_mail"]?>" class="item2_box"></td>
	</tr>
	<tr>
		<td class="item4_n"></td>
	</tr>

	<tr>
		<td class="item1_n"><span class="icon_img icon_5" style="margin:0 1.5vw"></span><span class="item3_n">pass/パスワード</span></td>
	</tr>
	<tr>
		<td class="item3_n"><input type="text" id="p_pass" name="p_pass" value="<?=$user["reg_pass"]?>" class="item2_box"></td>
	</tr>
	<tr>
		<td class="item4_n"></td>
	</tr>

	<tr>
		<td class="item1_n"><span class="icon_img icon_5" style="margin:0 1.5vw"></span><span class="item3_n">state/都道府県</span></td>
	</tr>
	<tr>
		<td class="item3_n">
			<select id="p_state" class="item2_box" name="p_state">
				<option value="">選択</option>
				<option value="1"<? if($user["reg_state"] =="1") print(" selected")?>>北海道</option>
				<option value="4"<? if($user["reg_state"] =="4") print(" selected")?>>宮城県</option>
				<option value="7"<? if($user["reg_state"] =="7") print(" selected")?>>福島県</option>
				<option value="3"<? if($user["reg_state"] =="3") print(" selected")?>>岩手県</option>
				<option value="2"<? if($user["reg_state"] =="2") print(" selected")?>>青森県</option>
				<option value="5"<? if($user["reg_state"] =="5") print(" selected")?>>秋田県</option>
				<option value="6"<? if($user["reg_state"] =="6") print(" selected")?>>山形県</option>
				<option value="13"<? if($user["reg_state"] =="13") print(" selected")?>>東京都</option>
				<option value="14"<? if($user["reg_state"] =="14") print(" selected")?>>神奈川県</option>
				<option value="11"<? if($user["reg_state"] =="11") print(" selected")?>>埼玉県</option>
				<option value="12"<? if($user["reg_state"] =="12") print(" selected")?>>千葉県</option>
				<option value="8"<? if($user["reg_state"] =="8") print(" selected")?>>茨城県</option>
				<option value="9"<? if($user["reg_state"] =="9") print(" selected")?>>栃木県</option>
				<option value="10"<? if($user["reg_state"] =="10") print(" selected")?>>群馬県</option>
				<option value="17"<? if($user["reg_state"] =="17") print(" selected")?>>石川県</option>
				<option value="16"<? if($user["reg_state"] =="16") print(" selected")?>>富山県</option>
				<option value="18"<? if($user["reg_state"] =="18") print(" selected")?>>福井県</option>
				<option value="15"<? if($user["reg_state"] =="15") print(" selected")?>>新潟県</option>
				<option value="20"<? if($user["reg_state"] =="20") print(" selected")?>>長野県</option>
				<option value="19"<? if($user["reg_state"] =="19") print(" selected")?>>山梨県</option>
				<option value="23"<? if($user["reg_state"] =="23") print(" selected")?>>愛知県</option>
				<option value="22"<? if($user["reg_state"] =="22") print(" selected")?>>静岡県</option>
				<option value="21"<? if($user["reg_state"] =="21") print(" selected")?>>岐阜県</option>
				<option value="24"<? if($user["reg_state"] =="24") print(" selected")?>>三重県</option>
				<option value="27"<? if($user["reg_state"] =="27") print(" selected")?>>大阪府</option>
				<option value="26"<? if($user["reg_state"] =="26") print(" selected")?>>京都府</option>
				<option value="28"<? if($user["reg_state"] =="28") print(" selected")?>>兵庫県</option>
				<option value="25"<? if($user["reg_state"] =="25") print(" selected")?>>滋賀県</option>
				<option value="29"<? if($user["reg_state"] =="29") print(" selected")?>>奈良県</option>
				<option value="30"<? if($user["reg_state"] =="30") print(" selected")?>>和歌山県</option>
				<option value="34"<? if($user["reg_state"] =="34") print(" selected")?>>広島県</option>
				<option value="33"<? if($user["reg_state"] =="33") print(" selected")?>>岡山県</option>
				<option value="35"<? if($user["reg_state"] =="35") print(" selected")?>>山口県</option>
				<option value="31"<? if($user["reg_state"] =="31") print(" selected")?>>鳥取県</option>
				<option value="32"<? if($user["reg_state"] =="32") print(" selected")?>>島根県</option>
				<option value="37"<? if($user["reg_state"] =="37") print(" selected")?>>香川県</option>
				<option value="38"<? if($user["reg_state"] =="38") print(" selected")?>>愛媛県</option>
				<option value="39"<? if($user["reg_state"] =="39") print(" selected")?>>高知県</option>
				<option value="36"<? if($user["reg_state"] =="36") print(" selected")?>>徳島県</option>
				<option value="40"<? if($user["reg_state"] =="40") print(" selected")?>>福岡県</option>
				<option value="41"<? if($user["reg_state"] =="41") print(" selected")?>>佐賀県</option>
				<option value="42"<? if($user["reg_state"] =="42") print(" selected")?>>長崎県</option>
				<option value="44"<? if($user["reg_state"] =="44") print(" selected")?>>大分県</option>
				<option value="43"<? if($user["reg_state"] =="43") print(" selected")?>>熊本県</option>
				<option value="45"<? if($user["reg_state"] =="45") print(" selected")?>>宮崎県</option>
				<option value="46"<? if($user["reg_state"] =="46") print(" selected")?>>鹿児島県</option>
				<option value="47"<? if($user["reg_state"] =="47") print(" selected")?>>沖縄県</option>
			</select>
		</td>
	</tr>
</table>

<div style="padding-bottom:1vw;">
	<div id="set1" class="set_btn">変更する</div>
	<div class="remove_comm">
		※登録情報を変更されますと一旦ログアウトし、登録メールアドレスに認証メールが送信されます。<br>
		変更を有効にするには、認証メールからのログインが必要となります。<br>
		<?if($user["reg_rank"] != 11){?> SNSからの登録の場合、パスワードを設定しないと登録名とメールアドレスをこちらから変更することができません。<br><?}?>
	</div>
</div>

<?if($user["reg_line"]){?>
<H2 class="h1"><span class=h1_title>LINE連携</span></h2>
<div style="padding-bottom:5vw;text-align:center;">
	<div id="set3" class="set_btn"><span class="icon_img" style="font-weight:400;"></span>LINE連携解除</div>
	<div id="set3" class="set_btn"><span class="icon_img"></span>QRコード登録</div>


	<div class="remove_comm">
		※退会されますとアルバムは全て削除されます<br>
		退会後、24時間以内の再開はできません。ご注意ください<br>	
	</div>
</div>
<?}?>



<H2 class="h1"><span class=h1_title>退会</span></h2>
<div style="padding-bottom:5vw;text-align:center;">
	<div id="set3" class="set_btn">退会する</div>
	<div class="remove_comm">
		※退会されますとアルバムは全て削除されます<br>
		退会後、24時間以内の再開はできません。ご注意ください<br>	
	</div>
</div>

<div class="pop00"></div>
<div class="err00">
	<div id="#err" style="text-align:left;width:100%;"></div>
	<div class="btn c1">戻る</div>
</div>

<div class="pop01">
	※Mail、PASSを変更されますと一旦ログアウトし、登録メールアドレスに認証メールが送信されます。<br>
	変更を有効にするには、認証メールからのログインが必要となります。<br>
	よろしいですか

	<div class="pop_notice">
		<div id="yes_1" class="btn c2">はい</div>　
		<div class="btn c1">いいえ</div>
	</div>

</div>

<div class="pop02">
	※変更します。よろしいですか。<br>

	<div class="pop_notice">
		<div id="yes_2" class="btn c2">はい</div>　
		<div class="btn c1">いいえ</div>
	</div>
</div>

<div class="pop03">
	※退会されますとアルバムは全て削除されます<br>
	退会後、24時間以内の再開はできません。ご注意ください<br>
	<div class="pop_notice">
		<div id="yes_3" class="btn c2">退会する</div>　
		<div class="btn c1">戻る</div>
	</div>
</div>

<div class="pop04">
	<div id="msg"></div>
	<img id="prv">
	<div class="pop04_msg">
		<div id="yes_4" class="btn c2">削除</div>　
		<div class="btn c1">戻る</div>
	</div>
</div>

<div class="pop05">
	<div class="img_box_in">
		<div class="img_box_in111"><canvas id="cvs1" width="400px" height="400px;" style=" background:#f0f0f0;"></canvas></div>
		<div class="img_box_out1"></div>
		<div class="img_box_out2"></div>
		<div class="img_box_out3"></div>
		<div class="img_box_out4"></div>
		<div class="img_box_out5"></div>
		<div class="img_box_out6"></div>
		<div class="img_box_out7"></div>
		<div class="img_box_out8"></div>
	</div>

	<div class="img_box_in2">
		<label for="upd" class="upload_btn"><span class="icon_img upload_icon"></span><span class="upload_txt">画像選択</span></label>
		<span class="img_rote icon_img"></span>
		<span class="img_reset icon_img"></span>
	</div>

	<div class="img_box_in3">
		<div class="zoom_mi">-</div>
		<div class="zoom_rg"><input id="input_zoom" type="range" name="num" min="100" max="200" step="1" value="100" class="range_bar"></div>
		<div class="zoom_pu">+</div><div class="zoom_box">100</div>
	</div>

	<div class="img_box_in4">
		<div id="yes_5" class="btn c2">登録</div>　
		<div class="btn c1">戻る</div>
	</div>
</div>

<input id="img_top" type="hidden" name="img_top" value="10">
<input id="img_left" type="hidden" name="img_left" value="10">

<input id="img_width" type="hidden" name="img_width" value="10">
<input id="img_height" type="hidden" name="img_height" value="10">

<input id="img_zoom" type="hidden" name="img_zoom" value="100">
<input id="upd" type="file" accept="image/*" style="display:none;">
</form>

<div id="err"></div>
<div id="wait"><span id="wait_in"></span></div>
</div>
<?include_once("./x_foot.php")?>
</body>
</html>
