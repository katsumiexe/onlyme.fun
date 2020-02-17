<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");

$user_id=$_POST["user_id"];
$date=date("Y-m-d H:i:s");

$sql="UPDATE me_prof SET net_kiyaku='{$date}'";
$sql.=" WHERE prof_id='{$user_id}'";
mysqli_query($mysqli,$sql);
echo $sql;
?>
    