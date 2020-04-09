<?
include_once("./library/session.php");
$sql="UPDATE reg SET reg_line=''";
$sql.=" WHERE id='{$_SESSION["id"]}'";
mysqli_query($mysqli,$sql);

$sql ="SELECT reg_pass FROM reg";
$sql.=" WHERE id='{$_SESSION["id"]}'";
$sql.=" LIMIT 1";
$res2 = mysqli_query($mysqli,$sql);
$dat2 = mysqli_fetch_assoc($res2);

if($dat2["reg_pass"]){
	$dat=1;
}else{
	$dat=2;
}

echo $dat;
exit;
?>
