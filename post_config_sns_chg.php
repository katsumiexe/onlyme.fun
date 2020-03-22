<?
include_once("./library/no_session.php");

$set_state	=$_POST["set_state"];
$set_name	=$_POST["set_name"];
$set_pass	=$_POST["set_pass"];
$set_id		=$_POST["set_id"];

$sql="UPDATE reg SET";
$sql.=" reg_name='{$set_name}',";
$sql.=" reg_pass='{$set_pass}',";
$sql.=" reg_state='{$set_state}'";

$sql.=" WHERE id='{$set_id}'";
mysqli_query($mysqli,$sql);

exit;
?>
