<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$check	=$_REQUEST["check"];
$sql ="SELECT * FROM reg";
$sql.=" WHERE reg_mail='{$check}'";
$sql.=" LIMIT 1";

$result = mysqli_query($mysqli,$sql);
$ck = mysqli_fetch_assoc($result);
if(count($ck)==0){
    $ok="ok";
}
echo($ok);
?>
