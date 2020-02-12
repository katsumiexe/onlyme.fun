<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=1;
$user_id=1;

$ask_name	=$_POST["ask_name"];	//■ニックネーム
$ask_mail	=$_POST["ask_mail"];	//■アドレス
$ask_log	=$_POST["ask_log"];
$send		=$_POST["send"];
$mode		=$_POST["mode"];
$back		=$_POST["back"];
$date		=date("Y-m-d H:i:s");

if($send){
	$mode++;

}elseif($back){
	$mode--;
}

if($mode==1){
	$tmp_log=str_replace("\n","<br>",$ask_log);
}


if($mode==2){
	$sql_up	 ="INSERT INTO me_post(`date`,`name`, `user_id`, `log`,`ua`,`ip`,`width`,`height`)";
	$sql_up	.="VALUES('{$date}', '{$user["reg_name"]}', '{$user["id"]}', '{$ask_log}','{$_REQUEST["n_ua"]}','{$_REQUEST["n_ip"]}','{$_REQUEST["n_width"]}','{$_REQUEST["n_height"]}'
)";
	mysqli_query ($mysqli,$sql_up);

	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	$to      = "onlymestaff@gmail.com";
	$subject = "OnlyMe_POST(in)";
	$message = $ask_log;
	$headers = 'From: dummy@onlyme.fun' . "\r\n";
	mb_send_mail($to, $subject, $message, $headers);

	$_POST="";
	$_REQUEST="";
}

$t_ua=$_SERVER['HTTP_USER_AGENT'];
$t_ip=$_SERVER['SERVER_ADDR'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」:POST</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,画像修正,onlyme,名刺作成,無料,簡単,とうらぶ,ボカロ">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/first.js"></script>
<script type="text/javascript">
$(function(){ 
    var w_w = $(window).width();
    var w_h = $(window).height();
	$('#send').click(function(){
		if ($('#ask_log').val() == '') {
			$('#err').text('本文がありません。');
			return false;
		} else {
			$('#forms').submit();
		}
	});
	$('#t_width').val(w_w);
	$('#t_height').val(w_h);

});
</script>
<style>

.box_01{
	width:90vw;
	background:#fff0e0;
	border-radius:1vw;
	border:1vw solid #f17766;
	padding:2vw;
	margin:2vw auto ;
	font-size:3.8vw;
	line-height:5vw;
}

.box_02{
	margin:1vw auto;
	width:70vw;
	text-align:left;
}

.box_03{
	text-align:center;
}


.box_04{
	width:80vw;
	background:#ffffff;
	border-radius:1vw;
	border:0.5vw solid #d0a000;
	padding:1vw;
	margin:2vw auto ;
	color:#606060;
	font-size:3.5vw;
	text-align:left;
}


.title{
	font-weight:600;
	font-size:3.5vw;
	color:#606060;
}

.area{
	width:68vw;
	height:40vw;
	font-size:4.5vw;
    border: 0.2vw solid #3498db;
	padding:0.5vw;;
}

</style>
</head>
<body class="body">
<?include_once("./x_head.php")?>
<div class="main">
<h1 class="h1"><span class="h1_title">ご意見メール</span></h1>

<form id="forms" action="./inpost.php" method="post">
<div id="err" style="color:#ff0000; font-weight:600; margin:3px auto; width:90%;height:20px;">　</div>
	<?if($mode == 1){?>
		<div class="box_01">
			下記のメールを送信します。よろしいですか。<br>
			<div class="box_04">
			<?=$tmp_log?>
			</div>

			<input type="hidden" value="<?=$ask_log?>" name="ask_log">
			<input type="hidden" value="<?=$mode?>" name="mode">

			<input type="hidden" id="t_width" name="n_width" value="">
			<input type="hidden" id="t_height" name="n_height" value="">
			<input type="hidden" id="t_ua" name="n_ua" value="<?=$t_ua?>">
			<input type="hidden" id="t_ip" name="n_ip" value="<?=$t_ip?>">

			<div style="text-align:center;">
				<button type="submit" value="send" name="send" class="btn c2">送信</button>
				<button type="submit" value="back" name="back" class="btn c1">戻る</button>
			</div>
		</div>

	<?}elseif($mode == 2){?>
		<div class="box_01">
<br>
<br>
		ご意見ありがとうございました。<br>
<br>
<br>
		</div>
	<?}else{?>
		<div class="box_01" style="text-align:left;">
			便利で使いやすいサイトにするため、お客様のご意見、ご要望をお寄せ下さいませ。<br>
			ご意見、ご要望、システム上の不具合や機能の希望などなんでも結構です。<br>
		</div>

		<div class="box_01">

			<div class="box_02">
				<textarea id="ask_log" class="area" name="ask_log"><?=$ask_log?></textarea>
			</div>

			<div class="box_03">
				<input type="hidden" value="<?=$mode+0?>" name="mode">
				<input type="hidden" value="send" name="send">
				<button id="send" type="submit" style="width:70%; height:9vw; font-size:4vw; font-weight:600;background:linear-gradient(#f0f0f0,#d0d0d0)">送　信</button>
			</div>
		</div>
	<?}?>
</form>
<?include_once("./x_foot.php")?>
</body>
</html>
