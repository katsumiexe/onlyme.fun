<?
include_once("./library/session.php");
$user_id	=$_POST["user_id"];
$img_id		=$_POST["img_id"];

unlink($prof_img[$img_id]);
$prof_img[$img_id]="";

if($user['reg_pic'] == $img_id){
	if(strpos($prof_img[1],'album') >0 ){
		$sql_log="UPDATE reg SET";
		$sql_log.=" `reg_pic`='1'";
		$sql_log.=" WHERE `id`='{$user_id}'";
		mysqli_query($mysqli,$sql_log);
		$n=1;

	}elseif(strpos($prof_img[2],'album') >0 ){
		$sql_log="UPDATE reg SET";
		$sql_log.=" `reg_pic`='2'";
		$sql_log.=" WHERE `id`='{$user_id}'";
		mysqli_query($mysqli,$sql_log);
		$n=2;

	}elseif(strpos($prof_img[3],'album') >0 ){
		$sql_log="UPDATE reg SET";
		$sql_log.=" `reg_pic`='3'";
		$sql_log.=" WHERE `id`='{$user_id}'";
		mysqli_query($mysqli,$sql_log);
		$n=3;

	}else{
		$user_face="./img/noimage{$user['reg_sex']}.jpg";
		$sql_log="UPDATE reg SET";
		$sql_log.=" `reg_pic`='0'";
		$sql_log.=" WHERE `id`='{$user_id}'";
		mysqli_query($mysqli,$sql_log);
		$n=0;
	}
}
echo($n);
?>
