<?php
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
include_once("./library/session.php");
include_once("./library/lib_regist.php");

$t_date=date("Y-m-d H:i:s");
$p_name		=$_POST["p_name"];
$p_mail		=$_POST["p_mail"];
$p_pass		=$_POST["p_pass"];
$p_state	=$_POST["p_state"];

$code=time()+$user["id"];
$p_code=substr("0000000000".$code,-12);

$sql ="INSERT INTO me_config_chg (`date`,`user_id`,`name`,`mail`,`pass`,`state`,`code`)";
$sql.="VALUES('{$t_date}','{$user["id"]}','{$p_name}','{$p_mail}','{$p_pass}','{$p_state}','{$p_code}')";
mysqli_query($mysqli,$sql);

	$msg=file_get_contents("./mail/mail_3.txt");
	$msg=str_replace("[code]",$p_code,$msg);
	$msg=str_replace("[name]",$p_name,$msg);

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
	$mailer->Subject  = mb_convert_encoding('会員登録変更',"UTF-8","AUTO");
	$mailer->Body     = mb_convert_encoding($msg,"UTF-8","AUTO");
	$mailer->AddAddress($me_mail);

/*
$to      = $p_mail;
$subject = "写真名刺簡単作成★OnlyMe";
$message = "下記リンクよりアクセスし、変更を完了させてください\n\nhttps://onlyme.fun/chg2.php?code=".$p_code."\n\n※登録後30分以上経過しますと無効となります。";
$headers = 'From: staff@onlyme.fun' . "\r\n";
mb_send_mail($to, $subject, $message, $headers);
*/


$_SESSION = array();
$user = array();
session_destroy(); 
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/regist.css?_<?=date("YmdHi")?>">
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
<h1 class="h1_irr"><span class="h1_title">登録情報変更</span></h1>
<div class="box_01">
確認メールが送信されました<br>
メールからログインを行ってください。<br>
<br>
<div class="box_02">
変更後、30分以上経過しますと変更手続きが無効となります。<br>
その際は再度変更手続きを行ってください。<bR>
変更手続きが完了するまでは、以前のメールアドレス、パスワードでログインが可能です。<br>
</div>
</div>
</div>
<?include_once("./x_foot.php")?>
</body>
</html>
