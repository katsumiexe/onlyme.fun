<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
mysqli_set_charset($mysqli,'UTF-8'); 

$user_id	=$_REQUEST["user_id"];
$card_id	=$_REQUEST["card_id"];
$log		=$_REQUEST["log"];

$date=date("Y-m-d H:i:s");

$sql_log="INSERT INTO me_alert(`al_date`,`al_card_id`,`al_user_id`,`al_log`)";
$sql_log.=" VALUES('{$date}','{$card_id}','{$user_id}','{$log}')";
mysqli_query($mysqli,$sql_log);
print($sql_log);

mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to      = "info@onlyme.fun";
$subject = "user_alert";
$message = "user:".$user_id."\n";
$message .= "card:".$card_id."\n";
$message .= "------------------------------\n";
$message .= $log."\n";

$headers = 'From: alert@onlyme.fun' . "\r\n";
mb_send_mail($to, $subject, $message, $headers);
?>
