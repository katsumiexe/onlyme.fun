<?php

$headers = 'From: test@onlyme.fun\r\n';
$headers.= 'Content-Type: multipart/mixed; boundary="nyan"\r\n';
$to      = 'counterpost2016@gmail.com';
$subject = 'まるちぱーと';
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

mb_send_mail($to, $subject, $msg, $headers);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<body class="body">
にゃんにゃ

</body>
</html>
