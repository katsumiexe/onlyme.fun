<?
include_once("./library/session.php");

$sql="UPDATE reg SET reg_line=''";
$sql.=" WHERE id='{$_SESSION["id"]}'";
mysqli_query($mysqli,$sql);

$sql1 ="SELECT * FROM reg";
$sql1.=" WHERE id='{$_SESSION["id"]}'";
$sql1.=" AND reg_pass<>''";
$sql1.=" LIMIT 1";

$res2 = mysqli_query($mysqli,$sql1);
if($dat2 = mysqli_fetch_assoc($res2)){
	$ps=1;
}

echo $ps;
exit;
?>
