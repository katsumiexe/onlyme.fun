<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
mysqli_set_charset($mysqli,'UTF-8'); 

$user_id	=$_POST["user_id"];
$img_id		=$_POST["img_id"];

$sql_log="UPDATE reg SET";
$sql_log.=" `reg_pic`='{$img_id}'";
$sql_log.=" WHERE id='{$user_id}'";
mysqli_query($mysqli,$sql_log);
?>

