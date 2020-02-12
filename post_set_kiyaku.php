<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
mysqli_set_charset($mysqli,'UTF-8'); 
1$user_id	=$_REQUEST["user_id"];

$date=date("Y-m-d H:i:s");
$sql="UPDATE me_prof SET net_kiyaku='{$date}'";
$sql.=" WHERE prof_id='{$user_id}'";
mysqli_query($mysqli,$sql);
?>

