<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");

$me_pass	=$_REQUEST["me_pass"];	//■ニックネーム
$me_mail	=$_REQUEST["me_mail"];	//■アドレス
$send		=$_REQUEST["send"];
$reg_code	=$_REQUEST["reg_code"];

$nowpage=4;

$date		=date("Y-m-d H:i:s");
$date_code	=date(mYsdHi).$me_pass;

if($me_pass && $me_mail){
	$mode=3;
	$sql_up	 ="INSERT INTO reg_try(`date`,`date_code`, `mail`, `pass`, `reg_code`)";
	$sql_up	.="VALUES('{$date}', '{$date_code}', '{$me_mail}', '{$me_pass}', '{$reg_code}')";
	mysqli_query ($mysqli,$sql_up);


	$msg=file_get_contents("./mail/mail_1.txt");
	$msg=str_replace("[code]",$date_code,$msg);

	mb_language("Japanese");
	mb_internal_encoding("UTF-8");




	$to      = $me_mail;
	$subject = "写真名刺作成サイト★OnlyMe";
	$message = "下記リンクよりアクセスし、無料登録を完了させてください\n\nhttps://onlyme.fun/regist2.php?target=".$date_code."\n\n※登録後30分以上経過しますと、登録は無効となります。";
	$headers = 'From:register@onlyme.fun' . "\r\n";
	mb_send_mail($to, $subject, $msg, $headers);





}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/regist.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(function(){ 
	$('.kiyaku').on('click',function(){

		if($(this).hasClass('kiyaku_on')){
			$(this).removeClass('kiyaku_on');
			$('.kiyaku_ck').animate({'height':'0vw'},200).css({"border-color":'#666666'});

		}else{
			$(this).addClass('kiyaku_on');
			$('.kiyaku_ck').animate({'height':'4vw'},200).css({"border-color":'#ff3030'});
		}
	});

	$('#send').click(function(){
		if ($('#me_pass').val() == '') {
			$('#err').text('パスワードが空欄です');
			return false;

		}else if ($('#me_mail').val() == '') {
			$('#err').text('メールアドレスが空欄です');
			return false;

		}else if(!$('#me_mail').val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){
			$('#err').text('メールアドレスが不正です');
			return false;

		}else if ($('#me_pass').val().length > 50) {
			$('#err').text('パスワードが長すぎます');
			return false;

		}else if ($('#me_pass').val().length < 4) {
			$('#err').text('パスワードが短すぎます');
			return false;

		}else if ($('.kiyaku').hasClass('kiyaku_on')) {
			var Add=$('#me_mail').val();
			$.post("post_check_address.php",
				{
					'check':Add
				},
				function(data){
					console.log(Add);
					console.log(data);
					Res=$.trim(data);
					if(Res == "ok"){
						$('#forms').submit();
					}else{	
						$('#err').text('すでに登録済のメールアドレスです');
						return false;
					}
				}
			);
		} else {
			$('#err').text('利用規約を確認下さい。');
			return false;

		}
	});
});
</script>
</head>
<body class="body">
<?include_once("./x_irr.php")?>
<div class="main">
<h1 class="h1"><span class="h1_title">新規登録(無料)</span></h1>

<?if($mode == 3){?>

<div class="box_01">
<span style="font-weight:600;width:100%;text-align:center;">仮登録受付完了</span><br>
<div class="box_02">
入力されたメールアドレスに登録メールを送信しました。<br>
※30分を過ぎますと仮登録は無効となります。その際は再度仮登録申請を行ってください。<br>
</div>
</div>
<?}else{?>
<form id="forms" action="./regist.php" method="post">
<div class="box_01">
	<div class="box_02">
		<span class="title">メールアドレス</span><span class="and">(最大50文字)</span><br>
		<input id="me_mail" type="text" value="" name="me_mail" class="send_box"><br>
	</div>

	<div class="box_02">
		<span class="title">パスワード</span><span class="and">(半角英数字4～10文字)</span><br>
		<input id="me_pass" type="text" value="" name="me_pass" class="send_box"><br>
	</div>
	<div id="err"></div>
	<div class="kiyaku"><div class="kiyaku_ck"></div>利用規約に同意する</div>
	<div class="box_03">
		<button id="send" type="button" value="送信" name="send" class="send_btn" >送　信</button>
	</div>
	<div class="box_04">
		<a href="lost_pass.php">パスワードを忘れた</a><br>
		<a href="regist_again.php">退会からの再開</a></br>
	</div>
</div>
<input type="hidden" value="<?=$reg_code?>" name="reg_code">
</form>
<?}?>
<div class="ft_box">
<a href="policy.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">プライバシーポリシー</span></a>
<a href="kiyaku.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">利用規約</span></a>
<a href="outpost.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">お問い合わせ・ご意見</span></a>
</div>
</div>
<?include_once("./x_foot.php")?>
</body>
</html>


