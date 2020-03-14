<?

include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
include_once("./library/lib_regist.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/regist.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
</script>
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
<h1 class="h1_irr"><span class="h1_title">LINEログイン</span></h1>


</div>
<?include_once("./x_foot.php")?>
</body>
</html>


