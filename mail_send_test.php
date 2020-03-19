<?php

$msg ='--nyan';
$msg.='Content-Type: text/plain; charset="iso-2022-jp"';
$msg.='Content-Transfer-Encoding: 7bit';
$msg.='にゃんにゃか。';
$msg.='にゃんにゃん';
$msg.='--nyan';
$msg.='Content-Type: text/html; charset="iso-2022-jp"';
$msg.='Content-Transfer-Encoding: 7bit';
$msg.='<!DOCTYPE HTML>';
$msg.='<html>';
$msg.='<head></head>';
$msg.='<body>';
$msg.='<span style="color:#ff0000">にゃんにゃか</span><br>';
$msg.='<span style="color:#0000ff">にゃんにゃん</span><br>';
$msg.='</body>';
$msg.='</html>';
$msg.='--nyan';


$mail	="counterpost2016@gmail.com";
$subject	= "てすと";//■メールタイトル

$from		= "onlymestaff@gmail.com";//■送信メールアドレス・エラー時戻りアドレス
$from_name	= "差出人";//■差出人
$pass		= "http://piyo-piyo.work/simulator/";//■このファイルが入っているフォルダ
$ret= "-f ".$from;

$head  = 'From:' . mb_encode_mimeheader($from_name,"ISO-2022-JP") . '<{$from}> \r\n';
$head .= 'Content-Type: multipart/mixed; boundary=nyan \r\n';


mb_send_mail($mail, $subject, $msg, $head, $ret);

?>
<!DOCTYPE HTML>
<html lang="ja">
<body class="body">
にゃんにゃん

</body>
</html>
