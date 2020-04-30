<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
mb_language("Japanese");
mb_internal_encoding("UTF-8");

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/POP3.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/OAuth.php';
require 'PHPMailer/language/phpmailer.lang-ja.php';

include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
include_once("./library/lib_regist.php");


$me_mail	=$_REQUEST["me_mail"];	//■アドレス
$send		=$_REQUEST["send"];

$date		=date("Y-m-d H:i:s");
$date_lim	=date("Y-m-d H:i:s",time()-86400);
$date_code	=date(mYsdHi).$me_pass;

if($me_mail){
	$mode=3;
	$sql	 ="SELECT * FROM reg";
	$sql	.=" WHERE reg_mail='{$me_mail}'";
	$sql	.=" AND reg_rank='2'";
	$sql	.=" AND reg_remove_day<'{$date_lim}'";
	$sql	.=" LIMIT 1";

	$dat2=mysqli_query($mysqli,$sql);

	if($dat = mysqli_fetch_assoc($dat2)){
		$code=time()+$dat["id"];
		$p_code=substr("0000000000".$code,-12);


		$msg=file_get_contents("./mail/mail_3.txt");
		$msg=str_replace("[code]",$p_code,$msg);

		$mailer = new PHPMailer();
		$mailer->IsSMTP();

		$mailer->Host		= $host;
		$mailer->CharSet	= 'utf-8';
		$mailer->SMTPAuth	= TRUE;
		$mailer->Username	= $mail_from;
		$mailer->Password	= $mail_pass;
		$mailer->SMTPSecure = 'tls';
		$mailer->Port		= 587;
	//	$mailer->SMTPDebug = 2;

		$mailer->From     = $mail_from;
		$mailer->FromName = mb_convert_encoding("写真名刺作成サイト★OnlyMe","UTF-8","AUTO");
		$mailer->Subject  = mb_convert_encoding('会員再登録',"UTF-8","AUTO");
		$mailer->Body     = mb_convert_encoding($msg,"UTF-8","AUTO");
		$mailer->AddAddress($me_mail);

		if($mailer->Send()){
		}else{
			$sql="INSERT INTO mail_error_log (`date`,`log_no`,`to_mail`)";
			$sql.=" VALUES('{$date}','regist_again.php','{$me_mail}');";
			mysqli_query($mysqli,$sql);
		}

	}else{
		$mode=2;	
	}
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
	$('#send').click(function(){
		if ($('#me_mail').val() == '') {
			$('#err').text('メールアドレスが空欄です');
			return false;

		}else if(!$('#me_mail').val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){
			$('#err').text('メールアドレスが不正です');
			return false;

		} else {
			var Add=$('#me_mail').val();
			$.post("post_check_address.php",
				{
					'check':Add
				},
				function(data){
					Res=$.trim(data);
					if(Res == "ok"){
						$('#err').text('このメールアドレスは登録されていません');
						return false;
					}else{	
						$('#forms').submit();
					}
				}
			);
		}
	});
});
</script>
</head>
<body class="body">
<div class="pc_only">
	<img src="./img/top.png" style="width:700px;"><br>
	<div class="pc_box" style="font-size:14px;">
		こちらはスマホ専用サイトです。<br>
		PC・タブレットではご利用いただけません。<br>
	</div>
</div>
<div class="main_irr sp_only">
<a href="./index.php" class="irr_top">写真名刺作成サイト★OnlyMe</a>
<h1 class="h1"><span class="h1_title">再登録</span></h1>
<?if($mode == 3){?>
<div class="box_01">
	<span style="font-weight:600;width:100%;text-align:center;">再登録受付完了</span><br>
	<div class="box_02">
		入力されたメールアドレスに確認メールを送信しました。<br>
		ログインされますと、再登録完了となります。<br>
		※30分を過ぎますと再登録手続きは無効となります。その際は再度申請を行ってください。<br>
	</div>
</div>
<?}elseif($mode == 2){?>
<div class="box_01">
	<span style="font-weight:600;width:100%;text-align:center;">エラーが発生しました</span><br>
	<div class="box_02">
処理時にエラーが発生しました。<br>
以下の可能性が考えられます。<br>
・すでに再開処理がされている<br>
・退会してから24時間経過していない<br>
・メールアドレスが間違っている<br>
・再開処理ができないアカウント<br>
	</div>
</div>

<?}else{?>
<form id="forms" action="./regist_again.php" method="post">
<div class="box_01">
登録されたメールアドレスをご入力下さい<br><br>
	<div class="box_02">
		<div class="title">メールアドレス</div>
		<div><input id="me_mail" type="text" value="" name="me_mail" class="send_box" maxlength="50"></div>
		<div class="and">※最大50文字</div>
	</div>
	<div class="box_03">
		<button id="send" type="button" value="送信" name="send" class="send_btn">送　信</button>
	</div>
</div>
<div id="err"></div>
</form>
<?}?>

<div class="ft_box">
<a href="policy.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">プライバシーポリシー</span></a>
<a href="kiyaku.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">利用規約</span></a>
<a href="outpost.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">お問い合わせ・ご意見</span></a>
</div>
</div>
<?include_once("./x_foot.php")?>
</body>
</html>
