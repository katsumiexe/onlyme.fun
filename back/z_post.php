<?php
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysql){
	die(接続エラーです);
}
mysqli_set_charset($mysqli,'UTF-8'); 

$n=0;
$sql ="SELECT * FROM `me_post`";
$sql.=" ORDER BY id DESC";

$result = mysqli_query($mysqli,$sql);
if($result){
	while($row = mysqli_fetch_assoc($result)){
		$dat[$row["id"]]["date"]		=$row["date"];	
		$dat[$row["id"]]["name"]		=$row["name"];
		$dat[$row["id"]]["mail"]		=$row["mail"];
		$dat[$row["id"]]["log"]			=str_replace("\n","<br>",$row["log"]);
		$dat[$row["id"]]["return_date"]	=$row["return_date"];
		$dat[$row["id"]]["return"]			=str_replace("\n","<br>",$row["return"]);
		$dat[$row["id"]]["memo"]		=$row["memo"];
		$dat[$row["id"]]["ua"]			=$row["ua"];
		$dat[$row["id"]]["ip"]			=$row["ip"];
	}
}

if($_POST["memo_upd"]){
	foreach($_POST["memo_upd"] as $s1 => $s2);
	$memo=$_POST["memo"];

	$sql="UPDATE me_post SET";
	$sql.=" `memo`='{$memo[$s1]}'";
	$sql.=" WHERE `id`='{$s1}'";

	mysqli_query($mysqli,$sql);
	$dat[$s1]["mail"]		=$memo[$s1];

}elseif($_POST["mail_send"]){
	foreach($_POST["mail_send"] as $s1 => $s2);
	$return=$_POST["return"];
	$memo=$_POST["memo"];

	$now_day=date("Y-m-d H:i:s");

	$sql="UPDATE me_post SET";
	$sql.=" return_date='{$now_day}',";
	$sql.=" `return`='{$return[$s1]}',";
	$sql.=" `memo`='{$memo[$s1]}'";
	$sql.=" WHERE `id`='{$s1}'";
	mysqli_query($mysqli,$sql);

	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	$to      = $dat[$s1]["mail"];
	$subject = "写真名刺作成サイト★OnlyMe";
	$message = $return[$s1];
	$headers = 'From: onlyme@piyo-piyo.work' . "\r\n";
	mb_send_mail($to, $subject, $message, $headers);

	$dat[$s1]["return"]		=$return[$s1];
	$dat[$s1]["memo"]		=$memo[$s1];
	$dat[$s1]["return_date"]=$now_day;

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta name="robots" content="noindex,nofollow">
<style>
table{
	margin:5px;
	border:1px solid #303030;
	border-collapse: collapse;
}

td{
	border:1px solid #303030;
	padding:3px;
	font-size:13px;
	line-height:16px;	
	background:#ffffff;
}

.td1{
	width:50px;
	
}

.td2{
	width:200px;
	
}
.td3{
	width:250px;
	
}
.ans{
	border:1px solid #303030;
	width:600px;
	height:100px;
	padding:3px;
	font-size:13px;
	line-height:16px;	
}

button{
	font-size:12px;
	padding:1px;
}

</style>
</head>
<body style="background:#f5f0ff;">
<div style="display:inline-block;">
<?foreach((array)$dat as $a1=> $a2){?>
<form method="post" action="./z_post.php">
<table style="background:#ffffff;">
	<tr>
		<td class="td1">NO</td>
		<td class="td1"><?=$a1?></td>
		<td class="td1">DATE</td>
		<td class="td2"><?=$dat[$a1]["date"]?></td>
		<td class="td3"><button type="submit" name="memo_upd[<?=$a1?>]" value="send">更新</button>　MEMO</td>
	</tr>

	<tr>
		<td>USER_ID</td>
		<td colspan="3"><?=$dat[$a1]["user_id"]?></td>
		<td rowspan="5"><textarea style="height:90px;width:98%;border:none;" name="memo[<?=$a1?>]"><?=$dat[$a1]["memo"]?></textarea></td>
	</tr>

	<tr>
		<td>NAME</td>
		<td colspan="3"><?=$dat[$a1]["name"]?></td>
	</tr>

	<tr>
		<td>mail</td>
		<td colspan="3"><?=$dat[$a1]["mail"]?></td>
	</tr>
	<tr>
		<td>UA</td>
		<td colspan="3"><?=$dat[$a1]["ua"]?></td>
	</tr>
	<tr>
		<td>IP</td>
		<td colspan="3"><?=$dat[$a1]["ip"]?></td>
	</tr>

	<tr>
		<td colspan="5"><?=$dat[$a1]["log"]?></td>
	</tr>

	<?if($dat[$a1]["mail"]){?>
	<tr>
		<td colspan="5">
			<?if(strtotime($dat[$a1]["return_date"]) >0){?>
				<span><?=$dat[$a1]["return_date"]?></span><br>
				<div style=""margin:3px;><?=$dat[$a1]["return"]?></div>
			<?}else{?>
				<button type="submit" name="mail_send[<?=$a1?>]" value="send">送信</button>
				<textarea style="height:60px;width:99%" name="return[<?=$a1?>]"><?=$dat[$a1]["return"]?></textarea>
			<? } ?>
		</td>
	</tr>
	<?}?>
</table>
</form>
<? } ?>
</div>



</body>
</html>
