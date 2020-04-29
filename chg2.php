<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
$t_date=date("Y-m-d H:i:s");

$code	=$_REQUEST["code"];

if(!$code){
	$msg="URLコードが不正です。再度変更手続きを行ってください。<br>（変更はされていません）";
}else{
	$sql ="SELECT * FROM me_config_chg";
	$sql.=" WHERE code='{$code}'";
	$sql.=" LIMIT 1"; 

	$result = mysqli_query($mysqli,$sql);
	$res = mysqli_fetch_assoc($result);
}

if($res){
	$ck=time()-strtotime($res["date"]);
	if($ck > 2000){
		$msg="タイムアウトしています。再度変更手続きを行ってください。<br>（変更はされていません）";
	}

}else{
	$msg="URLが不正です。再度変更手続きを行ってください。<br>（変更はされていません）";
}

if(!$msg){
	$sql ="UPDATE reg SET";
	$sql.=" `reg_name`='{$res["name"]}',";
	$sql.=" `reg_mail`='{$res["mail"]}',";
	$sql.=" `reg_state`='{$res["state"]}',";
	$sql.=" `reg_pass`='{$res["pass"]}'";
	$sql.=" WHERE `id`='{$res["user_id"]}'";
	mysqli_query($mysqli,$sql);
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("is")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("is")?>">
<link rel="stylesheet" href="./css/regist.css?_<?=date("is")?>">
<script src="./js/jquery-3.2.1.min.js"></script>
</head>
<body class="body">
<div class="pc_only">
	<img src="./img/top.png" style="width:700px;"><br>
	<div class="pc_box" style="font-size:14px;">
		こちらはスマホ専用サイトです。<br>
		PC・タブレットではご利用いただけません。<br>
	</div>
</div>
<div class="main_irr sp_only">
<a href="./index.php" class="irr_top">写真名刺作成サイト★OnlyMe</a>
<h1 class="h1_irr"><span class="h1_title">登録情報変更</span></h1>
	<?if($msg){?>
		<div class="box_01">
			<?=$msg?>
		</div>
	<?}else{?>
		<form action="./index.php" method="post">
		<div class="box_01">
			変更完了しました。<br>
			引き続きご利用いただけます。<br>
			<input type="hidden" name="log_pass" value="<?=$res["pass"]?>">
			<input type="hidden" name="log_in" value="<?=$res["user_id"]?>">
		</div>
		<button type="submit" name="send" class="send_btn">ログイン</button>
		</form>
<?}?>



</div>
<?include_once("./x_foot.php")?>
</body>
</html>
