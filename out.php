<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=1;
$t_date=date("Y-m-d H:i:s");

$sql ="UPDATE reg SET";
$sql.=" `reg_remove_day`='{$t_date}',";
$sql.=" `reg_pic`='0',";
$sql.=" `reg_rank`='2',";
$sql.=" `reg_line`=''";
$sql.=" WHERE `id`='{$user["id"]}'";
mysqli_query($mysqli,$sql);

$sql ="UPDATE me_making SET";
$sql.=" `del`='1'";
$sql.=" WHERE `user_id`='{$user["id"]}'";
mysqli_query($mysqli,$sql);

/*
$files = scandir($dir);
foreach( $files as $file_name ) {
	if( !preg_match( '/^\.(.*)/', $file_name) ) {
		unlink($dir. $file_name);
	}
}

$files = scandir($dir2);
foreach( $files as $file_name ) {
	if( !preg_match( '/^\.(.*)/', $file_name) ) {
		unlink($dir2. $file_name);
	}
}
*/
$files = scandir($dir3);
foreach( $files as $file_name ) {
	if( !preg_match( '/^\.(.*)/', $file_name) ) {
		unlink($dir3. $file_name);
	}
}




$_SESSION = array();
$user = array();
session_destroy(); 

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,画像修正,onlyme,名刺作成,無料,簡単">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/regist.css?_<?=date("YmdHi")?>">
<script src="./js/jquery-3.2.1.min.js"></script>
<style>

</style>
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
<h1 class="h1_irr"><span class="h1_title">退会</span></h1>
	<div class="box_01">
	<div class="box_02">
		退会しました。
	</div>
	</div>
</div>
<?include_once("./x_foot.php")?>
</body>
</html>
