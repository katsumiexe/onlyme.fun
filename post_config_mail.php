<?
include_once("./library/no_session.php");

$set_mail	=$_POST["set_mail"];
$set_name	=$_POST["set_name"];
$set_pass	=$_POST["set_pass"];
$res=0;
if(!$set_name){
	$res=4;

}elseif(!$set_pass || strlen($set_pass)<4 || mb_strlen($set_pass) != strlen($set_pass)){
	$res=3;

}elseif(!$set_mail || mb_strlen($set_mail) != strlen($set_mail)){
	$res=2;

}else{

	$sql="SELECT reg_mail FROM reg";
	$sql.=" WHERE reg_mail='{$set_mail}'";
	$sql.=" LIMIT 1";

	$res1 = mysqli_query($mysqli,$sql);
	$res2 = mysqli_fetch_assoc($res1);
	if($res2["reg_mail"] ==$set_mail){
		$res=1;
	}
}
echo $res;
exit;
?>
